<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Theme_testimonial_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-theme-testimonial';
   }

   public function get_title() {
      return __( 'Mayosis Testimonial', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return ' eicon-testimonial';
   }

   protected function _register_controls() {

      $this->add_control(
         'section_hero_testimonial',
         [
            'label' => __( 'Testimonial Content', 'mayosis' ),
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
                'section' => 'section_hero_testimonial',
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __( 'Sub Title', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Sub Title', 'mayosis' ),
                'section' => 'section_hero_testimonial',
            ]
        );
      
      $this->add_control(
            'margin_bottom',
            [
                'label' => __( 'Title Section Margin Bottom (With px)', 'mayosis' ),
                'description' => __('Add Margin Bottom','mayosis'),
                'type' => Controls_Manager::TEXT,
                'default' => '20px',
                'section' => 'section_hero_testimonial',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Button Text', 'mayosis' ),
                'section' => 'section_hero_testimonial',
            ]
        );


                $this->add_control(
                    'button_link',
                    [
                        'label' => __( 'Button URL', 'mayosis' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => '',
                        'title' => __( 'Enter Button URL', 'mayosis' ),
                        'section' => 'section_hero_testimonial',
                    ]
                );
                
        $this->add_control(
            'button_style',
            [
                'label' => __( 'Button Style', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_hero_testimonial',
                'options' => [
                    'solid' => 'Solid',
                    'transparent' => 'Ghost'
                ],
                'default' => 'solid',

            ]
        );

       $this->add_control(
         'amount_display',
         [
            'label' => __( 'Amount of Testimonial to display:', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '3',
            'title' => __( 'Enter Amount of Testimonial to display', 'mayosis' ),
            'section' => 'section_hero_testimonial',
         ]
      );
        $this->add_control(
            'order',
            [
                'label' => __( 'Order', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_hero_testimonial',
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'desc',

            ]
        );
       
       $this->add_control(
            'display_type',
            [
                'label' => __( 'Display Type', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_hero_testimonial',
                'options' => [
                    'normal' => 'Normal',
                    'grid' => 'Grid'
                ],
                'default' => 'normal',

            ]
        );
       
       $this->add_control(
            'arrow',
            [
                'label' => __( 'Arrow', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_hero_testimonial',
                'options' => [
                    'show' => 'Show',
                    'hide' => 'Hide'
                ],
                'default' => 'hide',

            ]
        );
        
$this->add_control(
         'section_style_testimonial',
         [
            'label' => __( 'Style', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
   $this->add_control(
         'pre_color',
         [
            'label' => __( 'Color of Pre Title Unit', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#c2c9cc',
            'section' => 'section_style_testimonial',
         ]
      );
       
       $this->add_control(
         'main_color',
         [
            'label' => __( 'Color of Main Title', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#c2c9cc',
            'section' => 'section_style_testimonial',
         ]
      );
       
       $this->add_control(
         'author_color',
         [
            'label' => __( 'Color of Author Title', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'section' => 'section_style_testimonial',
         ]
      );
       
       $this->add_control(
         'span_color',
         [
            'label' => __( 'Color of Span', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'section' => 'section_style_testimonial',
         ]
      );
       
       $this->add_control(
         'desc_color',
         [
            'label' => __( 'Color of Grid Description', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#c2c9cc',
            'section' => 'section_style_testimonial',
         ]
      );
       $this->add_control(
         'designation_color',
         [
            'label' => __( 'Color of Designation', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#c2c9cc',
            'section' => 'section_style_testimonial',
         ]
      );
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
        $recent_section_title = $settings['title'];
       $post_count = ! empty( $settings['amount_display'] ) ? (int)$settings['amount_display'] : 5;
        $post_order_term=$settings['order'];
        $sub_title = $settings['sub_title'];
        $title_sec_margin = $settings['margin_bottom'];
        $button_text = $settings['button_text'];
        $button_link = $settings['button_link'];
        $button_style = $settings['button_style'];
      ?>

 <!-- Element Code start -->
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
                        <a href="<?php echo esc_attr($button_link); ?>" class="btn title--box--btn <?php echo esc_attr($button_style);?>"><?php echo esc_attr($button_text); ?></a>
                    <?php } ?>
                </div>
            </div>
<?php if($settings['display_type'] == 'normal'){ ?>
       <?php
        global $post;
         $args = array( 'post_type' => 'testimonial','numberposts' => $post_count, 'order' => (string) trim($post_order_term),);
         $recent_posts = get_posts( $args );
         foreach( $recent_posts as $post ){?>
        <div class="testimonal-promo">
                    <?php $pre_title = get_field( 'pre_title' ); ?>
        <?php if ( $pre_title ) { ?>
                            <small style=" color: <?php echo $settings['pre_color']; ?>;"><?php echo esc_html($pre_title); ?></small>
                            <?php } ?>
                            <h2 style=" color: <?php echo $settings['main_color'];?>;">&#34;<?php the_title(); ?>&#34;</h2>
                            <?php $testimonial_author_name = get_field( 'testimonial_author_name' ); ?>
        <?php if ( $testimonial_author_name ) { ?>
                        <p style="color: <?php echo $settings['author_color'];?>;"><span style="color:<?php echo $settings['span_color'];?>;">By</span> <?php echo esc_html($testimonial_author_name); ?></p>
                        <?php } ?>

                </div>
  	     <?php } ?>
         <?php  wp_reset_postdata();
         ?>
         <?php } ?>

<?php if($settings['display_type'] == 'grid'){ ?>
<div class="testimonial-grid-carousel">
    <?php if($settings['arrow'] == 'show'){ ?>
        <div class="slideControls">
            <a class="slidePrev">
              <i class="fa fa-angle-left"></i>
             </a>
            <a class="slideNext">
              <i class="fa fa-angle-right"></i>
            </a>
      </div>
      <?php }?>
      <ul id="carousel-testimonial">
<?php
        global $post;
         $args = array( 'post_type' => 'testimonial','numberposts' => $post_count, 'order' => (string) trim($post_order_term),);
         $recent_posts = get_posts( $args );
         foreach( $recent_posts as $post ){?>
<li class="col-md-4 grid_style">
                          <div class="grid-testimonal-promo">
                          <div class="testimonial_details" style="color:<?php echo $settings['desc_color'];?>;">
                         
                          <?php the_field('testimonial_small_description(_for_grid_style_only)'); ?>
                          
                          </div>
                          <div class="arrow-down"></div>
    		
					<?php $testimonial_author_name = get_field( 'testimonial_author_name' ); ?>

   			<div class="testimonial-grid-author">
   			<div class="grid_photo text-center">
   				 <?php
								// display featured image?
								if ( has_post_thumbnail() ) :
									the_post_thumbnail( 'full', array( 'class' => 'img-responsive img-circle grid-thumbnail-left' ) );
								endif; 

							?>   
   			</div>
   			<?php if ( $testimonial_author_name ) { ?>
    			<div class="testimonial_grid_titles  text-center">
    			<h4 class="grid_main_author" style="color: <?php echo $settings['author_color'];?>;"><?php echo esc_html($testimonial_author_name); ?></h4>
    			<p class="grid_designation" style="color: <?php echo $settings['designation_color'];?>;"><?php the_field('testimonial_author_job_title'); ?></p>
    			
    			</div>
    			<div class="clearfix"></div>
    			<?php } ?>
    			</div>
    			
    		
    	</div>
                          </li>

<?php } ?>
         <?php  wp_reset_postdata();
         ?>
         </ul>
         </div>
<?php } ?>
<div class="clearfix"></div>
      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Theme_testimonial_Elementor_Thing );
?>