<?php
Mayosis_Option::add_field( 'mayo_config', array(
'type'        => 'color',
        'settings'     => 'product_thumb_hover',
        'label'       => __( 'Thumbnail Hover Background', 'mayosis' ),
        'description' => __( 'Set Thumbnail Hover Background', 'mayosis' ),
        'section'     => 'product_color',
        'priority'    => 10,
        'default'     => 'rgba(40,40,55,.8)',
        'choices' => array(
            'alpha' => true,
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
        'settings'     => 'product_thumb_hover_text',
        'label'       => __( 'Thumbnail Hover Text Color', 'mayosis' ),
        'description' => __( 'Set Thumbnail Hover Text Color', 'mayosis' ),
        'section'     => 'product_color',
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
        'settings'     => 'product_label',
        'label'       => __( 'Product Label Color', 'mayosis' ),
        'description' => __( 'Set Product Label Color', 'mayosis' ),
        'section'     => 'product_color',
        'priority'    => 10,
        'default'     => '#e6174b',
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
        'settings'     => 'product_label_edge',
        'label'       => __( 'Product Label Edge Color', 'mayosis' ),
        'description' => __( 'Set Product Label Edge Color', 'mayosis' ),
        'section'     => 'product_color',
        'priority'    => 10,
        'default'     => '#b71338',
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
