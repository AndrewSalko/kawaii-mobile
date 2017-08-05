using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Drawing;
using System.Data;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;
using SalkoDev.KawaiiTwitter.Sitemap;
using TweetSharp;

namespace SalkoDev.KawaiiTwitter
{
	public partial class SitePagesTweetControl : UserControl, ILog
	{
		public SitePagesTweetControl()
		{
			InitializeComponent();
		}

		/// <summary>
		/// Если задан извне, можно использовать для отправки в общий лог сообщений
		/// </summary>
		ILog ParentLog
		{
			get
			{
				return this.Parent as ILog;
			}
		}

		Service TwitterService
		{
			get
			{
				IMain main = this.Parent as IMain;
				if(main!=null)
				{
					return main.TwitterService;
				}

				return null;
			}
		}

		string _FileNameSiteMap;
		Sitemap.SitemapLoader _Loader;
		Sitemap.SitePageData _Data;

		Images.ImageData _DataImages;

		private void _ButtonLoadSitemap_Click(object sender, EventArgs e)
		{
			string fileName = _TextBoxURLSitemap.Text;
			if(string.IsNullOrWhiteSpace(fileName))
			{
				_ShowMessage(null, "Укажите корректно имя файла карты сайта", MessageBoxIcon.Information);
				return;
			}
			
			_FileNameSiteMap = fileName;

			_BackgroundWorkerSitemapLoad.RunWorkerAsync();

			//запуск процесса загрузки карты сайта (с анализом тайтлов)			
			_UpdateControls();
		}

		void _ShowMessage(string caption, string text, MessageBoxIcon icon)
		{
			if (caption == null)
				caption = text;

			MessageBox.Show(Parent, text, caption, MessageBoxButtons.OK, icon);
		}

		void _UpdateControls()
		{
			bool siteMapLoadBusy = _BackgroundWorkerSitemapLoad.IsBusy;
			bool tweetBusy = _BackgroundWorkerTweeting.IsBusy;
			bool imgLoadingBusy = _BackgroundWorkerLoadImages.IsBusy;

			_ButtonLoadSitemap.Enabled = (!siteMapLoadBusy) && (!tweetBusy);
			_ButtonStopLoadSitemap.Enabled = siteMapLoadBusy;

			_ButtonStartTweeting.Enabled = (!tweetBusy) && (!siteMapLoadBusy);
			_ButtonStopTweeting.Enabled = tweetBusy;

			_ButtonLoadImages.Enabled = (!imgLoadingBusy) && (!tweetBusy);
		}

		private void _BackgroundWorkerSitemapLoad_DoWork(object sender, DoWorkEventArgs e)
		{			
			_Loader = new Sitemap.SitemapLoader(_FileNameSiteMap);
			_Loader.DelayIntervalTitleRequest = 1000;
			_Loader.DoWork(_BackgroundWorkerSitemapLoad, this);

			if (_BackgroundWorkerSitemapLoad.CancellationPending)
				return;

			//теперь добавим все в базу
			var foundPages = _Loader.Pages;
			if (foundPages == null || foundPages.Length == 0)
				return;

			foreach (var pg in foundPages)
			{
				//проверим, для каждой страницы есть ли она такая уже, если нет - добавим
				//TODO@: пока не учитываем "обновление" оно не критично

				var foundInDB = (from page in _Data.Pages where page.URL == pg.URL select page).ToArray();
				if(foundInDB==null || foundInDB.Length==0)
				{
					//нет такой в базе, добавляем
					_Data.Pages.InsertOnSubmit(pg);
					_Data.SubmitChanges();
				}

				if (_BackgroundWorkerSitemapLoad.CancellationPending)
					return;
				
			}//foreach
		}

		private void _BackgroundWorkerSitemapLoad_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
		{
			_UpdateControls();

			if (e.Error!=null)
			{
				_ShowMessage(e.Error.Message, e.Error.ToString(), MessageBoxIcon.Exclamation);								
				_Loader = null;
				return;
			}			
		}

