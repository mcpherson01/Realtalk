<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class client_logo_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-client-logo';
   }

   public function get_title() {
      return __( 'Mayosis Logo Grid', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-logo';
   }

   protected function _register_controls() {

      $this->add_control(
         'section_client_logo',
         [
            'label' => __( 'Mayosis Logo Grid', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

    $this->add_control(
  'gallery',
  [
     'label' => __( 'Add Images', 'mayosis' ),
     'type' => Controls_Manager::GALLERY,
     'section' => 'section_client_logo',
  ]
);
       
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
       $images = $this->get_settings( 'gallery' );
      ?>


<div class="dm_clients" style="width:100%;">
    <ul class="slides">
<?php foreach ( $images as $image ) {
    echo '<li><img src="' . $image['url'] . '"></li>';
}
 ?>
</ul>
</div>
      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new client_logo_Elementor_Thing );
?>