<?php

/**
 * Base resolve class.
 */
class WHM_Base_Resolver implements WHM_Resolver_Interface {

	/**
	 * {@inheritdoc}
	 */
	public function init() {
	}

	/**
	 * Get JS asset path.
	 *
	 * @param string $file File name. Could be specified without .js, it will be auto appended.
	 *
	 * @return array
	 */
	public function get_js_asset_path( $file ) {
		$ext = 'js';
		if ( false === strpos( $file, ".$ext" ) ) {
			$file .= ".$ext";
		}

		return $this->get_asset_path( $ext, $file );
	}

	/**
	 * Get JS asset path.
	 *
	 * @param string $file File name. Could be specified without .js, it will be auto appended.
	 *
	 * @return array
	 */
	public function get_css_asset_path( $file ) {
		$ext = 'css';
		if ( false === strpos( $file, ".$ext" ) ) {
			$file .= ".$ext";
		}

		return $this->get_asset_path( $ext, $file );
	}

	/**
	 * Get path of JS asset.
	 *
	 * @param string $asset_folder Folder name inside assets. e.g. js without / at front or back.
	 * @param string $file File name with extension. If $asset_folder is 'js', file ext. assumed to be the same.
	 *
	 * @return array associative array of relative and absolute paths.
	 *         - relative: relative path to the file
	 *         - absolute: absolute (full) path to the file
	 *         - src: URI to
	 */
	public function get_asset_path( $asset_folder, $file ) {
		$dir           = "/public/$asset_folder";
		$relative_path = $dir . "/$file";
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

		$paths = [
			'relative' => $relative_path,
			'absolute' => $full_path,
			'src'      => $src
		];

		return apply_filters( 'wbcr_hmwp_base_resolver_asset_paths', $paths );
	}
}