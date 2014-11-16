<?php
/*
Plugin Name: Add LightBox & Title
Plugin URI: http://www.linhost.org/add-lightbox-title/
Description: This plugin automatically add the rel="lightbox[POST-ID]" to images linked in a post and in a comment, and recovers the image title. POST-ID is unique per post so all images per post are grouped in one lightbox set. Doesn't add the files required for lightbox! It is inspired by [Add Lightbox](http://mdkart.fr/blog/plugin-add-lightbox-pour-wordpress/) of Mdkart.
Author: ppalli
Author URI: http://www.linhost.org/
Version: 1.5
1. Unzip the file add-lightbox-title.php or the folder /add-lightbox-title/
2. Upload it in /wp-content/plugins/ of your Wordpress installation
3. Activate the Plugin
4. And that's it!
*/
add_filter('the_content', 'addlightboxtitle_replace', 99); // Filter for Post
add_filter('the_excerpt', 'addlightboxtitle_replace', 99); // Filter for Excerpt
add_filter('get_comment_text', 'addlightboxtitle_replace', 99); // Filter for Comment

function addlightboxtitle_replace ($content) {
	global $post;
	// [0] <a xyz href="...(.bmp|.gif|.jpg|.jpeg|.png)" zyx>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz zyx>yx</a>
	$pattern[0]		= "/(<a)([^\>]*?) href=('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)>(.*?)<\/a>/i";
	$replacement[0]	= '$1 href=$3$4$5$6$2$7>$8</a>';
	// [1] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz zyx>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" rel="lightbox[POST-ID]" xyz zyx>yx</a>
	$pattern[1]		= "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)(>)(.*?)(<\/a>)/i";
	$replacement[1]	= '$1$2$3$4$5 rel="lightbox['.$post->ID.']"$6$7$8$9';
	// [2] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" rel="lightbox[POST-ID]" xyz rel="(lightbox|nolightbox)yxz" zyx>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz rel="(lightbox|nolightbox)yxz" zyx>yx</a>
	$pattern[2]		= "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\") rel=('|\")lightbox([^\>]*?)('|\")([^\>]*?) rel=('|\")(lightbox|nolightbox)([^\>]*?)('|\")([^\>]*?)(>)(.*?)(<\/a>)/i";
	$replacement[2]	= '$1$2$3$4$5$9 rel=$10$11$12$13$14$15$16$17';
	// [3] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz>yx title=yxz xy</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz title=yxz>yx title=yxz xy</a>
	$pattern[3]		= "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)(>)(.*?) title=('|\")(.*?)('|\")(.*?)(<\/a>)/i";
	$replacement[3]	= '$1$2$3$4$5$6 title=$9$10$11$7$8 title=$9$10$11$12$13';
	// [4] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz title=zxy xzy title=yxz>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz title=zxy xzy>yx</a>
	$pattern[4]		= "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?) title=([^\>]*?) title=([^\>]*?)(>)(.*?)(<\/a>)/i";
	$replacement[4]	= '$1$2$3$4$5$6 title=$7$9$10$11';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
	
}
?>
