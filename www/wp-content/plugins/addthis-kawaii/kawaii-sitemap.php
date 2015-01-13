<?php
class KawaiiSiteMap
{


	public  static  function _GetXMLHeader()
	{
		$nl="\n";
		$xml  = '<?xml version="1.0" encoding="UTF-8"?>'.$nl;
		$xml .= '<!-- Created by Andrew Salko, for kawaii-mobile.com -->'.$nl;
		$xml .= '<!-- Generated-on="'.date("F j, Y, g:i a").'" -->'.$nl;
		$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">'.$nl;
		return $xml;
	}


	// Записать карту сайта в виде файла
	static function  _SaveXMLSiteMap($srvRoot, $itFileName, $xmlBody)
	{
		$image_sitemap_url = $srvRoot .'/'. $itFileName;
		file_put_contents($image_sitemap_url, $xmlBody);
	}

	public static function Generate($serverRootFolder)
	{
		$nl="\n";
		global $wpdb;

		$queryPosts="SELECT id,post_title,guid,post_type,post_date FROM $wpdb->posts
		WHERE post_type = 'post' AND post_status='publish'
		ORDER BY post_date desc";

		$posts = $wpdb->get_results($queryPosts);
		if (empty($posts))
		{
			return false;
		}

		$xml="";

		$curYear = 1979;

		foreach ($posts as $itpost)
		{
			$postID=$itpost->id;

			$postYear=mysql2date("Y", $itpost->post_date);

			if($postYear!=$curYear)
			{
				if($curYear!=1979)
				{
					//сформировать имя, сохранить файл
					$fileNameXML="images-sitemap-".$curYear.".xml";

					$fullXml=$headerXML=KawaiiSiteMap::_GetXMLHeader() . $xml;
					$fullXml.='</urlset>';
					KawaiiSiteMap::_SaveXMLSiteMap($serverRootFolder,$fileNameXML, $fullXml);

					$xml="";
				}

				$curYear=$postYear;
			}

			//найдем все изображения поста, если они в нем были
			$imageAttaches = $wpdb->get_results("SELECT post_title,post_excerpt,post_parent,guid FROM $wpdb->posts
				 			WHERE post_type = 'attachment'
							AND post_mime_type like 'image%'
							AND post_parent =".$postID."
							ORDER BY post_date desc");

			if (empty($imageAttaches))
			{
				continue;
			}

			$postURL=get_permalink($itpost->id);

			$xml .= "\t"."<url>".$nl;
			$xml .= "\t\t"."<loc>".htmlspecialchars($postURL)."</loc>".$nl;

			foreach($imageAttaches as $itAttach)
			{
				$xml .= "\t\t"."<image:image>".$nl;
				$xml .= "\t\t\t"."<image:loc>".htmlspecialchars($itAttach->guid)."</image:loc>".$nl;

				$postCapt=htmlspecialchars($itAttach->post_excerpt);
				if(strlen($postCapt)>0)
				{
					$xml .= "\t\t\t"."<image:caption>".$postCapt."</image:caption>".$nl;
				}

				$xml .= "\t\t\t"."<image:title>".htmlspecialchars($itAttach->post_title)."</image:title>".$nl;
				$xml .= "\t\t"."</image:image>".$nl;
			}

			$xml .= "\t"."</url>".$nl;

		}//foreach

		return true;
	}//function

}//class