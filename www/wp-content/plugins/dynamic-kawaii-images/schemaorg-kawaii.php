<?php
// Schema.org structured data "Article"
// 

class SchemaOrgKawaii
{

	public static function GetStructuredDataScriptBlock($url, $tc_title, $tc_description, $mainImageURL, $authorName, $datePublished, $dateUpdated)
	{			
		$res="
<script type=\"application/ld+json\">
{
  \"@context\": \"https://schema.org\",
  \"@type\": \"Article\",
  \"mainEntityOfPage\": 
	{
	\"@type\": \"WebPage\",
    \"@id\": \"".$url."\"
    },

	\"headline\": \"".$tc_title."\",

	\"image\": 
   [
    \"".$mainImageURL."\"
   ],
   \"datePublished\": \"".$datePublished."\",
   \"dateModified\": \"".$dateUpdated."\",
   \"author\": 
  {
    \"@type\": \"Person\",
    \"name\": \"".$authorName."\"
  },

  \"publisher\": 
  {
    \"@type\": \"Organization\",
    \"name\": \"Kawaii Mobile\",
	\"logo\": 
	{
		\"@type\": \"ImageObject\",
		\"url\": \"https://kawaii-mobile.com/mao-512.png\"
    }
  },
  \"description\": \"".$tc_description."\"
}
</script>";

		return $res;
	}//GetStructuredDataScriptBlock

}

