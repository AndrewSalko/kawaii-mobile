<?php
/*
Plugin Name: Chitika
Version: 2.0.8
Plugin URI: http://chitika.com/
Description: Enables you to quickly add and modify your use of Chitika within Wordpress! <a href="options-general.php?page=premium/premium.php">Edit your Chitika configuration settings</a>. Please report bugs, questions and concerns by <a href="http://support.chitika.com/customer/portal/emails/new">submitting a support ticket to Chitika</a>.
Author: Chitika Inc.
Author URI: http://chitika.com/
*/

/* These are defaults. Once the plugin is activated, these are no longer
 * used. You'll have to set the options in the Admin panel */

$PREMIUM_DEFAULTS['plugin-version'] =  '2.0.8';
$PREMIUM_DEFAULTS['client']     = 'demo';
$PREMIUM_DEFAULTS['width']      = '468'; 
$PREMIUM_DEFAULTS['height']     = '120';
$PREMIUM_DEFAULTS['size']     = '468x120';
$PREMIUM_DEFAULTS['channel']    = 'wordpress-plugin';
$PREMIUM_DEFAULTS['background'] = 'ffffff'; 
$PREMIUM_DEFAULTS['border'] = '000000'; 
$PREMIUM_DEFAULTS['titlecolor'] = '0000CC'; 
$PREMIUM_DEFAULTS['textcolor'] = '000000';
$PREMIUM_DEFAULTS['placement'] = 'top'; 
$PREMIUM_DEFAULTS['single'] = 'true'; 
$PREMIUM_DEFAULTS['append'] = 'true'; 
$PREMIUM_DEFAULTS['font'] = '';

$PREMIUM_DEFAULTS['template'] ="<!-- Chitika - WordPress Plugin --><div class='chitika-adspace {%placement%}'>
<script type='text/javascript'> 
  ( function() {
    if (window.CHITIKA === undefined) {
      window.CHITIKA = { 'units' : [] };
    };
    var unit = {
      'publisher' : {%client%},
      'width' : {%width%},
      'height' : {%height%},
      'type' : 'mpu',
      'sid' : {%channel%},
      'color_site_link' : {%titlecolor%},
      'color_title' : {%titlecolor%},
      'color_text' : {%textcolor%},
      'color_bg' : {%background%},
      'font_title' : {%font%},
      'font_text' : {%font%},
      'impsrc' : 'wordpress'
    };
    var placement_id = window.CHITIKA.units.length;
    window.CHITIKA.units.push(unit);
    document.write('<div id=\"chitikaAdBlock-' + placement_id + '\"></div>');
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.src = 'http://scripts.chitika.net/getads.js';
    try {
      document.getElementsByTagName('head')[0].appendChild(s);
    } catch(e) {
      document.write(s.outerHTML);
    }
}());
</script></div>";

class chitikaPremium {
	function chitikaPremium() {
		add_action('the_content', array(&$this, 'filter_content'), 500);
		add_action('admin_menu', array(&$this, 'add_options_page'));
		
		$this->install();
		$this->update();
		
		
		if ( ((!get_option('chitikap_client') || get_option('chitikap_client') == 'demo' ) && !isset($_POST['chitikap_update']) ) ||
			 ((empty($_POST['chitikap_client']) || $_POST['chitikap_client'] == 'demo') && isset($_POST['chitikap_update'])) ):
			add_action('admin_notices', array(&$this, 'chitika_premium_warning'));
		endif;
	}
	
	function chitika_premium_warning() {
		echo '
		<div id="chitika-warning" class="error"><p style="font-size:15px"><strong>The Chitika Plugin is almost ready to place ads on your site!</strong> You need to update your <a href="options-general.php?page=premium/premium.php#username">Chitika account username</a>.<br /><br />Don\'t have a Chitika account? <a href="https://chitika.com/publishers/apply?refid=wordpressplugin" target="_blank">Sign Up Today</a>! Note: Until your Chitika Account is approved, you will not be able to start earning revenue from your Chitika Ads.</p></div>';
	}
	
