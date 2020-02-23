<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class infobox_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-infobox';
   }

   public function get_title() {
      return __( 'Mayosis Contact Info', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-tel-field';
   }

   protected function _register_controls() {

      $this->add_control(
         'contact_settings',
         [
            'label' => __( 'Mayosis Contact Info', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

       $this->add_control(
         'title',
         [
            'label' => __( 'Address Widget Title', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Address',
            'section' => 'contact_settings',
         ]
      );
       
       $this->add_control(
         'details',
         [
            'label' => __( 'Address Details', 'mayosis' ),
            'type' => Controls_Manager::TEXTAREA,
            'section' => 'contact_settings',
         ]
      );
       
       $this->add_control(
         'contact_style',
         [
            'label' => __( 'Style', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
       
       $this->add_control(
         'title_color',
         [
            'label' => __( 'Color of Title', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Title Color', 'mayosis' ),
            'section' => 'contact_style',
         ]
      );
       
       $this->add_control(
         'content_color',
         [
            'label' => __( 'Color of Content', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Content Color', 'mayosis' ),
            'section' => 'contact_style',
         ]
      );
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
       $image = $this->get_settings( 'image' );
      ?>

        <!-- Element Code start -->
        <div class="contact-widget">
                    	<h4 style="color: <?php echo $settings['title_color']; ?>"> <?php echo $settings['title']; ?></h4>
                        <p style="color: <?php echo $settings['content_color']; ?> !important"> <?php echo $settings['details']; ?></p>
                    </div>
      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new infobox_Elementor_Thing );
?>