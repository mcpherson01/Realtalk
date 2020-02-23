<?php
Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'button_style_type',
        'label'       => __( 'Solid Button Style Type', 'mayosis' ),
        'section'     => 'button_style',
        'default'     => 'default',
        'priority'    => 10,
        'choices'     => array(
            'default'  => esc_attr__( 'Default', 'mayosis' ),
            'gradient' => esc_attr__( 'Gradient', 'mayosis' ),
        ),
    ));
    
    
    Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'color',
        'settings'     => 'btn_gradient_color_a',
        'label'       => __( 'Gradient Color A', 'mayosis' ),
        'description' => __( 'Choose Gradient Color A', 'mayosis' ),
        'section'     => 'button_style',
        'priority'    => 10,
        'default'     => '#3c28b4',
        'required'    => array(
            array(
                'setting'  => 'button_style_type',
                'operator' => '==',
                'value'    => 'gradient',
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
        'settings'     => 'btn_gradient_color_b',
        'label'       => __( 'Gradient Color B', 'mayosis' ),
        'description' => __( 'Choose Gradient Color B', 'mayosis' ),
        'section'     => 'button_style',
        'priority'    => 10,
        'default'     => '#643cdc',
        'required'    => array(
            array(
                'setting'  => 'button_style_type',
                'operator' => '==',
                'value'    => 'gradient',
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
        'type'        => 'radio-buttonset',
        'settings'    => 'gost_button_style_type',
        'label'       => __( 'Ghost Button Style Type', 'mayosis' ),
        'section'     => 'button_style',
        'default'     => 'default',
        'priority'    => 10,
        'choices'     => array(
            'default'  => esc_attr__( 'Default', 'mayosis' ),
            'gradient' => esc_attr__( 'Gradient', 'mayosis' ),
        ),
    ));
    
    
    Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'color',
        'settings'     => 'ghost_gradient_color_a',
        'label'       => __( 'Gradient Color A', 'mayosis' ),
        'description' => __( 'Choose Gradient Color A', 'mayosis' ),
        'section'     => 'button_style',
        'priority'    => 10,
        'default'     => '#3c28b4',
        'required'    => array(
            array(
                'setting'  => 'gost_button_style_type',
                'operator' => '==',
                'value'    => 'gradient',
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
        'settings'     => 'ghost_gradient_color_b',
        'label'       => __( 'Gradient Color B', 'mayosis' ),
        'description' => __( 'Choose Gradient Color B', 'mayosis' ),
        'section'     => 'button_style',
        'priority'    => 10,
        'default'     => '#643cdc',
        'required'    => array(
            array(
                'setting'  => 'gost_button_style_type',
                'operator' => '==',
                'value'    => 'gradient',
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