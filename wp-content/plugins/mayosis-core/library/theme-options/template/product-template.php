<?php
Mayosis_Option::add_panel( 'mayosis_template', array(
	'title'       => __( 'Product Template', 'mayosis' ),
	'description' => __( 'Mayosis Product Template', 'mayosis' ),
	'priority' => '8',
) );

Mayosis_Option::add_section( 'template_automation', array(
	'title'       => __( 'Template Automation', 'mayosis' ),
	'panel'       => 'mayosis_template',

) );

Mayosis_Option::add_section( 'product_template', array(
	'title'       => __( 'Default Product Template', 'mayosis' ),
	'panel'       => 'mayosis_template',

) );

Mayosis_Option::add_section( 'photo_template', array(
	'title'       => __( 'Media Template', 'mayosis' ),
	'panel'       => 'mayosis_template',

) );

Mayosis_Option::add_section( 'prime_template', array(
	'title'       => __( 'Prime Template', 'mayosis' ),
	'panel'       => 'mayosis_template',

) );

Mayosis_Option::add_section( 'product_archive', array(
	'title'       => __( 'Product Archive Template', 'mayosis' ),
	'panel'       => 'mayosis_template',

) );

Mayosis_Option::add_section( 'product_author', array(
	'title'       => __( 'Product Vendor Template', 'mayosis' ),
	'panel'       => 'mayosis_template',

) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'product_template_autmation_main',
        'label'       => __( 'Select Product Template Selection Type', 'mayosis' ),
        'section'     => 'template_automation',
        'default'     => 'single-download',
        'priority'    => 10,
        'choices'     => array(
            'single-download'   => esc_attr__( 'Default', 'mayosis' ),
            'allcat' => esc_attr__( 'Whole Site', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'select',
        'settings'    => 'whole_site_product_template',
        'label'       => __( 'Whole Site Product Template', 'mayosis' ),
        'section'     => 'template_automation',
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => array(
            'photo' => esc_attr__( 'Media Template', 'mayosis' ),
            'multi' => esc_attr__( 'Prime Template', 'mayosis' ),
            'full' => esc_attr__( 'Full Width Template', 'mayosis' ),
            'narrow' => esc_attr__( 'Narrow Template', 'mayosis' )

        ),

        'required'    => array(
            array(
                'setting'  => 'product_template_autmation_main',
                'operator' => '==',
                'value'    => 'allcat',
            ),
        ),
    
) );

//start default template

Mayosis_Option::add_field( 'mayo_config', array(
    
    'type'        => 'dimensions',
        'settings'    => 'product_dif_padding',
        'label'       => esc_attr__( 'Product Breadcrumb Padding', 'mayosis' ),
        'description' => esc_attr__( 'Change Breadcrumb Padding', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => array(
            'padding-top'    => '80px',
            'padding-bottom' => '80px',
            'padding-left'   => '0px',
            'padding-right'  => '0px',
        ),
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'radio-buttonset',
        'settings'    => 'featured_image_visibility',
        'label'       => __( 'Featured Image Visibility', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => 'show',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'featured_image_position',
        'label'       => __( 'Featured Image Position', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => 'left',
        'priority'    => 10,
        'choices'     => array(
            'left'   => esc_attr__( 'Left', 'mayosis' ),
            'right' => esc_attr__( 'Right', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'select',
        'settings'    => 'product_header_content_position',
        'label'       => __( 'Product Header Content Position', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => 'left',
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => array(
            'left' => esc_attr__( 'Left', 'mayosis' ),
            'center' => esc_attr__( 'Center', 'mayosis' ),
            'right' => esc_attr__( 'Right', 'mayosis' ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'select',
        'settings'    => 'background_product',
        'label'       => __( 'Background', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => 'color',
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => array(
            'color' => esc_attr__( 'Color', 'mayosis' ),
            'gradient' => esc_attr__( 'Gradient', 'mayosis' ),
            'image' => esc_attr__( 'Image', 'mayosis' ),
            'featured' => esc_attr__( 'Featured Image', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'product_bg_default',
        'label'       => __( 'Background Color', 'mayosis' ),
        'description' => __( 'Change  Backgrounnd Color', 'mayosis' ),
        'section'     => 'product_template',
        'priority'    => 10,
        'default'     => '#460082',
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

        'required'    => array(
            array(
                'setting'  => 'background_product',
                'operator' => '==',
                'value'    => 'color',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'multicolor',
        'settings'    => 'product_gradient_default',
        'label'       => esc_attr__( 'Product gradient', 'mayosis' ),
        'section'     => 'product_template',
        'priority'    => 10,
        'required'    => array(
            array(
                'setting'  => 'background_product',
                'operator' => '==',
                'value'    => 'gradient',
            ),
        ),
        'choices'     => array(
            'color1'    => esc_attr__( 'Form', 'mayosis' ),
            'color2'   => esc_attr__( 'To', 'mayosis' ),
        ),
        'default'     => array(
            'color1'    => '#1e0046',
            'color2'   => '#1e0064',
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'     => 'text',
        'settings' => 'gradient_angle_product',
        'label'    => __( 'Angle', 'mayosis' ),
        'section'  => 'product_template',
        'default'  => esc_attr__( '135', 'mayosis' ),
        'priority' => 10,
        'required'    => array(
            array(
                'setting'  => 'background_product',
                'operator' => '==',
                'value'    => 'gradient',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'image',
        'settings'    => 'product-main-bg',
        'label'       => esc_attr__( 'Image Control (URL)', 'mayosis' ),
        'description' => esc_attr__( 'Custom Image.', 'mayosis' ),
        'section'     => 'product_template',
        'required'    => array(
            array(
                'setting'  => 'background_product',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'     => 'text',
        'settings' => 'main_product_blur',
        'label'    => __( 'Blur Radius', 'mayosis' ),
        'section'  => 'product_template',
        'default'  => esc_attr__( '5px', 'mayosis' ),
        'priority' => 10,
        'required'    => array(
            array(
                'setting'  => 'background_product',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
) );

Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'color',
        'settings'     => 'product_ovarlay_main',
        'label'       => __( 'Overlay Color', 'mayosis' ),
        'description' => __( 'Change  Overlay Color', 'mayosis' ),
        'section'     => 'product_template',
        'priority'    => 10,
        'default'     => 'rgb(40,40,50,.5)',
        'choices'     => array(
            'alpha' => true,
        ),

        'required'    => array(
            array(
                'setting'  => 'background_product',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'parallax_featured_image',
        'label'       => __( 'Featured Image Parallax', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => 'no',
        'priority'    => 10,
        'choices'     => array(
            'yes'   => esc_attr__( 'Yes', 'mayosis' ),
            'no' => esc_attr__( 'No', 'mayosis' ),
        ),

        'required'    => array(
            array(
                'setting'  => 'background_product',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'image',
        'settings'    => 'default_overlay_image_product',
        'label'       => esc_attr__( 'Product Overlay Image', 'mayosis' ),
        'description' => esc_attr__( 'Upload product background image', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => '',
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'product_bdtxt_color',
        'label'       => __( 'Breadcrumb Text Color', 'mayosis' ),
        'description' => __( 'Change breadcrumb text color', 'mayosis' ),
        'section'     => 'product_template',
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
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'product_buttontxt_color',
        'label'       => __( 'Breadcrumb Button Text Color', 'mayosis' ),
        'description' => __( 'Change breadcrumb Button text color', 'mayosis' ),
        'section'     => 'product_template',
        'priority'    => 10,
        'default'     => '#ffffff',
        'transport' =>$transport,
        'output' => array(
            	array(
            		'element'  => '.default-product-template.product-main-header .single_main_header_products .edd-add-to-cart span',
            		'property' => 'color',
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
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'product_ghost_border_color',
        'label'       => __( 'Breadcrumb Ghost Button Border Color', 'mayosis' ),
        'description' => __( 'Change ghost breadcrumb button border color', 'mayosis' ),
        'section'     => 'product_template',
        'priority'    => 10,
        'default'     => 'rgba(255,255,255,0.25)',
        'transport' =>$transport,
        'output' => array(
            	array(
            		'element'  => '.comment-button a.btn,.social-button',
            		'property' => 'border-color',
            	),
    	),
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
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'product_ghost_social_bg',
        'label'       => __( 'Breadcrumb Ghost Social Button Background', 'mayosis' ),
        'description' => __( 'Change Ghost Social Button Background color', 'mayosis' ),
        'section'     => 'product_template',
        'priority'    => 10,
        'default'     => '#ffffff',
        'transport' =>$transport,
        'output' => array(
            	array(
            		'element'  => '.social-button a i',
            		'property' => 'background-color',
            	),
    	),
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
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'product_ghost_social_txt',
        'label'       => __( 'Breadcrumb Ghost Social Button Text', 'mayosis' ),
        'description' => __( 'Change Ghost Social Button Text color', 'mayosis' ),
        'section'     => 'product_template',
        'priority'    => 10,
        'default'     => '#000046',
        'transport' =>$transport,
        'output' => array(
            	array(
            		'element'  => '.social-button a i',
            		'property' => 'color',
            	),
    	),
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
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'sortable',
        'settings'    => 'product_content_layout_manager',
        'label'       => __( 'Product Content Layout Manager', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => array(
            'breadcrumb',
            'title',
            'category',
            'date',
            'button'
        ),
        'choices'     => array(
            'breadcrumb' => esc_attr__( 'Breadcrumb', 'mayosis' ),
            'title' => esc_attr__( 'Title', 'mayosis' ),
            'author' => esc_attr__( 'Author', 'mayosis' ),
            'category' => esc_attr__( 'Category', 'mayosis' ),
            'date' => esc_attr__( 'Date', 'mayosis' ),
            'button' => esc_attr__( 'Action Button', 'mayosis' ),
        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'radio-buttonset',
        'settings'    => 'product_gallery_width',
        'label'       => __( 'Product Gallery Type', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => 'two',
        'priority'    => 10,
        'choices'     => array(
            'one'   => esc_attr__( 'Full Width', 'mayosis' ),
            'two' => esc_attr__( 'With Sidebar', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'product_top_social_share',
        'label'       => __( 'Product Top Social Share', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => 'show',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'radio-buttonset',
        'settings'    => 'defultp_bottom_widget',
        'label'       => __( 'Enable/Disable Bottom Widget Panel', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => 'on',
        'priority'    => 10,
        'choices'     => array(
            'on'   => esc_attr__( 'Enable', 'mayosis' ),
            'off' => esc_attr__( 'Disable', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'radio-buttonset',
        'settings'    => 'defultp_bottom_widget_control',
        'label'       => __( 'Bottom Widget Control', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => 'default',
        'priority'    => 10,
        'choices'     => array(
            'default'   => esc_attr__( 'Default', 'mayosis' ),
            'widget' => esc_attr__( 'From Widget', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'radio-buttonset',
        'settings'    => 'defultp_bottom_widget_col',
        'label'       => __( 'Bottom Widget Column', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => 'three',
        'priority'    => 10,
        'choices'     => array(
            'one'   => esc_attr__( 'One Column', 'mayosis' ),
            'two' => esc_attr__( 'Two Column', 'mayosis' ),
            'three' => esc_attr__( 'Three Column', 'mayosis' ),
        ),
        
        'required'    => array(
            array(
                'setting'  => 'defultp_bottom_widget_control',
                'operator' => '==',
                'value'    => 'widget',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'free_product_cart_button',
        'label'       => __( 'Cart Button Show/hide on free products', 'mayosis' ),
        'section'     => 'product_template',
        'default'     => 'hide',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
        
    
) );


// End Deafult template

// Start Photo template


Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'radio-buttonset',
        'settings'    => 'photo_template_promo',
        'label'       => __( 'Photo Template Promo Bar', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'hide',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', [
	'type'        => 'dimensions',
	'settings'    => 'photo-video-template-padding',
	'label'       => esc_html__( 'Promo Padding', 'mayosis' ),
	'description' => esc_html__( 'add promo padding here.', 'mayosis' ),
	'section'     => 'photo_template',
	'required'    => array(
            array(
                'setting'  => 'photo_template_promo',
                'operator' => '==',
                'value'    => 'show',
            ),
        ),
	'default'     => [
		'padding-top'    => '80px',
		'padding-bottom' => '80px',
		'padding-left'   => '0',
		'padding-right'  => '0',
	],
] );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'photo_promobar_type',
        'label'       => __( 'Photo Template Promo Bar Background Type', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'none',
        'priority'    => 10,
        'required'    => array(
            array(
                'setting'  => 'photo_template_promo',
                'operator' => '==',
                'value'    => 'show',
            ),
        ),
        'choices'     => array(
            'none'   => esc_attr__( 'None', 'mayosis' ),
            'color'   => esc_attr__( 'Single Color', 'mayosis' ),
            'gradient' => esc_attr__( 'Gradient', 'mayosis' ),
            'image' => esc_attr__( 'Image', 'mayosis' ),
            'featured' => esc_attr__( 'Featured Image', 'mayosis' ),
            'video' => esc_attr__( 'Video', 'mayosis' ),
        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'photo_template_bg',
        'label'       => __( 'Photo Template Bg Color', 'mayosis' ),
        'description' => __( 'Change  Background Color', 'mayosis' ),
        'section'     => 'photo_template',
        'priority'    => 10,
        'default'     => '#e9ebf7',
        'required'    => array(
            array(
                'setting'  => 'photo_promobar_type',
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
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'photo_template_g1',
        'label'       => __( 'Photo Template Bg Gradient A', 'mayosis' ),
        'description' => __( 'Change  Background Color', 'mayosis' ),
        'section'     => 'photo_template',
        'priority'    => 10,
        'default'     => '#1e0046',
        'required'    => array(
            array(
                'setting'  => 'photo_promobar_type',
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
    
) );

Mayosis_Option::add_field( 'mayo_config', [
	'type'        => 'image',
	'settings'    => 'background_image_photo_promo',
	'label'       => esc_html__( 'Background Image', 'mayosis' ),
	'description' => esc_html__( 'Add Background Image.', 'mayosis' ),
	'section'     => 'photo_template',
	 'required'    => array(
            array(
                'setting'  => 'photo_promobar_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
	'default'     => '',
] );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'photo_template_g2',
        'label'       => __( 'Photo Template Bg Gradient B', 'mayosis' ),
        'description' => __( 'Change  Background Color', 'mayosis' ),
        'section'     => 'photo_template',
        'priority'    => 10,
        'default'     => '#1e0064',
        'required'    => array(
            array(
                'setting'  => 'photo_promobar_type',
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
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'photov_overlay_color',
        'label'       => __( 'Photo Template Promo Overlay Color', 'mayosis' ),
        'description' => __( 'Change  Overlay Color', 'mayosis' ),
        'section'     => 'photo_template',
        'priority'    => 10,
        'default'     => 'rgba(25,30,75,0.85)',
        'required'    => array(
            array(
                'setting'  => 'photo_promobar_type',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
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
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'photov_overlay_color_video',
        'label'       => __( 'Video Overlay Color', 'mayosis' ),
        'description' => __( 'Change  Overlay Color', 'mayosis' ),
        'section'     => 'photo_template',
        'priority'    => 10,
        'default'     => 'rgba(25,30,75,0.85)',
        'required'    => array(
            array(
                'setting'  => 'photo_promobar_type',
                'operator' => '==',
                'value'    => 'video',
            ),
        ),
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
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'radio-buttonset',
        'settings'    => 'photo_template_view',
        'label'       => __( 'Photo Template Layout', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'fixed',
        'priority'    => 10,
        'choices'     => array(
            'fixed'   => esc_attr__( 'Fixed', 'mayosis' ),
            'flexible' => esc_attr__( 'Flexible', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'dimension',
        'settings'    => 'product_photo_margin',
        'label'       => esc_attr__( 'Photo Template Margin Top', 'mayosis' ),
        'description' => esc_attr__( 'Photo Template Margin Top', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => '80px',
        'output'    => array(
            array(
                'element'  => '.photo-template-author',
                'property' => 'margin-top',

            ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'photo_template_author_enable',
        'label'       => __( 'Author Information Enable/Disable', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'enable',
        'priority'    => 10,
        'choices'     => array(
            'enable'   => esc_attr__( 'Enable', 'mayosis' ),
            'disable' => esc_attr__( 'Disable', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'     => 'text',
        'settings' => 'photography_by',
        'label'    => esc_html__( 'Author Type Name (i.e Photography By)', 'mayosis' ),
        'required'    => array(
            array(
                'setting'  => 'photo_template_author_enable',
                'operator' => '==',
                'value'    => 'enable',
            ),
        ),
        'section'  => 'photo_template',
        'default'  => esc_html__( 'Photography By', 'mayosis' ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'photo_template_box_gap',
        'label'       => __( 'Gap Between Photo & Infobox', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'disable',
        'priority'    => 10,
        'choices'     => array(
            'enable'   => esc_attr__( 'Gap', 'mayosis' ),
            'disable' => esc_attr__( 'No Gap', 'mayosis' ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'photo_template_backgrund_remove',
        'label'       => __( 'Background Color Remove from Photobox', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'enable',
        'priority'    => 10,
        'choices'     => array(
            'enable'   => esc_attr__( 'Background', 'mayosis' ),
            'disable' => esc_attr__( 'Transparent', 'mayosis' ),
        ),
        
        'required'    => array(
            array(
                'setting'  => 'photo_template_box_gap',
                'operator' => '==',
                'value'    => 'enable',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'photo_template_shadow',
        'label'       => __( 'Add Shadow on boxes', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'disable',
        'priority'    => 10,
        'choices'     => array(
            'enable'   => esc_attr__( 'Shadow', 'mayosis' ),
            'disable' => esc_attr__( 'No Shadow', 'mayosis' ),
        ),
         'required'    => array(
            array(
                'setting'  => 'photo_template_box_gap',
                'operator' => '==',
                'value'    => 'enable',
            ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'photo_equal_height',
        'label'       => __( 'Equal height Both Box', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'disable',
        'priority'    => 10,
        'choices'     => array(
            'enable'   => esc_attr__( 'Equal', 'mayosis' ),
            'disable' => esc_attr__( 'Not Equal', 'mayosis' ),
        ),
     'required'    => array(
            array(
                'setting'  => 'photo_template_box_gap',
                'operator' => '==',
                'value'    => 'enable',
            ),
        ),
) );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'photo_zoom_disable',
        'label'       => __( 'Photo Zoom Button', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'enable',
        'priority'    => 10,
        'choices'     => array(
            'enable'   => esc_attr__( 'Enable', 'mayosis' ),
            'disable' => esc_attr__( 'Disable', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'media_subscription_box',
        'label'       => __( 'Subscription Information', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'disable',
        'priority'    => 10,
        'choices'     => array(
            'enable'   => esc_attr__( 'Enable', 'mayosis' ),
            'disable' => esc_attr__( 'Disable', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'media_subscription_style',
        'label'       => __( 'Subscription Information Style', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'stylea',
        'priority'    => 10,
        'choices'     => array(
            'stylea'   => esc_attr__( 'Style One', 'mayosis' ),
            'styleb' => esc_attr__( 'Style Two(with sidebar)', 'mayosis' ),
            'stylec' => esc_attr__( 'Style Three', 'mayosis' ),
        ),
        
         'required'    => array(
            array(
                'setting'  => 'media_subscription_box',
                'operator' => '==',
                'value'    => 'enable',
            ),
        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'text',
        'settings'    => 'media_subscription_text',
        'label'       => __( 'Subscription Information Details', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'Download Unlimited Stock Videos at $99/month',
        'priority'    => 10,
        
         'required'    => array(
            array(
                'setting'  => 'media_subscription_box',
                'operator' => '==',
                'value'    => 'enable',
            ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', [
	'type'        => 'repeater',
	'label'       => esc_html__( 'Subscription Box Content', 'mayosis' ),
	'section'     => 'photo_template',
	'required'    => array(
            array(
                'setting'  => 'media_subscription_style',
                'operator' => '==',
                'value'    => 'styleb',
            ),
        ),
	'priority'    => 10,
	'row_label' => [
		'type'  => 'field',
		'value' => esc_html__( 'Your Custom Value', 'mayosis' ),
		'field' => 'subscription_option',
	],
	'button_label' => esc_html__('Add New Option ', 'mayosis' ),
	'settings'     => 'photoz_subscription_options',
	'default'      => [
		[
			'subscription_option' => esc_html__( 'Download Unlimited Videos', 'mayosis' ),
			
		],
		
	],
	'fields' => [
		'subscription_option' => [
			'type'        => 'text',
			'label'       => esc_html__( 'Option', 'mayosis' ),
			'default'     => '',
		],
		
	]
] );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'text',
        'settings'    => 'media_subscription_btn_text',
        'label'       => __( 'Subscription Button Title', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'Subscribe',
        'priority'    => 10,
        
         'required'    => array(
            array(
                'setting'  => 'media_subscription_box',
                'operator' => '==',
                'value'    => 'enable',
            ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'text',
        'settings'    => 'media_subscription_url',
        'label'       => __( 'Subscription Button URL', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => '',
        'priority'    => 10,
        
         'required'    => array(
            array(
                'setting'  => 'media_subscription_box',
                'operator' => '==',
                'value'    => 'enable',
            ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'media_price_align',
        'label'       => __( 'Price Align', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'center',
        'priority'    => 10,
        'choices'     => array(
            'left'   => esc_attr__( 'Left', 'mayosis' ),
            'center' => esc_attr__( 'Center', 'mayosis' ),
            'right' => esc_attr__( 'Right', 'mayosis' ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'text',
        'settings'    => 'media_price_desc_txt',
        'label'       => __( 'Price Above Text', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => '',
        'priority'    => 10,
       
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'text',
        'settings'    => 'related_product_title',
        'label'       => __( 'Related Product Title', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'Similar Images',
        'priority'    => 10,
       
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'related_download_style',
        'label'       => __( 'Related Download Style', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'justified',
        'priority'    => 10,
        'choices'     => array(
            'normal'   => esc_attr__( 'Normal', 'mayosis' ),
            'justified' => esc_attr__( 'Justified Grid', 'mayosis' ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'text',
        'settings'    => 'related_product_number',
        'label'       => __( 'Related Product Number', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => '8',
        'priority'    => 10,
       
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'media_coment',
        'label'       => __( 'Comment Width Mode', 'mayosis' ),
        'section'     => 'photo_template',
        'default'     => 'normal',
        'priority'    => 10,
        'choices'     => array(
            'normal'   => esc_attr__( 'Normal', 'mayosis' ),
            'compact' => esc_attr__( 'Compact', 'mayosis' ),
        ),
    
) );
// End Photo template

// Start prime template
    
Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'typography',
        'settings'    => 'prime_typography',
        'label'       => esc_attr__( 'Prime Title Typography', 'mayosis' ),
        'section'     => 'prime_template',
        'default'     => array(
            'font-family'    => '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif',
            'variant'        => '700',
            'font-size'      => '36px',
            'line-height'    => '45px',
            'letter-spacing'    => '-0.75',

        ),
        'priority'    => 10,

        'choices' => array(
            'fonts' => array(
                'google' => array( 'popularity', 60 ),
            ),
        ),

        'transport' => 'auto',
        'output'    => array(
            array(
                'element' => '.prime-product-template h1.single-post-title',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'dimensions',
        'settings'    => 'product_prime_padding',
        'label'       => esc_attr__( 'Product Breadcrumb Padding', 'mayosis' ),
        'description' => esc_attr__( 'Change Breadcrumb Padding', 'mayosis' ),
        'section'     => 'prime_template',
        'default'     => array(
            'padding-top'    => '80px',
            'padding-bottom' => '80px',
            'padding-left'   => '0px',
            'padding-right'  => '0px',
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'select',
        'settings'    => 'product_prime_content_position',
        'label'       => __( 'Product Header Content Position', 'mayosis' ),
        'section'     => 'prime_template',
        'default'     => 'left',
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => array(
            'left' => esc_attr__( 'Left', 'mayosis' ),
            'center' => esc_attr__( 'Center', 'mayosis' ),
            'right' => esc_attr__( 'Right', 'mayosis' ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'select',
        'settings'    => 'background_prime',
        'label'       => __( 'Background', 'mayosis' ),
        'section'     => 'prime_template',
        'default'     => 'color',
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => array(
            'color' => esc_attr__( 'Color', 'mayosis' ),
            'gradient' => esc_attr__( 'Gradient', 'mayosis' ),
            'image' => esc_attr__( 'Image', 'mayosis' ),
            'featured' => esc_attr__( 'Featured Image', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'prime_bg_default',
        'label'       => __( 'Background Color', 'mayosis' ),
        'description' => __( 'Change  Backgrounnd Color', 'mayosis' ),
        'section'     => 'prime_template',
        'priority'    => 10,
        'default'     => '#edf0f7',
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#edf0f7',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),

        'required'    => array(
            array(
                'setting'  => 'background_prime',
                'operator' => '==',
                'value'    => 'color',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'multicolor',
        'settings'    => 'prime_gradient_default',
        'label'       => esc_attr__( 'Product gradient', 'mayosis' ),
        'section'     => 'prime_template',
        'priority'    => 10,
        'required'    => array(
            array(
                'setting'  => 'background_prime',
                'operator' => '==',
                'value'    => 'gradient',
            ),
        ),
        'choices'     => array(
            'color1'    => esc_attr__( 'Form', 'mayosis' ),
            'color2'   => esc_attr__( 'To', 'mayosis' ),
        ),
        'default'     => array(
            'color1'    => '#1e0046',
            'color2'   => '#1e0064',
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'     => 'text',
        'settings' => 'gradient_angle_prime',
        'label'    => __( 'Angle', 'mayosis' ),
        'section'  => 'prime_template',
        'default'  => esc_attr__( '135', 'mayosis' ),
        'priority' => 10,
        'required'    => array(
            array(
                'setting'  => 'background_prime',
                'operator' => '==',
                'value'    => 'gradient',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'image',
        'settings'    => 'prime-main-bg',
        'label'       => esc_attr__( 'Image', 'mayosis' ),
        'description' => esc_attr__( 'Custom Image.', 'mayosis' ),
        'section'     => 'prime_template',
        'required'    => array(
            array(
                'setting'  => 'background_prime',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'     => 'text',
        'settings' => 'main_prime_blur',
        'label'    => __( 'Blur Radius', 'mayosis' ),
        'section'  => 'prime_template',
        'default'  => esc_attr__( '5px', 'mayosis' ),
        'priority' => 10,
        'required'    => array(
            array(
                'setting'  => 'background_prime',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'color',
        'settings'     => 'prime_ovarlay_main',
        'label'       => __( 'Overlay Color', 'mayosis' ),
        'description' => __( 'Change  Overlay Color', 'mayosis' ),
        'section'     => 'prime_template',
        'priority'    => 10,
        'default'     => 'rgb(40,40,50,.5)',
        'choices'     => array(
            'alpha' => true,
        ),

        'required'    => array(
            array(
                'setting'  => 'background_prime',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'parallax_prime_image',
        'label'       => __( 'Featured Image Parallax', 'mayosis' ),
        'section'     => 'prime_template',
        'default'     => 'no',
        'priority'    => 10,
        'choices'     => array(
            'yes'   => esc_attr__( 'Yes', 'mayosis' ),
            'no' => esc_attr__( 'No', 'mayosis' ),
        ),

        'required'    => array(
            array(
                'setting'  => 'background_prime',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'image',
        'settings'    => 'prime_overlay_image_product',
        'label'       => esc_attr__( 'Product Overlay Image', 'mayosis' ),
        'description' => esc_attr__( 'Upload product background image', 'mayosis' ),
        'section'     => 'prime_template',
        'default'     => '',
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'color',
        'settings'     => 'prime_bdtxt_color',
        'label'       => __( 'Breadcrumb Text Color', 'mayosis' ),
        'description' => __( 'Change breadcrumb text color', 'mayosis' ),
        'section'     => 'prime_template',
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
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'sortable',
        'settings'    => 'prime_content_layout_manager',
        'label'       => __( 'Product Content Layout Manager', 'mayosis' ),
        'section'     => 'prime_template',
        'default'     => array(
            'title',
        ),
        'choices'     => array(
            'breadcrumb' => esc_attr__( 'Breadcrumb', 'mayosis' ),
            'title' => esc_attr__( 'Title', 'mayosis' ),
            'author' => esc_attr__( 'Author', 'mayosis' ),
            'category' => esc_attr__( 'Category', 'mayosis' ),
            'date' => esc_attr__( 'Date', 'mayosis' ),
            'button' => esc_attr__( 'Action Button', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'prime_bottom_widget',
        'label'       => __( 'Enable/Disable Bottom Widget Panel', 'mayosis' ),
        'section'     => 'prime_template',
        'default'     => 'on',
        'priority'    => 10,
        'choices'     => array(
            'on'   => esc_attr__( 'Enable', 'mayosis' ),
            'off' => esc_attr__( 'Disable', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'prime_gallery_width',
        'label'       => __( 'Product Gallery/Thumbnail Width', 'mayosis' ),
        'section'     => 'prime_template',
        'default'     => 'two',
        'priority'    => 10,
        'choices'     => array(
            'one'   => esc_attr__( 'Full Width', 'mayosis' ),
            'two' => esc_attr__( 'With Sidebar', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'prime_media_position',
        'label'       => __( 'EDD Audio/Video Position', 'mayosis' ),
        'section'     => 'prime_template',
        'default'     => 'top',
        'priority'    => 10,
        'choices'     => array(
            'top'   => esc_attr__( 'Above Featured Image', 'mayosis' ),
            'bottom' => esc_attr__( 'Below Featured Image', 'mayosis' ),

        ),
    
) );

//end prime template

    //Start archive template
Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'select',
        'settings'    => 'archive_bg_type',
        'label'       => __( 'Archive Background Type', 'mayosis' ),
        'section'     => 'product_archive',
        'default'     => 'gradient',
        'priority'    => 10,
        'choices'     => array(
            'color'  => esc_attr__( 'Color', 'mayosis' ),
            'gradient' => esc_attr__( 'Gradient', 'mayosis' ),
            'image' => esc_attr__( 'Image', 'mayosis' ),
            'featured' => esc_attr__( 'Category Image', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'color',
        'settings'     => 'parchive_background',
        'label'       => __( 'Breadcrumb Background Color', 'mayosis' ),
        'description' => __( 'Set Breadcrumb Background color', 'mayosis' ),
        'section'     => 'product_archive',
        'priority'    => 10,
        'default'     => '#1e0047',
        'required'    => array(
            array(
                'setting'  => 'archive_bg_type',
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
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'multicolor',
        'settings'    => 'parchive_gradient',
        'label'       => esc_attr__( 'Breadcrumb gradient', 'mayosis' ),
        'section'     => 'product_archive',
        'priority'    => 10,
        'required'    => array(
            array(
                'setting'  => 'archive_bg_type',
                'operator' => '==',
                'value'    => 'gradient',
            ),
        ),
        'choices'     => array(
            'color1'    => esc_attr__( 'Form', 'mayosis' ),
            'color2'   => esc_attr__( 'To', 'mayosis' ),
        ),
        'default'     => array(
            'color1'    => '#1e0046',
            'color2'   => '#1e0064',
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'image',
        'settings'    => 'parchive_image',
        'label'       => esc_attr__( 'Breadcrumb Background Image', 'mayosis' ),
        'description' => esc_attr__( 'Upload Product/Blog background image', 'mayosis' ),
        'section'     => 'product_archive',
        'required'    => array(
            array(
                'setting'  => 'archive_bg_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'parchive_bg_image_repeat',
        'label'       => __( 'Image Repeat', 'mayosis' ),
        'section'     => 'product_archive',
        'default'     => 'repeat',
        'priority'    => 10,
        'choices'     => array(
            'repeat'  => esc_attr__( 'Repeat', 'mayosis' ),
            'cover' => esc_attr__( 'Cover', 'mayosis' ),

        ),
        'required'    => array(
            array(
                'setting'  => 'archive_bg_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'     => 'text',
        'settings' => 'pbread_blog_blur',
        'label'    => __( 'Blur Radius', 'mayosis' ),
        'section'  => 'product_archive',
        'default'  => esc_attr__( '5px', 'mayosis' ),
        'priority' => 10,
        'required'    => array(
            array(
                'setting'  => 'archive_bg_type',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'color',
        'settings'     => 'pbread_ovarlay_main',
        'label'       => __( 'Overlay Color', 'mayosis' ),
        'description' => __( 'Change  Overlay Color', 'mayosis' ),
        'section'     => 'product_archive',
        'priority'    => 10,
        'default'     => 'rgb(40,40,50,.5)',
        'choices'     => array(
            'alpha' => true,
        ),

        'required'    => array(
            array(
                'setting'  => 'archive_bg_type',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'parallax_prbred_image',
        'label'       => __( 'Featured Image Parallax', 'mayosis' ),
        'section'     => 'product_archive',
        'default'     => 'no',
        'priority'    => 10,
        'choices'     => array(
            'yes'   => esc_attr__( 'Yes', 'mayosis' ),
            'no' => esc_attr__( 'No', 'mayosis' ),
        ),

        'required'    => array(
            array(
                'setting'  => 'archive_bg_type',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'pbread_txt_color',
        'label'       => __( 'Breadcrumb Text Color', 'mayosis' ),
        'description' => __( 'Change Text Color', 'mayosis' ),
        'section'     => 'product_archive',
        'priority'    => 10,
        'default'     => '#ffffff',
        'choices'     => array(
            'alpha' => true,
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'select',
        'settings'    => 'pbread_txt_align',
        'label'       => __( 'Breadcrumb Text Align', 'mayosis' ),
        'section'     => 'product_archive',
        'default'     => 'center',
        'priority'    => 10,
        'choices'     => array(
            'left'   => esc_attr__( 'Left', 'mayosis' ),
            'center' => esc_attr__( 'Center', 'mayosis' ),
            'right' => esc_attr__( 'Right', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'product_archive_type',
        'label'       => __( 'Product Archive Type', 'mayosis' ),
        'section'     => 'product_archive',
        'default'     => 'one',
        'priority'    => 10,
        'choices'     => array(
            'one'   => esc_attr__( 'Full Width', 'mayosis' ),
            'two' => esc_attr__( 'With Sidebar', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'select',
        'settings'    => 'product_archive_column_grid',
        'label'       => __( 'Product Archive Column', 'mayosis' ),
        'section'     => 'product_archive',
        'default'     => 'two',
        'priority'    => 10,
        'choices'     => array(
            'one'   => esc_attr__( 'Two Column', 'mayosis' ),
            'two' => esc_attr__( 'Three Column', 'mayosis' ),
            'three' => esc_attr__( 'Four Column', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'select',
        'settings'    => 'archive_title_disable',
        'label'       => __( 'Archive Titlebar', 'mayosis' ),
        'section'     => 'product_archive',
        'default'     => 'enable',
        'priority'    => 10,
        'choices'     => array(
            'enable'   => esc_attr__( 'Enable', 'mayosis' ),
            'disable' => esc_attr__( 'Disable', 'mayosis' ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
    
    'type'     => 'text',
        'settings' => 'all_product_text',
        'label'    => __( 'Archive Page Title Prefix Text', 'mayosis' ),
        'section'  => 'product_archive',
        'default'  => esc_attr__( 'ALL PRODUCTS FROM', 'mayosis' ),
        'priority' => 10,
) );

    //vendor profile
    
Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'sortable',
        'settings'    => 'vendor_layout_control',
        'label'       => __( 'Vendor Content Layout Manager', 'mayosis' ),
        'section'     => 'product_author',
        'default'     => array(
            'products',
            'sales',
            'page',
            'follower',
            'following'
        ),
        'choices'     => array(
            'products' => esc_attr__( 'Product Count', 'mayosis' ),
            'sales' => esc_attr__( 'Lifetime Sales', 'mayosis' ),
            'page' => esc_attr__( 'Page Views', 'mayosis' ),
            'follower' => esc_attr__( 'Follower', 'mayosis' ),
            'following' => esc_attr__( 'Following', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'     => 'dimension',
        'settings' => 'vendor_form_border_radius',
        'label'    => __( 'Vendor Search Form Border Radius', 'mayosis' ),
        'section'  => 'product_author',
        'default'  => '20px',
        'priority' => 10,
        'output'    => array(
            array(

                'element'     => '.vendor--search--box input[type="text"]',
                'property'    => 'border-radius',

            ),
        )
) );


