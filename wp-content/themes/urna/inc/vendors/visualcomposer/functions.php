<?php


require get_template_directory() . '/inc/vendors/visualcomposer/custom-param-type/iconpicker.php';

/**
 * Custom parameters for visual composer
 */

if(!class_exists('Vc_Manager')) return;

define( 'URNA_VISUALCOMPOSER_ACTIVED', true );


/** 
* Param carousel
*/ 
if ( !function_exists('urna_vc_map_param_default_carousel')) {
    add_filter( 'urna_vc_map_param_carousel', 'urna_vc_map_param_default_carousel' );
    function urna_vc_map_param_default_carousel( $params = array() ) {
        $rows       = apply_filters( 'urna_admin_visualcomposer_rows', array(1,2,3) );
        $params = array( 
            array(
                "type"      => "dropdown",
                "heading"   => esc_html__('Rows','urna'),
                "group" => esc_html__( 'Carousel Settings', 'urna' ),
                "param_name" => 'rows',
                "value"     => $rows,
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__( 'Show Navigation?', 'urna' ),
                "group" => esc_html__( 'Carousel Settings', 'urna' ),
                "description"   => esc_html__( 'Show/hidden Navigation ', 'urna' ),
                "param_name"    => "nav_type",
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            ),                  
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__( 'Show Pagination?', 'urna' ),
                "group" => esc_html__( 'Carousel Settings', 'urna' ),
                "description"   => esc_html__( 'Show/hidden Pagination', 'urna' ),
                "param_name"    => "pagi_type",
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            ),

            array(
                "type"          => "checkbox",
                "heading"       => esc_html__( 'Loop Slider?', 'urna' ),
                "group" => esc_html__( 'Carousel Settings', 'urna' ),
                "description"   => esc_html__( 'Show/hidden Loop Slider', 'urna' ),
                "param_name"    => "loop_type",
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            ),                  
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__( 'Auto Slider?', 'urna' ),
                "group" => esc_html__( 'Carousel Settings', 'urna' ),
                "description"   => esc_html__( 'Show/hidden Auto Slider', 'urna' ),
                "param_name"    => "auto_type",
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            ),                  
            array(
                "type"          => "textfield",
                "heading"       => esc_html__( 'Auto Play Speed', 'urna' ),
                "group" => esc_html__( 'Carousel Settings', 'urna' ),
                "description"   => esc_html__( 'Auto Play Speed Slider', 'urna' ),
                "param_name"    => "autospeed_type",
                "value"         => '2000',
                'dependency'    => array(
                        'element'   => 'auto_type',
                        'value'     => array (
                            'yes',
                        ),
                ),
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__( 'Disable Carousel On Mobile', 'urna' ),
                "group" => esc_html__( 'Carousel Settings', 'urna' ),
                "description"   => esc_html__( 'To help load faster in mmobile', 'urna' ),
                "param_name"    => "disable_mobile",
                "std"           => "yes",
                "value"         => array( esc_html__('Yes', 'urna') =>'yes' ),
                'dependency'    => array(
                        'element'   => 'layout_type',
                        'value'     => 'carousel'
                ),
            )
        );

        return $params;
    }
}

/** 
* Param last params
*/ 
if ( !function_exists('urna_vc_map_param_default_last_params')) {
    add_filter( 'urna_vc_map_param_last_params', 'urna_vc_map_param_default_last_params' );
    function urna_vc_map_param_default_last_params( $params = array() ) {
        $params = array(
            vc_map_add_css_animation( true ),
            array(
                'type' => 'css_editor',
                'heading' => esc_html__( 'CSS box', 'urna' ),
                'param_name' => 'css',
                'group' => esc_html__( 'Design Options', 'urna' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Extra class name', 'urna' ),
                'param_name' => 'el_class',
                'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'urna' )
            )
        );

        return $params;
    }
}


/** 
* Params array responsive
*/  
if ( !function_exists('urna_vc_map_array_default_responsive')) {
    add_filter( 'urna_vc_map_array_responsive', 'urna_vc_map_array_default_responsive' );
    function urna_vc_map_array_default_responsive( $columns = '' ) { 

        $params = array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Columns','urna'),
                "description" => esc_html__('Column apply when the width is than 1600px','urna'),
                "param_name" => 'columns',
                "value" => $columns, 
                'std' => '4',
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__( 'Show config Responsive?', 'urna' ),
                "description"   => esc_html__( 'Show/hidden config Responsive', 'urna' ),
                "param_name"    => "responsive_type",
                "std"           => "yes",
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                "type"    => "dropdown",
                "heading" => esc_html__('Number of columns screen desktop','urna'),
                "description" => esc_html__('Column apply when the width is between 1200px and 1600px','urna'),
                "group" => esc_html__( 'Responsive Settings', 'urna' ),
                "param_name" => 'screen_desktop',
                "value" => $columns,
                'std'       => '4',
                'dependency'    => array(
                        'element'   => 'responsive_type',
                        'value'     => 'yes',
                ),
            ),                  
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Number of columns screen desktopsmall','urna'),
                "description" => esc_html__('Column apply when the width is between 992px and 1199px','urna'),
                "group" => esc_html__( 'Responsive Settings', 'urna' ),
                "param_name" => 'screen_desktopsmall',
                "value" => $columns,
                'std'       => '3',
                'dependency'    => array(
                        'element'   => 'responsive_type',
                        'value'     => 'yes',
                ),
            ),                 
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Number of columns screen tablet','urna'),
                "description" => esc_html__('Column apply when the width is between 768px and 991px','urna'),
                "group" => esc_html__( 'Responsive Settings', 'urna' ),
                "param_name" => 'screen_tablet',
                "value" => $columns,
                'std'       => '3',
                'dependency'    => array(
                        'element'   => 'responsive_type',
                        'value'     => 'yes',
                ),
            ),                  
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Number of columns screen mobile landscape','urna'),
                "group" => esc_html__( 'Responsive Settings', 'urna' ),
                "description" => esc_html__('Column apply when the width is between 480px and 767px','urna'),
                "param_name" => 'screen_landscape_mobile',
                "value" => $columns,
                'std'       => '3',
                'dependency'    => array(
                        'element'   => 'responsive_type',
                        'value'     => 'yes',
                ),
            ),           
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Number of columns screen mobile','urna'),
                "group" => esc_html__( 'Responsive Settings', 'urna' ),
                "description" => esc_html__('Column apply when the width is less 479px','urna'),
                "param_name" => 'screen_mobile',
                "value" => $columns,
                'std'       => '2',
                'dependency'    => array(
                        'element'   => 'responsive_type',
                        'value'     => 'yes',
                ),
            )
        );
        

        return $params;
    }
}


