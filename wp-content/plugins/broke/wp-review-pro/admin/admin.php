<?php
/**
 * Admin functions for this plugin.
 *
 * @since     1.0
 * @copyright Copyright (c) 2013, MyThemesShop
 * @author    MyThemesShop
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register admin.css file. */
add_action( 'admin_enqueue_scripts', 'wp_review_admin_style' );

/**
 * Register custom style for the meta box.
 *
 * @since 1.0
 */
function wp_review_admin_style( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'post-new.php', 'post.php', 'edit.php', 'settings_page_wp-review-pro/admin/options' ) ) ) {
		return;
	}

	wp_register_script( 'jquery-knob', trailingslashit( WP_REVIEW_ASSETS ) . 'js/jquery.knob.min.js', array( 'jquery' ), '1.1', true );
	wp_enqueue_style( 'wp-review-admin-style', WP_REVIEW_ASSETS . 'css/admin.css', array( 'wp-color-picker' ) );
	wp_enqueue_script(
		'wp-review-admin-script',
		WP_REVIEW_ASSETS . 'js/admin.js',
		array( 'wp-color-picker', 'jquery', 'jquery-ui-core', 'jquery-ui-slider', 'jquery-ui-sortable', 'jquery-ui-datepicker' ),
		false,
		true
	);
	wp_localize_script(
		'wp-review-admin-script',
		'wprVars',
		array(
			'ratingPermissionsCommentOnly' => WP_REVIEW_REVIEW_COMMENT_ONLY,
			'ratingPermissionsBoth'        => WP_REVIEW_REVIEW_ALLOW_BOTH,
			'imgframe_title'               => __( 'Select Image', 'wp-review' ),
			'imgbutton_title'              => __( 'Insert Image', 'wp-review' ),
			'imgremove_title'              => __( 'Remove Image', 'wp-review' ),
		)
	);

	wp_enqueue_style(
		'wp-review-pro-admin-ui-css',
		'//ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/smoothness/jquery-ui.css',
		false,
		null,
		false
	);

	// Load frontend css but not on the post editor screen
	if ( stripos('post.php', $hook_suffix) === false ) {
		wp_enqueue_style( 'wp_review-style', trailingslashit( WP_REVIEW_ASSETS ) . 'css/wp-review.css', array(), WP_REVIEW_PLUGIN_VERSION, 'all' );
	}
}
?>