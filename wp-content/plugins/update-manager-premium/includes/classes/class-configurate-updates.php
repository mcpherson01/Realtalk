<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class configures the parameters seo
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>, GitHub: https://github.com/alexkovalevv
 * @copyright (c) 01.10.2018, Webcraftic
 *
 * @version       1.0
 */
class WUPMP_ConfigUpdates {

	/**
	 * @param WUPM_Plugin $plugin
	 *
	 * @throws \Exception
	 */
	public function __construct( $plugin ) {
		if ( ! $plugin instanceof WUPM_Plugin && ! $plugin instanceof WCL_Plugin ) {
			throw new \Exception( 'Invalid $plugin argument type passed.' );
		}
		$this->plugin = $plugin;
		$this->registerActionsAndFilters();
	}

	public function registerActionsAndFilters() {
		$plugins_update = $this->plugin->getPopulateOption( 'theme_updates' );

		if ( $plugins_update != 'disable_theme_updates' ) {
			add_filter( 'site_transient_update_themes', [ $this, 'disableThemeNotifications' ], 50 );
			add_filter( 'http_request_args', [ $this, 'httpRequestArgsRemoveThemes' ], 5, 2 );
		}

		add_filter( 'site_transient_update_plugins', [ $this, 'disablePluginTranslationUpdates' ], 50 );
		add_filter( 'site_transient_update_themes', [ $this, 'disableThemeTranslationUpdates' ], 50, 1 );

		/**
		 * if off email notifications disabled for wp core updates
		 */

		if ( $this->plugin->getPopulateOption( 'wp_update_core' ) != 'disable_core_updates' ) {
			if ( $this->plugin->getPopulateOption( 'disable_core_notifications' ) ) {
				add_filter( 'auto_core_update_send_email', '__return_true' );
			} else {
				add_filter( 'auto_core_update_send_email', '__return_false' );
			}
		}

		add_action( 'all_plugins', [ $this, 'hidePlugins' ], 10, 1 );
		add_filter( 'wp_get_update_data', [ $this, 'hidePluginUpdateCount' ], 10, 2 );

		/**
		 * check updates and send mails
		 */
		// is main site of network
		if ( ! is_multisite() or ( function_exists( 'get_network' ) and $_SERVER['SERVER_NAME'] === get_network()->domain ) ) {
			require_once WUPMP_PLUGIN_DIR . "/includes/classes/class-update-notification.php";
			add_action( 'wbcr_upmp_mail_updates', [ 'WUPMP_UpdateNotification', 'checkUpdatesMail' ] );
		}
	}


	public function disableThemeNotifications( $themes ) {
		if ( ! isset( $themes->response ) || empty( $themes->response ) ) {
			return $themes;
		}

		$filters = $this->plugin->getPopulateOption( 'themes_update_filters' );

		if ( ! empty( $filters ) && isset( $filters['disable_updates'] ) ) {
			foreach ( (array) $themes->response as $slug => $theme ) {
				$slug_parts  = explode( '/', $slug );
				$actual_slug = array_shift( $slug_parts );
				if ( isset( $filters['disable_updates'][ $actual_slug ] ) ) {
					unset( $themes->response[ $slug ] );
				}
			}
		}

		return $themes;
	}

	/**
	 * Disables theme and plugin http requests on an individual basis.
	 *
	 * @param array  $r     Request array
	 * @param string $url   URL requested
	 *
	 * @return array Updated Request array
	 */
	public function httpRequestArgsRemoveThemes( $r, $url ) {
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
			return $r;
		}

		if ( isset( $r['body']['themes'] ) ) {
			$r_themes = json_decode( $r['body']['themes'], true );
			$filters  = $this->plugin->getPopulateOption( 'themes_update_filters' );

			if ( isset( $r_themes['themes'] ) && ! empty( $r_themes['themes'] ) ) {
				foreach ( $r_themes['themes'] as $actual_slug => $theme ) {

					if ( isset( $filters['disable_updates'] ) && isset( $filters['disable_updates'][ $actual_slug ] ) ) {
						unset( $r_themes['themes'][ $actual_slug ] );
					}
				}
			}
			$r['body']['themes'] = json_encode( $r_themes );
		}

