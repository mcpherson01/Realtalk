<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Member_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-member';
   }

   public function get_title() {
      return __( 'Mayosis Team Member', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-nerd-chuckle';
   }

   protected function _register_controls() {

      $this->add_control(
         'member_settings',
         [
            'label' => __( 'Team Member Settings', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

       $this->add_control(
         'title',
         [
            'label' => __( 'Team Member Name', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'S.R Shemul',
            'section' => 'member_settings',
         ]
      );
       
       $this->add_control(
         'designation',
         [
            'label' => __( 'Team Member Designation', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Founder & CEO',
            'section' => 'member_settings',
         ]
      );
       
       $this->add_control(
         'image',
         [
            'label' => __( 'Team Member Photo', 'mayosis' ),
            'type' => Controls_Manager::MEDIA,
            'section' => 'member_settings',
         ]
      );
       $this->add_control(
         'details',
         [
            'label' => __( 'Details About Member', 'mayosis' ),
            'type' => Controls_Manager::TEXTAREA,
            'section' => 'member_settings',
         ]
      );
       
       $this->add_control(
         'member_style',
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
            'section' => 'member_style',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );
       
       $this->add_control(
         'style_team',
         [
            'label' => __( 'Team Style', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'one',
            'title' => __( 'Select Team Style', 'mayosis' ),
            'section' => 'member_style',
             'options' => [
                    'one'  => __( 'Style One', 'mayosis' ),
                    'two' => __( 'Style Two', 'mayosis' ),
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
            'section' => 'member_style',
         ]
      );
       
       $this->add_control(
         'desig_color',
         [
            'label' => __( 'Color of Designation', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Designation Color', 'mayosis' ),
            'section' => 'member_style',
         ]
      );
       $this->add_control(
         'content_color',
         [
            'label' => __( 'Color of Content', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Content Color', 'mayosis' ),
            'section' => 'member_style',
         ]
      );
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
       $image = $this->get_settings( 'image' );
       $teamstyle = $this->get_settings( 'style_team' );
       
      ?>

        <!-- Element Code start -->
        <?php if($teamstyle=='one'){?>
       <div class="team-member">
                	<div class="col-md-4 no-padding-left" style="text-align:<?php echo $settings['align_text']; ?>;">
                  <img src="<?php echo $image['url']; ?>" class="img-responsive" alt="member-img">
                    </div>
                    <div class="col-xs-8 no-padding team-details" style="text-align:<?php echo $settings['align_text']; ?>;">
                    	<h2 style="color:<?php echo $settings['title_color']; ?>;"><?php echo $settings['title']; ?></h2>
                        <small  style="color:<?php echo $settings['desig_color']; ?>;"><?php echo $settings['designation']; ?></small>
                        <p style="color:<?php echo $settings['content_color']; ?>;"><?php echo $settings['details']; ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div> 
                <?php } else { ?>
                
                     <div class="team-member team-style-two">
                	<div class="team--photo--style2" style="text-align:<?php echo $settings['align_text']; ?>;">
                  <img src="<?php echo $image['url']; ?>" class="img-responsive" alt="member-img">
                    </div>
                    <div class="no-padding team-details" style="text-align:<?php echo $settings['align_text']; ?>;">
                    	<h2 style="color:<?php echo $settings['title_color']; ?>;"><?php echo $settings['title']; ?></h2>
                        <small  style="color:<?php echo $settings['desig_color']; ?>;"><?php echo $settings['designation']; ?></small>
                        <p style="color:<?php echo $settings['content_color']; ?>;"><?php echo $settings['details']; ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div> 
                <?php } ?>
      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Member_Elementor_Thing );
?>