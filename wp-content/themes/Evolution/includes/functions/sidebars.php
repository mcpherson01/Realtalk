<?php
if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
		'name' => 'Sidebar',
		'id' => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div> <!-- end .widget -->',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
    ));

	register_sidebar(array(
		'id' => 'footer-area-1',
		'name' => 'Footer Column 1',
		'before_widget' => '<div id="%1$s" class="f_widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
    ));

	register_sidebar(array(
		'id' => 'footer-area-2',
		'name' => 'Footer Column 2',
		'before_widget' => '<div id="%1$s" class="f_widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
    ));

	register_sidebar(array(
		'id' => 'footer-area-3',
		'name' => 'Footer Column 3',
		'before_widget' => '<div id="%1$s" class="f_widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
    ));

	register_sidebar(array(
		'id' => 'footer-area-4',
		'name' => 'Footer Column 4',
		'before_widget' => '<div id="%1$s" class="f_widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
    ));
}
?>