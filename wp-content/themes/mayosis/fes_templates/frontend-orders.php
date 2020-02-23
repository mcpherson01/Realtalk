<?php
global $orders;
do_action( 'fes_before_frontend_orders' );
if ( is_singular( 'download' ) ) {
			$author = new WP_User( $post->post_author );
		} else {
			$author = fes_get_vendor();
		}

		if ( ! $author ) {
			$author = get_current_user_id();
		}
?>
    <h3 class="mayofes-headers" id="mayofes-orders-page-title"><?php _e( 'Orders', 'mayosis' ); ?></h3>

    <div class="mayofes--table--order" id="mayofes-order-list">

        <div class="mayofes-order--flex">
            <?php
            if ( ! empty( $orders ) && count( $orders ) > 0 && is_array( $orders ) ) {
                foreach ( $orders as $order ) :
                    if ( ! is_object( $order ) ) {
                        continue;
                    }
        
                    ?>
                    <div class="mayofes--order--flex--item">
                         <div class = "mayofes-order-flex-data">
                               <?php echo get_the_author_meta( 'user_email',$order->ID ); ?>
                             <?php echo EDD_FES()->dashboard->order_list_customer( $order->ID ); ?></div>
                        <div class = "mayofes-order-flex-data"><?php echo EDD_FES()->dashboard->order_list_title( $order->ID ); ?></div>
                        
                        <div class = "mayofes-order-flex-data mayofes-flex-order-auto"><?php echo EDD_FES()->dashboard->order_list_total( $order->ID ); ?></div>
                    
                        <?php do_action( 'mayofes-order-table-column-value', $order ); ?>
                        <div class = "mayofes-order-flex-data"><?php echo EDD_FES()->dashboard->order_list_date( $order->ID ); ?></div>
                        
                        <div class = "mayofes-order-flex-data"><?php echo EDD_FES()->dashboard->order_list_status( $order->ID ); ?></div>
                        
                        <div class = "mayofes-order-flex-data"><?php EDD_FES()->dashboard->order_list_actions( $order->ID ); ?></div>
                    </div>
                    <?php
                    do_action( 'fes_frontend_order_rows' );
                endforeach;
            } else {
                echo '<div>' . __( 'No orders found','mayosis' ) . '</div><';
            }
            ?>
        </div>
    </div>
<?php EDD_FES()->dashboard->order_list_pagination();

do_action( 'fes_after_frontend_orders' );
