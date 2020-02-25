<?php

/**
 * settings page
 */
class wtb_idf_calculator_settings {
	/**
	 * @const string
	 */
	const SETTINGS_KEY = 'wtb_idf_calculator';

	/**
     * List of Google TLDs
	 * @const array
	 */
	const GOOGLE_TLDS = [
		".com",
		".co.uk",
		".co.id",
		".co.in",
		".co.jp",
		".co.th",
		".com.br",
		".com.pk",
		".com.bd",
		".com.ng",
		".com.mx",
		".com.ph",
		".com.fn",
		".com.tr",
		".com.ua",
		".ca",
		".es",
		".de",
		".at",
		".fr",
		".it",
		".nl",
		".ru",
		".lt",
		".lv",
		".ee",
		".fi",
		".pl",
		".ro",
		".ch",
		".se",
	];

	/**
	 * return currently installed plugin version
	 * @return mixed
	 */
	static function getInstalledVersion() {
		return get_option( 'wtb_idf_calculator_version', 0 );
	}

	/**
	 * get plugin settings
	 * @return array
	 */
	static function getSettings() {
		return get_option( self::SETTINGS_KEY, array() );
	}

	/**
	 * register settings for our plugin
	 */
	function registerSettings() {
		//register our settings
		register_setting( 'wtb_idf_calculator_settings_main_group', self::SETTINGS_KEY, array( $this, 'sanitize' ) );

		// main section
		add_settings_section(
			'wtb_idf_calculator_settings_main_section',
			__( 'Main settings', 'wtb_idf_calculator' ),
			null,
			'wtb_idf_calculator_settings'
		);

		add_settings_field(
			'google_domain',
			__( 'Google domain', 'wtb_idf_calculator' ),
			array( $this, 'create_an_google_domain_field' ),
			'wtb_idf_calculator_settings',
			'wtb_idf_calculator_settings_main_section'
		);

		// custom post types
		add_settings_section(
			'wtb_idf_calculator_settings_cpt_section',
			__( 'Activate in custom post types', 'wtb_idf_calculator' ),
			null,
			'wtb_idf_calculator_settings'
		);

		add_settings_field(
			'cpt',
			__( 'Custom post types', 'wtb_idf_calculator' ),
			array( $this, 'create_an_custom_post_types_fields' ),
			'wtb_idf_calculator_settings',
			'wtb_idf_calculator_settings_cpt_section'
		);
	}

	/**
	 * renders plugin settings page
	 */
	function renderSettingsPage() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		} ?>

        <div class="wrap">
            <h2><?php echo __( 'WDF*IDF Top10 Calculator settings', 'wtb_idf_calculator' ); ?></h2>

            <form method="post" action="options.php">

				<?php
				settings_fields( 'wtb_idf_calculator_settings_main_group' );
				do_settings_sections( 'wtb_idf_calculator_settings' );
				?>

				<?php submit_button(); ?>
            </form>
        </div>
		<?php
	}

	/**
	 * check input from settings page
	 *
	 * @param $input
	 *
	 * @return mixed
	 */
	public function sanitize( $input ) {
		return $input;
	}

	/**
	 * render custom post types selection fields
	 */
	public function create_an_google_domain_field() {
		$settings    = self::getSettings();
		$cptSettings = ! empty( $settings['google_domain'] ) ? $settings['google_domain'] : '.com';

        echo "<select name=\"".self::SETTINGS_KEY."[google_domain]\">";
        foreach (self::GOOGLE_TLDS as $tld) {
            echo "<option value=\"$tld\" " . selected( $cptSettings, $tld ) . ">$tld</option>";
        }
        echo '</select>';
		echo '<br /><br />';
	}

	/**
	 * render main settings fields
	 */
	public function create_an_custom_post_types_fields() {
		$settings    = self::getSettings();
		$cptSettings = ! empty( $settings['cpt'] ) ? (array) $settings['cpt'] : array();
		foreach ( get_post_types() as $cpt ) {
			if ( ! in_array( $cpt, array( 'attachment', 'revision', 'nav_menu_item' ) ) ) { ?>
                <input type="hidden" name="<?php echo self::SETTINGS_KEY ?>[cpt][<?php echo $cpt ?>]" value="-1"/>
                <label>
                    <input type="checkbox" name="<?php echo self::SETTINGS_KEY ?>[cpt][<?php echo $cpt ?>]"
						<?php checked( ! empty( $cptSettings[ $cpt ] ) and $cptSettings[ $cpt ] == 1 ) ?>
                           value="1"/>
					<?php echo $cpt; ?>
                </label><br/>
				<?php
			}
		}

		echo '<br /><br />';
	}

}