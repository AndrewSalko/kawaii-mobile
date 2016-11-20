using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Net;
using System.Text.RegularExpressions;
using System.Xml;

namespace SalkoDev.KawaiiTwitter.Sitemap
{
	class SitemapLoader
	{				
		string _FileName;

		List<SitePage> _ResultPages = new List<SitePage>();

		/// <summary>
		/// Задержка между запросами к сайту по тайтлу (в мс)
		/// </summary>
		public int DelayIntervalTitleRequest
		{
			get;
			set;
		}

		public SitemapLoader(string fileName)
		{
			if (string.IsNullOrWhiteSpace(fileName))
				throw new ArgumentException("fileName");

			_FileName = fileName;
		}

		public SitePage[] Pages
		{
			get
			{
				if (_ResultPages.Count == 0)
					return null;

				return _ResultPages.ToArray();
			}
		}

		internal void DoWork(BackgroundWorker worker, ILog log)
		{
			using (WebClient client = new WebClient())
			{
				var	xmlDoc = new XmlDocument();
				xmlDoc.Load(_FileName);

				XmlNamespaceManager nsmgr = new XmlNamespaceManager(xmlDoc.NameTable);
				nsmgr.AddNamespace("x", "http://www.sitemaps.org/schemas/sitemap/0.9");

				//выбираем все ноды <url>						
				XmlNodeList urlNodes = xmlDoc.SelectNodes("//x:url", nsmgr);
				if (urlNodes.Count > 0)
				{
					int totalNodes = urlNodes.Count;
					int processed = 0;

					for (int i = 0; i < urlNodes.Count; i++)
					{
						if (worker.CancellationPending)
						{
							log.Log("Загрузка отменена");
							_ResultPages.Clear();
							return;
						}
																								
						var node = urlNodes[i];

						SitePage page = new SitePage();
												
						var locNode = node.SelectSingleNode("x:loc", nsmgr);
						if(locNode!=null)
						{
							page.URL = locNode.InnerText;
						}

						var dateNode = node.SelectSingleNode("x:lastmod", nsmgr);
						if (dateNode != null)
						{
							DateTime dt;
							string dateVal = dateNode.InnerText;
							if (!string.IsNullOrWhiteSpace(dateVal))
							{
								if (DateTime.TryParse(dateVal, out dt))
								{
									page.LastModified = dt;
								}
							}
						}

						if (page.URL != null && page.LastModified != DateTime.MinValue)
						{
							//получить тайтл
							string title = _GetTitle(page.URL);
							if(title!=null)
							{
								page.Title = title;
							}

							_ResultPages.Add(page);

							processed++;
							log.Log("Загружено {0} из {1} страниц", processed, totalNodes);

							if (DelayIntervalTitleRequest!=0)
							{
								System.Threading.Thread.Sleep(DelayIntervalTitleRequest);
							}
						}

					}//for
				}//if

			}//using web client

		}

		string _GetTitle(string url)
		{
			string result = null;
			try
			{
				using (WebClient client = new WebClient())
				{
					string htmlBody = client.DownloadString(url);

					Match m = Regex.Match(htmlBody, @"<title>(.*?)</title>");
					if (m.Success)
					{
						result = m.Groups[1].Value;
					}

					if (result == null)
					{
						Match m2 = Regex.Match(htmlBody, @"<TITLE>(.*?)</TITLE>");
						if (m2.Success)
						{
							result = m2.Groups[1].Value;
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
