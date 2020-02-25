<?php

/**
 * Assets manager Premium base class
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>, GitHub: https://github.com/alexkovalevv
 * @copyright (c) 01.10.2018, Webcraftic
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WGNZP_Config_Assets_Manager {

	/**
	 * @param WGZ_Plugin $plugin
	 *
	 * @throws \Exception
	 */
	public function __construct( $plugin ) {
		if ( ! $plugin instanceof WGZ_Plugin && ! $plugin instanceof WCL_Plugin ) {
			throw new \Exception( 'Invalid $plugin argument type passed.' );
		}
		$this->plugin = $plugin;

		add_action( 'wam/views/safe_mode_checkbox', [ $this, 'print_save_mode_checkbox' ] );
		add_filter( 'wam/before_save_settings', [ $this, 'filter_save_options' ], 10, 2 );

		remove_all_filters( 'wam/conditions/call_method' );
		add_filter( 'wam/conditions/call_method', [ $this, 'check_conditions_method' ], 10, 4 );
	}

	/**
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.1.0
	 *
	 * @param $data
	 */
	public function print_save_mode_checkbox( $data ) {
		?>
        <label class="wam-float-panel__checkbox  wam-tooltip  wam-tooltip--bottom" data-tooltip="<?php _e( 'In test mode, you can experiment with disabling unused scripts safely for your site. The resources that you disabled will be visible only to you (the administrator), and all other users will receive an unoptimized version of the site, until you remove this tick', 'gonzales' ) ?>.">
            <input id="js-wam-save-mode-checkbox" class="wam-float-panel__checkbox-input visually-hidden" type="checkbox"<?php checked( $data['save_mode'] ) ?>>
            <span class="wam-float-panel__checkbox-text"><?php _e( 'Safe mode', 'gonzales' ) ?></span>
        </label>
		<?php
	}

	/**
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.1.0
	 *
	 * @param $settings
	 * @param $raw_updated_settings
	 *
	 * @return mixed
	 */
	public function filter_save_options( $settings, $raw_updated_settings ) {
		if ( ! empty( $raw_updated_settings['save_mode'] ) ) {
			$settings['save_mode'] = "true" === $raw_updated_settings['save_mode'] ? true : false;
		}

		return $settings;
	}

	/**
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.1.0
	 *
	 * @param $default
	 * @param $method_name
	 * @param $operator
	 * @param $value
	 *
	 * @return mixed
	 */
	public function check_conditions_method( $default, $method_name, $operator, $value ) {
		require_once WGZP_PLUGIN_DIR . '/includes/class-check-conditions.php';
		$conditions = new WGNZP_Check_Conditions();
		if ( method_exists( $conditions, $method_name ) ) {
			return $conditions->$method_name( $operator, $value );
		}

		return $default;
	}
}