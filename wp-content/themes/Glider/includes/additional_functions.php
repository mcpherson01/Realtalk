<?php

/* Meta boxes */

function glider_add_custom_panels(){
	add_meta_box("et_post_meta", "ET Settings", "glider_post_meta", "page", "normal", "high");
}
add_action("admin_init", "glider_add_custom_panels");

function glider_post_meta() {
	$custom = get_post_custom( get_the_ID() );

	$et_portfolio_page = isset($custom["et_portfolio_page"][0]) ? (bool) $custom["et_portfolio_page"][0] : false;
	$et_portfolio_categories = isset($custom["et_portfolio_categories"][0]) ? $custom["et_portfolio_categories"][0] : '';

	$et_portfolio_cats_array = ( $et_portfolio_categories <> '' ) ? explode(",", $et_portfolio_categories) : array();

	wp_nonce_field( basename( __FILE__ ), 'et_settings_nonce' );
?>

	<div id="et_custom_categories_content" style="margin: 13px 0 11px 4px;">
		<label class="selectit" for="et_portfolio_page">
			<input type="checkbox" name="et_portfolio_page" id="et_portfolio_page" value=""<?php checked( $et_portfolio_page ); ?> /> Use For Homepage Portfolio</label><br/>

		<div id="et_portfolio_categories_box" style="display: none;">
			<h4>Select portfolio categories:</h4>

			<?php $cats_array = get_categories('hide_empty=0');
				$site_cats = array();
				foreach ($cats_array as $categs) {
					$checked = '';

					if (!empty($et_portfolio_cats_array)) {
						if (in_array($categs->cat_ID, $et_portfolio_cats_array)) $checked = "checked=\"checked\"";
					} ?>

					<label style="width: 200px; float: left; padding-bottom: 5px;" for="<?php echo 'et_portfolio_categories-',$categs->cat_ID; ?>">
						<input type="checkbox" name="et_portfolio_categories[]" id="<?php echo esc_attr( 'et_portfolio_categories-' . $categs->cat_ID ); ?>" value="<?php echo esc_attr( $categs->cat_ID ); ?>" <?php echo $checked; ?> />
						<?php echo esc_html( $categs->cat_name ); ?>
					</label>

				<?php } ?>
			<br style="clear: both;" />
		</div>
	</div>

	<?php
}

function glider_custom_panel_save( $post_id, $post ){
	global $pagenow;

	if ( 'post.php' != $pagenow ) return $post_id;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	if ( !isset( $_POST['et_settings_nonce'] ) || ! wp_verify_nonce( $_POST['et_settings_nonce'], basename( __FILE__ ) ) )
        return $post_id;

	if (isset($_POST["et_portfolio_page"])) update_post_meta($post_id, "et_portfolio_page", 1);
	else update_post_meta($post_id, "et_portfolio_page", 0);

	if (isset($_POST["et_portfolio_categories"])) update_post_meta($post_id, "et_portfolio_categories", implode(",", $_POST["et_portfolio_categories"]));
	else update_post_meta($post_id, "et_portfolio_categories", '');

}
add_action( 'save_post', 'glider_custom_panel_save', 10, 2 );

add_action( 'admin_enqueue_scripts', 'glider_upload_categories_scripts' );
function glider_upload_categories_scripts( $hook_suffix ) {
	if ( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {
		wp_register_script('et-categories', get_template_directory_uri().'/js/et-categories.js', array('jquery'));
		wp_enqueue_script('et-categories');
	}
}