<?php
add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname, $default_colorscheme;
		$themename = "DailyNotes";
		$shortname = "dailynotes";
		$default_colorscheme = "Default";

		$template_dir = get_template_directory();

		require_once($template_dir . '/epanel/core_functions.php');

		require_once($template_dir . '/epanel/custom_functions.php');

		require_once($template_dir . '/includes/functions/comments.php');

		require_once($template_dir . '/includes/functions/sidebars.php');

		load_theme_textdomain('DailyNotes',$template_dir.'/lang');

		require_once($template_dir . '/includes/post_thumbnails_dailynotes.php');

		require_once($template_dir . '/includes/functions/custom_posts.php');

		remove_action( 'admin_init', 'et_epanel_register_portability' );

		add_action( 'pre_get_posts', 'et_posts_query' );

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

/**
 * Filters the main query
 */
function et_posts_query( $query = false ) {
	/* Don't proceed if it's not homepage or the main query */
	if ( is_admin() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() ) return;

	/* Set the amount of posts per page on homepage */
	if ( is_home() ) $query->set( 'posts_per_page', (int) et_get_option( 'dailynotes_homepage_posts', '6' ) );

	if ( ! is_singular() ) $query->set( 'post_type', array( 'note', 'photo', 'quote', 'video', 'customlink', 'audio', 'post' ) );
}

add_action('wp_head','et_portfoliopt_additional_styles',100);
function et_portfoliopt_additional_styles(){ ?>
	<style type="text/css">
		#et_pt_portfolio_gallery { margin-left: -15px; }
		.et_pt_portfolio_item { margin-left: 21px; width: 192px; }
		.et_portfolio_small { margin-left: -40px !important; }
		.et_portfolio_small .et_pt_portfolio_item { margin-left: 32px !important; }
		.et_portfolio_large { margin-left: -10px !important; }
		.et_portfolio_large .et_pt_portfolio_item { margin-left: 15px !important; }

		.et_portfolio_more_icon, .et_portfolio_zoom_icon { top: 49px; }
		.et_portfolio_more_icon { left: 54px; }
		.et_portfolio_zoom_icon { left: 95px; }
		.et_portfolio_small .et_pt_portfolio_item { width: 102px; }
		.et_portfolio_small .et_portfolio_more_icon { left: 11px; }
		.et_portfolio_small .et_portfolio_zoom_icon { left: 49px; }
		.et_portfolio_large .et_pt_portfolio_item { width: 312px; }
		.et_portfolio_large .et_portfolio_more_icon, .et_portfolio_large .et_portfolio_zoom_icon { top: 85px; }
		.et_portfolio_large .et_portfolio_more_icon { left: 119px; }
		.et_portfolio_large .et_portfolio_zoom_icon { left: 158px; }
	</style>
<?php }

function register_main_menus() {
	register_nav_menus( array(
		'primary-menu' => 'Primary Navigation', 'DailyNotes'
	) );
};
if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );

add_filter( 'et_fullpath', 'et_change_fullpath' );
function et_change_fullpath( $thumb ){
	global $post;
	if ( is_page() ) return $thumb;
	if ( get_post_meta( $post->ID, 'thumb', true ) ) $thumb = get_post_meta( $post->ID, 'thumb', true );
	return $thumb;
}

if ( ! function_exists( 'et_list_pings' ) ){
	function et_list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
	<?php }
}

add_action( 'admin_enqueue_scripts', 'upload_categories_scripts_fwdelete' );
function upload_categories_scripts_fwdelete( $hook_suffix ) {
	if ( in_array($hook_suffix, array('post.php','post-new.php')) ) {
		wp_enqueue_script('et-ptemplates-fwdelete', get_bloginfo('template_directory') . '/js/delete_fwidth.js', array('jquery'), '1.1', false);
	}
}

function et_epanel_custom_colors_css(){
	global $shortname; ?>

	<style type="text/css">
		#body, .post div.url div div, .post div.url span { color: #<?php echo esc_html(get_option($shortname.'_color_mainfont')); ?>; }
		a { color: #<?php echo esc_html(get_option($shortname.'_color_mainlink')); ?>; }
		ul.nav li a { color: #<?php echo esc_html(get_option($shortname.'_color_pagelink')); ?>; }
		ul.nav li a:hover { color: #<?php echo esc_html(get_option($shortname.'_color_pagelink_active')); ?>; }
		.post div h2, .big_post h1, .main_post h1  { color: #<?php echo esc_html(get_option($shortname.'_color_headings')); ?>; }
		div#footer { color:#<?php echo esc_html(get_option($shortname.'_footer_text')); ?> }
		#footer a, #footer a:visited { color:#<?php echo esc_html(get_option($shortname.'_color_footerlinks')); ?>; }
		.big_quote, .big_quote2 { color: #<?php echo esc_html(get_option($shortname.'_color_quote')); ?>; }
		.post_info, .post_info a, .post_info a:hover, .main_postinfo, .main_postinfo a, .main_postinfo a:hover { color: #<?php echo esc_html(get_option($shortname.'_color_postinfo')); ?>; }
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

