<?php

function mayosis_customize_register( $wp_customize ) {
    //All our sections, settings, and controls will be added here

    $wp_customize->remove_section( 'title_tagline');
    $wp_customize->remove_section( 'colors');
    $wp_customize->remove_section( 'header_image');
    $wp_customize->remove_section( 'background_image');
    $wp_customize->remove_section( 'static_front_page');


}
add_action( 'customize_register', 'mayosis_customize_register',50 );


/**
 * Removes the core 'Menus' panel from the Customizer.
 *
 * @param array $components Core Customizer components list.
 * @return array (Maybe) modified components list.
 */
function mayosis_remove_nav_menus_panel( $components ) {
    $i = array_search( 'nav_menus', $components );
    if ( false !== $i ) {
        unset( $components[ $i ] );
    }
    return $components;
}
add_filter( 'customize_loaded_components', 'mayosis_remove_nav_menus_panel' );

