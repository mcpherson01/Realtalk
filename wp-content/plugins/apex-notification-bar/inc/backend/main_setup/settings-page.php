<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<?php
   $edn_pro_object = new APEXNB_Class();
   $edn_pro_data = $this->apexnb_settings;
   $edn_bars = $this->get_notification_bar_data('');
   $top_edn_bars = $this->get_specific_notification_bar_data('top');
   $bottom_edn_bars = $this->get_specific_notification_bar_data('bottom');
   $left_edn_bars = $this->get_specific_notification_bar_data('left');
   $right_edn_bars = $this->get_specific_notification_bar_data('right');
   //$this->edn_pro_print_array($edn_pro_data);
   if(isset($edn_pro_data['edn_display_pagess']) && is_array($edn_pro_data['edn_display_pagess'])){
      $showpages_array = $edn_pro_data['edn_display_pagess'];
   }else{
       $showpages_array = '';
   }
   //$this->edn_pro_print_array($showpages_array);
    if(isset($edn_pro_data['edn_display_categories']) && is_array($edn_pro_data['edn_display_categories'])){
      $showcat_array = $edn_pro_data['edn_display_categories'];
   }else{
       $showcat_array = '';
   }
   
   ?>
<div class="edn-wrap edn-clear">
   <div class="edn-body-wrapper edn-settings-wrapper clearfix">
      <div class="edn-panel">
        <?php include_once(APEXNB_PRO_PATH.'inc/backend/panel-head.php');?>

         <div class="edn-panel-body apexnb-main-settings">
            <div class="edn-form-wrap">
                     <?php
                            if(isset($_GET['message'])){
                              if($_GET['message'] == 1){ ?>
                               <div class="edn-message edn-message-success updated">
                                    <p>
                                       <?php
                                         _e('All Settings Saved Successfully.',APEXNB_TD);
                                          ?>
                                    </p>
                                 </div>
                              <?php 
                              }else if($_GET['message'] == 2){?>
                                    <div class="edn-message edn-message-success updated">
                                    <p>
                                       <?php
                                         _e('Notification Bar File imported successfully.',APEXNB_TD);
                                          ?>
                                    </p>
                                 </div>

                              <?php }else if($_GET['message'] == 3){?>
                                    <div class="edn-message edn-message-success updated">
                                    <p>
                                       <?php
                                         _e('Something went wrong. Please try again later.',APEXNB_TD);
                                          ?>
                                    </p>
                                 </div>
                              <?php }else if($_GET['message'] == 4){?>
                                    <div class="edn-message edn-message-success updated">
                                    <p>
                                       <?php
                                         _e('Something went wrong. Please check the write permission of temp folder inside the plugin\'s folder.',APEXNB_TD);
                                          ?>
                                    </p>
                                 </div>
                              <?php }else if($_GET['message'] == 5){?>
                                    <div class="edn-message edn-message-success updated">
                                    <p>
                                       <?php
                                         _e('Invalid File Extension.',APEXNB_TD);
                                          ?>
                                    </p>
                                 </div>
                              <?php }else if($_GET['message'] == 7){?>
                                    <div class="edn-message edn-message-success updated">
                                    <p>
                                       <?php
                                         _e('No any file uploaded.',APEXNB_TD);
                                          ?>
                                    </p>
                                 </div>
                              <?php }


                            }
                            ?>
                        </p>
               

               <?php
                  if (isset($_SESSION['edn_settings_message'])) {
                      ?>
               <div class="edn-message edn-message-success updated">
                  <p>
                     <?php
                        echo $_SESSION['edn_settings_message'];
                        unset($_SESSION['edn_settings_message']);
                        ?>
                  </p>
               </div>
               <?php
                  }
                  ?>
                  <?php
                  if (isset($_SESSION['edn_settings_error'])) {
                      ?>
               <div class="edn-error edn-error-success updated">
                  <p>
                     <?php
                        echo $_SESSION['edn_settings_error'];
                        unset($_SESSION['edn_settings_error']);
                        ?>
                  </p>
               </div>
               <?php
                  }
                  ?>
               <?php
                  if (isset($_SESSION['edn_settings_messages'])) {
                      ?>
               <div class="edn-message edn-message-success updated">
                  <p>
                     <?php
                        echo $_SESSION['edn_settings_messages'];
                        unset($_SESSION['edn_settings_messages']);
                        ?>
                  </p>
               </div>
               <?php
                  }
                  ?>
               <?php
                    if (isset($_SESSION['edn-success-message'])) {
                        ?>
                        <div class="edn_clear_section"></div>
                        <div class="edn-message edn-message-success updated">
                            <p>
                                <?php
                                echo $_SESSION['edn-success-message'];
                                unset($_SESSION['edn-success-message']);
                                ?>
                            </p>
                        </div>
                        <?php
                    }
                ?>
               <div class="edn-col-full">
                  <div class="nav-tab-wrapper">
                     <a href="javascript:void(0);" class="nav-tab nav-tab-active ednnb-tabs-trigger" id="general-settings"><?php _e( 'General Settings', APEXNB_TD ); ?></a>
                     <a href="javascript:void(0);" class="nav-tab ednnb-tabs-trigger" id="mailchimp-settings"><?php _e( 'MailChimp API Settings', APEXNB_TD ); ?></a>
                     <a href="javascript:void(0);" class="nav-tab ednnb-tabs-trigger" id="smtp-config"><?php _e( 'SMTP Configuration', APEXNB_TD ); ?></a>
                     <a href="javascript:void(0);" class="nav-tab ednnb-tabs-trigger" id="import-export"><?php _e( 'Import/Export', APEXNB_TD ); ?></a>
                  </div>
        <div class="edn-tabs-section">
               
         <form method="post" action="<?php echo admin_url('admin-post.php');?>" class="edn-settings-form" enctype="multipart/form-data">
              <input type="hidden" name="action" value="edn_pro_settings_action"/>
               <?php $nonce = wp_create_nonce('edn-pro-restore-default-nonce');?> 
               
               <!-- General Settings Tab START-->
               <div class='ednnb-tab-contents ednnb-active-tab' id='tab-general-settings'>
                         <div class="edn-backend-h-title">
                           <?php _e('General Settings', APEXNB_TD) ?>
                         </div>
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label for="enable_disable_bar">
                                          <?php _e('Enable/Disable', APEXNB_TD); ?> 
                                          </label>
                                          <p class="edn-note"><?php _e('Note: Check to enable notification bar in your site.',APEXNB_TD);?>
                                          </p>
                                       </div>
                                       <div class="apexnb-switch edn-field-input">
                                          <input type="checkbox" name="edn_pro_optons" id="enable_disable_bar" value="1" <?php if($edn_pro_data['edn_pro_optons']==1){echo 'checked="checked"';}?> />
                                          <label for="enable_disable_bar"></label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label for="edn_pro_mobile"> <?php _e('Mobile Enable/Disable', APEXNB_TD); ?>
                                          </label>
                                          <p class="edn-note"><?php _e('Note: Check to enable notification bar in mobile.',APEXNB_TD);?>
                                          </p>
                                       </div>
                                       <div class="apexnb-switch edn-field-input">
                                          <input type="checkbox" name="edn_pro_mobile" id="edn_pro_mobile" value="1" <?php if(isset($edn_pro_data['edn_pro_mobile']) && $edn_pro_data['edn_pro_mobile']==1){echo 'checked="checked"';}?> />
                                          <label for="edn_pro_mobile"></label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label>
                                          <?php _e('Top Notification Bar', APEXNB_TD) ?>
                                          </label>
                                          <p class="edn-note">
                                             <?php _e('Note: Choose any dynamically added notification bar as default for top bar.',APEXNB_TD);?>
                                          </p>
                                       </div>
                                       <div class="edn-field-input">
                                          <select name="edn_default_bar" class="edn-default-bar">
                                             <option value="nobar">Choose Top Bar</option>
                                             <?php
                                                if (count($top_edn_bars) > 0) {
                                                    foreach ($top_edn_bars as $pro_bar) {
                                                        ?>
                                             <option value="<?php echo esc_attr($pro_bar->nb_id); ?>" <?php if($edn_pro_data['edn_default_bar']==$pro_bar->nb_id){echo 'selected="selected"';}?>><?php echo esc_attr($pro_bar->edn_bar_name); ?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                              <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label>
                                          <?php _e('Bottom Notification Bar', APEXNB_TD) ?>
                                          </label>
                                          <p class="edn-note">
                                             <?php _e('Note: Choose any dynamically added notification bar as default bottom bar.',APEXNB_TD);?>
                                          </p>
                                       </div>
                                       <div class="edn-field-input">
                                          <select name="edn_bottom_bar" class="edn-default-bar">
                                             <option value="nobar">Choose Bottom Bar</option>
                                             <?php
                                                if (count($bottom_edn_bars) > 0) {
                                                    foreach ($bottom_edn_bars as $pro_bar) {
                                                        ?>
                                             <option value="<?php echo esc_attr($pro_bar->nb_id); ?>" <?php if($edn_pro_data['edn_bottom_bar']==$pro_bar->nb_id){echo 'selected="selected"';}?>><?php echo esc_attr($pro_bar->edn_bar_name); ?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                              <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label>
                                          <?php _e('Left Notification Bar', APEXNB_TD) ?>
                                          </label>
                                          <p class="edn-note">
                                             <?php _e('Note: Choose any dynamically added notification bar as default as left bar.',APEXNB_TD);?>
                                          </p>
                                       </div>
                                       <div class="edn-field-input">
                                          <select name="edn_left_bar" class="edn-default-bar">
                                             <option value="nobar">Choose Left Bar</option>
                                             <?php
                                                if (count($left_edn_bars) > 0) {
                                                    foreach ($left_edn_bars as $pro_bar) {
                                                        ?>
                                             <option value="<?php echo esc_attr($pro_bar->nb_id); ?>" <?php if($edn_pro_data['edn_left_bar']==$pro_bar->nb_id){echo 'selected="selected"';}?>><?php echo esc_attr($pro_bar->edn_bar_name); ?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                              <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label>
                                          <?php _e('Right Notification Bar', APEXNB_TD) ?>
                                          </label>
                                          <p class="edn-note">
                                             <?php _e('Note: Choose any dynamically added notification bar as default as Right bar.',APEXNB_TD);?>
                                          </p>
                                       </div>
                                       <div class="edn-field-input">
                                          <select name="edn_right_bar" class="edn-default-bar">
                                             <option value="nobar">Choose Right Bar</option>
                                             <?php
                                                if (count($right_edn_bars) > 0) {
                                                    foreach ($right_edn_bars as $pro_bar) {
                                                        ?>
                                             <option value="<?php echo esc_attr($pro_bar->nb_id); ?>" <?php if($edn_pro_data['edn_right_bar']==$pro_bar->nb_id){echo 'selected="selected"';}?>><?php echo esc_attr($pro_bar->edn_bar_name); ?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline">
                                          <?php _e('Show Notification Bar On', APEXNB_TD); ?>
                                          </label>
                                          <p class="edn-note">
                                             <?php _e('Note: Show notification bar on whole website, show on all pages  or posts only , specific pages ,on specific category pages or only on home page.',APEXNB_TD);?>
                                          </p>
                                       </div>
                                       <div class="edn-field-input">
                                          <select name="edn_notify_on_pages" id="edn-notify-on-pages" class="edn_notify_on_pages apexnb-selection">
                                             <option value="show_on_all" <?php if(isset($edn_pro_data['edn_notify_on_pages']) && $edn_pro_data['edn_notify_on_pages']=="show_on_all"){echo 'selected="selected"';}?>><?php _e('Show On Whole Site', APEXNB_TD); ?></option>
                                             <option value="all_pages" <?php if(isset($edn_pro_data['edn_notify_on_pages']) && $edn_pro_data['edn_notify_on_pages']=="all_pages"){echo 'selected="selected"';}?>><?php _e('All Pages Only', APEXNB_TD); ?></option>
                                             <option value="all_posts" <?php if(isset($edn_pro_data['edn_notify_on_pages']) && $edn_pro_data['edn_notify_on_pages']=="all_posts"){echo 'selected="selected"';}?>><?php _e('All Posts Only', APEXNB_TD); ?></option>
                                             <option value="only_home_page" <?php if(isset($edn_pro_data['edn_notify_on_pages']) && $edn_pro_data['edn_notify_on_pages']=="only_home_page"){echo 'selected="selected"';}?>><?php _e('Only On Home Page', APEXNB_TD); ?></option>
                                             <option value="specific_pages" <?php if(isset($edn_pro_data['edn_notify_on_pages']) && $edn_pro_data['edn_notify_on_pages']=="specific_pages"){echo 'selected="selected"';}?>><?php _e('Specific Pages/Post', APEXNB_TD); ?></option>
                                             <option value="specific_categories" <?php if(isset($edn_pro_data['edn_notify_on_pages']) && $edn_pro_data['edn_notify_on_pages']=="specific_categories"){echo 'selected="selected"';}?>><?php _e('Specific Categories', APEXNB_TD); ?></option>
                                          </select>
                                       </div>
                                    </div>
                               
                                  <?php include_once(APEXNB_PRO_PATH.'inc/backend/main_setup/get-pages-lists.php');?>
                                  <?php include_once(APEXNB_PRO_PATH.'inc/backend/main_setup/get-category-lists.php');?>
                                

                                 </div>
                              </div>
                      </div>
                      <div class="edn-row">
                      <div class="edn-col-full">
                      <div class="edn-field-wrapper edn-form-field">
                      <div class="edn-field clearfix">
                         <div class="edn-field-label">
                            <label for="enable_disable_bar_on_category">
                            <?php _e('Disable Notification bar on all category pages?', APEXNB_TD); ?> 
                            </label>
                            <p class="edn-note"> <?php _e('Note: If you want to hide notification bar on all category pages, then you can enable this setting.',APEXNB_TD);?>
                            </p>
                         </div>
                         <div class="apexnb-switch edn-field-input">
                            <input type="checkbox" name="edn_disable_bar_on_categories" id="enable_disable_bar_on_category" value="1" <?php if(isset($edn_pro_data['edn_disable_bar_on_categories']) && $edn_pro_data['edn_disable_bar_on_categories']==1){echo 'checked="checked"';}?> />
                            <label for="enable_disable_bar_on_category"></label>
                         </div>
                      </div>                
                      </div>
                      </div>
                      </div>
                       <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline">
                                          <?php _e('Reset Show Only Once Bar', APEXNB_TD); ?>
                                          </label>
                                          <p class="edn-note">
                                             <?php _e('Note: Click on Reset button to reset flag set.<br/>On click reset button, 
                                                all the notification bar hidden after once clicked close or toggle button by logged in users only will be displayed again.',APEXNB_TD);?>
                                          </p>
                                          <img src="<?php echo APEXNB_IMAGE_DIR ?>/templates_ajaxloader/ajax-loader1.gif" class="edn-ajax-loader" style="display: none;margin-bottom: -11px;margin-left: -17px;margin-top: -13px;"><span class="edn-reset-messagess" id="edn-reset-message"></span>
                                       </div>
                                       <div class="edn-field-input">
                                          <input type="button" class="button button-primary" name="edn_reset_button" id="edn_reset_button" value="Reset Now"/>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                <!-- General Settings Tab END-->
                <!-- SMTP Settings Tab START-->
               <div class='ednnb-tab-contents' id='tab-smtp-config' style="display:none">
                         <div class="edn-backend-h-title">
                            <?php _e('SMTP Settings', APEXNB_TD) ?>
                         </div>
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline" for="edn_use_smtp">
                                          <?php _e('Use SMTP', APEXNB_TD); ?> 
                                          </label>
                                          <p class="edn-note">
                                             <?php _e('Use SMTP to send emails?Instead of PHP mail function',APEXNB_TD);?>
                                          </p>
                                       </div>
                                       <div class="apexnb-switch edn-field-input">
                                          <input type="checkbox" name="edn_use_smtp" value="1" id="edn_use_smtp" <?php if(isset($edn_pro_data['edn_use_smtp']) &&  $edn_pro_data['edn_use_smtp']==1){echo 'checked="checked"';}?> />
                                          <label for="edn_use_smtp"></label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline">
                                          <?php _e('SMTP Host', APEXNB_TD); ?>
                                          </label>
                                       </div>
                                       <div class="edn-field-input">
                                          <input type="text" name="edn_smtp_host" value="<?php if(isset($edn_pro_data['edn_smtp_host']) && $edn_pro_data['edn_smtp_host'] != ''){echo $edn_pro_data['edn_smtp_host'];}?>" />	
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline">
                                          <?php _e('SMTP Port', APEXNB_TD); ?>
                                          </label>
                                       </div>
                                       <div class="edn-field-input">
                                          <input type="text" name="edn_smtp_port" value="<?php if(isset($edn_pro_data['edn_smtp_port']) && $edn_pro_data['edn_smtp_port'] != ''){echo $edn_pro_data['edn_smtp_port'];}?>" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        
                        <div class="edn-row">
                           <div class="edn-col-full">
                              <div class="edn-field-wrapper edn-form-field">
                                 <div class="edn-field clearfix">
                                    <div class="edn-field-label">
                                       <label class="edn-label-inline" for="edn_smtp_auth">
                                       <?php _e('Use SMTP Authentication?', APEXNB_TD); ?>
                                       </label>
                                       <p class="edn-note">
                                          <?php _e('If you check this box, make sure the SMTP Username and SMTP Password are completed.',APEXNB_TD);?>
                                       </p>
                                    </div>
                                    <div class="apexnb-switch edn-field-input">
                                       <input type="checkbox" name="edn_smtp_auth" id="edn_smtp_auth" value="1" <?php if(isset($edn_pro_data['edn_smtp_auth']) && $edn_pro_data['edn_smtp_auth']==1){echo 'checked="checked"';}?> />
                                       <label for="edn_smtp_auth"></label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="edn-row">
                           <div class="edn-col-full">
                              <div class="edn-field-wrapper edn-form-field">
                                 <div class="edn-field clearfix">
                                    <div class="edn-field-label">
                                       <label class="edn-label-inline">
                                       <?php _e('Encryption Type', APEXNB_TD); ?>
                                       </label>
                                       <p class="description"><?php _e('Set SMTP required encryption type.',APEXNB_TD);?></p>
                                    </div>
                                    <div class="edn-field-input">
                                       <select name="edn_encryption_type" id="edn-edn_encryption_type" class="edn_encryption_type apexnb-selection">
                                          <option value="ssl" <?php if(isset($edn_pro_data['edn_encryption_type']) && $edn_pro_data['edn_encryption_type']=="ssl"){echo 'selected="selected"';}?>><?php _e('SSL', APEXNB_TD); ?></option>
                                          <option value="tls" <?php if(isset($edn_pro_data['edn_encryption_type']) && $edn_pro_data['edn_encryption_type']=="tls"){echo 'selected="selected"';}?>><?php _e('TLS', APEXNB_TD); ?></option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="edn-row">
                           <div class="edn-col-full">
                              <div class="edn-field-wrapper edn-form-field">
                                 <div class="edn-field clearfix">
                                    <div class="edn-field-label">
                                       <label class="edn-label-inline">
                                       <?php _e('SMTP Username ', APEXNB_TD); ?>
                                       </label>
                                    </div>
                                    <div class="edn-field-input">
                                       <input type="text" name="edn_smtp_username" value="<?php if(isset($edn_pro_data['edn_smtp_username']) && $edn_pro_data['edn_smtp_username'] != ''){echo $edn_pro_data['edn_smtp_username'];}?>" />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="edn-row">
                           <div class="edn-col-full">
                              <div class="edn-field-wrapper edn-form-field">
                                 <div class="edn-field clearfix">
                                    <div class="edn-field-label">
                                       <label class="edn-label-inline">
                                       <?php _e('SMTP Password', APEXNB_TD); ?>
                                       </label>
                                    </div>
                                    <div class="edn-field-input">
                                       <input type="password" name="edn_smtp_password" value="<?php if(isset($edn_pro_data['edn_smtp_password']) && $edn_pro_data['edn_smtp_password'] != ''){echo $edn_pro_data['edn_smtp_password'];}?>" />
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
               </div>
               <!-- SMTP Settings Tab END-->


               <div class="edn-col-full edn-clear edn_submit_section">
                  <div class="edn-well">
                     <div class="edn-field-wrapper edn-form-field">
                        <div class="edn-field clearfix"> 
                           <?php wp_nonce_field('edn-pro-nonce','edn_pro_nonce_field');?>
                           <div class="btn_submit_form">
                              <input type="submit" class="button button-primary" id="edn-save-button" name="settings_submit" value="<?php _e('Save',APEXNB_TD);?>"/>
                              <a class="edn-but" href="<?php echo admin_url().'admin-post.php?action=edn_pro_restore_default&_wpnonce='.$nonce;?>" onclick="return confirm('<?php _e('Are you sure you want to restore default settings?',APEXNB_TD);?>')">
                              <input type="button" value="Restore Default" class="button button-secondary" id="edn-reset-button"/>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

                  <!-- IMport/export Settings Tab START-->
               <div class='ednnb-tab-contents' id='tab-import-export' style="display:none;">
                         <div class="edn-backend-h-title">
                            <?php _e('Import Settings', APEXNB_TD) ?>
                         </div>
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline">
                                             <?php _e("Upload Import File", APEXNB_TD); ?>
                                             <p class="edn-note"><?php _e('Import Custom Notification Bar using json file.',APEXNB_TD);?></p>
                                          </label>
                                          
                                       </div>
                                      <div class="edn-field-input">
                                             <select id="apexnb-choose-file-type">
                                                <option value="">Choose File Type </option>
                                                <option value="upload_demofile">Upload Demo File </option>
                                                <option value="upload_customfile">Upload Custom Json File</option>
                                             </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="edn-row apexnb-demofile apexnb-file-type">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline">
                                             <?php _e("Upload Demo File", APEXNB_TD); ?>
                                             <p class="edn-note"><?php _e('Import Notification Bar Demo File using json file.',APEXNB_TD);?></p>
                                          </label>
                                          
                                       </div>
                                      <div class="edn-field-input">
                                         <?php 
                                          $dir    = APEXNB_PRO_PATH.'/demo';
                                          $files = scandir($dir, 1);
                                              
                                         ?>
                                         <select id="apexnb-first-choice" name="first-choice">
                                            <option value="">Choose Demo File</option>
                                            <?php 
                                            for ($i=0; $i < count($files) - 2; $i++) { 
                                               ?>
                                                <option value="<?php echo $files[$i];?>"><?php echo ucwords(str_replace('-',' ', $files[$i]));?></option>
                                               <?php 
                                            }

                                            ?>
                                         </select>
                                         <img src="<?php echo APEXNB_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-ajax-loader"/>
                                
                                        
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                        <div class="edn-row apexnb-file-type1">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline">
                                             <?php _e("Choose Components Type", APEXNB_TD); ?>
                                             <p class="edn-note"><?php _e('Choose Components type to upload demo file.',APEXNB_TD);?></p>
                                          </label>
                                          
                                       </div>
                                      <div class="edn-field-input">
                                              
                                         <select id="apexnb-second-choice" name="sec-choice">
                                            <option value="">Choose File</option>
                                         </select>
                                             
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                             <div class="edn-row apexnb-file-type2">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline">
                                             <?php _e("Choose Demo File Type", APEXNB_TD); ?>
                                             <p class="edn-note"><?php _e('Choose demo file type to upload.',APEXNB_TD);?></p>
                                          </label>
                                          
                                       </div>
                                      <div class="edn-field-input">
                                              
                                         
                                         <select id="apexnb-third-choice" name="third-choice">
                                            <option value="">Choose File</option>
                                         </select>
                                             
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="edn-row apexnb-uploadfile apexnb-file-type">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline">
                                             <?php _e("Upload Custom File", APEXNB_TD); ?>
                                             <p class="edn-note"><?php _e('Import Custom Notification Bar of our plugin using json file.',APEXNB_TD);?></p>
                                          </label>
                                          
                                       </div>
                                      <div class="edn-field-input">
                                             <input id="apexnb_uploadFile" placeholder="Choose File" disabled="disabled" />
                                             <div class="fileUpload btn btn-primary">
                                                 <span>Upload</span>
                                                 <input id="apexnb_uploadBtn" type="file" class="upload" name="import_bar_file" />
                                             </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

               <div class="apexnb-field">
                      <input type="submit" name="import_submit" value="<?php _e('Import',APEXNB_TD);?>" class="button-primary"/>
                </div> 

                      <div class="edn-backend-h-title">
                       <?php _e('Export Settings', APEXNB_TD) ?>
                         </div>
                           <div class="edn-row">
                              <div class="edn-col-full">
                                 <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-field clearfix">
                                       <div class="edn-field-label">
                                          <label class="edn-label-inline" for="edn_use_smtp">
                                          <?php _e("Export File", APEXNB_TD); ?>
                                          </label>
                                          <p class="edn-note">
                                             <?php _e("Choose Custom Notification Bar to Export", APEXNB_TD); ?>
                                          </p>
                                       </div>
                                       <div class="edn-field-input">
                                               <select name="export_bar_id"> 
                                                  <option value=""><?php _e( 'Select One', APEXNB_TD ); ?></option>
                                                   <?php
                                                if (count($edn_bars) > 0) {
                                                    foreach ($edn_bars as $pro_bar) {
                                                        ?>
                                                   <option value="<?php echo esc_attr($pro_bar->nb_id); ?>"><?php echo esc_attr($pro_bar->edn_bar_name); ?></option>
                                                   <?php
                                                      }
                                                      }
                                                ?>
                                                </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                    <div class="apexnb-field">
                     <input type="submit" name="export_submit" value="<?php _e('Export',APEXNB_TD);?>" class="button-primary"/>
                     </div> 
                        
               </div>
               <!-- IMport/export Settings Tab END-->



                   <!-- Mailchimp Settings Tab Start-->
                  <div class='ednnb-tab-contents' id='tab-mailchimp-settings' style="display:none">
                          <div class="edn-backend-h-title">
                              <?php _e('Mailchimp Settings', APEXNB_TD) ?>
                           </div>
      		             
                     <div class="edn-row">
      						   	<div class="edn-mailchimp-error"></div>
      						   	<?php  $connected = ( apexnb_edn_get_api()->is_connected() );?>
      						   	<input type="hidden" id="edn-positive" value="<?php _e('CONNECTED',APEXNB_TD);?>"/>
      						   	<input type="hidden" id="edn-neutral" value="<?php _e('NOT CONNECTED',APEXNB_TD);?>"/>
      						   	 <div class="apexnb-notifybar">
                              <p class="edn-note"><?php _e( 'The API key for connecting with your MailChimp account.', APEXNB_TD ); ?> <a target="_blank" href="https://admin.mailchimp.com/account/api"><?php _e('Get your API key here.',APEXNB_TD);?></a> / <a target="_blank" href="http://kb.mailchimp.com/accounts/management/about-api-keys"><?php _e('How to get API key.',APEXNB_TD);?></a></p>
                              </div>
                              <div class="edn-col-full">
                              <div class="edn-field-wrapper edn-form-field mailchimp_status">
      						      	 <div class="edn-field">
                                   <div class="edn-field-label-wrap"><label class="edn-label-inline status"><?php _e('Status', APEXNB_TD); ?></label></div>
            						      <div class="edn-field-input-wrap">
                                       <span class="edn_positive" id="edn-postive-response"><?php 
            						         if($connected){ 
            						         _e( 'CONNECTED' ,APEXNB_TD ); 
            						         }else{
            						            _e( 'NOT CONNECTED' ,APEXNB_TD);    
            						         }
            						         ?>
            						      	</span>
                                    </div>
                                    </div>
                              </div>
      						   	</div>
      						   	<div class="edn-status error notice is-dismissable" id="edn-neutral" style="display: none;">
      						      	<p><?php _e( 'NOT CONNECTED', APEXNB_TD ); ?></p>
      						   	</div>

      						   	<div class="edn-col-full">
      						      	<div class="edn-field-wrapper edn-form-field">
      						         	<div class="edn-field">
      						         	<div class="edn-field-label-wrap">
      							         	<label class="edn-label-inline edn_status"><?php _e('MailChimp API Key', APEXNB_TD); ?></label>
      						            	<?php 
      						               	$edn_api_key = get_option('edn_api_key');
      						               // print_r($edn_api_key);
      						               	$edn_api = ((isset($edn_api_key['edn_mailcimp_api']) && $edn_api_key['edn_mailcimp_api'] !='')?$edn_api_key['edn_mailcimp_api']:'');
      						               	?>
      						            </div>
      						            <div class="edn-field-input-wrap">
      						               		<input type="text" name="edn_mailchimp[api_key]" value="<?php echo $edn_api; ?>" class="apexnb-mailchimp-apifield"/>
      						            </div>
      						         	</div>
      						      	</div>
      						   	</div>
                  <div class="btn_submit_form">
                     <input type="button" class="button button-primary" id="edn-mailchimp-submit" value="<?php _e('Save',APEXNB_TD);?>"/>
                      <a class="edn-but" href="<?php echo admin_url().'admin-post.php?action=edn_pro_restore_default&_wpnonce='.$nonce;?>" onclick="return confirm('<?php _e('Are you sure you want to restore default settings?',APEXNB_TD);?>')">
                     <input type="button" value="Restore Default" class="button button-secondary" id="edn-reset-button2"/>
                     </a>
                  </div>
               <img src="<?php echo APEXNB_IMAGE_DIR ?>/templates_ajaxloader/ajax-loader1.gif" class="edn-ajax-loader" style="display: none;">
    <!-- Mailchimp Account Lists Start-->
      
      <div class="edn-form-wrap">
                <?php if($connected) { 
                      // echo '<pre>';
                      //  print_r($this->mailchimp->get_lists());
                      ?>
                  <div class="edn-inner-main-title"><?php _e( 'MailChimp Data' ,APEXNB_TD); ?></div>
                  <div class="apexnb-notifybar">
                    <p class="edn-note"><?php _e( 'The table below shows your MailChimp lists data. If you applied changes to your MailChimp lists, please use the following button to renew your cached data.', APEXNB_TD); ?></p>
                  </div>
               
                  <div class="edn-lists-overview">
                  <?php if( empty( $ednlists ) || ! is_array( $ednlists ) ) { ?>
                     <p><?php _e( 'No lists were found in your MailChimp account', APEXNB_TD); ?>.</p>
                  <?php } else { printf( '<p>' . __( 'A total of %d lists were found in your MailChimp account.', APEXNB_TD) . '</p>', count( $ednlists ) );
                       $i = 1; foreach ( $ednlists as $list ) { ?>

                    <div class="edn-inner-list-name" id="list-<?php echo $i;?>" style="cursor:pointer;">
                     <?php echo esc_html( $list->name ); ?>
                          <div class="arrow-up"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
                               <div class="arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                     </div>
                     <div class="clear"></div>
                  
                  <table class="widefat edn_liststable" cellspacing="0" id="lists-<?php echo $i;?>">
                    <tbody>
                    <tr>
                     <th width="150">List ID</th>
                     <td><?php echo esc_html( $list->id ); ?></td>
                     </tr>
                     <tr>
                        <th># of subscribers</th>
                        <td><?php echo esc_html( $list->subscriber_count ); ?></td>
                     </tr>
                     <tr>
                     <th>Fields</th>
                     <td style="padding: 0; border: 0;">
                        <?php if ( ! empty( $list->merge_vars ) && is_array( $list->merge_vars ) ) { ?>
                           <table class="widefat fixed" cellspacing="0" style="margin: 7px;width: 52%;">
                              <thead>
                              <tr>
                                 <th>Name</th>
                                 <th>Tag</th>
                                 <th>Type</th>
                              </tr>
                              </thead>
                              <?php foreach ( $list->merge_vars as $merge_var ) { ?>
                                 <tr title="<?php printf( __( '%s (%s) with field type %s.', APEXNB_TD), esc_html( $merge_var->name ), esc_html( $merge_var->tag ), esc_html( $merge_var->field_type ) ); ?>">
                                    <td><?php echo esc_html( $merge_var->name );
                                       if ( $merge_var->req ) {
                                          echo '<span style="color:red;">*</span>';
                                       } ?></td>
                                    <td><code><?php echo esc_html( $merge_var->tag ); ?></code></td>
                                    <td><?php echo esc_html( $merge_var->field_type ); ?></td>
                                 </tr>
                              <?php } ?>
                           </table>
                        <?php } ?>
                     </td>
                  </tr>
                  <?php if ( ! empty( $list->interest_groupings ) && is_array( $list->interest_groupings ) ) { ?>
                     <tr>
                        <th>Interest Groupings</th>
                        <td style="padding: 0; border: 0;">
                           <table class="widefat fixed" cellspacing="0">
                              <thead>
                              <tr>
                                 <th>Name</th>
                                 <th>Groups</th>
                              </tr>
                              </thead>
                                    <?php foreach ( $list->interest_groupings as $grouping ) { ?>
                                       <tr title="<?php esc_attr( printf( __( '%s (ID: %s) with type %s.', APEXNB_TD), $grouping->name, $grouping->id, $grouping->form_field ) ); ?>">
                                          <td><?php echo esc_html( $grouping->name ); ?></td>
                                          <td>
                                             <ul class="ul-square">
                                                <?php foreach ( $grouping->groups as $group ) { ?>
                                                   <li><?php echo esc_html( $group->name ); ?></li>
                                                <?php } ?>
                                             </ul>
                                          </td>
                                       </tr>
                                    <?php } ?>
                                 </table>

                              </td>
                           </tr>
                            </tbody>
                        <?php } ?>
                     </table>
                  <?php  $i++; } // end foreach $lists
               } // end if empty ?>
               </div>

              
            <?php }else{ ?>
            <p class="description"><?php _e('Please fill mailchimp api key above to get Mailchimp Account List.');?></p>
            <?php } ?>
         </div>
      	      <input type="hidden" name="edn-renew-cache" class="edn-renew-cache-btn" value="1" />
               <input type="submit" class="edn-renewcachebtn" name="edn_renew_mailchimp" value="<?php _e( 'Renew MailChimp lists', APEXNB_TD); ?>" class="button button-primary" />
               

      	</div>
      </div>
<!-- Mailchimp Settings Tab END-->
        </div>
        </form>
      <?php
      $selected_pages = (!empty($showpages_array)) ? implode(',', $showpages_array) : '';
      $selected_category = (!empty($showcat_array)) ? implode(',', $showcat_array) : '';
      ?>
      <input type="hidden" id="edn-selected-pages" name="specific_selected_page" value="<?php echo $selected_pages; ?>"/>
      <input type="hidden" id="edn-selected-category" name="specific_selected_category" value="<?php echo $selected_category; ?>"/>

     </div>   
  </div>
</div>
<!-- .edn-panel-body -->
</div>
</div>
</div>