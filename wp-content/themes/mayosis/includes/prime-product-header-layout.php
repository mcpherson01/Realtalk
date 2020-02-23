<?php
defined('ABSPATH') or die();

$layouts  = get_theme_mod( 'prime_content_layout_manager', array( 'title' ) );
if ($layouts): foreach ($layouts as $layout) {

    switch($layout) {

        case 'breadcrumb': if (function_exists('dm_breadcrumbs')) dm_breadcrumbs();
            break;

        case 'title': the_title( '<h1 class="single-post-title">', '</h1>' );;
            break;

        case 'author': get_template_part( 'includes/product_content_author' );
            break;

        case 'category': get_template_part( 'includes/product_content_category' );
            break;

        case 'date': get_template_part( 'includes/product_content_date' );
            break;

        case 'button': get_template_part( 'includes/product_content_button' );
            break;



    }

}

endif;

