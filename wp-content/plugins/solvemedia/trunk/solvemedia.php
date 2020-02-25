<?php
/*
Plugin Name: Solve Media
Plugin URI: http://www.solvemedia.com/
Description: Integrates Solve Media's anti-spam solutions with wordpress
Version: 1.2.3
Author: Ilia Fishbein
Email: support@solvemedia.com
Author URI: http://www.solvemedia.com/
Created: 2009-Jun-23 10:42 (EDT)

Copyright (c) 2010 by Solve Media

$Id$
*/

/* This code is based on code from,
 * and copied, modified and distributed with permission in accordance with its terms:

    Copyright (c) 2008 reCAPTCHA -- http://recaptcha.net
    AUTHORS:
      Mike Crawford
      Ben Maurer
      Jorge Peña

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
*/



// Plugin was initially created by Ben Maurer and Mike Crawford
// Permissions/2.5 transition help from Jeremy Clarke @ http://globalvoicesonline.org

// BEGIN WORDPRESS INSTALLATION TYPE DETECTION
define("WORDPRESS_STD",  1); // Standard WordPress
define("WORDPRESS_MU_O", 2); // WordPress multi-user optional activation
define("WORDPRESS_MU",   3); // WordPress multi-user forced activation
define("WORDPRESS_MS",   4); // WordPress multi-site

$WP_type       = WORDPRESS_STD;
$is_buddypress = false; //WordPress BuddyPress

if (function_exists('is_multisite'))
    if (is_multisite())
        $WP_type = WORDPRESS_MS;

global $wpmu_version;
if (!empty($wpmu_version))
    $WP_type = WORDPRESS_MU_O;

if (basename(dirname(__FILE__)) == 'mu-plugins') // Must Use plugins
    $WP_type = WORDPRESS_MU;

// Buddypress detection
if (function_exists('bp_is_register_page'))
    $is_buddypress = true;
// END WORDPRESS INSTALLATION TYPE DETECTION

// Get the options from the database
if ($WP_type == WORDPRESS_MU)
    $adcopy_opt = get_site_option('adcopy');
else
    $adcopy_opt = get_option('adcopy');

