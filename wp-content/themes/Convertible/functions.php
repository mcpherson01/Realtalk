<?php
add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname, $default_colorscheme, $et_bg_texture_urls, $et_google_fonts, $epanel_texture_urls;

		$themename = "Convertible";
		$shortname = "convertible";

		$default_colorscheme = "Default";

		$template_dir = get_template_directory();

		require_once($template_dir . '/epanel/custom_functions.php');

		load_theme_textdomain( $themename, $template_dir . '/lang' );

		require_once($template_dir . '/epanel/core_functions.php');

		require_once($template_dir . '/includes/post_thumbnails_convertible.php');

		include($template_dir . '/includes/widgets.php');

		remove_action( 'admin_init', 'et_epanel_register_portability' );

		remove_action( 'admin_init', 'et_theme_check_clean_installation' );

		if ( is_admin() ) add_action( 'admin_menu', 'et_lb_create_menu_link' );

		add_action('et_lb_hidden_editor', 'et_advanced_buttons');

		$et_bg_texture_urls = array(esc_html__('Thin Vertical Lines',$themename), esc_html__('Small Squares',$themename), esc_html__('Thick Diagonal Lines',$themename), esc_html__('Thin Diagonal Lines',$themename), esc_html__('Diamonds',$themename), esc_html__('Small Circles',$themename), esc_html__('Thick Vertical Lines',$themename), esc_html__('Thin Flourish',$themename), esc_html__('Thick Flourish',$themename), esc_html__('Pocodot',$themename), esc_html__('Checkerboard',$themename), esc_html__('Squares',$themename), esc_html__('Noise',$themename), esc_html__('Wooden',$themename), esc_html__('Stone',$themename), esc_html__('Canvas',$themename));

		$et_google_fonts = apply_filters( 'et_google_fonts', array('Georgia','Kreon','Droid Sans','Droid Serif','Lobster','Yanone Kaffeesatz','Nobile','Crimson Text','Arvo','Tangerine','Cuprum','Cantarell','Philosopher','Josefin Sans','Dancing Script','Raleway','Bentham','Goudy Bookletter 1911','Quattrocento','Ubuntu', 'PT Sans') );
		sort($et_google_fonts);

		$epanel_texture_urls = $et_bg_texture_urls;
		array_unshift( $epanel_texture_urls, 'Default' );

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

remove_action( 'wp_head', 'feed_links', 2 );

add_filter( 'et_get_additional_color_scheme', 'et_remove_additional_stylesheet' );
function et_remove_additional_stylesheet( $stylesheet ){
	global $default_colorscheme;
	return $default_colorscheme;
}

add_action( 'wp_enqueue_scripts', 'et_load_convertible_scripts' );
function et_load_convertible_scripts(){
	if ( ! is_admin() ){
		$template_dir = get_template_directory_uri();

		wp_enqueue_script('flexslider', $template_dir . '/js/jquery.flexslider-min.js', array('jquery'), '1.0', true);
		wp_enqueue_style('flexslider', $template_dir . '/css/flexslider.css');
		wp_enqueue_script('fitvids', $template_dir . '/js/jquery.fitvids.js', array('jquery'), '1.0', true);
		wp_enqueue_script('custom', $template_dir . '/js/custom.js', array('jquery'), '1.0', true);

		$admin_access = apply_filters( 'et_showcontrol_panel', current_user_can('switch_themes') );
		if ( $admin_access && get_option('convertible_show_control_panel') == 'on' ) {
			wp_enqueue_script('et_colorpicker', $template_dir . '/epanel/js/colorpicker.js', array('jquery'), '1.0', true);
			wp_enqueue_script('et_eye', $template_dir . '/epanel/js/eye.js', array('jquery'), '1.0', true);
			wp_enqueue_script('et_cookie', $template_dir . '/js/jquery.cookie.js', array('jquery'), '1.0', true);
			wp_enqueue_script('et_control_panel', $template_dir . '/js/et_control_panel.js', array('jquery'), '1.0', true);
			wp_localize_script( 'et_control_panel', 'et_control_panel', apply_filters( 'et_control_panel_settings', array( 'theme_folder' => $template_dir ) ) );
		}
	}
}

add_action('et_header_top','et_convertible_control_panel');
function et_convertible_control_panel(){
	global $themename;

	$admin_access = apply_filters( 'et_showcontrol_panel', current_user_can('switch_themes') );
	if ( !$admin_access ) return;
	if ( get_option('convertible_show_control_panel') <> 'on' ) return;
	global $et_bg_texture_urls, $et_google_fonts; ?>
	<div id="et-control-panel">
		<div id="control-panel-main">
			<a id="et-control-close" href="#"></a>
			<div id="et-control-inner">
				<h3 class="control_title"><?php esc_html_e('Example Colors',$themename); ?></h3>
				<a href="#" class="et-control-colorpicker" id="et-control-background"></a>

				<div class="clear"></div>

				<?php
					$sample_colors = array( '6a8e94', '8da49c', 'b0b083', '859a7c', 'c6bea6', 'b08383', 'a4869d', 'f5f5f5', '4e4e4e', '556f6a', '6f5555', '6f6755' );
					for ( $i=1; $i<=12; $i++ ) { ?>
						<a class="et-sample-setting" id="et-sample-color<?php echo $i; ?>" href="#" rel="<?php echo esc_attr($sample_colors[$i-1]); ?>" title="#<?php echo esc_attr($sample_colors[$i-1]); ?>"><span class="et-sample-overlay"></span></a>
				<?php } ?>
				<p><?php esc_html_e('or define your own in ePanel',$themename); ?></p>

				<h3 class="control_title"><?php esc_html_e('Texture Overlays',$themename); ?></h3>
				<div class="clear"></div>

				<?php
					$sample_textures = $et_bg_texture_urls;
					for ( $i=1; $i<=count($et_bg_texture_urls); $i++ ) { ?>
						<a title="<?php echo esc_attr($sample_textures[$i-1]); ?>" class="et-sample-setting et-texture" id="et-sample-texture<?php echo esc_attr( $i ); ?>" href="#" rel="bg<?php echo esc_attr( $i+1 ); ?>"><span class="et-sample-overlay"></span></a>
				<?php } ?>

				<p><?php esc_html_e('or define your own in ePanel',$themename); ?></p>

				<?php
					$google_fonts = $et_google_fonts;
					$font_setting = 'Lobster';
					$body_font_setting = 'Droid+Sans';
					if ( isset( $_COOKIE['et_convertible_header_font'] ) ) $font_setting = $_COOKIE['et_convertible_header_font'];
					if ( isset( $_COOKIE['et_convertible_body_font'] ) ) $body_font_setting = $_COOKIE['et_convertible_body_font'];
				?>

				<h3 class="control_title"><?php esc_html_e('Fonts',$themename); ?></h3>
				<div class="clear"></div>

				<label for="et_control_header_font"><?php esc_html_e('Header',$themename); ?>
					<select name="et_control_header_font" id="et_control_header_font">
						<?php foreach( $google_fonts as $google_font ) { ?>
							<?php $encoded_value = urlencode($google_font); ?>
							<option value="<?php echo esc_attr($encoded_value); ?>" <?php selected( $font_setting, $encoded_value ); ?>><?php echo esc_html($google_font); ?></option>
						<?php } ?>
					</select>
				</label>
				<a href="#" class="et-control-colorpicker et-font-control" id="et-control-headerfont_bg"></a>
				<div class="clear"></div>

				<label for="et_control_body_font"><?php esc_html_e('Body',$themename); ?>
					<select name="et_control_body_font" id="et_control_body_font">
						<?php foreach( $google_fonts as $google_font ) { ?>
							<?php $encoded_value = urlencode($google_font); ?>
							<option value="<?php echo esc_attr($encoded_value); ?>" <?php selected( $body_font_setting, $encoded_value ); ?>><?php echo esc_html($google_font); ?></option>
						<?php } ?>
					</select>
				</label>
				<a href="#" class="et-control-colorpicker et-font-control" id="et-control-bodyfont_bg"></a>
				<div class="clear"></div>

			</div> <!-- end #et-control-inner -->
		</div> <!-- end #control-panel-main -->
	</div> <!-- end #et-control-panel -->
<?php
}

