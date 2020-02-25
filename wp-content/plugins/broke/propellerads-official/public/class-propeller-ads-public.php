<?php

/**
 * The public-facing functionality of the plugin.
 */
class Propeller_Ads_Public
{
	/**
	 * Settings helper instance
	 *
	 * @var Propeller_Ads_Settings_Helper
	 */
	private $setting_helper;

	/**
	 * Ad-Block file helper instance
	 *
	 * @var Propeller_Ads_Anti_Adblock
	 */
	private $anti_adblock;

	/**
	 * Verification code helper
	 *
	 * @var Propeller_Ads_Verification_Code
	 */
	private $verification_code;

	/**
	 * @param string $plugin_name The name of the plugin.
	 */
	public function __construct($plugin_name)
	{
		$this->setting_helper = new Propeller_Ads_Settings_Helper($plugin_name);
		$this->anti_adblock = new Propeller_Ads_Anti_Adblock($plugin_name);
		$this->verification_code = new Propeller_Ads_Verification_Code($this->setting_helper);
	}

	/**
	 * Insert ad scripts
	 */
	public function insert_script()
	{
		if (is_user_logged_in() && $this->setting_helper->get_field_value('general', 'logged_in_disabled')) {
			return;
		}

		if ($this->setting_helper->get_field_value(Propeller_Ads_Zone_Helper::DIRECTION_ONCLICK, 'enabled')) {
			$onclick_zone_id = $this->setting_helper->get_field_value(Propeller_Ads_Zone_Helper::DIRECTION_ONCLICK, 'zone_id');
			echo $this->anti_adblock->get($onclick_zone_id);
		}

		if ($this->setting_helper->get_field_value(Propeller_Ads_Zone_Helper::DIRECTION_INTERSTITIAL, 'enabled')) {
			$interstitial_zone_id = $this->setting_helper->get_field_value(Propeller_Ads_Zone_Helper::DIRECTION_INTERSTITIAL, 'zone_id');
			echo $this->anti_adblock->get($interstitial_zone_id);
		}

		if ($this->setting_helper->get_field_value(Propeller_Ads_Zone_Helper::DIRECTION_PUSH_NOTIFICATION, 'enabled')) {
			$push_notification_zone_id = $this->setting_helper->get_field_value(Propeller_Ads_Zone_Helper::DIRECTION_PUSH_NOTIFICATION, 'zone_id');

			$this->anti_adblock->get_service_worker_file($push_notification_zone_id);
			echo $this->anti_adblock->get($push_notification_zone_id);
		}
	}

	/**
	 * Insert meta tag with verification code
	 */
	public function insert_verification_code()
	{
		echo $this->verification_code->render();
	}
}
