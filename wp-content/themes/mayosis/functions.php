<?php
/**
 * Mayosis Digital Marketplace Theme
 *
 * This is Theme Functions File
 * @package mayosis
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
// Set our theme version.
define('GENERATE_VERSION', '2.6.2');
// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////        Menu Register                 ////////////////////////////////
// //////////////////////////////////////////////////////////////////////////////////////////
function mayosis_main_menu()
{
    register_nav_menus(array(
        'main-menu' => esc_html__('Main Menu', 'mayosis'),
        'top-menu' => esc_html__('Top Menu', 'mayosis'),
        'bottom-menu' => esc_html__('Bottom Menu', 'mayosis'),
        'mobile-menu' => esc_html__('Mobile Menu', 'mayosis'),
        'account-menu' => esc_html__('Account Menu', 'mayosis')
    ));
}
add_action('init', 'mayosis_main_menu');
// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////        Include Theme Files                 //////////////////////////
// //////////////////////////////////////////////////////////////////////////////////////////

require get_theme_file_path('admin/admin-init.php');
require get_theme_file_path('admin/mayosis-demo-import.php');
require get_theme_file_path('admin/mayosis-admin-helper.php');
require get_theme_file_path('library/widget.php');
require get_theme_file_path('library/edd.php');
require get_theme_file_path('library/breadcrumb.php');
require get_theme_file_path('library/acf.php');
require get_theme_file_path('library/acf_fallback.php');
require get_theme_file_path('library/mayosis_comment.php');
require get_theme_file_path('library/post_format.php');
require get_theme_file_path('library/mayosis_navwalker.php');
require get_theme_file_path('library/mayosis-accordion-navalker.php');
require get_theme_file_path('library/mayosis_classes.php');
if (class_exists('mayosis_core')){
require get_theme_file_path('library/thumb-custom-size.php');
require get_theme_file_path('library/mayosis_js.php');
}



// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////        Enqueues scripts and styles         /////////////////////////
// //////////////////////////////////////////////////////////////////////////////////////////
add_action('wp_enqueue_scripts', 'mayosis_scripts');
function mayosis_scripts()
{
  
	// Theme stylesheet.
    wp_enqueue_style('mayosis-style', get_stylesheet_uri());
    wp_enqueue_style('mayosis-essential', get_template_directory_uri() . '/css/essential.css');
	wp_enqueue_style( 'mayosis-plyr-style', get_template_directory_uri() . '/css/plyr.css' ); 
	wp_enqueue_style( 'mayosis-main-style', get_template_directory_uri() . '/css/main.min.css' ); 
    wp_style_add_data( 'mayosis-main-style', 'rtl', 'replace' ); 
    
	// Zero Icon.
    wp_enqueue_style('zeroicon-line', get_template_directory_uri() . '/css/zero-icon-line.css');
    
    


   if (class_exists('WPBakeryShortCode')):
       	// Page Builder Font Icon.
    wp_enqueue_style('font-awesome');
   endif;
	
    wp_enqueue_script('bootstarp', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ) , '1.0', true);
    wp_enqueue_script('smoothscroll', get_template_directory_uri() . '/js/smoothscroll.min.js', array(), '1.1', true);
    
	wp_enqueue_script( 'html5', get_theme_file_uri( '/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
	
	//Enqueue hoverIntent
	wp_enqueue_script( 'hoverIntent' );
	
	// Theme Jquery.
    wp_enqueue_script('mayosis-theme', get_template_directory_uri() . '/js/theme.min.js', array('jquery'), '1.0', true);
    wp_enqueue_script('mayosis-yoututbe', get_template_directory_uri() . '/js/youtube.min.js', array(), '1.0', true);
    wp_enqueue_script('easing', get_template_directory_uri() . '/js/jquery.easing.min.js', array( 'jquery' ), '1.4.1', true);
    
    wp_enqueue_script('lity', get_template_directory_uri() . '/js/lity.min.js', array( 'jquery' ), '1.0.1', true);
    wp_enqueue_script('mayosis-isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array(), '1.5.6', true);
      
     wp_enqueue_script('mayosis-smart-sticky', get_template_directory_uri() . '/js/sticky.js', array(), '1.0', true);
     
     wp_enqueue_script('mayosis-essential', get_template_directory_uri() . '/js/essential-theme.js', array(), '1.0', true);
     
     wp_enqueue_script('mayosis-sticky-social', get_template_directory_uri() . '/js/sticky-sidebar-min.js', array(), '1.0', true);
     
     wp_enqueue_script('mayosis-fontsampler', get_template_directory_uri() . '/js/fontsampler.min.js', array('jquery'), '1.0', true);
    wp_enqueue_script('mayosis-fontimage', get_template_directory_uri() . '/js/text-image.js', array('jquery'), '1.0', true);
     
        
	// Modernizr.
    wp_enqueue_script('modernizr', get_template_directory_uri('jquery') . '/js/modernizr.js', array(), '2.7.1', true);
      
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    wp_enqueue_script('mayosis-video-plyr', get_template_directory_uri() . '/js/plyr.min.js', array('jquery'), '1.1', true);
    
     wp_enqueue_script('mayosis-imageloaded', get_template_directory_uri() . '/js/jquery.image.loaded.js', array(), '4.1.4', true);
  
   // Object parallax
        wp_enqueue_script('mayosis-parallax', get_template_directory_uri() . '/js/jquery.parallax-scroll.js', array('jquery'), '1.1', true);
      wp_enqueue_script('mayosis-object', get_template_directory_uri() . '/js/parallax.hover.js', array('jquery'), '1.5', true);

    
    wp_enqueue_script('mayosis-lightslider', get_template_directory_uri() . '/js/gallery.min.js',  array(), '1.1', true);
    
    wp_enqueue_script('mayosis-product-gallery', get_template_directory_uri() . '/js/gallery.main.js', array(), '0.9.4', true);

	
    
     /**
 * Enqueue jQuery Cookie
 */
     
