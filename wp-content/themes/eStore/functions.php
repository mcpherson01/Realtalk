<?php
add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname, $default_colorscheme;
		$themename = "eStore";
		$shortname = "estore";
		$default_colorscheme = 'Default';

		$template_dir = get_template_directory();

		require_once($template_dir . '/epanel/custom_functions.php');

		require_once( $template_dir . '/includes/functions/sanitization.php' );

		require_once($template_dir . '/includes/functions/sidebars.php');

		load_theme_textdomain('eStore',$template_dir.'/lang');

		require_once($template_dir . '/epanel/core_functions.php');

		require_once($template_dir . '/includes/post_thumbnails_estore.php');

		include($template_dir . '/includes/widgets.php');

		require_once($template_dir . '/includes/functions/additional_functions.php');

		remove_action( 'admin_init', 'et_epanel_register_portability' );

		add_action( 'pre_get_posts', 'et_home_posts_query' );

		add_action( 'et_epanel_changing_options', 'et_delete_featured_ids_cache' );
		add_action( 'delete_post', 'et_delete_featured_ids_cache' );
		add_action( 'save_post', 'et_delete_featured_ids_cache' );

		add_action( 'wp_enqueue_scripts', 'et_load_scripts_styles' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		add_action( 'body_class', 'et_add_woocommerce_class_to_homepage' );

		// take breadcrumbs out of .container
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		// woocommerce_breadcrumb function is overwritten in functions.php
		add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 9, 0 );

		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		add_action( 'woocommerce_archive_description', 'et_woocommerce_after_archive_description', 9999 );
		add_action( 'woocommerce_before_main_content', 'et_woocommerce_before_main_content', 9999 );

		add_action( 'woocommerce_before_shop_loop', 'et_woocommerce_before_shop_loop_open', 5 );
		add_action( 'woocommerce_before_shop_loop', 'et_woocommerce_before_shop_loop_close', 9999 );

		add_action( 'woocommerce_before_single_product', 'et_woocommerce_before_single_product', 9999 );
		add_action( 'woocommerce_after_single_product', 'et_woocommerce_after_single_product', 9999 );

		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_after_main_content', 'et_woocommerce_after_main_content', 9999 );

		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

		add_filter( 'loop_shop_columns', 'et_woocommerce_archive_columns' );
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

function et_load_scripts_styles() {
	global $shortname;

	// load Raleway from Google Fonts
	$protocol = is_ssl() ? 'https' : 'http';
	$query_args = array(
		'family' => 'Raleway:400,300,200'
	);
	wp_enqueue_style( 'estore-fonts', esc_url( add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ) ), array(), null );

	$et_prefix = ! et_options_stored_in_one_row() ? "{$shortname}_" : '';
	$heading_font_option_name = "{$et_prefix}heading_font";
	$body_font_option_name = "{$et_prefix}body_font";

	$et_gf_enqueue_fonts = array();
	$et_gf_heading_font = sanitize_text_field( et_get_option( $heading_font_option_name, 'none' ) );
	$et_gf_body_font = sanitize_text_field( et_get_option( $body_font_option_name, 'none' ) );

	if ( ! empty( $et_gf_heading_font ) && 'none' != $et_gf_heading_font ) $et_gf_enqueue_fonts[] = $et_gf_heading_font;
	if ( ! empty( $et_gf_body_font ) && 'none' != $et_gf_body_font ) $et_gf_enqueue_fonts[] = $et_gf_body_font;

	if ( ! empty( $et_gf_enqueue_fonts ) ) et_gf_enqueue_fonts( $et_gf_enqueue_fonts );
}

