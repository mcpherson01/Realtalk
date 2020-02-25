<?php
/**
 * File for registering meta box.
 *
 * @since     2.0
 * @copyright Copyright (c) 2013, MyThemesShop
 * @author    MyThemesShop
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Adds a box to the Posts edit screens. */
add_action( 'add_meta_boxes', 'wp_review_add_meta_boxes' );

/* Saves the meta box custom data. */
add_action( 'save_post', 'wp_review_save_postdata', 10, 2 );

/**
 * Adds a box to the Post edit screens.
 *
 * @since 1.0
 */
function wp_review_add_meta_boxes() {
    $post_types = get_post_types( array('public' => true), 'names' );
    $excluded_post_types = apply_filters('wp_review_excluded_post_types', array('attachment'));
    
    foreach ($post_types as $post_type) {
        if (!in_array($post_type, $excluded_post_types)) {
        	add_meta_box(
        		'wp-review-metabox-review',
        		__( 'Review', 'wp-review' ),
        		'wp_review_render_meta_box_review_options',
        		$post_type,
        		'normal',
        		'high'
        	);
        
        	add_meta_box(
        		'wp-review-metabox-item',
        		__( 'Review Item', 'wp-review' ),
        		'wp_review_render_meta_box_item',
        		$post_type,
        		'normal',
        		'high'
        	);

	        add_meta_box(
		        'wp-review-metabox-reviewLinks',
		        __( 'Review Links', 'wp-review' ),
		        'wp_review_render_meta_box_reviewLinks',
		        $post_type,
		        'normal',
		        'high'
	        );
        	
        	add_meta_box(
        		'wp-review-metabox-desc',
        		__( 'Review Description', 'wp-review' ),
        		'wp_review_render_meta_box_desc',
        		$post_type,
        		'normal',
        		'high'
        	);
        	
        	add_meta_box(
        		'wp-review-metabox-userReview',
        		__( 'User Reviews', 'wp-review' ),
        		'wp_review_render_meta_box_userReview',
        		$post_type,
        		'normal',
        		'high'
        	);
        }
    }
}

/**
 * Render the meta box.
 *
 * @since 1.0
 */