if ( ! defined( 'WP_CONTENT_URL' ) )
    define( 'WP_CONTENT_URL', WP_SITEURL . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
    define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
    define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
if ( ! defined( 'WPMU_PLUGIN_URL' ) )
    define( 'WPMU_PLUGIN_URL', WP_CONTENT_URL. '/mu-plugins' );
if ( ! defined( 'WPMU_PLUGIN_DIR' ) )
    define( 'WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-plugins' );

$wp_plugin_dir = WP_PLUGIN_DIR;
if ($WP_type == WORDPRESS_MU)  {
    $wp_plugin_dir = WPMU_PLUGIN_DIR;
}

$wp_plugin_url = WP_PLUGIN_URL;
if ($WP_type == WORDPRESS_MU)  {
    $wp_plugin_url = WPMU_PLUGIN_URL;
}

require($wp_plugin_dir . '/solvemedia/solvemedialib.php');
require($wp_plugin_dir . '/solvemedia/solvemedia.cf7.inc');
require($wp_plugin_dir . '/solvemedia/solvemedia.admin.inc');
require($wp_plugin_dir . '/solvemedia/solvemedia.reg.inc');
require($wp_plugin_dir . '/solvemedia/solvemedia.comment.inc');

// doesn't need to be secret, just shouldn't be used by any other code.
define ("ADCOPY_WP_HASH_SALT", "2bfaec807a2401880a33b18956663057");


/*  =============================================================================
    CSS - This links the pages to the stylesheet to be properly styled
    ============================================================================= */

function solve_css() {
    global $WP_type, $wp_version;

    $path = WP_PLUGIN_URL . '/solvemedia/solvemedia.css';

    if ($WP_type == WORDPRESS_MU)
        $path = WPMU_PLUGIN_URL . '/solvemedia/solvemedia.css';

    wp_enqueue_style('solvemedia_stylesheet', $path);

    if ($wp_version[0] > 2) {
        echo '<style>#adcopy-puzzle-image img {width: 100%; height: 100%}</style>';
    }
}

// include the stylesheet in typical pages to style in comment section
add_action('wp_head', 'solve_css');

// include stylesheet to style options page
add_action('admin_head', 'solve_css');

/*  =============================================================================
    End CSS
    ============================================================================= */

// If the plugin is deactivated, delete the preferences
function delete_solve_preferences() {
    global $WP_type;

    if ($WP_type == WORDPRESS_MU)
        delete_site_option('adcopy');
    else
        delete_option('adcopy');
}

register_deactivation_hook(__FILE__, 'delete_solve_preferences');


/*  =============================================================================
    Plugin Default Options
    ============================================================================= */

$option_defaults = array (
    'pubkey'              => '', // public key
    'privkey'             => '', // private key
    'hashkey'             => '', // hash key
    're_bypass'           => '', // allow certain users to skip verification
    're_bypasslevel'      => '', // user capabilities required to skip verification
    're_theme'            => 'white', // theme on the comment form
    're_theme_reg'        => 'white', // theme on the registration form
    're_theme_cf7'        => 'white', // theme on a Contact Form 7 form
    're_lang'             => 'en', // language on the widget
    're_tabindex'         => '5', // tabindex for the response field
    're_comments'         => '1', // show widget on the comment form
    're_registration'     => '1', // show widget on the registration page
    're_contact_form_7'   => '1', // show solvemedia on the comment post
    're_xhtml'            => '0', // XHTML 1.0 Strict compliant
    'error_blank'         => "<strong>ERROR</strong>: Please enter a response to the Solve Media puzzle.", // the message to display when the user enters no response
    'error_incorrect'     => '<strong>ERROR</strong>: That response to the Solve Media puzzle was incorrect.', // the message to display when the user enters an incorrect response
    'error_blank_cf7'     => "ERROR: Please enter a response to the Solve Media puzzle.", // the message to display when the user enters no response in a Contact Form 7 form
    'error_incorrect_cf7' => 'ERROR: That response to the Solve Media puzzle was incorrect.', // the message to display when the user enters an incorrect CAPTCHA response in a Contact Form 7 form
    'sm_instr'            => 'Human Verification: In order to verify that you are a human and not a spam bot, please enter the answer into the following box below based on the instructions contained in the graphic.', // Instructions to display above widget
);

// install the defaults
if ($WP_type == WORDPRESS_MU)
    add_site_option('adcopy', $option_defaults);
else
    add_option('adcopy', $option_defaults);

/*  =============================================================================
    End solvemedia Plugin Default Options
    ============================================================================= */

// Returns markup / Javascript to display widget
function solvemedia_wp_get_html ($error, $theme) {
    global $adcopy_opt;

    $options = <<<OPTIONS
        <script type="text/javascript">
            var ACPuzzleOptions = { theme : '$theme',
                                    lang : '{$adcopy_opt['re_lang']}',
                                    tabindex : '{$adcopy_opt['re_tabindex']}' };
        </script>
OPTIONS;

    $use_ssl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on");

    $html  = $options;
    $html .= '<p>' . $adcopy_opt['sm_instr'] . '</p>';
    $html .= solvemedia_get_html($adcopy_opt['pubkey'], $error, $use_ssl, $adcopy_opt['re_xhtml']);

    return $html;
}

// Check response to widget
function solvemedia_wp_check_answer() {
    global $adcopy_opt;

    $challenge = $_POST['adcopy_challenge'];
    $response = $_POST['adcopy_response'];
    $resp = solvemedia_check_answer ($adcopy_opt ['privkey'],
                                     $_SERVER['REMOTE_ADDR'],
                                     $challenge,
                                     $response,
                                     $adcopy_opt['hashkey'] );

    return $resp;
}

?>
