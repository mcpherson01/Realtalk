<?php

Mayosis_Option::add_section( 'header_main_menu', array(
	'title'       => __( 'Main Menu', 'mayosis' ),
	'panel'       => 'header',
) );


Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'radio-buttonset',
	'settings'    => 'menu_position',
	'label'       => __( 'Menu Position', 'mayosis' ),
	'section'     => 'header_main_menu',
	'default'     => 'text-right',
	'priority'    => 10,
	'choices'     => array(
		'text-left'   => esc_attr__( 'Left', 'mayosis' ),
		'text-center' => esc_attr__( 'Center', 'mayosis' ),
		'text-right' => esc_attr__( 'Right', 'mayosis' ),
	),
		'required'    => array(
    array(
        'setting'  => 'header_layout_type',
        'operator' => '==',
        'value'    => 'one',
            ),
        ),
));


 Mayosis_Option::add_field( 'mayo_config',  array(
  'type'        => 'color',
  'settings'     => 'main_nav_text',
  'label'       => __( 'Main Navigation Text Color', 'mayosis' ),
  'description' => __( 'Change navigation text Color', 'mayosis' ),
  'section'     => 'header_main_menu',
  'priority'    => 10,
  'default'     => '#28375a', 
  'output'      => array(
            array(
                'element'  => '#mayosis-menu > ul > li > a,.header-master .main-header ul li.cart-style-one a.cart-button,.search-dropdown-main a,.header-master .menu-item a,.header-master .cart-style-two .cart-button,.my-account-list>li>a ,.header-master .burger,.header-master .cart-button, .cart_top_1>.navbar-nav>li>a.cart-button,.header-master .my-account-menu a',
                'property' => 'color',
            ),
            
            array (
                'element '=> '',
                'property' => 'hover',
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
              
Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'select',
	'settings'    => 'menu_hover_type',
	'label'       => __( 'Menu Hover Type', 'mayosis' ),
	'section'     => 'header_main_menu',
	'default'     => 'opacity',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => array(
		'color' => esc_attr__( 'Color', 'mayosis' ),
		'opacity' => esc_attr__( 'Opacity', 'mayosis' ),
		'underline' => esc_attr__( 'Underline', 'mayosis' ),
		'dotted' => esc_attr__( 'Dotted', 'mayosis' ),
	),
));
                                        
              
Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'color',
'settings'     => 'main_nav_text_hover',
'label'       => __( 'Main Navigation Text Hover Color', 'mayosis' ),
'description' => __( 'Change navigation text hover Color', 'mayosis' ),
'section'     => 'header_main_menu',
'priority'    => 10,
'default'     => '#28375a', 
'required'    => array(
                array(
                    'setting'  => 'menu_hover_type',
                    'operator' => '==',
                    'value'    => 'color',
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
              
Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'color',
'settings'     => 'sub_nav_bg',
'label'       => __( 'Sub Navigation Background Color', 'mayosis' ),
'description' => __( 'Change navigation bg Color', 'mayosis' ),
'section'     => 'header_main_menu',
'priority'    => 10,
'default'     => '#1e1e2d', 
'output'      => array(
            array(
                'element'  => ' #mayosis-menu ul ul,.search-dropdown-main ul,.mayosis-option-menu .mini_cart,#mayosis-sidemenu > ul > li > a:hover,
        #mayosis-sidemenu > ul > li.active > a, #mayosis-sidemenu > ul > li.open > a,
        .my-account-menu .my-account-list',
                'property' => 'background',
            ),
            
             array(
            'element'  => '.search-dropdown-main ul:after,.header-master .mayosis-option-menu .mini_cart:after,.header-master .my-account-menu .my-account-list:after,#mayosis-menu ul ul:before',
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
              
Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'color',
'settings'     => 'sub_nav_text',
'label'       => __( 'Sub Navigation Text Color', 'mayosis' ),
'description' => __( 'Change navigation text Color', 'mayosis' ),
'section'     => 'header_main_menu',
'priority'    => 10,
'default'     => '#ffffff', 
'output'      => array(
            array(
                'element'  => '#mayosis-menu ul ul,.header-master .dropdown-menu li a,#mayosis-menu ul ul a,.header-master.fixedheader .dropdown-menu li a',
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
              