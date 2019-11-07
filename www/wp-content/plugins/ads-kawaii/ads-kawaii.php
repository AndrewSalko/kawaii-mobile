<?php
/* 
Plugin Name: Kawaii Ads
Plugin URI: https://kawaii-mobile.com/
Version: v1.00
Author: <a href="http://www.salkodev.com/">Andrew Salko</a>
Description: A helper Advert plugin for a <a href="https://kawaii-mobile.com">https://kawaii-mobile.com</a>
*/

require_once(plugin_dir_path( __FILE__ ) . 'kawaii-sitemap.php');

if (!class_exists("KawaiiAds")) 
{
	class KawaiiAds
	{
		const	TR_CLOSE_NODE="</tr>";
		const	TR_STUB_NODE="kawaiitr";
		const	TR_REAL_NODE="tr";

		public static function GetSharingHtml()
		{
			$addContent='';	
			$nl="\n";

			$addContent .='<div id="fb-root"></div>';
            $addContent .='<div class="sharing-bar">';
            $addContent .='<div><g:plusone width="60" size="tall"></g:plusone></div>';
			$addContent .='<div class="fb-like" data-layout="box_count" data-action="like" data-show-faces="false" data-share="true"></div>';
			
			
			$addContent .='<script type="text/javascript">' .$nl;
			$addContent .='var write_string="<iframe height=\"69\" width=\"51\" scrolling=\'no\' frameborder=\'0\' src=\"//www.redditstatic.com/button/button2.html?url="+encodeURIComponent(window.location.href)+"\"></iframe>";' .$nl;
			$addContent .='document.write(write_string);' .$nl;
			$addContent .='</script>' .$nl;

			$addContent .='<su:badge layout="5"></su:badge>';

            $addContent .='</div>';

			return $addContent;
		}

		function GetSocialScriptLoader()
		{
			$nl="\n";
			$addContent=''.$nl;
			$sharing_script=plugins_url('kawaiisharing.js', __FILE__);
			$addContent .= $nl.'<script type="text/javascript" src="'. $sharing_script .'" async defer></script>'.$nl;

			return $addContent;
		}


		function GetEventsScriptLoader()
		{
			$nl="\n";
			$addContent=''.$nl;
			$events_script=plugins_url('kawaii-events.js', __FILE__);
			$addContent .= '<script type="text/javascript" src="'. $events_script .'" async defer></script>'.$nl;

			return $addContent;
		}

		function _IsPageLevelAdsEnabledOnHome()
		{
			return false;
		}

		function _IsPageLevelAdsEnabledOnSingle()
		{
			return false; 	//page level on POST
		}

		function _IsPageLevelAdsEnabledOnAttach()
		{
			return true;    //page level on Attach
		}

		//Ads in post table (special banner)
		function _IsAdsEnabledInPostTable()
		{
			return true;
		}

		function _EndsWith($text, $subString)
		{
			$length = strlen($subString);
			if ($length == 0) 
			{
				return true;
			}
		
			return (substr($text, -$length) === $subString);
		}

		//Вернет true - скрипт ADSense не включается вообще (блокировка отдельных страниц и постов)
		function _IsAdsenseDisabledForThisURL()
		{
			$url = $_SERVER['REQUEST_URI'];
		
			if(is_category() || is_tag())
			{
				return true;	//общая блокировка рекламы - архив по категориям (например: kawaii-mobile.com/category/android/) и тегам
			}

			$arrDisabled=array('/onii-chan-dakedo-ai-sae-areba-kankei-nai-yo-ne/',
								'/highschool-of-the-dead-android-and-iphone/highschool-of-the-dead-1080x1920/',
								'/sora-no-otoshimono-iphone-4/');
			
			foreach($arrDisabled as $urlPart)
			{
				if (KawaiiAds::_EndsWith($url, $urlPart) == true) 
				{
					return true;
				}
			}

			return false;
		}

		function do_wp_head()
		{
			//google analytics always included
?>
<script type="text/javascript">
<?php include( plugin_dir_path( __FILE__ ) . 'kawaii-ga.js.php'); ?>
</script>
<?php

			if(KawaiiAds::_IsAdsenseDisabledForThisURL())
			{
				return;
			}

			if(is_home())
			{
				if(!KawaiiAds::_IsPageLevelAdsEnabledOnHome())
				{
					return;	//on home no ads, only page-level ads possible
				}
			}
			else
			{
				if(is_attachment())
				{
					if(!KawaiiAds::_IsPageLevelAdsEnabledOnAttach())
					{
						return;
					}
				}
				else
				{
					if(is_single())
					{
						//post and other single but not attach
						if(!KawaiiAds::_IsPageLevelAdsEnabledOnSingle() && !KawaiiAds::_IsAdsEnabledInPostTable())
						{
							return;
						}
					}
				}
			}

			echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
			echo '<script>';
  			echo '(adsbygoogle = window.adsbygoogle || []).push({ google_ad_client: "ca-pub-2908292943805064", enable_page_level_ads: true });';
			echo '</script>';
		}


		function do_wp_footer()
		{	
			//if it's main page, load script because do_content not used in such case
			if(is_home())
			{
				//echo KawaiiAds::GetSharingHtml();
			}

			if(!is_attachment())
			{
				//add sharing script (at bottom)
				//echo KawaiiAds::GetSocialScriptLoader();
			}

			//add Google Analytics event tracking on custom images
			echo KawaiiAds::GetEventsScriptLoader();
		}

		function do_add_stylesheet()
		{		  
			wp_register_style( 'kawaiiads1', plugins_url('kawaiiads1.css', __FILE__) );
			wp_enqueue_style( 'kawaiiads1' );
		}

		function GetBannerCode($bannerInfoArr)
		{
			$slot=$bannerInfoArr["slot"];
			$comment=$bannerInfoArr["comment"];

			$bannerHtmlCode="<!-- ".$comment." -->";
			$bannerHtmlCode.= "<ins class=\"adsbygoogle\" style=\"display:block\" data-ad-client=\"ca-pub-2908292943805064\" data-ad-slot=\"".$slot."\" data-ad-format=\"auto\" data-full-width-responsive=\"false\"></ins>";
			$bannerHtmlCode.= "<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>";

			return $bannerHtmlCode;
		}

		function do_content($content)
		{
			if(is_attachment() || is_feed() || is_home() || !is_single())
			{
				return $content;//do nothing
			}

			//if spec ad not allowed in table (in post body)

			if(!KawaiiAds::_IsAdsEnabledInPostTable())
			{
				return $content;
			}

			if(KawaiiAds::_IsAdsenseDisabledForThisURL())
			{
				return $content;
			}

			//check if we have 'table' in content? we need find first </tr>

			$startInd=0;
			$firstInd=stripos($content, KawaiiAds::TR_CLOSE_NODE, $startInd);

			if ($firstInd===FALSE)
			{
				return $content;
			}

			$adsCount=0;

			$contentModified=$content;

			$adsFileIndex=0;

			$banners = array(0 => array("slot" => "7273236631", 
										"comment" => "Banner-adaptive-in-post-table-1"),
							1 => array("slot" => "7171099150",
										"comment" => "Banner-adaptive-in-post-table-2"),
							2 => array("slot" => "3910016153",
										"comment" => "Banner-adaptive-in-post-table-3"));


			while($adsCount < count($banners))
			{
				if ($firstInd===FALSE)
				{
					break;	//not found
				}

				$bannerArrItem=$banners[$adsFileIndex];
				$adContent=KawaiiAds::GetBannerCode($bannerArrItem);
				$adsFileIndex++;

				$str_to_insert="<kawaiitr><td>".$adContent."</td></kawaiitr>";

				$contentModified = substr_replace($contentModified, $str_to_insert, $firstInd+5, 0);
				$startInd=$firstInd + 5; //len tr
				$adsCount++;
				
				$firstInd=stripos($contentModified, KawaiiAds::TR_CLOSE_NODE, $startInd);
			}

			if($adsCount==0)
			{
				return $content;
			}

			$contentModified=str_replace(KawaiiAds::TR_STUB_NODE, KawaiiAds::TR_REAL_NODE, $contentModified);

			return $contentModified;
		}

		function do_image_sitemap()
		{
    		if(function_exists('add_submenu_page')) 
			{
				add_submenu_page('tools.php', 'Image Sitemap Kawaii', 'Image Sitemap Kawaii', 'manage_options', 'image-sitemap-kawaii-uniq-id', array('KawaiiAds', 'do_image_sitemap_generate'));
			}
		}

		function do_image_sitemap_generate() 
		{
			if ($_POST ['submit']) 
			{
				$result=KawaiiAds::Generate();

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

		const KAWAII_SHORTCODE_FOOTER2="[kawaii-shortcode-footer2]";
		const FOOTER2_AD_HTML="<a href='https://chainbeat.io' title='Blockchain smart contracts analytics - Ethereum, RSK, Tron'><img alt='Chainbeat - blockchain analytics dashboards' src='/wp-content/uploads/chainbeat-blockchain-analytic.png' style='width:300px;height: 200px;'></a>";

		//Не используется (3 блок, если надо заменить на свое)
		//const KAWAII_SHORTCODE_FOOTER3="[kawaii-shortcode-footer3]";
		//const FOOTER3_AD_HTML="<a href='https://analyther.com'><img src='/wp-content/uploads/analyther-smart-contract-analytics.png' alt='Ethereum smart contract analytics and insights' style='width:300px;height: 200px;' /></a>";

		function do_widget_text($content) 
		{
			$ad2=KawaiiAds::FOOTER2_AD_HTML;
			//$ad3=KawaiiAds::FOOTER3_AD_HTML;

			if((!is_home()) || is_paged())
			{
				$ad2="";
				//$ad3="";
			}		

			$startInd=0;
			$firstInd=stripos($content, KawaiiAds::KAWAII_SHORTCODE_FOOTER2, $startInd);
			if ($firstInd!==FALSE)
			{
                $content=str_replace(KawaiiAds::KAWAII_SHORTCODE_FOOTER2, $ad2, $content);
				return $content;
			}

			/*
			$firstInd=stripos($content, KawaiiAds::KAWAII_SHORTCODE_FOOTER3, $startInd);
			if ($firstInd!==FALSE)
			{
                $content=str_replace(KawaiiAds::KAWAII_SHORTCODE_FOOTER3, $ad3, $content);
				return $content;
			}
			*/

			return $content;
		}


	}//class

	if (class_exists("KawaiiAds")) 
	{
		$pluginKawaiiAds = new KawaiiAds();
	}

}//End Class KawaiiAds

//Actions and Filters	
if (isset($pluginKawaiiAds)) 
{    			
	add_filter('wp_footer', array('KawaiiAds', 'do_wp_footer'),1);

	add_action('wp_enqueue_scripts', array('KawaiiAds','do_add_stylesheet'), 1);

	add_filter('the_content', array('KawaiiAds', 'do_content'),1);

	add_action('admin_menu', array('KawaiiAds', 'do_image_sitemap'),1);

	add_action('wp_head', array('KawaiiAds', 'do_wp_head'), 9999);

	add_filter('widget_text', array('KawaiiAds', 'do_widget_text'), 100);

}