<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class mayosis_edd_popular extends Widget_Base {

   public function get_name() {
      return 'mayosis_edd_popular';
   }

   public function get_title() {
      return __( 'Mayosis EDD Popular', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-elementor';
   }

   protected function _register_controls() {

      $this->add_control(
         'section_edd',
         [
            'label' => __( 'mayosis EDD Popular', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'title',
         [
            'label' => __( 'Section Title', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __( 'Enter Section Title', 'mayosis' ),
            'section' => 'section_edd',
         ]
      );
       
       $this->add_control(
				'item_per_page',
				[
					'label'   => esc_html_x( 'Amount of item to display', 'Admin Panel', 'mayosis' ),
					'type'    => Controls_Manager::NUMBER,
					'default' =>  "10",
                    'section' => 'section_edd',
				]
		);  
    $this->add_control(
    			'list_layout',
    			[
    				'label'     => esc_html_x( 'Layout', 'Admin Panel','mayosis' ),
    				'description' => esc_html_x('Column layout for the list"', 'mayosis' ),	
    				'type'      =>  Controls_Manager::SELECT,
    				'default'    =>  "1/1",
    				'section' => 'section_edd',
    				"options"    => array(
    									"1/1" => "1",
    									"1/2" => "2",													
    									"1/3" => "3",													
    									"1/4" => "4",		 											
    									"1/6" => "6",
    								),				
    			]
    		 
    		);
		
       $this->add_control(
         'ribbon',
         [
            'label' => __( 'Ribbon Text', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __( 'Enter Ribbon Text', 'mayosis' ),
            'section' => 'section_edd',
         ]
      );
       
       
       
	
        
        $this->add_control(
            'order',
            [
                'label' => __( 'Order', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_edd',
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'desc',

            ]
        );

   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
$post_count = ! empty( $settings['item_per_page'] ) ? (int)$settings['item_per_page'] : 5;
$post_order_term=$settings['order'];
$riboontext=$settings['ribbon'];
$productthumbvideo= get_theme_mod( 'thumbnail_video_play','show' );
$productthumbposter= get_theme_mod( 'thumbnail_video_poster','show' );
$productvcontrol= get_theme_mod( 'thumb_video_control','minimal' );
$productcartshow= get_theme_mod( 'thumb_cart_button','hide' );
$productthumbhoverstyle= get_theme_mod( 'product_thmub_hover_style','style1' );
      ?>


<div class="edd_fetured_ark">
    <h2 class="section-title"> <?php echo $settings['title']; ?></h2>
             <div class="row fix">
               
                   <?php
                    global $post;
         $args = array( 'post_type' => 'download','numberposts' => $post_count, 'order' => (string) trim($post_order_term), 'orderby' => 'meta_value_num','meta_key' => 'hits');
         $recent_posts = get_posts( $args );
         foreach( $recent_posts as $post ){?>
         <?php if($settings['list_layout'] == '1/1'){ ?>
          <div class="col-md-12 col-xs-12 col-sm-12">
          <?php } elseif($settings['list_layout'] == '1/2'){ ?>
           <div class="col-md-6 col-xs-12 col-sm-6">
         <?php } elseif($settings['list_layout'] == '1/3'){ ?>
         <div class="col-md-4 col-xs-12 col-sm-4">
        <?php } elseif($settings['list_layout'] == '1/4'){ ?>
          <div class="col-md-3 col-xs-12 col-sm-3">
         <?php } elseif($settings['list_layout'] == '1/6'){ ?>
            <div class="col-md-2 col-xs-12 col-sm-2">
                    <?php } ?>
					
               <div class="grid_dm group edge">
               <div class="product-box">
                   <?php if($riboontext){ ?>
               <div class="wrap-ribbon left-edge point lblue"><span><?php echo esc_html($riboontext); ?></span></div>
               <?php } ?>
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
         <?php } ?>
         <?php  wp_reset_postdata();
         ?>
    </div>



      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new mayosis_edd_popular );
?>