<?php 

/**
 * The following two functions show how to point Variant to a specified URL
 * if your /uploads/ folder is in a different place than usual, you're on multisite
 * or you're getting 404 errors inside Variant.
 * 
 * ebor_check_variant_img_directory - leave this as returning true, we're telling Variant
 * that it's ok to grab the images from the specified URL at: ebor_get_variant_img_directory
 * 
 * ebor_get_variant_img_directory - In the example below we're telling Variant that each of
 * its images should be prefixed with /media/, so we're changing /wp-content/uploads/2017/04/[xyz].jpg to just /media/[xyz].jpg
 */
 
/*
if(!( function_exists('ebor_check_variant_img_directory') )){
	function ebor_check_variant_img_directory(){
		return 'true';
	}
}


if(!( function_exists('ebor_get_variant_img_directory') )){
	function ebor_get_variant_img_directory(){
		return '/media/';
	}
}
*/