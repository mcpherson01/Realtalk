<?php

Mayosis_Option::add_section( 'top_bar', array(
	'title'       => __( 'Top Bar', 'mayosis' ),
	'panel'       => 'header',
) );

Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'radio-buttonset',
    'settings'    => 'top_header_show',
    'label'       => __( 'Top Header', 'mayosis' ),
    'section'     => 'top_bar',
    'default'     => 'off',
    'priority'    => 10,
    'choices'     => array(
        'on'   => esc_attr__( 'Show', 'mayosis' ),
        'off' => esc_attr__( 'Hide', 'mayosis' ),
    ),
) );


Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-image',
    'settings'    => 'main_top_header_layout',
    'label'       => __( 'Top Header layout', 'mayosis' ),
    'section'     => 'top_bar',
    'default'     => 'one',
    'choices'     => array(
            		'one'   => get_template_directory_uri() . '/images/header-layout-2.jpg',
            		'two'  => get_template_directory_uri() . '/images/header-layout-1.jpg',
            	),
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
	'settings'    => 'top_middle_header_align',
	'label'       => esc_html__( 'Middle Part Content Align', 'mayosis' ),
	'section'     => 'top_bar',
	'default'     => 'flexleft',
	'choices'     => [
		'flexleft'   => esc_html__( 'Left', 'mayosis' ),
		'flexcenter' => esc_html__( 'Center', 'mayosis' ),
		'flexright'  => esc_html__( 'Right', 'mayosis' ),
	],
	
	
	'required'    => array(
            array(
                'setting'  => 'main_top_header_layout',
                'operator' => '==',
                'value'    => 'one',
            ),

        ),
    ) );
    
Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
	'settings'    => 'top_left_header_align',
	'label'       => esc_html__( 'Left Side Content Align', 'mayosis' ),
	'section'     => 'top_bar',
	'default'     => 'flexleft',
	'choices'     => [
		'flexleft'   => esc_html__( 'Left', 'mayosis' ),
		'flexcenter' => esc_html__( 'Center', 'mayosis' ),
		'flexright'  => esc_html__( 'Right', 'mayosis' ),
	],
	
	
	'required'    => array(
            array(
                'setting'  => 'main_top_header_layout',
                'operator' => '==',
                'value'    => 'two',
            ),

        ),
    ) );
    
    
    Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
	'settings'    => 'top_right_header_align',
	'label'       => esc_html__( 'Right Side Content Align', 'mayosis' ),
	'section'     => 'top_bar',
	'default'     => 'flexright',
	'choices'     => [
		'flexleft'   => esc_html__( 'Left', 'mayosis' ),
		'flexcenter' => esc_html__( 'Center', 'mayosis' ),
		'flexright'  => esc_html__( 'Right', 'mayosis' ),
	],
	
	
	'required'    => array(
            array(
                'setting'  => 'main_top_header_layout',
                'operator' => '==',
                'value'    => 'two',
            ),

        ),
    ) );
    
     Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
	'settings'    => 'top_mobile_header_align',
	'label'       => esc_html__( 'Mobile Content Align', 'mayosis' ),
	'section'     => 'top_bar',
	'default'     => 'flexright',
	'choices'     => [
		'flexleft'   => esc_html__( 'Left', 'mayosis' ),
		'flexcenter' => esc_html__( 'Center', 'mayosis' ),
		'flexright'  => esc_html__( 'Right', 'mayosis' ),
	],
	
	
	'required'    => array(
            array(
                'setting'  => 'main_top_header_layout',
                'operator' => '==',
                'value'    => 'two',
            ),

        ),
    ) );
Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'switch',
	'settings'    => 'top_bar_fullwidth',
	'label'       => __( 'Full width top header', 'mayosis' ),
	'section'     => 'top_bar',
	'default'     => 'off',
	'choices'     => array(
		'on'  => esc_attr__( 'Enable', 'mayosis' ),
		'off' => esc_attr__( 'Disable', 'mayosis' ),
	),
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'dimension',
	'settings'    => 'top_header_height',
	'label'       => esc_attr__( 'Header Height', 'mayosis' ),
	'description' => esc_attr__( 'Change top header height', 'mayosis' ),
	'section'     => 'top_bar',
	'default'     => '40px',
	'output'      => array(
            array(
                'element'  => '.header-top .to-flex-row',
                'property' => 'height',
            ),
            
            array(
                'element'  => '.header-top #mayosis-menu > ul > li > a,.header-top #top-main-menu > ul > li > a,.header-top ul li.cart-style-one a.cart-button,
        .header-top .mayosis-option-menu li',
                'property' => 'line-height',
            ),
        ),
    ) );
    
Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'color',
'settings'     => 'top_header_bg',
'label'       => __( 'Top Header Background Color', 'mayosis' ),
'description' => __( 'Change top header bg Color', 'mayosis' ),
'section'     => 'top_bar',
'priority'    => 10,
'default'     => '#ffffff', 
'output'      => array(
            array(
                'element'  => '.header-top',
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
'settings'     => 'top_header_text',
'label'       => __( 'Top Header Text Color', 'mayosis' ),
'description' => __( 'Change top header text Color', 'mayosis' ),
'section'     => 'top_bar',
'priority'    => 10,
'default'     => '#28375a', 
'output'      => array(
            array(
                'element'  => '.header-top .to-flex-row,.header-top .burger',
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
              
Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'color',
'settings'     => 'top_header_menu',
'label'       => __( 'Top Header Menu Text Color', 'mayosis' ),
'description' => __( 'Change top header menu text Color', 'mayosis' ),
'section'     => 'top_bar',
'priority'    => 10,
'default'     => '#28375a', 
'output'      => array(
            array(
                'element'  => '#top-main-menu > ul > li > a ,.top-header #cart-menu li a,.header-top #mayosis-menu > ul > li > a,.header-top #top-main-menu > ul > li > a,.header-top ul li.cart-style-one a.cart-button,
        .header-top .mayosis-option-menu li, #top-main-menu > ul > li > a > i , .top-header #cart-menu li a i,#top-main-menu  ul li a i,.top-cart-menu li a i, .top-cart-menu li i,.header-top .to-flex-row i,.header-top .menu-item a',
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
              
Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'color',
'settings'     => 'top_header_sub_menu',
'label'       => __( 'Top Header Sub Menu Text Color', 'mayosis' ),
'description' => __( 'Change top header sub menu text Color', 'mayosis' ),
'section'     => 'top_bar',
'priority'    => 10,
'default'     => '#ffffff',
'output' => array(
        array(
            'element'  => '#top-main-menu ul ul a,.header-top .dropdown-menu li a,.header-top .mini_cart .widget .cart_item.empty .edd_empty_cart',
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
              
Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'color',
'settings'     => 'top_sub_menu_bg',
'label'       => __( 'Top Header Sub Menu Background Color', 'mayosis' ),
'description' => __( 'Change top header sub menu background Color', 'mayosis' ),
'section'     => 'top_bar',
'priority'    => 10,
'default'     => '#1e1e2d', 
'output' => array(
        array(
            'element'  => '.header-top .mayosis-option-menu .mini_cart, #top-main-menu ul ul a,.header-top .mayosis-option-menu .my-account-list',
            'property' => 'background',
        ),
        
        array(
            'element'  => '#top-main-menu  ul  ul:before,.header-top .cart_widget .mini_cart:before,#top-main-menu ul ul:after, .header-top .cart_widget .mini_cart:after,.header-top .mayosis-option-menu .my-account-list:before,.header-top .mayosis-option-menu .my-account-list:after',
            'property' => 'border-bottom-color',
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

Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'dimension',
'settings'    => 'top_icon_size',
'label'       => esc_attr__( 'Top Header Menu Icons Font Size', 'mayosis' ),
'description' => esc_attr__( 'Change Top Header Menu Icons Font Size', 'mayosis' ),
'section'     => 'top_bar',
'default'     => '12px',
'output'      => array(
            array(
                'element'  => '#top-main-menu > ul > li > a > i , .top-header #cart-menu li a i,#top-main-menu  ul li a i,.top-cart-menu li a i, .top-cart-menu li i,.header-top .to-flex-row i',
                'property' => 'font-size',
            ),
        ),
));
              