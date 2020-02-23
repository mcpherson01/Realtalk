<?php

if(!class_exists('WPBakeryShortCode')) return;

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_client_items extends WPBakeryShortCodesContainer {
		
		protected function content($atts, $content = null) {

			//$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
	
			extract(shortcode_atts(array(
				"el_animation" => 'slide',
				 'css' => ''
			), $atts));
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
	
			/* ================  Render Shortcodes ================ */
	
			ob_start();
			
			if(!isset($GLOBALS['dm_client_image_count'])){
				$GLOBALS['dm_client_image_count'] = 0;
			}
	
			?>
			
			<?php 
				//$img = wp_get_attachment_image_src($el_image, "large"); 
				//$imgSrc = $img[0];
			?>
	
			<!-- Element Code start -->
			
            <?php  
			
			echo '<div class="dm_clients '.$css_class .'" style="width:100%;"><ul class="slides">'.do_shortcode($content).'</ul></div>';
	
			
			//increment for next possible carousel slider
			$GLOBALS['dm_client_image_count']++;
			
			?><?php echo $this->endBlockComment('client_items'); ?>
            
			<!-- Element Code / END -->
	
			<?php
	
			$output = ob_get_clean();
	
			/* ================  Render Shortcodes ================ */
	
			return $output;
	
		}
		
    }
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_client_items_item extends WPBakeryShortCode {
		
		protected function content($atts, $content = null) {

			//$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
	
			extract(shortcode_atts(array(
				"el_image" => '',
				"el_title" => ''
				), 
			$atts));
	
	
			/* ================  Render Shortcodes ================ */
	
			ob_start();
	
			?>
			
			<?php 
				$img = wp_get_attachment_image_src($el_image, "large"); 
				$imgSrc = $img[0];
			?>
	
			<!-- Element Code start -->
			
            <?php
			
				echo '<li><img src="' . esc_url($imgSrc) . '" alt="' . esc_attr($el_title) . '" /></li>';
			
			?>
            
			<!-- Element Code / END -->
	
			<?php
	
			$output = ob_get_clean();
	
			/* ================  Render Shortcodes ================ */
	
			return $output;
	
		}
		
    }
}


vc_map( array(
    "name" => __("Mayosis Logo Grid", 'mayosis'),
    "base" => "client_items",
	"category"  => __("Mayosis Elements", 'mayosis'),
	"description" => __('Mayosis Client Logo Grid', 'mayosis') ,
    "as_parent" => array('only' => 'client_items_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
	"icon" => get_template_directory_uri() . '/images/DM-Symbol-64px.png',
    "show_settings_on_create" => false,
    "is_container" => true,
    "params" => array(
	array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),
    ),
    "js_view" => 'VcColumnView'
) );

vc_map( array(
    "name" => __("Client Logo", 'mayosis'),
    "base" => "client_items_item",
	"category"  => __("Digital Elements", 'mayosis'),
	"icon" => get_template_directory_uri() . '/images/DM-Symbol-64px.png',
    "content_element" => true,
    "as_child" => array('only' => 'client_items'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
	
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Alt attribute", 'mayosis'),
            "param_name" => "el_title",
            "description" => __("Enter a descriptive alt attribute - this is used for SEO purposes.", 'mayosis'),
			"value" => ''
        ),
		
		array(
            "type" => "attach_image",
            "heading" => __("Image", 'mayosis'),
            "param_name" => "el_image",
            "description" => __("Upload an image for your slide.", 'mayosis')
        ),
		
    )
) );