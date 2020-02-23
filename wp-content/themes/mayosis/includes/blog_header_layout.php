<?php
defined('ABSPATH') or die();

$layouts  = get_theme_mod( 'blog_content_layout_manager', array( 'breadcrumb','title','category','date' ) );
if ($layouts): foreach ($layouts as $layout) {
 
    switch($layout) {
 
        case 'breadcrumb': if (function_exists('dm_breadcrumbs')) dm_breadcrumbs();
        break;
 
        case 'title': the_title( '<h1 class="single-post-title">', '</h1>' );;
        break;
 
        case 'author': get_template_part( 'includes/blog_content_author' );
        break;
        
        case 'category': get_template_part( 'includes/blog_content_category' );
        break;
        
        case 'date': get_template_part( 'includes/blog_content_date' );
        break;
        
 
       
 
    }
 
}
 
endif;