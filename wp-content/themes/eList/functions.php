<?php
add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname, $default_colorscheme, $et_bg_texture_urls, $et_google_fonts, $epanel_texture_urls;
		$themename = "eList";
		$shortname = "elist";
		$default_colorscheme = "Default";

		$et_bg_texture_urls = array('Thin Vertical Lines', 'Small Squares', 'Thick Diagonal Lines', 'Thin Diagonal Lines', 'Diamonds', 'Small Circles', 'Thick Vertical Lines', 'Thin Flourish', 'Thick Flourish', 'Pocodot', 'Checkerboard', 'Squares', 'Noise', 'Wooden', 'Stone', 'Canvas');

		$et_google_fonts = apply_filters( 'et_google_fonts', array('Kreon','Droid Sans','Droid Serif','Lobster','Yanone Kaffeesatz','Nobile','Crimson Text','Arvo','Tangerine','Cuprum','Cantarell','Philosopher','Josefin Sans','Dancing Script','Raleway','Bentham','Goudy Bookletter 1911','Quattrocento','Ubuntu', 'PT Sans') );
		sort($et_google_fonts);

		$epanel_texture_urls = $et_bg_texture_urls;
		array_unshift( $epanel_texture_urls, 'Default' );

		$template_dir = get_template_directory();

		require_once($template_dir . '/epanel/custom_functions.php');

		require_once($template_dir . '/includes/functions/comments.php');

		require_once($template_dir . '/includes/functions/sidebars.php');

		load_theme_textdomain('eList',$template_dir.'/lang');

		require_once($template_dir . '/epanel/core_functions.php');

		require_once($template_dir . '/includes/post_thumbnails_elist.php');

		include($template_dir . '/includes/widgets.php');

		remove_action( 'admin_init', 'et_epanel_register_portability' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'automatic-feed-links' );

		add_action( 'pre_get_posts', 'et_home_posts_query' );
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
 * Filters the main query on homepage
 */
function et_home_posts_query( $query = false ) {
	/* Don't proceed if it's not homepage or the main query */
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() ) return;

	/* Set the amount of posts per page on homepage */
	$query->set( 'posts_per_page', (int) et_get_option( 'elist_recent_listings_num', '6' ) );

	$query->set( 'post_type', 'listing' );
}

add_action('wp_head','et_portfoliopt_additional_styles',100);
function et_portfoliopt_additional_styles(){ ?>
	<style type="text/css">
		#et_pt_portfolio_gallery { margin-left: -41px; margin-right: -51px; }
		.et_pt_portfolio_item { margin-left: 35px; }
		.et_portfolio_small { margin-left: -40px !important; }
		.et_portfolio_small .et_pt_portfolio_item { margin-left: 32px !important; }
		.et_portfolio_large { margin-left: -26px !important; }
		.et_portfolio_large .et_pt_portfolio_item { margin-left: 11px !important; }
	</style>
<?php }

function register_main_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu', 'eList' )
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

add_action( 'wp_enqueue_scripts', 'et_load_elist_scripts' );
function et_load_elist_scripts(){
	if ( !is_admin() ){
		$template_dir = get_template_directory_uri();

		wp_enqueue_script('easing', $template_dir . '/js/jquery.easing.1.3.js', array('jquery'), '1.0', true);
		wp_enqueue_script('cycle', $template_dir . '/js/jquery.cycle.all.min.js', array('jquery'), '1.0', true);
		wp_enqueue_script('custom_script', $template_dir . '/js/custom.js', array('jquery'), '1.0', true);
		wp_localize_script( 'custom_script', 'elist_settings', apply_filters( 'elist_custom_script_settings', array( 'home_url' => home_url() ) ) );

		$admin_access = apply_filters( 'et_showcontrol_panel', current_user_can('switch_themes') );
		if ( $admin_access && get_option('elist_show_control_panel') == 'on' ) {
			wp_enqueue_script('et_colorpicker', $template_dir . '/epanel/js/colorpicker.js', array('jquery'), '1.0', true);
			wp_enqueue_script('et_eye', $template_dir . '/epanel/js/eye.js', array('jquery'), '1.0', true);
			wp_enqueue_script('et_cookie', $template_dir . '/js/jquery.cookie.js', array('jquery'), '1.0', true);
			wp_enqueue_script('et_control_panel', $template_dir . '/js/et_control_panel.js', array('jquery'), '1.0', true);
			wp_localize_script( 'et_control_panel', 'elist_cp', apply_filters( 'elist_cp_settings', array( 'theme_folder' => $template_dir ) ) );
		}
	}
}

if ( ! function_exists( 'et_list_pings' ) ){
	function et_list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
	<?php }
}

add_action('init', 'et_elist_listing_register');
function et_elist_listing_register() {
	$labels = array(
		'name' => _x('Listings', 'post type general name','eList'),
		'singular_name' => _x('Listing', 'post type singular name','eList'),
		'add_new' => _x('Add Listing', 'listing item','eList'),
		'add_new_item' => __('Add New Listing','eList'),
		'edit_item' => __('Edit Listing','eList'),
		'new_item' => __('New Listing','eList'),
		'view_item' => __('View Listing','eList'),
		'search_items' => __('Search Listing','eList'),
		'not_found' =>  __('Nothing found','eList'),
		'not_found_in_trash' => __('Nothing found in Trash','eList'),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'listings' ),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','excerpt','comments','revisions','custom-fields','author')
	);

	register_post_type( 'listing' , $args );
}

add_action( 'init', 'et_elist_taxonomies_register', 0 );
function et_elist_taxonomies_register()
{
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name' => _x( 'Categories', 'taxonomy general name','eList' ),
		'singular_name' => _x( 'Category', 'taxonomy singular name','eList' ),
		'search_items' =>  __( 'Search Category','eList' ),
		'all_items' => __( 'All Categories','eList' ),
		'parent_item' => __( 'Parent Category','eList' ),
		'parent_item_colon' => __( 'Parent Category:','eList' ),
		'edit_item' => __( 'Edit Category','eList' ),
		'update_item' => __( 'Update Category','eList' ),
		'add_new_item' => __( 'Add New Category','eList' ),
		'new_item_name' => __( 'New Category Name','eList' ),
		'menu_name' => __( 'Categories','eList' ),
	);

	register_taxonomy('listing_category',array('listing'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => apply_filters( 'elist_rewrite_category_slug', 'listing-category' ) )
	));

	$labels = array(
		'name' => _x( 'Tags', 'taxonomy general name','eList' ),
		'singular_name' => _x( 'Tag', 'taxonomy singular name','eList' ),
		'search_items' =>  __( 'Search Tags','eList' ),
		'popular_items' => __( 'Popular Tags','eList' ),
		'all_items' => __( 'All Tags','eList' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Tag','eList' ),
		'update_item' => __( 'Update Tag','eList' ),
		'add_new_item' => __( 'Add New Tag','eList' ),
		'new_item_name' => __( 'New Tag Name','eList' ),
		'separate_items_with_commas' => __( 'Separate tags with commas','eList' ),
		'add_or_remove_items' => __( 'Add or remove tags','eList' ),
		'choose_from_most_used' => __( 'Choose from the most used tags','eList' ),
		'menu_name' => __( 'Tags','eList' ),
	);

	register_taxonomy('listing_tag','listing',array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => apply_filters( 'elist_rewrite_tag_slug', 'listing-tag' ) )
	));
}

add_action( 'admin_menu', 'et_elist_create_menu_link' );
function et_elist_create_menu_link(){
	$page = add_submenu_page( 'edit.php?post_type=listing', __( 'Custom Options', 'eList' ), __( 'Custom Options', 'eList' ), 'manage_options', 'et_elist_custom_options', 'et_elist_custom_options_screen' );

	add_action( "admin_print_scripts-{$page}", 'et_elist_custom_options_scripts' );
	add_action( "admin_print_styles-{$page}", 'et_elist_custom_options_css' );
}

