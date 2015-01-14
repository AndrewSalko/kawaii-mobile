<?php
/* 
Plugin Name: Kawaii AddThis
Plugin URI: http://www.salkodev.com/
Version: v1.00
Author: <a href="http://www.salkodev.com/">Andrew Salko</a>
Description: A helper AddThis plugin for a <a href="http://kawaii-mobile.com">http://kawaii-mobile.com</a>
*/

require_once(plugin_dir_path( __FILE__ ) . 'kawaii-sitemap.php');

if (!class_exists("KawaiiAddThis")) 
{
	class KawaiiAddThis
	{

		function KawaiiAddThis() 
		{ //constructor
			
		}

		public static function GetInnerButtons()
		{
			$addContent='';
			$addContent .= '<a class="addthis_button_google_plusone_share"></a>';
			$addContent .= '<a class="addthis_button_facebook"></a>';
			$addContent .= '<a class="addthis_button_twitter"></a>';
			$addContent .= '<a class="addthis_button_tumblr"></a>';
			$addContent .= '<a class="addthis_button_linkedin"></a>';
			$addContent .= '<a class="addthis_button_favorites"></a>';
			$addContent .= '<a class="addthis_counter addthis_bubble_style"></a>';
			return $addContent;
		}

		public static function GetScript($standartButtons)
		{
			$addContent='';	

			if($standartButtons===TRUE)
			{
				//standart style, mobile or small window
				$addContent .= '<div class="addthis_toolbox addthis_default_style addthis_32x32_style kawaii_sharing_standart">';
			}
			else
			{
				//float style,for desktop
				$addContent .= '<div class="addthis_toolbox addthis_floating_style addthis_32x32_style kawaii_sharing_float">';
			}

			$addContent .= KawaiiAddThis::GetInnerButtons();
			$addContent .= '</div>';
			return $addContent;
		}

		function GetAddThisScriptLoader()
		{
			$addContent='';	
			$addContent .= '<script type="text/javascript">var addthis_config = { "data_track_addressbar": false };</script>';
			$addContent .= '<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52ac5aea586b25eb"></script>';
			return $addContent;
		}

		function do_wp_footer()
		{	
			//add floating bar (vertical)					
			echo KawaiiAddThis::GetScript(FALSE);			
			echo KawaiiAddThis::GetAddThisScriptLoader();
		}

		function do_add_stylesheet()
		{		  
			wp_register_style( 'kawaiisharing', plugins_url('kawaiisharing.css', __FILE__) );
			wp_enqueue_style( 'kawaiisharing' );			
		}

		function do_content($content)
		{
			//add standart bar to content
			$addContent=KawaiiAddThis::GetScript(TRUE);

			return  $content . $addContent;
		}

		function do_image_sitemap()
		{
    		if(function_exists('add_submenu_page')) 
			{
				add_submenu_page('tools.php', 'Image Sitemap Kawaii', 'Image Sitemap Kawaii', 'manage_options', 'image-sitemap-kawaii-uniq-id', array('KawaiiAddThis', 'do_image_sitemap_generate'));
			}
		}

		function do_image_sitemap_generate() 
		{
			if ($_POST ['submit']) 
			{
				$result=KawaiiAddThis::Generate();

			    if (!$result)
				{
					echo '<br /><div class="error"><h2>An error occured!</h2><p>The XML sitemap was generated successfully but the  plugin was unable to save the xml to your WordPress root folder at <strong>' . $_SERVER["DOCUMENT_ROOT"] . '</strong>.</p><p>Please ensure that the folder has appropriate <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">write permissions</a>.</p><p> You can either use the chmod command in Unix or use your FTP Manager to change the permission of the folder to 0666 and then try generating the sitemap again.</p><p>If the issue remains unresolved, please post the error message in this <a target="_blank" href="http://wordpress.org/tags/google-image-sitemap?forum_id=10#postform">WordPress forum</a>.</p></div>';
					exit();
				}
				else
				{
					echo '<h2>Done</h2>';
				}

			}
			else
			{
				echo '<div class="wrap">';
				echo '<div style="width:800px; padding:10px 20px; background-color:#eee; font-size:.95em; font-family:Georgia;margin:20px">';
  				echo '<h2>XML Sitemap for Images (kawaii-mobile)</h2>';
  				echo '<p>Sitemaps are a way to tell Google and other search engines about web pages, images and video content on your site that they may otherwise not discover. </p>';
				echo '<form id="options_form" method="post" action="">';
    			echo '<div class="submit">';
      			echo '<input type="submit" name="submit" id="sb_submit" value="Generate Image Sitemap" />';
    			echo '</div>';
				echo '</form>';
				echo '<p>Click the button above to generate a Image Sitemap for your website. Once you have created your Sitemap, you should submit it to Google using Webmaster Tools. </p>';
				echo '</div>';
			}//else

		}//do_image_sitemap_generate

		public static function Generate()
		{
			$imageCacheDirBase=WP_CONTENT_DIR . '/imagescache';
			//check this directory, if need - create it
			if(! (is_dir($imageCacheDirBase) || mkdir($imageCacheDirBase)) )
			{
				return false;
			}

			//return an array fileName=>XML body
			$xmlFiles=KawaiiSiteMap::Generate($imageCacheDirBase);
			if($xmlFiles===false)
				return false;

			return true;
		}//Generate


	}//class

	if (class_exists("KawaiiAddThis")) 
	{
		$pluginKawaiiAddThis = new KawaiiAddThis();
	}

}//End Class KawaiiAddThis

//Actions and Filters	
if (isset($pluginKawaiiAddThis)) 
{    			
	add_filter('wp_footer', array('KawaiiAddThis', 'do_wp_footer'),1);

	add_action('wp_enqueue_scripts', array('KawaiiAddThis','do_add_stylesheet'), 1);

	add_filter('the_content', array('KawaiiAddThis', 'do_content'),1);

	add_action('admin_menu', array('KawaiiAddThis', 'do_image_sitemap'),1);
}