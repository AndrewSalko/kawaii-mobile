<?php
/* 
Plugin Name: Dynamic Kawaii Images
Plugin URI: http://www.salkodev.com/
Version: v1.00
Author: <a href="http://www.salkodev.com/">Andrew Salko</a>
Description: A helper plugin for a <a href="http://kawaii-mobile.com">http://kawaii-mobile.com</a>
*/

if (!class_exists("DynamicKawaiiImages")) 
{
	include ('kawaii-resolution.php');
	include ('encryptor-kawaii.php');
	include ('simpleimage.php');
	include ('kawaii-characters.php');
	include ('advert.php');
	include ('kawaii-content.php');

	class DynamicKawaiiImages
	{

		function DynamicKawaiiImages() 
		{ //constructor
			
		}

		public static function SendBaseImageHeaders($fileName)
		{
			header("HTTP/1.0 200 OK");
			$timeOffset = 60 * 60;//1 hour
			header("Expires: " . gmdate("D, d M Y H:i:s", time() + $timeOffset) . " GMT");
			header("Cache-Control: max-age=".$timeOffset.", must-revalidate"); 
			header("Pragma:");

			$fileExt=pathinfo($fileName, PATHINFO_EXTENSION);
			if($fileExt=='jpg' || $fileExt=='jpeg')
			{
				header("Content-Type: image/jpeg");
			}

			if($fileExt=='png')
			{
				header("Content-Type: image/png");
			}
		}

		public static function GetContentType($fileName)
		{
			$fileExt=pathinfo($fileName, PATHINFO_EXTENSION);
			if($fileExt=='jpg' || $fileExt=='jpeg')
			{
				return 'Content-Type: image/jpeg';				
			}

			if($fileExt=='png')
			{
				return 'Content-Type: image/png';				
			}	
			return '';				
		}

		// Save file to cache-dir and output it to browser.
		// The $image object will be cleaned.
		public static function OutputFileToBrowser($image, $fileNameForSave)
		{
			$fileExt=pathinfo($fileNameForSave, PATHINFO_EXTENSION);
			if($fileExt=='jpg' || $fileExt=='jpeg')
			{
				$image->save($fileNameForSave, IMAGETYPE_JPEG, 85);
			}

			if($fileExt=='png')
			{
				$image->save($fileNameForSave, IMAGETYPE_PNG);
			}	
        	
			$image->free();

        	//вывод в поток браузера того что сохранилось:
			ob_end_clean();
			readfile($fileNameForSave);
			flush(); 			
	        exit();			
		}		

		// Creates fake attach file name from real post ID
		// Returns FALSE if failed
		// Out params: $characters - имена персонажей
		public static function CreateImageElement($imageID, $resolution, &$characters)
		{
			$characters="";

			//check resolution
			$attMeta=wp_get_attachment_metadata($imageID);
            if($attMeta===FALSE)
			{
				return FALSE;
			}
					
			$attWidth=(int)$attMeta['width'];
			$attHeight=(int)$attMeta['height'];
						                       					
			$resParts=explode('x',$resolution);
			if(count($resParts)!=2)
			{
				return FALSE;
			}

			$imgWidth=$resParts[0];
			$imgHeight=$resParts[1];

			$resDetector=new KawaiiResolutionDetector();
			if($resDetector->IsResolutionAvailable($attWidth, $attHeight, $imgWidth, $imgHeight)==FALSE)
			{
				return FALSE;
			}

			$imgURL=wp_get_attachment_url($imageID);

			//full URL to attach page
			$postPermLink=post_permalink($imageID);			
			$fileName = basename($imgURL);

			//parts of file name..we need it later
			//Madlax.Margaret-Burton.Elenore-Baker.Madlax-HTC-Cha-Cha-wallpaper.Vanessa-Rene.320x480.jpg
			$nameParts=explode('.', $fileName);			
			$shortFileName=$nameParts[0];

			$namePartsCount=count($nameParts);
			if($namePartsCount>2)
			{
				$shortFileName='';
				//если можно, отрежем часть с разрешением
				for($q=0; $q<$namePartsCount-2; $q++)
				{
					if(strlen($shortFileName)>0)
					{
						$shortFileName.= '.';
					}

					$shortFileName.=$nameParts[$q];					
				}				
			}
			
			$fileExt=end($nameParts);//extension (jpg)

			$fileNameGood='kawaii-mobile.com.'.$shortFileName.'.'.$resolution.'.'.$fileExt;
            			
			$imgLink=$postPermLink.'custom/'.$fileNameGood.'?newsize='.$resolution.'&amp;id='.$imageID;

			$mainTitle="";
			$charactersCount=0;
			$imgAlt=KawaiiCharacters::GetCharacters($imageID, $mainTitle, $charactersCount);//подставить сюда имена персонажей

			//если не получии теги, или не нашлось, даем тайтл главного поста
			if($imgAlt=="")
			{
				$imgAlt=$mainTitle;
			}
			else
			{
				//мы вернем найденных персонажей
				$characters=$imgAlt;
			}

			$imgNode='<a href="'.$imgLink.'"><img class="image-autosize" src="'. $imgLink .'" alt="'. $imgAlt .'" title="'. $imgAlt. '" width="'.$imgWidth.'" height="'.$imgHeight.'"></img></a>';
			return $imgNode;

		}//CreateImageElement


		function do_template_redirect()
		{	
			global $wp_query;

			$url = $_SERVER['REQUEST_URI'];

						
			if (strpos($url,'/custom-image/') == true) 
			{												
				//here we extract attach ID from URL, and resolution:
				//custom-image/(attachID)/(320x240)
				//Very important: last slash may be!
				$trimmedURL=trim($url,'/');

				$splittedValues=explode('/',$trimmedURL);
				if(count($splittedValues)<3)
				{
					//assume 3 items at least:custom-image,attachID,320x240
					return;
				}

				//take last portion - this is resolution:
				$resolution=end($splittedValues);
				$attachID=prev($splittedValues);

				//check if we have such attachID in our base:
				$testPermLink=post_permalink($attachID);
				if($testPermLink===FALSE)
				{
					return;
				}

				$characters="";
				$imgNode=DynamicKawaiiImages::CreateImageElement($attachID, $resolution, $characters);
				if($imgNode===FALSE)
				{
					return;
				}

				$kawCont=new KawaiiContent();
				$descrText="";//описательный текст для страницы
				$attTitle=$kawCont->GetAttachTitleAndDescription($resolution, $attachID, $descrText);

				$wp_query->is_404 = false;
				status_header('200');

				get_header();
                
                $itPost=get_post($attachID);
				$parentPost=$itPost;

				echo '<div id="content">';

				// class=post необходим для wp-toch режима
				echo '<div class="post attachment type-attachment status-inherit clearfix single-post">';
				echo '<h1 class="entry-title">'.get_the_title($itPost->post_parent). ' wallpaper ';
				echo '[<a href="' . get_permalink( $parentPost ) . '">'. get_the_title($parentPost) .'</a>]';
				echo '</h1>';

				$resDetector=new KawaiiResolutionDetector();
				$mobilePhones=$resDetector->GetResolutionMobilePhones($resolution);
				if($mobilePhones!=NULL)
				{
					//описательный текст: персонажи, и прочее
					echo '<p>'. $descrText. ' ';
					//добавить имя персонажей перед словом Wallpaper
					echo 'This image is best suited to those phone models: ' . $mobilePhones. '</p>';
				}

				//добавить персонажа (типа Saber image size:) но если там два слова
				$sizePrefix="Image";
				if($characters!="")
				{
					$sizePrefix=$characters." image";
				}

				echo '<h2>'.$sizePrefix.' size: ' . $resolution . '</h2>';

				echo '</div>';

				global $wptouch_plugin;

				echo '<div class="post">';
				echo '<div id="container" class="single-attachment">';
				echo '	<div id="content" role="main">';
				echo $imgNode;
				echo '	</div><!-- #content -->';
				echo '</div><!-- #container -->';
				echo '</div><!-- #post -->';

				echo '</div>';// id="content"

				$mobileMode=false;
				if(isset ($wptouch_plugin))
				{				
					if ( bnc_is_iphone() && $wptouch_plugin->desired_view == 'mobile') 
					{
						$mobileMode=true;
					}
				}

				if($mobileMode)
				{					
					wptouch_include_adsense();
				}
				else
				{
					get_sidebar();
					get_footer();
				}

				return;
			}//if custom-image - special fake page
			

			//another check method for our special URL
			if (strpos($url,'/custom/') == false) 
			{
				return;
			}

			if(array_key_exists('newsize', $_GET)===FALSE ||
				array_key_exists('id', $_GET)===FALSE
					)
			{
				return;
			}

			$newsize=$_GET['newsize'];
			$imageID=$_GET['id'];
		
			$imageCacheDirBase=WP_CONTENT_DIR . '/imagescache';
			//check this directory, if need - create it			
			if(! (is_dir($imageCacheDirBase) || mkdir($imageCacheDirBase)) )
			{
				return;
			}

			//post perma link looks like:
			//http://kawaii-mobile.org/2012/11/hagure-yuusha-no-estetica/aesthetica-of-a-rogue-hero-hagure-yuusha-no-estetica-miu-myuu-ousawa-haruka-nanase-320x480/
			$postPermLink=post_permalink($imageID);
			if($postPermLink===FALSE)
			{
				return;
			}

			//разделим их по слешам и выделим имя поста, это будет имя подпапки
			$urlParts=explode('/', $postPermLink);
			end($urlParts);//прыгнули в конец массива
			prev($urlParts);
			$realPostName=prev($urlParts);//и взяли пред-последнюю часть (hagure-yuusha-no-estetica)
            
			//это будет под-папка в кеше:
			$imageCacheDir=$imageCacheDirBase . '/' . $realPostName;
			//check this directory, if need - create it			
			if(! (is_dir($imageCacheDir) || mkdir($imageCacheDir)) )
			{
				return;
			}			

			//все файлы именуются в стиле id_320x480 , чтобы их легче найти
			$filePrefix=$imageID.'_'.$newsize;

			$filesInCache = glob($imageCacheDir. '/'.$filePrefix.'*.*');
			if($filesInCache!=FALSE && is_array($filesInCache) && count($filesInCache)>0)
			{
				$resultFileName=$filesInCache[0];

				DynamicKawaiiImages::SendBaseImageHeaders($resultFileName);

				if(readfile($resultFileName)>0)
				{
        			die();
					return;
				}
			}
           
			$attMeta=wp_get_attachment_metadata($imageID);
            if($attMeta===FALSE)
			{
				return;
			}
					
			$attWidth=(int)$attMeta['width'];
			$attHeight=(int)$attMeta['height'];
			$attFileName=$attMeta['file'];
			$fileExt=pathinfo($attFileName, PATHINFO_EXTENSION);

			$contentType=DynamicKawaiiImages::GetContentType($attFileName);

			//parse new size:
			$destWidth=0;
			$destHeight=0;
			
			//$newsize
			$sizeParts=explode('x', $newsize);		
			$destWidth=(int)$sizeParts[0];
			$destHeight=(int)$sizeParts[1];
                        
			//check parameters (for bad users)
		
			$resDetector=new KawaiiResolutionDetector();
			if($resDetector->IsResolutionAvailable($attWidth, $attHeight, $destWidth, $destHeight)==FALSE)
			{
				//if we have un-supported resolution, redirect to attach post.
				//this possible if 'smart' users want from us something...
				header("location:".$postPermLink);
				return;
			}

			$upload_dir = wp_upload_dir();
			$fullFileName=$upload_dir['basedir'] . '/' . $attFileName;

			$image = new SimpleImage();
			$image->load($fullFileName);

			DynamicKawaiiImages::SendBaseImageHeaders($attFileName);

			//тут имя файла для сохранения в кеш
			$fileNameForSave=$imageCacheDir.'/'.$filePrefix.'.'.$fileExt;

			//проверим, позволяет ли изображение быть просто ресайзенным или
			//нужна интеллектуальная обрезка + ресайз
			if($resDetector->IsSimpleResize($attWidth, $attHeight, $destWidth, $destHeight))
			{
				$image->resize($destWidth, $destHeight);

				DynamicKawaiiImages::OutputFileToBrowser($image, $fileNameForSave);
				return;
			}

			//если дошли сюда нужно вырезать и возможно ресайзить
			$cutHeight=$resDetector->GetCutHeight($attWidth, $attHeight, $destWidth, $destHeight);
			if($cutHeight>0)
			{
				$image->CutByHeightAndResize($cutHeight, $destWidth, $destHeight);
				DynamicKawaiiImages::OutputFileToBrowser($image, $fileNameForSave);
				return;

			}

			//Если мы дошли сюда, то по ширине нужно уменьшить, чтобы
			//выдержать пропорции
			$image->CutByWidthAndResize($destWidth, $destHeight);
			DynamicKawaiiImages::OutputFileToBrowser($image, $fileNameForSave);
					    
		}//do_template_redirect

		function do_content($content)
		{
			global $post;

			if($post->post_type != 'attachment' || is_feed() || is_home() || !is_single())
			{
				return $content;//do nothing
			}
			
			$imageID=$post->ID;
			$imgURL=wp_get_attachment_url($imageID);
		
			//full URL to attach page
			$postPermLink=post_permalink($imageID);			
			$fileName = basename($imgURL);

			//parts of file name..we need it later
			//Madlax.Margaret-Burton.Elenore-Baker.Madlax-HTC-Cha-Cha-wallpaper.Vanessa-Rene.320x480.jpg
			$nameParts=explode('.', $fileName);			
			$shortFileName=$nameParts[0];

			$namePartsCount=count($nameParts);

			if($namePartsCount>2)
			{
				$shortFileName='';
				//если можно, отрежем часть с разрешением
				for($q=0; $q<$namePartsCount-2; $q++)
				{
					if(strlen($shortFileName)>0)
					{
						$shortFileName.= '.';
					}

					$shortFileName.=$nameParts[$q];					
				}				
			}//if

			$attMeta=wp_get_attachment_metadata($imageID);
			if($attMeta==FALSE)
			{
				return $content;//something wrong...default
			}

			$attWidth=$attMeta['width'];
			$attHeight=$attMeta['height'];

			//get available resolutions for this size:
			$resDetector=new KawaiiResolutionDetector();
			$resArr=$resDetector->GetAvailableResolutions($attWidth, $attHeight);
			$resName=sprintf("%sx%s", $attWidth, $attHeight);
			$uniqTitle=$resDetector->GetUniqTitleOnAttachID($resName,$imageID);

			//получаем персонажей
			$mainPostTitle="";
			$charactersCount=0;
			$charactersNames=KawaiiCharacters::GetCharacters($imageID, $mainPostTitle, $charactersCount);

			$singleCharacterName="";//имя персонажа - если он единственный
			if($charactersCount==1 || $charactersCount==2)
			{
				$singleCharacterName=" ". $charactersNames;
			}

			$descriptiveContent="";
			if($charactersNames=="")
			{
				$descriptiveContent=$mainPostTitle ." wallpaper";
			}
			else
			{
				$descriptiveContent=$charactersNames ." ". $uniqTitle;
			}

			$cont2=sprintf("Click on the links below to download the best suitable size images for your smartphone, and download the appropriate %s wallpaper. You may use this anime wallpaper for lock screen, or home screen background.",$mainPostTitle);
			$content.="<p>".$descriptiveContent.". ".$cont2."</p>";
			$content.="<p>";
				
			$linkNameCurrent=$resDetector->GetResolutionDescription($attWidth, $attHeight);

			$mainLink='<a href="'. $imgURL.'" >'.$linkNameCurrent.'</a>';

			$content .= '<div>';
			$content .= $mainLink;
			$content .= '</div>';

			//AD part
			$content = DynamicKawaiiImages::_AdSense($content);

			foreach ($resArr as $resName => $resParams)
			{
				$linkName=$resName;
				if (array_key_exists('description', $resParams))
				{
					$linkName=$linkName . $singleCharacterName . ' (' . $resParams['description']. ')';
				}

				//good file name.  
				$addLink='<div><a href="'.$postPermLink .'custom-image/'. $imageID .'/'.$resName. '" >'.$linkName.'</a></div>';
				$content .= $addLink;
			}
						
			$content.="</p>";
			return $content;
		}//do_content

		static function _AdSense($content)
		{
			global $wptouch_plugin;

			$mobileMode=false;
			if(isset ($wptouch_plugin))
			{
				//$mobileMode=true;

				if (bnc_is_iphone() && $wptouch_plugin->desired_view == 'mobile')
				{
					$mobileMode=true;
				}
			}

			$content .= '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';

			if($mobileMode)
			{
				//позже унифицировать (баннер из wptouch)
				$content .= '<!-- Kawaii-banner mobile 320x50 for attach page -->';
				$content .= '<ins class="adsbygoogle" style="display:inline-block;width:320px;height:50px" data-ad-client="ca-pub-6472729866072930" data-ad-slot="3749152772"></ins>';
			}
			else
			{
				$content .= '<!-- Kawaii-banner 468x60 for attach page -->';
				$content .= '<ins class="adsbygoogle" style="display:inline-block;width:468px;height:60px" data-ad-client="ca-pub-6472729866072930" data-ad-slot="4991551174"></ins>';
			}

			$content .= '<script>(adsbygoogle = window.adsbygoogle || []).push({});';
			$content .= '</script>';

			return $content;
		}

		function do_get_title($elements)
		{
			$url = $_SERVER['REQUEST_URI'];					
			if (strpos($url,'/custom-image/') == true) 
			{					
				//We have our special custom page. Must setup title tag.
				//$mainTitle=get_the_title($post->post_parent);	

				$trimmedURL=trim($url,'/');
				$splittedValues=explode('/',$trimmedURL);
				if(count($splittedValues)<3)
				{
					//assume 3 items at least:custom-image,attachID,320x240
					return $elements;
				}

				//take last portion - this is resolution:
				$resolution=end($splittedValues);
				$attachID=prev($splittedValues);
                $itPost=get_post($attachID);
				$parentTitle=get_the_title($itPost);//->post_parent
				//split title with dots.
				$splValues=explode('.',$parentTitle);

				$kawCont=new KawaiiContent();
				$descrText="";//описательный текст для страницы
				$attTitle=$kawCont->GetAttachTitleAndDescription($resolution, $attachID, $descrText);

				return $attTitle;
			}

			//do nothing,default
			return $elements;
		}//do_get_title

		// Получить изображение для поста
		static function GetFeaturedImage($pageID)
		{
			if ($pageID != '' && function_exists('has_post_thumbnail'))
			{
				if (has_post_thumbnail( $pageID ))
				{
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $pageID ), 'single-post-thumbnail' );
					if ($image !='')
						return $image[0];
					else
						return false;
				}
				else
				{
					//no thumbnail image
					return false;
				}
			}
			else
			{
				return false;
			}
		}


		function do_wp_head()
		{
			//блокируем пинтерест, так как он находится потом поиском google-images
			//нам это не нужно (потеря траффика)
			echo '<meta name="pinterest" content="nopin" />'. "\n";

			global $post;
			$imgURL='';//картинка для og:image

			if( is_attachment())
			{
				//страница файла-изображения. Картинка для него - он сам
				$imageID=$post->ID;
				$imgURL=wp_get_attachment_url($imageID);
			}
			else
			{
				//случай когда мы "дома" (дом.страница)
				if(is_home())
				{
					//для главной страницы подставим картинку из последнего поста
					$recent_posts = wp_get_recent_posts( array( 'numberposts' => '1' ) );
					$postID = $recent_posts[0]['ID'];
					$imgURL = DynamicKawaiiImages::GetFeaturedImage($postID);
				}
				else
				{
					if(is_single() || is_page())
					{
						//Reset query to double sure that it gives ID
						wp_reset_query();
						$postID = get_the_ID();
						$imgURL = DynamicKawaiiImages::GetFeaturedImage($postID);
					}
				}
			}//else

			if ($imgURL != '' && $imgURL != false)
			{
				echo '<meta property="og:image" content="'. $imgURL .'" />'."\n";
			}
		}

		function do_wp_footer()
		{
			//добавляем рекламные ссылки и кастом-баннеры
			KawaiiAdvert::Footer();
		}

		public static function _HasResolutionPart($testLine)
		{
			$rDetect=new KawaiiResolutionDetector();
			$hasRes=$rDetect->HasResolutionInLine($testLine);
			if($hasRes===true)
				return true;

			if(strpos($testLine, 'wallpaper')!==false)
			    return true;

			return false;
		}

		// WordPress changes text (for example, 1080x1920 - char 'x'
		// will be converted. We don't need this, so use this filter.
		function do_no_texturize_tags($defaultTags)
		{
			$defaultTags['a']='a';
			$defaultTags['h2']='h2';
			$defaultTags['h1']='h1';

			return $defaultTags;
		}

		// WordPress добавляет к каждому посту набор "классов" (стилей)
		// некоторые могут быть НЕ нужны (так мы отрубим hentry класс
		// в случае если хотим убрать микроданные
		function do_post_class($classes, $class, $postID)
		{
			$classes = array_diff($classes, array('hentry','entry-title','entry-summary','entry-comments'));
			return $classes;
		}

	}//class

	if (class_exists("DynamicKawaiiImages")) 
	{
		$pluginDynamicKawaiiImages = new DynamicKawaiiImages();
	}

} //End Class DynamicKawaiiImages

//Actions and Filters	
if (isset($pluginDynamicKawaiiImages)) 
{
	//Actions   template_redirect  wp
	add_action('wp', array('DynamicKawaiiImages', 'do_template_redirect'));

	add_filter('the_content', array('DynamicKawaiiImages', 'do_content'),1);

	add_filter('arras_doctitle', array('DynamicKawaiiImages', 'do_get_title'));

	add_filter('no_texturize_tags', array('DynamicKawaiiImages', 'do_no_texturize_tags'));

	add_action('wp_head',array('DynamicKawaiiImages', 'do_wp_head'));

	add_filter('wp_footer', array('DynamicKawaiiImages', 'do_wp_footer'),1);

	add_filter('post_class', array('DynamicKawaiiImages', 'do_post_class'),1);
}



