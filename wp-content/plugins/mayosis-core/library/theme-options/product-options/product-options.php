<?php
Mayosis_Option::add_panel( 'mayosis_product', array(
	'title'       => __( 'Product Options', 'mayosis' ),
	'description' => __( 'Mayosis Product Options.', 'mayosis' ),
	'priority' => '7',
) );

Mayosis_Option::add_section( 'product_options', array(
	'title'       => __( 'General Options', 'mayosis' ),
	'panel'       => 'mayosis_product',

) );

Mayosis_Option::add_section( 'grid_meta', array(
	'title'       => __( 'Meta Options', 'mayosis' ),
	'panel'       => 'mayosis_product',

) );


Mayosis_Option::add_section( 'grid_ribbon', array(
	'title'       => __( 'Ribbon & Badges', 'mayosis' ),
	'panel'       => 'mayosis_product',

) );

Mayosis_Option::add_section( 'product_information_widget', array(
	'title'       => __( 'Product Information Widget', 'mayosis' ),
	'panel'       => 'mayosis_product',

) );

Mayosis_Option::add_section( 'product_video', array(
	'title'       => __( 'Video Grid Options', 'mayosis' ),
	'panel'       => 'mayosis_product',

) );
Mayosis_Option::add_section( 'product_more', array(
	'title'       => __( 'Other Options', 'mayosis' ),
	'panel'       => 'mayosis_product',

) );


Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'radio-buttonset',
        'settings'    => 'product_grid_system',
        'label'       => __( 'Product Grid System', 'mayosis' ),
        'section'     => 'product_options',
        'default'     => 'one',
        'priority'    => 10,
        'choices'     => array(
            'one'   => esc_attr__( 'Normal', 'mayosis' ),
            'two' => esc_attr__( 'Masonary', 'mayosis' ),
        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'radio-buttonset',
        'settings'    => 'product_grid_options',
        'label'       => __( 'Product Grid Options', 'mayosis' ),
        'section'     => 'product_options',
        'default'     => 'one',
        'priority'    => 10,
        'choices'     => array(
            'one'   => esc_attr__( 'With Meta', 'mayosis' ),
            'two' => esc_attr__( 'Without Meta', 'mayosis' ),
        ),
        'required'    => array(
            array(
                'setting'  => 'product_grid_system',
                'operator' => '==',
                'value'    => 'one',
            ),

        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
    
    'type'        => 'color',
        'settings'     => 'product_grid_bg_color',
        'label'       => __( 'Product Grid Background', 'mayosis' ),
        'description' => __( 'Set Grid Background', 'mayosis' ),
        'section'     => 'product_options',
        'priority'    => 10,
        'default'     => 'rgba(255,255,255,0)',
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

        'required'    => array(
            array(
                'setting'  => 'product_grid_system',
                'operator' => '==',
                'value'    => 'one',
            ),

        ),
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'product_grid_txt_color',
        'label'       => __( 'Product Grid Text', 'mayosis' ),
        'description' => __( 'Set Thumbnail Hover Background', 'mayosis' ),
        'section'     => 'product_options',
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

        'required'    => array(
            array(
                'setting'  => 'product_grid_system',
                'operator' => '==',
                'value'    => 'one',
            ),

        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'padding_type_grid',
        'label'       => __( 'Grid Padding On', 'mayosis' ),
        'section'     => 'product_options',
        'default'     => 'meta',
        'priority'    => 10,
        'choices'     => array(
            'full'   => esc_attr__( 'Full Box', 'mayosis' ),
            'meta' => esc_attr__( 'Meta', 'mayosis' ),
        ),

        'required'    => array(
            array(
                'setting'  => 'product_grid_system',
                'operator' => '==',
                'value'    => 'one',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'dimensions',
        'settings'    => 'prod_grid_padding',
        'label'       => esc_attr__( 'Grid Padding', 'mayosis' ),
        'description' => esc_attr__( 'Add padding on product grid', 'mayosis' ),
        'section'     => 'product_options',
        'default'     => array(
            'padding-top'    => '0px',
            'padding-bottom' => '0px',
            'padding-left'   => '0px',
            'padding-right'  => '0px',
        ),

        'required'    => array(
            array(
                'setting'  => 'product_grid_system',
                'operator' => '==',
                'value'    => 'one',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'select',
        'settings'    => 'product_masonry_column',
        'label'       => __( 'Product Masonry Column', 'mayosis' ),
        'section'     => 'product_options',
        'default'     => 3,
        'priority'    => 10,
        'choices'     => array(
            '2'   => esc_attr__( 'Two Column', 'mayosis' ),
            '3' => esc_attr__( 'Three Column', 'mayosis' ),
            '4' => esc_attr__( 'Four Column', 'mayosis' ),
            '5' => esc_attr__( 'Five Column', 'mayosis' ),
        ),
        'required'    => array(
            array(
                'setting'  => 'product_grid_system',
                'operator' => '==',
                'value'    => 'two',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'select',
        'settings'    => 'product_masonry_title_hover',
        'label'       => __( 'Product Masonry Title Hover', 'mayosis' ),
        'section'     => 'product_options',
        'default'     => 1,
        'priority'    => 10,
        'choices'     => array(
            '1'   => esc_attr__( 'Show', 'mayosis' ),
            '2' => esc_attr__( 'Hide', 'mayosis' ),
            
        ),
        'required'    => array(
            array(
                'setting'  => 'product_grid_system',
                'operator' => '==',
                'value'    => 'two',
            ),

        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'slider',
        'settings'    => 'grid_border_radius',
        'label'       => esc_attr__( 'Change Grid Border Radius', 'mayosis' ),
        'section'     => 'product_options',
        'default'     => 3,
        'choices'     => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 1,
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'select',
        'settings'    => 'product_box_shadow',
        'label'       => __( 'Product Box Shadow', 'mayosis' ),
        'section'     => 'product_options',
        'default'     => 'none',
        'priority'    => 10,
        'choices'     => array(
            'none'   => esc_attr__( 'None', 'mayosis' ),
            'box' => esc_attr__( 'Shadow in Whole Box', 'mayosis' ),
            'hover' => esc_attr__( 'Shadow on Hover', 'mayosis' ),
        ),
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'product_shadow_color',
        'label'       => __( 'Box Shadow Color', 'mayosis' ),
        'description' => __( 'Set Box Shadow Color', 'mayosis' ),
        'section'     => 'product_options',
        'priority'    => 10,
        'default'     => 'rgba(40, 55,90, .15)',
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
    'type'        => 'select',
        'settings'    => 'product_grid_image_size',
        'label'       => __( 'Product Grid Image size', 'mayosis' ),
        'section'     => 'product_options',
        'default'     => 'full',
        'priority'    => 10,
        'choices'     => array(
            'full'   => esc_attr__( 'Full', 'mayosis' ),
            'custom' => esc_attr__( 'Custom', 'mayosis' ),
        ),
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'text',
        'settings'    => 'product_grid_image_width',
        'label'       => __( 'Custom Width', 'mayosis' ),
        'section'     => 'product_options',
        'default'     => '525',
        'priority'    => 10,
         'required'    => array(
            array(
                'setting'  => 'product_grid_image_size',
                'operator' => '==',
                'value'    => 'custom',
            ),

        ),
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'text',
        'settings'    => 'product_grid_image_height',
        'label'       => __( 'Custom Height', 'mayosis' ),
        'section'     => 'product_options',
        'default'     => '256',
        'priority'    => 10,
         'required'    => array(
            array(
                'setting'  => 'product_grid_image_size',
                'operator' => '==',
                'value'    => 'custom',
            ),

        ),
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'     => 'text',
        'settings' => 'recent_ribbon_text',
        'label'    => __( 'Recent Product Ribbon Text', 'mayosis' ),
        'section'  => 'grid_ribbon',
        'default'  => esc_attr__( 'New', 'mayosis' ),
        'priority' => 10,
        'required'    => array(
            array(
                'setting'  => 'product_grid_system',
                'operator' => '==',
                'value'    => 'one',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'     => 'text',
        'settings' => 'recent_ribbon_time',
        'label'    => __( 'Recent Product Ribbon Time (in days)', 'mayosis' ),
        'section'  => 'grid_ribbon',
        'default'  => esc_attr__( '30', 'mayosis' ),
        'priority' => 10,
        'required'    => array(
            array(
                'setting'  => 'product_grid_system',
                'operator' => '==',
                'value'    => 'one',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'     => 'text',
        'settings' => 'featured_ribbon_text',
        'label'    => __( 'Featured Product Ribbon Text', 'mayosis' ),
        'section'  => 'grid_ribbon',
        'default'  => esc_attr__( 'FEATURED', 'mayosis' ),
        'priority' => 10,
        'required'    => array(
            array(
                'setting'  => 'product_grid_system',
                'operator' => '==',
                'value'    => 'one',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'     => 'text',
        'settings' => 'featured_ribbon_time',
        'label'    => __( 'Featured Product Ribbon Time (in days)', 'mayosis' ),
        'section'  => 'grid_ribbon',
        'default'  => esc_attr__( '30', 'mayosis' ),
        'priority' => 10,
        'required'    => array(
            array(
                'setting'  => 'product_grid_system',
                'operator' => '==',
                'value'    => 'one',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'select',
        'settings'    => 'product_thmub_hover_style',
        'label'       => __( 'Thumb Hover Style', 'mayosis' ),
        'section'     => 'grid_meta',
        'default'     => 'style1',
        'priority'    => 10,
        'choices'     => array(
            'style1'   => esc_attr__( 'Style One', 'mayosis' ),
            'style2' => esc_attr__( 'Style Two', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'select',
        'settings'    => 'product_hover_top',
        'label'       => __( 'Hover Top Elements', 'mayosis' ),
        'section'     => 'grid_meta',
        'default'     => 'cart',
        'priority'    => 10,
        'choices'     => array(
            'none'   => esc_attr__( 'None', 'mayosis' ),
            'cart' => esc_attr__( 'Add to Cart', 'mayosis' ),
            'share' => esc_attr__( 'Share', 'mayosis' ),
            'sales' => esc_attr__( 'Sales and Download', 'mayosis' ),
        ),
        'required'    => array(
            array(
                'setting'  => 'product_thmub_hover_style',
                'operator' => '==',
                'value'    => 'style1',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
      'type'        => 'select',
        'settings'    => 'product_hover_bottom',
        'label'       => __( 'Hover Bottom Elements', 'mayosis' ),
        'section'     => 'grid_meta',
        'default'     => 'share',
        'priority'    => 10,
        'choices'     => array(
            'none'   => esc_attr__( 'None', 'mayosis' ),
            'cart' => esc_attr__( 'Add to Cart', 'mayosis' ),
            'share' => esc_attr__( 'Share', 'mayosis' ),
            'sales' => esc_attr__( 'Sales and Download', 'mayosis' ),
        ),
        
        'required'    => array(
            array(
                'setting'  => 'product_thmub_hover_style',
                'operator' => '==',
                'value'    => 'style1',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'select',
        'settings'    => 'product_meta_options',
        'label'       => __( 'Meta Options', 'mayosis' ),
        'section'     => 'grid_meta',
        'default'     => 'vendorcat',
        'priority'    => 10,
        'choices'     => array(
            'none'   => esc_attr__( 'None', 'mayosis' ),
            'vendor' => esc_attr__( 'Vendor', 'mayosis' ),
            'category' => esc_attr__( 'Category', 'mayosis' ),
            'vendorcat' => esc_attr__( 'Vendor and Category', 'mayosis' ),
            'sales' => esc_attr__( 'Sales and Download', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'product_pricing_options',
        'label'       => __( 'Pricing Options', 'mayosis' ),
        'section'     => 'grid_meta',
        'default'     => 'price',
        'priority'    => 10,
        'choices'     => array(
            'none'   => esc_attr__( 'None', 'mayosis' ),
            'price' => esc_attr__( 'Price', 'mayosis' ),
        ),
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'radio-buttonset',
        'settings'    => 'product_free_options',
        'label'       => __( 'Free Pricing Options', 'mayosis' ),
        'section'     => 'grid_meta',
        'default'     => 'custom',
        'priority'    => 10,
        'choices'     => array(
            'none'   => esc_attr__( '$0.00', 'mayosis' ),
            'custom' => esc_attr__( 'Custom Text', 'mayosis' ),
        ),
        'required'    => array(
            array(
                'setting'  => 'product_pricing_options',
                'operator' => '==',
                'value'    => 'price',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'     => 'text',
        'settings' => 'free_text',
        'label'    => __( 'Custom Text', 'mayosis' ),
        'section'  => 'grid_meta',
        'default'  => esc_attr__( 'FREE', 'mayosis' ),
        'priority' => 10,
        'required'    => array(
            array(
                'setting'  => 'product_free_options',
                'operator' => '==',
                'value'    => 'custom',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'radio-buttonset',
        'settings'    => 'variable_pricing_options',
        'label'       => __( 'Variable Pricing Options', 'mayosis' ),
        'section'     => 'grid_meta',
        'default'     => 'default',
        'priority'    => 10,
        'choices'     => array(
            'default'   => esc_attr__( 'Default', 'mayosis' ),
            'popup' => esc_attr__( 'Popup', 'mayosis' ),
        ),
    
) );

//Start product video
Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'title_play_button',
        'label'       => __( 'Title Play Button', 'mayosis' ),
        'description'       => __( '', 'mayosis' ),
        'section'     => 'product_video',
        'default'     => 'show',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'thumbnail_video_play',
        'label'       => __( 'Thumbnail Video', 'mayosis' ),
        'description'       => __( '', 'mayosis' ),
        'section'     => 'product_video',
        'default'     => 'show',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'thumbnail_video_poster',
        'label'       => __( 'Thumbnail Video Poster', 'mayosis' ),
        'description'       => __( '', 'mayosis' ),
        'section'     => 'product_video',
        'default'     => 'show',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'thumb_video_control',
        'label'       => __( 'Thumbnail Video Contol', 'mayosis' ),
        'description'       => __( '', 'mayosis' ),
        'section'     => 'product_video',
        'default'     => 'full',
        'priority'    => 10,
        'choices'     => array(
            'full'   => esc_attr__( 'Full', 'mayosis' ),
            'minimal' => esc_attr__( 'Minimal (Cart)', 'mayosis' ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'thumb_cart_button',
        'label'       => __( 'Thumbnail Cart Button', 'mayosis' ),
        'description'       => __( '', 'mayosis' ),
        'section'     => 'product_video',
        'default'     => 'hide',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

//End product video
Mayosis_Option::add_field( 'mayo_config', array(
        'type'     => 'text',
        'settings' => 'live_preview_text',
        'label'    => __( 'Live Preview Text', 'mayosis' ),
        'section'  => 'product_more',
        'default'  => esc_attr__( 'Live Preview', 'mayosis' ),
        'priority' => 10,
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'select',
        'settings'    => 'product_bottom_buttons',
        'label'       => __( 'Product Bottom Buttons', 'mayosis' ),
        'section'     => 'product_more',
        'default'     => 'show',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );



Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'select',
        'settings'    => 'product_bottom_extratext',
        'label'       => __( 'Product Bottom Buttons Text & Count', 'mayosis' ),
        'section'     => 'product_more',
        'default'     => 'show',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'select',
        'settings'    => 'product_bottom_social_share',
        'label'       => __( 'Product Bottom Social Share', 'mayosis' ),
        'section'     => 'product_more',
        'default'     => 'show',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'select',
        'settings'    => 'product_bottom_tags',
        'label'       => __( 'Product Tags', 'mayosis' ),
        'section'     => 'product_more',
        'default'     => 'hide',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'product_gallery_type',
        'label'       => __( 'Product Gallery Layout Type', 'mayosis' ),
        'section'     => 'product_more',
        'default'     => 'one',
        'priority'    => 10,
        'choices'     => array(
            'one'   => esc_attr__( 'Bottom Thumb', 'mayosis' ),
            'two' => esc_attr__( 'Side Thumb', 'mayosis' ),
            'three' => esc_attr__( 'Without Thumb', 'mayosis' ),
            'four' => esc_attr__( 'Carousel', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'select',
        'settings'    => 'site_product_type',
        'label'       => __( 'Easy Digital Download Product Type', 'mayosis' ),
        'section'     => 'product_more',
        'default'     => 'default',
        'priority'    => 10,
        'choices'     => array(
            'default'   => esc_attr__( 'Default', 'mayosis' ),
            'products' => esc_attr__( 'Products', 'mayosis' ),
            'items' => esc_attr__( 'Items', 'mayosis' ),
            'music' => esc_attr__( 'Music', 'mayosis' ),
            'video' => esc_attr__( 'Video', 'mayosis' ),
            'photo' => esc_attr__( 'Photo', 'mayosis' ),
        ),
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'sortable',
        'settings'    => 'product_information_widget_manager',
        'label'       => __( 'Product Information Widget Layout', 'mayosis' ),
        'section'     => 'product_information_widget',
        'default'     => array(
            'price',
            'released',
            'updated',
            'fileincluded',
            'filesize',
            'compatible',
            'version',
        ),
        'choices'     => array(
            'price' => esc_attr__( 'Price', 'mayosis' ),
            'released' => esc_attr__( 'Release Date', 'mayosis' ),
            'updated' => esc_attr__( 'Last Update', 'mayosis' ),
            'version' => esc_attr__( 'Version', 'mayosis' ),
            'fileincluded' => esc_attr__( 'File Included', 'mayosis' ),
            'filesize' => esc_attr__( 'File Size', 'mayosis' ),
            'compatible' => esc_attr__( 'Compatible', 'mayosis' ),
            'documentation' => esc_attr__( 'Documentation', 'mayosis' ),
            'sales' => esc_attr__( 'Sales', 'mayosis' ),
            'category' => esc_attr__( 'Category', 'mayosis' ),

        ),
) );
