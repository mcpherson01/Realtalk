<?php
include_once('bkap-common.php');
include_once('lang.php');
// GF and GF product adons compatibility
	//Hook to update the subtotal for GF product addons
	add_filter('woocommerce_gform_base_price', 'change_subtotal', 10,2);
	//Hook to update the options total for GF product addons
	add_filter('woocommerce_gform_total_price', 'change_total', 10,2);
	// Hook to update the total for GF product addons
	add_filter('woocommerce_gform_variation_total_price', 'change_options_total', 10,2);
	
	function calculate_GF_price($price_to_be_calculated) {
            
		$currency_selected = get_option( 'woocommerce_currency' );
		$currency_pos = get_option( 'woocommerce_currency_pos' );
		$thousand_separator = get_option( 'woocommerce_price_thousand_sep' );
		switch ( $currency_pos ) {
			case 'left' :
			
				if( $currency_selected == 'INR' ) { // Indian rupees
					$price_pos = strpos( $price_to_be_calculated, "." );
				}else {
					$price_pos = strpos( $price_to_be_calculated,";" );
				}
				$price_pos += 1;
				$price_substr = substr( $price_to_be_calculated, $price_pos );
			
				$price_last_pos = strpos( $price_substr, "<" );
				$price = substr($price_substr,0,$price_last_pos );
				break;
               
			case 'right' :
				
				$span_last_pos =  strpos( $price_to_be_calculated, ">" ); // we chnaged this as Price position on Right side. First Value displyed then Currency symbol
				$span_last_pos += 1;
				$first_price_substr = substr( $price_to_be_calculated, $span_last_pos );
				
				if( $currency_selected == 'INR' ) { // Indian rupees
					$price_last_pos = strpos( $first_price_substr, "Rs" ); // bcz Ruppes Do not have the & in the string.
				} else {
					$price_last_pos = strpos( $first_price_substr, "&" );
				}
				$price = substr( $first_price_substr, 0, $price_last_pos );
				break;
                    
			case 'left_space' :
				if( $currency_selected == 'INR' ) { // Indian rupees
					$first_price_pos = strpos( $price_to_be_calculated, "." );
				} else {
					$first_price_pos = strpos( $price_to_be_calculated, ";" );
				}
				$first_price_pos += 1;
				$price_first_substr = substr( $price_to_be_calculated, $first_price_pos );
				
				$second_price_pos = strpos( $price_first_substr, ";" ); // this second ; is for the spacein currency format.
				$second_price_pos += 1;
				$price_second_substr = substr( $price_first_substr, $second_price_pos );
				
				$price_last_pos = strpos( $price_second_substr, "<" );
				$price = substr( $price_second_substr, 0, $second_price_pos );
				break;
                    
			case 'right_space' :
				
				$span_last_pos =  strpos( $price_to_be_calculated, ">" ); // we chnaged this as Price position on Right side. First Value displyed then Currency symbol
				$span_last_pos += 1;
				$first_price_substr = substr( $price_to_be_calculated, $span_last_pos );
				$price_last_pos = strpos( $first_price_substr, "&" );
				$price = substr( $first_price_substr, 0, $price_last_pos );
				break;
		}
		// Remove the thousand seperators
		if ( $thousand_separator == ',' ) {
			$final_price = preg_replace( '#(\d),(\d)#','$1$2', $price );
		}
		else {
			$final_price = preg_replace( '#(\d)\.(\d)#','$1$2', $price );
		}
		return $final_price;
	}
	
	function change_subtotal($subtotal_price,$product_addon){
		$price = calculate_GF_price($subtotal_price,$product_addon->id);
		$booking_settings = get_post_meta($product_addon->id, 'woocommerce_booking_settings', true);
		
		if (isset($_POST['total_price_calculated']) && $_POST['total_price_calculated'] != '') {
			$price = $_POST['total_price_calculated'];
		}
		return woocommerce_price($price);
	}
	
	function change_total($gform_final_total,$product_addon){
		$price = calculate_GF_price($gform_final_total);
		$booking_settings = get_post_meta($product_addon->id, 'woocommerce_booking_settings', true);
		$product_type = $product_addon->product_type;
		$cart_option_price = 0;
		if ($product_type == 'variation') {
			$product_type = 'variable';
		}
		
		// get the product price and subtract it frm the total amt
		$product_price = bkap_common::bkap_get_price($_POST['product_id'], $_POST['variation_id'], $product_type);
		$price -= $product_price;
		// Assign the option price so that it works for single day bookings as well
		$cart_option_price = $price;
		if ($booking_settings != '' && (isset($booking_settings['booking_enable_multiple_day']) && $booking_settings['booking_enable_multiple_day'] == 'on' )) {	
			// multiply the options value with the diff days
			if (isset($_POST['diff_days']) && $_POST['diff_days'] > 1) {
				// mutiply the options price with 1 diff day less to be used on the cart page
				$diff_day_cart = $_POST['diff_days'] - 1;
				$cart_option_price = $price * $diff_day_cart;
				$price = $price * $_POST['diff_days'];
			}
		}
		// add the booking price to the final options price calculated
		if (isset($_POST['total_price_calculated']) && $_POST['total_price_calculated'] != '') {
			$price += $_POST['total_price_calculated'];
		}
		
		$_SESSION['booking_gravity_forms_option_price'] = $cart_option_price;
		return woocommerce_price($price);
	}
	
	function change_options_total($gform_options_total,$product_addon){
		$price = calculate_GF_price($gform_options_total);
		$booking_settings = get_post_meta($product_addon->id, 'woocommerce_booking_settings', true);
		if ($booking_settings != '' && (isset($booking_settings['booking_enable_multiple_day']) && $booking_settings['booking_enable_multiple_day'] == 'on' )) {
			if (isset($price) && $price != 0) {
				if (isset($_POST['diff_days']) && $_POST['diff_days'] > 1) {
					$price = $price * $_POST['diff_days'];
				}
			}
		}
		return woocommerce_price($price);
	}
class bkap_booking_process {
	/******************************************************
    *  This function will disable the quantity and add to cart button on the frontend,
    *  if the �Enable Booking� is �on� from admin product page,and if "Purchase without choosing date" is disable.
    *************************************************************/		
		
	public static function bkap_before_add_to_cart() {
		global $post,$wpdb;
		$booking_settings = get_post_meta($post->ID, 'woocommerce_booking_settings', true);
		
		if ( $booking_settings != '' && (isset($booking_settings['booking_enable_date']) && $booking_settings['booking_enable_date'] == 'on') && (isset($booking_settings['booking_purchase_without_date']) && $booking_settings['booking_purchase_without_date'] != 'on')) {
		?>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery( ".single_add_to_cart_button" ).hide();
					jQuery( ".payment_type" ).hide();
					jQuery( ".quantity" ).hide();
					jQuery(".partial_message").hide();
				});
				
