<?php

// create custom plugin settings menu
add_action('admin_menu', 'wpreview_create_menu');

function wpreview_create_menu() {

	//create new top-level menu
	$hook = add_options_page('WP Review Pro', 'WP Review Pro', 'administrator', __FILE__, 'wpreview_settings_page');

	//call register settings function
	add_action( 'admin_init', 'wpreview_register_settings' );

	// body class
	add_action( "load-$hook", 'wpreview_admin_body_class_filter' );
}
function wpreview_admin_body_class_filter() {
	add_filter( "admin_body_class", "wpreview_admin_body_class" );
}
// body class
function wpreview_admin_body_class( $classes ) {
	$classes .= 'wp-review-admin-options';
	return $classes;
}

function wpreview_register_settings() {
	//register our settings
	register_setting( 'wpreview-settings-group', 'wp_review_options' );
}

function wpreview_settings_page() {
	$options = get_option('wp_review_options');

    $available_types = apply_filters('wp_review_metabox_types', array('star' => __('Star', 'wp-review'), 'point' => __('Point', 'wp-review'), 'percentage' => __('Percentage', 'wp-review'), 'circle' => __('Circle', 'wp-review')));
    $default_options = array(
		'colors' => array(
			'color' => '',
    		'fontcolor' => '',
    		'bgcolor1' => '',
    		'bgcolor2' => '',
    		'bordercolor' => ''),
		'default_features' => array(),
	    'default_link_texts' => array(),
	    'default_link_urls' => array(),
	    'default_schema_type' => 'Thing',
		'default_user_review_type' => WP_REVIEW_REVIEW_DISABLED,
		'image_sizes' => array(),
	);
    // set defaults
    if (empty($options)) {
    	update_option( 'wp_review_options', $options = $default_options );
    }
    if (empty($options['image_sizes'])) $options['image_sizes'] = array();

    $opt_name = 'wp_review_options_'.wp_get_theme();
	$options_updated = get_option( $opt_name );
	$suggest_theme_defaults = true;
	if (!empty($_GET['wp-review-theme-defaults']) && empty($_GET['settings-updated'])) {
		wp_review_theme_defaults($options_updated, true);
		$options = get_option('wp_review_options');
		$suggest_theme_defaults = false;
	}
	// test to see if we need to sugges setting theme defaults
	if (empty($options_updated)) $options_updated = array();
	$opts_tmp = array_merge($options, $options_updated);
	if ($opts_tmp == $options) $suggest_theme_defaults = false;

	// Migrate
	global $wpdb;
	$current_blog_id = get_current_blog_id();
	$total_rows = 0;
	$rows_left = 0;
	$migrated_rows = get_option( 'wp_review_migrated_rows', 0 );
	$has_migrated = get_option( 'wp_review_has_migrated', false );
	if ( ! $has_migrated && $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->base_prefix}mts_wp_reviews'") == "{$wpdb->base_prefix}mts_wp_reviews") {
		// Table exists and not migrated (fully) yet
		$total_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM '.$wpdb->base_prefix.'mts_wp_reviews WHERE blog_id = '.$current_blog_id );
		$rows_left = $total_rows - $migrated_rows;
	}
	
