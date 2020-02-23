<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_dm_icon_box extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
		$css = '';
        extract(shortcode_atts(array(
			"title" => '',
			"icon" => 'fa fa-thumbs-o-up',
			//"animation_delay" => '0.3',
			"icon_color" => '#2C5C82',
			"title_color" => '#2C5C82',
			'title_font_size' => '18px',
			"content_color" => '#ffffff',
			"content_align" =>'left',
			"icon_align" => 'left',		
			"title_align" => 'left',
			"icon_gradient" => '',
			"icon_color_gradient_1" => '#05efd7',
			"icon_color_gradient_2" => '#4434f6',
			'custom_image'=> '',
			'cimage_bg_color' => '#001450',
			'ci_bg_type' => '',
			'cimage_g1_color' => '#00ffff',
			'cimage_g2_color' =>'#001450',
			'cimage_padding' => '20px',
			'cimage_bradius' =>'50%',
			'cimage_stack_top'=>'20%',
			'width_custom_image' =>'',
			'height_custom_image' => '',
			'icon_beside' =>'no',
			'btn_align' =>'',
			'cbtn_bg_color' =>'#2d3ce6',
			'cbtn_text_color' =>'#ffffff',
			'cbtn_text' =>'Open a shop',
			'cbtn_url' =>'',
			'cbtn_margin_top' =>'',
			'cbtn_margin_bottom' =>'',
			"custom_class" => '',
			'icon_bg_color'=>'#5a00f0',
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
        <div class="mayosis-icon-box">
            <?php if($icon_beside == "yes"){ ?>
            <div class="quality-box <?php echo esc_attr( $css_class ); ?> quality-box-flex <?php echo esc_attr( $custom_class ); ?>">
            <div class="icon-beside-title">
            <?php } else { ?>
            <div class="quality-box <?php echo esc_attr( $css_class ); ?>">
        <div style="text-align:<?php echo esc_attr($icon_align); ?>;margin-top:-<?php echo esc_attr($cimage_stack_top); ?>">
            <?php } ?>
            <?php if($custom_image){ ?>
            <?php $customicon = wp_get_attachment_image_src($custom_image, 'thumbnail'); ?>
            <?php if($ci_bg_type == "gradient"){ ?>
            <p class="qxbox-cs-bg" style="background:linear-gradient(60deg, <?php echo esc_attr($cimage_g1_color); ?> 0%,<?php echo esc_attr($cimage_g2_color); ?> 100%);
            padding:<?php echo esc_attr($cimage_padding); ?>;border-radius:<?php echo esc_attr($cimage_bradius); ?>;">
            <?php } else { ?>
            <p class="qxbox-cs-bg" style="background-color:<?php echo esc_attr($cimage_bg_color); ?>;padding:<?php echo esc_attr($cimage_padding); ?>;border-radius:<?php echo esc_attr($cimage_bradius); ?>;">
            <?php } ?>
            <img src="<?php echo $customicon[0]; ?>" alt="custom-icon" style="width:<?php echo esc_attr($width_custom_image); ?>px;height:<?php echo esc_attr($height_custom_image); ?>px; ">
            </p>
            <?php } else { ?>
            
            
        <?php if($icon_gradient == "on"){ ?>
         <?php } elseif($icon_gradient == "yes") { ?>
						<i class="<?php echo esc_attr($icon); ?>" aria-hidden="true" style="background: -webkit-linear-gradient(135deg,<?php echo esc_attr($icon_color_gradient_1); ?>, <?php echo esc_attr($icon_color_gradient_2); ?>);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;"></i>
						  <?php } else { ?>
						   <?php if($icon_beside == "yes"){ ?>
                      <i class="<?php echo esc_attr($icon); ?> icon-with-bg" aria-hidden="true" style="color:<?php echo esc_attr($icon_color); ?>; background:<?php echo esc_attr($icon_bg_color); ?>; "></i>
                      
                       <?php } else { ?>
                       
                        <i class="<?php echo esc_attr($icon); ?>" aria-hidden="true" style="color:<?php echo esc_attr($icon_color); ?>;"></i>
                        
                         <?php } ?>
                    <?php } ?>
                    
                    <?php } ?>
			</div>
			<?php if($icon_beside == "yes"){ ?>
		
				<div class="icon-beside-title-text" style="color:<?php echo esc_attr($content_color); ?>; text-align:<?php echo esc_attr($content_align); ?>;">
				    	<h4 style="color:<?php echo esc_attr($title_color); ?>; font-size:<?php echo esc_attr($title_font_size); ?>;"><?php echo esc_attr($title); ?></h4>
				    <div class="icon-box-content">	
				     <?php echo $content; ?>
				    <?php if($cbtn_url){ ?>		
		    <div class="qb-custom-button" style="text-align:<?php echo esc_attr($btn_align); ?>;margin-top:<?php echo esc_attr($cbtn_margin_top); ?>;margin-bottom:<?php echo esc_attr($cbtn_margin_bottom); ?>;">
		        <a href="<?php echo esc_attr($cbtn_url); ?>" class="btn qb-btn-cs" style="background:<?php echo esc_attr($cbtn_bg_color); ?>;color:<?php echo esc_attr($cbtn_text_color); ?>;"><?php echo esc_attr($cbtn_text); ?></a>
		    </div>
		    <?php } ?></div>
				   
				    
				    
				    </div>
			<?php } else { ?>
			<h4 style="color:<?php echo esc_attr($title_color); ?>;text-align:<?php echo esc_attr($title_align); ?>;font-size:<?php echo esc_attr($title_font_size); ?>;"><?php echo esc_attr($title); ?></h4>
			<div class="icon-box-content">
				<div style="color:<?php echo esc_attr($content_color); ?>; text-align:<?php echo esc_attr($content_align); ?>;"><?php echo $content; ?>
				</div>
					<?php if($cbtn_url){ ?>		
		    <div class="qb-custom-button" style="text-align:<?php echo esc_attr($btn_align); ?>;margin-top:<?php echo esc_attr($cbtn_margin_top); ?>;margin-bottom:<?php echo esc_attr($cbtn_margin_bottom); ?>;">
		        <a href="<?php echo esc_attr($cbtn_url); ?>" class="btn qb-btn-cs" style="background:<?php echo esc_attr($cbtn_bg_color); ?>;color:<?php echo esc_attr($cbtn_text_color); ?>;"><?php echo esc_attr($cbtn_text); ?></a>
		    </div>
		    <?php } ?>
				</div>
			<?php } ?>
				
			
		</div>
		
		
		</div><?php echo $this->endBlockComment('dm_icon_box'); ?>
        
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "dm_icon_box",
    "name"      => __('Mayosis Icon Box', 'mayosis'),
    "description"      => __('Mayosis Text with icon', 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __('Mayosis Elements', 'mayosis'),
    "params"    => array(
	
		array(
            "type" => "textfield",
            "heading" => __('Title', 'mayosis'),
            "param_name" => "title",
          
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
		    array(
                        'type' => 'attach_image',
                        'heading' => __( 'Custom Image', 'mayosis' ),
                        'param_name' => 'custom_image',
                        "group" => 'General',
                        'description' => __( 'Upload Custom Icon', 'mayosis' ),
                    ), 
		array(
            "type" => "textfield",
            "heading" => __('Custom Icon Width', 'mayosis'),
            "param_name" => "width_custom_image",
            'description' => __( 'Input without px', 'mayosis' ),
			"value" => '',
			"group" => 'General',
        ),
        array(
            "type" => "textfield",
            "heading" => __('Custom Icon Height', 'mayosis'),
            "param_name" => "height_custom_image",
            'description' => __( 'Input without px', 'mayosis' ),
			"value" => '',
			"group" => 'General',
        ),
		array(
            "type" => "colorpicker",
            "heading" => __('Icon Color', 'mayosis'),
            "param_name" => "icon_color",
			"value" => '#2C5C82',
			"group" => 'Style',
        ),
		
		array(
            "type" => "colorpicker",
            "heading" => __('Title Color', 'mayosis'),
            "param_name" => "title_color",
			"value" => '#2C5C82',
			"group" => 'Style',
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __('Icon Background Color', 'mayosis'),
            "param_name" => "icon_bg_color",
			"value" => '#5a00f0',
			"group" => 'Style',
			"dependency" => Array('element' => "icon_beside", 'value' => array('yes'))
        ),
        
        
        
        array(
            "type" => "colorpicker",
            "heading" => __('Content Color', 'mayosis'),
            "param_name" => "content_color",
			"value" => '#ffffff',
			"group" => 'Style',
        ),
        
	array(
            "type" => "dropdown",
            "heading" => __('Alignment of Icon', 'mayosis'),
            "param_name" => "icon_align",
            "description" => __('Choose Icon Align', 'mayosis'),
			"value"      => array( 'Left' => 'left', 'Center' => 'center', 'Right' => 'right' ), //Add default value in $atts
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
            "heading" => __('Alignment of Button', 'mayosis'),
            "param_name" => "btn_align",
            "description" => __('Choose Button Align', 'mayosis'),
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
            "type" => "textfield",
            "heading" => __('Title Font Size (with px)', 'mayosis'),
            "param_name" => "title_font_size",
			"group" => 'Style',
        ),
		
	array(
            "type" => "dropdown",
            "heading" => __('Gradient Icon', 'mayosis'),
            "param_name" => "icon_gradient",
            "description" => __('Choose Gradient or Not', 'mayosis'),
			"value"      => array( 'No' => 'no','Yes' => 'yes' ), //Add default value in $atts
			"group" => 'Style',
        ),
        
        array(
            "type" => "dropdown",
            "heading" => __('Icon Beside Title', 'mayosis'),
            "param_name" => "icon_beside",
            "description" => __('Choose Icon Position', 'mayosis'),
			"value"      => array( 'No' => 'no','Yes' => 'yes' ), //Add default value in $atts
			"group" => 'Style',
        ),
		
	
		array(
            "type" => "colorpicker",
            "heading" => __('Icon Color Gradient One', 'mayosis'),
            "param_name" => "icon_color_gradient_1",
          
			"value" => '#05efd7',
			"group" => 'Style',
			"dependency" => Array('element' => "icon_gradient", 'value' => array('yes'))
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __('Icon Color Gradient Two', 'mayosis'),
            "param_name" => "icon_color_gradient_2",
          
			"value" => '#4434f6',
			"group" => 'Style',
			"dependency" => Array('element' => "icon_gradient", 'value' => array('yes'))
        ),
        
        array(
            "type" => "dropdown",
            "heading" => __('Custom Image Background Type', 'mayosis'),
            "param_name" => "ci_bg_type",
            "description" => __('Choose Image Background Type', 'mayosis'),
			"value"      => array( 'Color' => 'color','Gradient' => 'gradient' ), //Add default value in $atts
			"group" => 'Style',
        ),
        
         array(
            "type" => "colorpicker",
            "heading" => __('Custom Image Background Color', 'mayosis'),
            "param_name" => "cimage_bg_color",
			"group" => 'Style',
			"dependency" => Array('element' => "ci_bg_type", 'value' => array('color'))
        ),
        
        array(
            "type" => "colorpicker",
            "heading" => __('Custom Image Background Gradient One', 'mayosis'),
            "param_name" => "cimage_g1_color",
			"group" => 'Style',
			"dependency" => Array('element' => "ci_bg_type", 'value' => array('gradient'))
        ),
        
         array(
            "type" => "colorpicker",
            "heading" => __('Custom Image Background Gradient Two', 'mayosis'),
            "param_name" => "cimage_g2_color",
			"group" => 'Style',
			"dependency" => Array('element' => "ci_bg_type", 'value' => array('gradient'))
        ),
        
        array(
            "type" => "textfield",
            "heading" => __('Custom Image Background Padding (with px)', 'mayosis'),
            "param_name" => "cimage_padding",
			"group" => 'Style',
        ),
        
         array(
            "type" => "textfield",
            "heading" => __('Custom Image Background Border radius (with px or %)', 'mayosis'),
            "param_name" => "cimage_bradius",
			"group" => 'Style',
        ),
        
        array(
            "type" => "textfield",
            "heading" => __('Custom Image Stacked on Top (with px or %)', 'mayosis'),
            "param_name" => "cimage_stack_top",
			"group" => 'Style',
        ),
        
        array(
            "type" => "colorpicker",
            "heading" => __('Custom Button Background Color', 'mayosis'),
            "param_name" => "cbtn_bg_color",
			"group" => 'Style',
        ),
        
         array(
            "type" => "colorpicker",
            "heading" => __('Custom Button Text Color', 'mayosis'),
            "param_name" => "cbtn_text_color",
			"group" => 'Style',
        ),
        
        array(
            "type" => "textfield",
            "heading" => __('Custom Button Margin Top (with px or %)', 'mayosis'),
            "param_name" => "cbtn_margin_top",
			"group" => 'Style',
        ),
        
         array(
            "type" => "textfield",
            "heading" => __('Custom Button Margin Bottom (with px or %)', 'mayosis'),
            "param_name" => "cbtn_margin_bottom",
			"group" => 'Style',
        ),
        array(
            "type" => "textfield",
            "heading" => __('Custom Button Text', 'mayosis'),
            "param_name" => "cbtn_text",
			"group" => 'General',
        ),
        
        array(
            "type" => "textfield",
            "heading" => __('Custom Button URL', 'mayosis'),
            "param_name" => "cbtn_url",
			"group" => 'General',
        ),
        
		array(
            "type" => "textarea",
            "heading" => __('Content', 'mayosis'),
            "param_name" => "content",
			"group" => 'General',
            //"description" => __("Enter a short description for your service.", 'mayosis')
        ),
        	array(
            "type" => "textfield",
            "heading" => __("Custom Class", 'mayosis'),
            "param_name" => "custom_class",
            "description" => __("Add a custom Class.", 'mayosis'),
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