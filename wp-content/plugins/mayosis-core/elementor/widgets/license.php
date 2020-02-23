<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class mayosis_license_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-license-grid';
   }

   public function get_title() {
      return __( 'Mayosis License', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-skill-bar';
   }

   protected function _register_controls() {

      $this->add_control(
         'section_license',
         [
            'label' => __( 'mayosis License', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

		
      $this->add_control(
				'item_per_page',
				[
					'label'   => esc_html_x( 'Amount of item to display', 'Admin Panel', 'mayosis' ),
					'type'    => Controls_Manager::NUMBER,
					'default' =>  "3",
                    'section' => 'section_license',
				]
		);  
		
        
        $this->add_control(
            'order',
            [
                'label' => __( 'Order', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_license',
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'desc',

            ]
        );
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
$post_count = ! empty( $settings['item_per_page'] ) ? (int)$settings['item_per_page'] : 5;
$post_order_term=$settings['order'];
      ?>


	<?php
                    global $post;
         $args = array( 'post_type' => 'licence','numberposts' => $post_count,'order' => (string) trim($post_order_term), );
         $recent_posts = get_posts( $args ); ?>
		    <?php
    	foreach( $recent_posts as $post ){?>
		  	<?php if( get_field('licence_type') == 'youcan' ): ?>
	<div class="dm_licence_main">
		<h2 class="licence_main_title youcantitle"><?php the_title();?></h2>
		<div class="main_content_licence youcan">
		<?php if( have_rows('licence_table_(you_can)') ): ?>
			<table class="table table-striped">
			<?php while( have_rows('licence_table_(you_can)') ): the_row(); 

		// vars
		$details_text = get_sub_field('details_text');

		?>
				<tr>
					<td><?php echo esc_html($details_text); ?></td>
					<td>
					<span class="fa-stack fa-lg">
					  <i class="fa fa-circle fa-stack-2x icon-background1"></i>
					  <i class="fa fa-check fa-stack-1x color_ic_n"></i>
					</span>
					</td>
				</tr>
				<?php endwhile; ?>
			</table>
			<?php endif; ?>
		</div>
	</div>
	
		<?php else: ?>
		<div class="dm_licence_main">
		<h2 class="licence_main_title youcannottitle"><?php the_title(); ?></h2>
		<div class="main_content_licence youcannot">
		<?php if( have_rows('licence_table_(you_can_not)') ): ?>
			<table class="table table-striped">
			<?php while( have_rows('licence_table_(you_can_not)') ): the_row(); 

		$details_text = get_sub_field('details_text');

		?>
				<tr>
					<td><?php echo esc_html($details_text); ?></td>
					<td>
					<span class="fa-stack fa-lg">
					  <i class="fa fa-circle fa-stack-2x icon-background1"></i>
					  <i class="fa fa-times fa-stack-1x color_ic_n"></i>
					</span>
					</td>
				</tr>
				<?php endwhile; ?>

			
			</table>
			
<?php endif; ?>
		</div>
	</div>
			<?php endif; ?>
	
	<?php } ?>
         <?php  wp_reset_postdata();
         ?>
   

      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new mayosis_license_Elementor_Thing );
?>