<?php
/* 
Plugin Name: Shortcuts Kawaii
Plugin URI: https://kawaii-mobile.com/
Version: v1.00
Author: <a href="http://kawaii-mobile.com/">Andrew Salko</a>
Description: A helper shortcuts plugin for a <a href="http://kawaii-mobile.com">http://kawaii-mobile.com</a>
*/

require_once(plugin_dir_path( __FILE__ ) . 'shortcuts-kawaii.php');

if (!class_exists("ShortcutsKawaii")) 
{
	include ('kawaii-genres.php');

	class ShortcutsKawaii
	{

		function ShortcutsKawaii() 
		{ //constructor			
		}

		public static function do_shortcode_genres($atts, $content) 
		{
			$siteURL=get_site_url();

			$genres=new KawaiiGenres();
			$resultLinks=$genres->GetGenres($siteURL);

			return $resultLinks;
		}


	}//class

	if (class_exists("ShortcutsKawaii")) 
	{
		$pluginShortcutsKawaii = new ShortcutsKawaii();
	}

}//End Class ShortcutsKawaii

//Actions and Filters	
if (isset($pluginShortcutsKawaii)) 
{    			
	add_shortcode('kawaii-genres', array('ShortcutsKawaii', 'do_shortcode_genres'));
}

