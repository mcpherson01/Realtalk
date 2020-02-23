<?php
Mayosis_Option::add_panel( 'mayosis_footer', array(
	'title'       => __( 'Footer', 'mayosis' ),
	'description' => __( 'Mayosis Footer Options.', 'mayosis' ),
	'priority' => '6',
) );

Mayosis_Option::add_section( 'main_footer', array(
	'title'       => __( 'Footer Options', 'mayosis' ),
	'panel'       => 'mayosis_footer',

) );

Mayosis_Option::add_section( 'footer_copyright', array(
	'title'       => __( 'Copyright Footer', 'mayosis' ),
	'panel'       => 'mayosis_footer',

) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'text',
        'settings'    => 'footer_container_width',
        'label'       => __( 'Footer Container Width', 'mayosis' ),
        'description' => _('change the base container width start from 1600px.'),
        'section'     => 'main_footer',
        'default'     => '1170px',
        'priority'    => 10,
        
    
) );
Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'footer_widget_hide',
        'label'       => __( 'Footer Widget', 'mayosis' ),
        'section'     => 'main_footer',
        'default'     => 'on',
        'priority'    => 10,
        'choices'     => array(
            'on'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'radio-buttonset',
        'settings'    => 'footer_widget_column',
        'label'       => __( 'Footer Widget Column', 'mayosis' ),
        'section'     => 'main_footer',
        'default'     => 'four',
        'priority'    => 10,
        'choices'     => array(
            'one'   => esc_attr__( 'One', 'mayosis' ),
            'two' => esc_attr__( 'Two', 'mayosis' ),
            'three' => esc_attr__( 'Three', 'mayosis' ),
            'four' => esc_attr__( 'Four', 'mayosis' ),
            'five' => esc_attr__( 'Five', 'mayosis' ),
            'six' => esc_attr__( 'Six', 'mayosis' ),
        ),

        'required'    => array(
            array(
                'setting'  => 'footer_widget_hide',
                'operator' => '==',
                'value'    => 'on',
            ),

        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
       'type'        => 'text',
        'settings'    => 'column_one_width',
        'label'       => esc_attr__( 'Column One Width', 'mayosis' ),
        'description' => esc_attr__( 'Add Column One Width on % (Without %)', 'mayosis' ),
        'section'     => 'main_footer',
        'default'     => '25',
        'output'      => array(
            array(
                'element'  => '.footer-widget.mx-one',
                'property' => 'width',
                'units' =>'%',
            ),
        ),
        'required'    => array(
            array(
                'setting'  => 'footer_widget_hide',
                'operator' => '==',
                'value'    => 'on',
            ),

        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
    
        'type'        => 'text',
        'settings'    => 'column_two_width',
        'label'       => esc_attr__( 'Column Two Width', 'mayosis' ),
        'description' => esc_attr__( 'Add Column Two Width on % (Without %)', 'mayosis' ),
        'section'     => 'main_footer',
        'default'     => '25',
        'output'      => array(
            array(
                'element'  => '.footer-widget.mx-two',
                'property' => 'width',
                'units' =>'%',
            ),
        ),
        'required'    => array(
            array(
                'setting'  => 'footer_widget_hide',
                'operator' => '==',
                'value'    => 'on',
            ),

        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'text',
        'settings'    => 'column_three_width',
        'label'       => esc_attr__( 'Column Three Width', 'mayosis' ),
        'description' => esc_attr__( 'Add Column Three Width on % (Without %)', 'mayosis' ),
        'section'     => 'main_footer',
        'default'     => '25',
        'output'      => array(
            array(
                'element'  => '.footer-widget.mx-three',
                'property' => 'width',
                'units' =>'%',
            ),
        ),
        'required'    => array(
            array(
                'setting'  => 'footer_widget_hide',
                'operator' => '==',
                'value'    => 'on',
            ),

        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'text',
        'settings'    => 'column_four_width',
        'label'       => esc_attr__( 'Column Four Width', 'mayosis' ),
        'description' => esc_attr__( 'Add Column Four Width on % (Without %)' , 'mayosis' ),
        'section'     => 'main_footer',
        'default'     => '25',
        'output'      => array(
            array(
                'element'  => '.footer-widget.mx-four',
                'property' => 'width',
                'units' =>'%',
            ),
        ),
        'required'    => array(
            array(
                'setting'  => 'footer_widget_hide',
                'operator' => '==',
                'value'    => 'on',
            ),

        ),

    
) );


Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'text',
        'settings'    => 'column_five_width',
        'label'       => esc_attr__( 'Column Five Width', 'mayosis' ),
        'description' => esc_attr__( 'Add Column Five Width on % (Without %)', 'mayosis' ),
        'section'     => 'main_footer',
        'default'     => '15',
        'output'      => array(
            array(
                'element'  => '.footer-widget.mx-five',
                'property' => 'width',
                'units' =>'%',
            ),
        ),
        'required'    => array(
            array(
                'setting'  => 'footer_widget_hide',
                'operator' => '==',
                'value'    => 'on',
            ),

        ),

    
) );


Mayosis_Option::add_field( 'mayo_config', array(
     'type'        => 'text',
        'settings'    => 'column_six_width',
        'label'       => esc_attr__( 'Column Six Width', 'mayosis' ),
        'description' => esc_attr__( 'Add Column Six Width on %(Without %)', 'mayosis' ),
        'section'     => 'main_footer',
        'default'     => '15',
        'output'      => array(
            array(
                'element'  => '.footer-widget.mx-six',
                'property' => 'width',
                'units' =>'%',
            ),
        ),
        'required'    => array(
            array(
                'setting'  => 'footer_widget_hide',
                'operator' => '==',
                'value'    => 'on',
            ),

        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
    
       'type'        => 'radio-buttonset',
        'settings'    => 'footer_additonal_widget',
        'label'       => __( 'Footer Additional Widget', 'mayosis' ),
        'section'     => 'main_footer',
        'default'     => 'hide',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),

        ),
        'required'    => array(
            array(
                'setting'  => 'footer_widget_hide',
                'operator' => '==',
                'value'    => 'on',
            ),

        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    
       'type'        => 'dimensions',
        'settings'    => 'main_footerr_padding',
        'label'       => esc_attr__( 'Footer Padding', 'mayosis' ),
        'description' => esc_attr__( 'Change Footer Padding', 'mayosis' ),
        'section'     => 'main_footer',
        'default'     => array(
            'padding-top'    => '80px',
            'padding-bottom' => '70px',
            'padding-left'   => '0px',
            'padding-right'  => '0px',
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'footer_back_to_top_hide',
        'label'       => __( 'Back to top', 'mayosis' ),
        'section'     => 'main_footer',
        'default'     => 'on',
        'priority'    => 10,
        'choices'     => array(
            'on'   => esc_attr__( 'Enable', 'mayosis' ),
            'hide' => esc_attr__( 'Disable', 'mayosis' ),
        ),
    
) );

Mayosis_Option::add_field( 'mayo_config', array(
    
    'type'        => 'radio-buttonset',
        'settings'    => 'copyright_footer',
        'label'       => __( 'Copyright Footer', 'mayosis' ),
        'section'     => 'footer_copyright',
        'default'     => 'show',
        'priority'    => 10,
        'choices'     => array(
            'show'   => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),

        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
    
    'type'        => 'radio-buttonset',
        'settings'    => 'copyright_type',
        'label'       => __( 'Copyright Type', 'mayosis' ),
        'section'     => 'footer_copyright',
        'default'     => 'single',
        'priority'    => 10,
        'choices'     => array(
            'single'   => esc_attr__( 'Single Copyright', 'mayosis' ),
            'columed' => esc_attr__( 'With Widget', 'mayosis' ),

        ),
    
) );


Mayosis_Option::add_field( 'mayo_config', array(
         'type'        => 'editor',
        'settings'    => 'copyright_text',
        'label'       => __( 'Copyright Text', 'mayosis' ),
        'section'     => 'footer_copyright',
        'default'     => esc_attr__( 'Copyright 2018 Mayosis Studio, All rights reserved!', 'mayosis' ),
        'priority'    => 20,
    
) );
