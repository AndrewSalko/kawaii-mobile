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


			_ButtonLoadSitemap.Enabled = (!siteMapLoadBusy) && (!tweetBusy);
			_ButtonStopLoadSitemap.Enabled = siteMapLoadBusy;

			_ButtonStartTweeting.Enabled = (!tweetBusy) && (!siteMapLoadBusy);
			_ButtonStopTweeting.Enabled = tweetBusy;
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


			int count = _Data.Pages.Count();
			Log("Всего страниц в базе: {0}", count);

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


				//если это имя заполнено, то сделать пост с этим изображением и ссылкой
				string fileImgName = null;

				//TODO@:проверим что там с размером изображения-twitter:image
				//На сайте есть много страниц где изображение слишком "портретное" для твиттера не сойдет
				string imgURL=page.GetTwitterImageFileURL();
				//размер который пригоден для твитте-тумбочки 2160x1920, 1440x1280
				if(!string.IsNullOrWhiteSpace(imgURL))
				{
					if(!imgURL.Contains("2160x1920") && !imgURL.Contains("1440x1280"))
					{
						//надо сделать просто пост с картинкой, а не классический
						ImageDownloader imgDown = new ImageDownloader(imgURL);
						int tryCount = 3;
						
						while (tryCount > 0)
						{
							if (imgDown.FileName != null)
							{
								fileImgName = imgDown.FileName;
								break;
							}

							tryCount--;
							imgDown = new ImageDownloader(imgURL);
						}
					}
				}								

				//делаем твит...		
				string tweetText = page.CreateTwitterText();

				if (fileImgName == null)
				{
					TweetSharp.SendTweetOptions opts = new TweetSharp.SendTweetOptions();
					opts.Status = tweetText;
					TwitterService.API.SendTweet(opts);
				}
				else
				{
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
						TwitterService.API.SendTweetWithMedia(ops);
					}
				}
				
				page.TweetDate = dt;
				_Data.SubmitChanges();

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

		void _UpdateTweetStatus(SitePage page, DateTime nextTweetTime, int totalTweetsDone, int maxTweets)
		{
			string msg = string.Format("Всего твитов:{0}, следующий {1}", totalTweetsDone, nextTweetTime);
			if (totalTweetsDone == maxTweets)
			{
				msg = string.Format("Всего твитов:{0}, задание завершено", totalTweetsDone);
			}

			if(ParentLog!=null)
			{
				ParentLog.Log("{0} - {1}", page.TweetDate, page.URL);
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
		/// </summary>
		/// <returns></returns>
		SitePage _GetPageForTwitting()
		{
			SitePage result;

			//получить список страниц которые ни разу не твиттили
			var pagesNotTwitted = (from page in _Data.Pages where (!page.Blocked && page.TweetDate == null) select page).ToArray();
			var twittedPages = (from page in _Data.Pages where (!page.Blocked && page.TweetDate != null) orderby page.TweetDate.Value select page).ToArray();

			if (pagesNotTwitted != null && pagesNotTwitted.Length > 0)
			{
				//взять случайную страницу из тех, кого еще ни разу не пускали в твиттер
				result = _GetRandomPage(pagesNotTwitted, 0);
			}
			else
			{
				//значит берем среди тех, кого уже твитили, но там сортировка по убыванию
				//Очень важно - у нас за день будет штук 5-10 твитов..а значит завтра нельзя твитить эти же страницы.
				//Вывод - т.к.страниц у нас немало, а отобрать надо штук 10-20, то вот это количество надо отобрать случайно из первого блока
				result = _GetRandomPage(twittedPages, 30);
			}

			return result;
		}

		SitePage _GetRandomPage(SitePage[] pages, int maxRandomIndex)
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

			return pages[ind];
		}

		private void _BackgroundWorkerTweeting_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
		{
			_UpdateControls();

			if (e.Error != null)
			{
				_ShowMessage(e.Error.Message, e.Error.ToString(), MessageBoxIcon.Exclamation);
			}
		}
	}
}
