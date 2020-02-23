<?php

Mayosis_Option::add_section( 'header_sticky', array(
	'title' => __( 'Sticky Header', 'mayosis' ),
	'panel' => 'header',
) );


Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'radio-buttonset',
'settings'    => 'sticky_hide',
'label'       => __( 'Sticky Header', 'mayosis' ),
'section'     => 'header_sticky',
'default'     => 'stickydisabled',
'choices'     => array(
	'stickyenabled'   => esc_attr__( 'Show', 'mayosis' ),
	'stickydisabled' => esc_attr__( 'Hide', 'mayosis' ),
),
));
                    
Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'radio-buttonset',
'settings'    => 'smart_sticky',
'label'       => __( 'Smart Sticky ', 'mayosis' ),
'section'     => 'header_sticky',
'default'     => 'smartdisable',
'choices'     => array(
	'smartenble'   => esc_attr__( 'Enable', 'mayosis' ),
	'smartdisable' => esc_attr__( 'Disable', 'mayosis' ),
),

));


Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'color',
'settings'     => 'sticky_header_bg',
'label'       => __( 'Sticky Header Background Color', 'mayosis' ),
'description' => __( 'Change sticky header background color', 'mayosis' ),
'section'     => 'header_sticky',
'priority'    => 10,
'default'     => '#ffffff', 
'output'      => array(
            array(
                'element'  => 'header .sticky,header .fixedheader',
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
              
Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'color',
'settings'     => 'sticky_header_text',
'label'       => __( 'Sticky Header Text Color', 'mayosis' ),
'description' => __( 'Change sticky header text color', 'mayosis' ),
'section'     => 'header_sticky',
'output'      => array(
            array(
                'element'  => '.fixedheader a.mobile-cart-button,header .fixedheader #mayosis-menu > ul > li > a,header .fixedheader .cart-button,
                header .fixedheader .search-dropdown-main a,.sticky #mayosis-menu > ul > li > a,.sticky .cart-button,
                .sticky .search-dropdown-main a,
                header  .fixedheader .cart-style-two .cart-button,
                .sticky .cart-style-two .cart-button,header .fixedheader .searchoverlay-button,
                .sticky .searchoverlay-button,
                header .fixedheader #menu-toggle,
                header .fixedheader .mobile_user > .navbar-nav > li > a,
                .sticky .mobile_user > .navbar-nav > li > a,
                header.fixedheader .login-button,
                .header-master.fixedheader .mayosis-option-menu.hidden-xs > .menu-item > a,
                .header-master.fixedheader .login-button,.fixedheader .header-ghost-form.header-search-form .mayosel-select .current,.fixedheader .header-ghost-form.header-search-form input[type="text"]::placeholder,.fixedheader .header-ghost-form.header-search-form .mayosel-select:after,.fixedheader .header-ghost-form.header-search-form .search-btn::after',
                'property' => 'color',
            ),
            
            array(
                'element'  => ' header .fixedheader #menu-toggle,header .fixedheader .mobile_user > .navbar-nav > li > a,
                .sticky .mobile_user > .navbar-nav > li > a, .header-master.fixedheader .login-button,.fixedheader .header-ghost-form.header-search-form input[type="text"],.fixedheader .header-ghost-form.header-search-form .mayosel-select',
                'property' => 'border-color',
            ),
            
            array(
                'element'  => 'header .fixedheader .burger span, header .fixedheader .burger span::before, header .fixedheader .burger span::after',
                'property' => 'background-color',
            ),
            
            
        ),
'priority'    => 10,
'default'     => '#28375a', 
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