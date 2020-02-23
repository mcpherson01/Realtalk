<?php
Mayosis_Option::add_panel( 'mayosis_other_template', array(
	'title'       => __( 'Other Template', 'mayosis' ),
	'description' => __( 'Mayosis Other Template', 'mayosis' ),
	'priority' => '9',
) );

Mayosis_Option::add_section( 'blog_template', array(
	'title'       => __( 'Blog Template', 'mayosis' ),
	'panel'       => 'mayosis_other_template',

) );

Mayosis_Option::add_section( 'page_template', array(
	'title'       => __( 'Page Template', 'mayosis' ),
	'panel'       => 'mayosis_other_template',

) );

Mayosis_Option::add_section( 'dashboard_template', array(
	'title'       => __( 'Dashboard Template', 'mayosis' ),
	'panel'       => 'mayosis_other_template',

) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'typography',
        'settings'    => 'post_content_font_family',
        'label'       => esc_attr__( 'Post Content Typography', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => array(
            'font-family'    => '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif',
            'variant'        => '400',
            'font-size'      => '1.125rem',
            'line-height'    => '1.75',
            'letter-spacing'    => '0',


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
                'element' => '.single-post-block,.single-post-block p',
            ),
        ),
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'blog_featured_visibility',
        'label'       => __( 'Blog Featured Image Visibility', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => 'show',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'featured_position_blog',
        'label'       => __( 'Blog Featured Image Position', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => 'left',
        'priority'    => 10,
        'choices'     => array(
            'left'   => esc_attr__( 'Left', 'mayosis' ),
            'right' => esc_attr__( 'Right', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'select',
        'settings'    => 'blog_header_content_position',
        'label'       => __( 'Blog Header Content Position', 'mayosis' ),
        'section'     => 'blog_template',
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
        'settings'    => 'blog_bg_type',
        'label'       => __( 'Blog Breadcrumb Background Type', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => 'gradient',
        'priority'    => 10,
        'choices'     => array(
            'color'  => esc_attr__( 'Color', 'mayosis' ),
            'gradient' => esc_attr__( 'Gradient', 'mayosis' ),
            'image' => esc_attr__( 'Image', 'mayosis' ),
            'featured' => esc_attr__( 'Featured Image', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'color',
        'settings'     => 'blog_background',
        'label'       => __( 'Breadcrumb Background Color', 'mayosis' ),
        'description' => __( 'Set Breadcrumb Background color', 'mayosis' ),
        'section'     => 'blog_template',
        'priority'    => 10,
        'default'     => '#282837',
        'required'    => array(
            array(
                'setting'  => 'blog_bg_type',
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
        'settings'    => 'blog_gradient',
        'label'       => esc_attr__( 'Breadcrumb gradient', 'mayosis' ),
        'section'     => 'blog_template',
        'priority'    => 10,
        'required'    => array(
            array(
                'setting'  => 'blog_bg_type',
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
        'settings'    => 'blog_bg_image',
        'label'       => esc_attr__( 'Breadcrumb Background Image', 'mayosis' ),
        'description' => esc_attr__( 'Upload Product/Blog background image', 'mayosis' ),
        'section'     => 'blog_template',
        'required'    => array(
            array(
                'setting'  => 'blog_bg_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'blog_bg_image_repeat',
        'label'       => __( 'Image Repeat', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => 'repeat',
        'priority'    => 10,
        'choices'     => array(
            'repeat'  => esc_attr__( 'Repeat', 'mayosis' ),
            'cover' => esc_attr__( 'Cover', 'mayosis' ),

        ),
        'required'    => array(
            array(
                'setting'  => 'blog_bg_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'     => 'text',
        'settings' => 'main_blog_blur',
        'label'    => __( 'Blur Radius', 'mayosis' ),
        'section'  => 'blog_template',
        'default'  => esc_attr__( '5px', 'mayosis' ),
        'priority' => 10,
        'required'    => array(
            array(
                'setting'  => 'blog_bg_type',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'color',
        'settings'     => 'blog_ovarlay_main',
        'label'       => __( 'Overlay Color', 'mayosis' ),
        'description' => __( 'Change  Overlay Color', 'mayosis' ),
        'section'     => 'blog_template',
        'priority'    => 10,
        'default'     => 'rgb(40,40,50,.5)',
        'choices'     => array(
            'alpha' => true,
        ),

        'required'    => array(
            array(
                'setting'  => 'blog_bg_type',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'parallax_featured_image_blog',
        'label'       => __( 'Featured Image Parallax', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => 'no',
        'priority'    => 10,
        'choices'     => array(
            'yes'   => esc_attr__( 'Yes', 'mayosis' ),
            'no' => esc_attr__( 'No', 'mayosis' ),
        ),

        'required'    => array(
            array(
                'setting'  => 'blog_bg_type',
                'operator' => '==',
                'value'    => 'featured',
            ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'image',
        'settings'    => 'blog_overlay_image',
        'label'       => esc_attr__( 'Blog Overlay Image', 'mayosis' ),
        'description' => esc_attr__( 'Upload product background image', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => '',
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'sortable',
        'settings'    => 'blog_content_layout_manager',
        'label'       => __( 'Blog Content Layout Manager', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => array(
            'breadcrumb',
            'title',
            'category',
            'date',
        ),
        'choices'     => array(
            'breadcrumb' => esc_attr__( 'Breadcrumb', 'mayosis' ),
            'title' => esc_attr__( 'Title', 'mayosis' ),
            'author' => esc_attr__( 'Author', 'mayosis' ),
            'category' => esc_attr__( 'Category', 'mayosis' ),
            'date' => esc_attr__( 'Date', 'mayosis' ),
        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'radio-buttonset',
        'settings'    => 'author_single_post',
        'label'       => __( 'Blog Author Box In Single Post', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => 'hide',
        'priority'    => 10,
        'choices'     => array(
            'on'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'blog_sidebar_remove',
        'label'       => __( 'Blog Sidebar Hide', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => 'on',
        'priority'    => 10,
        'choices'     => array(
            'on'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'blog_bottom_widget',
        'label'       => __( 'Related Post & Products', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => 'on',
        'priority'    => 10,
        'choices'     => array(
            'on'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'blog_comment_size',
        'label'       => __( 'Blog Comment', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => 'two',
        'priority'    => 10,
        'choices'     => array(
            'one'   => esc_attr__( 'Full Width', 'mayosis' ),
            'two' => esc_attr__( 'With Sidebar', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
         'type'        => 'radio-buttonset',
        'settings'    => 'blog_archive_post_style',
        'label'       => __( 'Blog Archive Post Style', 'mayosis' ),
        'section'     => 'blog_template',
        'default'     => 'both',
        'priority'    => 10,
        'choices'     => array(
            'list'   => esc_attr__( 'List', 'mayosis' ),
            'grid' => esc_attr__( 'Grid', 'mayosis' ),
            'both' => esc_attr__( 'Both', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'select',
        'settings'    => 'page_bredcrumb_content_position',
        'label'       => __( 'Page Bredcrumb Content Position', 'mayosis' ),
        'section'     => 'page_template',
        'default'     => 'center',
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => array(
            'left' => esc_attr__( 'Left', 'mayosis' ),
            'center' => esc_attr__( 'Center', 'mayosis' ),
            'right' => esc_attr__( 'Right', 'mayosis' ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'image',
        'settings'    => 'page_overlay_image',
        'label'       => esc_attr__( 'Page Breadcrumb Overlay Image', 'mayosis' ),
        'description' => esc_attr__( 'Upload page overlay image', 'mayosis' ),
        'section'     => 'page_template',
        'default'     => '',
    
) );

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'image',
	'settings'     => 'login_page_logo',
	'label'       => __( 'Dasboard Login Logo', 'mayosis' ),
	'description' => __( 'Upload 2X Logo for retina & use size from below.', 'mayosis' ),
	'section'     => 'dashboard_template',
	'default'     => get_template_directory_uri().'/images/logo.png',
	'transport' => 'auto',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'        => 'image',
	'settings'     => 'dash_inner_logo',
	'label'       => __( 'Dasboard Inner Logo', 'mayosis' ),
	'description' => __( 'Upload 2X Logo for retina & use size from below.', 'mayosis' ),
	'section'     => 'dashboard_template',
	'default'     => get_template_directory_uri().'/images/logo.png',
	'transport' => 'auto',
));
