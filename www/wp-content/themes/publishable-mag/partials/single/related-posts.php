<?php

// Create an array of current term ID's
$tax_terms = wp_get_post_terms( get_the_ID(), 'post_tag', array('fields' => 'all') );

if($tax_terms)
{
	$terms_ids = array();
	foreach( $tax_terms as $tax_term ) 
	{
		$terms_ids[] = $tax_term->term_id;
		//echo '<!-- '. $tax_term->name .'-->'.$nl;
	}

	$nl="\n";

	//change order to ASC or DESC by post ID
	$orderMode=($post->ID % 2 == 0) ? 'DESC' : 'ASC';

    $args=array('tag__in' => $terms_ids, 
			    'post__not_in' => array($post->ID), 
				'posts_per_page' => 50,
			    'ignore_sticky_posts' => 1, 	    
				'orderby' => 'date', 		
			    'order'   => $orderMode );


	$query = new wp_query( $args ); 
	if( $query->have_posts() ) 
	{
		$foundPosts=$query->posts;
		$postsLength=count($foundPosts);

		srand($post->ID);	//random seed on postID

		$maxCount=5;

		$selectedPostArr = array();

		for($i=0; $i<$maxCount; $i++)		
		{
			$rndIndex=rand(0, $postsLength-1);	
			$selectedPostArr[$rndIndex]=$rndIndex;
		}

		echo '<div class="related-posts"><div class="postauthor-top"><h3>'.esc_html('Related Posts', 'publishable-mag').'</h3></div>';

		$currInd=0;
		$j = 0; 

		foreach( $foundPosts as $pst )
		{

			if(array_key_exists($currInd, $selectedPostArr)==TRUE)
			{
				$excPart=(++$j % 3== 0) ? 'last' : '';

				$thumbid = get_post_thumbnail_id( $pst );

				if ( $thumbid != false ) 
				{
						echo '<article class="post excerpt '.$excPart.'">';

						$permLink=get_permalink($pst);
						$postTitle=$pst->post_title;

						echo '<a href="'.$permLink.'" title="'.$postTitle.'" >';

						echo '<div class="featured-thumbnail">';
						echo get_the_post_thumbnail($pst, 'publishable-mag-related', array('title' => ''));
						echo '</div>';

						echo '<header>';
						echo '<h4 class="title front-view-title">'.$postTitle.'</h4>';
						echo '</header>';

						echo '</a>';

						echo '</article>';
				} 				
			}//if arr

			$currInd++;
		}//foreach

		echo '</div>';

	}	
}

?>
<!-- End Related Posts -->
