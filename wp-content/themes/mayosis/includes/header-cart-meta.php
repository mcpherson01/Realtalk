<?php
defined('ABSPATH') or die();

$layouts  = get_theme_mod( 'header_layout_manager', array( 'cart', 'search', 'login' ) );
if ($layouts): foreach ($layouts as $layout) {
 
    switch($layout) {
 
        case 'cart': get_template_part( 'includes/cart-header-main' );
        break;
 
        case 'login': get_template_part( 'includes/login-meta' );
        break;
 
        case 'search': get_template_part( 'includes/search-header-main' );
        break;
        
        case 'account': get_template_part( 'includes/my-account-menu' );
        break;
 
       
 
    }
 
}
 
endif;