add_action( 'wp_head', 'et_set_bg_properties' );
function et_set_bg_properties(){
	global $et_bg_texture_urls;

	$bgcolor = '';
	$bgcolor = ( isset( $_COOKIE['et_convertible_bgcolor'] ) && get_option('convertible_show_control_panel') == 'on' ) ? $_COOKIE['et_convertible_bgcolor'] : get_option('convertible_bgcolor');

	$bgtexture_url = '';
	$bgimage_url = '';
	if ( get_option('convertible_bgimage') == '' ) {
		if ( isset( $_COOKIE['et_convertible_texture_url'] ) && get_option('convertible_show_control_panel') == 'on' ) $bgtexture_url =  $_COOKIE['et_convertible_texture_url'];
		else {
			$bgtexture_url = get_option('convertible_bgtexture_url');
			if ( $bgtexture_url == 'Default' ) $bgtexture_url = '';
			else $bgtexture_url = get_template_directory_uri() . '/images/control_panel/body-bg' . ( array_search( $bgtexture_url, $et_bg_texture_urls )+2 ) . '.png';
		}
	} else {
		$bgimage_url = get_option('convertible_bgimage');
	}

	$style = '';
	$style .= '<style type="text/css">';
	if ( $bgcolor <> '' ) $style .= 'body { background-color: #' . esc_html($bgcolor) . '; }';
	if ( $bgtexture_url <> '' ) $style .= 'body { background-image: url(' . esc_html($bgtexture_url) . '); }';
	if ( $bgimage_url <> '' ) $style .= 'body { background-image: url(' . esc_html($bgimage_url) . '); background-position: top center; background-repeat: no-repeat; }';
	$style .= '</style>';

	if ( $bgcolor <> '' || $bgtexture_url <> '' || $bgimage_url <> '' ) echo $style;
}

add_action( 'wp_head', 'et_set_font_properties' );
function et_set_font_properties(){
	$font_style = '';
	$font_color = '';
	$font_family = '';
	$font_color_string = '';

	if ( isset( $_COOKIE['et_convertible_header_font'] ) && get_option('convertible_show_control_panel') == 'on' ) $et_header_font =  $_COOKIE['et_convertible_header_font'];
	else {
		$et_header_font = get_option('convertible_header_font');
	}

	if ( $et_header_font == 'Georgia' ) $et_header_font = '';

	if ( isset( $_COOKIE['et_convertible_header_font_color'] ) && get_option('convertible_show_control_panel') == 'on' )
		$et_header_font_color =  $_COOKIE['et_convertible_header_font_color'];
	else
		$et_header_font_color = get_option('convertible_header_font_color');

	if ( $et_header_font <> '' || $et_header_font_color <> '' ) {
		$et_header_font_id = strtolower( str_replace( '+', '_', $et_header_font ) );
		$et_header_font_id = str_replace( ' ', '_', $et_header_font_id );

		if ( $et_header_font <> '' ) {
			$font_style .= "<link id='" . esc_attr($et_header_font_id) . "' href='" . esc_url( "http://fonts.googleapis.com/css?family=" . str_replace( ' ', '+', $et_header_font )  . ( 'Raleway' == $et_header_font ? ':100' : '' ) ) . "' rel='stylesheet' type='text/css' />";
			$font_family = "font-family: '" . esc_html(str_replace( '+', ' ', $et_header_font )) . "', Arial, sans-serif !important; ";
		}

		if ( $et_header_font_color <> '' ) {
			$font_color_string = "color: #" . esc_html($et_header_font_color) . "; ";
		}

		$font_style .= "<style type='text/css'>h1,h2,h3,h4,h5,h6 { ". $font_family .  " }</style>";
		$font_style .= "<style type='text/css'>h1,h2,h3,h4,h5,h6 { ". esc_html($font_color_string) .  " }
		</style>";

		echo $font_style;
	}

	$font_style = '';
	$font_color = '';
	$font_family = '';
	$font_color_string = '';

	if ( isset( $_COOKIE['et_convertible_body_font'] ) && get_option('convertible_show_control_panel') == 'on' ) $et_body_font =  $_COOKIE['et_convertible_body_font'];
	else {
		$et_body_font = get_option('convertible_body_font');
	}

	if ( $et_body_font == 'Georgia' ) $et_body_font = '';

	if ( isset( $_COOKIE['et_convertible_body_font_color'] ) && get_option('convertible_show_control_panel') == 'on' )
		$et_body_font_color =  $_COOKIE['et_convertible_body_font_color'];
	else
		$et_body_font_color = get_option('convertible_body_font_color');

	if ( $et_body_font <> '' || $et_body_font_color <> '' ) {
		$et_body_font_id = strtolower( str_replace( '+', '_', $et_body_font ) );
		$et_body_font_id = str_replace( ' ', '_', $et_body_font_id );

		if ( $et_body_font <> '' ) {
			$font_style .= "<link id='" . esc_attr($et_body_font_id) . "' href='" . esc_url( "http://fonts.googleapis.com/css?family=" . str_replace( ' ', '+', $et_body_font ) . ( 'Raleway' == $et_body_font ? ':100' : '' ) ) . "' rel='stylesheet' type='text/css' />";
			$font_family = "font-family: '" . esc_html(str_replace( '+', ' ', $et_body_font )) . "', Arial, sans-serif !important; ";
		}

		if ( $et_body_font_color <> '' ) {
			$font_color_string = "color: #" . esc_html($et_body_font_color);
		}

		$font_style .= "<style type='text/css'>body { ". $font_family .  " !important }</style>";
		$font_style .= "<style type='text/css'>body { ". esc_html($font_color_string) .  " }</style>";

		echo $font_style;
	}
}

add_action('admin_init','et_theme_activate');
function et_theme_activate(){
	global $pagenow;
	if ( isset( $_GET['activated'] ) && 'themes.php' == $pagenow ) do_action( 'et_theme_activated' );
}

add_action( 'et_theme_activated', 'et_convertible_activated' );
function et_convertible_activated(){
	wp_safe_redirect( esc_url( admin_url('themes.php?page=et_layout_builder_convertible') ) );
	exit;
}


function et_lb_create_menu_link(){
	$et_lb_options_user_can = 'manage_options';
	$et_lb_options_pagename = 'et_layout_builder_convertible';

	$et_lb_menu_page = add_theme_page( __('Landing Page Builder','Convertible'), __('Landing Page Builder','Convertible'), $et_lb_options_user_can, $et_lb_options_pagename, 'et_lb_build_settings_page' );

	add_action( "admin_print_styles-{$et_lb_menu_page}", 'et_lb_settings_page_css' );
	add_action( "admin_print_scripts-{$et_lb_menu_page}", 'et_lb_settings_page_js' );
}

function et_lb_settings_page_css(){
	$template_dir = get_template_directory_uri();

	wp_enqueue_style( 'et_lb_admin_css', $template_dir . '/css/et_lb_admin.css' );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
	wp_enqueue_style( 'thickbox' );
}

