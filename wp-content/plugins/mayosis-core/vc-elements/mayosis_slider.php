<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_dm_slider extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;

      	$css = '';
        extract(shortcode_atts(array(
			"num_of_posts" => '3',
			"post_order" => 'DESC',
			"display_type" => '1',
			"carousel_arrow" => '1',
			"content_color" => '#c2c9cc',
			"title_color" => '#ffffff',
			"author_color" => '#c2c9cc',
			"grid_description_color" => '#c2c9cc',
			"grid_designation_color" => '#c2c9cc',
			"span_color" => '#ffffff',
			"button_b_font_color" => '#ffffff',
			"button_a_font_hover_color" => '#ffffff',
			"button_b_font_hover_color" => '#ffffff',
			"button_a_bg_color" => '#94a63a',
			"button_b_bg_color" => '#94a63a',
			"button_a_border_color" => '#94a63a',
			"button_b_border_color" => '#94a63a',
			"button_a_hoverbg_color" => '#41474d',
			"button_b_hoverbg_color" => '#41474d',
			"button_a_hoverborder_color" => '#41474d',
			"button_b_hoverborder_color" => '#41474d',
			"button_a_font_color" => '#ffffff',
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
        <style>
			h1.slider-title-main{
				color:<?php echo esc_attr($title_color); ?>;
			}
			p.slider_content, .slider_dm_v  .header-text{
				color:<?php echo esc_attr($content_color); ?> !important;
				
			}
		.carousel-inner	.btn_a{
	background: <?php echo esc_attr($button_a_bg_color) ?>;
	border-width: <?php echo esc_attr($dm_border_size) ?>px;
	border-color: <?php echo esc_attr($button_a_border_color) ?>;
	padding: 12px 40px;
	font-weight: 900;
	font-size: <?php echo esc_attr($dm_font_size) ?>px;
	color: <?php echo esc_attr($button_a_font_color) ?>;
	border-radius: <?php echo esc_attr($dm_border_radius) ?>px;
		margin: 10px 0px;
	}
	.carousel-inner .btn_a:hover{
	background: <?php echo esc_attr($button_a_hoverbg_color) ?>;
	border-color: <?php echo esc_attr($button_a_hoverborder_color) ?>;
	color: <?php echo esc_attr($button_a_font_hover_color) ?>;
	}
	
	.carousel-inner .btn_b{
	background: <?php echo esc_attr($button_b_bg_color) ?>;
	border-width: <?php echo esc_attr($dm_border_size) ?>px;
	border-color: <?php echo esc_attr($button_b_border_color) ?>;
	padding: 12px 40px;
	font-weight: 900;
	font-size: <?php echo esc_attr($dm_font_size) ?>px;
	color: <?php echo esc_attr($button_b_font_color) ?>;
	border-radius: <?php echo esc_attr($dm_border_radius) ?>px;
		margin: 10px 0px;
	}
	.carousel-inner .btn_b:hover{
	background: <?php echo esc_attr($button_b_hoverbg_color) ?>;
	border-color: <?php echo esc_attr($button_b_hoverborder_color) ?>;
	color: <?php echo esc_attr($button_b_font_hover_color) ?>;
	}
</style>
      
        <div class="slider_dm_v <?php echo esc_attr( $css_class ); ?>" >
	<div class="row">
		<!-- Carousel -->
    	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    		<?php
	$args = array(
    	'post_type' => 'slider',
    	'post_per_page' =>$num_of_posts,
    	'order' => (string) trim($post_order),
    	'post_status' => 'publish'
	);
	$plumbing_slider = new WP_Query($args);
	?>

			<!-- Indicators -->
			<ol class="carousel-indicators">
			  		<?php
    	for ($i = 0; $i < $plumbing_slider->post_count; $i++) {
        	if ($i == 0) {
            	$class = 'active';
        	} else {
            	$class = '';
        	}
        	?>
        	<li data-target="#carousel-example-generic" data-slide-to="<?php echo esc_attr($i); ?>" class="<?php echo esc_attr($class); ?>"></li>
    	<?php } ?>

			</ol>
			<!-- Wrapper for slides -->
			<div class="carousel-inner">
		    <?php
    	$count = 0;
    	while ($plumbing_slider->have_posts()) {
        	$plumbing_slider->the_post();
        	$class = '';
        	if ($count == 0) {
            	$class = 'active';
        	}
    	?>

			    <div class="item <?php echo esc_attr($class); ?>">
			    	<?php the_post_thumbnail('slide_images'); ?>

                    <!-- Static Header -->
                    <div class="header-text hidden-xs">
                        <div class="col-md-10 col-md-offset-1 col-xs-12 col-sm-12">
                    <h1 class="hero-title slider-title-main"><?php the_title();?></h1>
                    <?php $slidedes = get_field( 'slider_description' ); ?>
                    <?php if ( $slidedes ) { ?>
                    <p class="slider_content"><?php  echo $slidedes; ?></p>
                    <?php } ?>
                    <div class="hero-button" style="text-align: center;">
                       <?php $buttona = get_field( 'button_a_text' ); ?>
                       <?php if ( $buttona ) { ?>
                        <div class="hero-button-group">
                            <a href="<?php the_field( 'button_a_url' ); ?>" class="btn btn-danger btn-lg browse-free btn_a"><?php echo esc_attr($buttona); ?></a>
                            	<?php if ( get_field( 'disable_or_section' ) ): ?>
                            <span class="divide-button">or</span>
								<?php else: ?>

						<?php endif; ?>
                        </div>
 						<?php } ?>
                          <?php $buttonb = get_field( 'button_b_text' ); ?>
                       <?php if ( $buttonb ) { ?>
                        <div class="hero-button-group">
                            <a href="<?php the_field( 'button_b_url' ); ?>" class="btn btn-danger btn-lg premium-button btn_b"><?php echo esc_attr($buttonb); ?></a>
                        </div>
                        <?php } ?>
                    </div>
			    </div>
                    </div><!-- /header-text -->
			    </div>
			   <?php $count++;
    	}
    	?>

			</div>
			  <?php if($carousel_arrow == "1"){ ?>
			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
		    	<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
		    	<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
			<?php } else { ?>
                       
                    <?php } ?>
		</div><!-- /carousel -->
	</div>
</div> <?php echo $this->endBlockComment('dm_slider'); ?>
<div class="clearfix"></div>
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "dm_slider",
    "name"      => __("Mayosis Slider", 'mayosis'),
    "description"      => __("Mayosis Custom Slider", 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __("Mayosis Elements", 'mayosis'),
    "params"    => array(
	
		
	array(
            "type" => "textfield",
            "heading" => __("Amount of Slider to display:", 'mayosis'),
            "param_name" => "num_of_posts",
            "description" => __("Choose how many news slider you would like to display.", 'mayosis'),
			"value"      => (''), //Add default value in $atts
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __("Slider Order", 'mayosis'),
            "param_name" => "post_order",
            "description" => __("Set the order in which slider will be displayed.", 'mayosis'),
			"value"      => array( 'DESC' => 'DESC', 'ASC' => 'ASC'), //Add default value in $atts
        ),
	
	array(
            "type" => "dropdown",
            "heading" => __("Carousel Arrow", 'mayosis'),
            "param_name" => "carousel_arrow",
            "description" => __("Set Carousel Arrow Display or Not.", 'mayosis'),
			"value"      => array( 'Yes' => '1', 'No' => '2'), //Add default value in $atts
        ),
	
	
	array(
            "type" => "colorpicker",
            "heading" => __("Color Of Content", 'mayosis'),
            "param_name" => "content_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#c2c9cc',
			"group" => 'Color',
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __("Color of Main Title", 'mayosis'),
            "param_name" => "title_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#ffffff',
			"group" => 'Color',
        ),
	array(
            "type" => "colorpicker",
            "heading" => __("Font A Color", 'mayosis'),
            "param_name" => "button_a_font_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#ffffff',
			"group" => 'Color',
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __("Separator Color", 'mayosis'),
            "param_name" => "color_seprator",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#666666',
			"group" => 'Color',
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __("Font B Color", 'mayosis'),
            "param_name" => "button_b_font_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#ffffff',
			"group" => 'Color',
        ),
	array(
            "type" => "colorpicker",
            "heading" => __("Font A Hover Color", 'mayosis'),
            "param_name" => "button_a_font_hover_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#ffffff',
			"group" => 'Color',
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __("Font B Hover Color", 'mayosis'),
            "param_name" => "button_b_font_hover_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#ffffff',
			"group" => 'Color',
        ),
		array(
            "type" => "colorpicker",
            "heading" => __("Button A Background Color", 'mayosis'),
            "param_name" => "button_a_bg_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#94a63a',
			"group" => 'Color',
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __("Button B Background Color", 'mayosis'),
            "param_name" => "button_b_bg_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#94a63a',
			"group" => 'Color',
        ),
	array(
            "type" => "colorpicker",
            "heading" => __("Button A Border Color", 'mayosis'),
            "param_name" => "button_a_border_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#94a63a',
			"group" => 'Color',
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __("Button B Border Color", 'mayosis'),
            "param_name" => "button_b_border_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#94a63a',
			"group" => 'Color',
        ),
	array(
            "type" => "colorpicker",
            "heading" => __("Button A Hover Background Color", 'mayosis'),
            "param_name" => "button_a_hoverbg_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#41474d',
			"group" => 'Color',
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __("Button B Hover Background Color", 'mayosis'),
            "param_name" => "button_b_hoverbg_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#41474d',
			"group" => 'Color',
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __("Button A Hover Border Color", 'mayosis'),
            "param_name" => "button_a_hoverborder_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#41474d',
			"group" => 'Color',
        ),
	
	array(
            "type" => "colorpicker",
            "heading" => __("Button B Hover Border Color", 'mayosis'),
            "param_name" => "button_b_hoverborder_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
			"value" => '#41474d',
			"group" => 'Color',
        ),
	array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),
      
    )

));