<?php
/**
 * Plugin Name: SEO Friendly Images Premium
 * Plugin URI: https://clearfy.pro
 * Description: Plugin for SEO friendly images
 * Author: Webcraftic <wordpress.webraftic@gmail.com>
 * Version: 1.1.1
 * Text Domain: seo-friendly-images
 * Domain Path: /languages/
 * Author URI: https://clearfy.pro
 */

// Выход при непосредственном доступе
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wsfip_premium_load' ) ) {
	function wsfip_premium_load() {
		if ( ! defined( 'WCL_PLUGIN_ACTIVE' ) || defined( 'WCL_PLUGIN_THROW_ERROR' ) ) {
			return;
		}

		if ( ! WCL_Plugin::app()->isActivateComponent( 'seo_friendly_images' ) ) {
			return;
		}

		if ( version_compare( WCL_PLUGIN_VERSION, '1.6.1', '<' ) ) {
			return;
		}

		// Устанавливаем контстанту, что плагин уже используется
		define( 'WSFIP_PLUGIN_ACTIVE', true );

		// Устанавливаем контстанту, что плагин уже используется
		define( 'WSFIP_PLUGIN_VERSION', '1.1.0' );

		// Директория плагина
		define( 'WSFIP_PLUGIN_DIR', dirname( __FILE__ ) );

		// Относительный путь к плагину
		define( 'WSFIP_PLUGIN_BASE', plugin_basename( __FILE__ ) );

		// Ссылка к директории плагина
		define( 'WSFIP_PLUGIN_URL', plugins_url( null, __FILE__ ) );

		// Global scripts
		// ---------------------------------------------------------
		require( WSFIP_PLUGIN_DIR . '/includes/classes/class-configurate-seo-images.php' );
		try {
			new WSFIP_Configurate( WCL_Plugin::app() );
		} catch( Exception $e ) {
			// nothing
		}

		// Admin scripts
		// ---------------------------------------------------------
		if ( is_admin() ) {
			$admin_path = WSFIP_PLUGIN_DIR . '/admin/pages';
			WCL_Plugin::app()->registerPage( 'WSFIP_SettingsPage', $admin_path . '/class-pages-settings.php' );
		}
	}

	add_action( 'plugins_loaded', 'wsfip_premium_load', 20 );

	/**.
	 * Очищает данные плагина, при удалении плагина
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.1.0
	 */
	function wsfip_premium_uninstall() {
		//global $wpdb;
		//$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE 'wbcr_sfip_%';" );
	}

	if ( defined( 'WCLP_PLUGIN_ACTIVE' ) ) {
		$wsfip_activation_file = WCLP_PLUGIN_FILE;
	} else {
		$wsfip_activation_file = __FILE__;
	}
	register_uninstall_hook( $wsfip_activation_file, 'wsfip_premium_uninstall' );
}
