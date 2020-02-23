<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_digital_edd extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
            $css = '';
        extract(shortcode_atts(array(
			"featured_title" => 'Featured Edd',
			"num_of_posts" => '3',
			"column_of_posts" => '1',
			"post_order" => 'DESC',
			'free_product_label' => '1',
			'custom_text' => '',
			'sub_title' =>'',
			'title_sec_margin' =>'',
			'button_text' =>'',
			'button_link' =>'',
			'button_style' =>'',
			'css' => ''
        ), $atts));
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

        /* ================  Render Shortcodes ================ */

        ob_start();
		
		
		//Fetch data
		$arguments = array(
			'post_type' => 'download',
			'post_status' => 'publish',
			//'posts_per_page' => -1,
			'order' => (string) trim($post_order),
			'posts_per_page' => $num_of_posts,
			'ignore_sticky_posts' => 1,
            'meta_key' => 'edd_feature_download',
			//'tag' => get_query_var('tag')
		);
	
		$post_query = new WP_Query($arguments);
	

        ?>
        
        	<?php 
        	global $post;
$productthumbvideo= get_theme_mod( 'thumbnail_video_play','show' );
$productthumbposter= get_theme_mod( 'thumbnail_video_poster','show' );
$productvcontrol= get_theme_mod( 'thumb_video_control','minimal' );
$productcartshow= get_theme_mod( 'thumb_cart_button','hide' );
$productthumbhoverstyle= get_theme_mod( 'product_thmub_hover_style','style1' );
?>
<div class="<?php echo esc_attr( $css_class ); ?> edd_fetured_ark">
        <!-- Element Code start -->
        <div class="title--box--full" style="margin-bottom:<?php echo esc_attr($title_sec_margin); ?>;">
            <div class="title--promo--box">
                <h3 class="section-title"><?php  echo esc_attr($featured_title) ?></h3>
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
       
       <?php $featured_downloads = new WP_Query( $arguments );

