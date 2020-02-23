<?php
function videopro_scripts_styles_child_theme() {
	global $wp_styles;
	wp_enqueue_style( 'videopro-parent', get_template_directory_uri() . '/style.css');
}
add_action( 'wp_enqueue_scripts', 'videopro_scripts_styles_child_theme' );

/**
 * Support MyCred plugin
 **/
add_filter('cactus_player_shortcode', 'videopro_child_cactus_player_shortcode_filter', 10, 3);
function videopro_child_cactus_player_shortcode_filter($html, $atts, $content){
	if(shortcode_exists('mycred_sell_this')){
		return do_shortcode('[mycred_sell_this]' . $html . '[/mycred_sell_this]');
	} else {
		return $html;
	}
}

/* Disable VC auto-update */
function videopro_vc_disable_update() {
    if (function_exists('vc_license') && function_exists('vc_updater') && ! vc_license()->isActivated()) {

        remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ), 10);
        remove_filter( 'pre_set_site_transient_update_plugins', array(
            vc_updater()->updateManager(),
            'check_update'
        ) );

    }
}
add_action( 'admin_init', 'videopro_vc_disable_update', 9 );