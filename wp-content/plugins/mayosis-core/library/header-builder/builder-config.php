<?php

function mayosis_custom_sanitize($content){
  return $content;
}

function mayosis_enqueue_customizer_stylesheet() {
    $theme = wp_get_theme( 'mayosis' );
    $version = $theme['Version'];

    wp_enqueue_script( 'mayosis-customizer-admin-js', plugin_dir_url( __FILE__ ) . 'assets/js/mayosis-admin.js', NULL, $version, 'all' );
    wp_enqueue_style( 'mayosis-header-builder-css',plugin_dir_url( __FILE__ )  . 'assets/css/mayosis-header-builder.css', NULL, $version, 'all' );
}
add_action( 'customize_controls_print_styles', 'mayosis_enqueue_customizer_stylesheet' );
