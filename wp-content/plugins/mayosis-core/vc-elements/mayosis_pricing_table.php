<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_dm_pricing_table extends WPBakeryShortCode {

    protected function content($atts,$content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
		$css = '';
        extract(shortcode_atts(array(
			"title" => 'Standard',
			"currency"=>"",
			"timeframe"=>"",
			"button_text" => 'Subscribe',
			"price_text" => '',
			"button_url" => 'http://www.something.com',
			"icon" => 'fa fa-thumbs-o-up',
			"show_hide_label" => '1',
			"show_hide__save_label" => '1',
			"label_text" => 'Popular',
			"label_text_save" => 'Save',
			"save_perchantage_amm" => '17%',
			//"animation_delay" => '0.3',
			"icon_color" => '#2C5C82',
			"title_color" => '#2C5C82',	
			"amount_color" => '#41474d',		
			"label_bg_color" => '#94a63a',		
			"save_label_bg_color" => '#41474d',		
			"main_button_background" => '#3a9da6',
			"button_border" =>'',
			"button_color" =>'',
			"title_bg" =>'',
			"button_hover_bg"=> '',
			"button_hover_border" => '',
			"button_hover_text" => '',
			"title_align" => 'left',								
			"content_align" => 'left',									
			'css' => ''
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
        <style>
            .btn.btn_blue_pricing:hover{
                background:<?php echo esc_attr( $button_hover_bg ); ?> !important;
                border-color:<?php echo esc_attr( $button_hover_border ); ?> !important;
                color:<?php echo esc_attr( $button_hover_text ); ?> !important;
            }
        </style>
        <div class="dm_pricing_table <?php echo esc_attr( $css_class ); ?>">
        	<div class="pricing_title" style="background:<?php echo esc_attr($title_bg); ?>">
				<h2 style="color:<?php echo esc_attr($title_color); ?>; text-align:<?php echo esc_attr($title_align); ?>;"><i class="<?php echo esc_attr($icon); ?>" aria-hidden="true" style="color:<?php echo esc_attr($icon_color); ?>;"></i> <?php echo esc_attr($title); ?></h2>
			</div>
			   <?php if($show_hide_label == "1"){ ?>
			<div class="lable_price_data">
				<span class="label_pricing" style="background:<?php echo esc_attr($label_bg_color); ?>;"><?php echo esc_attr($label_text); ?></span>
			</div>
			<?php } else { ?>
			 <?php } ?>
			<div class="pricing_content">
			    
			     <div class="pricing_table_title_box">
				<h3 class="price_tag_table" style="color:<?php echo esc_attr($amount_color); ?>;">
				    <sub class="pricing_currency"><?php echo esc_attr($currency); ?></sub><?php echo esc_attr($price_text); ?><span class="pricing_timeframe"><?php  echo esc_attr($timeframe); ?></span></h3>
				</div>
				
			
				 <?php if($show_hide__save_label == "1"){ ?>
				<span class="save_tooltip"  style="background:<?php echo esc_attr($save_label_bg_color); ?>;"><?php echo esc_attr($label_text_save); ?> <br><?php echo esc_attr($save_perchantage_amm); ?></span>
				<?php } else { ?>
			 <?php } ?>
			
				<div class="main_price_content" style="text-align:<?php echo esc_attr($content_align); ?>;"><?php echo $content; ?></div>
				<a href="<?php echo esc_attr($button_url); ?>" class="btn btn_blue_pricing"  style="background:<?php echo esc_attr($main_button_background); ?>;border-color:<?php echo esc_attr($button_border); ?>;color:<?php echo esc_attr($button_color); ?>;"><?php echo esc_attr($button_text); ?></a>
			</div>
		</div><?php echo $this->endBlockComment('dm_pricing_table'); ?>
        <div class="clearfix"></div>
        
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(
	 "base"      => "dm_pricing_table",
    "name"      => __('Mayosis Pricing Table', 'mayosis'),
    "description"      => __('Mayosis Custom Pricing Table', 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __("Mayosis Elements", 'mayosis'),
    "params"    => array(
	
		array(
            "type" => "textfield",
            "heading" => __('Title', 'mayosis'),
            "param_name" => "title",
            
			"value" => 'Standard',
			"group" => 'General',
        ),
        	array(
            "type" => "textfield",
            "heading" => __("Currency (i.e $)", 'mayosis'),
            "param_name" => "currency",
            
			"value" => '',
			"group" => 'General',
        ),
	array(
            "type" => "textfield",
            "heading" => __("Price", 'mayosis'),
            "param_name" => "price_text",
            
			"value" => '19',
			"group" => 'General',
        ),
        	array(
            "type" => "textfield",
            "heading" => __("Timeframe (ie. /mo)", 'mayosis'),
            "param_name" => "timeframe",
            
			"value" => '',
			"group" => 'General',
        ),
		array(
            "type" => "iconpicker",
            "heading" => __('Icon', 'mayosis'),
            "param_name" => "icon",
            "description" => __('Select Your Icon', 'mayosis'),
			"value" => 'fa fa-thumbs-o-up',
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
            "heading" => __('Icon Color', 'mayosis'),
            "param_name" => "icon_color",
            
			"group" => 'Style',
        ),
		
		array(
            "type" => "colorpicker",
            "heading" => __('Title Color', 'mayosis'),
            "param_name" => "title_color",
            
			"group" => 'Style',
        ),
        
        	array(
            "type" => "colorpicker",
            "heading" => __('Title Background Color', 'mayosis'),
            "param_name" => "title_bg",
            
			"group" => 'Style',
        ),
	
	
	array(
            "type" => "colorpicker",
            "heading" => __('Pricing Amount Color', 'mayosis'),
            "param_name" => "amount_color",
            
			"group" => 'Style',
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __('Button Background Color', 'mayosis'),
            "param_name" => "main_button_background",
			"group" => 'Style',
        ),
        	array(
            "type" => "colorpicker",
            "heading" => __('Button Text Color', 'mayosis'),
            "param_name" => "button_color",
			"group" => 'Style',
        ),
        	array(
            "type" => "colorpicker",
            "heading" => __('Button Border Color', 'mayosis'),
            "param_name" => "button_border",
			"group" => 'Style',
        ),
        
        	array(
            "type" => "colorpicker",
            "heading" => __('Button Hover Background Color', 'mayosis'),
            "param_name" => "button_hover_bg",
			"group" => 'Style',
        ),
        
        	array(
            "type" => "colorpicker",
            "heading" => __('Button Hover Border Color', 'mayosis'),
            "param_name" => "button_hover_border",
			"group" => 'Style',
        ),
        
        	array(
            "type" => "colorpicker",
            "heading" => __('Button Hover Text Color', 'mayosis'),
            "param_name" => "button_hover_text",
			"group" => 'Style',
        ),



	
	array(
            "type" => "dropdown",
            "heading" => __('Alignment of Title', 'mayosis'),
            "param_name" => "title_align",
            "description" => __('Choose Title Align', 'mayosis'),
			"value"      => array( 'Left' => 'left', 'Center' => 'center', 'Right' => 'right' ), //Add default value in $atts
			"group" => 'Style',
        ),
	
		array(
            "type" => "dropdown",
            "heading" => __('Alignment of Content', 'mayosis'),
            "param_name" => "content_align",
            "description" => __('Choose Content Align', 'mayosis'),
			"value"      => array( 'Left' => 'left', 'Center' => 'center', 'Right' => 'right' ), //Add default value in $atts
			"group" => 'Style',
        ),
		
		
		array(
            "type" => "textarea_html",
            "heading" => __('Content', 'mayosis'),
            "param_name" => "content",
			"group" => 'General',
			"value" => __('<ul>
			<li><i class="fa fa-check-circle" aria-hidden="true"></i>List Item</li>
			<li><i class="fa fa-check-circle" aria-hidden="true"></i>List Item</li>
			<li><i class="fa fa-check-circle" aria-hidden="true"></i>List Item</li>
			<li><i class="fa fa-times-circle" aria-hidden="true"></i>List Item</li>
			<li><i class="fa fa-times-circle" aria-hidden="true"></i>List Item</li>
			<li><i class="fa fa-times-circle" aria-hidden="true"></i>List Item</li>
			</ul>', 'mayosis'),
            //"description" => __("Enter a short description for your service.", 'mayosis')
        ),
	
	array(
            "type" => "textfield",
            "heading" => __('Button Text', 'mayosis'),
            "param_name" => "button_text",
            
			"value" => 'Subscribe',
			"group" => 'General',
        ),
	
	array(
            "type" => "textfield",
            "heading" => __('Button Url', 'mayosis'),
            "param_name" => "button_url",
            
			"value" => 'http://www.something.com',
			"group" => 'General',
        ),
	array(
            "type" => "dropdown",
            "heading" => __('Label Show/Hide', 'mayosis'),
            "param_name" => "show_hide_label",
            "description" => __('Show or Hide Label', 'mayosis'),
			"value"      => array( 'Show' => '1', 'Hide' => '2'), //Add default value in $atts
			"group" => 'Label',
        ),
		array(
            "type" => "textfield",
            "heading" => __('Label Text', 'mayosis'),
            "param_name" => "label_text",
            
			"group" => 'Label',
	"dependency" => Array('element' => "show_hide_label", 'value' => array('1'))
        ),
	array(
            "type" => "colorpicker",
            "heading" => __('Label Bg Color', 'mayosis'),
            "param_name" => "label_bg_color",
            
			"value" => '#94a63a',
			"group" => 'Label',
	"dependency" => Array('element' => "show_hide_label", 'value' => array('1'))
        ),
	
	array(
            "type" => "dropdown",
            "heading" => __('Show/Hide Save Label', 'mayosis'),
            "param_name" => "show_hide__save_label",
            "description" => __('Show Hide Save Label', 'mayosis'),
			"value"      => array( 'Show' => '1', 'Hide' => '2'), //Add default value in $atts
			"group" => 'Label',
        ),
array(
            "type" => "textfield",
            "heading" => __('Save Label Text', 'mayosis'),
            "param_name" => "label_text_save",
            
			"group" => 'Label',
	"dependency" => Array('element' => "show_hide__save_label", 'value' => array('1'))
        ),
	array(
            "type" => "textfield",
            "heading" => __('Save Perchantage/Ammount', 'mayosis'),
            "param_name" => "save_perchantage_amm",
            
			"group" => 'Label',
	"dependency" => Array('element' => "show_hide__save_label", 'value' => array('1'))
        ),
	array(
            "type" => "colorpicker",
            "heading" => __('Save Label Bg Color', 'mayosis'),
            "param_name" => "save_label_bg_color",
            
			"value" => '#41474d',
			"group" => 'Label',
	"dependency" => Array('element' => "show_hide__save_label", 'value' => array('1'))
        ),
	
	array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),

    )

));