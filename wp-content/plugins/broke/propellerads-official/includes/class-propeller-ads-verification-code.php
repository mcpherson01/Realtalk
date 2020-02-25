<?php

class Propeller_Ads_Verification_Code
{
	/**
	 * Settings helper instance
	 *
	 * @var Propeller_Ads_Settings_Helper
	 */
	private $settings_helper;

	/**
	 * @param Propeller_Ads_Settings_Helper $settings_helper
	 */
	public function __construct($settings_helper)
	{
		$this->settings_helper = $settings_helper;
	}

	/**
	 * Get verification code from plugin settings and render meta tag
	 *
	 * @return string
	 */
	public function render()
	{
		$verification_code = $this->settings_helper->get_verification_code();
		if ($verification_code === false) {
			return '';
		}
		return $this->get_tag($verification_code) . PHP_EOL;
	}

	/**
	 * Render meta tag with verification code
	 *
	 * @param string $code
	 * @return string
	 */
	private function get_tag($code)
	{
		return sprintf('<meta name="propeller" content="%s" />', $code);
	}
}