		private void _ButtonStopLoadSitemap_Click(object sender, EventArgs e)
		{
			_BackgroundWorkerSitemapLoad.CancelAsync();
		}

		public void InitData()
		{
			if (DesignMode)
				return;

			string sitemapFile = "sitemap.xml";
			string fullPath = Path.Combine(Application.StartupPath, @"..\..\..", sitemapFile);
			if (File.Exists(fullPath))
			{
				_TextBoxURLSitemap.Text = fullPath;
			}

			string dbFile = "pages_kawaii_mobile.s3db";
			string dataBaseFile= Path.Combine(Application.StartupPath, @"..\..\..", dbFile);
			//открываем базу, готовим все

			var connectionString = string.Format("Data Source={0};datetimeformat=CurrentCulture", dataBaseFile);
			var inst = System.Data.SQLite.Linq.SQLiteProviderFactory.Instance;
			System.Data.Common.DbConnection dbConn = inst.CreateConnection();
			dbConn.ConnectionString = connectionString;
			dbConn.Open();

			_Data = new Sitemap.SitePageData(dbConn);
			_DataImages = new Images.ImageData(dbConn);

			int count = _Data.Pages.Count();
			int imgCount = _DataImages.Images.Count();
			Log("Всего страниц в базе: {0}, внешних изображений: {1}", count, imgCount);

			_UpdateControls();
		}

		private void SitePagesTweetControl_Load(object sender, EventArgs e)
		{
			InitData();
		}

		public void Log(string format, params object[] args)
		{
			string msg = string.Format(format, args);

			if (InvokeRequired)
			{
				this.Invoke((MethodInvoker)delegate
				{
					_LabelTotalURLs.Text = msg;					
				});
			}
			else
			{
				_LabelTotalURLs.Text = msg;
			}
		}

		private void _ButtonStartTweeting_Click(object sender, EventArgs e)
		{
			if(_BackgroundWorkerTweeting.IsBusy)
			{
				_ShowMessage(null, "Процесс еще не завершен", MessageBoxIcon.Exclamation);
				return;
			}

			_BackgroundWorkerTweeting.RunWorkerAsync();
			_UpdateControls();
		}

		private void _ButtonStopTweeting_Click(object sender, EventArgs e)
		{
			if (_BackgroundWorkerTweeting.IsBusy)
			{
				_BackgroundWorkerTweeting.CancelAsync();
				return;
			}
			
			_UpdateControls();
		}

		private void _BackgroundWorkerTweeting_DoWork(object sender, DoWorkEventArgs e)
		{
			//запускаем процесс "фейк-твитинга" чтобы видеть как все идет
			if (TwitterService == null)
				throw new ApplicationException("Нет подключения к сервису Twitter");

			int maxTweets = 5;
			int doneTweets = 0;
			do
			{
				if (_BackgroundWorkerTweeting.CancellationPending)
					return;

				DateTime dt = DateTime.Now;
				//следующий твит - через час
				DateTime dtNext = dt.AddHours(1);

				var page = _GetPageForTwitting();
				if (page == null)
					throw new ApplicationException("_GetPageForTwitting returns null");


				//получить "скачанный" файл-картинку для твита (или null если с этим проблемы)
				string fileImgName = page.ImageFileName;
				if (string.IsNullOrWhiteSpace(fileImgName))
				{
					if (ParentLog != null)
					{
						ParentLog.Log("Не удалось получить изображения из {0}", page);
					}
					continue;
				}

				//делаем твит...		
				string tweetText = page.CreateTwitterText();
				using (var stream1 = File.OpenRead(fileImgName))
				{
					SendTweetWithMediaOptions ops = new SendTweetWithMediaOptions();
					if (ops.Images == null)
					{
						ops.Images = new Dictionary<string, Stream>();
					}

					string shortFileName = Path.GetFileName(fileImgName);
					ops.Images.Add(shortFileName, stream1);
					ops.Status = tweetText;					
					var statusResult = TwitterService.API.SendTweetWithMedia(ops);					
				}
				
				page.TweetDate = dt;

				//сохранить в базу сведения о том, что мы уже твитили
				_Data.SubmitChanges();
				_DataImages.SubmitChanges();

				doneTweets++;

				//обновить статус (что мы твитнули)
				_UpdateTweetStatus(page, dtNext, doneTweets, maxTweets);

				//может пора выходить?
				if (doneTweets == maxTweets)
				{
					break;
				}

				//спим 1 час, но делаем вызовы по 1 секунде чтобы можно было прервать
				int secondsSleep = 1 * 60 * 60;//3600 сек в одном часе
				//int secondsSleep = 10;
				for (int q = 0; q < secondsSleep; q++)
				{
					System.Threading.Thread.Sleep(1000);

					if (_BackgroundWorkerTweeting.CancellationPending)
						return;
				}

			} while (doneTweets < maxTweets);
		}

