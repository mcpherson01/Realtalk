<?php class SearchWidget extends WP_Widget
{
    function __construct(){
		$widget_ops = array('description' => 'Displays ET Search');
		$control_ops = array('width' => 400, 'height' => 300);
		parent::__construct(false,$name='ET Search',$widget_ops,$control_ops);
    }

	/* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$searchPhrase = empty($instance['searchPhrase']) ? '' : $instance['searchPhrase'];
?>
<div id="search-form">
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" id="searchform" method="get">
		<input type="text" id="searchinput" name="s" value="<?php echo esc_attr($searchPhrase); ?>">
	</form>
</div>
<?php
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['searchPhrase'] = sanitize_text_field( $new_instance['searchPhrase'] );

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('searchPhrase'=>'search this site...') );

		$searchPhrase = $instance['searchPhrase'];

		#Search phrase
		echo '<p><label for="' . $this->get_field_id('searchPhrase') . '">' . 'Search phrase:' . '</label><input type="text" class="widefat" id="' . $this->get_field_id('searchPhrase') . '" name="' . $this->get_field_name('searchPhrase') . '" value="' . esc_attr( $searchPhrase ) . '"  /></p>';
	}

}// end SearchWidget class

function SearchWidgetInit() {
  register_widget('SearchWidget');
}

add_action('widgets_init', 'SearchWidgetInit');