// overwrite woocommerce_breadcrumb function to change wrap_before and wrap_after arguments
function woocommerce_breadcrumb( $args = array() ) {
	$defaults = array(
		'delimiter'   => ' <span class="raquo">&raquo;</span> ',
		'wrap_before' => '<div id="breadcrumbs" itemprop="breadcrumb">',
		'wrap_after'  => '<span class="raquo">&raquo;</span></div>',
		'before'      => '',
		'after'       => '',
		'home'        => esc_html__( 'Home', 'eStore' ),
	);

	$args = wp_parse_args( $args, $defaults  );


	if ( function_exists( 'WC' ) ) {
		$breadcrumbs = new WC_Breadcrumb();

		if ( $args['home'] ) {
			$breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
		}

		$args['breadcrumb'] = $breadcrumbs->generate();

		wc_get_template( 'global/breadcrumb.php', $args );
	} else {
		woocommerce_get_template( 'shop/breadcrumb.php', $args );
	}
}

add_action('wp_head','et_portfoliopt_additional_styles',100);
function et_portfoliopt_additional_styles(){ ?>
	<style type="text/css">
		#et_pt_portfolio_gallery { margin-left: -41px; }
		.et_pt_portfolio_item { margin-left: 31px; }
		.et_portfolio_small { margin-left: -40px !important; }
		.et_portfolio_small .et_pt_portfolio_item { margin-left: 29px !important; }
		.et_portfolio_large { margin-left: -24px !important; }
		.et_portfolio_large .et_pt_portfolio_item { margin-left: 4px !important; }
	</style>
<?php }

function register_main_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu' ),
			'secondary-menu' => __( 'Secondary Menu' )
		)
	);
};
if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );

/**
 * Gets featured posts IDs from transient, if the transient doesn't exist - runs the query and stores IDs
 */
function et_get_featured_posts_ids(){
	if ( false === ( $et_featured_post_ids = get_transient( 'et_featured_post_ids' ) ) ) {
		if ( class_exists( 'woocommerce' ) ) {
			// show WooCommerce products from taxonomy term set in ePanel
			$featured_cat = get_option('estore_feat_cat');
			$featured_num = get_option('estore_featured_num');
			$et_featured_term = get_term_by( 'name', $featured_cat, 'product_cat' );

			$featured_query = new WP_Query(
				apply_filters( 'et_woocommerce_featured_args',
					array(
						'post_type' => 'product',
						'posts_per_page' => (int) $featured_num,
						'meta_query' => array(
							array( 'key' => '_visibility', 'value' => array( 'catalog', 'visible' ),'compare' => 'IN' )
						),
						'tax_query' => array(
							array(
								'taxonomy' 	=> 'product_cat',
								'field' 	=> 'id',
								'terms' 	=> (int) $et_featured_term->term_id
							)
						)
					)
				)
			);
		} else {
			// grab normal posts from selected category
			$featured_query = new WP_Query( apply_filters( 'et_featured_post_args', array(
				'posts_per_page'	=> (int) et_get_option( 'estore_featured_num' ),
				'cat'				=> (int) get_catId( et_get_option( 'estore_feat_cat' ) )
			) ) );
		}

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

	/* Set the amount of posts per page on homepage */
	$query->set( 'posts_per_page', et_get_option( 'estore_homepage_posts', '6' ) );

	/* Exclude slider posts, if the slider is activated, pages are not featured and posts duplication is disabled in ePanel  */
	if ( 'on' == et_get_option( 'estore_featured', 'on' ) && 'false' == et_get_option( 'estore_use_pages', 'false' ) && 'false' == et_get_option( 'estore_duplicate', 'on' ) )
		$query->set( 'post__not_in', et_get_featured_posts_ids() );

	/* Exclude categories set in ePanel */
	$exclude_categories = et_get_option( 'estore_exlcats_recent', false );

	if ( ! class_exists( 'woocommerce' ) ) {
		if ( $exclude_categories ) $query->set( 'category__not_in', array_map( 'intval', et_generate_wpml_ids( $exclude_categories, 'category' ) ) );
	} else {
		/* Display WooCommerce products on homepage */
		$query->set( 'post_type', 'product' );
		$query->set( 'meta_query', WC()->query->get_meta_query() );

		$custom_tax_query = $exclude_categories
			? array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'operator' => 'NOT IN',
					'terms'    => (array) array_map( 'intval', $exclude_categories ),
				),
			)
			: array();

		$query->set( 'tax_query', WC()->query->get_tax_query( $custom_tax_query ) );
	}
}

