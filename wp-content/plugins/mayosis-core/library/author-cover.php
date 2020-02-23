<?php
/**
 * Enqueue scripts and styles
 */
function mayosis_enqueue_scripts_styles() {
	wp_register_script( 'mayosis_admin_js', plugins_url( 'mayosis-core/js/user-image.js' ), array( 'jquery' ), '1.0.0', true );

	// Enqueue.
	wp_enqueue_script( 'mayosis_admin_js' );
}

add_action( 'admin_enqueue_scripts', 'mayosis_enqueue_scripts_styles' );

/**
 * Show the new image field in the user profile page.
 *
 * @param object $user User object.
 */
function mayosis_profile_img_fields( $user ) {
	if ( ! current_user_can( 'upload_files' ) ) {
		return;
	}

	// vars
	$url             = get_the_author_meta( 'mayosis_meta', $user->ID );
	$upload_url      = get_the_author_meta( 'mayosis_upload_meta', $user->ID );
	$upload_edit_url = get_the_author_meta( 'mayosis_upload_edit_meta', $user->ID );
	$button_text     = $upload_url ? 'Change Current Image' : 'Upload New Image';

	if ( $upload_url ) {
		$upload_edit_url = get_site_url() . $upload_edit_url;
	}
	?>

	<div id="mayosis_container">
		<h3><?php _e( 'Custom User Cover Photo', 'custom-user-profile-photo' ); ?></h3>

		<table class="form-table">
			<tr>
				<th><label for="mayosis_meta"><?php _e( 'Cover Photo', 'custom-user-profile-photo' ); ?></label></th>
				<td>
					<!-- Outputs the image after save -->
					<div id="current_img">
						<?php if ( $upload_url ): ?>
							<img class="mayosis-current-img author-img-trans" src="<?php echo esc_url( $upload_url ); ?>" style="max-width:300px"/>

							<div class="edit_options uploaded">
								<a class="remove_img">
									<span><?php _e( 'Remove', 'custom-user-profile-photo' ); ?></span>
								</a>

								<a class="edit_img" href="<?php echo esc_url( $upload_edit_url ); ?>" target="_blank">
									<span><?php _e( 'Edit', 'custom-user-profile-photo' ); ?></span>
								</a>
							</div>
						<?php elseif ( $url ) : ?>
							<img class="mayosis-current-img" src="<?php echo esc_url( $url ); ?>"/>
							<div class="edit_options single">
								<a class="remove_img">
									<span><?php _e( 'Remove', 'custom-user-profile-photo' ); ?></span>
								</a>
							</div>
						<?php else : ?>
							<img class="mayosis-current-img placeholder"
							     src="<?php echo esc_url( plugins_url( 'custom-user-profile-photo/img/placeholder.gif' ) ); ?>"/>
						<?php endif; ?>
					</div>

					<!-- Select an option: Upload to WPMU or External URL -->
					<div id="mayosis_options">
						<input type="radio" id="upload_option" name="img_option" value="upload" class="tog" checked>
						<label
								for="upload_option"><?php _e( 'Upload New Image', 'custom-user-profile-photo' ); ?></label><br>

						<input type="radio" id="external_option" name="img_option" value="external" class="tog">
						<label
								for="external_option"><?php _e( 'Use External URL', 'custom-user-profile-photo' ); ?></label><br>
					</div>

					<!-- Hold the value here if this is a WPMU image -->
					<div id="mayosis_upload">
						<input class="hidden" type="hidden" name="mayosis_placeholder_meta" id="mayosis_placeholder_meta"
						       value="<?php echo esc_url( plugins_url( 'custom-user-profile-photo/img/placeholder.gif' ) ); ?>"/>
						<input class="hidden" type="hidden" name="mayosis_upload_meta" id="mayosis_upload_meta"
						       value="<?php echo esc_url_raw( $upload_url ); ?>"/>
						<input class="hidden" type="hidden" name="mayosis_upload_edit_meta" id="mayosis_upload_edit_meta"
						       value="<?php echo esc_url_raw( $upload_edit_url ); ?>"/>
						<input id="uploadimage" type='button' class="mayosis_wpmu_button button-primary"
						       value="<?php _e( esc_attr( $button_text ), 'custom-user-profile-photo' ); ?>"/>
						<br/>
					</div>

					<!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
					<div id="mayosis_external">
						<input class="regular-text" type="text" name="mayosis_meta" id="mayosis_meta"
						       value="<?php echo esc_url_raw( $url ); ?>"/>
					</div>

					<!-- Outputs the save button -->
					<span class="description">
						<?php
						_e(
							'Upload a custom photo for your user profile or use a URL to a pre-existing photo.',
							'custom-user-profile-photo'
						);
						?>
					</span>
					<p class="description">
						<?php _e( 'Update Profile to save your changes.', 'custom-user-profile-photo' ); ?>
					</p>
				</td>
			</tr>
		</table><!-- end form-table -->
	</div> <!-- end #mayosis_container -->

	<?php
	// Enqueue the WordPress Media Uploader.
	wp_enqueue_media();
}

