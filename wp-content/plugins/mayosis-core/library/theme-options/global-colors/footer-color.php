<?php
Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'radio-buttonset',
        'settings'    => 'footer_bg_type',
        'label'       => __( 'Footer Background Type', 'mayosis' ),
        'section'     => 'footer_color',
        'default'     => 'color',
        'priority'    => 10,
        'choices'     => array(
            'color'  => esc_attr__( 'Color', 'mayosis' ),
            'gradient' => esc_attr__( 'Gradient', 'mayosis' ),
            'image' => esc_attr__( 'Image', 'mayosis' ),
        ),
    ));
    
Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'color',
        'settings'     => 'footer_background',
        'label'       => __( 'Footer Background Color', 'mayosis' ),
        'description' => __( 'Set footer background color', 'mayosis' ),
        'section'     => 'footer_color',
        'priority'    => 10,
        'default'     => '#1e0050',
        'required'    => array(
            array(
                'setting'  => 'footer_bg_type',
                'operator' => '==',
                'value'    => 'color',
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
    

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'multicolor',
        'settings'    => 'footer_gradient',
        'label'       => esc_attr__( 'Footer gradient', 'mayosis' ),
        'section'     => 'footer_color',
        'priority'    => 10,
        'required'    => array(
            array(
                'setting'  => 'footer_bg_type',
                'operator' => '==',
                'value'    => 'gradient',
            ),
        ),
        'choices'     => array(
            'color1'    => esc_attr__( 'Form', 'mayosis' ),
            'color2'   => esc_attr__( 'To', 'mayosis' ),
        ),
        'default'     => array(
            'color1'    => '#1e73be',
            'color2'   => '#00897e',
        ),
));



Mayosis_Option::add_field( 'mayo_config', array(
       'type' => 'image',
        'settings'    => 'footer_bg_image',
        'label'       => esc_attr__( 'Footer Background Image', 'mayosis' ),
        'description' => esc_attr__( 'Upload footer background image', 'mayosis' ),
        'section'     => 'footer_color',
        'required'    => array(
            array(
                'setting'  => 'footer_bg_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
        'default'     => '',
));


Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'image',
        'settings'    => 'footer_overlay_image',
        'label'       => esc_attr__( 'Footer Overlay Image', 'mayosis' ),
        'description' => esc_attr__( 'Upload footer background image', 'mayosis' ),
        'section'     => 'footer_color',
        'default'     => '',
));


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'footer_heading_color',
        'label'       => __( 'Footer Heading Color', 'mayosis' ),
        'description' => __( 'Set footer Heading color', 'mayosis' ),
        'section'     => 'footer_color',
        'priority'    => 10,
        'default'     => '#ffffff',
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


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'footer_text',
        'label'       => __( 'Footer text Color', 'mayosis' ),
        'description' => __( 'Set footer text color', 'mayosis' ),
        'section'     => 'footer_color',
        'priority'    => 10,
        'default'     => '#ffffff',
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


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'copyright_backgroud',
        'label'       => __( 'Copyright Background Color', 'mayosis' ),
        'description' => __( 'Set Copyright Background Color', 'mayosis' ),
        'section'     => 'footer_color',
        'priority'    => 10,
        'default'     => '#16003c',
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


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'copyright_text_color',
        'label'       => __( 'Copyright Text Color', 'mayosis' ),
        'description' => __( 'Set copyright text Color', 'mayosis' ),
        'section'     => 'footer_color',
        'priority'    => 10,
        'default'     => '#d8ddef',
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#d8ddef',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
));


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'back_to_top_bg',
        'label'       => __( 'Back to top background color', 'mayosis' ),
        'description' => __( 'Set back to top background color', 'mayosis' ),
        'section'     => 'footer_color',
        'priority'    => 10,
        'default'     => '#ffffff',
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#d8ddef',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
));

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'footer_field_type',
        'label'       => __( 'Form Field Type', 'mayosis' ),
        'section'     => 'footer_color',
        'default'     => 'solid',
        'priority'    => 10,
        'choices'     => array(
            'solid'  => esc_attr__( 'Solid', 'mayosis' ),
            'border' => esc_attr__( 'Border', 'mayosis' ),
        ),
    ));
    
Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'footer_field_color',
        'label'       => __( 'Form Field Color', 'mayosis' ),
        'description' => __( 'Change Form Field Color', 'mayosis' ),
        'section'     => 'footer_color',
        'priority'    => 10,
        'default'     => '#edeff2',
        'required'    => array(
            array(
                'setting'  => 'footer_field_type',
                'operator' => '==',
                'value'    => 'solid',
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


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'footer_border_color',
        'label'       => __( 'Form Border Color', 'mayosis' ),
        'description' => __( 'Change Form border Color', 'mayosis' ),
        'section'     => 'footer_color',
        'priority'    => 10,
        'default'     => '#282837',
        'required'    => array(
            array(
                'setting'  => 'footer_field_type',
                'operator' => '==',
                'value'    => 'border',
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

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'dimension',
        'settings'    => 'footer_border_thikness',
        'label'       => esc_attr__( 'Border Thickness', 'mayosis' ),
        'description' => esc_attr__( 'Add Main Site Form Border Thickness', 'mayosis' ),
        'section'     => 'footer_color',
        'default'     => '2px',
        'required'    => array(
            array(
                'setting'  => 'footer_field_type',
                'operator' => '==',
                'value'    => 'border',
            ),
        ),
));