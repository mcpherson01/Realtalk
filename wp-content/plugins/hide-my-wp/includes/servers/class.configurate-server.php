<?php

	/**
	 * Abstact Server Configuration Class
	 *
	 * @author Alex Kovalev <wordpress.webraftic@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 * @since 1.0.0
	 */
	abstract class WHM_ConfigurateServer {

		/**
		 * @var string
		 */
		protected $server = 'apache';

		/**
		 * @var array
		 */
		protected $rewrite_rules;

		/**
		 * @var array
		 */
		protected $disabled_paths;

		/**
		 * @var array
		 */
		/*protected $white_list_files = array(
			'index.php',
			'xmlrpc.php',
			'wp-login.php',
			'wp-signup.php',
			'wp-activate.php',
			'wp-tinymce.php',
			'wp-cron.php'
			//'wp-admin'
		);*/

		//public function __construct()
		//{
		//$this->rewrite_rules = apply_filters('wbcr_hmwp_rewrite_rules', $this->rewrite_rules, $this->server);
		//$this->disabled_paths = apply_filters('wbcr_hmwp_disabled_paths', $this->disabled_paths, $this->server);
		//$this->exclude_disabled_php_files = apply_filters('wbcr_hmwp_exclude_disabled_php_files', $this->exclude_disabled_php_files, $this->server);
		//}

		public function addRewriteRule($from, $to, $flags = "")
		{
			$this->rewrite_rules[] = $this->getRewriteRule($from, $to, $flags);
		}

		/**
		 * Добавляет правило для блокирования переданного пути
		 *
		 * @param $from
		 * @return mixed
		 */
		public function addDisablePathRule($path)
		{
			$this->disabled_paths[] = $path;
		}

		/**
		 * Позволяет распечатать правила конфигурации сервера для ручной настройки
		 *
		 * @return mixed
		 */
		public static function printRewriteRules()
		{
			echo static::getRewriteRules();
		}


		/**
		 * Позволяет получить правила конфигурации сервера для ручной настройки
		 *
		 * @return mixed
		 */
		public static function getRewriteRules()
		{
			$server = new static();
			$server->loadRewriteRules();

			return "# BEGIN " . WHM_Helpers::getRulesMarker() . PHP_EOL . $server->getPrintRules() . PHP_EOL . "# END " . WHM_Helpers::getRulesMarker();
		}

		/**
		 * Загружает правила конфигурации сервера из базы данных         *
		 */
		public function loadRewriteRules()
		{
			$this->rewrite_rules = (array)WCL_Plugin::app()->getPopulateOption($this->server . '_rewrite_rules', array());
			$this->disabled_paths = (array)WCL_Plugin::app()->getPopulateOption($this->server . '_disabled_paths', array());
		}

		/**
		 * Сохраняет правила конфигурации сервера в базе данных
		 */
		public function updateRewriteRules()
		{
			$this->rewrite_rules = apply_filters('wbcr_hmwp_update_rewrite_rules', $this->rewrite_rules, $this->server);
			$this->disabled_paths = apply_filters('wbcr_hmwp_update_disabled_paths', $this->disabled_paths, $this->server);

			if( !is_array($this->rewrite_rules) || !is_array($this->disabled_paths) ) {
				throw new Exception('Error, unknown data format');
			}

			WCL_Plugin::app()->updatePopulateOption($this->server . '_rewrite_rules', $this->rewrite_rules);
			WCL_Plugin::app()->updatePopulateOption($this->server . '_disabled_paths', $this->disabled_paths);
		}

		/**
		 * Сбросить правила
		 */
		public function resetRules()
		{
			$this->rewrite_rules = array();
			$this->disabled_paths = array();
			$this->exclude_disabled_php_files = array();

			WCL_Plugin::app()->deletePopulateOption($this->server . '_rewrite_rules');
		}

		/**
		 * Get list of general files to be disabled.
		 *
		 * @param bool $implode True when required to implode.
		 * @param string $implode_char Imploding char.
		 * @return array|string
		 */
		protected function getDisabledFilesReg($implode = false, $implode_char = '|')
		{
			$extensions =  array(
				'error_log',
				'wp-config-sample.php',
				'readme.html',
				'readme.txt',
				'license.txt',
				'install.php',
				'wp-config.php',
				'php.ini',
				'bb-config.php'
			);

			if($implode) {
				return implode($implode_char, $extensions);
			}

			return $extensions;
		}

		/**
		 * Get list of blocked extensions in subfolders.
		 *
		 * Example, wp-content/plugins/pluginname/*.txt.
		 *
		 * @param bool $implode True when required to implode.
		 * @param string $implode_char Imploding char.
		 * @return array|string
		 */
		protected function getBlockedExtensions($implode = false, $implode_char = '|') {
			$extensions = [
				'php' => '.php',
				'html' => '.html',
				'htm' => '.htm',
				'rtf' => '.rtf',
				'rtx' => '.rtx',
				'txt' => '.txt',
				'xsd' => '.xsd',
				'xml' => '.xml',
				'zip' => '.zip',
				'pot' => '.pot',
				'po' => '.po',
			];

			if($implode) {
				return implode($implode_char, $extensions);
			}

			return $extensions;
		}

		/**
		 * Get list of downloadable|viewable extensions for uploads folder.
		 *
		 * @param bool $implode True when required to implode.
		 * @param string $implode_char Imploding char.
		 *
		 * @return array|string
		 */
		protected function getBlockedUploadsExtensions($implode = false, $implode_char = '|') {
			$extensions = array_filter($this->getBlockedExtensions(), function($extension) {
				return !in_array($extension, ['xml', 'zip'], true);
			});

			if($implode) {
				return implode($implode_char, $extensions);
			}

			return $extensions;
		}

		/**
		 * Позволяет получить все заблокированные пути
		 *
		 * @return array
		 */
		protected function getDisabledPaths()
		{
			return (array)$this->disabled_paths;
		}

		/**
		 * @param $config
		 *
		 * @return mixed
		 */
		protected function cleanConfig($config)
		{
			$config = str_replace('//', '/', $config);

			if( defined('WP_SITEURL') ) {
				$config = str_replace(WP_SITEURL, '', $config);
			}

			if( defined('WP_HOME') ) {
				$config = str_replace(WP_HOME, '', $config);
			}

			return str_replace(array(site_url(), home_url()), '', $config);
		}

		/**
		 * Добавляет правило для перенаправления
		 *
		 * @param string $from
		 * @param string $to
		 * @param string $flags
		 * @return mixed
		 */
		abstract protected function getRewriteRule($from, $to, $flags = "");

		/**
		 * Генерирует правила конфигураци сервера
		 *
		 * @return string
		 */
		abstract public function generateRules();

		/**
		 * Позволяет получить сгенероиванные плавила конфигурации сервера для печати
		 *
		 * @return string
		 */
		abstract public function getPrintRules();

		/**
		 * Перезаписывает правила в конфигурационном файле
		 *
		 * @return bool
		 */
		abstract public function flushRewriteRulesHard();
	}