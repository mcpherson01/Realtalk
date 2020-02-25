<?php
require_once WHM_PLUGIN_DIR . '/includes/servers/class.configurate-server.php';

/**
 * Generate rules for the Apache server
 *
 * @author        Alex Kovalev <alex@byonepress.com><wordpress.webraftic@gmail.com>
 * @since         1.0.0
 * @copyright (c) 2018, Webcraftic Ltd
 */
class WHM_ConfigurateApache extends WHM_ConfigurateServer {

	public function addRewriteRule( $from, $to, $flags = "" ) {
		$this->rewrite_rules[] = $this->getRewriteRule( $from, $to, $flags );
	}

	public function addRewriteCond( $haystack, $condition, $flags = "" ) {
		$this->rewrite_rules[] = $this->getRewriteCond( $haystack, $condition, $flags );
	}

	/**
	 * Adds the var 'hmwp' to the new path in order to prevent blocking.
	 *
	 * Possible result:
	 *
	 * RewriteCond %{QUERY_STRING} \? [NC]
	 * RewriteRule ^libs/(.*) /wp-includes/$1&hmwp [QSA,L]
	 * RewriteRule ^libs/(.*) /wp-includes/$1?hmwp [QSA,L]
	 *
	 * @return string
	 */
	public function generateRules() {
		$disabled_paths = $this->getDisabledPaths();

		$rewrite_conds = [];
		$rewrite_rules = [];

		if ( ! empty( $disabled_paths ) ) {
			$rewrite_rules[] = [
				'type' => 'newline'
			];

			$rewrite_rules[] = $this->getRewriteCond( '%{HTTP_COOKIE}', '!(wordpress_logged_in_|wp-postpass_|wptouch_switch_toggle|comment_author_|comment_author_email_)', '[NC]' );
			$rewrite_rules[] = $this->getRewriteCond( '%{QUERY_STRING}', '!' . WHM_Helpers::generateAccessSecret(), '[NC]' );

			//$rewrite_rules[] = $this->getRewriteCond('%{REQUEST_URI}', '(' . $this->getDisabledFilesReg(true) . ')');
			$disabled_files = $this->getDisabledFilesReg();

			if ( ! empty( $disabled_files ) ) {
				foreach ( (array) $disabled_files as $file ) {
					$rewrite_conds[] = $this->getRewriteCond( '%{REQUEST_URI}', "{$file}$", '[NC,OR]' );
				}
			}

			$php_files_for_404 = [];
			foreach ( $disabled_paths as $disabled_path ) {

				// Collect all .php files
				if ( false !== strpos( $disabled_path, '.php' ) ) {
					$php_files_for_404[] = $disabled_path;
				}

				// Disable all wp-content related files
				if ( preg_match( '/^wp-content$/m', $disabled_path ) ) {
					$rewrite_conds[] = $this->getRewriteCond( '%{REQUEST_URI}', '^/wp-content(/.*)?', '[NC,OR]' );
					//$rewrite_rules[] = $this->getRewriteCond( '%{REQUEST_URI}', '^/wp-content/[^\.]+/?$', '[NC,OR]' );
				}

				// Disable wp-admin
				if ( preg_match( '/^wp-admin/m', $disabled_path ) ) {
					$rewrite_conds[] = $this->getRewriteCond( '%{REQUEST_URI}', '^/wp-admin', '[NC,OR]' );
				}

				// Disable paths like wp-content/themes, etc.
				if ( preg_match( '/^[a-z0-9-]{1,}\/[a-z0-9-]{1,}/m', $disabled_path ) ) {
					$clean_disable_path = str_replace( '/', '\/', $disabled_path );
					$clean_disable_path = preg_replace( [ '/\/$/', '/^\//' ], '', $clean_disable_path );

					// Extensions to be blocked in subfolders, e.g. wp-content/themes
					$imploded_extensions = '$|' . $this->getBlockedExtensions( true );

					// When matching uploads, should remove some of the extensions, such
					// as .xml and .zip as they should be downloadable
					if ( false !== strpos( $clean_disable_path, 'uploads' ) ) {
						$imploded_extensions = '$|' . $this->getBlockedUploadsExtensions( true );
					}

					$rewrite_conds[] = $this->getRewriteCond( '%{REQUEST_URI}', '^' . $clean_disable_path . '/[^\.]+(' . $imploded_extensions . ')', '[NC,OR]' );
				}

				if ( false !== strpos( $disabled_path, 'wp-includes' ) ) {
					$rewrite_conds[] = $this->getRewriteCond( '%{REQUEST_URI}', '^/wp-includes(/.*)?', '[NC,OR]' );
				}
			}

			// When there are some .php files, should generate rule for them
			if ( ! empty( $php_files_for_404 ) ) {
				$imploded_php_files = implode( '|', $php_files_for_404 );
				$rewrite_conds[]    = $this->getRewriteCond( '%{REQUEST_URI}', '(' . $imploded_php_files . ')', '[NC,OR]' );
			}

			# If it is last condition we must replace flag on the [NC],
			# because of it may be causes error. Server always will be return 404 error.
			if ( ! empty( $rewrite_conds ) ) {
				$rewrite_conds_key_last = key( array_slice( $rewrite_conds, - 1, 1, true ) );

				if ( isset( $rewrite_conds[ $rewrite_conds_key_last ] ) ) {
					$rewrite_conds[ $rewrite_conds_key_last ]['flags'] = "[NC]";
				}
			}

			$rewrite_rules   = array_merge( $rewrite_rules, $rewrite_conds );
			$rewrite_rules[] = $this->getRewriteRule( '^(.*)$', '', '- [L,R=404]' );

			$rewrite_rules[] = [
				'type' => 'newline'
			];
		}

		foreach ( (array) $this->rewrite_rules as $index => $rewriteRule ) {

			if ( $rewriteRule['type'] !== 'RewriteRule' ) {
				continue;
			}

			$rewrite_rules[] = $this->getRewriteRule( $rewriteRule['arg1'], $rewriteRule['arg2'] . '?' . WHM_Helpers::generateAccessSecret(), '[QSA,L]' );
		}

		$comp_rewrite_rules = [];

		foreach ( (array) $rewrite_rules as $rule ) {

			if ( 'newline' === $rule['type'] ) {
				$comp_rewrite_rules[] = "";
				continue;
			}

			$comp_rewrite_rules[] = $rule['type'] . ' ' . $rule['arg1'] . ' ' . $rule['arg2'] . ' ' . $rule['flags'];
		}

		return implode( "\n", $comp_rewrite_rules );
	}

