<?php

add_action( 'widgets_init', 'recent_post_box' );
function recent_post_box(){
	register_widget( 'recent_post' );
}
class recent_post extends WP_Widget {
	function  __construct() {
		$widget_ops = array( 'description' => 'Most  Recent'  );
		parent::__construct( 'recent_post','Mayosis Recent Blog Post', $widget_ops );
	}
	function widget( $args, $instance ) {
		extract( $args );
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts','mayosis' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		if( empty($instance['posts_number']) || $instance['posts_number'] == ' ' || !is_numeric($instance['posts_number']))	$posts_number = 5;
		else $posts_number = $instance['posts_number'];
	?>
	<div class="sidebar-theme theme--sidebar--widget">
                            
<h4 class="widget-title"><i class="zil zi-timer"></i> <?php echo esc_html($title); ?></h4>
<div class="recent_post_widget">
                            <?php mayosis_sidebar_post( $posts_number  )?>	
								</div>

                </div>       
                        
<?php
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['posts_number'] = strip_tags( $new_instance['posts_number'] );
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance );
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$posts_number    = isset( $instance['posts_number'] ) ? absint( $instance['posts_number'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:','mayosis' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_number' ); ?>"><?php esc_html_e('Number of items to show :','mayosis'); ?> </label>
			<input id="<?php echo $this->get_field_id( 'posts_number' ); ?>" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" value="<?php echo $posts_number; ?>" size="3" type="text" />
		</p>
		
	<?php
	}
}
?>