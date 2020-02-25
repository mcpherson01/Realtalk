<?php

/*
 * Copyright (c) 2012 by Solve Media, Inc.
 * Author: Ilia Fishbein
 * Function: Portion of the WordPress plugin related to registration
 *
 * $Id$
 */

// Modify styling of the standard WordPress registration panel
function solve_reg_css() {
	global $adcopy_opt, $is_buddypress;

	if ( $adcopy_opt['re_registration'] && ! $is_buddypress ) {
		$width = 358;
		echo <<<REGISTRATION
            <style type="text/css">
                #login {
                    width: {$width}px !important;
                }

                #login a {
                    text-align: center;
                }

                #nav {
                    text-align: center;
                }

                form .submit {
                    margin-top: 10px;
                }
            </style>
REGISTRATION;
	}
}

// include the login div styling, embedded
add_action( 'login_head', 'solve_reg_css' );

function display_puzzle_wpmu( $errors ) {
	global $adcopy_opt;

	$theme = $adcopy_opt['re_theme_reg'];
	$error = $errors->get_error_message( 'captcha' );
	$html = '<label for="verification">Verification:</label>';

	if ( $error ) {
		$html .= '<p class="error">' . $error . '</p>';
	}

	$html .= solvemedia_wp_get_html( $error, $theme );

	echo $html;
}

function display_puzzle_bp() {
	global $adcopy_opt, $bp;

	$theme = $adcopy_opt['re_theme_reg'];
	$error = '';

	if ( $bp ) {
		$error = $bp->signup->errors['captcha'];
	}

	$html = solvemedia_wp_get_html( $error, $theme );
	$html = <<<HTML
        <br style="clear:both;" /><br/>
	    $html
        <p class="error">$error</p>
        <hr style="clear: both; margin-bottom: 0; border: 0; border-bottom: 1px solid #999;" />
HTML;

	echo $html;
}

function display_puzzle_wp() {
	global $adcopy_opt;

	$error = $_GET['rerror'];
	$theme = $adcopy_opt['re_theme_reg'];
	$html  = '<hr style="clear: both; margin-bottom: 1.5em; border: 0; border-top: 1px solid #999; height: 1px;" />';

	$html .= solvemedia_wp_get_html( $error, $theme );

	echo $html;
}

// Hook the display_puzzle_ functions for registration into WordPress
if ( $adcopy_opt['re_registration'] ) {
	if ( $is_buddypress ) {
		add_action( 'bp_before_registration_submit_buttons', 'display_puzzle_bp' );
	} elseif ( WORDPRESS_MS == $WP_type || WORDPRESS_MU == $WP_type || WORDPRESS_MU_O == $WP_type ) {
		add_action( 'signup_extra_fields', 'display_puzzle_wpmu' );
	} else {
		add_action( 'register_form', 'display_puzzle_wp' );
	}
}

// Check the response to the puzzle
function check_reg_resp( $result ) {
	global $adcopy_opt, $errors, $bp;

	if ( ! isset( $_POST['adcopy_response'] ) || empty( $_POST['adcopy_response'] ) ) {
		if ( version_compare( get_bloginfo( 'version' ), '2.5' ) < 0 ) {
			$errors['blank_captcha'] = $adcopy_opt['error_blank'];
		} elseif ( $bp ) {
			$bp->signup->errors['captcha'] = $adcopy_opt['error_blank'];
		} else {
			$result->add( 'blank_captcha', $adcopy_opt['error_blank'] );
		}
	} else {
		$response = solvemedia_wp_check_answer();

		if ( ! $response->is_valid ) {
			if ( version_compare( get_bloginfo( 'version' ), '2.5' ) < 0 ) {
				$errors['captcha_wrong'] = $adcopy_opt['error_incorrect'];
			} elseif ( $bp ) {
				$bp->signup->errors['captcha'] = $adcopy_opt['error_incorrect'];
			} else {
				$result->add( 'captcha_wrong', $adcopy_opt['error_incorrect'] );
			}
		}
	}

	if ( version_compare( get_bloginfo( 'version' ), '2.5' ) >= 0 && ! $bp ) {
		return $result;
	}
}

// Check the response on WordPress MU
function check_reg_resp_wpmu( $result ) {
	global $_POST, $adcopy_opt, $bp;

	// The admin panel calls this function when a new user is created in the admin
	// interface. Ignore that call.
	if ( ! is_admin() ) {
		// It's blogname in 2.6, blog_id prior to that
		if ( isset( $_POST['blog_id'] ) || isset( $_POST['blogname'] ) ) {
			return $result;
		}

		// no text entered
		if ( empty( $_POST['adcopy_response'] ) || '' == $_POST['adcopy_response'] ) {
			if ( $bp ) {
				$bp->signup->errors['captcha'] = $adcopy_opt['error_blank'];
			} else {
				$result['errors']->add( 'captcha', $adcopy_opt['error_blank'] );
			}

			return $result;
		}

		$response = solvemedia_wp_check_answer();

		// incorrect response
		if ( ! $response->is_valid ) {
			if ( $bp ) {
				$bp->signup->errors['captcha'] = $adcopy_opt['error_incorrect'];
			} else {
				$result['errors']->add( 'captcha', $adcopy_opt['error_incorrect'] );
			}
		}
	}

	return $result;
}

if ( $adcopy_opt['re_registration'] ) {
	if ( WORDPRESS_MS == $WP_type || WORDPRESS_MU == $WP_type || WORDPRESS_MU_O == $WP_type ) {
		if ( $is_buddypress ) {
			add_action( 'bp_signup_validate', 'check_reg_resp_wpmu' );
		} else {
			add_filter( 'wpmu_validate_user_signup', 'check_reg_resp_wpmu' );
		}
	} else {
		if ( $is_buddypress ) {
			add_action( 'bp_signup_validate', 'check_reg_resp' );
		} else {
			add_filter( 'registration_errors', 'check_reg_resp' );
		}
	}
}