if (class_exists('Easy_Digital_Downloads') && function_exists('EDD_FES') && is_page(EDD_FES()->helper->get_option('fes-vendor-dashboard-page', false))) {
    if (isset($_GET['task']) && 'products' === $_GET['task']) {
        wp_enqueue_script('mayosis-cookie-js', get_template_directory_uri() . '/js/jquery.cookie.js', array('jquery'), '1.4.1', true);
    }
}

}

#-----------------------------------------------------------------#
# Register/Enqueue JS/CSS In Admin Panel
#-----------------------------------------------------------------#
function mayosis_register_admin_styles()
{
    wp_enqueue_style('mayosis-admin-css', get_template_directory_uri() . '/css/admin.css');
    
    wp_enqueue_script('mayosis-admin-js', get_template_directory_uri() . '/js/admin.js', array('jquery'), '0.9.4', true);
     
}
add_action('admin_enqueue_scripts', 'mayosis_register_admin_styles');
// Menu Fallback
function mayosis_default_menu()
{
    get_template_part('includes/fallback-menu.php');
}

#-----------------------------------------------------------------#
# MEJS CUSTOM STYLES
#-----------------------------------------------------------------#
add_action( 'wp_print_footer_scripts', 'mayosis_mejs_custom_class' );

function mayosis_mejs_custom_class() {
	if ( ! wp_script_is( 'mediaelement', 'done' ) ) {
		return;
	}
	?>
	<script>
	(function() {
		var settings = window._wpmejsSettings || {};
		settings.features = settings.features || mejs.MepDefaults.features;
		settings.features.push( 'exampleclass' );
		MediaElementPlayer.prototype.buildexampleclass = function( player ) {
			player.container.addClass( 'mayosis-mejs-container' );
		};
	})();
	</script>
	<?php
}

// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////   AJAX URL  /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////
if( ! function_exists( 'mayosis_ajax' ) ){
  function mayosis_ajax() {
    ?>
    <script type="text/javascript">
      var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
    <?php
  }
}
add_action('wp_head','mayosis_ajax');
/*
 * Globals
 */
function mayosis_global_var()
{
    global $global_var;
    return $global_var;
}
$get_my_global_var = mayosis_global_var();
echo esc_html($get_my_global_var['opt_name']);
if (!isset($content_width)) {
    $content_width = 600;
}
// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////         Dynamic Css                 ////////////////////////////////
// //////////////////////////////////////////////////////////////////////////////////////////
/**
 * Include Dynamic css
 */
include_once('css/mayosis_custom_css_loader.php');
// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////         WP Core Functionality        ////////////////////////////////
// //////////////////////////////////////////////////////////////////////////////////////////
add_theme_support('post-thumbnails');
add_image_size('mayosis-product-thumb-small', 170, 170, true);
add_image_size('mayosis-product-grid-small', 150, 100, true);
add_theme_support('custom-background');
add_theme_support('custom-header');
add_theme_support('automatic-feed-links');
add_theme_support('title-tag');
add_post_type_support('attachment:audio', 'thumbnail');
add_post_type_support('attachment:video', 'thumbnail');
add_filter('wpcf7_form_elements', 'do_shortcode');
add_theme_support('title-tag');
// Fixing the edd schema
add_filter('edd_add_schema_microdata', '__return_false');

