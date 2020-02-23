<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Search_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-search';
   }

   public function get_title() {
      return __( 'Mayosis Search', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-search';
   }

   protected function _register_controls() {

      $this->add_control(
         'search_style',
         [
            'label' => __( 'Search Content', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

       $this->add_control(
         'placeholder_text',
         [
            'label' => __( 'Placeholder text', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Search Now',
            'section' => 'search_style',
         ]
      );

       $this->add_control(
           'search-style',
           [
               'label' => __( 'Search Style', 'mayosis' ),
               'type' => Controls_Manager::SELECT,
               'default' => 'style1',
               'title' => __( 'Search Style', 'mayosis' ),
               'section' => 'search_style',
               'options' => [
                   'style1'  => __( 'Style One', 'mayosis' ),
                   'style2' => __( 'Style Two', 'mayosis' ),
               ],

           ]
       );
       
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
      ?>

 <!-- Element Code start -->
        <div class="product-search-form <?php echo $settings['search-style']; ?>">
		<form method="GET" action="<?php echo esc_url(home_url('/')); ?>">

			<?php 
				$taxonomies = array('download_category');
				$args = array('orderby'=>'count','hide_empty'=>true);
				echo mayosis_get_terms_dropdown($taxonomies, $args);
			 ?>
			
			 
			<div class="search-fields">
				<input name="s" value="<?php echo (isset($_GET['s']))?$_GET['s']: null; ?>" type="text" placeholder="<?php echo $settings['placeholder_text']; ?>">
				<input type="hidden" name="post_type" value="download">
			<span class="search-btn"><input value="" type="submit"></span>
			</div>
		</form>
	</div>
      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Search_Elementor_Thing );
?>