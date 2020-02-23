<?php
// Digital Recent Product
class digital_recent_products_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'digital_recent_products_widget', 

// Widget name will appear in UI
esc_html__('Mayosis Recent Products', 'mayosis'), 

// Widget description
array( 'description' => __( 'Your site&#8217;s most recent Products.', 'mayosis' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Digital Recent Products','mayosis' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filters the arguments for the Digital Recent Productswidget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'digital_product_args', array(
			'post_type'      => 'download',
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()) :
		?>
		<?php echo $args['before_widget']; ?>
		
		<h4 class="widget-title"><i class="zil zi-cube"></i> <?php echo esc_html($title); ?></h4>
		
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
		<div class="widget-products">
                        <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail"> 
                       <div class="product-thumb grid_dm">
                        <figure class="mayosis-fade-in"> 
                              <?php
									the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
								 ?>
                                   	<figcaption>
                                   	    <div class="overlay_content_center">               
                              <a href="<?php
	the_permalink(); ?>"><i class="zil zi-plus"></i></a>
	</div>
	</figcaption>
	     </figure>
							</div>
							</div>
                        <div class="col-md-6 col-sm-6 col-xs-6  sidebar-details paading-left-0">
							<h3><a href="<?php the_permalink(); ?>"><?php 
                                        $title  = the_title('','',false);
                                        if(strlen($title) > 35):
                                            echo trim(substr($title, 0, 34)).'...';
                                        else:
                                            echo esc_html($title);
                                        endif;
                                        ?></a></h3>
                          <?php get_template_part( 'includes/product-additional-meta'); ?>
                            
                        </div>
                    </div>
		
		<?php endwhile; ?>
		
		<?php echo $args['after_widget']; ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;
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
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		return $instance;
	}

		
// Widget Backend 
public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:','mayosis' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to show:','mayosis' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo esc_html($number); ?>" size="3" /></p>

<?php
	}
}

	
// Class digital_recent_products_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'digital_recent_products_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );