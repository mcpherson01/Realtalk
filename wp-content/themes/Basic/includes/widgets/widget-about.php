<?php class AboutMeWidget extends WP_Widget
{
    function __construct(){
		$widget_ops = array( 'description' => 'Displays About Me Information' );
		$control_ops = array( 'width' => 400, 'height' => 300 );
		parent::__construct( false, $name='ET About Me Widget', $widget_ops, $control_ops );
    }

	/* Displays the Widget in the front-end */
    function widget( $args, $instance ){
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? esc_html__( 'About Me', 'Basic' ) : esc_html( $instance['title'] ) );
		$imagePath = empty( $instance['imagePath'] ) ? '' : esc_url( $instance['imagePath'] );
		$aboutText = empty( $instance['aboutText'] ) ? '' : $instance['aboutText'];
		$readMore = empty( $instance['readMore'] ) ? '' : esc_url( $instance['readMore'] );

		echo '<div id="about">';
		if ( $title ) {
			echo $before_title . $title . $after_title;
		} ?>
		<div class="widget-about clearfix">
			<img src="<?php echo et_new_thumb_resize( et_multisite_thumbnail( $imagePath ), 74, 74, '', true ); ?>" id="about-image-border" alt="" />
			<p id="about-content"><?php echo wp_kses_post( $aboutText ); ?></p>
			<?php if ( $readMore ) { ?>
				<a href="<?php echo $readMore; ?>" class="about-more" ><?php esc_html_e( 'read more', 'Basic' ); ?></a>
			<?php } ?>
		</div> <!-- end about me section -->
	<?php
		echo '</div>';
	}

	/*Saves the settings. */
    function update( $new_instance, $old_instance ){
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['imagePath'] = esc_url( $new_instance['imagePath'] );
		$instance['aboutText'] = current_user_can( 'unfiltered_html' ) ? $new_instance['aboutText'] : stripslashes( wp_filter_post_kses( addslashes( $new_instance['aboutText'] ) ) );
		$instance['readMore'] = esc_url( $new_instance['readMore'] );

		return $instance;
	}

	/*Creates the form for the widget in the back-end. */
    function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title'=>'About Me', 'imagePath'=>'', 'aboutText'=>'', 'readMore' => '' ) );

		$title = esc_attr( $instance['title'] );
		$imagePath = esc_url( $instance['imagePath'] );
		$aboutText = esc_textarea( $instance['aboutText'] );
		$readMore = esc_url( $instance['readMore'] );

		# Title
		printf( '
			<p>
				<label for="%1$s">%2$s:</label>
				<input class="widefat" id="%1$s" name="%3$s" type="text" value="%4$s" />
			</p>',
			esc_attr( $this->get_field_id( 'title' ) ),
			esc_html__( 'Title', 'Basic' ),
			esc_attr( $this->get_field_name( 'title' ) ),
			$title
		);
		# Image
		printf(
			'<p>
				<label for="%1$s">%2$s:</label>
				<textarea cols="20" rows="2" class="widefat" id="%1$s" name="%3$s">%4$s</textarea>
			</p>',
			esc_attr( $this->get_field_id( 'imagePath' ) ),
			esc_html__( 'Image', 'Basic' ),
			esc_attr( $this->get_field_name( 'imagePath' ) ),
			$imagePath
		);
		# About Text
		printf(
			'<p>
				<label for="%1$s">%2$s:</label>
				<textarea cols="20" rows="5" class="widefat" id="%1$s" name="%3$s" >%4$s</textarea>
			</p>',
			esc_attr( $this->get_field_id( 'aboutText' ) ),
			esc_html__( 'Text', 'Basic' ),
			esc_attr( $this->get_field_name( 'aboutText' ) ),
			$aboutText
		);
		# Read more link
		printf(
			'<p>
				<label for="%1$s">%2$s:</label>
				<textarea cols="20" rows="2" class="widefat" id="%1$s" name="%3$s">%4$s</textarea>
			</p>',
			esc_attr( $this->get_field_id( 'readMore' ) ),
			esc_html__( 'Link', 'Basic' ),
			esc_attr( $this->get_field_name( 'readMore' ) ),
			$readMore
		);
	}

}// end AboutMeWidget class

function AboutMeWidgetInit() {
	register_widget( 'AboutMeWidget' );
}

add_action( 'widgets_init', 'AboutMeWidgetInit' ); ?>