<?php
	/*
	 * Inits the admin area for the plugin HideMyWP+
	 *
	 * @author Alex Kovalev <alex@byonepress.com>
	 * @copyright (c) 2018, OnePress Ltd
	 *
	 * @package core
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * @param WHM_Plugin $plugin
	 * @param Wbcr_FactoryPages000_ImpressiveThemplate $obj
	 * @return bool
	 */
	add_action('wbcr/factory/pages/impressive/print_all_notices', function ($plugin, $obj) {
		$is_hmwp = WCL_Plugin::app()->getPluginName() == $plugin->getPluginName();

		if( $is_hmwp && in_array($obj->id, WHM_Helpers::getUseSettingsPages()) ) {
			$default_notice_text = __('To fully use the Hide my wp plugin, you should activate the "%s" component.', 'hide_my_wp');

			$mac_button_print = '';
			$h_minify_button_print = '';
			$hlp_button_print = '';

			if( class_exists('WCL_Plugin') ) {
				$mac_button = WCL_Plugin::app()->getInstallComponentsButton('internal', 'minify_and_combine');
				$mac_button_print = $mac_button->getLink();

				$h_minify_button = WCL_Plugin::app()->getInstallComponentsButton('internal', 'html_minify');
				$h_minify_button_print = $h_minify_button->getLink();

				$hlp_button = WCL_Plugin::app()->getInstallComponentsButton('wordpress', 'hide-login-page/hide-login-page.php');
				$hlp_button_print = $hlp_button->getLink();
			}

			if( !defined('WMAC_PLUGIN_ACTIVE') ) {
				$obj->printWarningNotice(sprintf($default_notice_text, __("Minify and Combine", 'hide_my_wp')) . ' (' . $mac_button_print . ')');
			}
			if( !defined('WHTM_PLUGIN_ACTIVE') ) {
				$obj->printWarningNotice(sprintf($default_notice_text, __("Html minify", 'hide_my_wp')) . ' (' . $h_minify_button_print . ')');
			}
			if( !defined('WHLP_PLUGIN_ACTIVE') ) {
				$obj->printWarningNotice(sprintf($default_notice_text, __("Hide login page", 'hide_my_wp')) . ' (' . $hlp_button_print . ')');
			}
		}
	}, 10, 2);

	/**
	 * Asset additional scripts to the plugin Clearfy
	 *
	 * @see Wbcr_FactoryPages000_AdminPage
	 *
	 * @param Wbcr_Factory000_ScriptList $scripts
	 * @param Wbcr_Factory000_StyleList $styles
	 *
	 * @return void
	 */
	/*add_action('wbcr/clearfy/page_assets', function ($page_id, $scripts, $styles) {
		if( !defined('WBCR_CLEARFY_PLUGIN_ACTIVE') ) {
			return;
		}
		if( $page_id == 'quick_start-' . WCL_Plugin::app()->getPluginName() ) {
			$scripts->add(WHM_PLUGIN_URL . '/admin/assets/js/clearfy-extend-quick-configuration.js');
		}

		if( $page_id == 'components-' . WCL_Plugin::app()->getPluginName() ) {
			$scripts->add(WHM_PLUGIN_URL . '/admin/assets/js/clearfy-extend-components.js');
		}
	}, 10, 3);*/

	/**
	 * We add an additional argument to the list of returned args, after a quick configuration in the plugin Clearfy
	 *
	 * @param array $args
	 * @param string $mode_name
	 *
	 * @return array
	 */
	/*add_filter('wbcr_clearfy/configurate_quick_mode_success_args', function ($args, $mode_name) {
		if( !defined('WBCR_CLEARFY_PLUGIN_ACTIVE') ) {
			return $args;
		}
		if( $mode_name == 'hide_my_wp' || $mode_name == 'reset' ) {
			$page_id = 'quick_start-' . WCL_Plugin::app()->getPluginName();
			$args['redirect_url'] = admin_url('admin.php?page=' . $page_id . '&action=flush-cache-and-rules&_wpnonce=' . wp_create_nonce('wbcr_factory_' . $page_id . '_flush_action'));
		}

		return $args;
	}, 10, 2);*/
	

	/**
	 * Function overwrite the server configuration
	 *
	 * @return void
	 */
	function wbcr_hmwp_flush_rules()
	{
		if( WHM_Helpers::isHideModeActive() ) {
			WHM_Helpers::flushRules();

			return;
		}

		if( WCL_Plugin::app()->isNetworkAdmin() ) {
			$sites = WCL_Plugin::app()->getActiveSites();

			foreach($sites as $site) {
				switch_to_blog($site->blog_id);

				WHM_Helpers::resetOptions();

				restore_current_blog();
			}
		} else {
			WHM_Helpers::resetOptions();
		}
	}

	/**
	 * Flush configuration after saving the settings
	 *
	 * @param WHM_Plugin $plugin
	 * @param Wbcr_FactoryPages000_ImpressiveThemplate $obj
	 * @return bool
	 */
	add_action('wbcr_factory_000_imppage_after_form_save', function ($plugin, $obj) {
		$is_hmwp = WCL_Plugin::app()->getPluginName() == $plugin->getPluginName();

		if( $is_hmwp && in_array($obj->id, WHM_Helpers::getUseSettingsPages()) ) {
			wbcr_hmwp_flush_rules();
		}
	}, 10, 2);

	/**
	 * Flush configuration after activating the fast mode in the Clearfy plugin
	 *
	 * @param string $mode
	 * @return void
	 */
	add_action('wbcr_clearfy_configurated_quick_mode', function ($mode) {
		if( $mode == 'hide_my_wp' || $mode == 'reset' ) {
			wbcr_hmwp_flush_rules();
		}
	}, 20);

	/**
	 * Flush configuration, after importing the settings, through the Clearfy plugin
	 *
	 * @return void
	 */
	add_action('wbcr_clearfy_imported_settings', function () {
		wbcr_hmwp_flush_rules();
	}, 20);

	/**
	 * This action is executed when the component of the Clearfy plugin is activate and if this component is name webcraftic-hide-my-wp
	 */
	add_action('wbcr/clearfy/activated_component', function ($component_name) {
		if( $component_name == 'webcraftic-hide-my-wp' ) {
			require_once WHM_PLUGIN_DIR . '/admin/activation.php';
			$plugin = new WHM_Activation(WCL_Plugin::app());
			$plugin->activate();
		}
	});

	/**
	 * This action is executed when the component of the Clearfy plugin is deactivated and if this component is name webcraftic-hide-my-wp
	 */
	add_action('wbcr_clearfy_pre_deactivate_component', function ($component_name) {
		if( $component_name == 'webcraftic-hide-my-wp' ) {
			require_once WHM_PLUGIN_DIR . '/admin/activation.php';
			$plugin = new WHM_Activation(WCL_Plugin::app());
			$plugin->deactivate();
		}
	});

	/**
	 * @param array $options
	 * @return array
	 */
	function wbcr_hmwp_group_options($options)
	{
		/**
		 * General options
		 */
		$options[] = array(
			'name' => 'hide_my_wp_activate',
			'title' => __('Hidden mode', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => array()
		);
		$options[] = array(
			'name' => 'secret_name',
			'title' => __('Secret name of the variable', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'hide_my_wp'
		);
		$options[] = array(
			'name' => 'secret_key',
			'title' => __('Secret value of the variable', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => strtolower(WHM_Helpers::generateRandomString()),
		);
		$options[] = array(
			'name' => 'disable_directory_listing',
			'title' => __('Disable directory List', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => array()
		);
		/*$options[] = array(
			'name' => 'deny_php_files',
			'title' => __('Deny all php files (except wp-admin)', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => array()
		);*/
		$options[] = array(
			'name' => 'hide_other_wp_files',
			'title' => __('Hide service files(.txt,.log,.html)', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => array()
		);
		/*$options[] = array(
			'name' => 'exclude_php_files',
			'title' => __('Exclude files', 'hide_my_wp'),
			'tags' => array()
		);*/
		$options[] = array(
			'name' => 'remove_x_powered_by',
			'title' => __('Remove X-Powered-By', 'hide_my_wp'),
			'tags' => array('hide_my_wp')
		);

		/**
		 * System paths
		 * --------------------------------------------- */
		$options[] = array(
			'name' => 'admin_path',
			'title' => __('New admin path', 'hide_my_wp'),
			'tags' => array(),
			'values' => array()
		);
		$options[] = array(
			'name' => 'hide_admin_path',
			'title' => __('Disable admin path', 'hide_my_wp'),
			'tags' => array(),
			'values' => array()
		);

		/**
		 * Themes
		 */
		$options[] = array(
			'name' => 'theme_path',
			'title' => __('New theme path', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'template'
		);
		$options[] = array(
			'name' => 'style_file',
			'title' => __('New "style.css" name', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'base.css'
		);
		$options[] = array(
			'name' => 'hide_theme_path',
			'title' => __('Disable theme path', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			//'values' => array()
		);

		/**
		 * Plugins
		 */
		$options[] = array(
			'name' => 'plugins_path',
			'title' => __('New plugins path', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'modules'
		);
		$options[] = array(
			'name' => 'rename_plugins',
			'title' => __('Disable admin path', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'all'
		);
		$options[] = array(
			'name' => 'hide_plugins_path',
			'title' => __('Disable plugins dir', 'hide_my_wp'),
			'tags' => array('hide_my_wp')
		);

		/**
		 * Wp includes
		 */
		$options[] = array(
			'name' => 'wpinclude_path',
			'title' => __('New includes path', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'libs'
		);
		$options[] = array(
			'name' => 'hide_wpinclude_path',
			'title' => __('Disable wp-include dir', 'hide_my_wp'),
			'tags' => array('hide_my_wp')
		);

		/**
		 * Wp content
		 */
		$options[] = array(
			'name' => 'wpcontent_path',
			'title' => __('New content path', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'inc'
		);

		$options[] = array(
			'name' => 'hide_wpcontent_path',
			'title' => __('Disable wp-content dir', 'hide_my_wp'),
			'tags' => array('hide_my_wp')
		);

		/**
		 * Uploads
		 */
		$options[] = array(
			'name' => 'uploads_path',
			'title' => __('New includes path', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'files'
		);
		$options[] = array(
			'name' => 'hide_uploads_path',
			'title' => __('Disable uploads dir', 'hide_my_wp'),
			'tags' => array('hide_my_wp')
		);

		/**
		 * Comments
		 */
		$options[] = array(
			'name' => 'comments_post_file',
			'title' => __('New comments path', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'reviews.php'
		);
		$options[] = array(
			'name' => 'hide_comments_post_file',
			'title' => __('Disable wp-comments-post.php file', 'hide_my_wp'),
			'tags' => array('hide_my_wp')
		);

		/**
		 * Ajax paths
		 */
		$options[] = array(
			'name' => 'ajax_page',
			'title' => __('New ajax path', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'dynamic.php'
		);

		$options[] = array(
			'name' => 'hide_ajax_page',
			'title' => __('Disable admin-ajax.php file', 'hide_my_wp'),
			'tags' => array('hide_my_wp')
		);

		/**
		 * Permalinks paths
		 * --------------------------------------------- */

		/**
		 * Rest api
		 */

		$options[] = array(
			'name' => 'rest_api_base',
			'title' => __('Rest Api Base', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'rest-api'
		);

		$options[] = array(
			'name' => 'rest_api_query',
			'title' => __('Rest Api Query', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'rest_api'
		);

		/**
		 * Authors
		 */
		$options[] = array(
			'name' => 'author_base',
			'title' => __('Authors Base', 'hide_my_wp'),
			'tags' => array(),
			//'values' => 'user'
		);

		$options[] = array(
			'name' => 'author_query',
			'title' => __('Authors Base', 'hide_my_wp'),
			'tags' => array(),
			//'values' => 'user'
		);

		/*$options[] = array(
			'name' => 'remove_author_base',
			'title' => __('Authors Base', 'hide_my_wp'),
			'tags' => array()

		);*/

		/**
		 * Posts
		 */
		/*$options[] = array(
			'name' => 'posts_base',
			'title' => __('Post Permalink', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => '%author%/%postname%'
		);*/

		/*$options[] = array(
			'name' => 'posts_query',
			'title' => __('Post Query', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'article_id'
		);*/

		/**
		 * Pages
		 */

		/*$options[] = array(
			'name' => 'pages_base',
			'title' => __('Post Permalink', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'page'
		);

		$options[] = array(
			'name' => 'pages_query',
			'title' => __('Page Query', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'page_num'
		);*/

		/**
		 * Pagination
		 */

		$options[] = array(
			'name' => 'pagination_base',
			'title' => __('Post Permalink', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'list'
		);

		$options[] = array(
			'name' => 'pagination_query',
			'title' => __('Pagination Query', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'list'
		);

		/**
		 * Pagination
		 */

		/*$options[] = array(
			'name' => 'categories_base',
			'title' => __('Category base', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			//'values' => 'category'
		);*/

		$options[] = array(
			'name' => 'categories_query',
			'title' => __('Category Query', 'hide_my_wp'),
			'tags' => array(),
			//'values' => 'category'
		);

		/**
		 * Tags
		 */

		/*$options[] = array(
			'name' => 'tags_base',
			'title' => __('Tag base', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'keyword'
		);*/

		$options[] = array(
			'name' => 'tags_query',
			'title' => __('Tag Query', 'hide_my_wp'),
			'tags' => array(),
			//'values' => 'keyword'
		);

		/**
		 * Feeds
		 */

		$options[] = array(
			'name' => 'feed_base',
			'title' => __('Feeds base', 'hide_my_wp'),
			'tags' => array(),
			//'values' => 'rss'
		);

		$options[] = array(
			'name' => 'feed_query',
			'title' => __('Feed Query', 'hide_my_wp'),
			'tags' => array(),
			//'values' => 'rss'
		);

		/**
		 * Search
		 */
		$options[] = array(
			'name' => 'search_base',
			'title' => __('Search base', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'search'
		);

		$options[] = array(
			'name' => 'search_query',
			'title' => __('Search Query', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'values' => 'search'
		);

		$options[] = array(
			'name' => 'nice_search_redirect',
			'title' => __('Search base redirect', 'hide_my_wp'),
			'tags' => array('hide_my_wp')
		);

		/**
		 * Privacy contents
		 * --------------------------------------------- */

		$options[] = array(
			'name' => 'replace_javascript_path',
			'title' => __('Search base redirect', 'hide_my_wp'),
			'tags' => array('hide_my_wp'),
			'value' => 1
		);

		$options[] = array(
			'name' => 'remove_feed_meta',
			'title' => __('Feed Meta', 'hide_my_wp'),
			'tags' => array('hide_my_wp')
		);

		$options[] = array(
			'name' => 'remove_default_description',
			'title' => __('Default Tagline', 'hide_my_wp'),
			'tags' => array('hide_my_wp')
		);

		/*$options[] = array(
			'name' => 'remove_body_class',
			'title' => __('Body Classes', 'hide_my_wp'),
			'tags' => array()
		);

		$options[] = array(
			'name' => 'remove_post_class',
			'title' => __('Post Classes', 'hide_my_wp'),
			'tags' => array()
		);

		$options[] = array(
			'name' => 'remove_menu_class',
			'title' => __('Menu Classes', 'hide_my_wp'),
			'tags' => array()
		);*/

		$options[] = array(
			'name' => 'replace_in_ajax',
			'title' => __('Replace in AJAX', 'hide_my_wp'),
			'tags' => array()
		);

		$options[] = array(
			'name' => 'replace_wpnonce',
			'title' => __('Change Nonce', 'hide_my_wp'),
			'tags' => array()
		);

		return $options;
	}

	add_filter("wbcr_clearfy_group_options", 'wbcr_hmwp_group_options');

	/**
	 * Adds a new mode to the Quick Setup page
	 *
	 * @param array $mods
	 * @return mixed
	 */

	add_filter("wbcr_clearfy_allow_quick_mods", function ($mods) {
		$mod['hide_my_wp'] = array(
			'title' => __('One click hide my wp', 'hide_my_wp'),
			'icon' => 'dashicons-hidden',
			'args' => array('flush_redirect' => 1)
		);

		return $mod + $mods;
	});

	//'hide_my_wp'
