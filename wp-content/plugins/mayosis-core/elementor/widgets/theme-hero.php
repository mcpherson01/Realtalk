<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Theme_hero_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-theme-hero';
   }

   public function get_title() {
      return __( 'Mayosis Hero', 'mayosis' );
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
            'default' => 'none',
            'title' => __( 'Select Counter Type', 'mayosis' ),
            'section' => 'section_hero_main',
             'options' => [
                    'none'  => __( 'None', 'mayosis' ),
                    'tuser' => __( 'Total User', 'mayosis' ),
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
         'heading_type',
         [
            'label' => __( 'Heading Type', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'h2',
            'title' => __( 'Select Text Alignment', 'mayosis' ),
            'section' => 'section_style',
             'options' => [
                    'h1'  => __( 'H1', 'mayosis' ),
                    'h2' => __( 'H2', 'mayosis' ),
                    'h3' => __( 'H3', 'mayosis' ),
                    'h4' => __( 'H4', 'mayosis' ),
                    'h5' => __( 'H5', 'mayosis' ),
                    'h6' => __( 'H6', 'mayosis' ),
                 ],
         ]
      );
      
      $this->add_control(
         'title_font_size',
         [
            'label' => __( 'Title Font Size', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '34px',
            'title' => __( 'Enter Section Title Font Size', 'mayosis' ),
            'section' => 'section_style',
         ]
      );
      
      $this->add_control(
         'title_line_height',
         [
            'label' => __( 'Title Line Height', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '44px',
            'title' => __( 'Enter Section Title Line Height', 'mayosis' ),
            'section' => 'section_style',
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
       $heading_type = $this->get_settings('heading_type');
       $title_font_size = $this->get_settings('title_font_size');
       $title_line_height= $this->get_settings('title_line_height');
      ?>

 <!-- Element Code start -->
       
  <div class="col-md-12  col-xs-12 col-sm-12" style="text-align: <?php echo $settings['align_text']; ?>;">
                    <<?php if($heading_type){ ?><?php echo esc_attr( $heading_type); ?><?php } else { ?>h2<?php } ?> class="hero-title" style="color:<?php echo $settings['suppri_color']; ?>;font-size:<?php echo esc_attr($title_font_size); ?>;line-height:<?php echo esc_attr($title_line_height); ?>;"><?php echo $settings['hero_prefix']; ?>
                    
                   <span style="color:<?php echo $settings['count_color']; ?>">  <?php if($settings['counter_type'] == "tuser"){ ?>
                         <?php
                        $result = count_users();
                        echo  $result['total_users'];
                        
                        ?>
                        <?php } elseif($settings['counter_type'] == "none") { ?>
                      
                    <?php } else { ?>
                       <?php echo $settings['custom_count']; ?>
					   <?php } ?></span>
                       <?php echo $settings['hero_suffix']; ?></<?php if($heading_type){ ?><?php echo esc_attr( $heading_type); ?><?php } else { ?>h2<?php } ?>>
                   <div class="hero-description" style="color:<?php echo $settings['content_color']; ?> !important; margin-top:<?php echo $settings['gap_title_desc']; ?>;"><?php echo $settings['section_content']; ?></div>
                   
			    </div>
        <div class="clearfix"></div>

      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Theme_hero_Elementor_Thing );
?>