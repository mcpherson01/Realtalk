<?php

	/**
	 * Generates and rewrites rules.
	 *
	 * @author Alex Kovalev <alex@byonepress.com><wordpress.webraftic@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 *
	 * @package core
	 * @since 1.0.0
	 */
	abstract class WHM_RewriteRules {

		/**
		 * @var WHM_ConfigurateServer
		 */
		protected $server;

		/**
		 * @var array
		 */
		protected $content_filters;

		/**
		 * @var array
		 */
		protected $content_patterns;

		/**
		 * @var array
		 */
		protected $content_recovery_filters;

		/**
		 * @var array
		 */
		protected $content_recovery_patterns;

		/**
		 * @var array
		 */
		//protected $content_filter_replacements;

		/**
		 * WHM_RewriteRules constructor.
		 *
		 * Prepares class before its usage.
		 *
		 * For example, it predefines server property based on currently active web-server.
		 */
		public function __construct()
		{
			if( WHM_Helpers::isApache() ) {
				require_once WHM_PLUGIN_DIR . '/includes/servers/class.configurate-apache.php';
				$this->server = new WHM_ConfigurateApache();
			} else if( WHM_Helpers::isNginx() ) {
				require_once WHM_PLUGIN_DIR . '/includes/servers/class.configurate-nginx.php';
				$this->server = new WHM_ConfigurateNginx();
			} //else if( WHM_Helpers::isIIS7() || WHM_Helpers::isIIS() ) {
			/*require_once WHM_PLUGIN_DIR . '/includes/servers/class.configurate-apache.php';
			$this->server = new WHM_ConfigurateApache();*/
			//$this->server = null;
			//}
		}


		/**
		 * Reset rules for filters, patterns and web-server ones as well.
		 *
		 * @return void
		 */
		public function resetRules()
		{
			$this->content_filters = array();
			$this->content_patterns = array();

			$this->server->resetRules();
		}

		/**
		 * Calls a set of hooks to filter rules.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function callHooks()
		{
			$this->content_patterns = apply_filters('wbcr_hmwp_content_patterns', $this->content_patterns);
			$this->content_filters = apply_filters('wbcr_hmwp_content_filters', $this->content_filters);
		}

		/**
		 * Prettifying filtering rule format.
		 *
		 * Mostly, this is used as normalization before these rules
		 * inserted into the database.
		 *
		 * @param array $content_filters Array list of content filters.
		 *
		 * @return array
		 */
		public function prepareFilters($content_filters)
		{
			/**
			 * Preparing replacements for hooks and page content.
			 */
			$filters = array(
				'admin' => array(
					'hooks' => array(
						'patterns' => array(),
						'replacements' => array(),
					),
					'content' => array(
						'patterns' => array(),
						'replacements' => array(),
					)
				),
				'public' => array(
					'hooks' => array(
						'patterns' => array(),
						'replacements' => array(),
					),
					'content' => array(
						'patterns' => array(),
						'replacements' => array(),
					)
				)
			);

			foreach((array)$content_filters as $filter) {

				$for_hooks = isset ($filter['what']['all']) || isset($filter['what']['hooks']);
				$for_content = isset ($filter['what']['all']) || isset($filter['what']['content']);

				$for_admin = isset ($filter['where']['anywhere']) || isset($filter['where']['admin']);
				$for_public = isset ($filter['where']['anywhere']) || isset($filter['where']['public']);

				if( $for_admin && $for_hooks ) {
					$filters['admin']['hooks']['patterns'][] = $filter['pattern'];
					$filters['admin']['hooks']['replacements'][] = $filter['replacement'];
				}

				if( $for_admin && $for_content ) {
					$filters['admin']['content']['patterns'][] = $filter['pattern'];
					$filters['admin']['content']['replacements'][] = $filter['replacement'];
				}

				if( $for_public && $for_hooks ) {
					$filters['public']['hooks']['patterns'][] = $filter['pattern'];
					$filters['public']['hooks']['replacements'][] = $filter['replacement'];
				}

				if( $for_public && $for_content ) {
					$filters['public']['content']['patterns'][] = $filter['pattern'];
					$filters['public']['content']['replacements'][] = $filter['replacement'];
				}
			}

			return $filters;
		}

		public function addContentFilter($pattern, $replacement, $what = null, $where = null)
		{
			$this->content_filters[] = array(
				'pattern' => $pattern,
				'replacement' => $replacement,
				'what' => empty($what)
					? array('all' => true)
					: $what,
				'where' => empty($where)
					? array('anywhere' => true)
					: $where
			);
		}

		public function addContentFilterPattern($pattern, $replacement, $what = null, $where = null)
		{
			$this->content_patterns[] = array(
				'pattern' => $pattern,
				'replacement' => $replacement,
				'what' => empty($what)
					? array('all' => true)
					: $what,
				'where' => empty($where)
					? array('anywhere' => true)
					: $where
			);
		}

		public function addContentRecoveryFilter($pattern, $replacement)
		{
			$this->content_recovery_filters['patterns'][] = $pattern;
			$this->content_recovery_filters['replacements'][] = $replacement;
		}

		public function addContentRecoveryFilterPattern($pattern, $replacement)
		{
			$this->content_recovery_patterns['patterns'][] = $pattern;
			$this->content_recovery_patterns['replacements'][] = $replacement;
		}

		/**
		 * Добавляем правило перенаправления для конфигураци сервера
		 *
		 * @param $from
		 * @param $to
		 * @param string $flags
		 */
		public function addRewriteRule($from, $to, $flags = "")
		{
			$this->server->addRewriteRule($from, $to, $flags);
		}

		/**
		 * Добавляем пути к файлам и директориям в список заблокированных
		 *
		 * @param $path
		 */
		public function addDisablePathRule($path)
		{
			$this->server->addDisablePathRule($path);
		}

		/**
		 * Добавляем Php файлы в список исключений
		 *
		 * @param $path
		 */
		/*public function excludeDisabledPhpFiles($path)
		{
			$this->server->excludeDisabledPhpFiles($path);
		}*/

		/**
		 * Saved collected rewrites.
		 *
		 * @return void
		 */
		public function saveCollections()
		{
			$replace_content_patterns = apply_filters('wbcr_hmwp_replace_content_patterns', $this->content_patterns);
			$replace_content_filters = apply_filters('wbcr_hmwp_replace_content_filters', $this->content_filters);
			$recovery_content_patterns = apply_filters('wbcr_hmwp_recovery_content_patterns', $this->content_recovery_patterns);
			$recovery_content_filters = apply_filters('wbcr_hmwp_recovery_content_filters', $this->content_recovery_filters);

			$replace_content_patterns = $this->prepareFilters($replace_content_patterns);
			$replace_content_filters = $this->prepareFilters($replace_content_filters);

			WCL_Plugin::app()->updatePopulateOption('replace_content_filters', $replace_content_filters);
			WCL_Plugin::app()->updatePopulateOption('replace_content_patterns', $replace_content_patterns);
			WCL_Plugin::app()->updatePopulateOption('recovery_content_patterns', $recovery_content_patterns);
			WCL_Plugin::app()->updatePopulateOption('recovery_content_filters', $recovery_content_filters);

			WHM_Plugin::$content_filter->reload();
		}

		/**
		 * Flushes web-server rewrite rules.
		 *
		 * @return bool
		 * @throws Exception on failure.
		 */
		public function flushRewriteRulesHard()
		{
			return $this->server->flushRewriteRulesHard();
		}
	}