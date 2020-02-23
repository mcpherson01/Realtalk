<?php class SearchWidget extends WP_Widget
{
    function __construct(){
		$widget_ops = array('description' => 'Displays Search bar');
		$control_ops = array('width' => 400, 'height' => 300);
		parent::__construct(false,$name='ET Search Widget',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$searchText = empty($instance['searchText']) ? 'search this site...' : $instance['searchText'];
?>
<div class="widget search">
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" id="searchform1" method="get">
		<input type="text" id="searchinput" name="s" value="<?php echo esc_attr( $searchText ); ?>"/>

		<?php global $default_colorscheme,$shortname; ?>
		<?php $colorSchemePath = '';
			  $colorScheme = get_option($shortname . '_color_scheme');
			  if ($colorScheme <> $default_colorscheme) $colorSchemePath = strtolower($colorScheme) . '/'; ?>
		<input type="image" id="searchsubmit" src="<?php echo get_template_directory_uri(); ?>/images/<?php if ( $colorSchemePath <> '') echo esc_attr($colorSchemePath); ?>search_btn.png"/>
	</form>
</div> <!-- end .widget -->
<?php
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['searchText'] = sanitize_text_field( $new_instance['searchText'] );

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('searchText'=>'search this site...') );

		$searchText = $instance['searchText'];

		# Search Text
		echo '<p><label for="' . $this->get_field_id('searchText') . '">' . 'Search value text:' . '</label><textarea cols="20" rows="5" class="widefat" id="' . $this->get_field_id('searchText') . '" name="' . $this->get_field_name('searchText') . '" >'. esc_textarea($searchText) .'</textarea></p>';
	}

}// end SearchWidget class

function SearchWidgetInit() {
  register_widget('SearchWidget');
}

add_action('widgets_init', 'SearchWidgetInit');