				jQuery(document).ajaxSend(function(event, jqXHR, ajaxOptions) {
					if (ajaxOptions.data) {
					    if(ajaxOptions.context) {
					    	var split_data = ajaxOptions.data.split("&");
					    	var found = jQuery.inArray('action=get_updated_price',split_data) > -1;
					    	if (found) {
						    	ajaxOptions.context.data = "diff_days="+jQuery('#wapbk_diff_days').val()+"&" + "total_price_calculated="+jQuery('#total_price_calculated').val()+"&" + ajaxOptions.context.data;
					    	}
					    } else {
					    	var split_data = ajaxOptions.data.split("&");
					    	var found = jQuery.inArray('action=get_updated_price',split_data) > -1;
					    	if (found) {
						    	ajaxOptions.data = "diff_days="+jQuery('#wapbk_diff_days').val()+"&" + "total_price_calculated="+jQuery('#total_price_calculated').val()+"&" + ajaxOptions.data;
					    	}
					    }
					}
				});
			</script>
		<?php 
		}
	}

	/**************************************************
	* This function add the Booking fields on the frontend product page as per the settings selected when Enable Booking is enabled.
    *************************************************/
			
	public static function bkap_booking_after_add_to_cart() {
		global $post, $wpdb,$woocommerce;

		$duplicate_of = bkap_common::bkap_get_product_id($post->ID);
		$booking_settings = get_post_meta($duplicate_of, 'woocommerce_booking_settings', true);
		if (isset($booking_settings['booking_enable_date']) && $booking_settings['booking_enable_date'] == "on") {
			// Set the Session gravity forms option total to 0
			$_SESSION['booking_gravity_forms_option_price'] = 0;
			do_action('bkap_print_hidden_fields',$duplicate_of);
			$method_to_show = 'bkap_check_for_time_slot';
			$get_method = bkap_common::bkap_ajax_on_select_date();
			if(isset($get_method) && $get_method == 'multiple_time') {
				$method_to_show = apply_filters('bkap_function_slot','');
			}
			
			$global_settings = json_decode(get_option('woocommerce_booking_global_settings'));
			$sold_individually = get_post_meta($post->ID, '_sold_individually', true);
			print('<input type="hidden" id="wapbk_sold_individually" name="wapbk_sold_individually" value="'.$sold_individually.'">');
			// Global or Product level minimum Multiple day setting
			$enable_min_multiple_day = '';
			$minimum_multiple_day = 1;
			if (isset($booking_settings['enable_minimum_day_booking_multiple']) && $booking_settings['enable_minimum_day_booking_multiple'] == "on") {
				$enable_min_multiple_day = $booking_settings['enable_minimum_day_booking_multiple'];
				$minimum_multiple_day = $booking_settings['booking_minimum_number_days_multiple'];
			}
			else if (isset($global_settings->minimum_day_booking) && $global_settings->minimum_day_booking == "on") {
				$enable_min_multiple_day = $global_settings->minimum_day_booking;
				$minimum_multiple_day = $global_settings->global_booking_minimum_number_days;
			}
			print('<input type="hidden" id="wapbk_enable_min_multiple_day" name="wapbk_enable_min_multiple_day" value="'.$enable_min_multiple_day.'">');
			print('<input type="hidden" id="wapbk_multiple_day_minimum" name="wapbk_multiple_day_minimum" value="'.$minimum_multiple_day.'">');
			//	default global settings
			if ($global_settings == '') {
				$global_settings = new stdClass();
				$global_settings->booking_date_format = 'd MM, yy';
				$global_settings->booking_time_format = '12';
				$global_settings->booking_months = '1';
			}
			//rounding settings
			$rounding = "";
			if (isset($global_settings->enable_rounding) && $global_settings->enable_rounding == "on") {
				$rounding = "yes";
	        } else {
				$rounding = "no";
	        }
			print('<input type="hidden" id="wapbk_round_price" name="wapbk_round_price" value="'.$rounding.'">');
	
			// availability display settings
			$availability_display = "";
			if (isset($global_settings->booking_availability_display) && $global_settings->booking_availability_display == "on") {
				$availability_display = "yes";
			} else {
				$availability_display = "no";
			}
			print('<input type="hidden" id="wapbk_availability_display" name="wapbk_availability_display" value="'.$availability_display.'">');
			if (isset($global_settings->booking_global_selection) && $global_settings->booking_global_selection == "on"){
				$selection = "yes";
	        } else {
	            $selection = "no";
			}
			print('<input type="hidden" id="wapbk_global_selection" name="wapbk_global_selection" value="'.$selection.'">');
					
			if ( $booking_settings != '' ) {
				// fetch specific booking dates
				if(isset($booking_settings['booking_specific_date'])){
					$booking_dates_arr = $booking_settings['booking_specific_date'];
	            } else { 
					$booking_dates_arr = array();
	            }
				$booking_dates_str = "";
				if (isset($booking_settings['booking_specific_booking']) && $booking_settings['booking_specific_booking'] == "on"){
					if(!empty($booking_dates_arr)){
						foreach ($booking_dates_arr as $k => $v) {
							$booking_dates_str .= '"'.$v.'",';
						}					
	                }
	                $booking_dates_str = substr($booking_dates_str,0,strlen($booking_dates_str)-1);		
				}
				print('<input type="hidden" name="wapbk_booking_dates" id="wapbk_booking_dates" value=\''.$booking_dates_str.'\'>');
	
				if (isset($global_settings->booking_global_holidays)) {
					$book_global_holidays = $global_settings->booking_global_holidays;
					$book_global_holidays = substr($book_global_holidays,0,strlen($book_global_holidays));
					$book_global_holidays = '"'.str_replace(',', '","', $book_global_holidays).'"';
				} else {
					$book_global_holidays = "";
				}
				print('<input type="hidden" name="wapbk_booking_global_holidays" id="wapbk_booking_global_holidays" value=\''.$book_global_holidays.'\'>');
					
				$booking_holidays_string = '"'.str_replace(',', '","', $booking_settings['booking_product_holiday']).'"';
				print('<input type="hidden" name="wapbk_booking_holidays" id="wapbk_booking_holidays" value=\''.$booking_holidays_string.'\'>');
					
				//Default settings
				$default = "Y";
				if ((isset($booking_settings['booking_recurring_booking']) && $booking_settings['booking_recurring_booking'] == "on") || (isset($booking_settings['booking_specific_booking']) && $booking_settings['booking_specific_booking'] == "on")) {
					$default = "N";
				}
				$number_of_days = 0;
				foreach ($booking_settings['booking_recurring'] as $wkey => $wval) {
					if ($default == "Y") {
						print('<input type="hidden" name="wapbk_'.$wkey.'" id="wapbk_'.$wkey.'" value="on">');
					} else {
						if ($booking_settings['booking_recurring_booking'] == "on"){
							print('<input type="hidden" name="wapbk_'.$wkey.'" id="wapbk_'.$wkey.'" value="'.$wval.'">');
							if ( isset ( $wval ) && $wval == 'on' ) {
								$number_of_days++;
							}
						} else {
							print('<input type="hidden" name="wapbk_'.$wkey.'" id="wapbk_'.$wkey.'" value="">');
						}
					}
				}
	
				if (isset($booking_settings['booking_time_settings'])) {
					print('<input type="hidden" name="wapbk_booking_times" id="wapbk_booking_times" value="YES">');
				} else {
					print('<input type="hidden" name="wapbk_booking_times" id="wapbk_booking_times" value="NO">');
				}
				
				// set mindate and maxdate based on the Bookable time period
				if (isset($booking_settings['booking_date_range_type']) && $booking_settings['booking_date_range_type'] == 'fixed_range') {
					$min_date = $days = '';
					if (isset($booking_settings['booking_start_date_range'])) {
						// check if the range start date is a past dat, if yes then we need to set the mindate to today
						$current_time = current_time( 'timestamp' );
						$current_date = date("d-m-Y", $current_time);
						$range_start = date("d-m-Y",strtotime($booking_settings['booking_start_date_range']));
						$current_date1 = new DateTime($current_date);
						$range_start1 = new DateTime($range_start);
						
						$diff_days = $current_date1->diff($range_start1);
						// the diff days is always a positive number. However, if the start date is in the future then invert = 0, else = 1
						if ($diff_days->invert == 0) {
							$min_date = date("j-n-Y",strtotime($booking_settings['booking_start_date_range']));
						}
						else {
						    $min_date = '';
						    if ( isset( $booking_settings['booking_minimum_number_days'] ) ) {
						        // Wordpress Time
						        $current_time = current_time( 'timestamp' );
						        // Convert the advance period to seconds and add it to the current time
						        $advance_seconds = $booking_settings['booking_minimum_number_days'] *60 *60;
						        $cut_off_timestamp = $current_time + $advance_seconds;
						        $cut_off_date = date("d-m-Y", $cut_off_timestamp);
						        $min_date = date("j-n-Y",strtotime($cut_off_date));
						    }else{
						        $min_date = date("j-n-Y",strtotime($current_date));
						    }
						}
						$date2 = new DateTime($min_date);
					}
					if (isset($booking_settings['booking_start_date_range']) && isset($booking_settings['booking_end_date_range'])) {
						$date1 = new DateTime($booking_settings['booking_end_date_range']);
						$days_array = $date1->diff($date2);
						$days = $days_array->days;
						if ( isset( $booking_settings['booking_enable_multiple_day'] ) && $booking_settings['booking_enable_multiple_day'] != 'on' ) {
							// if inline then pass the end range date
							if (isset($booking_settings['enable_inline_calendar']) && $booking_settings['enable_inline_calendar'] == 'on') {
								$days = date ( "j-n-Y", strtotime ( $booking_settings['booking_end_date_range'] ) );
							}
							// else pass the number of bookable dates in the range
							else {
								if ( ( isset( $number_of_days ) && $number_of_days > 0 ) || ( isset( $booking_settings['booking_specific_booking'] ) && $booking_settings['booking_specific_booking'] == "on" ) ) {
									$count = 0;
									// if specific dates are enabled then find the number of dates that should be enabled in this range
									if ( isset( $booking_settings['booking_specific_booking'] ) && $booking_settings['booking_specific_booking'] == "on" ) {
										if( !empty( $booking_dates_arr ) ) {
											foreach ( $booking_dates_arr as $k => $v ) {
												if ( strtotime( $v) > strtotime( $min_date ) && strtotime( $v ) < strtotime( $booking_settings['booking_end_date_range'] ) ) {
													$count++;
												}
											}
										}
									}
									if ( isset( $number_of_days ) && $number_of_days > 0 ) {
										// divide by 7 to find the number of weeks
										$number_of_weeks = ceil( $days / 7 );
										// find how many days in a week are to be enabled and multiply with that (This applies only for single day recurring weekday bookings) 
										$days = $number_of_weeks * $number_of_days;
										$days += $count;
									} else {
									    $days = $count;
									}
								}
							}
						}
					}
				}
				else {
					$min_date = $days = '';
					if (isset($booking_settings['booking_minimum_number_days'])) {
						// Wordpress Time
						$current_time = current_time( 'timestamp' );
						// Convert the advance period to seconds and add it to the current time 
						$advance_seconds = $booking_settings['booking_minimum_number_days'] *60 *60;
						$cut_off_timestamp = $current_time + $advance_seconds;
						$cut_off_date = date("d-m-Y", $cut_off_timestamp);
						$min_date = date("j-n-Y",strtotime($cut_off_date));
					} 
					if (isset($booking_settings['booking_maximum_number_days'])) {
						$days = $booking_settings['booking_maximum_number_days'];
					} 
				}
				// check mindate is today.. if yes, then check if all time slots are past, if yes, then set mindate to tomorrow
				if ( isset ( $booking_settings['booking_enable_time'] ) && $booking_settings['booking_enable_time'] == 'on' ) {
					$current_date = date( 'j-n-Y', $current_time );
					$last_slot_hrs = $current_slot_hrs = $last_slot_min = 0;
					if ( is_array( $booking_settings['booking_time_settings'] ) && array_key_exists( $min_date, $booking_settings['booking_time_settings'] ) ) {
						foreach ( $booking_settings['booking_time_settings'][$min_date] as $key => $value ) {
							$current_slot_hrs = $value['from_slot_hrs'];
							if ( $current_slot_hrs > $last_slot_hrs ) {
								$last_slot_hrs = $current_slot_hrs;
								$last_slot_min = $value['to_slot_min'];
							}
						}
					}
					else {
						// Get the weekday as it might be a recurring day setup
						$weekday = date( 'w', strtotime( $min_date ) );
						$booking_weekday = 'booking_weekday_' . $weekday;
						if ( is_array( $booking_settings['booking_time_settings'] ) && array_key_exists( $booking_weekday, $booking_settings['booking_time_settings'] ) ) {
							foreach ( $booking_settings['booking_time_settings'][$booking_weekday] as $key => $value ) {
								$current_slot_hrs = $value['from_slot_hrs'];
								if ( $current_slot_hrs > $last_slot_hrs ) {
									$last_slot_hrs = $current_slot_hrs;
									$last_slot_min = $value['to_slot_min'];
								}
							}
						}
					}
					$last_slot = $last_slot_hrs . ':' . $last_slot_min;
					$advance_booking_hrs = 0;
					if ( isset( $booking_settings['booking_minimum_number_days'] ) && $booking_settings['booking_minimum_number_days'] != '' ) {
						$advance_booking_hrs = $booking_settings['booking_minimum_number_days'];
					}
					$booking_date2 = $min_date . $last_slot;
					$booking_date2 = date( 'Y-m-d G:i', strtotime( $booking_date2 ) );
					$date2 = new DateTime( $booking_date2 );
					$booking_date1 = date( 'Y-m-d G:i', $current_time );
					$date1 = new DateTime( $booking_date1 );
					$difference = $date2->diff( $date1 );
					
					if ( $difference->days > 0 ) {
						$days_in_hour = $difference->h + ( $difference->days * 24 ) ;
                        $difference->h = $days_in_hour;
					}
						
					if ( $difference->invert == 0 || $difference->h < $advance_booking_hrs ) {
						$min_date = date( 'j-n-Y', strtotime( $min_date . '+1 day' ) );
					}
				}
				
				print('<input type="hidden" name="wapbk_minimumOrderDays" id="wapbk_minimumOrderDays" value="'.$min_date.'">');
				print('<input type="hidden" name="wapbk_number_of_dates" id="wapbk_number_of_dates" value="'.$days.'">');
									
				
				if (isset($booking_settings['booking_enable_time'])) {
			 		print('<input type="hidden" name="wapbk_bookingEnableTime" id="wapbk_bookingEnableTime" value="'.$booking_settings['booking_enable_time'].'">');
				} else {
					print('<input type="hidden" name="wapbk_bookingEnableTime" id="wapbk_bookingEnableTime" value="">');
				}
	
				if (isset($booking_settings['booking_recurring_booking'])) {
			 		print('<input type="hidden" name="wapbk_recurringDays" id="wapbk_recurringDays" value="'.$booking_settings['booking_recurring_booking'].'">');
				} else {
					print('<input type="hidden" name="wapbk_recurringDays" id="wapbk_recurringDays" value="">');
				}
	
				if (isset($booking_settings['booking_specific_booking'])) {
			 		print('<input type="hidden" name="wapbk_specificDates" id="wapbk_specificDates" value="'.$booking_settings['booking_specific_booking'].'">');
				} else {
					print('<input type="hidden" name="wapbk_specificDates" id="wapbk_specificDates" value="">');
				} 		
			}
			//Lockout Dates
			$lockout_query = "SELECT DISTINCT start_date FROM `".$wpdb->prefix."booking_history`
									WHERE post_id= %d
									AND total_booking > 0
									AND available_booking <= 0
									AND status = ''";
			$results_lockout = $wpdb->get_results ( $wpdb->prepare($lockout_query,$duplicate_of) );
				
			$lockout_query = "SELECT DISTINCT start_date FROM `".$wpdb->prefix."booking_history`
					WHERE post_id= %d
					AND available_booking > 0
					AND status = ''";
			$results_lock = $wpdb->get_results ( $wpdb->prepare($lockout_query,$duplicate_of) );
			$lockout_date = '';
			
			foreach ($results_lockout as $k => $v) {
				foreach($results_lock as $key => $value) {
					if ($v->start_date == $value->start_date) {
						$date_lockout = "SELECT COUNT(start_date) FROM `".$wpdb->prefix."booking_history`
													WHERE post_id= %d
													AND start_date= %s
													AND available_booking = 0";
						$results_date_lock = $wpdb->get_results($wpdb->prepare($date_lockout,$duplicate_of,$v->start_date));
						if ($booking_settings['booking_date_lockout'] > $results_date_lock[0]->{'COUNT(start_date)'}) {
							unset($results_lockout[$k]);	
						}
					} 
				}
			}
			$lockout_dates_str = "";
			foreach ($results_lockout as $k => $v) {
				$lockout_temp = $v->start_date;
				$lockout = explode("-",$lockout_temp);
				$lockout_dates_str .= '"'.intval($lockout[2])."-".intval($lockout[1])."-".$lockout[0].'",';
				$lockout_temp = "";
			}
			$lockout_dates_str = substr($lockout_dates_str,0,strlen($lockout_dates_str)-1);
			$lockout_dates = $lockout_dates_str;
			print('<input type="hidden" name="wapbk_lockout_days" id="wapbk_lockout_days" value=\''.$lockout_dates.'\'>');
	
			$todays_date = date('Y-m-d');
			
			$query_date ="SELECT DATE_FORMAT(start_date,'%d-%c-%Y') as start_date,DATE_FORMAT(end_date,'%d-%c-%Y') as end_date FROM ".$wpdb->prefix."booking_history 
							WHERE (start_date >='".$todays_date."' OR end_date >='".$todays_date."') AND post_id = '".$duplicate_of."'";
			$results_date = $wpdb->get_results($query_date);
			$dates_new = array();
			$booked_dates = array();
			if (isset($results_date) && count($results_date) > 0 && $results_date != false) {
				foreach($results_date as $k => $v) {
					$start_date = $v->start_date;
					$end_date = $v->end_date;
					$dates = bkap_common::bkap_get_betweendays($start_date, $end_date);
					$dates_new = array_merge($dates,$dates_new);
				}
			}
			//Enable the start date for the booking period for checkout
			if (isset($results_date) && count($results_date) > 0 && $results_date != false) {
				foreach ($results_date as $k => $v) {
					$start_date = $v->start_date;
					$end_date = $v->end_date;
					$new_start = strtotime("+1 day", strtotime($start_date));
					$new_start = date("d-m-Y",$new_start);
					$dates = bkap_common::bkap_get_betweendays($new_start, $end_date);
					$booked_dates = array_merge($dates,$booked_dates);
				}
			}
			$dates_new_arr = array_count_values($dates_new);
			$booked_dates_arr = array_count_values($booked_dates);
			$lockout = "";
			if (isset($booking_settings['booking_date_lockout'])) {
				$lockout = $booking_settings['booking_date_lockout'];
			}
			$new_arr_str = '';
			foreach($dates_new_arr as $k => $v) {
				if($v >= $lockout && $lockout != 0) {
					$date_temp = $k;
					$date = explode("-",$date_temp);
					$new_arr_str .= '"'.intval($date[0])."-".intval($date[1])."-".$date[2].'",';
					$date_temp = "";
				}
			}
			$new_arr_str = substr($new_arr_str,0,strlen($new_arr_str)-1);
			print("<input type='hidden' id='wapbk_hidden_booked_dates' name='wapbk_hidden_booked_dates' value='".$new_arr_str."'/>");
	
			//checkout calendar booked dates
			$blocked_dates = array();
			$booked_dates_str = "";
			foreach ($booked_dates_arr as $k => $v) {
				if($v >= $lockout && $lockout != 0) {
					$date_temp = $k;
					$date = explode("-",$date_temp);
					$date_without_zero_prefixed = intval($date[0])."-".intval($date[1])."-".$date[2];
					$booked_dates_str .= '"'.intval($date[0])."-".intval($date[1])."-".$date[2].'",';
					$date_temp = "";
					$blocked_dates[] = $date_without_zero_prefixed;
				}
			}
			if (isset($booked_dates_str)) {
				$booked_dates_str = substr($booked_dates_str,0,strlen($booked_dates_str)-1);
			} else {
				$booked_dates_str = "";
			}
			print("<input type='hidden' id='wapbk_hidden_booked_dates_checkout' name='wapbk_hidden_booked_dates_checkout' value='".$booked_dates_str."'/>");
					
			if(isset($booking_settings['booking_recurring'])) {
				$recurring_date = $booking_settings['booking_recurring'];
	        } else {
				$recurring_date = array();
	        }
	
			if(isset($booking_settings['booking_specific_date'])) {
				$specific_date = $booking_settings['booking_specific_date'];
	        } else {
				$specific_date = array();
	        }
			
			if(isset($booking_settings['booking_product_holiday'])) {
	            $holiday_array = explode(',',$booking_settings['booking_product_holiday']);
	        }
	
			if(isset($global_settings->booking_global_holidays)) {
				$global_holidays = explode(',',$global_settings->booking_global_holidays);
			} else {
				$global_holidays = array();
			}
	
			$i = 0;
	        if(isset($specific_date) && $specific_date != '') {
				foreach($specific_date as $key => $val) {
					$min_specific = date('j-n-Y',min(array_map('strtotime', $specific_date)));
					if(array_key_exists($i,$specific_date)) {
	                    if(strtotime($min_specific) < strtotime($specific_date[$i])) {
							unset($specific_date[$i]);
							if(in_array($min_specific, $holiday_array) || in_array($min_specific,$global_holidays)) {
								unset($specific_date[array_search($min_specific,$specific_date)]);
	                    	}
	                    }
	                }
	                $i++;
				}
			}
			
			$first_enable_day = '';
			$default_date = '';
			$min_day = date('N',strtotime($min_date)); 
			$default_date_recurring = $min_date;
			if(isset($booking_settings['booking_enable_multiple_day']) && $booking_settings['booking_enable_multiple_day'] != 'on' && isset($booking_settings['booking_recurring_booking']) && $booking_settings['booking_recurring_booking'] == 'on') {          
				for($i = 0;; $i++) {
					if(isset($recurring_date['booking_weekday_'.$min_day]) && $recurring_date['booking_weekday_'.$min_day] == 'on') {
						if(in_array($default_date_recurring, $holiday_array) || in_array($default_date_recurring,$global_holidays)) {
							if($min_day < 6) {
								$min_day = $min_day + 1;
							} else {
								$min_day = $min_day - $min_day;
							}
							$default_date_recurring = date('j-n-Y', strtotime('+1day',strtotime($default_date_recurring)));
						} else {
							break;
						}
					} else {
						if($min_day < 6) {
							$min_day = $min_day + 1;
						} else {
							$min_day = $min_day - $min_day;
						}
						$default_date_recurring =  date('j-n-Y', strtotime('+1day',strtotime($default_date_recurring)));
					}
				}
			}
					
			if($first_enable_day != '' && $booking_settings['booking_recurring_booking'] == 'on' && $booking_settings['booking_specific_booking'] == 'on') {
				$default_date_recurring= date('d-m-Y', strtotime('+'.$first_enable_day.' day',strtotime($min_date)));
				if(strtotime($default_date_recurring) < strtotime($min_specific)) {
					$default_date  = $default_date_recurring;
				} else {
					$default_date = $min_specific;
	            }
			} else if(isset($booking_settings['booking_specific_booking']) && $booking_settings['booking_specific_booking'] == 'on' && $booking_settings['booking_recurring_booking'] != 'on') {
				$default_date = $min_specific;
	        } else if(isset($booking_settings['booking_recurring_booking']) && $booking_settings['booking_recurring_booking'] == 'on' && $booking_settings['booking_specific_booking'] != 'on') {
				$default_date  = $default_date_recurring;
	        }
			print("<input type='hidden' id='wapbk_hidden_default_date' name='wapbk_hidden_default_date' value='".$default_date."'/>");
		}
		
		/**************
		 * This filter allows user to hiding the weekdays for a calender.
		 ****************/
		$disable_week_days = array();
		$calendar = '';
		$disable_week_days = apply_filters( 'bkap_block_weekdays', $disable_week_days );
		
		if( isset( $disable_week_days ) && !empty ($disable_week_days)){
		
		    foreach ( $disable_week_days as $calender_key => $calender_value ){
		        $calendar_name = strtolower( $calender_key );
		
		        if( 'checkin' == $calendar_name){
		            $disable_weekdays_array = array_map('trim',$calender_value);
		            $disable_weekdays_array = array_map('strtolower',$calender_value);
		            $week_days_funcion = bkap_get_book_arrays( 'days' );
		            $week_days_numeric_value = '';
		            foreach ($week_days_funcion as $week_day_key => $week_day_value){
		                if( in_array( strtolower($week_day_value) ,$disable_weekdays_array ) ){
		                    $week_days_numeric_value .= $week_day_key .',';
		                }
		            }
		            $week_days_numeric_value = rtrim( $week_days_numeric_value, ",");
		             
		            print("<input type='hidden' id='wapbk_block_checkin_weekdays' name='wapbk_block_checkin_weekdays' value='".$week_days_numeric_value."'/>");
		        }elseif( 'checkout' == $calendar_name ){
		             
		            $disable_weekdays_array = array_map('trim',$calender_value);
		            $disable_weekdays_array = array_map('strtolower',$calender_value);
		            $week_days_funcion = bkap_get_book_arrays( 'days' );
		            $week_days_numeric_value = '';
		            foreach ($week_days_funcion as $week_day_key => $week_day_value){
		                if( in_array( strtolower($week_day_value) ,$disable_weekdays_array ) ){
		                    $week_days_numeric_value .= $week_day_key .',';
		                }
		            }
		            $week_days_numeric_value = rtrim( $week_days_numeric_value, ",");
		
		            print("<input type='hidden' id='wapbk_block_checkout_weekdays' name='wapbk_block_checkout_weekdays' value='".$week_days_numeric_value."'/>");
		        }
		    }
		
		}
		
		if ( isset($booking_settings['booking_enable_date']) && $booking_settings['booking_enable_date'] == 'on' ) {
			// Display the stock div above the dates
			if (isset($global_settings->booking_availability_display) && $global_settings->booking_availability_display == 'on') {
				$available_stock = "Unlimited";
				if ($booking_settings['booking_date_lockout'] > 0) {
					$available_stock = $booking_settings['booking_date_lockout'];
				}
				print('<div id="show_stock_status" name="show_stock_status" class="show_stock_status" >'.$available_stock.bkap_get_book_t('book.stock-total').' </div>');
			}
			print ('<label class ="book_start_date_label" style="margin-top:5em;">'.__(get_option("book.date-label"),"woocommerce-booking").': </label><input type="text" id="booking_calender" name="booking_calender" class="booking_calender" style="cursor: text!important;" readonly/>
							<img src="'.plugins_url().'/woocommerce-booking/images/cal.gif" width="20" height="20" style="cursor:pointer!important;" id ="checkin_cal"/><div id="inline_calendar"></div>');
			$options_checkin = $options_checkout = array();
			$options_checkin_calendar = '';
			if (isset($booking_settings['booking_enable_multiple_day']) && $booking_settings['booking_enable_multiple_day'] == 'on') {
				print ('<label class ="book_end_date_label">'.__(get_option("checkout.date-label"),"woocommerce-booking").': </label><input type="text" id="booking_calender_checkout" name="booking_calender_checkout" class="booking_calender" style="cursor: text!important;" readonly/>
									<img src="'.plugins_url().'/woocommerce-booking/images/cal.gif" width="20" height="20" style="cursor:pointer!important;" id ="checkout_cal"/><div id="inline_calendar_checkout"></div>');
				if (isset($booking_settings['enable_inline_calendar']) && $booking_settings['enable_inline_calendar'] == 'on') {
					//$options_checkout[] = "minDate: jQuery('#wapbk_minimumOrderDays').val()";
					$options_checkout[] = "minDate: 1";
					$options_checkin_calendar = 'jQuery("#inline_calendar").datepicker("option", "onSelect",function(date,inst)  {
						jQuery( ".single_add_to_cart_button" ).show();
						var monthValue = inst.selectedMonth+1;
						var dayValue = inst.selectedDay;
						var yearValue = inst.selectedYear;
						var current_dt = dayValue + "-" + monthValue + "-" + yearValue;
						if (jQuery("#block_option_enabled").val()=="on") {
							var nod= parseInt(jQuery("#block_option_number_of_day").val(),10);										
							if (current_dt != "") {
								var num_of_day= jQuery("#block_option_number_of_day").val();
								var split = current_dt.split("-");
								split[1] = split[1] - 1;		
								var minDate = new Date(split[2],split[1],split[0]);	
								minDate.setDate(minDate.getDate() + nod ); 
								jQuery("#inline_calendar_checkout").datepicker("setDate",minDate);
								// Populate the hidden field for checkout
								var dd = minDate.getDate();
								var mm = minDate.getMonth()+1; //January is 0!
								var yyyy = minDate.getFullYear();
								var checkout = dd + "-" + mm + "-"+ yyyy;
								jQuery("#wapbk_hidden_date_checkout").val(checkout);
								bkap_calculate_price();
							}
						} 
						else if(jQuery("#wapbk_same_day").val() == "on") {
							if (current_dt != "") {
								var split = current_dt.split("-");
								split[1] = split[1] - 1;
								var minDate = new Date(split[2],split[1],split[0]);
								minDate.setDate(minDate.getDate());
								jQuery( "#inline_calendar_checkout" ).datepicker( "option", "minDate", minDate);
							}
						} else {	
							if (current_dt != "") {
								var split = current_dt.split("-");
								split[1] = split[1] - 1;
								var minDate = new Date(split[2],split[1],split[0]);
								
								if (jQuery("#wapbk_enable_min_multiple_day").val() == "on") {
									var minimum_multiple_day = jQuery("#wapbk_multiple_day_minimum").val();
                                  	if(minimum_multiple_day == 0 || !minimum_multiple_day) {
                                  		minimum_multiple_day = 1;
                                    }
									minDate.setDate(minDate.getDate() + parseInt(minimum_multiple_day));
								}
								else {
									minDate.setDate(minDate.getDate() + 1);
								}
								jQuery( "#inline_calendar_checkout" ).datepicker( "option", "minDate", minDate);
							}
						}
						jQuery("#wapbk_hidden_date").val(current_dt); 
						// Availability Display for the date selected only if setting is enabled
						if (jQuery("#wapbk_availability_display").val() == "yes") {
							var data = {
									checkin_date: jQuery("#wapbk_hidden_date").val(),
									post_id: "'.$duplicate_of.'", 
									action: "bkap_get_date_lockout"
									};
			
							jQuery.post("'.get_admin_url().'admin-ajax.php", data, function(response)
							{
								jQuery("#show_stock_status").html(response);
							});
						}
				        if(jQuery("#booking_calender_checkout").val() != "") {
					         var checkout;
					         if( jQuery("#wapbk_hidden_date_checkout").val() != "" ){
					           checkout = jQuery("#wapbk_hidden_date_checkout").val();
					         }else { // this is used to set first time when we click the checkin date.
					           var dd = minDate.getDate();
							   var mm = minDate.getMonth()+1; //January is 0!
							   var yyyy = minDate.getFullYear();
							   checkout = dd + "-" + mm + "-"+ yyyy;
					         }
 					        
			                 jQuery("#wapbk_hidden_date_checkout").val(checkout);
						}
						// This is to ensure that the hidden fields are populated and prices recalculated when users switch between date ranges
						if(jQuery("#wapbk_hidden_date_checkout").val() != "") {
							var dd = minDate.getDate();
							var mm = minDate.getMonth()+1; //January is 0!
							var yyyy = minDate.getFullYear();
							var checkout = dd + "-" + mm + "-"+ yyyy;
							var new_checkout_date = new Date(yyyy,mm,dd);
							
							var split_hidden = jQuery("#wapbk_hidden_date_checkout").val().split("-");
							var existing_hidden_checkout = new Date(split_hidden[2],split_hidden[1],split_hidden[0]);
							
							if (new_checkout_date > existing_hidden_checkout) {
								jQuery("#wapbk_hidden_date_checkout").val(checkout);
							}
                            bkap_calculate_price();
                         }
						});';
					$options_checkout[] = "onSelect: bkap_get_per_night_price";
					$options_checkin[] = "onSelect: bkap_set_checkin_date";
					$options_checkout[] = "beforeShowDay: bkap_check_booked_dates";
					$options_checkin[] = "beforeShowDay: bkap_check_booked_dates";
				} else {
					$options_checkout[] = "minDate: 1";
					$options_checkin[] = 'onClose: function( selectedDate ) {
						if (jQuery("#block_option_enabled").val()=="on") {
							var nod= parseInt(jQuery("#block_option_number_of_day").val(),10);										
							if (jQuery("#wapbk_hidden_date").val() != "") {
								var num_of_day= jQuery("#block_option_number_of_day").val();
								var split = jQuery("#wapbk_hidden_date").val().split("-");
								split[1] = split[1] - 1;		
								var minDate = new Date(split[2],split[1],split[0]);	
								minDate.setDate(minDate.getDate() + nod ); 
								jQuery("#booking_calender_checkout").datepicker("setDate",minDate);
								bkap_calculate_price();
							}
						} else {
							if (jQuery("#wapbk_hidden_date").val() != "") {				
								if(jQuery("#wapbk_same_day").val() == "on") {
									if (jQuery("#wapbk_hidden_date").val() != "") {				
										var split = jQuery("#wapbk_hidden_date").val().split("-");
										split[1] = split[1] - 1;		
										var minDate = new Date(split[2],split[1],split[0]);
										minDate.setDate(minDate.getDate()); 
										jQuery( "#booking_calender_checkout" ).datepicker( "option", "minDate", minDate);
									}
									} else {
										var split = jQuery("#wapbk_hidden_date").val().split("-");
										split[1] = split[1] - 1;		
										var minDate = new Date(split[2],split[1],split[0]);
										
										if (jQuery("#wapbk_enable_min_multiple_day").val() == "on") {
											var minimum_multiple_day = jQuery("#wapbk_multiple_day_minimum").val();
                                            if(minimum_multiple_day == 0 || !minimum_multiple_day) {
                                        	    minimum_multiple_day = 1;
                                            }
											minDate.setDate(minDate.getDate() + parseInt(minimum_multiple_day));
										}
										else {
											minDate.setDate(minDate.getDate() + 1); 
										} 
										jQuery( "#booking_calender_checkout" ).datepicker( "option", "minDate", minDate);
									}
								}
							}
							// Availability Display for the date selected if setting is enabled
							if (jQuery("#wapbk_availability_display").val() == "yes") {
								var data = {
									checkin_date: jQuery("#wapbk_hidden_date").val(),
									post_id: "'.$duplicate_of.'", 
									action: "bkap_get_date_lockout"
									};
			
								jQuery.post("'.get_admin_url().'admin-ajax.php", data, function(response)
								{
									jQuery("#show_stock_status").html(response);
								});
							}
							// This is to ensure that the hidden fields are populated and prices recalculated when users switch between date ranges
						if(jQuery("#wapbk_hidden_date_checkout").val() != "") {
							var dd = minDate.getDate();
							var mm = minDate.getMonth()+1; //January is 0!
							var yyyy = minDate.getFullYear();
							var checkout = dd + "-" + mm + "-"+ yyyy;
							var new_checkout_date = new Date(yyyy,mm,dd);
							
							var split_hidden = jQuery("#wapbk_hidden_date_checkout").val().split("-");
							var existing_hidden_checkout = new Date(split_hidden[2],split_hidden[1],split_hidden[0]);
							
							if (new_checkout_date > existing_hidden_checkout) {
								jQuery("#wapbk_hidden_date_checkout").val(checkout);
							}
							bkap_calculate_price();
						}
					}';
						$options_checkout[] = "onSelect: bkap_get_per_night_price";
						$options_checkin[] = "onSelect: bkap_set_checkin_date";
						$options_checkout[] = "beforeShowDay: bkap_check_booked_dates";
						$options_checkin[] = "beforeShowDay: bkap_check_booked_dates";
					}
				} else {
					$options_checkin[] = "beforeShowDay: bkap_show_book";
					$options_checkin[] = "onSelect: bkap_show_times";
				}
				$options_checkin_str = '';
				if (count($options_checkin) > 0) {
					$options_checkin_str = implode(',', $options_checkin);
				}
				$options_checkout_str = '';
				if (count($options_checkout) > 0){
					$options_checkout_str = implode(',', $options_checkout);
				}
				$product = get_product($post->ID);
				$product_type = $product->product_type;
				$attribute_change_var = '';
				
				if ($product_type == 'variable'){
					$variations = $product->get_available_variations();
					$attributes = $product->get_variation_attributes();
					$attribute_fields_str = "";
					$attribute_name = "";
					$attribute_value = "";
					$attribute_value_selected = "";
					$attribute_fields = array();
					$i = 0;
					foreach ($variations as $var_key => $var_val) {
						foreach ($var_val['attributes'] as $a_key => $a_val) {
							if (!in_array($a_key, $attribute_fields)) {
								$attribute_fields[] = $a_key;
								$attribute_fields_str .= ",\"$a_key\": jQuery(\"[name='$a_key']\").val() ";
								$key = str_replace("attribute_","",$a_key);
								$attribute_value .= "attribute_values =  attribute_values + '|' + jQuery('#".$key."').val();";
								$attribute_value_selected .= "attribute_selected =  attribute_selected + '|' + jQuery('#".$key." :selected').text();";
								$on_change_attributes[] = $a_key;
							}
							$i++;
						}
					}
					$on_change_attributes_str = implode(',#',$on_change_attributes);
					$on_change_attributes_str_rep = str_replace("attribute_","",$on_change_attributes_str);
					$on_change_attributes_str = settype($on_change_attributes_str_rep,'string');
					$attribute_change_var = 'jQuery(document).on("change",jQuery("#'.$on_change_attributes_str.'"),function() {
					
					var attribute_values = "";
						var attribute_selected = "";
						'.$attribute_value.'
						'.$attribute_value_selected.'
						jQuery("#wapbk_variation_value").val(attribute_selected);
						if (jQuery("#wapbk_hidden_date").val() != "" && jQuery("#wapbk_hidden_date_checkout").val() != "") bkap_calculate_price();
					});';
					print("<input type='hidden' id='wapbk_hidden_booked_dates' name='wapbk_hidden_booked_dates'/>");					
					print("<input type='hidden' id='wapbk_hidden_booked_dates_checkout' name='wapbk_hidden_booked_dates_checkout'/>");
				} elseif ($product_type == 'simple') {
					$attribute_fields_str = ",\"tyche\": 1";
				}
				
				$child_ids_str = '';
				if ($product_type == 'grouped') {
					$attribute_fields_str = ",\"tyche\": 1";
					if ($product->has_child()) {
						$child_ids = $product->get_children();
					}
						
					if (isset($child_ids) && count($child_ids) > 0) {
						foreach ($child_ids as $k => $v) {
							$child_ids_str .= $v . "-";
						}
					}
				}
				print("<input  type='hidden' id='wapbk_grouped_child_ids' name='wapbk_grouped_child_ids' value='".$child_ids_str."'/>");
				$js_code = $blocked_dates_hidden_var = '';
				$block_dates = array();
			
				$block_dates = (array) apply_filters( 'bkap_block_dates', $duplicate_of , $blocked_dates );
			
				if (isset($block_dates) && count($block_dates) > 0 && $block_dates != false) {
					$i = 1;
					$bvalue = array();
					$add_day = '';
					$same_day = '';
					$date_label = '';
					foreach ($block_dates as $bkey => $bvalue) {
						$blocked_dates_str = '';
						if (is_array($bvalue) && isset($bvalue['dates']) && count($bvalue['dates']) > 0){
							$blocked_dates_str = '"'.implode('","', $bvalue['dates']).'"';
                        }
						$field_name = $i;
						if ( (is_array($bvalue) && isset($bvalue['field_name']) && $bvalue['field_name'] != '' ) ) {
							$field_name = $bvalue['field_name'];
						}
						$fld_name = 'woobkap_'.str_replace(' ','_', $field_name);
						$blocked_dates_hidden_var .= "<input type='hidden' id='".$fld_name."' name='".$fld_name."' value='".$blocked_dates_str."'/>";
						$i++;
						
						if(is_array($bvalue) && isset($bvalue['add_days_to_charge_booking'])){
							$add_day = $bvalue['add_days_to_charge_booking'];
						}
						if($add_day == '') {
							$add_day = 0;
						}
						if(is_array($bvalue) && isset($bvalue['same_day_booking'])) {
							$same_day = $bvalue['same_day_booking'];
                        } else {
							$same_day = '';
                        }
						print("<input type='hidden' id='wapbk_same_day' name='wapbk_same_day' value='".$same_day."'/>");
					}
					if (isset($bvalue['date_label']) && $bvalue['date_label'] != '') {
						$date_label = $bvalue['date_label'];
                    } else {
						$date_label = 'Unavailable for Booking';
                    }
					$js_code = 'var '.$fld_name.' = eval("["+jQuery("#'.$fld_name.'").val()+"]");
						for (i = 0; i < '.$fld_name.'.length; i++) {
							if( jQuery.inArray(d + "-" + (m+1) + "-" + y,'.$fld_name.') != -1 ) {
								return [false, "", "'.$date_label.'"];
							}
						}';
					$js_block_date  = '
						var '.$fld_name.' = eval("["+jQuery("#'.$fld_name.'").val()+"]");
						var date = new_end = new Date(CheckinDate);
						var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
						for (var i = 1; i<= count;i++) {
							if( jQuery.inArray(d + "-" + (m+1) + "-" + y,'.$fld_name.') != -1 ) {
								jQuery("#wapbk_hidden_date_checkout").val("");
								jQuery("#booking_calender_checkout").val("");
								jQuery( ".single_add_to_cart_button" ).hide();
								jQuery( ".quantity" ).hide();
								CalculatePrice = "N";
								alert("'. __( "Some of the dates in the selected range are on rent. Please try another date range.", "woocommerce-booking" ) .'");
								break;
							}
							new_end = new Date(ad(new_end,1));
							var m = new_end.getMonth(), d = new_end.getDate(), y = new_end.getFullYear();
						}';
				}
						
				print ('<div id="show_time_slot" name="show_time_slot" class="show_time_slot"> </div>
						<input type="hidden" id="total_price_calculated" name="total_price_calculated"/>
						<input type="hidden" id="wapbk_multiple_day_booking" name="wapbk_multiple_day_booking" value="'.$booking_settings['booking_enable_multiple_day'].'"/>');
				
				if (!isset($booking_settings['booking_enable_multiple_day']) || (isset($booking_settings['booking_enable_multiple_day']) && $booking_settings['booking_enable_multiple_day'] != "on")) {
					do_action('bkap_display_price_div',$post->ID);
				}
						
				if (isset($booking_settings['booking_enable_multiple_day']) && $booking_settings['booking_enable_multiple_day'] != "on") {
					$currency_symbol = get_woocommerce_currency_symbol();
					$addon_price = 'var quantity = jQuery("input[class=\"input-text qty text\"]").attr("value");
									if (typeof quantity == "undefined") {
										var quantity = 1;
									}
									var sold_individually = jQuery("#wapbk_sold_individually").val();
								
									var time_slot_value = jQuery("#time_slot").val();
								
									if (typeof time_slot_value == "undefined" ) {
										var values = new Array();
										jQuery.each(jQuery("input[name=\"time_slot[]\"]:checked"), function() {
								 			 values.push(jQuery(this).val());
										});
										
										if (values.length > 0) {
											time_slot_value = values.join(","); 
										}
									}
									jQuery( "#ajax_img" ).show();
									// for grouped products
									var quantity_str = jQuery("input[class=\"input-text qty text\"]").attr("value");
									if (jQuery("#wapbk_grouped_child_ids").val() != "") {
										var child_ids = jQuery("#wapbk_grouped_child_ids").val();
										var child_ids_exploded = child_ids.split("-");
								
										var arrayLength = child_ids_exploded.length;
										var arrayLength = arrayLength - 1;
										for (var i = 0; i < arrayLength; i++) {
											var quantity_grp1 = jQuery("input[name=\"quantity[" + child_ids_exploded[i] +"]\"]").attr("value");
											if (quantity_str != "")
												quantity_str = quantity_str  + "," + quantity_grp1;
											else
												quantity_str = quantity_grp1;	
										}
									}
                            // for variable products
						    var variation_id = 0;
						    if ( jQuery( ".variation_id" ).length > 0 ) {
                                variation_id = jQuery( ".variation_id" ).val();
						    }
							var data = {
							id: '.$duplicate_of.',
						    post_id: '.$post->ID.',
							details: jQuery("#wapbk_hidden_date").val(),
							timeslots: jQuery("#wapbk_number_of_timeslots").val(),
							timeslot_value: time_slot_value,
							quantity: quantity_str,
                            variation_id: variation_id,
							action: "bkap_call_addon_price"
							'.$attribute_fields_str.'
						};
						jQuery.post("'.get_admin_url().'admin-ajax.php", data, function(amt) {
							jQuery( "#ajax_img" ).hide();
							if (isNaN(parseInt(amt))) {
								jQuery("#show_addon_price").html(amt);
								if (jQuery("#wapbk_bookingEnableTime").val() == "on" && jQuery("#wapbk_booking_times").val() == "YES") {
										if ( jQuery("#time_slot").val() != "" && typeof time_slot_value != "undefined" ) {
											jQuery( ".single_add_to_cart_button" ).show();
										}
										else {
											jQuery( ".single_add_to_cart_button" ).hide();
										}
								}
								else {
									jQuery( ".single_add_to_cart_button" ).show();
								}
							} 
							if (jQuery("#wapbk_bookingEnableTime").val() == "on" && jQuery("#wapbk_booking_times").val() == "YES") {
								if ( jQuery("#time_slot").val() != "" && typeof time_slot_value != "undefined" ) {
									jQuery( ".single_add_to_cart_button" ).show();
								} else {
									jQuery( ".single_add_to_cart_button" ).hide();
								}
							} else {
								jQuery( ".single_add_to_cart_button" ).show();
							}			
							// Woo Product Addons compatibility
							if (jQuery("#product-addons-total").length > 0) {
								jQuery("#product-addons-total").data( "price", price );
							}
							var $cart = jQuery(".cart");
							$cart.trigger("woocommerce-product-addons-update");
							// Update the GF product addons total
							if (typeof update_dynamic_price == "function") {
								update_dynamic_price(jQuery(".ginput_container").find(".gform_hidden").val());
							}
						});';
					if ($product_type == 'variable') {
						$attribute_change_single_day_var = 'jQuery(document).on("change",jQuery("#'.$on_change_attributes_str.'"),function()
							{
								if (jQuery("#wapbk_hidden_date").val() != "")  {
								'.$addon_price.'
							}});';
					} else {
						$attribute_change_single_day_var = '';
					}
					$quantity_change_var = 'jQuery("form.cart").on("change", "input.qty", function(){
						if (jQuery("#wapbk_hidden_date").val() != "") {
							bkap_single_day_price();
						}
					});';
				} else {
					$addon_price = "";
					$attribute_change_single_day_var = "";
					$currency_symbol = get_woocommerce_currency_symbol();
					print("<input type='hidden' id='wapbk_currency' name='wapbk_currency' value='".$currency_symbol."'/>");
					$quantity_change_var =  'jQuery("form.cart").on("change", "input.qty", function(){
						if (jQuery("#wapbk_hidden_date").val() != "" && jQuery("#wapbk_hidden_date_checkout").val() != "") {
							bkap_calculate_price();
						}
					});';
				}
				
				$day_selected = "";
				if(isset($global_settings->booking_calendar_day))  {
					$day_selected = $global_settings->booking_calendar_day;
				} else {
					$day_selected = get_option("start_of_week");
				}
					
				if (isset($booking_settings['enable_inline_calendar']) && $booking_settings['enable_inline_calendar'] == 'on'){
					$current_language = json_decode(get_option('woocommerce_booking_global_settings'));
                    if (isset($current_language)) {
						$curr_lang = $current_language->booking_language;
                    } else {
						$curr_lang = "en-GB";
					}
					$hidden_date = '';
					$hidden_date_checkout = '';
					global $bkap_block_booking;
					$number_of_fixed_price_blocks = $bkap_block_booking->bkap_get_fixed_blocks_count($post->ID);

					if (isset($_SESSION['start_date']) && $_SESSION['start_date'] != '') {
					    $hidden_date = date('j-n-Y',strtotime($_SESSION['start_date']));
					    $widget_search = 1;
					}
					if (isset($_SESSION['end_date']) && $_SESSION['end_date'] != '') {
					    if ( isset( $booking_settings[ 'booking_enable_multiple_day' ] ) && $booking_settings[ 'booking_enable_multiple_day' ] == 'on' ) {
					        $hidden_date_checkout = date( 'j-n-Y', strtotime( $_SESSION[ 'end_date' ] ) );
					    }
					}
					
					if (isset($global_settings->booking_global_selection) && $global_settings->booking_global_selection == "on") {
						foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
							if(array_key_exists('booking',$values)) {
								$booking = $values['booking'];
							    $hidden_date_arr = explode("-",$booking[0]['hidden_date']);
								$hidden_time = mktime(0,0,0,$hidden_date_arr[1],$hidden_date_arr[0],$hidden_date_arr[2]);
								if( $hidden_time > $current_time ) {
								    $hidden_date = $booking[0]['hidden_date'];
								} else {
								    $hidden_date = $default_date;   
								}
								if(array_key_exists("hidden_date_checkout",$booking[0])) {
									$hidden_date_checkout = $booking[0]['hidden_date_checkout'];
								}
							}
							break;
						}
					}
					
					print('<input type="hidden" id="wapbk_hidden_date" name="wapbk_hidden_date" value="'.$hidden_date.'"/>
						<input type="hidden" id="wapbk_hidden_date_checkout" name="wapbk_hidden_date_checkout" value="'.$hidden_date_checkout.'"/>
						<input type="hidden" id="wapbk_diff_days" name="wapbk_diff_days" />
						'.$blocked_dates_hidden_var.'
						<div id="ajax_img" name="ajax_img"> <img src="'.plugins_url().'/woocommerce-booking/images/ajax-loader.gif"> </div>
						
						<script type="text/javascript">
							jQuery( "#ajax_img" ).hide();
							jQuery(document).ready(function() {
								'.$attribute_change_var.' 
								'.$quantity_change_var.'
								'.$attribute_change_single_day_var.' 
								var formats = ["d.m.y", "d-m-yy","MM d, yy"];
								var split = jQuery("#wapbk_hidden_default_date").val().split("-");
								split[1] = split[1] - 1;		
								var default_date = new Date(split[2],split[1],split[0]);
								var delay_date = jQuery("#wapbk_minimumOrderDays").val();
								var split_date = delay_date.split("-");
								var delay_days = new Date (split_date[1] + "/" + split_date[0] + "/"+ split_date[2]);
								// check if the maxdate is a date
								var index = jQuery("#wapbk_number_of_dates").val().indexOf("-");
								if (index > 0) {
									// split the string and create a jQuery date object 
									var split_maxDate = jQuery("#wapbk_number_of_dates").val().split("-");
									var max_date = new Date(split_maxDate[2],split_maxDate[1] - 1,split_maxDate[0]);
								}
								else {
									var max_date = jQuery("#wapbk_number_of_dates").val();
								}
					    
					    
					            // This Will ensure if any week days are blocked via filter then it will populate correct date to front end.
							    var disabled_checkin_week_days = eval("["+jQuery("#wapbk_block_checkin_weekdays").val()+"]"); 
							    for ( jjj = 0; jjj < disabled_checkin_week_days.length; jjj++) {
        							
							    if( jQuery.inArray( delay_days.getDay(), disabled_checkin_week_days ) != -1 ) {
        								var delay_days_checkin = delay_days.getDate() + 1; 
							            delay_days = new Date ( split_date[1] + "/" + delay_days_checkin + "/"+ split_date[2]); 
        							}
							   }
					    
								jQuery.extend(jQuery.datepicker, { afterShow: function(event) {
									jQuery.datepicker._getInst(event.target).dpDiv.css("z-index", 9999);
								}});
								jQuery(function() {
									jQuery("#inline_calendar").datepicker({
										beforeShow: avd,
										defaultDate: default_date,
										minDate:delay_days,
										maxDate:max_date,
										altField: "#booking_calender",
										dateFormat: "'.$global_settings->booking_date_format.'",
										numberOfMonths: parseInt('.$global_settings->booking_months.'),
										'.$options_checkin_str.' ,
									}).focus(function (event){
										jQuery.datepicker.afterShow(event);
								});
								if((jQuery("#wapbk_global_selection").val() == "yes" && jQuery("#block_option_enabled").val() != "on") || (jQuery("#wapbk_widget_search").val() == "1")) {
									var split = jQuery("#wapbk_hidden_date").val().split("-");
									split[1] = split[1] - 1;		
									var CheckinDate = new Date(split[2],split[1],split[0]);
									var timestamp = Date.parse(CheckinDate); 
									if (isNaN(timestamp) == false) { 
										var default_date_selection = new Date(timestamp);
										jQuery("#inline_calendar").datepicker("setDate",default_date_selection);
									}
								}
					            var split = jQuery("#wapbk_hidden_date").val().split("-");
					                if(split != ""){
    									split[1] = split[1] - 1;		
    									var CheckinDate = new Date(split[2],split[1],split[0]);
    									var timestamp = Date.parse(CheckinDate); 
    									if (isNaN(timestamp) == false) { 
    										var default_date_selection = new Date(timestamp);
    										jQuery("#inline_calendar").datepicker("setDate",default_date_selection);
    									}
					            }
								jQuery("#inline_calendar").datepicker("option",jQuery.datepicker.regional[ "'.$curr_lang.'" ]);
								jQuery("#inline_calendar").datepicker("option", "dateFormat","'.$global_settings->booking_date_format.'");
								jQuery("#inline_calendar").datepicker("option", "firstDay","'.$day_selected.'");
								'.$options_checkin_calendar.'
							});
							jQuery("#ui-datepicker-div").wrap("<div class=\"hasDatepicker\"></div>");');
				} else {
					global $bkap_block_booking;
					$number_of_fixed_price_blocks = $bkap_block_booking->bkap_get_fixed_blocks_count($post->ID);
					
					$hidden_date = '';
					$hidden_date_checkout = '';
					$widget_search = 0;
					if (isset($_SESSION['start_date']) && $_SESSION['start_date'] != '') {
						$hidden_date = date('j-n-Y',strtotime($_SESSION['start_date']));
						$widget_search = 1;
					}
					if (isset($_SESSION['end_date']) && $_SESSION['end_date'] != '') {
					    if ( isset( $booking_settings[ 'booking_enable_multiple_day' ] ) && $booking_settings[ 'booking_enable_multiple_day' ] == 'on' ) {
					        $start_ts = strtotime( $_SESSION['start_date'] );
						    $end_ts = strtotime( $_SESSION[ 'end_date' ] );
						    if ( $start_ts == $end_ts ){
						        
						        if ( is_plugin_active( 'bkap-rental/rental.php' ) ) {
						            if( isset( $booking_settings[ 'booking_charge_per_day' ] ) && $booking_settings[ 'booking_charge_per_day' ] == 'on' && isset( $booking_settings[ 'booking_same_day' ] ) && $booking_settings[ 'booking_same_day' ] == 'on' ) {
						                $hidden_date_checkout = date( 'j-n-Y', strtotime( $_SESSION[ 'end_date' ] ) );
						            }else { 
						                $next_end_date = strtotime( '+1 day', strtotime( $_SESSION[ 'end_date' ] ) );
						                $hidden_date_checkout = date( 'j-n-Y', $next_end_date );
						            }
						        }else { 
						                $next_end_date = strtotime( '+1 day', strtotime( $_SESSION[ 'end_date' ] ) );
						                $hidden_date_checkout = date( 'j-n-Y', $next_end_date );
						            }
						    } else {
						        
						        $hidden_date_checkout = date( 'j-n-Y', strtotime( $_SESSION[ 'end_date' ] ) );
						    }
						}
					}
					if (isset($global_settings->booking_global_selection) && $global_settings->booking_global_selection == "on") {
						foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
							if(array_key_exists('booking',$values)) {
								$booking = $values['booking'];
								$hidden_date_arr = explode("-",$booking[0]['hidden_date']);
								$hidden_time = mktime(0,0,0,$hidden_date_arr[1],$hidden_date_arr[0],$hidden_date_arr[2]);
								if( $hidden_time > $current_time ) {
								    $hidden_date = $booking[0]['hidden_date'];
								} else {
								    $hidden_date = $default_date;   
								}
								$widget_search = 0;
								if(array_key_exists("hidden_date_checkout",$booking[0])){
									$hidden_date_checkout = $booking[0]['hidden_date_checkout'];
								}
							}
							break;
						}
					}
					print('<input type="hidden" id="wapbk_widget_search" name="wapbk_widget_search" value="'.$widget_search.'"/>');
					print('<input type="hidden" id="wapbk_hidden_date" name="wapbk_hidden_date" value="'.$hidden_date.'"/>
							<input type="hidden" id="wapbk_hidden_date_checkout" name="wapbk_hidden_date_checkout" value="'.$hidden_date_checkout.'"/>
							<input type="hidden" id="wapbk_diff_days" name="wapbk_diff_days" />
							'.$blocked_dates_hidden_var.'
							<div id="ajax_img" name="ajax_img"> <img src="'.plugins_url().'/woocommerce-booking/images/ajax-loader.gif"> </div>

							<script type="text/javascript">
								jQuery( "#ajax_img" ).hide();
								jQuery(document).ready(function() {
									'.$attribute_change_var.' 
									'.$quantity_change_var.'
									'.$attribute_change_single_day_var.' 
									var formats = ["d.m.y", "d-m-yy","MM d, yy"];
							        var split = jQuery("#wapbk_hidden_default_date").val().split("-");
								    split[1] = split[1] - 1;		
								    var default_date = new Date(split[2],split[1],split[0]);
									jQuery.extend(jQuery.datepicker, { afterShow: function(event){
										jQuery.datepicker._getInst(event.target).dpDiv.css("z-index", 9999);
									}});
									jQuery("#booking_calender").datepicker({
										beforeShow: avd,
                                        defaultDate: default_date,
										dateFormat: "'.$global_settings->booking_date_format.'",
										numberOfMonths: parseInt('.$global_settings->booking_months.'),
										firstDay: parseInt('.$day_selected.'),
										'.$options_checkin_str.' ,
									}).focus(function (event){
										jQuery.datepicker.afterShow(event);
									});
                                                                        
									if((jQuery("#wapbk_global_selection").val() == "yes" && jQuery("#block_option_enabled").val() != "on") || (jQuery("#wapbk_widget_search").val() == "1")) {
										var split = jQuery("#wapbk_hidden_date").val().split("-");
										split[1] = split[1] - 1;		
										var CheckinDate = new Date(split[2],split[1],split[0]);
										var timestamp = Date.parse(CheckinDate); 
										if (isNaN(timestamp) == false) { 
											var default_date = new Date(timestamp);
											jQuery("#booking_calender").datepicker("setDate",default_date);
										}
									}
								jQuery("#ui-datepicker-div").wrap("<div class=\"hasDatepicker\"></div>");
								jQuery("#checkin_cal").click(function() {
									jQuery("#booking_calender").datepicker("show");
								});');
					}
					//from here
					if ($booking_settings['booking_enable_multiple_day'] == 'on'){
						if (isset($booking_settings['enable_inline_calendar']) && $booking_settings['enable_inline_calendar'] == 'on') {
							print ('jQuery(document).ready(function(){
							    
				                    var delay_date = jQuery("#wapbk_minimumOrderDays").val();
    								var split_date = delay_date.split("-"); 
    								var delay_days = new Date (split_date[1] + "/" + split_date[0] + "/"+ split_date[2]); 
    							    var delay_days_checkout = delay_days.getDate() + 1; 
    							    delay_days = new Date ( split_date[1] + "/" + delay_days_checkout + "/"+ split_date[2]); 
    							    
    							    // This Will ensure if ay week days are blocked via filter then it will populate correct date to front end.
    							    var disabled_checkout_week_days = eval("["+jQuery("#wapbk_block_checkout_weekdays").val()+"]"); 
    							    for ( jjj = 0; jjj < disabled_checkout_week_days.length; jjj++) {
            							
    							    if( jQuery.inArray( delay_days.getDay(), disabled_checkout_week_days) != -1 ) {
            								var delay_days_checkout = delay_days.getDate() + 1; // james fix
    							            
    							            delay_days = new Date ( split_date[1] + "/" + delay_days_checkout + "/"+ split_date[2]); 
            							}
    							   }
    							    // check if check and checkout date are same , if it is then increase checkout date
    							    var checkin_date = jQuery("#inline_calendar").datepicker( "getDate" );
    							    if ( delay_days.getTime() == checkin_date.getTime() ){
    							         
    							         var delay_days_checkout = delay_days.getDate() + 1; 
    							         delay_days = new Date ( split_date[1] + "/" + delay_days_checkout + "/"+ split_date[2]); 
    							    }			    
							    
							    
									jQuery("#inline_calendar_checkout").datepicker({
										dateFormat: "'.$global_settings->booking_date_format.'",
										numberOfMonths: parseInt('.$global_settings->booking_months.'),
										'.$options_checkout_str.' ,
										altField: "#booking_calender_checkout",
										onClose: function( selectedDate ) {
											jQuery( "#inline_calendar" ).datepicker( "option", "maxDate", selectedDate );
										},
										}).focus(function (event){
											jQuery.datepicker.afterShow(event);
										});
							    
        							    
							            jQuery("#inline_calendar_checkout").datepicker("setDate",delay_days);
                                        jQuery("#inline_calendar_checkout").datepicker("option", "minDate", delay_days); 
										
							            if((jQuery("#wapbk_global_selection").val() == "yes" && jQuery("#block_option_enabled").val() != "on") || (jQuery("#wapbk_widget_search").val() == "1")) {
											var split = jQuery("#wapbk_hidden_date_checkout").val().split("-");
											split[1] = split[1] - 1;		
											var CheckoutDate = new Date(split[2],split[1],split[0]);
											var timestamp = Date.parse(CheckoutDate);
											if (isNaN(timestamp) == false)  { 
												var default_date = new Date(timestamp);
												jQuery("#inline_calendar_checkout").datepicker("setDate",default_date);
												bkap_calculate_price();
											}
										}
										jQuery("#checkout_cal").click(function() {
										jQuery("#inline_calendar_checkout").datepicker("show");
								});
							    
							    var split = jQuery("#wapbk_hidden_date_checkout").val().split("-");
    				                if(split != ""){
        								split[1] = split[1] - 1;		
        								var CheckoutDate = new Date(split[2],split[1],split[0]);
        								var timestamp = Date.parse(CheckoutDate); 
        								if (isNaN(timestamp) == false) { 
        									var default_date_selection = new Date(timestamp);
        									jQuery("#inline_calendar_checkout").datepicker("setDate",default_date_selection);
        								}
    				                }
    					            
							    
							    var checkin_date = jQuery("#inline_calendar").datepicker( "getDate" );
							    var date = checkin_date.getDate();
	                            var month = checkin_date.getMonth() + 1;
	                            var year = checkin_date.getFullYear();
							    
							    var date_selected = date + "-" + month + "-" + year;
							    jQuery("#wapbk_hidden_date").val( date_selected );
							    
							    
							    var checkout_date = jQuery("#inline_calendar_checkout").datepicker( "getDate" );
							    var date = checkout_date.getDate();
	                            var month = checkout_date.getMonth() + 1;
	                            var year = checkout_date.getFullYear();
							    
							    var date_selected_checkout = date + "-" + month + "-" + year;
							    jQuery("#wapbk_hidden_date_checkout").val( date_selected_checkout );
							    
							    if ( date_selected != "" && date_selected_checkout != "" ){
							             bkap_calculate_price();
							    }
								jQuery("#inline_calendar_checkout").datepicker("option", "firstDay","'.$day_selected.'");
							});
							');
						}else {
							print ('jQuery("#booking_calender_checkout").datepicker({
								dateFormat: "'.$global_settings->booking_date_format.'",
								numberOfMonths: parseInt('.$global_settings->booking_months.'),
								firstDay: '.$day_selected.',
								'.$options_checkout_str.' , 
								onClose: function( selectedDate ) {
									jQuery( "#booking_calender" ).datepicker( "option", "maxDate", selectedDate );
								},
								}).focus(function (event){
									jQuery.datepicker.afterShow(event);
								}); 
								if((jQuery("#wapbk_global_selection").val() == "yes" && jQuery("#block_option_enabled").val() != "on") || (jQuery("#wapbk_widget_search").val() == "1")) {
									var split = jQuery("#wapbk_hidden_date_checkout").val().split("-");
									split[1] = split[1] - 1;		
									var CheckoutDate = new Date(split[2],split[1],split[0]);
									var timestamp = Date.parse(CheckoutDate);
									if (isNaN(timestamp) == false) { 
										var default_date = new Date(timestamp);
										jQuery("#booking_calender_checkout").datepicker("setDate",default_date);
										bkap_calculate_price();
									}
								}
								jQuery("#checkout_cal").click(function() {
								jQuery("#booking_calender_checkout").datepicker("show");
							});');
						}
					}
					
					$currency_symbol = get_woocommerce_currency_symbol();
					print('});
						//**********************************************
                        // This function disables the dates in the calendar for holidays, global holidays set and for which lockout is reached for Multiple day booking feature.
                        //***************************************************

						function bkap_check_booked_dates(date) {
							var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
							var holidayDates = eval("["+jQuery("#wapbk_booking_holidays").val()+"]");
							var globalHolidays = eval("["+jQuery("#wapbk_booking_global_holidays").val()+"]");
							var bookedDates = eval("["+jQuery("#wapbk_hidden_booked_dates").val()+"]");	
							var bookedDatesCheckout = eval("["+jQuery("#wapbk_hidden_booked_dates_checkout").val()+"]");
							var block_option_start_day= jQuery("#block_option_start_day").val();
						 	var block_option_price= jQuery("#block_option_price").val();
					        
					        var disabled_checkin_week_days = eval("["+jQuery("#wapbk_block_checkin_weekdays").val()+"]");
					        var disabled_checkout_week_days = eval("["+jQuery("#wapbk_block_checkout_weekdays").val()+"]");
					    
							for (iii = 0; iii < globalHolidays.length; iii++) {
								if( jQuery.inArray(d + "-" + (m+1) + "-" + y,globalHolidays) != -1 ) {
									return [false, "", "'.__("Holiday","woocommerce-booking").'"];
								}
							}
							for (ii = 0; ii < holidayDates.length; ii++) {
								if( jQuery.inArray(d + "-" + (m+1) + "-" + y,holidayDates) != -1 ) {
									return [false, "","'.__("Holiday","woocommerce-booking").'"];
								}
							}
							var id_booking = jQuery(this).attr("id");
							if (id_booking == "booking_calender" || id_booking == "inline_calendar") {
								for (iii = 0; iii < bookedDates.length; iii++) {
									if( jQuery.inArray(d + "-" + (m+1) + "-" + y,bookedDates) != -1 ){
										return [false, "", "'.__("Unavailable for Booking","woocommerce-booking").'"];
									}
								}
					            for ( jjj = 0; jjj < disabled_checkin_week_days.length; jjj++) {
        							if( jQuery.inArray( date.getDay(), disabled_checkin_week_days) != -1 ) {
        								return [false, "", "'.__("Blocked","woocommerce-booking").'"];
        							}
							   }
							}
							if (id_booking == "booking_calender_checkout" || id_booking == "inline_calendar_checkout") {
								for (iii = 0; iii < bookedDatesCheckout.length; iii++) {
									if( jQuery.inArray(d + "-" + (m+1) + "-" + y,bookedDatesCheckout) != -1 ) {
										return [false, "", "'.__("Unavailable for Booking","woocommerce-booking").'"];
									}
								}
					            for ( jjj = 0; jjj < disabled_checkout_week_days.length; jjj++) {
        							if( jQuery.inArray( date.getDay(), disabled_checkout_week_days) != -1 ) {
        								return [false, "", "'.__("Blocked","woocommerce-booking").'"];
        							}
							   }
							}
							'.$js_code.'
							var block_option_enabled= jQuery("#block_option_enabled").val();
							if (block_option_enabled =="on") {
								if ( id_booking == "booking_calender" || id_booking == "inline_calendar" ) {
									if (block_option_start_day == date.getDay() || block_option_start_day == "any_days") {
										return [true];
									} else {
					            		return [false];
									}
								}
								var bcc_date=jQuery( "#booking_calender_checkout").datepicker("getDate");
								if (bcc_date == null) {
									var bcc_date = jQuery("#inline_calendar_checkout").datepicker("getDate");
								}
								var dd = bcc_date.getDate();
								var mm = bcc_date.getMonth()+1; //January is 0!
								var yyyy = bcc_date.getFullYear();
								var checkout = dd + "-" + mm + "-"+ yyyy;
								jQuery("#wapbk_hidden_date_checkout").val(checkout);

				       			if (id_booking == "booking_calender_checkout" || id_booking == "inline_calendar_checkout") {
									if (Date.parse(bcc_date) === Date.parse(date)){
				       					return [true];
									} else{
				       					return [false];
				       				}
				       			}
				       		}
							return [true];
						}
                        
						// ***************************************************
                        //This function disables the dates in the calendar for holidays, global holidays set and for which lockout is reached for Single day booking	feature.
						//***********************************
						
						function bkap_show_book(date){
							var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
							// .html() is used when we have zip code groups enabled
							var deliveryDates = eval("["+jQuery("#wapbk_booking_dates").val()+"]");	
							var holidayDates = eval("["+jQuery("#wapbk_booking_holidays").val()+"]");
							var globalHolidays = eval("["+jQuery("#wapbk_booking_global_holidays").val()+"]");
					    
					        var disabled_week_days = eval("["+jQuery("#wapbk_block_checkin_weekdays").val()+"]");
					    
					        for ( jjj = 0; jjj < disabled_week_days.length; jjj++) {
    						 	if( jQuery.inArray( date.getDay(), disabled_week_days) != -1 ) {
    						 		return [false, "", "'.__("Blocked","woocommerce-booking").'"];
    						 	}
						    }
						
							//Lockout Dates
							var lockoutdates = eval("["+jQuery("#wapbk_lockout_days").val()+"]");
							var bookedDates = eval("["+jQuery("#wapbk_hidden_booked_dates").val()+"]");
							var dt = new Date();
							var today = dt.getMonth() + "-" + dt.getDate() + "-" + dt.getFullYear();
							for (iii = 0; iii < lockoutdates.length; iii++) {
								if( jQuery.inArray(d + "-" + (m+1) + "-" + y,lockoutdates) != -1 ) {
									return [false, "", "'.__("Booked","woocommerce-booking").'"];
								}
							}	
						
							for (iii = 0; iii < globalHolidays.length; iii++) {
								if( jQuery.inArray(d + "-" + (m+1) + "-" + y,globalHolidays) != -1 ){
									return [false, "", "'.__("Holiday","woocommerce-booking").'"];
								}
							}
						
							for (ii = 0; ii < holidayDates.length; ii++) {
								if( jQuery.inArray(d + "-" + (m+1) + "-" + y,holidayDates) != -1 ) {
									return [false, "","'.__("Holiday","woocommerce-booking").'"];
								}
							}
					
							for (i = 0; i < bookedDates.length; i++) {
								if( jQuery.inArray(d + "-" + (m+1) + "-" + y,bookedDates) != -1 ) {
									return [false, "","'.__("Unavailable for Booking","woocommerce-booking").'"];
								}
							}
							'.$js_code.' 	
							for (i = 0; i < deliveryDates.length; i++) {
								if( jQuery.inArray(d + "-" + (m+1) + "-" + y,deliveryDates) != -1 ){
									return [true];
								}
							}
							var day = "booking_weekday_" + date.getDay();
							if (jQuery("#wapbk_"+day).val() == "on"){
									return [true];
							}
							return [false];
						}
                                    
						//********************************************************
						//This function calls an ajax when a date is selected which displays the time slots on frontend product page.
                        //**************************************************
					
						function bkap_show_times(date,inst) {
							jQuery( ".single_add_to_cart_button" ).hide();
							var monthValue = inst.selectedMonth+1;
							var dayValue = inst.selectedDay;
							var yearValue = inst.selectedYear;

							var current_dt = dayValue + "-" + monthValue + "-" + yearValue;
							var sold_individually = jQuery("#wapbk_sold_individually").val();
							var quantity = jQuery("input[class=\"input-text qty text\"]").attr("value");
							if (typeof quantity == "undefined") {
								var quantity = 1;
							}
							jQuery("#wapbk_hidden_date").val(current_dt);
							// Availability Display for the date selected if setting is enabled
							if (jQuery("#wapbk_availability_display").val() == "yes") {
								var data = {
									checkin_date: jQuery("#wapbk_hidden_date").val(),
									post_id: "'.$duplicate_of.'", 
									action: "bkap_get_date_lockout"
									};
			
								jQuery.post("'.get_admin_url().'admin-ajax.php", data, function(response)
								{
									jQuery("#show_stock_status").html(response);
								});
							}
							if (jQuery("#wapbk_bookingEnableTime").val() == "on" && jQuery("#wapbk_booking_times").val() == "YES") {
								jQuery( "#ajax_img" ).show();
								jQuery( ".single_add_to_cart_button" ).hide();	
								var time_slots_arr = jQuery("#wapbk_booking_times").val();
								var data = {
									current_date: current_dt,
									post_id: "'.$duplicate_of.'", 
									action: "'.$method_to_show.'"
									'.$attribute_fields_str.'
								};
								jQuery.post("'.get_admin_url().'admin-ajax.php", data, function(response) {
									jQuery( "#ajax_img" ).hide();
									jQuery("#show_time_slot").html(response);
									bkap_time_slot_events();
								});
							} else {
								if ( jQuery("#wapbk_hidden_date").val() != "" ) {
									var data = {
										current_date: current_dt,
										post_id: "'.$duplicate_of.'",
										action: "bkap_insert_date"
										'.$attribute_fields_str.'
									};
									jQuery.post("'.get_admin_url().'admin-ajax.php", data, function(response){
                                    jQuery( ".payment_type" ).show();
									if(sold_individually == "yes") {
										jQuery( ".quantity" ).hide();
                                    } else {
										jQuery( ".quantity" ).show();
									}
								});
								} else if ( jQuery("#wapbk_hidden_date").val() == "" ) {
									jQuery( ".single_add_to_cart_button" ).hide();
									jQuery( ".quantity" ).hide();
                                    jQuery( ".payment_type" ).hide()
									jQuery(".partial_message").hide();
								}
							}
							bkap_single_day_price();
						}
							
						function bkap_time_slot_events() {
							jQuery("#time_slot").change(function() {
								var time_slot_value = jQuery("#time_slot").val();
								if (typeof time_slot_value == "undefined") {
									var values = new Array();
									jQuery.each(jQuery("input[name=\"time_slot[]\"]:checked"), function() {
										 values.push(jQuery(this).val());
									});
											
									if (values.length > 0) {
										time_slot_value = values.join(","); 
									}
								}
								var sold_individually = jQuery("#wapbk_sold_individually").val();
								var quantity = jQuery("input[class=\"input-text qty text\"]").attr("value");
								if (typeof quantity == "undefined") {
									var quantity = 1;
								}
								// Availability display for the time slot selected if setting is enabled
							
								if (typeof time_slot_value != "undefined" && jQuery("#wapbk_availability_display").val() == "yes") {
									var data = {
										checkin_date: jQuery("#wapbk_hidden_date").val(),
										timeslot_value: time_slot_value,
										post_id: "'.$duplicate_of.'", 
										action: "bkap_get_time_lockout"
									};
									jQuery.post("'.get_admin_url().'admin-ajax.php", data, function(response) {
										jQuery("#show_stock_status").html(response);
									});
								}
								if ( jQuery("#time_slot").val() != "" ) {
                                	jQuery( ".payment_type" ).show();
									if(sold_individually == "yes") {
										jQuery( ".quantity" ).hide();
										jQuery( ".payment_type" ).hide();
										jQuery(".partial_message").hide();
									} else {
										jQuery( ".quantity" ).show();
										jQuery( ".payment_type" ).show();
									}
								} else if ( jQuery("#time_slot").val() == "" ) {
									jQuery( ".single_add_to_cart_button" ).hide();
									jQuery( ".quantity" ).hide();
                                    jQuery( ".payment_type" ).hide();
									jQuery(".partial_message").hide();
								}
								// This is called to ensure the variable pricing for time slots is displayed
								bkap_single_day_price();
							})
						}
						/*************************************************
							This function is used to display the price for 
							single day bookings
						**************************************************/
							function bkap_single_day_price() {
							var data = {
									booking_date: jQuery("#wapbk_hidden_date").val(),
									post_id: '.$duplicate_of.', 
									addon_data: jQuery("#wapbk_addon_data").val(),
									action: "bkap_js"									
								};
								jQuery.post("'.get_admin_url().'admin-ajax.php", data, function(response) {
									eval(response);
									'.$addon_price.'
							});
							
							}
						//******************************************
						//This functions checks if the selected date range does not have product holidays or global holidays and sets the hidden date field.
						//********************************************
					
						function bkap_set_checkin_date(date,inst){
							var monthValue = inst.selectedMonth+1;
							var dayValue = inst.selectedDay;
							var yearValue = inst.selectedYear;

							var current_dt = dayValue + "-" + monthValue + "-" + yearValue;
							jQuery("#wapbk_hidden_date").val(current_dt);
							// Check if any date in the selected date range is unavailable
							if (jQuery("#wapbk_hidden_date").val() != "" && jQuery("#wapbk_hidden_date_checkout").val() != "") {
								var CalculatePrice = "Y";
								var split = jQuery("#wapbk_hidden_date").val().split("-");
								split[1] = split[1] - 1;		
								var CheckinDate = new Date(split[2],split[1],split[0]);
								
								var split = jQuery("#wapbk_hidden_date_checkout").val().split("-");
								split[1] = split[1] - 1;
								var CheckoutDate = new Date(split[2],split[1],split[0]);
								
								var date = new_end = new Date(CheckinDate);
								var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
								
								var bookedDates = eval("["+jQuery("#wapbk_hidden_booked_dates").val()+"]");
								var holidayDates = eval("["+jQuery("#wapbk_booking_holidays").val()+"]");
								var globalHolidays = eval("["+jQuery("#wapbk_booking_global_holidays").val()+"]");
						
								var count = gd(CheckinDate, CheckoutDate, "days");
								//Locked Dates
								for (var i = 1; i<= count;i++) {
									if( jQuery.inArray(d + "-" + (m+1) + "-" + y,bookedDates) != -1 ) {
										jQuery("#wapbk_hidden_date").val("");
										jQuery("#booking_calender").val("");
										jQuery( ".single_add_to_cart_button" ).hide();
										jQuery( ".quantity" ).hide();
										CalculatePrice = "N";
										alert("'. __("Some of the dates in the selected range are unavailable. Please try another date range.", "woocommerce-booking") .'");
										break;
									}
									new_end = new Date(ad(new_end,1));
									var m = new_end.getMonth(), d = new_end.getDate(), y = new_end.getFullYear();													
								}
								//Global Holidays
								var date = new_end = new Date(CheckinDate);
								var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
							
								for (var i = 1; i<= count;i++){
									if( jQuery.inArray(d + "-" + (m+1) + "-" + y,globalHolidays) != -1 ) {
										jQuery("#wapbk_hidden_date").val("");
										jQuery("#booking_calender").val("");
										jQuery( ".single_add_to_cart_button" ).hide();
										jQuery( ".quantity" ).hide();
										CalculatePrice = "N";
										alert("' . __( "Some of the dates in the selected range are unavailable. Please try another date range.", "woocommerce-booking" ) . '");
										break;
									}
									new_end = new Date(ad(new_end,1));
									var m = new_end.getMonth(), d = new_end.getDate(), y = new_end.getFullYear();													
								}
								//Product Holidays
								var date = new_end = new Date(CheckinDate);
								var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
						
								for (var i = 1; i<= count;i++){
									if( jQuery.inArray(d + "-" + (m+1) + "-" + y,holidayDates) != -1 ) {
										jQuery("#wapbk_hidden_date").val("");
										jQuery("#booking_calender").val("");
										jQuery( ".single_add_to_cart_button" ).hide();
										jQuery( ".quantity" ).hide();
										CalculatePrice = "N";
										alert ("'. __( "Some of the dates in the selected range are unavailable. Please try another date range.", "woocommerce-booking" ) .'");
										break;
									}
									new_end = new Date(ad(new_end,1));
									var m = new_end.getMonth(), d = new_end.getDate(), y = new_end.getFullYear();													
								}
								if (CalculatePrice == "Y") {
									bkap_calculate_price();
								}
							}
						}

						//************************************
						//This function sets the hidden checkout date for Multiple day booking feature.
                        //***********************************
					
						function bkap_get_per_night_price(date,inst){
							var monthValue = inst.selectedMonth+1;
							var dayValue = inst.selectedDay;
							var yearValue = inst.selectedYear;
							var current_dt = dayValue + "-" + monthValue + "-" + yearValue;
							jQuery("#wapbk_hidden_date_checkout").val(current_dt);
							bkap_calculate_price();
						}
                                       
						//***********************************
                        //This function add an ajax call to calculate price and displays the price on the frontend product page for Multiple day booking feature.
						//************************************
					
						function bkap_calculate_price(){
							// Check if any date in the selected date range is unavailable
							var CalculatePrice = "Y";				
							var split = jQuery("#wapbk_hidden_date").val().split("-");
							
						/*	var data = {
									booking_date: jQuery("#wapbk_hidden_date").val(),
									post_id: '.$duplicate_of.', 
									addon_data: jQuery("#wapbk_addon_data").val(),
									action: "bkap_js"									
								};
								jQuery.post("'.get_admin_url().'admin-ajax.php", data, function(response) {
									eval(response);
							});
					*/
							split[1] = split[1] - 1;		
							var CheckinDate = new Date(split[2],split[1],split[0]);
						
						
							var split = jQuery("#wapbk_hidden_date_checkout").val().split("-");
							split[1] = split[1] - 1;
							var CheckoutDate = new Date(split[2],split[1],split[0]);
						
							var date = new_end = new Date(CheckinDate);
							var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
						
							var bookedDates = eval("["+jQuery("#wapbk_hidden_booked_dates").val()+"]");
							var holidayDates = eval("["+jQuery("#wapbk_booking_holidays").val()+"]");
							var globalHolidays = eval("["+jQuery("#wapbk_booking_global_holidays").val()+"]");
					
							var count = gd(CheckinDate, CheckoutDate, "days");
                                                        if(jQuery("#wapbk_same_day").val() == "on") {
                                                            count = count + 1;
                                                        }
							for (var i = 1; i<= count;i++){
								if( jQuery.inArray(d + "-" + (m+1) + "-" + y,bookedDates) != -1 ){
									jQuery("#wapbk_hidden_date_checkout").val("");
									jQuery("#booking_calender_checkout").val("");
									jQuery( ".single_add_to_cart_button" ).hide();
									jQuery( ".quantity" ).hide();
									CalculatePrice = "N";
									alert ("'. __("Some of the dates in the selected range are unavailable. Please try another date range.", "woocommerce-booking") .'");
									break;
								}
								new_end = new Date(ad(new_end,1));
								var m = new_end.getMonth(), d = new_end.getDate(), y = new_end.getFullYear();
							}

							//Global Holidays
							var date = new_end = new Date(CheckinDate);
							var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
						
							for (var i = 1; i<= count;i++){
								if( jQuery.inArray(d + "-" + (m+1) + "-" + y,globalHolidays) != -1 ){
									jQuery("#wapbk_hidden_date_checkout").val("");
									jQuery("#booking_calender_checkout").val("");
									jQuery( ".single_add_to_cart_button" ).hide();
									jQuery( ".quantity" ).hide();
									CalculatePrice = "N";
									alert ("'. __( "Some of the dates in the selected range are unavailable. Please try another date range.", "woocommerce-booking" ) .'");
									break;
								}
								new_end = new Date(ad(new_end,1));
								var m = new_end.getMonth(), d = new_end.getDate(), y = new_end.getFullYear();
							}
							//Product Holidays
							var date = new_end = new Date(CheckinDate);
							var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
						
							for (var i = 1; i<= count;i++){
								if( jQuery.inArray(d + "-" + (m+1) + "-" + y,holidayDates) != -1 ) {
									jQuery("#wapbk_hidden_date_checkout").val("");
									jQuery("#booking_calender_checkout").val("");
									jQuery( ".single_add_to_cart_button" ).hide();
									jQuery( ".quantity" ).hide();
									CalculatePrice = "N";
									alert("'. __( "Some of the dates in the selected range are unavailable. Please try another date range.", "woocommerce-booking" ) .'");
									break;
								}
								new_end = new Date(ad(new_end,1));
								var m = new_end.getMonth(), d = new_end.getDate(), y = new_end.getFullYear();
							}
							'.$js_block_date.'
							// Calculate the price	
							if (CalculatePrice == "Y") {
								var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
								var sold_individually = jQuery("#wapbk_sold_individually").val();
								var firstDate = CheckinDate;
								var secondDate = CheckoutDate;
								var value_charge = '.$add_day.';
								var diffDays = Math.ceil(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
								diffDays = diffDays + value_charge;
								// set diff days to 1 if it is currently 0, this scenario occurs when user selects date range and then changes the Checkin date same as the checkout date
								if (diffDays == 0) {
									diffDays = 1;
								}
								jQuery("#wapbk_diff_days").val(diffDays);
								var quantity_str = jQuery("input[class=\"input-text qty text\"]").attr("value");
								if (typeof quantity_str == "undefined") {
									var quantity_str = 1;
								}
								// for grouped products
								if (jQuery("#wapbk_grouped_child_ids").val() != "") {
									var quantity_str = "";
									var child_ids = jQuery("#wapbk_grouped_child_ids").val();
									var child_ids_exploded = child_ids.split("-");
								
									var arrayLength = child_ids_exploded.length;
									var arrayLength = arrayLength - 1;
									for (var i = 0; i < arrayLength; i++) {
										var quantity_grp1 = jQuery("input[name=\"quantity[" + child_ids_exploded[i] +"]\"]").attr("value");
										if (quantity_str != "")
											quantity_str = quantity_str  + "," + quantity_grp1;
										else
											quantity_str = quantity_grp1;	
									}
								}
                                // for variable products
						        var variation_id = 0;
						        if ( jQuery( ".variation_id" ).length > 0 ) {
						            variation_id = jQuery( ".variation_id" ).val();
						        }
								jQuery( "#ajax_img" ).show();
								var data = {
									booking_date: jQuery("#wapbk_hidden_date").val(),
									post_id: '.$duplicate_of.', 
									addon_data: jQuery("#wapbk_addon_data").val(),
									action: "bkap_js"									
								};
								jQuery.post("'.get_admin_url().'admin-ajax.php", data, function(response) {
									eval(response);
									var data = {
										current_date: jQuery("#wapbk_hidden_date_checkout").val(),
										checkin_date: jQuery("#wapbk_hidden_date").val(),
										attribute_selected: jQuery("#wapbk_variation_value").val(),
										currency_selected: jQuery(".wcml_currency_switcher").val(),
										block_option_price: jQuery("#block_option_price").val(),
										post_id: "'.$duplicate_of.'",
										diff_days:  jQuery("#wapbk_diff_days").val(),
										quantity: quantity_str,  
                                        variation_id: variation_id, 
										action: "bkap_get_per_night_price",
										product_type: "'.$product_type.'"
										'.$attribute_fields_str.' 
										
									};
									jQuery.post("'.get_admin_url().'admin-ajax.php", data, function(response) {
										jQuery( "#ajax_img" ).hide();		
										if (isNaN(parseInt(response))) {
											jQuery("#show_time_slot").html(response)
										} 
										jQuery( ".single_add_to_cart_button" ).show();
		                                jQuery( ".payment_type" ).show();
										if(sold_individually == "yes") {
											jQuery( ".quantity" ).hide();
										}else {
											jQuery( ".quantity" ).show();
										}
										// Woo Product Addons compatibility
										if (jQuery("#product-addons-total").length > 0) {
											jQuery("#product-addons-total").data( "price", price );
										}
										var $cart = jQuery(".cart");
										$cart.trigger("woocommerce-product-addons-update");
										// Update the GF product addons total
										if (typeof update_dynamic_price == "function") {
											update_dynamic_price(jQuery(".ginput_container").find(".gform_hidden").val());
										}
									});
								});
							}
						}
					</script>');
				}
		do_action("bkap_before_add_to_cart_button",$booking_settings);
	}

	/***********************************************
	* This function displays the prices calculated from other Addons on frontend product page.
    **************************************************/
	public static function bkap_call_addon_price(){
		$product_id = $_POST['id'];
		$booking_date_format = $_POST['details'];
		$booking_date = date('Y-m-d',strtotime($booking_date_format));
		$number_of_timeslots = 0;
		if (isset($_POST['timeslots'])) {
			$number_of_timeslots = $_POST['timeslots'];
		}
		$product = get_product($product_id);
		$product_type = $product->product_type;
		$variation_id = $_POST[ 'variation_id' ];
		$booking_settings = get_post_meta($product_id, 'woocommerce_booking_settings', true);
		do_action('bkap_display_updated_addon_price',$product_id,$booking_date,$variation_id);
	}
			
	/*************************************************************
	 * This function adds a hook where addons can execute js code
	 ************************************************************/
	
	public static function bkap_js() {
		$booking_date = $_POST['booking_date'];
		$post_id = $_POST['post_id'];
		if (isset($_POST['addon_data'])) {
			$addon_data = $_POST['addon_data'];
		}
		else {
			$addon_data = '';
		}
		do_action('bkap_js',$booking_date,$post_id,$addon_data);
		die();
	}
	/************************************************************
	 * This function displays the available lockout for a given 
	 * date for all types of bookings
	 ***********************************************************/
	public static function bkap_get_date_lockout() {
		global $wpdb, $woocommerce;
		
		$product_id = $_POST['post_id'];
		// Booking settings
		$booking_settings = get_post_meta($product_id , 'woocommerce_booking_settings' , true);
		// Checkin/Booking Date
		// Checkin/Booking Date
		$date_formats = bkap_get_book_arrays('date_formats');
		// get the global settings to find the date formats
		$global_settings = json_decode(get_option('woocommerce_booking_global_settings'));
		$date_format_set = $date_formats[$global_settings->booking_date_format];
		
		$date = strtotime( $_POST['checkin_date'] );
		// Checkin/Booking Date
		$check_in_date = date($date_format_set,$date);
		
		$date_check_in = date('Y-m-d', $date);
	
		$available_tickets = 0;
		$unlimited = 'YES';
		// if multiple day booking is enabled then calculate the availability based on the total lockout in the settings
		if ($booking_settings != '' && (isset($booking_settings['booking_enable_multiple_day']) && $booking_settings['booking_enable_multiple_day'] == 'on' )) {
			// Set the default availability to the total lockout value
			$available_tickets = $booking_settings['booking_date_lockout'];
			// Now fetch all the records for the product that have a date range which includes the start date
			$date_query = "SELECT available_booking FROM `".$wpdb->prefix."booking_history`
							WHERE post_id = %d
							AND start_date <= %s
							AND end_date > %s";
			$results_date = $wpdb->get_results($wpdb->prepare($date_query,$product_id,$date_check_in,$date_check_in));
			// If records are found then the availability needs to be subtracted from the total lockout value
			if ($booking_settings['booking_date_lockout'] > 0) {
				$unlimited = 'NO';
				$available_tickets = $booking_settings['booking_date_lockout'] - count($results_date);
			}
		}
		else {
			// Fetch the record for that date from the Booking history table
			$date_query = "SELECT available_booking FROM `".$wpdb->prefix."booking_history`
							WHERE post_id = %d
							AND start_date = %s
							AND status = ''";
			$results_date = $wpdb->get_results($wpdb->prepare($date_query,$product_id,$date_check_in));
			if (isset($results_date) && count($results_date) > 0) {
				// If records are found then the total available will be the total available for each time slot for that date
				// If its only day bookings, then only 1 record will be present, so this will work 
				foreach ($results_date as $key => $value) {
					if ($value->available_booking > 0) {
						$unlimited = 'NO';
						$available_tickets += $value->available_booking;
					}
				}
			}
			// if no record found and multiple day bookings r not enabled then get the base record for that weekday
			else {
				$weekday = date('w',strtotime($date_check_in));
				$booking_weekday = 'booking_weekday_' . $weekday;
				$base_query = "SELECT available_booking FROM `".$wpdb->prefix."booking_history`
								WHERE post_id = %d
								AND weekday = %s
								AND start_date = '0000-00-00'
								AND status = ''";
				$results_base = $wpdb->get_results($wpdb->prepare($base_query,$product_id,$booking_weekday));
				
				if (isset($results_base) && count($results_base) > 0) {
					foreach ($results_base as $key => $value) {
						if ($value->available_booking > 0) {
							$unlimited = 'NO';
							$available_tickets += $value->available_booking;
						}
					}
				}	
			}
		}
	
		// Check if the same product is already present in the cart
		foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
			$product_id_cart = $values['product_id'];
			if ($product_id_cart == $product_id) {
				if (isset($values['booking'])) {
					$booking = $values['booking'];
				}
				$quantity = $values['quantity'];
				if ($booking[0]['hidden_date'] == $check_in_date) {
					if ($available_tickets > 0) {
						$unlimited = 'NO';
						$available_tickets -= $quantity;
					} 	
				}
			}
		}
		
		if ($available_tickets == 0 && $unlimited == 'YES') {
			$available_tickets = "Unlimited ";
		}
	    if( isset($_POST['checkin_date']) && $_POST['checkin_date'] != ''){
		  $message = $available_tickets . bkap_get_book_t('book.available-stock') . $check_in_date;
		}else{
		    $message = __('Please select a date.','woocommerce-booking');
		}
		echo $message;
		die();			
	}
	
	/********************************************************************
	 * This function displays the available bookings for a give time slot
	 *******************************************************************/
	public static function bkap_get_time_lockout() {
		global $wpdb, $woocommerce;
		$product_id = $_POST['post_id'];
		// Booking settings
		$booking_settings = get_post_meta($product_id , 'woocommerce_booking_settings' , true);
		// Checkin/Booking Date
		// Checkin/Booking Date
		$booking_date_in = $_POST['checkin_date'];
		//$booking_date = date('Y-m-d', strtotime($booking_date_in));
		
		$date_formats = bkap_get_book_arrays('date_formats');
		// get the global settings to find the date formats
		$global_settings = json_decode(get_option('woocommerce_booking_global_settings'));
		$date_format_set = $date_formats[$global_settings->booking_date_format];
		
		$date = strtotime( $_POST['checkin_date'] );
		
		// Checkin/Booking Date
		$booking_date = date('Y-m-d', $date);
		$booking_date_disply = date($date_format_set,$date);
	
		$available_tickets = 0;
		$unlimited = 'YES';
		$timeslots = $message = '';
		if (isset($_POST['timeslot_value'])) {
			$timeslots = $_POST['timeslot_value'];
		}
		if ($timeslots != '') {
			// Check if multiple time slots are enabled
			$seperator_pos = strpos($timeslots,",");
			if (isset($seperator_pos) && $seperator_pos != "") {
				$time_slot_array = explode(",",$timeslots);
			}
			else {
				$time_slot_array = array();
				$time_slot_array[] = $timeslots;
			}
			for($i = 0; $i < count($time_slot_array); $i++) {
				// split the time slot into from and to time
				$timeslot_explode = explode('-',$time_slot_array[$i]);
				$from_hrs = date('G:i',strtotime($timeslot_explode[0]));
				$to_hrs = '';
				if (isset($timeslot_explode[1])) {
					$to_hrs = date('G:i',strtotime($timeslot_explode[1]));
				}
				$time_query = "SELECT available_booking FROM `".$wpdb->prefix."booking_history`
								WHERE post_id = %d
								AND start_date = %s
								AND from_time = %s
								AND to_time = %s
								AND status = ''";
				$results_time = $wpdb->get_results($wpdb->prepare($time_query,$product_id,$booking_date,$from_hrs,$to_hrs));
				// If record is found then simply display the available bookings
				if (isset($results_time) && count($results_time) > 0) {
					if ($results_time[0]->available_booking > 0) {
						$unlimited = 'NO';
						$available_tickets = $results_time[0]->available_booking;
					}
				}
				// Else get the base record and the availability for that weekday
				else {
					$weekday = date('w',strtotime($booking_date));
					$booking_weekday = 'booking_weekday_' . $weekday;
					$base_query = "SELECT available_booking FROM `".$wpdb->prefix."booking_history`
									WHERE post_id = %d
									AND weekday = %s
									AND from_time = %s
									AND to_time = %s
									ANd status = ''";
					$results_base = $wpdb->get_results($wpdb->prepare($base_query,$product_id,$booking_weekday,$from_hrs,$to_hrs));
					if (isset($results_base) && count($results_base) > 0) {
						if ($results_base[0]->available_booking > 0) {
							$unlimited = 'NO';
							$available_tickets = $results_base[0]->available_booking;
						}
					}
				}
				// Check if the same product is already present in the cart
				foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
					$product_id_cart = $values['product_id'];
					if ($product_id_cart == $product_id) {
						if (isset($values['booking'])) {
							$booking = $values['booking'];
						}
						$quantity = $values['quantity'];
						if ($booking[0]['time_slot'] == $time_slot_array[$i] && $booking[0]['hidden_date'] == $booking_date_in) {
							if ($available_tickets > 0) {
								$unlimited = 'NO';
								$available_tickets -= $quantity;
							}
						}
					}
				}
				
				if ($available_tickets == 0 && $unlimited == 'YES') {
					$available_tickets = "Unlimited ";
				}
				$message .= $available_tickets . bkap_get_book_t('book.available-stock-time-msg1') . $time_slot_array[$i] . bkap_get_book_t('book.available-stock-time-msg2') . $booking_date_disply . "<br>";
			}
		}
		echo $message;
		die();
	}
	/**********************************
	* This function displays the price calculated on the frontend product page for Multiple day booking feature.
    ******************************************/
			
	public static function bkap_get_per_night_price() {
		global $wpdb,$woocommerce_wpml;
		$product_type = $_POST['product_type'];
		$product_id = $_POST['post_id'];
		$check_in_date = $_POST['checkin_date'];
		$check_out_date = $_POST['current_date'];
		$diff_days = $_POST['diff_days'];
		
		if (isset($_POST['quantity'])) {
			$quantity_grp_str = $_POST['quantity'];
		}
		else {
			$quantity_grp_str = 1;
		}
		
		$variation_id_to_fetch = $_POST[ 'variation_id' ];
		
		if(isset($_POST['currency_selected']) && $_POST['currency_selected'] != '') {
			$currency_selected = $_POST['currency_selected'];
		}
		else {
			$currency_selected = '';
		}
		$checkin_date = date('Y-m-d',strtotime($check_in_date));
		$checkout_date = date('Y-m-d',strtotime($check_out_date));
		// This condition has been put as fixed,variable blocks and the addons are currently not compatible with grouped products.
		// Please remove this condition once that is fixed.
		if ($product_type != 'grouped') {
			do_action("bkap_display_multiple_day_updated_price",$product_id,$product_type,$variation_id_to_fetch,$checkin_date,$checkout_date,$currency_selected);
		}
		$booking_settings = get_post_meta($product_id, 'woocommerce_booking_settings', true);
		
		if ($product_type == 'variable') {
			if ($variation_id_to_fetch != ""){
				$sale_price = get_post_meta( $variation_id_to_fetch, '_sale_price', true);
				if($sale_price == '') {
					$regular_price = get_post_meta( $variation_id_to_fetch, '_regular_price',true);
					echo $regular_price;
				} else {
					echo $sale_price;
				}
			}
			else {
				echo "Please select an option."; 
			}
		} elseif ($product_type == 'simple') {
			$sale_price = get_post_meta( $_POST['post_id'], '_sale_price', true);
			if($sale_price == '') {
				$regular_price = get_post_meta( $_POST['post_id'], '_regular_price',true);
				echo $regular_price;
			} else {
				echo $sale_price;
			}
		}
		elseif ($product_type == 'grouped') {
			$currency_symbol = get_woocommerce_currency_symbol();
			$has_children = $price_str = "";
			$price_arr = array();
			$product = get_product($_POST['post_id']);
			if ($product->has_child()) {
				$has_children = "yes";
				$child_ids = $product->get_children();
			}
			$quantity_array = explode(",",$quantity_grp_str);
			$i = 0;
			foreach ($child_ids as $k => $v) {
				$price = get_post_meta( $v, '_sale_price', true);
				if($price == '') {
					$price = get_post_meta( $v, '_regular_price',true);
				}
				$final_price = $diff_days * $price * $quantity_array[$i];
				$child_product = get_product($v);
				if ( function_exists( 'icl_object_id' ) ) {
					$final_price = apply_filters( 'wcml_formatted_price', $final_price );
				} else {
					$final_price = wc_price( $final_price );
				}
				$price_str .= $child_product->get_title() . ": " . $final_price . "<br>";
				$i++;
			}
			echo $price_str;
		}
		die();
	}
	
	/******************************************************
	* This function adds the booking date selected on the frontend product page for recurring booking method when the date is selected.
    *****************************************************/
	
	public static function bkap_insert_date() {
		global $wpdb;
		$current_date = $_POST['current_date'];
		$date_to_check = date('Y-m-d', strtotime($current_date));
		$day_check = "booking_weekday_".date('w', strtotime($current_date));
		$post_id = $_POST['post_id'];
		$product = get_product($post_id);
		$product_type = $product->product_type;
		// Grouped products compatibility
		if ($product->has_child()) {
			$has_children = "yes";
			$child_ids = $product->get_children();
		}
		
		$check_query = "SELECT * FROM `".$wpdb->prefix."booking_history`
							WHERE start_date= %s
							AND post_id= %d
							AND status = ''
							AND available_booking >= 0";
		$results_check = $wpdb->get_results ( $wpdb->prepare($check_query,$date_to_check,$post_id) );
		if ( !$results_check ) {
			$check_day_query = "SELECT * FROM `".$wpdb->prefix."booking_history`
									WHERE weekday= %s
									AND post_id= %d
									AND start_date='0000-00-00'
									AND status = ''
									AND available_booking > 0";
			$results_day_check = $wpdb->get_results ( $wpdb->prepare($check_day_query,$day_check,$post_id) );	
			if (!$results_day_check) {
				$check_day_query = "SELECT * FROM `".$wpdb->prefix."booking_history`
										WHERE weekday= %s
										AND post_id= %d
										AND start_date='0000-00-00'
										AND status = ''
										AND total_booking = 0 
										AND available_booking = 0";
				$results_day_check = $wpdb->get_results ( $wpdb->prepare($check_day_query,$day_check,$post_id) );	
			}
			foreach ( $results_day_check as $key => $value ) {
				$insert_date = "INSERT INTO `".$wpdb->prefix."booking_history`
										(post_id,weekday,start_date,end_date,from_time,to_time,total_booking,available_booking)
										VALUES (
										'".$post_id."',
										'".$day_check."',
										'".$date_to_check."',
										'0000-00-00',
										'',
										'',
										'".$value->total_booking."',
										'".$value->available_booking."' )";
				$wpdb->query( $insert_date );
				// Grouped products compatibility
				if ($product_type == "grouped") {
					if ($has_children == "yes") {
						foreach ($child_ids as $k => $v) {
				
							$check_day_query = "SELECT * FROM `".$wpdb->prefix."booking_history`
												WHERE weekday= %s
												AND post_id= %d
												AND start_date='0000-00-00'
												AND status = ''
												AND available_booking > 0";
							$results_day_check = $wpdb->get_results ( $wpdb->prepare($check_day_query,$day_check,$v) );
				
							if (!$results_day_check) {
								$check_day_query = "SELECT * FROM `".$wpdb->prefix."booking_history`
													WHERE weekday= %s
													AND post_id= %d
													AND start_date='0000-00-00'
													AND status = ''
													AND total_booking = 0
													AND available_booking = 0";
								$results_day_check = $wpdb->get_results ( $wpdb->prepare($check_day_query,$day_check,$v) );
							}
				
							$insert_date = "INSERT INTO `".$wpdb->prefix."booking_history`
											(post_id,weekday,start_date,end_date,from_time,to_time,total_booking,available_booking)
											VALUES (
											'".$v."',
											'".$day_check."',
											'".$date_to_check."',
											'0000-00-00',
											'',
											'',
											'".$results_day_check[0]->total_booking."',
											'".$results_day_check[0]->available_booking."' )";
							$wpdb->query( $insert_date );
						}
					}
				}
			}
		}
		die();
	}

	/***********************************************
     * This function displays the timeslots for the selected date on the frontend page when Enable time slot is enabled.
     ************************************************/
			
	public static function bkap_check_for_time_slot() {	

		$current_date = $_POST['current_date'];
		$post_id = $_POST['post_id'];
		$time_drop_down = bkap_booking_process::get_time_slot($current_date,$post_id);

		$time_drop_down_array = explode("|",$time_drop_down);

		if(function_exists('icl_t')) {
    		$drop_down = "<label>".__(get_option('book.time-label'), 'woocommerce-booking').": </label><select name='time_slot' id='time_slot' class='time_slot'>";
    		$drop_down .= "<option value=''>".icl_t('woocommerce-booking','choose_a_time',get_option('book.time-select-option'))."</option>";
  		} 
  		else {
      		$drop_down = "<label>".__(get_option('book.time-label'), 'woocommerce-booking').": </label><select name='time_slot' id='time_slot' class='time_slot'>";
      		$drop_down .= "<option value=''>".__(get_option('book.time-select-option'), 'woocommerce-booking' )."</option>";
  		}
		foreach ($time_drop_down_array as $k => $v) {
			if ($v != "") {
				$drop_down .= "<option value'".$v."'>".$v."</option>";
			}
		}
		echo $drop_down;
		die();
	}
	
	/**************************************************************
	 * This function prepares the time slots string to be displayed
	 *************************************************************/
	public static function get_time_slot($current_date,$post_id) {
		global $wpdb;
		$saved_settings = json_decode(get_option('woocommerce_booking_global_settings'));
		// Booking settings
		$booking_settings = get_post_meta($post_id , 'woocommerce_booking_settings' , true);
		if (isset($booking_settings['booking_minimum_number_days']) && $booking_settings['booking_minimum_number_days'] != '') {
			$advance_booking_hrs = $booking_settings['booking_minimum_number_days'];
		}
		if (isset($saved_settings)) {
			$time_format = $saved_settings->booking_time_format;
		} else {
			$time_format = '12';
		}
		$time_format_db_value = 'G:i';
		if ($time_format == '12') {
			$time_format_to_show = 'h:i A';
		} else {
			$time_format_to_show = 'H:i';
		}
		$current_time = current_time( 'timestamp' );
		$today = date("Y-m-d G:i", $current_time);
		$date1 = new DateTime($today);
		
		$date_to_check = date('Y-m-d', strtotime($current_date));
		$day_check = "booking_weekday_".date('w', strtotime($current_date));
		$from_time_db_value = '';
		$from_time_show = '';
		
		$product = get_product($post_id);
		$product_type = $product->product_type;
		// Grouped products compatibility
		if ($product->has_child()) {
			$has_children = "yes";
			$child_ids = $product->get_children();
		}
		
        $drop_down = "";
        // check if there's a record available for the given date and time with availability > 0
        $check_query = "SELECT * FROM `".$wpdb->prefix."booking_history`
        				 WHERE start_date= '".$date_to_check."'
        				AND post_id = '".$post_id."'
        				AND status = ''
        				AND available_booking > 0 ORDER BY STR_TO_DATE(from_time,'%H:%i')
        ";
        $results_check = $wpdb->get_results ($check_query);
		if ( count($results_check) > 0 ) {
			// assume its a recurring weekday record		
			$specific = "N";
			foreach ( $results_check as $key => $value ) {
				// weekday = '', means its a specific date record
				if ($value->weekday == "") {
					$specific = "Y";
					if ($value->from_time != '') {
						$from_time_show = date($time_format_to_show, strtotime($value->from_time));
						$from_time_db_value = date($time_format_db_value, strtotime($value->from_time));
					}
					$include = 'YES';
					$booking_time = $current_date . $from_time_db_value;
					$date2 = new DateTime($booking_time);
						
					$difference = $date2->diff($date1);
					if ($difference->days > 0) {
						$days_in_hour = $difference->h + ($difference->days * 24) ;
						$difference->h = $days_in_hour;
					}
					
					if ($difference->invert == 0 || $difference->h < $advance_booking_hrs) {
						$include = 'NO';
					}
					if ($include == 'YES') {
						$to_time_show = $value->to_time;
						if( $to_time_show != '' ) {
							$to_time_show = date($time_format_to_show, strtotime($value->to_time));
							$to_time_db_value = date($time_format_db_value, strtotime($value->to_time));
							$drop_down .= $from_time_show." - ".$to_time_show."|";
						} else {
							$drop_down .= $from_time_show."|";
						}
					}
				}
			}
			if ($specific == "N") {
				foreach ( $results_check as $key => $value ) {
					if ($value->from_time != '') {
						$from_time_show = date($time_format_to_show, strtotime($value->from_time));
						$from_time_db_value = date($time_format_db_value, strtotime($value->from_time));
					}
					$include = 'YES';
					$booking_time = $current_date . $from_time_db_value;
					$date2 = new DateTime($booking_time);
					
					$difference = $date2->diff($date1);
					if ($difference->days > 0) {
						$days_in_hour = $difference->h + ( $difference->days * 24 ) ;
                        $difference->h = $days_in_hour;
					}
				
					if ($difference->invert == 0 || $difference->h < $advance_booking_hrs) {
						$include = 'NO';
					}
					if ($include == 'YES') {
						$to_time_show = $value->to_time;
						if( $to_time_show != '' ) {
							$to_time_show = date($time_format_to_show, strtotime($value->to_time));
							$to_time_db_value = date($time_format_db_value, strtotime($value->to_time));
							$drop_down .= $from_time_show." - ".$to_time_show."|";
						} else {
							if ($value->from_time != '') {
							$drop_down .= $from_time_show."|";
						}
					}
				}	
			}
			// get all the records using the base record to ensure we include any time slots that might hv been added after the original date record was created
			// This can happen only for recurring weekdays
			$check_day_query = "SELECT * FROM `".$wpdb->prefix."booking_history`
											WHERE weekday= '".$day_check."'
											AND post_id= '".$post_id."'
											AND start_date='0000-00-00'
											AND status = ''
											AND available_booking > 0 ORDER BY STR_TO_DATE(from_time,'%H:%i')";
			$results_day_check = $wpdb->get_results ($check_day_query);
			//remove duplicate time slots that have available booking set to 0
			foreach ($results_day_check as $k => $v) {
				$from_time_qry = date($time_format_db_value, strtotime($v->from_time));
				if ($v->to_time != '') {
					$to_time_qry = date($time_format_db_value, strtotime($v->to_time));
				} else {
					$to_time_qry = "";
				}
				$time_check_query = "SELECT * FROM `".$wpdb->prefix."booking_history`
										WHERE start_date= '".$date_to_check."'
										AND post_id= '".$post_id."'
										AND from_time= '".$from_time_qry."'
										AND to_time= '".$to_time_qry."' 
										AND status = '' ORDER BY STR_TO_DATE(from_time,'%H:%i')";
				$results_time_check = $wpdb->get_results ($time_check_query);
				if (count($results_time_check) > 0) {
					unset($results_day_check[$k]);
				}
			}
			//remove duplicate time slots that have available booking > 0
			foreach ($results_day_check as $k => $v) {
				foreach ($results_check as $key => $value) {
					if ($v->from_time != '' && $v->to_time != '') {
						$from_time_chk = date($time_format_db_value, strtotime($v->from_time));
						if ($value->from_time == $from_time_chk) {
							if ($v->to_time != ''){
								$to_time_chk = date($time_format_db_value, strtotime($v->to_time));
                            }
							if ($value->to_time == $to_time_chk){
								unset($results_day_check[$k]);
                            }
						}
					} else {
						if($v->from_time == $value->from_time) {
							if ($v->to_time == $value->to_time) {
								unset($results_day_check[$k]);
							}
						}
					}
				}
			}
			foreach ( $results_day_check as $key => $value ) {
				if ($value->from_time != '') {
					$from_time_show = date($time_format_to_show, strtotime($value->from_time));
					$from_time_db_value = date($time_format_db_value, strtotime($value->from_time));
				}
				$include = 'YES';
				$booking_time = $current_date . $from_time_db_value;
				$date2 = new DateTime($booking_time);
					
				$difference = $date2->diff($date1);
				if ($difference->days > 0) {
					$days_in_hour = $difference->h + ( $difference->days * 24 ) ;
                    $difference->h = $days_in_hour;
				}
			
				if ($difference->invert == 0 || $difference->h < $advance_booking_hrs) {
					$include = 'NO';
				}
				
				$to_time_show = $value->to_time;
				if ( $to_time_show != '' ) {
					$to_time_show = date($time_format_to_show, strtotime($value->to_time));
					$to_time_db_value = date($time_format_db_value, strtotime($value->to_time));
					if ($include == 'YES') {
						$drop_down .= $from_time_show." - ".$to_time_show."|";
					}
				} else {
					if ($value->from_time != '' && $include == 'YES') {
						$drop_down .= $from_time_show."|";
					}
					$to_time_db_value = '';
				}
				
					$insert_date = "INSERT INTO `".$wpdb->prefix."booking_history`
											(post_id,weekday,start_date,end_date,from_time,to_time,total_booking,available_booking)
											VALUES (
											'".$post_id."',
											'".$day_check."',
											'".$date_to_check."',
											'0000-00-00',
											'".$from_time_db_value."',
											'".$to_time_db_value."',
											'".$value->total_booking."',
											'".$value->available_booking."' )";
					$wpdb->query( $insert_date );
					// Grouped products compatibility
					if ($product_type == "grouped") {
						if ($has_children == "yes") {
							foreach ($child_ids as $k => $v) {
								$check_day_query_child = "SELECT * FROM `".$wpdb->prefix."booking_history`
															WHERE weekday= '".$day_check."'
															AND post_id= '".$v."'
															AND start_date='0000-00-00'
															AND status = ''
															AND available_booking > 0 ORDER BY STR_TO_DATE(from_time,'%H:%i')";
								$results_day_check_child = $wpdb->get_results ($check_day_query_child);
					
								$insert_date = "INSERT INTO `".$wpdb->prefix."booking_history`
												(post_id,weekday,start_date,end_date,from_time,to_time,total_booking,available_booking)
												VALUES (
												'".$v."',
												'".$day_check."',
												'".$date_to_check."',
												'0000-00-00',
												'".$from_time_db_value."',
												'".$to_time_db_value."',
												'".$results_day_check_child[0]->total_booking."',
												'".$results_day_check_child[0]->available_booking."' )";
								$wpdb->query( $insert_date );
							}
						}
					}
				}
			}
		} else {
			$check_day_query = "SELECT * FROM `".$wpdb->prefix."booking_history`
								WHERE weekday= '".$day_check."'
								AND post_id= '".$post_id."'
								AND start_date='0000-00-00'
								AND status = ''
								AND available_booking > 0 ORDER BY STR_TO_DATE(from_time,'%H:%i')";
			$results_day_check = $wpdb->get_results ( $check_day_query );
			// No base record for availability > 0
			if (!$results_day_check) {
			// check if there's a record for the date where unlimited bookings are allowed i.e. total and available = 0
				$check_query = "SELECT * FROM `".$wpdb->prefix."booking_history`
								WHERE start_date= '".$date_to_check."'
								AND post_id= '".$post_id."'
								AND total_booking = 0
								AND available_booking = 0
								AND status = '' ORDER BY STR_TO_DATE(from_time,'%H:%i')
								";
					
				$results_check = $wpdb->get_results( $check_query );
				
				// if record found, then create the dropdown
				if (isset($results_check) && count($results_check) > 0) {
					foreach ( $results_check as $key => $value ) {
						if ($value->from_time != '') {
							$from_time_show = date($time_format_to_show, strtotime($value->from_time));
							$from_time_db_value = date($time_format_db_value, strtotime($value->from_time));
						} else {
							$from_time_show = $from_time_db_value = "";
						}
						$include = 'YES';
						$booking_time = $current_date . $from_time_db_value;
						$date2 = new DateTime($booking_time);
				
						$difference = $date2->diff($date1);
						if ($difference->days > 0) {
							$days_in_hour = $difference->h + ( $difference->days * 24 ) ;
                            $difference->h = $days_in_hour;
						}
							
						if ($difference->invert == 0 || $difference->h < $advance_booking_hrs) {
							$include = 'NO';
						}
						if ($include == 'YES') {
							$to_time_show = $value->to_time;
							if ( $to_time_show != '' ) {
								$to_time_show = date($time_format_to_show, strtotime($value->to_time));
								$to_time_db_value = date($time_format_db_value, strtotime($value->to_time));
								$drop_down .= $from_time_show." - ".$to_time_show."|";
							} else {
								$drop_down .= $from_time_show."|";
								$to_time_show = $to_time_db_value = "";
							}
						}
					}
				} else {
					// else check if there's a base record with unlimited bookings i.e. total and available = 0 
					$check_day_query = "SELECT * FROM `".$wpdb->prefix."booking_history`
										WHERE weekday= '".$day_check."'
										AND post_id= '".$post_id."'
										AND start_date='0000-00-00'
										AND status = ''
										AND total_booking = 0
										AND available_booking = 0 ORDER BY STR_TO_DATE(from_time,'%H:%i')";
					$results_day_check = $wpdb->get_results ($check_day_query);
				}
			}
			if ($results_day_check) {
				foreach ( $results_day_check as $key => $value ) {
					if ($value->from_time != '') {
						$from_time_show = date($time_format_to_show, strtotime($value->from_time));
						$from_time_db_value = date($time_format_db_value, strtotime($value->from_time));
					} else {
						$from_time_show = $from_time_db_value = "";
					}
					$include = 'YES';
					$booking_time = $current_date . $from_time_db_value;
					$date2 = new DateTime($booking_time);
					
					$difference = $date2->diff($date1);
					if ($difference->days > 0) {
						$days_in_hour = $difference->h + ( $difference->days * 24 ) ;
                        $difference->h = $days_in_hour;
					}
				
					if ($difference->invert == 0 || $difference->h < $advance_booking_hrs) {
						$include = 'NO';
					}
					
					$to_time_show = $value->to_time;
					if ( $to_time_show != '' ) {
						$to_time_show = date($time_format_to_show, strtotime($value->to_time));
						$to_time_db_value = date($time_format_db_value, strtotime($value->to_time));
						if ($include == 'YES') {
							$drop_down .= $from_time_show." - ".$to_time_show."|";
						}
					} else  {
						if ($include == 'YES') {
							$drop_down .= $from_time_show."|";
						}
						$to_time_show = $to_time_db_value = "";
					}
					$insert_date = "INSERT INTO `".$wpdb->prefix."booking_history`
											(post_id,weekday,start_date,end_date,from_time,to_time,total_booking,available_booking)
											VALUES (
											'".$post_id."',
											'".$day_check."',
											'".$date_to_check."',
											'0000-00-00',
											'".$from_time_db_value."',
											'".$to_time_db_value."',
											'".$value->total_booking."',
											'".$value->available_booking."' )";
					$wpdb->query( $insert_date );
					// Grouped products compatibility
					if ($product_type == "grouped") {
						if ($has_children == "yes") {
							foreach ($child_ids as $k => $v) {
								$check_day_query_child = "SELECT * FROM `".$wpdb->prefix."booking_history`
															WHERE weekday= '".$day_check."'
															AND post_id= '".$v."'
															AND start_date='0000-00-00'
															AND status = ''
															AND available_booking > 0 ORDER BY STR_TO_DATE(from_time,'%H:%i')";
								$results_day_check_child = $wpdb->get_results ($check_day_query_child);
								$insert_date = "INSERT INTO `".$wpdb->prefix."booking_history`
												(post_id,weekday,start_date,end_date,from_time,to_time,total_booking,available_booking)
												VALUES (
												'".$v."',
												'".$day_check."',
												'".$date_to_check."',
												'0000-00-00',
												'".$from_time_db_value."',
												'".$to_time_db_value."',
												'".$results_day_check_child[0]->total_booking."',
												'".$results_day_check_child[0]->available_booking."' )";
								$wpdb->query( $insert_date );
							}
						}
					}
				}
			}
		}
		return $drop_down;
	}
}
?>