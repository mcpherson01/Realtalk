<?php

/**
 * Base resolver class to merge all available resolving classes.
 */
class WHM_Resolver_Loader {

	/**
	 * @var array Key => value list of plugins supported, where key is folder/plugin php file and
	 *      value is class name without class. prefix and .php suffix.
	 */
	private $_plugins = [
		'woocommerce/woocommerce.php' => [
			'file'  => 'woocommerce',
			'class' => 'WHM_WooCommerce_ResolverLoader'
		],
		'jetpack/jetpack.php' => [
			'file' => 'jetpack',
			'class' => 'WHM_Jetpack_Resolver'
		]
	];

	/**
	 * @var array Instantiated resolvers. Key => value list of plugins, where key is folder/plugin php file and
	 *      value is instance of instantiated class.
	 */
	private $_actives = [];

	/**
	 * WHM_Base_Resolver constructor.
	 */
	public function __construct() {
		$this->check_resolves();
	}

	/**
	 * Check for available conflict or adaptable resolvers and include them.
	 * List of active resolvers will be stored in `active` property.
	 *
	 * @see WHM_Resolver_Loader::$_actives for further information.
	 */
	public function check_resolves() {
		$plugins = $this->get_plugins();

		if ( ! empty( $plugins ) ) {
			foreach ( $plugins as $plugin => $plugin_data ) {

				$plugin = trim( $plugin );
				$file   = isset( $plugin_data['file'] ) ? $plugin_data['file'] : null;
				$class  = isset( $plugin_data['class'] ) ? $plugin_data['class'] : null;

				if ( empty( $file ) || empty( $class ) ) {
					continue;
				}

				if ( is_plugin_active( $plugin ) ) {
					$path = WHM_PLUGIN_DIR . "/includes/resolver/class.$file.php";

					if ( ! file_exists( $path ) ) {
						continue;
					}

					include( $path );

					if ( class_exists( $class ) && ! isset( $this->active[ $plugin ] ) ) {

						/**
						 * @var $resolver_class WHM_Resolver_Interface
						 */
						$resolver_class = new $class();

						if ( $resolver_class instanceof WHM_Resolver_Interface ) {
							$resolver_class->init();
						}

						$this->_actives[ $plugin ] = $resolver_class;
					}
				}
			}
		}
	}

	/**
	 * Get path of JS asset.
	 *
	 * @return array associative array of relative and absolute paths.
	 *         - relative: relative path to the file
	 *         - absolute: absolute (full) path to the file
	 */
	public function get_js_asset_path() {
		$dir           = '/public/js';
		$relative_path = $dir . "/woo-resolver.js";
		$full_path     = WHM_PLUGIN_DIR . $relative_path;

		if ( ! file_exists( WHM_PLUGIN_DIR . $dir ) ) {
			mkdir( WHM_PLUGIN_DIR . $dir, 0755, true );
		}

		$src = untrailingslashit( plugins_url( '/', WHM_PLUGIN_DIR ) );

		if ( defined( 'LOADING_WEBCRAFTIC_HIDE_MY_WP_AS_ADDON' ) ) {
			$src .= '/hide-my-wp' . $relative_path;
		} else {
			$src .= $relative_path;
		}

		return [
			'relative' => $relative_path,
			'absolute' => $full_path,
			'src'      => $src
		];
	}

	/**
	 * Get list of supported plugins.
	 *
	 * @return array
	 */
	public function get_plugins() {
		return $this->_plugins;
	}

	/**
	 * Get list of active resolvers.
	 *
	 * @return array
	 */
	public function get_actives() {
		return $this->_actives;
	}
}

WHM_Plugin::$resolver = new WHM_Resolver_Loader();