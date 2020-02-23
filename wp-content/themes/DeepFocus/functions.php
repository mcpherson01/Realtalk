<?php
add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname, $default_colorscheme;
		$themename = "DeepFocus";
		$shortname = "deepfocus";
		$default_colorscheme = "Default";

		$template_dir = get_template_directory();

		require_once($template_dir . '/epanel/custom_functions.php');

		require_once( $template_dir . '/includes/functions/sanitization.php' );

		require_once($template_dir . '/includes/functions/comments.php');

		require_once($template_dir . '/includes/functions/sidebars.php');

		load_theme_textdomain('DeepFocus',$template_dir.'/lang');

		require_once($template_dir . '/epanel/core_functions.php');

		require_once($template_dir . '/includes/post_thumbnails_deepfocus.php');

		include($template_dir . '/includes/widgets.php');

		remove_action( 'admin_init', 'et_epanel_register_portability' );

		add_filter( 'et_print_thumbnail_dimensions', 'et_single_post_thumbnail_dimensions' );
		function et_single_post_thumbnail_dimensions( $dimensions ){
			if ( false !== strpos( $dimensions, '9999' ) ) $dimensions = '';
			return $dimensions;
		}

		add_action( 'wp_enqueue_scripts', 'et_add_responsive_shortcodes_css', 11 );

		add_action( 'pre_get_posts', 'et_home_posts_query' );

		add_action( 'et_epanel_changing_options', 'et_delete_featured_ids_cache' );
		add_action( 'delete_post', 'et_delete_featured_ids_cache' );
		add_action( 'save_post', 'et_delete_featured_ids_cache' );

		add_action( 'wp_enqueue_scripts', 'et_deepfocus_load_scripts_styles' );

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

add_action('wp_head','et_portfoliopt_additional_styles',100);
function et_portfoliopt_additional_styles(){ ?>
	<style type="text/css">
		div.pp_default .pp_content_container .pp_details { color: #666; }
	</style>
<?php }

function et_insert_thumbnail_rss($content) {
	$thumb = ''; $thumb = get_post_meta(get_the_ID(), 'Thumbnail',true);

	if ( has_post_thumbnail( get_the_ID() ) ){
		$content = '<p>' . get_the_post_thumbnail( get_the_ID(), 'medium' ) . '</p>' . $content;
	} else if ($thumb <> '') {
		$content = '<p>' . '<img src="'. esc_attr( et_new_thumb_resize( et_multisite_thumbnail($thumb), 300, 200, '', true ) ) .'"/>' . '</p>' . $content;
	}

	return $content;
}
add_filter('the_excerpt_rss', 'et_insert_thumbnail_rss');
add_filter('the_content_feed', 'et_insert_thumbnail_rss');

function register_main_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu', 'DeepFocus' )
		)
	);
}
if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );

if ( ! function_exists( 'et_list_pings' ) ){
	function et_list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
	<?php }
}

add_action( 'wp_enqueue_scripts', 'et_responsive_layout' );
function et_responsive_layout(){
	if ( 'on' != get_option('deepfocus_responsive_layout') ) return;
	$template_dir = get_template_directory_uri();

	wp_enqueue_style('et_responsive', $template_dir . '/css/responsive.css');

	wp_enqueue_script('flexslider', $template_dir . '/js/jquery.flexslider-min.js', array('jquery'), '1.0', true);
	wp_enqueue_script('et_flexslider_script', $template_dir . '/js/et_flexslider.js', array('jquery'), '1.0', true);
}

function et_deepfocus_load_scripts_styles(){
	global $shortname;

	$et_prefix = ! et_options_stored_in_one_row() ? "{$shortname}_" : '';
	$heading_font_option_name = "{$et_prefix}heading_font";
	$body_font_option_name = "{$et_prefix}body_font";

	$et_gf_enqueue_fonts = array();
	$et_gf_heading_font = sanitize_text_field( et_get_option( $heading_font_option_name, 'none' ) );
	$et_gf_body_font = sanitize_text_field( et_get_option( $body_font_option_name, 'none' ) );

	if ( 'none' != $et_gf_heading_font ) $et_gf_enqueue_fonts[] = $et_gf_heading_font;
	if ( 'none' != $et_gf_body_font ) $et_gf_enqueue_fonts[] = $et_gf_body_font;

	if ( ! empty( $et_gf_enqueue_fonts ) ) et_gf_enqueue_fonts( $et_gf_enqueue_fonts );
}

