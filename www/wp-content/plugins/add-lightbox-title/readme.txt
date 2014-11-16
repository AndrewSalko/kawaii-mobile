=== Add LightBox & Title ===
Contributors: ppalli
Donate link: http://www.linhost.org/support-us/
Tags: lightbox, automatic, images, shadowbox, javascripts
Requires at least: 2.7.0
Tested up to: 3.1
Stable tag: 1.5

This plugin for WordPress automatically add the rel="lightbox[ID-OF-THE-POST]" and recovers the image title.

== Description ==

This plugin automatically add the rel="lightbox[POST-ID]" to images linked in a post and in a comment, and recovers the image title.
POST-ID is unique per post so all images per post are grouped in one LightBox set.
Doesn't add the files required for LightBox, it's add the "rel lightbox" tag.
You have to insert the required files yourself in your theme, you can use [Lightbox 2](http://www.huddletogether.com/projects/lightbox2/), [Shadowbox.js](http://www.shadowbox-js.com/) or an other script, or use a plugin like [Shadowbox JS](http://wordpress.org/extend/plugins/shadowbox-js/).

== Installation ==

1. Unzip the folder /add-lightbox-title/
2. Upload it in /wp-content/plugins/ of your Wordpress installation
3. Activate the Plugin
4. And that's it!

== Frequently Asked Questions ==

= How disable the automatic addition for an image? =

You must add rel="nolighbox" to the image link.

= Which script is better to use? =

Can work with any script that uses the tag rel="lightbox[xy]", we recommend the use of the script [Shadowbox.js](http://www.shadowbox-js.com/) by insert the script in the theme or via the plugin [Shadowbox JS](http://wordpress.org/extend/plugins/shadowbox-js/).

= Shadowbox.js use the tag rel="shadowbox[xy]" this plugin works however =

Yes, [Shadowbox.js](http://www.shadowbox-js.com/) normally use the tag rel="shadowbox[xy]" but works however with the tag rel="lightbox[xy]"

== Screenshots ==

1. The code without _Add LightBox & Title_
2. The code with _Add LightBox & Title_

== Changelog ==

= 1.5 =
 * Released 25.05.2010
 * New: Compatible up to: 3.0
= 1.4 =
 * Released 27.02.2010
 * New: Allow all characters in the name of the image (Thanks Thiago)
= 1.3 =
 * Released 10.01.2010
 * New: Compatible up to: 2.9
= 1.2 =
 * Released 12.06.2009
 * New: Compatible up to: 2.8
= 1.1 =
 * Released 31.03.2009
 * Bug fix: If rel="..." is alredy exist but not rel="lightbox" add it
 * New: If user add rel="nolighbox" not add rel="lightbox[ID]"
= 1.0 =
 * Released 24.03.2009
 * Bug fix: Add Lightbox to text link
 * Bug fix: Don't add "rel=..." and "title=..." if already exist in the link
= 0.2 =
 * Released 20.03.2009
 * Simplification of the code
= 0.1 =
 * Released 19.03.2009
 * First Release