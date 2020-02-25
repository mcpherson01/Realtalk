<?php

/**
 * Resolves issue when some services could find usage of WooCommerce in the code.
 */
class WHM_WooCommerce_ResolverLoader extends WHM_Base_Resolver implements WHM_Resolver_Interface {

	/**
	 * @var string Handler name. Use to determine specific handle in handle_params().
	 * @see WHM_WooCommerce_ResolverLoader::handle_params() for furher information.
	 */
	public $woocommerce_param = 'woocommerce';

	/**
	 * @var string Complete WooCommerce param name.
	 */
	public $woocommerce_js_param = 'woocommerce_param';

	/**
	 * @var string JS file name to be auto generated.
	 */
	public $js_file_name = 'woo-resolver.js';

	/**
	 * WHM_WooCommerceResolver constructor.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * {@inheritdoc}
	 */
	public function init() {
		add_filter( 'woocommerce_get_script_data', [ $this, 'handle_params' ], 999, 2 );
	}

	/**
	 * Handle params passed via woocommerce_params filter.
	 *
	 * Data params would be excluded from inline JS and put into
	 * separate JS file, to make sniffing services believe that
	 * this is not WooCommerce as most of them check for break
	 * changing variable names.
	 *
	 *
	 * @param array $params List of data to be in the JSON object.
	 * @param string $handle Handler name.
	 *
	 * @return array
	 */
	public function handle_params( $params, $handle ) {

		if ( $handle !== $this->woocommerce_param ) {
			return $params;
		}

		// Dynamically generate JS file
		$this->generate_js_file( $params );

		// No inline JS
		return [];
	}

	/**
	 * Dynamically generate JS file based on provided data.
	 *
	 * @param array $params List of data to be in the JSON object.
	 *
	 * @return bool
	 */
	public function generate_js_file( $params ) {

		if ( empty( $params ) ) {
			return false;
		}

		// res = resolver

		$paths      = $this->get_js_asset_path( $this->js_file_name );
		$full_path  = $paths['absolute'];
		$param_name = $this->woocommerce_js_param;
		$script     = "window.$param_name = " . wp_json_encode( $params ) . ';';
		$marker     = '/*AUTO GENERATED*/';
		$js_content = $marker . '(function(){' . $script . '})();' . $marker;

		// If files does not exist yet, should consider creating one
		if ( ! file_exists( $full_path ) ) {
			return false !== file_put_contents( $full_path, $js_content );
		}

		$this->load_js_asset();

		return true;
	}

	/**
	 * Load JS asset with WooCommerce JSON object to hide it from inline JS.
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
			wp_enqueue_script( 'whm-woo-resolver', $src, [], '', true );
		}

		return true;
	}
}