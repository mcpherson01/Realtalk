<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class mayosis_edd_category_Elementor extends Widget_Base {

    public function get_name() {
        return 'mayosis-edd-category';
    }

    public function get_title() {
        return __( 'Mayosis Download Category', 'mayosis' );
    }
    public function get_categories() {
        return [ 'mayosis-ele-cat' ];
    }
    public function get_icon() {
        return 'eicon-elementor';
    }

    protected function _register_controls() {

        $this->add_control(
            'section_edd',
            [
                'label' => __( 'Mayosis Download Category', 'mayosis' ),
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
       
        ?>

   
        <div class="<?php
        echo esc_attr($custom_css); ?>">
             <h2 class="section-title"><?php echo esc_attr($recent_section_title); ?> </h2>
        <?php echo mayosis_edd_grid_terms(); ?>
        </div>


        <?php

    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new mayosis_edd_category_Elementor );
?>