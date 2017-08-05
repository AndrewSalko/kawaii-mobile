using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace SalkoDev.KawaiiTwitter
{
	interface IMediaImage
	{

		/// <summary>
		/// Для нормальной работы извне нужно установить связанную страницу-пост
		/// </summary>
		Sitemap.SitePage Page
		{
			get;
			set;
		}

		/// <summary>
		/// Это оконцовка URL для поиска
		/// </summary>
		/// <returns></returns>
		string GetURLSlug();
			


	}
}
