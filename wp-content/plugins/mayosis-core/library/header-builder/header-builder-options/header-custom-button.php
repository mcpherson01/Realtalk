<?php

Mayosis_Option::add_section( 'header_custom_button', array(
	'title'       => __( 'Custom Button', 'mayosis' ),
	'panel'       => 'header',
) );


Mayosis_Option::add_field( 'mayo_config',  array(
    'type'     => 'text',
	'settings' => 'custom_button_text',
	'label'    => __( 'Button Text', 'mayosis' ),
	'section'  => 'header_custom_button',
	'default'  => esc_attr__( 'Button', 'mayosis' ),
));


Mayosis_Option::add_field( 'mayo_config',  array(
    'type'     => 'link',
	'settings' => 'custom_button_url',
	'label'    => __( 'Button URL', 'mayosis' ),
	'section'  => 'header_custom_button',
	'default'  => esc_attr__( 'http://yourdomain.com', 'mayosis' ),
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'radio-buttonset',
	'settings'    => 'ct-button-type',
	'label'       => __( 'Custom Button Type', 'mayosis' ),
	'section'     => 'header_custom_button',
	'default'     => 'standard-button',
	'priority'    => 10,
	'choices'     => array(
		'standard-button'  => esc_attr__( 'Standard', 'mayosis' ),
		'ghost-button' => esc_attr__( 'Ghost', 'mayosis' ),
	),
) );


Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'color',
	'settings'    => 'button-bg-ct',
	'label'       => __( 'Custom Button Background', 'mayosis' ),
	'section'     => 'header_custom_button',
	'default'     => '#0088CC',
	'choices'     => array(
		'alpha' => true,
	),
) );

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'color',
	'settings'    => 'button-border-ct',
	'label'       => __( 'Custom Button Border', 'mayosis' ),
	'section'     => 'header_custom_button',
	'default'     => '#0088CC',
	'choices'     => array(
		'alpha' => true,
	),
) );

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'color',
	'settings'    => 'button-color-text',
	'label'       => __( 'Custom Button Text', 'mayosis' ),
	'section'     => 'header_custom_button',
	'default'     => '#ffffff',
	'choices'     => array(
		'alpha' => true,
	),
) );


Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'color',
	'settings'    => 'button-bghover-ct',
	'label'       => __( 'Custom Button Background Hover Color', 'mayosis' ),
	'section'     => 'header_custom_button',
	'default'     => '#0088CC',
	'choices'     => array(
		'alpha' => true,
	),
) );

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'color',
	'settings'    => 'button-borderhov-ct',
	'label'       => __( 'Custom Button Border Hover Color', 'mayosis' ),
	'section'     => 'header_custom_button',
	'default'     => '#0088CC',
	'choices'     => array(
		'alpha' => true,
	),
) );

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'color',
	'settings'    => 'button-colorhov-text',
	'label'       => __( 'Custom Button Text Hover Color', 'mayosis' ),
	'section'     => 'header_custom_button',
	'default'     => '#ffffff',
	'choices'     => array(
		'alpha' => true,
	),
) );
