<?php
	
	class WHM_Helpers {

		public static function isHideModeActive()
		{
			return WCL_Plugin::app()->getPopulateOption('hide_my_wp_activate', false);
		}

		/**
		 * Allows you to get the id of the pages on which the user can configure the plugin.
		 * This is necessary in order to perform overwriting of configuration files and display notifications only on the pages of this plugin.
		 * @return array
		 */
		public static function getUseSettingsPages()
		{
			//return array('general', 'defence', 'system_paths', 'permalinks', 'site_content', 'privacy');
			return array('hide_my_wp');
		}

		/**
		 * Return if the server run Apache
		 *
		 * @return bool
		 */
		public static function isApache()
		{
			$is_apache = (strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false || strpos($_SERVER['SERVER_SOFTWARE'], 'LiteSpeed') !== false);

			return $is_apache;
		}


		/**
		 * Return if the server run on nginx
		 *
		 * @return bool
		 */
		public static function isNginx()
		{
			$is_nginx = (strpos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false);

			return $is_nginx;
		}

		/**
		 * Return if the server run on IIS
		 *
		 * @return bool
		 */
		public static function isIIS()
		{
			$is_IIS = !self::isApache() && (strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false || strpos($_SERVER['SERVER_SOFTWARE'], 'ExpressionDevServer') !== false);

			return $is_IIS;
		}

		/**
		 * Return if the server run on IIS version 7 and up
		 *
		 * @return bool
		 */
		public static function isIIS7()
		{
			$is_iis7 = self::isIIS() && intval(substr($_SERVER['SERVER_SOFTWARE'], strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS/') + 14)) >= 7;

			return $is_iis7;
		}

		/**
		 * return whatever server using the .htaccess config file
		 *
		 */
		/*function server_use_web_config_file()
		{
			$is_iis7 = $this->isIIS7();

			$supports_permalinks = false;
			if( $is_iis7 ) {
				$supports_permalinks = class_exists('DOMDocument', false) && isset($_SERVER['IIS_UrlRewriteModule']) && (PHP_SAPI == 'cgi-fcgi');
			}

			$supports_permalinks = apply_filters('iis7_supports_permalinks', $supports_permalinks);

			return $supports_permalinks;
		}*/

		/**
		 * Return whatever the web.config config file is writable
		 */
		public static function isWritableWebConfigFile()
		{
			$home_path = self::getHomePath();
			$web_config_file = $home_path . 'web.config';

			if( (!file_exists($web_config_file) && self::isPermalink()) || win_is_writable($web_config_file) ) {
				return true;
			}

			return false;
		}

		/**
		 * @return bool
		 */
		public static function gotModRewrite()
		{

			if( self::apacheModLoaded('mod_rewrite', true) ) {
				return true;
			}

			return false;
		}

		/**
		 * Get rules marker
		 *
		 * @return string
		 */
		public static function getRulesMarker()
		{
			if( is_multisite() ) {
				return "Webcraftic Hide My Wp Site" . get_current_blog_id();
			}

			return "Webcraftic Hide My Wp";
		}

		/**
		 * Does the specified module exist in the Apache config?
		 *
		 * @since 2.5.0
		 *
		 * @global bool $is_apache
		 *
		 * @param string $mod The module, e.g. mod_rewrite.
		 * @param bool $default Optional. The default return value if the module is not found. Default false.
		 * @return bool Whether the specified module is loaded.
		 */
		public static function apacheModLoaded($mod, $default = false)
		{
			if( !self::isApache() ) {
				return false;
			}

			if( function_exists('apache_get_modules') ) {
				$mods = apache_get_modules();
				if( in_array($mod, $mods) ) {
					return true;
				}
			} elseif( getenv('HTTP_MOD_REWRITE') !== false ) {
				$mod_found = getenv('HTTP_MOD_REWRITE') == 'On' ? true : false;

				return $mod_found;
			} elseif( function_exists('phpinfo') && false === strpos(ini_get('disable_functions'), 'phpinfo') ) {
				ob_start();
				phpinfo(8);
				$phpinfo = ob_get_clean();
				if( false !== strpos($phpinfo, $mod) ) {
					return true;
				}
			}

			return $default;
		}

		/**
		 * return the server home path
		 *
		 */
		public static function getHomePath()
		{
			$home = set_url_scheme(get_option('home'), 'http');
			$siteurl = set_url_scheme(get_option('siteurl'), 'http');

			if( !empty($home) && 0 !== strcasecmp($home, $siteurl) ) {
				$wp_path_rel_to_home = str_ireplace($home, '', $siteurl); /* $siteurl - $home */
				$pos = strripos(str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']), trailingslashit($wp_path_rel_to_home));

				if( $pos !== false ) {
					$home_path = substr($_SERVER['SCRIPT_FILENAME'], 0, $pos);
					$home_path = trim($home_path, '/\\') . DIRECTORY_SEPARATOR;;
				} else {
					$wp_path_rel_to_home = DIRECTORY_SEPARATOR . trim($wp_path_rel_to_home, '/\\') . DIRECTORY_SEPARATOR;

					$real_apth = realpath(ABSPATH) . DIRECTORY_SEPARATOR;

					$pos = strpos($real_apth, $wp_path_rel_to_home);
					$home_path = substr($real_apth, 0, $pos);
					$home_path = trim($home_path, '/\\') . DIRECTORY_SEPARATOR;
				}
			} else {
				$home_path = ABSPATH;
			}

			$home_path = trim($home_path, '\\/ ');

			//not for windows
			if( DIRECTORY_SEPARATOR != '\\' ) {
				$home_path = DIRECTORY_SEPARATOR . $home_path;
			}

			return $home_path;
		}

		/**
		 * Return whatever server using the .htaccess config file
		 *
		 * @return bool
		 */
		public static function serverUseHtaccessConfigFile()
		{
			$home_path = self::getHomePath();
			$htaccess_file = $home_path . DIRECTORY_SEPARATOR . '.htaccess';

			if( (!file_exists($htaccess_file) && is_writable($home_path) && self::isPermalink()) || is_writable($htaccess_file) ) {
				if( self::gotModRewrite() ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Return whatever the htaccess config file is writable
		 *
		 * @return bool
		 */
		public static function isWritableHtaccessConfigFile()
		{
			$home_path = self::getHomePath();
			$htaccess_file = $home_path . DIRECTORY_SEPARATOR . '.htaccess';

			if( (!file_exists($htaccess_file) && self::isPermalink()) || is_writable($htaccess_file) ) {
				return true;
			}

			return false;
		}

		/**
		 * @param string $filename
		 * @param string $marker
		 * @param string $insertion
		 * @return bool
		 */
		public static function writeRulesToFile($filename, $marker, $insertion)
		{
			if( !file_exists($filename) ) {
				if( !is_writable(dirname($filename)) ) {
					return false;
				}
				if( !touch($filename) ) {
					return false;
				}
			} elseif( !is_writeable($filename) ) {
				return false;
			}
			
			if( !is_array($insertion) ) {
				$insertion = explode("\n", $insertion);
			}
			
			$start_marker = "# BEGIN {$marker}";
			$end_marker = "# END {$marker}";
			
			$fp = fopen($filename, 'r+');
			if( !$fp ) {
				return false;
			}
			
			// Attempt to get a lock. If the filesystem supports locking, this will block until the lock is acquired.
			flock($fp, LOCK_EX);
			
			$lines = array();
			while( !feof($fp) ) {
				$lines[] = rtrim(fgets($fp), "\r\n");
			}
			
			// Split out the existing file into the preceding lines, and those that appear after the marker
			$pre_lines = $post_lines = $existing_lines = array();
			$found_marker = $found_end_marker = false;
			foreach($lines as $line) {
				if( !$found_marker && false !== strpos($line, $start_marker) ) {
					$found_marker = true;
					continue;
				} elseif( !$found_end_marker && false !== strpos($line, $end_marker) ) {
					$found_end_marker = true;
					continue;
				}
				if( !$found_marker ) {
					$pre_lines[] = $line;
				} elseif( $found_marker && $found_end_marker ) {
					$post_lines[] = $line;
				} else {
					$existing_lines[] = $line;
				}
			}
			
			// Check to see if there was a change
			if( $existing_lines === $insertion ) {
				flock($fp, LOCK_UN);
				fclose($fp);
				
				return true;
			}
			
			// Generate the new file data
			if( $found_marker && $found_end_marker ) {
				$new_file_data = implode("\n", array_merge($pre_lines, array($start_marker), $insertion, array($end_marker), $post_lines));
			} else {
				
				$new_file_data = implode("\n", array_merge(array($start_marker), $insertion, array($end_marker), $pre_lines));
			}
			
			// Write to the start of the file, and truncate it to that length
			fseek($fp, 0);
			$bytes = fwrite($fp, $new_file_data);
			if( $bytes ) {
				ftruncate($fp, ftell($fp));
			}
			fflush($fp);
			flock($fp, LOCK_UN);
			fclose($fp);
			
			return (bool)$bytes;
		}

		/**
		 * @param $filename
		 * @param $markers
		 * @return bool
		 */
		public static function cleanRulesInFile($filename, $markers)
		{

			if( !file_exists($filename) ) {
				if( !is_writable(dirname($filename)) ) {
					return false;
				}
				if( !touch($filename) ) {
					return false;
				}
			} elseif( !is_writeable($filename) ) {
				return false;
			}

			$start_marker = $markers['start'];
			$end_marker = $markers['end'];

			$fp = fopen($filename, 'r+');
			if( !$fp ) {
				return false;
			}

			// Attempt to get a lock. If the filesystem supports locking, this will block until the lock is acquired.
			flock($fp, LOCK_EX);

			$lines = array();
			while( !feof($fp) ) {
				$lines[] = rtrim(fgets($fp), "\r\n");
			}

			// Split out the existing file into the preceding lines, and those that appear after the marker
			$pre_lines = $post_lines = $existing_lines = array();
			$found_marker = $found_end_marker = false;
			foreach($lines as $line) {
				if( !$found_marker && false !== strpos($line, $start_marker) ) {
					$found_marker = true;
					continue;
				} elseif( !$found_end_marker && false !== strpos($line, $end_marker) ) {
					$found_end_marker = true;
					continue;
				}
				if( !$found_marker ) {
					$pre_lines[] = $line;
				} elseif( $found_marker && $found_end_marker ) {
					$post_lines[] = $line;
				} else {
					$existing_lines[] = $line;
				}
			}

			// Generate the new file data
			if( $found_marker && $found_end_marker ) {
				$new_file_data = implode("\n", array_merge($pre_lines, $post_lines));

				// Write to the start of the file, and truncate it to that length
				fseek($fp, 0);
				$bytes = fwrite($fp, $new_file_data);
				if( $bytes ) {
					ftruncate($fp, ftell($fp));
				}
				fflush($fp);
				flock($fp, LOCK_UN);
				fclose($fp);

				return (bool)$bytes;
			}

			return false;
		}

		/**
		 * Записывает правила в файл web.config
		 *
		 * @param $rules
		 *
		 * @return bool
		 */
		public function writeRulesToWebConfig($rules)
		{
			$start_marker = "<!-- BEGIN " . WHM_Helpers::getRulesMarker() . ' -->';
			$end_marker = '<!-- END ' . WHM_Helpers::getRulesMarker() . ' -->';

			if( empty($rules) || !WHM_Helpers::isWritableWebConfigFile() || strpos($rules, $start_marker) === false
			) {
				return false;
			}

			$home_path = WHM_Helpers::getHomePath();
			$web_config_file = $home_path . DIRECTORY_SEPARATOR . 'web.config';

			if( !file_exists($web_config_file) ) {
				if( !is_writable(dirname($web_config_file)) ) {
					return false;
				}
				if( !touch($web_config_file) ) {
					return false;
				}
			} elseif( !is_writeable($web_config_file) ) {
				return false;
			}

			$file_content = file_get_contents($web_config_file);
			if( !$file_content ) {
				return false;
			}

			if( strpos($file_content, $start_marker) !== false && strpos($file_content, $end_marker) !== false
			) {
				$markers = array(
					'start' => $start_marker,
					'end' => $end_marker
				);
				WHM_Helpers::cleanRulesInFile($web_config_file, $markers);
				$file_content = file_get_contents($web_config_file);
			}

			$web_config_text = '<rule name="wordpress"';
			$position = stripos($file_content, $web_config_text);
			if( $position !== false && strpos($file_content, $start_marker) === false
			) {
				$text = substr($file_content, $position, 22);
				// Опорный текст разбивки делает в нижнем регистре
				$file_content = str_ireplace($text, $web_config_text, $file_content);
				$parts = explode($web_config_text, $file_content);
				// Добавляет правила
				$parts[0] .= $rules . "\n";
				$file_content = implode($web_config_text, $parts);
				// Записывает с блокировкой
				file_put_contents($web_config_file, $file_content, LOCK_EX);
			}

			return true;
		}

		public static function getActivePluginsFolders($type = 'active')
		{
			$folders = array();

			// Check if get_plugins() function exists. This is required on the front end of the
			// site, since it is in a file that is normally only loaded in the admin.
			if( !function_exists('get_plugins') ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			if( $type == 'all' ) {
				$plugins = array_keys(get_plugins());
			} else {
				$plugins = get_option('active_plugins');
				if( is_multisite() ) {
					$all_sites_plugins = array_keys(get_site_option('active_sitewide_plugins'));
					$plugins = array_merge($plugins, $all_sites_plugins);
				}
			}

			if( empty($plugins) ) {
				return $folders;
			}

			foreach($plugins as $pluginPath)
				$folders[] = dirname($pluginPath);

			return $folders;
		}

		public static function generateAccessSecret()
		{
			$trust_key = WCL_Plugin::app()->getPopulateOption('secret_key');
			$output = WCL_Plugin::app()->getPopulateOption('secret_name', 'hide_my_wp');

			if( !empty($trust_key) ) {
				$output .= '=' . WCL_Plugin::app()->getPopulateOption('secret_key', '123');
			}

			return $output;
		}

		public static function generateTrustSecret()
		{
			$output = '';
			$secret_key = WCL_Plugin::app()->getPopulateOption('secret_key');
			if( $secret_key ) {
				$secret_name = WCL_Plugin::app()->getPopulateOption('secret_name', 'hide_my_wp');
				$output = '?' . $secret_name . '=' . $secret_key;
			}

			return $output;
		}

		public static function generateSubFolder()
		{
			$output = '';
			$sub_installation = trim(str_replace(home_url(), '', site_url()), ' /');

			if( $sub_installation && substr($sub_installation, 0, 4) != 'http' ) {
				$output = $sub_installation . '/';
			}

			$is_subdir_mu = false;
			if( is_multisite() ) {
				$is_subdir_mu = true;
			}
			if( (defined('SUBDOMAIN_INSTALL') && SUBDOMAIN_INSTALL) || (defined('VHOST') && VHOST == 'yes')
			) {
				$is_subdir_mu = false;
			}

			if( is_multisite() && !$output && $is_subdir_mu ) {
				$output = ltrim(parse_url(trim(home_url(), '/') . '/', PHP_URL_PATH), '/');
			}

			return $output;
		}

		/**
		 * If root not empty(/), then get root with right slash
		 *
		 * @return string
		 */
		public static function getNotEmptySubFolder()
		{
			$root = trim(WHM_Helpers::generateSubFolder(), '/\\');
			if( $root != '' ) {
				$root .= "/";
			}

			return $root;
		}

		public static function getHash($key)
		{
			return hash('crc32', preg_replace("/[^a-zA-Z-_]/", "", substr(NONCE_KEY, 2, 6)) . $key);
		}

		public static function generateRandomString($length = 10)
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}

			return $randomString;
		}

		public static function resetOptions()
		{
			WCL_Plugin::app()->deletePopulateOption('hide_my_wp_activate');
			WCL_Plugin::app()->deletePopulateOption('replace_content_filters');
			WCL_Plugin::app()->deletePopulateOption('replace_content_patterns');
			WCL_Plugin::app()->deletePopulateOption('recovery_content_patterns');
			WCL_Plugin::app()->deletePopulateOption('recovery_content_filters');
			WCL_Plugin::app()->deletePopulateOption('nginx_rewrite_rules');
			WCL_Plugin::app()->deletePopulateOption('apache_rewrite_rules');
			WCL_Plugin::app()->deletePopulateOption('server_configuration_error');

			//check if .htaccess file exists and is writable
			if( self::isWritableHtaccessConfigFile() ) {
				$home_path = self::getHomePath();
				$htaccess_file = $home_path . DIRECTORY_SEPARATOR . '.htaccess';

				$markers = array(
					'start' => '# BEGIN ' . self::getRulesMarker(),
					'end' => '# END ' . self::getRulesMarker()
				);
				self::cleanRulesInFile($htaccess_file, $markers);
			} /*else if( self::isWritableWebConfigFile() ) {
				$home_path = self::getHomePath();
				$web_config_file = $home_path . DIRECTORY_SEPARATOR . 'web.config';

				$markers = array(
					'start' => '<!-- BEGIN ' . self::getRulesMarker() . ' -->',
					'end' => '<!-- END ' . self::getRulesMarker() . ' -->'
				);
				self::cleanRulesInFile($web_config_file, $markers);
			}*/
		}

		public static function flushRules()
		{
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/misc.php';
			flush_rewrite_rules(true);
		}

		public static function doFeedBase($for_comments)
		{
			if( $for_comments ) {
				load_template(ABSPATH . WPINC . '/feed-rss2-comments.php');
			} else {
				load_template(ABSPATH . WPINC . '/feed-rss2.php');
			}
		}

		/**
		 * Display 404 page to bump bots and bad guys
		 *
		 * @param bool $simple If true force displaying basic 404 page
		 */
		public static function setError404()
		{
			global $wp_query;

			if( function_exists('status_header') ) {
				status_header('404');
				nocache_headers();
			}

			if( $wp_query && is_object($wp_query) ) {
				$wp_query->set_404();
				get_template_part(404);
			} else {
				global $pagenow;

				$pagenow = 'index.php';

				if( !defined('WP_USE_THEMES') ) {
					define('WP_USE_THEMES', true);
				}

				wp();

				$_SERVER['REQUEST_URI'] = self::userTrailingslashit('/hmwp_404');

				require_once(ABSPATH . WPINC . '/template-loader.php');
			}

			exit();
		}

		public static function useTrailingSlashes()
		{
			return ('/' === substr(get_option('permalink_structure'), -1, 1));
		}

		public static function userTrailingslashit($string)
		{
			return self::useTrailingSlashes() ? trailingslashit($string) : untrailingslashit($string);
		}

		/**
		 * Is permalink enabled?
		 * @global WP_Rewrite $wp_rewrite
		 * @since 1.0.0
		 * @return bool
		 */
		public static function isPermalink()
		{
			global $wp_rewrite;

			if( !isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks() ) {
				return false;
			}

			return true;
		}

		/**
		 * Returns true if the string is a valid regex.
		 *
		 * @param string $string String, duh.
		 *
		 * @return bool
		 */
		public static function strIsValidRegex($string)
		{
			set_error_handler(function () {
			}, E_WARNING);
			$is_regex = (false !== preg_match($string, ''));
			restore_error_handler();

			return $is_regex;
		}

		/**
		 * Returns true if a needle can be found in a haystack
		 *
		 * @param string $string
		 * @param string $find
		 * @param bool $case_sensitive
		 * @return bool
		 */
		public static function strContains($string, $find, $case_sensitive = true)
		{
			if( empty($string) || empty($find) ) {
				return false;
			}

			$pos = $case_sensitive ? strpos($string, $find) : stripos($string, $find);

			return !($pos === false);
		}

		/**
		 * Tests if a text starts with an given string.
		 *
		 * @param string $string
		 * @param string $find
		 * @param bool $case_sensitive
		 * @return bool
		 */
		public static function strStartsWith($string, $find, $case_sensitive = true)
		{
			if( $case_sensitive ) {
				return strpos($string, $find) === 0;
			}

			return stripos($string, $find) === 0;
		}

		/**
		 * Tests if a text ends with an given string.
		 *
		 * @param $string
		 * @param $find
		 * @param bool $case_sensitive
		 * @return bool
		 */
		public static function strEndsWith($string, $find, $case_sensitive = true)
		{
			$expected_position = strlen($string) - strlen($find);

			if( $case_sensitive ) {
				return strrpos($string, $find, 0) === $expected_position;
			}

			return strripos($string, $find, 0) === $expected_position;
		}

		/**
		 * Return the last element in the path of the requested URI.
		 *
		 * @param bool $check_php if true check if a php script has been requested
		 *
		 * @return bool|string
		 */
		/*public static function lastUriPart($check_php = false)
		{
			static $ret;

			if( isset($ret) ) {
				return $ret;
			}

			$ret = strtolower($_SERVER['REQUEST_URI']);

			if( $pos = strpos($ret, '?') ) {
				$ret = substr($ret, 0, $pos);
			}

			$ret = rtrim($ret, '/');
			$ret = substr(strrchr($ret, '/'), 1);

			return $ret;
		}*/
	}