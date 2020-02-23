<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class mayosis_edd_recent_Elementor_Thing extends Widget_Base {

    public function get_name() {
        return 'mayosis-edd-recent';
    }

    public function get_title() {
        return __( 'Mayosis Regular Grid', 'mayosis' );
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
                'label' => __( 'mayosis EDD Recent', 'mayosis' ),
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
            'sub_title',
            [
                'label' => __( 'Sub Title', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Sub Title', 'mayosis' ),
                'section' => 'section_edd',
            ]
        );

        $this->add_control(
            'margin_bottom',
            [
                'label' => __( 'Title Section Margin Bottom (With px)', 'mayosis' ),
                'description' => __('Add Margin Bottom','mayosis'),
                'type' => Controls_Manager::TEXT,
                'default' => '20px',
                'section' => 'section_edd',
            ]
        );
      $this->add_control(
            'selectoption',
            [
                'label' => __( 'Right Side Option', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_edd',
                'options' => [
                    'button' => 'Button',
                    'category' => 'Category Filter'
                ],
                'default' => 'button',

            ]
        );
        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Button Text', 'mayosis' ),
                'section' => 'section_edd',
                 'condition' => [
                    'selectoption' => array('button'),
                ],
            ]
        );


        $this->add_control(
            'button_link',
            [
                'label' => __( 'Button URL', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Button URL', 'mayosis' ),
                'section' => 'section_edd',
                'condition' => [
                    'selectoption' => array('button'),
                ],
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
            'show_category',
            [
                'label'     => esc_html_x( 'Filter Category Wise', 'Admin Panel','mayosis' ),
                'description' => esc_html_x('Select if want to show product by category', 'mayosis' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'    =>  "no",
                'section' => 'section_edd',
                "options"    => array(
                    "yes" => "Yes",
                    "no" => "No",

                ),
            ]

        );


        $this->add_control(
            'category',
            [
                'label' => __( 'Category Slug', 'mayosis' ),
                'description' => __('Add one category slug','mayosis'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'section' => 'section_edd',
            ]
        );
        
        $this->add_control(
            'categorynotin',
            [
                'label' => __( 'Exclude Category', 'mayosis' ),
                'description' => __('Add one category slug','mayosis'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'section' => 'section_edd',
            ]
        );
        
       
        
        $this->add_control(
            'metaoption',
            [
                'label' => __( 'Meta Option', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_edd',
                'options' => [
                    'global' => 'Global',
                    'custom' => 'Custom'
                ],
                'default' => 'global',

            ]
        );
        
        $this->add_control(
            'metaoptiontype',
            [
                'label' => __( 'Meta Option Type', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_edd',
                'options' => [
                    'none' => 'None',
                    'vendor' => 'Vendor',
                    'category' => 'Category',
                    'vendorcat' => 'Vendor & Category',
                    'sales' => 'Sales & Download',
                ],
                'default' => 'none',
                'condition' => [
                    'metaoption' => array('custom'),
                ],
            ]
        );
        
         $this->add_control(
            'productpriceoption',
            [
                'label' => __( 'Pricing Option', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_edd',
                'options' => [
                    'none' => 'None',
                    'price' => 'Price',
                ],
                'default' => 'none',
                'condition' => [
                    'metaoption' => array('custom'),
                ],
            ]
        );
        
          $this->add_control(
            'freepricingoption',
            [
                'label' => __( 'Free Pricing Option', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_edd',
                'options' => [
                    'none' => '$0.00',
                    'custom' => 'Custom Text',
                ],
                'default' => 'none',
                'condition' => [
                    'metaoption' => array('custom'),
                ],
            ]
        );

 $this->add_control(
            'customtext',
            [
                'label' => __( 'Custom Text', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Free Custom Title', 'mayosis' ),
                'section' => 'section_edd',
                'condition' => [
                    'metaoption' => array('custom'),
                ],
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
        $downloads_category=$settings['category'];
        $downloads_category_not=$settings['categorynotin'];
        $productmetadisplayop=$settings['metaoptiontype'];
        $productpricingoptions=$settings['productpriceoption'];
        $productfreeoptins=$settings['freepricingoption'];
        $productcustomtext=$settings['customtext'];
        $recent_section_title = $settings['title'];
        $sub_title = $settings['sub_title'];
        $title_sec_margin = $settings['margin_bottom'];
        $selectoption = $settings['selectoption'];
        $button_text = $settings['button_text'];
        $button_link = $settings['button_link'];
        $productthumbvideo= get_theme_mod( 'thumbnail_video_play','show' );
        $productvideointer= get_theme_mod( 'product_video_interaction','full' );
        $productthumbposter= get_theme_mod( 'thumbnail_video_poster','show' );
        $productvcontrol= get_theme_mod( 'thumb_video_control','minimal' );
        $productcartshow= get_theme_mod( 'thumb_cart_button','hide' );
        $productthumbhoverstyle= get_theme_mod( 'product_thmub_hover_style','style1' );
       
        ?>


        <div class="edd_fetured_ark">

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
                if ($selectoption=='button') { ?>
                
                <?php
                if ($button_link) { ?>
                    <a href="<?php echo esc_attr($button_link); ?>" class="btn title--box--btn"><?php echo esc_attr($button_text); ?></a>
                <?php } ?>
                <?php } else { ?>
                 <div class="regular-category-search">
            <select class="mayosis-filters-select">
                <option value=".all"><?php esc_html_e('All Categories','mayosis'); ?></option>
                            <?php

                            $taxonomy = 'download_category';
                            $terms = get_terms($taxonomy); // Get all terms of a taxonomy

                            if ( $terms && !is_wp_error( $terms ) ) :
                                ?>

                                <?php foreach ( $terms as $term ) { ?>
                                <option value=".<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
                            <?php } ?>
                            
                            <?php endif;?>

          
            </select>
        </div>
        <?php } ?>
            </div>
        </div>
       
        <div class="row fix  <?php
                if ($selectoption=='category') { ?>gridbox<?php }?>">

        <?php
        global $post;
        if($settings['show_category'] == 'no') {
            $args = array('post_type' => 'download', 'numberposts' => $post_count, 'order' => (string)trim($post_order_term),);
        } else {
            $args = array(
                'post_type' => 'download',
                'numberposts' => $post_count,
                'tax_query' => array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'download_category',
                        'field' => 'slug',
                        'terms' => array($downloads_category),
                        'operator' => 'IN'
                    ),
                    
                    array(
                        'taxonomy' => 'download_category',
                        'field' => 'slug',
                        'terms' => array($downloads_category_not),
                        'operator' => 'NOT IN'
                    ),
                    ),
                'order' => (string)trim($post_order_term),);
        }
        $recent_posts = get_posts( $args );
    foreach( $recent_posts as $post ){?>
     <?php
                            global $post;
                            $downlodterms = get_the_terms( $post->ID, 'download_category' );// Get all terms of a taxonomy
                            $cls = '';

                            if ( ! empty( $downlodterms ) ) {
                                foreach ($downlodterms as $term ) {
                                    $cls .= $term->slug . ' ';
                                }
                            }
                            ?>
        <?php if($settings['list_layout'] == '1/1'){ ?>
        <div class="col-md-12 col-xs-12 col-sm-12 element-item <?php echo $cls; ?> all">
        <?php } elseif($settings['list_layout'] == '1/2'){ ?>
        <div class="col-md-6 col-xs-12 col-sm-6 element-item <?php echo $cls; ?> all">
        <?php } elseif($settings['list_layout'] == '1/3'){ ?>
        <div class="col-md-4 col-xs-12 col-sm-4 element-item <?php echo $cls; ?> all">
        <?php } elseif($settings['list_layout'] == '1/4'){ ?>
        <div class="col-md-3 col-xs-12 col-sm-3 element-item <?php echo $cls; ?> all">
        <?php } elseif($settings['list_layout'] == '1/6'){ ?>
        <div class="col-md-2 col-xs-12 col-sm-2 element-item <?php echo $cls; ?> all">
            <?php } ?>

            <div class="grid_dm ribbon-box group edge">
                <div class="product-box">
                    <?php
                    $postdate = get_the_time('Y-m-d'); // Post date
                                $postdatestamp = strtotime($postdate); 
                                
                                $riboontext = get_theme_mod('recent_ribbon_text', 'New'); // Newness in days
                                
                                $newness = get_theme_mod('recent_ribbon_time', '30'); // Newness in days
                                if ((time() - (60 * 60 * 24 * $newness)) < $postdatestamp) { // If the product was published within the newness time frame display the new badge
                                    echo '<div class="wrap-ribbon left-edge point lblue"><span>' . esc_html($riboontext) . '</span></div>';
                                }
                    ?>
                    <figure class="mayosis-fade-in">
                        
                       
                    <?php if ($productthumbvideo=='show'){ ?>
                        <?php if ( has_post_format( 'video' )) { ?>
                       
                        <div class="mayosis--video--box">
                        <div class="video-inner-box-promo"> 
                        <a href="<?php the_permalink();?>" class="mayosis-video-url"></a>
                             <?php get_template_part( 'library/mayosis-video-box-thumb' ); ?>
                            <div class="video-inner-main">
                  
                       
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
                        <?php   if($settings['metaoption'] == 'global') { ?>
                        <?php get_template_part( 'includes/product-meta' ); ?>
                        
                        <?php } else { ?>
                        
                <div class="product-tag">
                    
                                        <?php 
																	global $edd_logs;
															$single_count = $edd_logs->get_log_count(66, 'file_download');
															$total_count  = $edd_logs->get_log_count('*', 'file_download');
                                                            $sales = edd_get_download_sales_stats( get_the_ID() );
                                                            $sales = $sales > 1 ? $sales . ' sales' : $sales . ' sale';
                                        $price = edd_get_download_price(get_the_ID());
                                        
                                        $download_cats = get_the_term_list( get_the_ID(), 'download_category', '', _x(' , ', '', 'mayosis' ), '' );
																	?>
																	
                    <?php if ( has_post_format( 'audio' )) { 
								get_template_part( 'includes/edd_title_audio');
							} ?>
							
							<?php if ( has_post_format( 'video' )) { 
								get_template_part( 'includes/edd_title_video');
							} ?>
							<h4 class="product-title"><a href="<?php the_permalink(); ?>">
								    <?php 
                                        $title  = the_title('','',false);
                                        if(strlen($title) > 40):
                                            echo trim(substr($title, 0, 38)).'...';
                                        else:
                                            echo esc_html($title);
                                        endif;
                                        ?>
								</a></h4>
								
								<?php if ($productmetadisplayop=='vendor'): ?>
								 <span><a href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID')) )); ?>"><?php the_author(); ?></a></span>		
								 <?php elseif ($productmetadisplayop=='category'): ?>
								 <span><?php echo '<span>' . $download_cats . '</span>'; ?></span>
								 <?php elseif ($productmetadisplayop=='vendorcat'): ?>
								 <span><?php esc_html_e("by","mayosis"); ?> <a href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID')) )); ?>"><?php the_author(); ?></a>
								 <?php if ($download_cats):?>
								 <?php esc_html_e("in","mayosis"); ?></span> <span><?php echo '<span>' . $download_cats . '</span>'; ?></span>
								 <?php endif; ?>
								 <?php elseif ($productmetadisplayop=='sales'): ?>
								   <?php if( $price == "0.00"  ){ ?>
                                   <p><span><?php $download = $edd_logs->get_log_count(get_the_ID(), 'file_download'); echo ( is_null( $download ) ? '0' : $download ); ?> downloads </span></p>
                                   <?php } else { ?>
                                   <p><span><?php echo esc_html($sales); ?></span></p>
                                   <?php } ?>
								 <?php else: ?>
								 <?php endif; ?>
                    </div>
                    
                   <?php if ($productpricingoptions=='price'): ?>								
																	
								<div class="count-download">
								 <?php if( $price == "0.00"  ){ ?>
								 <?php if ($productfreeoptins=='none'): ?>		
									<span><?php edd_price(get_the_ID()); ?></span>
								<?php else: ?>
								    <span><?php echo esc_html($productcustomtext); ?></span>
								<?php endif;?>
								
								
									 <?php } else { ?>
                       <div class="product-price promo_price"><?php edd_price(get_the_ID()); ?></div>
                    <?php } ?>
									
								</div>
								<?php endif; ?>
                        <?php } ?>

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
Plugin::instance()->widgets_manager->register_widget_type( new mayosis_edd_recent_Elementor_Thing );
?>