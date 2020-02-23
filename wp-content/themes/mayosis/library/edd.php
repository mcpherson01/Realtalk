<?php
/**
 * Custom edd
 *
 * Learn more: http://docs.easydigitaldownloads.com/
 *
 */


if ( class_exists( 'Easy_Digital_Downloads' ) ) :


///////////////////////////////////////////////////////////////////////////////////////////
//////////////////////   EDD Sale Count /////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

if( ! function_exists( 'dm_get_edd_sale_count' ) ){
  function mayosis_get_edd_sale_count($postID){
   return get_post_meta( $postID, '_edd_download_sales', true ); 
 }
}


function edd_count_total_file_downloads() {
    global $edd_logs;
    return $edd_logs->get_log_count( null, 'file_download' );
}


endif;

	/**
 * Show the list of products when the cart is empty
 *
 * @since 1.0
 */
function checkout_empty_cart_template() {

	echo ( '<section id="Section_empty_cart">
            <div class="container">
			    <div class="row">
                        
                      <div class="col-md-12 empty_cart_icon">
                      <i class="fa fa-shopping-cart"></i>
                      <h1>Your Cart is Empty</h1>
                      <h2>No Problem, Lets Start Browse</h2>
						</div>

                    </div>
                
            </div>
        </section>' );
	get_template_part( 'content/content', 'product-footer' );
}
add_filter( 'edd_cart_empty', 'checkout_empty_cart_template' );

/**
 * Add wrapper class to EDD [download] shortcode
 *
 * @since mayosis 1.0
 */
function mayosis_edd_download_wrap( $class, $atts ) {
	return 'dm-default-wrapper download-wrapper ' . $class;
}
add_filter( 'edd_downloads_list_wrapper_class', 'mayosis_edd_download_wrap', 10, 2 );
/**
 * Change checkout page image size
 *
 * @since mayosis 1.0
 */
 function mayosis_filter_edd_checkout_image_size( $array ) {
     return array( 120, 80 );
 }
 add_filter( 'edd_checkout_image_size', 'mayosis_filter_edd_checkout_image_size', 10, 1 );
 
if ( class_exists( 'EDD_Wish_Lists' ) ) {

function mayosis_remove_favorites() {
    // remove from default location
    remove_action( 'edd_purchase_link_end', 'edd_favorites_load_link' );

    remove_action( 'edd_purchase_link_top', 'edd_favorites_load_link' );

}
add_action( 'template_redirect', 'mayosis_remove_favorites' );



/**
 * Remove standard favorite links
 * @return [type] [description]
 */
function mayosis_wisthlist_load() {
	// remove standard add to wish list link
	remove_action( 'edd_purchase_link_top', 'edd_favorites_load_link' );

	// add our new link
	add_action( 'edd_purchase_link_top', 'edd_wl_load_wish_list_link' );
}
add_action( 'template_redirect', 'mayosis_wisthlist_load' );
}


