<?php
defined('ABSPATH') or die("No script kiddies please!");
global $wpdb;
$apexnb_constant_settings = $this->apexnb_constant_settings;
if($apexnb_constant_settings['edn_cc_username']){
$cc_username         = $apexnb_constant_settings['edn_cc_username'];
}else{
   $cc_username         = ''; 
}
if(isset($apexnb_constant_settings['edn_cc_apikey'])){
$edn_cc_apikey       = $apexnb_constant_settings['edn_cc_apikey'];
}else{
 $edn_cc_apikey       = '';   
}
if(isset($apexnb_constant_settings['edn_cc_accesstoken'])){
$edn_cc_accesstoken  = $apexnb_constant_settings['edn_cc_accesstoken'];
}else{
    $edn_cc_accesstoken  = '';
}

if( $cc_username != '' && $edn_cc_apikey != '' && $edn_cc_accesstoken != ''){
$EDN_ConstantContact = new EDN_ConstantContact('oauth2', $edn_cc_apikey ,$cc_username, $edn_cc_accesstoken);
//echo "<pre>"; print_r($EDN_ConstantContact);
// Get a page of ContactLists
$constant_lists = $EDN_ConstantContact->getLists();
//echo "<pre>"; print_r($constant_lists);
}else{
    $constant_lists = array();
}


$nb_id = $_GET['nb_id'];
$edn_bars = $this->get_notification_bar_data($nb_id);
$edn_bar = $edn_bars[0];
$edn_bar_setting = unserialize($edn_bar->edn_bar);
$edn_bar_date = unserialize($edn_bar->edn_date);

// $this->edn_pro_print_array($edn_bar_setting);

?>
<style id="edn-label-font-style"></style>
<div class="edn-body-wrapper edn-add-bar-wrapper">
    <div class="edn-panel">
         <?php include(APEXNB_PRO_PATH.'inc/backend/panel-head.php');?>
        <?php
            if (isset($_SESSION['edn_message'])) {
                ?>
                <div class="edn-message edn-message-success updated">
                    <p>
                        <?php
                        echo $_SESSION['edn_message'];
                        unset($_SESSION['edn_message']);
                        ?>
                    </p>
                </div>
                <?php
            }
        ?>
        <div class="edn-panel-body">
            <div class="edn-backend-h-title">
            <?php if(isset($_GET['action']) && $_GET['action'] == 'edit_nb'){
                 _e('Edit Notification Bar',APEXNB_TD);
                }else{
                _e('Add Notification Bar',APEXNB_TD);
                    } ?>
                <input type="button" class="button button-primary edn-add-trigger-button" value="<?php _e('Save Notification Bar',APEXNB_TD);?>"/>
            </div>
            <div class="edn-form-wrap">
                <form method="post" action="<?php echo admin_url('admin-post.php');?>" class="edn-add-bar-form">
                    <input type="hidden" name="action" value="edn_edit_action"/>
                    <div class="edn-row">
                        <div class="edn-col-half edn-left-panel-wrap">
                            <!-- Left panel/column -->
                            <div class="edn-left-panel-wrap">
                                   <?php include_once(APEXNB_PRO_PATH.'inc/backend/includes/edit/left-panel.php');?>
                            </div>
                            <!-- Left panel/column -->
                            <div class="edn-common-option-panel">
                                <!-- Common option for both types of bar -->
                                  <?php include_once(APEXNB_PRO_PATH.'inc/backend/includes/edit/common-option-panel.php');?>
                                <!-- Common option for both types of bar -->
                            </div>
                        </div>
                    </div>
                    <?php wp_nonce_field('edn_edit_action', 'edn_edit_set_nonce'); ?>
                    <div class="edn-field-wrapper edn-form-field">
                        <input type="submit" class="button button-primary" id="edn-add-button" name="edit_settings_submit" value="<?php _e('Save Notification Bar',APEXNB_TD);?>"/>
                        <input type="hidden" name="social_counter" id="edn-icon-counter" data-msg="<?php _e('You have reached limit for adding social icons',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['social_counter'])){echo esc_attr($edn_bar_setting['social_counter']);}?>"/>
                        <input type="hidden" name="nb_id" value="<?php echo $nb_id; ?>"/>
                        <input type="hidden" name="current_page" value="<?php echo $this->curPageURL(); ?>"/>
                        <input type="hidden" name="edn_template_id" id="edn_template_id"/>
                    </div>
                </form>
            </div>
            <div class="edn-font-awesome-icons" style="display:none">
               <?php include(APEXNB_PRO_PATH.'inc/backend/includes/font-awesome-icons.php');?>
            </div>

              <div class="edn-addwidgets" style="display:none">
                  <?php include(APEXNB_PRO_PATH.'inc/backend/includes/widgets-lists.php');?>
                </div>
        </div>
    </div>
</div>