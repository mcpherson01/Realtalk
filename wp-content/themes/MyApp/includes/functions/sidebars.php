<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar Homepage',
		'id' => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><!-- end .widget-content --></div> <!-- end .widget -->',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><div class="widget-content">',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar',
		'id' => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><!-- end .widget-content --></div> <!-- end .widget -->',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><div class="widget-content">',
    ));
?>