<?php
Mayosis_Option::add_panel( 'white_label', array(
	'title'       => __( 'White Label', 'mayosis' ),
	'description' => __( 'White Label', 'mayosis' ),
	'priority' => '11',
) );

Mayosis_Option::add_section( 'admin_logo_white', array(
	'title'       => __( 'Admin', 'mayosis' ),
	'panel'       => 'white_label',

) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'image',
        'settings'    => 'admin_logo',
        'label'       => esc_attr__( 'Admin Login Logo', 'mayosis' ),
        'description' => esc_attr__( 'Recommanded Size 130 x 90px Maximum', 'mayosis' ),
        'section'     => 'admin_logo_white',
        'default'     => get_template_directory_uri() . '/images/logo.png',
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'multicolor',
        'settings'    => 'gradient_admin',
        'label'       => esc_attr__( 'Admin gradient bg', 'mayosis' ),
        'section'     => 'admin_logo_white',
        'priority'    => 10,
        'choices'     => array(
            'color1'    => esc_attr__( 'Form', 'mayosis' ),
            'color2'   => esc_attr__( 'To', 'mayosis' ),
        ),
        'default'     => array(
            'color1'    => '#1e0046',
            'color2'   => '#1e0064',
        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'color',
        'settings'     => 'login_button_admin',
        'label'       => __( 'Login Button Color', 'mayosis' ),
        'description' => __( 'Main Admin Login Button Color', 'mayosis' ),
        'section'     => 'admin_logo_white',
        'priority'    => 10,
        'default'     => '#5a00f0',
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#ff6b6b',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
    
) );