function et_elist_custom_options_scripts(){
	$theme_folder = get_template_directory_uri();
	wp_enqueue_script( 'et_elist_custom_options', $theme_folder . '/js/et_elist_custom_options.js', array( 'jquery-ui-sortable', 'jquery-ui-draggable', 'jquery-ui-droppable' ) );
}

function et_elist_custom_options_css(){
	$theme_folder = get_template_directory_uri();
	wp_enqueue_style( 'et_elist_options_css', $theme_folder . '/css/elist_options.css' );
}

function et_elist_custom_options_screen(){
	$et_cp_usual_options = array(
		'title' => array(
			'name' => esc_html__( 'Title', 'eList' ),
			'type' => 'textinput'
		),
		'required' => array(
			'name' => esc_html__( 'This option is required', 'eList' ),
			'type' => 'checkbox'
		)
	);
	$et_cp_types = array(
		'textinput' => array(
			'name' => esc_html__( 'Text Input', 'eList' ),
			'description' => ''
		),
		'textarea' => array(
			'name' => esc_html__( 'Textarea', 'eList' ),
			'description' => ''
		)
	); ?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php esc_html_e( 'Custom Options Builder', 'eList' ); ?></h2>

		<?php
			$custom_options = get_option( 'elist_custom_options' );
			$custom_options_order = get_option( 'elist_custom_options_order' );
		?>
		<div class="et_widget-left">
			<div id="available-widgets" class="widgets-holder-wrap">
				<div class="sidebar-name">
					<h3><?php esc_html_e( 'Available Options', 'eList' ); ?></h3>
				</div>
				<div class="widget-holder">
					<p class="description"><?php esc_html_e('Drag fields from here to a sidebar on the right to activate them.', 'eList'); ?></p>

					<div id="widget-list">
						<?php foreach ( $et_cp_types as $key => $et_cp_type_value ) { ?>
							<div id="<?php echo esc_attr( 'et-cf-option-' . $key . '-__i__' ); ?>" class="widget ui-draggable">
								<div class="widget-top">
									<div class="widget-title-action">
										<a class="widget-action hide-if-no-js" href="#available-widgets"></a>
									</div>
									<div class="widget-title"><h4><?php echo esc_html( $et_cp_type_value['name'] ); ?><span class="in-widget-title"></span></h4></div>
								</div>

								<div class="widget-inside">
									<form action="" method="post">
										<div class="widget-content">
											<?php foreach ( $et_cp_usual_options as $et_cp_title => $et_cp_type ) { ?>
												<p>
													<?php
														$et_option_prefix = 'et-cf-option-' . $key;
														$et_option_id = $et_option_prefix . '-__i__-' . $et_cp_title;

														if ( in_array( $et_cp_type['type'], array( 'textinput', 'textarea' ) ) ){
															echo '<label for="' . esc_attr( $et_option_id ) . '">' . $et_cp_type['name'] . '</label> <input class="widefat" id="' . esc_attr( $et_option_id ) . '" name="' . esc_attr( $et_option_prefix . '-__i__['. $et_cp_title .']' ) . '" type="text" value="">';
														} elseif ( 'checkbox' == $et_cp_type['type'] ){
															echo '<input class="checkbox" type="checkbox" id="' . esc_attr( $et_option_id ) .'" name="' . esc_attr( $et_option_prefix . '-__i__['. $et_cp_title .']' ) .'"> <label for="' . esc_attr( $et_option_id ) .'">' . $et_cp_type['name'] . '</label>';
														}
													?>
												</p>
											<?php } ?>
										</div>

										<input type="hidden" name="widget-id" class="widget-id" value="<?php echo esc_attr( $key . '-__i__' ); ?>">
										<input type="hidden" name="id_base" class="id_base" value="<?php echo esc_attr( $key ); ?>">
										<input type="hidden" name="multi_number" class="multi_number" value="<?php echo esc_attr( et_max_number( $key, $custom_options_order['et_custom_options'] ) )?>">
										<input type="hidden" name="add_new" class="add_new" value="multi">

										<div class="widget-control-actions">
											<div class="alignleft">
												<a class="widget-control-remove" href="#remove"><?php echo esc_html( 'Delete', 'eList' ); ?></a> |
												<a class="widget-control-close" href="#close"><?php echo esc_html( 'Close', 'eList' ); ?></a>
											</div>
											<div class="alignright">
												<input type="submit" name="savewidget" id="<?php echo esc_attr( 'et-cf-option-' . $key . '-__i__-savewidget' ); ?>" class="button-primary widget-control-save" value="<?php echo esc_attr( 'Save', 'eList' ); ?>">
												<span class="spinner"></span>
											</div>
											<br class="clear">
										</div>
									</form>
								</div>

								<div class="widget-description">
									<?php echo esc_html( $et_cp_type_value['description'] ); ?>
								</div>
							</div>
						<?php } ?>
					</div>

					<br class='clear' />
				</div>
				<br class="clear" />
			</div>
		</div>

		<div class="et_widget-right">
			<div class="widgets-holder-wrap">
				<div class="sidebar-name">
					<h3><?php esc_html_e( 'Option Set', 'eList' ); ?>
					<span class="spinner"></span></h3>
				</div>

				<div id="et_custom_options" class="widgets-sortables ui-sortable" style="min-height: 194px; ">
					<?php
						if ( $custom_options_order['et_custom_options'] ){
							foreach( $custom_options_order['et_custom_options'] as $rendered_option_name ) { ?>
								<?php
									$et_rendered_field_name = substr( $rendered_option_name, 0, strpos( $rendered_option_name, '-' ) );
									$et_rendered_field_number = substr( $rendered_option_name, strpos( $rendered_option_name, '-' ) + 1, strlen( $rendered_option_name ) );
								?>

								<div id="<?php echo esc_attr( 'et-cf-option-' . $rendered_option_name ); ?>" class="widget ui-draggable">
									<div class="widget-top">
										<div class="widget-title-action">
											<a class="widget-action hide-if-no-js" href="#available-widgets"></a>
										</div>
										<div class="widget-title"><h4><?php echo esc_html( $et_cp_types[$et_rendered_field_name]['name'] ); ?><span class="in-widget-title"><?php echo esc_html( ': ' . $custom_options[$rendered_option_name]['title'] ); ?></span></h4></div>
									</div>

									<div class="widget-inside">
										<form action="" method="post">
											<div class="widget-content">
												<?php foreach ( $et_cp_usual_options as $et_cp_title => $et_cp_type ) { ?>
													<p>
														<?php
															$et_option_prefix = 'et-cf-option-' . $rendered_option_name;
															$et_option_id = $et_option_prefix . '-' . $et_cp_title;

															if ( in_array( $et_cp_type['type'], array( 'textinput', 'textarea' ) ) ){
																echo '<label for="' . esc_attr( $et_option_id ) . '">' . $et_cp_type['name'] . '</label> <input class="widefat" id="' . esc_attr( $et_option_id ) . '" name="' . esc_attr( $et_option_prefix . '[' . $et_cp_title . ']' ) . '" type="text" value="' . esc_attr( $custom_options[$rendered_option_name][$et_cp_title] ) . '">';
															} elseif ( 'checkbox' == $et_cp_type['type'] ){
																$et_checked = isset( $custom_options[$rendered_option_name][$et_cp_title] ) && 'on' == $custom_options[$rendered_option_name][$et_cp_title] ? ' checked="checked"' : '';

																echo '<input class="checkbox" type="checkbox" id="' . esc_attr( $et_option_id ) .'" name="' . esc_attr( $et_option_prefix . '[' . $et_cp_title . ']' ) .'"' . esc_html( $et_checked ) . '> <label for="' . esc_attr( $et_option_id ) .'">' . $et_cp_type['name'] . '</label>';
															}
														?>
													</p>
												<?php } ?>
											</div>

											<input type="hidden" name="widget-id" class="widget-id" value="<?php echo esc_attr( $rendered_option_name ); ?>">
											<input type="hidden" name="id_base" class="id_base" value="<?php echo esc_attr( $et_rendered_field_name ); ?>">
											<input type="hidden" name="multi_number" class="multi_number" value="4">
											<input type="hidden" name="add_new" class="add_new" value="">

											<div class="widget-control-actions">
												<div class="alignleft">
													<a class="widget-control-remove" href="#remove">Delete</a> |
													<a class="widget-control-close" href="#close">Close</a>
												</div>
												<div class="alignright">
													<input type="submit" name="savewidget" id="widget-<?php echo esc_attr( $rendered_option_name ); ?>-savewidget" class="button-primary widget-control-save" value="Save">
													<span class="spinner"></span>
												</div>
												<br class="clear">
											</div>
										</form>
									</div>
								</div>
						<?php
							}
						}
					?>
				</div>
			</div>
		</div>

		<form action="" method="post">
			<?php wp_nonce_field( 'et_save-listings', '_wpnonce_et_listings_options', false ); ?>
		</form>
	</div>
<?php
}

