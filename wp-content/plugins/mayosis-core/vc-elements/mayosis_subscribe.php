<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_dm_subscribe extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

$css = '';
        extract(shortcode_atts(array(
			"title" => '',
			//"animation_delay" => '0.3',
			"title_color" => '#2C5C82',		
			"countent_color" => '#ffffff',		
			"title_align" => 'left',				
			"subscribe_content_all" => '',	
			 'css' => ''
        ), $atts));
		$atts['main_content'] = wpb_js_remove_wpautop($subscribe_content_all, true);
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );


        /* ================  Render Shortcodes ================ */

        ob_start();

        ?>
        
       

        <!-- Element Code start -->
        <div class="subscribe-block <?php echo esc_attr( $css_class ); ?>">
        <div class="col-md-12 col-sm-12 col-xs-12">
						<h4 style="color:<?php echo esc_attr($title_color); ?>;text-align:<?php echo esc_attr($title_align); ?>;"><?php echo esc_attr($title); ?></h4>
					<div class="subscribe-description" style="color:<?php echo esc_attr($countent_color); ?> !important"><?php echo $atts['main_content']; ?></div>
	                </div>
	                </div><?php echo $this->endBlockComment('dm_subscribe'); ?>
      
        
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "dm_subscribe",
    "name"      => __("Mayosis Subscribe", 'mayosis'),
    "description"      => __("Mayosis Subscribe Box", 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __("Mayosis Elements", 'mayosis'),
    "params"    => array(
	
		array(
            "type" => "textfield",
            "heading" => __("Subscribe Title", 'mayosis'),
            "param_name" => "title",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '',
			"group" => 'General',
        ),
	
		
		
		/*array(
            "type" => "textfield",
            "heading" => __("Animation Delay", 'mayosis'),
            "param_name" => "animation_delay",
            "description" => __("Accepts a positive integer value.", 'mayosis'),
			"value" => '0.3'
        ),*/
		
		
		
		array(
            "type" => "colorpicker",
            "heading" => __("Title Color", 'mayosis'),
            "param_name" => "title_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#2C5C82',
			"group" => 'Style',
        ),
	
	
	array(
            "type" => "dropdown",
            "heading" => __("Alignment of Title", 'mayosis'),
            "param_name" => "title_align",
            "description" => __("Choose Title Align", 'mayosis'),
			"value"      => array( 'Left' => 'left', 'Center' => 'center', 'Right' => 'right' ), //Add default value in $atts
			"group" => 'Style',
        ),
		
		
 
	 array(
                        'type' => 'textarea_html',
                        'heading' => __( 'Subscribe Description & Shortcode', 'mayosis' ),
                        'param_name' => 'subscribe_content_all',
                        'description' => __( 'Subscribe Description With any types od Shortcode', 'mayosis' ),
	"group" => 'General',
                    ),
	 array(
            "type" => "colorpicker",
            "heading" => __("Color Of Content", 'mayosis'),
            "param_name" => "countent_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#ffffff',
			"group" => 'Style',
        ),
array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),


      
    )

));