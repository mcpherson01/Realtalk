<?php
if ( function_exists('register_sidebar') )
register_sidebar(array(
	'name' => 'Sidebar',
	'id' => 'sidebar-1',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div> <!-- end .widget -->',
	'before_title' => '<h3 class="widgettitle"><span>',
	'after_title' => '</span></h3>',
));
?>