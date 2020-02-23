<?php

if (!class_exists('WPBakeryShortCode')) return;
class WPBakeryShortCode_dm_theme_dual_button extends WPBakeryShortCode

	{
	protected
	function content($atts, $content = null)
		{

		// $custom_css = $el_class = $title = $btn_a_icon = $output = $s_content = $number = '' ;

		$css = '';
		extract(shortcode_atts(array(
			"btn_a_text" => 'Button A',
			"button_a_style" => 'sone',
			"button_b_style" => 'sone',
			"btn_separator" => 'or',
			"button_separator_show" => '',
			"btn_b_text" => 'Button B',
			"btn_a_link" => '#',
			"btn_b_link" => '#',
			"margin_top" => 0,
			"margin_bottom" => 0,
			"btn_a_target" => '_self',
			"btn_b_target" => '_self',
			"btn_a_icon" => 'fa fa-angle-right',
			"btn_b_icon" => 'fa fa-angle-right',
			"button_a_font_color" => '#ffffff',
			"color_seprator" => '#666666',
			"button_align" => 'left',
			"class_a" => '',
			"class_b" => '',
			"background_b" => '#666666',
			"background_b_border" => '#666666',
			"background_b_text" => '#ffffff',
			"background_a" => '#666666',
			"background_a_border" => '#666666',
			"background_a_text" => '#ffffff',
			'button_video_poup_a' => '',
			'button_video_poup_b' =>'',
			'gradient_color_aa' =>'',
			'gradient_color_ab' => '',
			'gradient_color_ba' =>'',
			'gradient_color_bb' => '',
			'css' => ''
		) , $atts));
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' ') , $this->settings['base'], $atts);
		/* ================  Render Shortcodes ================ */
		ob_start();
?>
     
        

        <!-- Element Code start -->
       
         <div class="block_of_dual_button col-md-12 <?php
		echo esc_attr($css_class); ?>" style="margin-top:<?php
		echo esc_attr($margin_top) ?>px; margin-bottom:<?php
		echo esc_attr($margin_bottom) ?>px; text-align:<?php
		echo esc_attr($button_align) ?>;padding-left:0;padding-right:0; ">
                        
                            <a <?php
		echo esc_attr($button_video_poup_a); ?> href="<?php
		echo esc_url($btn_a_link); ?>" class="<?php
		echo ($button_a_style == 'sone' ? 'styleone' : '') . ' ' . ($button_a_style == 'stwo' ? 'styletwo' : '') . ' ' . ($button_a_style == 'transparent' ? 'transbutton' : '') . ' ' . ($button_a_style == 'gradienta' ? 'gradienta' : '') . ' ' . ($button_a_style == 'custom' ? 'custombuttona' : '') ?> btn btn-danger btn-lg browse-free btn_a <?php
		echo esc_attr($class_a); ?>" target="<?php
		echo esc_attr($btn_a_target); ?>" 
		
		 style="<?php if($button_a_style=="custom"){ ?>background: <?php
		echo esc_attr($background_a); ?>;
		<?php } elseif($button_a_style=="gradienta"){ ?>background-image:linear-gradient( 90deg, <?php echo esc_attr($gradient_color_aa) ?> 0%, <?php echo esc_attr($gradient_color_ab) ?> 100%);
		<?php } ?>
		color:<?php
		echo esc_attr($background_a_text); ?>; border-color:<?php
		echo esc_attr($background_a_border); ?>;"
		
		><?php
		echo esc_attr($btn_a_text); ?> <?php
		echo ($btn_a_icon !== '' ? '<i class="' . $btn_a_icon . '"></i>' : ''); ?></a> 
                            
                            <?php
		if ($button_separator_show == "yes")
			{ ?>
                            <span class="divide-button" style="color:<?php
			echo esc_attr($color_seprator); ?>"><?php
			echo esc_attr($btn_separator); ?></span>
                      <?php
			}
		  else
			{ ?>
                      <span style="width:8px;padding: 4px;"></span>
                      <?php
			} ?>
   <a <?php
		echo esc_attr($button_video_poup_b); ?>  href="<?php
		echo esc_url($btn_b_link); ?>" class="<?php
		echo ($button_b_style == 'sone' ? 'styleone' : '') . ' ' . ($button_b_style == 'stwo' ? 'styletwo' : '') . ' ' . ($button_b_style == 'gradientb' ? 'gradientb' : '') . ' ' . ($button_b_style == 'transparent' ? 'transbutton' : '') . ' ' . ($button_b_style == 'custom' ? 'custombuttonb' : '') ?> btn btn-danger btn-lg browse-free btn_b <?php
		echo esc_attr($class_b); ?>" target="<?php
		echo esc_attr($btn_b_target); ?>"
		style="<?php if($button_b_style=="custom"){ ?>background:<?php
		echo esc_attr($background_b); ?>;<?php } elseif($button_b_style=="gradientb"){ ?>background-image:linear-gradient( 90deg, <?php echo esc_attr($gradient_color_ba) ?> 0%, <?php echo esc_attr($gradient_color_bb) ?> 100%);<?php }?>color:<?php
		echo esc_attr($background_b_text); ?>; border-color:<?php
		echo esc_attr($background_b_border); ?>;"
		><?php
		echo esc_attr($btn_b_text); ?> <?php
		echo ($btn_b_icon !== '' ? '<i class="' . $btn_b_icon . '"></i>' : ''); ?></a>
                        
                           
                        
                    </div><?php
		echo $this->endBlockComment('dm_theme_dual_button'); ?>
