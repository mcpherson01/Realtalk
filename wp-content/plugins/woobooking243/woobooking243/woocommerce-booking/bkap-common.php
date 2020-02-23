<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
class bkap_common{
/*********************************
 * This function returns the function name to display the timeslots on frontend if type of timeslot is Multiple for multiple time slots addon.
 ********************************/
	public static function bkap_ajax_on_select_date() {
		global $post;
		
		$booking_settings = get_post_meta( $post->ID, 'woocommerce_booking_settings', true );
		
		if( isset( $booking_settings['booking_enable_multiple_time'] ) && $booking_settings['booking_enable_multiple_time'] == "multiple" && function_exists('is_bkap_multi_time_active') && is_bkap_multi_time_active() ) {
			return 'multiple_time';
		}
	}

	public static function bkap_get_betweendays( $StartDate, $EndDate )
	{
		$Days[]                   =   $StartDate;
		$CurrentDate              =   $StartDate;
			
		$CurrentDate_timestamp    =   strtotime($CurrentDate);
		$EndDate_timestamp        =   strtotime($EndDate);
		
		if( $CurrentDate_timestamp != $EndDate_timestamp )
		{
			while( $CurrentDate_timestamp < $EndDate_timestamp )
			{
				$CurrentDate            =   date( "d-n-Y", strtotime( "+1 day", strtotime( $CurrentDate ) ) );
				$CurrentDate_timestamp  =   $CurrentDate_timestamp + 86400;
				$Days[]                 =   $CurrentDate;
			}
			array_pop( $Days );
		}
		return $Days;
	}
	/**
	 * Send the Base language product ID
	 * 
	 * This function has been written as a part of making the Booking plugin
	 * compatible with WPML. It returns the base language Product ID when WPML
	 * is enabled. 
	 */
	public static function bkap_get_product_id( $product_id ) {
	    $base_product_id = $product_id;
	    // If WPML is enabled, the make sure that the base language product ID is used to calculate the availability
	    if ( function_exists( 'icl_object_id' ) ) {
	        global $sitepress;
	        $default_lang = $sitepress->get_default_language();
	        $base_product_id = icl_object_id( $product_id, 'product', false, $default_lang );
	        // The base product ID is blanks when the product is being created.
	        if (! isset( $base_product_id ) || ( isset( $base_product_id ) && $base_product_id == '' ) ) {
	            $base_product_id = $product_id;
	        }
	    } 
		return $base_product_id;
	}
	
	public static function bkap_get_price( $product_id, $variation_id, $product_type ) {
		$price = 0;
		
		if ( $product_type == 'variable' ){
			$sale_price = get_post_meta( $variation_id, '_sale_price', true );
			
			if( !isset( $sale_price ) || $sale_price == '' || $sale_price == 0 ) {
				$regular_price  =   get_post_meta( $variation_id, '_regular_price', true );
				$price          =   $regular_price;
			}else {
				$price          =   $sale_price;
			}
			
		}elseif( $product_type == 'simple' ) {
			$sale_price = get_post_meta( $product_id, '_sale_price', true );
			
			if( !isset( $sale_price ) || $sale_price == '' || $sale_price == 0 ) {
				$regular_price  =   get_post_meta( $product_id, '_regular_price', true );
				$price          =   $regular_price;
			}else {
				$price          =   $sale_price;
			}
		}
		return $price;
	}
	
	public static function bkap_get_product_type($product_id) {
		$product      =   get_product( $product_id );
		$product_type =   $product->product_type;
		
		return $product_type;
	}
	
/*	public static function bkap_multicurrency_price($price,$currency_selected) {	
		global $woocommerce_wpml;
		if($currency_selected != '') {
			$settings = $woocommerce_wpml->get_settings();
			if($settings['enable_multi_currency'] == 2) {
				$custom_post = get_post_meta( $variation_id, '_wcml_custom_prices_status', true);
				if($custom_post == 0) {
					$currencies = $woocommerce_wpml->multi_currency_support->get_currencies();
					foreach($currencies as $ckey => $cval) {
						if($ckey == $currency_selected) {
							$price  = $price * $cval['rate'];
						}
					}
				}
			}
		}
		return $price;
	}*/
	
/*	public static function gf_compatibility_cart($price,$diff_days) {
		if(is_plugin_active('woocommerce-gravityforms-product-addons/gravityforms-product-addons.php')) {
			$gravity_price = 0;
			$amount_reduce = 0;
			if (isset($_POST['gform_form_id'])) {
				$form_meta = RGFormsModel::get_form_meta($_POST['gform_form_id']);
				for($i=1;$i<= count($form_meta);$i++) {
					if(isset($_POST['input_'.$i])) 	{
						$str_pos = strpos($_POST['input_'.$i],'|');
						if (isset($str_pos) && $str_pos != '') {
							$price_arr = explode('|',$_POST['input_'.$i]);
							if (isset($diff_days) && $diff_days > 1) {
								$diff_days -= 1;
								$gravity_price = $gravity_price + ($price_arr[0] * $diff_days);
							}
						}
						else {
							if (isset($diff_days) && $diff_days > 1) {
								$diff_days -= 1;
								$form_meta_fields = $form_meta['fields'];
                                foreach($form_meta_fields as $form_field_key => $form_field_value){
                                	if($form_field_value['productField'] > '0'){
                                    	$amount_reduce = ($_POST['input_'.$i] * $diff_days);
                                        $gravity_price = $gravity_price + ($_POST['input_'.$i] * $diff_days);
                                    }
                                }
							}
						}
					}
				}
			}
			$price = $price + ($gravity_price - $amount_reduce );
		}
		return $price;
	}*/
	
	public static function woo_product_addons_compatibility_cart( $price, $diff_days, $cart_item_meta ) {
		
	    if( class_exists('WC_Product_Addons') ) {
			$addons_price = $single_addon_price = 0;
		 	
		 	if( isset( $cart_item_meta['addons'] ) ) {
				$product_addons = $cart_item_meta['addons'];
				
				foreach( $product_addons as $key => $val ) {
					$single_addon_price += $val['price'];
				}
				
				if( isset( $diff_days ) && $diff_days > 1 && $single_addon_price > 0 ) {
					$diff_days         -=  1;
					$single_addon_price =  $single_addon_price * $diff_days;
					$addons_price      +=  $single_addon_price;
				}
					
			}
			$price += $addons_price;
		}
		return $price;
	}
}
?>