	function chitika_premium_news() {
		$string = '
		<p class="sub" style="margin:10px 0;padding:5px 0;border-bottom:1px solid #ECECEC;">Advertising News</p>
		<p><strong class="spam">Have you checked out the MEGA-Unit?</strong> Network-wide, Chitika\'s new MEGA-Unit\'s CTR is 4 times higher than our other ad units, adding a massive increase in clicks and revenue. Darren Rowse at <a href="http://www.problogger.net/archives/2009/05/16/chitika-mega-units-publishers-reporting-massive-increases-in-earnings/" target="_blank">Pro Blogger</a> posted his reactions to this new unit!</p>';
		$_placement = get_option('chitikap_placement');
		switch($_placement){
			case 'bottom':
				$string .= '<p><strong>You already display Chitika ads below your posts</strong> - a sweet spot for the MEGA-Unit to sit, so why not check it out?  <a href="options-general.php?page=premium/premium.php">Just choose the 550x250 MEGA-Unit in the dropdown</a> and change your channel tracking so that you can compare your current performance to the MEGA-Unit\'s performance!</p>';
				break;
			case 'both':
			case 'top':
			default:
				$string .= '<p><strong>Why not try it out</strong>?  <a href="options-general.php?page=premium/premium.php">Just choose the 550x250 MEGA-Unit in the dropdown</a> and change your channel tracking so that you can compare your current performance to the MEGA-Unit\'s performance</p>';
				break;
		}
		return $string;			
	}
	
	function install() {
		global $PREMIUM_DEFAULTS;
	
		$options = array('width', 'height', 'border', 'titlecolor', 'textcolor', 'client', 'channel', 'background', 'placement','font','size','single','append', 'password');
		foreach ($options as $option) {
			if ( !get_option("chitikap_{$option}".$option) ) {
				add_option("chitikap_{$option}", $PREMIUM_DEFAULTS[$option]);
			}
		}
	}
	
	function update() {
		global $PREMIUM_DEFAULTS;
		// Updates the default variables in the wordpress database if the version number 
		// in the database doesn't match the one in the plugin.
		if (get_option('chitikap_plugin-version') != $PREMIUM_DEFAULTS['plugin-version']){
		  $options = array('width', 'height', 'border', 'titlecolor', 'textcolor', 'client', 'channel', 'background','placement','font','size','single','append', 'password');
			if(get_option('chitikap_channel') == 'default' || get_option('chitikap_channel') == ''){
				// only change for previous default variables
				update_option('chitikap_channel', $PREMIUM_DEFAULTS['channel']);
			}
		}
		update_option('chitikap_plugin-version', $PREMIUM_DEFAULTS['plugin-version']);
	}
	
	function filter_content($text)
	{
		global $PREMIUM_DEFAULTS;
		$textContainsTag = preg_match_all("/(<\!--NO-ChitikaPremium-->)/is", $text, $matches);
		
		if($textContainsTag || is_feed() || (get_option('chitikap_single') == 'true' && !is_single()) ) {
			return $text;
		}
			
		// Get user defined name value pairs from their tag				
		$attributes = array('width', 'height', 'border', 'titlecolor', 'textcolor', 'client', 'channel', 'background','font','size','single','append', 'password');
		$vars = array();
		foreach ($attributes as $att) {
			$vars[$att] = $this->_get_attribute($att, $tag);
		}

		// Get the chitikaPremium javascript template
		
		$template = $PREMIUM_DEFAULTS['template'];
		list($vars['width'], $vars['height']) = explode('x', get_option('chitikap_size'));	
					
		// Put the chitikaPremium template into the post, replacing the user's tag	
		
		$_placement = get_option('chitikap_placement');
		
		if($_placement == 'bottom'){
			$text = $text . "\n" . $this->_apply_template($template, $vars, 'below');
		} elseif($_placement == 'both') {
			$text = $this->_apply_template($template, $vars, 'above - both') . "\n" . $text. "\n" . $this->_apply_template($template, $vars, 'below - both');
                } elseif ($_placement == 'bp1p2') {
                        $text_array = explode('</p>', $text, 2);
                        $text = $text_array[0] . '</p>' . "\n" . $this->_apply_template($template, $vars, 'above') . "\n" . $text_array[1];
		} else {
			$text = $this->_apply_template($template, $vars, 'above') . "\n" . $text;
		}

		return $text;
	}
	
