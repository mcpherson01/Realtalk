<?php defined('ABSPATH') or die("No script kiddies please!");
/**
 * Posted Data
 * 
 */
//$this->edn_pro_print_array($_POST);
$apexnb_constant_settings = $this->apexnb_constant_settings;
$apexnb_constant_settings['edn_cc_username']       = sanitize_text_field($_POST['edn_cc_username']);
$apexnb_constant_settings['edn_cc_pwd']            = sanitize_text_field($_POST['edn_cc_pwd']);
$apexnb_constant_settings['edn_cc_apikey']         = sanitize_text_field($_POST['edn_cc_apikey']);
$apexnb_constant_settings['edn_cc_accesstoken']    = sanitize_text_field($_POST['edn_cc_accesstoken']);

$EDN_ConstantContact = new EDN_ConstantContact('oauth2', $apexnb_constant_settings['edn_cc_apikey']  ,$apexnb_constant_settings['edn_cc_username'],$apexnb_constant_settings['edn_cc_accesstoken'] );
// Get a page of ContactLists
$cc_lists = $EDN_ConstantContact->getLists();
            if(isset($cc_lists['xml'])){
              $string = $cc_lists['xml'];
              $err_codes= array(
                '401'
                );
              $check_error = 0;
              foreach ($err_codes as $error_code) {
                  if (strpos($string, $error_code) !== FALSE) {
                      // echo "Match found";
                      // return $response;
                      $check_error = 1;
                  }
              }
            }else{
            	$check_error = 0;
            }

            if($check_error != 1){
            // $_SESSION['edn_settings_message'] = __('Constant Contact Settings Saved Successfully',APEXNB_TD);
              $message = 1;
             update_option('apexnb_constant_settings', $apexnb_constant_settings);   
            }else{
              $message = 2;
             //$_SESSION['edn_settings_message'] = __($string,APEXNB_TD);
             update_option('apexnb_constant_settings', $apexnb_constant_settings); 
            }

wp_redirect(admin_url('admin.php?page=apexnb-constant_contact&message='.$message));       
exit();

// update_option('apexnb_constant_settings', $apexnb_constant_settings);
// $_SESSION['edn_settings_message'] = __('Constant Contact Settings Saved Successfully',APEXNB_TD);
// wp_redirect(admin_url('admin.php?page=apexnb-constant_contact'));
// exit();