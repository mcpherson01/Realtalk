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
	class WHM_PermalinkRules {

		/**
		 * @var bool
		 */
		protected $disable_queries;

		public function __construct()
		{
			add_action('init', array($this, 'applyRuntimeRules'));
			//wbcr_factory_000_imppage_after_form_save
			add_action('wbcr_factory_000_imppage_saved', array($this, 'applyPermalinksRules'));
			add_action('wbcr_clearfy_configurated_quick_mode', array($this, 'applyPermalinksRules'));
			add_action('wbcr_clearfy_imported_settings', array($this, 'applyPermalinksRules'));
			add_action('plugins_loaded', array($this, 'setApiPrefix'));
			//add_action('permalink_structure_changed', array($this, 'setPluginPostPermalink'), 10, 2);

			//add_action('wp', array($this, 'show404'), 0);

			if( WHM_Helpers::isPermalink() ) {
				add_action('template_redirect', array($this, 'setSearchRedirect'));
			}

			$this->disable_queries = (int)WCL_Plugin::app()->getPopulateOption('disable_queries');
		}

		/*
		* @global WP_Rewrite $wp_rewrite
		* @since 1.0.0
		* @global string $wp_version
		* @global string $wp_version
		* @return void
		*/
		public function setApiRunTime($force = false)
		{
			global $wp_version, $wp;

			$actual_version = version_compare($wp_version, '4.7', '>=');

			if( $actual_version ) {

				$opt_rest_api_base = rtrim(trim(WCL_Plugin::app()->getPopulateOption('rest_api_base'), ' /'), ' /');

				if( !empty($opt_rest_api_base) && $opt_rest_api_base != 'wp-json' ) {
					add_filter('rest_url_prefix', function () use ($opt_rest_api_base) {
						return $opt_rest_api_base;
					});
				}

				if( !$force ) {
					$opt_rest_api_query = WCL_Plugin::app()->getPopulateOption('rest_api_query');

					if( !empty($opt_rest_api_query) && $opt_rest_api_query != 'rest_route' ) {
						$this->removeQueryVars(array('rest_route'));

						$wp->add_query_var($opt_rest_api_query);

						if( isset($_GET[$opt_rest_api_query]) ) {
							$_GET['rest_route'] = $_GET[$opt_rest_api_query];
						}

						add_filter('rest_url', function ($url) use ($opt_rest_api_query) {
							return str_replace("rest_route=", "' . $opt_rest_api_query . '=", $url);
						}, 1000, 1);
					}
				}
			}
		}

		public function setApiPrefix()
		{
			$this->setApiRunTime(true);
		}

		/*
		* @global WP_Rewrite $wp_rewrite
		* @since 1.0.0
		* @return void
		*/
		public function setAuthorRunTime()
		{
			global $wp_rewrite, $wp;

			$opt_author_query = WCL_Plugin::app()->getPopulateOption('author_query');
			/*$opt_remove_author_base = (int)WCL_Plugin::app()->getPopulateOption('remove_author_base');

			if( $opt_remove_author_base && WHM_Helpers::isPermalink() ) {
				$wp_rewrite->author_structure = $wp_rewrite->root . '/%author%';
			}*/

			$opt_author_base = WCL_Plugin::app()->getPopulateOption('author_base');

			if( !empty($opt_author_base) && WHM_Helpers::isPermalink() ) {
				$wp_rewrite->author_base = $opt_author_base;
			}

			if( !empty($opt_author_query) && $opt_author_query != 'author' && !is_admin() ) {

				$this->removeQueryVars(array('author', 'author_name'));

				$wp->add_query_var($opt_author_query);

				if( isset($_GET[$opt_author_query]) && is_numeric($_GET[$opt_author_query]) ) {
					$_GET['author'] = $_GET[$opt_author_query];
				}

				if( isset($_GET[$opt_author_query]) && !is_numeric($_GET[$opt_author_query]) ) {
					$_GET['author_name'] = $_GET[$opt_author_query];
				}
			}
		}

		/*
		* @global WP_Rewrite $wp_rewrite
		* @since 1.0.0
		* @return void
		*/
		public function setFeedRunTime()
		{
			global $wp_rewrite, $wp;

			// feeds
			$opt_feed_base = trim(WCL_Plugin::app()->getPopulateOption('feed_base'), ' /');

			if( !empty($opt_feed_base) && $opt_feed_base != 'feed' && WHM_Helpers::isPermalink() ) {

				$wp_rewrite->feed_base = $opt_feed_base;

				add_feed($opt_feed_base, array('WHM_Helpers', 'doFeedBase'));

				// removing the default fead
				foreach($wp_rewrite->feeds as $index => $name) {
					if( 'feed' !== $name ) {
						continue;
					}
					unset($wp_rewrite->feeds[$index]);
					break;
				}
			}

			$opt_feed_query = WCL_Plugin::app()->getPopulateOption('feed_query');

			if( !empty($opt_feed_query) && $opt_feed_query != 'feed' && !is_admin() ) {

				$this->removeQueryVars(array('feed'));

				$wp->add_query_var($opt_feed_query);

				if( isset($_GET[$opt_feed_query]) ) {
					$_GET['feed'] = $_GET[$opt_feed_query];
				}
			}
		}

		/*
		* Posts
		* @since 1.0.0
		* @return void
		*/
		public function setPostsRunTime()
		{
			global $wp;

			$opt_posts_query = WCL_Plugin::app()->getPopulateOption('posts_query');

			// todo: проверить для чего это нужно
			//$is_preview = isset($_GET['preview']) && is_user_logged_in() && current_user_can('edit_posts');

			if( !empty($opt_posts_query) && $opt_posts_query != 'p' && !is_admin() ) {
				$this->removeQueryVars(array('p'));

				$wp->add_query_var($opt_posts_query);

				if( isset($_GET[$opt_posts_query]) && is_numeric($_GET[$opt_posts_query]) ) {
					$_GET['p'] = $_GET[$opt_posts_query];
				}
			}
		}

		/*
		* Pages
		* @global WP_Rewrite $wp_rewrite
		* @since 1.0.0
		* @return void
		*/
		public function setPagesRunTime()
		{
			global $wp_rewrite, $wp;

			$opt_page_base = WCL_Plugin::app()->getPopulateOption('pages_base');

			if( !empty($opt_page_base) && WHM_Helpers::isPermalink() ) {
				$wp_rewrite->page_structure = $wp_rewrite->root . '/' . $opt_page_base . '/' . '%pagename%';
			}

			$opt_page_query = WCL_Plugin::app()->getPopulateOption('pages_query');

			if( !empty($opt_page_query) && $opt_page_query != 'page_id' && !is_admin() ) {
				$this->removeQueryVars(array('page_id', 'pagename'));

				$wp->add_query_var($opt_page_query);

				if( isset($_GET[$opt_page_query]) && is_numeric($_GET[$opt_page_query]) ) {
					$_GET['page_id'] = $_GET[$opt_page_query];
				}

				if( isset($_GET[$opt_page_query]) && !is_numeric($_GET[$opt_page_query]) ) {
					$_GET['pagename'] = $_GET[$opt_page_query];
				}
			}
		}

		/*
		* @global WP_Rewrite $wp_rewrite
		* @since 1.0.0
		* @return void
		*/
		public function setPaginationRunTime()
		{
			global $wp_rewrite, $wp;

			// pagination

			$opt_pagination_base = WCL_Plugin::app()->getPopulateOption('pagination_base');

			if( !empty($opt_pagination_base) && WHM_Helpers::isPermalink() ) {
				$wp_rewrite->pagination_base = $opt_pagination_base;
			}

			$opt_pagination_query = WCL_Plugin::app()->getPopulateOption('pagination_query');

			if( !empty($opt_pagination_query) && $opt_pagination_query != 'paged' && !is_admin() ) {
				$this->removeQueryVars(array('paged'));

				$wp->add_query_var($opt_pagination_query);

				if( isset($_GET[$opt_pagination_query]) ) {
					$_GET['paged'] = $_GET[$opt_pagination_query];
				}

				add_filter('paginate_links', array($this, 'removeQueryArgsInPaginateLinks'));
			}
		}

		/**
		 * @param $link
		 * @return string
		 */
		public function removeQueryArgsInPaginateLinks($link)
		{
			$opt_pagination_query = WCL_Plugin::app()->getPopulateOption('pagination_query');

			if( empty($opt_pagination_query) || is_admin() ) {
				return $link;
			}

			return remove_query_arg($opt_pagination_query, $link);
		}


		/*
		* @since 1.0.0
		* @return void
		*/
		public function setCategoriesRunTime()
		{
			global $wp;

			$opt_categories_query = WCL_Plugin::app()->getPopulateOption('categories_query');

			if( !empty($opt_categories_query) && $opt_categories_query != 'cat' && !is_admin() ) {

				$this->removeQueryVars(array('cat', 'category_name'));

				$wp->add_query_var($opt_categories_query);

				if( isset($_GET[$opt_categories_query]) && is_numeric($_GET[$opt_categories_query]) ) {
					$_GET['cat'] = $_GET[$opt_categories_query];
				}

				if( isset($_GET[$opt_categories_query]) && !is_numeric($_GET[$opt_categories_query]) ) {
					$_GET['category_name'] = $_GET[$opt_categories_query];
				}
			}
		}

		/*
		* @since 1.0.0
		* @return void
		*/
		public function setTagsRunTime()
		{
			global $wp;

			$opt_tags_query = WCL_Plugin::app()->getPopulateOption('tags_query');

			if( !empty($opt_tags_query) && $opt_tags_query != 'tag' && !is_admin() ) {

				$this->removeQueryVars(array('tag'));

				$wp->add_query_var($opt_tags_query);

				if( isset($_GET[$opt_tags_query]) ) {
					$_GET['tag'] = $_GET[$opt_tags_query];
				}
			}
		}

		/*
		* @global WP_Rewrite $wp_rewrite
		* @since 1.0.0
		* @return void
		*/
		public function setSearchRunTime()
		{
			global $wp_rewrite, $wp;

			// search

			$opt_search_base = WCL_Plugin::app()->getPopulateOption('search_base');

			if( !empty($opt_search_base) && WHM_Helpers::isPermalink() ) {
				$wp_rewrite->search_base = $opt_search_base;
			}

			$opt_search_query = WCL_Plugin::app()->getPopulateOption('search_query');

			if( !empty($opt_search_query) && $opt_search_query != 's' && !is_admin() ) {
				$this->removeQueryVars(array('s'));

				$wp->add_query_var($opt_search_query);

				if( isset($_GET[$opt_search_query]) ) {
					$_GET['s'] = $_GET[$opt_search_query];
				}
			}
		}

		/*
		* @global WP_Rewrite $wp_rewrite
		* @since 1.0.0
		* @return void
		*/
		public function setSearchRedirect()
		{
			global $wp_rewrite;

			$opt_search_query = WCL_Plugin::app()->getPopulateOption('search_query');
			$opt_nice_search_redirect = WCL_Plugin::app()->getPopulateOption('nice_search_redirect');

			if( $opt_nice_search_redirect ) {
				$search_base = $wp_rewrite->search_base;

				if( is_search() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false ) {
					if( isset($_GET['s']) ) {
						$keyword = get_query_var('s');
					}

					if( isset($_GET[$opt_search_query]) ) {
						$keyword = get_query_var($opt_search_query);
					}

					wp_redirect(home_url("/{$search_base}/" . urlencode($keyword)));
					exit();
				}
			}
		}

		/**
		 * Синхронизируем параметр постоянных ссылок
		 *
		 * @param $old_permalink
		 * @param $permalink
		 */
		/*public function setPluginPostPermalink( $old_permalink, $permalink ) {
			WCL_Plugin::app()->updatePopulateOption('posts_base', $permalink);
		}*/

		/**
		 * @global Wp_Rewrite $wp_rewrite
		 * @param bool $force
		 */
		public function applyRuntimeRules($force = false)
		{
			if( !WHM_Helpers::isHideModeActive() ) {
				return;
			}
			if( !$force && isset($_POST[WCL_Plugin::app()->getPluginName() . '_save_action']) ) {
				return;
			}

			// posts
			// see setPostPermalinkStructure

			// categories
			// see setCatsPermalinkStructure

			// tags
			// see setTagsPermalinkStructure

			$this->setApiRunTime();
			$this->setFeedRunTime();
			$this->setAuthorRunTime();
			$this->setPagesRunTime();
			$this->setPostsRunTime();
			$this->setPaginationRunTime();
			$this->setSearchRunTime();
			$this->setCategoriesRunTime();
			$this->setTagsRunTime();
		}

		/*
		* @global WP_Rewrite $wp_rewrite
		* @since 1.0.0
		* @return void
		*/
		public function setFeedPermalinkStructure()
		{
			global $wpdb;

			// feeds

			// - reseting the feed cache
			$opt_feed_base = WCL_Plugin::app()->getPopulateOption('feed_base');

			if( !empty($opt_feed_base) ) {
				$wpdb->query("DELETE FROM " . $wpdb->options . " WHERE option_name LIKE '_transient%_feed_%'");
			}
		}

		/*
		* @global WP_Rewrite $wp_rewrite
		* @since 1.0.0
		* @return void
		*/
		public function setPostPermalinkStructure()
		{
			global $wp_rewrite;

			// posts

			/*$opt_post_permalink_structure = WCL_Plugin::app()->getPopulateOption('posts_base');

			if( !empty($opt_post_permalink_structure) ) {
				remove_action('permalink_structure_changed', array($this, 'setPluginPostPermalink'), 10);
				$wp_rewrite->set_permalink_structure($opt_post_permalink_structure);
			}*/
		}

		/*
		* @global WP_Rewrite $wp_rewrite
		* @since 1.0.0
		* @return void
		*/
		public function setCatsPermalinkStructure()
		{
			global $wp_rewrite;

			// categories

			$opt_categories_base = WCL_Plugin::app()->getPopulateOption('categories_base');

			if( !empty($opt_categories_base) ) {
				$wp_rewrite->set_category_base($opt_categories_base);
			}
		}

		/*
		* @global WP_Rewrite $wp_rewrite
		* @since 1.0.0
		* @return void
		*/
		public function setTagsPermalinkStructure()
		{
			global $wp_rewrite;

			// tags

			$opt_tags_base = WCL_Plugin::app()->getPopulateOption('tags_base');

			if( !empty($opt_tags_base) ) {
				$wp_rewrite->set_tag_base($opt_tags_base);
			}
		}

		/**
		 * Updates properties of the object $wp_rewrite
		 * @global WP_Rewrite $wp_rewrite
		 * @since 1.0.0
		 * @return void
		 */
		public function applyPermalinksRules()
		{
			if( !WHM_Helpers::isHideModeActive() ) {
				return;
			}
			// runtime rules

			$this->applyRuntimeRules(true);

			if( WHM_Helpers::isPermalink() ) {
				$this->setCatsPermalinkStructure();
				$this->setFeedPermalinkStructure();
				$this->setPostPermalinkStructure();
				$this->setTagsPermalinkStructure();
				$this->setFeedPermalinkStructure();
			}
		}

		public function blockAccess()
		{

			status_header(404);
			nocache_headers();

			$headers = array('X-Pingback' => get_bloginfo('pingback_url'));
			$headers['Content-Type'] = get_option('html_type') . '; charset=' . get_option('blog_charset');

			foreach((array)$headers as $name => $field_value) {
				@header("{$name}: {$field_value}");
			}

			//wp-login.php wp-admin and direct .php access can not be implemented using 'wp' hook block_access can't work correctly with init hook so we use wp_remote_get to fix the problem
			/*if ( $this->h->str_contains($_SERVER['PHP_SELF'], '/wp-admin/') || $this->h->ends_with($_SERVER['PHP_SELF'], '.php')) {

				if ($this->opt('custom_404') && $this->opt('custom_404_page') )   {
					wp_redirect(add_query_arg( array('by_user'=>$visitor, 'ref_url'=> urldecode($_SERVER["REQUEST_URI"])), home_url( '?'.$this->opt('page_query').'=' . $this->opt('custom_404_page') ))) ;
				}else{
					$response = @wp_remote_get( home_url('/nothing_404_404'.$this->trust_key) );

					if ( ! is_wp_error($response) )
						echo $response['body'];
					else
						wp_redirect( home_url('/404_Not_Found')) ;
				}

			}else{
				if(get_404_template())
					require_once( get_404_template() );
				else
					require_once(get_single_template());
			}*/

			die();
		}

		/**
		 * Shows the error 404 for the disabled pages.
		 */
		public function show404()
		{
			global $wp_query, $post;

			/*if ((is_date() || is_time()) && !isset($_GET['monthnum']) && !isset($_GET['m'])  && !isset($_GET['w']) && !isset($_GET['second']) && !isset($_GET['year']) && !isset($_GET['day']) && !isset($_GET['hour']) && !isset($_GET['second']) && !isset($_GET['minute']) && !isset($_GET['calendar']) && $this->opt('disable_archive'))
				$this->block_access();

			if ((is_tax() || is_post_type_archive() || is_trackback() || is_attachment()) && !isset($_GET['post_type']) && !isset($_GET['taxonamy']) && !isset($_GET['attachment']) && !isset($_GET['attachment_id']) && !isset($_GET['preview']) && $this->opt('disable_other_wp'))
				$this->block_access();

			if (isset($_SERVER['HTTP_USER_AGENT']) && !is_404() && !is_home() && (stristr($_SERVER['HTTP_USER_AGENT'], 'BuiltWith') || stristr($_SERVER['HTTP_USER_AGENT'], '2ip.ru')) )
				wp_redirect(home_url());

			if ($this->opt('remove_other_meta')){
				if (function_exists('header_remove')){
					header_remove('X-Powered-By'); // PHP 5.3+
					header_remove('WP-Super-Cache');
				}else{
					header('X-Powered-By: ');
					header('WP-Super-Cache: ');
				}
			}*/
			
			// authors

			//$opt_disable_queries = WCL_Plugin::app()->getPopulateOption('disable_queries');

			//$opt_disable_queries = WCL_Plugin::app()->getPopulateOption('disable_queries');

			/*if( is_author() ) {
				$wp_query->set_404();
			}*/

			// feeds

			/*$opt_feeds = WCL_Plugin::app()->getPopulateOption('feeds', 'on');

			if( 'off' === $opt_feeds && is_feed() ) {
				$wp_query->is_feed = false;
				$wp_query->set_404();
			}

			// posts

			$opt_posts = WCL_Plugin::app()->getPopulateOption('posts', 'on');

			if( 'off' === $opt_posts && is_single() && 'post' === $post->post_type ) {
				$wp_query->set_404();
			}

			// pages

			$opt_pages = WCL_Plugin::app()->getPopulateOption('pages', 'on');

			if( 'off' === $opt_pages && is_page() ) {
				$wp_query->set_404();
			}

			// pagination
			
			$opt_pagination = WCL_Plugin::app()->getPopulateOption('pagination', 'on');

			if( 'off' === $opt_pagination && is_paged() ) {
				$wp_query->set_404();
			}

			// categories

			$opt_categories = WCL_Plugin::app()->getPopulateOption('categories', 'on');

			if( 'off' === $opt_categories && is_category() ) {
				$wp_query->set_404();
			}

			// tags

			$opt_tags = WCL_Plugin::app()->getPopulateOption('tags', 'on');

			if( 'off' === $opt_tags && is_tag() ) {
				$wp_query->set_404();
			}

			// search

			$optS_search = WCL_Plugin::app()->getPopulateOption('search', 'on');

			if( 'off' === $optS_search && is_search() ) {
				$wp_query->set_404();
			}*/
		}

		/**
		 * @param array $vars
		 */
		protected function removeQueryVars(array $vars)
		{
			if( is_admin() ) {
				return;
			}

			if( $this->disable_queries ) {
				foreach($vars as $arg) {
					unset($_GET[$arg]);
				}
			}
		}
	}

	new WHM_PermalinkRules();