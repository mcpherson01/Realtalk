<?php

/* Meta boxes */

function et_elegantestate_settings(){
	add_meta_box("et_post_meta", "ET Settings", "et_elegantestate_options", "post", "normal", "high");
	add_meta_box("et_post_meta", "ET Settings", "et_elegantestate_options", "page", "normal", "high");
}
add_action("admin_init", "et_elegantestate_settings");

function et_elegantestate_options($callback_args) {
	global $post;

	$thumbs = array();
	$custom = get_post_custom($post->ID);

	$price = isset($custom["price"][0]) ? $custom["price"][0] : '';
	$description =  isset($custom["description"][0]) ? $custom["description"][0] : '';
	/*$et_latitude = isset($custom["et_latitude"][0]) ? $custom["et_latitude"][0] : '';
	$et_longtitude = isset($custom["et_longtitude"][0]) ? $custom["et_longtitude"][0] : ''; */
	$et_address = isset($custom["et_address"][0]) ? $custom["et_address"][0] : '';

	$et_property_type = isset($custom["et_property_type"][0]) ? $custom["et_property_type"][0] : '';
	$et_bedrooms_number = isset($custom["et_bedrooms_number"][0]) ? $custom["et_bedrooms_number"][0] : '';
	$et_bathrooms_number = isset($custom["et_bathrooms_number"][0]) ? $custom["et_bathrooms_number"][0] : '';
	$et_garages_number = isset($custom["et_garages_number"][0]) ? $custom["et_garages_number"][0] : '';
	$et_square_footage = isset($custom["et_square_footage"][0]) ? $custom["et_square_footage"][0] : '';

	$featured_image = isset($custom["featured_image"][0]) ? $custom["featured_image"][0] : '';
	$integrate_gmaps = isset($custom["integrate_gmaps"][0]) ? (bool) $custom["integrate_gmaps"][0] : false;

	$custom["thumbs"] = isset($custom["thumbs"][0]) ? unserialize($custom["thumbs"][0]) : array();
	$custom["thumbs_alt"] = isset($custom["_thumbs_alt"][0]) ? unserialize($custom["_thumbs_alt"][0]) : array();
	$thumbnail1 =  isset($custom["thumbs"][0]) ? $custom["thumbs"][0] : '';
	$thumbnail1_alt = isset($custom["thumbs_alt"][0]) ? $custom["thumbs_alt"][0] : '';
	$thumbnail2 =  isset($custom["thumbs"][1]) ? $custom["thumbs"][1] : '';
	$thumbnail2_alt = isset($custom["thumbs_alt"][1]) ? $custom["thumbs_alt"][1] : '';
	$thumbnail3 =  isset($custom["thumbs"][2]) ? $custom["thumbs"][2] : '';
	$thumbnail3_alt = isset($custom["thumbs_alt"][2]) ? $custom["thumbs_alt"][2] : '';
	$thumbnail4 =  isset($custom["thumbs"][3]) ? $custom["thumbs"][3] : '';
	$thumbnail4_alt = isset($custom["thumbs_alt"][3]) ? $custom["thumbs_alt"][3] : '';
	$thumbnail5 =  isset($custom["thumbs"][4]) ? $custom["thumbs"][4] : '';
	$thumbnail5_alt = isset($custom["thumbs_alt"][4]) ? $custom["thumbs_alt"][4] : '';
	$thumbnail6 =  isset($custom["thumbs"][5]) ? $custom["thumbs"][5] : '';
	$thumbnail6_alt = isset($custom["thumbs_alt"][5]) ? $custom["thumbs_alt"][5] : '';
	$thumbnail7 =  isset($custom["thumbs"][6]) ? $custom["thumbs"][6] : '';
	$thumbnail7_alt = isset($custom["thumbs_alt"][6]) ? $custom["thumbs_alt"][6] : '';
	$thumbnail8 =  isset($custom["thumbs"][7]) ? $custom["thumbs"][7] : '';
	$thumbnail8_alt = isset($custom["thumbs_alt"][7]) ? $custom["thumbs_alt"][7] : '';

	if ($callback_args->post_type == 'page') $et_page_template =  isset($custom["et_page_template"][0]) ? $custom["et_page_template"][0] : '';

	wp_nonce_field( basename( __FILE__ ), 'et_settings_nonce' );
?>

	<?php if ($callback_args->post_type == 'page') { ?>
		<p style="margin-bottom: 22px;">
			<label for="et_page_template">Page Type</label>
			<select id="et_page_template" name="et_page_template">
				<option value="">Product Page</option>
				<option <?php if (htmlspecialchars($et_page_template) == 'usual') echo('selected="selected"')?> value="usual">Usual Page</option>
			</select>
		</p>
	<?php }; ?>

	<p style="margin-bottom: 22px;">
		<label for="et_price">Price</label>
		<input name="et_price" id="et_price" type="text" value="<?php echo esc_attr($price); ?>" size="20" />
		<small>(ex. 29.99)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_description">Product Description: </label><br/>
		<textarea id="et_description" name="et_description" style="width: 90%"><?php echo esc_textarea($description); ?></textarea><br/>
		<small>(used on Single post pages)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image">Product Thumbnail #1: </label><br/>
		<input id="et_upload_image" type="text" size="90" name="et_upload_image" value="<?php echo esc_attr($thumbnail1); ?>" />
		<input class="upload_image_button" type="button" value="Upload Image" data-choose="Choose Product Thumbnail #1" data-update="Use For Product Thumbnail #1" /><br/>
		<small>(enter an URL or upload an image for the 1st Product Image)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image_alt">Product Thumbnail #1 Description ( Alt Text ): </label><br/>
		<input id="et_upload_image_alt" type="text" size="90" name="et_upload_image_alt" value="<?php echo esc_attr( $thumbnail1_alt ); ?>" />
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image2">Product Thumbnail #2: </label><br/>
		<input id="et_upload_image2" type="text" size="90" name="et_upload_image2" value="<?php echo esc_attr($thumbnail2); ?>" />
		<input class="upload_image_button" type="button" value="Upload Image" data-choose="Choose Product Thumbnail #2" data-update="Use For Product Thumbnail #2" /><br/>
		<small>(enter an URL or upload an image for the 2nd Product Image)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image2_alt">Product Thumbnail #2 Description ( Alt Text ): </label><br/>
		<input id="et_upload_image2_alt" type="text" size="90" name="et_upload_image2_alt" value="<?php echo esc_attr( $thumbnail2_alt ); ?>" />
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image3">Product Thumbnail #3: </label><br/>
		<input id="et_upload_image3" type="text" size="90" name="et_upload_image3" value="<?php echo esc_attr($thumbnail3); ?>" />
		<input class="upload_image_button" type="button" value="Upload Image" data-choose="Choose Product Thumbnail #3" data-update="Use For Product Thumbnail #3" /><br/>
		<small>(enter an URL or upload an image for the 3rd Product Image)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image3_alt">Product Thumbnail #3 Description ( Alt Text ): </label><br/>
		<input id="et_upload_image3_alt" type="text" size="90" name="et_upload_image3_alt" value="<?php echo esc_attr( $thumbnail3_alt ); ?>" />
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image4">Product Thumbnail #4: </label><br/>
		<input id="et_upload_image4" type="text" size="90" name="et_upload_image4" value="<?php echo esc_attr($thumbnail4); ?>" />
		<input class="upload_image_button" type="button" value="Upload Image" data-choose="Choose Product Thumbnail #4" data-update="Use For Product Thumbnail #4" /><br/>
		<small>(enter an URL or upload an image for the 4th Product Image)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image4_alt">Product Thumbnail #4 Description ( Alt Text ): </label><br/>
		<input id="et_upload_image4_alt" type="text" size="90" name="et_upload_image4_alt" value="<?php echo esc_attr( $thumbnail4_alt ); ?>" />
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image5">Product Thumbnail #5: </label><br/>
		<input id="et_upload_image5" type="text" size="90" name="et_upload_image5" value="<?php echo esc_attr($thumbnail5); ?>" />
		<input class="upload_image_button" type="button" value="Upload Image" data-choose="Choose Product Thumbnail #5" data-update="Use For Product Thumbnail #5" /><br/>
		<small>(enter an URL or upload an image for the 5th Product Image)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image5_alt">Product Thumbnail #5 Description ( Alt Text ): </label><br/>
		<input id="et_upload_image5_alt" type="text" size="90" name="et_upload_image5_alt" value="<?php echo esc_attr( $thumbnail5_alt ); ?>" />
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image6">Product Thumbnail #6: </label><br/>
		<input id="et_upload_image6" type="text" size="90" name="et_upload_image6" value="<?php echo esc_attr($thumbnail6); ?>" />
		<input class="upload_image_button" type="button" value="Upload Image" data-choose="Choose Product Thumbnail #6" data-update="Use For Product Thumbnail #6" /><br/>
		<small>(enter an URL or upload an image for the 6th Product Image)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image6_alt">Product Thumbnail #6 Description ( Alt Text ): </label><br/>
		<input id="et_upload_image6_alt" type="text" size="90" name="et_upload_image6_alt" value="<?php echo esc_attr( $thumbnail6_alt ); ?>" />
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image7">Product Thumbnail #7: </label><br/>
		<input id="et_upload_image7" type="text" size="90" name="et_upload_image7" value="<?php echo esc_attr($thumbnail7); ?>" />
		<input class="upload_image_button" type="button" value="Upload Image" data-choose="Choose Product Thumbnail #7" data-update="Use For Product Thumbnail #7" /><br/>
		<small>(enter an URL or upload an image for the 7th Product Image)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image7_alt">Product Thumbnail #7 Description ( Alt Text ): </label><br/>
		<input id="et_upload_image7_alt" type="text" size="90" name="et_upload_image7_alt" value="<?php echo esc_attr( $thumbnail7_alt ); ?>" />
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image8">Product Thumbnail #8: </label><br/>
		<input id="et_upload_image8" type="text" size="90" name="et_upload_image8" value="<?php echo esc_attr($thumbnail8); ?>" />
		<input class="upload_image_button" type="button" value="Upload Image" data-choose="Choose Product Thumbnail #8" data-update="Use For Product Thumbnail #8" /><br/>
		<small>(enter an URL or upload an image for the 8th Product Image)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_upload_image8_alt">Product Thumbnail #8 Description ( Alt Text ): </label><br/>
		<input id="et_upload_image8_alt" type="text" size="90" name="et_upload_image8_alt" value="<?php echo esc_attr( $thumbnail8_alt ); ?>" />
	</p>

	<p style="margin-bottom: 22px;">
		<label for="featured_image">Featured Product Alternative Image: </label><br/>
		<input id="featured_image" type="text" size="90" name="featured_image" value="<?php echo esc_attr($featured_image); ?>" />
		<input class="upload_image_button" type="button" value="Upload Image" data-choose="Choose Featured Product Alternative Image" data-update="Use For Featured Product Alternative Image" /><br/>
		<small>(enter an URL or upload an image to use as Featured Product Alternative Image)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_property_type">Property Type:</label>
		<input name="et_property_type" id="et_property_type" type="text" value="<?php echo esc_attr($et_property_type); ?>" size="30" />
		<small>(ex. Condo)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_bedrooms_number">Number of Bedrooms:</label>
		<input name="et_bedrooms_number" id="et_bedrooms_number" type="text" value="<?php echo esc_attr($et_bedrooms_number); ?>" size="6" />
		<small>(ex. 1)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_bathrooms_number">Number of Bathrooms:</label>
		<input name="et_bathrooms_number" id="et_bathrooms_number" type="text" value="<?php echo esc_attr($et_bathrooms_number); ?>" size="6" />
		<small>(ex. 1)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_garages_number">Number of Garages:</label>
		<input name="et_garages_number" id="et_garages_number" type="text" value="<?php echo esc_attr($et_garages_number); ?>" size="6" />
		<small>(ex. 1)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label for="et_square_footage">Square Footage:</label>
		<input name="et_square_footage" id="et_square_footage" type="text" value="<?php echo esc_attr($et_square_footage); ?>" size="6" />
		<small>(ex. 1)</small>
	</p>

	<p style="margin-bottom: 22px;">
		<label class="selectit" for="et_show_googlemaps">
			<input type="checkbox" name="et_show_googlemaps" id="et_show_googlemaps" value=""<?php checked( $integrate_gmaps ); ?> /> Integrate google maps
		</label>
	</p>
	<!-- <p style="margin-bottom: 22px;">
		<label for="et_latitude" style="padding-right:14px;">Latitude</label>
		<input name="et_latitude" id="et_latitude" type="text" value="<?php #echo $et_latitude; ?>" size="30" />
		<small>(ex. 40.713279732514515)</small>
	</p>
	<p style="margin-bottom: 22px;">
		<label for="et_longtitude">Longtitude</label>
		<input name="et_longtitude" id="et_longtitude" type="text" value="<?php #echo $et_longtitude; ?>" size="30" />
		<small>(ex. -74.00542840361595)</small>
	</p> -->
	<p style="margin-bottom: 22px;">
		<label for="et_address">Address</label>
		<input name="et_address" id="et_address" type="text" value="<?php echo esc_attr($et_address); ?>" size="100" />
		<small>(ex. 270 Park Ave. New York)</small>
	</p>
	<?php
}

