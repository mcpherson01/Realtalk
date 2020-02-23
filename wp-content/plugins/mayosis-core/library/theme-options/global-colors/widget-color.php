<?php

Mayosis_Option::add_field( 'mayo_config', array(
            'type'        => 'radio-buttonset',
            'settings'    => 'wd_bg_type',
            'label'       => __( 'Title Background Type', 'mayosis' ),
            'section'     => 'widget_color',
            'default'     => 'color',
            'priority'    => 10,
            'choices'     => array(
                'color'  => esc_attr__( 'Color', 'mayosis' ),
                'gradient' => esc_attr__( 'Gradient', 'mayosis' ),
            ),
));

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'multicolor',
        'settings'    => 'wd_title_gradient',
        'label'       => esc_attr__( 'Widget gradient', 'mayosis' ),
        'section'     => 'widget_color',
        'priority'    => 10,
        'required'    => array(
            array(
                'setting'  => 'wd_bg_type',
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
        'type'        => 'color',
        'settings'     => 'wd_title_bg',
        'label'       => __( 'Title Background Color', 'mayosis' ),
        'description' => __( 'Set Title Background color', 'mayosis' ),
        'section'     => 'widget_color',
        'priority'    => 10,
        'default'     => '#1e0046',
        'required'    => array(
            array(
                'setting'  => 'wd_bg_type',
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
       'type'        => 'color',
        'settings'     => 'wd_title_text',
        'label'       => __( 'Title Color', 'mayosis' ),
        'description' => __( 'Set Title color', 'mayosis' ),
        'section'     => 'widget_color',
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
        'settings'     => 'wd_field_text',
        'label'       => __( 'Field Text Color', 'mayosis' ),
        'description' => __( 'Set Field Text color', 'mayosis' ),
        'section'     => 'widget_color',
        'priority'    => 10,
        'default'     => '#28375a',
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
       'type'        => 'radio-buttonset',
        'settings'    => 'wd_field_type',
        'label'       => __( 'Form Field Type', 'mayosis' ),
        'section'     => 'widget_color',
        'default'     => 'solid',
        'priority'    => 10,
        'choices'     => array(
            'solid'  => esc_attr__( 'Solid', 'mayosis' ),
            'border' => esc_attr__( 'Border', 'mayosis' ),
        ),
));

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'color',
        'settings'     => 'wd_field_color',
        'label'       => __( 'Form Field Color', 'mayosis' ),
        'description' => __( 'Change Form Field Color', 'mayosis' ),
        'section'     => 'widget_color',
        'priority'    => 10,
        'default'     => '#edeff2',
        'required'    => array(
            array(
                'setting'  => 'wd_field_type',
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
        'settings'     => 'wd_border_color',
        'label'       => __( 'Form Border Color', 'mayosis' ),
        'description' => __( 'Change Form border Color', 'mayosis' ),
        'section'     => 'widget_color',
        'priority'    => 10,
        'default'     => '#282837',
        'required'    => array(
            array(
                'setting'  => 'wd_field_type',
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
        'settings'    => 'wd_border_thikness',
        'label'       => esc_attr__( 'Border Thickness', 'mayosis' ),
        'description' => esc_attr__( 'Add Main Site Form Border Thickness', 'mayosis' ),
        'section'     => 'widget_color',
        'default'     => '2px',
        'required'    => array(
            array(
                'setting'  => 'wd_field_type',
                'operator' => '==',
                'value'    => 'border',
            ),
        ),
));
