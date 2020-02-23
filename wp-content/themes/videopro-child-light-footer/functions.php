<?php
function videopro_scripts_styles_child_theme() {
	global $wp_styles;
	wp_enqueue_style( 'videopro-parent', get_template_directory_uri() . '/style.css');
}
add_action( 'wp_enqueue_scripts', 'videopro_scripts_styles_child_theme' );

add_filter('videopro-footer-schema','videopro_footer_schema');
function videopro_footer_schema($current){
    return '';
}

