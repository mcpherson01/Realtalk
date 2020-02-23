<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class mayosis_search_term_Elementor extends Widget_Base {

    public function get_name() {
        return 'mayosis-search-terms';
    }

    public function get_title() {
        return __( 'Mayosis Search Keyword', 'mayosis' );
    }
    public function get_categories() {
        return [ 'mayosis-ele-cat' ];
    }
    public function get_icon() {
        return 'eicon-meta-data';
    }

    protected function _register_controls() {

        $this->add_control(
            'section_edd',
            [
                'label' => __( 'Mayosis Search Terms', 'mayosis' ),
                'type' => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Title', 'mayosis' ),
                'section' => 'section_edd',
            ]
        );

       $this->add_control(
            'list_layout',
            [
                'label'     => esc_html_x( 'Style', 'Admin Panel','mayosis' ),
                'description' => esc_html_x('Column layout for the list"', 'mayosis' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'    =>  "3",
                'section' => 'section_edd',
                "options"    => array(
                    "1" => "One",
                    "2" => "Two",
                    "3" => "Three",
                    "4" => "Four",
                    "5" => "Five",
                    "6" => "Six",
                    "7" => "Seven",
                ),
            ]

        );
        
         $this->add_control(
         'color_text_seven',
         [
            'label' => __( 'Text Color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgb(255,255,255)',
            'title' => __( 'Change text color for style seven', 'mayosis' ),
            'section' => 'section_edd',
            'condition' => [
                    'list_layout' => array('7'),
                ],
         ]
      );
      
        $this->add_control(
            'custom_css',
            [
                'label' => __( 'Custom CSS', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Custom CSS name', 'mayosis' ),
                'section' => 'section_edd',
            ]
        );

    }

    protected function render( $instance = [] ) {

        // get our input from the widget settings.

        $settings = $this->get_settings();
        $custom_css = $settings['custom_css'];
        $recent_section_title = $settings['title'];
        $termstyle = $settings['list_layout'];
        $termcolor = $settings['color_text_seven'];
       global $wp_recent_searches_widget;
        ?>

    <div class="search--term--div <?php echo esc_attr( $custom_css ); ?>">
        <h2 class="section-title"><?php echo esc_attr($recent_section_title); ?> </h2>
        
          <?php if ($termstyle == "1") : ?>
        <div class="search-term-style-one">
            
            <?php elseif ($termstyle == "2") : ?>
               <div class="search-term-style-one bottom--border--style">
                   
              <?php elseif ($termstyle == "3") : ?>
              
               <div class="search-term-style-three tag_widget_single">
            
            <?php elseif ($termstyle == "4") :?>
              
               <div class="search-term-style-four tag_widget_single">
                   
           <?php elseif ($termstyle == "5") : ?>
              
               <div class="search-term-style-five tag_widget_single">
                   
         <?php elseif ($termstyle == "7") : ?>
                   <div class="search-term-style-seven tag_widget_single" style="color:<?php echo esc_attr($termcolor); ?>;">
                       <style>
                           .search-term-style-seven.tag_widget_single  a{
                               color:<?php echo esc_attr($termcolor); ?>
                           }
                       </style>
            <?php  else : ?>
            <div class="tag_widget_single search-term-style-six">
              <?php endif; ?>
              <?php if ($termstyle == "7") : ?>
              <span class="termtitle"><?php esc_html_e('Popular Searches:', 'mayosis'); ?></span> <?php mayosis_show_recent_searches( "<span class='termtags'>", "</span>", ", " ); ?>
              <?php else : ?>
         <?php mayosis_show_recent_searches( "<ul>\n<li>", "</li>\n</ul>", "" ); ?>
         <?php endif; ?>
         </div>
          
</div> 


        <?php

    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new mayosis_search_term_Elementor );
?>