<?php

// Get urls to posts by anime genres
class KawaiiGenres
{
	public $GenreTags = array(
	'action',
	'adventure',
	'alternate-history',

	'comedy',
	'comedy-drama',
	'black-comedy',	//!!!

	'crime-fiction',
	'cyberpunk',


	'detective',
	'drama',
	'dystopian',
	'ecchi',

	'educational',

	'fantasy',
	'dark-fantasy',
	'science-fantasy',
	'urban-fantasy',

	'girls-with-guns',

	'harem',
	'historical',
	'horror',

	'japanese-idol',


	'magical-girl',
	'magic',

	'martial-arts',

	'mecha',

	'military',
	'military-science-fiction',


	'mystery',

	'murder',
	'noir',

	'parody',
	'paranormal',
	'post-apocalyptic',
	'police',

	'professional-wrestling',

	'psychological',
	'psychological-thriller',
	'psychology',
	'social-psychology',


	'romance',
	'romantic-comedy',

	//'sci-fi',

	'science-fiction',	// !!!
	'sci-fi-noir',

	'school-story',
	'slice-of-life',
	'steampunk',
	'space-western',
	'sports',

	'spy',
	'suspense',

	'survival-action',	// !!!
	'survival',
	'survival-horror',	// !!!

	'supernatural',

	'thriller',
	'tragedy',

	'visual-novel',

	'war-drama'
	);


	public function GetGenres($siteUrl)
	{
		$resultText='';

		foreach ($this->GenreTags as $genreTagSlug)
		{
			$genreName=$genreTagSlug;

			$term = get_term_by('slug', $genreTagSlug, 'post_tag');

		
			if(!($term===false))
			{
				$genreName=$term->name;			
				$genreName .= ' ('.$term->count.')';
			}

			$linkBlock='<p><a href="'.$siteUrl.'/tag/'.$genreTagSlug.'/">'.$genreName.'</a></p>';


			$resultText .= $linkBlock;
		}

		return $resultText;
	}



}