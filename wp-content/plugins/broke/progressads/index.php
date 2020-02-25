<?php
/*
Plugin Name: Progress Ads
Plugin URI: https://premium.divcoder.com/
Description: Increase your advertising earnings without losing your visitors.
Author: Divcoder
Version: 1.0.0
Author URI: https://premium.divcoder.com/progressads
Authoras URI: https://premium.divcoder.com/progressads
Domain Path: /languages
*/

if ( !function_exists( 'add_action' ) ) {
    exit;
}

//Plugin DIR URL
define( 'DCPA_URL', plugin_dir_url( __FILE__ ) );
//Plugin DIR Path
define( 'DCPA_DIR', plugin_dir_path( __FILE__ ) );

//Admin Styles
add_action( 'admin_init', 'DCPA_echo_css' );

function DCPA_echo_css() {
	//Add CSS Style for Admin Panel
   wp_enqueue_style( 'DCPA-style', DCPA_URL."admin/assets/css/style.css", array(), "1.0.0" );
}

/*
* Load Admin Settings
*/
include DCPA_DIR ."admin/index.php";

/*
* Load Functions
*/
include DCPA_DIR ."functions/DCPA-functions.php";

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function DCPA_language() {
  load_plugin_textdomain( 'DCPA-plugin', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}

//Load Plugin Functions
add_action( 'plugins_loaded', 'DCPA_language' );

/*
* Default Options for Plugin
*/
function DCPA_activation() {

	add_option("DCPA_start","0");
	add_option("DCPA_show","0");
	add_option("DCPA_showPop","0");
	add_option("DCPA_logged_prog","0");
	add_option("DCPA_logged_modal","0");
	add_option("DCPA_progressHeight","8");
	add_option("DCPA_enable_home","0");
	add_option("DCPA_enable_archives","0");
	add_option("DCPA_enable_search","0");
	add_option("DCPA_enable_404","0");
	add_option("DCPA_customedit","");
	add_option("DCPA_progressColor","#dd3333");
	add_option("DCPA_pbBack","#d2d2d2");
	add_option("DCPA_progressColorAd","#eff700");
	add_option("DCPA_adBackground","#fff");
	add_option("DCPA_closerButton","#000");
	add_option("DCPA_closerTextButton","#fff");
	add_option("DCPA_closerType","1");
	add_option("DCPA_progType","1");
	add_option("DCPA_skipType","1");
	add_option("DCPA_cdButton","5");
	add_option("DCPA_removProg","0");
	add_option("DCPA_cdText","Skip Ad >");
	add_option("DCPA_modalPlace","30");
	add_option("DCPA_progSty","1");
	add_option("DCPA_remaininText","seconds remaining");
	add_option("DCPA_standText","Please wait...");
	add_option("DCPA_modalFreq","");
	add_option("DCPA_customPosts","array()");
	
}

//Register Options
register_activation_hook( __FILE__, 'DCPA_activation' );

// Plugin WP-Admin Settings Text
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'DCPA_plugin_page');

function DCPA_plugin_page( $links ) {
    $links[] = '<a href="' . admin_url( 'admin.php?page=DCPA_plugin_dashboard' ) . '">' . __("Settings", "DCPA-plugin") . '</a>';
    return $links;
}