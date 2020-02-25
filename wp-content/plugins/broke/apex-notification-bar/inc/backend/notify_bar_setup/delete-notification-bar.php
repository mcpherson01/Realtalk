<?php
defined('ABSPATH') or die("No script kiddies please!");
global $wpdb;
$nb_id = $_GET['nb_id'];
$table_name = $table_name = $wpdb->prefix . "apex_notification_bar";
$wpdb->delete( $table_name, array( 'nb_id' => $nb_id ), array( '%d' ) );
//$_SESSION['edn_message'] = __('Notification bar deleted successfully.',APEXNB_TD);
wp_redirect(admin_url().'admin.php?page=apexnb-pro&message=4');
exit;