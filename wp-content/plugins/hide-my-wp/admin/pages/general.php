<?php

/**
 * Class WHM_GeneralPage
 * @method string getInstrutionWidget()
 */
class WHM_GeneralPage extends WCL_Page {

	/**
	 * @var string
	 */
	public $id = "hide_my_wp";

	/**
	 * @var string
	 */
	public $page_parent_page = 'defence';

	/**
	 * @var bool
	 */
	public $internal = true;

	/**
	 * @var string
	 */
	public $page_menu_dashicon = 'dashicons-menu';

	/**
	 * @var int
	 */
	public $page_menu_position = 30;

	/**
	 * @var bool
	 */
	public $show_right_sidebar_in_options = false;

	/**
	 * Доступена для мультисайтов
	 *
	 * @var bool
	 */
	//public $available_for_multisite = true;

	/**
	 * Is there a server error?
	 *
	 * @var bool
	 */
	public $is_server_error;

	/**
	 * WHM_GeneralPage constructor.
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 *
	 * @param \WCL_Plugin $plugin
	 */
	public function __construct( WCL_Plugin $plugin ) {
		$this->menu_title = __( 'Webcraftic Hide My Wp', 'hide_my_wp' );

		parent::__construct( $plugin );

		$this->plugin = $plugin;

		$this->is_server_error = WHM_Helpers::isHideModeActive() && WCL_Plugin::app()->getPopulateOption( 'server_configuration_error' );

		add_action( 'wbcr/factory/pages/impressive/print_all_notices', [ $this, 'printUpdateNotice' ], 10, 2 );
		add_filter( 'wbcr/factory/admin_notices', [ $this, 'showGlobalNotices' ], 10, 2 );
	}

	public function getMenuTitle() {
		return __( '"Hide my wp" settings', 'hide_my_wp' );
	}

	/**
	 * We register notifications for some actions
	 *
	 * @param                        $notices
	 * @param Wbcr_Factory000_Plugin $plugin
	 *
	 * @return array
	 * @see libs\factory\pages\themplates\FactoryPages000_ImpressiveThemplate
	 */
	public function getActionNotices( $notices ) {

		$notices[] = [
			'conditions' => [
				'wbcr-server-configuration-success' => 1
			],
			'type'       => 'success',
			'message'    => __( 'Your server configuration has been completed! But if you use Nginx server or htaccess file is not rewritable, you’ll have to update the server configuration each time you modify the theme or install a new plugin.', 'hide_my_wp' )
		];

		return $notices;
	}

	private function getErrorNotices() {
		$message = '';
		if ( WHM_Helpers::isNginx() && $this->is_server_error ) {
			$nginx_configuration_page_url = $this->getActionUrl( 'manual-configurate-nginx', [ 'replace' => 'no' ] );
			$message                      = sprintf( __( "The Hide my wp component detected that you use Nginx server. Our plugin can’t change your server configuration automatically, so you’d have to set up the server manually. Please, go to the <a href='%s'>manual Nginx server configuration</a> page and follow the instructions.", 'hide_my_wp' ), $nginx_configuration_page_url );
		}

		if ( WHM_Helpers::isApache() && $this->is_server_error ) {
			$apache_configuration_page_url = $this->getActionUrl( 'manual-configurate-apache', [ 'replace' => 'no' ] );
			$message                       = sprintf( __( "The Hide my wp component can’t complete the configuration of your Apache server automatically, as the htaccess file is not rewritable. You need to complete the configuration of your Apache server manually. Please, go to the <a href='%s'>manual Apache server configuration</a> page and follow the instructions.", 'hide_my_wp' ), $apache_configuration_page_url );
		}

		return $message;
	}

	/**
	 * Вызывается всегда при загрузке страницы, перед опциями формы с типом страницы options
	 */
	public function printUpdateNotice() {
		$message = $this->getErrorNotices();

		if ( ! empty( $message ) ) {
			$this->printErrorNotice( $message );
		}
	}

	public function showGlobalNotices( $notices ) {
		$message = $this->getErrorNotices();

		if ( ! empty( $message ) ) {
			$notices[] = [
				'id'              => 'hmwp_server_configuration_error',
				'type'            => 'error',
				'dismissible'     => false,
				'dismiss_expires' => 0,
				'text'            => '<p><b>Clearfy:</b> ' . $message . '</p>'
			];
		}

		return $notices;
	}

	/**
	 * Permalinks options.
	 *
	 * @since 1.0.0
	 * @return mixed[]
	 */
	public function getPageOptions() {

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header">' . __( '<strong>Wordpress in hidden mode</strong>.', 'hide_my_wp' ) . '<p>' . __( 'You can protect your WordPress by preventing the hacker from knowing which CMS, plugins and themes you use. In this case, the hacker wouldn’t know about plugins & themes vulnerabilities and couldn’t bruteforce passwords, since he wouldn’t know the address of the admin page.', 'hide_my_wp' ) . '</p></div>'
		];

		$options[] = [
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'hide_my_wp_activate',
			'title'     => __( 'Hidden mode', 'hide_my_wp' ),
			'hint'      => __( 'When the feature is enabled, your WordPress will be working in hidden mode', 'hide_my_wp' ),
			'layout'    => [ 'hint-type' => 'icon', 'hint-icon-color' => 'red' ],
			'eventsOn'  => [
				'show' => '.factory-control-secret_name,.factory-control-secret_key,.factory-control-manual-server-configuration-button'
			],
			'eventsOff' => [
				'hide' => '.factory-control-secret_name,.factory-control-secret_key,.factory-control-manual-server-configuration-button'
			]
		];

		$options[] = [
			'type'    => 'textbox',
			'name'    => 'secret_name',
			'title'   => __( 'Secret name of the variable', 'hide_my_wp' ),
			'hint'    => __( "See the description below.", 'hide_my_wp' ),
			'default' => 'hide_my_wp',
			//'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey')
		];

		$options[] = [
			'type'    => 'textbox',
			'name'    => 'secret_key',
			'title'   => __( 'Secret value of the variable', 'hide_my_wp' ),
			'hint'    => __( "This is the value of the variable to access old URLs. Improves the security of hidden addresses: when you address the page through the old URL, the plugin checks and verifies the secret variable. Only after you’ll get access to the old address. For example: http://testwp.test/wp-login.php?secret_name=my_secret_key", 'hide_my_wp' ),
			'default' => strtolower( WHM_Helpers::generateRandomString() ),
			//'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey')
		];

		if ( WHM_Helpers::isNginx() && $this->is_server_error ) {
			$options[] = [
				'type' => 'html',
				'html' => [ $this, 'manualNginxButton' ]
			];
		}

		/*if( (WHM_Helpers::isIIS() || WHM_Helpers::isIIS7()) && $this->is_server_error) {
			$options[] = array(
				'type' => 'html',
				'html' => array($this, 'manualIisButton')
			);
		}*/

		if ( WHM_Helpers::isApache() && $this->is_server_error ) {
			$options[] = [
				'type' => 'html',
				'html' => [ $this, 'manualApacheButton' ]
			];
		}

