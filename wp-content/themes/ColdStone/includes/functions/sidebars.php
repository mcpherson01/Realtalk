<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
    'name' => 'Main Sidebar',
    'id' => 'sidebar-1',
    'before_widget' => '<div class="side_roll">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
    ));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
    'name' => 'Homepage Sidebar',
    'id' => 'sidebar-2',
    'before_widget' => '',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="aboutustab">',
    'after_title' => '</h3> <div class="aboutus">',
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