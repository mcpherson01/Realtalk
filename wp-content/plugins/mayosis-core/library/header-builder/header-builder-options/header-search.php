<?php

Mayosis_Option::add_section( 'header_search', array(
	'title'       => __( 'Search', 'mayosis' ),
	'panel'       => 'header',
) );


Mayosis_Option::add_field( '',
	array(
		'type'     => 'custom',
		'settings' => 'custom-title-search',
		'label'    => __( '', 'mayosis' ),
		'section'  => 'header_search',
		'default'  => '<div class="options-title">Search Icon Options</div>',
	)
);


Mayosis_Option::add_field( 'mayo_config',  array(
	                'type'        => 'radio-image',
                	'settings'    => 'search_style',
                	'label'       => esc_html__( 'Search Style', 'mayosis' ),
                	'section'     => 'header_search',
                	'default'     => 'one',
                	'priority'    => 10,
                	'choices'     => array(
                		'one'   => get_template_directory_uri() . '/images/search-style-1.png',
                		'two' => get_template_directory_uri() . '/images/search-style-2.png',
                	),
));



Mayosis_Option::add_field( 'mayo_config',  array(
    
                        'type'        => 'radio-buttonset',
                    	'settings'    => 'search_behaviour',
                    	'label'       => __( 'Search Beahviour', 'mayosis' ),
                    	'section'     => 'header_search',
                    	'default'     => 'dropdown',
                    	'priority'    => 10,
                    	'choices'     => array(
                    		'dropdown'   => esc_attr__( 'Dropdown', 'mayosis' ),
                    		'collapse' => esc_attr__( 'Collapse', 'mayosis' ),
                    		'fullscreen' => esc_attr__( 'Fullscreen Overlay', 'mayosis' ),
                    	),
                    	'required'    => array(
                        array(
                            'setting'  => 'search_style',
                            'operator' => '==',
                            'value'    => 'one',
                                ),
                            ),
    
    ));
    
    Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'dimension',
	'settings'    => 'header-search-border-radius',
	'label'       => esc_attr__( 'Search Form Border Radius (px)', 'mayosis' ),
	'section'     => 'header_search',
	'output'      => array(
            array(
                'element'  => '.stylish-input-group input.dm_search',
                'property' => 'border-radius',
            ),
            
        ),
	'default'     => '3px',
        ));
Mayosis_Option::add_field( '',
	array(
		'type'     => 'custom',
		'settings' => 'custom-title-search-two',
		'label'    => __( '', 'mayosis' ),
		'section'  => 'header_search',
		'default'  => '<div class="options-title">Search Form Options</div>',
	)
);

Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'dimension',
	'settings'    => 'header-search-form-width',
	'label'       => esc_attr__( 'Search Form Width (px or %)', 'mayosis' ),
	'section'     => 'header_search',
	'output'      => array(
            array(
                'element'  => '.header-search-form',
                'property' => 'width',
            ),
        ),
	'default'     => '360px',
        ));
        
        
Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'dimension',
	'settings'    => 'header-search-form-height',
	'label'       => esc_attr__( 'Search Form height (px)', 'mayosis' ),
	'section'     => 'header_search',
	'output'      => array(
            array(
                'element'  => '.header-search-form input[type=search], .header-search-form input[type=text], .header-search-form select,.header-search-form .search-btn,
        .header-search-form .mayosel-select,.header-search-form .search-btn::after',
                'property' => 'height',
            ),
            
            array(
                'element'  => '.header-search-form input[type=search], .header-search-form input[type=text], .header-search-form select,.header-search-form .search-btn,
        .header-search-form .mayosel-select,.header-search-form .search-btn::after',
                'property' => 'max-height',
            ),
            
            array(
                'element'  => '.header-search-form .search-btn::after',
                'property' => 'line-height',
            ),
        ),
	'default'     => '40px',
        ));
        
Mayosis_Option::add_field( 'mayo_config',  array(
    
                        'type'        => 'radio-buttonset',
                    	'settings'    => 'search_form_style',
                    	'label'       => __( 'Search Form Style', 'mayosis' ),
                    	'section'     => 'header_search',
                    	'default'     => 'standard',
                    	'priority'    => 10,
                    	'choices'     => array(
                    		'standard'   => esc_attr__( 'Standard', 'mayosis' ),
                    		'ghost' => esc_attr__( 'Ghost', 'mayosis' ),
                    	),
    
    ));
    
    Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'ghost_border_color',
        'label'       => __( 'Ghost Search Border Color', 'mayosis' ),
        'description' => __( 'Change ghost search border color', 'mayosis' ),
        'section'     => 'header_search',
        'priority'    => 10,
        'default'     => 'rgba(40,55,90,0.25)',
        'output' => array(
            	array(
            		'element'  => '.header-ghost-form.header-search-form input[type="text"],.header-ghost-form.header-search-form .mayosel-select,.header-ghost-form.header-search-form select, .header-ghost-form.header-search-form .download_cat_filter',
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
));

 Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'ghost_text_color',
        'label'       => __( 'Ghost Search Text Color', 'mayosis' ),
        'description' => __( 'Change ghost search text color', 'mayosis' ),
        'section'     => 'header_search',
        'priority'    => 10,
        'default'     => 'rgba(40,55,90,1)',
        'output' => array(
            	array(
            		'element'  => '.header-ghost-form.header-search-form input[type="text"],.header-ghost-form.header-search-form .mayosel-select .current,.header-ghost-form.header-search-form select,.header-ghost-form.header-search-form .mayosel-select:after,.header-ghost-form.header-search-form .search-btn::after,.header-ghost-form.header-search-form input[type="text"]::placeholder',
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
));

  Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'dimension',
	'settings'    => 'header-seccond-border-radius',
	'label'       => esc_attr__( 'Search Form Border Radius (px)', 'mayosis' ),
	'section'     => 'header_search',
	'output'      => array(
            array(
                'element'  => '.header-ghost-form.header-search-form .mayosel-select,.header-ghost-form.header-search-form select',
                'property' => 'border-radius',
            ),
            
             array(
                'element'  => '.header-ghost-form.header-search-form input[type="text"]',
                'property' => 'border-top-right-radius',
            ),
            
            array(
                'element'  => '.header-ghost-form.header-search-form input[type="text"]',
                'property' => 'border-bottom-right-radius',
            ),
            
        ),
	'default'     => '3px',
        ));
        
        Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'text',
	'settings'    => 'search_form_placeholder_cs',
	'label'       => esc_attr__( 'Change Placeholder Text', 'mayosis' ),
	'description' => esc_attr__( '', 'mayosis' ),
	'section'     => 'header_search',
	'default'     => 'e.g. mockup',
    ));