add_action( 'wp_head', 'et_add_viewport_meta' );
function et_add_viewport_meta(){
	if ( 'on' != get_option('deepfocus_responsive_layout') ) return;
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />';
}

/**
 * Gets featured posts IDs from transient, if the transient doesn't exist - runs the query and stores IDs
 */
function et_get_featured_posts_ids(){
	if ( false === ( $et_featured_post_ids = get_transient( 'et_featured_post_ids' ) ) ) {
		$featured_query = new WP_Query( apply_filters( 'et_featured_post_args', array(
			'posts_per_page'	=> (int) et_get_option( 'deepfocus_featured_num' ),
			'cat'				=> (int) get_catId( et_get_option( 'deepfocus_feat_cat' ) )
		) ) );

		if ( $featured_query->have_posts() ) {
			while ( $featured_query->have_posts() ) {
				$featured_query->the_post();

				$et_featured_post_ids[] = get_the_ID();
			}

			set_transient( 'et_featured_post_ids', $et_featured_post_ids );
		}

		wp_reset_postdata();
	}

	return $et_featured_post_ids;
}

/**
 * Filters the main query on homepage
 */
function et_home_posts_query( $query = false ) {
	/* Don't proceed if it's not homepage or the main query */
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() ) return;

	if ( 'false' == et_get_option( 'deepfocus_blog_style', 'false' ) ) {
		$exclude_gallery_categories = et_get_option( 'deepfocus_exlcats_recentworks', false );
		if ( $exclude_gallery_categories ) $query->set( 'category__not_in', array_map( 'intval', et_generate_wpml_ids( $exclude_gallery_categories, 'category' ) ) );

		$query->set( 'posts_per_page', (int) et_get_option( 'deepfocus_portfolio_number', '8' ) );

		return;
	}

	/* Set the amount of posts per page on homepage */
	$query->set( 'posts_per_page', (int) et_get_option( 'deepfocus_homepage_posts', '6' ) );

	/* Exclude categories set in ePanel */
	$exclude_categories = et_get_option( 'deepfocus_exlcats_recent', false );
	if ( $exclude_categories ) $query->set( 'category__not_in', array_map( 'intval', et_generate_wpml_ids( $exclude_categories, 'category' ) ) );

	/* Exclude slider posts, if the slider is activated, pages are not featured and posts duplication is disabled in ePanel  */
	if ( 'on' == et_get_option( 'deepfocus_featured', 'on' ) && 'false' == et_get_option( 'deepfocus_use_pages', 'false' ) && 'false' == et_get_option( 'deepfocus_duplicate', 'on' ) )
		$query->set( 'post__not_in', et_get_featured_posts_ids() );
}

/**
 * Deletes featured posts IDs transient, when the user saves, resets ePanel settings, creates or moves posts to trash in WP-Admin
 */
function et_delete_featured_ids_cache(){
	if ( false !== get_transient( 'et_featured_post_ids' ) ) delete_transient( 'et_featured_post_ids' );
}

add_action( 'et_header_menu', 'et_add_mobile_navigation' );
function et_add_mobile_navigation(){
	if ( 'on' != get_option('deepfocus_responsive_layout') ) return;
	echo '<a href="#" id="mobile_nav" class="closed">' . esc_html__( 'Navigation Menu', 'DeepFocus' ) . '<span></span></a>';
}