add_action( 'show_user_profile', 'mayosis_profile_img_fields' );
add_action( 'edit_user_profile', 'mayosis_profile_img_fields' );


/**
 * Save the new user mayosis url.
 *
 * @param int $user_id ID of the user's profile being saved.
 */
function mayosis_save_img_meta( $user_id ) {
	if ( ! current_user_can( 'upload_files', $user_id ) ) {
		return;
	}

	$values = array(
		// String value. Empty in this case.
		'mayosis_meta'             => filter_input( INPUT_POST, 'mayosis_meta', FILTER_SANITIZE_STRING ),

		// File path, e.g., http://3five.dev/wp-content/plugins/custom-user-profile-photo/img/placeholder.gif.
		'mayosis_upload_meta'      => filter_input( INPUT_POST, 'mayosis_upload_meta', FILTER_SANITIZE_URL ),

		// Edit path, e.g., /wp-admin/post.php?post=32&action=edit&image-editor.
		'mayosis_upload_edit_meta' => filter_input( INPUT_POST, 'mayosis_upload_edit_meta', FILTER_SANITIZE_URL ),
	);

	foreach ( $values as $key => $value ) {
		update_user_meta( $user_id, $key, $value );
	}
}

add_action( 'personal_options_update', 'mayosis_save_img_meta' );
add_action( 'edit_user_profile_update', 'mayosis_save_img_meta' );

/**
 * Retrieve the appropriate image size
 *
 * @param int    $user_id      Default: $post->post_author. Will accept any valid user ID passed into this parameter.
 * @param string $size         Default: 'thumbnail'. Accepts all default WordPress sizes and any custom sizes made by
 *                             the add_image_size() function.
 *
 * @return string      (Url) Use this inside the src attribute of an image tag or where you need to call the image url.
 */
function mayosis_profile_meta( $user_id, $size = 'thumbnail' ) {
	global $post;

	if ( ! $user_id || ! is_numeric( $user_id ) ) {
		/*
		 * Here we're assuming that the avatar being called is the author of the post.
		 * The theory is that when a number is not supplied, this function is being used to
		 * get the avatar of a post author using get_avatar() and an email address is supplied
		 * for the $id_or_email parameter. We need an integer to get the custom image so we force that here.
		 * Also, many themes use get_avatar on the single post pages and pass it the author email address so this
		 * acts as a fall back.
		 */
		$user_id = $post->post_author;
	}

	// Check first for a custom uploaded image.
	$attachment_upload_url = esc_url( get_the_author_meta( 'mayosis_upload_meta', $user_id ) );

	if ( $attachment_upload_url ) {
		// Grabs the id from the URL using the WordPress function attachment_url_to_postid @since 4.0.0.
		$attachment_id = attachment_url_to_postid( $attachment_upload_url );

		// Retrieve the thumbnail size of our image. Should return an array with first index value containing the URL.
		$image_thumb = wp_get_attachment_image_src( $attachment_id, $size );

		return isset( $image_thumb[0] ) ? $image_thumb[0] : '';
	}

	// Finally, check for image from an external URL. If none exists, return an empty string.
	$attachment_ext_url = esc_url( get_the_author_meta( 'mayosis_meta', $user_id ) );

	return $attachment_ext_url ? $attachment_ext_url : '';
}


/**
 * Get a WordPress User by ID or email
 *
 * @param int|object|string $identifier User object, ID or email address.
 *
 * @return WP_User
 */
function mayosis_get_user_by_id_or_email( $identifier ) {
	// If an integer is passed.
	if ( is_numeric( $identifier ) ) {
		return get_user_by( 'id', (int) $identifier );
	}

	// If the WP_User object is passed.
	if ( is_object( $identifier ) && property_exists( $identifier, 'ID' ) ) {
		return get_user_by( 'id', (int) $identifier->ID );
	}

	// If the WP_Comment object is passed.
	if ( is_object( $identifier ) && property_exists( $identifier, 'user_id' ) ) {
		return get_user_by( 'id', (int) $identifier->user_id );
	}

	return get_user_by( 'email', $identifier );
}
