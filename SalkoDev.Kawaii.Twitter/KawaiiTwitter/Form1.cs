using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;
using System.Data.SQLite;
using System.Reflection;
using System.Configuration;
using LinqToTwitter;

namespace SalkoDev.KawaiiTwitter
{
	public partial class Form1 : Form, ILog
	{
		public Form1()
		{
			InitializeComponent();
		}

		Service _Service;

		Sitemap.SitePageData _Data;
		Images.ImageData _DataImages;

		private void exitToolStripMenuItem_Click(object sender, EventArgs e)
		{
			Close();
		}

		bool _Auth()
		{
			bool result = false;

			try
			{
				if (_Service != null)
					return true;//уже подключены


				_Service = new Service();

				result = true;
			}
			catch (Exception ex)
			{
				_Service = null;
				Log(ex.Message);
				MessageBox.Show(this, ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
			}

			return result;
		}

		public void Log(string format, params object[] args)
		{
			string msg = string.Format(format, args);

			if(InvokeRequired)
			{
				this.Invoke((MethodInvoker)delegate
				{
					int ind = _ListBoxLog.Items.Add(msg);
					_ListBoxLog.SelectedIndex = ind;
				});
			}
			else
			{
				int ind = _ListBoxLog.Items.Add(msg);
				_ListBoxLog.SelectedIndex = ind;
			}
		}

		private void _ConnectToolStripMenuItem_Click(object sender, EventArgs e)
		{
			if (_Auth())
			{
				Log("Авторизовано успішно");
			}
		}

		private void Form1_Load(object sender, EventArgs e)
		{
			_InitData();

			_UpdateControls();
		}

		void _InitData()
		{
			if (DesignMode)
				return;

			string dbFile = "pages_kawaii_mobile.s3db";
			string dataBaseFile = Path.Combine(Application.StartupPath, @"..\..\..", dbFile);
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
			Log("Всього сторінок у базі: {0}, зовнішніх зображень: {1}", count, imgCount);

			_UpdateControls();
		}

		void _UpdateControls()
		{
			bool tweetBusy = _BackgroundWorkerTweeting.IsBusy;

			_ButtonStartTweeting.Enabled = !tweetBusy;
			_ButtonStopTweeting.Enabled = tweetBusy;

			loadNewImagesFromDiskToolStripMenuItem.Enabled = !tweetBusy;
			updateFromSitemapToolStripMenuItem.Enabled = !tweetBusy;
		}

		private void _UpdateFromSitemapToolStripMenuItem_Click(object sender, EventArgs e)
		{
			UpdateSitemapForm upd = new UpdateSitemapForm();
			upd.Data = _Data;

			upd.ShowDialog(this);

			_InitData();
		}

		private void _ButtonStartTweeting_Click(object sender, EventArgs e)
		{
			if (_BackgroundWorkerTweeting.IsBusy)
			{
				MessageBox.Show(this, "Процес ще не завершено", "Помилка", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
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
			if (_Service == null)
				throw new ApplicationException("Немає підключення до сервісу Twitter");

			int maxTweets = 7;
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
					Log("Не вдалося отримати зображення з {0}", page);
					continue;
				}

				//делаем твит...
				string tweetText = page.CreateTwitterText();

				//твит с медиа и текстом
				try
				{
					_Service.TweetWithMedia(tweetText, fileImgName);
				}
				catch (Exception ex)
				{
					Log("Помилка для {0}: {1}", page, ex.Message);

					//спим 1 минуту, и пробуем еще раз
					System.Threading.Thread.Sleep(6000);

					continue;
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

				//спим 40 мин, но делаем вызовы по 1 секунде чтобы можно было прервать
				int secondsSleep = 1 * 60 * 40;

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
			string msg = string.Format("Всього твітів:{0}, наступний {1}", totalTweetsDone, nextTweetTime);
			if (totalTweetsDone == maxTweets)
			{
				msg = string.Format("Всього твітів:{0}, завдання завершено", totalTweetsDone);
			}
						
			Log("{0} - {1}", page.TweetDate, page);			

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
			var gifsNotTwitted = (from pageGif in _DataImages.Images where (pageGif.TweetDate == null) select pageGif).ToArray();

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

			var twittedImages = (from page in _DataImages.Images where (page.TweetDate != null) orderby page.TweetDate.Value select page).ToArray();
			if (twittedImages != null && twittedImages.Length > 0)
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
					throw new ApplicationException(string.Format("Не знайдено сторінку для зображення: slug={0}", urlSlug));
				}
				else
				{
					if (foundPages.Length > 1)
					{
						throw new ApplicationException(string.Format("Знайдено більш однієї сторінки для зображення: slug={0}", urlSlug));
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
				MessageBox.Show(this, e.Error.ToString(), e.Error.Message, MessageBoxButtons.OK, MessageBoxIcon.Error);
			}
		}

		private void loadNewImagesFromDiskToolStripMenuItem_Click(object sender, EventArgs e)
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
					if (postInDB == null || postInDB.Length == 0)
					{
						Log("Пост не знайдено для:" + img.FilePath);
						continue;
					}

					_DataImages.Images.InsertOnSubmit(img);
					_DataImages.SubmitChanges();
				}
			}

		}
	}
}
