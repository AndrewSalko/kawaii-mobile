<?php

//include ('kawaii-resolution.php');
//include ('kawaii-characters.php');

class KawaiiContent
{

	public function GetAttachAdditionalDescription($attID)
	{
		//доп.текст
		$addText = array(0 => "anime phone wallpapers",//2966
			1 => "anime wallpaper phone",			//2431
			2 => "ecchi wallpaper",					//236			
			3 => "wallpaper anime android", 		//1010
			4 => "anime wallpaper hd for android",	//650
			5 => "anime phone wallpaper",			//1552			
			6 => "anime wallpaper for android",		//1000
			7 => "anime wallpaper android",			//953
			8 => "anime mobile wallpaper",			//605
			9 => "anime wallpaper hd for android"	//650
		);

		$strID=strval($attID);
		$lastChar=substr($strID, -1);
		$lastID=intval($lastChar);

		return $addText[$lastID];
	}

	public function GetAttachTitleAndDescription($resolutionName, $attID, &$description)
	{
		//получить персонажей, если таковые есть, или тайтл главного поста
		$description="";
		$mainTitle="";
		$charactersCount=0;
		$charactersNames=KawaiiCharacters::GetCharacters($attID,$mainTitle,$charactersCount);

		//в зависимости от разрешения получить описание на аттач
		//Тайтл - это будет 'android' или 'iPhone 5'
		$detector=new KawaiiResolutionDetector();
		//$phoneTitle будет iPhone 5, android, точное указание модели телефона.
		//Но его может не быть, тогда - пустая строка
		$phoneTitle=$detector->GetPhoneTitle($resolutionName);

		$postTitle=$mainTitle;//тут будет общий тайтл для страницы

		$titles = array(0 => "mobile wallpaper",
			1 => "phone wallpaper",
			2 => "anime wallpaper",
			3 => "lock screen wallpaper",
			4 => "hd anime wallpaper",
			5 => "smartphone wallpaper",
			6 => "anime background",
			7 => "wallpaper for mobile phones",
			8 => "anime phone wallpaper",
			9 => "cute anime wallpaper"
		);

		//Если есть имена персонажей - берем сразу их, это лучше
		if($charactersNames!="")
		{
			$postTitle=$charactersNames;
		}

		//теперь добавим случайно ключевые слова - они войдут и в тайтл, и в контент
		$wallpaperText="wallpaper";//текст "по умолчанию"(обои)

		$strID=strval($attID);
		$lastChar=substr($strID, -1);
		$lastID=intval($lastChar);
		
		$addContent=$mainTitle." ".$this->GetAttachAdditionalDescription($attID).".";

		if($phoneTitle!="")
		{
			$wallpaperText="wallpaper"; //получится типа 'android wallpaper', 'iPhone 5 wallpaper'
			$description="Download ".$mainTitle." ". $phoneTitle. " wallpaper for your smartphone. ". $addContent;
		}
		else
		{
			//нет тайтла для телефона. Это все тогда будет идти по случ.тексту
			$wallpaperText=$titles[$lastID];
			$description="Download ".$mainTitle." ". $wallpaperText. ". " . $addContent;
		}



		//Исследование "трендов" - по убыванию популярность запросов:
		//--- супер-тренд
		//x3 iphone wallpaper     => обязательно в тайтл если iphone
		//x2 android wallpaper    => обязательно в тайтл если android

		//--- очень высокий тренд
		//mobile wallpaper
		//phone wallpaper
		//anime wallpaper

		//--- высокий тренд
		//lock screen wallpaper   -> тайтл
		//hd anime wallpaper               (+контент)
		//smartphone wallpaper    -> тайтл
		//anime background                 (+контент)

		//---- хороший тренд ----
		//x5 "cute anime wallpaper"        (+контент)
		//x3 "wallpaper for mobile phones" (+контент)

		//---- примерно равный тренд ----
		//100 "hd anime android wallpaper"
		//80  "anime phone wallpaper"
		//70  "smart phone wallpaper"
		//"anime lock screen"
		//47  "mobile anime wallpaper" (anime mobile wallpaper)
		//14  "anime lock screen wallpaper"
		//10  hd anime iphone wallpaper

		//<Персонажи> <iPhone> <640x960> (<идентиф.поста>)
		$fullTitle=sprintf("%s %s %s %s", $postTitle, $phoneTitle, $resolutionName, $wallpaperText);

		return $fullTitle;

	}//GetAttachTitleAndDescription

}