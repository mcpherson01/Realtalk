<?php

/*
Plugin Name: WDF*IDF Top10 Calculator
Plugin URI: 
Description: WDF*IDF Top10 Calculator
Version: 1.0.5
Author: WebTec-Braun
Author URI: http://www.webtec-braun.com
License: 
*/

// don't load it not in admin
if (!is_admin()) {
	return;
}

// load localized translations
load_plugin_textdomain('wtb_idf_calculator', false, 'wtb_idf_calculator/languages');

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

/* config and settings classes */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'actions.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'settings.php';

class wtb_idf_calculator {
	
	const VERSION = '1.0.5';
	
	/**
	 * add plugin actions to wordpress
	 * @param wtb_idf_calculator_actions $actions
	 */
	function __construct(wtb_idf_calculator_actions $actions)
	{
		// load required files/classes
		// @todo load only if realy required
		$this->requireForFunction();

		register_activation_hook( __FILE__, array($actions, 'createTables') );
		
		if (!extension_loaded('curl')) {
			add_action('admin_notices', array($actions, 'showNotices' ));
		} else {
			add_action( 'add_meta_boxes', array($actions, 'addBox' ));

			/* enqueue js and css */
			add_action( 'admin_enqueue_scripts', array($actions, 'addAssets' ));

			/* ajax */
			add_action('wp_ajax_wtb_idf_calculator_api', array($actions, 'wtb_idf_calculator_api_callback' ));
			add_action('wp_ajax_wtb_idf_calculator_stopword_api', array($actions, 'wtb_idf_calculator_stopword_api_callback' ));
            
            /* Do something with the data entered */
            add_action( 'save_post', array($actions, 'savePostdata' ));
		}

		/* settings page */
		add_action( 'admin_menu', array($actions, 'addSettingPage') );
	}
	
	/**
	 * require all files only if plugin activated
	 */
   function requireForFunction()
   {
	   require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'helper.php';

	   /* vendors */
	   require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendors' . DIRECTORY_SEPARATOR . 'simple_html_dom.php';
   }
}

// and we start here
new wtb_idf_calculator(new wtb_idf_calculator_actions());
