<?php

Mayosis_Option::add_section( 'header_cart', array(
	'title'       => __( 'Cart', 'mayosis' ),
	'panel'       => 'header',
	//'description' => __( 'This is the section description', 'mayosis' ),
) );

   
Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'radio-image',
'settings'    => 'cart_icon_type',
'label'       => esc_html__( 'Cart Icon', 'mayosis' ),
'section'     => 'header_cart',
'Description' =>'There are available two type of cart icon. Choose your desired one',
'default'     => 'zi-cart',
'priority'    => 10,
'choices'     => array(
	'zi-cart'   => get_template_directory_uri() . '/images/cart-icon-1.png',
	'zi-cart-ii' => get_template_directory_uri() . '/images/cart-icon-2.png',
	'fa fa-shopping-cart' => get_template_directory_uri() . '/images/cart-icon-3.png',
),
    ));
    
Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'radio-image',
'settings'    => 'cart_style',
'label'       => esc_html__( 'Cart Style', 'mayosis' ),
'section'     => 'header_cart',
'Description' =>'There are available two type of cart design. Choose your desired one',
'default'     => 'one',
'priority'    => 10,
'choices'     => array(
	'one'   => get_template_directory_uri() . '/images/cart-style-1.png',
	'two' => get_template_directory_uri() . '/images/cart-style-2.png',
),
    ));
    