function et_lb_settings_page_js(){
	$template_dir = get_template_directory_uri();

	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-draggable' );
	wp_enqueue_script( 'jquery-ui-droppable' );
	wp_enqueue_script( 'jquery-ui-resizable' );

	wp_enqueue_script( 'et_lb_admin_js', $template_dir . '/js/et_lb_admin.js', array('jquery','jquery-ui-core','jquery-ui-sortable','jquery-ui-draggable','jquery-ui-droppable','jquery-ui-resizable'), '1.0' );
	wp_localize_script( 'et_lb_admin_js', 'et_lb_options', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'et_load_nonce' => wp_create_nonce( 'et_load_nonce' ), 'confirm_message' => __('Permanently delete this module?', 'Convertible'), 'confirm_message_yes' => __('Yes', 'Convertible'), 'confirm_message_no' => __('No', 'Convertible'), 'saving_text' => __('Saving...', 'Convertible'), 'saved_text' => __('Layout Saved.', 'Convertible') ) );
}

add_action('init','et_lb_modules_init');
function et_lb_modules_init(){
	global $et_lb_modules, $et_lb_columns, $et_lb_sample_layouts;

	$et_lb_widget_areas = apply_filters( 'et_lb_widget_areas', array( __('Widget Area 1', 'Convertible'), __('Widget Area 2', 'Convertible'), __('Widget Area 3', 'Convertible'), __('Widget Area 4', 'Convertible'), __('Widget Area 5', 'Convertible') ) );

	$et_lb_modules['logo'] = array(
		'name' => __('Logo', 'Convertible'),
		'options' => array(
			'logo_url' => array(
				'title' => __('Logo Image URL', 'Convertible'),
				'type' => 'upload',
				'is_content' => true
			),
			'align' => array(
				'title' => __('Select the logo placement', 'Convertible'),
				'type' => 'select',
				'options' => array( __('left', 'Convertible'), __('center', 'Convertible'), __('right', 'Convertible') ),
				'std' => __('center', 'Convertible')
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['header'] = array(
		'name' => __('Header', 'Convertible'),
		'options' => array(
			'heading' => array(
				'title' => __('Add a heading text', 'Convertible'),
				'type' => 'text'
			),
			'text' => array(
				'title' => __('Add a ribbon text', 'Convertible'),
				'type' => 'wp_editor',
				'is_content' => true
			),
			'color' => array(
				'title' => __('Select a ribbon color', 'Convertible'),
				'type' => 'select',
				'options' => array( __('blue', 'Convertible'), __('purple', 'Convertible') ),
				'std' => __('purple', 'Convertible')
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		),
		'full_width' => true
	);

	$et_lb_modules['paper'] = array(
		'name' => __('Paper', 'Convertible'),
		'options' => array(
			'text' => array(
				'title' => __('Add a paper text', 'Convertible'),
				'type' => 'wp_editor',
				'is_content' => true
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['video'] = array(
		'name' => __('Video', 'Convertible'),
		'options' => array(
			'video_url' => array(
				'title' => __('Video URL', 'Convertible'),
				'type' => 'text'
			),
			'text' => array(
				'title' => __('Add module text', 'Convertible'),
				'type' => 'wp_editor',
				'is_content' => true
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['testimonial'] = array(
		'name' => __('Testimonial', 'Convertible'),
		'options' => array(
			'image_url' => array(
				'title' => __('Image URL', 'Convertible'),
				'type' => 'upload'
			),
			'author_name' => array(
				'title' => __('Author Name', 'Convertible'),
				'type' => 'text'
			),
			'author_position' => array(
				'title' => __('Company\'s Position', 'Convertible'),
				'type' => 'text'
			),
			'author_site' => array(
				'title' => __('Author Site URL', 'Convertible'),
				'type' => 'text'
			),
			'testimonial_content' => array(
				'title' => __('Testimonial text', 'Convertible'),
				'type' => 'wp_editor',
				'is_content' => true
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['slogan'] = array(
		'name' => __('Slogan', 'Convertible'),
		'options' => array(
			'slogan_content' => array(
				'title' => __('Slogan text', 'Convertible'),
				'type' => 'wp_editor',
				'is_content' => true
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['slider'] = array(
		'name' => __('Image Slider', 'Convertible'),
		'options' => array(
			'imagesize' => array(
				'title' => __('Image Size (e.g. 300x200)', 'Convertible'),
				'type' => 'text'
			),
			'animation' => array(
				'title' => __('Animation Effect', 'Convertible'),
				'type' => 'select',
				'options' => array( __('fade', 'Convertible'), __('slide', 'Convertible') ),
				'std' => __('fade', 'Convertible')
			),
			'animation_duration' => array(
				'title' => __('Animation Duration (in ms)', 'Convertible'),
				'type' => 'text',
				'std' => '600'
			),
			'auto_animation' => array(
				'title' => __('Auto Animation', 'Convertible'),
				'type' => 'select',
				'options' => array( __('off', 'Convertible'), __('on', 'Convertible') ),
				'std' => __('off', 'Convertible')
			),
			'auto_speed' => array(
				'title' => __('Auto Animation Speed (in ms)', 'Convertible'),
				'type' => 'text',
				'std' => '7000'
			),
			'pause_on_hover' => array(
				'title' => __('Pause Slider On Hover', 'Convertible'),
				'type' => 'select',
				'options' => array( __('off', 'Convertible'), __('on', 'Convertible') ),
				'std' => __('off', 'Convertible')
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			),
			'images' => array(
				'type' => 'slider_images'
			)
		)
	);

	$et_lb_modules['button'] = array(
		'name' => __('Button', 'Convertible'),
		'options' => array(
			'color' => array(
				'title' => __('Color', 'Convertible'),
				'type' => 'select',
				'options' => array( __('blue', 'Convertible'), __('green', 'Convertible'), __('red', 'Convertible'), __('purple', 'Convertible'), __('yellow', 'Convertible'), __('black', 'Convertible') ),
				'std' => __('blue', 'Convertible')
			),
			'size' => array(
				'title' => __('Size', 'Convertible'),
				'type' => 'select',
				'options' => array( __('small', 'Convertible'), __('medium', 'Convertible'), __('large', 'Convertible') ),
				'std' => __('small', 'Convertible')
			),
			'url' => array(
				'title' => __('URL', 'Convertible'),
				'type' => 'text'
			),
			'window' => array(
				'title' => __('Open link in the new window?', 'Convertible'),
				'type' => 'select',
				'options' => array( __('off', 'Convertible'), __('on', 'Convertible') ),
				'std' => __('off', 'Convertible')
			),
			'text' => array(
				'title' => __('Text', 'Convertible'),
				'type' => 'text',
				'is_content' => true
			),
			'align' => array(
				'title' => __('Button alignment', 'Convertible'),
				'type' => 'select',
				'options' => array( __('left', 'Convertible'), __('center', 'Convertible'), __('right', 'Convertible') ),
				'std' => __('left', 'Convertible')
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['bar'] = array(
		'name' => __('Horizontal Bar', 'Convertible'),
		'options' => array(
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		),
		'full_width' => true
	);

	$et_lb_modules['list'] = array(
		'name' => __('List', 'Convertible'),
		'options' => array(
			'type' => array(
				'title' => __('Type', 'Convertible'),
				'type' => 'select',
				'options' => array( __('arrow', 'Convertible'), __('checkmark', 'Convertible'), 'x' ),
				'std' => __('checkmark', 'Convertible')
			),
			'content' => array(
				'title' => __('Content', 'Convertible'),
				'type' => 'wp_editor',
				'is_content' => true
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['toggle'] = array(
		'name' => __('Toggle', 'Convertible'),
		'options' => array(
			'heading' => array(
				'title' => __('Title', 'Convertible'),
				'type' => 'text'
			),
			'content' => array(
				'title' => __('Content', 'Convertible'),
				'type' => 'wp_editor',
				'is_content' => true
			),
			'state' => array(
				'title' => __('Default State', 'Convertible'),
				'type' => 'select',
				'options' => array( __('close', 'Convertible'), __('open', 'Convertible') ),
				'std' => __('close', 'Convertible')
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['tabs'] = array(
		'name' => __('Tabs', 'Convertible'),
		'options' => array(
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			),
			'tabs' => array(
				'type' => 'tabs_interface'
			)
		)
	);

	$et_lb_modules['simple_slider'] = array(
		'name' => __('Simple Slider', 'Convertible'),
		'options' => array(
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			),
			'tabs' => array(
				'type' => 'slider_interface'
			)
		)
	);

	$et_lb_modules['pricing_table'] = array(
		'name' => __('Pricing Table', 'Convertible'),
		'options' => array(
			'heading' => array(
				'title' => __('Title', 'Convertible'),
				'type' => 'text'
			),
			'content' => array(
				'title' => __('Content', 'Convertible'),
				'type' => 'wp_editor',
				'is_content' => true
			),
			'price' => array(
				'title' => __('Price', 'Convertible'),
				'type' => 'text'
			),
			'old_price' => array(
				'title' => __('Old Price', 'Convertible'),
				'type' => 'text'
			),
			'button_text' => array(
				'title' => __('Button Text', 'Convertible'),
				'type' => 'text'
			),
			'button_url' => array(
				'title' => __('Button URL', 'Convertible'),
				'type' => 'text'
			),
			'button_color' => array(
				'title' => __('Button Color', 'Convertible'),
				'type' => 'select',
				'options' => array( __('blue', 'Convertible'), __('green', 'Convertible'), __('red', 'Convertible'), __('purple', 'Convertible'), __('yellow', 'Convertible'), __('black', 'Convertible') ),
				'std' => __('blue', 'Convertible')
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['box'] = array(
		'name' => __('Box', 'Convertible'),
		'options' => array(
			'heading' => array(
				'title' => __('Title', 'Convertible'),
				'type' => 'text'
			),
			'color' => array(
				'title' => __('Button Color', 'Convertible'),
				'type' => 'select',
				'options' => array( __('blue', 'Convertible'), __('green', 'Convertible'), __('red', 'Convertible') ),
				'std' => __('blue', 'Convertible')
			),
			'content' => array(
				'title' => __('Content', 'Convertible'),
				'type' => 'wp_editor',
				'is_content' => true
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['text_block'] = array(
		'name' => __('Text Block', 'Convertible'),
		'options' => array(
			'content' => array(
				'title' => __('Content', 'Convertible'),
				'type' => 'wp_editor',
				'is_content' => true
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['widget_area'] = array(
		'name' => __('Widget Area', 'Convertible'),
		'options' => array(
			'area' => array(
				'title' => __('Widget Area', 'Convertible'),
				'type' => 'select',
				'options' => $et_lb_widget_areas,
				'std' => __('Widget Area 1', 'Convertible')
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules['image'] = array(
		'name' => __('Image', 'Convertible'),
		'options' => array(
			'image_url' => array(
				'title' => __('Image URL', 'Convertible'),
				'type' => 'upload'
			),
			'imagesize' => array(
				'title' => __('Image Size (e.g. 300x200)', 'Convertible'),
				'type' => 'text'
			),
			'image_title' => array(
				'title' => __('Image Title', 'Convertible'),
				'type' => 'text'
			),
			'caption' => array(
				'title' => __('Caption', 'Convertible'),
				'type' => 'wp_editor',
				'is_content' => true
			),
			'css_class' => array(
				'title' => __('Additional css class', 'Convertible'),
				'type' => 'text'
			)
		)
	);

	$et_lb_modules = apply_filters( 'et_lb_modules', $et_lb_modules );

	$et_lb_columns['1_2'] = array( 'name' => __('1/2 Column', 'Convertible') );
	$et_lb_columns['1_3'] = array( 'name' => __('1/3 Column', 'Convertible') );
	$et_lb_columns['1_4'] = array( 'name' => __('1/4 Column', 'Convertible') );
	$et_lb_columns['2_3'] = array( 'name' => __('2/3 Column', 'Convertible') );
	$et_lb_columns['3_4'] = array( 'name' => __('3/4 Column', 'Convertible') );
	$et_lb_columns['resizable'] = array( 'name' => __('Resizable Column', 'Convertible') );

	$et_lb_columns = apply_filters( 'et_lb_columns', $et_lb_columns );

	require_once(TEMPLATEPATH . '/includes/et_lb_sample_layouts.php');
	$et_lb_sample_layouts = apply_filters( 'et_lb_sample_layouts', $et_lb_sample_layouts );

	foreach( $et_lb_columns as $et_lb_column_key => $et_lb_column ){
		add_shortcode("et_lb_{$et_lb_column_key}", 'et_lb_column');
		add_shortcode("et_lb_alt_{$et_lb_column_key}", 'et_lb_alt_column');
	}

	$i = 0;
	foreach ( $et_lb_widget_areas as $et_lb_widget_area ){
		++$i;

		register_sidebar( array(
			'name' => $et_lb_widget_area,
			'id' => 'sidebar-' . $i,
			'before_widget' => '<div id="%1$s" class="et_lb_widget %2$s">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="et_lb_widget-title">',
			'after_title' => '</h3>',
		) );
	}
}

function et_lb_build_settings_page(){
	global $et_lb_modules, $et_lb_columns, $et_lb_sample_layouts;
	$et_helper_class = '';
	$et_convertible_settings = get_option( 'et_convertable_settings' );
?>
	<div id="et_page_builder">
		<div id="et_builder_controls" class="clearfix">
			<a href="#" class="et_add_element et_add_module"><span><?php esc_html_e('Add a Module', 'Convertible'); ?></span></a>
			<a href="#" class="et_add_element et_add_column"><span><?php esc_html_e('Add a Column', 'Convertible'); ?></span></a>
			<a href="#" class="et_add_element et_add_sample_layout"><span><?php esc_html_e('Sample Layout', 'Convertible'); ?></span></a>
			<h2><?php esc_html_e('Landing Page Builder', 'Convertible'); ?></h2>
		</div> <!-- #et_builder_controls -->

		<div id="et_modules">
			<?php
				foreach ( $et_lb_modules as $module_key => $module_settings ){
					$class = "et_module et_m_{$module_key}";
					if ( isset( $module_settings['full_width'] ) && $module_settings['full_width'] ) $class .= ' et_full_width';

					echo "<div data-placeholder='" . esc_attr( $module_settings['name'] ) . "' data-name='" . esc_attr( $module_key ) . "' class='" . esc_attr( $class ) . "'>" . '<span class="et_module_name">' . esc_html( $module_settings['name'] ) . '</span>' .
					'<span class="et_move"></span><span class="et_delete"></span><span class="et_settings_arrow"></span><div class="et_module_settings"></div></div>';
				}

				foreach ( $et_lb_columns as $column_key => $column_settings ){
					echo "<div data-placeholder='" . esc_attr( $column_settings['name'] ) . "' data-name='" . esc_attr( $column_key ) . "' class='" . esc_attr( "et_module et_m_column et_m_column_{$column_key}" ) . "'>" .
					'<span class="et_module_name et_column_name">' . esc_html( $column_settings['name'] ) . '</span>' .
					'<span class="et_move"></span> <span class="et_delete_column"></span></div>';
				}

				foreach ( $et_lb_sample_layouts as $layout_key => $layout_settings ){
					echo "<div data-placeholder='" . esc_attr( $layout_settings['name'] ) . "' data-name='" . esc_attr( $layout_key ) . "' class='" . esc_attr( "et_module et_sample_layout" ) . "'>" .
					'<span class="et_module_name">' . esc_html( $layout_settings['name'] ) . '</span>' .
					'<span class="et_move"></span></div>';
				}
			?>
			<div id="et_module_separator"></div>
			<div id="active_module_settings"></div>
		</div> <!-- #et_modules -->

		<div id="et_layout_container">
			<div id="et_layout" class="clearfix">
				<?php
					if ( $et_convertible_settings['layout_html'] ) {
						echo stripslashes( $et_convertible_settings['layout_html'] );
						$et_helper_class = ' class="hidden"';
					}
				?>
			</div> <!-- #et_layout -->
			<div id="et_lb_helper"<?php echo $et_helper_class; ?>><?php esc_html_e('Drag a Module Onto Your Canvas', 'Convertible'); ?></div>
		</div> <!-- #et_layout_container -->

		<div style="display: none;">
			<?php
				wp_editor( ' ', 'et_lb_hidden_editor' );
				do_action( 'et_lb_hidden_editor' );
			?>
		</div>
	</div> <!-- #et_page_builder -->

	<div id="et_lb_ajax_save">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/core/admin/images/loader.gif' ); ?>" alt="loading" id="loading" />
		<span><?php esc_html_e( 'Saving...', 'Convertible' ); ?></span>
	</div>

	<?php
		echo '<div id="et_lb_save">';
		submit_button( __('Save Changes', 'Convertible'), 'primary', 'et_lb_main_save' );
		echo '</div> <!-- end #et_lb_save -->';
}

add_action( 'wp_ajax_et_save_layout', 'et_save_layout' );
function et_save_layout(){
	if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);

	$et_convertible_settings = array();

	$et_convertible_settings['layout_html'] = trim( $_POST['et_layout_html'] );
	$et_convertible_settings['layout_shortcode'] = $_POST['et_layout_shortcode'];
	update_option( 'et_convertable_settings', $et_convertible_settings );

	die();
}

add_action( 'wp_ajax_et_append_layout', 'et_append_layout' );
function et_append_layout(){
	global $et_lb_sample_layouts;

	if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);

	$layout_name = $_POST['et_layout_name'];
	if ( isset( $et_lb_sample_layouts[$layout_name] ) ) echo stripslashes( $et_lb_sample_layouts[$layout_name]['content'] );

	die();
}

add_action( 'wp_ajax_et_show_module_options', 'et_show_module_options' );
function et_show_module_options(){
	if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);

	$module_class = $_POST['et_module_class'];
	$et_module_exact_name = $_POST['et_module_exact_name'];
	$module_window = (int) $_POST['et_modal_window'];

	preg_match( '/et_m_([^\s])+/', $module_class, $matches );
	$module_name = str_replace( 'et_m_', '', $matches[0] );

	$paste_to_editor_id = isset( $_POST['et_paste_to_editor_id'] ) ? $_POST['et_paste_to_editor_id'] : '';

	et_generate_module_options( $module_name, $module_window, $paste_to_editor_id, $et_module_exact_name );

	die();
}

add_action( 'wp_ajax_et_show_column_options', 'et_show_column_options' );
function et_show_column_options(){
	if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);

	$module_class = $_POST['et_module_class'];

	preg_match( '/et_m_column_([^\s])+/', $module_class, $matches );
	$module_name = str_replace( 'et_m_column_', '', $matches[0] );

	$paste_to_editor_id = isset( $_POST['et_paste_to_editor_id'] ) ? $_POST['et_paste_to_editor_id'] : '';

	et_generate_column_options( $module_name, $paste_to_editor_id );

	die();
}

add_action( 'wp_ajax_et_add_slider_item', 'et_add_slider_item' );
function et_add_slider_item(){
	if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);

	$attachment_class = $_POST['et_attachment_class'];
	$et_change_image = (bool) $_POST['et_change_image'];

	preg_match( '/wp-image-([\d])+/', $attachment_class, $matches );
	$attachment_id = str_replace( 'wp-image-', '', $matches[0] );
	$attachment_image = wp_get_attachment_image( $attachment_id );

	if ( $et_change_image ) {
		echo json_encode( array( 'attachment_image' => $attachment_image, 'attachment_id' => $attachment_id ) );
	} else {
		echo '<div class="et_attachment clearfix" data-attachment="' . esc_attr( $attachment_id ) .'">'
				. $attachment_image
				. '<div class="et_attachment_options">'
					. '<p class="clearfix">' . '<label>' . esc_html__('Description', 'Convertible') . ': </label>' . '<textarea name="attachment_description[]" class="attachment_description"></textarea> </p>'
					. '<p class="clearfix">' . '<label>' . esc_html__('Link', 'Convertible') . ': </label>'. '<input name="attachment_link[]" class="attachment_link" /> </p>'
				. '</div> <!-- .et_attachment_options -->'
				. '<a href="#" class="et_delete_attachment">' . esc_html__('Delete this slide', 'Convertible') . '</a>'
				. '<a href="#" class="et_change_attachment_image">' . esc_html__('Change image', 'Convertible') . '</a>'
			. '</div>';
	}

	die();
}

add_action( 'wp_ajax_et_convert_div_to_editor', 'et_convert_div_to_editor' );
function et_convert_div_to_editor(){
	if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);

	$index = (int) $_POST['et_index'];
	$option_slug = 'et_tab_text_' . $index;

	wp_editor( '', $option_slug, array( 'editor_class' => 'et_lb_wp_editor' ) );

	die();
}

add_action( 'wp_ajax_et_add_tabs_item', 'et_add_tab_item' );
function et_add_tab_item(){
	if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);

	$et_tabs_length = (int) $_POST['et_tabs_length'];
	$option_slug = 'et_tab_text_' . $et_tabs_length;

	echo '<div class="et_lb_tab">'
			. '<p class="clearfix">' . '<label>' . esc_html__('Tab Title', 'Convertible') . ': </label>' . '<input name="et_lb_tab_title[]" class="et_lb_tab_title" /> </p>';
			wp_editor( '', $option_slug, array( 'editor_class' => 'et_lb_wp_editor' ) );
	echo 	'<a href="#" class="et_lb_delete_tab">' . esc_html__('Delete this tab', 'Convertible') . '</a>'
	. '</div>';

	die();
}

add_action( 'wp_ajax_et_add_slides_item', 'et_add_slide_item' );
function et_add_slide_item(){
	if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);

	$et_tabs_length = (int) $_POST['et_tabs_length'];
	$option_slug = 'et_slide_text_' . $et_tabs_length;

	echo '<div class="et_lb_tab">';
			wp_editor( '', $option_slug, array( 'editor_class' => 'et_lb_wp_editor' ) );
	echo 	'<a href="#" class="et_lb_delete_tab">' . esc_html__('Delete this tab', 'Convertible') . '</a>'
	. '</div>';

	die();
}

if ( ! function_exists('et_generate_column_options') ){
	function et_generate_column_options( $column_name, $paste_to_editor_id ){
		global $et_lb_columns;

		$module_name = $et_lb_columns[$column_name]['name'];
		echo '<form id="et_dialog_settings">'
				. '<h3 id="et_settings_title">' . esc_html( ucfirst( $module_name ) . ' ' . __('Settings', 'Convertible') ) . '</h3>'
				. '<a href="#" id="et_close_dialog_settings"></a>'
				. '<p class="clearfix"><input type="checkbox" id="et_dialog_first_class" name="et_dialog_first_class" value="" class="et_lb_option" /> ' . esc_html__('This is the first column in the row', 'Convertible') . '</p>';

		if ( 'resizable' == $column_name ) echo '<p class="clearfix"><label>' . esc_html__('Column width (%)', 'Convertible') . ':</label> <input name="et_dialog_width" type="text" id="et_dialog_width" value="100" class="regular-text et_lb_option" /></p>';

		submit_button();

		echo '<input type="hidden" id="et_saved_module_name" value="' . esc_attr( "alt_{$column_name}" ) . '" />';

		if ( '' != $paste_to_editor_id ) echo '<input type="hidden" id="et_paste_to_editor_id" value="' . esc_attr( $paste_to_editor_id ) . '" />';

		echo '</form>';
	}
}

if ( ! function_exists('et_generate_module_options') ){
	function et_generate_module_options( $module_name, $module_window, $paste_to_editor_id, $et_module_exact_name ){
		global $et_lb_modules;

		$i = 1;
		$form_id = ( 0 == $module_window ) ? 'et_module_settings' : 'et_dialog_settings';

		echo '<form id="' . esc_attr( $form_id ) . '">';
		echo '<h3 id="et_settings_title">' . esc_html( $et_module_exact_name . ' ' . __('Settings', 'Convertible') ) . '</h3>';

		if ( 0 == $module_window ) echo '<a href="#" id="et_close_module_settings"></a>';
		else echo '<a href="#" id="et_close_dialog_settings"></a>';

		foreach ( $et_lb_modules[$module_name]['options'] as $option_slug => $option_settings ){
			$content_class = isset( $option_settings['is_content'] ) && $option_settings['is_content'] ? ' et_lb_module_content' : '';

			echo '<p class="clearfix">';
			if ( isset( $option_settings['title'] ) ) echo "<label><span class='et_module_option_number'>{$i}</span>. {$option_settings['title']}</label>";

			if ( 1 == $module_window ) $option_slug = 'et_dialog_' . $option_slug;

			switch ( $option_settings['type'] ) {
				case 'wp_editor':
					wp_editor( '', $option_slug, array( 'editor_class' => 'et_lb_wp_editor et_lb_option' . $content_class ) );
					break;
				case 'select':
					$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
					echo
					'<select name="' . esc_attr( $option_slug ) . '" id="' . esc_attr( $option_slug ) . '" class="et_lb_option' . $content_class . '">'
						. ( ( '' == $std ) ? '<option value="nothing_selected">  ' . esc_html__('Select', 'Convertible') . '  </option>' : '' );
						foreach ( $option_settings['options'] as $setting_value ){
							echo '<option value="' . esc_attr( $setting_value ) . '"' . selected( $setting_value, $std, false ) . '>' . esc_html( $setting_value ) . '</option>';
						}
					echo '</select>';
					break;
				case 'text':
					$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
					echo '<input name="' . esc_attr( $option_slug ) . '" type="text" id="' . esc_attr( $option_slug ) . '" value="'.( '' != $std ? esc_attr( $std ) : '' ).'" class="regular-text et_lb_option' . $content_class . '" />';
					break;
				case 'upload':
					echo '<input name="' . esc_attr( $option_slug ) . '" type="text" id="' . esc_attr( $option_slug ) . '" value="" class="regular-text et_lb_option et_lb_upload_field' . $content_class . '" />' . '<a href="#" class="et_lb_upload_button">' . esc_html__('Upload', 'Convertible') . '</a>';
					break;
				case 'slider_images':
					echo '<div id="et_slider_images">' . '<div id="et_slides" class="et_lb_option"></div>' . '<a href="#" id="et_add_slider_images">' . esc_html__('Add Slider Image', 'Convertible') . '</a>' . '</div>';
					break;
				case 'tabs_interface':
					echo '<div id="et_tabs_interface">' . '<div id="et_lb_tabs" class="et_lb_option" data-elements="0"></div>' . '<a href="#" id="et_lb_add_tab">' . esc_html__('Add Tab', 'Convertible') . '</a>' . '</div>';
					break;
				case 'slider_interface':
					echo '<div id="et_slides_interface">' . '<div id="et_lb_tabs" class="et_lb_option" data-elements="0"></div>' . '<a href="#" id="et_lb_add_tab">' . esc_html__('Add Slide', 'Convertible') . '</a>' . '</div>';
					break;
			}

			echo '</p>';

			++$i;
		}

		submit_button();

		echo '<input type="hidden" id="et_saved_module_name" value="' . esc_attr( $module_name ) . '" />';

		if ( '' != $paste_to_editor_id ) echo '<input type="hidden" id="et_paste_to_editor_id" value="' . esc_attr( $paste_to_editor_id ) . '" />';

		echo '</form>';
	}
}

if ( ! function_exists('et_lb_get_attributes') ){
	function et_lb_get_attributes( $atts, $additional_classes = '', $additional_styles = '' ){
		extract( shortcode_atts(array(
					'css_class' => '',
					'first_class' => '0',
					'width' => ''
				), $atts));
		$attributes = array( 'class' => '', 'inline_styles' => '' );

		if ( '' != $css_class ) $css_class = ' ' . $css_class;
		if ( '' != $additional_classes ) $additional_classes = ' ' . $additional_classes;
		$first_class = ( '1' == $first_class ) ? ' et_lb_first' : '';
		$attributes['class'] = ' class="' . esc_attr( "et_lb_module{$additional_classes}{$first_class}{$css_class}" ) . '"';

		if ( '' != $width ) $attributes['inline_styles'] .= " width: {$width}%;";
		$attributes['inline_styles'] .= $additional_styles;
		if ( '' != $attributes['inline_styles'] ) $attributes['inline_styles'] = ' style="' . esc_attr( $attributes['inline_styles'] ) . '"';

		return $attributes;
	}
}

if ( ! function_exists('et_lb_fix_shortcodes') ){
	function et_lb_fix_shortcodes($content){
		$replace_tags_from_to = array (
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']'
		);

		return strtr( $content, $replace_tags_from_to );
	}
}

add_shortcode('et_lb_logo', 'et_lb_logo');
function et_lb_logo($atts, $content = null) {
	extract(shortcode_atts(array(
				'align' => 'center'
			), $atts));

	$logo = ( $logo_url = trim( $content ) ) && '' != $logo_url ? $logo_url : get_template_directory_uri() . '/images/logo.png';
	$inline_styles = '';

	if ( 'center' != $align ) $inline_styles .= " text-align: {$align};";
	$attributes = et_lb_get_attributes( $atts, 'et_lb_logo', $inline_styles );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<a href='" . esc_url( home_url() ) ."'>
						<img src='" .  esc_attr( $logo ) . "' alt='" . esc_attr( get_bloginfo('name') ) . "' />
					</a>
				</div>";

	return $output;
}

add_shortcode('et_lb_header', 'et_lb_header');
function et_lb_header($atts, $content = null) {
	extract(shortcode_atts(array(
				'color' => 'purple',
				'heading' => ''
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_ribbon et_lb_color_{$color}" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. ( '' != $heading ? "<h2 class='et_lb_landing-title'>{$heading}</h2>" : '' )
					. '<div class="et_lb_header_content">' . do_shortcode( et_lb_fix_shortcodes($content) ) . '</div> <!-- end .et_lb_header_content -->' .
				"</div>";

	return $output;
}

add_shortcode('et_lb_paper', 'et_lb_paper');
function et_lb_paper($atts, $content = null) {
	$attributes = et_lb_get_attributes( $atts, "et_lb_note-block" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_note'>
						<div class='et_lb_note-inner'>
							<div class='et_lb_note-content clearfix'>"
								. do_shortcode( et_lb_fix_shortcodes($content) ) .
							"</div> <!-- end .et_lb_note-content-->
						</div> <!-- end .et_lb_note-inner-->
					</div> <!-- end .et_lb_note-->
					<div class='et_lb_note-bottom-left'>
						<div class='et_lb_note-bottom-right'>
							<div class='et_lb_note-bottom-center'></div>
						</div>
					</div>
				</div> <!-- end .et_lb_note-block-->";

	return $output;
}

add_shortcode('et_lb_video', 'et_lb_video');
function et_lb_video($atts, $content = null) {
	global $wp_embed;
	extract(shortcode_atts(array(
				'video_url' => ''
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_note-video" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_note-video-bg'>
						<div class='et_lb_note-video-container clearfix'>"
							. ( '' != $video_url ? '<div class="et_note_video_container">' . apply_filters( 'the_content', $wp_embed->shortcode( '', esc_url( $video_url ) ) ) . '</div>' : '' )
							. do_shortcode( et_lb_fix_shortcodes($content) ) .
						"</div> <!-- end .et_lb_note-video-container-->
					</div> <!-- end .et_lb_note-video-bg-->
					<div class='et_lb_video-bottom-left'>
						<div class='et_lb_video-bottom-right'>
							<div class='et_lb_video-bottom-center'></div>
						</div>
					</div>
				</div> <!-- end .et_lb_note-video-->";

	return $output;
}

add_shortcode('et_lb_testimonial', 'et_lb_testimonial');
function et_lb_testimonial($atts, $content = null) {
	extract(shortcode_atts(array(
				'image_url' => '',
				'author_name' => '',
				'author_position' => '',
				'author_site' => ''
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_new-testimonial" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_module_content clearfix'>
						<div class='et_lb_testimonial-bottom'></div>"
						. ( '' != $image_url ?
							"<div class='et_lb_testimonial-image'>
								<img alt='' src='" . esc_attr( et_new_thumb_resize( et_multisite_thumbnail($image_url), 51, 51, '', true ) ) . "' />
								<span class='et_lb_overlay'></span>
							</div> <!-- end .et_lb_testimonial-image -->"
						: '' )
						. ( '' != $author_name ?
							"<h3>" . esc_html( $author_name ) . "</h3>"
						: '' )
						. "<p class='et_lb_testimonial-meta'>" . esc_html( $author_position )
							. ( '' != $author_site ? "<br />" . "<a href='" . esc_url( $author_site ) . "'>" . esc_html( $author_site ) . "</a>" : '' )
						. "</p>" . "<div class='clear'></div>"
						. do_shortcode( et_lb_fix_shortcodes($content) ) .
					"</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_new-testimonial-->";

	return $output;
}

add_shortcode('et_lb_slogan', 'et_lb_slogan');
function et_lb_slogan($atts, $content = null) {
	$attributes = et_lb_get_attributes( $atts, "et_lb_slogan" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_module_content clearfix'>"
						. do_shortcode( et_lb_fix_shortcodes($content) )
						. "<span class='right-quote'></span>" .
					"</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_slogan -->";

	return $output;
}

add_shortcode('et_lb_slider', 'et_lb_slider');
function et_lb_slider($atts, $content = null){
	global $et_lb_sliders_on_page, $et_lb_slider_imagesize;

	extract(shortcode_atts(array(
				'imagesize' => '',
				'animation' => 'fade',
				'animation_duration' => '600',
				'auto_animation' => 'off',
				'auto_speed' => '7000',
				'pause_on_hover' => 'off'
			), $atts));

	$et_lb_slider_imagesize = ( '' == $imagesize ) ? '' : $imagesize;
	$et_lb_sliders_on_page = isset( $et_lb_sliders_on_page ) ? ++$et_lb_sliders_on_page : 1;

	$class = '';
	if ( ! in_array( $animation, array('','fade') ) ) $class .= " et_lb_slider_effect_{$animation}";
	if ( ! in_array( $animation_duration, array('','600') ) ) $class .= " et_lb_slider_animation_duration_{$animation_duration}";
	if ( ! in_array( $auto_animation, array('','off') ) ) $class .= " et_lb_slider_animation_auto_{$auto_animation}";
	if ( ! in_array( $auto_speed, array('','7000') ) ) $class .= " et_lb_slider_animation_autospeed_{$auto_speed}";
	if ( ! in_array( $pause_on_hover, array('','off') ) ) $class .= " et_lb_slider_pause_hover_{$pause_on_hover}";

	$attributes = et_lb_get_attributes( $atts, "et_lb_slider flex-container{$class}" );

	$output = 	"<div id='" . esc_attr('et_lb_slider_' . $et_lb_sliders_on_page) . "' {$attributes['class']}{$attributes['inline_styles']}>
					<div class='flexslider'>
						<ul class='slides'>"
							. do_shortcode( et_lb_fix_shortcodes($content) ) .
						"</ul> <!-- end .slides -->
					</div> <!-- .flexslider -->
				</div> <!-- end .et_lb_slider -->";

	return $output;
}

add_shortcode('et_attachment', 'et_attachment');
function et_attachment($atts, $content = null){
	global $et_lb_slider_imagesize;

	extract(shortcode_atts(array(
				'attachment_id' => '',
				'link' => ''
			), $atts));

	$attachment_image = $image_size = '';
	$image = wp_get_attachment_image_src( $attachment_id, 'full' );

	if ( '' != $et_lb_slider_imagesize ){
		$image_size = explode( 'x', $et_lb_slider_imagesize );
		$image_size = array_map('intval', $image_size);
	}

	$attachment_image = ( '' != $image && '' == $et_lb_slider_imagesize ) ? $image[0] : et_new_thumb_resize( et_multisite_thumbnail( $image[0] ), $image_size[0], $image_size[1], '', true );
	if ( '' != $attachment_image ) $attachment_image = "<img alt='' src='" . esc_attr( $attachment_image ) . "' />" . "<span class='et_attachment_overlay'></span>";

	$output = 	"<li>"
					. ( '' != $link ? "<a href='" . esc_url( $link ) . "'>" . $attachment_image . "</a>" : $attachment_image )
					. ( '' != $content ? "<div class='flex-caption'>" . do_shortcode( et_lb_fix_shortcodes($content) ) . "</div>" : '' ) .
				"</li>";

	return $output;
}

add_shortcode('et_lb_button', 'et_lb_button');
function et_lb_button($atts, $content = null) {
	extract(shortcode_atts(array(
				'color' => 'blue',
				'size' => 'small',
				'url' => '',
				'window' => 'off',
				'align' => 'left'
			), $atts));

	$inline_styles = '';
	$class = " et_lb_button_{$color} et_lb_button_{$size}";

	if ( 'left' != $align ) $inline_styles .= " text-align: {$align};";
	$attributes = et_lb_get_attributes( $atts, "et_lb_button{$class}", $inline_styles );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<a " . ( 'on' == $window ? "target='_blank' " : "" ) . "href='" . esc_url( $url ) . "'>
						<span>" . do_shortcode( et_lb_fix_shortcodes($content) ) . "</span>
					</a>
				</div> <!-- end .et_lb_button -->";

	return $output;
}

add_shortcode('et_lb_bar', 'et_lb_bar');
function et_lb_bar($atts, $content = null) {
	$attributes = et_lb_get_attributes( $atts, "et_lb_bar" );

	$output = "<div {$attributes['class']}{$attributes['inline_styles']}></div>";

	return $output;
}

add_shortcode('et_lb_list', 'et_lb_list');
function et_lb_list($atts, $content = null) {
	extract(shortcode_atts(array(
				'type' => 'checkmark'
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_list et_lb_list_{$type}" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_list -->";

	return $output;
}

add_shortcode('et_lb_toggle', 'et_lb_toggle');
function et_lb_toggle($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
				'state' => 'close'
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_toggle et_lb_toggle_{$state}" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_module_content'>
						<div class='et_lb_module_content_inner'>
							<h3 class='et_lb_toggle_title'>{$heading}<span class='et_toggle'></span></h3>
							<div class='et_lb_toggle_content clearfix" . ( 'close' == $state ? ' et_lb_hidden' : '' ) . "'>"
								. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"			</div>
						</div> <!-- end .et_lb_module_content_inner -->
					</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_toggle -->";

	return $output;
}

add_shortcode('et_lb_tabs', 'et_lb_tabs');
function et_lb_tabs($atts, $content = null) {
	global $et_lb_tab_titles;

	$et_lb_tab_titles = array();
	$attributes = et_lb_get_attributes( $atts, "et_lb_tabs" );

	$tabs_content = "<div class='et_lb_module_content'>
						<div class='et_lb_module_content_inner'>"
							. do_shortcode( et_lb_fix_shortcodes($content) ) .
					"	</div> <!-- end .et_lb_module_content_inner -->
					</div> <!-- end .et_lb_module_content -->";

	$tabs = "<ul class='et_lb_tabs_nav clearfix'>";

	$i = 0;
	foreach ( $et_lb_tab_titles as $tab_title ){
		++$i;
		$tabs .= "<li" . ( 1 == $i ? ' class="et_lb_tab_active"' : '' ) . "><a href='#'>{$tab_title}</a></li>";
	}
	$tabs .= "</ul>";

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					{$tabs}
					{$tabs_content}
				</div> <!-- end .et_lb_tabs -->";

	return $output;
}

add_shortcode('et_lb_tab', 'et_lb_tab');
function et_lb_tab($atts, $content = null) {
	global $et_lb_tab_titles;

	extract(shortcode_atts(array(
				'title' => ''
			), $atts));

	$et_lb_tab_titles[] = '' != $title ? $title : 'Tab';

	$output = 	"<div class='clearfix et_lb_tab" . ( 1 != count( $et_lb_tab_titles ) ? " et_lb_tab_hidden" : '' ) . "'>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_tab -->";

	return $output;
}

add_shortcode('et_lb_simple_slider', 'et_lb_simple_slider');
function et_lb_simple_slider($atts, $content = null) {
	global $et_lb_simple_slides;

	$et_lb_simple_slides = 0;
	$attributes = et_lb_get_attributes( $atts, "et_lb_simple_slider" );

	$output =  "<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_simple_slider_nav'>
						<a href='#' class='et_lb_simple_slider_prev'>Previous</a>
						<a href='#' class='et_lb_simple_slider_next'>Next</a>
					</div>
					<div class='et_lb_simple_slider_content'>
						<div class='et_lb_module_content'>
							<div class='et_lb_module_content_inner clearfix'>"
								. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"			</div> <!-- end .et_lb_module_content_inner -->
						</div> <!-- end .et_lb_module_content -->
					</div> <!-- end .et_lb_simple_slider_content -->
				</div> <!-- end .et_lb_simple_slider -->";

	return $output;
}

add_shortcode('et_lb_simple_slide', 'et_lb_simple_slide');
function et_lb_simple_slide($atts, $content = null) {
	global $et_lb_simple_slides;
	++$et_lb_simple_slides;

	$output = 	"<div class='clearfix et_lb_simple_slide" . ( 1 != $et_lb_simple_slides ? " et_lb_slide_hidden" : ' et_lb_simple_slide_active' ) . "'>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_simple_slide -->";

	return $output;
}

add_shortcode('et_lb_pricing_table', 'et_lb_pricing_table');
function et_lb_pricing_table($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
				'price' => '',
				'old_price' => '',
				'button_text' => '',
				'button_url' => '#',
				'button_color' => 'blue'
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_pricing_table" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_module_content'>
						<div class='et_lb_module_content_inner clearfix'>
							<h3 class='et_lb_pricing_title'>{$heading}</h3>
							<div class='et_lb_pricing_content'>"
								. do_shortcode( et_lb_fix_shortcodes($content) ) .
								( '' != $old_price ? "<span class='et_lb_old_price'>{$old_price}</span>" : '' ) .
								( '' != $price ? "<span class='et_lb_price'>{$price}</span>" : '' )  .
					"		</div> <!-- end .et_lb_pricing_content -->
						</div> <!-- end .et_lb_module_content_inner -->"
						. ( '' != $button_text ? do_shortcode( "[et_lb_button size='medium' align='center' url='" . esc_url( $button_url ) . "' color='{$button_color}']{$button_text}[/et_lb_button]" ) : '' ) .
					"</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_button -->";

	return $output;
}

add_shortcode('et_lb_box', 'et_lb_box');
function et_lb_box($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
				'color' => 'blue'
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_box et_lb_box_{$color}" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_module_content clearfix'>"
						. ( '' != $heading ? "<h3 class='et_lb_box_title'>{$heading}</h3>" : '' )
						. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"	</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_box -->";

	return $output;
}

function et_lb_column( $atts, $content = null, $name = '' ){
	$attributes = et_lb_get_attributes( $atts, "et_lb_column {$name}" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_column_{$name} -->";

	return $output;
}

// dialog box columns
function et_lb_alt_column( $atts, $content = null, $name = '' ){
	$name = str_replace( 'alt_', '', $name );
	$attributes = et_lb_get_attributes( $atts, "et_lb_column {$name}" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_column_{$name} -->";

	return $output;
}

add_shortcode('et_lb_text_block', 'et_lb_text_block');
function et_lb_text_block($atts, $content = null) {
	$attributes = et_lb_get_attributes( $atts, "et_lb_text_block" );

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_text_block -->";

	return $output;
}

add_shortcode('et_lb_widget_area', 'et_lb_widget_area');
function et_lb_widget_area($atts, $content = null) {
	extract(shortcode_atts(array(
				'area' => 'Widget Area 1'
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_widget_area" );

	ob_start();
	dynamic_sidebar($area);
	$widgets = ob_get_contents();
	ob_end_clean();

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. $widgets .
				"</div> <!-- end .et_lb_widget_area -->";

	return $output;
}

add_shortcode('et_lb_image','et_lb_image');
function et_lb_image($atts, $content = null) {
	extract(shortcode_atts(array(
				'image_url' => '',
				'imagesize' => '',
				'image_title' => ''
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_image" );

	if ( '' != $imagesize ){
		$image_size = explode( 'x', $imagesize );
		$image_size = array_map('intval', $image_size);
	}

	$image = ( '' != $image_url && '' == $imagesize ) ? $image_url : et_new_thumb_resize( et_multisite_thumbnail( $image_url ), $image_size[0], $image_size[1], '', true );
	if ( '' != $image ) $image = "<img alt='' src='" . esc_attr( $image ) . "' title='' />";

	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_module_content'>
						<div class='et_lb_module_content_inner clearfix'>"
							. ( '' != $image ? '<div class="et_lb_image_box">' . "<a href='" . esc_url($image_url) . "' class='fancybox' title='" . esc_attr( $image_title ) . "'>{$image}<span class='et_lb_zoom_icon'></span></a>" . '</div>' : '' )
							. ( '' != trim($content) ? '<div class="et_lb_image_content">' . do_shortcode( et_lb_fix_shortcodes($content) ) . '</div> <!-- end .et_lb_image_content -->' : '' ) .
				"		</div> <!-- end .et_lb_module_content_inner -->
					</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_widget_area -->";

	return $output;
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

