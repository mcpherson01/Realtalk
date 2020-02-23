<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_digital_edd_hero extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
$css = '';
        extract(shortcode_atts(array(
			"edd_hero_title_prefix" => 'We Are The Secret Behind',
			"type_of_counter" => '1',
			"edd_custom_count" => '2580',
			"title_align" => 'left',
			"title_color" => '#ffffff',
			"count_color" => '#ffffff',
			"countent_color" => '#ffffff',
			"gap_title_desc" => "",
			'css' => '',
			"edd_hero_title_suffix" => 'Graphic Designers',
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
      
        <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 <?php echo esc_attr( $css_class ); ?>" style="text-align: <?php echo esc_attr($title_align); ?>;">
                    <h1 class="hero-title" style="color:<?php echo esc_attr($title_color); ?>"><?php echo esc_attr($edd_hero_title_prefix); ?>
                    
                   <span style="color:<?php echo esc_attr($count_color); ?>">  <?php if($type_of_counter == "1"){ ?>
                          <?php 
                                        $args = array(
                                            'post_type' => 'download',
                                            'posts_per_page'    => -1,
											'download_category' => ''
                                        );
                                        $query = new WP_Query($args);
                                     ?>
                                     <?php echo $query->found_posts; ?>
                        <?php } elseif($type_of_counter == "2") { ?>
                      <?php echo edd_count_total_file_downloads(); ?>
                    <?php } else { ?>
                       <?php echo esc_attr($edd_custom_count); ?>
					   <?php } ?></span>
                        <?php echo esc_attr($edd_hero_title_suffix); ?></h1>
                    <div class="hero-description" style="color:<?php echo esc_attr($countent_color); ?> !important; margin-top:<?php echo esc_attr($gap_title_desc); ?>;"><?php echo $content; ?></div>
                   
			    </div><?php echo $this->endBlockComment('digital_edd_hero'); ?>
			    <div class="clearfix"></div>
			    </div>
		
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "digital_edd_hero",
    "name"      => __("Mayosis EDD Hero", 'mayosis'),
    "description"      => __("Mayosis Easy Digital Download Hero", 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __("Mayosis Elements", 'mayosis'),
    "params"    => array(
	 array(
                        'type' => 'textfield',
                        'heading' => __( 'Section Title Prefix', 'mayosis' ),
                        'param_name' => 'edd_hero_title_prefix',
                        'value' => __( 'We Are The Secret Behind', 'mayosis' ),
                        'description' => __( 'Title Prefix Of Count', 'mayosis' ),
                    ), 
	array(
            "type" => "dropdown",
            "heading" => __("Counter Type:", 'mayosis'),
            "param_name" => "type_of_counter",
            "description" => __("Type of Counter", 'mayosis'),
			"value"      => array( 'Total Product' => '1', 'Total Download' => '2', 'Custom Count' => '3' ), //Add default value in $atts
        ),
	 array(
                        'type' => 'textfield',
                        'heading' => __( 'Custom Count', 'mayosis' ),
                        'param_name' => 'edd_custom_count',
                        'value' => __( '2532', 'mayosis' ),
                        'description' => __( 'Input Integear Value', 'mayosis' ),
                    ), 
	
	 array(
                        'type' => 'textfield',
                        'heading' => __( 'Section Title Suffix', 'mayosis' ),
                        'param_name' => 'edd_hero_title_suffix',
                        'value' => __( 'Graphic Designers', 'mayosis' ),
                        'description' => __( 'Title Suffix Of Count', 'mayosis' ),
                    ), 
	
	 array(
                        'type' => 'textarea_html',
                        'heading' => __( 'Section Description', 'mayosis' ),
                        'param_name' => 'content',
                        'value' => __( 'High End Graphic Templates &amp; Resources such as Graphic Objects, Add Ons, PSD Templates, Photo Packs, Backgrounds, UI Kits and so on...
    Browse, Download &amp; Use Our Resources To Design Faster &amp; Get Your Payment Quicker!', 'mayosis' ),
                        'description' => __( 'Description of the Section', 'mayosis' ),
                    ), 
array(
            "type" => "dropdown",
            "heading" => __("Alignment of Text", 'mayosis'),
            "param_name" => "title_align",
            "description" => __("Choose Alignement Of Text", 'mayosis'),
			"value"      => array( 'Left' => 'left', 'Center' => 'center', 'Right' => 'right' ), //Add default value in $atts
			"group" => 'Style',
        ),
		
		array(
                        'type' => 'textfield',
                        'heading' => __( 'Gap in Title & Description', 'mayosis' ),
                        'param_name' => 'gap_title_desc',
                        'description' => __( 'Add gap between title & description (i.e 22px)', 'mayosis' ),
                        
                        	"group" => 'Style',
                    ),
		
	
		array(
            "type" => "colorpicker",
            "heading" => __("Color Of Prefix & Suffix", 'mayosis'),
            "param_name" => "title_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#ffffff',
			"group" => 'Style',
        ),
	
		array(
            "type" => "colorpicker",
            "heading" => __("Color Of Count", 'mayosis'),
            "param_name" => "count_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#ffffff',
			"group" => 'Style',
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