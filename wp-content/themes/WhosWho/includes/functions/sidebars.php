<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
    	'id' => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="sidebar-box %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<span class="headings-sidebar">',
        'after_title' => '</span>',
    ));
?>