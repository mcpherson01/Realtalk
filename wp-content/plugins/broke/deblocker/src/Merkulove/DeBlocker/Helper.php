<?php
/**
 * Most effective way to detect ad blockers. Ask the visitors to disable their ad blockers.
 * Exclusively on Envato Market: https://1.envato.market/deblocker
 *
 * @encoding        UTF-8
 * @version         2.0.2
 * @copyright       Copyright (C) 2018 - 2020 Merkulove ( https://merkulov.design/ ). All rights reserved.
 * @license         Commercial Software
 * @contributors    Alexander Khmelnitskiy (info@alexander.khmelnitskiy.ua), Dmitry Merkulov (dmitry@merkulov.design)
 * @support         help@merkulov.design
 **/

namespace Merkulove\DeBlocker;

use Merkulove\DeBlocker;
use WP_Filesystem_Direct;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Class used to implement work with WordPress filesystem.
 *
 * @since 1.0.0
 * @author Alexandr Khmelnytsky (info@alexander.khmelnitskiy.ua)
 **/
final class Helper {

	/**
	 * The one true Helper.
	 *
	 * @var Helper
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Remove directory with all contents.
	 *
	 * @param $dir - Directory path to remove.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function remove_directory( $dir ) {

		require_once ( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
		require_once ( ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php' );
		$fileSystemDirect = new WP_Filesystem_Direct( false );
		$fileSystemDirect->rmdir( $dir, true );

	}

	/**
	 * Send Action to our remote host.
	 *
	 * @param $action - Action to execute on remote host.
	 * @param $plugin - Plugin slug.
	 * @param $version - Plugin version.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 **/
	public function send_action( $action, $plugin, $version ) {

		$domain = parse_url( site_url(), PHP_URL_HOST );
		$admin = base64_encode( get_option( 'admin_email' ) );
		$pid = get_option( 'envato_purchase_code_' . EnvatoItem::get_instance()->get_id() );

		$ch = curl_init();

		$url = 'https://upd.merkulov.design/wp-content/plugins/mdp-purchase-validator/src/Merkulove/PurchaseValidator/Validate.php?';
		$url .= 'action=' . $action . '&'; // Action.
		$url .= 'plugin=' . $plugin . '&'; // Plugin Name.
		$url .= 'domain=' . $domain . '&'; // Domain Name.
		$url .= 'version=' . $version . '&'; // Plugin version.
		$url .= 'pid=' . $pid . '&'; // Purchase Code.
		$url .= 'admin_e=' . $admin;

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

		curl_exec( $ch );

	}

	/**
	 * Parser function to get formatted headers with response code.
	 *
	 * @param $headers - HTTP response headers.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 **/
	public function parse_headers( $headers ) {
		$head = [];
		foreach( $headers as $k => $v ) {
			$t = explode( ':', $v, 2 );
			if ( isset( $t[1] ) ) {
				$head[ trim($t[0]) ] = trim( $t[1] );
			} else {
				$head[] = $v;
				if ( preg_match( "#HTTP/[0-9\.]+\s+([0-9]+)#",$v, $out ) ) {
					$head['response_code'] = intval($out[1]);
				}
			}
		}

		return $head;
	}

	/**
	 * Start session
	 *
	 * @since  2.0.0
	 * @access public
	 **/
	public static function start_session() {

		if ( ! session_id() ) {

			try {
				session_start();
			} catch ( \Exception $e ) {}

		}

	}

	/**
	 * Obfuscate JS code.
	 *
	 * @param $js
	 *
	 * @since  2.0.0
	 * @access public
	 * @return string
	 **/
	public static function obfuscate( $js ) {

		$hunter = new Obfuscator( $js );

		$parse = parse_url( site_url() );
		$domain_name = $parse['host'];

		$hunter->addDomainName( $domain_name );
		$hunter->setExpiration('+3 day'); // Expires after 3 days

		return $hunter->Obfuscate();

	}

	/**
	 * Return js file and add deblocker scripts.
	 *
	 * @param      $path
	 * @param bool $add
	 *
	 * @since  2.0.0
	 * @access public
	 * @return false|string
	 **/
	public static function get_js_contents( $path, $add = false ) {

		$js = file_get_contents( $path );

		if ( $add ) {
			/** Get Randomized Script. */
			$d_js = require_once 'DeBlockerJS.php';

			$js .= Helper::obfuscate( $d_js );
		}

		return $js;
	}

	/**
	 * Destroy the session
	 *
	 * @since  2.0.0
	 * @access public
	 **/
	public static function end_session() {

		try {
			session_destroy();
		} catch ( \Exception $e ) {}

	}

	/**
	 * Main Helper Instance.
	 *
	 * Insures that only one instance of Helper exists in memory at any one time.
	 *
	 * @static
	 * @return Helper
	 * @since 1.0.0
	 **/
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Helper ) ) {
			self::$instance = new Helper;
		}

		return self::$instance;
	}

} // End Class Helper.
