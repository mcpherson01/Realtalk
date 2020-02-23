<?php
// Digital Recent Product
class digital_search extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'digital_search', 

// Widget name will appear in UI
esc_html__('Mayosis Search', 'mayosis'), 

// Widget description
array( 'description' => esc_html__( 'Your site&#8217;s Search.', 'mayosis' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
  $title = apply_filters( 'widget_title', $instance[ 'title' ] );
  echo $args['before_widget']; ?>
		
<div class="sidebar--search--blog">
		
                   <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="width:100%;float: left;">
                       <?php $searchresults = get_search_query(); ?>
                   <div class="input-group sidebar-search">
                    <input class="form-control" value="<?php echo esc_html($searchresults); ?>" placeholder="Search within the blog"  type="search"  name="s" id="search"> <span class="input-group-addon dm_sidebar_input_button" id="icon-addon"><input type="submit" value="submit"></span>
                     	<input type="hidden" name="post_type" value="post" />
                     </div>
			</form>
                   
<div class="clearfix"></div>
</div>
	<?php echo $args['after_widget'];
}
	/**
	 * Handles updating the settings for the current Digital Recent Productswidget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance['title'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','mayosis'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php
	}

	/**
	 * Handles updating settings for the current Search widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}

}


	
// Class digital_search ends here

// Register and load the widget
function load_search_widget() {
	register_widget( 'digital_search' );
}
add_action( 'widgets_init', 'load_search_widget' );