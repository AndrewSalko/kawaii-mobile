using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Linq.Mapping;
using System.Linq;
using System.Text;

namespace SalkoDev.KawaiiTwitter.Sitemap
{
	[Database(Name = "main")]
	class SitePageData : DbLinq.Sqlite.SqliteDataContext
	{
		public SitePageData(IDbConnection conn) : base(conn)
		{
		}

		public DbLinq.Data.Linq.Table<SitePage> Pages
		{
			get
			{
				return this.GetTable<SitePage>();
			}
		}

		/// <summary>
		/// Найти пост по его URL
		/// </summary>
		/// <param name="searchURL">Должен быть в формате /akame-ga-kill/</param>
		/// <returns></returns>
		public SitePage[] GetPostByURLSlug(string searchURL)
		{
			var postInDB = (from p in Pages where p.URL.EndsWith(searchURL) select p).ToArray();
			return postInDB;
		}

	}
}
