<?php

Mayosis_Option::add_section( 'header_logo', array(
	'title'       => __( 'Logo', 'mayosis' ),
	'panel'       => 'header',
	//'description' => __( 'This is the section description', 'mayosis' ),
) );



Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'image',
	'settings'     => 'main_logo',
	'label'       => __( 'Logo image', 'mayosis' ),
	'description' => __( 'Upload 2X Logo for retina & use size from below.', 'mayosis' ),
	'section'     => 'header_logo',
	'default'     => get_template_directory_uri().'/images/logo.png',
	'transport' => 'auto',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'image',
	'settings'     => 'mobile-logo-image',
	'label'       => __( 'Mobile Logo Image', 'mayosis' ),
	'description' => __( 'Upload different logo on mobile', 'mayosis' ),
	'section'     => 'header_logo',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'image',
	'settings'     => 'sticky_logo',
	'label'       => __( 'Sticky Header Logo Image', 'mayosis' ),
	'description' => __( 'Upload different logo on sticky header', 'mayosis' ),
	'section'     => 'header_logo',
));

Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'image',
'settings'    => 'favicon-upload',
'label'       => esc_attr__( 'Favicon', 'mayosis' ),
'description' => esc_attr__( 'Recommanded 80 X 80px', 'mayosis' ),
'section'     => 'header_logo',
'default'     => get_template_directory_uri() . '/images/fav.png',
));
 
 Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
	'settings'    => 'logo_property',
	'label'       => __( 'Set Logo Property', 'mayosis' ),
	'section'     => 'header_logo',
	'default'     => 'width',
	'description'     => 'Set logo size property by Width or Height',
	'choices'     => array(
		'width'   => esc_attr__( 'Width', 'mayosis' ),
		'height' => esc_attr__( 'Height', 'mayosis' ),
	),
));

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'dimension',
	'settings'    => 'logo-width',
	'label'       => esc_attr__( 'Logo Width', 'mayosis' ),
	'description' => esc_attr__( 'Add Logo Width', 'mayosis' ),
	'section'     => 'header_logo',
	'default'     => '',
	'required'    => array(
            array(
                'setting'  => 'logo_property',
                'operator' => '==',
                'value'    => 'width',
            ),
        ),
    ));
    
    Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'dimension',
	'settings'    => 'logo-height',
	'label'       => esc_attr__( 'Logo Height', 'mayosis' ),
	'description' => esc_attr__( 'Add Logo Height', 'mayosis' ),
	'section'     => 'header_logo',
	'default'     => '',
	'required'    => array(
            array(
                'setting'  => 'logo_property',
                'operator' => '==',
                'value'    => 'height',
            ),
        ),
    ));
    
    Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
	'settings'    => 'logo_property_mobile',
	'label'       => __( 'Set Logo Property(Mobile)', 'mayosis' ),
	'section'     => 'header_logo',
	'default'     => 'width',
	'description'     => 'Set logo size property by Width or Height',
	'choices'     => array(
		'width'   => esc_attr__( 'Width', 'mayosis' ),
		'height' => esc_attr__( 'Height', 'mayosis' ),
	),
));

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'dimension',
	'settings'    => 'logo-width-mobile',
	'label'       => esc_attr__( 'Logo Width(Mobile)', 'mayosis' ),
	'description' => esc_attr__( 'Add Logo Width', 'mayosis' ),
	'section'     => 'header_logo',
	'default'     => '',
	'required'    => array(
            array(
                'setting'  => 'logo_property_mobile',
                'operator' => '==',
                'value'    => 'width',
            ),
        ),
    ));
    
    Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'dimension',
	'settings'    => 'logo-height-mobile',
	'label'       => esc_attr__( 'Logo Height(Mobile)', 'mayosis' ),
	'description' => esc_attr__( 'Add Logo Height', 'mayosis' ),
	'section'     => 'header_logo',
	'default'     => '',
	'required'    => array(
            array(
                'setting'  => 'logo_property_mobile',
                'operator' => '==',
                'value'    => 'height',
            ),
        ),
    ));