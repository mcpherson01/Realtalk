<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
    'name' => 'Sidebar',
    'id' => 'sidebar-1',
    'before_widget' => '',
    'after_widget' => '</div> <!-- end sidebar block -->',
    'before_title' => '<h3>',
    'after_title' => '</h3><div class="sidebar-block">',
    ));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
    'name' => 'Footer',
    'id' => 'sidebar-2',
    'before_widget' => '<div class="widget">',
    'after_widget' => '</div> <!-- end widget -->',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
    ));
?>