		void _UpdateTweetStatus(ITwittable page, DateTime nextTweetTime, int totalTweetsDone, int maxTweets)
		{
			string msg = string.Format("Всего твитов:{0}, следующий {1}", totalTweetsDone, nextTweetTime);
			if (totalTweetsDone == maxTweets)
			{
				msg = string.Format("Всего твитов:{0}, задание завершено", totalTweetsDone);
			}

			if(ParentLog!=null)
			{
				ParentLog.Log("{0} - {1}", page.TweetDate, page);
			}

			if (InvokeRequired)
			{
				this.Invoke((MethodInvoker)delegate
				{
					_LabelLastPost.Text = page.Title;
					_LabelNextPostTime.Text = msg;
				});
			}
			else
			{
				_LabelLastPost.Text = page.Title;
				_LabelNextPostTime.Text = msg;
			}
		}

		/// <summary>
		/// Получить случайную страницу для твита-сообщения. В первую очередь берем случайно
		/// из тех, кого не твитили вообще, затем - те что твитили но давно.
		/// Также берет из базы gif-изображения
		/// </summary>
		/// <returns></returns>
		ITwittable _GetPageForTwitting()
		{
			//получить список страниц которые ни разу не твиттили
			var pagesNotTwitted = (from page in _Data.Pages where (!page.Blocked && page.TweetDate == null) select page).ToArray();
			var gifsNotTwitted= (from pageGif in _DataImages.Images where (pageGif.TweetDate == null) select pageGif).ToArray();
						
			//взять случайную страницу из тех, кого еще ни разу НЕ пускали в твиттер
			if (pagesNotTwitted != null && pagesNotTwitted.Length > 0)
			{
				return _GetRandomPage(pagesNotTwitted, 0);
			}

			//Если попали сюда значит нет новых страниц, но может есть новые gif-файлы? (которые НИ разу не твитили)
			if (gifsNotTwitted != null && gifsNotTwitted.Length > 0)
			{
				return _GetRandomPage(gifsNotTwitted, 0);
			}

			//на этом этапе у нас все страницы и все гифки уже твитились. Собрать в кучу, выбрать кого твитили давно, выбрать случаное
			List<ITwittable> normPagesAndGifs = new List<ITwittable>();

			var twittedPages = (from page in _Data.Pages where (!page.Blocked && page.TweetDate != null) orderby page.TweetDate.Value select page).ToArray();
			if (twittedPages != null && twittedPages.Length > 0)
			{
				normPagesAndGifs.AddRange(twittedPages);
			}

			var twittedImages= (from page in _DataImages.Images where (page.TweetDate != null) orderby page.TweetDate.Value select page).ToArray();
			if(twittedImages != null && twittedImages.Length > 0)
			{
				normPagesAndGifs.AddRange(twittedImages);
			}

			var result = normPagesAndGifs.OrderBy(pg => pg.TweetDate).ToArray();					

			return _GetRandomPage(result, 30);//выбор из топ-30
		}

