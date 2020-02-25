<?php

/**
 * Generates and rewrites rules.
 *
 * @author        Alex Kovalev <alex@byonepress.com><wordpress.webraftic@gmail.com>
 * @since         1.0.0
 * @package       core
 * @copyright (c) 2018, Webcraftic Ltd
 *
 */
class WHM_GenerateRules extends WHM_RewriteRules {

	public function __construct() {
		$this->setRequestWPnonce();

		parent::__construct();

		add_filter( 'flush_rewrite_rules_hard', [ $this, 'generateRules' ], 999 );
	}

	/**
	 * Generate WP rules to rewrite.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	public function generateRules() {
		if ( ! WHM_Helpers::isHideModeActive() ) {
			return true;
		}

		$this->processRules();

		return true;
	}

	/**
	 * Process rules
	 */
	private function processRules() {
		$this->setAndCompileRules();

		$this->flushRewriteRulesHard();

		//$dgg = WHM_ConfigurateNginx::getRewriteRules();
		//$xd = '';
	}

	/**
	 * Set and compile rules
	 */
	public function setAndCompileRules() {
		$this->resetRules();

		$this->setFeedRules();
		$this->setPluginsRules();
		$this->setThemesRules();
		$this->setUploadsDirRules();
		$this->setMultisite();
		$this->setWpContentRules();
		$this->disableServiceFiles();
		$this->setWpInludesRules();
		$this->setAdminAjaxRules();
		$this->setWpAdminRules();
		$this->setWpCommentsPostRules();
		$this->setApiRules();
		$this->setWPnonce();

		if ( ! WHM_Helpers::isPermalink() ) {
			$this->setAuthorNoPermalinksFilters();
			$this->setFeedNoPermalinksFilters();
			$this->setPageNoPermalinksFilters();
			$this->setPostNoPermalinksFilters();
			$this->setPaginationNoPermalinksFilters();
			$this->setSearchNoPermalinksFilters();
			$this->setCategoriesNoPermalinksFilters();
			$this->setTagsNoPermalinksFilters();
		}

		$this->saveCollections();
	}

	/* ----------------------------------------------------------------- *
	 *  Замена старых url, если отключены постоянные ссылки
	 * ----------------------------------------------------------------- */

	public function setAuthorNoPermalinksFilters() {
		$opt_author_query = WCL_Plugin::app()->getPopulateOption( 'author_query' );

		if ( ! empty( $opt_author_query ) && $opt_author_query != 'author' ) {
			$this->addContentFilterPattern( '#(' . home_url() . '(/\?)[0-9a-z=_/.&\-;]*)((author|author_name)=)#', '$1' . $opt_author_query . '=' );
		}
	}

	public function setFeedNoPermalinksFilters() {
		$opt_feed_query = WCL_Plugin::app()->getPopulateOption( 'feed_query' );

		if ( ! empty( $opt_feed_query ) && $opt_feed_query != 'feed' ) {
			$this->addContentFilterPattern( '#(' . home_url() . '(/\?)[0-9a-z=_/.&\-;]*)(feed=)#', '$1' . $opt_feed_query . '=' );
		}
	}

	public function setPageNoPermalinksFilters() {
		$opt_page_query = WCL_Plugin::app()->getPopulateOption( 'pages_query' );

		if ( ! empty( $opt_page_query ) && $opt_page_query != 'page_id' ) {
			$this->addContentFilterPattern( '#(' . home_url() . '(/\?)[0-9a-z=_/.&\-;]*)((page_id|pagename)=)#', '$1' . $opt_page_query . '=' );
		}
	}

	public function setPostNoPermalinksFilters() {
		$opt_posts_query = WCL_Plugin::app()->getPopulateOption( 'posts_query' );

		if ( ! empty( $opt_posts_query ) && $opt_posts_query != 'p' ) {
			$this->addContentFilterPattern( '#(' . home_url() . '(/\?)[0-9a-z=_/.&\-;]*)(p=)#', '$1' . $opt_posts_query . '=' );
		}
	}

	public function setPaginationNoPermalinksFilters() {
		$opt_pagination_query = trim( WCL_Plugin::app()->getPopulateOption( 'pagination_query' ) );

		if ( ! empty( $opt_pagination_query ) && $opt_pagination_query != 'paged' ) {
			$this->addContentFilterPattern( '#(' . home_url() . '(/\?)[0-9a-z=_/.&\-;]*)(paged=)#', '$1' . $opt_pagination_query . '=' );
		}
	}

