<?php

add_action( 'widgets_init', 'widget_tabs_box' );
function widget_tabs_box(){
	register_widget( 'widget_tabs' );
}
class widget_tabs extends WP_Widget {
	function widget_tabs() {
		$widget_ops = array( 'description' => 'Most Popular, Recent'  );
		parent::__construct( 'widget_tabs','Mayosis Post Tab', $widget_ops );
	}
	function widget( $args, $instance ) {
		extract( $args );
		$posts_order = $instance['posts_order'];
		if( empty($instance['posts_number']) || $instance['posts_number'] == ' ' || !is_numeric($instance['posts_number']))	$posts_number = 5;
		else $posts_number = $instance['posts_number'];
	?>
	<div class="sidebar-theme">
<div class="sidebar-product-widget post-tabs">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a href="#1a" data-toggle="tab"><?php esc_html_e( 'Popular' , 'mayosis' ) ?></a></li>
                        <li><a href="#2a" data-toggle="tab"><?php esc_html_e( 'Recent' , 'mayosis' ) ?></a> </li>
                    </ul>
                    <div class="tab-content clearfix">
                        <div class="tab-pane active" id="1a">
                             <?php if( $posts_order == 'viewed' ) mayosis_most_viewed_posts( $posts_number  );
						else mayosis_popular_posts( $posts_number  );
					?>	
                            <!--Sidebar Blog Post-->
                            
                            
                        </div>
                        <div class="tab-pane" id="2a">
                            <?php mayosis_sidebar_post( $posts_number  )?>	
                        </div>
                    </div>
                </div>
                </div>
<?php
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['posts_order'] = strip_tags( $new_instance['posts_order'] );
		$instance['posts_number'] = strip_tags( $new_instance['posts_number'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'posts_order' => 'popular', 'posts_number' => 5 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_number' ); ?>"><?php esc_html_e('Number of items to show :','mayosis'); ?> </label>
			<input id="<?php echo $this->get_field_id( 'posts_number' ); ?>" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" value="<?php echo $instance['posts_number']; ?>" size="3" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_order' ); ?>"><?php esc_html_e('Popular order :','mayosis'); ?> </label>
			<select id="<?php echo $this->get_field_id( 'posts_order' ); ?>" name="<?php echo $this->get_field_name( 'posts_order' ); ?>" >
				<option value="popular" <?php if( $instance['posts_order'] == 'popular' ) echo "selected=\"selected\""; else echo ""; ?>>Most Commented</option>
				<option value="viewed" <?php if( $instance['posts_order'] == 'viewed' ) echo "selected=\"selected\""; else echo ""; ?>>Most Viewed</option>
			</select>
		</p>
	<?php
	}
}
?>
