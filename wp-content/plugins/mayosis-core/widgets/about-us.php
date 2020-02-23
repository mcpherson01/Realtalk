<?php
// Digital Social
class digital_about extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'digital_about', 

// Widget name will appear in UI
esc_html__('Mayosis About', 'mayosis'), 

// Widget description
array( 'description' => esc_html__( 'Your site&#8217;s About.', 'mayosis' ), ) 
);
}
	


// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
  $title = apply_filters( 'widget_title', $instance[ 'title' ] );
  $about = apply_filters( 'about', $instance[ 'about' ] );
  $image_uri = apply_filters( 'image_uri', $instance[ 'image_uri' ] );
  
  echo $args['before_widget']; ?>
	<div class="sidebar-theme">	
 <img src="<?php echo esc_url($image_uri); ?>" alt="Footer Logo" class="img-responsive footer-logo"/>
						<p class="footer-text"><?php echo esc_html($about); ?></p>
		
                   
                   
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
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['about'] = sanitize_text_field( $new_instance['about'] );
		$instance['image_uri'] = strip_tags( $new_instance['image_uri'] );
		

		return $instance;
	}

	/**
	 * Outputs the settings form for the Categories widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'About Us') );
		$instance = wp_parse_args( (array) $instance, array( 'image_uri' => '#') );
		$instance = wp_parse_args( (array) $instance, array( 'about' => '') );
		$image_uri = strip_tags( $instance['image_uri'] );
		$title = sanitize_text_field( $instance['title'] );
		$about = sanitize_text_field( $instance['about'] );
		
		?>
		<p>
        <label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('About logo:','mayosis'); ?></label><br />

        <?php
            if ( $instance['image_uri'] != '' ) :
                echo '<img class="custom_media_image" src="' . $instance['image_uri'] . '" style="margin:0;padding:0;max-width:100px;float:left;display:inline-block" /></br>';
            endif;
        ?>

        <input type="text" class="widefat custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $instance['image_uri']; ?>" style="margin-top:5px;">

        <input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="Upload Image" style="margin-top:5px;" />
    </p>
		<p><label for="<?php echo $this->get_field_id('about'); ?>"><?php _e( 'About:', 'mayosis' ); ?></label>
		<textarea  rows="10" cols="10" class="widefat text" id="<?php echo $this->get_field_id('about'); ?>" name="<?php echo $this->get_field_name('about'); ?>" /><?php echo esc_textarea( $instance['about'] ); ?></textarea></p>
		
		
		<?php
	}

}
	
// Class digital_about ends here

// Register and load the widget
function load_about_widget() {
	register_widget( 'digital_about' );
}
add_action( 'widgets_init', 'load_about_widget' );

	// add admin scripts
add_action('admin_enqueue_scripts', 'ctup_wdscript');
function ctup_wdscript() {
    wp_enqueue_media();
    wp_enqueue_script('ads_script', get_template_directory_uri() . '/js/widget.js', false, '1.0', true);
}