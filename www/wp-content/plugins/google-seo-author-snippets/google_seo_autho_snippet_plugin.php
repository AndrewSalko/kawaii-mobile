<?php 
/*
*Plugin Name: Google SEO Author Snippet Plugin
*Plugin URI: http://www.smackcoders.com/google-seo-author-snippet-wordpress-plugin.html
*Description: A plugin that Manages the user's social profile details
*Version: 1.1.0
*Author: smackcoders.com
*Author URI: http://www.smackcoders.com
*
* Copyright (C) 2012 Smackcoders (www.smackcoders.com)
*

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*
* @link http://www.smackcoders.com/google-seo-author-snippet-wordpress-plugin.html

***********************************************************************************************
*/

define('SMACK_IMAGE_URL', get_bloginfo('wpurl').'/wp-content/plugins/google-seo-author-snippets/images/');

$FieldNames[0] = array(
		'g_image' => 'googleplus-icon-setone.png',
		'g_image_url' => SMACK_IMAGE_URL,
		'f_image' => 'facebook-icon-setone.png',
		'f_image_url' => SMACK_IMAGE_URL,
		't_image' => 'twitter-icon-setone.png',
		't_image_url' => SMACK_IMAGE_URL,
		'l_image' => 'linkedin-icon-setone.png',
		'l_image_url' => SMACK_IMAGE_URL,
		'location_image' => 'locator-icon-setone.png',
		'location_url' => SMACK_IMAGE_URL,
	);	
$FieldNames[1] = array(
		'g_image' => 'googleplus-icon-settwo.png',
		'g_image_url' => SMACK_IMAGE_URL,
		'f_image' => 'facebook-icon-settwo.png',
		'f_image_url' => SMACK_IMAGE_URL,
		't_image' => 'twitter-icon-settwo.png',
		't_image_url' => SMACK_IMAGE_URL,
		'l_image' => 'linkedin-icon-settwo.png',
		'l_image_url' => SMACK_IMAGE_URL,
		'location_image' => 'locator-icon-settwo.png',
		'location_url' => SMACK_IMAGE_URL,
	);	
$FieldNames[2] = array(
		'g_image' => 'googleplus-icon-setthree.png',
		'g_image_url' => SMACK_IMAGE_URL,
		'f_image' => 'facebook-icon-setthree.png',
		'f_image_url' => SMACK_IMAGE_URL,
		't_image' => 'twitter-icon-setthree.png',
		't_image_url' => SMACK_IMAGE_URL,
		'l_image' => 'linkedin-icon-setthree.png',
		'l_image_url' => SMACK_IMAGE_URL,
		'location_image' => 'locator-icon-setthree.png',
		'location_url' => SMACK_IMAGE_URL,
	);	
$FieldNames[3] = array(
		'g_image' => 'googleplus-icon-setfour.png',
		'g_image_url' => SMACK_IMAGE_URL,
		'f_image' => 'facebook-icon-setfour.png',
		'f_image_url' => SMACK_IMAGE_URL,
		't_image' => 'twitter-icon-setfour.png',
		't_image_url' => SMACK_IMAGE_URL,
		'l_image' => 'linkedin-icon-setfour.png',
		'l_image_url' => SMACK_IMAGE_URL,
		'location_image' => 'locator-icon-setfour.png',
		'location_url' => SMACK_IMAGE_URL,
	);	

register_deactivation_hook( __FILE__, 'deactivate_now' );
function deactivate_now()
{
	delete_option( 'smack_microdata_settings');
	delete_option( 'smack_microdata_imageset');
	$blogusers = get_users();
	foreach($blogusers as $users){
		delete_user_meta($users->ID, 'smack_social_links' );
		delete_user_meta($users->ID, 'smack_user_geoinfo' );
	}
}
class MyPlugin {
     static function install() {
            // do not generate any output here
     }
}
register_activation_hook( __FILE__, array('MyPlugin', 'install') );
update_option( 'smack_microdata_imageset' , $FieldNames );

require_once 'microdata_form.php';
function admin_menus() {  
	$contentUrl = WP_CONTENT_URL; 
	add_menu_page('Plugin settings', 'Google SEO Author Snippet', 'manage_options',  
	       'plugin_configuration', 'microdata_configuration_page', "$contentUrl/plugins/google-seo-author-snippets/images/icon.png");
}  
   add_action("admin_menu", "admin_menus"); 

wp_enqueue_script("microdata_configuration_page", "/wp-content/plugins/google-seo-author-snippets/js/smack-microdata.js", array("jquery"));
?>
