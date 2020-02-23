<?php global $products; ?>
<h3 class="fes-headers" id="mayofes-orders-page-title"><?php echo EDD_FES()->helper->get_product_constant_name( $plural = true, $uppercase = true ) ?></h3>
<?php echo EDD_FES()->dashboard->product_list_status_bar(); ?>

<div class="fes--list--style-p" id="fes-product-list">

    
                <?php
                if ( count( $products ) > 0 ) {
                    foreach ( $products as $product ) : ?>
                        <div class="product--flex--fes">
                            <div class = "fes-product-list-td fes--mob--image"><?php echo get_the_post_thumbnail( $product->ID, array( 100, 100,true ) ); ?></div>
                            <div class = "fes-product-list-td fes--mob--title"><?php echo EDD_FES()->dashboard->product_list_title( $product->ID ); ?></div>
                            <div class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_status( $product->ID ); ?></div>
                            <div class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_price( $product->ID ); ?></div>
                            <div class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_sales_esc( $product->ID ); ?> <?php esc_html_e('Sales','mayosis'); ?></div>
                            <div class = "fes-product-list-td"><?php EDD_FES()->dashboard->product_list_actions( $product->ID ); ?></div>
                            <div class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_date( $product->ID ); ?></div>
                            <?php do_action( 'fes-product-table-column-value', $product ); ?>
                        </div>
                    <?php
                    endforeach;
                } else {
                    echo '<div><div class = "fes-product-list-td" >' . sprintf( _x( 'No %s found', 'FES lowercase plural setting for download','mayosis' ), EDD_FES()->helper->get_product_constant_name( $plural = true, $uppercase = false ) ) . '</div></div>';
                }
                ?>
            

</div>
<?php EDD_FES()->dashboard->product_list_pagination();
