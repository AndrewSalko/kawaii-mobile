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
	class SitePage
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

		/// <summary>
		/// Генерирует текст для твита для данной страницы
		/// </summary>
		/// <returns></returns>
		internal string CreateTwitterText()
		{
			//формируем текст для твита данной страницы
			string urlAndTags = string.Format("{0}{1}{2}", URL, Environment.NewLine, _GetRandomHashTags());
			string complexText = string.Empty;
			if (!string.IsNullOrWhiteSpace(Title))
				complexText = Title;

			complexText += " ";
			complexText += urlAndTags;
			if (complexText.Length < 140)
			{
				return complexText;
			}
			else
			{
				//проверим, может без хеш-тегов выйдет?
				string complexText2 = string.Format("{0} {1}", Title, URL);
				if(complexText2.Length<140)
				{
					return complexText2;
				}
			}
			
			return urlAndTags;
		}

		string _GetRandomHashTags()
		{
			string[] animeHashTags = new string[] { "#anime", "#animewallpaper", "#animegirl" };
			string[] hashTags = new string[] { "#otaku", "#animelover", "#smartphonewallpaper", "#iphone", "#smartphone" };
			Random rnd = new Random(Environment.TickCount);

			List<string> resultList = new List<string>();
			
			int ind = rnd.Next(animeHashTags.Length);
			string tag = animeHashTags[ind];
			resultList.Add(tag);
			
			//один хеш тег из одного списка, второй из другого
			ind = rnd.Next(hashTags.Length);
			tag = hashTags[ind];
			resultList.Add(tag);

			string result = string.Join(" ", resultList.ToArray());

			return result;
		}

		internal string GetTwitterImageFileURL()
		{
			string result = null;
			try
			{
				using (WebClient client = new WebClient())
				{
					string htmlBody = client.DownloadString(URL);
					string twiImage = "twitter:image";
					string contentEq = "content=\"";

					int twImgStart = htmlBody.IndexOf(twiImage);
					if(twImgStart>=0)
					{
						int contentEqStart = htmlBody.IndexOf(contentEq, twImgStart + twiImage.Length);
						if(contentEqStart>=0)
						{
							int lastQuoteInd=htmlBody.IndexOf("\"", contentEqStart + contentEq.Length);

							string resultURL = htmlBody.Substring(contentEqStart + contentEq.Length, lastQuoteInd - (contentEqStart + contentEq.Length));
							return resultURL;
						}
					}								
				}
			}
			catch (Exception)
			{
			}
			return result;
		}
	}
}
