using System;
using System.Collections.Generic;
using System.Configuration;
using System.IO;
using System.Linq;
using System.Text;
using LinqToTwitter;


namespace SalkoDev.KawaiiTwitter
{
	public class Service
	{
		const string _MEDIA_CATEGORY_IMAGE = "tweet_image";
		const string _MEDIA_CATEGORY_GIF = "tweet_gif";

		const string _GIF_EXT = "gif";

		TwitterContext _Context;

		public Service()
		{
			string twitterAPIKey = ConfigurationManager.AppSettings["TwitterAPIKey"];
			string twitterAPISecret = ConfigurationManager.AppSettings["TwitterAPISecret"];

			string twitterAccessToken = ConfigurationManager.AppSettings["TwitterAccessToken"];
			string twitterAccessTokenSecret = ConfigurationManager.AppSettings["TwitterAccessTokenSecret"];

			IAuthorizer auth = new SingleUserAuthorizer
			{
				CredentialStore = new SingleUserInMemoryCredentialStore
				{
					ConsumerKey = twitterAPIKey,
					ConsumerSecret = twitterAPISecret,
					AccessToken = twitterAccessToken,
					AccessTokenSecret = twitterAccessTokenSecret
				}
			};

			auth.AuthorizeAsync().Wait();

			_Context = new TwitterContext(auth);
		}


		/// <summary>
		/// Если вернул true, надо ждать минут 15 до след.вызова любого метода
		/// </summary>
		public bool LimitReached
		{
			get
			{
				//TODO@: реализовать проверку лимитов 

				//var limits = API.Response.RateLimitStatus;
				//if (limits.RemainingHits <= 2)
				//{
				//	//превышен лимит, нужно подождать минут 15
				//	return true;
				//}

				return false;
			}
		}

		public void TweetWithMedia(string tweetText, string imageFileName)
		{
			byte[] fileBody = File.ReadAllBytes(imageFileName);

			string mediaType = null;

			string mediaCategory = _MEDIA_CATEGORY_IMAGE;

			string ext = Path.GetExtension(imageFileName);
			if (!string.IsNullOrEmpty(ext))
			{
				ext = ext.ToLower().Replace(".", string.Empty);
				if (ext == _GIF_EXT)
				{
					mediaCategory = _MEDIA_CATEGORY_GIF;
				}

				mediaType = string.Format("image/{0}", ext);
			}

			if (string.IsNullOrEmpty(mediaType))
			{
				string msg = $"Неможливо визначити тип зображення для файлу {imageFileName}";
				throw new ApplicationException(msg);
			}

			var uploadTaskResult = _Context.UploadMediaAsync(fileBody, mediaType, mediaCategory).Result;
			var mediaID = uploadTaskResult.MediaID;

			ulong[] mediaIDs = new ulong[] { mediaID };

			//TODO@: можно даже задать alt-текст? неплохо изучить позже
			//mediaIds.ForEach(async id => await twitterCtx.CreateMediaMetadataAsync(id, $"Test Alt Text for Media ID: {id}"));

			var result = _Context.TweetAsync(tweetText, mediaIDs).Result;
		}
	}
}
