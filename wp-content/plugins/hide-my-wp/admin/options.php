<?php
	/**
	 * Options for additionally form
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 21.01.2018, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}


	/*function wbcr_hmwp_site_content_page_options($form_options)
	{
		$form_options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'remove_x_powered_by',
			'title' => __('Remove X-Powered-By', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'green'),
			'hint' => __("Many WordPress plugins (WP SuperCache, WT3 Total cache, etc.) stores meta data of the usage. The caching plugins developers use it for advertisements, while hackers need this information to damage your website. By enabling this feature, the X-Powered-By meta data will be removed from the server title.", 'hide_my_wp')
		);

		//todo: Protect admin scripts from cerber

		return $form_options;
	}

	add_action('wbcr_clr_defence_form_base_options', 'wbcr_hmwp_site_content_page_options', 10);*/

	/**
	 * @param $form_options
	 * @return mixed
	 */
	function wbcr_hmwp_privacy_form_options($form_options)
	{
		$options[] = array(
			'type' => 'dropdown',
			'way' => 'buttons',
			'name' => 'replace_javascript_path',
			'title' => __('Search base redirect', 'hide_my_wp'),
			'data' => array(
				array(0, __("Disable JS URLs", 'hide_my_wp')),
				array(1, __('Theme', 'hide_my_wp')),
				array(2, __('Theme and plugins', 'hide_my_wp')),
				array(3, __('Theme, plugins and uploads', 'hide_my_wp'))
			),
			'default' => 1,
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __("Choose if you see Javascript URLs (e.g. \/wp-content\/themes)", 'hide_my_wp')
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'remove_default_description',
			'title' => __('Default Tagline', 'hide_my_wp'),
			'default' => false,
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __("Remove 'Just another WordPress blog' from your feed.", 'hide_my_wp')
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'remove_body_class',
			'title' => __('Body Classes', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __("Clean up body classes *", 'hide_my_wp')
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'remove_post_class',
			'title' => __('Post Classes', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __("Clean up post classes *", 'hide_my_wp')
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'remove_menu_class',
			'title' => __('Menu Classes', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __("Clean up menu classes *", 'hide_my_wp')
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'replace_in_ajax',
			'title' => __('Replace in AJAX', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __("Replace content of AJAX responses *", 'hide_my_wp')
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'replace_wpnonce',
			'title' => __('Change Nonce', 'hide_my_wp'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __("Replace _wpnonce in URLs with _nonce.", 'hide_my_wp')
		);

		$form_options[0]['items'] = WbcrFactoryClearfy000_Helpers::arrayMergeInsert($form_options[0]['items'], $options, 'bottom');

		return $form_options;
	}

	//add_action('wbcr_clr_privacy_form_options', 'wbcr_hmwp_privacy_form_options', 10);