function elegantestate_save_details( $post_id, $post ){
	global $pagenow;

	if ( 'post.php' != $pagenow ) return $post_id;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	if ( !isset( $_POST['et_settings_nonce'] ) || ! wp_verify_nonce( $_POST['et_settings_nonce'], basename( __FILE__ ) ) )
        return $post_id;

	if ( isset( $_POST["et_price"] ) && $_POST["et_price"] <> '' )
		update_post_meta( $post_id, "price", sanitize_text_field( $_POST["et_price"] ) );
	else
		delete_post_meta( $post_id, "price" );

	if ( isset( $_POST["et_description"] ) && $_POST["et_description"] <> '' )
		update_post_meta( $post_id, "description", $_POST["et_description"] );
	else
		delete_post_meta( $post_id, "description" );

	if ( isset( $_POST["et_property_type"] ) && $_POST["et_property_type"] <> '' )
		update_post_meta( $post_id, "et_property_type", sanitize_text_field( $_POST["et_property_type"] ) );
	else
		delete_post_meta( $post_id, "et_property_type" );

	if ( isset( $_POST["et_bedrooms_number"] ) && $_POST["et_bedrooms_number"] <> '' )
		update_post_meta( $post_id, "et_bedrooms_number", sanitize_text_field( $_POST["et_bedrooms_number"] ) );
	else
		delete_post_meta( $post_id, "et_bedrooms_number" );

	if ( isset( $_POST["et_bathrooms_number"] ) && $_POST["et_bathrooms_number"] <> '' )
		update_post_meta( $post_id, "et_bathrooms_number", sanitize_text_field( $_POST["et_bathrooms_number"] ) );
	else
		delete_post_meta( $post_id, "et_bathrooms_number" );

	if ( isset( $_POST["et_garages_number"] ) && $_POST["et_garages_number"] <> '' )
		update_post_meta( $post_id, "et_garages_number", sanitize_text_field( $_POST["et_garages_number"] ) );
	else
		delete_post_meta( $post_id, "et_garages_number" );

	if ( isset( $_POST["et_square_footage"] ) && $_POST["et_square_footage"] <> '' )
		update_post_meta( $post_id, "et_square_footage", sanitize_text_field( $_POST["et_square_footage"] ) );
	else
		delete_post_meta( $post_id, "et_square_footage" );

	/*if (isset($_POST["et_latitude"]) && $_POST["et_latitude"] <> '') update_post_meta($post->ID, "et_latitude", $_POST["et_latitude"]);
	if (isset($_POST["et_longtitude"]) && $_POST["et_longtitude"] <> '') update_post_meta($post->ID, "et_longtitude", $_POST["et_longtitude"]); */

	if ( isset( $_POST["et_address"] ) && $_POST["et_address"] <> '' )
		update_post_meta( $post_id, "et_address", sanitize_text_field( $_POST["et_address"] ) );
	else
		delete_post_meta( $post_id, "et_address" );

	if ( isset( $_POST["et_show_googlemaps"] ) )
		update_post_meta( $post_id, "integrate_gmaps", 1 );
	else
		delete_post_meta( $post_id, "integrate_gmaps" );

	if ( isset( $_POST["et_upload_image"] ) && $_POST["et_upload_image"] <> '' )
		$thumbs[] = esc_url_raw( $_POST["et_upload_image"] );
	if ( isset( $_POST["et_upload_image2"] ) && $_POST["et_upload_image2"] <> '' )
		$thumbs[] = esc_url_raw( $_POST["et_upload_image2"] );
	if ( isset( $_POST["et_upload_image3"] ) && $_POST["et_upload_image3"] <> '' )
		$thumbs[] = esc_url_raw( $_POST["et_upload_image3"] );
	if ( isset( $_POST["et_upload_image4"] ) && $_POST["et_upload_image4"] <> '' )
		$thumbs[] = esc_url_raw( $_POST["et_upload_image4"] );
	if ( isset( $_POST["et_upload_image5"] ) && $_POST["et_upload_image5"] <> '' )
		$thumbs[] = esc_url_raw( $_POST["et_upload_image5"] );
	if ( isset( $_POST["et_upload_image6"] ) && $_POST["et_upload_image6"] <> '' )
		$thumbs[] = esc_url_raw( $_POST["et_upload_image6"] );
	if ( isset( $_POST["et_upload_image7"] ) && $_POST["et_upload_image7"] <> '' )
		$thumbs[] = esc_url_raw( $_POST["et_upload_image7"] );
	if ( isset( $_POST["et_upload_image8"] ) && $_POST["et_upload_image8"] <> '' )
		$thumbs[] = esc_url_raw( $_POST["et_upload_image8"] );

	if ( isset( $_POST["et_upload_image_alt"] ) && $_POST["et_upload_image_alt"] <> '' )
		$thumbs_alt[] = sanitize_text_field( $_POST["et_upload_image_alt"] );
	if ( isset( $_POST["et_upload_image2_alt"] ) && $_POST["et_upload_image2_alt"] <> '' )
		$thumbs_alt[] = sanitize_text_field( $_POST["et_upload_image2_alt"] );
	if ( isset( $_POST["et_upload_image3_alt"] ) && $_POST["et_upload_image3_alt"] <> '' )
		$thumbs_alt[] = sanitize_text_field( $_POST["et_upload_image3_alt"] );
	if ( isset( $_POST["et_upload_image4_alt"] ) && $_POST["et_upload_image4_alt"] <> '' )
		$thumbs_alt[] = sanitize_text_field( $_POST["et_upload_image4_alt"] );
	if ( isset( $_POST["et_upload_image5_alt"] ) && $_POST["et_upload_image5_alt"] <> '' )
		$thumbs_alt[] = sanitize_text_field( $_POST["et_upload_image5_alt"] );
	if ( isset( $_POST["et_upload_image6_alt"] ) && $_POST["et_upload_image6_alt"] <> '' )
		$thumbs_alt[] = sanitize_text_field( $_POST["et_upload_image6_alt"] );
	if ( isset( $_POST["et_upload_image7_alt"] ) && $_POST["et_upload_image7_alt"] <> '' )
		$thumbs_alt[] = sanitize_text_field( $_POST["et_upload_image7_alt"] );
	if ( isset( $_POST["et_upload_image8_alt"] ) && $_POST["et_upload_image8_alt"] <> '' )
		$thumbs_alt[] = sanitize_text_field( $_POST["et_upload_image8_alt"] );

	if ( ! empty( $thumbs ) )
		update_post_meta( $post_id, "thumbs", $thumbs );
	else
		delete_post_meta( $post_id, "thumbs" );

	if ( ! empty( $thumbs_alt ) )
		update_post_meta( $post_id, "_thumbs_alt", $thumbs_alt );
	else
		delete_post_meta( $post_id, "_thumbs_alt" );

	if ( isset( $_POST["featured_image"] ) && $_POST["featured_image"] <> '' )
		update_post_meta( $post_id, "featured_image", esc_url_raw( $_POST["featured_image"] ) );
	else
		delete_post_meta( $post_id, "featured_image" );

	if ( isset( $_POST["et_page_template"] ) )
		update_post_meta( $post_id, "et_page_template", sanitize_text_field( $_POST["et_page_template"] ) );
	else
		delete_post_meta( $post_id, "et_page_template" );
}
add_action( 'save_post', 'elegantestate_save_details', 10, 2 );

function elegantestate_upload_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', get_template_directory_uri().'/js/custom_uploader.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
}

function elegantestate_upload_styles() {
	wp_enqueue_style('thickbox');
}
add_action('admin_print_scripts', 'elegantestate_upload_scripts');
add_action('admin_print_styles', 'elegantestate_upload_styles');