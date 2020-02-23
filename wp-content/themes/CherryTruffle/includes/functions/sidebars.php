<?php
if ( function_exists('register_sidebar') )
  register_sidebar(array(
 'id' => 'sidebar-1',
 'before_widget' => '<div class="sidebar-box">',
 'after_widget' => '</div>',
 'before_title' => '<span class="sidebar-box-title">',
 'after_title' => '</span>',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
	'name' => 'Footer',
	'id' => 'sidebar-2',
    'before_widget' => '<div class="footer-box">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
    ));
?>