<?php

add_action( 'widgets_init', 'additional_post_box' );
function additional_post_box(){
	register_widget( 'additional_post_pack' );
}
class additional_post_pack extends WP_Widget {
	function  __construct() {
		$widget_ops = array( 'description' => 'Post Box for Single Product Additional Widget'  );
		parent::__construct( 'additional_post_pack','Mayosis Product List Widget', $widget_ops );
	}
	function widget( $args, $instance ) {
		extract( $args );
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Related Products','mayosis' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$posttype = ( ! empty( $instance['posttype'] ) ) ? $instance['posttype'] : __( 'related','mayosis' );
		if( empty($instance['posts_number']) || $instance['posts_number'] == ' ' || !is_numeric($instance['posts_number']))	$posts_number = 5;
		else $posts_number = $instance['posts_number'];
	?>
	<div class="default-product-sidebar">
                            
<h4 class="widget-title"><i class="zil zi-timer"></i> <?php echo esc_html($title); ?></h4>
<div class="additional_post_pack_widget">
    
                          <?php if ($posttype =='related' ){?>
                            <?php mayosis_related_product_footer( $posts_number  )?>	
                             <?php } elseif ($posttype =='featured' ){?>
                             <?php  mayosis_featured_product_footer( $posts_number  )?>	
                             
                              <?php } elseif ($posttype =='popular' ){?>
                               <?php mayosis_most_viewed_product_footer( $posts_number  )?>	
                               
                               <?php } elseif ($posttype =='sameauthor' ){?>
                               <?php mayosis_same_product_author( $posts_number  )?>	
                        <?php }?>
                            
								</div>

                </div>       
                        
<?php
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['posts_number'] = strip_tags( $new_instance['posts_number'] );
		$instance['posttype']     = strip_tags( $new_instance['posttype'] );
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance );
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$posts_number    = isset( $instance['posts_number'] ) ? absint( $instance['posts_number'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:','mayosis' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
		<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'posttype' ) ); ?>"><?php printf( esc_html__( 'Product Type', 'mayosis' ), edd_get_label_singular() ); ?></label>
				<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'posttype' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'posttype' ) ); ?>">
					<option value="related" <?php if ( $instance['posttype'] == 'related' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Related', 'mayosis' ); ?></option>
					<option value="popular" <?php if ( $instance['posttype'] == 'popular' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Popular', 'mayosis' ); ?></option>
					<option value="featured" <?php if ( $instance['posttype'] == 'featured' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Featured', 'mayosis' ); ?></option>
					<option value="sameauthor" <?php if ( $instance['posttype'] == 'sameauthor' ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Same Author', 'mayosis' ); ?></option>
				</select>
			</p>
			
	
			
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_number' ); ?>"><?php esc_html_e('Number of items to show :','mayosis'); ?> </label>
			<input id="<?php echo $this->get_field_id( 'posts_number' ); ?>" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" value="<?php echo $posts_number; ?>" size="3" type="text" />
		</p>
		
		<p><strong style="background: rgba(0, 142, 194, 0.08);
    padding: 3px 8px;
    font-size: 11px;
    color: #008ec2;
    border-radius: 3px;">Note: this widget releated option work in single product inner widget.</strong></p>
	<?php
	}
}
?>