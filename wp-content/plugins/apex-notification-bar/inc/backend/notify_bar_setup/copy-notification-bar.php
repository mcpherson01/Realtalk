<?php
defined('ABSPATH') or die("No script kiddies please!");
global $wpdb;
$nb_id = $_GET['nb_id'];
$table_name = $table_name = $wpdb->prefix . "apex_notification_bar";
$edn_bars = $this->get_notification_bar_data($nb_id);
$edn_bar = $edn_bars[0];
//$this->edn_pro_print_array($edn_bar);
/**
 * 
 * stdClass Object
(
    [nb_id] => 4
    [edn_bar_name] => new bar
    [edn_position] => 
    [edn_visibility] => 
    [edn_bar] => a:36:{s:12:"edn_bar_type";N;s:17:"edn_social_optons";N;s:11:"edn_cp_type";s:4:"text";s:21:"edn_text_display_mode";s:6:"static";s:12:"edn_multiple";a:2:{s:18:"call_action_button";s:6:"custom";s:14:"contact_choose";s:6:"c-form";}s:10:"edn_static";a:12:{s:4:"text";s:0:"";s:18:"call_action_button";s:6:"custom";s:8:"but_text";s:0:"";s:7:"but_url";s:0:"";s:9:"but_color";s:0:"";s:14:"but_font_color";s:0:"";s:14:"contact_choose";s:6:"c-form";s:10:"name_label";s:0:"";s:11:"email_label";s:0:"";s:9:"msg_label";s:0:"";s:12:"send_to_mail";s:0:"";s:14:"form_shortcode";s:0:"";}s:15:"edn_subs_choose";s:11:"subs-c-form";s:15:"edn_subs_custom";a:4:{s:9:"head_text";s:0:"";s:8:"but_text";s:0:"";s:14:"but_label_text";s:0:"";s:10:"thank_text";s:0:"";}s:13:"edn_mailchimp";a:3:{s:7:"api_key";s:0:"";s:10:"form_label";s:0:"";s:16:"form_botton_text";s:0:"";}s:18:"edn_contact_choose";N;s:18:"edn_contact_custom";N;s:18:"edn_form_shortcode";N;s:11:"edn_twitter";a:8:{s:12:"consumer_key";s:0:"";s:19:"consumer_secret_key";s:0:"";s:16:"access_token_key";s:0:"";s:23:"access_token_secret_key";s:0:"";s:12:"cache_period";s:0:"";s:10:"total_feed";s:0:"";s:8:"username";s:0:"";s:16:"fallback_message";s:0:"";}s:11:"edn_display";N;s:21:"edn_bar_effect_option";N;s:10:"edn_ticker";a:3:{s:8:"duration";s:0:"";s:9:"animation";s:0:"";s:5:"speed";s:0:"";}s:10:"edn_slider";a:3:{s:8:"duration";s:0:"";s:9:"animation";s:0:"";s:5:"speed";s:0:"";}s:17:"edn_scroll_option";s:10:"left-right";s:17:"edn_selected_page";N;s:17:"edn_selected_post";N;s:21:"edn_selected_category";N;s:18:"edn_selected_terms";N;s:22:"edn_selected_post_type";N;s:14:"edn_start_date";s:0:"";s:12:"edn_end_date";s:0:"";s:8:"edn_type";s:1:"1";s:12:"edn_bg_color";s:0:"";s:14:"edn_font_color";s:0:"";s:9:"edn_fonts";s:7:"defalut";s:13:"edn_font_size";s:1:"8";s:10:"edn_height";s:0:"";s:9:"edn_width";s:0:"";s:23:"edn_social_heading_text";N;s:9:"icon_type";N;s:12:"icon_details";a:0:{}s:16:"edn_bar_template";N;}
)
 * */
 foreach($edn_bar as $key=>$val){
    $$key = $val;
 }
 $nb_created_date  =  date( 'Y-m-d H:i:s:u' );
$nb_modified_date =  date( 'Y-m-d H:i:s:u' );
 $edn_bar_name .=' -copy';
 $wpdb->insert( 
	$table_name, 
array( 
		'edn_bar_name'      => $edn_bar_name,
        'edn_position'      => $edn_position,
        'edn_visibility'    => $edn_visibility,
        'edn_show_duration' => $edn_show_duration,
        'edn_hide_duration' => $edn_hide_duration,
        'edn_close_button'  => $edn_close_button,
        'edn_bar'           => $edn_bar,
        'edn_date'          => $edn_date,
        'nb_created'       => $nb_created_date,
        'nb_modified'      => $nb_modified_date
	),
	array(
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s' 
	)
 );
 //$_SESSION['edn_message'] = __('Notification Bar Copied Successfully.',APEXNB_TD);
 wp_redirect(admin_url().'admin.php?page=apexnb-pro&message=3');   
 exit;