if ( ! function_exists( 'et_max_number' ) ){
	function et_max_number( $key, $options ){
		$max = 0;

		if ( ! empty( $options ) ){
			foreach ( $options as $option ){
				if ( false !== strpos( $option, $key ) ){
					$option_number = (int) str_replace( $key . '-', '', $option );
					$max = max( $max, $option_number );
				}
			}
		}
		return ( $max + 1 );
	}
}

add_action( 'wp_ajax_listings-options-order', 'elist_listings_options_order' );
function elist_listings_options_order(){
	check_ajax_referer( 'et_save-listings', 'save_listings_order' );

	if ( !current_user_can('edit_theme_options') )
		die('-1');

	unset( $_POST['save_listings_order'], $_POST['action'] );

	if ( is_array($_POST['custom_options']) ) {
		$custom_options_order = array();
		foreach ( $_POST['custom_options'] as $key => $val ) {
			$sb = array();
			if ( !empty($val) ) {
				$val = explode(',', $val);
				foreach ( $val as $k => $v ) {
					if ( strpos($v, 'et-cf-option-') === false )
						continue;
					$sb[$k] = str_replace( 'et-cf-option-', '', $v );
				}
			}
			$custom_options_order[$key] = $sb;
		}
		update_option( 'elist_custom_options_order', $custom_options_order );
		die('1');
	}

	die('-1');
}

add_action( 'wp_ajax_listings-option-save', 'elist_listings_option_save' );
function elist_listings_option_save(){
	check_ajax_referer( 'et_save-listings', 'save_listings_option' );

	if ( !current_user_can('edit_theme_options') || !isset($_POST['id_base']) ) die('-1');

	$listings_options = (array) get_option( 'elist_custom_options', array() );

	$id_base = $_POST['id_base'];
	$widget_id = $_POST['widget-id'];

	$widget_number = (int) substr( $widget_id, -1 );

	$sidebar_id = $_POST['sidebar'];
	$multi_number = !empty($_POST['multi_number']) ? (int) $_POST['multi_number'] : 0;
	$settings = isset($_POST['et-cf-option-' . $widget_id]) ? $_POST['et-cf-option-' . $widget_id] : false;
	$error = '<p>' . __('An error has occurred. Please reload the page and try again.') . '</p>';

	$sidebar = array();

	if ( isset($_POST['delete_widget']) && $_POST['delete_widget'] ) {
		unset( $listings_options[$widget_id] );
		update_option( 'elist_custom_options', $listings_options );
		die('1');
	} elseif ( $settings ) {
		$listings_options[$widget_id] = $settings;
		update_option( 'elist_custom_options', $listings_options );
		die('1');
	}

	die('-1');
}

add_action("admin_init", "elist_custom_settings");
function elist_custom_settings(){
	add_meta_box("et_post_meta", __( 'ET Settings', 'eList' ) , "elist_listing_options", "listing", "normal", "high");
}

function elist_listing_options( $callback_args ) {
	global $post;

	$custom_options = get_option( 'elist_custom_options' );
	$custom_options_order = get_option( 'elist_custom_options_order' ); ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'et_elist_settings_nonce' ); ?>

	<div id="et_custom_settings" style="margin: 13px 0 17px 4px;">
		<div class="et_fs_setting" style="margin: 13px 0 26px 4px;">
			<?php $featured_checked = get_post_meta( $post->ID, '_elist_featured', true ) && 'on' == get_post_meta( $post->ID, '_elist_featured', true ) ? ' checked="checked"' : ''; ?>
			<label for="_elist_featured" class="selectit"><input name="_elist_featured" type="checkbox" id="_elist_featured"<?php echo esc_html( $featured_checked ); ?>> <?php esc_html_e( 'This listing is featured.' ); ?></label>
		</div> <!-- .et_fs_setting -->

		<?php do_action( 'et_display_custom_options', $post->ID ); ?>

		<?php
			if ( $custom_options_order['et_custom_options'] ){
				foreach ( $custom_options_order['et_custom_options'] as $custom_option_title ){
					$custom_option_type = substr( $custom_option_title, 0, strpos( $custom_option_title, '-' ) );
					$custom_option_name = '_et_cf_' . $custom_option_title;
					$custom_option_value = get_post_meta( $post->ID, $custom_option_name, true ) ? get_post_meta( $post->ID, $custom_option_name, true ) : '';

					echo '<div class="et_fs_setting" style="margin: 13px 0 26px 4px;">';

					echo '<label for="'. esc_attr( $custom_option_name ) .'" style="color: #000; font-weight: bold;">' . esc_html( $custom_options[$custom_option_title]['title'] ) . ': </label>';

					if ( 'textinput' == $custom_option_type ){
						echo '<input type="text" style="width: 30em;" value="' . esc_attr( $custom_option_value ) . '" id="' . esc_attr( $custom_option_name ) . '" name="' . esc_attr( $custom_option_name ) . '" size="67" />';
					} elseif ( 'textarea' == $custom_option_type ){
						echo '<br /> <textarea id="' . esc_attr( $custom_option_name ) . '" name="'.esc_attr( $custom_option_name ).'" cols="40" rows="1" style="display: inline; position: relative; top: 5px; width: 490px; height: 125px;">' . esc_textarea( $custom_option_value ) . '</textarea>';
					}

					echo '</div> <!-- .et_fs_setting -->';
				}
			}
		?>
	</div> <!-- #et_custom_settings -->
	<?php
}

