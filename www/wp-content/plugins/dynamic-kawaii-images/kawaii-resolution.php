<?php

// Class detects available image sizes which
// can be cut-resize from source image.
class KawaiiResolutionDetector
{
	public $resolutions = array(

		'2160x1920' => array('width' =>2160, 'height'=>1920, 
							'description'=>'Android Wallpaper 2160x1920',
							'title'=>'android',
							'mobilephones'=>'Samsung Galaxy Note 3, HTC One, LG D802, Samsung Galaxy S4, Sony Xperia Z, Lenovo K900, Magic THL W300, Magic THL W9.'),


		'1440x1280' => array('width' =>1440, 'height'=>1280, 											
							'description'=>'Android Wallpaper 1440x1280',
							'title'=>'android',
							'mobilephones'=>'Samsung Galaxy Note2 N7100, Sony LT28H Xperia ion, Samsung GT-i9300 Galaxy S3, Sony Xperia S, HTC One X S720e, Huawei U9500-1 Ascend D1, Magic THL W3.'),

		'960x800'=> array('width' =>960, 'height'=>800, 
							'title'=>'android',
							'description'=>'Android Wallpaper 960x800'),

		'2160x3840'=> array('width' =>2160, 'height'=>3840, 
							'title'=>'4K UHD',
							'description'=>'4K resolution'),
				
		'1440x2560'=> array('width' =>1440, 'height'=>2560, 
							'title'=>'QHD Quad HD',
							'description'=>'Quad HD resolution'),
		
		'1284x2778'=> array('width' =>1284, 'height'=>2778, 
							'title'=>'iPhone 12 Pro Max',
							'description'=>'iPhone 12 resolution'),

		
		'1125x2436'=> array('width' =>1125, 'height'=>2436, 
							'title'=>'iPhone X',
							'description'=>'iPhone X resolution'),

		'1080x2340'=> array('width' =>1080, 'height'=>2340, 
							'title'=>'iPhone 12 Mini, Xiaomi Redmi 9',
							'description'=>'iPhone 12 Mini resolution, Xiaomi Redmi 9, Xiaomi Redmi Note'),


		'1080x1920' => array('width' =>1080, 'height'=>1920, 
							'description'=>'iPhone 7, Samsung Galaxy, Xiaomi',
							'mobilephones'=>'iPhone 7, Xiaomi Mi Note 2, Xiaomi Redmi Note 4, Samsung Galaxy Note 3'),

		'828x1792'  => array('width' =>828, 'height'=>1792, 
							'title'=>'iPhone 11',
							'description'=>'iPhone 11 resolution'),


		'750x1334'  => array('width' =>750, 'height'=>1334, 
							'title'=>'iPhone 7',
							'description'=>'iPhone 7, iPhone 6, iPhone SE'),

		'720x1280' => array('width' =>720, 'height'=>1280, 
							'description'=>'Galaxy S3, HTC, Sony Xperia',
							'mobilephones'=>'Samsung Galaxy Note2 N7100, Sony LT28H Xperia ion, Samsung GT-i9300 Galaxy S3, HTC Windows Phone 8X, Sony LT26i Xperia S, HTC One X S720e, Huawei U9500-1 Ascend D1, Magic THL W3.'),

		'640x1136' => array('width' =>640, 'height'=>1136, 
							'title'=>'iPhone 5',
							'description'=>'iPhone 5, iPod touch 5'),

		'640x960' => array('width' =>640, 'height'=>960, 
							'title'=>'iPhone 4',
							'description'=>'iPhone 4, iPod touch 4'),

		);


	public function  GetPhoneTitle($resolutionName)
	{
		$prefixPhone="";

		if(array_key_exists($resolutionName, $this->resolutions)==TRUE)
		{
			$resolItem=$this->resolutions[$resolutionName];
			//now check the title
			if(array_key_exists('title', $resolItem)==TRUE)
			{
				$prefixPhone=$resolItem['title'];
			}
		}

		return $prefixPhone;
	}

	// Resolution (like 320x480) and attach ID for permanent
	// but uniq title
	public function GetUniqTitleOnAttachID($resolutionName, $attID)
	{
		$prefixPhone="";

		if(array_key_exists($resolutionName, $this->resolutions)==TRUE)
		{
			$resolItem=$this->resolutions[$resolutionName];
			//now check the title
			if(array_key_exists('title', $resolItem)==TRUE)
			{
				$prefixPhone=$resolItem['title'];
			}
		}

		//on attach ID choose one of typical titles
		$strID=strval($attID);
		$lastChar=substr($strID, -1);
		$lastID=intval($lastChar);

		$titles = array(0 => " mobile anime wallpaper",
						1 => " anime phone wallpaper",
						2 => " anime lock screen wallpaper",
						3 => " anime lock screen image",
						4 => " anime lock screen background",
						5 => " smart phone wallpaper",
						6 => " anime smartphone wallpaper",
						7 => " otaku smartphone wallpaper",
						8 => " wallpaper for mobile phones",
						9 => " anime background");
			
		return $prefixPhone . $titles[$lastID];
	}


