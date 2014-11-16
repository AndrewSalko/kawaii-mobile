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

        	//����� � ����� �������� ���� ��� �����������:
			ob_end_clean();
			readfile($fileNameForSave);
			flush(); 			
	        exit();			
		}		

		// Creates fake attach file name from real post ID
		// Returns FALSE if failed
		// Out params:
		public static function CreateImageElement($imageID, $resolution, &$shortDescription)
		{
			//check resolution
			$attMeta=wp_get_attachment_metadata($imageID);
            if($attMeta===FALSE)
			{
				return;
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
				//���� �����, ������� ����� � �����������
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

			$nowTime = (string)time();
			$encryptor=new EncryptorKawaii();
			$secretCode=$encryptor->Encode($nowTime);
            			
			$imgLink=$postPermLink.'custom/'.$fileNameGood.'?newsize='.$resolution.'&amp;code='.$secretCode.'&amp;id='.$imageID;

			$linkNameCurrent=$resDetector->GetResolutionDescription($imgWidth, $imgHeight);

			//prepare ALT text for image. Just use fileName,replace '-' chars with spaces
			$fileNameForALT=str_replace('-', ' ', $shortFileName);

			$imgAlt=$fileNameForALT .' '. $linkNameCurrent;
			
			$imgNode='<a href="'.$imgLink.'"><img src="'. $imgLink .'" alt="'. $imgAlt .'" title="'. $imgAlt. '" width="'.$imgWidth.'" height="'.$imgHeight.'"></img></a>';

			$shortDescription=$imgAlt;

			return $imgNode;

		}//CreateImageElement


		function do_template_redirect()
		{	
			global $wp_query;

			/*					
		    if(is_404()===FALSE)
			{
				return;	
			}*/

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

				$shortDescr;
				$imgNode=DynamicKawaiiImages::CreateImageElement($attachID, $resolution, $shortDescr);
				if($imgNode===FALSE)
				{
					return;
				}

				$wp_query->is_404 = false;
				status_header('200');

				get_header();
                
                $itPost=get_post($attachID);
				$parentPost=$itPost;
				
				echo '<h1>'.get_the_title($itPost->post_parent). ' wallpaper</h1>';
				echo '<a href="' . get_permalink( $parentPost ) . '">'. get_the_title($parentPost) .'</a>';
				echo '<h2>Wallpaper size: ' . $resolution . '</h2>';

				$resDetector=new KawaiiResolutionDetector();
				$mobilePhones=$resDetector->GetResolutionMobilePhones($resolution);
				if($mobilePhones!=NULL)
				{ 					
					echo '<p>Background for mobile phones: ' . $mobilePhones. '</p>';
				}
	
				echo '<div id="container" class="single-attachment">';
				echo '	<div id="content" role="main">';
				echo $imgNode;
				echo '	</div><!-- #content -->';
				echo '</div><!-- #container -->';
				
				get_sidebar();
				get_footer();

				return;			
			}//if custom-image - special fake page
			

			//another check method for our special URL
			if (strpos($url,'/custom/') == false) 
			{
				return;
			}

			if(array_key_exists('newsize', $_GET)===FALSE ||
				array_key_exists('code', $_GET)===FALSE ||
				array_key_exists('id', $_GET)===FALSE
					)
			{
				return;
			}

			$code=$_GET['code'];
			$newsize=$_GET['newsize'];
			$imageID=$_GET['id'];			

			//--- ���� ������ �� ������ ������ �� ������������ �����������			
			$nowTime = time();
			$encryptor=new EncryptorKawaii();
			$timeCode=(int)$encryptor->Decode($code);
			$timeDiff=$nowTime-$timeCode;
			//������� � �������� �� ���������������� ���� 
			//��� �������� �������� � �������� �������. ��
			//������� ��� ������� ������ ����� "������" ����� 2 �����,
			//������� ��� ����� ��� - ���� ������ ����� 2 ����� ����
			//���������� ����� �� �������� ������.
			if($timeDiff>120*60)
			{
				//������� ��������� ����-���������, ���� ����
				//���������� ID �����������
				$testPermLink=post_permalink($imageID);
				if($testPermLink===FALSE)
				{
					return;
				}

				header("location:".$testPermLink);
				return;
			}
			//--- (end)���� ������ �� ������ ������ �� ������������ �����������
			

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

			//�������� �� �� ������ � ������� ��� �����, ��� ����� ��� ��������
			$urlParts=explode('/', $postPermLink);
			end($urlParts);//�������� � ����� �������
			prev($urlParts);
			$realPostName=prev($urlParts);//� ����� ����-��������� ����� (hagure-yuusha-no-estetica)
            
			//��� ����� ���-����� � ����:
			$imageCacheDir=$imageCacheDirBase . '/' . $realPostName;
			//check this directory, if need - create it			
			if(! (is_dir($imageCacheDir) || mkdir($imageCacheDir)) )
			{
				return;
			}			

			//��� ����� ��������� � ����� id_320x480 , ����� �� ����� �����
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

			//header("HTTP/1.0 200 OK");
			//header($contentType);

			//��� ��� ����� ��� ���������� � ���
			$fileNameForSave=$imageCacheDir.'/'.$filePrefix.'.'.$fileExt;

			//��������, ��������� �� ����������� ���� ������ ����������� ���
			//����� ���������������� ������� + ������
			if($resDetector->IsSimpleResize($attWidth, $attHeight, $destWidth, $destHeight))
			{
				$image->resize($destWidth, $destHeight);

				DynamicKawaiiImages::OutputFileToBrowser($image, $fileNameForSave);
				return;
			}

			//���� ����� ���� ����� �������� � �������� ���������
			$cutHeight=$resDetector->GetCutHeight($attWidth, $attHeight, $destWidth, $destHeight);
			if($cutHeight>0)
			{
				$image->CutByHeightAndResize($cutHeight, $destWidth, $destHeight);
				DynamicKawaiiImages::OutputFileToBrowser($image, $fileNameForSave);
				return;

			}

			//���� �� ����� ����, �� �� ������ ����� ���������, �����
			//��������� ���������
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
				//���� �����, ������� ����� � �����������
				for($q=0; $q<$namePartsCount-2; $q++)
				{
					if(strlen($shortFileName)>0)
					{
						$shortFileName.= '.';
					}

					$shortFileName.=$nameParts[$q];					
				}				
			}//if
			
			$fileExt=end($nameParts);//extension (jpg)

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

			//secret code generation	
			$nowTime = (string)time();
			$encryptor=new EncryptorKawaii();
			$secretCode=$encryptor->Encode($nowTime);
				
			$content.="<p>";	//style='float:right'
				
			$linkNameCurrent=$resDetector->GetResolutionDescription($attWidth, $attHeight);

			$mainLink='<a href="'. $imgURL.'" target="_blank">'.$linkNameCurrent.'</a>';

			$content .= '<br/>';
			$content .= $mainLink;            		
			$content .= '<br/>';

			foreach ($resArr as $resName => $resParams)
			{
				$linkName=$resName;
				if (array_key_exists('description', $resParams))
				{
					$linkName=$linkName . ' (' . $resParams['description']. ')';
				}

				//good file name. 
				$addLink='<a href="'.$postPermLink .'custom-image/'. $imageID .'/'.$resName. '" target="_blank">'.$linkName.'</a><br/>';
				$content .= $addLink;
			}
						
			$content.="</p>";
			return $content;
		}//do_content


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
					return;
				}

				//take last portion - this is resolution:
				$resolution=end($splittedValues);
				$attachID=prev($splittedValues);
                $itPost=get_post($attachID);
				$parentTitle=get_the_title($itPost);//->post_parent
				//split title with dots.
				$splValues=explode('.',$parentTitle);

				$cleanTitle=get_the_title($itPost->post_parent);
				if(count($splValues)>0)
				{
					$tmpTitle="";
				   	//the part of resolution (in form 320x480) should be removed
					foreach($splValues as $splItemKey => $splItemValue)
					{
						if(DynamicKawaiiImages::_HasResolutionPart($splItemValue)===false)
						{
							$tmpTitle .= $splItemValue;
                            $tmpTitle .= " ";
						}
					}
					
					$cleanTitle=$tmpTitle;
				}

				$rDetect=new KawaiiResolutionDetector();
				$uniqTitle=	$rDetect->GetUniqTitleOnAttachID($resolution, $attachID);
				return $cleanTitle. " " . $resolution. " " . $uniqTitle;
			}

			//do nothing,default
			return $elements;
		}//do_get_title


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

}



