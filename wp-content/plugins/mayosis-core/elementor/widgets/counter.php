<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Counter_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-counter';
   }

   public function get_title() {
      return __( 'Mayosis Stats Counter', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-counter-circle';
   }

   protected function _register_controls() {

      $this->add_control(
         'counter_settings',
         [
            'label' => __( 'Counter Settings', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

       $this->add_control(
         'title',
         [
            'label' => __( 'Counter Title', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Title',
            'section' => 'counter_settings',
         ]
      );
       
       $this->add_control(
         'counter_type',
         [
            'label' => __( 'Counter Type', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'user',
            'title' => __( 'Select Counter Type', 'mayosis' ),
            'section' => 'counter_settings',
             'options' => [
                    'user'  => __( 'Total User', 'mayosis' ),
                    'product' => __( 'Total Products', 'mayosis' ),
                    'download' => __( 'Total Download', 'mayosis' ),
                    'custom' => __( 'Custom', 'mayosis' ),
                 ],
         ]
      );
       
       $this->add_control(
         'count',
         [
            'label' => __( 'Custom Count', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '4515',
            'section' => 'counter_settings',
         ]
      );
       
       $this->add_control(
         'counter_style',
         [
            'label' => __( 'Style', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
       $this->add_control(
         'align_text',
         [
            'label' => __( 'Text Alignment', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'title' => __( 'Select Text Alignment', 'mayosis' ),
            'section' => 'counter_style',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );
       
       $this->add_control(
         'title_color',
         [
            'label' => __( 'Color of Title', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Title Color', 'mayosis' ),
            'section' => 'counter_style',
         ]
      );
       
       $this->add_control(
         'count_color',
         [
            'label' => __( 'Color of Count', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Count Color', 'mayosis' ),
            'section' => 'counter_style',
         ]
      );
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
      ?>

<script>
	  jQuery('.statistic-counter').counterUp({
                delay: 10,
                time: 2000
            });
</script>
        <!-- Element Code start -->
        <div class="counter-box" style="text-align:<?php echo $settings['align_text']; ?>;">
               	<?php if($settings['counter_type'] == "user"){ ?>
               	
                	<h4 class="statistic-counter" style="color:<?php echo $settings['count_color']; ?>;">
                	<?php
                        $result = count_users();
                        echo  $result['total_users'];
                        
                        ?></h4>
                 <p style="color:<?php echo $settings['title_color']; ?>"><?php echo $settings['title']; ?></p>
                  <?php } elseif($settings['counter_type'] == "product"){ ?>
                   <?php
			$count_products = wp_count_posts('download');
	$total_products = $count_products->publish;
?>
			<h4 class="statistic-counter" style="color:<?php echo $settings['count_color']; ?>;"><?php
			echo $total_products; ?></h4>
                 <p style="color:<?php echo $settings['title_color']; ?>"><?php echo $settings['title']; ?></p>
                   
                    <?php } elseif($settings['counter_type'] == "download"){ ?>
                     <h4 class="statistic-counter" style="color:<?php echo $settings['count_color']; ?>;"><?php
			echo edd_count_total_file_downloads(); ?></h4>
                   <p style="color:<?php echo $settings['title_color']; ?>"><?php echo $settings['title']; ?></p>
                    <?php
			}
		  else
			{ ?>
			<h4 class="statistic-counter" style="color:<?php echo $settings['count_color']; ?>;"><?php echo $settings['count']; ?></h4>
				   <p style="color:<?php echo $settings['title_color']; ?>"><?php echo $settings['title']; ?></p>
					   <?php
			} ?>
                    
                </div>
      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Counter_Elementor_Thing );
?>