<?php get_header(); ?>

<?php
	$et_convertible_settings = get_option( 'et_convertable_settings' );

	if ( $et_convertible_settings['layout_shortcode'] && '' != $et_convertible_settings['layout_shortcode'] ) {
		echo do_shortcode( stripslashes( $et_convertible_settings['layout_shortcode'] ) );
	} else {
		if ( is_user_logged_in() && current_user_can('manage_options') ) echo '<h1>' . sprintf( __('Please, go to <a href="%s" style="color: #00B7F3;">Layout Builder</a> to setup modules.','Convertible'), admin_url('themes.php?page=et_layout_builder_convertible') ) . '</h1>';
	}
?>

<?php get_footer(); ?>