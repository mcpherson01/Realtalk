<?php

if (!class_exists('WPBakeryShortCode')) return;
class WPBakeryShortCode_digital_contact_info extends WPBakeryShortCode

	{
	protected
	function content($atts, $content = null)
		{

		// $custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;

		$css = '';
		extract(shortcode_atts(array(
			"address_widget" => 'Address',
			"title_align" => 'left',
			"title_color" => '#575e66',
			"countent_color" => '#575e66',
			'css' => '',
		) , $atts));

		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' ') , $this->settings['base'], $atts);
		/* ================  Render Shortcodes ================ */
		ob_start();
?>
        
        <?php

		// $img = wp_get_attachment_image_src($el_image, "large");
		// $imgSrc = $img[0];

?>

        <!-- Element Code start -->
    
                    <div class="contact-widget">
                    	<h4 style="color:<?php echo esc_attr($title_color); ?>"><?php
		echo esc_attr($address_widget); ?></h4>
                        <p style="color:<?php
		echo esc_attr($countent_color); ?> !important"><?php
		echo $content; ?></p>
                    </div>
                <?php
		echo $this->endBlockComment('digital_contact_info'); ?>
			    <div class="clearfix"></div>
			    
			    
      
		
        
        <!-- Element Code / END -->

        <?php
		$output = ob_get_clean();
		/* ================  Render Shortcodes ================ */
		return $output;
		}
	}

vc_map(array(
	"base" => "digital_contact_info",
	"name" => __('Mayosis Contact Info', 'mayosis') ,
	"description" => __('Mayosis contact information box', 'mayosis') ,
	"class" => "",
	"icon" => get_template_directory_uri() . '/images/DM-Symbol-64px.png',
	"category" => __('Mayosis Elements', 'mayosis') ,
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => __('Address Widget Title', 'mayosis') ,
			'param_name' => 'address_widget',
			'value' => __('Address', 'mayosis') ,
			'description' => __('Input Address Widget Title', 'mayosis') ,
		) ,
		array(
			'type' => 'textarea',
			'heading' => __('Address Details', 'mayosis') ,
			'param_name' => 'content',
			'value' => __('37/5, Joarshahara,<br />Baridhara, <br />Dhaka-1229,Bangladesh', 'mayosis') ,
			'description' => __('', 'mayosis') ,
		) ,
		array(
			"type" => "colorpicker",
			"heading" => __('Color Of Titles', 'mayosis') ,
			"param_name" => "title_color",

			// "description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),

			"value" => '#ffffff',
			"group" => 'Style',
		) ,
		array(
			"type" => "colorpicker",
			"heading" => __('Color Of Content', 'mayosis') ,
			"param_name" => "countent_color",

			// "description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),

			"value" => '#ffffff',
			"group" => 'Style',
		) ,
		array(
			'type' => 'css_editor',
			'heading' => __('Css', 'mayosis') ,
			'param_name' => 'css',
			'group' => __('Design options', 'mayosis') ,
		) ,
	)
));