<div class="clearfix"></div>
        <!-- Element Code / END -->

        <?php
		$output = ob_get_clean();
		/* ================  Render Shortcodes ================ */
		return $output;
		}
	}

vc_map(array(
	"base" => "dm_theme_dual_button",
	"name" => __("Mayosis Dual Button", 'mayosis') ,
	"description" => __("Dual Button", 'mayosis') ,
	"class" => "",
	"icon" => get_template_directory_uri() . '/images/DM-Symbol-64px.png',
	"category" => __("Mayosis Elements", 'mayosis') ,
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Show Button Separator", 'mayosis') ,
			"param_name" => "button_separator_show",
			"description" => __("Choose Gradient or Not", 'mayosis') ,
			"value" => array(
				'No' => 'no',
				'Yes' => 'yes'
			) , //Add default value in $atts
			"group" => 'General',
		) ,
		
	
		array(
			"type" => "textfield",
			"heading" => __("Button Separator", 'mayosis') ,
			"param_name" => "btn_separator",

			// "description" => __("Enter a CSS class if required.", 'mayosis'),

			"value" => 'or',
			"group" => 'General',
			"dependency" => Array(
				'element' => "button_separator_show",
				'value' => array(
					'yes'
				)
			)
		) ,
		array(
			"type" => "textfield",
			"heading" => __("Button A Text", 'mayosis') ,
			"param_name" => "btn_a_text",

			// "description" => __("Enter a CSS class if required.", 'mayosis'),

			"value" => '',
			"group" => 'Button A'
		) ,
		array(
			"type" => "textfield",
			"heading" => __("Button A Link", 'mayosis') ,
			"param_name" => "btn_a_link",

			// "description" => __("Enter a CSS class if required.", 'mayosis'),

			"value" => '#',
			"group" => 'Button A'
		) ,
		array(
			"type" => "iconpicker",
			"heading" => __("Btn A Icon", 'mayosis') ,
			"param_name" => "btn_a_icon",
			"description" => __("Accepts a FontAwesome for Btn A value. (Ex. fa fa-angle-right)", 'mayosis') ,
			"value" => 'fa fa-angle-right',
			"group" => 'Button A'
		) ,
		array(
			"type" => "dropdown",
			"heading" => __("Style Of Button A ", 'mayosis') ,
			"param_name" => "button_a_style",
			"description" => __("Choose Button A Color Style", 'mayosis') ,
			"value" => array(
				'Color One' => 'sone',
				'Color Two' => 'stwo',
				'Transparent' => 'transparent',
				'Gradient' => 'gradienta',
				'Custom' => 'custom'
			) , //Add default value in $atts
			"group" => 'Button A',
		) ,
		
		array(
            "type" => "colorpicker",
            "heading" => __('Gradient Color A', 'mayosis'),
            "param_name" => "gradient_color_aa",
			"value" => 'rgb(60,40,180)',
			"group" => 'Button A',
			"dependency" => Array('element' => "button_a_style", 'value' => array('gradienta')),
        ),
        
        array(
            "type" => "colorpicker",
            "heading" => __('Gradient Color B', 'mayosis'),
            "param_name" => "gradient_color_ab",
			"value" => 'rgb(100,60,220)',
			"group" => 'Button A',
			"dependency" => Array('element' => "button_a_style", 'value' => array('gradienta')),
        ),
			array(
			"type" => "dropdown",
			"heading" => __("Show Video Popup Button One", 'mayosis') ,
			"param_name" => "button_video_poup_a",
			"description" => __("Show Video Popup On Button A", 'mayosis') ,
			"value" => array(
				'No' => '',
				'Yes' => 'data-lity'
			) , //Add default value in $atts
			"group" => 'Button A',
		) ,
		array(
			"type" => "colorpicker",
			"heading" => __("Custom Background Color", 'mayosis') ,
			"param_name" => "background_a",

			// "description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),

			"value" => '#666666',
			"group" => 'Button A',
			"dependency" => Array(
				'element' => "button_a_style",
				'value' => array(
					'custom'
				)
			)
		) ,
		array(
			"type" => "colorpicker",
			"heading" => __("Custom Border Color", 'mayosis') ,
			"param_name" => "background_a_border",

			// "description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),

			"value" => '#666666',
			"group" => 'Button A',
			"dependency" => Array(
				'element' => "button_a_style",
				'value' => array(
					'custom'
				)
			)
		) ,
		array(
			"type" => "colorpicker",
			"heading" => __("Custom Text Color", 'mayosis') ,
			"param_name" => "background_a_text",

			// "description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),

			"value" => '#ffffff',
			"group" => 'Button A',
			"dependency" => Array(
				'element' => "button_a_style",
				'value' => array(
					'custom'
				)
			)
		) ,
		array(
			"type" => "textfield",
			"heading" => __("Button B Text", 'mayosis') ,
			"param_name" => "btn_b_text",

			// "description" => __("Enter a CSS class if required.", 'mayosis'),

			"value" => '',
			"group" => 'Button B'
		) ,
		array(
			"type" => "textfield",
			"heading" => __("Button B Link", 'mayosis') ,
			"param_name" => "btn_b_link",

			// "description" => __("Enter a CSS class if required.", 'mayosis'),

			"value" => '#',
			"group" => 'Button B'
		) ,
		array(
			"type" => "iconpicker",
			"heading" => __("Btn B Icon", 'mayosis') ,
			"param_name" => "btn_b_icon",
			"description" => __("Accepts a FontAwesome for Btn B value. (Ex. fa fa-angle-right)", 'mayosis') ,
			"value" => 'fa fa-angle-right',
			"group" => 'Button B'
		) ,
		array(
			"type" => "dropdown",
			"heading" => __("Style Of Button B ", 'mayosis') ,
			"param_name" => "button_b_style",
			"description" => __("Choose Button B Color Style", 'mayosis') ,
			"value" => array(
				'Color One' => 'sone',
				'Color Two' => 'stwo',
				'Transparent' => 'transparent',
				'Gradient' => 'gradientb',
				'Custom' => 'custom'
			) , //Add default value in $atts
			"group" => 'Button B',
		) ,
		
		
		array(
            "type" => "colorpicker",
            "heading" => __('Gradient Color A', 'mayosis'),
            "param_name" => "gradient_color_ba",
			"value" => 'rgb(60,40,180)',
			"group" => 'Button B',
			"dependency" => Array('element' => "button_b_style", 'value' => array('gradientb')),
        ),
        
        array(
            "type" => "colorpicker",
            "heading" => __('Gradient Color B', 'mayosis'),
            "param_name" => "gradient_color_bb",
			"value" => 'rgb(100,60,220)',
			"group" => 'Button B',
			"dependency" => Array('element' => "button_b_style", 'value' => array('gradientb')),
        ),
		array(
			"type" => "dropdown",
			"heading" => __("Show Video Popup Button Two", 'mayosis') ,
			"param_name" => "button_video_poup_b",
			"description" => __("Show Video Popup On Button B", 'mayosis') ,
			"value" => array(
				'No' => '',
				'Yes' => 'data-lity'
			) , //Add default value in $atts
			"group" => 'Button B',
		) ,
		
		array(
			"type" => "colorpicker",
			"heading" => __("Custom Background Color", 'mayosis') ,
			"param_name" => "background_b",

			// "description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),

			"value" => '#666666',
			"group" => 'Button B',
			"dependency" => Array(
				'element' => "button_b_style",
				'value' => array(
					'custom'
				)
			)
		) ,
		array(
			"type" => "colorpicker",
			"heading" => __("Custom Border Color", 'mayosis') ,
			"param_name" => "background_b_border",

			// "description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),

			"value" => '#666666',
			"group" => 'Button B',
			"dependency" => Array(
				'element' => "button_b_style",
				'value' => array(
					'custom'
				)
			)
		) ,
		array(
			"type" => "colorpicker",
			"heading" => __("Custom Text Color", 'mayosis') ,
			"param_name" => "background_b_text",

			// "description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),

			"value" => '#ffffff',
			"group" => 'Button B',
			"dependency" => Array(
				'element' => "button_b_style",
				'value' => array(
					'custom'
				)
			)
		) ,
		array(
			"type" => "textfield",
			"heading" => __("Margin Top", 'mayosis') ,
			"param_name" => "margin_top",
			"description" => __("Enter a positive integer value.", 'mayosis') ,
			"value" => 0,
			"group" => 'Style'
		) ,
		array(
			"type" => "textfield",
			"heading" => __("Margin Bottom", 'mayosis') ,
			"param_name" => "margin_bottom",
			"description" => __("Enter a positive integer value.", 'mayosis') ,
			"value" => 0,
			"group" => 'Style'
		) ,
		array(
			"type" => "dropdown",
			"heading" => __("Btn A Target Window", 'mayosis') ,
			"param_name" => "btn_a_target",
			"description" => __("Set the Btn A window for the button.", 'mayosis') ,
			"value" => array(
				'_self' => '_self',
				'_blank' => '_blank'
			) , //Add default value in $atts
			"group" => 'Button A'
		) ,
		array(
			"type" => "dropdown",
			"heading" => __("Btn B Target Window", 'mayosis') ,
			"param_name" => "btn_b_target",
			"description" => __("Set the Btn B window for the button.", 'mayosis') ,
			"value" => array(
				'_self' => '_self',
				'_blank' => '_blank'
			) , //Add default value in $atts
			"group" => 'Button B'
		) ,
		array(
			"type" => "colorpicker",
			"heading" => __("Separator Color", 'mayosis') ,
			"param_name" => "color_seprator",

			// "description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),

			"value" => '#666666',
			"group" => 'Color',
		) ,
		/*array(
		"type" => "colorpicker",
		"heading" => __("Text Color", 'mayosis'),
		"param_name" => "text_color",

		// "description" => __("Enter an btn_a_icon value.", 'mayosis'),

		"value" => '#ffffff'
		),*/
		array(
			"type" => "dropdown",
			"heading" => __("Alignment of Button", 'mayosis') ,
			"param_name" => "button_align",
			"description" => __("Choose Button Align", 'mayosis') ,
			"value" => array(
				'Left' => 'left',
				'Center' => 'center',
				'Right' => 'right'
			) , //Add default value in $atts
			"group" => 'Style',
		) ,
		array(
			"type" => "textfield",
			"heading" => __("Class of Button A", 'mayosis') ,
			"param_name" => "class_a",
			"description" => __("Apply a custom CSS class if required.", 'mayosis') ,
			"value" => '',
			"group" => 'Style'
		) ,
		array(
			"type" => "textfield",
			"heading" => __("Class of Button B", 'mayosis') ,
			"param_name" => "class_b",
			"description" => __("Apply a custom CSS class if required.", 'mayosis') ,
			"value" => '',
			"group" => 'Style'
		) ,
		array(
			'type' => 'css_editor',
			'heading' => __('Css', 'mayosis') ,
			'param_name' => 'css',
			'group' => __('Design options', 'mayosis') ,
		) ,
	)
));