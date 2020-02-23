<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class subscribe_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-subscribe';
   }

   public function get_title() {
      return __( 'Mayosis Subscribe', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-form-horizontal';
   }

   protected function _register_controls() {

      $this->add_control(
         'subscribe_main',
         [
            'label' => __( 'Subscribe', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
   $this->add_control(
         'title',
         [
            'label' => __( 'Subscribe Title', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Title',
            'title' => __( 'Enter Subscribe Title', 'mayosis' ),
            'section' => 'subscribe_main',
         ]
      );
       
       
       $this->add_control(
         'section_content',
         [
            'label' => __( 'Subscribe Content', 'mayosis' ),
            'type' => Controls_Manager::WYSIWYG,
            'default' => 'High End Graphic Templates & Resources such as Graphic Objects, Add Ons, PSD Templates, Photo Packs, Backgrounds, UI Kits and so on...
Browse, Download & Use Our Resources To Design Faster & Get Your Payment Quicker!',
            'title' => __( 'Enter Subtitle Description & Any Shortcode', 'mayosis' ),
            'section' => 'subscribe_main',
         ]
      );
        $this->add_control(
         'section_style',
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
            'section' => 'section_style',
         ]
      );
       $this->add_control(
         'align_text',
         [
            'label' => __( 'Text Alignment', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'title' => __( 'Select Text Alignment', 'mayosis' ),
            'section' => 'section_style',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );
       
       $this->add_control(
         'content_color',
         [
            'label' => __( 'Color of Content', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Content Color', 'mayosis' ),
            'section' => 'section_style',
         ]
      );
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
      ?>

 <!-- Element Code start -->
 <div class="subscribe-block">
        <div class="col-md-12 col-sm-12 col-xs-12">
						<h4 style="color:<?php echo $settings['title_color']; ?>;text-align:<?php echo $settings['align_text']; ?>"><?php echo $settings['title']; ?></h4>
					<div class="subscribe-description" style="color:<?php echo $settings['content_color']; ?> !important"><?php echo $settings['section_content']; ?></div>
	                </div>
	                </div>

      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new subscribe_Elementor_Thing );
?>