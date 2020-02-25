<?php
/**
 * @package Schema Premium - Extension : sameAs
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter('schema_output', 				'schema_wp_types_sameAs_markup_output');
add_filter('schema_output_blog_post', 		'schema_wp_types_sameAs_markup_output');
add_filter('schema_output_category_post', 	'schema_wp_types_sameAs_markup_output');
/**
 * Output Markup
 *
 * @since 1.0.0
 */
function schema_wp_types_sameAs_markup_output( $schema ) {
	
	global $post;
	
	if ( empty($schema) ) return;
	
	$sameAs = schema_wp_types_get_sameAs();
	
	if ( ! empty( $sameAs ) )
		$schema['sameAs'] = $sameAs;
	
	return $schema;
}

/**
 * Get sameAs 
 *
 * @since 1.0.0
 *
 * return array
 */
function schema_wp_types_get_sameAs() {
	
	$sameAs = array();
	
	// check if the repeater field has rows of data
	if( have_rows('field_schema_sameAs_repeater', get_the_ID() ) ):
		
		// loop through the rows of data
    	while ( have_rows('field_schema_sameAs_repeater', get_the_ID() ) ) : the_row();

        	// display a sub field value
        	$sameAs[] = get_sub_field('feild_schema_sameAs_url');

    	endwhile;

	else :

    	// no rows found

	endif;
	
	return $sameAs;
}

add_action( 'acf/init', 'schema_wp_types_acf_field_sameAs' );
/**
 * Meta Box
 *
 * @since 1.0
 */
function schema_wp_types_acf_field_sameAs() {

	if( function_exists('acf_add_local_field_group') ):

		// ACF Group: sameAs
		//
		//
		acf_add_local_field_group(array (
			'key' => 'group_schema_sameAs',
			'title' => __('sameAs', 'schema-premium'),
			'location' => array (
				array (
					array (	 // custom location
						'param' => 'is_schema',
						'operator' => '==',
						'value' => 'true',
					),
					array ( // Exclude from schema post type
						'param' => 'post_type',
						'operator' => '!=',
						'value' => 'schema',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));
				
		// Repeater
		// 
		// sameAs repeater
		acf_add_local_field( array(
			'key'          => 'field_schema_sameAs_repeater',
			'label'        => '',
			'name'         => 'schema_sameAs_repeater',
			'type'         => 'repeater',
			'parent'       => 'group_schema_sameAs',
			'instructions' => __('URL of a reference Web page that unambiguously indicates the item\'s identity. E.g. the URL of the item\'s Wikipedia page, Wikidata entry, or official website.', 'schema-wp-types'),
			'layout' 	   => 'table',
			'button_label' => __('Add URL', 'schema-wp-types'),
		) );
		
		// Sub Repeater
		// 
		// sameAs repeater
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_sameAs_url',
			'label' 	=> 'Sub Title',
			'name' 		=> 'schema_sameAs_url',
			'type' 		=> 'url',
			'parent' 	=> 'field_schema_sameAs_repeater',
			'default_value' => '',
			'placeholder' => 'https://',
		));
		
	endif;
}
