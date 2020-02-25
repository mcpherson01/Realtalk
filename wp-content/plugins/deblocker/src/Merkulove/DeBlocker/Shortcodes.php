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

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

use Merkulove\DeBlocker as DeBlocker;

/**
 * SINGLETON: Class used to implement shortcodes.
 *
 * @since 1.0.0
 * @author Alexandr Khmelnytsky (info@alexander.khmelnitskiy.ua)
 **/
final class Shortcodes {

	/**
	 * The one true Shortcodes.
	 *
	 * @var Shortcodes
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Sets up a new Shortcodes instance.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	private function __construct() {

		/** Initializes plugin shortcodes. */
		add_action( 'init', [$this, 'shortcodes_init'] );


	}

	/**
	 * Initializes shortcodes.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 **/
	public function shortcodes_init() {

		/** Add shortcode [disable_deblocker] */
		add_shortcode( 'disable_deblocker', [ $this, 'disable_deblocker_shortcode' ] );

	}

	/**
	 * Shortcode to disable plugin for certain pages.
	 * Use [disable_deblocker].
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function disable_deblocker_shortcode() {

		wp_enqueue_script( 'mdp-deblocker-destroyer', DeBlocker::$url . 'js/deblocker-destroyer' . DeBlocker::$suffix . '.js', [], DeBlocker::$version, true );

		return;
	}

	/**
	 * Main Shortcodes Instance.
	 *
	 * Insures that only one instance of Shortcodes exists in memory at any one time.
	 *
	 * @static
	 * @return Shortcodes
	 * @since 1.0.0
	 **/
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Shortcodes ) ) {
			self::$instance = new Shortcodes;
		}

		return self::$instance;
	}

} // End Class Shortcodes.