	public function setSearchNoPermalinksFilters() {
		$opt_search_query = WCL_Plugin::app()->getPopulateOption( 'search_query' );

		if ( ! empty( $opt_search_query ) && $opt_search_query != 's' ) {
			$this->addContentFilterPattern( '#name=(\'|\")s(\'|\")#', "name='" . $opt_search_query . "'" );
		}
	}

	public function setCategoriesNoPermalinksFilters() {
		$opt_categories_query = WCL_Plugin::app()->getPopulateOption( 'categories_query' );

		if ( ! empty( $opt_categories_query ) && $opt_categories_query != 'cat' ) {
			$this->addContentFilterPattern( '#(' . home_url() . '(/\?)[0-9a-z=_/.&\-;]*)((cat|category_name)=)#', '$1' . $opt_categories_query . '=' );
		}
	}

	public function setTagsNoPermalinksFilters() {
		$opt_tags_query = WCL_Plugin::app()->getPopulateOption( 'tags_query' );

		if ( ! empty( $opt_tags_query ) && $opt_tags_query != 'tag' ) {
			$this->addContentFilterPattern( '#(' . home_url() . '(/\?)[0-9a-z=_/.&\-;]*)(tag=)#', '$1' . $opt_tags_query . '=' );
		}
	}

	public function setFeedRules() {
		$opt_feed_base = trim( WCL_Plugin::app()->getPopulateOption( 'feed_base' ), ' /' );

		if ( ! empty( $opt_feed_base ) && $opt_feed_base != 'feed' ) {
			$this->addContentFilterPattern( '#(' . home_url() . '/[0-9a-z_\-/.]*)(/feed)#', '$1/' . $opt_feed_base );
		}
	}

	/* ----------------------------------------------------------------- *
	 * Правила перенаправлений для севера
	 * ----------------------------------------------------------------- */

