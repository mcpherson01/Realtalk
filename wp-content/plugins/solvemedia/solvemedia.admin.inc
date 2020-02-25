<?php

/*
 * Copyright (c) 2012 by Solve Media, Inc.
 * Author: Ilia Fishbein
 * Function: Portion of the WordPress plugin related to the administrator panel
 *
 * $Id$
 */

function adcopy_wp_blog_domain() {
	$uri = parse_url( get_settings( 'siteurl' ) );
	return $uri['host'];
}

function adcopy_wp_add_options_to_admin() {
	global $WP_type;

	if ( WORDPRESS_MU == $WP_type && is_site_admin() ) {
	    add_submenu_page( 'wpmu-admin.php', 'Solve Media', 'Solve Media', 'manage_options', __FILE__, 'adcopy_wp_options_subpanel' );
	} elseif ( WORDPRESS_MS == $WP_type && is_super_admin() ) {
	    add_submenu_page( 'settings.php', 'Solve Media', 'Solve Media', 'manage_options', __FILE__, 'adcopy_wp_options_subpanel' );
	}

	add_submenu_page( 'plugins.php', 'Solve Media', 'Solve Media', 'manage_options', __FILE__, 'adcopy_wp_options_subpanel' );
}

function adcopy_wp_options_subpanel() {
	global $WP_type;

	// Check form submission and update options if no error occurred
	if ( isset( $_POST['submit'] ) ) {
	    check_admin_referer( 'adcopy_admin_options', 'adcopy_nonce' );

	    $pattern = '/<.*?>/';
	    $substitute = '';
	    $updated_options = array(
	        'pubkey'              => trim( filter_input( INPUT_POST, 'adcopy_opt_pubkey' ) ),
	        'privkey'             => trim( filter_input( INPUT_POST, 'adcopy_opt_privkey' ) ),
	        'hashkey'             => trim( filter_input( INPUT_POST, 'adcopy_opt_hashkey' ) ),
	        're_bypass'           => filter_input( INPUT_POST, 're_bypass' ),
	        're_bypasslevel'      => filter_input( INPUT_POST, 're_bypasslevel' ),
	        're_theme'            => filter_input( INPUT_POST, 're_theme' ),
	        're_theme_reg'        => filter_input( INPUT_POST, 're_theme_reg' ),
	        're_theme_cf7'        => filter_input( INPUT_POST, 're_theme_cf7' ),
	        're_lang'             => filter_input( INPUT_POST, 're_lang' ),
	        're_tabindex'         => filter_input( INPUT_POST, 're_tabindex' ),
	        're_comments'         => filter_input( INPUT_POST, 're_comments' ),
	        're_registration'     => filter_input( INPUT_POST, 're_registration' ),
	        're_contact_form_7'   => filter_input( INPUT_POST, 're_contact_form_7' ),
	        're_xhtml'            => filter_input( INPUT_POST, 're_xhtml' ),
	        'error_blank'         => filter_input( INPUT_POST, 'error_blank' ),
	        'error_incorrect'     => filter_input( INPUT_POST, 'error_incorrect' ),
	        'error_blank_cf7'     => preg_replace( $pattern, $substitute, filter_input( INPUT_POST, 'error_blank' ) ),
	        'error_incorrect_cf7' => preg_replace( $pattern, $substitute, filter_input( INPUT_POST, 'error_incorrect' ) ),
	        'sm_instr'            => filter_input( INPUT_POST, 'sm_instr' ),
	    );

	    // save updated options
	    if ( WORDPRESS_MU == $WP_type ) {
	        update_site_option( 'adcopy', $updated_options );
		} else {
	        update_option( 'adcopy', $updated_options );
		}
	}

	// Get options
	if ( WORDPRESS_MU == $WP_type ) {
	    $adcopy_opt = get_site_option( 'adcopy' );
	} else {
	    $adcopy_opt = get_option( 'adcopy' );
	}

	// Generic function to generate dropdowns
	function create_select( $name, $options, $selected_value ) {
	    echo '<select name="' . $name . '">' . "\n";

	    foreach ( $options as $text => $value ) {
	        $selected = ($value == $selected_value) ? 'selected="selected"' : '';

	        echo "\t<option value=\"$value\" $selected>$text</option>\n";
	    }

	    echo "</select>\n";
	}

	// Create a dropdown of the types of users who are allowed to bypass the
	// human verification check
	function sm_dropdown_capabilities( $selected ) {
	    $capability_choices = array(
	        'All registered users' => 'read',
	        'Edit posts'           => 'edit_posts',
	        'Publish Posts'        => 'publish_posts',
	        'Moderate Comments'    => 'moderate_comments',
	        'Administer site'      => 'activate_plugins',
	    );

	    create_select( 're_bypasslevel', $capability_choices, $selected );
	}

	// Create a dropdown of the themes our widget supports
	function sm_dropdown_themes( $name, $selected_value ) {
	    $theme_choices = array(
	        'White'  => 'white',
	        'Red'    => 'red',
	        'Black'  => 'black',
	        'Purple' => 'purple',
	    );

	    create_select( $name, $theme_choices, $selected_value );
	}

	// Create a dropdown of the languages
	function sm_dropdown_languages( $selected ) {
	    $lang_choices = array(
	        'English'    => 'en',
	        'Spanish'    => 'es',
	        'French'     => 'fr',
	        'German'     => 'de',
	        'Italian'    => 'it',
	        'Catalan'    => 'ca',
	        'Polish'     => 'pl',
	        'Hungarian'  => 'hu',
	        'Swedish'    => 'sv',
	        'Norwegian'  => 'no',
	        'Portuguese' => 'pt',
	        'Dutch'      => 'nl',
	        'Turkish'    => 'tr',
	        'Japanese'   => 'ja',
	        'Yiddish'    => 'yi',
	    );

	    create_select( 're_lang', $lang_choices, $selected );
	}
?>

<!-- ############################## BEGIN: ADMIN OPTIONS ################### -->
<div class="wrap">
	<h2>Solve Media Options</h2>
	<h3>About Solve Media</h3>
	<p>Solve Media's puzzles offer a free, accessible service that helps block
	    spam on your blog.</p>

	<p>For details, visit the <a href="http://www.solvemedia.com/">Solve Media website</a>.</p>
	<p>
	    <strong>NOTE</strong>: If you are using some form of Cache plugin,
	    you will probably need to flush/clear your cache for changes to take effect.
	</p>

<?php
	$action_url  = $_SERVER['SCRIPT_NAME'] . '?page=';
	$action_url .= plugin_basename( __FILE__ ) . '&updated=true';
?>
	<form name="form1" method="post" action="<?php echo $action_url ?>">
	    <div class="submit">
	        <input type="submit" name="submit"
	            value="<?php _e( 'Update Options' ) ?> &raquo;" />
	     </div>

	     <table class="form-table">
	     <tr valign="top">
	             <th scope="row">Solve Media Keys</th>
	             <td>Solve Media requires a set of API keys, consisting of a
	                 "public", "private", and "hash" key. You can sign up for a
	                 <a href="<?php echo solvemedia_get_signup_url( adcopy_wp_blog_domain(), 'wordpress' ); ?>" target="0">free Solve Media account</a>.
	                 <br />
	                 <p class="re-keys">
	                     <label class="which-key" for="adcopy_opt_pubkey">
	                         Public Key:</label>
	                     <input name="adcopy_opt_pubkey" id="adcopy_opt_pubkey"
	                      size="40" value="<?php echo $adcopy_opt['pubkey']; ?>" />
	                     <br />

	                     <label class="which-key" for="adcopy_opt_privkey">
	                         Private Key:</label>
	                     <input name="adcopy_opt_privkey" id="adcopy_opt_privkey"
	                      size="40" value="<?php echo $adcopy_opt['privkey']; ?>" />
	                     <br />

	                     <label class="which-key" for="adcopy_opt_hashkey">
	                         Hash Key:</label>
	                     <input name="adcopy_opt_hashkey" id="adcopy_opt_hashkey"
	                      size="40" value="<?php echo $adcopy_opt['hashkey']; ?>" />
	                 </p>
	             </td>
	         </tr>
	         <tr valign="top">
	             <th scope="row">Comment Options</th>
	             <td>
	                 <!-- Show widget on the comment post -->
	                 <span style="font-size:larger">
	                     <input type="checkbox" name="re_comments" id="re_comments"
	                      value="1" <?php if ( true == $adcopy_opt['re_comments'] ) { echo 'checked="checked"'; } ?> />
	                      <label for="re_comments">
	                          Enable Solve Media puzzles for comments.
	                      </label>
	                  </span>
	                  <br />

	                  <!-- Allow certain user groups to skip verification -->
	                  <div class="theme-select">
	                       <input type="checkbox" id="re_bypass" name="re_bypass"
	                        <?php if ( true == $adcopy_opt['re_bypass'] ) { echo 'checked="checked"'; } ?>/>
	                       <label name="re_bypass" for="re_bypass">Hide Solve Media
	                           puzzles for <strong>registered</strong> users who can:
	                       </label>
							<?php sm_dropdown_capabilities( $adcopy_opt['re_bypasslevel'] ) ?>
	                  </div>

	                  <!-- The theme selection -->
	                  <div class="theme-select">
	                      <label for="re_theme">Theme:</label>
							<?php sm_dropdown_themes( 're_theme', $adcopy_opt['re_theme'] ) ?>
	                  </div>

	                  <!-- Tab Index -->
	                 <label for="re_tabindex">Tab Index (<em>e.g. WP:
	                     <strong>5</strong>, WPMU: <strong>3</strong></em>):
	                 </label>
	                 <input name="re_tabindex" id="re_tabindex" size="5"
	                     value="<?php  echo $adcopy_opt['re_tabindex']; ?>" />
	                 <br />
	             </td>
	         </tr>
	         <tr valign="top">
	             <th scope="row">Registration Options</th>
	             <td>
	                 <!-- Show widget on the registration page -->
	                 <span style="font-size:larger">
	                     <input type="checkbox" name="re_registration"
	                      id="re_registration" value="1" <?php if ( true == $adcopy_opt['re_registration'] ) { echo 'checked="checked"'; } ?> />
	                     <label for="re_registration">Enable Solve Media puzzles
	                         on registration form.</label>
	                 </span>
	                 <br />

	                 <!-- The theme selection -->
	                 <div class="theme-select">
	                     <label for="re_theme_reg">Theme:</label>
						<?php sm_dropdown_themes( 're_theme_reg', $adcopy_opt['re_theme_reg'] ) ?>
	                 </div>
	             </td>
	         </tr>
	         <tr valign="top">
	             <th scope="row">Contact Form 7 Options</th>
	             <td>
	                 <!-- Show widget on a Contact Form 7 form -->
	                 <span style="font-size:larger">
	                     <input type="checkbox" name="re_contact_form_7"
	                       id="re_contact_form_7" value="1" <?php if ( true == $adcopy_opt['re_contact_form_7'] ) { echo 'checked="checked"'; } ?> />
	                     <label for="re_contact_form_7">Enable Solve Media puzzles
	                         on Contact Form 7 forms.</label>
	                 </span>
	                 <br />

	                 <!-- The theme selection -->
	                <div class="theme-select">
	                    <label for="re_theme_cf7">Theme:</label>
	                    <?php sm_dropdown_themes( 're_theme_cf7', $adcopy_opt['re_theme_cf7'] ) ?>
	                </div>
	            </td>
	        </tr>
	        <tr valign="top">
	        <th scope="row">Error Messages</th>
	            <td>
	                <p>The following are the messages to display when the user does
	                     not enter a CAPTCHA response or enters the incorrect
	                     CAPTCHA response.</p>

	                <p class="re-keys">
	                    <label class="which-key" for="error_blank">No response
	                        entered:</label>
	                    <input name="error_blank" id="error_blank" size="80"
	                        value="<?php echo $adcopy_opt['error_blank']; ?>" />
	                    <br />

	                    <label class="which-key" for="error_incorrect">Incorrect
	                        response entered:</label>
	                    <input name="error_incorrect" id="error_incorrect" size="80"
	                        value="<?php echo $adcopy_opt['error_incorrect']; ?>" />
	                </p>
	            </td>
	        </tr>
	        <tr valign="top">
	        <th scope="row">Instructions</th>
	            <td>
	                <p>The follwing is the message to display above the Solve Media
	                     widget in order to help users</p>

	                <p class="re-keys">
	                    <input name="sm_instr" id="sm_instr" size="80"
	                        value="<?php echo $adcopy_opt['sm_instr']; ?>" />
	                </p>
	            </td>
	        </tr>
	        <tr valign="top">
	        <th scope="row">General Settings</th>
	            <td>
	                <!-- The language selection -->
	                <div class="lang-select">
	                    <label for="re_lang">Language:</label>
	                    <?php sm_dropdown_languages( $adcopy_opt['re_lang'] ) ?>
	                </div>

	                <!-- Whether or not to be XHTML 1.0 Strict compliant -->
	                <input type="checkbox" name="re_xhtml" id="re_xhtml" value="1"
						<?php if ( true == $adcopy_opt['re_xhtml'] ) { echo 'checked="checked"'; } ?> />
	                <label for="re_xhtml">Be XHTML 1.0 Strict compliant.
	                    <strong>Note</strong>: Bad for users who don't have
	                    Javascript enabled in their browser (Majority do).
	                </label>
	                <br />
	            </td>
	        </tr>
	    </table>
	    <div class="submit">
	        <?php wp_nonce_field( 'adcopy_admin_options', 'adcopy_nonce' ); ?>
	        <input type="submit" name="submit"
	            value="<?php _e( 'Update Options' ) ?> &raquo;" />
		</div>
	</form>

	<p class="copyright">&copy; Copyright 2012&nbsp;&nbsp;
	    <a href="http://www.solvemedia.com">Solve Media, Inc.</a>, etal.</p>
</div>
<!-- ############################## END: ADMIN OPTIONS ##################### -->

<?php
}