	public function HasResolutionInLine($testline)
	{
		foreach ($this->resolutions as $resName => $resParams)
		{
			$w=strval($resParams['width']);
			$h=strval($resParams['height']);

			if(strpos($testline,$w)!==false && strpos($testline,$h)!==false)
			{
				return true;
			}
		}
		return false;
	}

	// Get description - mobile phones models for
	// this resolution
	public function GetResolutionMobilePhones($resolutionName)
	{
		if(array_key_exists($resolutionName, $this->resolutions)==FALSE)
		{
			return NULL;
		}		
		
		$resolItem=$this->resolutions[$resolutionName];
		
		//check if we have a mobile phones description:		
		if(array_key_exists('mobilephones', $resolItem)==TRUE)
		{
			return $resolItem['mobilephones'];
		}	

		if(array_key_exists('description', $resolItem)==TRUE)
		{
			return $resolItem['description'];
		}	
	    
		return NULL;
		
	}//GetResolutionMobilePhones

	public function GetResolutionDescription($srcWidth, $srcHeight)
	{
		$result=$srcWidth . 'x' . $srcHeight;
		//Отбираем те разрешения, которые по размерам МЕНЬШЕ чем данное
		//(ширина меньше или равна, и высота меньше или равна)
		foreach ($this->resolutions as $resName => $resParams)
		{
			$itWidth=$resParams['width'];
			$itHeight=$resParams['height'];

			if($itWidth==$srcWidth && $itHeight==$srcHeight)
			{
				if (array_key_exists('description', $resParams))
				{
					$result.=' (' . $resParams['description']. ')';
					break;
				}
			}
		}//foreach
		return	$result;
	}

	//
	// Checks if given source image can be resize-cutted to destination image.
	//
	public function IsResolutionAvailable($srcWidth, $srcHeight, $destWidth, $destHeight)
	{		
		if(($srcWidth<$destWidth || $srcHeight<$destHeight) ||
			($srcWidth==$destWidth && $srcHeight==$destHeight))
		{
			return FALSE;
		}	
		
		return TRUE;
	}

	//
	// $srcWidth, $srcHeight - source image
	// $destWidth, $destHeight - destination image , $destWidth, $destHeight
	public function GetAvailableResolutions($srcWidth, $srcHeight)
	{
		$arrResult=array();

		//Отбираем те разрешения, которые по размерам МЕНЬШЕ чем данное
		//(ширина меньше или равна, и высота меньше или равна)
		foreach ($this->resolutions as $resName => $resParams)
		{
			$itWidth=$resParams['width'];
			$itHeight=$resParams['height'];
			if($this->IsResolutionAvailable($srcWidth,$srcHeight,$itWidth,$itHeight)==FALSE)
			{
				continue;
			}		

			//проверим "андроид-случай": когда ширина больше высоты, обычно
			//это характерно для андроид-обоев (параллакс).
			//Нормально получить красивые обои в таком случае можно только из
			//аналогичных изображений, т.е.андроид-обои будут ресайзится только в такие же
			//но не в "портретные"
			if($srcWidth>$srcHeight)
			{
				if($itWidth<$itHeight)
					continue;
			}
			else
			{
				//И обратно: для портретных обоев нельзя делать преобразование
				//в андроид-обои - скорее всего выйдет не очень
				if($itWidth>$itHeight)
					continue;
			}

			$arrResult[$resName]=$resParams;

		}//foreach
			
		return $arrResult;

	}//GetAvailableResolutions

	//
	// Можем ли мы сделать простой ресайз, если пропорции подходят
	//
	public function IsSimpleResize($srcWidth, $srcHeight, $destWidth, $destHeight)
	{		
		//вычисляем пропорциональный коэффициент src-image:
		$koeff=$srcWidth/$srcHeight;
		
		//вычисляем коэффициент изображения которое НУЖНО получить
		$koeffDest=$destWidth/$destHeight;
		
		if(abs($koeff-$koeffDest)<0.01)
		{
			return TRUE;
		}

		return FALSE;
	}//IsSimpleResize


	//
	// Проверяем, влезает ли "пропорция" так чтобы просто 
	// уменьшить по высоте (обрезать по высоте, сохранив ширину)
	//
	// Возвращаемое значение: ВЫСОТА, которую нужно оставить изображению,
	// обрезав его снизу (ширину оставляем ту же исходную), и ресайз
	// Если так делать НЕЛЬЗЯ, то вернет 0.
	public function GetCutHeight($srcWidth, $srcHeight, $destWidth, $destHeight)
	{
		$koeffDest=$destWidth/$destHeight;//320/240  =1.333
		$testHeight=(int)($srcWidth/$koeffDest);//640/1.333=480
		if ($testHeight<=$srcHeight)
		{
			//можно просто вырезать по высоте
			//вырезать по текущей ширине и высоте testHeight,
			//выполнить РЕСАЙЗ и будет готово, КОНЕЦ.
			return $testHeight;
		}	
		return 0;
	}//GetCutHeight

}


