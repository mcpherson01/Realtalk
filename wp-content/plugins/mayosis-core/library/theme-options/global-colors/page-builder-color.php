<?php
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'color',
        'settings'     => 'testimonial_grid_bg',
        'label'       => __( 'Testimonial Grid Background', 'mayosis' ),
        'description' => __( 'Change Testimonial Grid Background', 'mayosis' ),
        'section'     => 'composer_color',
        'priority'    => 10,
        'default'     => '#5a00f0',
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
        'settings'     => 'search_main_color',
        'label'       => __( 'Search Accent Color', 'mayosis' ),
        'description' => __( 'Change Search Main Color', 'mayosis' ),
        'section'     => 'composer_color',
        'priority'    => 10,
        'default'     => '#5a00f0',
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
        'settings'     => 'search_accent_text_color',
        'label'       => __( 'Search Accent Text  Color', 'mayosis' ),
        'description' => __( 'Change Accent Text  Color', 'mayosis' ),
        'section'     => 'composer_color',
        'priority'    => 10,
        'default'     => '#ffffff',
        'output' => array(
            array(
                'element'  => '.product-search-form .download_cat_filter .mayosel-select span.current,.product-search-form .download_cat_filter .mayosel-select:after',
                'property' => 'color',
            ),

            array(
                'element'  => '.product-search-form .download_cat_filter .mayosel-select:after',
                'property' => 'border-color',
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
        'settings'     => 'search_main_bg_color',
        'label'       => __( 'Search Main Background Color', 'mayosis' ),
        'description' => __( 'Change Search Main Bg Color', 'mayosis' ),
        'section'     => 'composer_color',
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
        'settings'     => 'search_main_border_color',
        'label'       => __( 'Search Main Border Color', 'mayosis' ),
        'description' => __( 'Change Search Main Border Color', 'mayosis' ),
        'section'     => 'composer_color',
        'priority'    => 10,
        'default'     => '#5a00f0',
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
        'settings'     => 'single_button_bg',
        'label'       => __( 'Single Button Custom Background Color', 'mayosis' ),
        'description' => __( 'Change Single Button Custom Background Color', 'mayosis' ),
        'section'     => 'composer_color',
        'priority'    => 10,
        'default'     => '#3c465a',
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
        'settings'    => 'remove_elementor_default',
        'label'       => __( 'Elementor Default Content Width Overwrite', 'mayosis' ),
        'section'     => 'composer_color',
        'default'     => 'one',
        'priority'    => 10,
        'choices'     => array(
            'one'   => esc_attr__( 'Bootstarp Width', 'mayosis' ),
            'two' => esc_attr__( 'Elementor Width', 'mayosis' ),
        ),
    
) );