<?php global $is_ajax; $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']); if (!$is_ajax) get_header(); ?>
<?php $wptouch_settings = bnc_wptouch_get_settings(); ?>

<div class="content" id="content<?php echo md5($_SERVER['REQUEST_URI']); ?>">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post">
				
				<?php
				if( !is_attachment())
				{?>
			    <a class="sh2" href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( "Permanent Link to ", "wptouch" ); ?><?php if (function_exists('the_title_attribute')) the_title_attribute(); else the_title(); ?>"><?php the_title(); ?></a>
				<?php
				}
				else
				{
					echo '<h1>'. get_the_title() .' [<a href="' . get_permalink($post->post_parent) . '" rev="attachment">' . get_the_title($post->post_parent) . '</a>]</h1>';
				}
				?>
		        <div class="single-post-meta-top"><?php echo get_the_time('M jS, Y @ h:i a') ?> &rsaquo; <?php the_author() ?><br />

		<!-- Let's check for DISQUS... we need to skip to a different div if it's installed and active -->		
		</div>
	</div>

		<div class="clearer"></div>			

        <div class="post" id="post-<?php the_ID(); ?>">
         	<div id="singlentry" class="<?php echo $wptouch_settings['style-text-justify']; ?>">
            	<?php the_content(); ?>				
			</div>  
			
			<!-- Categories and Tags post footer -->
			<?php 
			if( !is_attachment())
			{
				echo '<div class="single-post-meta-bottom">';

				wp_link_pages( 'before=<div class="post-page-nav">' . __( "Article Pages", "wptouch-pro" ) . ':&after=</div>&next_or_number=number&pagelink=page %&previouspagelink=&raquo;&nextpagelink=&laquo;' );
			    _e( "Categories", "wptouch" );

				echo ': ';

				if (the_category(', ')) 
				{
					the_category();
				}

			    if (function_exists('get_the_tags')) 
				{
					the_tags('<br />' . __( 'Tags', 'wptouch' ) . ': ', ', ', '');
				}

			    echo '</div>';
			}
			?>


    	</div>

<!-- Let's rock the comments -->
<?php if ( bnc_can_show_comments() ) : ?>
	<?php comments_template(); ?>
<script type="text/javascript">
jQuery(document).ready( function() {
// Ajaxify '#commentform'
var formoptions = { 
	beforeSubmit: function() {$wptouch("#loading").fadeIn(400);},
	success:  function() {
		$wptouch("#commentform").hide();
		$wptouch("#loading").fadeOut(400);
		$wptouch("#refresher").fadeIn(400);
		}, // end success 
	error:  function() {
		$wptouch('#errors').show();
		$wptouch("#loading").fadeOut(400);
		} //end error
	} 	//end options
$wptouch('#commentform').ajaxForm(formoptions);
}); //End onReady
</script>
<?php endif; ?>
	<?php endwhile; else : ?>

<!-- Dynamic test for what page this is. A little redundant, but so what? -->

	<div class="result-text-footer">
		<?php wptouch_core_else_text(); ?>
	</div>

	<?php endif; ?>
</div>
	
	<!-- Do the footer things -->
	
<?php global $is_ajax; if (!$is_ajax) 
get_footer();