// Register the admin menu
add_action( 'admin_menu', 'adcopy_wp_add_options_to_admin' );

// Show a warning if the user did not enter the keys
function adcopy_warning() {
	$path = plugin_basename( __FILE__ );
	echo <<<API_KEY_WARNING
	    <div id='adcopy-warning' class='updated fade-ff0000'>
	        <p><strong>The Solve Media plugin is not active.</strong>
	            You must <a href='plugins.php?page=$path'>enter your Solve Media
	            API keys</a> for it to work
	        </p>
	    </div>
	    <style type='text/css'>
	        #adminmenu { margin-bottom: 5em; }
	    </style>
API_KEY_WARNING;
}

// Register the warning
if ( ! ($adcopy_opt ['pubkey'] && $adcopy_opt['privkey'] ) && ! isset( $_POST['submit'] ) ) {
	if ( WORDPRESS_MU == $WP_type && function_exists( 'is_site_admin' ) && is_site_admin() ) {
	    add_action( 'admin_footer', 'adcopy_warning' );
	} elseif ( WORDPRESS_MS != $WP_type ) {
	    if ( version_compare( get_bloginfo( 'version' ), '3.0' ) < 0 ) {
	        add_action( 'admin_footer', 'adcopy_warning' );
		} elseif ( ! function_exists( 'is_site_admin' ) || ! is_network_admin() ) {
	    	add_action( 'admin_footer', 'adcopy_warning' );
		}
	}
}
