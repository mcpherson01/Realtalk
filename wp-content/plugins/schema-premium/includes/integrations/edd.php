<?php
/**
 * Easy Digital Downloads (EDD)
 *
 *
 * Integrate with EDD plugin
 *
 * plugin url: https://wordpress.org/plugins/easy-digital-downloads/
 * @since 1.6.9.8
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

//add_filter( 'schema_wp_breadcrumb_enabled', 'schema_wp_breadcrumb_edd_product_disable' );
/*
* Disable breadcrumbs on WooCommerce 
*
* @since 1.6.9.5
*/
function schema_wp_breadcrumb_edd_product_disable( $breadcrumb_enabled ){
	
	if ( function_exists( 'edd_add_schema_microdata' ) ) { 
		if ( edd_add_schema_microdata() ) return false;
	}
	return true;
}

add_action( 'schema_wp_action_post_type_archive', 'schema_wp_edd_add_schema_microdata_disable' );

/*
* Disable EDD Product markup output , it's hook to the post type archive function
*
* @since 1.6.9.8
*/
function schema_wp_edd_add_schema_microdata_disable() {
	
	if ( function_exists( 'edd_add_schema_microdata' ) ) { 
		add_filter( 'edd_add_schema_microdata', '__return_false' );
	}
}

// Mostly, we don't need this since we cached meta keys array
add_filter( 'schema_premium_admin_post_types_extras', 'schema_premium_edd_remove_post_types_extras' );
/*
* Remoove EDD post types extras 
*
* @since 1.1.1
*/
function schema_premium_edd_remove_post_types_extras( $post_types ) {
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
	if ( is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ) ) {
		
		unset($post_types['edd_log']);
		unset($post_types['edd_payment']);
		unset($post_types['edd_discount']);
		unset($post_types['edd_license']); 
		unset($post_types['edd_license_log']); 
	}
	
	return $post_types;
}
