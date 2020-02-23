<?php
add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname, $default_colorscheme;
		$themename = "Deviant";
		$shortname = "deviant";
		$default_colorscheme = "Red";

		$template_dir = get_template_directory();

		require_once($template_dir . '/epanel/custom_functions.php');

		require_once($template_dir . '/includes/functions/comments.php');

		require_once($template_dir . '/includes/functions/sidebars.php');

		load_theme_textdomain('Deviant',$template_dir.'/lang');

		require_once($template_dir . '/epanel/core_functions.php');

		require_once($template_dir . '/includes/post_thumbnails_deviant.php');

		include($template_dir . '/includes/widgets.php');

		remove_action( 'admin_init', 'et_epanel_register_portability' );

		add_action( 'pre_get_posts', 'et_home_posts_query' );

		add_theme_support( 'title-tag' );
	}
}

if ( ! function_exists( '_wp_render_title_tag' ) ) :
/**
 * Manually add <title> tag in head for WordPress 4.1 below for backward compatibility
 * Title tag is automatically added for WordPress 4.1 above via theme support
 * @return void
 */
	function et_add_title_tag_back_compat() { ?>
		<title><?php wp_title( '-', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'et_add_title_tag_back_compat' );
endif;

function register_main_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu', 'Deviant' )
		)
	);
};
if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );

/**
 * Filters the main query on homepage
 */
function et_home_posts_query( $query = false ) {
	/* Don't proceed if it's not homepage or the main query */
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() ) return;

	/* Set the amount of posts per page on homepage */
	$query->set( 'posts_per_page', (int) et_get_option( 'deviant_homepage_posts', '6' ) );

	/* Exclude categories set in ePanel */
	$exclude_categories = et_get_option( 'deviant_exlcats_recent', false );
	if ( $exclude_categories ) $query->set( 'category__not_in', array_map( 'intval', et_generate_wpml_ids( $exclude_categories, 'category' ) ) );
}

if ( ! function_exists( 'et_list_pings' ) ){
	function et_list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
	<?php }
}

function et_epanel_custom_colors_css(){
	global $shortname; ?>

	<style type="text/css">
		body { color: #<?php echo esc_html(get_option($shortname.'_color_mainfont')); ?>; }
		a:link, a:visited { color: #<?php echo esc_html(get_option($shortname.'_color_mainlink')); ?>; }
		#wrapper .content #mainDiv .links ul.nav_links li a { color: #<?php echo esc_html(get_option($shortname.'_color_pagelink')); ?>; }
		#wrapper .content #mainDiv .links ul.nav_links li:hover , #wrapper .content #mainDiv .links ul.nav_links li.sfHover, #wrapper .content #mainDiv .links ul.nav_links li a:hover{ color: #<?php echo esc_html(get_option($shortname.'_color_pagelink_hover')); ?>; }
		#wrapper #sidebarDiv .categories h2, #wrapper #sidebarDiv .widget .tablinks ul li a { color: #<?php echo esc_html(get_option($shortname.'_color_sidebar_titles')); ?>; }
		#wrapper .content #mainDiv .post .post_mid h1 a, #wrapper .content #mainDiv .post .post_mid h1, #wrapper .content #mainDiv .posts .mainpost .content_wrapper .post_content h2 a, #wrapper .content #mainDiv .posts .subposts .sub_post_wrapper h2 a, #wrapper .content #mainDiv .comment .comment_mid h2, #respond h3 { color: #<?php echo esc_html(get_option($shortname.'_color_heading')); ?>; }
		#wrapper .content #mainDiv .post .post_mid h1, #wrapper .content #mainDiv .comment .comment_mid h2, #wrapper .content #mainDiv .posts .mainpost .content_wrapper .post_content h2 a, #wrapper .content #mainDiv .posts .subposts .sub_post_wrapper h2 a, #respond h3 { background-color: #<?php echo esc_html(get_option($shortname.'_color_heading_bg')); ?>; }
		#wrapper .content #mainDiv .posts .mainpost .content_wrapper .post_content h2 a:hover, #wrapper .content #mainDiv .posts .subposts .sub_post_wrapper h2 a:hover{ background-color: #<?php echo esc_html(get_option($shortname.'_color_heading_bg_hover')); ?>; }
		#wrapper #sidebarDiv .categories ul li a, #wrapper #sidebarDiv .widget .widget_content ul li p.title a { color: #<?php echo esc_html(get_option($shortname.'_color_sidebar_links')); ?>; }
		#wrapper #sidebarDiv .categories ul li a:hover, #wrapper #sidebarDiv .widget .widget_content ul li p.title a:hover { color: #<?php echo esc_html(get_option($shortname.'_color_sidebar_links_hover')); ?>; }
		#wrapper #sidebarDiv .categories { color: #<?php echo esc_html(get_option($shortname.'_color_sidebar_text')); ?>; }
		#wrapper .content #mainDiv .post .post_details .info a, #wrapper .content #mainDiv .post .post_details .info span, #wrapper .content #mainDiv .posts .mainpost .post_details .info p a, #wrapper .content #mainDiv .posts .mainpost .post_details .info p { color: #<?php echo esc_html(get_option($shortname.'_color_postinfo_font')); ?>; }
		#wrapper .content #mainDiv .posts .mainpost .content_wrapper .post_content p { color: #<?php echo esc_html(get_option($shortname.'_color_quote')); ?>; }
	</style>

<?php }

function et_remove_additional_epanel_styles() {
	return true;
}
add_filter( 'et_epanel_is_divi', 'et_remove_additional_epanel_styles' );

function et_register_updates_component() {
	require_once( get_template_directory() . '/core/updates_init.php' );

	et_core_enable_automatic_updates( get_template_directory_uri(), et_get_theme_version() );
}
add_action( 'admin_init', 'et_register_updates_component' );

if ( ! function_exists( 'et_core_portability_link' ) && ! class_exists( 'ET_Builder_Plugin' ) ) :
function et_core_portability_link() {
	return '';
}
endif;

function et_theme_maybe_load_core() {
	if ( et_core_exists_in_active_plugins() ) {
		return;
	}

	if ( defined( 'ET_CORE' ) ) {
		return;
	}

	require_once get_template_directory() . '/core/init.php';

	et_core_setup( get_template_directory_uri() );
}
add_action( 'after_setup_theme', 'et_theme_maybe_load_core' );

