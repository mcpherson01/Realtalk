<?php defined('ABSPATH') or die("No script kiddies please!");
	/**
	* @return APEXNB_API
	*/
	function apexnb_get_api() {

		  $opts = apexnb_ednmc_get_options();
          $api = new APEXNB_API( $opts['general']['edn_mailcimp_api'] );

		return $api;
	}