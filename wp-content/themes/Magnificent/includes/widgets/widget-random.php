<?php class RandomWidget extends WP_Widget
{
    function __construct(){
		$widget_ops = array('description' => 'Displays Random Posts');
		$control_ops = array('width' => 400, 'height' => 300);
		parent::__construct(false,$name='ET Random Posts',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Random Posts' : $instance['title']);
		$postsNum = empty($instance['postsNum']) ? '' : (int) $instance['postsNum'];

		echo '<div class="widget ul-thumb">';

		if ( $title )
		echo $before_title . $title . $after_title;
?>
<ul>
	<?php $custom_query = new WP_Query("posts_per_page=$postsNum&orderby=rand&ignore_sticky_posts=1");
	if ($custom_query->have_posts()) : while ($custom_query->have_posts()) : $custom_query->the_post();
		get_template_part('includes/widget-post'); ?>
	<?php endwhile; endif;
	wp_reset_postdata(); ?>
</ul>
<?php
		echo '</div></div> <!-- end .widget -->';
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['postsNum'] = (int) $new_instance['postsNum'];

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'Random Posts', 'postsNum'=>'5') );

		$title = $instance['title'];
		$postsNum = $instance['postsNum'];

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($title) . '" /></p>';
		# Number of posts
		echo '<p><label for="' . $this->get_field_id('postsNum') . '">' . 'Number Of Posts:' . '</label><input type="text" class="widefat" id="' . $this->get_field_id('postsNum') . '" name="' . $this->get_field_name('postsNum') . '" value="'.esc_attr($postsNum).'"  /></p>';
	}

}// end RecentWidget class

function RandomWidgetInit() {
  register_widget('RandomWidget');
}

add_action('widgets_init', 'RandomWidgetInit');