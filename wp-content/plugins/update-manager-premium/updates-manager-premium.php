<?php
/**
 * Plugin Name: Webcraftic Updates manager Premium
 * Plugin URI: https://clearfy.pro/update-manager/
 * Description: Advanced functions for plugin Update manager
 * Author: Webcraftic <wordpress.webraftic@gmail.com>
 * Version: 1.1.0
 * Text Domain: webcraftic-updates-manager-premium
 * Domain Path: /languages/
 * Author URI: https://clearfy.pro
 */

// Выход при непосредственном доступе
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wupmp_premium_load' ) ) {
	function wupmp_premium_load() {

		if ( ! defined( 'WUPM_PLUGIN_ACTIVE' ) || defined( 'WUPM_PLUGIN_THROW_ERROR' ) ) {
			return;
		}

		if ( version_compare( WCL_PLUGIN_VERSION, '1.6.1', '<' ) ) {
			return;
		}

		// Устанавливаем контстанту, что плагин уже используется
		define( 'WUPMP_PLUGIN_ACTIVE', true );

		// Устанавливаем контстанту, что плагин уже используется
		define( 'WUPMP_PLUGIN_VERSION', '1.1.0' );

		// Директория плагина
		define( 'WUPMP_PLUGIN_DIR', dirname( __FILE__ ) );

		// Относительный путь к плагину
		define( 'WUPMP_PLUGIN_BASE', plugin_basename( __FILE__ ) );

		// Ссылка к директории плагина
		define( 'WUPMP_PLUGIN_URL', plugins_url( null, __FILE__ ) );

		// Global scripts
		// ---------------------------------------------------------
		require( WUPMP_PLUGIN_DIR . '/includes/classes/class-configurate-updates.php' );
		new WUPMP_ConfigUpdates( WUPM_Plugin::app() );

		// Admin scripts
		// ---------------------------------------------------------
		if ( is_admin() ) {
			require( WUPMP_PLUGIN_DIR . '/admin/boot.php' );
		}
	}

	add_action( 'plugins_loaded', 'wupmp_premium_load', 20 );

	/**
	 * Function is performed when the parent plugin Robin image optimizer is activated.
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.1.0
	 */
	function wupmp_premium_activate() {
		// schedule event for sending updates to email
		if ( ! wp_next_scheduled( 'wbcr_upmp_mail_updates' ) ) {
			// is main site of network
			if ( is_multisite() and $_SERVER['SERVER_NAME'] !== get_network()->domain ) {
				return;
			}
			wp_schedule_event( time(), 'daily', 'wbcr_upmp_mail_updates' );
		}
	}

	/**
	 * Function is performed when the parent plugin Robin image optimizer is deactivated.
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.1.0
	 */
	function wupmp_premium_deactivate() {
		if ( is_multisite() and $_SERVER['SERVER_NAME'] !== get_network()->domain ) {
			return;
		}
		wp_clear_scheduled_hook( 'wbcr_upmp_mail_updates' );
	}

	/**.
	 * Очищает данные плагина, при удалении плагина
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.1.0
	 */
	function wupmp_premium_uninstall() {
		//global $wpdb;
		//$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE 'wbcr_upmp_%';" );
	}

	if ( defined( 'WCLP_PLUGIN_ACTIVE' ) ) {
		$wupmp_activation_file = WCLP_PLUGIN_FILE;
	} else {
		$wupmp_activation_file = __FILE__;
	}

	register_activation_hook( $wupmp_activation_file, 'wupmp_premium_activate' );
	register_deactivation_hook( $wupmp_activation_file, 'wupmp_premium_activate' );
	register_uninstall_hook( $wupmp_activation_file, 'wupmp_premium_uninstall' );
}

