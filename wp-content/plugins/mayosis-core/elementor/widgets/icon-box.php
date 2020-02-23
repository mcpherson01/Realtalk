<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class icon_box_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-icon-box';
   }

   public function get_title() {
      return __( 'Mayosis Icon Box', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-info-box';
   }

   protected function _register_controls() {

      $this->add_control(
         'section_icon_box',
         [
            'label' => __( 'Box Content', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

      $this->add_control(
         'section_heading',
         [
            'label' => __( 'Title', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __( 'Enter Icon Box Title', 'mayosis' ),
            'section' => 'section_icon_box',
         ]
      );

		$this->add_control(
         'section_icon',
         [
            'label' => __( 'Icon', 'mayosis' ),
            'type' => Controls_Manager::ICON,
            'default' => '',
            'title' => __( 'Select Icon', 'mayosis' ),
            'section' => 'section_icon_box',
         ]
      );
      $this->add_control(
        	'show_cicon',
        	[
        		'label' => __( 'Show Custom Icon', 'mayosis' ),
        		'type' => Controls_Manager::SWITCHER,
        		'default' => '',
        		'label_on' => __( 'Show', 'mayosis' ),
        		'label_off' => __( 'Hide', 'mayosis' ),
        		'return_value' => 'yes',
        		'section' => 'section_icon_box',
        	]
        );
              $this->add_control(
         'image',
         [
            'label' => __( 'Custom Icon', 'mayosis' ),
            'type' => Controls_Manager::MEDIA,
            'section' => 'section_icon_box',
         ]
      );
      $this->add_control(
              'icon_width',
              [
                 'label'       => __( 'Custom Icon Width', 'mayosis' ),
                 'type'        => Controls_Manager::TEXT,
                 'default'     => __( '25', 'mayosis' ),
                 'placeholder' => __( 'Input only integear value', 'mayosis' ),
                 'section' => 'section_icon_box',
              ]
            );
            
            $this->add_control(
              'icon_height',
              [
                 'label'       => __( 'Custom Icon Width', 'mayosis' ),
                 'type'        => Controls_Manager::TEXT,
                 'default'     => __( '25', 'mayosis' ),
                 'placeholder' => __( 'Input only integear value', 'mayosis' ),
                 'section' => 'section_icon_box',
              ]
            );
      
		$this->add_control(
         'section_content',
         [
            'label' => __( 'Content', 'mayosis' ),
            'type' => Controls_Manager::TEXTAREA,
            'default' => '',
            'title' => __( 'Add Content', 'mayosis' ),
            'section' => 'section_icon_box',
         ]
      );
      $this->add_control(
         'cbtn_text',
         [
            'label' => __( 'Custom Button Text', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __( 'Enter Custom Button Text', 'mayosis' ),
            'section' => 'section_icon_box',
         ]
      );
      
       $this->add_control(
         'cbtn_url',
         [
            'label' => __( 'Custom Button Url', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __( 'Enter Custom Button Url', 'mayosis' ),
            'section' => 'section_icon_box',
         ]
      );
      
    $this->add_control(
         'section_icon_style',
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
            'section' => 'section_icon_style',
         ]
      );
      
        $this->add_control(
         'icon_bg',
         [
            'label' => __( 'Icon Bg Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#4c00db',
            'title' => __( 'Select Icon Bg Color', 'mayosis' ),
            'section' => 'section_icon_style',
         ]
      );
      
       $this->add_control(
         'title_color',
         [
            'label' => __( 'Title Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Title Color', 'mayosis' ),
            'section' => 'section_icon_style',
         ]
      );
       
       $this->add_control(
         'content_color',
         [
            'label' => __( 'Content Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Content Color', 'mayosis' ),
            'section' => 'section_icon_style',
         ]
      );
       
       $this->add_control(
         'align_icon',
         [
            'label' => __( 'Icon Align', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'title' => __( 'Select Icon Align', 'mayosis' ),
            'section' => 'section_icon_style',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );
       
       $this->add_control(
         'align_image',
         [
            'label' => __( 'Custom Icon Align', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'center-block',
            'title' => __( 'Select Custom Icon Align', 'mayosis' ),
            'section' => 'section_icon_style',
             'options' => [
                    'align-left'  => __( 'Left', 'mayosis' ),
                    'center-block' => __( 'Center', 'mayosis' ),
                    'align-right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );
       $this->add_control(
         'align_title',
         [
            'label' => __( 'Title Align', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'title' => __( 'Select Title Align', 'mayosis' ),
            'section' => 'section_icon_style',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );

       $this->add_control(
         'align_content',
         [
            'label' => __( 'Content Align', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'title' => __( 'Select Content Align', 'mayosis' ),
            'section' => 'section_icon_style',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );
       
       
      $this->add_control(
         'title_font_size',
         [
            'label' => __( 'Title Font Size', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '20px',
            'title' => __( 'Custom Title Font Size(With px)', 'mayosis' ),
            'section' => 'section_icon_style',
         ]
      );
      
       $this->add_control(
         'icon_gradient',
         [
            'label' => __( 'Icon Gradient', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'no',
            'title' => __( 'Add Icon Gradient', 'mayosis' ),
            'section' => 'section_icon_style',
             'options' => [
                    'yes'  => __( 'Yes', 'mayosis' ),
                    'no' => __( 'No', 'mayosis' ),
                 ],
         ]
      );
    
       $this->add_control(
         'gradient_one',
         [
            'label' => __( 'Gradient Color One', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Gradient Color One', 'mayosis' ),
            'section' => 'section_icon_style',
            'condition' => [
                    'icon_gradient' => array('yes'),
                ],
         ]
      );
       
       $this->add_control(
         'gradient_two',
         [
            'label' => __( 'Gradient Color Two', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Gradient Color Two', 'mayosis' ),
            'section' => 'section_icon_style',
            'condition' => [
                    'icon_gradient' => array('yes'),
                ],
         ]
      );
      
      $this->add_control(
         'cs_bg_type',
         [
            'label' => __( 'Custom Image Background Type', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'no',
            'title' => __( 'Select Custom Image Background Type', 'mayosis' ),
            'section' => 'section_icon_style',
             'options' => [
                    'color'  => __( 'Color', 'mayosis' ),
                    'gradient' => __( 'Gradient', 'mayosis' ),
                 ],
         ]
      );
       
       $this->add_control(
         'cs_bg_color',
         [
            'label' => __( 'Custom Background Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#001450',
            'title' => __( 'Select Custom Background Color', 'mayosis' ),
            'section' => 'section_icon_style',
            'condition' => [
                    'cs_bg_type' => array('color'),
                ],
         ]
      );
      
      
      $this->add_control(
         'cs_g1_color',
         [
            'label' => __( 'Custom Background Gradient One', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#00ffff',
            'title' => __( 'Select Custom Background Gradient', 'mayosis' ),
            'section' => 'section_icon_style',
            'condition' => [
                    'cs_bg_type' => array('gradient'),
                ],
         ]
      );
      
      $this->add_control(
         'cs_g2_color',
         [
            'label' => __( 'Custom Background Gradient Two', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#001450',
            'title' => __( 'Select Custom Background Gradient', 'mayosis' ),
            'section' => 'section_icon_style',
            'condition' => [
                    'cs_bg_type' => array('gradient'),
                ],
         ]
      );
      
      
      $this->add_control(
         'cs_bg_padding',
         [
            'label' => __( 'Custom Background Padding', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '20px',
            'title' => __( 'Custom Backgroud padding(With px)', 'mayosis' ),
            'section' => 'section_icon_style',
         ]
      );
      
      
      $this->add_control(
         'cs_bg_radius',
         [
            'label' => __( 'Custom Image Background Border radius', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '20px',
            'title' => __( 'Custom Image Background Border radius (with px or %)', 'mayosis' ),
            'section' => 'section_icon_style',
         ]
      );
      
       $this->add_control(
         'cs_bg_stop',
         [
            'label' => __( 'Custom Image Stacked on Top', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '20px',
            'title' => __( 'Custom Image Stacked on Top (with px or %)', 'mayosis' ),
            'section' => 'section_icon_style',
         ]
      );
      
       $this->add_control(
         'btn_align',
         [
            'label' => __( 'Custom Button Align', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'no',
            'title' => __( 'Select Custom Button Align', 'mayosis' ),
            'section' => 'section_icon_style',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );
      
      $this->add_control(
         'cbtn_margin_top',
         [
            'label' => __( 'Custom Button Margin Top', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '20px',
            'title' => __( 'Custom Image Button Margin Top (with px or %)', 'mayosis' ),
            'section' => 'section_icon_style',
         ]
      );
      
      $this->add_control(
         'cbtn_margin_bottom',
         [
            'label' => __( 'Custom Button Margin Bottom', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '20px',
            'title' => __( 'Custom Image Button Margin Bottom (with px or %)', 'mayosis' ),
            'section' => 'section_icon_style',
         ]
      );
      
      $this->add_control(
         'cbtn_bg_color',
         [
            'label' => __( 'Custom Button BG Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#2d3ce6',
            'title' => __( 'Custom Image Background Color', 'mayosis' ),
            'section' => 'section_icon_style',
         ]
      );
      $this->add_control(
         'cbtn_text_color',
         [
            'label' => __( 'Custom Button Text Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Custom Image Text Color', 'mayosis' ),
            'section' => 'section_icon_style',
         ]
      );
      
       $this->add_control(
        	'icon_beside',
        	[
        		'label' => __( 'Icon Beside Title', 'mayosis' ),
        		'type' => Controls_Manager::SWITCHER,
        		'default' => '',
        		'label_on' => __( 'Yes', 'mayosis' ),
        		'label_off' => __( 'No', 'mayosis' ),
        		'return_value' => 'yes',
        		'section' => 'section_icon_style',
        	]
        );
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
       $images = $this->get_settings( 'image' );
      ?>


    <div class="mayosis-icon-box">
     <?php if ($settings['icon_beside'] == "yes"){ ?>
     <div class="quality-box quality-box-flex">
     <div class="icon-beside-title">
     <?php } else{ ?>
     <div class="quality-box">
     <div style="text-align:<?php echo $settings['align_icon']; ?>;margin-top:-<?php echo $settings['cs_bg_stop']; ?>">
     <?php } ?>
        
            <?php if ($settings['show_cicon'] == "yes"){ ?>
            
                <?php if($settings['cs_bg_type'] == "gradient"){ ?>
            <p class="qxbox-cs-bg" style="background:linear-gradient(60deg, <?php echo $settings['cs_g1_color']; ?> 0%,<?php echo $settings['cs_g2_color']; ?> 100%);
            padding:<?php echo $settings['cs_bg_padding']; ?>;border-radius:<?php echo $settings['cs_bg_radius']; ?>;">
            <?php } else { ?>
            <p class="qxbox-cs-bg" style="background-color:<?php echo $settings['cs_bg_color']; ?>;padding:<?php echo $settings['cs_bg_padding']; ?>;border-radius:<?php echo $settings['cs_bg_radius']; ?>;">
            <?php } ?>
              <img src="<?php echo $images['url']; ?>" class="img-responsive <?php echo $settings['align_image']; ?>" alt="custom-img" style="width:<?php echo $settings['icon_width'];?>px; height:<?php echo $settings['icon_height'];?>px">
              
              </p>
            <?php } else { ?>   
        <?php if($settings['icon_gradient'] == 'yes'){ ?>
		<i class="<?php echo $settings['section_icon']; ?>" aria-hidden="true" style="background: -webkit-linear-gradient(135deg,<?php echo $settings['gradient_one']; ?>, <?php echo $settings['gradient_two']; ?>);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;"></i>
       
        <?php } else { ?>				  
        <i class="<?php echo $settings['section_icon']; ?> icon-with-bg" aria-hidden="true" style="color:<?php echo $settings['icon_color']; ?>; background:<?php echo $settings['icon_bg']; ?>;"></i>
        <?php } ?>
               <?php } ?>  
			</div>
			  <?php if ($settings['icon_beside'] == "yes"){ ?>
			  <div class="icon-beside-title-text" style="color:<?php echo $settings['content_color']; ?>; text-align:<?php echo $settings['align_content']; ?>;">
			  <h4  style="color:<?php echo $settings['title_color']; ?>;text-align:<?php echo $settings['align_title']; ?>;font-size:<?php echo $settings['title_font_size']; ?>;"><?php echo $settings['section_heading']; ?></h4>
			   <div class="icon-box-content">	
			  <?php echo $settings['section_content']; ?>
			  
			  <?php if($settings['cbtn_url']){ ?>		
		    <div class="qb-custom-button" style="text-align:<?php echo $settings['btn_align']; ?>;margin-top:<?php echo $settings['cbtn_margin_top']; ?>;margin-bottom:<?php echo $settings['cbtn_margin_bottom']; ?>;">
		        <a href="<?php echo $settings['cbtn_url']; ?>" class="btn qb-btn-cs" style="background:<?php echo $settings['cbtn_bg_color']; ?>; color:<?php echo $settings['cbtn_text_color']; ?>;"><?php echo $settings['cbtn_text']; ?></a>
		    </div>
		    <?php } ?>
			  </div>
			  </div>
			  <?php } else { ?>
			  <h4 style="color:<?php echo $settings['title_color']; ?>;text-align:<?php echo $settings['align_title']; ?>;font-size:<?php echo $settings['title_font_size']; ?>;"><?php echo $settings['section_heading']; ?></h4>
			  <div class="icon-box-content">
			  <div style="color:<?php echo $settings['content_color']; ?>; text-align:<?php echo $settings['align_content']; ?>;"><?php echo $settings['section_content']; ?></div>
			  
			  <?php if($settings['cbtn_url']){ ?>		
		    <div class="qb-custom-button" style="text-align:<?php echo $settings['btn_align']; ?>;margin-top:<?php echo $settings['cbtn_margin_top']; ?>;margin-bottom:<?php echo $settings['cbtn_margin_bottom']; ?>;">
		        <a href="<?php echo $settings['cbtn_url']; ?>" class="btn qb-btn-cs" style="background:<?php echo $settings['cbtn_bg_color']; ?>; color:<?php echo $settings['cbtn_text_color']; ?>;"><?php echo $settings['cbtn_text']; ?></a>
		    </div>
		    <?php } ?>
		    
			    </div>
			  	
			  <?php } ?>
            
			
		</div>
		
		</div>

      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new icon_box_Elementor_Thing );
?>