add_action( 'save_post', 'elist_save_custom_settings', 10, 2 );
function elist_save_custom_settings( $post_id, $post ){
	global $pagenow;
	if ( 'post.php' != $pagenow ) return $post_id;

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	if ( !isset( $_POST['et_elist_settings_nonce'] ) || !wp_verify_nonce( $_POST['et_elist_settings_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	$custom_options_order = get_option( 'elist_custom_options_order' );

	if ( $custom_options_order['et_custom_options'] ){
		foreach ( $custom_options_order['et_custom_options'] as $custom_option_title ){
			$custom_option_type = substr( $custom_option_title, 0, strpos( $custom_option_title, '-' ) );
			$custom_option_name = '_et_cf_' . $custom_option_title;

			update_post_meta( $post_id, $custom_option_name, wp_kses_post( $_POST[$custom_option_name] ) );
		}
	}

	if ( isset( $_POST['_elist_featured'] ) && 'on' == $_POST['_elist_featured'] ) update_post_meta( $post_id, '_elist_featured', 'on' );
	else delete_post_meta( $post_id, '_elist_featured' );

	do_action( 'et_save_custom_options', $post_id );
}

add_action( 'listing_category_add_form_fields', 'et_add_category_image_uploader' );
function et_add_category_image_uploader(){
	echo '<div class="form-field">';
		echo '<label for="et_elist_category_image">' . esc_html__('Category Image', 'eList') . '</label>';
		echo '<input name="et_elist_category_image" id="et_elist_category_image" type="text" value="" size="40" style="float: left; width: 78%;" />';
		echo '<a class="elist_upload_image_button button" href="#" style="float: left; margin-left: 10px;">' . esc_html__('Upload Image','eList') . '</a>';
		echo '<br style="clear: both;" />';
		echo '<p>' . esc_html__('Upload an image to use for this category','eList') . '</p>';
	echo '</div>';
}

add_action( 'listing_category_edit_form', 'et_edit_category_image_uploader' );
function et_edit_category_image_uploader(){
	$elist_category_images = get_option( 'elist_category_images', array() );
	$value = isset( $elist_category_images[$_GET['tag_ID']] ) ? $elist_category_images[$_GET['tag_ID']] : '';

	echo '<table class="form-table"><tbody><tr class="form-field et_category_image_uploader">';
		echo '<th scope="row" valign="top"><label for="et_elist_category_image">' . esc_html__('Category Image', 'eList') . '</label></th>';
		echo '<td><input name="et_elist_category_image" id="et_elist_category_image" type="text" value="' . esc_url( $value ) .'" size="40" style="float: left; width: 90%;" />';
		echo '<a class="elist_upload_image_button button" href="#" style="float: left; margin-left: 10px;">' . esc_html__('Upload Image','eList') . '</a>';
		echo '<br style="clear: both;" />';
		if ( '' != $value ) echo '<img src="' . esc_attr( et_new_thumb_resize( et_multisite_thumbnail($value), 200, 200, '', true ) ) . '" style="border: 4px solid #eee; margin-top: 8px;" alt="" id="et_category_image" />';
		echo '<p class="description">' . esc_html__('Upload an image to use for this category','eList') . '</p></td>';
	echo '</tr></tbody></table>';
}

add_action( 'created_term', 'elist_create_edit_term_image_save', 10, 3 );
add_action( 'edited_term', 'elist_create_edit_term_image_save', 10, 3 );
function elist_create_edit_term_image_save( $term_id, $tt_id, $taxonomy ){
	if ( 'listing_category' != $taxonomy || !isset( $_POST['et_elist_category_image'] ) ) return;

	$elist_category_images = get_option( 'elist_category_images', array() );
	$elist_category_images[$term_id] = esc_url_raw( $_POST['et_elist_category_image'] );
	update_option( 'elist_category_images', (array) $elist_category_images );
}

add_action( 'admin_print_scripts-edit-tags.php', 'elist_taxonomy_admin_js' );
function elist_taxonomy_admin_js(){
	$theme_folder = get_template_directory_uri();
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
	wp_enqueue_script( 'et_elist_uploader', $theme_folder . '/js/et_elist_uploader.js', array( 'jquery' ) );
}

add_action( 'admin_print_styles-edit-tags.php', 'elist_taxonomy_admin_css' );
function elist_taxonomy_admin_css(){
	wp_enqueue_style( 'thickbox' );
}

add_action( 'et_header_top', 'elist_display_breadcrumb' );
function elist_display_breadcrumb(){
	if ( ! is_home() ) get_template_part('includes/breadcrumbs','index');
}

function elist_get_listing_fields(){
	$custom_options = get_option( 'elist_custom_options' );
	$custom_options_order = get_option( 'elist_custom_options_order' );

	$listing_fields = apply_filters( 'elist_listing_fields', array(
		'title' => array(
			'name' => esc_html__( 'Title', 'eList' ),
			'field' => 'textinput',
			'required' => true
		),
		'content' => array(
			'name' => esc_html__( 'Content', 'eList' ),
			'field' => 'textarea',
			'required' => true
		),
		'image' => array(
			'name' => esc_html__( 'Image: ', 'eList' ),
			'field' => 'upload'
		),
		'tags' => array(
			'name' => esc_html__( 'Tags', 'eList' ),
			'field' => 'textinput'
		),
		'category' => array(
			'name' => esc_html__( 'Category', 'eList' ),
			'field' => 'select',
			'required' => true
		)
	) );

	$listing_custom_fields = array();
	if ( $custom_options_order['et_custom_options'] ){
		foreach ( $custom_options_order['et_custom_options'] as $custom_option_title ){
			$required = isset( $custom_options[$custom_option_title]['required'] ) && 'on' == $custom_options[$custom_option_title]['required'] ? true : false;
			$listing_custom_fields[$custom_option_title] = array(
				'name' => esc_html( $custom_options[$custom_option_title]['title'] ),
				'field' => substr( $custom_option_title, 0, strpos( $custom_option_title, '-' ) ),
				'required' => $required
			);
		}
	}

	$listing_custom_fields = apply_filters( 'elist_listing_custom_fields', $listing_custom_fields );

	$listing_fields = array_merge( $listing_fields, $listing_custom_fields );

	return $listing_fields;
}

add_action( 'elist_submit_before_content', 'elist_listing_check_user_rights', 10 );
function elist_listing_check_user_rights(){
	if ( elist_can_user_submit_listing() ) return;

	if ( ! get_option('users_can_register') ) { ?>
		<h3><?php esc_html_e('Users cannot currently register themselves, only administrator can manually create users.', 'eList' ); ?></h3>
	<?php } else { ?>
		<div id="register-form">
			<h2><?php esc_html_e('Login', 'eList'); ?></h2>

			<?php wp_login_form( array( 'redirect' => get_permalink() ) ); ?>

			<div class="clear"></div>

			<div class="page-separator"></div>

			<h2><?php esc_html_e('Register your Account', 'eList'); ?></h2>

			<form action="<?php echo esc_url( site_url('wp-login.php?action=register', 'login_post') ); ?>" method="post">
				<p class="clearfix">
					<label for="user_login" class="inputlable"><?php esc_html_e('Username','eList'); ?>:</label>
					<input type="text" name="user_login" value="" id="user_login" class="input" />
				</p>

				<p class="clearfix">
					<label for="user_email" class="inputlable"><?php esc_html_e('E-Mail','eList'); ?>:</label>
					<input type="text" name="user_email" value="" id="user_email" class="input"  />
				</p>

				<?php do_action('register_form'); ?>
				<p><input type="submit" value="<?php esc_attr_e('Register','eList'); ?>" id="register" class="register" /></p>

				<p class="statement"><?php esc_html_e('A password will be e-mailed to you.', 'eList');?></p>
			</form>
		</div>
	<?php }
}

add_action( 'elist_submit_before_content', 'elist_listing_validate_form', 20 );
function elist_listing_validate_form(){
	if ( ! isset( $_POST['_wpnonce-et-listing-form-submitted'] ) || ! wp_verify_nonce( $_POST['_wpnonce-et-listing-form-submitted'], 'et-listing-form-submit' ) )
		return;

	if ( ! elist_can_user_submit_listing() ) return;
	if ( ! $_POST ) return;

	if ( isset( $_GET['elist_paypal_return'] ) && '1' == $_GET['elist_paypal_return'] ){
		remove_action( 'elist_submit_after_content', 'elist_listing_display_form' );
		echo '<p id="elist_submit_successful">' . esc_html__( 'Your listing was submitted successfully. ', 'eList' ) . '</p>';
		return;
	}

	$listing_fields = elist_get_listing_fields();
	$errors = array();

	foreach ( $listing_fields as $field_title => $field_options ){
		if ( ! isset( $field_options['required'] ) || ! $field_options['required'] ) continue;

		if ( ! isset( $_POST['elist_' . $field_title] ) || '' == $_POST['elist_' . $field_title] ) $errors[] = sprintf( esc_html__( 'Please, fill %s field.', 'eList' ), $field_options['name'] );
	}

	if ( empty( $errors ) ){
		do_action( 'elist_listing_validation_succesful' );
	} else {
		foreach ( $errors as $error ){
			echo '<p class="elist_submit_error">' . $error . '</p>';
		}
	}
}

add_action( 'elist_listing_validation_succesful', 'elist_on_succesful_validation' );
function elist_on_succesful_validation(){
	$custom_options_order = get_option( 'elist_custom_options_order' );
	$needs_featured_payment = isset( $_POST['elist_make_featured'] ) ? true : false;

	$publish_post = 'draft';
	if ( 'false' == get_option('elist_sumbit_as_drafts','on') && 'false' == get_option('elist_paid_listings','false') && ! $needs_featured_payment ) $publish_post = 'publish';

	$publish_post = apply_filters( 'elist_publish_post', $publish_post, $needs_featured_payment );

	$new_post_options = array(
		'post_title' => strip_tags( $_POST['elist_title'] ),
		'post_content' =>  wp_kses_post( $_POST['elist_content'] ),
		'post_status' => $publish_post,
		'post_type' => apply_filters( 'elist_create_post_type', 'listing' )
	);

	$post_id = wp_insert_post( $new_post_options );

	if ( $custom_options_order['et_custom_options'] ){
		foreach ( $custom_options_order['et_custom_options'] as $custom_option_title ){
			$cf_form_field = 'elist_'.$custom_option_title;
			if ( isset( $_POST[$cf_form_field] ) && '' != $_POST[$cf_form_field] ) update_post_meta( $post_id, '_et_cf_' . $custom_option_title, wp_kses_post( $_POST[$cf_form_field] ) );
		}
	}

	if ( $_FILES['elist_image'] && UPLOAD_ERR_OK === $_FILES['elist_image']['error'] ){
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		require_once(ABSPATH . "wp-admin" . '/includes/media.php');

		$attachment_id = media_handle_upload( 'elist_image', $post_id );
		update_post_meta( $post_id, '_thumbnail_id', $attachment_id );
	}

	if ( $post_id ){
		wp_set_post_terms( $post_id, array( (int) $_POST['elist_category'] ), 'listing_category' );
		wp_set_post_terms( $post_id, strip_tags( $_POST['elist_tags'] ), 'listing_tag' );

		if ( $needs_featured_payment ) update_post_meta( $post_id, '_make_listing_featured', 'on' );

		if ( $needs_featured_payment || 'on' == get_option('elist_paid_listings','false') ) elist_display_paypal_form( $post_id );

		do_action( 'elist_listing_created', $post_id );

		remove_action( 'elist_submit_after_content', 'elist_listing_display_form' );
		echo '<p id="elist_submit_successful">' . esc_html__( 'Your listing was submitted successfully. ', 'eList' ) . '</p>';
		if ( 'publish' != $publish_post ) echo '<p id="elist_admin_approve"><small>' . esc_html__( 'Site admin should approve this listing to make it visible.', 'eList' ) . '</small></p>';
	}
}

add_action( 'elist_submit_after_content', 'elist_listing_display_form' );
function elist_listing_display_form(){
	if ( ! elist_can_user_submit_listing() ) return;

	$listing_fields = elist_get_listing_fields();

	echo '<p id="elist_required_message">' . esc_html__( 'Required fields are marked *', 'eList' ) . '</p>';

	if ( 'on' == get_option('elist_paid_listings','false') ) echo '<p id="elist_standart_subscription_field">' . sprintf( esc_html__( 'Standard subscription price: %s', 'eList' ), get_option( 'elist_paypal_currency_sign', '$' ) . get_option('elist_standart_subscription', '19.99') ) . '</p>';

	echo '<form action="' . esc_url( get_permalink() ) . '" method="post" id="elist_submit_form" enctype="multipart/form-data">';

	foreach ( $listing_fields as $field_name => $field_options ){
		$field_id = 'elist_' . $field_name;
		$required = isset( $field_options['required'] ) && $field_options['required'] ? '<span class="required">*</span>' : '';

		echo '<p>' . '<label for="' . esc_attr( $field_id ) . '">' . $field_options['name'] . '</label>' . $required;

		$posted_value = isset( $_POST[$field_id] ) ? $_POST[$field_id] : '';
		switch ( $field_options['field'] ) {
			case 'textinput':
				echo '<input id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $field_id ) . '" type="text" value="' . esc_attr( $posted_value ) . '" />';
				break;
			case 'textarea':
				echo '<textarea id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $field_id ) . '" cols="45" rows="8">' . esc_textarea( $posted_value ) . '</textarea>';
				break;
			case 'select':
				if ( 'category' == $field_name ){
					wp_dropdown_categories( apply_filters( 'elist_listing_category_args', array( 'taxonomy' => 'listing_category', 'hide_empty' => 0, 'name' => $field_id, 'orderby' => 'name', 'hierarchical' => true ) ) );
				} else {
					echo '<textarea id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $field_id ) . '" cols="45" rows="8">' . esc_textarea( $posted_value ) . '</textarea>';
				}
				break;
			case 'upload':
				$input_hidden = '';
				if ( isset( $_FILES[$field_id]['name'] ) && '' != $_FILES[$field_id]['name'] ){
					echo '<span class="elist_image_attached">' . sprintf( esc_html__( 'You attached \'%s\' image', 'eList' ), $_FILES[$field_id]['name'] ) . '<span>';
					$input_hidden = ' style="display: none;"';
				}

				echo '<input type="file" name="' . esc_attr( $field_id ) . '"' . $input_hidden . ' />';
				break;
		}

		echo '</p>';
	}

	do_action( 'elist_after_listing_submit_form' );

	$elist_make_featured_checked = isset( $_POST['elist_make_featured'] ) ? ' checked="checked"' : '';
	echo '<p id="elist_featured_listing_field">' . '<input name="elist_make_featured" type="checkbox" id="elist_make_featured" value=""' . esc_html( $elist_make_featured_checked ) . ' />' . sprintf( esc_html__( 'Make this listing featured for %1$s days ( + %2$s )', 'eList' ), get_option( 'elist_paid_listing_expire_days', '10' ), get_option( 'elist_paypal_currency_sign', '$' ) . get_option( 'elist_featured_subscription', '9.99' ) ) . '</p>';

	echo '<input name="submit" type="submit" id="submit" value="' . esc_attr__( 'Submit', 'eList' ) . '">';

	wp_nonce_field( 'et-listing-form-submit', '_wpnonce-et-listing-form-submitted' );

	echo '</form> <!-- end #elist_submit_form -->';
}

if ( ! function_exists('elist_can_user_submit_listing') ){
	function elist_can_user_submit_listing(){
		return is_user_logged_in();
	}
}

add_action( 'elist_after_listing', 'elist_display_additional_info', 10 );
function elist_display_additional_info(){
	global $post;
	$custom_options = get_option( 'elist_custom_options' );
	$custom_options_order = get_option( 'elist_custom_options_order' );
	$output = '';

	if ( $custom_options_order['et_custom_options'] ){
		foreach ( $custom_options_order['et_custom_options'] as $custom_option_title ){
			$cf = get_post_meta( $post->ID, '_et_cf_' . $custom_option_title, true );
			if ( '' != $cf ){
				$output .= '<div class="elist_cf">';
				$output .= 		'<h3>' . esc_html( $custom_options[$custom_option_title]['title'] ) . ':' . '</h3>';
				$output .= 		wpautop( wp_kses_post( $cf ) );
				$output .= '</div> <!-- end .elist_cf -->';
			}
		}
	}

	$output = apply_filters( 'elist_additional_info', $output );

	if ( '' != $output ) { ?>
		<div class="hr"></div>

		<section id="listing_info">
			<h1><?php esc_html_e( 'Additional Info', 'eList' ); ?></h1>
			<?php echo $output; ?>
		</section>
	<?php }
}

add_filter( 'elist_listing_fields', 'elist_listing_add_more_fields' );
function elist_listing_add_more_fields( $fields ){
	if ( 'on' == get_option('elist_show_google_maps_field','on') )
		$fields['gmaps'] = array(
			'name' => esc_html__( 'Address', 'eList' ),
			'field' => 'textinput',
			'required' => false
		);

	if ( 'on' == get_option('elist_show_company_website_field','on') )
		$fields['company_website'] = array(
			'name' => esc_html__( 'Company Website', 'eList' ),
			'field' => 'textinput',
			'required' => false
		);

	return $fields;
}

add_action( 'elist_listing_created', 'elist_process_additional_fields' );
function elist_process_additional_fields( $post_id ){
	if ( 'on' == get_option('elist_show_google_maps_field','on') && isset( $_POST['elist_gmaps'] ) )
		update_post_meta( $post_id, '_et_cf_gmaps_address', strip_tags( $_POST['elist_gmaps'] ) );
	if ( 'on' == get_option('elist_show_company_website_field','on') && isset( $_POST['elist_company_website'] ) )
		update_post_meta( $post_id, '_et_cf_company_website', esc_url_raw( $_POST['elist_company_website'] ) );
}

add_filter( 'et_display_custom_options', 'et_display_gmaps_site_options' );
function et_display_gmaps_site_options( $post_id ){
	if ( 'on' == get_option('elist_show_google_maps_field','on') ){
		echo '<div class="et_fs_setting" style="margin: 13px 0 26px 4px;">';
		echo 	'<label for="_et_cf_gmaps_address" style="color: #000; font-weight: bold;">' . esc_html__( 'Google Maps Address: ', 'eList' ) . ' </label>';
		echo 	'<input type="text" style="width: 30em;" value="' . esc_attr( get_post_meta( $post_id, '_et_cf_gmaps_address', true ) ) . '" id="_et_cf_gmaps_address" name="_et_cf_gmaps_address" size="67" />';
		echo '</div> <!-- .et_fs_setting -->';
	}

	if ( 'on' == get_option('elist_show_company_website_field','on') ){
		echo '<div class="et_fs_setting" style="margin: 13px 0 26px 4px;">';
		echo 	'<label for="_et_cf_company_website" style="color: #000; font-weight: bold;">' . esc_html__( 'Company Website: ', 'eList' ) . ' </label>';
		echo 	'<input type="text" style="width: 30em;" value="' . esc_url( get_post_meta( $post_id, '_et_cf_company_website', true ) ) . '" id="_et_cf_company_website" name="_et_cf_company_website" size="67" />';
		echo '</div> <!-- .et_fs_setting -->';
	}
}

add_filter( 'et_save_custom_options', 'et_save_gmaps_site_options' );
function et_save_gmaps_site_options( $post_id ){
	if ( isset( $_POST['_et_cf_gmaps_address'] ) ) update_post_meta( $post_id, '_et_cf_gmaps_address', strip_tags( $_POST['_et_cf_gmaps_address'] ) );
	if ( isset( $_POST['_et_cf_company_website'] ) ) update_post_meta( $post_id, '_et_cf_company_website', esc_url_raw( $_POST['_et_cf_company_website'] ) );
}

add_filter( 'elist_additional_info', 'elist_additional_info_add_website' );
function elist_additional_info_add_website( $output ){
	global $post;

	$website_link_output = '';
	$link = get_post_meta( $post->ID, '_et_cf_company_website', true ) ? get_post_meta( $post->ID, '_et_cf_company_website', true ) : '';

	if ( 'on' == get_option('elist_show_company_website_field','on') && '' != $link ){
		$website_link_output .= '<div class="elist_cf">';
		$website_link_output .= 		'<h3>' . esc_html__( 'Company Website', 'eList' ) . ':' . '</h3>';
		$website_link_output .= 		'<p>' . '<a href="' . esc_url( $link ) . '" target="_blank">' . esc_url( $link ) . '</a>' . '</p>';
		$website_link_output .= '</div> <!-- end .elist_cf -->';
	}

	return $website_link_output . $output;
}

add_action( 'elist_after_listing', 'elist_display_gmaps', 20 );
function elist_display_gmaps(){
	global $post;
	$et_address = get_post_meta( $post->ID, '_et_cf_gmaps_address', true );
	if ( '' != $et_address ) { ?>
		<div class="hr"></div>

		<section id="listing_location">
			<h1><?php esc_html_e( 'View Location', 'eList' ); ?></h1>
			<div id="gmaps-border">
				<div id="gmaps-container"></div>
			</div> <!-- end #gmaps-border -->

			<script type="text/javascript" src="<?php echo esc_url( add_query_arg( array( 'key' => et_pb_get_google_api_key() ), is_ssl() ? 'https://maps.googleapis.com/maps/api/js' : 'http://maps.googleapis.com/maps/api/js' ) ); ?>"></script>
			<script type="text/javascript">
				//<![CDATA[
				var map;
				var geocoder;

				initialize();

				function initialize() {
					geocoder = new google.maps.Geocoder();
					geocoder.geocode({
					'address': '<?php echo esc_js( $et_address ); ?>',
					'partialmatch': true}, geocodeResult);
				}

				function geocodeResult(results, status) {
					if (status == 'OK' && results.length > 0) {
						var latlng = new google.maps.LatLng(results[0].geometry.location.b,results[0].geometry.location.c);
						var myOptions = {
						   zoom: 10,
						   center: results[0].geometry.location,
						   mapTypeId: google.maps.MapTypeId.ROADMAP
						};

						map = new google.maps.Map(document.getElementById("gmaps-container"), myOptions);
						   var marker = new google.maps.Marker({
						   position: results[0].geometry.location,
						   map: map,
						   title:"<?php echo esc_js( get_the_title() ); ?>"
						});

						var contentString = '<div id="content">'+
						'<h3 id="firstHeading" class="firstHeading" style="padding-bottom: 15px;">'+marker.title+'</h3>'+
						'<div id="bodyContent">'+
						'<p><a target="_blank" href="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q='+escape(results[0].formatted_address)+'&amp;ie=UTF8&amp;view=map">'+results[0].formatted_address+'</a>'+
						'</p>'+
						'</div>'+
						'</div>';
						//&amp;sll=29.67226,-94.873971

						var infowindow = new google.maps.InfoWindow({
						   content: contentString,
						   maxWidth: 300
						});

						google.maps.event.addListener(marker, 'click', function() {
						   infowindow.open(map,marker);
						});

						google.maps.event.trigger(marker, "click");

					} else {
						//alert("Geocode was not successful for the following reason: " + status);
					}
				}
				//]]>
			</script>
		</section>
	<?php }
}

add_filter( 'elist_featured_args', 'elist_taxonomy_featured_options' );
function elist_taxonomy_featured_options( $args ){
	if ( ! is_tax() ) return $args;

	$queried_object = get_queried_object();
	if ( 'listing_category' != $queried_object->taxonomy ) return $args;

	$args['tax_query'] = array(
		array(
			'taxonomy' => 'listing_category',
			'field' => 'id',
			'terms' => array( $queried_object->term_id ),
			'operator' => 'IN',
		)
	);

	return $args;
}

add_action( 'template_redirect', 'elist_check_category_taxonomy' );
function elist_check_category_taxonomy(){
	if ( ! isset( $_GET['elist_taxonomy'] ) ) return;
	wp_redirect( get_term_link( (int) $_GET['elist_taxonomy'], 'listing_category' ) );
}

if ( ! function_exists('elist_display_paypal_form') ){
	function elist_display_paypal_form( $post_id ){
		$paypal_url = 'on' == get_option('elist_paypal_test_mode','false') ? 'https://www.sandbox.paypal.com/webscr?test_ipn=1&' : 'https://www.paypal.com/webscr?';

		$output = '';

		$amount = 'on' == get_option('elist_paid_listings','false') ? floatval( get_option('elist_standart_subscription', '19.99') ) : 0;
		if ( isset( $_POST['elist_make_featured'] ) ) $amount = $amount + floatval( get_option('elist_featured_subscription', '9.99') );

		$args = apply_filters( 'elist_paypal_args', array(
			'cmd' => '_xclick',
			'business' => get_option( 'elist_paypal_email' ),
			'currency_code' => get_option( 'elist_paypal_currency' ),
			'charset' => 'UTF-8',
			'return' => esc_url( add_query_arg( 'elist_paypal_return', '1', get_permalink() ) ),
			'rm' => 2,
			'upload' => 1,
			'cancel_return'	=> home_url(),
			'custom' => $post_id,
			'notify_url' => trailingslashit( home_url() ) . '?elistpaypal=standard_payment',
			'no_note' => 1,
			'item_name' => esc_html__( 'Payment for Featured listing', 'eList' ),
			'amount' => $amount
		) );

		$output = '<p id="elist_paypal_redirect">' . esc_html__( 'Redirecting to Paypal... Please, don\'t navigate away from this page.' ) . '</p>';

		$output .= '<form action="' . esc_url( $paypal_url ) . '" method="post" id="paypal_payment_form">';

		foreach( $args as $name => $value ){
			$output .= '<input type="hidden" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
		}

		$output .= '<input id="elist_submit_paypal" type="submit" value="' . esc_attr__( 'Pay via PayPal', 'eList' ) . '" style="display:none;" />';
		$output .= '<script type="text/javascript">
						jQuery(function($){
							$("#elist_submit_paypal").click();
						});
					</script>';
		$output .= '<form>';

		echo $output;
	}
}

add_action( 'init', 'elist_check_payment' );
function elist_check_payment(){
	if ( isset( $_GET['elistpaypal'] ) && 'standard_payment' == $_GET['elistpaypal'] ){
		$paypal_url = 'on' == get_option('elist_paypal_test_mode','false') ? 'https://www.sandbox.paypal.com/webscr?test_ipn=1&' : 'https://www.paypal.com/webscr?';

		$_POST['cmd'] = '_notify-validate';
        $posted_data = array( 'body' => $_POST );

        $response = wp_remote_post( $paypal_url, $posted_data );

		if ( ! is_wp_error( $response ) && 200 <= $response['response']['code'] && 300 > $response['response']['code'] && ( strcmp( $response['body'], "VERIFIED") == 0 ) ){
			do_action( 'elist_payment_successful', $_POST );
		}
	}
}

add_action( 'elist_payment_successful', 'elist_on_payment_successful' );
function elist_on_payment_successful( $posted_data ){
	if ( 'on' == get_post_meta( (int) $posted_data['custom'], '_make_listing_featured', true ) ){
		update_post_meta( (int) $posted_data['custom'], '_elist_featured', 'on' );
		add_post_meta( (int) $posted_data['custom'], '_elist_featured_expire', time() );
	}
	wp_update_post( array( 'ID' => (int) $posted_data['custom'], 'post_status' => 'publish' ) );
}

add_action('init', 'elist_schedule_featured_listings_check');
function elist_schedule_featured_listings_check(){
	if ( !wp_next_scheduled('elist_featured_listings_check') && !defined('WP_INSTALLING') )
		wp_schedule_event( time(), 'daily', 'elist_featured_listings_check' );
}

if ( !function_exists('elist_featured_listings_check') ){
	function elist_featured_listings_check(){
		$featured_posts_args = array(
			'post_type' => 'listing',
			'posts_per_page' => -1,
			'meta_key' => '_elist_featured_expire'
		);
		$days_num = (int) get_option( 'elist_paid_listing_expire_days', 10 );
		$timeout = $days_num * 24 * 60 * 60;

		$featured_posts = new WP_Query( $featured_posts_args );

		while ( $featured_posts->have_posts() ) : $featured_posts->the_post();
			$listing_created_time = get_post_meta( $post->ID, '_elist_featured_expire', true );
			if ( $timeout < ( time() - $listing_created_time ) ){
				delete_post_meta( $post->ID, '_elist_featured' );
				delete_post_meta( $post->ID, '_elist_featured_expire' );
			}
		endwhile;
		wp_reset_postdata();
	}
}

add_action( 'pre_get_posts', 'et_display_author_listings' );
function et_display_author_listings( $query ){
	if ( is_admin() ) return $query;
	if ( ! is_author() ) return $query;

	$query->set( 'post_type', apply_filters( 'elist_author_custom_post_types', array( 'post', 'nav_menu_item', 'listing' ) ) );

	return $query;
}

add_filter( 'manage_edit-listing_columns', 'elist_edit_listing_columns' ) ;
function elist_edit_listing_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Title',
		'author' => 'Author',
		'tax_terms' => 'Categories',
		'featured' => 'Featured',
		'date' => 'Date'
	);

	return $columns;
}

add_filter( 'manage_edit-listing_category_columns', 'elist_edit_listing_category_columns' ) ;
function elist_edit_listing_category_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'elist_image' => 'Image',
		'name' => 'Name',
		'description' => 'Description',
		'slug' => 'Slug',
		'posts' => 'Listings'
	);

	return $columns;
}

