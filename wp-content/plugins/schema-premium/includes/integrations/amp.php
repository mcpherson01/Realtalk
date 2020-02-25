<?php
/**
 * AMP plugin integration
 *
 *
 * plugin url: https://wordpress.org/plugins/amp/
 * @since 1.3
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'amp_post_template_metadata', 'schema_premium_amp_remove_markup', 10, 2 );
/**
 * Remove AMP schema.org markup
 *
 * @since 1.1.2.3
 */
function schema_premium_amp_remove_markup( $metadata, $post ) {
	return;
}

add_action( 'amp_post_template_head', 'schema_premium_amp_markup_output', 20 );
/**
 * Output the generated schema.org markup type on enabled AMP posts
 *
 * @since 1.1.2.3
 */
function schema_premium_amp_markup_output() {

	global $post;

	if ( ! isset($post->ID) || ! is_singular() )
		return;

	$json = array();

	// Get AMP plugin settings
	$options = get_option('amp-options');
	
	// Check if this is the About, Contact page, or Checkout page
	// If so, get the correct schema,org markup
	//
	if ( is_array($options['supported_post_types']) ) {
		
		if ( in_array("page", $options['supported_post_types']) ) {
		
			$about_page_id 	 	= schema_wp_get_option( 'about_page' );
			$contact_page_id 	= schema_wp_get_option( 'contact_page' );
			$checkout_page_id	= schema_wp_get_option( 'checkout_page' );
	
			if ( isset($about_page_id) && $post->ID == $about_page_id ) {
				if ( class_exists('Schema_WP_SpecialPage_AboutPage') ) {
					$schema_about_page = new Schema_WP_SpecialPage_AboutPage;  
					//$json = $schema_about_page->get_markup();
					$schema_about_page->output_markup();
					return;
				}
			}  
			if ( isset($contact_page_id) && $post->ID == $contact_page_id) {
				if ( class_exists('Schema_WP_ContactPage') ) {
					$schema_contact_page = new Schema_WP_ContactPage;  
					//$json = $schema_contact_page->get_markup();
					$schema_contact_page->output_markup();
					return;
				}
			}	
			if ( isset($checkout_page_id) && $post->ID == $checkout_page_id) {
				if ( class_exists('Schema_WP_SpecialPage_CheckoutPage') ) {
					$schema_checkout_page = new Schema_WP_SpecialPage_CheckoutPage;  
					//$json = $schema_checkout_page->get_markup();
					$schema_checkout_page->output_markup();
					return;
				}
			}
			
		} // end if
	} // end if
	
	// Output the enabled schema.org markup type for this content
	$schema = new Schema_WP_Output();
	$schema->do_schema();
}