/** 
* Param last responsive
*/  
if ( !function_exists('urna_vc_map_param_default_responsive')) {
    add_filter( 'urna_vc_map_param_responsive', 'urna_vc_map_param_default_responsive' );
    function urna_vc_map_param_default_responsive( $params = array() ) { 

        $columns = apply_filters( 'urna_admin_visualcomposer_columns', array(1,2,3,4,5,6) ); 

        $params  = apply_filters( 'urna_vc_map_array_responsive', $columns ); 

        return $params;
    }
}

/** 
* Param last responsive instagram
*/  
if ( !function_exists('urna_vc_map_param_default_responsive_instagrams')) {
    add_filter( 'urna_vc_map_param_responsive_instagrams', 'urna_vc_map_param_default_responsive_instagrams' );
    function urna_vc_map_param_default_responsive_instagrams( $params = array() ) { 

        $columns = apply_filters( 'urna_admin_visualcomposer_instagram_columns', array(1,2,3,4,5,6,7,8) ); 
        $params  = apply_filters( 'urna_vc_map_array_responsive', $columns ); 

        return $params;
    }
}

/** 
* Param last responsive recently viewed
*/  
if ( !function_exists('urna_vc_map_param_default_responsive_recently_viewed')) {
    add_filter( 'urna_vc_map_param_responsive_recently_viewed', 'urna_vc_map_param_default_responsive_recently_viewed' );
    function urna_vc_map_param_default_responsive_recently_viewed( $params = array() ) { 

        $columns = apply_filters( 'urna_admin_visualcomposer_recently_viewed_columns', array(1,2,3,4,5,6,7,8,9,10,12) ); 
        $params  = apply_filters( 'urna_vc_map_array_responsive', $columns ); 

        return $params;
    }
}

/** 
* Param last responsive brand
*/  
if ( !function_exists('urna_vc_map_param_default_responsive_brands')) {
    add_filter( 'urna_vc_map_param_responsive_brands', 'urna_vc_map_param_default_responsive_brands' );
    function urna_vc_map_param_default_responsive_brands( $params = array() ) { 

        $columns = apply_filters( 'urna_admin_visualcomposer_brands_columns', array(1,2,3,4,5,6,7,8) ); 
        $params  = apply_filters( 'urna_vc_map_array_responsive', $columns ); 

        return $params;
    }
}

 
/** 
* Replace pagebuilder columns and rows class by bootstrap classes
*/
if ( !function_exists('urna_tbay_change_bootstrap_class')) {
    function urna_tbay_change_bootstrap_class( $class_string, $tag ) {
        if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
            $class_string = preg_replace('/vc_span(\d{1,2})/', 'col-md-$1', $class_string);
            $class_string = preg_replace('/vc_hidden-(\w)/', 'hidden-$1', $class_string);
            $class_string = preg_replace('/vc_col-(\w)/', 'col-$1', $class_string);
            $class_string = str_replace('wpb_column', '', $class_string);
            $class_string = str_replace('column_container', 'fluid', $class_string);
        }
        return $class_string;
    }
}

add_filter( 'vc_shortcodes_css_class', 'urna_tbay_change_bootstrap_class', 10, 2 );

function titled_content_box_func( $atts, $content ) {
    $atts = shortcode_atts( array(
        'title'      =>  'title',
    ), $atts);
    $atts['content'] = $content;

    return include_vc_template('titled_content_box.php', $atts);
}


function urna_tbay_translate_column_width_to_span( $width ) {
	preg_match( '/(\d+)\/(\d+)/', $width, $matches );

	if ( ! empty( $matches ) ) {
		$part_x = (int) $matches[1];
		$part_y = (int) $matches[2];
		if ( $part_x > 0 && $part_y > 0 ) {
			$value = ceil( $part_x / $part_y * 12 );
			if ( $value > 0 && $value <= 12 ) {
				$width = 'vc_col-md-' . $value;
			}
		}
	}

	return $width;
}

/**
 * ------------------------------------------------------------------------------------------------
 * Visualcomposer Woocommerce skin load file
 * ------------------------------------------------------------------------------------------------
 */
if ( !function_exists('urna_tbay_visualcomposer_woocommerce_skin_load_file') ) {
    function urna_tbay_visualcomposer_woocommerce_skin_load_file() {
        
        if(!class_exists('Vc_Manager') || !class_exists( 'WooCommerce' )) return;

        $skin = urna_tbay_get_theme();

        switch ($skin) {
            case 'kitchen':
            case 'sportwear':
            case 'handmade':
            case 'minimal': 
            case 'technology-v2':
            case 'technology-v3':
            case 'beauty':
            case 'interior':
            case 'women':
            case 'book':
                require_once URNA_VISUALCOMPOSER .'/skins/' . $skin . '.php';
                break;
            
            default:
                break;
        }

    }
}