<?php class RecentWidget extends WP_Widget
{
    function __construct(){
		$widget_ops = array('description' => 'Displays Recent Custom Posts');
		$control_ops = array('width' => 400, 'height' => 500);
		parent::__construct(false,$name='ET Recent Widget',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Recent Posts' : $instance['title']);
		$recentNum = empty($instance['recentNum']) ? 5 : (int) $instance['recentNum'];

		echo $before_widget;

		if ( $title )
		echo $before_title . $title . $after_title;
?>
<?php $args = array(
		   'posts_per_page' => (int) $recentNum,
		   'paged' => $paged,
		   'post_type' => array('note','photo','quote','video','customlink','audio'),
		);
query_posts($args);
echo('<ul>');
	if (have_posts()) : while (have_posts()) : the_post();
		echo('<li><a href="'.esc_url(get_permalink()).'">'.esc_html(get_the_title()).'</a></li>');
	endwhile; endif; wp_reset_query();
echo('</ul>');?>
<?php
		echo $after_widget;
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['recentNum'] = intval( $new_instance['recentNum'] );

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'Recent Posts', 'recentNum'=>'5') );

		$title = $instance['title'];
		$recentNum = (int) $instance['recentNum'];

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($title) . '" /></p>';
		# recentNum
		echo '<p><label for="' . $this->get_field_id('recentNum') . '">' . 'Number of Posts:' . '</label><input class="widefat" id="' . $this->get_field_id('recentNum') . '" name="' . $this->get_field_name('recentNum') . '" type="text" value="' . esc_attr($recentNum) . '" /></p>';
	}

}// end RecentWidget class

function RecentWidgetInit() {
  register_widget('RecentWidget');
}

add_action('widgets_init', 'RecentWidgetInit');