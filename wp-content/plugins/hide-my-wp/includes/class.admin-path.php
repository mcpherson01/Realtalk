<?php

	/**
	 * The controller to process changing the admin path correctly.
	 */
	class WHM_AdminPathController {
		
		/**
		 * @var string
		 */
		public $auth_cookie_name;
		
		/**
		 * @var string
		 */
		public $secure;
		
		/**
		 * @var string
		 */
		public $auth_cookie;
		
		/**
		 * @var int
		 */
		public $expire;

		/**
		 * @var bool
		 */
		private $called = false;
		
		public function __construct()
		{
			if( !WHM_Helpers::isHideModeActive() ) {
				return;
			}

			$optAdminPath = '/' . WCL_Plugin::app()->getPopulateOption('admin_path');
			if( empty($optAdminPath) ) {
				return;
			}

			add_action('set_auth_cookie', array($this, 'saveCookiesData'), 10, 5);
			add_action('wp_login', array($this, 'setCorrectCookies'), 10, 2);
			/**
			 * issue #S01
			 * add_action('wp_before_admin_bar_render', array($this, 'startBufferingAdminMenu'));
			 * add_action('wp_after_admin_bar_render', array($this, 'endBufferingAdminMenu'));
			 */
		}

		public function saveCookiesData($auth_cookie, $expire, $expiration, $user_id, $scheme)
		{

			$this->called = true;

			if( 'secure_auth' === $scheme ) {
				$this->secure = true;
				$this->auth_cookie_name = SECURE_AUTH_COOKIE;
			} else {
				$this->secure = false;
				$this->auth_cookie_name = AUTH_COOKIE;
			}

			$this->auth_cookie = $auth_cookie;
			$this->expire = $expire;
		}

		public function setCorrectCookies()
		{
			if( !$this->called ) {
				return;
			}

			setcookie($this->auth_cookie_name, $this->auth_cookie, $this->expire, '/', COOKIE_DOMAIN, $this->secure, true);
		}

		public function startBufferingAdminMenu()
		{
			ob_start(array($this, 'filterAdminMenu'));
		}

		public function endBufferingAdminMenu()
		{
			ob_end_flush();
		}

		public function filterAdminMenu($content)
		{
			return str_replace('/wp-admin', '/' . WCL_Plugin::app()->getPopulateOption('admin_path'), $content);
		}
	}

	WHM_Plugin::$admin_path_controller = new WHM_AdminPathController();