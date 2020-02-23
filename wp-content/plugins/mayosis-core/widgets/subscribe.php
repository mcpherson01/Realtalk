<?php


add_action('widgets_init', 'dm_subscribe_widget');

function dm_subscribe_widget()
{
	register_widget('dm_subscribe_widget');
}

class dm_subscribe_widget extends WP_Widget {
	
	function __construct()
	{
		$widget_ops = array('classname' => 'dm_subscribe_widget', 'description' => esc_html__('Displays download item features. Used in Single Download Sidebar','mayosis') );
		$control_ops = array('id_base' => 'dm_subscribe_widget');
		parent::__construct('dm_subscribe_widget', esc_html__('Mayosis Subscribe  widget','mayosis'), $widget_ops, $control_ops);
		
		
	}
	function widget($args, $instance)
	{
		extract($args);
	
		$title = $instance['title'];
	    $text = ! empty( $instance['text'] ) ? $instance['text'] : '';
	    $dm_subscribe_widget_do_shortcode_priority = has_filter( 'widget_text', 'do_shortcode' );
	     $text = apply_filters( 'widget_text', $text, $instance, $this );
	     if ( has_filter( 'widget_text_content', 'do_shortcode' ) && ! $dm_subscribe_widget_do_shortcode_priority ) {
                if ( ! empty( $instance['filter'] ) ) {
                    $text = shortcode_unautop( $text );
                }
                $text = do_shortcode( $text );
            }
        
		echo $before_widget;
		?>
		<div class="sidebar-theme">
		<div class="single-product-widget">
			<h4 class="widget-title"><i class="zil zi-envelope" aria-hidden="true"></i> <?php echo esc_html($title); ?> </h4>
			<div class="details-table_subscribe">
				<?php echo $text; ?>
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
		$instance['text'] =  $new_instance['text'];
		return $instance;
	}
	
	function form($instance)
	{
		$defaults = array('title' => esc_html__('Subscribe','mayosis') );
		$instance = wp_parse_args((array) $instance, $defaults); 
		$instance = wp_parse_args( (array) $instance, array( 'text' => '') );
		$text = esc_textarea($instance['text']); 
?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title','mayosis');?>:</label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_html($text); ?></textarea>
    *<a><?php esc_html_e('Add Any Type Subscribe Shortcode','mayosis'); ?></a>
		<?php }
	}