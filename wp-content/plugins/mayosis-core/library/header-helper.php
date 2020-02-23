<?php

$transport = 'postMessage';
if ( ! isset( $wp_customize->selective_refresh ) ) {
  $transport = 'refresh';
}

$image_url = get_template_directory_uri().'/inc/admin/customizer/img/';

$builder_items = array(
  'logo' => __( 'Logo', 'mayosis' ),
  'hamburger' => __( 'Hamburger', 'mayosis' ),
  'accordion' => __( 'Mobile Menu(Accordion)', 'mayosis' ),
  'mobile' => __( 'Mobile Burger', 'mayosis' ),
  'nav' => __( 'Main Menu', 'mayosis' ),
  'nav-top' => __( 'Top Bar Menu', 'mayosis' ),
  'nav-bottom' => __( 'Bottom Bar Menu', 'mayosis' ),
  'search' => __( 'Search Icon', 'mayosis' ),
  'search-form' => __( 'Search Form', 'mayosis' ),
  'social' => __( 'Social Icons', 'mayosis' ),
  'button' => __( 'Button', 'mayosis' ),
  'cart' => __( 'Cart', 'mayosis' ),
  'account' => __( 'My Account', 'mayosis' ),
  'login' => __( 'Login Button', 'mayosis' ),
  'code' => __( 'Text/HTML', 'mayosis' ),
  'code-2' => __( 'Text/HTML 2', 'mayosis' ),
);

// Add Hooked Header Elements
$builder_items = apply_filters( 'mayosis_header_element', $builder_items);

function mayosis_old_version_content(){

   // Upgrade to mayosis 2.5
   if(get_theme_mod('mayosis_version') < 2.5){

      $options = get_theme_mods();

     if(!isset($options['header_elements_left'])) set_theme_mod('header_elements_left', mayosis_header_elements_left());
     if(!isset($options['header_elements_center'])) set_theme_mod('header_elements_center', mayosis_header_elements_center());
     if(!isset($options['header_elements_right'])) set_theme_mod('header_elements_right', mayosis_header_elements_right());
     
      if(!isset($options['header_mobile_elements_left'])) set_theme_mod('header_mobile_elements_left', mayosis_header_mobile_elements_left());
       if(!isset($options['header_mobile_elements_right'])) set_theme_mod('header_mobile_elements_right', mayosis_header_mobile_elements_right());
       if(!isset($options['header_mobile_elements_sidebar_main'])) set_theme_mod('header_mobile_elements_sidebar_main', mayosis_header_mobile_elements_sidebar_main());

     
     set_theme_mod('mayosis_version', 2.5);
   }
}
add_action( 'after_setup_theme', 'mayosis_old_version_content');

function mayosis_header_elements_left(){
    $main_logo = get_theme_mod('main_logo');
  	$options= array(
			);
    $options[] = 'logo';
  return $options;
}

function mayosis_header_elements_center(){
    $options = array();
 $options[] = 'nav';
  return $options;
}
function mayosis_header_elements_right(){
  $options = array();
 $options[] = 'cart';
 $options[] = 'account';
  return $options;
}

function mayosis_header_mobile_elements_left(){
    $options = array();
    $options[] = 'logo';
  return $options;
}

function mayosis_header_mobile_elements_right(){
    $options = array();
    $options[] = 'cart';
    $options[] = 'mobile';
  return $options;
}

function mayosis_header_mobile_elements_sidebar_main(){
    $options = array();
    $options[] = 'accordion';
  return $options;
}
