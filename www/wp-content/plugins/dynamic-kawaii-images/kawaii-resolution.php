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

		'1080x1920' => array('width' =>1080, 'height'=>1920, 
							'description'=>'iPhone 6 Plus, Galaxy S4, HTC, Xperia',
							'mobilephones'=>'iPhone 6 Plus, Samsung Galaxy Note 3, HTC One, LG D802, Samsung Galaxy S4, Sony Xperia Z, Lenovo K900, Magic THL W300, Magic THL W9.'),

		'750x1334'  => array('width' =>750, 'height'=>1334, 
							'title'=>'iPhone 6',
							'description'=>'iPhone 6'),

		'720x1280' => array('width' =>720, 'height'=>1280, 
							'description'=>'Galaxy S3, HTC, Sony Xperia',
							'mobilephones'=>'Samsung Galaxy Note2 N7100, Sony LT28H Xperia ion, Samsung GT-i9300 Galaxy S3, HTC Windows Phone 8X, Sony LT26i Xperia S, HTC One X S720e, Huawei U9500-1 Ascend D1, Magic THL W3.'),

		'640x1136' => array('width' =>640, 'height'=>1136, 
							'title'=>'iPhone 5',
							'description'=>'iPhone 5, iPod touch 5'),

		'640x960' => array('width' =>640, 'height'=>960, 
							'title'=>'iPhone 4',
							'description'=>'iPhone 4, iPod touch 4'),

		'640x480' => array('width' =>640, 'height'=>480, 
							'title'=>'android',
							'description'=>'Android Wallpaper 640x480'),
                                                                         

		'540x960' => array('width' =>540, 'height'=>960,
							'description'=>'Acer Liquid, LG P765, HTC One S',
							'mobilephones'=>'Magic W710 Socrat, ZTE V970, Texet TM-4504, Acer Liquid Gallant Duo E350, Fly IQ443, Huawei U8836D-1 Ascend G500, Acer Liquid E1 Duo V360, Huawei U8950-1 Ascend Honor Pro G600, LG P765 Optimus L9, Sony LT22i Xperia P, HTC One S'
							),


		'480x854' => array('width' =>480, 'height'=>854,
							'description'=>'Fly IQ450, Sony Xperia Sola',
							'mobilephones'=>'Fly IQ450 Horizon, Gigabyte GSmart G1362, Sony ST26i Xperia J, Sony ST25i Xperia U, Sony MT27i Xperia Sola'
							),


		'480x800' => array('width' =>480, 'height'=>800,
							'description'=>'Nokia Lumia, Samsung Galaxy S II'							
							),

		'480x640' => array('width' =>480, 'height'=>640, 'description'=>'HTC Touch Diamond'),

		'360x640' => array('width' =>360, 'height'=>640, 
							'description'=>'Nokia 5800',
							'title'=>'Nokia',
							'mobilephones'=>'Nokia 808 PureView, Nokia 5800, Nokia C5, Nokia C6, Nokia C7, Nokia E7, Nokia X6, Nokia N8, Nokia N97, Nokia 5250, Nokia 5228, Nokia 5230.'
							),

		'360x480' => array('width' =>360, 'height'=>480, 'description'=>'BlackBerry'),

		
		'320x480' => array('width' =>320, 'height'=>480, 
							'description'=>'iPhone 3G, iPod touch 3',
							'title'=>'iPhone 3G',
							'mobilephones'=>'iPhone 3G, iPod, HTC Desire C, HTC Gratia, HTC Wildfire, HTC Cha-Cha,  HTC Salsa, Samsung S5830 Galaxy Ace, Samsung S5660 Galaxy Gio,  Sony Ericsson E15i Xperia X8,  LG GT540 Optimus, LG P500 Optimus One, LG C550 Optimus, LG Optimus L5, Fly E154, Fly IQ256, Fly IQ245, Gigabyte GSmart G1310, Samsung GT-S5380, Samsung GT-S6802 Galaxy Ace,Samsung GT-S7500 Galaxy Ace, Samsung GT-S5690 Galaxy Xcover, Magic THL A1, Magic W660, Huawei U8655-1 Ascend Y200,LG P698 Optimus, LG E510 Optimus, LG E612 Optimus L5, LG E615 Optimus L5,Sony ST21i Xperia, Sony Ericsson ST15i Xperia, Sony Ericsson WT19i,Sony ST23i Xperia, Sony ST27i Xperia, Acer Liquid E320, Seals TS3.'
							),


		'320x455' => array('width' =>320, 'height'=>455, 'description'=>'Samsung Galaxy Ace, Sony Xperia Arc'),
		'320x401' => array('width' =>320, 'height'=>401),
		'320x240' => array('width' =>320, 'height'=>240, 'description'=>'Nokia E5, Nokia C3'),

        '240x400' => array('width' =>240, 'height'=>400, 'description'=>'Sony Ericsson, Samsung, LG'),

		'240x320' => array('width' =>240, 'height'=>320, 'description'=>'Fly, Nokia Asha'),
		);

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
		//�������� �� ����������, ������� �� �������� ������ ��� ������
		//(������ ������ ��� �����, � ������ ������ ��� �����)
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

		//�������� �� ����������, ������� �� �������� ������ ��� ������
		//(������ ������ ��� �����, � ������ ������ ��� �����)
		foreach ($this->resolutions as $resName => $resParams)
		{
			$itWidth=$resParams['width'];
			$itHeight=$resParams['height'];
			if($this->IsResolutionAvailable($srcWidth,$srcHeight,$itWidth,$itHeight)==FALSE)
			{
				continue;
			}		
		
			$arrResult[$resName]=$resParams;

			//�������� ������� "�������������", ������� �������������? 
			//������� ��������������: ����� ������� ������ � �����.
			//������������: ���� ����� �� "���������"
			//if($koeff-$koeffDest<=0.01)
			//{
			//}			
		}//foreach
			
		return $arrResult;

	}//GetAvailableResolutions

	//
	// ����� �� �� ������� ������� ������, ���� ��������� ��������
	//
	public function IsSimpleResize($srcWidth, $srcHeight, $destWidth, $destHeight)
	{		
		//��������� ���������������� ����������� src-image:
		$koeff=$srcWidth/$srcHeight;
		
		//��������� ����������� ����������� ������� ����� ��������
		$koeffDest=$destWidth/$destHeight;
		
		if(abs($koeff-$koeffDest)<0.01)
		{
			return TRUE;
		}

		return FALSE;
	}//IsSimpleResize


	//
	// ���������, ������� �� "���������" ��� ����� ������ 
	// ��������� �� ������ (�������� �� ������, �������� ������)
	//
	// ������������ ��������: ������, ������� ����� �������� �����������,
	// ������� ��� ����� (������ ��������� �� �� ��������), � ������
	// ���� ��� ������ ������, �� ������ 0.
	public function GetCutHeight($srcWidth, $srcHeight, $destWidth, $destHeight)
	{
		$koeffDest=$destWidth/$destHeight;//320/240  =1.333
		$testHeight=(int)($srcWidth/$koeffDest);//640/1.333=480
		if ($testHeight<=$srcHeight)
		{
			//����� ������ �������� �� ������
			//�������� �� ������� ������ � ������ testHeight,
			//��������� ������ � ����� ������, �����.
			return $testHeight;
		}	
		return 0;
	}//GetCutHeight

}


