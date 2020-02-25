<?php defined('ABSPATH') or die("No script kiddies please!");?>
<style id="edn-label-font-style"></style>
<div class="edn-wrap edn-clear">
    <div class="edn-body-wrapper edn-add-bar-wrapper">
        <div class="edn-panel">
              <?php include(APEXNB_PRO_PATH.'inc/backend/panel-head.php');?>
            <div class="edn-panel-body">
                <div class="edn-backend-h-title"><?php _e('Add Notification Bar',APEXNB_TD)?>
                    <input type="button" class="button button-primary edn-add-trigger-button" value="<?php _e('Save Notification Bar',APEXNB_TD);?>"/>
                </div>
                <div class="edn-form-wrap">      
                    <form method="post" action="<?php echo admin_url('admin-post.php');?>" class="edn-add-bar-form">
                        <input type="hidden" name="action" value="edn_pro_add_bar_action"/>
                        <div class="edn-row">
                            <div class="edn-col-half edn-left-panel-wrap">
                                <!-- Left panel/column -->
                                <div class="edn-left-panel-wrap">
                                    <?php include(APEXNB_PRO_PATH.'inc/backend/includes/add_bar/left-panel.php');?>
                                </div>
                                <!-- Left panel/column -->
                                <div class="edn-common-option-panel">
                                    <!-- Common option for both types of bar -->
                                     <?php include(APEXNB_PRO_PATH.'inc/backend/includes/add_bar/common-option-panel.php');?>
                                    <!-- Common option for both types of bar -->
                                </div>
                            </div>
                        </div>
                  
                        <?php wp_nonce_field('edn-pro-add-nonce','edn_pro_add_nonce_field');?>
                        <div class="edn-field-wrapper edn-form-field">
                            <input type="submit" class="button button-primary" id="edn-add-button" name="settings_submit" value="<?php _e('Save Notification Bar',APEXNB_TD);?>"/>
                            <input type="hidden" name="social_counter" id="edn-icon-counter" value="0"/>
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
</div>