add_action( 'manage_listing_posts_custom_column', 'elist_manage_listing_posts_custom_column', 10, 2 );
function elist_manage_listing_posts_custom_column( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'tax_terms':
			$categories = get_the_terms( $post_id, 'listing_category' );

			if ( ! empty( $categories ) ) {
				$output = array();

				foreach ( $categories as $category ) {
					$output[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'listing_category' => $category->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $category->name, $category->term_id, 'listing_category', 'display' ) )
					);
				}

				echo join( ', ', $output );
			} else {
				esc_html_e( 'No Categories', 'eList' );
			}
		break;

		case 'featured':
			if ( 'on' == get_post_meta( $post_id, '_elist_featured', true ) ) esc_html_e( 'Featured Listing', 'eList' );
		break;

		default :
			break;
	}
}

add_action( 'manage_listing_category_custom_column', 'elist_manage_listing_category_custom_column', 10, 3 );
function elist_manage_listing_category_custom_column( $temp, $column, $term_id ) {
	global $post;
	$elist_category_images = get_option( 'elist_category_images', array() );
	$category_image_size = apply_filters( 'elist_category_image_size_admin', array( 'width' => 50, 'height' => 50 ) );

	switch( $column ) {
		case 'elist_image':
			$thumb = isset( $elist_category_images[$term_id] ) ? $elist_category_images[$term_id] : '';
			if ( '' != $thumb ) echo '<img src="' . esc_attr( et_new_thumb_resize( et_multisite_thumbnail( $thumb ), (int) $category_image_size['width'], (int) $category_image_size['height'], '', true ) ) . '" style="border: 2px solid #eee; margin-bottom: 2px;" alt="" />';
		break;

		default :
			break;
	}
}

