<?php

Mayosis_Option::add_section( 'header_login', array(
	'title'       => __( 'Login Button Options', 'mayosis' ),
	'panel'       => 'header',
) );


Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'radio-buttonset',
	'settings'    => 'login_logout_bg_remove',
	'label'       => __( 'Login/Logout Button Background Remove', 'mayosis' ),
	'section'     => 'header_login',
	'default'     => 'notremove',
	'priority'    => 10,
	'choices'     => array(
		'remove'   => esc_attr__( 'On', 'mayosis' ),
		'notremove' => esc_attr__( 'Off', 'mayosis' ),
	),
));

Mayosis_Option::add_field( 'mayo_config',  array(
'type'     => 'text',
'settings' => 'login_text',
'label'    => __( 'Login Button Text', 'mayosis' ),
'section'  => 'header_login',
'default'  => esc_attr__( 'Login', 'mayosis' ),
'priority' => 10,
 ));
 
 Mayosis_Option::add_field( 'mayo_config',  array(
'type'     => 'text',
'settings' => 'logout_text',
'label'    => __( 'Logout Button Text', 'mayosis' ),
'section'  => 'header_login',
'default'  => esc_attr__( 'Logout', 'mayosis' ),
'priority' => 10,
 ));
 
 Mayosis_Option::add_field( 'mayo_config',  array(
'type'     => 'text',
'settings' => 'login_url',
'label'    => __( 'Login Link', 'mayosis' ),
'section'  => 'header_login',
'default'  => esc_attr__( 'http://demo.com/login', 'mayosis' ),
'priority' => 10,
 ));
 
 Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'color',
'settings'     => 'header_buttonbg_color',
'label'       => __( 'Header Button Background Color', 'mayosis' ),
'description' => __( 'Change Header Button Background Color', 'mayosis' ),
'section'     => 'header_login',
'priority'    => 10,
'default'     => 'rgba(0,0,0,.0)', 
'output' => array(
        array(
            'element'  => '.main-header .login-button',
            'property' => 'background',
        ),
    ),
'choices' => array(
   'alpha' => true,
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
));
              
Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'color',
'settings'     => 'header_buttonborder_color',
'label'       => __( 'Header Button Border Color', 'mayosis' ),
'description' => __( 'Change Header Button Border Color', 'mayosis' ),
'section'     => 'header_login',
'priority'    => 10,
'default'     => 'rgba(255,255,255,0.25)', 
'output' => array(
        array(
            'element'  => '.main-header .login-button',
            'property' => 'border-color',
        ),
    ),
'choices' => array(
   'alpha' => true,
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
));
              
Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'color',
'settings'     => 'header_button_text',
'label'       => __( 'Header Button Text Color', 'mayosis' ),
'description' => __( 'Change sticky header text color', 'mayosis' ),
'section'     => 'header_login',
'priority'    => 10,
'default'     => '#ffffff', 
'output' => array(
        array(
            'element'  => '.main-header .login-button',
            'property' => 'color',
        ),
    ),
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
));