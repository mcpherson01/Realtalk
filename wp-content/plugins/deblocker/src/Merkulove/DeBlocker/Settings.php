<?php
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

namespace Merkulove\DeBlocker;

use Merkulove\DeBlocker;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Class used to implement plugin settings.
 *
 * @since 1.0.0
 * @author Alexandr Khmelnytsky (info@alexander.khmelnitskiy.ua)
 **/
final class Settings {

	/**
	 * DeBlocker Plugin settings.
	 *
	 * @var array()
	 * @since 1.0.0
	 **/
	public $options = [];

	/**
	 * The one true Settings.
	 *
	 * @var Settings
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Sets up a new Settings instance.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	private function __construct() {

		/** Get plugin settings. */
		$this->get_options();

	}

	/**
	 * Render Tabs Headers.
	 *
	 * @param string $current - Selected tab key.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render_tabs( $current = 'general' ) {

		/** Tabs array. */
		$tabs = [];
		$tabs['general'] = [
			'icon' => 'tune',
			'name' => esc_html__( 'General', 'deblocker' )
		];

        $tabs['assignments'] = [
            'icon' => 'flag',
            'name' => esc_html__( 'Assignments', 'deblocker' )
        ];

		$tabs['css'] = [
			'icon' => 'code',
			'name' => esc_html__( 'Custom CSS', 'deblocker' )
		];

		/** Activation tab enable only if plugin have Envato ID. */
		$plugin_id = EnvatoItem::get_instance()->get_id();
		if ( (int)$plugin_id > 0 ) {
			$tabs['activation'] = [
				'icon' => 'vpn_key',
				'name' => esc_html__( 'Activation', 'deblocker' )
			];
		}

		$tabs['status'] = [
			'icon' => 'info',
			'name' => esc_html__( 'Status', 'deblocker' )
		];

		$tabs['uninstall'] = [
			'icon' => 'delete_sweep',
			'name' => esc_html__( 'Uninstall', 'deblocker' )
		];

		/** Render Tabs. */
		?>
        <aside class="mdc-drawer">
            <div class="mdc-drawer__content">
                <nav class="mdc-list">

                    <div class="mdc-drawer__header mdc-plugin-fixed">
                        <!--suppress HtmlUnknownAnchorTarget -->
                        <a class="mdc-list-item mdp-plugin-title" href="#wpwrap">
                            <i class="mdc-list-item__graphic" aria-hidden="true">
                                <img src="<?php echo esc_attr( DeBlocker::$url . 'images/logo-color.svg' ); ?>" alt="<?php echo esc_html__( 'DeBlocker', 'deblocker' ) ?>">
                            </i>
                            <span class="mdc-list-item__text">
                                <?php echo esc_html__( 'DeBlocker', 'deblocker' ) ?>
                                <sup><?php echo esc_html__( 'ver.', 'deblocker' ) . esc_html( DeBlocker::$version ); ?></sup>
                            </span>
                        </a>
                        <button type="submit" name="submit" id="submit"
                                class="mdc-button mdc-button--dense mdc-button--raised">
                            <span class="mdc-button__label"><?php echo esc_html__( 'Save changes', 'deblocker' ) ?></span>
                        </button>
                    </div>

                    <hr class="mdc-plugin-menu">
                    <hr class="mdc-list-divider">
                    <h6 class="mdc-list-group__subheader"><?php echo esc_html__( 'Plugin settings', 'deblocker' ) ?></h6>

					<?php

					// Plugin settings tabs
					foreach ( $tabs as $tab => $value ) {
						$class = ( $tab == $current ) ? ' mdc-list-item--activated' : '';
						echo "<a class='mdc-list-item " . $class . "' href='?post_type=deblocker_record&page=mdp_deblocker_settings&tab=" . $tab . "'><i class='material-icons mdc-list-item__graphic' aria-hidden='true'>" . $value['icon'] . "</i><span class='mdc-list-item__text'>" . $value['name'] . "</span></a>";
					}

					/** Helpful links. */
					$this->support_link();

					/** Activation Status. */
					PluginActivation::get_instance()->display_status();

					?>
                </nav>
            </div>
        </aside>
		<?php
	}

	/**
	 * Displays useful links for an activated and non-activated plugin.
	 *
	 * @since 1.0.0
     *
     * @return void
	 **/
	public function support_link() { ?>

        <hr class="mdc-list-divider">
        <h6 class="mdc-list-group__subheader"><?php echo esc_html__( 'Helpful links', 'deblocker' ) ?></h6>

        <a class="mdc-list-item" href="https://docs.merkulov.design/tag/deblocker/" target="_blank">
            <i class="material-icons mdc-list-item__graphic" aria-hidden="true"><?php echo esc_html__( 'collections_bookmark' ) ?></i>
            <span class="mdc-list-item__text"><?php echo esc_html__( 'Documentation', 'deblocker' ) ?></span>
        </a>

		<?php if ( PluginActivation::get_instance()->is_activated() ) : /** Activated. */ ?>
            <a class="mdc-list-item" href="https://1.envato.market/deblocker-support" target="_blank">
                <i class="material-icons mdc-list-item__graphic" aria-hidden="true">mail</i>
                <span class="mdc-list-item__text"><?php echo esc_html__( 'Get help', 'deblocker' ) ?></span>
            </a>
            <a class="mdc-list-item" href="https://1.envato.market/cc-downloads" target="_blank">
                <i class="material-icons mdc-list-item__graphic" aria-hidden="true">thumb_up</i>
                <span class="mdc-list-item__text"><?php echo esc_html__( 'Rate this plugin', 'deblocker' ) ?></span>
            </a>
		<?php endif; ?>

        <a class="mdc-list-item" href="https://1.envato.market/cc-merkulove" target="_blank">
            <i class="material-icons mdc-list-item__graphic" aria-hidden="true"><?php echo esc_html__( 'store' ) ?></i>
            <span class="mdc-list-item__text"><?php echo esc_html__( 'More plugins', 'deblocker' ) ?></span>
        </a>
		<?php

	}

	/**
	 * Add plugin settings page.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function add_settings_page() {

		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		add_action( 'admin_init', [ $this, 'settings_init' ] );

	}

	/**
	 * Create Custom CSS Tab.
	 *
	 * @since 2.0.1
	 * @access public
	 **/
	public function tab_custom_css() {

		/** Custom CSS. */
		$group_name = 'DeBlockerCSSOptionsGroup';
		$section_id = 'mdp_deblocker_settings_page_css_section';

		/** Create settings section. */
		register_setting( $group_name, 'mdp_deblocker_css_settings' );
		add_settings_section( $section_id, '', null, $group_name );

	}

	/**
	 * Create General Tab.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
    public function tab_general() {

	    /** General Tab. */
	    $group_name = 'DeBlockerOptionsGroup';
	    $section_id = 'mdp_deblocker_settings_page_general_section';
	    $option_name = 'mdp_deblocker_settings';

	    /** Create settings section. */
	    register_setting( $group_name, $option_name );
	    add_settings_section( $section_id, '', null, $group_name );

	    /** Render Settings fields. */
	    add_settings_field( 'algorithm',        esc_html__( 'Algorithm:', 'deblocker' ),                ['\Merkulove\DeBlocker\SettingsFields', 'algorithm'], $group_name, $section_id );
        add_settings_field( 'style',            esc_html__( 'Modal Style:', 'deblocker' ),              ['\Merkulove\DeBlocker\SettingsFields', 'style'], $group_name, $section_id );
	    add_settings_field( 'timeout',          esc_html__( 'Delay:', 'deblocker' ),                    ['\Merkulove\DeBlocker\SettingsFields', 'timeout'], $group_name, $section_id );
	    add_settings_field( 'title',            esc_html__( 'Title:', 'deblocker' ),                    ['\Merkulove\DeBlocker\SettingsFields', 'title'], $group_name, $section_id );
	    add_settings_field( 'content',          esc_html__( 'Content:', 'deblocker' ),                  ['\Merkulove\DeBlocker\SettingsFields', 'content'], $group_name, $section_id );
	    add_settings_field( 'bg_color',         esc_html__( 'Overlay Color:', 'deblocker' ),            ['\Merkulove\DeBlocker\SettingsFields', 'bg_color'], $group_name, $section_id );
	    add_settings_field( 'modal_color',      esc_html__( 'Modal Color:', 'deblocker' ),              ['\Merkulove\DeBlocker\SettingsFields', 'modal_color'], $group_name, $section_id );
	    add_settings_field( 'text_color',       esc_html__( 'Text Color:', 'deblocker' ),               ['\Merkulove\DeBlocker\SettingsFields', 'text_color'], $group_name, $section_id );
	    add_settings_field( 'closeable',        esc_html__( 'Is it possible to close?', 'deblocker' ),  ['\Merkulove\DeBlocker\SettingsFields', 'closeable'], $group_name, $section_id );
	    add_settings_field( 'blur',             esc_html__( 'Blur Content:', 'deblocker' ),             ['\Merkulove\DeBlocker\SettingsFields', 'blur'], $group_name, $section_id );
	    add_settings_field( 'javascript',       esc_html__( 'JavaScript Required:', 'deblocker' ),      ['\Merkulove\DeBlocker\SettingsFields', 'javascript'], $group_name, $section_id );
	    add_settings_field( 'javascript_msg',   esc_html__( 'JavaScript Message:', 'deblocker' ),       ['\Merkulove\DeBlocker\SettingsFields', 'javascript_msg'], $group_name, $section_id );

    }

	/**
	 * Generate Settings Page.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function settings_init() {

		/** General Tab. */
	    $this->tab_general();

		/** Create Assignments Tab. */
		AssignmentsTab::get_instance()->add_settings();

		/** Create Custom CSS Tab. */
		$this->tab_custom_css();

		/** Activation Tab. */
		PluginActivation::get_instance()->add_settings();

		/** Create Status Tab. */
		StatusTab::get_instance()->add_settings();

		/** Create Uninstall Tab. */
		UninstallTab::get_instance()->add_settings();

	}

	/**
	 * Add admin menu for plugin settings.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function add_admin_menu() {

		add_menu_page(
			esc_html__( 'DeBlocker Settings', 'deblocker' ),
			esc_html__( 'DeBlocker', 'deblocker' ),
			'manage_options',
			'mdp_deblocker_settings',
			[ $this, 'options_page' ],
			'data:image/svg+xml;base64,' . base64_encode( file_get_contents( DeBlocker::$path . 'images/logo-menu.svg' ) ),
			'58.3510'// Always change digits after "." for different plugins.
		);

	}

	/**
	 * Plugin Settings Page.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function options_page() {

		/** User rights check. */
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		} ?>
        <!--suppress HtmlUnknownTarget -->
        <form action='options.php' method='post'>
            <div class="wrap">

				<?php
				$tab = 'general';
				if ( isset ( $_GET['tab'] ) ) { $tab = $_GET['tab']; }

				/** Render "DeBlocker settings saved!" message. */
				SettingsFields::get_instance()->render_nags();

				/** Render Tabs Headers. */
				?><section class="mdp-aside"><?php $this->render_tabs( $tab ); ?></section><?php

				/** Render Tabs Body. */
				?><section class="mdp-tab-content mdp-tab-<?php echo esc_attr( $tab ) ?>"><?php

					/** General Tab. */
					if ( 'general' === $tab ) {
						echo '<h3>' . esc_html__( 'DeBlocker Settings', 'deblocker' ) . '</h3>';
						settings_fields( 'DeBlockerOptionsGroup' );
						do_settings_sections( 'DeBlockerOptionsGroup' );

                    /** Assignments Tab. */
					} elseif ( 'assignments' === $tab ) {
						echo '<h3>' . esc_html__( 'Assignments Settings', 'deblocker' ) . '</h3>';
						settings_fields( 'DeBlockerAssignmentsOptionsGroup' );
						do_settings_sections( 'DeBlockerAssignmentsOptionsGroup' );
						AssignmentsTab::get_instance()->render_assignments();

                    /** Custom CSS Tab. */
					} elseif ( 'css' === $tab ) {
						echo '<h3>' . esc_html__( 'Custom CSS', 'deblocker' ) . '</h3>';
						settings_fields( 'DeBlockerCSSOptionsGroup' );
						do_settings_sections( 'DeBlockerCSSOptionsGroup' );
						SettingsFields::get_instance()->custom_css();

					/** Activation Tab. */
					} elseif ( 'activation' === $tab ) {
						settings_fields( 'DeBlockerActivationOptionsGroup' );
						do_settings_sections( 'DeBlockerActivationOptionsGroup' );
						PluginActivation::get_instance()->render_pid();

                    /** Status tab. */
					} elseif ( 'status' === $tab ) {
						echo '<h3>' . esc_html__( 'System Requirements', 'deblocker' ) . '</h3>';
						StatusTab::get_instance()->render_form();

					} /** Uninstall Tab. */
                    elseif ( 'uninstall' === $tab ) {
						echo '<h3>' . esc_html__( 'Uninstall Settings', 'deblocker' ) . '</h3>';
						UninstallTab::get_instance()->render_form();
					}

					?>
                </section>
            </div>
        </form>

		<?php
	}

	/**
	 * Get plugin settings with default values.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 **/
	public function get_options() {

		/** General Tab Options. */
		$options = get_option( 'mdp_deblocker_settings' );

		/** Default values. */
		$defaults = [
			# General Tab
            'algorithm'         => 'random-folder',
			'style'             => 'compact', // Modal Style.
			'closeable'         => isset( $options[ 'closeable' ] ) ? $options[ 'closeable' ] : 'on',
			'timeout'           => '0', // Delay.
			'title'             => esc_html__( 'It Looks Like You Have AdBlocker Enabled', 'deblocker' ), // Title.
			'content'           => '<p>' . esc_html__( 'Please disable AdBlock to proceed to the destination page.', 'deblocker' ) . '<p>', // Content.
			'bg_color'          => 'rgba(255,0,0,0.75)', // Overlay Color.
			'modal_color'       => 'rgba(255,255,255,1)', // Modal Color.
            'text_color'        => '#23282d', // Text Color.
            'blur'              => isset( $options[ 'blur' ] ) ? $options[ 'blur' ] : 'on',
			'javascript'        => isset( $options[ 'javascript' ] ) ? $options[ 'javascript' ] : 'on',
		    'javascript_msg'    => '<h3>' . esc_html__( 'Please Enable JavaScript in your Browser to Visit this Site.', 'deblocker' ) . '<h3>',

			# Custom CSS Tab
            'custom_css'                => '',
        ];

		$results = wp_parse_args( $options, $defaults );

		/** Custom CSS tab Options. */
		$mdp_css_settings = get_option( 'mdp_deblocker_css_settings' );
		$results = wp_parse_args( $mdp_css_settings, $results );

		$this->options = $results;
	}

	/**
	 * Main Settings Instance.
	 *
	 * Insures that only one instance of Settings exists in memory at any one time.
	 *
	 * @static
	 * @return Settings
	 * @since 1.0.0
	 **/
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Settings ) ) {
			self::$instance = new Settings;
		}

		return self::$instance;
	}

} // End Class Settings.
