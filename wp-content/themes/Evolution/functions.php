<?php
add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname, $default_colorscheme;
		$themename = "Evolution";
		$shortname = "Evolution";
		$default_colorscheme = "Default";

		$template_dir = get_template_directory();

		require_once($template_dir . '/epanel/custom_functions.php');

		require_once( $template_dir . '/includes/functions/sanitization.php' );

		require_once($template_dir . '/includes/functions/comments.php');

		require_once($template_dir . '/includes/functions/sidebars.php');

		load_theme_textdomain('Evolution',$template_dir.'/lang');

		require_once($template_dir . '/epanel/core_functions.php');

		require_once($template_dir . '/includes/post_thumbnails_evolution.php');

		include($template_dir . '/includes/widgets.php');

		remove_action( 'admin_init', 'et_epanel_register_portability' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'automatic-feed-links' );

		add_action( 'wp_enqueue_scripts', 'et_add_responsive_shortcodes_css', 11 );

		add_action( 'pre_get_posts', 'et_home_posts_query' );

		add_action( 'et_epanel_changing_options', 'et_delete_featured_ids_cache' );
		add_action( 'delete_post', 'et_delete_featured_ids_cache' );
		add_action( 'save_post', 'et_delete_featured_ids_cache' );
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
			'primary-menu' => __( 'Primary Menu', 'Evolution' )
		)
	);
}
if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );

// add Home link to the custom menu WP-Admin page
function et_add_home_link( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'et_add_home_link' );

add_action( 'wp_enqueue_scripts', 'et_load_evolution_scripts' );
function et_load_evolution_scripts(){
	global $shortname;

	if ( !is_admin() ){
		$template_dir = get_template_directory_uri();

		wp_enqueue_script('superfish', $template_dir . '/js/superfish.js', array('jquery'), '1.0', true);
		wp_enqueue_script('flexslider', $template_dir . '/js/jquery.flexslider-min.js', array('jquery'), '1.0', true);
		wp_enqueue_script('custom_script', $template_dir . '/js/custom.js', array('jquery'), '1.0', true);
	}

	$et_prefix = ! et_options_stored_in_one_row() ? "{$shortname}_" : '';
	$heading_font_option_name = "{$et_prefix}heading_font";
	$body_font_option_name = "{$et_prefix}body_font";

	$et_gf_enqueue_fonts = array();
	$et_gf_heading_font = sanitize_text_field( et_get_option( $heading_font_option_name, 'none' ) );
	$et_gf_body_font = sanitize_text_field( et_get_option( $body_font_option_name, 'none' ) );

	if ( 'none' != $et_gf_heading_font ) $et_gf_enqueue_fonts[] = $et_gf_heading_font;
	if ( 'none' != $et_gf_body_font ) $et_gf_enqueue_fonts[] = $et_gf_body_font;

	if ( ! empty( $et_gf_enqueue_fonts ) ) et_gf_enqueue_fonts( $et_gf_enqueue_fonts );

	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
}

add_action( 'wp_head', 'et_flexslider_css' );
function et_flexslider_css(){
	echo '<link rel="stylesheet" href="' . esc_url( get_template_directory_uri() . '/css/flexslider.css' ) . '" type="text/css" media="screen" />';
}

add_action( 'wp_head', 'et_add_viewport_meta' );
function et_add_viewport_meta(){
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />';
}

if ( ! function_exists( 'et_list_pings' ) ){
	function et_list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
	<?php }
}

/**
 * Gets featured posts IDs from transient, if the transient doesn't exist - runs the query and stores IDs
 */
