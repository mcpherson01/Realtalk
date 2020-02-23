<?php

if ( class_exists( 'Easy_Digital_Downloads' ) ) :
add_action('widgets_init', 'dm_product_tag_widget');

function dm_product_tag_widget()
{
	register_widget('dm_product_tag_widget');
}

class dm_product_tag_widget extends WP_Widget {
	
	function __construct()
	{
		$widget_ops = array('classname' => 'dm_product_tag_widget', 'description' => esc_html__('Displays download item features. Used in Single Download Sidebar','mayosis') );
		$control_ops = array('id_base' => 'dm_product_tag_widget');
		parent::__construct('dm_product_tag_widget', esc_html__('Mayosis Product Tag Widget','mayosis'), $widget_ops, $control_ops);
		
	}
	function widget($args, $instance)
	{
		extract($args);
	
		$title = $instance['title'];
		echo $before_widget;
		?>
		<?php global $wp_query;
		$postID = $wp_query->post->ID; ?>
		<div class="sidebar-theme">
		<div class="single-product-widget product--tag--widget">
			<h4 class="widget-title"><i class="zil zi-tag" aria-hidden="true"></i> <?php echo esc_html($title); ?> </h4>
			<div class="tag_widget_single">
			<?php $download_tags = get_the_term_list( get_the_ID(), 'download_tag', '<ul><li>', '</li><li>', '</li></ul>', _x(' ', '', 'mayosis' ), '' ); ?>
				<?php echo $download_tags; ?>
			</div>
	</div>
	</div>
		<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		
		return $instance;
	}
	
	function form($instance)
	{
		$defaults = array('title' => esc_html__('Product Tags','mayosis') );
		$instance = wp_parse_args((array) $instance, $defaults); 
		 
?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title','mayosis');?>:</label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		
		<?php }
	}

endif;