<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna custom image list categories element map
* ------------------------------------------------------------------------------------------------
*/ 

if ( !function_exists('urna_vc_map_tbay_custom_image_list_categories') ) {
	function urna_vc_map_tbay_custom_image_list_categories() {

		$categories = urna_tbay_woocommerce_get_categories();

		$params = array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__('Title', 'urna'),
				"param_name" => "title",
				"value" =>''
			),
			array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__('Sub Title','urna'),
                "param_name" => "subtitle",
                "admin_label" => true
            ),
            array(
				'type' => 'param_group',
				'heading' => esc_html__( 'List Categories', 'urna' ),
				'param_name' => 'categoriestabs',
				'description' => '',
				'value' => '',
				'params' => array(
					array(
						"type" => "dropdown",
						"heading" => esc_html__( 'Category', 'urna' ),
						"param_name" => "category",
						"value" => $categories,
						"admin_label" => true,
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Icon library', 'urna' ),
						'value' => array(
							esc_html__( 'None Font Icon', 'urna' ) 		=> 'none',
							esc_html__( 'Font Awesome', 'urna' ) => 'fontawesome',
							esc_html__( 'Simple Line', 'urna' ) 	=> 'simpleline',
							esc_html__( 'Linear Icons', 'urna' ) 	=> 'linearicons',
							esc_html__( 'Material', 'urna' ) 		=> 'material',
						),
						'param_name' => 'type',
						'description' => esc_html__( 'Select icon library.', 'urna' ),
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'urna' ),
						'param_name' => 'icon_fontawesome',
						'value' => 'fa fa-adjust',
						// default value to backend editor admin_label
						'settings' => array(
							'emptyIcon' => false,
							// default true, display an "EMPTY" icon?
							'iconsPerPage' => 4000,
							// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
						),
						'dependency' => array(
							'element' => 'type',
							'value' => 'fontawesome',
						),
						'description' => esc_html__( 'Select icon from library.', 'urna' ),
					),									
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'urna' ),
						'param_name' => 'icon_simpleline',
						'value' => 'icon-user',
						// default value to backend editor admin_label
						'settings' => array(
							'emptyIcon' => false,
							// default true, display an "EMPTY" icon?
							'type' => 'simpleline',
							'iconsPerPage' => 100,
							// default 100, how many icons per/page to display
						),
						'dependency' => array(
							'element' => 'type',
							'value' => 'simpleline',
						),
						'description' => esc_html__( 'Select icon from library.', 'urna' ),
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'urna' ),
						'param_name' => 'icon_linearicons',
						'value' => 'linear-icon-home',
						// default value to backend editor admin_label
						'settings' => array(
							'emptyIcon' => false,
							// default true, display an "EMPTY" icon?
							'type' => 'linearicons',
							'iconsPerPage' => 100,
							// default 100, how many icons per/page to display
						),
						'dependency' => array(
							'element' => 'type',
							'value' => 'linearicons',
						),
						'description' => esc_html__( 'Select icon from library.', 'urna' ),
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'urna' ),
						'param_name' => 'icon_material',
						'value' => 'vc-material vc-material-cake',
						// default value to backend editor admin_label
						'settings' => array(
							'emptyIcon' => false,
							// default true, display an "EMPTY" icon?
							'type' => 'material',
							'iconsPerPage' => 4000,
							// default 100, how many icons per/page to display
						),
						'dependency' => array(
							'element' => 'type',
							'value' => 'material',
						),
						'description' => esc_html__( 'Select icon from library.', 'urna' ),
					),
					array( 
						'type' => 'attach_image',
						'heading' => esc_html__( 'Image', 'urna' ),
						'param_name' => 'images',
						'description' => esc_html__( 'In case of choosing both, the image will be prioritized', 'urna' ),
					),
					array(
						"type" 			=> "checkbox",
						"heading" 		=> esc_html__( 'Show custom link?', 'urna' ),
						"description" 	=> esc_html__( 'Show/hidden custom link', 'urna' ),
						"param_name" 	=> "check_custom_link",
						"value" 		=> array(
											esc_html__('Yes', 'urna') =>'yes' ),
					),	
					array(
						'type' 			=> 'textfield',
						'heading' 		=> esc_html__( 'Custom link', 'urna' ),
						'param_name' 	=> 'custom_link',
						'description' 	=> esc_html__( 'Select custom link.', 'urna' ),
						'dependency' 	=> array(
								'element' 	=> 'check_custom_link',
								'value' 	=> 'yes',
						),
					),
				)
			),
            array(
				"type" => "dropdown",
				"heading" => esc_html__('Layout Type','urna'),
				"param_name" => "layout_type",
				'std'       => 'grid',
                "value" => array(
                	esc_html__('Grid', 'urna') =>'grid',
        			esc_html__('Carousel', 'urna') => 'carousel', 
        		 ),
                "admin_label" => true,
			),
			array(
				"type" 			=> "checkbox",
				"heading" 		=> esc_html__( 'Show Count Items?', 'urna' ),
				"description" 	=> esc_html__( 'Show/hidden number items of category', 'urna' ),
				"param_name" 	=> "count_item",
				'std'       	=> 'yes',
                "value" 		=> array(
                		 			esc_html__('Yes', 'urna') =>'yes' ),
			),
            array(
				"type" 			=> "dropdown",
				"heading" 		=> esc_html__( 'Button Show', 'urna' ),
				"description" 	=> esc_html__( 'Show/hidden config button show', 'urna' ),
				"param_name" 	=> 'button_show_type',
                "value" 		=> array(
                					esc_html__('None', 'urna') => 'none', 
                					esc_html__('Show All', 'urna') => 'all'),
                'std'       	=> 'none',
			),
			array(
				"type" 		=> "textfield",
				"class" 	=> "",
				"heading" 	=> esc_html__('Text Button Show All', 'urna'),
				"param_name" => "show_all_text",
				"value" 	=> '',
				'std'       => esc_html__('Show All', 'urna'),
				'dependency' 	=> array(
						'element' 	=> 'button_show_type',
						'value' 	=> array (
							'all',
						),
				)
			),
	   	);


		$responsive     = apply_filters( 'urna_vc_map_param_responsive', array() );
		$carousel 		= apply_filters( 'urna_vc_map_param_carousel', array() );
		$last_params 	= apply_filters( 'urna_vc_map_param_last_params', array() );

		$params = array_merge($params, $carousel, $responsive, $last_params);

		vc_map( array(
			"name"     => esc_html__('Urna Custom Images List Categories','urna'),
			"base"     => "tbay_custom_image_list_categories",
			"icon" 	   	  => "vc-icon-urna",
			'description' => esc_html__( 'Show images and links of sub categories in block','urna' ),
			"class"    => "",
			"category" => esc_html__('Urna Woocommerce','urna'),
			"params"   => $params
		));
	}
	add_action( 'vc_before_init', 'urna_vc_map_tbay_custom_image_list_categories' );
}

if( class_exists( 'WPBakeryShortCode' ) ){
    class WPBakeryShortCode_tbay_custom_image_list_categories extends WPBakeryShortCode {}
}