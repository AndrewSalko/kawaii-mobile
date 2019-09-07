using System;
using System.Collections.Generic;
using System.Data.Linq.Mapping;
using System.Linq;
using System.Net;
using System.Text;
using System.Text.RegularExpressions;

namespace SalkoDev.KawaiiTwitter.Sitemap
{
	/// <summary>
	/// Страница сайта
	/// </summary>
	[Table(Name = "Pages")]
	class SitePage: ITwittable
	{
		[Column(Name = "id", IsPrimaryKey = true, CanBeNull = false, IsDbGenerated = true)]
		public long id
		{
			get;
			set;
		}

		[Column(Name = "URL", CanBeNull = true)]
		public string URL
		{
			get;
			set;
		}

		/// <summary>
		/// Дата модификации страницы (по карте сайта)
		/// </summary>
		[Column(Name = "LastModified", CanBeNull = true)]
		public DateTime? LastModified
		{
			get;
			set;
		}

		/// <summary>
		/// Тайтл страницы
		/// </summary>
		[Column(Name = "Title", CanBeNull = true)]
		public string Title
		{
			get;
			set;
		}

		/// <summary>
		/// Дата, когда мы твитили последний раз эту страницу
		/// </summary>
		[Column(Name = "TweetDate", CanBeNull = true)]
		public DateTime? TweetDate
		{
			get;
			set;
		}

		/// <summary>
		/// Блокировать (не твитить)
		/// </summary>
		[Column(Name = "Blocked", CanBeNull = false)]
		public bool Blocked
		{
			get;
			set;
		}

		internal string GetTwitterImageFileURL()
		{
			string result = null;
			try
			{
				TwitterImageExtractor extractor = new TwitterImageExtractor();

				using (WebClient client = new WebClient())
				{
					string htmlBody = client.DownloadString(URL);

					//Здесь мы проведем анализ - соберем все ссылки на аттачи-изображения на этой странице
					AttachPagesLoader attachPagesLoader = new AttachPagesLoader(URL, htmlBody);
					string[] imagePagesURLs = attachPagesLoader.GetAttachImagePagesURLs();

					if (imagePagesURLs != null && imagePagesURLs.Length > 0)
					{
						//извлечем случайно одну из них, и у нее пробуем взять твиттер-изображение
						Random r = new Random();
						int indexOfURL = r.Next(0, imagePagesURLs.Length);
						string urlToGetImage = imagePagesURLs[indexOfURL];

						//теперь извлечем оттуда тело html и его изображение
						string htmlBodySubPage = client.DownloadString(urlToGetImage);
						string subPageImageURL = extractor.ExtractImageURL(htmlBodySubPage);
						if (!string.IsNullOrEmpty(subPageImageURL))
						{
							result = subPageImageURL;
							return result;
						}
					}

					//если что-то пошло не так - берем уже по-старому
					result = extractor.ExtractImageURL(htmlBody);
				}
			}
			catch (Exception)
			{
			}
			return result;
		}

		public string CreateTwitterText()
		{
			PostText text = new PostText(URL, Title);
			return text.CreateTwitterText();
		}

		string _TwitterImageURL;
		bool _TwitterImageURLDone;

		public bool HasImage
		{
			get
			{
				if (!_TwitterImageURLDone)
				{
					_TwitterImageURLDone = true;
					_TwitterImageURL = GetTwitterImageFileURL();
				}

				return !string.IsNullOrWhiteSpace(_TwitterImageURL);
			}
		}

		string _ImageFileOnDisk;

		/// <summary>
		/// Картинка (путь на нашем локальном диске, готова для работы). 
		/// null если нет или не загрузилась или другие проблемы
		/// </summary>
		public string ImageFileName
		{
			get
			{
				if (!HasImage)
					return null;

				if (_ImageFileOnDisk == null)
				{
					//скачать на диск файл-картинку, вернуть путь к ней
					ImageDownloader imgDown = new ImageDownloader(_TwitterImageURL);
					int tryCount = 3;
					while (tryCount > 0)
					{
						if (imgDown.FileName != null)
						{
							_ImageFileOnDisk = imgDown.FileName;
							break;
						}

						tryCount--;
						imgDown = new ImageDownloader(_TwitterImageURL);
					}
				}

				return _ImageFileOnDisk;
			}
		}

		public override string ToString()
		{
			return URL;
		}
	}
}
