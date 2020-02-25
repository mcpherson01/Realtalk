<?php
/**
 * Rank Math WordPress SEO
 *
 *
 * Integrate with Rank Math WordPress SEO plugin
 *
 * plugin url: https://wordpress.org/plugins/seo-by-rank-math/
 * @since 1.1.2.2
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Code to remove json+ld data
 * 
 * @since 1.1.2.2
 */
add_action( 'rank_math/head', function() {
	global $wp_filter;
	$disable_rank_math = schema_wp_get_option( 'disable_rank_math' );
	if ( $disable_rank_math == 'yes' ) {
		if ( isset( $wp_filter["rank_math/json_ld"] ) ) {
			unset( $wp_filter["rank_math/json_ld"] );
		}
	}
});

add_action( 'admin_init', 'schema_wp_register_settings_rank_math', 1 );
/*
* Register Yoast SEO plugin settings 
*
* @since 1.6.4
*/
function schema_wp_register_settings_rank_math() {
	
	if ( ! class_exists('RankMath') ) return;
	
	add_filter( 'schema_wp_settings_advanced', 'schema_wp_add_advanced_settings_rank_math');
}

/*
* Add Yoast SEO plugin settings 
*
* @since 1.6.4
*/
function schema_wp_add_advanced_settings_rank_math( $settings_advanced ) {

	$settings_advanced['main']['disable_rank_math'] = array(
		'id' => 'disable_rank_math',
		'name' => __( 'Disable Duplicate Features that Rank Math Offers?', 'schema-premium' ),
		'desc' => '',
		'type' => 'select',
		'options' => array(
			'yes'	=> __( 'Yes', 'schema-premium'),
			'no'	=> __( 'No', 'schema-premium')
		),
		'std' => 'yes',
		'tooltip_title' => __('When disabled', 'schema-premium'),
		'tooltip_desc' => __('Rank Math schema.org markup output will be removed.', 'schema-premium'),
	);
	
	return $settings_advanced;
}