	function options_page() {
	
		if (isset($_POST['chitikap_update'])) {
		  $options = array('width', 'height', 'border', 'titlecolor', 'textcolor', 'client', 'channel', 'background', 'placement','font','size','single','append', 'password');
			
			// Verify username
			$usr_verify = $this->testUserName(
                            stripslashes($_POST['chitikap_client']),
                            stripslashes($_POST['chitikap_password'])
                        );
			if(!$usr_verify){
				$_usr_class = 'usralert';
			}

			foreach ($options as $option) {
				update_option('chitikap_'.$option, stripslashes($_POST['chitikap_'.$option]));
			}
			echo '<div class="updated"><p><strong>Your Chitika settings have been saved.</strong></p></div>';
            if (!$usr_verify){
                echo '<div class="updated"><p><strong><font color="red">
                    Username & password combination not correct. Please update username and password to start earning revenue from your Chitika Ads.
                </font></strong></p></div>';
            }
		}
?>
<div class="wrap"><h2>Chitika Settings</h2>
	<fieldset class="options"> 
	<legend>Customize Your Chitika Ad Display Settings</legend>
	<h3>What is Chitika?</h3>
	<p><a href="http://chitika.com">Chitika</a> is a CPC advertising solution. The ads are search-targeted, meaning that they will show relevant ads to your search visitors based on what they are searching for. Chitika ads will also show ads to non-search users. The ads can be run on the same page as Google AdSense, or on their own as an AdSense Alternative.</p>
<?php
	if((float)get_bloginfo('version') >= 2.2){
?>
	<div>
	<h3>How Do I Preview Chitika on my Blog?</h3>
	<p>Enter the URL of the page you want to preview your Chitika Ads on, and add the keyword to display ads for and click preview.</p>
	<p>For additional help, <a href="http://support.chitika.com/customer/portal/emails/new">send us an email</a>.</p>
	
	<div style="background-color:#EAF3FA; margin-left:10px; width:500px; padding:15px; line-height:1.6em;">
	<form name="previewtool" id="previewtool" method="get">
		<fieldset><legend style="font-size:1.3em; font-weight:bold;">Chitika Preview Tool</legend>
		<label for="chitikap_url"><strong>URL</strong>  (For preview purposes only)</label><br />
		<input name="chitikap_url" type="text" id="chitikap_url" value="<?php echo bloginfo('url') ?>" size="45" /><br />
		<label for="chitikap_keywords"><strong>Keyword(s)</strong>  (For preview purposes only)</label><br />
		<input name="chitikap_keywords" type="text" id="chitikap_keywords" value="powered generators" size="45" />
		<p class="submit" style="border-top-width: 0pt; padding-top:0">
		  <input type="button" onclick="var uri = jQuery('#chitikap_url').val() + '#chitikatest=' + jQuery('#chitikap_keywords').val(); window.open( uri ,'chitikapreview','width=600,height=500,status=1,toolbar=1,resizable=1,location=1,scrollbars=1');" name="chitikap_preview" value="Preview (in new window)" />
		</p>
</fieldset>
<p>This tool is for previewing only - it will append <code>#chitikatest=keywords</code> to the URL of your choosing to preview the ad unit.  Only the form below will be saved to change the Chitika display options on your blog.</p>
	</form>
</div>
	</div>
<?php
	} else {
?>
	<h3>How Do I Preview Chitika on my Blog?</h3>
	<p>Since Chitika ads will only display to your US and Canada search engine traffic, you need to append `#chitikatest=keywords` to the end of your URL to preview Chitika in your blog. For additional help please view the <a href="https://chitika.com/support/index.php?_m=knowledgebase&_a=viewarticle&kbarticleid=138&nav=0,13">preview support documentation</a>.	
<?php
	}
?>
	
	<br style="clear:both;" />	
<style type="text/css">
.usralert { font-weight:bold; }
input.usralert { font-weight:normal; font-style:italic; }
</style>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
<h3>Settings</h3>

<table width="100%" cellspacing="2" cellpadding="5" class="form-table">
	<tr valign="top"> 
    	<th width="33%" scope="row">Placement</th> 
        <td>
		<?php
			$_placement = get_option('chitikap_placement');
			if( $_placement == 'bottom'){
				$chitikap_placement_put[1] = ' checked="checked"'; $chitikap_placement_put[0] = ''; $chitikap_placement_put[2] = ''; $chitikap_placement_put[3] = '';
			} else if ($_placement == 'both'){
				$chitikap_placement_put[1] = ''; $chitikap_placement_put[0] = ''; $chitikap_placement_put[2] = ' checked="checked"'; $chitikap_placement_put[3] = '';
                        } else if ($_placement == 'bp1p2') {
                                $chitikap_placement_put[1] = ''; $chitikap_placement_put[0] = ''; $chitikap_placement_put[2] = ''; $chitikap_placement_put[3] = ' checked="checked"';
			} else {
				$chitikap_placement_put[1] = ''; $chitikap_placement_put[0] = ' checked="checked"'; $chitikap_placement_put[2] = ''; $chitikap_placement_put[3] = '';
			}
		?>
	<input name="chitikap_placement" type="radio" id="chitikap_placement" value="top" <?php echo $chitikap_placement_put[0]; ?>/> <label for="chitikap_placement_top">Above Posts <em>(Recommended!)</em></label><br />
        <input name="chitikap_placement" type="radio" id="chitikap_placement" value="bottom" <?php echo $chitikap_placement_put[1]; ?>/> <label for="chitikap_placement_bottom">Below Posts</label><br />
        <input name="chitikap_placement" type="radio" id="chitikap_placement" value="both" <?php echo $chitikap_placement_put[2]; ?>/> <label for="chitikap_placement_both">Above and Below Posts</label><br />
        <input name="chitikap_placement" type="radio" id="chitikap_placement" value="bp1p2" <?php echo $chitikap_placement_put[3]; ?>/> <label for="chitikap_placement_bp1p2">Between First and Second Paragraph</label><br />
		<p>Placing the code <code>&lt;!--no-chitikapremium--&gt;</code> within a post will stop Chitika from displaying with that specific post.</p>
	  </td>  
	</tr>
	
	<tr valign="top"> 
    	<th width="33%" scope="row" id="username">Chitika Account Username</th> 
        <td>
		<?php
				$_style = $_stylep = '';
				if ( (!get_option('chitikap_client') || get_option('chitikap_client') == 'demo' ) && !isset($_POST['submit']) ) {
					$_style = 'style="background-color:#FFFBCC; border-color:#D54E21;"';
				}
				if(isset($_usr_class)){
					$_style .= ' class="' . $_usr_class.'"';
					$_stylep = ' class="' . $_usr_class.'"';
				}
	        ?>
                Username <input name="chitikap_client" type="text" id="chitikap_client" value="<?php echo get_option('chitikap_client') ?>" <?php echo $_style; ?> size="50" /><br />
                Password <input name="chitikap_password" type="password" id="chitikap_password" value="<?php echo get_option('chitikap_password') ?>" <?php echo $_style; ?> size="50" /><br />

        <p <?php echo $_stylep; ?>>If you dont have a Chitika account, please <a target="_blank" href="https://chitika.com/publishers/apply?refid=wordpressplugin">sign up</a> for one.<br /> Note: Until your Chitika Account is approved, you will not be able to start earning revenue from your Chitika Ads.<br />This is the ID you sign into <a href="http://publishers.chitika.com" target="_blank">chitika.com</a> with to check your earnings.</p>
	  </td>  
	</tr>
    <tr valign="top"> 
    	<th width="33%" scope="row">Size</th> 
        <td>
		<fieldset><legend class="hidden">Chitika Size</legend>
		<?php
			$_font = get_option('chitikap_size');
			$put_chitikap_size = array_fill(0, 23, '');
			switch($_font){
				case '728x90' :
					$put_chitikap_size[0] = ' selected="selected"';		break;
				case '120x600' :
					$put_chitikap_size[1] = ' selected="selected"';		break;
				case '160x600' :
					$put_chitikap_size[2] = ' selected="selected"';		break;
				case '468x180' :
					$put_chitikap_size[3] = ' selected="selected"';		break;
				case '468x90' :
					$put_chitikap_size[5] = ' selected="selected"';		break;
				case '468x60' :
					$put_chitikap_size[6] = ' selected="selected"';		break;
				case '550x120' :
					$put_chitikap_size[7] = ' selected="selected"';		break;
				case '550x90' :
					$put_chitikap_size[8] = ' selected="selected"';		break;
				case '450x90' :
					$put_chitikap_size[9] = ' selected="selected"';		break;
				case '430x90' :
					$put_chitikap_size[10] = ' selected="selected"';	break;
				case '400x90' :
					$put_chitikap_size[11] = ' selected="selected"';	break;
				case '300x250' :
					$put_chitikap_size[12] = ' selected="selected"';	break;
				case '300x150' :
					$put_chitikap_size[13] = ' selected="selected"';	break;
				case '300x125' :
					$put_chitikap_size[14] = ' selected="selected"';	break;
				case '300x70' :
					$put_chitikap_size[15] = ' selected="selected"';	break;
				case '250x250' :
					$put_chitikap_size[16] = ' selected="selected"';	break;
				case '200x200' :
					$put_chitikap_size[17] = ' selected="selected"';	break;
				case '160x160' :
					$put_chitikap_size[18] = ' selected="selected"';	break;
				case '336x280' :
					$put_chitikap_size[19] = ' selected="selected"';	break;
				case '336x160' :
					$put_chitikap_size[20] = ' selected="selected"';	break;
				case '334x100' :
					$put_chitikap_size[21] = ' selected="selected"';	break;
				case '180x300' :
					$put_chitikap_size[22] = ' selected="selected"';	break;
				case '180x150' :
					$put_chitikap_size[23] = ' selected="selected"';	break;
				case '550x250' :
					$put_chitikap_size[24] = ' selected="selected"';	break;
				case '500x250' :
					$put_chitikap_size[25] = ' selected="selected"';	break;
				default:
					$put_chitikap_size[4] = ' selected="selected"';		break;
			}
		?>
			<select name="chitikap_size" id="chitikap_size">
			
				<option value="550x250"<?php echo $put_chitikap_size[24]; ?>>550 x 250 *New!* MEGA-Unit</option>
				<option value="500x250"<?php echo $put_chitikap_size[25]; ?>>500 x 250 *New!* MEGA-Unit</option>
				<option value="468x180"<?php echo $put_chitikap_size[3]; ?>>468 x 180 Blog Banner</option>
				<option value="468x120"<?php echo $put_chitikap_size[4]; ?>>468 x 120 Blog Banner</option>
				<option value="" disabled="disabled"></option>
				<option value="468x90"<?php echo $put_chitikap_size[5]; ?>>468 x 90 Small Blog Banner</option>
				<option value="468x60"<?php echo $put_chitikap_size[6]; ?>>468 x 60 Mini Blog Banner</option>
				<option value="" disabled="disabled"></option>
				<option value="728x90"<?php echo $put_chitikap_size[0]; ?>>728 x 90 Leaderboard</option>
				<option value="120x600"<?php echo $put_chitikap_size[1]; ?>>120 x 600 Skyscraper</option>
				<option value="160x600"<?php echo $put_chitikap_size[2]; ?>>160 x 600 Wide Skyscraper</option>
				<option value="" disabled="disabled"></option>
				<option value="550x120"<?php echo $put_chitikap_size[7]; ?>>550 x 120 Content Banner</option>
				<option value="550x90"<?php echo $put_chitikap_size[8]; ?>>550 x 90 Content Banner</option>
				<option value="450x90"<?php echo $put_chitikap_size[9]; ?>>450 x 90 Small Content Banner</option>

				<option value="430x90"<?php echo $put_chitikap_size[10]; ?>>430 x 90 Small Content Banner</option>
				<option value="400x90"<?php echo $put_chitikap_size[11]; ?>>400 x 90 Small Content Banner</option>
				<option value="" disabled="disabled"></option>
				<option value="300x250"<?php echo $put_chitikap_size[12]; ?>>300 x 250 Rectangle</option>
				<option value="300x150"<?php echo $put_chitikap_size[13]; ?>>300 x 150 Rectangle, Wide</option>
				<option value="300x125"<?php echo $put_chitikap_size[14]; ?>>300 x 125 Mini Rectangle, Wide</option>

				<option value="300x70"<?php echo $put_chitikap_size[15]; ?>>300 x 70 Mini Rectangle, Wide</option>
				<option value="" disabled="disabled"></option>
				<option value="250x250"<?php echo $put_chitikap_size[16]; ?>>250 x 250 Square</option>
				<option value="200x200"<?php echo $put_chitikap_size[17]; ?>>200 x 200 Small Square</option>
				<option value="160x160"<?php echo $put_chitikap_size[18]; ?>>160 x 160 Small Square</option>
				<option value="" disabled="disabled"></option>
				<option value="336x280"<?php echo $put_chitikap_size[19]; ?>>336 x 280 Rectangle</option>

				<option value="336x160"<?php echo $put_chitikap_size[20]; ?>>336 x 160 Rectangle, Wide</option>
				<option value="" disabled="disabled"></option>
				<option value="334x100"<?php echo $put_chitikap_size[21]; ?>>334 x 100 Small Rectangle, Wide</option>
				<option value="180x300"<?php echo $put_chitikap_size[22]; ?>>180 x 300 Small Rectangle, Tall</option>
				<option value="180x150"<?php echo $put_chitikap_size[23]; ?>>180 x 150 Small Rectangle</option>
			</select>
		</fieldset>
			<p>Recommended sizes are the MEGA-Unit (550x250) which has an awesome CTR or the 468 wide x 120 high which fits well in most WordPress templates.</p>
	</td>  
    </tr>
    <tr valign="top"> 
        <th width="33%" scope="row">Font</th> 
        <td>
		<?php
			$_font = get_option('chitikap_font');
			$put_chitikap_font = array_fill(0, 7, '');
			switch($_font){
				case 'Arial' :
					$put_chitikap_font[1] = ' selected="selected"';		break;
				case 'Comic Sans MS' :
					$put_chitikap_font[2] = ' selected="selected"';		break;
				case 'Georgia' :
					$put_chitikap_font[3] = ' selected="selected"';		break;
				case 'Tahoma' :
					$put_chitikap_font[4] = ' selected="selected"';		break;
				case 'Times' :
					$put_chitikap_font[5] = ' selected="selected"';		break;
				case 'Verdana' :
					$put_chitikap_font[6] = ' selected="selected"';		break;
				case 'Courier' :
					$put_chitikap_font[7] = ' selected="selected"';		break;
				default:
					$put_chitikap_font[9] = ' selected="selected"';		break;
			}
		?>
			<select name="chitikap_font" id="chitikap_font">
				<option value="" <?php echo $put_chitikap_font[0]; ?>>-- Default Font --</option>
				<option value="Arial"<?php echo $put_chitikap_font[1]; ?>>Arial</option>
				<option value="Comic Sans MS"<?php echo $put_chitikap_font[2]; ?>>Comic Sans MS</option>
				<option value="Georgia"<?php echo $put_chitikap_font[3]; ?>>Georgia</option>
				<option value="Tahoma"<?php echo $put_chitikap_font[4]; ?>>Tahoma</option>
				<option value="Times"<?php echo $put_chitikap_font[5]; ?>>Times</option>
				<option value="Verdana"<?php echo $put_chitikap_font[6]; ?>>Verdana</option>
				<option value="Courier"<?php echo $put_chitikap_font[7]; ?>>Courier</option>
			</select>
		</td>  
    </tr> 
    <tr valign="top"> 
        <th width="33%" scope="row">Channel Tracking</th> 
        <td><input name="chitikap_channel" type="text" id="chitikap_channel" value="<?php echo get_option('chitikap_channel') ?>" size="50" /><br />
		<p><a href="http://support.chitika.com/customer/portal/articles/62580-tracking-the-performance-of-each-ad-unit" target="_blank">What are Channels?</a></p>
		<?php
			$_append = get_option('chitikap_append');
			if( $_append == 'true'){
				$chitikap_append_put = ' checked="checked"';
			} else {
				$chitikap_append_put = '';
			}
		?>
		<input name="chitikap_append" type="checkbox" id="chitikap_append" <?php echo $chitikap_append_put; ?> value="true" /> Append top / bottom to channel name depending on ad placement?
		</td>  
    </tr> 
    <tr valign="top"> 
        <th width="33%" scope="row">Background Color</th>
        <td>#<input name="chitikap_background" type="text" id="chitikap_background" value="<?php echo get_option('chitikap_background') ?>" size="25" />
		</td>  
    </tr>
	<?php
	/*
    <tr valign="top"> 
        <th width="33%" scope="row">Border Color</th> 
        <td>#<input name="chitikap_border" type="text" id="chitikap_border" value="<?php echo get_option('chitikap_border') ?>" size="25" />
		</td>  
    </tr>
	*/
	?>
    <tr valign="top"> 
        <th width="33%" scope="row">Link Color</th> 
        <td>#<input name="chitikap_titlecolor" type="text" id="chitikap_titlecolor" value="<?php echo get_option('chitikap_titlecolor') ?>" size="25" />
		</td>  
    </tr>
    <tr valign="top"> 
        <th width="33%" scope="row">Text Color</th> 
        <td>#</strong><input name="chitikap_textcolor" type="text" id="chitikap_textcolor" value="<?php echo get_option('chitikap_textcolor') ?>" size="25" />
		</td>  
    </tr>
    </table>
    </fieldset>

    <p class="submit">
      <input type="submit" name="chitikap_update" id="chitikap_update" value="Update Settings &raquo;" style="font-weight:bold;" />
    </p>
</form>
<?php
	}
	
