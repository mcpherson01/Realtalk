<?php class TabbedWidget extends WP_Widget
{
    function __construct(){
		$widget_ops = array('description' => 'Displays Recent-Popular-Random widget');
		$control_ops = array('width' => 400, 'height' => 500);
		parent::__construct(false,$name='ET Tabbed',$widget_ops,$control_ops);
	}

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$recentPostsNumber = empty($instance['recentPostsNumber']) ? '' : (int) $instance['recentPostsNumber'];
		$popularPostsNumber = empty($instance['popularPostsNumber']) ? '' : (int) $instance['popularPostsNumber'];
		$randomNumber = empty($instance['randomNumber']) ? '' : (int) $instance['randomNumber'];

?>

<div class="sidebar-block">
	<div id="tabbed-area">
		<div id="tabs">
			<ul id="tab_controls" class="clearfix">
				<li class="first active"><a href="#"><?php esc_html_e('Recent','MyProduct'); ?></a></li>
				<li class="second"><a href="#"><?php esc_html_e('Popular','MyProduct'); ?></a></li>
				<li class="last"><a href="#"><?php esc_html_e('Random','MyProduct'); ?></a></li>
			</ul>
		</div> <!-- end #tabs -->

		<div id="all_tabs">
			<div class="tab-content">
				<h3 class="title"><?php esc_html_e('From the Blog','MyProduct'); ?></h3>
				<ul>
					<?php query_posts("posts_per_page=$recentPostsNumber&cat=".get_catid(get_option('myproduct_blog_cat')));
					if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php get_template_part('includes/fromblog_post'); ?>
					<?php endwhile; endif; wp_reset_query(); ?>
				</ul>
			</div> <!-- end .tab-content -->

			<div class="tab-content">
				<h3 class="title"><?php esc_html_e('Popular','MyProduct'); ?></h3>
				<ul>
					<?php global $wpdb;
					$result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $popularPostsNumber");
					foreach ($result as $post) {
						#setup_postdata($post);
						$postid = (int) $post->ID;
						$title = $post->post_title;
						$commentcount = (int) $post->comment_count;
						if ($commentcount != 0) { ?>
							<?php query_posts("p=$postid"); ?>
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<?php get_template_part('includes/fromblog_post'); ?>
							<?php endwhile; endif; wp_reset_query(); ?>
						<?php };
					}; ?>
				</ul>
			</div> <!-- end .tab-content -->

			<div class="tab-content">
				<h3 class="title"><?php esc_html_e('Random','MyProduct'); ?></h3>
				<ul>
					<?php query_posts("posts_per_page=$randomNumber&caller_get_posts=1&orderby=rand&cat=".get_catid(get_option('myproduct_blog_cat')));
					if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php get_template_part('includes/fromblog_post'); ?>
					<?php endwhile; endif; wp_reset_query(); ?>
				</ul>
			</div> <!-- end .tab-content -->
		</div> <!-- end #all_tabs -->
	</div> <!-- end #tabbed-area -->
</div> <!-- end .sidebar-block -->


<?php
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['recentPostsNumber'] = intval($new_instance['recentPostsNumber']);
		$instance['popularPostsNumber'] = intval($new_instance['popularPostsNumber']);
		$instance['randomNumber'] = intval($new_instance['randomNumber']);

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('recentPostsNumber'=>'3', 'popularPostsNumber'=>'3', 'randomNumber'=>'3') );

		$recentPostsNumber = (int) $instance['recentPostsNumber'];
		$popularPostsNumber = (int) $instance['popularPostsNumber'];
		$randomNumber = (int) $instance['randomNumber'];

		# Number of Recent Posts
		echo '<p><label for="' . $this->get_field_id('recentPostsNumber') . '">' . 'Number of Recent Posts:' . '</label><input class="widefat" id="' . $this->get_field_id('recentPostsNumber') . '" name="' . $this->get_field_name('recentPostsNumber') . '" type="text" value="' . esc_attr($recentPostsNumber) . '" /></p>';

		# Number of Popular Posts
		echo '<p><label for="' . $this->get_field_id('popularPostsNumber') . '">' . 'Number of Popular Posts:' . '</label><input class="widefat" id="' . $this->get_field_id('popularPostsNumber') . '" name="' . $this->get_field_name('popularPostsNumber') . '" type="text" value="' . esc_attr($popularPostsNumber) . '" /></p>';

		# Number of Comments
		echo '<p><label for="' . $this->get_field_id('randomNumber') . '">' . 'Number of Random Posts:' . '</label><input class="widefat" id="' . $this->get_field_id('randomNumber') . '" name="' . $this->get_field_name('randomNumber') . '" type="text" value="' . esc_attr($randomNumber) . '" /></p>';

	}

}// end TabbedWidget class

function TabbedWidgetInit() {
	register_widget('TabbedWidget');
}

add_action('widgets_init', 'TabbedWidgetInit');