/**
 * Deletes featured posts IDs transient, when the user saves, resets ePanel settings, creates or moves posts to trash in WP-Admin
 */
function et_delete_featured_ids_cache(){
	if ( false !== get_transient( 'et_featured_post_ids' ) ) delete_transient( 'et_featured_post_ids' );
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
		body { background-color: #<?php echo esc_html(get_option($shortname.'_color_bgcolor')); ?>; }
		.post a:link, .post a:visited { color: #<?php echo esc_html(get_option($shortname.'_color_mainlink')); ?>; }
		ul.nav li a { color: #<?php echo esc_html(get_option($shortname.'_color_pagelink')); ?>; }
		#sidebar h3 { color:#<?php echo esc_html(get_option($shortname.'_color_sidebar_titles')); ?>; }
		#footer, p#copyright { color:#<?php echo esc_html(get_option($shortname.'_color_footer')); ?> !important; }
		#footer a { color:#<?php echo esc_html(get_option($shortname.'_color_footer_links')); ?> !important; }
	</style>
<?php
}

function et_add_woocommerce_class_to_homepage( $classes ) {
	if ( is_home() ) $classes[] = 'woocommerce';

	return $classes;
}

if ( function_exists( 'get_custom_header' ) ) {
	// compatibility with versions of WordPress prior to 3.4

	add_action( 'customize_register', 'et_estore_customize_register' );
	function et_estore_customize_register( $wp_customize ) {
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
			'title'		=> __( 'Fonts', 'eStore' ),
			'priority'	=> 50,
		) );

		$wp_customize->add_setting( 'estore_heading_font', array(
			'default'		    => 'none',
			'type'			    => 'option',
			'capability'	    => 'edit_theme_options',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( 'estore_heading_font', array(
			'label'		=> __( 'Header Font', 'eStore' ),
			'section'	=> 'et_google_fonts',
			'settings'	=> 'estore_heading_font',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) );

		$wp_customize->add_setting( 'estore_body_font', array(
			'default'		    => 'none',
			'type'			    => 'option',
			'capability'	    => 'edit_theme_options',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( 'estore_body_font', array(
			'label'		=> __( 'Body Font', 'eStore' ),
			'section'	=> 'et_google_fonts',
			'settings'	=> 'estore_body_font',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) );
	}

	add_action( 'wp_head', 'et_estore_add_customizer_css' );
	add_action( 'customize_controls_print_styles', 'et_estore_add_customizer_css' );
	function et_estore_add_customizer_css(){ ?>
		<style type="text/css">
		<?php
			global $shortname;

			$et_prefix = ! et_options_stored_in_one_row() ? "{$shortname}_" : '';
			$heading_font_option_name = "{$et_prefix}heading_font";
			$body_font_option_name = "{$et_prefix}body_font";

			$et_gf_heading_font = sanitize_text_field( et_get_option( $heading_font_option_name, 'none' ) );
			$et_gf_body_font = sanitize_text_field( et_get_option( $body_font_option_name, 'none' ) );

			if ( 'none' != $et_gf_heading_font || 'none' != $et_gf_body_font ) :

				if ( ! empty( $et_gf_heading_font ) && 'none' != $et_gf_heading_font )
					et_gf_attach_font( $et_gf_heading_font, 'h1, h2, h3, h4, h5, h6, .description h2.title, .item-content h4, .product h3, .post h1, .post h2, .post h3, .post h4, .post h5, .post h6, .related-items span, .page-title, .product_title' );

				if ( ! empty( $et_gf_body_font ) && 'none' != $et_gf_body_font )
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

function et_woocommerce_after_archive_description() {
	if ( ! is_archive() ) {
		return;
	}

	echo '<div id="main-area">
			<div id="main-content" class="clearfix">
				<div id="left-column">';
}

function et_woocommerce_before_main_content() {
	if ( is_archive() ) {
		return;
	}

	echo '<div id="main-area">
			<div id="main-content" class="clearfix">
				<div id="left-column">';
}

function et_woocommerce_after_main_content() {
	if ( is_archive() ) {
		echo '<div class="clear"></div>
			<div id="et_archive_pagination" class="clearfix">
			</div> <!-- #et_archive_pagination -->
		</div><!--#left-column-->';
	} else {
		echo '</div><!--#left-column-->';
	}
}

function et_woocommerce_before_shop_loop_open() {
	echo '<div class="et_page_meta_info clearfix">';
}

function et_woocommerce_before_shop_loop_close() {
	echo '</div> <!-- .et_page_meta_info -->';
}

function et_woocommerce_archive_columns() {
	if ( is_archive() ) {
		return 3;
	} else {
		return 2;
	}
}

// override wocoommerce function which generates thumbnails for the archive page
function woocommerce_template_loop_product_thumbnail() {
	if ( is_archive() ) {
		global $post;
		$using_woocommerce = false;

		$thumb = '';
		$width = 193;
		$height = 130;
		$classtext = '';
		$titletext = get_the_title();

		$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, true );
		$thumb = $thumbnail["thumb"];

		if ( class_exists( 'woocommerce' ) ) {
			$using_woocommerce = true;

			$wc_product = function_exists( 'wc_get_product' ) ? wc_get_product( get_the_ID() ) : new WC_Product( get_the_ID() );
		}

		$custom = get_post_custom( $post->ID );

		if ( $using_woocommerce ) {
			$price = $wc_product->get_price_html();
		} else {
			$price = isset($custom["price"][0]) ? $custom["price"][0] : '';
			if ( $price !== '' ) {
				$price = get_option('estore_cur_sign') . $price;
			}
		}

		$et_band = isset($custom["et_band"][0]) ? 'et_' . $custom["et_band"][0] : ''; ?>

		<div class="product-content clearfix">
			<a href="<?php the_permalink(); ?>" class="image">
				<span class="rounded" style="background: url( '<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext, true, true ); ?>' ) no-repeat;"></span>
				<?php if ($price <> '') { ?>
					<span class="tag"><span><?php echo $price; ?></span></span>
				<?php }; ?>
			</a>

			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<p><?php truncate_post( 115 ); ?></p>
			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
			<a href="<?php the_permalink(); ?>" class="more"><span><?php esc_html_e( 'more info','eStore' ); ?></span></a>

			<?php if ( $et_band <> '' ) { ?>
				<span class="band<?php echo( ' '. esc_attr( $et_band ) ); ?>"></span>
			<?php }; ?>

			<?php if ( $using_woocommerce ) woocommerce_show_product_sale_flash( $post, $wc_product ); ?>
		</div> <!-- .product-content -->
<?php
	} else {
		$thumb = '';
		$width = 44;
		$height = 44;
		$classtext = '';
		$titletext = get_the_title();

		$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		$thumb = $thumbnail["thumb"];
	?>

		<?php if ( $thumb !== '' ) print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext ); ?>

		<span><?php the_title(); ?></span>
<?php
	}
}

function et_woocommerce_before_single_product() {
	global $product;
	$custom = get_post_custom( get_the_ID() );
	$et_band =  isset( $custom["et_band"][0] ) ? 'et_' . $custom["et_band"][0] : '';

	if ( $et_band <> '' ) {
		printf( '<div class="post clearfix"><span class="band %1$s"></span>', esc_attr( $et_band ) );
	} else {
		echo '<div class="post clearfix">';
	}
}

function et_woocommerce_show_product_images() {
	global $product, $post;
	$wc_product = function_exists( 'wc_get_product' ) ? wc_get_product( get_the_ID() ) : new WC_Product( get_the_ID() );
	$et_price = $wc_product->get_price_html();
	$custom = get_post_custom( get_the_ID() );

	$thumb = '';
	$width = 510;
	$height = 510;
	$classtext = '';
	$titletext = get_the_title();

	$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, true );
	$thumb = $thumbnail["thumb"];

	$custom["thumbs"] = isset( $custom["thumbs"][0] ) ? unserialize( $custom["thumbs"][0] ) : ''; ?>

	<?php $attachment_ids = $product->get_gallery_attachment_ids(); ?>

	<?php if ( $attachment_ids || ( '' !== $thumb && empty( $custom["thumbs"] ) ) ) { ?>
		<div id="product-slider">
			<div id="product-slides">
				<div class="item-slide images">
				<?php
					printf( '<a class="woocommerce-main-image zoom" itemprop="image" href="%1$s" title="%2$s" data-o_href="%1$s">',
						esc_url( $thumbnail['fullpath'] ),
						esc_attr( $titletext )
					);
					print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext );

					echo '</a>';

					woocommerce_show_product_sale_flash( $post, $wc_product );
				?>
				</div> <!-- .item-class -->
			</div> <!-- #product-slides -->

			<?php do_action('woocommerce_product_thumbnails'); ?>
		</div> <!-- #product-slider -->
	<?php } elseif ( ! empty( $custom["thumbs"] ) ) { ?>
		<div id="product-slider">
			<div id="product-slides">
				<?php for ( $i = 0; $i <= count( $custom["thumbs"] ) - 1; $i++ ) { ?>
					<div class="item-slide">
						<a href="<?php echo( $custom["thumbs"][ $i ] ); ?>" rel="gallery" class="fancybox">
							<?php echo et_new_thumb_resize( et_multisite_thumbnail( $custom["thumbs"][ $i ] ), 298, 226 ); ?>
							<span class="overlay"></span>
						</a>
					</div> <!-- .item-slide -->
				<?php }; ?>

				<?php woocommerce_show_product_sale_flash( $post, $wc_product ); ?>
			</div> <!-- #product-slides -->

				<?php if ( count( $custom["thumbs"] ) > 1 ) { ?>
					<div id="product-thumbs">
						<?php for ( $i = 0; $i <= count( $custom["thumbs"] ) - 1; $i++ ) { ?>
							<a href="#" <?php if( $i == 0 ) echo( 'class="active"' ); if ( $i==count( $custom["thumbs"] ) - 1 ) echo( 'class="last"' ) ?> rel="<?php echo( $i + 1 ); ?>">
								<?php echo et_new_thumb_resize( et_multisite_thumbnail( $custom["thumbs"][ $i ] ), 69, 69 ); ?>
								<span class="overlay"></span>
							</a>
						<?php }; ?>
					</div> <!-- #product-thumbs -->
				<?php }; ?>
		</div> <!-- #product-slider -->
	<?php }
}

function et_woocommerce_after_single_product() {
	echo '</div><!-- .post -->';
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

function et_theme_maybe_load_core() {
	if ( et_core_exists_in_active_plugins() ) {
		return;
	}

	if ( ! defined( 'ET_CORE' ) ) {
		require_once get_template_directory() . '/core/init.php';

		et_core_setup( get_template_directory_uri() );
	} else if ( defined( 'ET_CORE_VERSION' ) && '3.0.61' === ET_CORE_VERSION ) {
		require_once get_template_directory() . '/core/functions.php';
		et_core_patch_core_3061();
	}
}
add_action( 'after_setup_theme', 'et_theme_maybe_load_core' );

if ( ! function_exists( 'et_core_portability_link' ) && ! class_exists( 'ET_Builder_Plugin' ) ) :
function et_core_portability_link() {
	return '';
}
endif;
