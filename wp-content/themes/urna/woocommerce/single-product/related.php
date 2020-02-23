<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

if ( sizeof( $related_products ) == 0 ) return;


if( isset($_GET['releated_columns']) ) { 
	$woocommerce_loop['columns'] = $_GET['releated_columns'];
} else {
	$woocommerce_loop['columns'] = urna_tbay_get_config('releated_product_columns', 4);
}

$columns_desktopsmall = 3;
$columns_tablet = 2;
$columns_mobile = 2;

$rows = apply_filters( 'urna_supermaket_woo_row_single_full', false,2 ); 
if($rows) {
	$rows = 4;
	$woocommerce_loop['columns'] = 1;
	$columns_desktopsmall = 1;
	$columns_tablet = 1;
	$columns_mobile = 1;
} else {
	$rows = 1;
}

$show_product_releated = urna_tbay_get_config('enable_product_releated', true);
 
if ( $related_products && $show_product_releated ) : ?> 

	<div class="related products tbay-addon tbay-addon-products" id="product-related">
		<h3 class="tbay-addon-title"><span><?php esc_html_e( 'Related Products', 'urna' ); ?></span></h3>
		<div class="tbay-addon-content woocommerce">
		<?php  wc_get_template( 'layout-products/carousel-related.php' , array( 'loops'=>$related_products,'rows' => $rows, 'pagi_type' => 'yes', 'nav_type' => 'yes','columns'=>$woocommerce_loop['columns'],'screen_desktop'=>$woocommerce_loop['columns'],'screen_desktopsmall'=>$columns_desktopsmall,'screen_tablet'=>$columns_tablet,'screen_mobile'=>$columns_mobile ) ); ?>
		</div>
	</div>

<?php endif;

wp_reset_postdata();