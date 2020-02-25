<?php
/**
 * Hide my wp core class
 *
 * @author        Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 19.02.2018, Webcraftic
 * @version       1.0
 */

class WHM_Plugin {

	/**
	 * @var WHM_RewriteRules
	 */
	public static $rewrite_rules;
	/**
	 * @var WHM_ContentFilter
	 */
	public static $content_filter;
	/**
	 * @var WHM_AdminPathController
	 */
	public static $admin_path_controller;

	/**
	 * @var WHM_Page404Controller
	 */
	public static $page_404_controller;

	/**
	 * @var WHM_Resolver_Loader
	 */
	public static $resolver;

	/**
	 * @var
	 */
	public static $feeds_controller;


	/**
	 * @param string $plugin_path
	 * @param array  $data
	 *
	 * @throws Exception
	 */
	public function __construct() {

		$this->global_scripts();

		if ( is_admin() ) {
			$this->admin_scripts();
		}
	}

	/**
	 * @author  Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since   1.2.0
	 * @throws \Exception
	 */
	private function register_pages() {
		WCL_Plugin::app()->registerPage( 'WHM_GeneralPage', WHM_PLUGIN_DIR . '/admin/pages/general.php' );
	}

	/**
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.2.0
	 * @throws \Exception
	 */
	private function admin_scripts() {
		require_once( WHM_PLUGIN_DIR . '/admin/boot.php' );
		require_once( WHM_PLUGIN_DIR . '/admin/options.php' );

		$this->register_pages();
	}

	/**
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.2.0
	 */
	private function global_scripts() {
		// Interfaces
		require_once( WHM_PLUGIN_DIR . '/includes/interfaces/class.resolver.php' );
		// Resolvers
		require_once( WHM_PLUGIN_DIR . '/includes/resolver/class.base-resolver.php' );
		require_once( WHM_PLUGIN_DIR . '/includes/resolver/class.resolve-loader.php' );

		require_once( WHM_PLUGIN_DIR . '/includes/class.admin-path.php' );
		require_once( WHM_PLUGIN_DIR . '/includes/class.rules.php' );
		require_once( WHM_PLUGIN_DIR . '/includes/class.generate-rules.php' );
		require_once( WHM_PLUGIN_DIR . '/includes/class.permalinks.php' );
		require_once( WHM_PLUGIN_DIR . '/includes/class.content-filter.php' );
		require_once( WHM_PLUGIN_DIR . '/includes/class.page-404.php' );
	}

}