if( $featured_downloads->have_posts() ) : ?>
        
      <div<?php echo ($num_of_posts > 3 ? ' id="digital_post"' : ''); ?>>
      
      <div class="row fix">
       <?php while( $featured_downloads->have_posts() ) : $featured_downloads->the_post(); ?>
        
         <?php if($column_of_posts == "1"){ ?>
                          <div class="col-md-4 col-xs-12 col-sm-4 product-grid">
                    <?php } elseif($column_of_posts == "2") { ?>
                       <div class="col-md-6 col-xs-12 col-sm-6 product-grid">
                    <?php } elseif($column_of_posts == "3") { ?>
                       <div class="col-md-4 col-xs-12 col-sm-4 product-grid">
                        <?php } elseif($column_of_posts == "4") { ?>
                       <div class="col-md-3 col-xs-12 col-sm-3 product-grid">
                       <?php } elseif($column_of_posts == "5") { ?>
                       <div class="col-md-5ths col-xs-12 col-sm-5ths product-grid">
                        <?php } elseif($column_of_posts == "6") { ?>
                       <div class="col-md-2 col-xs-12 col-sm-2 product-grid">
                    <?php } else { ?>
                       <div class="col-md-4 col-xs-12 col-sm-4 product-grid">
                    <?php } ?> 
               
						
						   <div class="grid_dm group edge">
						   <div class="product-box">
						   <?php $postdate = get_the_time('Y-m-d'); // Post date
                                $postdatestamp = strtotime($postdate); 
                                
                                $riboontextfet = get_theme_mod('featured_ribbon_text', 'Featured'); // Newness in days
                                
                                $newnessfet = get_theme_mod('featured_ribbon_time', '30'); // Newness in days
                                if ((time() - (60 * 60 * 24 * $newnessfet)) < $postdatestamp) { // If the product was published within the newness time frame display the new badge
                                    echo '<div class="wrap-ribbon left-edge point lblue"><span>' . esc_html($riboontextfet) . '</span></div>';
                                } ?>
					<figure class="mayosis-fade-in">

                    
                        <?php if ($productthumbvideo=='show'){ ?>
                        <?php if ( has_post_format( 'video' )) { ?>
                    
                        <div class="mayosis--video--box">
                            <div class="video-inner-box-promo">
                    
                                <a href="<?php the_permalink();?>" class="mayosis-video-url"></a>
                                <div class="video-inner-main">
                                    <?php get_template_part( 'library/mayosis-video-box-thumb' ); ?>
                                </div>
                                <div class="clearfix"></div>
                                <?php if ($productcartshow=='show'){ ?>
                                    <div class="product-cart-on-hover">
                                        <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>
                                    </div>
                                <?php }?>
                                <?php if ($productvcontrol=='minimal'){ ?>
                                    <div class="minimal-video-control">
                                        <div class="minimal-control-left">
                    
                                            <?php if ( function_exists( 'edd_favorites_load_link' ) ) {
                                                edd_favorites_load_link( $download_id );
                                            } ?>
                                        </div>
                    
                    
                    
                                        <div class="minimal-control-right">
                                            <ul>
                                                <li>	<?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>  </li>
                                                <?php $mayosis_video = get_post_meta($post->ID, 'video_url',true);?>
                                                <li><a href="<?php echo esc_attr($mayosis_video); ?>" data-lity>
                                                        <i class="fa fa-arrows-alt" aria-hidden="true"></i></a></li>
                    
                                            </ul>
                                        </div>
                    
                                    </div>
                                <?php } ?>
                            </div>
                    
                    
                    
                    
                    
                    
                            <?php } else { ?>
                            <div class="mayosis--thumb">
                                <?php get_template_part( 'includes/product-grid-thumbnail' ); ?>
                                <?php } ?>
                    
                                <?php } else { ?>
                    
                                <div class="mayosis--thumb">
                                    <?php get_template_part( 'includes/product-grid-thumbnail' ); ?>
                                    <?php } ?>
                                    <figcaption>
                                        <?php
                if ($productthumbhoverstyle=='style2') { ?>
                <a href="<?php the_permalink();?>" class="full-thumb-hover-plus">
                <i class="zil zi-plus"></i>
                </a>
                <?php } else { ?>
                                        <div class="overlay_content_center">
                                            <?php get_template_part( 'includes/product-hover-content-top' ); ?>
                    
                                            <div class="product_hover_details_button">
                                                <a href="<?php the_permalink(); ?>" class="button-fill-color"><?php esc_html_e('View Details', 'mayosis'); ?></a>
                                            </div>
                                            <?php
                                            $demo_link = get_post_meta(get_the_ID(), 'demo_link', true);
                                            $livepreviewtext= get_theme_mod( 'live_preview_text','Live Preview' );
                                            ?>
                                            <?php if ( $demo_link ) { ?>
                                                <div class="product_hover_demo_button">
                                                    <a href="<?php echo esc_url($demo_link); ?>" class="live_demo_onh" target="_blank"><?php echo esc_html($livepreviewtext); ?></a>
                                                </div>
                                            <?php } ?>
                    
                                            <?php get_template_part( 'includes/product-hover-content-bottom' ); ?>
                                        </div>
                                        <?php } ?>
                                    </figcaption>
                                </div>
                    </figure>
				<div class="product-meta">
						 <?php get_template_part( 'includes/product-meta' ); ?>
							
						</div>
					
				</div>
                       	</div>
						   
						   </div>
						  
		     <?php endwhile; ?>
		  </div>
	  </div>
						   </div><?php echo $this->endBlockComment('digital_edd'); ?>
						   <div class="clearfix"></div>
        <!-- Element Code / END -->
        
      <?php endif; wp_reset_postdata(); ?>

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "digital_edd",
    "name"      => __("Mayosis Featured Grid", 'mayosis'),
    "description"      => __("Mayosis Easy Digital Download Featured", 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __("Mayosis Elements", 'mayosis'),
    "params"    => array(
	 array(
                        'type' => 'textfield',
                        'heading' => __( 'Section Title', 'mayosis' ),
                        'param_name' => 'featured_title',
                        'value' => __( 'Featured Edd', 'mayosis' ),
                        'description' => __( 'Title for Featured Section', 'mayosis' ),
                    ), 

		array(
            "type" => "textfield",
            "heading" => __("Amount of Edd Featured to display:", 'mayosis'),
            "param_name" => "num_of_posts",
            "description" => __("Choose how many news posts you would like to display.", 'mayosis'),
			'value' => __( '3' , 'mayosis' ),
        ),
	
	array(
            "type" => "dropdown",
            "heading" => __("Amount of Edd Featured Column:", 'mayosis'),
            "param_name" => "column_of_posts",
            "description" => __("Choose how many news posts you would like to display.", 'mayosis'),
			"value"      => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'), //Add default value in $atts
        ),
	
	array(
            "type" => "dropdown",
            "heading" => __("Free Product Label(Download Count/ Free Label):", 'mayosis'),
            "param_name" => "free_product_label",
            "description" => __("Choose How You want to show Free Product Label", 'mayosis'),
			"value"      => array( 'Download Count' => '1', 'Free Text Only' => '2'), //Add default value in $atts
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
			"heading" => __("Custom text", 'mayosis'),
            "param_name" => "custom_text",
			"value" =>'',
			"description" => __("Set Custom text i.e. FREE", 'mayosis'),
			"dependency" => Array('element' => "free_product_label", 'value' => array('2'))
		),
		array(
            "type" => "dropdown",
            "heading" => __("Post Order", 'mayosis'),
            "param_name" => "post_order",
            "description" => __("Set the order in which news posts will be displayed.", 'mayosis'),
			"value"      => array( 'DESC' => 'DESC', 'ASC' => 'ASC'), //Add default value in $atts
        ),
		
	
		array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),

    )

));