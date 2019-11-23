_DisableADSense

https://developer.wordpress.org/reference/functions/get_post_meta/
Since r21559 (v3.5), you can just call $post->foo to fetch the equivalent of get_post_meta( $post->ID, 'foo', true ).


			// if(get_post_meta( imageID, "_DisableADSense", true ) !== "on")
			// {
			// 	$content.="<h3>ADSense banner will be here</h3>";
			// }