function et_epanel_custom_colors_css(){
	global $shortname; ?>

	<style type="text/css">
		body { color: #<?php echo esc_html(get_option($shortname.'_color_mainfont')); ?>; }
		#bg { background-color: #<?php echo esc_html(get_option($shortname.'_color_bgcolor')); ?>; }
		.post a:link, .post a:visited { color: #<?php echo esc_html(get_option($shortname.'_color_mainlink')); ?>; }
		ul#primary li a { color: #<?php echo esc_html(get_option($shortname.'_color_pagelink')); ?>; }
		ul#secondary li a { color: #<?php echo esc_html(get_option($shortname.'_color_catslink')); ?>; }
		#sidebar h4 { color:#<?php echo esc_html(get_option($shortname.'_color_sidebar_titles')); ?>; }
		.footer-widget h4.widgettitle { color:#<?php echo esc_html(get_option($shortname.'_color_footer_titles')); ?>; }
		#footer a { color:#<?php echo esc_html(get_option($shortname.'_color_footer_links')); ?>; }
	</style>

<?php }

if ( function_exists( 'get_custom_header' ) ) {
	// compatibility with versions of WordPress prior to 3.4

	add_action( 'customize_register', 'et_deepfocus_customize_register' );
	function et_deepfocus_customize_register( $wp_customize ) {
		$google_fonts = et_get_google_fonts();

		$font_choices = array();
		$font_choices['none'] = 'Default Theme Font';
		foreach ( $google_fonts as $google_font_name => $google_font_properties ) {
			$font_choices[ $google_font_name ] = $google_font_name;
		}

		$wp_customize->remove_section( 'title_tagline' );
		$wp_customize->remove_section( 'background_image' );
		$wp_customize->remove_section( 'colors' );

		$wp_customize->add_section( 'et_google_fonts' , array(
			'title'		=> __( 'Fonts', 'DeepFocus' ),
			'priority'	=> 50,
		) );

		$wp_customize->add_setting( 'deepfocus_heading_font', array(
			'default'		    => 'none',
			'type'			    => 'option',
			'capability'	    => 'edit_theme_options',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( 'deepfocus_heading_font', array(
			'label'		=> __( 'Header Font', 'DeepFocus' ),
			'section'	=> 'et_google_fonts',
			'settings'	=> 'deepfocus_heading_font',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) );

		$wp_customize->add_setting( 'deepfocus_body_font', array(
			'default'		    => 'none',
			'type'			    => 'option',
			'capability'	    => 'edit_theme_options',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( 'deepfocus_body_font', array(
			'label'		=> __( 'Body Font', 'DeepFocus' ),
			'section'	=> 'et_google_fonts',
			'settings'	=> 'deepfocus_body_font',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) );
	}

	add_action( 'wp_head', 'et_deepfocus_add_customizer_css' );
	add_action( 'customize_controls_print_styles', 'et_deepfocus_add_customizer_css' );
	function et_deepfocus_add_customizer_css(){ ?>
		<style type="text/css">
		<?php
			global $shortname;

			$et_prefix = ! et_options_stored_in_one_row() ? "{$shortname}_" : '';
			$heading_font_option_name = "{$et_prefix}heading_font";
			$body_font_option_name = "{$et_prefix}body_font";

			$et_gf_heading_font = sanitize_text_field( et_get_option( $heading_font_option_name, 'none' ) );
			$et_gf_body_font = sanitize_text_field( et_get_option( $body_font_option_name, 'none' ) );

			if ( 'none' != $et_gf_heading_font || 'none' != $et_gf_body_font ) :

				if ( 'none' != $et_gf_heading_font )
					et_gf_attach_font( $et_gf_heading_font, 'h1, h2, h3, h4, h5, h6, ul.nav a, #featured h2.title, #tagline, h3.hometitle, .entry h2.title, .entry h1.title, .comment-author, h3#comments, #reply-title span, .entry h1, .entry h2, .entry h3, .entry h4, .entry h5, .entry h6, div.service a.readmore, #portfolio-items a.readmore, .entry a.readmore, .reply-container a, #blog-content h4.widgettitle, h4.widgettitle, .wp-pagenavi' );

				if ( 'none' != $et_gf_body_font )
					et_gf_attach_font( $et_gf_body_font, 'body' );

			endif;
		?>
		</style>
	<?php }

	add_action( 'customize_controls_print_footer_scripts', 'et_load_google_fonts_scripts' );
	function et_load_google_fonts_scripts() {
		wp_enqueue_script( 'et_google_fonts', get_template_directory_uri() . '/epanel/google-fonts/et_google_fonts.js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'et_google_fonts', 'et_google_fonts', array(
			'options_in_one_row' => ( et_options_stored_in_one_row() ? 1 : 0 )
		) );
	}

	add_action( 'customize_controls_print_styles', 'et_load_google_fonts_styles' );
	function et_load_google_fonts_styles() {
		wp_enqueue_style( 'et_google_fonts_style', get_template_directory_uri() . '/epanel/google-fonts/et_google_fonts.css', array(), null );
	}
}

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

