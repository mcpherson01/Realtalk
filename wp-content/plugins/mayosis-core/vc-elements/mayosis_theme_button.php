<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_dm_theme_button extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
$css = '';
        extract(shortcode_atts(array(	
			"btn_text" => '',					
			"button_main_style" => 'sone',					
			"link" => '#',
			"margin_top" => 0,
			"margin_bottom" => 0,
			"target" => '_self',
			"icon" => 'fa fa-angle-right',
			"button_align" => 'left',
			"class" => '',
			'button_video_poup' =>'',
			'css' => '',
			'z_index' => 5,
			'gradient_color_a' => '',
			'gradient_color_b' => '',
        ), $atts));
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

        /* ================  Render Shortcodes ================ */

        ob_start();

        ?>
        
        <?php 
			//$img = wp_get_attachment_image_src($el_image, "large"); 
			//$imgSrc = $img[0];
		?>
        <!-- Element Code start -->
        <div class="<?php echo esc_attr( $css_class ); ?>" style="z-index:<?php echo esc_attr($z_index) ?>;margin-top:<?php echo esc_attr($margin_top) ?>px; margin-bottom:<?php echo esc_attr($margin_bottom) ?>px; text-align:<?php echo esc_attr($button_align) ?>; position:relative; ">
        <a <?php echo esc_attr( $button_video_poup ); ?> class="<?php echo ( $button_main_style == 'sone' ? 'styleone' : '' ) .' '. ( $button_main_style == 'stwo' ? 'styletwo' : '' ).' '.( $button_main_style == 'transparent' ? 'transbutton' : '' ).' '.( $button_main_style == 'gradient' ? 'gradient' : '' ).' '.( $button_main_style == 'custom' ? 'custombuttonmain' : '' )?> btn btn-primary btn-lg browse-more single_dm_btn <?php echo  esc_attr($class); ?>" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>"
        <?php if($button_main_style=="gradient"){ ?>
            style="background-image:linear-gradient( 90deg, <?php echo esc_attr($gradient_color_a) ?> 0%, <?php echo esc_attr($gradient_color_b) ?> 100%);"
        <?php } ?>
        
        > <?php echo esc_attr($btn_text); ?> <?php echo ( $icon !== '' ? '<i class="'.$icon.'"></i>' : '' ); ?></a>
</div><?php echo $this->endBlockComment('dm_theme_button'); ?>
<div class="clearfix"></div>
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "dm_theme_button",
    "name"      => __("Mayosis Single Button", 'mayosis'),
    "description"      => __("Single Button", 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __("Mayosis Elements", 'mayosis'),
    "params"    => array(

		array(
            "type" => "textfield",
            "heading" => __("Button Text", 'mayosis'),
            "param_name" => "btn_text",
            //"description" => __("Enter a CSS class if required.", 'mayosis'),
			"value" => '',
			"group" => 'General'
        ),
	
		array(
            "type" => "textfield",
            "heading" => __("Link", 'mayosis'),
            "param_name" => "link",
            //"description" => __("Enter a CSS class if required.", 'mayosis'),
			"value" => '#',
			"group" => 'General'
        ),
				
		array(
            "type" => "textfield",
            "heading" => __("Margin Top", 'mayosis'),
            "param_name" => "margin_top",
            "description" => __("Enter a positive integer value.", 'mayosis'),
			"value" => 0,
			"group" => 'Style'
        ),
		
		array(
            "type" => "textfield",
            "heading" => __("Margin Bottom", 'mayosis'),
            "param_name" => "margin_bottom",
            "description" => __("Enter a positive integer value.", 'mayosis'),
			"value" => 0,
			"group" => 'Style'
        ),
		array(
            "type" => "textfield",
            "heading" => __("Font Size", 'mayosis'),
            "param_name" => "dm_font_size",
            "description" => __("Enter a positive integer value.", 'mayosis'),
			"value" => 18,
			"group" => 'Style'
        ),
	
	array(
            "type" => "textfield",
            "heading" => __("Border Width", 'mayosis'),
            "param_name" => "dm_border_size",
            "description" => __("Enter a positive integer value.", 'mayosis'),
			"value" => 1,
			"group" => 'Style'
        ),
	array(
            "type" => "dropdown",
            "heading" => __("Style Of Button ", 'mayosis'),
            "param_name" => "button_main_style",
            "description" => __("Choose Button Color Style(Custom Color Set From Theme Option)", 'mayosis'),
			"value"      => array( 'Color One' => 'sone', 'Color Two' => 'stwo','Transparent' => 'transparent', 'Gradient' => 'gradient' ,'Custom' => 'custom'  ), //Add default value in $atts
			"group" => 'Style',
        ),
	
		array(
            "type" => "colorpicker",
            "heading" => __('Gradient Color A', 'mayosis'),
            "param_name" => "gradient_color_a",
			"value" => 'rgb(60,40,180)',
			"group" => 'Style',
			"dependency" => Array('element' => "button_main_style", 'value' => array('gradient')),
        ),
        
        array(
            "type" => "colorpicker",
            "heading" => __('Gradient Color B', 'mayosis'),
            "param_name" => "gradient_color_b",
			"value" => 'rgb(100,60,220)',
			"group" => 'Style',
			"dependency" => Array('element' => "button_main_style", 'value' => array('gradient')),
        ),
	array(
            "type" => "textfield",
            "heading" => __("Border Radius", 'mayosis'),
            "param_name" => "dm_border_radius",
            "description" => __("Enter a positive integer value.", 'mayosis'),
			"value" => 3,
			"group" => 'Style'
        ),
		
		array(
            "type" => "textfield",
            "heading" => __("Z Index", 'mayosis'),
            "param_name" => "z_index",
            "description" => __("Enter a integer value.", 'mayosis'),
			"value" => 0,
			"group" => 'Style'
        ),
        
		array(
            "type" => "dropdown",
            "heading" => __("Target Window", 'mayosis'),
            "param_name" => "target",
            "description" => __("Set the target window for the button.", 'mayosis'),
			"value"      => array( '_self' => '_self', '_blank' => '_blank' ), //Add default value in $atts
			"group" => 'General'
        ),
		
		array(
			"type" => "dropdown",
			"heading" => __("Show Video Popup Button", 'mayosis') ,
			"param_name" => "button_video_poup",
			"description" => __("Show Video Popup On", 'mayosis') ,
			"value" => array(
				'No' => '',
				'Yes' => 'data-lity'
			) , //Add default value in $atts
			"group" => 'General',
		) ,
		array(
            "type" => "iconpicker",
            "heading" => __("Icon", 'mayosis'),
            "param_name" => "icon",
            "description" => __("Select Your Icon", 'mayosis'),
			"value" => 'fa fa-angle-right',
			"group" => 'Style'
        ),
	
		/*array(
            "type" => "colorpicker",
            "heading" => __("Text Color", 'mayosis'),
            "param_name" => "text_color",
            //"description" => __("Enter an icon value.", 'mayosis'),
			"value" => '#ffffff'
        ),*/
		
		
	array(
            "type" => "dropdown",
            "heading" => __("Alignment of Button", 'mayosis'),
            "param_name" => "button_align",
            "description" => __("Choose Button Align", 'mayosis'),
			"value"      => array( 'Left' => 'left', 'Center' => 'center', 'Right' => 'right' ), //Add default value in $atts
			"group" => 'Style',
        ),
		
		
		
		array(
            "type" => "textfield",
            "heading" => __("Class", 'mayosis'),
            "param_name" => "class",
            "description" => __("Apply a custom CSS class if required.", 'mayosis'),
			"value" => '',
			"group" => 'Style'
        ),
array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),


    )

));