<?php

Mayosis_Option::add_section( 'header_breadcrumbs', array(
	'title'       => __( 'Breadcrumbs', 'mayosis' ),
	'panel'       => 'header',
) );


Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'dimensions',
'settings'    => 'page_padding',
'label'       => esc_attr__( 'Page Breadcrumb Padding', 'mayosis' ),
'description' => esc_attr__( 'Change Breadcrumb Padding', 'mayosis' ),
'section'     => 'header_breadcrumbs',
'default'     => array(
	'padding-top'    => '80px',
	'padding-bottom' => '80px',
	'padding-left'   => '0px',
	'padding-right'  => '0px',
),
));

Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'dimensions',
	'settings'    => 'blog_padding',
	'label'       => esc_attr__( 'Blog Breadcrumb Padding', 'mayosis' ),
	'description' => esc_attr__( 'Change Breadcrumb Padding', 'mayosis' ),
	'section'     => 'header_breadcrumbs',
	'default'     => array(
		'padding-top'    => '80px',
		'padding-bottom' => '80px',
		'padding-left'   => '0px',
		'padding-right'  => '0px',
	),
));