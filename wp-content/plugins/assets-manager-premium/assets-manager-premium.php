<?php
/**
 * Plugin Name: Webcraftic Assets manager Premium
 * Plugin URI: https://clearfy.pro/assets-manager/
 * Description: Advanced functions for plugin Assets manager
 * Author: Webcraftic <wordpress.webraftic@gmail.com>
 * Version: 1.1.1
 * Text Domain: gonzales
 * Domain Path: /languages/
 * Author URI: https://clearfy.pro
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wgnzp_premium_load' ) ) {
	function wgnzp_premium_load() {
		if ( ! defined( 'WGZ_PLUGIN_ACTIVE' ) || defined( 'WGZ_PLUGIN_THROW_ERROR' ) ) {
			return;
		}

		if ( version_compare( WCL_PLUGIN_VERSION, '1.6.1', '<' ) ) {
			return;
		}

		// Устанавливаем контстанту, что плагин уже используется
		define( 'WGZP_PLUGIN_ACTIVE', true );

		// Устанавливаем контстанту, что плагин уже используется
		define( 'WGZP_PLUGIN_VERSION', '1.1.1' );

		// Директория плагина
		define( 'WGZP_PLUGIN_DIR', dirname( __FILE__ ) );

		// Относительный путь к плагину
		define( 'WGZP_PLUGIN_BASE', plugin_basename( __FILE__ ) );

		// Ссылка к директории плагина
		define( 'WGZP_PLUGIN_URL', plugins_url( null, __FILE__ ) );

		// Global scripts
		// ---------------------------------------------------------
		require( WGZP_PLUGIN_DIR . '/includes/class-configurate-assets.php' );
		new WGNZP_Config_Assets_Manager( WGZ_Plugin::app() );
	}

	add_action( 'plugins_loaded', 'wgnzp_premium_load', 20 );

	/**
	 * Function is performed when the parent plugin Robin image optimizer is activated.
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.0.4
	 */
	function wgnzp_premium_activate() {
	}

	/**
	 * Function is performed when the parent plugin Robin image optimizer is deactivated.
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.0.4
	 */
	function wgnzp_premium_deactivate() {
	}
}