/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption'
));
add_post_type_support('download', 'post-formats');
/*
 * Enable support for Post Formats.
 *
 * See: https://codex.wordpress.org/Post_Formats
 */
add_theme_support('post-formats', array(
    'aside',
    'image',
    'video',
    'gallery',
    'audio'
));
add_theme_support('customize-selective-refresh-widgets');
function mayosis_disable_acf_on_frontend($plugins)
{
    if (is_admin())
        return $plugins;
    foreach ($plugins as $i => $plugin)
        if ('advanced-custom-fields-pro/acf.php' == $plugin)
            unset($plugins[$i]);
    return $plugins;
}
add_filter('option_active_plugins', 'mayosis_disable_acf_on_frontend');

/**
* Add support for Gutenberg.
*
* @link https://wordpress.org/gutenberg/handbook/reference/theme-support/
*/
function mayosis_gutenberg_features() {
		
		// Theme supports wide images, galleries and videos.
		add_theme_support( 'align-wide' );
		
		// Make specific theme colors available in the editor.
    add_theme_support( 'editor-color-palette', array(
	array(
		'name'  => __( 'Light gray', 'mayosis' ),
		'slug'  => 'light-gray',
		'color'	=> '#f5f5f5',
	),
	array(
		'name'  => __( 'Medium gray', 'mayosis' ),
		'slug'  => 'medium-gray',
		'color' => '#999',
	),
	array(
		'name'  => __( 'Dark gray', 'mayosis' ),
		'slug'  => 'dark-gray',
		'color' => '#222a36',
       ),
       
       array(
		'name'  => __( 'Purple', 'mayosis' ),
		'slug'  => 'purple',
		'color' => '#5a00f0',
       ),
       
        array(
		'name'  => __( 'Dark Blue', 'mayosis' ),
		'slug'  => 'dark-blue',
		'color' => '#28375a',
       ),
       
        array(
		'name'  => __( 'Red', 'mayosis' ),
		'slug'  => 'red',
		'color' => '#c44d58',
       ),
       
       array(
		'name'  => __( 'Yellow', 'mayosis' ),
		'slug'  => 'yellow',
		'color' => '#ecca2e',
       ),
       
        array(
		'name'  => __( 'Green', 'mayosis' ),
		'slug'  => 'green',
		'color' => '#64a500',
       ),
       
       array(
		'name'  => __( 'White', 'mayosis' ),
		'slug'  => 'white',
		'color' => '#ffffff',
       ),
) );

add_theme_support( 'editor-font-sizes', array(
    array(
        'name' => __( 'Small', 'mayosis' ),
        'size' => 14,
        'slug' => 'small'
    ),
    array(
        'name' => __( 'Normal', 'mayosis' ),
        'size' => 16,
        'slug' => 'normal'
    ),
    array(
        'name' => __( 'Large', 'mayosis' ),
        'size' => 26,
        'slug' => 'large'
    ),
    array(
        'name' => __( 'Huge', 'mayosis' ),
        'size' => 36,
        'slug' => 'huge'
    )
) );
add_theme_support( 'wp-block-styles' );
add_theme_support( 'editor-styles' );
add_editor_style( 'style-editor.css' );
add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'mayosis_gutenberg_features' );



// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////        Registers an editor stylesheet for the theme.       ////////////////////////////////
// //////////////////////////////////////////////////////////////////////////////////////////
function mayosis_theme_add_editor_styles()
{
    add_editor_style('custom-editor-style.css');
}
add_action('admin_init', 'mayosis_theme_add_editor_styles');
// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////         WP Language Functionality        ////////////////////////////////
// //////////////////////////////////////////////////////////////////////////////////////////
if (!function_exists('mayosis_theme_setup')) {
    function mayosis_theme_setup()
    {
        load_theme_textdomain('mayosis', get_template_directory() . '/languages');
    }
}
add_action('after_setup_theme', 'mayosis_theme_setup');
// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////     Comment On Download     /////////////////////////////////////////
// //////////////////////////////////////////////////////////////////////////////////////////
function mayosis_edd_add_comments_support($supports)
{
    $supports[] = 'comments';
    return $supports;
}
add_filter('edd_download_supports', 'mayosis_edd_add_comments_support');
// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////  mayosis PAGINATION  /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////
if (!function_exists('mayosis_page_navs')): /**
 * Displays post pagination links
 *
 * @since mayosis 1.0
 */ 
    function mayosis_page_navs($query = false)
    {
        global $wp_query;
        if ($query) {
            $temp_query = $wp_query;
            $wp_query   = $query;
        }
        // Return early if there's only one page.
        if ($GLOBALS['wp_query']->max_num_pages < 2) {
            return;
        }
?>
	<div class="common-paginav text-center">
	<div class="pagination">
		<?php
        $big = 999999999; // need an unlikely integer
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages,
            'prev_text' => 'Previous',  
            'next_text' => 'Next'  
        ));