	function add_options_page() {
		add_options_page('Chitika Settings', 'Chitika', 10, 'premium/premium.php', array(&$this, 'options_page'));
	}
	
	/* Parses premium tag for attributes values.
	 * If not found, use get_option to get defaults */
	function _get_attribute($name, $tag)
	{
		// Look for the name value pair, parse it out. Backreferences here provides
		// flexibility so the user can use either single or double quotes, as
		// long as their balanced, this will parse. 
		$tag = str_replace(array("&#8243;", "&#8242;"), array('"', "'"), $tag);
		$hasAttribute = preg_match( "/$name=('|\")([^\\1]*?)\\1/i", $tag, $matches );
		if ( $hasAttribute ) {
			$quote = $matches[1];
			$value = "$quote$matches[2]$quote";
		} else {
			$value = '"' . get_option("chitikap_${name}") . '"';
		}

		return $value;
	}
	
	function _prepare_template_var(&$item, $key) {
		$item = '{%' . $item . '%}';
	}

	function _apply_template($str, $replace = 0, $position = 'top') {
		global $wp_query;
		
		if(get_option('chitikap_append') == 'true'){ 
			$replace['channel'] = '"' . trim($replace['channel'], '"') . ' ' .$position .'"';
		}
		$replace['placement'] = str_replace(array(' ', '-'),'', $position);
		
	    if ( is_array($replace) ) {
			$from = array_keys($replace);
			array_walk($from, array(&$this, '_prepare_template_var'));
			
			$to = array_values($replace);
			return str_replace($from, $to, $str);
		}
		return $str;
	}
	
    function testUserName($user, $password){ // username verification
        global $PREMIUM_DEFAULTS;
        $uri="https://publishers.chitika.com/validate?username=".$user;
        $data = array('password' => $password);
        $ch = curl_init($uri);
        if ($ch) {
            $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
            curl_setopt($ch, CURLOPT_POST, true );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_REFERER, $host);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $r = curl_exec($ch);
            curl_close($ch);
            $results = json_decode($r);
            return $results->{'response'};
        } else {
            return false;
        }
    }
}

$chitikapremiumad = new chitikaPremium();

// WP < 2.5
function chpremium_stats() {
	if ( !function_exists('did_action') || did_action( 'rightnow_end' ) ) // We already displayed this info in the "Right Now" section
		return;
		
	global $chitikapremiumad;
		
	echo $chitikapremiumad->chitika_premium_news();
}

add_action('activity_box_end', 'chpremium_stats');

// WP 2.5+
function chpremium_rightnow() {
	global $chitikapremiumad;

	echo $chitikapremiumad->chitika_premium_news();
}
	
add_action('rightnow_end', 'chpremium_rightnow');







