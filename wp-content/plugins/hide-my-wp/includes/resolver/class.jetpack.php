<?php

/**
 * Resolves issue when some services could find usage of Jetpack in the code.
 */
class WHM_Jetpack_Resolver extends WHM_Base_Resolver implements WHM_Resolver_Interface {

	/**
	 * @var string JS file name to be auto generated.
	 */
	public $js_file_name = 'jet-resolver.js';

	/**
	 * {@inheritdoc}
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', [ $this, 'unqueue_scripts' ], 9999 );
	}

	/**
	 * Unqueue scripts which may help some services to detect usage of Jetpack.
	 */
	public function unqueue_scripts() {
		if ( Jetpack::is_active() && ! Jetpack_AMP_Support::is_amp_request() ) {
			wp_dequeue_script( 'devicepx' );

			$this->generate_js_file();
		}
	}

	/**
	 * Fetches Jetpack's devicepx-jetpack.js file from remote,
	 * saves it locally under different name, so detecting services cannot
	 * find usage of Jetpack.
	 *
	 * @link http://s0.wp.com/wp-content/js/devicepx-jetpack.js for further information.
	 *
	 * @return bool
	 */
	public function generate_js_file() {

		$paths         = $this->get_asset_path( 'js', $this->js_file_name );
		$absolute_path = $paths['absolute'];


		$should_refetch = false;

		// Check whether file is old and should be refetched
		if ( file_exists( $absolute_path ) ) {
			$timeout        = apply_filters( 'wbcr_hmwp_jetpack_devicepx_timeout', 24 * 60 * 60 );
			$unix_timestamp = filemtime( $absolute_path );

			$file_expiration_timestamp = $unix_timestamp + $timeout;

			if ( time() >= $file_expiration_timestamp ) {
				$should_refetch = true;
			}
		}

		// Should refetch or file does not exist
		if ( $should_refetch || ! file_exists( $absolute_path ) ) {

			// All loaded scripts
			$scripts = wp_scripts();

			/**
			 * Try to find devicepx
			 * @var $asset_devicepx _WP_Dependency
			 */
			$asset_devicepx = isset( $scripts->registered['devicepx'] ) ? $scripts->registered['devicepx'] : null;

			if ( ! empty( $asset_devicepx ) ) {
				$src = $asset_devicepx->src;

				$res = wp_remote_get( $src, [ 'timeout' => 3 ] );

				if ( $res instanceof WP_Error && $res['response']['code'] !== 200 ) {
					return false;
				}

				$content = trim( $res['body'] );

				$content = apply_filters( 'wbcr_hmwp_jetpack_devicepx_content', $content );

				// Save file content to local JS file for further usage
				@file_put_contents( $absolute_path, $content );
			}
		}

		// Queue script locally
		$this->load_js_asset();

		return true;
	}

	/**
	 * Load JS asset downloaded from remote.
	 *
	 * @return bool
	 */
	public function load_js_asset() {
		$paths = $this->get_js_asset_path( $this->js_file_name );

		$src           = isset( $paths['src'] ) ? $paths['src'] : null;
		$absolute_path = isset( $paths['absolute'] ) ? $paths['absolute'] : null;

		if ( empty( $src ) || empty( $absolute_path ) ) {
			return false;
		}

		if ( file_exists( $absolute_path ) ) {
			wp_enqueue_script( 'whm-jet-resolver', $src, [], '', true );
		}

		return true;
	}
}