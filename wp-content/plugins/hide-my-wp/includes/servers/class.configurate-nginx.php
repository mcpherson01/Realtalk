<?php
	require_once WHM_PLUGIN_DIR . '/includes/servers/class.configurate-server.php';

	/**
	 * Generate rules for the Nginx server
	 *
	 * @author Alex Kovalev <alex@byonepress.com><wordpress.webraftic@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 * @since 1.0.0
	 */
	class WHM_ConfigurateNginx extends WHM_ConfigurateServer {

		/**
		 * @var string Server name.
		 */
		protected $server = 'nginx';


		/**
		 * Adds the var 'hmwp' to the new path in order to prevent blocking.
		 *
		 * @return string
		 */
		public function generateRules()
		{
			$rewrite_rules = array();
			$access_secret = WHM_Helpers::generateAccessSecret();

			foreach((array)$this->rewrite_rules as $index => $rewriteRule) {
				$rewrite_rules[] = $this->getRewriteRule($rewriteRule['arg1'], $rewriteRule['arg2'] . '?' . $access_secret);
			}

			$comp_rewrite_rules = array();
			$hmwp_404_error_rule = $this->generate404Rules();

			if(!empty($hmwp_404_error_rule)) {
				$comp_rewrite_rules[] = $hmwp_404_error_rule . PHP_EOL;
			}


			foreach((array)$rewrite_rules as $rule) {
				$print_rule = str_replace('^', '', $rule['arg1']);
				$comp_rewrite_rules[] = sprintf("%s ^/%s /%s %s;", $rule['type'], $print_rule, $rule['arg2'], $rule['flags']);
			}

			return implode("\n", $comp_rewrite_rules);
		}

		/**
		 * Generates all 404 related rules.
		 *
		 * For example, paths and extensions that are not allowed to be access
		 * without special secret get parameter defined by user.
		 *
		 * @return string Generated 404 rules. May return empty string when there are no disabled paths defined.
		 */
		public function generate404Rules() {
			$disabled_paths = $this->getDisabledPaths();
			$access_secret = WHM_Helpers::generateAccessSecret();
			$opt_hide_other_wp_files = (bool)WCL_Plugin::app()->getPopulateOption('hide_other_wp_files');



			if( empty($disabled_paths) ) {
				return '';
			}

			$hmwp_404_error_rule = <<<EOT
if (\$request_uri ~* author=\d+$) { set \$cond "author_uri"; }
if (\$cond = "author_uri") {  return 404; }
if (\$http_cookie !~* "wordpress_logged_in_|wp-postpass_|wptouch_switch_toggle|comment_author_|comment_author_email_" ) {  set \$cond cookie; }
if (\$request_uri ~* ^/wp-admin(/.*)?) { set \$cond "\${cond}+deny_uri"; }
EOT;

			if( $opt_hide_other_wp_files ) {
				$disabled_files_reg = $this->getDisabledFilesReg(true);
				$hmwp_404_error_rule .= PHP_EOL;
				$hmwp_404_error_rule .= 'if ($request_uri ~ ('. $disabled_files_reg .')) { set $cond "${cond}+deny_uri"; }';
				$hmwp_404_error_rule .= PHP_EOL;
			}

			$php_files_for_404 = [];
			foreach ($disabled_paths as $disabled_path) {

				// Collect all .php files
				if(false !== strpos($disabled_path, '.php')) {
					$php_files_for_404[] = $disabled_path;
				}

				// Disable all wp-content related files
				if(preg_match('/^wp-content$/m', $disabled_path)) {
					$hmwp_404_error_rule .= <<<EOT
if (\$request_uri ~* ^/wp-content/?$) { set \$cond "\${cond}+deny_uri"; }
if (\$request_uri ~* ^/wp-content/[^\.]+/?$) { set \$cond "\${cond}+deny_uri"; }
EOT;
				}

				// Disable wp-admin
				if(preg_match('/^wp-admin$/m', $disabled_path)) {
					$hmwp_404_error_rule .= PHP_EOL;
					$hmwp_404_error_rule .= 'if ($request_uri ~* ^/wp-admin$) { set $cond "${cond}+deny_uri"; }';
					$hmwp_404_error_rule .= PHP_EOL;
				}

				// Disable paths like wp-content/themes, etc.
				if(preg_match('/^[a-z0-9-]{1,}\/[a-z0-9-]{1,}/m', $disabled_path)) {
					$clean_disable_path = str_replace('/', '\/', $disabled_path);
					$clean_disable_path = preg_replace(['/\/$/', '/^\//'], '', $clean_disable_path);
					$hmwp_404_error_rule .= PHP_EOL;

					$imploded_extensions = '$|' . $this->getBlockedExtensions(true);

					// When matching uploads, should remove some of the extensions, such
					// as .xml and .zip as they should be downloadable
					if(false !== strpos($clean_disable_path, 'uploads')) {
						$imploded_extensions = '$|' . $this->getBlockedUploadsExtensions(true);
					}

					$hmwp_404_error_rule .= 'if ($request_uri ~* ^' . $clean_disable_path . '/[^\.]+(' . $imploded_extensions . ')) { set $cond "${cond}+deny_uri"; }';
					$hmwp_404_error_rule .= PHP_EOL;
				}

				if(false !== strpos($disabled_path, 'wp-includes')) {
					$hmwp_404_error_rule .= PHP_EOL;
					$hmwp_404_error_rule .= 'if ($request_uri ~* ^/wp-includes(/.*)?) { set $cond "${cond}+deny_uri"; }';
				}
			}

			// When there are some .php files, should generate rule for them
			if(!empty($php_files_for_404)) {
				$imploded_php_files = implode('|', $php_files_for_404);
				$hmwp_404_error_rule .= 'if ($request_uri ~* ('. $imploded_php_files .')) { set $cond "${cond}+deny_uri"; }';
				$hmwp_404_error_rule .= PHP_EOL;
			}

			// When URL matching secret access GET param, should change cookie condition
			// to allow gran user access
			$hmwp_404_error_rule .= <<<EOT
if (\$args ~ '$access_secret') { set \$cond  "skip"; }
if (\$cond = "cookie+deny_uri") {  return 404; }
EOT;
			return $hmwp_404_error_rule;
		}

		/**
		 * Позволяет получить сгенероиванные плавила конфигурации сервера для печати
		 *
		 * @return string
		 */
		public function getPrintRules()
		{
			$rules = $this->generateRules();
			$output = $this->cleanConfig($rules);

			return $output;
		}

		/**
		 * Метод проверяет существуют ли настройки для этого сервера или нет
		 *
		 * @return bool - truе, если существуют
		 */
		public static function isServerDirectives()
		{
			$opt_remove_x_powered_by = WCL_Plugin::app()->getPopulateOption('remove_x_powered_by');
			$opt_disable_directory_listing = WCL_Plugin::app()->getPopulateOption('disable_directory_listing');

			return $opt_remove_x_powered_by || $opt_disable_directory_listing;
		}

		/**
		 * Позволяет получить настройки сервера
		 *
		 * @return string
		 */
		public static function getServerDirectives()
		{
			$opt_remove_x_powered_by = WCL_Plugin::app()->getPopulateOption('remove_x_powered_by');
			$opt_disable_directory_listing = WCL_Plugin::app()->getPopulateOption('disable_directory_listing');

			$directives = '';

			if( $opt_disable_directory_listing ) {
				$directives = "autoindex off;" . PHP_EOL;
			}

			if( $opt_remove_x_powered_by ) {
				$directives .= "proxy_hide_header X-Powered-By;" . PHP_EOL;
				$directives .= "fastcgi_hide_header X-Powered-By;" . PHP_EOL;
			}

			return $directives;
		}

		/**
		 * Echos rules and directives together.
		 *
		 * Notice: directive rules will be output in case server directive
		 * option is not enabled.
		 *
		 * @see WHM_ConfigurateNginx::isServerDirectives() for further information.
		 */
		public static function printRulesAndDirectives() {

			if( WHM_ConfigurateNginx::isServerDirectives()) {
				self::printDirectives();
				echo str_repeat(PHP_EOL, 2);
			}

			self::printRewriteRules();
		}

		/**
		 * Печатает настройки сервера
		 *
		 * @return void
		 */
		public static function printDirectives()
		{
			$server = new self();

			echo "# BEGIN " . WHM_Helpers::getRulesMarker() . PHP_EOL . $server->getServerDirectives() . "# END " . WHM_Helpers::getRulesMarker();
		}

		/**
		 * Перезаписывает правила в базе данных и создает предупреждение,
		 * что нужно обновить файл конфигурации
		 *
		 * @return bool
		 * @throws Exception on failure to retrieve rewrite rules.
		 */
		public function flushRewriteRulesHard()
		{
			$this->updateRewriteRules();

			// Always create a server configuration error so that the user
			// do not forget to update the configuration manually
			WCL_Plugin::app()->updatePopulateOption('server_configuration_error', 1);

			//nothing
			return false;
		}

		protected function getRewriteRule($from, $to, $flags = "last")
		{
			$from = preg_replace("/\\\\?\.(?!\*)/", "\.", $from);

			return array(
				'type' => 'rewrite',
				'arg1' => $from,
				'arg2' => $to,
				'flags' => $flags
			);
		}
	}