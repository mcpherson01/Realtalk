<?php
if ( function_exists('register_sidebar') )
  register_sidebar(array(
  'name' => 'Sidebar',
  'id' => 'sidebar-1',
 'before_widget' => '<img src="' . get_bloginfo('template_directory') . '/images/sidebar-box-top.png" style="float: left;" alt="sidebar-top" /><div class="sidebar-box"><div class="sidebar-box-inside">',
 'after_widget' => '</div></div><img src="' . get_bloginfo('template_directory') . '/images/sidebar-box-bottom.png" alt="sidebar-bottom" style="float: left; margin-bottom: 10px;" />',
 'before_title' => '<span class="sidebar-box-title">',
 'after_title' => '</span><div style="clear: both;"></div>',
    ));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
    'name' => 'Pages',
    'id' => 'sidebar-2',
 'before_widget' => '<img src="' . get_bloginfo('template_directory') . '/images/sidebar-box-top.png" style="float: left;" alt="sidebar-top" /><div class="sidebar-box"><div class="sidebar-box-inside">',
 'after_widget' => '</div></div><img src="' . get_bloginfo('template_directory') . '/images/sidebar-box-bottom.png" alt="sidebar-bottom" style="float: left; margin-bottom: 10px;" />',
 'before_title' => '<span class="sidebar-box-title">',
 'after_title' => '</span><div style="clear: both;"></div>',
    ));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
    'name' => 'Footer',
    'id' => 'sidebar-3',
    'before_widget' => '<div class="footer-box">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
    ));
?>