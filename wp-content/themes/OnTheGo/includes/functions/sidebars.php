<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar',
		'id' => 'sidebar-1',
		'before_widget' => '<div class="widget_wrap">
							<div class="widget_entries">',
		'after_widget' => '</div> <!-- .widget-content -->
							<div class="entries-bottom usual"></div>
							</div> <!-- .entries -->
							</div> <!-- .widget_wrap -->',
		'before_title' => '<h3>',
		'after_title' => '</h3><div class="widget-content">',
    ));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
	'name' => 'Footer',
	'id' => 'sidebar-2',
    'before_widget' => '<div class="widget">
						<div class="widgettop">',
    'after_widget' => '</div> <!-- end .widget-content -->
						</div> <!-- end .widgettop -->
						<div class="widgetbottom"></div> <!-- end .widgetbottom -->
					</div> <!-- end .widget -->',
    'before_title' => '<h4><span>',
    'after_title' => '</span></h4><div class="widget-content">',
    ));
?>