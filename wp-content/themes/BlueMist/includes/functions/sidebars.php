<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar',
		'id' => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="sidebar-box %2$s">',
		'after_widget' => '</span></div> <!-- end .sidebar-box -->',
		'before_title' => '<h2>',
        'after_title' => '</h2><span class="widget-inside">',
    ));
?>