function wp_review_render_meta_box_review_options( $post ) {
	global $post, $wp_review_rating_types;

	/* Add an nonce field so we can check for it later. */
	wp_nonce_field( basename( __FILE__ ), 'wp-review-review-options-nonce' );

	$options = get_option('wp_review_options');

	/* Retrieve an existing value from the database. */
	$type = get_post_meta( $post->ID, 'wp_review_type', true );
	$schema = wp_review_get_review_schema( $post->ID );
	$schema_data = get_post_meta( $post->ID, 'wp_review_schema_options', true );
	
	$heading = get_post_meta( $post->ID, 'wp_review_heading', true );
	$rating_schema = get_post_meta( $post->ID, 'wp_review_rating_schema', true );
	if ( '' === $rating_schema && ! empty( $options['default_rating_schema'] ) ) {
		$rating_schema = $options['default_rating_schema'];
	}
    //$available_types = apply_filters('wp_review_metabox_types', wp_review_get_review_types() );
    $available_types = wp_review_get_rating_types();
	$schemas = wp_review_schema_types();
?>
	
	<p class="wp-review-field">
		<label for="wp_review_type"><?php _e( 'Review Type', 'wp-review' ); ?></label>
		<select name="wp_review_type" id="wp_review_type">
			<option value=""><?php _e( 'No Review', 'wp-review' ) ?></option>
            <?php foreach ($available_types as $available_type_name => $available_type) { ?>
                <option value="<?php echo $available_type_name; ?>" data-max="<?php echo $available_type['max']; ?>" data-decimals="<?php echo $available_type['decimals']; ?>" <?php selected( $type, $available_type_name ); ?>><?php echo $available_type['label']; ?></option>
            <?php } ?>
		</select>
        <span id="wp_review_id_hint">Review ID: <strong><?php echo $post->ID; ?></strong></span>
	</p>

	<p class="wp-review-field" id="wp_review_heading_group">
		<label><?php _e( 'Review Heading', 'wp-review' ); ?></label>
		<input type="text" name="wp_review_heading" id="wp_review_heading" value="<?php _e( $heading ); ?>" />
	</p>

	<p class="wp-review-field" id="wp_review_schema_group">
		<label for="wp_review_schema"><?php _e( 'Reviewed Item Schema', 'wp-review' ); ?></label>
		<select name="wp_review_schema" id="wp_review_schema">
			<?php foreach ( $schemas as $key => $arr ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $schema ); ?>><?php echo esc_html( $arr['label'] ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<div id="wp_review_schema_type_options_wrap">
	<?php foreach ( $schemas as $type => $arr ) : ?>
		<div class="wp_review_schema_type_options" id="wp_review_schema_type_<?php echo $type; ?>" <?php if ( $type !== $schema ) echo 'style="display:none;"';?>>
		<?php if ( isset( $arr['fields'] ) ) { ?>
			<?php foreach ( $arr['fields'] as $data ) : ?>
				<p class="wp-review-field">
					<?php $values = isset( $schema_data[ $type ] ) ? $schema_data[ $type ] : array(); ?>
					<?php wp_review_schema_field( $data, $values, $type ); ?>
				</p>
			<?php endforeach; ?>
			<?php } ?>
		</div>
	<?php endforeach; ?>
		<p class="wp-review-field" id="wp_review_schema_rating_group" <?php if ( '' === $schema ) echo 'style="display:none;"';?>>
			<label for="wp_review_rating_schema"><?php _e( 'Rating Schema', 'wp-review' ); ?></label>
			<select name="wp_review_rating_schema" id="wp_review_rating_schema">
				<option value="author" <?php selected( 'author', $rating_schema ); ?>><?php _e( 'Author Review Rating', 'wp-review'); ?></option>
				<option value="visitors" <?php selected( 'visitors', $rating_schema ); ?>><?php _e( 'Visitors Aggregate Rating (if enabled)', 'wp-review'); ?></option>
				<option value="comments" <?php selected( 'comments', $rating_schema ); ?>><?php _e( 'Comments Reviews Aggregate Rating (if enabled)', 'wp-review'); ?></option>
			</select>
		</p>
	</div>
	
	
	<?php
}

/**
 * Render the meta box.
 *
 * @since 1.0
 */
function wp_review_render_meta_box_item( $post ) {
	$options = get_option('wp_review_options');
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
    if (empty($defaultCriteria) && ! empty($options['default_features'])) $defaultCriteria = $options['default_features'];
    foreach ($defaultCriteria as $item) {
        $defaultItems[] = array( 'wp_review_item_title' => $item, 'wp_review_item_star' => '');
    }
    
	/* Add an nonce field so we can check for it later. */
	wp_nonce_field( basename( __FILE__ ), 'wp-review-item-nonce' ); 

	/* Retrieve an existing value from the database. */
	$custom_colors   = get_post_meta( $post->ID, 'wp_review_custom_colors', true );
	$custom_location = get_post_meta( $post->ID, 'wp_review_custom_location', true );
	$custom_width = get_post_meta( $post->ID, 'wp_review_custom_width', true );
	$custom_author = get_post_meta( $post->ID, 'wp_review_custom_author', true );

	$show_schema_data = get_post_meta( $post->ID, 'wp_review_show_schema_data', true );


	$items     = get_post_meta( $post->ID, 'wp_review_item', true ); 
	$color     = get_post_meta( $post->ID, 'wp_review_color', true );
	$location  = get_post_meta( $post->ID, 'wp_review_location', true );
	$fontcolor = get_post_meta( $post->ID, 'wp_review_fontcolor', true );
	$bgcolor1  = get_post_meta( $post->ID, 'wp_review_bgcolor1', true );
	$bgcolor2  = get_post_meta( $post->ID, 'wp_review_bgcolor2', true );
	$bordercolor  = get_post_meta( $post->ID, 'wp_review_bordercolor', true );
	$align     = get_post_meta( $post->ID, 'wp_review_align', true ); 
	$width     = get_post_meta( $post->ID, 'wp_review_width', true );
	$author    = get_post_meta( $post->ID, 'wp_review_author', true ); 
    if ( $items == '' ) $items = $defaultItems;
	if( $color == '' ) $color = ( ! empty($options['colors']['color'] ) ? $options['colors']['color'] : $defaultColors['color']);
    if( $location == '' ) $location = ( ! empty($options['location'] ) ? $options['location'] : $defaultLocation);
	if( $fontcolor == '' ) $fontcolor = ( ! empty($options['colors']['fontcolor'] ) ? $options['colors']['fontcolor'] : $defaultColors['fontcolor']);
	if( $bgcolor1 == '' ) $bgcolor1 = ( ! empty($options['colors']['bgcolor1'] ) ? $options['colors']['bgcolor1'] : $defaultColors['bgcolor1']);
	if( $bgcolor2 == '' ) $bgcolor2 = ( ! empty($options['colors']['bgcolor2'] ) ? $options['colors']['bgcolor2'] : $defaultColors['bgcolor2']);
	if( $bordercolor == '' ) $bordercolor = ( ! empty($options['colors']['bordercolor'] ) ? $options['colors']['bordercolor'] : $defaultColors['bordercolor']);
    if ( empty( $width )) $width = 100;
    if ( empty( $align )) $align = 'left';
    if ( !$author ) $author = '';

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

	<!-- Start repeater field -->
	<table id="wp-review-item" class="wp-review-item" width="100%">

		<thead>
			<tr>
				<th width="3%"></th>
				<th width="70%"><?php _e( 'Feature Name', 'wp-review' ); ?></th>
				<th width="17%" class="dynamic-text"><?php _e( 'Star (1-5)', 'wp-review' ); ?></th>
				<th width="10%"></th>
			</tr>
		</thead>

		<tbody>
			<?php if ( !empty($items) ) : ?>
		 
				<?php foreach ( $items as $item ) { ?>

					<tr>
						<td class="handle">
							<span class="dashicons dashicons-menu"></span>
						</td>
						<td>
							<input type="text" class="widefat" name="wp_review_item_title[]" value="<?php if( !empty( $item['wp_review_item_title'] ) ) echo esc_attr( $item['wp_review_item_title'] ); ?>" />
						</td>
						<td>
							<input type="text" min="1" step="1" autocomplete="off" class="widefat review-star" name="wp_review_item_star[]" value="<?php if ( !empty ($item['wp_review_item_star'] ) ) echo $item['wp_review_item_star']; ?>" />
						</td>
						<td><a class="button remove-row" href="#"><?php _e( 'Delete', 'wp-review' ); ?></a></td>
					</tr>

				<?php } ?>

			<?php else : ?>
				
				<tr>
					<td class="handle"><span class="dashicons dashicons-menu"></span></td>
					<td><input type="text" class="widefat" name="wp_review_item_title[]" /></td>
					<td><input type="text" min="1" step="1" autocomplete="off" class="widefat review-star" name="wp_review_item_star[]" /></td>
					<td><a class="button remove-row" href="#"><?php _e( 'Delete', 'wp-review' ); ?></a></td>
				</tr>

			<?php endif; ?>
		 
			<!-- empty hidden one for jQuery -->
			<tr class="empty-row screen-reader-text">
				<td class="handle"><span class="dashicons dashicons-menu"></span></td>
				<td><input type="text" class="widefat focus-on-add" name="wp_review_item_title[]" /></td>
				<td><input type="text" min="1" step="1" autocomplete="off" class="widefat" name="wp_review_item_star[]" /></td>
				<td><a class="button remove-row" href="#"><?php _e( 'Delete', 'wp-review' ); ?></a></td>
			</tr>

		</tbody>

	</table>
	
	<table width="100%">
		<tr>
			<td width="73%"><a class="add-row button" data-target="#wp-review-item" href="#"><?php _e( 'Add another', 'wp-review' ) ?></a></td>
			<td width="17%">
				<input type="text" class="widefat wp-review-total" name="wp_review_total" value="<?php echo get_post_meta( $post->ID, 'wp_review_total', true ); ?>" />
			</td>
			<td width="10%"><?php _e( 'Total', 'wp-review' ); ?></td>
		</tr>
	</table>

	<p class="wp-review-field">
		<input name="wp_review_custom_location" id="wp_review_custom_location" type="checkbox" value="1" <?php echo (! empty($custom_location) ? 'checked ' : ''); ?> />
		<label for="wp_review_custom_location"><?php _e( 'Custom Location', 'wp-review' ); ?></label>
	</p>
    <div class="wp-review-location-options"<?php if (empty($custom_location)) echo ' style="display: none;"'; ?>>
		<p class="wp-review-field">
			<label for="wp_review_location"><?php _e( 'Review Location', 'wp-review' ); ?></label>
			<select name="wp_review_location" id="wp_review_location">
				<option value="bottom" <?php selected( $location, 'bottom' ); ?>><?php _e( 'After Content', 'wp-review' ) ?></option>
				<option value="top" <?php selected( $location, 'top' ); ?>><?php _e( 'Before Content', 'wp-review' ) ?></option>
	            <option value="custom" <?php selected( $location, 'custom' ); ?>><?php _e( 'Custom (use shortcode)', 'wp-review' ) ?></option>
			</select>
		</p>
		<p class="wp-review-field" id="wp_review_shortcode_hint_field">
			<label for="wp_review_shortcode_hint"></label>
			<input id="wp_review_shortcode_hint" type="text" value='[wp-review id="<?php echo trim( $post->ID ); ?>"]' readonly="readonly" />
	        <span><?php _e('Copy &amp; paste this shortcode in the content.', 'wp-review') ?></span>
		</p>
	</div>
	<p class="wp-review-field">
		<input name="wp_review_custom_colors" id="wp_review_custom_colors" type="checkbox" value="1" <?php echo (! empty($custom_colors) ? 'checked ' : ''); ?>/>
		<label for="wp_review_custom_colors"><?php _e( 'Custom Colors', 'wp-review' ); ?></label>
	</p>
    <div class="wp-review-color-options"<?php if (empty($custom_colors)) echo ' style="display: none;"'; ?>>

		<p class="wp-review-field"<?php if (empty($displayed_fields['color'])) echo ' style="display: none;"'; ?>>
			<label for="wp_review_color"><?php _e( 'Review Color', 'wp-review' ); ?></label>
			<input type="text" class="wp-review-color" name="wp_review_color" value="<?php echo $color; ?>" />
		</p>

		<p class="wp-review-field"<?php if (empty($displayed_fields['fontcolor'])) echo ' style="display: none;"'; ?>>
			<label for="wp_review_fontcolor"><?php _e( 'Font Color', 'wp-review' ); ?></label>
			<input type="text" class="wp-review-color" name="wp_review_fontcolor" id ="wp_review_fontcolor" value="<?php echo $fontcolor; ?>" />
		</p>

		<p class="wp-review-field"<?php if (empty($displayed_fields['bgcolor1'])) echo ' style="display: none;"'; ?>>
			<label for="wp_review_bgcolor1"><?php _e( 'Heading Background Color', 'wp-review' ); ?></label>
			<input type="text" class="wp-review-color" name="wp_review_bgcolor1" id ="wp_review_bgcolor1" value="<?php echo $bgcolor1; ?>" />
		</p>

		<p class="wp-review-field"<?php if (empty($displayed_fields['bgcolor2'])) echo ' style="display: none;"'; ?>>
			<label for="wp_review_bgcolor2"><?php _e( 'Background Color', 'wp-review' ); ?></label>
			<input type="text" class="wp-review-color" name="wp_review_bgcolor2" id="wp_review_bgcolor2" value="<?php echo $bgcolor2; ?>" />
		</p>

		<p class="wp-review-field"<?php if (empty($displayed_fields['bordercolor'])) echo ' style="display: none;"'; ?>>
			<label for="wp_review_bordercolor"><?php _e( 'Border Color', 'wp-review' ); ?></label>
			<input type="text" class="wp-review-color" name="wp_review_bordercolor" id="wp_review_bordercolor" value="<?php echo $bordercolor; ?>" />
		</p>
	</div>
	<p class="wp-review-field">
		<input name="wp_review_custom_width" id="wp_review_custom_width" type="checkbox" value="1" <?php echo (! empty($custom_width) ? 'checked ' : ''); ?>/>
		<label for="wp_review_custom_width"><?php _e( 'Custom Width', 'wp-review' ); ?></label>
	</p>
    <div class="wp-review-width-options"<?php if (empty($custom_width)) echo ' style="display: none;"'; ?>>
		<div id="wp-review-width-slider"></div>
		<p class="wp-review-field">
			<label for="wp_review_width"><?php _e( 'Review Box Width', 'wp-review' ); ?></label>
			<input type="number" min="1" max="100" step="1" name="wp_review_width" id="wp_review_width" value="<?php echo $width; ?>" /> %
		</p>
		<p class="wp-review-field wp-review-align-options"<?php if ($width == 100) echo ' style="display: none;"'; ?>>
			<label for="wp-review-align-left"> <?php _e( 'Align Left', 'wp-review' ); ?> 
				<input type="radio" name="wp_review_align" id="wp-review-align-left" value="left" <?php checked( $align, 'left' ); ?> />
			</label>
			
			<label for="wp-review-align-right"> <?php _e( 'Align Right', 'wp-review' ); ?> 
				<input type="radio" name="wp_review_align" id="wp-review-align-right" value="right" <?php checked( $align, 'right' ); ?> />
			</label>
		</p>
	</div>

	<p class="wp-review-field">
		<input name="wp_review_custom_author" id="wp_review_custom_author" type="checkbox" value="1" <?php echo (! empty($custom_author) ? 'checked ' : ''); ?>/>
		<label for="wp_review_custom_author"><?php _e( 'Custom Author', 'wp-review' ); ?></label>
	</p>
	<div class="wp-review-author-options"<?php if (empty($custom_author)) echo ' style="display: none;"'; ?>>
		<p class="wp-review-field">
			<label><?php _e( 'Review Author', 'wp-review' ); ?></label>
			<input type="text" name="wp_review_author" id="wp_review_author" value="<?php echo esc_attr($author); ?>">
		</p>
	</div>

	<p>
		<input name="wp_review_show_schema_data" id="wp_review_show_schema_data" type="checkbox" value="1" <?php echo (! empty($show_schema_data) ? 'checked ' : ''); ?>/>
		<label for="wp_review_show_schema_data"><?php _e( 'Display reviewed item schema data (if available)', 'wp-review' ); ?></label>
	</p>
	<?php
}
 
function wp_review_render_meta_box_desc( $post ) {

	/* Add an nonce field so we can check for it later. */
	wp_nonce_field( basename( __FILE__ ), 'wp-review-desc-nonce' ); 

	/* Retrieve existing values from the database. */
	$hide_desc = get_post_meta( $post->ID, 'wp_review_hide_desc', true );
	$desc = get_post_meta( $post->ID, 'wp_review_desc', true );
	$desc_title = get_post_meta( $post->ID, 'wp_review_desc_title', true );
	if (!$desc_title) $desc_title = __('Summary', 'wp-review');
	?>
	<p id="wp-review-desc-title" class="wp-review-field">
			<input type="text" name="wp_review_desc_title" id="wp_review_desc_title" value="<?php esc_attr_e( $desc_title ); ?>" />
	</p>
	<?php

	/* Display wp editor field. */
	wp_editor( 
		$desc,
		'wp_review_desc',
		array(
			'tinymce'       => false,
			'quicktags'     => true,
			'media_buttons' => false,
			'textarea_rows' => 10 
		) 
	);
	?>
	<p class="wp-review-field">
		<label style="width: 100%;">
			<input type="hidden" name="wp_review_hide_desc" id="wp_review_hide_desc_unchecked" value="" />
			<input type="checkbox" name="wp_review_hide_desc" id="wp_review_hide_desc" value="1" <?php checked( $hide_desc ); ?> />
			<?php _e( 'Hide Description &amp; Total Rating', 'wp-review' ); ?>
		</label>
	</p>
	<?php
}

function wp_review_render_meta_box_reviewLinks( $post ) {

	wp_nonce_field( basename( __FILE__ ), 'wp-review-links-options-nonce' );

	function wp_review_get_default_links( $text, $url ) {
		return array(
			'text' => $text,
			'url' => $url
		);
	}

	$options = get_option( 'wp_review_options' );
	$defaults = array_map(
			'wp_review_get_default_links',
			empty( $options['default_link_text'] ) ? array() : $options['default_link_text'],
			empty( $options['default_link_url'] ) ? array() : $options['default_link_url']
	);
	$items = get_post_meta( $post->ID, 'wp_review_links', true );
	if ( ! is_array( $items ) ) {
		$items = $defaults;
	}
?>
	<table id="wp-review-links" class="wp-review-links" width="100%">

		<thead>
		<tr>
			<th width="5%"></th>
			<th width="45%"><?php _e( 'Text', 'wp-review' ); ?></th>
			<th width="40%"><?php _e( 'URL', 'wp-review' ); ?></th>
			<th width="10%"></th>
		</tr>
		</thead>

		<tbody>
		<?php if ( !empty($items) && ( isset( $items[0] ) && ! empty( $items[0]['text'] ) ) ) : ?>

			<?php foreach ( $items as $item ) { ?>

				<?php if ( ! empty( $item['text'] ) && ! empty( $item['url'] ) ) : ?>
					<tr>
						<td class="handle">
							<span class="dashicons dashicons-menu"></span>
						</td>
						<td>
							<input type="text" class="widefat" name="wp_review_link_title[]" value="<?php echo esc_attr( $item['text'] ); ?>" />
						</td>
						<td>
							<input type="url" class="widefat" name="wp_review_link_url[]" value="<?php echo esc_url( $item['url'] ); ?>" />
						</td>
						<td><a class="button remove-row" href="#"><?php _e( 'Delete', 'wp-review' ); ?></a></td>
					</tr>
				<?php endif; ?>

			<?php } ?>

		<?php else : ?>

			<tr>
				<td class="handle"><span class="dashicons dashicons-menu"></span></td>
				<td><input type="text" class="widefat" name="wp_review_link_title[]" /></td>
				<td><input type="text" class="widefat" name="wp_review_link_url[]" /></td>
				<td><a class="button remove-row" href="#"><?php _e( 'Delete', 'wp-review' ); ?></a></td>
			</tr>

		<?php endif; ?>

		<!-- empty hidden one for jQuery -->
		<tr class="empty-row screen-reader-text">
			<td class="handle"><span class="dashicons dashicons-menu"></span></td>
			<td><input type="text" class="widefat focus-on-add" name="wp_review_link_title[]" /></td>
			<td><input type="text" class="widefat" name="wp_review_link_url[]" /></td>
			<td><a class="button remove-row" href="#"><?php _e( 'Delete', 'wp-review' ); ?></a></td>
		</tr>

		</tbody>

	</table>

	<a class="add-row button" data-target="#wp-review-links" href="#"><?php _e( 'Add another', 'wp-review' ) ?></a>
<?php
}

function wp_review_render_meta_box_userReview( $post ) {
	/* Add an nonce field so we can check for it later. */
	wp_nonce_field( basename( __FILE__ ), 'wp-review-userReview-nonce' );
	$enabled = wp_review_get_user_rating_setup( $post->ID );
	$commentRating = get_post_meta( $post->ID, 'wp_review_comment_rating_type', true );
	if ( empty( $commentRating ) ) {
		$commentRating = 'overall';
	}
	$type = get_post_meta( $post->ID, 'wp_review_user_review_type', true );
	if (! $type ) {
		$type = 'star';
	}
	//$available_types = apply_filters('wp_review_metabox_user_rating_types', wp_review_get_review_types( 'user' ) );
	$available_types = wp_review_get_rating_types();
	$hide_comments_total = get_post_meta( $post->ID, 'wp_review_hide_comments_total', true );
	?>

	<p class="wp-review-field">
		<input type="radio" name="wp_review_userReview" id="wp-review-userReview-disable" value="<?php echo WP_REVIEW_REVIEW_DISABLED; ?>" <?php checked( WP_REVIEW_REVIEW_DISABLED, $enabled ); ?> />
		<label for="wp-review-userReview-disable"> <?php _e( 'Disabled', 'wp-review' ); ?></label>
	</p>
	<p class="wp-review-field">
		<input type="radio" name="wp_review_userReview" id="wp-review-userReview-visitor" value="<?php echo WP_REVIEW_REVIEW_VISITOR_ONLY; ?>" <?php checked( WP_REVIEW_REVIEW_VISITOR_ONLY, $enabled ); ?> />
		<label for="wp-review-userReview-visitor"> <?php _e( 'Visitor Rating Only', 'wp-review' ); ?>
	</p>
	<p class="wp-review-field">
		<input type="radio" name="wp_review_userReview" id="wp-review-userReview-comment" value="<?php echo WP_REVIEW_REVIEW_COMMENT_ONLY; ?>" <?php checked( WP_REVIEW_REVIEW_COMMENT_ONLY, $enabled ); ?> />
		<label for="wp-review-userReview-comment"> <?php _e( 'Comment Rating Only', 'wp-review' ); ?></label>
	</p>
	<p class="wp-review-field">
		<input type="radio" name="wp_review_userReview" id="wp-review-userReview-both" value="<?php echo WP_REVIEW_REVIEW_ALLOW_BOTH; ?>" <?php checked( WP_REVIEW_REVIEW_ALLOW_BOTH, $enabled ); ?> />
		<label for="wp-review-userReview-both"> <?php _e( 'Both', 'wp-review' ); ?></label>
	</p>
	<p class="wp-review-field" id="wp_review_rating_type">
		<label for="rating_type"><?php _e( 'User Rating Type', 'wp-review' ); ?></label>
		<select name="wp_review_user_review_type" id="rating_type">
			<?php foreach ($available_types as $available_type_name => $available_type) {
				// skip ones that only have output template
				if ( ! $available_type['user_rating'] ) continue; ?>
                <option value="<?php echo $available_type_name; ?>" <?php selected( $type, $available_type_name ); ?>><?php echo $available_type['label']; ?></option>
            <?php } ?>
		</select>
		<span class="edit-ratings-notice"><?php _e( 'Note: If you are changing user rating type and post already have user ratings, please edit or remove existing ratings if needed.', 'wp-review' ); ?></span>
	</p>
	<p class="wp-review-field">
		<label style="width: 100%;">
			<input type="hidden" name="wp_review_hide_comments_total" id="wp_review_hide_comments_total_unchecked" value="" />
			<input type="checkbox" name="wp_review_hide_comments_total" id="wp_review_hide_comments_total" value="1" <?php checked( $hide_comments_total ); ?> />
			<?php _e( 'Hide Comments Total Rating ( if "Comment Rating Only" or "Both" is checked )', 'wp-review' ); ?>
		</label>
	</p>
	<!-- <p class="wp-review-field" id="wp_review_comment_rating_type" <?php echo in_array( $enabled, array( WP_REVIEW_REVIEW_COMMENT_ONLY, WP_REVIEW_REVIEW_ALLOW_BOTH ) ) ? '' : 'style="display:none"'; ?>>
		<label for="comment_rating_overall"><?php _e( 'Comment Rating Type', 'wp-review' ); ?></label>
		<input type="radio" value="overall" name="wp_review_comment_rating_type" id="comment_rating_overall" <?php checked( $commentRating, 'overall' ); ?>><label for="comment_rating_overall">Overall</label>
		<input type="radio" value="individual" name="wp_review_comment_rating_type" id="comment_rating_indiv" <?php checked( $commentRating, 'individual' ); ?>><label for="comment_rating_indiv">Individual</label>
	</p> -->
	<?php
}

/**
 * Saves the meta box.
 *
 * @since 1.0
 */
function wp_review_save_postdata( $post_id, $post ) {

	if ( !isset( $_POST['wp-review-review-options-nonce'] ) || !wp_verify_nonce( $_POST['wp-review-review-options-nonce'], basename( __FILE__ ) ) )
		return;

	if ( !isset( $_POST['wp-review-item-nonce'] ) || !wp_verify_nonce( $_POST['wp-review-item-nonce'], basename( __FILE__ ) ) )
		return;
	
	if ( !isset( $_POST['wp-review-desc-nonce'] ) || !wp_verify_nonce( $_POST['wp-review-desc-nonce'], basename( __FILE__ ) ) )
		return;
	
	if ( !isset( $_POST['wp-review-userReview-nonce'] ) || !wp_verify_nonce( $_POST['wp-review-userReview-nonce'], basename( __FILE__ ) ) )
		return;

	if ( !isset( $_POST['wp-review-links-options-nonce'] ) || !wp_verify_nonce( $_POST['wp-review-links-options-nonce'], basename( __FILE__ ) ) )
		return;

	/* If this is an autosave, our form has not been submitted, so we don't want to do anything. */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	/* Check the user's permissions. */
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	$meta = array(
		'wp_review_custom_location' => filter_input( INPUT_POST, 'wp_review_custom_location', FILTER_SANITIZE_STRING ),
		'wp_review_custom_colors' => filter_input( INPUT_POST, 'wp_review_custom_colors', FILTER_SANITIZE_STRING ),
		'wp_review_custom_width' => filter_input( INPUT_POST, 'wp_review_custom_width', FILTER_SANITIZE_STRING ),
		'wp_review_custom_author' => filter_input( INPUT_POST, 'wp_review_custom_author', FILTER_SANITIZE_STRING ),
		'wp_review_location' => filter_input( INPUT_POST, 'wp_review_location', FILTER_SANITIZE_STRING ),
		'wp_review_type'     => filter_input( INPUT_POST, 'wp_review_type', FILTER_SANITIZE_STRING ),
		'wp_review_heading'     => filter_input( INPUT_POST, 'wp_review_heading', FILTER_SANITIZE_STRING ),
		'wp_review_desc_title'     => filter_input( INPUT_POST, 'wp_review_desc_title', FILTER_SANITIZE_STRING ),
		'wp_review_desc'     => wp_kses_post( $_POST['wp_review_desc'] ),
		'wp_review_hide_desc'     => filter_input( INPUT_POST, 'wp_review_hide_desc', FILTER_SANITIZE_STRING ),
		'wp_review_userReview'     => filter_input( INPUT_POST, 'wp_review_userReview', FILTER_SANITIZE_STRING ),
		'wp_review_hide_comments_total'     => filter_input( INPUT_POST, 'wp_review_hide_comments_total', FILTER_SANITIZE_STRING ),
		'wp_review_total'    => filter_input( INPUT_POST, 'wp_review_total', FILTER_SANITIZE_STRING ),
		'wp_review_color'    => filter_input( INPUT_POST, 'wp_review_color', FILTER_SANITIZE_STRING ),
		'wp_review_fontcolor'    => filter_input( INPUT_POST, 'wp_review_fontcolor', FILTER_SANITIZE_STRING ),
		'wp_review_bgcolor1'    => filter_input( INPUT_POST, 'wp_review_bgcolor1', FILTER_SANITIZE_STRING ),
		'wp_review_bgcolor2'    => filter_input( INPUT_POST, 'wp_review_bgcolor2', FILTER_SANITIZE_STRING ),
		'wp_review_bordercolor' => filter_input( INPUT_POST, 'wp_review_bordercolor', FILTER_SANITIZE_STRING ),
		'wp_review_width'    => filter_input( INPUT_POST, 'wp_review_width', FILTER_SANITIZE_STRING ),
		'wp_review_align'    => filter_input( INPUT_POST, 'wp_review_align', FILTER_SANITIZE_STRING ),
		'wp_review_author'    => filter_input( INPUT_POST, 'wp_review_author', FILTER_SANITIZE_STRING ),
		'wp_review_schema' => filter_input( INPUT_POST, 'wp_review_schema', FILTER_SANITIZE_STRING ),
		'wp_review_rating_schema' => filter_input( INPUT_POST, 'wp_review_rating_schema', FILTER_SANITIZE_STRING ),
		'wp_review_show_schema_data' => filter_input( INPUT_POST, 'wp_review_show_schema_data', FILTER_SANITIZE_STRING ),
		'wp_review_comment_rating_type' => filter_input( INPUT_POST, 'wp_review_comment_rating_type', FILTER_SANITIZE_STRING ),
		'wp_review_user_review_type' => filter_input( INPUT_POST, 'wp_review_user_review_type', FILTER_SANITIZE_STRING ),
	);

	foreach ( $meta as $meta_key => $new_meta_value ) {

		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		/* If there is no new meta value but an old value exists, delete it. */
		if ( current_user_can( 'delete_post_meta', $post_id, $meta_key ) && empty( $new_meta_value ) && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );

		/* If a new meta value was added and there was no previous value, add it. */
		elseif ( current_user_can( 'add_post_meta', $post_id, $meta_key ) && ($new_meta_value || $new_meta_value === '0') && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		/* If the new meta value does not match the old value, update it. */
		elseif ( current_user_can( 'edit_post_meta', $post_id, $meta_key ) && ($new_meta_value || $new_meta_value === '0') && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );
	}

	/* Repeatable update and delete meta fields method. */
	$title = $_POST['wp_review_item_title'];
	$star  = $_POST['wp_review_item_star'];

	$old   = get_post_meta( $post_id, 'wp_review_item', true );
	$new   = array();

	$count = count( $title );
	
	for ( $i = 0; $i < $count; $i++ ) {
		if ( $title[$i] != '' )
			$new[$i]['wp_review_item_title'] = sanitize_text_field( $title[$i] );
		if ( $star[$i] != '' )
			$new[$i]['wp_review_item_star'] = sanitize_text_field( $star[$i] );
	}

	if ( !empty( $new ) && $new != $old )
		update_post_meta( $post_id, 'wp_review_item', $new );
	elseif ( empty($new) && $old )
		delete_post_meta( $post_id, 'wp_review_item', $old );

	$link_text = (array) filter_input( INPUT_POST, 'wp_review_link_title', FILTER_SANITIZE_STRING, FILTER_FORCE_ARRAY );
	$link_url = (array) filter_input( INPUT_POST, 'wp_review_link_url', FILTER_SANITIZE_STRING, FILTER_FORCE_ARRAY );
	$new_links = array();

	if ( ! empty( $link_text )  ) {
		foreach ( $link_text as $key => $text ) {
			if ( ! empty( $text ) && ! empty( $link_url[ $key ] ) ) {
				$new_links[] = array(
					'text' => $text,
					'url' => $link_url[ $key ]
				);
			}
		}
	}

	if ( empty( $new_links ) ) {
		delete_post_meta( $post_id, 'wp_review_links' );
	} else {
		update_post_meta( $post_id, 'wp_review_links', $new_links );
	}
	if ( isset( $_POST['wp_review_schema_options'] ) ) {
		update_post_meta( $post_id, 'wp_review_schema_options', $_POST['wp_review_schema_options'] );
	}
	

	/**
	 * Delete all data when switched to 'No Review' type.
	 */
	$type = $meta['wp_review_type'];//get_post_meta( $post_id, 'wp_review_type', true );
	if ( $type == '' ) {
		delete_post_meta( $post_id, 'wp_review_desc', $_POST['wp_review_desc'] );
		delete_post_meta( $post_id, 'wp_review_heading', $_POST['wp_review_heading'] );
		delete_post_meta( $post_id, 'wp_review_userReview', $_POST['wp_review_userReview'] );
		delete_post_meta( $post_id, 'wp_review_item', $old );
	}

}

// Fix for post previews
// with this code, the review meta data will actually get saved on Preview
add_filter('_wp_post_revision_fields', 'add_field_debug_preview');
function add_field_debug_preview($fields){
   $fields["debug_preview"] = "debug_preview";
   return $fields;
}
add_action( 'edit_form_after_title', 'add_input_debug_preview' );
function add_input_debug_preview() {
   echo '<input type="hidden" name="debug_preview" value="debug_preview">';
}

function wp_review_schema_types() {
	$default = array(
		'none' => array(
			'label' => __( 'None', 'wp-review' ),
		),
		'Book' => array(
			'label' => __( 'Book', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Book Title', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'description',
					'label' => __( 'Book Description', 'wp-review' ),
					'type' => 'textarea',
					'default' => ''
				),
				array(
					'name' => 'image',
					'label' => __( 'Book Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'author',
					'label' => __( 'Book Author', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'bookEdition',
					'label' => __( 'Book Edition', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'bookFormat',
					'label' => __( 'Book Format', 'wp-review' ),
					'type' => 'select',
					'default' => '',
					'options' => array(
						'' => '---',
						'AudiobookFormat' => 'AudiobookFormat',
						'EBook' => 'EBook',
						'Hardcover' => 'Hardcover',
						'Paperback' => 'Paperback'
					)
				),
				array(
					'name' => 'datePublished',
					'label' => __( 'Date published', 'wp-review' ),
					'type' => 'date',
					'default' => '',
				),
				array(
					'name' => 'illustrator',
					'label' => __( 'Illustrator', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'isbn',
					'label' => __( 'ISBN', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'numberOfPages',
					'label' => __( 'Number Of Pages', 'wp-review' ),
					'type' => 'number',
					'default' => ''
				)
			)
		),
		'Game' => array(
			'label' => __( 'Game', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Game title', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'description',
					'label' => __( 'Game description', 'wp-review' ),
					'type' => 'textarea',
					'default' => ''
				),
				array(
					'name' => 'image',
					'label' => __( 'Game Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
			)
		),
		'Movie' => array(
			'label' => __( 'Movie', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Movie title', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'description',
					'label' => __( 'Movie description', 'wp-review' ),
					'type' => 'textarea',
					'default' => ''
				),
				array(
					'name' => 'image',
					'label' => __( 'Movie Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'dateCreated',
					'label' => __( 'Date published', 'wp-review' ),
					'type' => 'date',
					'default' => '',
				),
				array(
					'name' => 'director',
					'label' => __( 'Director(s)', 'wp-review' ),
					'type' => 'textarea',
					'multiline' => true,
					'default' => '',
					'info' => __('Add one director per line', 'wp-review'),
				),
				array(
					'name' => 'actor',
					'label' => __( 'Actor(s)', 'wp-review' ),
					'type' => 'textarea',
					'multiline' => true,
					'default' => '',
					'info' => __('Add one actor per line', 'wp-review'),
				),
				array(
					'name' => 'genre',
					'label' => __( 'Genre', 'wp-review' ),
					'type' => 'textarea',
					'multiline' => true,
					'default' => '',
					'info' => __('Add one item per line', 'wp-review'),
				),
			)
		),
		'MusicRecording' => array(
			'label' => __( 'MusicRecording', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Track name', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'byArtist',
					'label' => __( 'Author', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'duration',
					'label' => __( 'Track Duration', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'inAlbum',
					'label' => __( 'Album name', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'genre',
					'label' => __( 'Genre', 'wp-review' ),
					'type' => 'textarea',
					'multiline' => true,
					'default' => '',
					'info' => __('Add one item per line', 'wp-review'),
				),
			)
		),
		'Painting' => array(
			'label' => __( 'Painting', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Name', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'author',
					'label' => __( 'Author', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'image',
					'label' => __( 'Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'genre',
					'label' => __( 'Genre', 'wp-review' ),
					'type' => 'textarea',
					'multiline' => true,
					'default' => '',
					'info' => __('Add one item per line', 'wp-review'),
				),
				array(
					'name' => 'datePublished',
					'label' => __( 'Date published', 'wp-review' ),
					'type' => 'date',
					'default' => '',
				),
			)
		),
		'Place' => array(
			'label' => __( 'Place', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Place Name', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'description',
					'label' => __( 'Place Description', 'wp-review' ),
					'type' => 'textarea',
					'default' => ''
				),
				array(
					'name' => 'image',
					'label' => __( 'Place Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
			)
		),
		'Product' => array(
			'label' => __( 'Product', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Product Name', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'description',
					'label' => __( 'Product Description', 'wp-review' ),
					'type' => 'textarea',
					'default' => ''
				),
				array(
					'name' => 'image',
					'label' => __( 'Product Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'price',
					'label' => __( 'Price', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'part_of' => 'offers',
					'@type' => 'Offer'
				),
				array(
					'name' => 'priceCurrency',
					'label' => __( 'Currency', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'part_of' => 'offers',
					'@type' => 'Offer'
				),
				array(
					'name' => 'availability',
					'label' => __( 'Availability', 'wp-review' ),
					'type' => 'select',
					'default' => '',
					'options' => array(
						'' => '---',
						'Discontinued' => 'Discontinued',
						'InStock' => 'In Stock',
						'InStoreOnly' => 'In Store Only',
						'LimitedAvailability' => 'Limited',
						'OnlineOnly' => 'Online Only',
						'OutOfStock' => 'Out Of Stock',
						'PreOrder' => 'Pre Order',
						'PreSale' => 'Pre Sale',
						'SoldOut' => 'Sold Out'
					),
					'part_of' => 'offers',
					'@type' => 'Offer'
				),
			)
		),
		'Recipe' => array(
			'label' => __( 'Recipe', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Name', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'author',
					'label' => __( 'Author', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'description',
					'label' => __( 'Description', 'wp-review' ),
					'type' => 'textarea',
					'default' => ''
				),
				array(
					'name' => 'image',
					'label' => __( 'Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'prepTime',
					'label' => __( 'Preperation time', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'info' => __('Format: 1H30M. H - Hours, M - Minutes', 'wp-review')
				),
				array(
					'name' => 'cookTime',
					'label' => __( 'Cook Time', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'info' => __('Format: 1H30M. H - Hours, M - Minutes', 'wp-review')
				),
				array(
					'name' => 'totalTime',
					'label' => __( 'Total Time', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'info' => __('Format: 1H30M. H - Hours, M - Minutes', 'wp-review')
				),
				array(
					'name' => 'recipeCategory',
					'label' => __( 'Type', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'info' => __('Type of dish, for example "appetizer", "entree", or "dessert"', 'wp-review')
				),
				array(
					'name' => 'recipeYield',
					'label' => __( 'Recipe Yield', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'info' => __('Quantity produced by the recipe, for example "4 servings"', 'wp-review')
				),
				array(
					'name' => 'recipeIngredient',
					'label' => __( 'Recipe Ingredients', 'wp-review' ),
					'type' => 'textarea',
					'multiline' => true,
					'default' => '',
					'info' => __('Recipe ingredients, add one item per line', 'wp-review'),
				),
				array(
					'name' => 'recipeInstructions',
					'label' => __( 'Recipe Instructions', 'wp-review' ),
					'type' => 'textarea',
					'default' => '',
					'info' => __('Steps to take', 'wp-review')
				),
				array(
					'name' => 'calories',
					'label' => __( 'Calories', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'info' => __('The number of calories', 'wp-review'),
					'part_of' => 'nutrition',
					'@type' => 'NutritionInformation'
				),
				
			)
		),
		'Restaurant' => array(
			'label' => __( 'Restaurant', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Restaurant Name', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'description',
					'label' => __( 'Restaurant Description', 'wp-review' ),
					'type' => 'textarea',
					'default' => ''
				),
				array(
					'name' => 'image',
					'label' => __( 'Restaurant Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
			)
		),
		'SoftwareApplication' => array(
			'label' => __( 'SoftwareApplication', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Name', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'description',
					'label' => __( 'Description', 'wp-review' ),
					'type' => 'textarea',
					'default' => ''
				),
				array(
					'name' => 'image',
					'label' => __( 'Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'price',
					'label' => __( 'Price', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'part_of' => 'offers',
					'@type' => 'Offer'
				),
				array(
					'name' => 'priceCurrency',
					'label' => __( 'Currency', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'part_of' => 'offers',
					'@type' => 'Offer'
				),
				array(
					'name' => 'operatingSystem',
					'label' => __( 'Operating System', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'info' => __('For example, "Windows 7", "OSX 10.6", "Android 1.6"', 'wp-review')
				),
				array(
					'name' => 'applicationCategory',
					'label' => __( 'Application Category', 'wp-review' ),
					'type' => 'text',
					'default' => '',
					'info' => __('For example, "Game", "Multimedia"', 'wp-review')
				)
			)
		),
		'Store' => array(
			'label' => __( 'Store', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Store Name', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'description',
					'label' => __( 'Store Description', 'wp-review' ),
					'type' => 'textarea',
					'default' => ''
				),
				array(
					'name' => 'image',
					'label' => __( 'Store Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
			)
		),
		'Thing' => array(
			'label' => __( 'Thing (Default)', 'wp-review' )
		),
		'TVSeries' => array(
			'label' => __( 'TVSeries', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Name', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'description',
					'label' => __( 'Description', 'wp-review' ),
					'type' => 'textarea',
					'default' => ''
				),
				array(
					'name' => 'image',
					'label' => __( 'Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
			)
		),
		'WebSite' => array(
			'label' => __( 'WebSite', 'wp-review' ),
			'fields' => array(
				array(
					'name' => 'name',
					'label' => __( 'Name', 'wp-review' ),
					'type' => 'text',
					'default' => '',
				),
				array(
					'name' => 'description',
					'label' => __( 'Description', 'wp-review' ),
					'type' => 'textarea',
					'default' => ''
				),
				array(
					'name' => 'image',
					'label' => __( 'Image', 'wp-review' ),
					'type' => 'image',
					'default' => ''
				),
				array(
					'name' => 'url',
					'label' => __( 'URL', 'wp-review' ),
					'type' => 'text',
					'default' => ''
				),
			)
		)
	);

	return apply_filters( 'wp_review_schema_types', $default );
}


function wp_review_schema_field( $args, $value, $schema_type ) {

	$type    = isset( $args['type'] ) ? $args['type'] : '';
	$name    = isset( $args['name'] ) ? $args['name'] : '';
	$label   = isset( $args['label'] ) ? $args['label'] : '';
	$options = isset( $args['options'] ) ? $args['options'] : array();
	$default = isset( $args['default'] ) ? $args['default'] : '';
	$min = isset( $args['min'] ) ? $args['min'] : '0';
	$max = isset( $args['max'] ) ? $args['max'] : '';
	$info = isset( $args['info'] ) ? $args['info'] : '';

	// Option value
	$opt_val = isset( $value[ $name ] ) ? $value[ $name ] : $default;
	$opt_id_attr = 'wp_review_schema_options_'.$schema_type.'_'.$name;
	$opt_name_attr = 'wp_review_schema_options['.$schema_type.']['.$name.']';
	?>
	<label for="<?php echo $opt_id_attr; ?>" class="wp_review_schema_options_label"><?php echo $label; ?></label>
	<?php
	switch ( $type ) {

		case 'text':
		?>
			<input type="text" name="<?php echo $opt_name_attr; ?>" id="<?php echo $opt_id_attr; ?>" value="<?php echo esc_attr( $opt_val );?>" />
		<?php
		break;
		case 'select':
		?>
			<select name="<?php echo $opt_name_attr; ?>" id="<?php echo $opt_id_attr; ?>">
			<?php foreach ( $options as $val => $label ) { ?>
				<option value="<?php echo $val; ?>" <?php selected( $opt_val, $val, true); ?>><?php echo $label ?></option>
			<?php } ?>
			</select>
		<?php
		break;
		case 'number':
		?>
			<input type="number" step="1" min="<?php echo $min;?>" max="<?php echo $max;?>" name="<?php echo $opt_name_attr; ?>" id="<?php echo $opt_id_attr; ?>" value="<?php echo $opt_val;?>" class="small-text"/>
		<?php
		break;
		case 'textarea':
		?>
			<textarea name="<?php echo $opt_name_attr; ?>" id="<?php echo $opt_id_attr; ?>"><?php echo esc_textarea( $opt_val );?></textarea>
		<?php
		break;
		case 'checkbox':
		?>
			<input type="checkbox" name="<?php echo $opt_name_attr; ?>" id="<?php echo $opt_id_attr; ?>" value="1" <?php checked( $opt_val, '1', true ); ?> />
		<?php
		break;
		case 'image':
		?>
		<span class="wpr_image_upload_field">
			<span class="clearfix" id="<?php echo $opt_id_attr; ?>-preview">
			<?php
			if ( isset( $opt_val['url'] ) && $opt_val['url'] != '' ) {
				echo '<img class="wpr_image_upload_img" src="' . $opt_val['url'] . '" />';
			}
			?>
			</span>
			<input type="hidden" id="<?php echo $opt_id_attr; ?>-id" name="<?php echo $opt_name_attr; ?>[id]" value="<?php if (isset($opt_val['id'])) echo $opt_val['id']; ?>" />
			<input type="hidden" id="<?php echo $opt_id_attr; ?>-url" name="<?php echo $opt_name_attr; ?>[url]" value="<?php if (isset($opt_val['url'])) echo $opt_val['url']; ?>" />
			<button class="button" name="<?php echo $opt_id_attr; ?>-upload" id="<?php echo $opt_id_attr; ?>-upload" data-id="<?php echo $opt_id_attr; ?>" onclick="wprImageField.uploader( '<?php echo $opt_id_attr; ?>' ); return false;"><?php _e( 'Select Image', 'wp-review' ); ?></button>
			<?php
			if ( isset( $opt_val['url'] ) && $opt_val['url'] != '' ) {
				echo '<a href="#" class="clear-image">' . __( 'Remove Image', 'wp-review' ) . '</a>';
			}
			?>
			<span class="clear"></span>
		</span>
			<?php

		break;

		case 'date':
		?>
			<input class="wpr-datepicker" type="text" name="<?php echo $opt_name_attr; ?>" id="<?php echo $opt_id_attr; ?>" value="<?php echo $opt_val;?>" size="30" />
		<?php
		break;
	}
	if ( !empty( $info ) ) {
		?>
		<em class="wp_review_schema_options_info"><?php echo $info; ?></em>
		<?php
	}
}
