using System;
using System.Collections.Generic;
using System.Text;
using System.Drawing;

namespace WallpaperImages
{
	class PhonePromo
	{						
		Dictionary<string, string[]> _ScreenToPhones=new Dictionary<string,string[]>(StringComparer.CurrentCultureIgnoreCase);
		Random _Rnd = new Random(Environment.TickCount);

		public PhonePromo()
		{
			#region iPhone 320x480
			string[] iPhone320 = new string[] {
				"iPhone 3G", 
				"iPod", 
				"HTC Desire C", 
				"HTC Gratia", 
				"HTC Wildfire", 
				"HTC Cha-Cha", 
				"HTC Salsa",
				"Samsung S5830 Galaxy Ace",
				"Samsung S5660 Galaxy Gio",
				"Sony Ericsson E15i Xperia X8",
				"LG GT540 Optimus",
				"LG P500 Optimus One",
				"LG C550 Optimus",
				"LG Optimus L5",
				
				//"",
				"Fly E154",
				"Fly IQ256",
				"Fly IQ245",

				"Gigabyte GSmart G1310",

				"Samsung GT-S5380",	
				"Samsung GT-S6802 Galaxy Ace",
				"Samsung GT-S7500 Galaxy Ace",
				"Samsung GT-S5690 Galaxy Xcover",

				"Magic THL A1",	
				"Magic W660",	
				"Huawei U8655-1 Ascend Y200",	

				"LG P698 Optimus",	
				"LG E510 Optimus",
				"LG E612 Optimus L5",
				"LG E615 Optimus L5",
				
				"Sony ST21i Xperia",	
				"Sony Ericsson ST15i Xperia",	
				"Sony Ericsson WT19i",
				"Sony ST23i Xperia",
				"Sony ST27i Xperia",
				
				"Acer Liquid E320",	
				"Seals TS3"				
			};

			_ScreenToPhones["320x480"]=iPhone320;
			#endregion

			#region Nokia phones
			string[] nokia = new string[] { 
				"Nokia 808 PureView",
				"Nokia 5800",
				"Nokia C5",
				"Nokia C6",
				"Nokia C7",
				"Nokia E7",
				"Nokia X6",
				"Nokia N8",
				"Nokia N97",
				"Nokia 5250",
				"Nokia 5228",
				"Nokia 5230",

				"Nokia 500",
				"Nokia 603"
			};			
			_ScreenToPhones["360x640"] = nokia;
			#endregion

			#region iPhone 4
			string[] iPhone4 = new string[] { "iPhone 4", "iPod 4" };
			_ScreenToPhones["640x960"] = iPhone4;
			#endregion

			#region iPhone 5

			string[] iPhone5 = new string[] { "iPhone 5", "iPod 5" };
			_ScreenToPhones["640x1136"] = iPhone5;
			
			#endregion

			#region iPhone 6
			string[] iPhone6 = new string[] { "iPhone 6", "iPhone 7" };
			_ScreenToPhones["750x1334"] = iPhone6;

			#endregion


			#region 720x1280
			string[] phones720x1280 = new string[] 
			{ 							
				"Samsung Ativ S Neo",
				"Samsung Galaxy Mega 6.3",
				"ZTE PF112 HD",
				"Asus Padfone 2",
				"HTC Rezound",
				"ZTE Flash",
				"Motorola Droid Razr HD",
				"Sony Xperia V",
				"Sony Xperia S",
				"Acer CloudMobile",
				"Lenovo K800",
				"Motorola Atrix HD",
				"Samsung Galaxy Nexus",
				"Samsung Galaxy Note2 N7100",
				"Sony LT28H Xperia ion",
				"Samsung GT-i9300 Galaxy S3",
				"HTC Windows Phone 8X",
				"Sony LT26i Xperia S",
				"HTC One X",
				"Huawei U9500-1 Ascend D1",
				"Magic THL W3"
			};
			_ScreenToPhones["720x1280"] = phones720x1280;

			#endregion

			#region 1440x1280
			string[] phones1440x1280 = new string[]
			{
				"Android"
			};
			_ScreenToPhones["1440x1280"] = phones1440x1280;

			#endregion

			#region 2160x1920
			string[] phones2160x1920 = new string[]
			{
				"Android"
			};

			_ScreenToPhones["2160x1920"] = phones2160x1920;
			#endregion

			#region 1080x1920
			string[] phones1080x1920 = new string[] 
			{				
				"iPhone 6 Plus",
				"iPhone 7 Plus",
				"Magic THL W8",
				"Magic THL W9",
				"Magic THL W300",
				"Lenovo K900",
				"Sony Xperia Z",
				"Samsung Galaxy S4",
				"LG D802 Optimus G2",
				"HTC One",
				"Samsung Galaxy Note 3"
			};
			_ScreenToPhones["1080x1920"] = phones1080x1920;
			#endregion

		}

		public string GetPhonePromoText(Size phoneScreenSize)
		{
			string result = string.Empty;

			//формируем ключ - разрешение:
			string key = string.Format("{0}x{1}", phoneScreenSize.Width, phoneScreenSize.Height);

			string[] phoneNames;
			if (!_ScreenToPhones.TryGetValue(key, out phoneNames))
			{
				return result;
			}

			//берем случайно 1 имя			
			int index=_Rnd.Next(0, phoneNames.Length);

			result = phoneNames[index];

			//а теперь добавим к нему ключевое слово "wallpaper"
			result += " wallpaper";

			return result;
		}

	}
}