	/**
	 * Позволяет получить сгенероиванные плавила конфигурации сервера для печати
	 *
	 * @return string
	 */
	public function getPrintRules() {
		$rules = $this->generateRules();

		$opt_remove_x_powered_by       = WCL_Plugin::app()->getPopulateOption( 'remove_x_powered_by' );
		$opt_disable_directory_listing = WCL_Plugin::app()->getPopulateOption( 'disable_directory_listing' );

		$print_rules = '';
		if ( $opt_disable_directory_listing ) {
			$print_rules = "# --------" . PHP_EOL;
			$print_rules .= "# Disable directory browsing" . PHP_EOL;
			$print_rules .= "Options All -Indexes" . PHP_EOL;
		}
		if ( $opt_remove_x_powered_by ) {
			$print_rules .= "# --------" . PHP_EOL;
			$print_rules .= "# Disable X-Powered-By" . PHP_EOL;
			$print_rules .= "<IfModule mod_headers.c>" . PHP_EOL;
			$print_rules .= "Header unset X-Powered-By" . PHP_EOL;
			$print_rules .= "</IfModule>" . PHP_EOL;
			$print_rules .= "# --------" . PHP_EOL;
		}

		$print_rules .= "<IfModule mod_rewrite.c> \n" . "RewriteEngine On \n" . "RewriteBase / \n" . $this->cleanConfig( $rules ) . "\n" . "</IfModule>";

		return $print_rules;
	}

	/**
	 * Записывает правила в файл htaccess
	 *
	 * @return bool
	 */
	public function flushRewriteRulesHard() {
		$this->updateRewriteRules();

		if ( WHM_Helpers::serverUseHtaccessConfigFile() ) {
			$home_path     = WHM_Helpers::getHomePath();
			$htaccess_file = $home_path . DIRECTORY_SEPARATOR . '.htaccess';

			//check if .htaccess file exists and is writable
			/*if( !WHM_Helpers::isWritableHtaccessConfigFile() ) {
				WCL_Plugin::app()->updatePopulateOption('server_configuration_error', 1);
				return false;
			}*/

			$print_rules = $this->getPrintRules();

			//check if there's a  # BEGIN WordPress and   # END WordPress    markers or create those to ensude plugin rules are put on top of Wordpress ones
			$file_content = file( $htaccess_file );

			if ( count( preg_grep( "/.*# BEGIN WordPress.*/i", $file_content ) ) < 1 && count( preg_grep( "/.*# END WordPress.*/i", $file_content ) ) < 1 ) {
				WHM_Helpers::writeRulesToFile( $htaccess_file, 'WordPress', '' );
			}

			$write_result = WHM_Helpers::writeRulesToFile( $htaccess_file, WHM_Helpers::getRulesMarker(), $this->cleanConfig( $print_rules ) );

			if ( $write_result ) {
				if ( WCL_Plugin::app()->getPopulateOption( 'server_configuration_error' ) ) {
					WCL_Plugin::app()->deletePopulateOption( 'server_configuration_error' );
				}

				return true;
			}
		}

		WCL_Plugin::app()->updatePopulateOption( 'server_configuration_error', 1 );

		return false;
	}

	protected function getRewriteRule( $from, $to, $flags = "" ) {
		if ( empty( $flags ) ) {
			$flags = "[QSA,L]";
		}

		$from = preg_replace( "/\\\\?\.(?!\*)/", "\.", $from );

		return [
			'type'  => 'RewriteRule',
			'arg1'  => $from,
			'arg2'  => $to,
			'flags' => $flags
		];
	}

	protected function getRewriteCond( $haystack, $condition, $flags = "" ) {
		if ( empty( $flags ) ) {
			$flags = "[NC]";
		}

		$condition = preg_replace( "/\\\\?\.(?!\*)/", "\.", $condition );

		return [
			'type'  => 'RewriteCond',
			'arg1'  => $haystack,
			'arg2'  => $condition,
			'flags' => $flags
		];
	}
}