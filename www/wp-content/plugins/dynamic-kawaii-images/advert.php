<?php

// Class detects character names 
// from attach ID (imageID)
class KawaiiAdvert
{
	//Вызывается из WP_FOOTER, добаляет рекламные скрипты
	//Скрипты всегда "блокируются" в robots.txt ,
	//чтобы реклама не мешалась роботу
	public static function Footer()
	{
		$scriptPath= plugins_url('kawaii-ads.js', __FILE__);
		echo '<script type="text/javascript" src="'.$scriptPath.'"></script>';
	}
}