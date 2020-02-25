<?php defined('ABSPATH') or die("No script kiddies please!");
/**
 * Posted Data
 * 
 */
// $this->edn_pro_print_array($_POST);
// exit();
$apexnb_settings = $this->apexnb_settings;
$apexnb_settings['edn_pro_optons']  = sanitize_text_field($_POST['edn_pro_optons']);
$apexnb_settings['edn_disable_bar_on_categories']  = (isset($_POST['edn_disable_bar_on_categories']) && $_POST['edn_disable_bar_on_categories'] == 1)?1:0;
if(isset($_POST['edn_pro_mobile'] )){ 
	$apexnb_settings['edn_pro_mobile']  =  sanitize_text_field($_POST['edn_pro_mobile']);
}else{
$apexnb_settings['edn_pro_mobile'] = 0;
}
$apexnb_settings['edn_default_bar'] = sanitize_text_field($_POST['edn_default_bar']); // top bar
$apexnb_settings['edn_bottom_bar'] = sanitize_text_field($_POST['edn_bottom_bar']);//bottom bar
$apexnb_settings['edn_left_bar'] = sanitize_text_field($_POST['edn_left_bar']); //left bar
$apexnb_settings['edn_right_bar'] = sanitize_text_field($_POST['edn_right_bar']); //right bar

if(isset($_POST['edn_showpages'])){
$edn_display_pages = $_POST['edn_showpages'];
if(isset($edn_display_pages)){$edn_display_pages = $edn_display_pages;}else{$edn_display_pages = array();}
}else{
	$edn_display_pages = array();
}


if(isset($_POST['edn_showterm'])){
$edn_display_categories = $_POST['edn_showterm'];
if(isset($edn_display_categories)){$edn_display_categories = $edn_display_categories;}else{$edn_display_categories = array();}
}else{
	$edn_display_categories = array();
}

$apexnb_settings['edn_notify_on_pages'] = sanitize_text_field($_POST['edn_notify_on_pages']);
$apexnb_settings['edn_display_pagess'] = $edn_display_pages;
$apexnb_settings['edn_display_categories'] = $edn_display_categories;

$apexnb_settings['edn_notification_font'] = 'Roboto';
$apexnb_settings['edn_font_size'] = '12';


//smtp configuration

$edn_use_smtp       =  ((isset($_POST['edn_use_smtp']) && $_POST['edn_use_smtp'] != '')?sanitize_text_field($_POST['edn_use_smtp']):'');
$edn_smtp_host      = ((isset($_POST['edn_smtp_host']) && $_POST['edn_smtp_host'] != '')?sanitize_text_field($_POST['edn_smtp_host']):''); 
$edn_smtp_port      =  ((isset($_POST['edn_smtp_port']) && $_POST['edn_smtp_port'] != '')?sanitize_text_field($_POST['edn_smtp_port']):''); 
$edn_smtp_auth      =  ((isset($_POST['edn_smtp_auth']) && $_POST['edn_smtp_auth'] != '')?sanitize_text_field($_POST['edn_smtp_auth']):''); 
$edn_smtp_username  =  ((isset($_POST['edn_smtp_username']) && $_POST['edn_smtp_username'] != '')?sanitize_text_field($_POST['edn_smtp_username']):''); 
$edn_smtp_password  =  ((isset($_POST['edn_smtp_password']) && $_POST['edn_smtp_password'] != '')?sanitize_text_field($_POST['edn_smtp_password']):''); 
$edn_encryption_type        =  ((isset($_POST['edn_encryption_type']) && $_POST['edn_encryption_type'] != '')?sanitize_text_field($_POST['edn_encryption_type']):''); 

// if($edn_use_smtp  != ''){
// $alert_message = $this->testing_smtp($edn_use_smtp,$edn_smtp_host,$edn_smtp_port,$edn_smtp_auth,$edn_smtp_username,$edn_smtp_password,$edn_encryption_type);
// }
$apexnb_settings['edn_use_smtp']  =  sanitize_text_field($edn_use_smtp);
$apexnb_settings['edn_smtp_host']  =  sanitize_text_field($edn_smtp_host);
$apexnb_settings['edn_smtp_port']  =  sanitize_text_field($edn_smtp_port);
$apexnb_settings['edn_smtp_auth']  =  sanitize_text_field($edn_smtp_auth);
$apexnb_settings['edn_smtp_username']  =  sanitize_text_field($edn_smtp_username);
$apexnb_settings['edn_smtp_password']  =  sanitize_text_field($edn_smtp_password);
$apexnb_settings['edn_encryption_type']  =  sanitize_text_field($edn_encryption_type);
update_option('apexnb_settings', $apexnb_settings);
//$_SESSION['edn_settings_message'] = __('All Settings Saved Successfully.',APEXNB_TD);
wp_redirect(admin_url('admin.php?page=apexnb-settings&message=1'));
exit();