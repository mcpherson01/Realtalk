<?php
class WPBakeryShortCode_dm_post extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
$css = '';
        extract(shortcode_atts(array(
			"post_section_title" => 'Recent Post',
			"num_of_post" => '3',
			"column_of_post" => '3',
			"post_order_term" => 'DESC',
			'posts_category' => '',
			 'css' => ''
        ), $atts));
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );



        /* ================  Render Shortcodes ================ */
	
	

        ob_start();
		
		
			//Fetch data
		$arguments = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			//'posts_per_page' => -1,
			'order' => (string) trim($post_order_term),
			'posts_per_page' => $num_of_post,
			'category_name' => $posts_category,
			'ignore_sticky_posts' => 1
			//'tag' => get_query_var('tag')
		);
	
		$post_query = new WP_Query($arguments); ?>

			<div class="<?php echo esc_attr( $css_class ); ?>">
        <!-- Element Code start -->
          <h2 class="section-title"><?php echo esc_attr($post_section_title); ?> </h2>
         
    <div<?php echo ($num_of_post > 3 ? ' id="digital_post"' : ''); ?>>
      
      <div class="row">
       <?php if ( $post_query->have_posts() ) : while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
        
            <?php if($column_of_post == "1"){ ?>
                          <div class="col-md-12 col-xs-12 col-sm-12">
                    <?php } elseif($column_of_post == "2") { ?>
                       <div class="col-md-6 col-xs-12 col-sm-6">
                    <?php } elseif($column_of_post == "3") { ?>
                       <div class="col-md-4 col-xs-12 col-sm-4">
                        <?php } elseif($column_of_post == "4") { ?>
                       <div class="col-md-3 col-xs-12 col-sm-3">
                       <?php } elseif($column_of_post == "5") { ?>
                       <div class="col-md-5ths col-xs-12 col-sm-5ths">
                        <?php } elseif($column_of_post == "6") { ?>
                       <div class="col-md-2 col-xs-12 col-sm-2">
                    <?php } else { ?>
                       <div class="col-md-12 col-xs-12 col-sm-12">
                    <?php } ?>
                    
					   
					   
					   <div class="blog-box grid_dm">
							<figure class="mayosis-fade-in">
							
								<?php
								// display featured image?
								if ( has_post_thumbnail() ) :
									the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
								endif; 

							?>                                                   
							
							<figcaption>
							    <div class="overlay_content_center blog_overlay_content">
							    <a href="<?php the_permalink(); ?>"><i class="zil zi-plus"></i></a>
							    </div>
							</figcaption>
						</figure>
						<div class="clearfix"></div>
						<?php
 global $post;
 $categories = get_the_category($post->ID);
 $cat_link = get_category_link($categories[0]->cat_ID);
?>
						<div class="blog-meta">
				
							<h4 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<div class="meta-bottom">
								<div class="user-info">
									<span><?php esc_html_e('by','mayosis'); ?></span>	<a href="<?php
	echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php
	the_author(); ?></a> <span><?php esc_html_e('in','mayosis'); ?></span>	<a href="<?php echo  esc_url($cat_link); ?>"><?php
	$category = get_the_category();
	$dmcat = $category[0]->cat_name;
	echo esc_html($dmcat); ?></a>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div><!-- .blog box -->
						   </div>
			 <?php endwhile; else: ?>
		  </div>
	  </div>
        <!-- Element Code / END -->
       
                    <div class="col-lg-12 pm-column-spacing">
                     <p><?php echo esc_attr('No posts were found.', 'mayosis'); ?></p>
                    </div>
                <?php endif; ?>
            
            </div>
        </div>
        
        <!-- Element Code / END -->
							  </div><?php echo $this->endBlockComment('dm_post'); ?>
							  <div class="clearfix"></div>
        <?php wp_reset_postdata(); ?>

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "dm_post",
    "name"      => __('Mayosis Blog Post', 'mayosis'),
    "description"      => __('Mayosis Recent Blog Post', 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __('Mayosis Elements', 'mayosis'),
    "params"    => array(
	 array(
                        'type' => 'textfield',
                        'heading' => __( 'Section Title', 'mayosis' ),
                        'param_name' => 'post_section_title',
                        'value' => __( 'Recent Post', 'mayosis' ),
                        'description' => __( 'Title for Recent Post Section', 'mayosis' ),
                    ), 

		array(
            "type" => "textfield",
            "heading" => __('Amount of Recent Post to display:', 'mayosis'),
            "param_name" => "num_of_post",
            "description" => __('Choose how many news posts you would like to display.', 'mayosis'),
			'value' => __( '' , 'mayosis' ),
        ),
	
	array(
            "type" => "dropdown",
            "heading" => __('Amount of Recent Post Column:', 'mayosis'),
            "param_name" => "column_of_post",
            "description" => __('Choose how many news posts you would like to display.', 'mayosis'),
			"value"      => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'), //Add default value in $atts
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __('Post Order', 'mayosis'),
            "param_name" => "post_order_term",
            "description" => __('Set the order in which news posts will be displayed.', 'mayosis'),
			"value"      => array( 'DESC' => 'DESC', 'ASC' => 'ASC'), //Add default value in $atts
        ),
	
	  array(
                    "type" => "textfield",
                    "heading" => __('Category',  'mayosis'),
                    "param_name" => "posts_category",
                    "value" =>'',
                    "description" => __('Enter a comma separated list of category IDs / names',  'mayosis'),
                    
                ),
		array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),

		

    )

));