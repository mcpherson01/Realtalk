<?php

Mayosis_Option::add_section( 'header_content', array(
	'title'       => __( 'Code Block', 'mayosis' ),
	'panel'       => 'header',
) );


Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'textarea',
	'settings'     => 'topbar_left',
	'transport' => $transport,
	'label'       => __( 'Code Block', 'mayosis' ),
	'description' => __( 'Add text or code here', 'mayosis' ),
	'section'     => 'header_content',
));



Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'textarea',
	'settings'     => 'topbar_right',
	'transport' => $transport,
	'label'       => __( 'Code Block 2', 'mayosis' ),
	'description' => __( 'Add text or code here', 'mayosis' ),
	'section'     => 'header_content',
));


function mayosis_refresh_header_partials( WP_Customize_Manager $wp_customize ) {

	if ( ! isset( $wp_customize->selective_refresh ) ) {
	      return;
	  }
	
	$wp_customize->selective_refresh->add_partial( 'topbar_left', array(
	    'selector' => '.html_topbar_left',
	    'settings' => array('topbar_left'),
	    'render_callback' => function() {
	        return Mayosis_Option('topbar_left');
	    },
	) );

	$wp_customize->selective_refresh->add_partial( 'topbar_right', array(
	    'selector' => '.html_topbar_right',
	    'settings' => array('topbar_right'),
	    'render_callback' => function() {
	        return Mayosis_Option('topbar_right');
	    },
	) );



}
add_action( 'customize_register', 'mayosis_refresh_header_partials' );