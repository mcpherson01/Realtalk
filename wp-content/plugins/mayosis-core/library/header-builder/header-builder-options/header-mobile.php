<?php

Mayosis_Option::add_section( 'header_mobile', array(
	'title'       => __( 'Header Mobile', 'mayosis' ),
	'panel'       => 'header',
) );


Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'color',
'settings'     => 'mobile_header_icons_color',
'label'       => __( 'Mobile Header Icons Color', 'mayosis' ),
'description' => __( 'Change mobile Header Icons color', 'mayosis' ),
'section'     => 'header_mobile',
'priority'    => 10,
'default'     => '#28375a', 
'output'      => array(
            array(
                'element'  => '.burger span, .burger span::before, .burger span::after,.burger.clicked span:before, .burger.clicked span:after',
                'property' => 'background-color',
            ),
            
            array(
                'element'  => ' a.mobile-cart-button',
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
              
Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'color',
'settings'     => 'mobile_menu_text',
'label'       => __( 'Mobile Menu Text Color', 'mayosis' ),
'description' => __( 'Change mobile menu text color', 'mayosis' ),
'section'     => 'header_mobile',
'priority'    => 10,
'default'     => '#ffffff', 
'output'      => array(
            array(
                'element'  => '#menu-toggle,.mobile--nav-menu > .navbar-nav > li > a, #sidebar-wrapper .navbar-nav > li > a, #sidebar-wrapper #mega-menu-wrap-main-menu #mega-menu-main-menu > li.mega-menu-item > a.mega-menu-link,.mobile--nav-menu a,#sidebar-wrapper .dropdown-menu > li > a,.mobile--nav-menu a, .mobile--nav-menu>#mayosis-sidemenu>ul>li>a,.mobile--nav-menu ,.mobile--nav-menu .menu-item a,.mobile-menu-main-part #mayosis-sidemenu a,.top-part-mobile a,.bottom-part-mobile a',
                'property' => 'color',
            ),
            
            array(
                'element'  => '#menu-toggle,.mobile_user > .navbar-nav > li > a,.mobile--nav-menu .holder::after',
                'property' => 'border-color',
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
              