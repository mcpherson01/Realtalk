<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Double_button_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-double-button';
   }

   public function get_title() {
      return __( 'Mayosis Dual Button', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-dual-button';
   }

   protected function _register_controls() {

      $this->add_control(
         'section_double_button',
         [
            'label' => __( 'General', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
 $this->add_control(
         'button-separator',
         [
        'label' => __( 'Show Separator', 'mayosis' ),
		'type' => Controls_Manager::SWITCHER,
		'default' => '',
		'label_on' => __( 'Show', 'mayosis' ),
		'label_off' => __( 'Hide', 'mayosis' ),
		'return_value' => 'yes',
        'section' => 'section_double_button',
         ]
      );
       $this->add_control(
         'button_separator_text',
         [
            'label' => __( 'Button Separator Text', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'or',
            'title' => __( 'Enter Button Separator Text', 'mayosis' ),
            'section' => 'section_double_button',
         ]
      );
    $this->add_control(
         'align_button',
         [
            'label' => __( 'Button Align', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'title' => __( 'Select Button Align', 'mayosis' ),
            'section' => 'section_double_button',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );
       
       $this->add_control(
         'sep_color',
         [
            'label' => __( 'Separator Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#666666',
            'title' => __( 'Select Separator Color', 'mayosis' ),
            'section' => 'section_double_button',
         ]
      );
      
 $this->add_control(
         'section_btn_one',
         [
            'label' => __( 'Button A', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
       
      $this->add_control(
         'button_a_heading',
         [
            'label' => __( 'Title', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Button',
            'title' => __( 'Enter Button Title', 'mayosis' ),
            'section' => 'section_btn_one',
         ]
      );
       $this->add_control(
         'button_a_url',
         [
            'label' => __( 'Button Url', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'http://teconce.com',
            'title' => __( 'Enter Button Url', 'mayosis' ),
            'section' => 'section_btn_one',
         ]
      );
       $this->add_control(
         'target_button_a',
         [
            'label' => __( 'Button Target', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => '_blank',
            'title' => __( 'Select Button Target', 'mayosis' ),
            'section' => 'section_btn_one',
             'options' => [
                    '_blank'  => __( 'Blank', 'mayosis' ),
                    '_self' => __( 'Self', 'mayosis' ),
                 ],
         ]
      );
		$this->add_control(
         'button_icon_a',
         [
            'label' => __( 'Icon', 'mayosis' ),
            'type' => Controls_Manager::ICON,
            'default' => '',
            'title' => __( 'Select Icon', 'mayosis' ),
            'section' => 'section_btn_one',
         ]
      );
       $this->add_control(
         'button_style_a',
         [
            'label' => __( 'Button Style', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'styleone',
            'title' => __( 'Select Button Style', 'mayosis' ),
            'section' => 'section_btn_one',
             'options' => [
                    'styleone'  => __( 'Style One', 'mayosis' ),
                    'styletwo' => __( 'Style Two', 'mayosis' ),
                    'transbutton' => __( 'Transparent', 'mayosis' ),
                    'gradienta' => __( 'Gradient', 'mayosis' ),
                    'custombuttona' => __( 'Custom', 'mayosis' ),
                 ],
         ]
      );
      
      $this->add_control(
         'gradient_aone',
         [
            'label' => __( 'Gradient Color One', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgb(60,40,180)',
            'title' => __( 'Select Gradient Color One', 'mayosis' ),
            'section' => 'section_btn_one',
            
            'condition' => [
                    'button_style_a' => array('gradienta'),
                ],
         ]
      );
       
       $this->add_control(
         'gradient_atwo',
         [
            'label' => __( 'Gradient Color Two', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgb(100,60,220)',
            'title' => __( 'Select Gradient Color Two', 'mayosis' ),
            'section' => 'section_btn_one',
            'condition' => [
                    'button_style_a' => array('gradienta'),
                ],
         ]
      );

      
      $this->add_control(
         'button_a_video_popup',
         [
            'label' => __( 'Video Popup For Button A', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'title' => __( 'Select Popup', 'mayosis' ),
            'section' => 'section_btn_one',
             'options' => [
                    ''  => __( 'No', 'mayosis' ),
                    'data-lity' => __( 'Yes', 'mayosis' ),
                 ],
         ]
      );
      
      $this->add_control(
         'buton_one_bg',
         [
            'label' => __( 'Button One Background', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button One Background', 'mayosis' ),
            'section' => 'section_btn_one',
            'condition' => [
                    'button_style_a' => array('custombuttona'),
                ],
         ]
      );
      
      $this->add_control(
         'buton_one_border',
         [
            'label' => __( 'Button One Border', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button One Border', 'mayosis' ),
            'section' => 'section_btn_one',
            
              
             'condition' => [
                    'button_style_a' => array('custombuttona'),
                ],
         ]
      );
      
      $this->add_control(
         'buton_one_text',
         [
            'label' => __( 'Button One Text', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button One Text', 'mayosis' ),
            'section' => 'section_btn_one',
             'description' => __('Work in custom & gradient mode','mayosis'),
         ]
      );
      
       $this->add_control(
         'button_a_class',
         [
            'label' => __( 'Button a Custom Class', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'section' => 'section_btn_one',
         ]
      );
       
       $this->add_control(
         'section_btn_two',
         [
            'label' => __( 'Button B', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
       
      $this->add_control(
         'button_b_heading',
         [
            'label' => __( 'Title', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Button',
            'title' => __( 'Enter Button Title', 'mayosis' ),
            'section' => 'section_btn_two',
         ]
      );
       $this->add_control(
         'button_b_url',
         [
            'label' => __( 'Button Url', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'http://teconce.com',
            'title' => __( 'Enter Button Url', 'mayosis' ),
            'section' => 'section_btn_two',
         ]
      );
       $this->add_control(
         'target_button_b',
         [
            'label' => __( 'Button Target', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => '_blank',
            'title' => __( 'Select Button Target', 'mayosis' ),
            'section' => 'section_btn_two',
             'options' => [
                    '_blank'  => __( 'Blank', 'mayosis' ),
                    '_self' => __( 'Self', 'mayosis' ),
                 ],
         ]
      );
		$this->add_control(
         'button_icon_b',
         [
            'label' => __( 'Icon', 'mayosis' ),
            'type' => Controls_Manager::ICON,
            'default' => '',
            'title' => __( 'Select Icon', 'mayosis' ),
            'section' => 'section_btn_two',
         ]
      );
       $this->add_control(
         'button_style_b',
         [
            'label' => __( 'Button Style', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'styleone',
            'title' => __( 'Select Button Style', 'mayosis' ),
            'section' => 'section_btn_two',
             'options' => [
                    'styleone'  => __( 'Style One', 'mayosis' ),
                    'styletwo' => __( 'Style Two', 'mayosis' ),
                    'transbutton' => __( 'Transparent', 'mayosis' ),
                    'gradientb' => __( 'Gradient', 'mayosis' ),
                    'custombuttonb' => __( 'Custom', 'mayosis' ),
                 ],
         ]
      );
      
      $this->add_control(
         'gradient_bone',
         [
            'label' => __( 'Gradient Color One', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgb(60,40,180)',
            'title' => __( 'Select Gradient Color One', 'mayosis' ),
            'section' => 'section_btn_two',
            
            'condition' => [
                    'button_style_b' => array('gradientb'),
                ],
         ]
      );
       
       $this->add_control(
         'gradient_btwo',
         [
            'label' => __( 'Gradient Color Two', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgb(100,60,220)',
            'title' => __( 'Select Gradient Color Two', 'mayosis' ),
            'section' => 'section_btn_two',
            'condition' => [
                    'button_style_b' => array('gradientb'),
                ],
         ]
      );
      
      $this->add_control(
         'button_b_video_popup',
         [
            'label' => __( 'Video Popup For Button B', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'title' => __( 'Select Popup', 'mayosis' ),
            'section' => 'section_btn_two',
             'options' => [
                    ''  => __( 'No', 'mayosis' ),
                    'data-lity' => __( 'Yes', 'mayosis' ),
                 ],
         ]
      );
      
      $this->add_control(
         'buton_two_bg',
         [
            'label' => __( 'Button Two Background', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button Two Background', 'mayosis' ),
            'section' => 'section_btn_two',
            'condition' => [
                    'button_style_b' => array('custombuttonb'),
                ],
         ]
      );
      
      $this->add_control(
         'buton_two_border',
         [
            'label' => __( 'Button Two Border', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button Two Border', 'mayosis' ),
            'section' => 'section_btn_two',
            
              
             'condition' => [
                    'button_style_b' => array('custombuttonb'),
                ],
         ]
      );
      
       $this->add_control(
         'buton_two_text',
         [
            'label' => __( 'Button Two Text', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button Two Text', 'mayosis' ),
            'description' => __('Work in custom & gradient mode','mayosis'),
            'section' => 'section_btn_two',
            
         ]
      );
      
      $this->add_control(
         'button_b_class',
         [
            'label' => __( 'Button B Custom Class', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'section' => 'section_btn_two',
         ]
      );
       
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
       $button_a_style= $settings['button_style_a'];
       $gradient_color_aa = $settings['gradient_aone'];
        $gradient_color_ab = $settings['gradient_atwo'];
        
        $button_b_style= $settings['button_style_b'];
       $gradient_color_ba = $settings['gradient_bone'];
        $gradient_color_bb = $settings['gradient_btwo'];
       
      ?>

 <!-- Element Code start -->
       

<div class="block_of_dual_button col-md-12" style="text-align:<?php echo $settings['align_button']; ?>;">
                        
                            <a <?php echo $settings['button_a_video_popup']; ?> href="<?php echo $settings['button_a_url']; ?>" class="<?php echo $settings['button_style_a']; ?> btn btn-lg browse-free btn_a <?php echo $settings['button_a_class']; ?>" target="<?php echo $settings['target_button_a']; ?>" 
                            
                            style="<?php if($button_a_style=="custombuttona"){ ?>background:<?php echo $settings['buton_one_bg']; ?>;color:<?php echo $settings['buton_one_text']; ?>;border-color:<?php echo $settings['buton_one_border']; ?>;<?php } elseif($button_a_style=="gradienta"){ ?>background-image:linear-gradient( 90deg, <?php echo esc_attr($gradient_color_aa) ?> 0%, <?php echo esc_attr($gradient_color_ab) ?> 100%);color:<?php echo $settings['buton_one_text']; ?>;border-color:<?php echo $settings['buton_one_border']; ?>;
		<?php } ?>"
                            
                            ><?php echo $settings['button_a_heading']; ?>  <i class="<?php echo $settings['button_icon_a']; ?>"></i></a> 
                            
                            <?php if ( 'yes' == $settings['button-separator'] ) { ?>
                            <span class="divide-button" style="color:<?php echo $settings['sep_color']; ?>"><?php echo $settings['button_separator_text']; ?></span>
                      <?php } else { ?>
                      <span style="width:8px;padding: 4px;"></span>
                      <?php } ?>
   <a <?php echo $settings['button_b_video_popup']; ?>  href="<?php echo $settings['button_b_url']; ?>" class="<?php echo $settings['button_style_b']; ?> btn btn-lg browse-free btn_b <?php echo $settings['button_b_class']; ?>" target="<?php echo $settings['target_button_b']; ?>"
   
   style="<?php if($button_b_style=="custombuttonb"){ ?>background:<?php echo $settings['buton_two_bg']; ?>;color:<?php echo $settings['buton_two_text']; ?>;border-color:<?php echo $settings['buton_two_border']; ?>;<?php } elseif($button_b_style=="gradientb"){ ?>background-image:linear-gradient( 90deg, <?php echo esc_attr($gradient_color_ba) ?> 0%, <?php echo esc_attr($gradient_color_bb) ?> 100%);color:<?php echo $settings['buton_two_text']; ?>;border-color:<?php echo $settings['buton_two_border']; ?>;
		<?php } ?>" 
   
   ><?php echo $settings['button_b_heading']; ?>  <i class="<?php echo $settings['button_icon_b']; ?>"></i></a>
                        
                           
                        
                    </div>
      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Double_button_Elementor_Thing );
?>