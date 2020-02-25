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

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Class used to render plugin settings fields.
 *
 * @since 1.0.0
 * @author Alexandr Khmelnytsky (info@alexander.khmelnitskiy.ua)
 **/
final class SettingsFields {

	/**
	 * The one true SettingsFields.
	 *
	 * @var SettingsFields
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Render Algorithm field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function algorithm() {

		/** Options. */
		$options = [
			'default'       => esc_html__( 'Default', 'deblocker' ),
			'inline'        => esc_html__( 'Inline', 'deblocker' ),
			'random-folder' => esc_html__( 'Random Folder', 'deblocker' ),
			'proxy'         => esc_html__( 'Script Proxy', 'deblocker' ),
		];

		/** Render Select. */
		UI::get_instance()->render_select(
			$options,
			Settings::get_instance()->options['algorithm'], // Selected option.
			esc_html__('Algorithm', 'deblocker' ),
			esc_html__('The DeBlocker supports several algorithms. Choose the most suitable for your needs. ', 'deblocker' ) .
			esc_html__('Read more ', 'deblocker' ) .
            '<a href="https://docs.merkulov.design/algorithms-of-the-deblocker-wordpress-plugin/" target="_blank" rel="noopener">' .
                esc_html__('about algorithms', 'deblocker' ) .
            '</a>' .
			esc_html__(' in the documentation.', 'deblocker' ),
			[
				'name' => 'mdp_deblocker_settings[algorithm]',
				'id' => 'mdp_deblocker_settings_algorithm'
			]
		);

	}

	/**
	 * Render Modal Style field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function style() {

		/** Modal Styles options. */
		$options = [
            'compact'               => esc_html__( 'Compact', 'deblocker' ),
			'compact-right-top'     => esc_html__( 'Compact: Upper Right Corner', 'deblocker' ),
            'compact-left-top'      => esc_html__( 'Compact: Upper Left Corner', 'deblocker' ),
            'compact-right-bottom'  => esc_html__( 'Compact: Bottom Right Corner', 'deblocker' ),
            'compact-left-bottom'   => esc_html__( 'Compact: Bottom Left Corner', 'deblocker' ),
            'full'                  => esc_html__( 'Full Screen', 'deblocker' ),
		];

		/** Render Modal Style select. */
		UI::get_instance()->render_select(
			$options,
			Settings::get_instance()->options['style'], // Selected option.
			esc_html__('Modal Style', 'deblocker' ),
			esc_html__('Deblocker modal window style.', 'deblocker' ),
			[
				'name' => 'mdp_deblocker_settings[style]',
				'id' => 'mdp_deblocker_settings_style'
			]
		);

	}

	/**
	 * Render Is it possible to close? field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function closeable() {

		/** Render Is it possible to close? switcher. */
		UI::get_instance()->render_switches(
			Settings::get_instance()->options['closeable'],
			esc_html__('Closable', 'deblocker' ),
			esc_html__( 'The user can close the window and continue browsing the site.', 'deblocker' ),
			[
				'name' => 'mdp_deblocker_settings[closeable]',
				'id' => 'mdp_deblocker_settings_closeable'
			]
		);

	}

	/**
	 * Render Delay field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function timeout() {

		/** Render Delay slider. */
		UI::get_instance()->render_slider(
			Settings::get_instance()->options['timeout'],
			0,
			10000,
			100,
			esc_html__( 'Delay', 'deblocker' ),
			esc_html__( 'Modal window will be shown after ', 'deblocker' ) .
			'<strong>' . Settings::get_instance()->options['timeout'] . '</strong>' .
			esc_html__( ' milliseconds.', 'deblocker' ),
			[
				'name' => 'mdp_deblocker_settings[timeout]',
				'id' => 'mdp_deblocker_settings_timeout',
				'class' => 'mdc-slider-width'
			]
		);

	}

	/**
	 * Render Title field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function title() {

		/** Render Title input. */
		UI::get_instance()->render_input(
			Settings::get_instance()->options['title'],
			esc_html__( 'Title:', 'deblocker' ),
			esc_html__( 'Modal window title.', 'deblocker' ),
			[
				'name' => 'mdp_deblocker_settings[title]',
				'id' => 'mdp_deblocker_settings_title'
			]
        );

    }

	/**
	 * Render Content field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function content() {

		/** Render Content editor. */
		wp_editor( Settings::get_instance()->options['content'], 'mdpdeblockersettingscontent', array( 'textarea_rows' => 3, 'textarea_name' => 'mdp_deblocker_settings[content]' ) );

	}

	/**
	 * Render Overlay Color field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function bg_color() {

		/** Render Overlay Color colorpicker. */
		UI::get_instance()->render_colorpicker(
			Settings::get_instance()->options['bg_color'],
			esc_html__( 'Overlay Color', 'deblocker' ),
			esc_html__( 'Page overlay Background Color.', 'deblocker' ),
			[
				'name' => 'mdp_deblocker_settings[bg_color]',
				'id' => 'mdp_deblocker_settings_bg_color',
				'readonly' => 'readonly'
			]
		);

    }

	/**
	 * Render Modal Color field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function modal_color() {

		/** Render Modal Color colorpicker. */
		UI::get_instance()->render_colorpicker(
			Settings::get_instance()->options['modal_color'],
			esc_html__( 'Modal Color', 'deblocker' ),
			esc_html__( 'Modal window Background Color.', 'deblocker' ),
			[
				'name' => 'mdp_deblocker_settings[modal_color]',
				'id' => 'mdp_deblocker_settings_modal_color',
				'readonly' => 'readonly'
			]
		);

	}

	/**
	 * Render Text Color field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function text_color() {

		/** Render Text Color colorpicker. */
		UI::get_instance()->render_colorpicker(
			Settings::get_instance()->options['text_color'],
			esc_html__( 'Text Color', 'deblocker' ),
			esc_html__( 'Text color inside a modal window.', 'deblocker' ),
			[
				'name' => 'mdp_deblocker_settings[text_color]',
				'id' => 'mdp_deblocker_settings_text_color',
				'readonly' => 'readonly'
			]
		);

	}

	/**
	 * Render Blur Content field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function blur() {

		/** Render Blur Content switcher. */
		UI::get_instance()->render_switches(
			Settings::get_instance()->options['blur'],
			esc_html__( 'Blur Content', 'deblocker' ),
			esc_html__( 'Effects like blur or color shifting on an element\'s rendering before the element is displayed.', 'deblocker' ),
			[
				'name' => 'mdp_deblocker_settings[blur]',
				'id' => 'mdp_deblocker_settings_blur'
			]
		);

	}

	/**
	 * Render JavaScript Required field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function javascript() {

		/** Render JavaScript Required switcher. */
		UI::get_instance()->render_switches(
			Settings::get_instance()->options['javascript'],
			esc_html__('Protect if JavaScript is Disabled.', 'deblocker' ),
			esc_html__('Block page content if JS is disabled.', 'deblocker' ),
			[
				'name' => 'mdp_deblocker_settings[javascript]',
				'id' => 'mdp_deblocker_settings_javascript'
			]
		);

	}

	/**
	 * Render JavaScript Required Message field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function javascript_msg() {

		/** Render JavaScript Required Message editor. */
		wp_editor( Settings::get_instance()->options['javascript_msg'], 'mdpdeblockersettingsjavascript', array( 'textarea_rows' => 3, 'textarea_name' => 'mdp_deblocker_settings[javascript_msg]' ) );
		?>
		<div class="mdc-text-field-helper-line">
			<div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent"><?php esc_html_e( 'Message to show if JavaScript is Disabled.', 'deblocker' ); ?></div>
		</div>
		<?php

	}

	/**
	 * Render CSS field.
	 *
	 * @since 2.0.1
	 * @access public
	 **/
	public static function custom_css() {
		?>
        <div>
            <label>
                <textarea
                        id="mdp_custom_css_fld"
                        name="mdp_deblocker_css_settings[custom_css]"
                        class="mdp_custom_css_fld"><?php echo esc_textarea( Settings::get_instance()->options['custom_css'] ); ?></textarea>
            </label>
            <p class="description"><?php esc_html_e( 'Add custom CSS here.', 'deblocker' ); ?></p>
        </div>
		<?php
	}

	/**
	 * Render "SettingsFields Saved" nags.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 **/
	public static function render_nags() {

		/** Did we try to save settings? */
		if ( ! isset( $_GET['settings-updated'] ) ) { return; }

		/** Are the settings saved successfully? */
		if ( $_GET['settings-updated'] === 'true' ) {

			/** Render "SettingsFields Saved" message. */
			UI::get_instance()->render_snackbar( esc_html__( 'Settings saved!', 'deblocker' ) );
		}

		if ( ! isset( $_GET['tab'] ) ) { return; }

		if ( strcmp( $_GET['tab'], "activation" ) == 0 ) {

			if ( PluginActivation::get_instance()->is_activated() ) {

				/** Render "Activation success" message. */
				UI::get_instance()->render_snackbar( esc_html__( 'Plugin activated successfully.', 'deblocker' ), 'success', 5500 );

			} else {

				/** Render "Activation failed" message. */
				UI::get_instance()->render_snackbar( esc_html__( 'Invalid purchase code.', 'deblocker' ), 'error', 5500 );

			}

		}

	}

	/**
	 * Main SettingsFields Instance.
	 *
	 * Insures that only one instance of SettingsFields exists in memory at any one time.
	 *
	 * @static
	 * @return SettingsFields
	 * @since 1.0.0
	 **/
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof SettingsFields ) ) {
			self::$instance = new SettingsFields;
		}

		return self::$instance;
	}
	
} // End Class SettingsFields.
