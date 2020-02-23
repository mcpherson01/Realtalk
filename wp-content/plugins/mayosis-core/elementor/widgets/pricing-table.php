<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pricing_table_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-pricing-table';
   }

   public function get_title() {
      return __( 'Mayosis Pricing Table', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-price-list';
   }

   protected function _register_controls() {

      $this->add_control(
         'section_pricing',
         [
            'label' => __( 'Pricing Content', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
       $this->add_control(
         'title',
         [
            'label' => __( 'Title', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Title',
            'title' => __( 'Enter Table Title', 'mayosis' ),
            'section' => 'section_pricing',
         ]
      );
      
       $this->add_control(
         'currency',
         [
            'label' => __( 'Currency', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '$',
            'title' => __( 'Enter Table Price Currency', 'mayosis' ),
            'section' => 'section_pricing',
         ]
      );
       
       $this->add_control(
         'price',
         [
            'label' => __( 'Price', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '25',
            'title' => __( 'Enter Table Price Value', 'mayosis' ),
            'section' => 'section_pricing',
         ]
      );
      
      $this->add_control(
         'time',
         [
            'label' => __( 'Timeframe', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '/mo',
            'title' => __( 'Enter Table Price Timeframe', 'mayosis' ),
            'section' => 'section_pricing',
         ]
      );
       
       $this->add_control(
         'icon',
         [
            'label' => __( 'Icon', 'mayosis' ),
            'type' => Controls_Manager::ICON,
            'default' => '',
            'title' => __( 'Enter Table Title Icon', 'mayosis' ),
            'section' => 'section_pricing',
         ]
      );
       
       $this->add_control(
	'list',
	[
		'label' => __( 'Table Option List', 'mayosis' ),
		'type' => Controls_Manager::REPEATER,
        'section' => 'section_pricing',
		'default' => [
			[
				'list_title' => __( 'Title #1', 'mayosis' ),
			],
		],
		'fields' => [
			[
				'name' => 'list_title',
				'label' => __( 'Title', 'mayosis' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'List Title' , 'mayosis' ),
				'label_block' => true,
			],
            
            [
				'name' => 'list_icon',
				'label' => __( 'Icon', 'mayosis' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fa-check-circle',
                'options' => [
                    'fa-check-circle'  => __( 'Correct', 'mayosis' ),
                    'fa-times-circle' => __( 'Wrong', 'mayosis' ),
                 ],
				
			],
			
		],
		'title_field' => '{{{ list_title }}}',
	]
);
       $this->add_control(
         'button_text',
         [
            'label' => __( 'Button Text', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __( 'Enter Button Text', 'mayosis' ),
            'section' => 'section_pricing',
         ]
      );
       
       $this->add_control(
         'button_url',
         [
            'label' => __( 'Button Url', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'https://teconce.com',
            'title' => __( 'Enter Button Url', 'mayosis' ),
            'section' => 'section_pricing',
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
         'icon-color',
         [
            'label' => __( 'Icon Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#666666',
            'title' => __( 'Select Icon Color', 'mayosis' ),
            'section' => 'section_style',
         ]
      );
       
        $this->add_control(
         'title-color',
         [
            'label' => __( 'Title Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Title Color', 'mayosis' ),
            'section' => 'section_style',
         ]
      );
       
       $this->add_control(
         'title-bg',
         [
            'label' => __( 'Title Background Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#c6c9cc',
            'title' => __( 'Select Title Color', 'mayosis' ),
            'section' => 'section_style',
         ]
      );
       $this->add_control(
         'amount-color',
         [
            'label' => __( 'Pricing Amount Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Pricing Amount Color', 'mayosis' ),
            'section' => 'section_style',
         ]
      );
       
       $this->add_control(
         'button-color',
         [
            'label' => __( 'Button Background Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button Background Color', 'mayosis' ),
            'section' => 'section_style',
         ]
      );
      $this->add_control(
         'button-border-color',
         [
            'label' => __( 'Button Border Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button Border Color', 'mayosis' ),
            'section' => 'section_style',
         ]
      );
      $this->add_control(
         'button-text-color',
         [
            'label' => __( 'Button Text Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button Text Color', 'mayosis' ),
            'section' => 'section_style',
         ]
      );
       $this->add_control(
         'align_title',
         [
            'label' => __( 'Alignment of Title', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'title' => __( 'Select Alignment of Title', 'mayosis' ),
            'section' => 'section_style',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );
      
       $this->add_control(
         'button-hover-color',
         [
            'label' => __( 'Button Background Hover Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button Background Hover Color', 'mayosis' ),
            'section' => 'section_style',
            'selectors' => [
					'{{WRAPPER}} .btn_blue_pricing:hover' => 'background-color: {{VALUE}} !important',],
         ]
      );
      
       $this->add_control(
         'button-border-hover-color',
         [
            'label' => __( 'Button Border Hover Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button Border Hover Color', 'mayosis' ),
            'section' => 'section_style',
            'selectors' => [
					'{{WRAPPER}} .btn_blue_pricing:hover' => 'border-color: {{VALUE}} !important',],
         ]
      );
      
      $this->add_control(
         'button-text-hover-color',
         [
            'label' => __( 'Button Text Hover Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'title' => __( 'Select Button Text Hover Color', 'mayosis' ),
            'section' => 'section_style',
            'selectors' => [
					'{{WRAPPER}} .btn_blue_pricing:hover' => 'color: {{VALUE}} !important',],
         ]
      );
       $this->add_control(
         'align_content',
         [
            'label' => __( 'Alignment of Content', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'title' => __( 'Select Alignment of Content', 'mayosis' ),
            'section' => 'section_style',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 ],
         ]
      );
      
      $this->add_control(
			'title_padding',
			[
				'label' => __( 'Title Padding', 'mayosis' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'section' => 'section_style',
				'selectors' => [
					'{{WRAPPER}} .pricing_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		 $this->add_control(
	'pricing_padding',
			[
				'label' => __( 'Pricing Padding', 'mayosis' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'section' => 'section_style',
				'selectors' => [
					'{{WRAPPER}} .price_tag_table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
       
       $this->add_control(
			'button_margin',
			[
				'label' => __( 'Button Margin', 'mayosis' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'section' => 'section_style',
				'selectors' => [
					'{{WRAPPER}} .btn_blue_pricing ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
        $this->add_control(
         'section_label',
         [
            'label' => __( 'Label', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
             );
       
            $this->add_control(
         'show_label',
         [
            'label' => __( 'Label', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'show',
            'section' => 'section_label',
             'options' => [
                    'show'  => __( 'Show', 'mayosis' ),
                    'hide' => __( 'Hide', 'mayosis' ),
                 ],
         ]
      );
            
    $this->add_control(
         'label_text',
         [
            'label' => __( 'Label Text', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Featured',
            'title' => __( 'Enter Label Text', 'mayosis' ),
            'section' => 'section_label',
         ]
      );
        
    $this->add_control(
         'label_bg',
         [
            'label' => __( 'Label Background', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#94a63a',
            'section' => 'section_label',
         ]
      );
       
       
            $this->add_control(
         'show_save',
         [
            'label' => __( 'Save', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'hide',
            'section' => 'section_label',
             'options' => [
                    'show'  => __( 'Show', 'mayosis' ),
                    'hide' => __( 'Hide', 'mayosis' ),
                 ],
         ]
      );
       $this->add_control(
         'save_label_text',
         [
            'label' => __( 'Save Label Text', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Save',
            'title' => __( 'Enter Save Label Text', 'mayosis' ),
            'section' => 'section_label',
         ]
      );
       $this->add_control(
         'save_p_amount',
         [
            'label' => __( 'Save Amount', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '45%',
            'title' => __( 'Enter Save Amount', 'mayosis' ),
            'section' => 'section_label',
         ]
      );
       
       $this->add_control(
         'save_label_bg',
         [
            'label' => __( 'Save Label Background', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '45%',
            'title' => __( 'Enter Save Label Background', 'mayosis' ),
            'section' => 'section_label',
         ]
      );
        
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
       $list = $this->get_settings( 'list' );
      ?>

 <!-- Element Code start -->
       
   <div class="dm_pricing_table">
        	<div class="pricing_title" style="background:<?php echo $settings['title-bg']; ?>">
				<h2 style="color:<?php echo $settings['title-color']; ?>; text-align:<?php echo $settings['align_title']; ?>;"><i class=" <?php echo $settings['icon']; ?>" aria-hidden="true" style="color:<?php echo $settings['icon-color']; ?>;"></i> <?php echo $settings['title']; ?></h2>
			</div>
			  <?php if($settings['show_label'] == "show"){ ?>
			<div class="lable_price_data">
				<span class="label_pricing" style="background:<?php echo $settings['label_bg']; ?>;"><?php echo $settings['label_text']; ?></span>
			</div>
			<?php } else { ?>
			 <?php } ?>
			<div class="pricing_content">
			    <div class="pricing_table_title_box">
				<h3 class="price_tag_table" style="color:<?php echo $settings['amount_color']; ?>;"> <sub class="pricing_currency"><?php echo $settings['currency']; ?></sub> <?php echo $settings['price']; ?><span class="pricing_timeframe"><?php echo $settings['time']; ?></span></h3>
				</div>
			  <?php if($settings['show_save'] == "show"){ ?>
				<span class="save_tooltip"  style="background:<?php echo $settings['save_label_bg']; ?>;"><?php echo $settings['save_label_text']; ?> <br>
				<?php echo $settings['save_p_amount']; ?></span>
				<?php } else { ?>
			 <?php } ?>
				
				<div class="main_price_content" style="text-align:<?php echo $settings['align_content']; ?>;">
				<?php if ( $list ) {
                    echo '<ul>';
                    foreach ( $list as $item ) {
                        echo '<li>'.'<i class="fa '.$item['list_icon'].'" aria-hidden="true">'.'</i>' . $item['list_title'] . '</li>';
                    }
                    echo '</ul>';
                          
                }?>
				</div>
				<a href="<?php echo $settings['button_url']; ?>" class="btn_blue_pricing btn"  style="background:<?php echo $settings['button-color']; ?>;border-color:<?php echo $settings['button-border-color']; ?>;color:<?php echo $settings['button-text-color']; ?>;"><?php echo $settings['button_text']; ?></a>
			</div>
		</div>

      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Pricing_table_Elementor_Thing );
?>