	/**
	 * @global string $wp_version
	 */
	public function setApiRules() {
		global $wp_version;

		$actual_version = version_compare( $wp_version, '4.7', '>=' );

		if ( $actual_version ) {

			$opt_rest_api_query = WCL_Plugin::app()->getPopulateOption( 'rest_api_query' );
			$opt_rest_api_base  = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'rest_api_base' ), ' /' ), ' /' );

			if ( ! empty( $opt_rest_api_base ) ) {
				if ( $opt_rest_api_base == 'wp-json' ) {
					return;
				}
			}

			if ( ! empty( $opt_rest_api_query ) || ! empty( $opt_rest_api_base ) ) {
				$this->addContentFilter( " rel='https://api.w.org/'", "" );
			}
		}
	}

	public function setThemesRules() {
		$wp_content_path  = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'wpcontent_path' ), ' /' ), ' /' );
		$theme_path       = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'theme_path' ), ' /' ), ' /' );
		$child_theme_path = $theme_path . '_c';
		$style_file_name  = WCL_Plugin::app()->getPopulateOption( 'style_file' );

		$theme = wp_get_theme();
		$root  = WHM_Helpers::getNotEmptySubFolder();

		$rgx_part_1 = "wp-content";

		if ( ! empty( $wp_content_path ) ) {
			$rgx_part_1 = "(?:wp-content|{$wp_content_path})";
		}

		// changing a filename of the file style.css
		if ( ! empty( $style_file_name ) ) {

			if ( is_child_theme() ) {
				$theme_dir_name = $theme->stylesheet;
				$new_style_path = $child_theme_path;
			} else {
				$theme_dir_name = $theme->template;
				$new_style_path = $theme_path;
			}

			$next_style_path = empty( $theme_path ) ? "wp-content/themes/$theme_dir_name" : $new_style_path;

			$this->addRewriteRule( "^{$root}{$next_style_path}/$style_file_name", $root . "wp-content/themes/$theme_dir_name/style.css" );

			// The second part of the regular expression
			$rgx_part_2 = "(?:$theme_path|{$theme->template})";

			if ( is_child_theme() ) {
				$rgx_part_2 = "(?:{$theme_path}|{$child_theme_path}|{$theme->template}";
				if ( $theme->stylesheet != $theme->template ) {
					$rgx_part_2 .= "|{$theme->stylesheet}";
				}
				$rgx_part_2 .= ")";
			}

			// e.g.
			// wp-content/themes/twentyfourteen/style.css => template/main.css
			// inc/themes/twentyfourteen/style.css => template/main.css
			// template/style.css => template/main.css
			$this->addContentFilterPattern( "#\/{$rgx_part_1}\/themes\/$rgx_part_2\/style\.css#", "/$next_style_path/$style_file_name" );

			// e.g.
			// inc/themes/twentyfourteen/style.css => "/wp-content/themes/theme_name/style.css"
			$this->addContentRecoveryFilterPattern( "#\/{$rgx_part_1}\/themes\/$rgx_part_2\/style\.css#", "/wp-content/themes/$theme_dir_name/style.css" );
			// e.g.
			// template/main.css => "/wp-content/themes/theme_name/style.css"
			$this->addContentRecoveryFilter( "/$next_style_path/$style_file_name", "/wp-content/themes/$theme_dir_name/style.css" );
		}

		// changing the theme path
		if ( ! empty( $theme_path ) ) {

			$this->addRewriteRule( "^{$root}{$theme_path}/(.*)", $root . "wp-content/themes/" . $theme->template . "/$1" );

			if ( is_child_theme() ) {
				$this->addRewriteRule( "^{$root}{$child_theme_path}/(.*)", $root . "wp-content/themes/" . $theme->stylesheet . "/$1" );
			}

			$old_theme_path = "wp-content/themes/" . ( is_child_theme() ? $theme->stylesheet : $theme->template );

			$new_theme_path = empty( $theme_path ) ? $old_theme_path : $theme_path;

			$new_child_theme_path = empty( $theme_path ) ? $old_theme_path : $child_theme_path;

			/**
			 * Replaces regular URLs:
			 * wp-content/themes/twentyfourteen/ => template/
			 * inc/themes/twentyfourteen/ => template/
			 *
			 * and replaces URLs inside JSON object:
			 * wp-content\/themes\/twentyfourteen\/ => template/
			 * inc\/themes\/twentyfourteen\/ => template/
			 */
			$theme_filter_pattern     = "#\/{$rgx_part_1}\/themes\/{$theme->template}\/#";
			$theme_json_filter_patter = str_replace( '\/', '\\\\\\/', $theme_filter_pattern );

			$this->addContentFilterPattern( $theme_filter_pattern, "/$new_theme_path/" );
			$this->addContentFilterPattern( $theme_json_filter_patter, "/$new_theme_path/" );

			// e.g.
			// wp-content/themes/twentyfourteen/ => wp-content/themes/theme_name/
			// inc/themes/twentyfourteen/ => wp-content/themes/theme_name/
			$this->addContentRecoveryFilterPattern( "#\/{$rgx_part_1}\/themes\/{$theme->template}\/#", "/$old_theme_path/" );
			// e.g.
			// template/ => "/wp-content/themes/theme_name/"
			$this->addContentRecoveryFilter( "/$new_theme_path/", "/$old_theme_path/" );

			if ( is_child_theme() ) {
				// e.g.
				// wp-content/themes/twentyfourteen-child/ => template_c/
				// inc/themes/twentyfourteen-child/ => template_c/
				$this->addContentFilterPattern( "#\/{$rgx_part_1}\/themes\/{$theme->stylesheet}\/#", "/$new_child_theme_path/" );
				// e.g.
				// wp-content/themes/twentyfourteen-child/ => wp-content/themes/theme_name-child/
				// inc/themes/twentyfourteen-child/ => wp-content/themes/theme_name-child/
				$this->addContentRecoveryFilterPattern( "#\/{$rgx_part_1}\/themes\/{$theme->stylesheet}\/#", "/$old_theme_path/" );
				// e.g.
				// template_c/ => "/wp-content/themes/theme_name-child/"
				$this->addContentRecoveryFilter( "/$new_child_theme_path/", "/$old_theme_path/" );
			}

			$opt_hide_theme_path = WCL_Plugin::app()->getPopulateOption( 'hide_theme_path' );

			if ( $opt_hide_theme_path ) {
				$opt_hide_wp_content_path = WCL_Plugin::app()->getPopulateOption( 'hide_wpcontent_path' );

				if ( ! $opt_hide_wp_content_path ) {
					$this->addDisablePathRule( $root . "wp-content/themes" );
				}
			}
		}
	}

	public function setPluginsRules() {

		$wp_content_path = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'wpcontent_path' ), ' /' ), ' /' );
		$plugins_path    = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'plugins_path' ), ' /' ), ' /' );
		$rename_plugins  = WCL_Plugin::app()->getPopulateOption( 'rename_plugins' );

		$rgx_part_1 = "wp-content";

		if ( ! empty( $wp_content_path ) ) {
			$rgx_part_1 = "(wp-content|{$wp_content_path})";
		}

		$next_plugins_path = empty( $plugins_path ) ? "wp-content/plugins" : $plugins_path;

		$root = WHM_Helpers::getNotEmptySubFolder();

		if ( ! empty( $rename_plugins ) && $rename_plugins != 'none' ) {
			$plugin_folders = WHM_Helpers::getActivePluginsFolders( $rename_plugins );

			foreach ( $plugin_folders as $plugin_folder ) {
				$random_string = WHM_Helpers::getHash( $plugin_folder );

				$this->addRewriteRule( "^{$root}{$next_plugins_path}/{$random_string}/(.*)", $root . "wp-content/plugins/{$plugin_folder}/$1" );

				$old_path = "wp-content/plugins/{$plugin_folder}";
				$new_path = "{$next_plugins_path}/{$random_string}";

				// e.g.
				// wp-content/plugins/digg-digg => modules/abcd12345
				// modules/digg-digg => modules/abcd12345

				$this->addContentFilterPattern( "#\/(?:{$rgx_part_1}\/plugins|{$plugins_path})\/{$plugin_folder}\/#", "/$new_path/" );

				// e.g.
				// wp-content/plugins/digg-digg => wp-content/plugins/plugin_name
				// modules/digg-digg => wp-content/plugins/plugin_name
				$this->addContentRecoveryFilterPattern( "#\/(?:{$rgx_part_1}\/plugins|{$plugins_path})\/{$plugin_folder}\/#", "/$old_path/" );

				// modules/abcd12345 => wp-content/plugins/plugin_name
				$this->addContentRecoveryFilter( "/$new_path/", "/$old_path/" );
			}
		}

		if ( ! empty( $plugins_path ) ) {
			$this->addRewriteRule( "^{$root}{$plugins_path}/(.*)", $root . "wp-content/plugins/$1" );

			// e.g.
			// wp-content/plugins => modules

			//$this->addContentFilter("/wp-content/plugins", "/$next_plugins_path");

			// e.g.
			// wp-content/plugins/digg-digg => modules/abcd12345
			// modules/digg-digg => modules/abcd12345

			$this->addContentFilterPattern( "#\/{$rgx_part_1}\/plugins\/#", "/{$plugins_path}/" );

			// e.g.
			// wp-content/plugins/digg-digg => /wp-content/plugins/
			// inc/plugins/digg-digg => /wp-content/plugins/
			$this->addContentRecoveryFilterPattern( "#\/{$rgx_part_1}\/plugins\/#", "/wp-content/plugins/" );
			// e.g.
			// modules/abcd12345 => /wp-content/plugins/
			$this->addContentRecoveryFilter( "/{$plugins_path}/", "/wp-content/plugins/" );

			$opt_hide_plugins_path = WCL_Plugin::app()->getPopulateOption( 'hide_plugins_path' );

			if ( $opt_hide_plugins_path ) {
				$opt_hide_wp_content_path = WCL_Plugin::app()->getPopulateOption( 'hide_wpcontent_path' );

				if ( ! $opt_hide_wp_content_path ) {
					$this->addDisablePathRule( $root . "wp-content/plugins" );
				}
			}
		}
	}

	public function setWpInludesRules() {
		// the 'wp-includes' path
		$wp_include_path = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'wpinclude_path' ), ' /' ), ' /' );

		if ( ! empty( $wp_include_path ) ) {
			$root = WHM_Helpers::getNotEmptySubFolder();
			$this->addRewriteRule( "^{$root}{$wp_include_path}/(.*)", $root . "wp-includes/$1" );

			// e.g.
			// wp-includes => libs

			$this->addContentFilter( "/wp-includes/", "/$wp_include_path/" );

			// libs => wp-includes
			$this->addContentRecoveryFilter( "/{$wp_include_path}/", "/wp-includes/" );

			$hide_wpinclude_path = WCL_Plugin::app()->getPopulateOption( 'hide_wpinclude_path' );

			if ( $hide_wpinclude_path ) {
				$this->addDisablePathRule( $root . "wp-includes" );
			}
		}
	}

	public function setWpAdminRules() {

		// --------------------------------------------------------------
		// The 'wp-admin' path
		// --------------------------------------------------------------
		$admin_path = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'admin_path' ), ' /' ), ' /' );

		// chaning the 'wp-admin' path
		if ( ! empty( $admin_path ) ) {
			$root = WHM_Helpers::getNotEmptySubFolder();
			$this->addRewriteRule( "^{$root}{$admin_path}/(.*)", $root . "wp-admin/$1" );

			// e.g.
			// wp-admin => panel

			$this->addContentFilter( "/wp-admin/", "/$admin_path/" );

			// panel => wp-admin
			$this->addContentRecoveryFilter( "/{$admin_path}/", "/wp-admin/" );

			$opt_hide_admin_path = WCL_Plugin::app()->getPopulateOption( 'hide_admin_path' );

			if ( $opt_hide_admin_path ) {
				$this->addDisablePathRule( $root . "wp-admin" );
			}
		}
	}

	/**
	 * Set multisite specific rules and/or content filters.
	 *
	 * @return bool
	 */
	public function setMultisite() {

		if ( is_multisite() ) {
			// Get main network information
			$network = get_network();

			// Make sure domain name is not empty
			if ( ! empty( $network->domain ) ) {
				return false;
			}

			$domain_raw      = $network->domain;
			$domain_quoted   = preg_quote( $domain_raw );
			$wp_content_path = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'wpcontent_path' ), ' /' ), ' /' );

			$dirs = [ 'wp-includes', 'wp-content' ];

			if ( ! empty( $wp_content_path ) ) {
				$dirs[] = $wp_content_path;
			}

			$dirs_imploded = implode( '|', $dirs );

			/**
			 * Replace all subfolder domains e.g. `example.com/site1/wp-content/` with `example.com/{$just_dir}`,
			 * where $just_dir is single value matches from `$dir`.
			 */
			$pattern     = "/$domain_quoted\/[a-zA-Z0-9-]*\/(" . $dirs_imploded . ")/";
			$replacement = "$domain_raw/$1";

			$this->addContentFilterPattern( $pattern, $replacement );
			// todo: not sure if recovery is much applicable in this situation
			//                $this->addContentRecoveryFilter($replacement, "/wp-content/uploads/");
		}
	}

	public function setWpContentRules() {
		// the 'wp-content' path
		$wp_content_path = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'wpcontent_path' ), ' /' ), ' /' );
		$root            = WHM_Helpers::getNotEmptySubFolder();

		$rgx_part_1 = "wp-content";

		if ( ! empty( $wp_content_path ) ) {
			$rgx_part_1 = "(?:wp-content|{$wp_content_path})";
		}

		// --------------------------------------------------------------
		// Minify and combine replace cache path
		// --------------------------------------------------------------

		$this->addRewriteRule( "^{$root}scripts-cache/(js|css)/(.*)", $root . "wp-content/cache/wmac/$1/wmac_$2" );
		$this->addContentFilterPattern( "#\/{$rgx_part_1}\/cache\/wmac\/(js|css)\/wmac_((?:single_)?[A-z0-9]+\.(?:css|js))#", "/scripts-cache/$1/$2" );

		// --------------------------------------------------------------
		// The 'wp-content' path
		// --------------------------------------------------------------

		if ( ! empty( $wp_content_path ) ) {

			$this->addRewriteRule( "^{$root}{$wp_content_path}/(.*)", $root . "wp-content/$1" );

			// e.g.
			// wp-content => inc
			$blog_uri = preg_quote( get_home_url(), '/' );

			$blog_uri_variants = "($blog_uri|^(?![a-z]))\/";

			// Should rewrite only specific URIs containing absolute path
			// or relative, as some of the scripts, e.g. http://s0.wp.com/wp-content/js/devicepx-jetpack.js
			// could be rewritten to /$wp_content_path/js etc
			// See HMW-97 for further information
			$this->addContentFilterPattern( "/{$blog_uri_variants}wp-content\//", "/$wp_content_path/" );

			// inc => wp-content
			//$this->addContentRecoveryFilterPattern( "/{$wp_content_path}/", "/{$blog_uri_variants}wp-content\//" );

			$hide_wpcontent_path = WCL_Plugin::app()->getPopulateOption( 'hide_wpcontent_path' );

			if ( $hide_wpcontent_path ) {
				$this->addDisablePathRule( $root . "wp-content" );
			}
		}
	}

	public function setUploadsDirRules() {
		$wp_content_path = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'wpcontent_path' ), ' /' ), ' /' );
		$rgx_part_1      = "wp-content";

		if ( ! empty( $wp_content_path ) ) {
			$rgx_part_1 = "(wp-content|{$wp_content_path})";
		}

		// the 'uploads' path
		$uploads_path = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'uploads_path' ), ' /' ), ' /' );

		if ( ! empty( $uploads_path ) ) {
			$root = WHM_Helpers::getNotEmptySubFolder();
			$this->addRewriteRule( "^$root$uploads_path/(.*)", $root . "wp-content/uploads/$1" );

			// e.g.
			// wp-content/uploads => files
			// inc/uploads => files
			$this->addContentFilterPattern( "#\/{$rgx_part_1}\/uploads\/#", "/{$uploads_path}/" );
			// files => wp-content
			$this->addContentRecoveryFilter( "/{$uploads_path}/", "/wp-content/uploads/" );

			$hide_uploads_path = WCL_Plugin::app()->getPopulateOption( 'hide_uploads_path' );

			if ( $hide_uploads_path ) {
				$opt_hide_wp_content_path = WCL_Plugin::app()->getPopulateOption( 'hide_wpcontent_path' );

				if ( ! $opt_hide_wp_content_path ) {
					$this->addDisablePathRule( $root . "wp-content/uploads" );
				}
			}
		}
	}

	public function setWpCommentsPostRules() {
		// --------------------------------------------------------------
		// The file 'wp-comments-post.php'
		// --------------------------------------------------------------

		// the 'uploads' path
		$comments_post_file = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'comments_post_file' ), ' /' ), ' /' );

		if ( ! empty( $comments_post_file ) ) {
			$root = WHM_Helpers::getNotEmptySubFolder();

			$this->addRewriteRule( "^{$root}$comments_post_file", $root . "wp-comments-post.php" );

			// e.g.
			// wp-comments-post.php => user_opinion.php

			$this->addContentFilter( "wp-comments-post.php", "$comments_post_file", [ 'content' => true ], [ 'public' => true ] );

			$hide_comments_post_file = WCL_Plugin::app()->getPopulateOption( 'hide_comments_post_file' );

			if ( $hide_comments_post_file ) {
				$this->addDisablePathRule( $root . "wp-comments-post\.php" );
			}
		}
	}

	public function setAdminAjaxRules() {
		// --------------------------------------------------------------
		// The 'admin-ajax.php' path
		// --------------------------------------------------------------

		$ajax_page_name = rtrim( trim( WCL_Plugin::app()->getPopulateOption( 'ajax_page' ), ' /' ), ' /' );

		// chaning the 'wp-admin/admin-ajax.php' path
		if ( ! empty( $ajax_page_name ) ) {
			$root = WHM_Helpers::getNotEmptySubFolder();

			$this->addRewriteRule( "^{$root}$ajax_page_name", $root . "wp-admin/admin-ajax.php" );

			// e.g.
			// wp-admin/admin-ajax.php => ajax.php
			$this->addContentFilter( "wp-admin/admin-ajax.php", "$ajax_page_name" );

			$opt_hide_ajax_page = WCL_Plugin::app()->getPopulateOption( 'hide_ajax_page' );

			if ( $opt_hide_ajax_page ) {
				$this->addDisablePathRule( $root . "admin-ajax\.php" );
			}
		}
	}

	public function disableServiceFiles() {
		WHM_Helpers::generateSubFolder();
		$opt_hide_other_wp_files = WCL_Plugin::app()->getPopulateOption( 'hide_other_wp_files' );

		if ( $opt_hide_other_wp_files ) {
			$root = WHM_Helpers::getNotEmptySubFolder();

			$this->addRewriteRule( "^$root(.*)preview\.png", $root . "$1screenshot.png" );
			$this->addContentFilter( "screenshot.png", "preview.png", [ 'content' => true ], [ 'admin' => true ] );

			$this->addRewriteRule( "^$root(.*)/embeds\.min\.js", $root . "/wp-includes/js/wp-embed.min.js" );
			$this->addContentFilter( "wp-embed.min.js", "embeds.min.js", [ 'content' => true ], [ 'public' => true ] );
		}
	}

	/**
	 * Set _wpnonce parameter
	 */
	public function setRequestWPnonce() {
		if ( isset( $_GET['_nonce'] ) ) {
			$_GET['_wpnonce'] = $_GET['_nonce'];
		}

		if ( isset( $_POST['_nonce'] ) ) {
			$_POST['_wpnonce'] = $_POST['_nonce'];
		}
	}

	/**
	 * Set _wpnonce filter
	 */
	public function setWPnonce() {
		if ( WCL_Plugin::app()->getPopulateOption( 'replace_wpnonce' ) ) {
			$this->addContentFilterPattern( "/_wpnonce\=/", "_nonce=" );
		}
	}
}

WHM_Plugin::$rewrite_rules = new WHM_GenerateRules();