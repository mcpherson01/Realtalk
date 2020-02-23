<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_dm_testimonial extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;

        extract(shortcode_atts(array(
            "num_of_posts" => '3',
            "post_order" => 'DESC',
            "display_type" => '1',
            "carousel_arrow" => '1',
            "carousel_thumbnail" => '1',
            "pre_title_color" => '#c2c9cc',
            "title_color" => '#ffffff',
            "author_color" => '#c2c9cc',
            "grid_description_color" => '#c2c9cc',
            "grid_designation_color" => '#c2c9cc',
            "span_color" => '#ffffff',
            'section_title' =>'',
            'sub_title' =>'',
            'title_sec_margin' => '',
            'button_text' => '',
            'button_link' => '',
            'button_style' => ''
        ), $atts));


        /* ================  Render Shortcodes ================ */

        ob_start();


        //Fetch data
        $arguments = array(
            'post_type' => 'testimonial',
            'post_status' => 'publish',
            //'posts_per_page' => -1,
            'order' => (string) trim($post_order),
            'posts_per_page' => $num_of_posts,
            'ignore_sticky_posts' => 1
            //'tag' => get_query_var('tag')
        );

        $query = new WP_Query( $arguments );


        ?>

        <?php
        //$img = wp_get_attachment_image_src($el_image, "large"); 
        //$imgSrc = $img[0];
        ?>
         <div class="title--box--full" style="margin-bottom:<?php echo esc_attr($title_sec_margin); ?>;">
            <div class="title--promo--box">
                <h3 class="section-title"><?php echo esc_attr($section_title); ?> </h3>
                <?php
                if ($sub_title ) { ?>
                    <p><?php echo esc_attr($sub_title); ?></p>
                <?php } ?>
            </div>

            <div class="title--button--box">
                <?php
                if ($button_link) { ?>
                    <a href="<?php echo esc_attr($button_link); ?>" class="btn title--box--btn <?php echo esc_attr($button_style);?>"><?php echo esc_attr($button_text); ?></a>
                <?php } ?>
            </div>
        </div>
        <?php if($display_type == "1"){ ?>
            <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="testimonal-promo">
                    <?php $pre_title = get_field( 'pre_title' ); ?>
                    <?php if ( $pre_title ) { ?>
                        <small style=" color: <?php echo esc_attr($pre_title_color); ?>;"><?php echo esc_html($pre_title); ?></small>
                    <?php } ?>
                    <h2 style=" color: <?php echo esc_attr($title_color); ?>;">&#34;<?php the_title(); ?>&#34;</h2>
                    <?php $testimonial_author_name = get_field( 'testimonial_author_name' ); ?>
                    <?php if ( $testimonial_author_name ) { ?>
                        <p style="color: <?php echo esc_attr($author_color); ?>;"><span style="color: <?php echo esc_attr($span_color); ?>;">By</span> <?php echo esc_html($testimonial_author_name); ?></p>
                    <?php } ?>

                </div>
            <?php endwhile; else: ?>
                <div class="col-lg-12 pm-column-spacing">
                    <p><?php echo esc_attr('No posts were found.', 'mayosis'); ?></p>
                </div>
            <?php endif; ?>
        <?php } elseif($display_type == "2") { ?>

            <div id="testimonial_carousel_dm" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">


                    <?php if($query->have_posts()) : ?>
                        <?php $i = 0; ?>
                        <?php while($query->have_posts()) : $query->the_post() ?>
                            <div class="item <?php if($i === 0): ?>active<?php endif; ?> testimonal-promo">


                                <?php if($carousel_thumbnail == 1){ ?>
                                    <?php
                                    // display featured image?
                                    if ( has_post_thumbnail() ) :
                                        the_post_thumbnail( 'full', array( 'class' => 'img-responsive center-block img-circle' ) );
                                    endif;

                                    ?>
                                <?php } else { ?>
                                <?php } ?>
                                <?php $pre_title = get_field( 'pre_title' ); ?>
                                <?php if ( $pre_title ) { ?>
                                    <small style=" color: <?php echo esc_attr($pre_title_color); ?>;"><?php echo esc_html($pre_title); ?></small>
                                <?php } ?>
                                <h2 style=" color: <?php echo esc_attr($title_color); ?>;">&#34;<?php the_title(); ?>&#34;</h2>
                                <?php $testimonial_author_name = get_field( 'testimonial_author_name' ); ?>
                                <?php if ( $testimonial_author_name ) { ?>
                                    <p style="color: <?php echo esc_attr($author_color); ?>;" ><span style="color: <?php echo esc_attr($span_color); ?>;">By</span> <?php echo esc_html($testimonial_author_name); ?></p>
                                <?php } ?>
                            </div>

                            <?php $i++; ?>
                        <?php endwhile ?>
                    <?php endif ?>




                    <!-- Element Code / END -->

                    <?php wp_reset_postdata(); ?>
                </div>
                <!-- Controls -->
                <?php if($carousel_arrow == "1"){ ?>
                    <a class="left carousel-control" href="#testimonial_carousel_dm" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#testimonial_carousel_dm" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                <?php } else { ?>

                <?php } ?>
            </div>
        <?php } else { ?>
        <div class="testimonial-grid-carousel">
             <?php if($carousel_arrow == "1"){ ?>
        <div class="slideControls">
            <a class="slidePrev">
              <i class="fa fa-angle-left"></i>
             </a>
            <a class="slideNext">
              <i class="fa fa-angle-right"></i>
            </a>
      </div> 
      <?php } ?>
            <ul id="carousel-testimonial">
                <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
                    <li class="col-md-4 grid_style">
                        <div class="grid-testimonal-promo">
                            <div class="testimonial_details" style="color: <?php echo esc_attr($grid_description_color); ?>;">

                                <?php the_field('testimonial_small_description(_for_grid_style_only)'); ?>

                            </div>
                            <div class="arrow-down"></div>

                            <?php $testimonial_author_name = get_field( 'testimonial_author_name' ); ?>

                            <div class="testimonial-grid-author">
                                 <?php if($carousel_thumbnail == 1){ ?>
                                <div class="grid_photo text-center">
                                    <?php
                                    // display featured image?
                                    if ( has_post_thumbnail() ) :
                                        the_post_thumbnail( 'full', array( 'class' => 'img-responsive img-circle grid-thumbnail-left' ) );
                                    endif;

                                    ?>
                                </div>
                                <?php } ?>
                                <?php if ( $testimonial_author_name ) { ?>
                                    <div class="testimonial_grid_titles  text-center">
                                        <h4 class="grid_main_author" style="color: <?php echo esc_attr($author_color); ?>;"><?php echo esc_html($testimonial_author_name); ?></h4>
                                        <p class="grid_designation" style="color: <?php echo esc_attr($grid_designation_color); ?>;"><?php the_field('testimonial_author_job_title'); ?></p>

                                    </div>
                                    <div class="clearfix"></div>
                                <?php } ?>
                            </div>


                        </div>
                    </li>
                <?php endwhile; else: ?>

                    <div class="col-lg-12 pm-column-spacing">
                        <p><?php esc_html_e('No Testimonial were found.', 'mayosis'); ?></p>
                    </div>
                <?php endif; ?>
            </ul>
            </div>
        <?php } ?>


        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "dm_testimonial",
    "name"      => __("Mayosis Testimonial", 'mayosis'),
    "description"      => __("Mayosis Client Testimonial", 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __("Mayosis Elements", 'mayosis'),
    "params"    => array(
            array(
                        'type' => 'textfield',
                        'heading' => __( 'Section Title', 'mayosis' ),
                        'param_name' => 'section_title',
                        'value' => __( 'Recent Edd', 'mayosis' ),
                        'description' => __( 'Title for Recent Section', 'mayosis' ),
                    ), 
        array(
			    "heading" => __( "Subtitle", "mayosis" ),
                "description" => __("Enter Sub title","mayosis"),
                 "param_name" => "sub_title",
                "type" => "textfield",
                
			    ),
		
			array(
			    "heading" => __( "Title Margin Bottom", "mayosis" ),
                "description" => __("Title Section Margin Bottom (With px)","mayosis"),
                 "param_name" => "title_sec_margin",
                "type" => "textfield",
                
			    ),
			    
			    array(
			    "heading" => __( "Button Text", "mayosis" ),
                "description" => __("Enter Button Text","mayosis"),
                 "param_name" => "button_text",
                "type" => "textfield",
                
			    ),
			    
			     array(
			    "heading" => __( "Button URL", "mayosis" ),
                "description" => __("Enter Button URL","mayosis"),
                 "param_name" => "button_link",
                "type" => "textfield",
                
			    ),
		
			array(
                    "type" => "dropdown",
            "heading" => __("Button Style", 'mayosis'),
            "param_name" => "button_style",
            "description" => __("Set Button Style", 'mayosis'),
			"value"      => array( 'Solid' => 'solid', 'Ghost' => 'transparent'), //Add default value in $atts
        ),
        array(
            "type" => "textfield",
            "heading" => __("Amount of Testimonial to display:", 'mayosis'),
            "param_name" => "num_of_posts",
            "description" => __("Choose how many news posts you would like to display.", 'mayosis'),
            "value"      => (''), //Add default value in $atts
        ),

        array(
            "type" => "dropdown",
            "heading" => __("Testimonial Order", 'mayosis'),
            "param_name" => "post_order",
            "description" => __("Set the order in which news posts will be displayed.", 'mayosis'),
            "value"      => array( 'DESC' => 'DESC', 'ASC' => 'ASC'), //Add default value in $atts
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Display Type", 'mayosis'),
            "param_name" => "display_type",
            "description" => __("Set how testimonial will be displayed.", 'mayosis'),
            "value"      => array( 'Normal' => '1', 'Carousel' => '2','Grid' => '3'), //Add default value in $atts
        ),

        array(
            "type" => "dropdown",
            "heading" => __("Carousel Arrow", 'mayosis'),
            "param_name" => "carousel_arrow",
            "description" => __("Set Carousel Arrow Display or Not.", 'mayosis'),
            "value"      => array( 'Yes' => '1', 'No' => '2'), //Add default value in $atts
        ),

        array(
            "type" => "dropdown",
            "heading" => __("Thumbnail Show/Hide", 'mayosis'),
            "param_name" => "carousel_thumbnail",
            "description" => __("Set Carousel Thumbnail Display Type.", 'mayosis'),
            "value"      => array( 'Yes' => '1', 'No' => '2'), //Add default value in $atts
        ),
        array(
            "type" => "colorpicker",
            "heading" => __("Color of Pre Title Unit", 'mayosis'),
            "param_name" => "pre_title_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
            "value" => '#c2c9cc',
            "group" => 'Style',
        ),

        array(
            "type" => "colorpicker",
            "heading" => __("Color of Main Title", 'mayosis'),
            "param_name" => "title_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
            "value" => '#ffffff',
            "group" => 'Style',
        ),
        array(
            "type" => "colorpicker",
            "heading" => __("Color of Author Title", 'mayosis'),
            "param_name" => "author_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
            "value" => '#c2c9cc',
            "group" => 'Style',
        ),
        array(
            "type" => "colorpicker",
            "heading" => __("Color of Span", 'mayosis'),
            "param_name" => "span_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
            "value" => '#ffffff',
            "group" => 'Style',
        ),

        array(
            "type" => "colorpicker",
            "heading" => __("Color of Grid Description", 'mayosis'),
            "param_name" => "grid_description_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
            "value" => '#c2c9cc',
            "group" => 'Style',
        ),


        array(
            "type" => "colorpicker",
            "heading" => __("Color of Designation", 'mayosis'),
            "param_name" => "grid_designation_color",
            //"description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),
            "value" => '#c2c9cc',
            "group" => 'Style',
        ),

    )

));