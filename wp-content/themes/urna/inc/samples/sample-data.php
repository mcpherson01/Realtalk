<?php

$upload_dir = wp_upload_dir();
if ( isset($upload_dir['basedir']) ) {

	$theme_name = 'urna';

	$demo_import_base_dir = $upload_dir['basedir'] . '/'.$theme_name.'_import/';
	$demo_import_base_uri = $upload_dir['baseurl'] . '/'.$theme_name.'_import/';
	$path_dir = $demo_import_base_dir . 'data/';
	$path_uri = $demo_import_base_uri . 'data/';	

	$path_img_dir = $demo_import_base_dir . 'images/';
	$path_img_uri = $demo_import_base_uri . 'images/';

	$path_img_dir 	= $demo_import_base_dir . 'images/';

	if( is_dir($path_img_dir) ) {
		$files = glob($path_img_dir . '*.{jpg}', GLOB_BRACE);

		$skins 			= array();
		foreach($files as $file) {

		  	$name =  basename($file, ".jpg");

		  	$str 			= explode("/images/",$file);


		  	$img_dir 	   	= $path_img_uri.''. $str[1];

			$skins += [$name 	=> array(
				'skin'      	=> $img_dir,
				'title'         => ucfirst($name),
			)];

		}

	}

	if ( is_dir($path_dir) ) {
		$demo_datas = array();

		foreach(glob($path_dir . '*', GLOB_ONLYDIR) as $theme_dir) {
			if(is_file($theme_dir . '/data.xml')) {
				$theme_dir_name = basename($theme_dir);
				$demo_data_items = array();
				$id = 0;

				$files = glob($theme_dir . '/*', GLOB_ONLYDIR);

				$str = explode("/data/",$theme_dir);

				$home_dir_name = basename($theme_dir);
				$home_uri 	   = $path_uri.'/'. $str[1];

				$demo_datas += [$theme_dir_name => $home_uri];
			}
		}
	}
}