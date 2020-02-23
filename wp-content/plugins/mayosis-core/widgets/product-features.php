<?php 

if ( class_exists( 'Easy_Digital_Downloads' ) ) :
class product_features_info extends WP_Widget {
  /**
  * Start Widget
  **/
	public function __construct() {
    $widget_options = array( 
      'classname' => 'product_features_info',
      'description' => 'Product Product Features',
    );
    parent::__construct( 'product_features_info', 'Mayosis Products Features', $widget_options );
  }
	/**
  * Frontend
  **/
	public function widget( $args, $instance ) {
  $title = apply_filters( 'widget_title', $instance[ 'title' ] );
  echo $args['before_widget']; ?>
  
  <h4 class="widget-title"><i class="zil zi-cube"></i> <?php echo esc_html($title); ?></h4>
  <div class="features">
      <?php global $post; $repeatable_fields = get_post_meta($post->ID, 'mayosis_features_field', true);  if ( $repeatable_fields ) : ?>
    <div class="list">
         <ul>
        <?php foreach ( $repeatable_fields as $field ) { ?>
        <li class="features-row">
           
            <?php if($field['name'] != '') echo '<span class="features-field features-field-name">'. esc_attr( $field['name'] ) . '</span>'; ?>
            <span class="features-dot">:</span>
            <?php if($field['description'] != '') echo '<span class="features-field"> '. $field['description'] . '</span>'; ?>
        </li>
        <?php } ?> 
        </ul>
    </div>
<?php endif; ?>
  </div>

  <?php echo $args['after_widget'];
}
	/**
  * Backend
  **/
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Features') );
  $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
  <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'mayosis' ) ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p><?php 
}
	
	public function update( $new_instance, $old_instance ) {
  $instance = $old_instance;
  $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
  return $instance;
}
	
	
}

function product_features_info() { 
  register_widget( 'product_features_info' );
}
add_action( 'widgets_init', 'product_features_info' );

endif;