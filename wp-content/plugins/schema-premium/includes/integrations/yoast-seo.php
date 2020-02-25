<?php
/**
 * Yoast SEO 
 *
 *
 * Integrate with Yoast SEO plugin
 *
 * plugin url: https://wordpress.org/plugins/wordpress-seo/
 * @since 1.5.6
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'wpseo_json_ld_output', 'schema_wp_remove_wpseo_json_ld_output' );
/*
* Remove Structured Data generated by Yoast SEO plugin
* As of the release of Yoast 11.0 on April 16th, 2019
*
* add_filter( 'wpseo_json_ld_output', '__return_false' );
*
* @since 1.1.2.2
*/
function schema_wp_remove_wpseo_json_ld_output(){
	
	$use_yoast_seo_json = schema_wp_get_option( 'use_yoast_seo_json' );
	
	if ( $use_yoast_seo_json == 'yes' ) {
		return false;
	}
}

add_filter( 'wpseo_json_ld_output', 'schema_wp_remove_yoast_json', 10, 1 );
/*
* Remove Yoast SEO plugin JSON-LD output
*
* @since 1.6.4
*/
function schema_wp_remove_yoast_json( $data ){
	
	$use_yoast_seo_json = schema_wp_get_option( 'use_yoast_seo_json' );
	
	if ( $use_yoast_seo_json == 'yes' ) {
		$data = array();
	}
	
	return $data;
}

add_filter( 'wpseo_breadcrumb_output', 'my_wpseo_breadcrumb_output' );
/*
* Remove Yoast SEO plugin breadcrumb markup output
*
* @since 1.6.9.4
*/
function my_wpseo_breadcrumb_output( $output ) {
  	
	$breadcrumbs_enable = schema_wp_get_option( 'breadcrumbs_enable' );
	
	if ( $breadcrumbs_enable ) {
				
		// clean Yoast SEO from RDF markups
		$output = str_replace('xmlns:v="http://rdf.data-vocabulary.org/#"', '', $output); 
		$output = str_replace('typeof="v:Breadcrumb"', '', $output);
		$output = str_replace('rel="v:url"', '', $output);
		$output = str_replace('property="v:title"', '', $output);
		$output = str_replace('rel="v:child"', '', $output);
	}
	
    return $output;
}

add_action( 'admin_init', 'schema_wp_register_settings_yoast_seo', 1 );
/*
* Register Yoast SEO plugin settings 
*
* @since 1.6.4
*/
function schema_wp_register_settings_yoast_seo() {
	
	if ( ! defined('WPSEO_VERSION') ) return;
	
	add_filter( 'schema_wp_settings_advanced', 'schema_wp_add_advanced_settings_yoast_seo');
}

/*
* Add Yoast SEO plugin settings 
*
* @since 1.6.4
*/
function schema_wp_add_advanced_settings_yoast_seo( $settings_advanced ) {

	$settings_advanced['main']['use_yoast_seo_json'] = array(
		'id' => 'use_yoast_seo_json',
		'name' => __( 'Disable Duplicate Features that Yoast SEO Offers?', 'schema-premium' ),
		'desc' => '',
		'type' => 'select',
		'options' => array(
			'yes'	=> __( 'Yes', 'schema-premium'),
			'no'	=> __( 'No', 'schema-premium')
		),
		'std' => 'yes',
		'tooltip_title' => __('When disabled', 'schema-premium'),
		'tooltip_desc' => __('Schema plugin will override Yoast SEO output to avoid markup duplication. Check this box if you would like to disable Schema markup and use Yoast SEO output instead.', 'schema-premium') . '<br /><br />' . __('Features that will be disabled:<br /><ol><li>Organization/Person</li><li>Social Profiles</li><li>Corporate Contacts
</li><li>Breadcrumb</li><li>Sitelink Search Box</li></ol>', 'schema-premium'),
	);
	
	return $settings_advanced;
}

add_filter( 'schema_wp_yoast_knowledge_graph_remove', 'schema_wp_yoast_knowledge_graph_remove' );
/*
* Remove Knowledge Graph
*
* @since 1.5.6
*/
function schema_wp_yoast_knowledge_graph_remove( $knowledge_graph ) {
	
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	
	// Plugin is active ?
	if( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' ) ) {
		
		$use_yoast_seo_json = schema_wp_get_option( 'use_yoast_seo_json' );
		
		if ( $use_yoast_seo_json == 'yes' )
			return; // do nothing!
	}
	
	return $knowledge_graph;
}

//add_filter( 'schema_wp_output_sitelinks_search_box', 'schema_wp_yoast_sitelinks_search_box_remove' );
/*
* Remove SiteLinks & Search Box
*
* @since 1.5.6
*/
/*
function schema_wp_yoast_sitelinks_search_box_remove( $sitelinks_search_box ) {
	// Run only on front page and if Yoast SEO is active
	if ( ! is_front_page() ) return;
	
	$use_yoast_seo_json = schema_wp_get_option( 'use_yoast_seo_json' );
	
	if ( $use_yoast_seo_json == 'yes' && defined('WPSEO_VERSION') ) {
		return; // do nothing!
	}
	
	return $sitelinks_search_box;
}
*/

/* Hook to 'add_meta_boxes' with lower priority. */
add_action( 'add_meta_boxes', 'schema_wp_yoast_remove_wpseo_metabox', 11 );
/**
* Remove WordPress seo meta box.
*
* * @since 1.0.0
*/
function schema_wp_yoast_remove_wpseo_metabox() {
    if ( get_post_type() == 'schema' ) {
        remove_meta_box( 'wpseo_meta', 'schema', 'normal' );
    }
}

add_filter ( 'manage_edit-schema_columns', 'schema_wp_yoast_remove_columns' );
/**
* Remove WordPress SEO columns.
*
* * @since 1.0.0
*/
function schema_wp_yoast_remove_columns( $columns ) {
	
	unset( $columns['wpseo-score'] );
	unset( $columns['wpseo-links'] );
	unset( $columns['wpseo-score-readability'] );
	
    return $columns;
}