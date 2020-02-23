<?php

Mayosis_Option::add_section( 'bottom_bar', array(
	'title'       => __( 'Header Bottom', 'mayosis' ),
	'panel'       => 'header',
) );

Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'radio-buttonset',
    'settings'    => 'bottom_header_show',
    'label'       => __( 'bottom Header', 'mayosis' ),
    'section'     => 'bottom_bar',
    'default'     => 'off',
    'choices'     => array(
        'on'   => esc_attr__( 'Show', 'mayosis' ),
        'off' => esc_attr__( 'Hide', 'mayosis' ),
    ),
) );


Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-image',
    'settings'    => 'bottom_header_layout',
    'label'       => __( 'Bottom Header layout', 'mayosis' ),
    'section'     => 'bottom_bar',
    'default'     => 'one',
    'choices'     => array(
            		'one'   => get_template_directory_uri() . '/images/header-layout-2.jpg',
            		'two'  => get_template_directory_uri() . '/images/header-layout-1.jpg',
            	),
) );

Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'switch',
	'settings'    => 'bottom_bar_fullwidth',
	'label'       => __( 'Full width bottom header', 'mayosis' ),
	'section'     => 'bottom_bar',
	'default'     => 'off',
	'choices'     => array(
		'on'  => esc_attr__( 'Enable', 'mayosis' ),
		'off' => esc_attr__( 'Disable', 'mayosis' ),
	),
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'dimension',
	'settings'    => 'bottom_header_height',
	'label'       => esc_attr__( 'Header Height', 'mayosis' ),
	'description' => esc_attr__( 'Change bottom header height', 'mayosis' ),
	'section'     => 'bottom_bar',
	'default'     => '40px',
	'output'      => array(
            array(
                'element'  => '.header-bottom',
                'property' => 'height',
            ),
        ),
    ) );
    
    Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'dimension',
	'settings'    => 'bottom_header_line_height',
	'label'       => esc_attr__( 'Header Line Height', 'mayosis' ),
	'description' => esc_attr__( 'Change bottom header line height', 'mayosis' ),
	'section'     => 'bottom_bar',
	'default'     => '40px',
	'output'      => array(
            array(
                'element'  => '.header-bottom,.header-bottom #mayosis-menu>ul>li>a',
                'property' => 'line-height',
            ),
        ),
    ) );
    
    
Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'color',
'settings'     => 'bottom_header_bg',
'label'       => __( 'Bottom Header Background Color', 'mayosis' ),
'description' => __( 'Change bottom header bg Color', 'mayosis' ),
'section'     => 'bottom_bar',
'priority'    => 10,
'default'     => '#ffffff', 
'output'      => array(
            array(
                'element'  => '.header-bottom',
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
'settings'     => 'bottom_header_text',
'label'       => __( 'Bottom Header Text Color', 'mayosis' ),
'description' => __( 'Change bottom header text Color', 'mayosis' ),
'section'     => 'bottom_bar',
'priority'    => 10,
'default'     => '#28375a', 
'output'      => array(
            array(
                'element'  => '.header-bottom',
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
'settings'     => 'bottom_header_menu',
'label'       => __( 'Bottom Header Menu Text Color', 'mayosis' ),
'description' => __( 'Change bottom header menu text Color', 'mayosis' ),
'section'     => 'bottom_bar',
'priority'    => 10,
'default'     => '#28375a', 
'output'      => array(
            array(
                'element'  => '.header-bottom #mayosis-menu>ul>li>a,.header-bottom ul li.cart-style-one a.cart-button,.header-bottom .my-account-menu a',
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
'settings'     => 'bottom_header_sub_menu',
'label'       => __( 'Bottom Header Sub Menu Text Color', 'mayosis' ),
'description' => __( 'Change bottom header sub menu text Color', 'mayosis' ),
'section'     => 'bottom_bar',
'priority'    => 10,
'default'     => '#ffffff', 
'output'      => array(
            array(
                'element'  => '.header-bottom #mayosis-menu ul ul a,.header-bottom #mayosis-menu ul ul, .header-bottom .search-dropdown-main ul,.header-bottom .mayosis-option-menu .mini_cart,.header-bottom #mayosis-sidemenu > ul > li > a:hover,
        .header-bottom #mayosis-sidemenu > ul > li.active > a, .header-bottom #mayosis-sidemenu > ul > li.open > a,.header-bottom  .my-account-menu .my-account-list,.header-bottom .my-account-list a',
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
'settings'     => 'bottom_sub_menu_bg',
'label'       => __( 'Bottom Header Sub Menu Background Color', 'mayosis' ),
'description' => __( 'Change bottom header sub menu background Color', 'mayosis' ),
'section'     => 'bottom_bar',
'priority'    => 10,
'default'     => '#1e1e2d', 
'output'      => array(
            array(
                'element'  => '.header-bottom #mayosis-menu ul ul, .header-bottom .search-dropdown-main ul,.header-bottom .mayosis-option-menu .mini_cart,.header-bottom #mayosis-sidemenu > ul > li > a:hover,
        .header-bottom #mayosis-sidemenu > ul > li.active > a, .header-bottom #mayosis-sidemenu > ul > li.open > a,.header-bottom  .my-account-menu .my-account-list',
                'property' => 'background',
            ),
            
            array(
                'element'  => '.header-bottom #mayosis-menu ul ul:before,.header-bottom .mayosis-option-menu .mini_cart:after,.header-bottom .my-account-menu .my-account-list:after',
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