add_filter( 'manage_edit-listing_sortable_columns', 'elist_manage_edit_listing_sortable_columns' );
function elist_manage_edit_listing_sortable_columns( $columns ) {
	$columns['featured'] = 'featured';

	return $columns;
}

add_action( 'load-edit.php', 'elist_edit_listing_load_screen' );
function elist_edit_listing_load_screen() {
	add_filter( 'request', 'elist_sort_featured_column' );
}

function elist_sort_featured_column( $vars ) {
	if ( isset( $vars['post_type'] ) && 'listing' == $vars['post_type'] ) {
		if ( isset( $vars['orderby'] ) && 'featured' == $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => '_elist_featured',
					'orderby' => 'meta_value_num'
				)
			);
		}
	}

	return $vars;
}

add_action('et_header_top','et_elist_control_panel');
function et_elist_control_panel(){
	$admin_access = apply_filters( 'et_showcontrol_panel', current_user_can('switch_themes') );
	if ( !$admin_access ) return;
	if ( get_option('elist_show_control_panel') <> 'on' ) return;
	global $et_bg_texture_urls, $et_google_fonts; ?>
	<div id="et-control-panel">
		<div id="control-panel-main">
			<a id="et-control-close" href="#"></a>
			<div id="et-control-inner">
				<h3 class="control_title">Example Colors</h3>
				<a href="#" class="et-control-colorpicker" id="et-control-background"></a>

				<div class="clear"></div>

				<?php
					$sample_colors = array( '6a8e94', '8da49c', 'b0b083', '859a7c', 'c6bea6', 'b08383', 'a4869d', 'f5f5f5', '4e4e4e', '556f6a', '6f5555', '6f6755' );
					for ( $i=1; $i<=12; $i++ ) { ?>
						<a class="et-sample-setting" id="et-sample-color<?php echo $i; ?>" href="#" rel="<?php echo $sample_colors[$i-1]; ?>" title="#<?php echo esc_attr($sample_colors[$i-1]); ?>"><span class="et-sample-overlay"></span></a>
				<?php } ?>
				<p>or define your own in ePanel</p>

				<h3 class="control_title">Texture Overlays</h3>
				<div class="clear"></div>

				<?php
					$sample_textures = $et_bg_texture_urls;
					for ( $i=1; $i<=count($et_bg_texture_urls); $i++ ) { ?>
						<a title="<?php echo esc_attr($sample_textures[$i-1]); ?>" class="et-sample-setting et-texture" id="et-sample-texture<?php echo $i; ?>" href="#" rel="bg<?php echo $i+1; ?>"><span class="et-sample-overlay"></span></a>
				<?php } ?>

				<p>or define your own in ePanel</p>

				<?php
					$google_fonts = $et_google_fonts;
					$font_setting = 'Kreon';
					$body_font_setting = 'Droid+Sans';
					if ( isset( $_COOKIE['et_elist_header_font'] ) ) $font_setting = $_COOKIE['et_elist_header_font'];
					if ( isset( $_COOKIE['et_elist_body_font'] ) ) $body_font_setting = $_COOKIE['et_elist_body_font'];
				?>

				<h3 class="control_title">Fonts</h3>
				<div class="clear"></div>

				<label for="et_control_header_font">Header
					<select name="et_control_header_font" id="et_control_header_font">
						<?php foreach( $google_fonts as $google_font ) { ?>
							<?php $encoded_value = urlencode($google_font); ?>
							<option value="<?php echo esc_attr($encoded_value); ?>" <?php selected( $font_setting, $encoded_value ); ?>><?php echo esc_html($google_font); ?></option>
						<?php } ?>
					</select>
				</label>
				<a href="#" class="et-control-colorpicker et-font-control" id="et-control-headerfont_bg"></a>
				<div class="clear"></div>

				<label for="et_control_body_font">Body
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
	$bgcolor = ( isset( $_COOKIE['et_elist_bgcolor'] ) && get_option('elist_show_control_panel') == 'on' ) ? $_COOKIE['et_elist_bgcolor'] : get_option('elist_bgcolor');

	$bgtexture_url = '';
	$bgimage_url = '';
	if ( get_option('elist_bgimage') == '' ) {
		if ( isset( $_COOKIE['et_elist_texture_url'] ) && get_option('elist_show_control_panel') == 'on' ) $bgtexture_url =  $_COOKIE['et_elist_texture_url'];
		else {
			$bgtexture_url = get_option('elist_bgtexture_url');
			if ( $bgtexture_url == 'Default' ) $bgtexture_url = '';
			else $bgtexture_url = get_bloginfo('template_directory') . '/images/body-bg' . ( array_search( $bgtexture_url, $et_bg_texture_urls )+2 ) . '.png';
		}
	} else {
		$bgimage_url = get_option('elist_bgimage');
	}

	$style = '';
	$style .= '<style type="text/css">';
	if ( $bgcolor <> '' ) $style .= '#main-header, body.home #featured, #main-footer { background-color: #' . esc_html($bgcolor) . '; }';
	if ( $bgtexture_url <> '' ) $style .= '#main-header, body.home #featured, #main-footer { background-image: url(' . esc_html($bgtexture_url) . '); }';
	if ( $bgimage_url <> '' ) $style .= '#main-header { background-image: url(' . esc_html($bgimage_url) . '); background-position: top center; background-repeat: no-repeat; }';
	$style .= '</style>';

	if ( $bgcolor <> '' || $bgtexture_url <> '' || $bgimage_url <> '' ) echo $style;
}

