<?php
/**
 * Plugin Name: Webcraftic hide my wp
 * Plugin URI: https://clearfy.pro/hide-my-wp/
 * Description: This premium component helps in hiding your WordPress from hackers and bots. Basically, it disables identification of your CMS by changing directories and files names, removing meta data and replacing HTML content which can provide all information about the platform you use.    Most websites can be hacked easily, as hackers and bots know all security flaws in plugins, themes and the WordPress core. You can secure the website from the attack by hiding the information the hackers will need.
 * Author: Webcraftic
 * Version: 1.2.0
 * Author URI: https://clearfy.pro
 * Framework Version: FACTORY_000_VERSION
 */

// Выход при непосредственном доступе
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'whmwp_premium_load' ) ) {
	function whmwp_premium_load() {
		if ( ! defined( 'WCL_PLUGIN_ACTIVE' ) || defined( 'WCL_PLUGIN_THROW_ERROR' ) ) {
			return;
		}

		if ( ! WCL_Plugin::app()->isActivateComponent( 'hide_my_wp' ) ) {
			return;
		}

		if ( version_compare( WCL_PLUGIN_VERSION, '1.6.1', '<' ) ) {
			return;
		}

		// Устанавливаем контстанту, что плагин уже используется
		define( 'WHM_PLUGIN_ACTIVE', true );

		// Устанавливаем контстанту, что плагин уже используется
		define( 'WHM_PLUGIN_VERSION', '1.2.0' );

		// Директория плагина
		define( 'WHM_PLUGIN_DIR', dirname( __FILE__ ) );

		// Относительный путь к плагину
		define( 'WHM_PLUGIN_BASE', plugin_basename( __FILE__ ) );

		// Ссылка к директории плагина
		define( 'WHM_PLUGIN_URL', plugins_url( null, __FILE__ ) );

		if ( is_ssl() ) {
			if ( ! defined( 'WHM_PLUGIN_BASE' ) ) {
				define( 'WHM_WP_CONTENT_URL', str_replace( 'http:', 'https:', WP_CONTENT_URL ) );
			}
			if ( ! defined( 'WHM_PLUGIN_BASE' ) ) {
				define( 'WHM_WP_PLUGIN_URL', str_replace( 'http:', 'https:', WP_PLUGIN_URL ) );
			}
		} else {
			if ( ! defined( 'WHM_WP_CONTENT_URL' ) ) {
				define( 'WHM_WP_CONTENT_URL', WP_CONTENT_URL );
			}
			if ( ! defined( 'WHM_WP_PLUGIN_URL' ) ) {
				define( 'WHM_WP_PLUGIN_URL', WP_PLUGIN_URL );
			}
		}

		require_once( WHM_PLUGIN_DIR . '/includes/class.helpers.php' );
		require_once( WHM_PLUGIN_DIR . '/includes/class.plugin.php' );

		// Global scripts
		// ---------------------------------------------------------
		new WHM_Plugin();
	}

	add_action( 'plugins_loaded', 'whmwp_premium_load', 20 );

	/**
	 * Unstall hook
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.2.0
	 */
	function whmp_uninstall() {
		global $wpdb;

		$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE 'wbcr_hmwp_%';" );
	}

	/**
	 * Activation hook
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.2.0
	 */
	function whmp_activation() {
		global $wp_rewrite;
		if ( ! isset( $wp_rewrite ) ) {
			return;
		}
		//flush_rewrite_rules();
	}

	/**
	 * Deactivation hook
	 *
	 * todo: if clearfy is deactivating now, we must call to the action
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.2.0
	 */
	function whmp_deactivation() {
		global $wp_rewrite;

		if ( ! isset( $wp_rewrite ) ) {
			return;
		}

		if ( defined( 'WCL_PLUGIN_ACTIVE' ) && class_exists( 'WCL_Plugin' ) ) {
			require_once( dirname( __FILE__ ) . '/includes/class.helpers.php' );

			if ( WCL_Plugin::app()->isNetworkAdmin() ) {
				$sites = WCL_Plugin::app()->getActiveSites();

				foreach ( $sites as $site ) {
					switch_to_blog( $site->blog_id );

					WHM_Helpers::resetOptions();

					restore_current_blog();
				}
			} else {
				WHM_Helpers::resetOptions();
			}

			WHM_Helpers::flushRules();

			WCL_Plugin::app()->updatePopulateOption( 'need_rewrite_rules', 1 );
		}
	}
}