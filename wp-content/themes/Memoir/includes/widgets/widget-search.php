<?php class ETSearchWidget extends WP_Widget
{
    function __construct(){
		$widget_ops = array('description' => 'Display custom search field.');
		parent::__construct(false,$name='ET Search',$widget_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
?>
	<div id="custom-search">
		<div id="search-form">
			<form method="get" id="searchform1" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="text" value="<?php esc_attr_e('Search this site...', 'Memoir'); ?>" name="s" id="searchinput" />
				<input type="image" src="<?php bloginfo('template_directory'); ?>/images/search_btn.png" id="searchsubmit" />
			</form>
		</div> <!-- end #search-form -->
	</div> <!-- end #custom-search -->
<?php
	}

}// end ETSearchWidget class

function ETSearchWidgetInit() {
  register_widget('ETSearchWidget');
}

add_action('widgets_init', 'ETSearchWidgetInit');