?>
<div class="wrap wp-review">
	<h2><?php _e('WP Review Pro Settings', 'wp-review'); ?></h2>

	<form method="post" action="options.php">
	    <?php settings_fields( 'wpreview-settings-group' ); ?>

		<?php 

		$comment_form_integration = ( ! empty( $options['comment_form_integration'] ) ? $options['comment_form_integration'] : 'replace' );
		if ($comment_form_integration != 'replace')
			$comment_form_integration = 'extend';

		$comments_template = ( ! empty( $options['comments_template'] ) ? $options['comments_template'] : 'theme' );
		if ($comments_template != 'theme')
			$comments_template = 'plugin';

		$defaultColors = apply_filters('wp_review_default_colors', array(
	    	'color' => '#1e73be',
	    	'fontcolor' => '#555555',
	    	'bgcolor1' => '#e7e7e7',
	    	'bgcolor2' => '#ffffff',
	    	'bordercolor' => '#e7e7e7'
	    ));
	    $defaultLocation = apply_filters('wp_review_default_location', 'bottom');
	    
	    $defaultCriteria = apply_filters('wp_review_default_criteria', array());
	    $defaultItems = array();
	    foreach ($defaultCriteria as $item) {
	        $defaultItems[] = array( 'wp_review_item_title' => $item, 'wp_review_item_star' => '');
	    }
		$default_schema = empty( $options['default_schema_type'] ) ? $default_options['default_schema_type'] : $options['default_schema_type'];
		$default_user_review_type = empty( $options['default_user_review_type'] ) ? WP_REVIEW_REVIEW_DISABLED : $options['default_user_review_type'];
		$rating_schema = empty( $options['default_rating_schema'] ) ? 'author' : $options['default_rating_schema'];
	    $options['colors'] = apply_filters( 'wp_review_colors', $options['colors'], 0 );
	    if (!isset($options['deafults'])) $options['deafults'] = array();
		/* Retrieve an existing value from the database. */
		$items = ! empty($options['default_features']) ? $options['default_features'] : '';
		$link_texts = ! empty( $options['default_link_text'] ) ? $options['default_link_text'] : array();
		$link_urls = ! empty( $options['default_link_url'] ) ? $options['default_link_url'] : array();
		$color     = ! empty($options['colors']['color']) ? $options['colors']['color'] : '';
		$location  = ! empty($options['review_location']) ? $options['review_location'] : ''; 
		$fontcolor = ! empty($options['colors']['fontcolor']) ? $options['colors']['fontcolor'] : ''; 
		$bgcolor1  = ! empty($options['colors']['bgcolor1']) ? $options['colors']['bgcolor1'] : ''; 
		$bgcolor2  = ! empty($options['colors']['bgcolor2']) ? $options['colors']['bgcolor2'] : ''; 
		$bordercolor  = ! empty($options['colors']['bordercolor']) ? $options['colors']['bordercolor'] : ''; 
		$show_on_thumbnails  = ! empty($options['show_on_thumbnails']) ? $options['show_on_thumbnails'] : '';
		$show_on_thumbnails_type  = isset($options['show_on_thumbnails_type']) ? $options['show_on_thumbnails_type'] : 'author';
		$align     = ! empty($options['align']) ? $options['align'] : '';
		$registered_only = ! empty( $options['registered_only'] ) ? $options['registered_only'] : '';
		$force_user_ratings = ! empty( $options['force_user_ratings'] ) ? $options['force_user_ratings'] : '';
		$require_rating = ! empty( $options['require_rating'] ) ? $options['require_rating'] : '';
		$allow_comment_feedback = ! empty( $options['allow_comment_feedback'] ) ? $options['allow_comment_feedback'] : '';
		$width     = ! empty($options['width']) ? $options['width'] : 100;
		$custom_comment_colors = ! empty($options['custom_comment_colors']) ? '1' : '0';
		$comment_color  = ! empty($options['comment_color']) ? $options['comment_color'] : '#FFB300';
	    if ( $items == '' ) $items = $defaultItems;
		if( $color == '' ) $color = $defaultColors['color'];
	    if( $location == '' ) $location = $defaultLocation;
		if( $fontcolor == '' ) $fontcolor = $defaultColors['fontcolor'];
		if( $bgcolor1 == '' ) $bgcolor1 = $defaultColors['bgcolor1'];
		if( $bgcolor2 == '' ) $bgcolor2 = $defaultColors['bgcolor2'];
		if( $bordercolor == '' ) $bordercolor = $defaultColors['bordercolor'];
		if ( empty( $width )) $width = 100;
	    if ( empty( $align )) $align = 'left';
	    
	    $fields = array(
	        'location' => true, 
	        'color' => true, 
	        'fontcolor' => true, 
	        'bgcolor1' => true, 
	        'bgcolor2' => true, 
	        'bordercolor' => true,
	        'custom_colors' => true,
	        'custom_location' => true,
	        'width' => true,
	        'align' => true
	    );
	    $displayed_fields = apply_filters('wp_review_metabox_item_fields', $fields);
		
		?>
		
		<div class="nav-tab-wrapper">
			<a href="#general" class="nav-tab nav-tab-active" data-tab="general"><?php _e('General', 'wp-review'); ?></a>
			<a href="#styling" class="nav-tab" data-tab="styling"><?php _e('Styling', 'wp-review'); ?></a>
			<a href="#defaults" class="nav-tab" data-tab="defaults"><?php _e('Defaults', 'wp-review'); ?></a>
			<?php if ( $rows_left ) : ?>
				<a href="#migrate" class="nav-tab" data-tab="migrate"><?php _e('Migrate Ratings', 'wp-review'); ?></a>
			<?php endif; ?>
		</div>
		<div id="wp-review-settings-tab-contents">
		<div class="settings-tab-general">
			<h3><?php _e( 'General Settings', 'wp-review' ); ?></h3>
		<?php
		$location = apply_filters( 'wp_review_location', $location, 0 );
		if (has_filter('wp_review_location')) echo '<p class="wp-review-filter-msg"><div class="dashicons dashicons-info"></div>'.__('There is a filter set for the review location that may modify the options below.', 'wp-review').'</p>'; 
		
		if ($suggest_theme_defaults) { ?>
		<div class="wp-review-theme-defaults-msg updated settings-error">
			<p class="wp-review-field">
				<?php _e('The current theme provides default settings for the plugin.', 'wp-review'); ?><br />
			</p>
			<a href="<?php echo admin_url('options-general.php?page=wp-review/admin/options.php&wp-review-theme-defaults=1'); ?>" class="button button-primary"><?php _e('Set to theme defaults', 'wp-review'); ?></a>
			<a href="#" class="dashicons dashicons-no-alt close-notice"></a>
		</div>
		<?php } ?>

		<p class="wp-review-field">
			<label><?php _e( 'Comments template', 'wp-review' ); ?>
			</label>
			
			<input name="wp_review_options[comments_template]" id="wp_review_comments_template_theme" type="radio" value="theme" <?php checked( $comments_template, 'theme' ); ?> />
			<label for="wp_review_comments_template_theme">
				<strong><?php _e( 'Theme', 'wp-review' ); ?></strong><br />
				<span class="description"><?php _e( 'Use theme comments template. Might need customization of comments.php', 'wp-review' ); ?></span>
			</label>

			<input name="wp_review_options[comments_template]" id="wp_review_comments_template_plugin" type="radio" value="plugin" <?php checked( $comments_template, 'plugin' ); ?> />
			<label for="wp_review_comments_template_plugin">
				<strong><?php _e( 'WP Review', 'wp-review' ); ?><br /></strong>
				<span class="description"><?php _e( 'Use WP Review comments template. Better chances for out of the box integration.', 'wp-review' ); ?></span>
			</label>
		</p>

		<p class="wp-review-field">
			<label><?php _e( 'Comment form integration', 'wp-review' ); ?>
			</label>
			
			<input name="wp_review_options[comment_form_integration]" id="wp_review_comment_form_integration_replace" type="radio" value="replace" <?php checked( $comment_form_integration, 'replace' ); ?> />
			<label for="wp_review_comment_form_integration_replace">
				<strong><?php _e( 'Replace', 'wp-review' ); ?></strong><br />
				<span class="description"><?php _e( 'Replace form fields.', 'wp-review' ); ?></span>
			</label>

			<input name="wp_review_options[comment_form_integration]" id="wp_review_comment_form_integration_extend" type="radio" value="extend" <?php checked( $comment_form_integration, 'extend' ); ?> />
			<label for="wp_review_comment_form_integration_extend">
				<strong><?php _e( 'Extend', 'wp-review' ); ?><br /></strong>
				<span class="description"><?php _e( 'Add new fields without modifying the default fields.', 'wp-review' ); ?></span>
			</label>
		</p>

		<p class="wp-review-field">
			<label for="wp_review_registered_only"><?php _e( 'Restrict rating to registered users only', 'wp-review' ); ?></label>
			<input name="wp_review_options[registered_only]" id="wp_review_registered_only" type="checkbox" value="1" <?php checked( $registered_only, '1' ); ?> />
		</p>

		<p class="wp-review-field">
			<label for="wp_review_require_rating"><?php _e( 'Require a rating when commenting', 'wp-review' ); ?></label>
			<input name="wp_review_options[require_rating]" id="wp_review_require_rating" type="checkbox" value="1" <?php checked( $require_rating, '1' ); ?> />
		</p>

		<p class="wp-review-field">
			<label for="wp_review_allow_comment_feedback"><?php _e( 'Allow comment feedback (helpful/unhelpful)', 'wp-review' ); ?></label>
			<input name="wp_review_options[allow_comment_feedback]" id="wp_review_allow_comment_feedback" type="checkbox" value="1" <?php checked( $allow_comment_feedback, '1' ); ?> />
		</p>

		<p class="wp-review-field">
			<label for="wp_review_show_on_thumbnails"><?php _e( 'Add total rating to thumbnails', 'wp-review' ); ?></label>
			<input type="hidden" name="wp_review_show_on_thumbnails" id="wp_review_show_on_thumbnails_unchecked" value="" />
			<input name="wp_review_options[show_on_thumbnails]" id="wp_review_show_on_thumbnails" type="checkbox" value="1" <?php echo (! empty($show_on_thumbnails) ? 'checked ' : ''); ?> />
		</p>

		<p class="wp-review-field wp-review-thumbnail-options"<?php if (empty($show_on_thumbnails)) echo ' style="display: none;"'; ?>>
			<label for="wp_review_show_on_thumbnails_type"><?php _e('Rating to show: ', 'wp-review'); ?></label><br />
			<select name="wp_review_options[show_on_thumbnails_type]" id="wp_review_show_on_thumbnails_type">
				<option value="author" <?php selected( $show_on_thumbnails_type, 'author' ); ?>><?php _e( 'Author total', 'wp-review' ) ?></option>
				<option value="visitors" <?php selected( $show_on_thumbnails_type, 'visitors' ); ?>><?php _e( 'Visitors total', 'wp-review' ) ?></option>
	            <option value="comments" <?php selected( $show_on_thumbnails_type, 'comments' ); ?>><?php _e( 'Comments total', 'wp-review' ) ?></option>
			</select>
			<br /><br />
			<?php 
			_e('Registered image sizes: ', 'wp-review'); echo '<br />';
			$image_sizes = wp_review_get_all_image_sizes();
			foreach ($image_sizes as $size => $params) { ?>
			<input name="wp_review_options[image_sizes][]" id="wp_review_thumbnail_<?php echo $size; ?>" type="checkbox" value="<?php echo $size; ?>" <?php echo (in_array($size, $options['image_sizes']) ? 'checked ' : ''); ?> />
			<label for="wp_review_thumbnail_<?php echo $size; ?>"><?php echo $size.' ('.$params['width'].'x'.$params['height'].') '; ?></label><br />
			<?php } ?>
		</p>
		</div>
		<div class="settings-tab-styling">

		<h3><?php _e( 'Styling', 'wp-review' ); ?></h3>

		<?php if (has_filter('wp_review_colors')) echo '<p class="wp-review-filter-msg"><div class="dashicons dashicons-info"></div>'.__('There is a filter set for the review colors that may modify the options below.', 'wp-review').'</p>'; ?>
		
		<div class="wp-review-color-options">
			<p class="wp-review-field"<?php if (empty($displayed_fields['color'])) echo ' style="display: none;"'; ?>>
				<label for="wp_review_color"><?php _e( 'Review Color', 'wp-review' ); ?></label>
				<input type="text" class="wp-review-color" name="wp_review_options[colors][color]" value="<?php echo $color; ?>" />
			</p>

			<p class="wp-review-field"<?php if (empty($displayed_fields['fontcolor'])) echo ' style="display: none;"'; ?>>
				<label for="wp_review_fontcolor"><?php _e( 'Font Color', 'wp-review' ); ?></label>
				<input type="text" class="wp-review-color" name="wp_review_options[colors][fontcolor]" id ="wp_review_fontcolor" value="<?php echo $fontcolor; ?>" />
			</p>

			<p class="wp-review-field"<?php if (empty($displayed_fields['bgcolor1'])) echo ' style="display: none;"'; ?>>
				<label for="wp_review_bgcolor1"><?php _e( 'Heading Background Color', 'wp-review' ); ?></label>
				<input type="text" class="wp-review-color" name="wp_review_options[colors][bgcolor1]" id ="wp_review_bgcolor1" value="<?php echo $bgcolor1; ?>" />
			</p>

			<p class="wp-review-field"<?php if (empty($displayed_fields['bgcolor2'])) echo ' style="display: none;"'; ?>>
				<label for="wp_review_bgcolor2"><?php _e( 'Background Color', 'wp-review' ); ?></label>
				<input type="text" class="wp-review-color" name="wp_review_options[colors][bgcolor2]" id="wp_review_bgcolor2" value="<?php echo $bgcolor2; ?>" />
			</p>

			<p class="wp-review-field"<?php if (empty($displayed_fields['bordercolor'])) echo ' style="display: none;"'; ?>>
				<label for="wp_review_bordercolor"><?php _e( 'Border Color', 'wp-review' ); ?></label>
				<input type="text" class="wp-review-color" name="wp_review_options[colors][bordercolor]" id="wp_review_bordercolor" value="<?php echo $bordercolor; ?>" />
			</p>
		</div>

		<div id="wp-review-width-slider"></div>
		<p class="wp-review-field">
			<label for="wp_review_width"><?php _e( 'Review Box Width', 'wp-review' ); ?></label>
			<input type="number" min="1" max="100" step="1" name="wp_review_options[width]" id="wp_review_width" value="<?php echo $width; ?>" /> %
		</p>
		<p class="wp-review-field wp-review-align-options"<?php if ($width == 100) echo ' style="display: none;"'; ?>>
			<label for="wp-review-align-left"> <?php _e( 'Align Left', 'wp-review' ); ?>
				<input type="radio" name="wp_review_options[align]" id="wp-review-align-left" value="left" <?php checked( $align, 'left' ); ?> />
			</label>

			<label for="wp-review-align-right"> <?php _e( 'Align Right', 'wp-review' ); ?>
				<input type="radio" name="wp_review_options[align]" id="wp-review-align-right" value="right" <?php checked( $align, 'right' ); ?> />
			</label>
		</p>
		<p class="wp-review-field">
			<label for="wp_review_custom_comment_colors">
				<?php _e( 'Comment Rating Color', 'wp-review' ); ?><br />
				<span class="description">
					<?php _e( 'Use different color for ratings in comments', 'wp-review' ); ?>
				</span>
			</label>
			<input name="wp_review_options[custom_comment_colors]" id="wp_review_custom_comment_colors" type="checkbox" value="1" <?php checked( $custom_comment_colors, '1' ); ?> />

			<span id="wp_review_comment_color_wrapper"<?php if (!$custom_comment_colors) echo ' style="display: none;"'; ?>><input type="text" class="wp-review-color" name="wp_review_options[comment_color]" id="wp_review_comment_color" value="<?php echo $comment_color; ?>" /></span>
		</p>
		</div>
		<div class="settings-tab-defaults">
		<h3><?php _e( 'Defaults', 'wp-review' ); ?></h3>

		<?php $has_criteria_filter = has_filter( 'wp_review_default_criteria' ); ?>
		<?php $schemas = wp_review_schema_types(); ?>

		<table class="form-table">
			<tr>
				<th scope="row"><?php _e( 'Review Location', 'wp-review' ); ?></th>
				<td>
					<select name="wp_review_options[review_location]" id="wp_review_location">
						<option value="bottom" <?php selected( $location, 'bottom' ); ?>><?php _e( 'After Content', 'wp-review' ) ?></option>
						<option value="top" <?php selected( $location, 'top' ); ?>><?php _e( 'Before Content', 'wp-review' ) ?></option>
			            <option value="custom" <?php selected( $location, 'custom' ); ?>><?php _e( 'Custom (use shortcode)', 'wp-review' ) ?></option>
					</select>
					<p class="wp-review-field" id="wp_review_shortcode_hint_field">
						<input id="wp_review_shortcode_hint" type="text" value="[wp-review]" readonly="readonly" />
				        <span><?php _e('Copy &amp; paste this shortcode in the post content.', 'wp-review') ?></span>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Review Schema', 'wp-review' ); ?></th>
				<td>
					<select name="wp_review_options[default_schema_type]" id="wp_review_schema">
						<?php foreach ( $schemas as $key => $arr ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $default_schema ); ?>><?php echo esc_html( $arr['label'] ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Features', 'wp-review' ); ?></th>
				<td>
					<table id="wp-review-item">
						<?php if ( $has_criteria_filter ) : ?>
							<?php foreach ( $defaultCriteria as $item ) : ?>
								<?php if ( ! empty( $item ) ) : ?>
									<tr>
										<td style="padding:0">
											<input type="text" name="wp_review_options[default_features][]" value="<?php if( !empty( $item ) ) echo esc_attr( $item ); ?>" <?php echo $has_criteria_filter ? 'disabled="disabled" readonly="readonly"' : ''; ?> />
											<?php if ( ! $has_criteria_filter ) : ?>
												<a class="button remove-row" href="#"><?php _e( 'Delete', 'wp-review' ); ?></a>
											<?php endif; ?>
										</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else : ?>
							<?php foreach ( $items as $item ) : ?>
								<?php if ( ! empty( $item ) ) : ?>
									<tr>
										<td style="padding:0">
											<input type="text" name="wp_review_options[default_features][]" value="<?php if( !empty( $item ) ) echo esc_attr( $item ); ?>" <?php echo $has_criteria_filter ? 'disabled="disabled" readonly="readonly"' : ''; ?> />
											<?php if ( ! $has_criteria_filter ) : ?>
												<a class="button remove-row" href="#"><?php _e( 'Delete', 'wp-review' ); ?></a>
											<?php endif; ?>
										</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
						<tr class="empty-row screen-reader-text">
							<td style="padding:0">
								<input class="focus-on-add" type="text" name="wp_review_options[default_features][]" />
								<a class="button remove-row" href="#"><?php _e( 'Delete', 'wp-review' ); ?></a>
							</td>
						</tr>
					</table>
					<?php if ( $has_criteria_filter ) : ?>
						<p class="description"><?php _e('Default features are set by a filter function. Remove it to change.', 'wp-review'); ?></p>
					<?php else : ?>
						<a class="add-row button" data-target="#wp-review-item" href="#"><?php _e( 'Add default feature', 'wp-review' ) ?></a>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Links', 'wp-review' ); ?></th>
				<td>
					<table id="wp-review-link">
						<?php if ( ! empty ( $link_texts ) ) : ?>
							<?php foreach ( $link_texts as $key => $text ) : ?>
								<?php if ( ! empty( $text ) && ! empty( $link_urls[ $key ] ) ) : ?>
									<tr>
										<td style="padding:0">
											<input type="text" name="wp_review_options[default_link_text][]" placeholder="Text" value="<?php echo esc_attr( $text ); ?>" />
											<input type="url" name="wp_review_options[default_link_url][]" placeholder="URL" value="<?php echo esc_url( $link_urls[ $key ] ); ?>" />
											<a class="button remove-row" href="#"><?php _e( 'Delete', 'wp-review' ); ?></a>
										</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
						<tr class="empty-row screen-reader-text">
							<td style="padding:0">
								<input class="focus-on-add" type="text" name="wp_review_options[default_link_text][]" placeholder="Text" />
								<input type="url" name="wp_review_options[default_link_url][]" placeholder="URL" />
								<a class="button remove-row" href="#"><?php _e( 'Delete', 'wp-review' ); ?></a>
							</td>
						</tr>
					</table>
					<a class="add-row button" data-target="#wp-review-link" href="#"><?php _e( 'Add default link', 'wp-review' ) ?></a>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'User Ratings', 'wp-review' ); ?></th>
				<td>
					<input type="radio" name="wp_review_options[default_user_review_type]" id="wp-review-userReview-disable" value="<?php echo WP_REVIEW_REVIEW_DISABLED; ?>" <?php checked( WP_REVIEW_REVIEW_DISABLED, $default_user_review_type ); ?> />
					<label for="wp-review-userReview-disable"> <?php _e( 'Disabled', 'wp-review' ); ?></label>
					<br>
					<input type="radio" name="wp_review_options[default_user_review_type]" id="wp-review-userReview-visitor" value="<?php echo WP_REVIEW_REVIEW_VISITOR_ONLY; ?>" <?php checked( WP_REVIEW_REVIEW_VISITOR_ONLY, $default_user_review_type ); ?> />
					<label for="wp-review-userReview-visitor"> <?php _e( 'Visitor Rating Only', 'wp-review' ); ?>
					<br>
					<input type="radio" name="wp_review_options[default_user_review_type]" id="wp-review-userReview-comment" value="<?php echo WP_REVIEW_REVIEW_COMMENT_ONLY; ?>" <?php checked( WP_REVIEW_REVIEW_COMMENT_ONLY, $default_user_review_type ); ?> />
					<label for="wp-review-userReview-comment"> <?php _e( 'Comment Rating Only', 'wp-review' ); ?></label>
					<br>
					<input type="radio" name="wp_review_options[default_user_review_type]" id="wp-review-userReview-both" value="<?php echo WP_REVIEW_REVIEW_ALLOW_BOTH; ?>" <?php checked( WP_REVIEW_REVIEW_ALLOW_BOTH, $default_user_review_type ); ?> />
					<label for="wp-review-userReview-both"> <?php _e( 'Both', 'wp-review' ); ?></label>
				</td>
			</tr>
			<tr>
				<th><label for="wp_review_rating_schema"><?php _e( 'Rating Schema', 'wp-review' ); ?></label></th>
				<td>
					<select name="wp_review_options[default_rating_schema]" id="wp_review_rating_schema">
						<option value="author" <?php selected( 'author', $rating_schema ); ?>><?php _e( 'Author Review Rating', 'wp-review'); ?></option>
						<option value="visitors" <?php selected( 'visitors', $rating_schema ); ?>><?php _e( 'Visitors Aggregate Rating (if enabled)', 'wp-review'); ?></option>
						<option value="comments" <?php selected( 'comments', $rating_schema ); ?>><?php _e( 'Comments Reviews Aggregate Rating (if enabled)', 'wp-review'); ?></option>
					</select>
				</td>
			</tr>
			<!-- <tr>
				<th scope="row">
					<label for="wp_review_force_user_ratings"><?php _e( 'Force Enable User Ratings', 'wp-review' ); ?>
					<p class="description">
						<?php _e( 'Enable user ratings on all posts, pages and custom post types where it is not disabled explicitly.', 'wp-review' ); ?>
					</p>
					</label>
				</th>
				<td>
					<input name="wp_review_options[force_user_ratings]" id="wp_review_force_user_ratings" type="checkbox" value="1" <?php checked( $force_user_ratings, '1' ); ?> />
				</td>
			</tr> -->
		</table>
		</div>
		
		<?php if ( $rows_left ) : ?>
			<div class="settings-tab-migrate">
				<div id="settings-allow-migrate">
					<p><?php _e('Here you can import your existing user ratings from WP Review 1.x and WP Review Pro 1.x.', 'wp-review'); ?></p>
					<p class="migrate-items"><?php printf( __( '%s ratings left to import.', 'wp-review'), '<span id="migrate-items-num">'.$rows_left.'</span>' ); ?></p>
					<a href="#" class="button button-secondary" id="start-migrate" data-start="<?php echo $migrated_rows; ?>"><?php _e('Start import', 'wp-review'); ?></a>
					<textarea id="wp-review-migrate-log"></textarea>
				</div>
				<p class="already-migrated-msg"><?php _e('Ratings have already been migrated.', 'wp-review'); ?></p>
			</div>
		<?php endif; ?>

		</div>
		

	    <p class="submit">
	    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	    </p>

	</form>
</div>
<?php }

// Add settings link on plugin page
function wpreview_plugin_settings_link($links) {
	$dir = explode('/', WP_REVIEW_PLUGIN_BASE);
	$dir = $dir[0];
	$settings_link = '<a href="options-general.php?page='.$dir.'/admin/options.php">'.__('Settings', 'wp-review').'</a>'; 
	array_unshift($links, $settings_link); 
	return $links; 
}
add_filter('plugin_action_links_'.WP_REVIEW_PLUGIN_BASE, 'wpreview_plugin_settings_link' );

?>
