<?php class TaxonomiesWidget extends WP_Widget
{
    function __construct(){
		$widget_ops = array('description' => 'Displays Taxonomies');
		$control_ops = array('width' => 400, 'height' => 500);
		parent::__construct(false,$name='ET Taxonomies Widget',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Categories' : $instance['title']);

		echo $before_widget;

		if ( $title )
		echo $before_title . $title . $after_title;
?>
	<?php
		$taxArray = array('note','video','quote','photo','customlink','audio');

		for ($i = 0; $i <= 5; $i++) {
			$orderby = 'name'; $show_count = 0; $pad_counts = 0; $hierarchical = 0;
			$taxonomy = 'custom-tax';
			if ($i>0) $taxonomy = 'custom-tax'.($i+1);

			$title = '';
			$args = array( 'orderby' => $orderby, 'show_count' => $show_count, 'pad_counts' => $pad_counts, 'hierarchical' => $hierarchical, 'taxonomy' => $taxonomy, 'title_li' => $title, 'echo' => '0' ); ?>

			<?php $taxonomyCategories = get_categories($args);
			if (!empty($taxonomyCategories)) {
				$taxonomyTemp = wp_list_categories($args); ?>
				<p class="taxonomy"><?php echo esc_html(ucfirst($taxArray[$i]))?>:</p>
				<ul>
					<?php echo $taxonomyTemp; ?>
				</ul>
			<?php };
		}; ?>
<?php
		echo $after_widget;
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'Categories') );

		$title = $instance['title'];

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($title) . '" /></p>';
	}

}// end TaxonomiesWidget class

function TaxonomiesWidgetInit() {
  register_widget('TaxonomiesWidget');
}

add_action('widgets_init', 'TaxonomiesWidgetInit');