add_action( 'wp_head', 'et_set_font_properties' );
function et_set_font_properties(){
	$font_style = '';
	$font_color = '';
	$font_family = '';
	$font_color_string = '';

	if ( isset( $_COOKIE['et_elist_header_font'] ) && get_option('elist_show_control_panel') == 'on' ) $et_header_font =  $_COOKIE['et_elist_header_font'];
	else {
		$et_header_font = get_option('elist_header_font');
		if ( $et_header_font == 'Kreon' ) $et_header_font = '';
	}

	if ( isset( $_COOKIE['et_elist_header_font_color'] ) && get_option('elist_show_control_panel') == 'on' )
		$et_header_font_color =  $_COOKIE['et_elist_header_font_color'];
	else
		$et_header_font_color = get_option('elist_header_font_color');

	if ( $et_header_font <> '' || $et_header_font_color <> '' ) {
		$et_header_font_id = strtolower( str_replace( '+', '_', $et_header_font ) );
		$et_header_font_id = str_replace( ' ', '_', $et_header_font_id );

		if ( $et_header_font <> '' ) {
			$font_style .= "<link id='" . esc_attr($et_header_font_id) . "' href='" . esc_url( "http://fonts.googleapis.com/css?family=" . str_replace( ' ', '+', $et_header_font )  . ( 'Raleway' == $et_header_font ? ':100' : '' ) ) . "' rel='stylesheet' type='text/css' />";
			$font_family = "font-family: '" . str_replace( '+', ' ', $et_header_font ) . "', Arial, sans-serif !important; ";
		}

		if ( $et_header_font_color <> '' ) {
			$font_color_string = "color: #" . esc_html($et_header_font_color) . "; ";
		}

		$font_style .= "<style type='text/css'>h1,h2,h3,h4,h5,h6,ul#top-menu a { ". $font_family .  " }</style>";
		$font_style .= "<style type='text/css'>h1,h2,h3,h4,h5,h6,ul#top-menu > li.current_page_item > a, ul#top-menu a:hover, ul#top-menu > li.sfHover > a { ". esc_attr($font_color_string) .  " }
		</style>";

		echo $font_style;
	}

	$font_style = '';
	$font_color = '';
	$font_family = '';
	$font_color_string = '';

	if ( isset( $_COOKIE['et_elist_body_font'] ) && get_option('elist_show_control_panel') == 'on' ) $et_body_font =  $_COOKIE['et_elist_body_font'];
	else {
		$et_body_font = get_option('elist_body_font');
		if ( $et_body_font == 'Droid+Sans' ) $et_body_font = '';
	}

	if ( isset( $_COOKIE['et_elist_body_font_color'] ) && get_option('elist_show_control_panel') == 'on' )
		$et_body_font_color =  $_COOKIE['et_elist_body_font_color'];
	else
		$et_body_font_color = get_option('elist_body_font_color');

	if ( $et_body_font <> '' || $et_body_font_color <> '' ) {
		$et_body_font_id = strtolower( str_replace( '+', '_', $et_body_font ) );
		$et_body_font_id = str_replace( ' ', '_', $et_body_font_id );

		if ( $et_body_font <> '' ) {
			$font_style .= "<link id='" . esc_attr($et_body_font_id) . "' href='" . esc_url( "http://fonts.googleapis.com/css?family=" . str_replace( ' ', '+', $et_body_font ) . ( 'Raleway' == $et_body_font ? ':100' : '' ) ) . "' rel='stylesheet' type='text/css' />";
			$font_family = "font-family: '" . str_replace( '+', ' ', $et_body_font ) . "', Arial, sans-serif !important; ";
		}

		if ( $et_body_font_color <> '' ) {
			$font_color_string = "color: #" . esc_html($et_body_font_color) . "; ";
		}

		$font_style .= "<style type='text/css'>body { ". $font_family .  " }</style>";
		$font_style .= "<style type='text/css'>body { ". esc_html($font_color_string) .  " }</style>";

		echo $font_style;
	}
}

add_filter( 'et_get_additional_color_scheme', 'et_remove_additional_stylesheet' );
function et_remove_additional_stylesheet( $stylesheet ){
	global $default_colorscheme;
	return $default_colorscheme;
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

