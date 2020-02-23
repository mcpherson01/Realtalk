<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna gallery element map
* ------------------------------------------------------------------------------------------------
*/

if ( !function_exists('urna_vc_map_tbay_features') ) {
	function urna_vc_map_tbay_features() {
		$params = array(
        	array(
				"type" => "textfield",
				"holder" => "div",
				"heading" => esc_html__('Title', 'urna'),
				"param_name" => "title",
				"admin_label" => true,
				"value" => '',
			),
			array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__( 'Sub Title','urna' ),
                "param_name" => "subtitle",
                "admin_label" => true
            ),
			array(
				'type' => 'param_group',
				'heading' => esc_html__('Members Settings', 'urna' ),
				'param_name' => 'items',
				'description' => '',
				'value' => '',
				'params' => array(
					array(
		                "type" => "textfield",
		                "holder" => "div",
		                "class" => "",
		                "heading" => esc_html__('Title','urna'),
		                "param_name" => "title",
		            ),
		            array(
		                "type" => "textarea",
		                "class" => "",
		                "heading" => esc_html__('Description','urna'),
		                "param_name" => "description",
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
						'admin_label' => true,
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
						'value' => 'icon-home',
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
						"type" => "attach_image",
						"description" => esc_html__('If you upload an image, icon will not show.', 'urna'),
						"param_name" => "image",
						"value" => '',
						'heading'	=> esc_html__('Image', 'urna' )
					),
				),
			),
			array(	
				"type" => "dropdown",
				"heading" => esc_html__('Layout Type', 'urna'),
				"param_name" => "layout_type",
				'value' 	=> array(
					esc_html__('Style 1', 'urna') => '', 
					esc_html__('Style 2', 'urna') => 'style-2',
					esc_html__('Style 3', 'urna') => 'style-3'
				)
			),
        );
	
		$responsive     = apply_filters( 'urna_vc_map_param_responsive', array() );  
		$last_params 	= apply_filters( 'urna_vc_map_param_last_params', array() );
		$params 		= array_merge($params, $responsive, $last_params); 

		vc_map( array(
            "name" => esc_html__('Urna Features','urna'),
            "base" => "tbay_features",
            "icon" => "vc-icon-urna",
            'description'=> esc_html__('Display Features In FrontEnd', 'urna'),
            "class" => "",
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params,
        ));
	}
	add_action( 'vc_before_init', 'urna_vc_map_tbay_features' );
}

if( class_exists( 'WPBakeryShortCode' ) ){
    class WPBakeryShortCode_tbay_features extends WPBakeryShortCode {}
}