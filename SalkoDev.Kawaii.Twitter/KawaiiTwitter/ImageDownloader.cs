using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Text;

namespace SalkoDev.KawaiiTwitter
{
	class ImageDownloader
	{		
		public ImageDownloader(string url)
		{
			try
			{
				int ind = url.LastIndexOf('.');
				string ext = url.Substring(ind, url.Length - ind);
				string tempFile = Path.GetTempFileName().Replace(".tmp", ext);

				using (WebClient client = new WebClient())
				{
					client.DownloadFile(url, tempFile);

					FileName = tempFile;
				}
			}
			catch (Exception)
			{
			}			
		}

		public string FileName
		{
			get;
			private set;
		}

	}
}
