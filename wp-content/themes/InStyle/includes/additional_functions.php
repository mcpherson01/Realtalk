<?php

/* Meta boxes */

function instyle_add_custom_panels(){
	add_meta_box("et_post_meta", "ET Settings", "instyle_post_meta", "page", "normal", "high");
	add_meta_box("et_post_meta", "ET Settings", "instyle_post_meta", "post", "normal", "high");
}
add_action("admin_init", "instyle_add_custom_panels");

function instyle_post_meta() {
	global $post;

	$temp_array = array();

	$temp_array = maybe_unserialize( get_post_meta($post->ID,'et_instyle_settings',true) );

	$et_fs_bg_images = isset( $temp_array['et_fs_bg_images'] ) ? $temp_array['et_fs_bg_images'] : '';
	$et_fs_title = isset( $temp_array['et_fs_title'] ) ? $temp_array['et_fs_title'] : '';
	$et_fs_description = isset( $temp_array['et_fs_description'] ) ? $temp_array['et_fs_description'] : '';
	$et_fs_link = isset( $temp_array['et_fs_link'] ) ? $temp_array['et_fs_link'] : '';

	wp_nonce_field( basename( __FILE__ ), 'et_settings_nonce' );
?>

	<div id="et_custom_settings" style="margin: 13px 0 17px 4px;">
		<div class="et_fs_setting" style="margin: 13px 0 26px 4px;">
			<label for="et_fs_bg_images" style="color: #000; font-weight: bold;"> Background Image Urls: </label>
			<br />
			<textarea id="et_fs_bg_images" name="et_fs_bg_images" cols="40" rows="1" tabindex="6" style="display: inline; position: relative; top: 5px; width: 490px; height: 125px;"><?php echo esc_textarea( $et_fs_bg_images ); ?></textarea>
			<br />
			<small style="position: relative; top: 8px;">ex: <code><?php echo htmlspecialchars("http://mysite.com/uploads/image1.jpg, http://mysite.com/uploads/image2.jpg, http://mysite.com/uploads/image3.jpg");?></code></small>
		</div>

		<div class="et_fs_setting" style="margin: 13px 0 26px 4px;">
			<label for="et_fs_title" style="color: #000; font-weight: bold;"> Custom Title: </label>
			<input type="text" style="width: 30em;" value="<?php echo wp_kses( $et_fs_title, array( 'span' => array() ) ); ?>" id="et_fs_title" name="et_fs_title" size="87" />
			<br />
			<small style="position: relative; top: 8px;">ex: <code><?php echo htmlspecialchars("<span>innovative</span> design is our passion");?></code></small>
		</div>

		<div class="et_fs_setting" style="margin: 13px 0 26px 4px;">
			<label for="et_fs_description" style="color: #000; font-weight: bold;"> Description Text: </label>
			<input type="text" style="width: 30em;" value="<?php echo wp_kses( $et_fs_description, array( 'span' => array() ) ); ?>" id="et_fs_description" name="et_fs_description" size="87" />
			<br />
			<small style="position: relative; top: 8px;">ex: <code><?php echo htmlspecialchars("we work hard <span>every day</span> to bring your ideas to life");?></code></small>
		</div>

		<div class="et_fs_setting" style="margin: 13px 0 26px 4px;">
			<label for="et_fs_link" style="color: #000; font-weight: bold;"> Custom Featured Link: </label>
			<input type="text" style="width: 30em;" value="<?php echo esc_url( $et_fs_link ); ?>" id="et_fs_link" name="et_fs_link" size="67" />
			<br />
			<small style="position: relative; top: 8px;">If you use this post/page in featured slider and want to change the url, paste it here. ex: <code><?php echo htmlspecialchars("http://mysite.com/newurl");?></code></small>
		</div>
	</div> <!-- #et_custom_settings -->

	<?php
}

add_action( 'save_post', 'instyle_custom_panel_save', 10, 2 );
function instyle_custom_panel_save( $post_id, $post ){
	global $pagenow;

	if ( 'post.php' != $pagenow ) return $post_id;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	if ( !isset( $_POST['et_settings_nonce'] ) || ! wp_verify_nonce( $_POST['et_settings_nonce'], basename( __FILE__ ) ) )
        return $post_id;

	$temp_array = array();
	$temp_array['et_fs_bg_images'] = isset($_POST["et_fs_bg_images"]) ? esc_textarea( $_POST["et_fs_bg_images"] ) : '';
	$temp_array['et_fs_title'] = isset($_POST["et_fs_title"]) ? wp_kses( $_POST["et_fs_title"], array( 'span' => array() ) ) : '';
	$temp_array['et_fs_description'] = isset($_POST["et_fs_description"]) ? wp_kses( $_POST["et_fs_description"], array( 'span' => array() ) ) : '';
	$temp_array['et_fs_link'] = isset($_POST["et_fs_link"]) ? esc_url_raw( $_POST["et_fs_link"] ) : '';

	update_post_meta( $post_id, "et_instyle_settings", $temp_array );
}