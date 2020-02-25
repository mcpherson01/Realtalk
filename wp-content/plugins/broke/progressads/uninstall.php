<?php

//Remove Options for Uninstall

if( !defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') ) exit;

	delete_option("DCPA_start");
	delete_option("DCPA_show");
	delete_option("DCPA_showPop");
	delete_option("DCPA_enable_home");
	delete_option("DCPA_logged_prog");
	delete_option("DCPA_logged_modal");
	delete_option("DCPA_modalFreq");
	delete_option("DCPA_pbBack");
	delete_option("DCPA_customPosts");
	delete_option("DCPA_enable_archives");
	delete_option("DCPA_enable_search");
	delete_option("DCPA_enable_404");
	
	delete_option("DCPA_customedit");
	
	delete_option("DCPA_progType");
	delete_option("DCPA_progressHeight");
	delete_option("DCPA_modalPlace");
	delete_option("DCPA_progressColor");
	delete_option("DCPA_progressColorAd");
	delete_option("DCPA_adBackground");
	delete_option("DCPA_closerButton");
	delete_option("DCPA_closerType");
	delete_option("DCPA_skipType");
	delete_option("DCPA_cdButton");
	delete_option("DCPA_closerTextButton");
	delete_option("DCPA_cdText");
	delete_option("DCPA_progSty");
	delete_option("DCPA_remaininText");
	delete_option("DCPA_standText");
	delete_option("DCPA_removProg");
	
	

	//***