<?php

	/*
	 * Activation and deactivation hooks.
	 *
	 * @author Alex Kovalev <alex@byonepress.com><wordpress.webraftic@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 *
	 * @package core
	 * @since 1.0.0
	 */

	class WHM_Activation extends Wbcr_Factory000_Activator {

		public function activate()
		{
			parent::activate();

			global $wp_rewrite;
			if( !isset($wp_rewrite) ) {
				return;
			}
			//flush_rewrite_rules();
		}

		public function deactivate()
		{
			parent::deactivate();

			global $wp_rewrite;
			if( !isset($wp_rewrite) ) {
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

			WHM_Helpers::flushRules();

			if( defined('WBCR_CLEARFY_PLUGIN_ACTIVE') && class_exists('WCL_Plugin') ) {
				WCL_Plugin::app()->updatePopulateOption('need_rewrite_rules', 1);
			}
		}
	}