		ITwittable _GetRandomPage(ITwittable[] pages, int maxRandomIndex)
		{
			if (pages == null || pages.Length == 0)
				throw new ArgumentNullException("pages");

			if (maxRandomIndex <= 0)
			{
				maxRandomIndex = pages.Length;
			}
			else
			{
				if (pages.Length < maxRandomIndex)
					maxRandomIndex = pages.Length;
			}

			Random rnd = new Random(Environment.TickCount);
			int ind = rnd.Next(maxRandomIndex);

			ITwittable result = pages[ind];
			IMediaImage resultImg = result as IMediaImage;
			if (resultImg != null && resultImg.Page == null)
			{
				//найти связанный пост для изображения. 
				string urlSlug = resultImg.GetURLSlug();

				var foundPages = (from page in _Data.Pages where (page.URL.EndsWith(urlSlug)) select page).ToArray();
				if (foundPages == null || foundPages.Length == 0)
				{
					throw new ApplicationException(string.Format("Не найдена страница для изображения: slug={0}", urlSlug));
				}
				else
				{
					if (foundPages.Length > 1)
					{
						throw new ApplicationException(string.Format("Найдено более одной страницы для изображения: slug={0}", urlSlug));
					}

					resultImg.Page = foundPages[0];
				}				

			}

			return result;
		}

		private void _BackgroundWorkerTweeting_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
		{
			_UpdateControls();

			if (e.Error != null)
			{
				_ShowMessage(e.Error.Message, e.Error.ToString(), MessageBoxIcon.Exclamation);
			}
		}

		private void _ButtonLoadImages_Click(object sender, EventArgs e)
		{
			if (_BackgroundWorkerLoadImages.IsBusy)
			{
				_ShowMessage(null, "Процесс еще не завершен", MessageBoxIcon.Exclamation);
				return;
			}

			_BackgroundWorkerLoadImages.RunWorkerAsync();
			_UpdateControls();
		}

		private void _BackgroundWorkerLoadImages_DoWork(object sender, DoWorkEventArgs e)
		{
			string imagesDir = Path.Combine(Application.StartupPath, @"..\..\..\images");

			//в папке будут под-папки по урлам постов. Это важно - связь с постом. 
			//далее в каждой уже файл-гифка или что-то там еще

			var files = Directory.EnumerateFiles(imagesDir, "*.gif", SearchOption.AllDirectories);
			foreach (var fileItem in files)
			{
				string dir = Path.GetDirectoryName(fileItem);
				//разбить на части, взять последнее
				string[] spl = dir.Split('\\');
				string urlPart = spl.Last();

				//это часть, которой должен заканчиваться "пост" (URL) в базе урлов
				string searchURL = string.Format("/{0}/", urlPart);
				
				string relPath = fileItem.Replace(imagesDir, string.Empty);
				if (relPath.StartsWith("\\"))
				{
					relPath = relPath.TrimStart('\\');
				}

				Images.Image img = new Images.Image();
				img.FilePath = relPath;

				//проверить, если такое ли уже в базе? Если нет добавить
				var foundInDB = (from im in _DataImages.Images where im.FilePath == img.FilePath select im).ToArray();
				if (foundInDB == null || foundInDB.Length == 0)
				{
					//нет такой в базе, добавляем, но только ЕСЛИ найдется соотв.URL
					var postInDB = _Data.GetPostByURLSlug(searchURL);
					if(postInDB==null || postInDB.Length == 0)
					{
						Log("Пост не найден для:" + img.FilePath);
						continue;
					}

					_DataImages.Images.InsertOnSubmit(img);
					_DataImages.SubmitChanges();
				}
			}
		}

		private void _BackgroundWorkerLoadImages_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
		{
			_UpdateControls();

			if (e.Error != null)
			{
				_ShowMessage(e.Error.Message, e.Error.ToString(), MessageBoxIcon.Exclamation);
			}
			else
			{
				_ShowMessage("Загрузка выполнена", "Загрузка изображений в базу выполнена", MessageBoxIcon.Information);
			}

		}
	}
}