		return $r;
	}


	public function disablePluginTranslationUpdates( $plugins ) {
		if ( ! isset( $plugins->translations ) || empty( $plugins->translations ) ) {
			return $plugins;
		}

		$is_disabled_translation_updates = $this->plugin->getPopulateOption( 'auto_tran_update' );
		if ( $is_disabled_translation_updates ) {
			$plugins->translations = [];

			return $plugins;
		}

		$filters = $this->plugin->getPopulateOption( 'plugins_update_filters' );

		if ( ! empty( $filters ) && isset( $filters['disable_translation_updates'] ) ) {
			foreach ( (array) $plugins->translations as $key => $translation ) {
				if ( $translation['type'] == 'plugin' && array_key_exists( $translation['slug'], $filters['disable_translation_updates'] ) && $filters['disable_translation_updates'][ $translation['slug'] ] ) {
					unset( $plugins->translations[ $key ] );
				}
			}
		}

		return $plugins;
	}

	public function disableThemeTranslationUpdates( $themes ) {
		if ( ! isset( $themes->translations ) || empty( $themes->translations ) ) {
			return $themes;
		}

		$is_disabled_translation_updates = $this->plugin->getPopulateOption( 'auto_tran_update' );
		if ( $is_disabled_translation_updates ) {
			$themes->translations = [];

			return $themes;
		}

		$filters = $this->plugin->getPopulateOption( 'themes_update_filters' );
		if ( ! empty( $filters ) && isset( $filters['disable_translation_updates'] ) ) {
			foreach ( (array) $themes->translations as $key => $translation ) {
				if ( $translation['type'] == 'theme' && array_key_exists( $translation['slug'], $filters['disable_translation_updates'] ) && $filters['disable_translation_updates'][ $translation['slug'] ] ) {
					unset( $themes->translations[ $key ] );
				}
			}
		}
	}

	public function hidePlugins( $plugins ) {
		$filters = $this->plugin->getPopulateOption( 'plugins_update_filters' );
		if ( ! isset( $filters['disable_display'] ) ) {
			return $plugins;
		}
		$filters = (array) $filters['disable_display'];

		foreach ( (array) $plugins as $plugin_path => $plugin ) {
			$slug_parts  = explode( '/', $plugin_path );
			$actual_slug = array_shift( $slug_parts );
			foreach ( $filters as $filter => $filter_value ) {
				if ( $filter_value and $actual_slug == $filter ) {
					unset( $plugins[ $plugin_path ] );
				}
			}
		}

		return $plugins;
	}

	/**
	 * change update counter for plugins in sidebar
	 */
	public function hidePluginUpdateCount( $update_data, $titles ) {
		$filters = $this->plugin->getPopulateOption( 'plugins_update_filters' );
		if ( ! isset( $filters['disable_display'] ) ) {
			return $update_data;
		}
		$filters = (array) $filters['disable_display'];
		if ( count( $filters ) == 0 ) {
			return $update_data;
		}

		// count hidden plugins with available update
		$hidden_updates = 0;

		$update_plugins = get_site_transient( 'update_plugins' );
		if ( $update_plugins === false ) {
			return $update_data;
		}
		foreach ( $update_plugins->response as $plugin_path => $plugin ) {
			$slug_parts  = explode( '/', $plugin_path );
			$actual_slug = array_shift( $slug_parts );
			if ( array_key_exists( $actual_slug, $filters ) ) {
				$hidden_updates ++;
			}
		}
		$new_count = $update_data['counts']['plugins'] - $hidden_updates;
		if ( $hidden_updates > 0 and strpos( $update_data['title'], ',' ) !== false ) {
			$strings              = explode( ',', $update_data['title'] );
			$strings[1]           = str_replace( $update_data['counts']['plugins'], $new_count, $strings[1] );
			$update_data['title'] = implode( ',', $strings );
		}
		$update_data['counts']['plugins'] = $new_count;

		return $update_data;
	}
}