		$options = apply_filters( 'wbcr_hmwp_before_hidden_mode_general_form_options', $options, $this );

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header">' . __( '<strong>Files & Directories</strong>.', 'hide_my_wp' ) . '<p>' . __( 'Disable access to files which can be used to recognize your Wordpress site.', 'hide_my_wp' ) . '</p></div>'
		];

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'disable_directory_listing',
			'title'  => __( 'Disable directory List', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "For example, in some hostings, when you address the directory http://site.dev/wp-content/plugins/test/ or any other with no index file in there, you’ll still see the list of all files in the directory. And the hackers can use this information to attack your website.", 'hide_my_wp' )
		];

		/*$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'deny_php_files',
			'title' => __('Deny all php files (except wp-admin)', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __("Restricts access to all php files (except wp-admin directory and such files as wp-login.php, wp-singup.php, xmlrpc.php, wp-cron.php). This is aimed to forbid any direct access to your WordPress files. For example, let’s address the file http://test.dev/wp-content/themes/twentyfifteen/single.php. If you’ve enabled php errors, then you’ll see the following: 'Fatal error: Call to undefined function get_header()'. Technically, it doesn’t affect your website performance, but if the hacker gets this information, he can use it to break the website.", 'hide_my_wp')
		);*/

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'hide_other_wp_files',
			'title'  => __( 'Hide service files(.txt,.log,.html)', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "Denies access to .txt,.log,.html files and screenshot.png of your theme. For example, once gaining access to .log files, the hacker can get all the necessary information to hack your website.", 'hide_my_wp' )
		];

		/*$options[] = array(
			'type' => 'textarea',
			'name' => 'exclude_php_files',
			'title' => __('Exclude files', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __("You can exclude php files or directories from the forbidden list. It is a handy feature if you use file markers specifying you as the website owner on different services. <b>Use comma to separate the files (google-identity.txt, analitics.php, prices.html).</b> <i>You don’t need to exclude files wp-login.php,wp-signup.php,xmlrpc.php,wp-cron.php,robots.txt</i>", 'hide_my_wp'),
			//'default' => ''
		);*/

		/** ============================== SECTION =============================== */

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header"><strong>' . __( 'Private content', 'hide_my_wp' ) . '</strong><p>' . __( 'This part replaces CSS classes, JavaScript code, parts of HTML code, titles and subtitles (secondary titles) of pages. We recommend you to combine these settings with the Clearfy features from the Security page – those are responsible for removing plugin’s version and Wordpress itself.', 'hide_my_wp' ) . '</p></div>'
		];

		/*$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'style_file_clean',
			'title' => __('Remove description header from Style file', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __("Strip out all meta data from style file e.g. Theme Name, Theme URI, Author etc. Those are important information to find out possible theme security breaches.
This feature may not work if style file url not available on html (being concatenated).", 'hide_my_wp')
		);*/

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'remove_x_powered_by',
			'title'  => __( 'Remove X-Powered-By', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "Many WordPress plugins (WP SuperCache, WT3 Total cache, etc.) stores meta data of the usage. The caching plugins developers use it for advertisements, while hackers need this information to damage your website. By enabling this feature, the X-Powered-By meta data will be removed from the server title.", 'hide_my_wp' )
		];

		$options[] = [
			'type'    => 'dropdown',
			'way'     => 'buttons',
			'name'    => 'replace_javascript_path',
			'title'   => __( 'Replace paths in the JavaScript code', 'hide_my_wp' ),
			'data'    => [
				[ 0, __( "Disable JS URLs", 'hide_my_wp' ) ],
				[ 1, __( 'Theme', 'hide_my_wp' ) ],
				[ 2, __( 'Theme and plugins', 'hide_my_wp' ) ],
				[ 3, __( 'Theme, plugins and uploads', 'hide_my_wp' ) ]
			],
			'default' => 1,
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( "Some developers of plugins & themes do not maintain WordPress coding standards and roughly add the JavaScript code with manually written custom paths to AJAX files, images, styles, etc. If you look at the JavaScript code and see such paths as \/wp-content\/themes, and the basic Wordpress directories haven’t been renamed, then you should really use this feature, as plugin will find and replace these paths. Use the switcher to select replacement mode: for plugins, for plugins & themes, for plugins & themes & media files directories.", 'hide_my_wp' )
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'remove_default_description',
			'title'   => __( 'Remove default subtitles', 'hide_my_wp' ),
			'default' => false,
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( "Each time you install a new CMS, the “Just another Wordpress site” subtitle generates by WordPress by default. Even if you forget to replace it with a custom text, this plugin will remove it automatically to improve the privacy.", 'hide_my_wp' )
		];

		/*$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'remove_body_class',
			'title' => __('Remove CSS classes in body', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'red'),
			'hint' => __("Most of theme developers create layouts using the imbedded Wordpress feature named body_class – it dynamically adds CSS classes to the body tag of the page. The body_class feature automatically generates such classes as home blog logged-in admin-bar hfeed customize-support, because they are typical for Wordpress only. Obviously, that can help hackers in identifying your CMS. Enable the feature to remove all classes with the post- prefix.
Attention! Enabling this feature can damage your website style, because the layout may depend on removed classes!
", 'hide_my_wp')
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'remove_post_class',
			'title' => __('Remove CSS classes in post', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'red'),
			'hint' => __("Most of theme developers create layouts using the imbedded Wordpress feature named post_class – it dynamically adds CSS classes to the post or page container. The post_class feature automatically generates such classes as post-2843 post type-post status-publish, because they are typical for Wordpress only. Obviously, that can help hackers in identifying your CMS. Enable the feature to remove all classes with the post- prefix.
Attention! Enabling this feature can damage your website style, because the layout may depend on removed classes!
", 'hide_my_wp')
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'remove_menu_class',
			'title' => __('Remove CSS classes in menu', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'red'),
			'hint' => __("Most of theme developers create layouts using the imbedded Wordpress feature named wp_nav_menu to generate menu quickly. This feature automatically generates such classes as menu-item menu-item-type-post_type menu-item-object-page menu-item-2174, because they are typical for Wordpress only. Obviously, that can help hackers in identifying your CMS. Enable the feature to remove all classes with the menu- prefix.
Attention! Enabling this feature can damage your website style, because the layout may depend on removed classes!
", 'hide_my_wp')
		);*/

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'replace_in_ajax',
			'title'  => __( 'Replace in AJAX requests', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "Plugin automatically replaces URL addresses and other content without changing the files or renaming directories. Enable the feature to replace content for AJAX requests. In means the following: if any plugin tries to get HTML content of the page using ajax, then this feature will control the whole process of the content replacement. In some cases, this can be useful. But in rare cases, it can damage your plugin or theme workflow, so you should really control the situation where the feature is used.", 'hide_my_wp' )
		];

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'replace_wpnonce',
			'title'  => __( 'Replace the _wpnonce variable', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "_nonce are the security tokens helping to protect the website from some types of unauthorized or malicious use. _wpnonce is the request variable name taking argument as Security Token. Since the variable contains the wp prefix, it can help hackers to identify your CMS. This feature replaces the _wpnonce variable with _nonce.", 'hide_my_wp' )
		];

		/** ============================== SECTION =============================== */

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header"><strong>' . __( 'System paths', 'hide_my_wp' ) . '</strong><p>' . __( 'This part changes URL addresses of the Wordpress system directories, which usually look like this: http://-domain-name-/<b>wp-content</b>/elementor/readme.txt or this: http: //-domain-name-/<b>wp-content/uploads/</b>2017/11/mi-pham-123424234.jpg. Each user who has ever tried WordPress knows the names of system directories (wp-content, wp-admin, wp-includes и т.д.), so if he sees such names in the source code of the HTML page, he’ll know for sure that this website is using WordPress CMS. We’ve gathered the whole group of settings allowing you to change classic and well-known names of system directories to the custom ones.', 'hide_my_wp' ) . '</p> <p><code>' . __( 'Important! Plugin doesn’t rename or change actual path to the directories. You can undo this action by reseting the plugin settings.', 'hide_my_wp' ) . '</code></p></div>'
		];

		/*$options[] = [
			'type'        => 'textbox',
			'name'        => 'admin_path',
			'placeholder' => 'my-secret-admin',
			'title'       => __( 'New admin path', 'hide_my_wp' ),
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'        => __( "By default, if a user follows the link http://-domain-name-/wp-admin, Wordpress forwards him to the login page: http://-domain-name-/wp-login.php
Anyone who has ever used WordPress knows about it and can access your login page easily. This page needs to be secured, because it expects the greatest amount of hacker attacks. And one of the ways of doing so is to block redirection from http://-domain-name-/wp-admin. Another solution is to change the path to wp-admin directory.
 Enter a new path to your admin folder using letters and number numbers only. Escape slashes before and after the line. For example, if you enter “my-secret-admin”, then the path to the theme will look like this:  http://-domain-name-/my-secret-admin/", 'hide_my_wp' )
			//'units' => '<i class="fa fa-unlock" title="' . __('This option will protect your blog against unauthorized access.', 'hide_my_wp') . '"></i>'
		];

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'hide_admin_path',
			'title'  => __( 'Disable admin path', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "After changing the wp-admin directory name, access to the directory is still active. This feature helps in restricting access to the http://-domain-name-/wp-admin URL. Now when a user tries to address admin page, he’ll get 404 error from your theme by default.", 'hide_my_wp' )
		];*/

		$options[] = [
			'type'        => 'textbox',
			'name'        => 'theme_path',
			'placeholder' => 'template',
			'title'       => __( 'New path to the theme', 'hide_my_wp' ),
			'hint'        => __( "Enter a new path to your theme using letters and number numbers only. Escape slashes before and after the line. For example, if you enter “template”, then the path to the theme will look like this:  http://-domain-name-/template/style.css", 'hide_my_wp' ),
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
		];

		$options[] = [
			'type'        => 'textbox',
			'name'        => 'style_file',
			'placeholder' => 'base.css',
			'title'       => __( 'New "style.css" name', 'hide_my_wp' ),
			'hint'        => __( "This allow to change the default style.css filename to something else e.g. my-custom-style.css Per this example, on front side the main style link change from style.css to my-custom-style.css", 'hide_my_wp' ),
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
		];

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'hide_theme_path',
			'title'  => __( 'Block access to the directory', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "Even if you change the path to the directory, it will still be accessible via the link. This feature disables access by the http://-domain-name-/wp-content/themes/Divi/ URL. Now if someone tries to open the http://-domain-name-/wp-content/themes/Divi/style.css page, he’ll see 404 error of your default theme.", 'hide_my_wp' )
		];

		$options[] = [
			'type'        => 'textbox',
			'name'        => 'plugins_path',
			'placeholder' => 'modules',
			'title'       => __( 'New path to the plugins', 'hide_my_wp' ),
			'hint'        => __( "This feature changes links to your plugin directories. Enter a new path to your plugin directories using letters and numbers only. Escape slashes before and after the line.  For example, if you enter “modules”, then the path to the plugins will look like this: http://-domain-name-/modules/[your-plugin-name]", 'hide_my_wp' ),
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
		];

		$options[] = [
			'type'    => 'dropdown',
			'way'     => 'buttons',
			'name'    => 'rename_plugins',
			'title'   => __( 'Renaming of plugins', 'hide_my_wp' ),
			'data'    => [
				[ 'none', __( "Don't rename", 'hide_my_wp' ) ],
				[ 'all', __( 'All plugins', 'hide_my_wp' ) ],
				[ 'active', __( 'Only active', 'hide_my_wp' ) ]
			],
			'default' => 'none',
			'hint'    => __( "Even if you change the path to the plugins, there is a possibility that someone will find what plugins are active on your website. For example, all links to the plugin directories look like this: http://-domain-name-/modules/elementor. When this feature is enabled, the same links look this way: http://-domain-name-/modules/3MrL9DZxRQ. The plugin name “elementor” is replaced by the random set of symbols, and it is much harder to identify the plugin name.", 'hide_my_wp' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
		];

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'hide_plugins_path',
			'title'  => __( 'Disable plugins dir', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "Even if you change the path to the directory, it will still be accessible via the link. This feature disables access by the http://-domain-name-/wp-content/plugins/ URL. Now if someone tries to open the http://-domain-name-/wp-content/plugins/elementor/readme.txt page, he’ll see 404 error of your default theme.", 'hide_my_wp' )
		];

		$options[] = [
			'type'        => 'textbox',
			'name'        => 'wpinclude_path',
			'placeholder' => 'lib',
			'title'       => __( 'New path to the wp-includes directory', 'hide_my_wp' ),
			'hint'        => __( "Enter a new path to the wp-includes directory using letters and numbers only. Escape slashes before and after the line. For example, if you enter new path “libs”, then the path to the wp-includes directory will look like this http://-domain-name-/libs/css/dashicons.min.css", 'hide_my_wp' ),
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
		];

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'hide_wpinclude_path',
			'title'  => __( 'Disable wp-include dir', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "Even if you change the path to the directory, it will still be accessible via the link. This feature disables access by the http://-domain-name-/wp-includes/ URL. Now if someone tries to open the http://-domain-name-/wp-includes/js/wp-embed.min.js page, he’ll see 404 error of your default theme.", 'hide_my_wp' )
		];

		$options[] = [
			'type'        => 'textbox',
			'name'        => 'wpcontent_path',
			'placeholder' => 'inc',
			'title'       => __( 'New path to the Wp-content directory', 'hide_my_wp' ),
			'hint'        => __( "Enter a new path to the wp-content directory using letters and numbers only. Escape slashes before and after the line. For example, if you enter the new path “inc”, then the path to the wp-includes directory will look like this http://-domain-name-/inc/uploads/2017/11/mi-pham-123424234.jpg", 'hide_my_wp' ),
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
		];

		$options[] = [
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'hide_wpcontent_path',
			'title'     => __( 'Disable wp-content dir', 'hide_my_wp' ),
			'layout'    => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'      => __( "Even if you change the path to the directory, it will still be accessible via the link. This feature disables access by the http://-domain-name-/wp-content/themes/Divi/ URL. Now if someone tries to open the http: //-domain-name-/wp-content/themes/Divi/style.css page, he’ll see 404 error of your default theme.", 'hide_my_wp' ),
			'eventsOn'  => [
				'hide' => '.factory-control-hide_theme_path,.factory-control-hide_plugins_path,.factory-control-hide_uploads_path'
			],
			'eventsOff' => [
				'show' => '.factory-control-hide_theme_path,.factory-control-hide_plugins_path,.factory-control-hide_uploads_path'
			]
		];

		$options[] = [
			'type'        => 'textbox',
			'name'        => 'uploads_path',
			'placeholder' => 'files',
			'title'       => __( 'New path to the wp-content/uploads folder', 'hide_my_wp' ),
			'hint'        => __( "This feature changes links to the images and other files that you use in the media library. We talk about this directory: wp-content/uploads. Enter a new path to the wp-content/uploads directory using letters and numbers only. Escape slashes before and after the line. For example, if you enter a new path “comments-handler”, then the path to the wp-content/uploads directory will look like this http: //-domain-name-/files/2017/11/mi-pham-123424234.jpg", 'hide_my_wp' ),
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
		];

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'hide_uploads_path',
			'title'  => __( 'Disable uploads dir', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "Even if you change the path to the directory, it will still be accessible via the link. This feature disables access by the http://-domain-name-/wp-content/uploads/ URL. Now if someone tries to open the http://-domain-name-/wp-content/uploads/2017/10/0005-300x225.jpg page, he’ll see 404 error of your default theme.", 'hide_my_wp' )
		];

		$options[] = [
			'type'        => 'textbox',
			'name'        => 'comments_post_file',
			'placeholder' => 'reviews.php',
			'title'       => __( 'New comments path', 'hide_my_wp' ),
			'hint'        => __( "When users post a comment and press “Send”, all user data goes straightly to the wp-comments-post.php file for the further processing. This is a public file and all spam bots know the name and the location of the file, so it can be hacked easily. This part of the settings hides the comment processing file from bots and Wordpress identification systems.
Enter a new path to the wp-comments-post.php file using letters and numbers only. Escape slashes before and after the line. For example, if you enter a new path “reviews.php”, then the path to the wp-comments-post.php file will look like this http: //-domain-name-/reviews.php
", 'hide_my_wp' ),
			//'units' => '<i class="fa fa-comments" title="' . __('This option will protect your blog against spam.', 'hide_my_wp') . '"></i>',
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
		];

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'hide_comments_post_file',
			'title'  => __( 'Disable wp-comments-post.php file', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "Even if you change the path to the directory, it will still be accessible via the link. This feature disables access by the http://-domain-name-/wp-comments-post.php URL. Now if someone tries to open the http://-domain-name-/wp-comments-post.php page, he’ll see 404 error of your default theme.", 'hide_my_wp' )
		];

		$options[] = [
			'type'        => 'textbox',
			'name'        => 'ajax_page',
			'placeholder' => 'dynamic.php',
			'title'       => __( 'New ajax path', 'hide_my_wp' ),
			'hint'        => __( "All ajax requests from installed plugins and themes are handled in the admin-ajax.php file. This is a public and well-known file. Enter a new path to the wp-comments-post.php file using letters and numbers only. Escape slashes before and after the line. For example, if you enter a new path “dynamic.php”, then the path to the wp-admin/admin-ajax.php file will look like this http: //-domain-name-/dynamic.php", 'hide_my_wp' ),
			//'units' => '<i class="fa fa-comments" title="' . __('This option will protect your blog against spam.', 'hide_my_wp') . '"></i>',
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
		];

		$options[] = [
			'type'   => 'checkbox',
			'way'    => 'buttons',
			'name'   => 'hide_ajax_page',
			'title'  => __( 'Disable admin-ajax.php file', 'hide_my_wp' ),
			'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'   => __( "Even if you change the path to the directory, it will still be accessible via the link. This feature disables access by the http://-domain-name-/wp-admin/admin-ajax.php URL. Now if someone tries to open the http://-domain-name-/wp-admin/admin-ajax.php page, he’ll see 404 error of your default theme.", 'hide_my_wp' )
		];

		/** ============================== SECTION =============================== */

		// ----------------------------------------
		// API
		// ----------------------------------------

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header"><strong>' . __( 'Permalinks', 'hide_my_wp' ) . '</strong><p>' . __( 'This part replaces URL addresses of your posts, pages, taxonomies, metrics, RSS feeds, Rest API, etc. If a user has ever tried Wordpress, then he knows that links to the posts can look like this http://-domain-name-/<b>?p=124</b>, and a search link can be the following: http://-domain-name-/<b>?s=latest news</b>. So it’s pretty simple to identify WordPress on your website. Even if you enable the “beautiful” link structure, it still can reveal WordPress in such links as http://-domain-name-/<b>category</b>/performance/ or http://-domain-name-/<b>page</b>/2/. We’ve collected a group of settings helping you to replace popular URL addresses of your permalinks to the custom ones.', 'hide_my_wp' ) . '</p></div>'
		];

		if ( WHM_Helpers::isPermalink() ) {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'rest_api_base',
				'placeholder' => 'rest-api',
				'title'       => __( 'Rest Api Base', 'hide_my_wp' ),
				'hint'        => __( 'Wordpress REST API generates interaction between remote websites and mobile apps. It looks like this http://-domain-name-/wp-json/. This link is common for Wordpress, so bots can identify your CMS easily. Enter a new REST API interaction link using letters and numbers only. Escape slashes before and after the line. For example, if you enter <b>“api/v2”</b>, then your new link to REST API will look like this http://-domain-name-/<b>api/v2/</b>.', 'hide_my_wp' ) . $this->getPopulateOptionState( 'rest_api' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		} else {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'rest_api_query',
				'placeholder' => 'rest_api',
				'title'       => __( 'Rest Api Query', 'hide_my_wp' ),
				'hint'        => __( 'Wordpress REST API generates interaction between remote websites and mobile apps. If you’ve disabled the “beautiful” permalinks, then your Rest API interaction links will look like this http://-domain-name-/<b>?rest_route=1</b>, where rest_route is the request variable taking the argument equal 1. Enter a new variable name using letters and numbers only. Escape slashes before and after the line. This request variable name is common for Wordpress, so analyzing bots can easily detect your CMS. For example, if you enter <b>“site_api”</b> as a request variable, then the REST API interaction link will look like this http://-domain-name-/<b>?site_api=1</b>.', 'hide_my_wp' ) . $this->getPopulateOptionState( 'rest_api' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		}

		// ----------------------------------------
		// Authors
		// ----------------------------------------

		if ( ! WHM_Helpers::isPermalink() ) {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'author_query',
				'placeholder' => 'user',
				'title'       => __( 'Authors Query', 'hide_my_wp' ),
				'hint'        => __( "Such links are used to view authors’ profiles and filter posts by authors. The link looks like this http://-domain-name-/<b>author/webcraftic</b>. It should be hidden not only to mask the Wordpress usage, but to prevent bots from searching user names (logins) too. Enter a new author link using letters and numbers only. Escape slashes before and after the line. For example, if you enter <b>“user”</b>, then the new REST API link will look like this: http://-domain-name-/<b>user/webcraftic/</b>.", 'hide_my_wp' ) . $this->getPopulateOptionState( 'author' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		} else {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'author_base',
				'placeholder' => 'user',
				'title'       => __( 'Authors Base', 'hide_my_wp' ),
				'hint'        => __( "Such links are used to view the author’s profile and filter posts by authors. If you’ve disabled the “beautiful” permalinks, then all links to the author page look this way: http://-domain-name-/<b>?author=1</b>, where author is a request variable taking the argument equal 1 as Author ID. Enter a new variable name using letters and numbers only. Escape slashes before and after the line. If you enter <b>“user”</b> as a request variable, then the new author’s link will look like this: http://-domain-name-/<b>?user=1</b>", 'hide_my_wp' ) . $this->getPopulateOptionState( 'author' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		}

		/*$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'remove_author_base',
			'title' => __('Without Base', 'hide_my_wp'),
			'hint' => __("Basic prefix in the author link is what you'll be able to change using the feature above. It means that usually the author link looks this way: http://-domain-name-/<b>base_var</b>/webcraftic, where base_var is a variable name that takes the argument value as the author name. When this feature is enabled, the author link will be as following http://-domain-name-/<b>webcraftic</b>, without <b>base_var</b>. If the author name matches the link to the post or the category prefix, then this feature will work incorrectly.", 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey')
		);*/

		// ----------------------------------------
		// Posts
		// ----------------------------------------

		if ( ! WHM_Helpers::isPermalink() ) {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'posts_query',
				'placeholder' => 'article_id',
				'title'       => __( 'Post Query', 'hide_my_wp' ),
				'hint'        => __( "If you’ve disabled the “beautiful” permalinks, then your links to pages and posts will look this way: http://-domain-name-/<b>?p=1</b>, where p is a request variable taking argument 1 as Post ID. Enter a new variable name using letters and numbers only. Escape slashes before and after the line. If you enter “article_id” as a request variable, then the link to posts will look like this http://-domain-name-/<b>?article_id=1</b>
We recommend you not to use this feature if your pages have already been indexed!
", 'hide_my_wp' ) . $this->getPopulateOptionState( 'posts' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		}/* else {
				$options[] = array(
					'type' => 'textbox',
					'name' => 'posts_base',
					'placeholder' => '%author%/%postname%',
					'title' => __('Post Permalink', 'hide_my_wp'),
					'hint' => __("e.g. '%author%/%postname%'", 'hide_my_wp') . $this->getPopulateOptionState('posts'),
					//'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey')
				);
			}*/

		// ----------------------------------------
		// Pages
		// ----------------------------------------

		if ( ! WHM_Helpers::isPermalink() ) {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'pages_query',
				'placeholder' => 'page_num',
				'title'       => __( 'Page Query', 'hide_my_wp' ),
				'hint'        => __( "If you’ve disabled the “beautiful” permalinks, then your links to the pages look this way http://-domain-name-/<b>?p=1</b>, where p is the request variable taking the argument 1 as Post ID. Enter a new variable name using letters and numbers only. Escape slashes before and after the line. If you enter “page_id”, then the link to the page will look like this http://-domain-name-/<b>?page_id=1</b>
We do not recommend you to use this feature in case of indexed pages!
", 'hide_my_wp' ) . $this->getPopulateOptionState( 'pages' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		} else {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'pages_base',
				'placeholder' => 'page',
				'title'       => __( 'Page base', 'hide_my_wp' ),
				'hint'        => __( "All default links to pages are similar to the posts ones and usually look like this http://-domain-name-/<b>[page-slug]</b>. Links with basic prefix have a different structure and look this way http://-domain-name-/<b>base_name</b>/sample-page, where base_name is a basic prefix of the page. Enter a new name of the basic prefix in links using letters and numbers only. Escape slashes before and after the line. If you enter <b>“static_page”</b> as a prefix name, then the link to the page will look like this http://-domain-name-/<b>static_page</b>/[page-slug]
We do not recommend you to use this feature in case of indexed pages!
", 'hide_my_wp' ) . $this->getPopulateOptionState( 'pages' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		}

		// ----------------------------------------
		// Pagination
		// ----------------------------------------

		if ( ! WHM_Helpers::isPermalink() ) {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'pagination_query',
				'placeholder' => 'list',
				'title'       => __( 'Pagination Query', 'hide_my_wp' ),
				'hint'        => __( "Pagination is a sequence numbering of the pages on the top or the bottom of the website. If you’ve disabled the “beautiful” permalinks, then your pagination links will look as following http://-domain-name-/<b>?paged=2</b>, where paged is the request variable taking the argument 2 as the page number. Enter a new variable name using letters and numbers only. Escape slashes before and after the line. If you enter “list” as the request variable, then your page link will look like this http://-domain-name-/?list=1", 'hide_my_wp' ) . $this->getPopulateOptionState( 'pagination' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		} else {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'pagination_base',
				'placeholder' => 'list',
				'title'       => __( 'Pagination base', 'hide_my_wp' ),
				'hint'        => __( "Pagination is a sequence numbering of pages on the top or the bottom of the website. Pagination links usually look this way http://-domain-name-/<b>page/2/</b>, where page is a basic prefix of the link and 2 is the page number. Enter a new basic prefix name of the page links using letters and numbers only. Escape slashes before and after the line. If you enter “list”, then your pagination link will look like this http://-domain-name-/<b>list/2</b>", 'hide_my_wp' ) . $this->getPopulateOptionState( 'pagination' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		}

		// ----------------------------------------
		// Categories
		// ----------------------------------------

		if ( ! WHM_Helpers::isPermalink() ) {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'categories_query',
				'placeholder' => 'category',
				'title'       => __( 'Category Query', 'hide_my_wp' ),
				'hint'        => __( "If you’ve disabled beautiful permanent links then your category links look like this http://-domain-name-/?cat=2, where cat is the request variable taking argument 2 as Category ID.  Enter a new variable name using letters and numbers only. Escape slashes before and after the line. For example, if you enter “category” as the request variable, then your link to pages will look like this: http://-domain-name-/?category =1", 'hide_my_wp' ) . $this->getPopulateOptionState( 'categories' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		} /*else {
				$options[] = array(
					'type' => 'textbox',
					'name' => 'categories_base',
					'placeholder' => 'category',
					'title' => __('Category base', 'hide_my_wp'),
					'hint' => __("Category links look this way: http://-domain-name-/category/plugins/, where category is the link prefix and plugins is the category name. Enter a new prefix name for category links using letters and numbers only. Escape slashes before and after the line. For example, if you enter “cats” as the prefix name, then your pagination link will look like this: http://-domain-name-/cats/plugins/", 'hide_my_wp') . $this->getPopulateOptionState('categories'),
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey')
				);
			}*/

		// ----------------------------------------
		// Tags
		// ----------------------------------------

		if ( ! WHM_Helpers::isPermalink() ) {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'tags_query',
				'placeholder' => 'keyword',
				'title'       => __( 'Tag Query', 'hide_my_wp' ),
				'hint'        => __( "Change /?tag=tag1 (e.g. keyword, find).", 'hide_my_wp' ) . $this->getPopulateOptionState( 'tags' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		} /*else {
				$options[] = array(
					'type' => 'textbox',
					'name' => 'tags_base',
					'placeholder' => 'keyword',
					'title' => __('Tag base', 'hide_my_wp'),
					'hint' => __("e.g. 'tags'", 'hide_my_wp') . $this->getPopulateOptionState('tags'),
					'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey')
				);
			}*/

		// ----------------------------------------
		// Feeds
		// ----------------------------------------

		if ( ! WHM_Helpers::isPermalink() ) {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'feed_query',
				'placeholder' => 'rss',
				'title'       => __( 'Feed Query', 'hide_my_wp' ),
				'hint'        => __( "Change /?feed=rss2 (e.g. xml, rss, sitefeed).", 'hide_my_wp' ) . $this->getPopulateOptionState( 'feed' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		} else {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'feed_base',
				'placeholder' => 'rss',
				'title'       => __( 'Feeds base', 'hide_my_wp' ),
				'hint'        => __( "Change /feed (e.g. xml, rss, index.xml).", 'hide_my_wp' ) . $this->getPopulateOptionState( 'feed' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		}

		// ----------------------------------------
		// Search
		// ----------------------------------------

		if ( ! WHM_Helpers::isPermalink() ) {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'search_query',
				'placeholder' => 'find',
				'title'       => __( 'Search Query', 'hide_my_wp' ),
				'hint'        => __( "Change /?s=keyword (e.g. find, s, dl).", 'hide_my_wp' ) . $this->getPopulateOptionState( 'search' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		} else {
			$options[] = [
				'type'        => 'textbox',
				'name'        => 'search_base',
				'placeholder' => 'find',
				'title'       => __( 'Search base', 'hide_my_wp' ),
				'hint'        => __( "Change /search/keyword (e.g. find, s, dl).", 'hide_my_wp' ) . $this->getPopulateOptionState( 'search' ),
				'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];

			$options[] = [
				'type'   => 'checkbox',
				'way'    => 'buttons',
				'name'   => 'nice_search_redirect',
				'title'  => __( 'Search base redirect', 'hide_my_wp' ),
				'hint'   => __( "Redirect all search queries to permalink (e.g. /search/test instead /?s=test).", 'hide_my_wp' ),
				'layout' => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ]
			];
		}

		/*$options[] = array(
			'type' => 'separator'
		);*/

		//todo: Активировать опции Clearfy,если он подключен
		/*$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'disable_other_wp',
			'title' => __('Disable Other WP', 'hide_my_wp'),
			'hint' => __("Disable other WordPress queries like post type, taxonamy, attachments, comment page etc. Post types may be used by themes or plugins.", 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey')
		);*/

		$form_options = [];

		$form_options[] = [
			'type'  => 'form-group',
			'items' => apply_filters( 'wbcr_hmwp_general_form_options', $options, $this )
		];

		return $form_options;
	}

	/**
	 * @param $html_builder Wbcr_FactoryForms000_Html
	 */
	public function manualNginxButton( $html_builder ) {

		?>
        <div class="form-group form-group-checkbox factory-control-manual-server-configuration-button">
            <label class="col-sm-4 control-label">
				<?php _e( 'Nginx Configuration', 'hide_my_wp' ) ?>
                <span class="factory-hint-icon factory-hint-icon-grey" data-toggle="factory-tooltip" data-placement="right" title="" data-original-title="<?php _e( 'It\'s require to config Nginx to get all features of the plugin', 'hide_my_wp' ) ?>">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAQAAABKmM6bAAAAUUlEQVQIHU3BsQ1AQABA0X/komIrnQHYwyhqQ1hBo9KZRKL9CBfeAwy2ri42JA4mPQ9rJ6OVt0BisFM3Po7qbEliru7m/FkY+TN64ZVxEzh4ndrMN7+Z+jXCAAAAAElFTkSuQmCC" alt="">
				</span>
            </label>
            <div class="control-group col-sm-8">
                <div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group">
                    <form method="post">
                        <a href="<?php $this->actionUrl( 'manual-configurate-nginx' ) ?>" target="_blank" class="button button-default"><?php _e( 'Nginx Configuration', 'hide_my_wp' ) ?></a>
                    </form>
                </div>
            </div>
        </div>
		<?php
	}

	// выводит экран конфигурации IIS сервера
	public function manualConfigurateNginxAction() {
		if ( ! $this->is_server_error ) {
			$this->redirectToAction( 'index' );
		}

		require_once WHM_PLUGIN_DIR . '/includes/servers/class.configurate-nginx.php';
		?>
        <div class="form-group">
            <h2><?php _e( 'Nginx Configuration Rules', 'hide_my_wp' ) ?></h2>
            <p>
                <a href="<?php echo wp_nonce_url( $this->getActionUrl( 'server-manual-configuration-complete', [ 'server' => 'nginx' ] ), 'configuration_nginx' ) ?>" class="button button-hero"><?php _e( 'Manual Configuration Complete!' ); ?></a>
            </p>
            <span>
		           <?php _e( 'Add to Nginx config file to get all features of the plugin.', 'hide_my_wp' ) ?>
		        </span>
            <ul style="list-style: disc;">
                <li><?php echo sprintf( __( 'Nginx vhosts config file usually located in %s or %s or %s', 'hide_my_wp' ), '<code>/etc/nginx/sites-available/YOURSITE</code>', '<code>/etc/nginx/sites-available/default</code>', '<code>/etc/nginx/nginx.conf</code>' ) ?></li>
                <li><?php echo sprintf( __( 'Add below lines right before %s and %s inside %s block', 'hide_my_wp' ), '<code>location / {</code>', '<code>location ~ \.php {</code>', '<code>server {</code>' ) ?>
                    :
                </li>
            </ul>
            <div class="control-group">
                <!-- hmwp_ignore -->
                <textarea cols="100" style="height: 500px;"><?php WHM_ConfigurateNginx::printRulesAndDirectives() ?></textarea>
                <!-- /hmwp_ignore -->
            </div>
            <ul style="list-style: disc">
                <li>
                    <p><?php _e( 'Restart Nginx to apply changes', 'hide_my_wp' ) ?></p>
                    <p><?php _e( 'For Debian distibutions (e.g. Ubuntu), use the following' ) ?>: <code>sudo service
                            nginx restart</code></p>
                </li>
                <li><?php _e( 'You may need to re-configure the server whenever you change settings or activate a new theme or plugin.', 'hide_my_wp' ) ?></li>
                <li><?php _e( 'If you use sub-directory for WP block you have to add that directory before all of below pathes (e.g. rewrite ^/wordpress/lib/(.*) /wordpress/wp-includes/$1 or rewrite ^/wordpress/(.*)\.php(.*) /wordpress/nothing_404_404)', 'hide_my_wp' ) ?></li>
            </ul>
            <h3><?php _e( 'Hide Nginx Version', 'hide_my_wp' ) ?></h3>
            <ul>
                <li><?php echo sprintf( __( 'If you would like to hide Nginx version, open %s and add %s within %s block', 'hide_my_wp' ), '<code>/etc/nginx/nginx.conf</code>', '<code>server_tokens off;</code>', '<code>http</code>' ) ?></li>
            </ul>
            <h3><?= _e( 'Completed the server configuration?', 'hide_my_wp' ) ?></h3>
            <p><?php _e( ' Then press the "Manual configuration is completed" button to confirm that all plugin requirements were met.' ); ?></p>
            <p>
                <a href="<?php echo wp_nonce_url( $this->getActionUrl( 'server-manual-configuration-complete', [ 'server' => 'nginx' ] ), 'configuration_nginx' ) ?>" class="button button-hero"><?php _e( 'Manual Configuration Complete!' ); ?></a>
            </p>
        </div>
		<?php
	}

	/**
	 * @param $html_builder Wbcr_FactoryForms000_Html
	 */
	/*public function manualIisButton($html_builder)
	{
		?>
		<div class="form-group form-group-checkbox factory-control-reset_notices_button">
			<label for="wbcr_clearfy_reset_notices_button" class="col-sm-6 control-label">
				<?php _e('Windows Configuration (IIS)', 'hide_my_wp') ?>
				<span class="factory-hint-icon factory-hint-icon-grey" data-toggle="factory-tooltip" data-placement="right" title="" data-original-title="<?php _e('It\'s require to config web.config file to get all features of the plugin', 'hide_my_wp') ?>">
				<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAQAAABKmM6bAAAAUUlEQVQIHU3BsQ1AQABA0X/komIrnQHYwyhqQ1hBo9KZRKL9CBfeAwy2ri42JA4mPQ9rJ6OVt0BisFM3Po7qbEliru7m/FkY+TN64ZVxEzh4ndrMN7+Z+jXCAAAAAElFTkSuQmCC" alt="">
			</span>
			</label>

			<div class="control-group col-sm-6">
				<div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group">
					<form method="post">
						<a href="<?php $this->actionUrl('manual-configurate-iis', array('replace' => 'no')) ?>" target="_blank" class="button button-default"><?php _e('IIS Configuration', 'hide_my_wp') ?></a>
					</form>
				</div>
			</div>
		</div>
	<?php
	}*/

	// выводит экран конфигурации IIS сервера
	/*public function manualConfigurateIisAction()
	{
		require_once WHM_PLUGIN_DIR . '/includes/servers/class.configurate-nginx.php';
		?>
		<div class="form-group">
			<h2><?php _e('Правила конфигурации IIS', 'hide_my_wp') ?></h2>
			<span>
				<?php _e('Add to web.config file to get all features of the plugin.', 'hide_my_wp') ?>
			</span>
			<ol type="1">
				<li><?php _e('Web.config file is located in WP root directory', 'hide_my_wp') ?></li>
				<li><?php _e('Add it to right before <strong>&lt;rule name="wordpress" patternSyntax="Wildcard"&gt;</strong>', 'hide_my_wp') ?></li>
				<li><?php _e('You may need to re-configure the server whenever you change settings or activate a new theme or plugin.', 'hide_my_wp') ?></li>
			</ol>
			<div class="control-group">
				<?php $rewrite_rules = new WHM_GenerateRules() ?>;
				<textarea row="50" cols="100" style="height: 500px;"><?php echo $rewrite_rules->getIISRules() ?></textarea>
			</div>
		</div>
	<?php
	}*/

	/**
	 * @param $html_builder Wbcr_FactoryForms000_Html
	 */
	public function manualApacheButton( $html_builder ) {
		?>
        <div class="form-group form-group-checkbox factory-control-manual-server-configuration-button">
            <label class="col-sm-4 control-label">
				<?php _e( 'Apache manual Configuration', 'hide_my_wp' ) ?>
                <span class="factory-hint-icon factory-hint-icon-grey" data-toggle="factory-tooltip" data-placement="right" title="" data-original-title="<?php _e( 'In rare cases you need to configure .htaccess file manually', 'hide_my_wp' ) ?>">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAQAAABKmM6bAAAAUUlEQVQIHU3BsQ1AQABA0X/komIrnQHYwyhqQ1hBo9KZRKL9CBfeAwy2ri42JA4mPQ9rJ6OVt0BisFM3Po7qbEliru7m/FkY+TN64ZVxEzh4ndrMN7+Z+jXCAAAAAElFTkSuQmCC" alt="">
				</span>
            </label>
            <div class="control-group col-sm-8">
                <div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group">
                    <form method="post">
                        <a href="<?php $this->actionUrl( 'manual-configurate-apache' ) ?>" target="_blank" class="button button-default"><?php _e( 'Apache Configuration', 'hide_my_wp' ) ?></a>
                    </form>
                </div>
            </div>
        </div>
		<?php
	}

	// выводит экран конфигурации IIS сервера
	public function manualConfigurateApacheAction() {
		if ( ! $this->is_server_error ) {
			$this->redirectToAction( 'index' );
		}
		require_once WHM_PLUGIN_DIR . '/includes/servers/class.configurate-apache.php';
		?>
        <div class="form-group">
            <h2><?php _e( 'Apache Configuration Rules', 'hide_my_wp' ) ?></h2>
            <p>
                <a href="<?php echo wp_nonce_url( $this->getActionUrl( 'server-manual-configuration-complete', [ 'server' => 'apache' ] ), 'configuration_apache' ) ?>" class="button button-hero"><?php _e( 'Manual Configuration Complete!' ); ?></a>
            </p>
            <div>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/mNrgTo_-hFI" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
            <span>
                    <?php _e( 'In rare cases you need to configure it manually.', 'hide_my_wp' ) ?>
                </span>
            <ol type="1">
                <li><?php _e( 'If you use <strong>BulletProof Security</strong> plugin first secure htaccess file using it  and then add below lines to your htaccess file using FTP.', 'hide_my_wp' ) ?></li>
                <li><?php _e( 'You may need to re-configure server whenever you change settings or activate a new theme or plugin.', 'hide_my_wp' ) ?></li>
                <li><?php _e( 'Add these lines right before: <strong># BEGIN WordPress</strong>. Next you may want to change htaccess permission to read-only (e.g. 666)', 'hide_my_wp' ) ?></li>
            </ol>
            <div class="control-group">
                <!-- hmwp_ignore -->
                <textarea row="50" cols="100" style="height: 500px;"><?php WHM_ConfigurateApache::printRewriteRules() ?></textarea>
                <!-- /hmwp_ignore -->
                <p><?php _e( 'Completed the server configuration? Then press the "Manual configuration is completed" button to confirm that all plugin requirements were met.' ); ?></p>
                <p>
                    <a href="<?php echo wp_nonce_url( $this->getActionUrl( 'server-manual-configuration-complete', [ 'server' => 'apache' ] ), 'configuration_apache' ) ?>" class="button button-hero"><?php _e( 'Manual Configuration Complete!' ); ?></a>
                </p>
            </div>
        </div>
		<?php
	}

	/**
	 * Действие обрабатывается после того, как пользователь подтвердит,
	 * что он завершил конфигурацию сервера
	 */
	public function serverManualConfigurationCompleteAction() {
		$server = $this->request->get( 'server', null, true );

		if ( empty( $server ) ) {
			$this->redirectToAction( 'index' );
		}

		check_admin_referer( 'configuration_' . $server );

		$this->plugin->deletePopulateOption( 'server_configuration_error' );

		//'manual-configurate-nginx'
		$this->redirectToAction( 'index', [ 'wbcr-server-configuration-success' => 1 ] );
	}

	private function getPopulateOptionState( $option_name ) {
		$default = '';
		$base    = trim( $this->plugin->getPopulateOption( $option_name . '_base', null ), ' /' );
		$query   = stripslashes( $this->plugin->getPopulateOption( $option_name . '_query', null ) );

		switch ( $option_name ) {

			case 'rest_api':
				$default = get_site_url() . '?rest_route=/';

				if ( WHM_Helpers::isPermalink() ) {
					$default = get_site_url() . '/wp-json/';
				}

				$current = $default;

				if ( WHM_Helpers::isPermalink() ) {
					if ( ! empty( $base ) ) {
						$current = get_site_url() . '/' . $base . '/';
					}
				} else {
					if ( ! empty( $query ) ) {
						$current = get_site_url() . '?' . $query . '=/';
					}
				}

				break;

			case 'author':

				global $current_user;
				$default = get_site_url() . '?author=' . $current_user->ID;
				$current = $default;

				if ( WHM_Helpers::isPermalink() ) {
					if ( ! empty( $base ) ) {
						$current = get_site_url() . '/' . $base . '/' . $current_user->user_login;
					}
				} else {
					if ( ! empty( $query ) ) {
						$current = get_site_url() . '?' . $query . '=' . $current_user->ID;
					}
				}

				break;

			case 'feed':

				$default = get_site_url() . '?feed=rss2';
				$current = $default;

				if ( ! WHM_Helpers::isPermalink() && ! empty( $query ) ) {
					$current = get_site_url() . '?' . $query . '=rss2';
				} else {
					$current = get_feed_link();
				}

				break;

			case 'posts':

				$recent_post = $this->getRecentPost();

				if ( empty( $recent_post ) ) {
					$default = __( 'not any posts found to show an example', 'hide_my_wp' );
					$current = $default;
				} else {
					$default = get_site_url() . '/?p=' . $recent_post->ID;
					$current = $default;

					if ( ! WHM_Helpers::isPermalink() && ! empty( $query ) ) {
						$current = get_site_url() . '/?' . $query . '=' . $recent_post->ID;
					} else {
						$current = get_permalink( $recent_post->ID );
					}
				}

				break;

			case 'pages':

				$recent_post = $this->getRecentPage();
				$current     = $default;

				if ( empty( $recent_post ) ) {
					$default = __( 'not any posts found to show an example', 'hide_my_wp' );
					$current = $default;
				} else {
					$default = get_site_url() . '/?p=' . $recent_post->ID;

					if ( ! WHM_Helpers::isPermalink() && ! empty( $query ) ) {
						$current = get_site_url() . '/?' . $query . '=' . $recent_post->ID;
					} else {
						$current = get_permalink( $recent_post->ID );
					}
				}

				break;

			case 'pagination':

				$default = get_site_url() . '/?paged=2';
				$current = $default;

				if ( ! WHM_Helpers::isPermalink() && ! empty( $query ) ) {
					$current = get_site_url() . '/?' . $query . '=2';
				} else {
					$current = $this->getPagenumLink( 2 );
				}

				break;

			case 'categories':

				$category = $this->getRecentCategory();
				if ( empty( $category ) ) {
					$default = __( 'not any category found to show an example', 'hide_my_wp' );
					$current = $default;
				} else {
					$default = get_site_url() . '/?cat=' . $category->term_id;

					if ( ! WHM_Helpers::isPermalink() && ! empty( $query ) ) {
						$current = get_site_url() . '/?' . $query . '=' . $category->term_id;
					} else {
						$current = get_category_link( $category->term_id );
					}
				}

				break;

			case 'tags':

				$tag = $this->getRecentTag();

				if ( empty( $tag ) ) {
					$default = __( 'Not any tag found to show an example', 'hide_my_wp' );
					$current = $default;
				} else {
					$default = get_site_url() . '/?tag=' . $tag->term_id;
					$current = $default;

					if ( ! WHM_Helpers::isPermalink() && ! empty( $query ) ) {
						$current = get_site_url() . '/?' . $query . '=' . $tag->slug;
					} else {
						$current = get_category_link( $tag->term_id );
					}
				}

				break;

			case 'search':

				$default = get_site_url() . '/?s=example';
				$current = $default;

				if ( ! WHM_Helpers::isPermalink() && ! empty( $query ) ) {
					$current = get_site_url() . '/?' . $query . '=example';
				} else {
					$current = get_search_link( 'example' );
				}

				break;
		}

		if ( ! WHM_Helpers::isHideModeActive() ) {
			$current = '<em style="color:#ff5722">' . __( 'The hidden mode is not activated, the redirect settings you set do not work.', 'hide_my_wp' ) . '</em>';
		} else if ( empty( $base ) ) {
			$current = '<em>' . __( 'The the same format as the format by default. Nothing changed.', 'hide_my_wp' ) . '</em>';
		} else {
			$current = sprintf( '<!-- hmwp_ignore --><a href="%s" target="_blank" class="wbcr-factory-color-grey">%s</a><!-- /hmwp_ignore -->', $current, $current );
		}

		$message = '';
		//$message .= sprintf('<p>' . __('By default:', 'hide_my_wp') . ' <a href="%s" target="_blank">%s</a></p>', $default, $default);
		$message .= '<p>' . __( 'Current:', 'hide_my_wp' ) . ' ' . $current . '</p>';

		return $message;
	}

	/**
	 * @return null|WP_Post
	 */
	private function getRecentPost() {
		$recent_posts = wp_get_recent_posts( [ 'numberposts' => '1' ], OBJECT );

		return empty( $recent_posts ) ? null : $recent_posts[0];
	}

	/**
	 * @return null|WP_Post
	 */
	private function getRecentPage() {
		$recent_posts = wp_get_recent_posts( [ 'numberposts' => '1', 'post_type' => 'page' ], OBJECT );

		return empty( $recent_posts ) ? null : $recent_posts[0];
	}

	/**
	 * @return mixed|null
	 */
	private function getRecentCategory() {
		$categories = get_categories();
		if ( empty( $categories ) ) {
			return null;
		}

		return end( $categories );
	}

	/**
	 * @return mixed|null
	 */
	private function getRecentTag() {
		$tags = get_tags();
		if ( empty( $tags ) ) {
			return null;
		}

		return end( $tags );
	}

	/**
	 * @return mixed
	 */
	private function websiteUrlBase() {
		return $this->removeHttp( $this->getSiteUrl() );
	}

	/**
	 * @return string
	 */
	private function getSiteUrl() {
		return trim( get_site_url(), '/' );
	}

	/**
	 * @param $url
	 *
	 * @return mixed
	 */
	private function removeHttp( $url ) {
		return preg_replace( '/https?\:\/\//', '', $url );
	}

	/**
	 * @param int         $pagenum
	 *
	 * @return string
	 * @global WP_Rewrite $wp_rewrite
	 */
	private function getPagenumLink( $pagenum ) {
		global $wp_rewrite;

		$pagenum = (int) $pagenum;

		$temp                   = $_SERVER['REQUEST_URI'];
		$_SERVER['REQUEST_URI'] = '';

		$request = remove_query_arg( 'paged' );

		$_SERVER['REQUEST_URI'] = $temp;

		$home_root = parse_url( home_url() );
		$home_root = ( isset( $home_root['path'] ) ) ? $home_root['path'] : '';
		$home_root = preg_quote( $home_root, '|' );

		$request = preg_replace( '|^' . $home_root . '|i', '', $request );

		$qs_regex = '|\?.*?$|';
		preg_match( $qs_regex, $request, $qs_match );

		if ( ! empty( $qs_match[0] ) ) {
			$query_string = $qs_match[0];
			$request      = preg_replace( $qs_regex, '', $request );
		} else {
			$query_string = '';
		}

		$request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request );
		$request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request );
		$request = ltrim( $request, '/' );

		$base = trailingslashit( get_bloginfo( 'url' ) );

		if ( $wp_rewrite->using_index_permalinks() && ( $pagenum > 1 || '' != $request ) ) {
			$base .= $wp_rewrite->index . '/';
		}

		if ( $pagenum > 1 ) {
			$request = ( ( ! empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
		}

		$result = $base . $request . $query_string;

		/**
		 * Filter the page number link for the current request.
		 *
		 * @since 2.5.0
		 *
		 * @param string $result   The page number link.
		 */
		$result = apply_filters( 'get_pagenum_link', $result );

		//if( $escape ) {
		return esc_url( $result );
		//} else {
		//return esc_url_raw($result);
		//}
	}
}


