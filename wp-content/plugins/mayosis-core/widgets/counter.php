<?php
/**
* Adds mayosis Counter widget
*/
class mayosiscounter_Widget extends WP_Widget {

	/**
	* Register widget with WordPress
	*/
	function __construct() {
		parent::__construct(
			'mayosiscounter_widget', // Base ID
			esc_html__( 'Mayosis Counter', 'mayosis' ), // Name
			array( 'description' => esc_html__( 'Display Counter about Product,Total Download, Custom Etc', 'mayosis' ), ) // Args
		);
	}

	/**
	* Widget Fields
	*/
	private $widget_fields = array(
		array(
			'label' => 'Show Total Product Count',
			'id' => 'product_count',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Label For Product Count',
			'id' => 'product_label',
			'type' => 'text',
		),
		array(
			'label' => 'Show Total Download Count',
			'id' => 'download_count',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Label For Download Count',
			'id' => 'download_label',
			'type' => 'text',
		),
		array(
			'label' => 'Custom Count',
			'id' => 'custom_count',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Custom Count',
			'id' => 'custom_count_text',
			'type' => 'text',
		),
		array(
			'label' => 'Label For Custom Count',
			'id' => 'custom_label',
			'type' => 'text',
		),
	);

	/**
	* Front-end display of widget
	*/
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
 echo '<div class="sidebar-theme widget-stats-counter">';
		// Output widget title
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
    echo '<div class="mx-widget-counter">';
	if ( ! empty( $instance['product_count'] ) ) {
        	    
        	                        $args = array(
                                            'post_type' => 'download',
                                            'posts_per_page'    => -1,
											'download_category' => ''
                                        );
                                        $query = new WP_Query($args);
                                        echo '<h2>'. $query->found_posts .'</h2>';
        	    echo '<p>'.$instance['product_label'].'</p>';
        	}
        	
        		if ( ! empty( $instance['download_count'] ) ) {
        		    	echo '<h2>' .edd_count_total_file_downloads().'</h2>' ;
        		    		echo '<p>'.$instance['download_label'].'</p>';
        		    	
        		}
        		
        			if ( ! empty( $instance['custom_count'] ) ) {
                        echo '<h2>'.$instance['custom_count_text'].'</h2>';
                        echo '<p>'.$instance['custom_label'].'</p>';
        			}
		
	  echo '</div></div>';
	   echo '</div>';
	 
	}

	/**
	* Back-end widget fields
	*/
	public function field_generator( $instance ) {
		$output = '';
		foreach ( $this->widget_fields as $widget_field ) {
			$widget_value = ! empty( $instance[$widget_field['id']] ) ? $instance[$widget_field['id']] :  $widget_field['label'];
			switch ( $widget_field['type'] ) {
				case 'checkbox':
					$output .= '<p>';
					$output .= '<input class="checkbox" type="checkbox" '.checked( $widget_value, true, false ).' id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" value="1">';
					$output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'], 'mayosis' ).'</label>';
					$output .= '</p>';
					break;
				default:
					$output .= '<p>';
					$output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'], 'mayosis' ).':</label> ';
					$output .= '<input class="widefat" id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_name( $widget_field['id'] ) ).'" type="'.$widget_field['type'].'" value="'.esc_attr( $widget_value ).'">';
					$output .= '</p>';
			}
		}
		echo $output;
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'mayosis' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'mayosis' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
		$this->field_generator( $instance );
	}

	/**
	* Sanitize widget form values as they are saved
	*/
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				case 'checkbox':
					$instance[$widget_field['id']] = $_POST[$this->get_field_id( $widget_field['id'] )];
					break;
				default:
					$instance[$widget_field['id']] = ( ! empty( $new_instance[$widget_field['id']] ) ) ? strip_tags( $new_instance[$widget_field['id']] ) : '';
			}
		}
		return $instance;
	}
} // class mayosiscounter_Widget

// register mayosis Counter widget
function register_mayosiscounter_widget() {
	register_widget( 'mayosiscounter_Widget' );
}
add_action( 'widgets_init', 'register_mayosiscounter_widget' );