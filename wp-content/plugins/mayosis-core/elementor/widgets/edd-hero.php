<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class EDD_hero_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-edd-hero';
   }

   public function get_title() {
      return __( 'Mayosis EDD Hero', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-device-desktop';
   }

   protected function _register_controls() {

      $this->add_control(
         'section_hero_main',
         [
            'label' => __( 'Hero Content', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
   $this->add_control(
         'hero_prefix',
         [
            'label' => __( 'Section Title Prefix', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'We Are The Secret Behind',
            'title' => __( 'Enter Section Title Prefix', 'mayosis' ),
            'section' => 'section_hero_main',
         ]
      );
       $this->add_control(
         'counter_type',
         [
            'label' => __( 'Counter Type', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'tdown',
            'title' => __( 'Select Counter Type', 'mayosis' ),
            'section' => 'section_hero_main',
             'options' => [
                    'tdown'  => __( 'Total Download', 'mayosis' ),
                    'tproduct' => __( 'Total Product', 'mayosis' ),
                    'ccount' => __( 'Custom Count', 'mayosis' ),
                 ],
         ]
      );
       $this->add_control(
         'custom_count',
         [
            'label' => __( 'Custom Count', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '2592',
            'title' => __( 'Enter Custom Count', 'mayosis' ),
            'section' => 'section_hero_main',
         ]
      );
       
    $this->add_control(
         'hero_suffix',
         [
            'label' => __( 'Section Title Suffix', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Graphic Designers',
            'title' => __( 'Enter Section Title Suffix', 'mayosis' ),
            'section' => 'section_hero_main',
         ]
      );
       
       $this->add_control(
         'section_content',
         [
            'label' => __( 'Section Content', 'mayosis' ),
            'type' => Controls_Manager::TEXTAREA,
            'default' => 'High End Graphic Templates & Resources such as Graphic Objects, Add Ons, PSD Templates, Photo Packs, Backgrounds, UI Kits and so on...
Browse, Download & Use Our Resources To Design Faster & Get Your Payment Quicker!',
            'title' => __( 'Enter Section Description', 'mayosis' ),
            'section' => 'section_hero_main',
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
         'gap_title_desc',
         [
            'label' => __( 'Title & Description Gap', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '22px',
            'title' => __( 'Enter gap between title & description', 'mayosis' ),
            'section' => 'section_style',
         ]
         );
       $this->add_control(
         'suppri_color',
         [
            'label' => __( 'Color of Suffix & Prefix', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#666666',
            'title' => __( 'Select Suffix & Prefix Color', 'mayosis' ),
            'section' => 'section_style',
         ]
      );
       
       $this->add_control(
         'count_color',
         [
            'label' => __( 'Color of Count', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Count Color', 'mayosis' ),
            'section' => 'section_style',
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
       
  <div class="col-md-12 col-xs-12 col-sm-12" style="text-align: <?php echo $settings['align_text']; ?>;">
                    <h1 class="hero-title" style="color:<?php echo $settings['suppri_color']; ?>"><?php echo $settings['hero_prefix']; ?>
                    
                   <span style="color:<?php echo $settings['count_color']; ?>">  <?php if($settings['counter_type'] == "tdown"){ ?>
                          <?php echo edd_count_total_file_downloads(); ?>
                        <?php } elseif($settings['counter_type'] == "tproduct") { ?>
                       <?php
			$count_products = wp_count_posts('download');
	$total_products = $count_products->publish;
?>              <?php echo 	$total_products ; ?>
                    <?php } else { ?>
                       <?php echo $settings['custom_count']; ?>
					   <?php } ?></span>
                       <?php echo $settings['hero_suffix']; ?></h1>
                   <div class="hero-description" style="color:<?php echo $settings['content_color']; ?> !important; margin-top:<?php echo $settings['gap_title_desc']; ?>;"><?php echo $settings['section_content']; ?></div>
                   
			    </div>
        <div class="clearfix"></div>

      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new EDD_hero_Elementor_Thing );
?>