?>
	</div>
	</div>
	<?php
        if (isset($temp_query)) {
            $wp_query = $temp_query;
        }
    }
endif;
// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////   DOWNLOAD CATEGORY DROPDOWN  /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////
function mayosis_get_terms_dropdown($taxonomies, $args)
{
    $myterms = get_terms($taxonomies, $args);
    $output  = "<div class='download_cat_filter '><select name='download_cats'>";
    $output .= "<option value='all'>" . esc_html__("All", "mayosis") . "</option>";
    foreach ($myterms as $term) {
        $term_name = $term->name;
        $slug      = $term->slug;
        $output .= "<option value='" . $slug . "'>" . $term_name . "</option>";
    }
    $output .= "</select></div>";
    return $output;
}


function mayosis_vendor_cat_dropdown($taxonomies, $args)
{
    $myterms = get_terms($taxonomies, $args);
    $output  = "<div class='mayosis_vendor_cat'><select name='download_cats'>";
    $output .= "<option value='all'>" . esc_html__("All", "mayosis") . "</option>";
    foreach ($myterms as $term) {
        $term_name = $term->name;
        $slug      = $term->slug;
        $output .= "<option value='" . $slug . "'>" . $term_name . "</option>";
    }
    $output .= "</select></div>";
    return $output;
}



add_filter('edd_has_variable_price', 'special_nav_class', 10, 2);
function mayosis_excerpt($limit)
{
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . '...';
    } else {
        $excerpt = implode(" ", $excerpt);
    }
    $excerpt = preg_replace('`[[^]]*]`', '', $excerpt);
    return $excerpt;
}
function mayosis_content($limit)
{
    $content = explode(' ', get_the_content(), $limit);
    if (count($content) >= $limit) {
        array_pop($content);
        $content = implode(" ", $content) . '...';
    } else {
        $content = implode(" ", $content);
    }
    $content = preg_replace('/[.+]/', '', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}
function mayosis_description($limit)
{
    $description = explode(' ', the_author_meta('description'), $limit);
    if (count($description) >= $limit) {
        array_pop($description);
        $description = implode(" ", $description) . '...';
    } else {
        $description = implode(" ", $description);
    }
    $description = preg_replace('`[[^]]*]`', '', $description);
    return $description;
}
// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////   SHORT TITLE  /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////
function mayosis_short_title($after = '', $length)
{
    $mytitle = explode(' ', get_the_title(), $length);
    if (count($mytitle) >= $length) {
        array_pop($mytitle);
        $mytitle = implode(" ", $mytitle) . $after;
    } else {
        $mytitle = implode(" ", $mytitle);
    }
    return $mytitle;
}



// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////   HEX to RGB  /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_hexto_rgb($color, $opacity = false) {

$default = 'rgb(0,0,0)';

//Return default if no color provided
if(empty($color))
return $default;

//Sanitize $color if "#" is provided
if ($color[0] == '#' ) {
$color = substr( $color, 1 );
}

//Check if color has 6 or 3 characters and get values
if (strlen($color) == 6) {
$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
} elseif ( strlen( $color ) == 3 ) {
$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
} else {
return $default;
}

$rgb =  array_map('hexdec', $hex);

//Check if opacity is set(rgba or rgb)
if($opacity){
if(abs($opacity) > 1)
$opacity = 1.0;
$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
} else {
$output = 'rgb('.implode(",",$rgb).')';
}

//Return rgb(a) color string
return $output;
}




add_filter( 'wp_nav_menu_items', 'mayosis_account_logout', 10, 2 );
function mayosis_account_logout( $items, $args ) {
    if (is_user_logged_in() && $args->theme_location == 'account-menu') {
        $items .= '<li class="menu-item"><a href="'. wp_logout_url(home_url('/')) .'">'.__( 'Log Out', 'mayosis').'</a></li>';
    }
 
    return $items;
}

  add_filter('upload_mimes', 'add_custom_upload_mimes');
  function add_custom_upload_mimes($existing_mimes) {
  	$existing_mimes['otf'] = 'application/x-font-otf';
  	$existing_mimes['woff'] = 'application/x-font-woff';
  	$existing_mimes['woff2'] = 'application/x-font-woff';
  	$existing_mimes['ttf'] = 'application/x-font-ttf';
  	$existing_mimes['svg'] = 'image/svg+xml';
  	$existing_mimes['eot'] = 'application/vnd.ms-fontobject';
  	return $existing_mimes;
  }

