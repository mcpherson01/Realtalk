<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<?php
    $apexnb_constant_settings = $this->apexnb_constant_settings;
    if(isset($apexnb_constant_settings)){
        $edn_username = $apexnb_constant_settings['edn_cc_username'];
        $edn_psd  = $apexnb_constant_settings['edn_cc_pwd'];
        $edn_ccc_apikey  = $apexnb_constant_settings['edn_cc_apikey'];
        $edn_ccc_accesstoken  = $apexnb_constant_settings['edn_cc_accesstoken'];
    }
?>


<div class="edn-wrap edn-clear">
    <div class="edn-body-wrapper edn-settings-wrapper clearfix">
        <div class="edn-panel">
            <?php include_once(APEXNB_PRO_PATH.'inc/backend/panel-head.php');?>
            <div class="edn-panel-body apexnb-backend-setup apexnb-constant-contact-setup">
              
                <div class="edn-form-wrap">
                 <div class="edn-backend-h-title"><?php _e('Constant Contact API Settings', APEXNB_TD) ?></div>
                    
          <div class="edn-clear"></div>
           <?php
                    if (isset($_GET['message'])) {
                        ?>
                        <div class="edn-message edn-message-success updated">
                            <p>
                                <?php
                                if($_GET['message'] == 1){
                                    _e('Constant Contact Settings Saved Successfully',APEXNB_TD);
                                }else if($_GET['message'] == 2){
                                   _e('Please Try again later. Error Found while saving data.',APEXNB_TD);
                                }
                                ?>
                            </p>
                        </div>
                        <?php
                    }
                ?>
                    <form method="post" action="<?php echo admin_url('admin-post.php');?>" class="edn-settings-form">
                        <input type="hidden" name="action" value="edn_pro_constant_contactsettings_action"/>
                        <div class="apexnb-notifybar">
                        <p class="edn-note">
                        <?php _e('To create an API Key,  you need  a Constant Contact account.To Create Your account Sign up From here.'); ?>
                        <a target="_blank" href="https://login.constantcontact.com/login/login.sdo?nosell=">
                        <?php _e('SIGN UP FROM HERE.',APEXNB_TD);?></a>
                        <?php _e('To get your api key and access token, you need to create your mashery account first from here'); ?>
                       
                        <a target="_blank" href="https://constantcontact.mashery.com/login">
                        <?php _e('Get your API key and Access Token here.',APEXNB_TD);?></a></p>
                        </div>
                        <div class="edn-row">
                            <div class="edn-col-full">
                                <div class="edn-field-wrapper edn-form-field">
                                   
                                 <label>
                                <?php _e('Constant Contact Username', APEXNB_TD); ?>
                                </label>
                                <div class="edn-field">
                                <input type="text" name="edn_cc_username" value="<?php if(!empty($edn_username)) { echo $edn_username; }?>"/> 
                                </div>
                                       
                                   
                                </div>
                            </div>
                        </div>
                           <div class="edn-row">
                            <div class="edn-col-full">
                                <div class="edn-field-wrapper edn-form-field">
                                   
                                 <label>
                                <?php _e('Constant Contact Password', APEXNB_TD); ?>
                                </label>
                                <div class="edn-field">
                                <input type="password" name="edn_cc_pwd" value="<?php if(!empty($edn_psd)) {  echo $edn_psd; } ?>"/> 
                                </div>
                                       
                                   
                                </div>
                            </div>
                        </div>
                             <div class="edn-row">
                            <div class="edn-col-full">
                                <div class="edn-field-wrapper edn-form-field">      
                                 <label>
                                <?php _e('Constant Contact API KEY', APEXNB_TD); ?>
                                </label>
                                <div class="edn-field">
                                <input type="text" name="edn_cc_apikey" value="<?php echo $edn_ccc_apikey;?>"/> 
                                </div>
                                       
                                   
                                </div>
                            </div>
                        </div>
                             <div class="edn-row">
                            <div class="edn-col-full">
                                <div class="edn-field-wrapper edn-form-field"> 
                                 <label>
                                <?php _e('Constant Contact Access Token', APEXNB_TD); ?>
                                </label>
                                <div class="edn-field">
                                <input type="text" name="edn_cc_accesstoken" value="<?php echo $edn_ccc_accesstoken;?>"/> 
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="edn-col-full edn-clear">
                            <div class="edn-well">
                                <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field"> 
                                        <?php wp_nonce_field('edn-pro-constant-nonce','edn_pro_constant_nonce_field');?>
                                        <input type="submit" class="button button-primary" id="edn-save-button" name="settings_submit" value="<?php _e('Save',APEXNB_TD);?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- .edn-panel-body -->
        </div>
    </div>
</div>