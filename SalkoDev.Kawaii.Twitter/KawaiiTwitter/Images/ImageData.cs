using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data.Linq.Mapping;
using System.Data;

namespace SalkoDev.KawaiiTwitter.Images
{
	[Database(Name = "main")]
	class ImageData : DbLinq.Sqlite.SqliteDataContext
	{

		public ImageData(IDbConnection conn) : base(conn)
		{
		}

		public DbLinq.Data.Linq.Table<Image> Images
		{
			get
			{
				return this.GetTable<Image>();
			}
		}



	}
}
