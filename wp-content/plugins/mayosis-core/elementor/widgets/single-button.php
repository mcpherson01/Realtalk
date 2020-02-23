<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Single_button_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-single-button';
   }

   public function get_title() {
      return __( 'Mayosis Single Button', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-button';
   }

   protected function _register_controls() {

      $this->add_control(
         'section_single_button',
         [
            'label' => __( 'Button Content', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'section_heading',
         [
            'label' => __( 'Title', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Button',
            'title' => __( 'Enter Button Title', 'mayosis' ),
            'section' => 'section_single_button',
         ]
      );
       $this->add_control(
         'button_url',
         [
            'label' => __( 'Button Url', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'http://teconce.com',
            'title' => __( 'Enter Button Url', 'mayosis' ),
            'section' => 'section_single_button',
         ]
      );
       $this->add_control(
         'target_button',
         [
            'label' => __( 'Button Target', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => '_blank',
            'title' => __( 'Select Button Target', 'mayosis' ),
            'section' => 'section_single_button',
             'options' => [
                    '_blank'  => __( 'Blank', 'mayosis' ),
                    '_self' => __( 'Self', 'mayosis' ),
                 ],
         ]
      );
		$this->add_control(
         'section_icon',
         [
            'label' => __( 'Icon', 'mayosis' ),
            'type' => Controls_Manager::ICON,
            'default' => '',
            'title' => __( 'Select Icon', 'mayosis' ),
            'section' => 'section_single_button',
         ]
      );
      
       $this->add_control(
         'button_video_popup',
         [
            'label' => __( 'Video Popup For Button', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'title' => __( 'Select Popup', 'mayosis' ),
            'section' => 'section_single_button',
             'options' => [
                    ''  => __( 'No', 'mayosis' ),
                    'data-lity' => __( 'Yes', 'mayosis' ),
                 ],
         ]
      );
      
    $this->add_control(
         'section_button_style',
         [
            'label' => __( 'Style', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
       
       $this->add_control(
         'icon_color',
         [
            'label' => __( 'Icon Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Icon Color', 'mayosis' ),
            'section' => 'section_button_style',
         ]
      );
      
       
       $this->add_control(
         'align_button',
         [
            'label' => __( 'Button Align', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'title' => __( 'Select Button Align', 'mayosis' ),
            'section' => 'section_button_style',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );
       
       
       $this->add_control(
         'button_style',
         [
            'label' => __( 'Button Style', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'styleone',
            'title' => __( 'Select Button Style', 'mayosis' ),
            'section' => 'section_button_style',
             'options' => [
                    'styleone'  => __( 'Style One', 'mayosis' ),
                    'styletwo' => __( 'Style Two', 'mayosis' ),
                    'transbutton' => __( 'Transparent', 'mayosis' ),
                    'gradient' => __( 'Gradient', 'mayosis' ),
                    'custombuttonmain' => __( 'Custom', 'mayosis' ),
                 ],
         ]
      );
      
      $this->add_control(
         'gradient_one',
         [
            'label' => __( 'Gradient Color One', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgb(60,40,180)',
            'title' => __( 'Select Gradient Color One', 'mayosis' ),
            'section' => 'section_button_style',
            
            'condition' => [
                    'button_style' => array('gradient'),
                ],
         ]
      );
       
       $this->add_control(
         'gradient_two',
         [
            'label' => __( 'Gradient Color Two', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgb(100,60,220)',
            'title' => __( 'Select Gradient Color Two', 'mayosis' ),
            'section' => 'section_button_style',
            'condition' => [
                    'button_style' => array('gradient'),
                ],
         ]
      );

       
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.
       $settings = $this->get_settings();
       $button_main_style= $settings['button_style'];
       $gradient_color_a= $settings['gradient_one'];
       $gradient_color_b= $settings['gradient_two'];
      ?>

 <!-- Element Code start -->
        <div class="elementor-button-area" style="text-align:<?php echo $settings['align_button']; ?>; ">
        <a <?php echo $settings['button_video_popup']; ?> class="<?php echo $settings['button_style']; ?> btn btn-primary btn-lg browse-more single_dm_btn" href="<?php echo $settings['button_url']; ?>" target="<?php echo $settings['target_button']; ?>" 
         <?php if($button_main_style=="gradient"){ ?>
            style="background-image:linear-gradient( 90deg, <?php echo esc_attr($gradient_color_a) ?> 0%, <?php echo esc_attr($gradient_color_b) ?> 100%);"
        <?php } ?>
        
        ><?php echo $settings['section_heading']; ?>  <i class="<?php echo $settings['section_icon']; ?>"></i></a>
        </div>


      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Single_button_Elementor_Thing );
?>