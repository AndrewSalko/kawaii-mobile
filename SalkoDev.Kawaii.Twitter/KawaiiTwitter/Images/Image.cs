using System;
using System.Data.Linq.Mapping;
using System.IO;
using System.Windows.Forms;

namespace SalkoDev.KawaiiTwitter.Images
{
	/// <summary>
	/// Таблица для отдельных изображений (например gif-файлов). На сайте их нет,
	/// но они лежат на диске. Папка для них базовая images, в ней - подпапки, такие же как slug-урлы постов.
	/// При твиттинге в базу помечается какой файл и когда твитили, а в твите будет ссылка на пост
	/// </summary>
	[Table(Name = "Images")]
	class Image : ITwittable, IMediaImage
	{
		[Column(Name = "id", IsPrimaryKey = true, CanBeNull = false, IsDbGenerated = true)]
		public long id
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
		/// Путь к файлу (относительно папки images), т.е. oregairu\ore1.gif
		/// </summary>
		[Column(Name = "FilePath", CanBeNull = false)]
		public string FilePath
		{
			get;
			set;
		}

		public bool HasImage => true;

		public string ImageFileName
		{
			get
			{
				string imagesDir = Path.Combine(Application.StartupPath, @"..\..\..\images");
				string fullPath = Path.Combine(imagesDir, FilePath);
				return fullPath;
			}
		}

		/// <summary>
		/// Страница будет установлена извне. Необходима для всего, чтобы сделать твит
		/// </summary>
		public Sitemap.SitePage Page
		{
			get;
			set;
		}

		public string CreateTwitterText()
		{
			if (Page == null)
				throw new ApplicationException("Страница не присоединена Page == null");

			return Page.CreateTwitterText();
		}

		public string Title
		{
			get
			{
				if (Page == null)
					throw new ApplicationException("Страница не присоединена Page == null");
				return Page.Title;
			}
			set
			{
			}
		}

		/// <summary>
		/// Это оконцовка URL для поиска
		/// </summary>
		/// <returns></returns>
		public string GetURLSlug()
		{
			string[] parts = FilePath.Split('\\');
			string searchURL = string.Format("/{0}/", parts[0]);
			return searchURL;
		}

		public override string ToString()
		{
			return FilePath;
		}
	}
}
