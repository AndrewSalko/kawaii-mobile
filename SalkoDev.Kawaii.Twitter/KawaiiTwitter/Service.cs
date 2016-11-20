using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using TweetSharp;

namespace SalkoDev.KawaiiTwitter
{
	public class Service
	{
		public Service(TwitterService service)
		{
			API = service;
		}

		public TwitterService API
		{
			get;
			private set;
		}

		/// <summary>
		/// Если вернул true, надо ждать минут 15 до след.вызова любого метода
		/// </summary>
		public bool LimitReached
		{
			get
			{
				var limits = API.Response.RateLimitStatus;
				if (limits.RemainingHits <= 2)
				{
					//превышен лимит, нужно подождать минут 15
					return true;
				}

				return false;
			}
		}

	}
}
