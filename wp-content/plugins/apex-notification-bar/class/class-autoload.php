<?php
defined('ABSPATH') or die("No script kiddies please!");
//function edn_get_api() {
//    return get_api();
//}

function apexnb_ednmc_get_options( $key = '' ) {
	static $defaults;
	if( is_null( $defaults ) ) {
		$email_label = __( 'Email address', APEXNB_TD );
		$email_placeholder = __( 'Your email address', APEXNB_TD );
		$signup_button = __( 'Sign up', APEXNB_TD );

		$defaults = array(
			'general' => array(
				'edn_mailcimp_api' => '',
			),
			'form' => array(
				'css' => 'default',
				'markup' => "<p>\n\t<label>{$email_label}: </label>\n\t<input type=\"email\" name=\"edn_mailchimp_email\" placeholder=\"{$email_placeholder}\" required />\n</p>\n\n<p>\n\t<input type=\"submit\" value=\"{$signup_button}\" />\n</p>",
				'text_subscribed' => __( 'Thank you, your sign-up request was successful! Please check your e-mail inbox.', APEXNB_TD ),
				'text_error' => __( 'Oops. Something went wrong. Please try again later.', APEXNB_TD ),
				'text_invalid_email' => __( 'Please provide a valid email address.', APEXNB_TD ),
				'text_already_subscribed' => __( 'Given email address is already subscribed, thank you!', APEXNB_TD ),
				'text_invalid_captcha' => __( 'Please complete the CAPTCHA.', APEXNB_TD ),
				'text_required_field_missing' => __( 'Please fill in the required fields.', APEXNB_TD ),
				'text_unsubscribed' => __( 'You were successfully unsubscribed.', APEXNB_TD ),
				'text_not_subscribed' => __( 'Given email address is not subscribed.', APEXNB_TD ),
				'redirect' => '',
				'lists' => array(),
				'hide_after_success' => 0,
				'double_optin' => 1,
				'update_existing' => 0,
				'replace_interests' => 1,
				'send_welcome' => 0,
			),
		);
	}
    $db_keys_option_keys = array(
		'edn_api_key' => 'general',
		'edn_lite_form' => 'form',
	);

	$options = array();
	foreach ( $db_keys_option_keys as $db_key => $option_key ) {
		$option = (array) get_option( $db_key, array() );

		$options[$option_key] = array_merge( $defaults[$option_key], $option );
	}
	
	
	if( '' !== $key ) {
		return $options[$key];
	}

	return $options;

}
//print_r(ednmc_get_options());
require('class-api.php');
require('class-plugin.php');
require('class-mailchimp.php');
require('twitteroauth.php');



/* constant contact */
require('edn_cct_library/ConstantContact.php');

/**
* Gets the MailChimp for WP API class and injects it with the given API key
* @since 1.0
* @return MC4WP_API
*/
function apexnb_edn_get_api() {
	return apexnb_get_api();
}
