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
	}
}
