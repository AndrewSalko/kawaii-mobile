<?php

// Class detects character names 
// from attach ID (imageID)
class KawaiiCharacters
{
	//Returns: char names from imageID
	//Out: $parentTitle - parent post title
	//Out: $charactersCount - how many characters was found
	public static function GetCharacters($imageID, &$parentTitle, &$charactersCount)
	{
		$charactersCount=0;
		$itPost=get_post($imageID);
		$itPostMainID=$itPost->post_parent;
		$parentTitle=get_the_title($itPostMainID);

		$imgTitle=$itPost->post_title;

		//получаем у поста его "теги" - там будут имена персонажей
		$imgAlt="";//подставить сюда имена персонажей
		$tagNames = get_the_tags($itPostMainID);

		//теги (части) которые нужно пропустить (не имена персонажей)
		$skipTags=array("wallpaper","iphone","nokia","android","1920","720");

		if(!empty($tagNames))
		{
			$foundCharCount=0;
			$foundCharacters=array();

			foreach($tagNames as $itName)
			{
				//проверим, есть ли такое имя (тег) в названии родит.поста
				if(strpos($imgTitle, $itName->name)===false)
					continue;

				if($parentTitle==$itName->name)
					continue;

				//проверим запрещенные теги
				$skipThis=false;
				foreach ($skipTags as $testTag)
				{
					if(stripos($itName->name,$testTag)!==false)
					{
						$skipThis=true;
						break;
					}
				}
				if($skipThis===true)
					continue;


				$foundCharacters[$foundCharCount]=$itName->name;
				$foundCharCount++;
			}//foreach

			//теперь сформируем красиво надпись. Если 1 - то его сразу и все,
			//если ровно 2 - то напишем "Имя1 and Имя2"
			//если больше - через запятую
			if($foundCharCount>0)
			{
				$charactersCount=$foundCharCount;

				if($foundCharCount==1)
				{
					$imgAlt=$foundCharacters[0];
				}
				else
				{
					if($foundCharCount==2)
					{
						$imgAlt=$foundCharacters[0].' and '.$foundCharacters[1];
					}
					else
					{
						for($i=0; $i<$foundCharCount; $i++)
						{
							if($imgAlt!="")
								$imgAlt.=", ";
							$imgAlt.=$foundCharacters[$i];
						}
					}//else
				}
			}//if

		}//!empty

		return $imgAlt;
	}//GetCharacters

}