function et_get_featured_posts_ids(){
	if ( false === ( $et_featured_post_ids = get_transient( 'et_featured_post_ids' ) ) ) {
		$featured_query = new WP_Query( apply_filters( 'et_featured_post_args', array(
			'posts_per_page'	=> (int) et_get_option( 'evolution_featured_num' ),
			'cat'				=> (int) get_catId( et_get_option( 'evolution_feat_cat' ) )
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

	/* Exclude slider posts, if the slider is activated, pages are not featured and posts duplication is disabled in ePanel  */
	if ( 'on' == et_get_option( 'evolution_featured', 'on' ) && 'false' == et_get_option( 'evolution_use_pages', 'false' ) && 'false' == et_get_option( 'evolution_duplicate', 'on' ) )
		$query->set( 'post__not_in', et_get_featured_posts_ids() );

	if ( 'false' == et_get_option( 'evolution_blog_style', 'false' ) ) {
		if ( 'on' == et_get_option( 'evolution_display_recent_blog_posts', 'on' ) ) {
			$query->set( 'posts_per_page', (int) et_get_option( 'evolution_posts_blog_num', '3' ) );
			$query->set( 'ignore_sticky_posts', 1 );
			$query->set( 'cat', get_catId( et_get_option('evolution_home_recentblog_section') ) );
		}

		return;
	}

	/* Set the amount of posts per page on homepage */
	$query->set( 'posts_per_page', (int) et_get_option( 'evolution_homepage_posts', '6' ) );

	/* Exclude categories set in ePanel */
	$exclude_categories = et_get_option( 'evolution_exlcats_recent', false );
	if ( $exclude_categories ) $query->set( 'category__not_in', array_map( 'intval', et_generate_wpml_ids( $exclude_categories, 'category' ) ) );
}

/**
 * Deletes featured posts IDs transient, when the user saves, resets ePanel settings, creates or moves posts to trash in WP-Admin
 */
function et_delete_featured_ids_cache(){
	if ( false !== get_transient( 'et_featured_post_ids' ) ) delete_transient( 'et_featured_post_ids' );
}

add_action( 'admin_enqueue_scripts', 'et_portfolio_fullwidth_delete' );
function et_portfolio_fullwidth_delete( $hook_suffix ) {
	if ( in_array($hook_suffix, array('post.php','post-new.php')) ) {
		wp_enqueue_script('et-ptemplates-fwdelete', get_bloginfo('template_directory') . '/js/delete_fwidth.js', array('jquery'), '1.1', false);
	}
}

function et_epanel_custom_colors_css(){
	global $shortname; ?>

	<style type="text/css">
		body { color: #<?php echo esc_html(get_option($shortname.'_color_mainfont')); ?>; }
		a { color: #<?php echo esc_html(get_option($shortname.'_color_mainlink')); ?>; }
		ul.nav li a { color: #<?php echo esc_html(get_option($shortname.'_color_pagelink')); ?> !important; }
		ul.nav > li.current-menu-item > a { color: #<?php echo esc_html(get_option($shortname.'_color_pagelink_active')); ?> !important; }
		h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: #<?php echo esc_html(get_option($shortname.'_color_headings')); ?> !important; }

		#sidebar a { color:#<?php echo esc_html(get_option($shortname.'_color_sidebar_links')); ?>; }
		.footer-widget { color:#<?php echo esc_html(get_option($shortname.'_footer_text')); ?> }
		#footer a, ul#bottom-menu li a { color:#<?php echo esc_html(get_option($shortname.'_color_footerlinks')); ?> }
	</style>

<?php }

/**
 * Overrides the main et_load_core_options function,
 * it makes sure the filename is always lowercase
 */
function et_load_core_options() {
	global $shortname;
	$shortname = strtolower( $shortname );

	require_once( get_template_directory() . esc_attr( "/options_{$shortname}.php" ) );
}

if ( function_exists( 'get_custom_header' ) ) {
	// compatibility with versions of WordPress prior to 3.4

	add_action( 'customize_register', 'et_evolution_customize_register' );
	function et_evolution_customize_register( $wp_customize ) {
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
			'title'		=> __( 'Fonts', 'Evolution' ),
			'priority'	=> 50,
		) );

		$wp_customize->add_setting( 'Evolution_heading_font', array(
			'default'		    => 'none',
			'type'			    => 'option',
			'capability'	    => 'edit_theme_options',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( 'Evolution_heading_font', array(
			'label'		=> __( 'Header Font', 'Evolution' ),
			'section'	=> 'et_google_fonts',
			'settings'	=> 'Evolution_heading_font',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) );

		$wp_customize->add_setting( 'Evolution_body_font', array(
			'default'		    => 'none',
			'type'			    => 'option',
			'capability'	    => 'edit_theme_options',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( 'Evolution_body_font', array(
			'label'		=> __( 'Body Font', 'Evolution' ),
			'section'	=> 'et_google_fonts',
			'settings'	=> 'Evolution_body_font',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) );
	}

	add_action( 'wp_head', 'et_evolution_add_customizer_css' );
	add_action( 'customize_controls_print_styles', 'et_evolution_add_customizer_css' );
	function et_evolution_add_customizer_css(){ ?>
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
					et_gf_attach_font( $et_gf_heading_font, 'h1, h2, h3, h4, h5, h6, #slogan p, #recent-work h3, #about h3, #recent-posts h3, h3.widgettitle, h4.widgettitle' );

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

