<?php
if(!class_exists('Vc_Manager')) return;

if ( !function_exists('urna_tbay_load_private_woocommerce_element')) {
	function urna_tbay_load_private_woocommerce_element() {
        $columns = apply_filters( 'urna_admin_visualcomposer_columns', array(1,2,3,4,5,6) );
        $rows    = apply_filters( 'urna_admin_visualcomposer_rows', array(1,2,3) );


        $attributes_instagram = array(
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__( 'Add Custom link?', 'urna' ),
                "description"   => esc_html__( 'Show/hidden Shop Now in each category', 'urna' ),
                "param_name"    => "custom_link",
                'weight'        => 1,
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                'type'          => 'vc_link',
                'group'         => esc_html__( 'Custom link', 'urna' ),
                'heading'       => esc_html__( 'Custom link', 'urna' ),
                'param_name'    => 'link',
                'dependency'    => array(
                    'element'   => 'custom_link',
                    'value'     => array (
                        'yes',
                    ),
                ),
                'description'   => esc_html__( 'Add custom link.', 'urna' ),
            ),  
        );

        vc_add_params( 'tbay_instagram',  $attributes_instagram);

        $attributes_image_list_categories = array(
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__( 'Display Shop Now?', 'urna' ),
                "description"   => esc_html__( 'Show/hidden Shop Now in each category', 'urna' ),
                "param_name"    => "shop_now",
                'weight' => 2,
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                "type"      => "textfield",
                "heading"   => esc_html__('Text Button Shop Now', 'urna'),
                "param_name" => "shop_now_text",
                "value"     => '',
                'weight' => 1,
                'std'       => esc_html__('Shop Now', 'urna'),
                'dependency'    => array(
                        'element'   => 'shop_now',
                        'value'     => array (
                            'yes',
                        ),
                ),

            )
        );

        vc_add_params( 'tbay_custom_image_list_categories',  $attributes_image_list_categories);        

	}
}

add_action( 'vc_after_set_mode', 'urna_tbay_load_private_woocommerce_element', 98 );