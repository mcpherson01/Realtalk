<?php 

if ( class_exists( 'Easy_Digital_Downloads' ) ) :
class product_release_info extends WP_Widget {
  /**
  * Start Widget
  **/
	public function __construct() {
    $widget_options = array( 
      'classname' => 'product_release_info',
      'description' => 'Product Information',
    );
    parent::__construct( 'product_release_info', 'Mayosis Product Information', $widget_options );
  }
	/**
  * Frontend
  **/
	public function widget( $args, $instance ) {
  $title = apply_filters( 'widget_title', $instance[ 'title' ] );
  $download_id = get_the_ID();
$widgetlayouts  = get_theme_mod( 'product_information_widget_manager', array( 'price','released','updated','fileincluded','filesize' ,'compatible') );
  echo $args['before_widget']; ?>
  
  <h4 class="widget-title"><i class="zil zi-info-ii"></i> <?php echo esc_html($title); ?></h4>
  <ul class="release-info">
    <?php if ($widgetlayouts): foreach ($widgetlayouts as $layout) {
 
                            switch($layout) {
                         
                         
                                case 'price': get_template_part( 'includes/products/information-price' );
                                break;
                                
                                 case 'released': get_template_part( 'includes/products/information-released' );
                                break;
                                
                                
                                 case 'updated': get_template_part( 'includes/products/information-updated' );
                                break;
                                
                                case 'version': get_template_part( 'includes/products/information-version' );
                                break;
                                
                                 case 'fileincluded': get_template_part( 'includes/products/information-fileincluded' );
                                break;
                         
                               case 'filesize': get_template_part( 'includes/products/information-filesize' );
                                break;
                                
                                
                                 case 'compatible': get_template_part( 'includes/products/information-compatible' );
                                break;
                                
                                case 'documentation': get_template_part( 'includes/products/information-documentation' );
                                break;
                                
                                 case 'sales': get_template_part( 'includes/products/information-sales' );
                                break;
                              
                              
                               case 'category': get_template_part( 'includes/products/information-category' );
                                break;
                         
                            }
                         
                        }
                         
                        endif; ?>
                        
                           <?php global $post; $repeatable_fields = get_post_meta($post->ID, 'mayosis_features_field', true);  if ( $repeatable_fields ) : ?>
                            <?php foreach ( $repeatable_fields as $field ) { ?>
                                <li class="release-info-block">

                                    <?php if($field['name'] != '') echo '<div class="rel-info-tag released--info--flex">'. esc_attr( $field['name'] ) . '</div>'; ?>
                                    <span class="released--info--flex">:</span>
                                    <?php if($field['description'] != '') echo '<div class="rel-info-value released--info--flex"> '. $field['description'] . '</div>'; ?>
                                </li>
                            <?php } ?>
                            <?php endif; ?>
                         
                    </ul>


  <?php echo $args['after_widget'];
}
	/**
  * Backend
  **/
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Product Information') );
  $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
  <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'mayosis' ) ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>
				<p>
    Rearrange the product information from the Theme Option. This widget Information will be collected from product.
</p>		    
				    
			
			<?php 
}
	
	public function update( $new_instance, $old_instance ) {
  $instance = $old_instance;
  $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
  return $instance;
}
	
	
}

function product_release_info() { 
  register_widget( 'product_release_info' );
}
add_action( 'widgets_init', 'product_release_info' );

endif;