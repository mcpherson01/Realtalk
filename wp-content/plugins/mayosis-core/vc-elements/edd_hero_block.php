<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_mayosis_edd_hero_product extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
$css = '';
        extract(shortcode_atts(array(
			"recent_section_title" => '',
			"num_of_posts" => '1',
			"column_of_posts" => '3',
			"post_order" => 'DESC',
			'free_product_label' => '1',
			'product_style_option' => '1',
			'sub_title' =>'',
			'title_sec_margin' =>'',
			'products_ids' =>'',
			'button_text' =>'',
			'button_link' =>'',
			'show_single' => '',
			'custom_description' => '',
			'css' => ''
        ), $atts));
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );



        /* ================  Render Shortcodes ================ */
	
	

        ob_start();
		if ($show_single=='SINGLE'){
		$myarray = array($products_ids);
		//Fetch data
		$arguments = array(
			'post_type' => 'download',
			'post_status' => 'publish',
			//'posts_per_page' => -1,
			'order' => (string) trim($post_order),
			'posts_per_page' => 1,
			'ignore_sticky_posts' => 1,
			'post__in'      => $myarray
		);
		} else {
		    
		    $arguments = array(
			'post_type' => 'download',
			'post_status' => 'publish',
			'order' => (string) trim($post_order),
			'posts_per_page' => $num_of_posts,
			'ignore_sticky_posts' => 1,
		);
		}
	
		$post_query = new WP_Query($arguments);
	

        ?>
        
         <div class="row fix">
           <div class="col-md-12">
               
            <div class="title--box--full" style="margin-bottom:<?php echo esc_attr($title_sec_margin); ?>;">
            <div class="title--promo--box">
                <h3 class="section-title"><?php echo esc_attr($recent_section_title); ?> </h3>
                <?php
                if ($sub_title ) { ?>
                    <p><?php echo esc_attr($sub_title); ?></p>
                <?php } ?>
            </div>

            <div class="title--button--box">
                <?php
                if ($button_link) { ?>
                    <a href="<?php echo esc_attr($button_link); ?>" class="btn title--box--btn"><?php echo esc_attr($button_text); ?></a>
                <?php } ?>
            </div>
        </div>
        <?php if ($post_query->have_posts()) : while ($post_query->have_posts()) : $post_query->the_post(); ?>
        <div class="mayosis_block_product">
            <div class="col-md-6 block_product_thumbnail">
               <a href="<?php
                            the_permalink(); ?>"> <?php
                    the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                    ?></a>
            </div>
            <div class="col-md-6 block_product_details single-cart-button">
                <h4><?php the_title(); ?></h4>
                <?php if ($show_single=='RECENT'){ ?>
                   <?php the_excerpt(); ?>
                <?php } else { ?>
                <?php echo esc_attr($custom_description); ?>
                <?php } ?>
                <div class="block_button_details">
                    <a href="<?php
                            the_permalink(); ?>" class="button_accent btn" ><?php esc_html_e('View Details','mayosis');?></a>
                </div>
            </div>
        </div>
         <?php endwhile; ?>
        	</div>
        	</div>
<?php endif; wp_reset_postdata(); ?>
       <?php echo $this->endBlockComment('mayosis_edd_hero_product'); ?>
						   <div class="clearfix"></div>
       
        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "mayosis_edd_hero_product",
    "name"      => __("Mayosis Download Block", 'mayosis'),
    "description"      => __("Edd product block can be used as hero product", 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __("Mayosis Elements", 'mayosis'),
    "params"    => array(
	 array(
                        'type' => 'textfield',
                        'heading' => __( 'Section Title', 'mayosis' ),
                        'param_name' => 'recent_section_title',
                        'value' => __( 'Recent Edd', 'mayosis' ),
                        'description' => __( 'Title for Recent Section', 'mayosis' ),
                    ), 

	
        
        	array(
            "type" => "dropdown",
            "heading" => __("Product Type", 'mayosis'),
            "param_name" => "show_single",
            "description" => __("Set the order in which news posts will be displayed.", 'mayosis'),
			"value"      => array( 'SINGLE' => 'SINGLE', 'RECENT' => 'RECENT'), //Add default value in $atts
        ),
        
        array(
            "type" => "textfield",
            "heading" => __("Product ID", 'mayosis'),
            "param_name" => "products_ids",
            "description" => __("Add Product ID", 'mayosis'),
			'value' => __( '1' , 'mayosis' ),
			"dependency" => Array('element' => "show_single", 'value' => array('SINGLE'))
        ),
        
        array(
            "type" => "textarea",
            "heading" => __('Custom Description', 'mayosis'),
            "param_name" => "custom_description",
            //"description" => __("Enter a short description for your service.", 'mayosis')
            "dependency" => Array('element' => "show_single", 'value' => array('SINGLE'))
        ),
        
        	array(
            "type" => "textfield",
            "heading" => __("Amount of Edd Recent to display:", 'mayosis'),
            "param_name" => "num_of_posts",
            "description" => __("Choose how many news posts you would like to display.", 'mayosis'),
			'value' => __( '1' , 'mayosis' ),
			"dependency" => Array('element' => "show_single", 'value' => array('RECENT'))
        ),
        
        	
		
		array(
            "type" => "dropdown",
            "heading" => __("Post Order", 'mayosis'),
            "param_name" => "post_order",
            "description" => __("Set the order in which news posts will be displayed.", 'mayosis'),
			"value"      => array( 'DESC' => 'DESC', 'ASC' => 'ASC'), 
			"dependency" => Array('element' => "show_single", 'value' => array('RECENT'))
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
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),

    )

));