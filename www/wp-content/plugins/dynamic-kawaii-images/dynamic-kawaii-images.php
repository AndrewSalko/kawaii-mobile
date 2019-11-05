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
	include ('schemaorg-kawaii.php');

	class DynamicKawaiiImages
	{

		function DynamicKawaiiImages() 
		{ //constructor
			
		}

		public static function SendBaseImageHeaders($fileName)
		{
			header("HTTP/1.0 200 OK");
			$timeOffset = 60 * 60 * 24 * 30 * 12;//12 months
			header("Expires: " . gmdate("D, d M Y H:i:s", time() + $timeOffset) . " GMT");
			header("Cache-Control: public, max-age=".$timeOffset.", must-revalidate"); 
			

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
		public static function CreateImageElement($imageID, $resolution, &$characters, &$firstCharacterName, &$firstCharacterTagURL)
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

			$availResolutions=$resDetector->GetAvailableResolutions($attWidth, $attHeight);
			if(count($availResolutions)==0)
			{
				return FALSE;	//простой случай - когда изображение слишком маленькое чтобы его обрезать
			}

			//более сложный случай когда оно большое, но нельзя "резать" его в то что нас попросили			
			if (array_key_exists($resolution, $availResolutions)==FALSE) 
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
			$imgAlt=KawaiiCharacters::GetCharacters($imageID, $mainTitle, $charactersCount,$firstCharacterName,$firstCharacterTagURL);//подставить сюда имена персонажей

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
					$wp_query->set_404();
					status_header(404);
					include(get_query_template('404'));
					return;
				}

				//take last portion - this is resolution:
				$resolution=end($splittedValues);
				$attachID=prev($splittedValues);

				//check if we have such attachID in our base:
				$testPermLink=post_permalink($attachID);
				if($testPermLink===FALSE)
				{
					$wp_query->set_404();
					status_header(404);
					include(get_query_template('404'));
					return;
				}

				$characters="";
				$firstCharacterName="";
				$firstCharacterTagURL="";
				$imgNode=DynamicKawaiiImages::CreateImageElement($attachID, $resolution, $characters,$firstCharacterName,$firstCharacterTagURL);
				if($imgNode===FALSE)
				{
					$wp_query->set_404();
					status_header(404);	
					include(get_query_template('404'));
					return;
				}

				$kawCont=new KawaiiContent();
				$descrText="";//описательный текст для страницы
				$attTitle=$kawCont->GetAttachTitleAndDescription($resolution, $attachID, $descrText);

				$wp_query->is_404 = false;
				status_header('200');

				get_header();

                $attPost=get_post($attachID);
				
				//это тайтл не аттача а основного поста
				$mainPost=$attPost->post_parent;
				$titleOfMainPost=get_the_title($mainPost);
				$urlOfMainPost=get_permalink($mainPost);

				echo '<div id="page" class="single">';
				echo '<div class="content">';
				//здесь нужно вывести breadcrumbs (сразу на главный пост)
				echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">'; 

					echo '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . $urlOfMainPost . '">'. $titleOfMainPost .'</a></span>';
					echo '<span><i class="publishable-icon icon-angle-double-right"></i></span>';

				//здесь нужно вывести персонажа (первого с url как тег)
				if($firstCharacterName!="")
				{
					echo '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . $firstCharacterTagURL . '">'. $firstCharacterName .'</a></span>';
				}
				else
				{
					//если нет персонажей - выводим разрешение
					echo '<span>'. $resolution. '</span>';
				}

				echo '</div>'; /* breadcrumb */

				echo '<article class="article">';


				echo '<div class="post attachment type-attachment status-inherit">';
				echo '<div class="single_post">';

				//главный заголовок - если есть персонажи - берем их и туда разрешение, если их нет - имя главного поста и разрешение
				$h1ForPage=$titleOfMainPost;
				if($characters!="")
				{
					$h1ForPage=$characters;
				}

				$h1ForPage=$h1ForPage.' wallpaper '.$resolution;

				echo '<h1 class="entry-title">'.$h1ForPage;
				echo '</h1>';

				$resDetector=new KawaiiResolutionDetector();
				$mobilePhones=$resDetector->GetResolutionMobilePhones($resolution);
				if($mobilePhones!=NULL)
				{
					//описательный текст: персонажи, и прочее
					//Проверим если там есть полное имя поста - заменим его на ссылку
					$titleMainIndexStart=stripos($descrText, $titleOfMainPost, 0);
					if($titleMainIndexStart!==FALSE)
					{
						$refToMain='<a href="'.$urlOfMainPost.'">'.$titleOfMainPost.'</a>';
						//заменить на урл
						$descrText=str_replace($titleOfMainPost, $refToMain, $descrText);
					}

					echo '<p>'. $descrText. ' ';
					//добавить имя персонажей перед словом Wallpaper
					echo 'This image is best suited to : ' . $mobilePhones. '</p>';
				}

				//Banner-adaptive (for custom attach) - только для кастом-аттача
				//вещь весьма результативная, 2018.12.02 поменял место проверим как оно будет
				//include( plugin_dir_path( __FILE__ ) . 'kawaii-adsense.php');

				echo $imgNode;

                echo '</div>';    //single_post
				echo '</div>';    //attachment
	
				echo '</article>';

				get_sidebar();

				echo '</div>';// div content
				echo '</div>';// div page single

				
				get_footer();


				return;
			}//if custom-image - special fake page
			

			//another check method for our special URL - for images
			if (strpos($url,'/custom/') == false) 
			{
				return;
			}

			if(array_key_exists('newsize', $_GET)===FALSE || array_key_exists('id', $_GET)===FALSE)
			{
				return;
			}

			$refURL = $_SERVER['HTTP_REFERER'];
			if (!empty($refURL))
			{
				//проверим если это хотлинкер 
				if(strpos($refURL,'.blogspot.com')!==false || strpos($refURL,'anime-spin.net')!==false)
				{
					wp_redirect('http://i.imgur.com/KnWGUkI.jpg', 301);
					exit;
				}
			}

			$newsize=$_GET['newsize'];
			$imageID=$_GET['id'];
		
			//нужно проверить поддерживается ли это разрешение (ресайз) если нет вернуть 404

			//post perma link looks like:
			//http://kawaii-mobile.org/2012/11/hagure-yuusha-no-estetica/aesthetica-of-a-rogue-hero-hagure-yuusha-no-estetica-miu-myuu-ousawa-haruka-nanase-320x480/
			$postPermLink=post_permalink($imageID);
			if($postPermLink===FALSE)
			{
				return;
			}

			//определим реальный размер изображения
			$attMeta=wp_get_attachment_metadata($imageID);
            if($attMeta===FALSE)
			{
				return;
			}

			$attWidth=(int)$attMeta['width'];
			$attHeight=(int)$attMeta['height'];

			//разбираем новый размер, который запросили
			$destWidth=0;
			$destHeight=0;

			$sizeParts=explode('x', $newsize);
			$destWidth=(int)$sizeParts[0];
			$destHeight=(int)$sizeParts[1];
                        
			//check parameters (for bad users)
			$resDetector=new KawaiiResolutionDetector();
			if($resDetector->IsResolutionAvailable($attWidth, $attHeight, $destWidth, $destHeight)==FALSE)
			{
				//если разрешение не поддерживается - выброс 404 и все
				$wp_query->set_404();
				status_header(404);	
				include(get_query_template('404'));
				return;
			}

			$imageCacheDirBase=WP_CONTENT_DIR . '/imagescache';
			//check this directory, if need - create it
			if(! (is_dir($imageCacheDirBase) || mkdir($imageCacheDirBase)) )
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
           
			$attFileName=$attMeta['file'];
			$fileExt=pathinfo($attFileName, PATHINFO_EXTENSION);

			$contentType=DynamicKawaiiImages::GetContentType($attFileName);

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
			if(count($resArr)==0)
			{
				return $content;	//для данного разрешения нет вариантов более маленьких чем оно, обычное содержание на выходе	
			}

			$resName=sprintf("%sx%s", $attWidth, $attHeight);
			$uniqTitle=$resDetector->GetUniqTitleOnAttachID($resName,$imageID);

			//получаем персонажей
			$mainPostTitle="";
			$charactersCount=0;
			$firstCharacterName="";
			$firstCharacterTagURL="";
			$charactersNames=KawaiiCharacters::GetCharacters($imageID, $mainPostTitle, $charactersCount,$firstCharacterName,$firstCharacterTagURL);

			$kawCont=new KawaiiContent();
			$descrText=$kawCont->GetAttachAdditionalDescription($imageID);//доп.текст, случайный для лучшей индексации
			$addContent=$mainPostTitle ." ". $descrText . ".";

			$descriptiveContent="";
			if($charactersNames=="")
			{
				$descriptiveContent=$mainPostTitle ." wallpaper";
			}
			else
			{
				$descriptiveContent=$charactersNames ." ". $uniqTitle;
			}

			$content.="<p>".$descriptiveContent."</p>";
			$content.="<p>";
				
			$linkNameCurrent=$resDetector->GetResolutionDescription($attWidth, $attHeight);

			//AD part
			$content = DynamicKawaiiImages::_AdSense($content);


			$content .= '<select id="screenResolutionSelectorID" style="width:100%;max-width:90%;" onchange="location = this.options[this.selectedIndex].value;">';
    		$content .= '<option disabled selected>Select wallpaper size</option>';

			//добавим основную ссылку тоже, для общности
			$content .= '<option data-id="'.$resName.'" value="'.$imgURL.'">'.$linkNameCurrent.'</option>';

			foreach ($resArr as $resName => $resParams)
			{
				$linkName=$resName;
				if (array_key_exists('description', $resParams))
				{
					$linkName=$linkName . ' (' . $resParams['description']. ')';
				}

				$linkURL=$postPermLink .'custom-image/'. $imageID .'/'.$resName .'/';
				$content .= '<option data-id="'.$resName.'" value="'.$linkURL.'">'.$linkName.'</option>';
			}

			$content .= '</select>';
			$content.="</p>";
			return $content;
		}//do_content

		static function _AdSense($content)
		{
			//NOT working because no wptouch_ 
/*
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

			if($mobileMode)
			{
				$content.='<!-- Banner-adaptive (for custom attach) -->';
				$content.='<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2908292943805064"';
				$content.=' data-ad-slot="2563835433"';
				$content.=' data-ad-format="auto"></ins>';
				$content.='<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
			}
*/
			return $content;
		}

		function do_get_title($title)
		{
			$url = $_SERVER['REQUEST_URI'];					
			if (strpos($url,'/custom-image/') == true) 
			{					
				$kawCont=new KawaiiContent();
				$attTitle="";
				$attMetaDescr="";
				$attachID="";

				if($kawCont->GetCustomAttachMetas($url,$attTitle,$attMetaDescr,$attachID)!==true)
				{
					return $title;	//ошибка, генерация не удалась
				}

				return $attTitle;
			}

			//do nothing,default
			return $title;
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

		// Отрезает до первого перевода каретки,т.к.обычно
		// все что далее нам не интересно (в первой строке будет норм.описание)
		// а ниже будет уже оглавление разрешений и прочее
		static function GetTwitterDescription($rawDescription)
		{
			$splittedValues=explode(PHP_EOL, $rawDescription);

			$descr=$splittedValues[0];

			$descr=str_replace("<p>", "", $descr);
			$descr=str_replace("</p>", "", $descr);
			$descr=str_replace("</br>", "", $descr);
			$descr=str_replace("<br />", "", $descr);
			

			return $descr;
		}

		static function EndsWith($haystack, $needle)
		{
			$length = strlen($needle);
		
			return $length === 0 || 
			(substr($haystack, -$length) === $needle);
		}

		function do_wp_head()
		{
			//блокируем пинтерест, так как он находится потом поиском google-images
			//нам это не нужно (потеря траффика)
			echo "\n".'<meta name="pinterest" content="nopin" />'. "\n";

			echo '<link rel="manifest" href="/manifest.json">';
			echo '<link rel="apple-touch-icon" href="/mao-192.png">';
			echo '<link rel="apple-touch-startup-image" href="/mao-192.png">';
			echo '<meta name="theme-color" content="#212121">';

			global $post;
			$imgURL='';//картинка для og:image

			$tc_title = get_the_title();//тайтл для твиттер-кард
			$tc_description ='';//описание для твиттер-кард

			//мета-описание будет применено на обычной странице аттача и на кастом-изображении
			$metaDescription=$tc_title;
			$needAddMetaDescr=false;
			
			$url = $_SERVER['REQUEST_URI'];
			if (strpos($url,'/custom-image/') == true) 
			{
				if(is_404())
				{
					return;
				}

				$kawCont=new KawaiiContent();
				$attTitle="";
				$attMetaDescr="";
				$attachID="";

				if($kawCont->GetCustomAttachMetas($url,$attTitle,$attMetaDescr,$attachID)!==true)
				{
					return;
				}

				//check if we have such attachID in our base:
				$testPermLink=post_permalink($attachID);
				if($testPermLink===FALSE)
				{
					return;
				}

				//need validate full url for this page
				$fullCanonicalURL=get_site_url().$url;
				//url must end with '/' slash
				$fullCanonicalURL=trim($fullCanonicalURL,'\\');
				if(!DynamicKawaiiImages::EndsWith($fullCanonicalURL,'/'))
				{
					$fullCanonicalURL.='/';
				}

				echo "\n".'<link rel="canonical" href="'.$fullCanonicalURL.'"/>'."\n";

				//у кастом-изображения нет явного условия что это "аттач"
				$needAddMetaDescr=true;
				$metaDescription=$attMetaDescr;
			}

			if( is_attachment())
			{
				$needAddMetaDescr=true;
				//страница файла-изображения. Картинка для него - он сам
				$imageID=$post->ID;
				$imgURL=wp_get_attachment_url($imageID);

				$kawCont=new KawaiiContent();

				//спец.для аттача более "надежный" метод описания для твиттер-карточки
				//в моб.режиме там была беда с get_the_excerpt()
				$tc_description = $tc_title . ' '. $kawCont->GetAttachAdditionalDescription($imageID);
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
				echo '<meta property="twitter:image" content="'. $imgURL .'" />'."\n";

				echo '<meta name="twitter:card" content="summary_large_image" />'."\n";
				echo '<meta name="twitter:site" content="@KawaiiMobile" />'."\n";
				echo '<meta name="twitter:creator" content="@KawaiiMobile" />'."\n";
                				

				if($tc_description=='')
				{
			    	$tc_description = get_the_excerpt();
				}

				$tc_description=DynamicKawaiiImages::GetTwitterDescription($tc_description);

				echo '<meta name="twitter:description" content="'. $tc_description .'" />'."\n";
				echo '<meta name="twitter:title" content="'. $tc_title .'" />'."\n";

				//подключим схема-орг разметку
				$postURL=wp_get_canonical_url();

				$postAuthorName=get_the_author_meta("display_name");

				$datePublishedStr=get_the_date('c');
				$dateUpdatedStr=get_the_modified_time('c');

				$scriptArticle=SchemaOrgKawaii::GetStructuredDataScriptBlock($postURL, $tc_title, $tc_description, $imgURL, $postAuthorName, $datePublishedStr, $dateUpdatedStr);
				echo $scriptArticle;

			}

			if($needAddMetaDescr===true)
			{
				echo '<meta name="description" content="'.$metaDescription.'" />'."\n";
			}
		}

		function do_wp_footer()
		{
			//добавляем рекламные ссылки и кастом-баннеры
			KawaiiAdvert::Footer();
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

		function do_exclude_widget_categories($args)
		{
			//1672	//2019 
			//1673	//2018 
			//1674	//2017 
			//1675	//2016 
			//1676	//2015 
			//1677	//2014 
			//1678	//2013 
			//1679	//2012 
			//1680	//2011 
			//1681	//2010 
			//1682	//2009 
			//1683	//2008 
			//1684	//2007 
			//1685	//2006
			//1686	//2005
			//1687	//2004
			//1688	//2003
			//1689	//2002
			//1690	//2001 
			//1691	//2000 
			//1692	//anime1995
			//1693	//1998
			//1694	//1999 

		    $exclude = "1672,1673,1674,1675,1676,1677,1678,1679,1680,1681,1682,1683,1684,1685,1686,1687,1688,1689,1690,1691,1692,1693,1694";
		    $args["exclude"] = $exclude;
	    	return $args;
		}

		// WordPress добавляет к каждому посту набор "классов" (стилей)
		// некоторые могут быть НЕ нужны (так мы отрубим hentry класс
		// в случае если хотим убрать микроданные
		/*
		function do_post_class($kawclasses, $kawclass, $postID)
		{
			$arrTest=array("hentry","entry-title","entry-summary","entry-comments");
			$resclasses = array_diff($kawclasses, $arrTest);
			return $resclasses;
		}*/

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

	add_filter('pre_get_document_title', array('DynamicKawaiiImages', 'do_get_title'));

	add_filter('no_texturize_tags', array('DynamicKawaiiImages', 'do_no_texturize_tags'));

	add_action('wp_head',array('DynamicKawaiiImages', 'do_wp_head'), 70);

	add_filter('wp_footer', array('DynamicKawaiiImages', 'do_wp_footer'),1);

	add_filter('widget_categories_args', array('DynamicKawaiiImages', 'do_exclude_widget_categories'),1);

	//add_filter('post_class', array('DynamicKawaiiImages', 'do_post_class'),1);

}



