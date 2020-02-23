<?php

Mayosis_Option::add_section( 'header_collapsed', array(
	'title'       => __( 'Header Sidebar', 'mayosis' ),
	'panel'       => 'header',
) );


 Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'sidebar_top_color_max',
        'label'       => __( 'Top Part Logo Background', 'mayosis' ),
        'description' => __( 'Change Logo Background', 'mayosis' ),
        'section'     => 'header_collapsed',
        'priority'    => 10,
        'default'     => '#26264d',
        'output' => array(
             array(
                	        'element' => '#mayosis-sidebar .mayosis-sidebar-header',
                	        'property' =>'background-color',
                	        ),
            ),
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#ff6b6b',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
    ));

Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'image',
'settings'    => 'sidebar_logo_icon',
'label'       => esc_attr__( 'Sidebar Logo Icon Upload', 'mayosis' ),
'description' => esc_attr__( 'Recommanded Size 40x40px', 'mayosis' ),
'section'     => 'header_collapsed',
'default'     => '',
));

                        
Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'radio-buttonset',
'settings'    => 'default_side_menu',
'label'       => __( 'Default Side Menu', 'mayosis' ),
'section'     => 'header_collapsed',
'default'     => 'expanded',
'priority'    => 10,
'choices'     => array(
	'collapse'   => esc_attr__( 'Collapsed', 'mayosis' ),
	'expanded' => esc_attr__( 'Expanded', 'mayosis' ),
),
));

Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'radio-buttonset',
'settings'    => 'secondary_header',
'label'       => __( 'Secondary Header', 'mayosis' ),
'section'     => 'header_collapsed',
'default'     => 'on',
'priority'    => 10,
'choices'     => array(
	'on'   => esc_attr__( 'Enable', 'mayosis' ),
	'off' => esc_attr__( 'Disable', 'mayosis' ),
),
));
                    
Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'radio-buttonset',
'settings'    => 'collapse_button',
'label'       => __( 'Collapse Button', 'mayosis' ),
'section'     => 'header_collapsed',
'default'     => 'on',
'priority'    => 10,
'choices'     => array(
	'on'   => esc_attr__( 'Show', 'mayosis' ),
	'off' => esc_attr__( 'Hide', 'mayosis' ),
),
));
                    
Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'radio-buttonset',
'settings'    => 'icon_in_expanded',
'label'       => __( 'Icon in Expanded Mode', 'mayosis' ),
'section'     => 'header_collapsed',
'default'     => 'on',
'priority'    => 10,
'choices'     => array(
	'on'   => esc_attr__( 'Show', 'mayosis' ),
	'off' => esc_attr__( 'Hide', 'mayosis' ),
),
));
                    
Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'radio-buttonset',
'settings'    => 'text_in_collapsed',
'label'       => __( 'Text in Collapsed Mode', 'mayosis' ),
'section'     => 'header_collapsed',
'default'     => 'on',
'priority'    => 10,
'choices'     => array(
	'on'   => esc_attr__( 'Show', 'mayosis' ),
	'off' => esc_attr__( 'Hide', 'mayosis' ),
),
));
                    
Mayosis_Option::add_field( 'mayo_config',  array(
'type'        => 'slider',
'settings'    => 'collapse_bar_width',
'label'       => esc_attr__( 'Collapsed bar Width', 'mayosis' ),
'section'     => 'header_collapsed',
'default'     => 80,
'choices'     => array(
	'min'  => 40,
	'max'  => 100,
	'step' =>5,
),

));
                       