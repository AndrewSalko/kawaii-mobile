<?php
/**
 * publishable Lite functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package publishable Lite
 */

if ( ! function_exists( 'publishable_lite_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function publishable_lite_setup() {
	define( 'publishable_mag', '4.0' );
    /*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on publishable, use a find and replace
	 * to change 'publishable-mag' to the name of your theme in all the template files.
	 */
    load_theme_textdomain( 'publishable-mag', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(150, 150, true);

	add_image_size('kawaii-thumb-168x300', 168, 300);
	add_image_size('kawaii-thumb-225x400', 225, 400);
	add_image_size('kawaii-thumb-340x604', 340, 604);
	add_image_size('kawaii-thumb-300x266', 300, 266);
	add_image_size('kawaii-thumb-450x400', 450, 400);
	add_image_size('kawaii-thumb-576x1024', 576, 1024);


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'publishable-mag' ),
		) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		) );

	if ( publishable_lite_is_wc_active() ) {
		add_theme_support( 'woocommerce' );
	}

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'publishable_lite_custom_background_args', array(
		'default-color' => '#eee',
		'default-image' => '',
		) ) );
}
endif;
add_action( 'after_setup_theme', 'publishable_lite_setup' );

function publishable_lite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'publishable_lite_content_width', 678 );
}
add_action( 'after_setup_theme', 'publishable_lite_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function publishable_lite_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'publishable-mag' ),
		'id'            => 'sidebar',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		) );

	// Header Ad sidebar
	register_sidebar(array(
		'name' => __('Header Ad', 'publishable-mag'),
		'description'   => __( '728x90 Ad Area', 'publishable-mag' ),
		'id' => 'widget-header',
		'before_widget' => '<div id="%1$s" class="widget-header">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		));

    // First Footer
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'publishable-mag' ),
		'description'   => __( 'First footer column', 'publishable-mag' ),
		'id'            => 'footer-first',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		) );

	// Second Footer
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'publishable-mag' ),
		'description'   => __( 'Second footer column', 'publishable-mag' ),
		'id'            => 'footer-second',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		) );

	// Third Footer
	register_sidebar( array(
		'name'          => __( 'Footer 3', 'publishable-mag' ),
		'description'   => __( 'Third footer column', 'publishable-mag' ),
		'id'            => 'footer-third',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		) );

	if ( publishable_lite_is_wc_active() ) {
        // Register WooCommerce Shop and Single Product Sidebar
		register_sidebar( array(
			'name' => __('Shop Page Sidebar', 'publishable-mag' ),
			'description'   => __( 'Appears on Shop main page and product archive pages.', 'publishable-mag' ),
			'id' => 'shop-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			) );
		register_sidebar( array(
			'name' => __('Single Product Sidebar', 'publishable-mag' ),
			'description'   => __( 'Appears on single product pages.', 'publishable-mag' ),
			'id' => 'product-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			) );
	}
}
add_action( 'widgets_init', 'publishable_lite_widgets_init' );

function publishable_lite_custom_sidebar() {
    // Default sidebar.
	$sidebar = 'sidebar';

    // Woocommerce.
	if ( publishable_lite_is_wc_active() ) {
		if ( is_shop() || is_product_category() ) {
			$sidebar = 'shop-sidebar';
		}
		if ( is_product() ) {
			$sidebar = 'product-sidebar';
		}
	}

	return $sidebar;
}

/**
 * Enqueue scripts and styles.
 */
function publishable_lite_scripts() {
	wp_enqueue_style( 'publishable-mag-style', get_stylesheet_uri(), array(), "17.03.2023");

	$handle = 'publishable-mag-style';

    // WooCommerce
	if ( publishable_lite_is_wc_active() ) {
		if ( is_woocommerce() || is_cart() || is_checkout() ) {
			wp_enqueue_style( 'woocommerce', get_template_directory_uri() . '/css/woocommerce2.css' );
			$handle = 'woocommerce';
		}
	}

	wp_enqueue_script( 'publishable-mag-customscripts', get_template_directory_uri() . '/js/customscripts.js',array('jquery'),'',true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	$publishable_lite_color_scheme = get_theme_mod('publishable_lite_color_scheme', '#c69c6d');
	$publishable_lite_color_scheme2 = get_theme_mod('publishable_lite_color_scheme2', '#1b1b1b');
	$publishable_lite_layout = get_theme_mod('publishable_lite_layout', 'cslayout');
	$header_image = get_header_image();
	/* footer .widget li a:hover, */
	/* .top a:hover, */
	/* .copyrights a:hover */
	$custom_css = "

/* latin */
@font-face {
  font-family: 'Roboto';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu4mxK.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* latin */
@font-face {
  font-family: 'Roboto';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmEU9fBBc4.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* latin */
@font-face {
  font-family: 'Roboto';
  font-style: normal;
  font-weight: 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmWUlfBBc4.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}

        #tabber .inside li .meta b,.fn a,.reply a,#tabber .inside li div.info .entry-title a:hover, #navigation ul ul a:hover,.single_post a, a:hover, .sidebar.c-4-12 .textwidget a, #site-footer .textwidget a, #commentform a, #tabber .inside li a, a, .sidebar.c-4-12 a:hover, footer .tagcloud a:hover { color: $publishable_lite_color_scheme; }

	span.sticky-post, #commentform input#submit, #searchform input[type='submit'], .home_menu_item, .primary-navigation, .currenttext, .readMore a, .mts-subscribe input[type='submit'], .pagination .current, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-product-search input[type=\"submit\"], .woocommerce a.button, .woocommerce-page a.button, .woocommerce button.button, .woocommerce-page button.button, .woocommerce input.button, .woocommerce-page input.button, .woocommerce #respond input#submit, .woocommerce-page #respond input#submit, .woocommerce #content input.button, .woocommerce-page #content input.button { background-color: $publishable_lite_color_scheme; }

	.woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-page nav.woocommerce-pagination ul li span.current, .woocommerce #content nav.woocommerce-pagination ul li span.current, .woocommerce-page #content nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce-page nav.woocommerce-pagination ul li a:focus, .woocommerce #content nav.woocommerce-pagination ul li a:focus, .woocommerce-page #content nav.woocommerce-pagination ul li a:focus, .pagination .current, .tagcloud a { border-color: $publishable_lite_color_scheme; }
	.corner { border-color: transparent transparent $publishable_lite_color_scheme transparent;}

	.primary-navigation, footer, .readMore a:hover, #commentform input#submit:hover, .featured-thumbnail .latestPost-review-wrapper { background-color: $publishable_lite_color_scheme2; }
	";
	if(!empty($publishable_lite_layout) && $publishable_lite_layout == "sclayout") {
		$custom_css .= ".article { float: right; } .sidebar.c-4-12 { float: left; }";
	}
	wp_add_inline_style( $handle, $custom_css );
}
add_action( 'wp_enqueue_scripts', 'publishable_lite_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Add the Social buttons Widget.
 */
include_once( "functions/widget-social.php" );

/**
 * Copyrights
 */
if ( ! function_exists( 'publishable_lite_copyrights_credit' ) ) {
	function publishable_lite_copyrights_credit() {
		global $mts_options
		?>
		<!--start copyrights-->
		<div class="copyrights">
			<div class="container">
				<div class="row" id="copyright-note">
					<span>
						<?php echo '&copy; '. esc_html(date_i18n(__('Y','publishable-mag'))); ?> <?php bloginfo( 'name' ); ?>
						<?php /* <span class="footer-info-right"> */ ?>
						<?php /* echo esc_html_e(' | WordPress Theme by', 'publishable-mag') */ ?>
                        <?php /* salko
						<a href="<xphp echo esc_url('https://superbthemes.com/', 'publishable-mag'); x>"><xphp echo esc_html_e(' Superb Themes', 'publishable-mag') x></a>
						*/ ?>
						<?php /*</span>*/ ?>
					<div class="top">

						<a href="#top" class="toplink"><?php esc_html_e('Back to Top','publishable-mag'); ?> &uarr;</a>
					</div>
				</div>
			</div>
		</div>
		<!--end copyrights-->
		<?php }
	}

/**
 * Custom Comments template
 */
if ( ! function_exists( 'publishable_lite_comments' ) ) {
	function publishable_lite_comment($comment, $args, $depth) { ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" style="position:relative;" itemscope itemtype="http://schema.org/UserComments">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment->comment_author_email, 70 ); ?>
				<div class="comment-metadata">
					<?php printf('<span class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</span>', get_comment_author_link()) ?>
					<span class="comment-meta">
						<?php edit_comment_link(__('(Edit)', 'publishable-mag'),'  ','') ?>
					</span>
				</div>
			</div>
			<?php if ($comment->comment_approved == '0') : ?>
				<em><?php esc_html_e('Your comment is awaiting moderation.', 'publishable-mag') ?></em>
				<br />
			<?php endif; ?>
			<div class="commentmetadata" itemprop="commentText">
				<?php comment_text() ?>
				<time><?php comment_date(get_option( 'date_format' )); ?></time>
				<span class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</span>
			</div>
		</div>
	</li>
	<?php }
}

/*
 * Excerpt
 */
function publishable_lite_excerpt($limit)
{
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit)
	{
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt);
	}
	else
	{
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	return $excerpt;
}

/**
 * Shorthand function to check for more tag in post.
 *
 * @return bool|int
 */
function publishable_lite_post_has_moretag() {
	return strpos( get_the_content(), '<!--more-->' );
}

if ( ! function_exists( 'publishable_lite_readmore' ) ) {
    /**
     * Display a "read more" link.
     */
    function publishable_lite_readmore() {
    	?>
    	<div class="readMore">
    		<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
    			<?php esc_html_e( 'Read More', 'publishable-mag' ); ?>
    		</a>
    	</div>
    	<?php
    }
}

/**
 * Breadcrumbs
 */
if (!function_exists('publishable_lite_the_breadcrumb'))
{
	function publishable_lite_the_breadcrumb()
	{
		if (is_front_page())
		{
			return;
		}

		echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="root">';
		echo '<a itemprop="item" href="';
		echo esc_url( home_url() );
		echo '"><span itemprop="name">'.esc_html(sprintf( __( "Home", 'publishable-mag' ))).'</span> ';
		echo '</a>';
		echo '<meta itemprop="position" content="1" />';
		echo '</span>';
		echo '<span><i class="publishable-icon icon-angle-double-right"></i>';
		echo '</span>';

		if (is_attachment())
		{
			//�������� ������ - ����� � ��� ����� ������� � ��������� ������������ ����, ����� �������� ������ ���������
			$attPage=get_post(get_the_ID());
			$parent_id  = $attPage->post_parent;
			if($parent_id)
			{
				$breadToParentPost='<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
				$breadToParentPost .='<a itemprop="item" href="'.esc_url( get_permalink( $parent_id ) ).'">';
				$breadToParentPost .='<span itemprop="name">'.esc_html( get_the_title($parent_id)).'</span></a>';
				$breadToParentPost .='<meta itemprop="position" content="2" /></span>';//<span><i class="publishable-icon icon-angle-double-right"></i></span>';
				echo $breadToParentPost;
			}
			/*
			echo "<span><span>";
			the_title();
			echo "</span></span>";*/
		}
		elseif (is_single()) //��������� ������������ �� �������� ������ ������ ���� ������� ����� attachment � page
		{
			$categories = get_the_category();	//�������� ������ ������ � ���������� ����������� � ���������� �����
			if ( $categories )
			{
				$level = 0;
				$hierarchy_arr = array();
				foreach ( $categories as $cat )
				{
					$anc = get_ancestors( $cat->term_id, 'category' );
					$count_anc = count( $anc );
					if (  0 < $count_anc && $level < $count_anc )
					{
						$level = $count_anc;
						$hierarchy_arr = array_reverse( $anc );
						array_push( $hierarchy_arr, $cat->term_id );
					}
				}
				if ( empty( $hierarchy_arr ) )
				{
					$category = $categories[0];
					echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><meta itemprop="position" content="2" /><a itemprop="item" href="'. esc_url( get_category_link( $category->term_id ) ).'"><span itemprop="name">'.esc_html( $category->name ).'</span></a></span>';
					//echo '<span><i class="publishable-icon icon-angle-double-right"></i></span>';
				}
				else
				{
					$catIndex=2; //��� ���������
					foreach ( $hierarchy_arr as $cat_id )
					{
						$catIndexStr=strval($catIndex);
						$category = get_term_by( 'id', $cat_id, 'category' );
						echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><meta itemprop="position" content="'.$catIndexStr.'" /><a itemprop="item" href="'. esc_url( get_category_link( $category->term_id ) ).'"><span itemprop="name">'.esc_html( $category->name ).'</span></a></span>';
						//<span><i class="publishable-icon icon-angle-double-right"></i></span>';
						$catIndex++;
					}
				}
			}
			//echo "<span><span>";
			//the_title();
			//echo "</span></span>";
		}
		elseif (is_page())
		{
			$parent_id  = wp_get_post_parent_id( get_the_ID() );
			if ( $parent_id )
			{
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page = get_page( $parent_id );
					$breadcrumbs[] = '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><meta itemprop="position" content="2" /><a itemprop="item" href="'.esc_url( get_permalink( $page->ID ) ).'"><span itemprop="name">'.esc_html( get_the_title($page->ID) ).'</span></a></span><span><i class="publishable-icon icon-angle-double-right"></i></span>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) { echo $crumb; }
			}
			//echo "<span><span>";
			//the_title();
			//echo "</span></span>";
		}
		elseif (is_category())
		{
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$this_cat_id = $cat_obj->term_id;
			$hierarchy_arr = get_ancestors( $this_cat_id, 'category' );
			if ( $hierarchy_arr )
			{
				$catIndex=2; //��� ���������

				$hierarchy_arr = array_reverse( $hierarchy_arr );
				foreach ( $hierarchy_arr as $cat_id )
				{
					$catIndexStr=strval($catIndex);
					$category = get_term_by( 'id', $cat_id, 'category' );
					echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><meta itemprop="position" content="'.$catIndexStr.'" /><a itemprop="item" href="'.esc_url( get_category_link( $category->term_id ) ).'"><span itemprop="name">'.esc_html( $category->name ).'</span></a></span><span><i class="publishable-icon icon-angle-double-right"></i></span>';
					$catIndex++;
				}
			}
			echo "<span><span>";
			single_cat_title();
			echo "</span></span>";
		}
		elseif (is_author())
		{
			echo "<span><span>";
			if(get_query_var('author_name')) :
				$curauth = get_user_by('slug', get_query_var('author_name'));
			else :
				$curauth = get_userdata(get_query_var('author'));
			endif;
			echo esc_html( $curauth->nickname );
			echo "</span></span>";
		} elseif (is_search())
		{
			echo "<span><span>";
			the_search_query();
			echo "</span></span>";
		} elseif (is_tag())
		{
			echo "<span><span>";
			single_tag_title();
			echo "</span></span>";
		}
	}
}


/*
 * Google Fonts
 */
function publishable_lite_fonts_url() {
	$fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by Monda, translate this to 'off'. Do not translate
    * into your own language.
    */
    $monda = _x( 'on', 'Monda font: on or off', 'publishable-mag' );

    if ( 'off' !== $monda ) {
    	$font_families = array();

    	if ( 'off' !== $monda ) {
    		$font_families[] = urldecode('Roboto:400,500,700,900');
    	}

    	$query_args = array(
    		'family' => urlencode( implode( '|', $font_families ) ),
            //'subset' => urlencode( 'latin,latin-ext' ),
    		);

    	$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }

    return $fonts_url;
}

// salko
// Change the excerpt length
function kawaii_excerpt_length( $length )
{
  return 15;
}
//add_filter( 'excerpt_length', 'kawaii_excerpt_length', 999 );


// salko - detect real post excerpt
function kawaii_wp_trim_excerpt( $text )
{
	if( is_admin() )
	{
		return $text;
	}

	// Fetch the content with filters applied to get <p> tags
	$content = apply_filters( 'the_content', get_the_content() );

	// Stop after the first </p> tag
	$text = substr( $content, 0, strpos( $content, '</p>' ) + 4 );
	return $text;
}

// Leave priority at default of 10 to allow further filtering
add_filter( 'wp_trim_excerpt', 'kawaii_wp_trim_excerpt', 10, 1 );


/* Salko: google fonts will be inlined. Open this and remove inline Roboto if need return old way
function publishable_lite_scripts_styles() 
{
	wp_enqueue_style( 'publishable-mag-fonts', publishable_lite_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'publishable_lite_scripts_styles' );
*/

/**
 * WP Mega Menu Plugin Support
 */
function publishable_lite_megamenu_parent_element( $selector ) {
	return '.primary-navigation .container';
}
add_filter( 'wpmm_container_selector', 'publishable_lite_megamenu_parent_element' );

/**
 * Determines whether the WooCommerce plugin is active or not.
 * @return bool
 */
function publishable_lite_is_wc_active() {
	if ( is_multisite() ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		return is_plugin_active( 'woocommerce/woocommerce.php' );
	} else {
		return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}
}

/**
 * WooCommerce
 */
if ( publishable_lite_is_wc_active() ) {
	if ( !function_exists( 'mts_loop_columns' )) {
        /**
         * Change number or products per row to 3
         *
         * @return int
         */
        function mts_loop_columns() {
            return 3; // 3 products per row
        }
    }
    add_filter( 'loop_shop_columns', 'mts_loop_columns' );

    /**
     * Redefine woocommerce_output_related_products()
     */
    function woocommerce_output_related_products() {
    	$args = array(
    		'posts_per_page' => 3,
    		'columns' => 3,
    		);
        woocommerce_related_products($args); // Display 3 products in rows of 1
    }

    global $pagenow;
    if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
        /**
         * Define WooCommerce image sizes.
         */
        function publishable_lite_woocommerce_image_dimensions() {
        	$catalog = array(
                'width'     => '210',   // px
                'height'    => '155',   // px
                'crop'      => 1        // true
                );
        	$single = array(
                'width'     => '326',   // px
                'height'    => '444',   // px
                'crop'      => 1        // true
                );
        	$thumbnail = array(
                'width'     => '74',    // px
                'height'    => '74',   // px
                'crop'      => 0        // false
                );
            // Image sizes
            update_option( 'shop_catalog_image_size', $catalog );       // Product category thumbs
            update_option( 'shop_single_image_size', $single );         // Single product image
            update_option( 'shop_thumbnail_image_size', $thumbnail );   // Image gallery thumbs
        }
        add_action( 'init', 'publishable_lite_woocommerce_image_dimensions', 1 );
    }


    /**
     * Change the number of product thumbnails to show per row to 4.
     *
     * @return int
     */
    function publishable_lite_woocommerce_thumb_cols() {
     return 4; // .last class applied to every 4th thumbnail
 }
 add_filter( 'woocommerce_product_thumbnails_columns', 'publishable_lite_woocommerce_thumb_cols' );


    /**
     * Ensure cart contents update when products are added to the cart via AJAX.
     *
     * @param $fragments
     *
     * @return mixed
     */
    function publishable_lite_header_add_to_cart_fragment( $fragments ) {
    	global $woocommerce;
    	ob_start(); ?>

    	<a class="cart-contents" href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'publishable-mag' ); ?>"><?php echo sprintf( _n( '%d item', '%d items', $woocommerce->cart->cart_contents_count, 'publishable-mag' ), $woocommerce->cart->cart_contents_count );?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>

    	<?php $fragments['a.cart-contents'] = ob_get_clean();
    	return $fragments;
    }
    add_filter( 'add_to_cart_fragments', 'publishable_lite_header_add_to_cart_fragment' );

    /**
     * Optimize WooCommerce Scripts
     * Updated for WooCommerce 2.0+
     * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
     */
    function publishable_lite_manage_woocommerce_styles() {
        //remove generator meta tag
    	remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

        //first check that woo exists to prevent fatal errors
    	if ( function_exists( 'is_woocommerce' ) ) {
            //dequeue scripts and styles
    		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
    			wp_dequeue_style( 'woocommerce-layout' );
    			wp_dequeue_style( 'woocommerce-smallscreen' );
    			wp_dequeue_style( 'woocommerce-general' );
                wp_dequeue_style( 'wc-bto-styles' ); //Composites Styles
                wp_dequeue_script( 'wc-add-to-cart' );
                wp_dequeue_script( 'wc-cart-fragments' );
                wp_dequeue_script( 'woocommerce' );
                wp_dequeue_script( 'jquery-blockui' );
                wp_dequeue_script( 'jquery-placeholder' );
            }
        }
    }
    add_action( 'wp_enqueue_scripts', 'publishable_lite_manage_woocommerce_styles', 99 );

    // Remove WooCommerce generator tag.
    remove_action('wp_head', 'wc_generator_tag');
}

/**
 * Post Layout for Archives
 */
if ( ! function_exists( 'publishable_lite_archive_post' ) ) {
    /**
     * Display a post of specific layout.
     *
     * @param string $layout
     */
    function publishable_lite_archive_post( $layout = '' ) {
    	$publishable_lite_full_posts = get_theme_mod('publishable_lite_full_posts', '0'); ?>
    	<article class="post excerpt">
    		<?php
    		if ( is_sticky() && is_home() && ! is_paged() ) {
    			printf( '<span class="sticky-post">%s</span>', __( 'Featured', 'publishable-mag' ) );
    		} ?>


    		<?php if ( is_single() ) : ?>

    			<div class="post-date-publishable">
					<?php /* the_time( get_option( 'date_format' ) );*/ ?>
					<?php echo get_the_date(); ?>
				</div>
    		<?php endif; ?>

    		<header>
    			<h2 class="title">
    				<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
    			</h2>

				<!-- publish date salko -->
    			<div class="post-date-publishable">
					<?php echo get_the_date(); ?>
				</div>


    		</header><!--.header salko-->
    		<?php if ( empty($publishable_lite_full_posts) ) : ?>
    			<?php if ( has_post_thumbnail() ) { ?>
    			<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" id="featured-thumbnail">
    				<div class="featured-thumbnail">
						<!-- publishable-mag-featured -->
    					<?php the_post_thumbnail('medium',array('title' => '')); ?>
    					<?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>
    				</div>
    			</a>
    			<?php }
				else  { ?>
    			<?php } ?>


    			<div class="post-content">
    				<?php echo publishable_lite_excerpt(46); /* 56 */ ?>
    			</div>
    			<!-- <xphp publishable_lite_readmore(); x> -->


    		<?php else : ?>
    			<div class="post-content full-post">
    				<?php the_content(); ?>
    			</div>
    			<?php if (publishable_lite_post_has_moretag()) : ?>
    				<?php publishable_lite_readmore(); ?>
    			<?php endif; ?>
    		<?php endif; ?>
    	</article>
    	<?php }
    }






/**
 * Copyright and License for Upsell button by Justin Tadlock - 2016 ?� Justin Tadlock. Customizer button https://gitblogily.com/justintadlock/trt-customizer-pro
 */
require_once( trailingslashit( get_template_directory() ) . 'justinadlock-customizer-button/class-customize.php' );


/**
 * Compare page CSS
 */

function publishable_mag_comparepage_css($hook) {
	if ( 'appearance_page_publishable-mag-info' != $hook ) {
		return;
	}
	wp_enqueue_style( 'publishable-mag-custom-style', get_template_directory_uri() . '/css/compare.css' );
}
add_action( 'admin_enqueue_scripts', 'publishable_mag_comparepage_css' );



function debug_has_cap_calls() {
    add_action('deprecated_argument_run', function($function, $message, $version) {
        if ($function === 'has_cap' && strpos($message, 'user levels') !== false) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);
            error_log('Deprecated has_cap call detected. Backtrace: ' . print_r($backtrace, true));
        }
    }, 10, 3);
}
add_action('init', 'debug_has_cap_calls');




/**
 * Compare page content
 */

add_action('admin_menu', 'publishable_mag_themepage');
function publishable_mag_themepage(){
	$theme_info = add_theme_page( __('Publishable Mag','publishable-mag'), __('Publishable Mag','publishable-mag'), 'manage_options', 'publishable-mag-info.php', 'publishable_mag_info_page' );
}

function publishable_mag_info_page() {
	$user = wp_get_current_user();
	?>
	<div class="wrap about-wrap publishable-mag-add-css">
		<div>
			<h1>
				<?php echo esc_html_e('Welcome to Publishable Mag!','publishable-mag'); ?>
			</h1>

			<div class="feature-section three-col">
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo esc_html_e("Contact Support", "publishable-mag"); ?></h3>
						<p><?php echo esc_html_e("Getting started with a new theme can be difficult, if you have issues with Publishable Mag then throw us an email.", "publishable-mag"); ?></p>
						<p><a target="blank" href="<?php echo esc_url('https://superbthemes.com/help-contact/', 'publishable-mag'); ?>" class="button button-primary">
							<?php echo esc_html_e("Contact Support", "publishable-mag"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo esc_html_e("View our other themes", "publishable-mag"); ?></h3>
						<p><?php echo esc_html_e("Do you like our concept but feel like the design doesn't fit your need? Then check out our website for more designs.", "publishable-mag"); ?></p>
						<p><a target="blank" href="<?php echo esc_url('https://superbthemes.com/wordpress-themes/', 'publishable-mag'); ?>" class="button button-primary">
							<?php echo esc_html_e("View All Themes", "publishable-mag"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo esc_html_e("Premium Edition", "publishable-mag"); ?></h3>
						<p><?php echo esc_html_e("If you enjoy Publishable Mag and want to take your website to the next step, then check out our premium edition here.", "publishable-mag"); ?></p>
						<p><a target="blank" href="<?php echo esc_url('https://superbthemes.com/publishable-mag/', 'publishable-mag'); ?>" class="button button-primary">
							<?php echo esc_html_e("Read More", "publishable-mag"); ?>
						</a></p>
					</div>
				</div>
			</div>
		</div>
		<hr>

		<h2><?php echo esc_html_e("Free Vs Premium","publishable-mag"); ?></h2>
		<div class="publishable-mag-button-container">
			<a target="blank" href="<?php echo esc_url('https://superbthemes.com/publishable-mag/', 'publishable-mag'); ?>" class="button button-primary">
				<?php echo esc_html_e("Read Full Description", "publishable-mag"); ?>
			</a>
			<a target="blank" href="<?php echo esc_url('https://superbthemes.com/demo/publishable-mag/', 'publishable-mag'); ?>" class="button button-primary">
				<?php echo esc_html_e("View Theme Demo", "publishable-mag"); ?>
			</a>
		</div>


		<table class="wp-list-table widefat">
			<thead>
				<tr>
					<th><strong><?php echo esc_html_e("Theme Feature", "publishable-mag"); ?></strong></th>
					<th><strong><?php echo esc_html_e("Basic Version", "publishable-mag"); ?></strong></th>
					<th><strong><?php echo esc_html_e("Premium Version", "publishable-mag"); ?></strong></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?php echo esc_html_e("Page Background Image", "publishable-mag"); ?></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Header Background Image & Logo Image / Text", "publishable-mag"); ?></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Excerpts/Full Posts on Homepage", "publishable-mag"); ?></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>

				<tr>
					<td><?php echo esc_html_e("Premium Support", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Post Widgets Extended", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Custom Primary Color	", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Numbered Pagination", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Custom Primary Color", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Improved Search Engine Optimizaiton (SEO)", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("More Language Meta Data", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("SEO Plugins & Page Speed Plugins", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Custom Header Background Color", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Custom Copyright Text	", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Fullwidth Mode	", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Right or Left Sidebar", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Next/Previous Pagination", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Hide/Show Breadcrumbs	", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Hide/Show Tags Section", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Hide/Show Related Posts", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html_e("Hide/Show Author Box", "publishable-mag"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo esc_html_e("No", "publishable-mag"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo esc_html_e("Yes", "publishable-mag"); ?>" /></span></td>
				</tr>
			</tbody>
		</table>

	</div>
	<?php
}
