<?php
/*
Plugin Name: PopCash.Net Code Integration Tool
Plugin URI: https://popcash.net/
Description: PopCash.Net Popunder code integration plugin
Version: 1.1
Author: PopCash
Author URI: http://popcash.net/
*/

register_activation_hook(__FILE__,'popcash_net_install'); 
register_deactivation_hook( __FILE__, 'popcash_net_remove' );

function popcash_net_install() {
	add_option("popcash_net_uid", '', '', 'yes');
	add_option("popcash_net_wid", '', '', 'yes');
	add_option("popcash_net_textarea", '', '', 'yes');
	add_option("popcash_net_disabled", '0', '', 'yes');
}

function popcash_net_remove() {
	delete_option('popcash_net_uid');
	delete_option('popcash_net_wid');
	delete_option('popcash_net_textarea');
	delete_option('popcash_net_disabled');
}

function pcit_register_mysettings() {
	register_setting( 'myoption-group', 'popcash_net_uid', 'pcit_uid_validation' );
	register_setting( 'myoption-group', 'popcash_net_wid', 'pcit_wid_validation' );
	register_setting( 'myoption-group2', 'popcash_net_textarea');
	register_setting( 'myoption-group', 'popcash_net_disabled', 'pcit_switch_enabled');
}

function pcit_load_custom_wp_admin_style() {
    wp_register_style( 'pcit_bootstrap', plugins_url( 'assets/bootstrap.min.css', __FILE__ ), false, '' );
    wp_enqueue_style( 'pcit_bootstrap' );

    wp_register_style( 'pcit_bootstrap_theme', plugins_url( 'assets/bootstrap_theme.min.css', __FILE__ ), false, '' );
    wp_enqueue_style( 'pcit_bootstrap_theme' );

    wp_register_script( 'pcit_bootstrap_js', plugins_url( 'assets/bootstrap.min.js', __FILE__ ), false, '' );
    wp_enqueue_script( 'pcit_bootstrap_js' );
}
add_action( 'admin_enqueue_scripts', 'pcit_load_custom_wp_admin_style' );	

if ( is_admin() ){

	add_action('admin_menu', 'pcit_popcash_net_admin_menu');
	add_action( 'admin_init', 'pcit_register_mysettings' );
	add_action('wp_loaded', 'pcit_switch_enabled');

	function pcit_popcash_net_admin_menu() {
		add_menu_page( 'PopCash.Net', 'PopCash.Net', 'administrator', 'popcash-net', 'pcit_popcash_net_publisher_code', 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAxNjAgMTYwIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCAxNjAgMTYwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cGF0aCBmaWxsPSIjMTQ1RThEIiBkPSJNNDMuOCwxMTkuNGMwLjQtMi4zLDE2LjYtMTQuMSwxNy0xMy43YzMuNywzLjcsMTAsOS4xLDE0LjQsMTEuMmMxLjksMC45LDQsMS41LDYuMywxLjljMy4yLDAuNiw2LjYsMC44LDkuNiwwLjZjMi40LTAuMSw0LjUtMC42LDYuMy0xLjJjMi43LTEsNi41LTMuMiw3LjgtNS42YzEuMy0yLjQsMi4xLTQuMywxLjgtOC45Yy0wLjItMy41LTMuMi02LjYtNi44LTkuM2MtMy4yLTIuNC03LjItNC44LTExLjEtNy4xYy0yLTEuMi0zLjktMi40LTUuNy0zLjVjLTEuMi0wLjctMi43LTEuNi00LjQtMi41Yy0xMS44LTYuMS0zMy4zLTE2LjktMzQuNS0zMi43Yy0xLjEtMTQuMiwzLjYtMTksOC4yLTIzLjNjMy43LTMuNCwxMS43LTcuNSwyMi04LjRsLTAuNi05LjZDMzcuNiwxMC4zLDguNyw0MS43LDguNyw4MGMwLDQwLjMsMzEuOSw3Mi45LDcxLjIsNzIuOWMxLjMsMCwyLjYtMC4xLDMuOS0wLjJMODMsMTQwLjZDNjAuNCwxNDAuNCw0My40LDEyMS42LDQzLjgsMTE5LjR6Ii8+PHBhdGggZmlsbD0iIzJEODBCNiIgZD0iTTE1MS4zLDc5LjljMC0zOC43LTI5LjUtNzAuMy02Ni43LTcyLjdsMC42LDkuOGMxNCwxLjksMzEuMiwxNC40LDMxLjIsMTQuNHMtMTMuMiwxNC45LTEzLjcsMTQuOWMtNS4yLTUuNC0xMC4xLTguOS0xNi4zLTEwLjNjLTEuNi0wLjQtMy4zLTAuNi01LjEtMC43Yy0xLjgtMC4xLTMuNCwwLjItNC45LDAuOGMtNy4xLDIuNi0xMS4yLDExLjQtNi4xLDE2LjljMS44LDEuOSw0LjUsMy41LDcuNSw0LjhjMy40LDEuNCw3LjEsMi43LDEwLjEsNC4xbDAsMGMxNi42LDcuNywyOSwxNS4xLDM1LDI3LjJjMS4zLDIuNiwyLjEsNy44LDIuMywxMy4zYzAuMiw2LjgtMC4yLDExLTIuOSwxNy4xYy0xLjMsMi45LTMsNS42LTQuOCw3LjhjLTMuMyw0LTcuNSw2LjgtMTIuNiw5LjJjLTMuMywxLjYtNy4zLDIuNy0xMi4zLDMuM2wwLjcsMTEuNkMxMjYuNCwxNDUuMiwxNTEuMywxMTUuNiwxNTEuMyw3OS45eiIvPjwvc3ZnPg==');
	}
}

$uid = get_option('popcash_net_uid');
$wid = get_option('popcash_net_wid');
$textarea = get_option('popcash_net_textarea');

require ('functions.php');

if (get_option('popcash_net_disabled') == false){
	if ((($uid) != null) && ($wid) != null) {
		add_action( 'wp_footer', 'pcit_add_individual_ids' );
	} elseif (isset($textarea)) {
		add_action( 'wp_footer', 'pcit_add_textarea' );
	}	
}

?>