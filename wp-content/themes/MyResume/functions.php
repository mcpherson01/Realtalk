<?php
add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname, $default_colorscheme;
		$themename = "MyResume";
		$shortname = "myresume";
		$default_colorscheme = "Grey";

		$template_dir = get_template_directory();

		require_once($template_dir . '/epanel/custom_functions.php');

		require_once($template_dir . '/includes/functions/sidebars.php');

		require_once($template_dir . '/epanel/core_functions.php');

		require_once($template_dir . '/includes/post_thumbnails_myresume.php');

		include($template_dir . '/includes/widgets.php');

		remove_action( 'admin_init', 'et_epanel_register_portability' );

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

if ( ! function_exists( 'portImage' ) ){
	function portImage($atts, $content = null) {
		return '<a class="gallery-item" href="'. et_new_thumb_resize( et_multisite_thumbnail(esc_attr($content)), 600, 500, '', true ) .'" rel="'.et_new_thumb_resize( et_multisite_thumbnail(esc_attr($content)), 388, 222, '', true ).'"><img src="'.et_new_thumb_resize( et_multisite_thumbnail(esc_attr($content)), 59, 59, '', true ).'" alt="" /></a>';
	};
}
add_shortcode("portfolio", "portImage");

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
		#inside a { color: #<?php echo esc_html(get_option($shortname.'_color_mainlink')); ?>; }
		#inside a:hover { color: #<?php echo esc_html(get_option($shortname.'_color_mainlink_hover')); ?>; }
		#header ul li a { color: #<?php echo esc_html(get_option($shortname.'_color_pagelink')); ?>; }
		#header ul li a:hover { color: #<?php echo esc_html(get_option($shortname.'_color_pagelink_hover')); ?>; }
		#header ul li.active a { color: #<?php echo esc_html(get_option($shortname.'_color_pagelink_active')); ?>; }
		h2 { color: #<?php echo esc_html(get_option($shortname.'_color_headings')); ?>; }
		#footer, #footer a {color: #<?php echo esc_html(get_option($shortname.'_footer_text')); ?>; }
		.entry ul li { color: #<?php echo esc_html(get_option($shortname.'_color_list')); ?>; }
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

