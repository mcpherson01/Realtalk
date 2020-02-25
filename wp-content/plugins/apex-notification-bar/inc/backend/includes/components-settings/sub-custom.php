<div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                         <div class="edn-field">
                      <div class="edn-field-label-wrap"><label><?php _e('Form Header Text',APEXNB_TD);?></label></div>
                    <div class="edn-field-input-wrap">
                        <input type="text" name="edn_subs_custom[head_text]" placeholder="<?php _e('E.g: Subscribe Newsletter',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_subs_custom']['head_text']) && $edn_bar_setting['edn_subs_custom']['head_text'] != ''){ echo esc_attr($edn_bar_setting['edn_subs_custom']['head_text']); }?>" />
                    </div>
                    </div>
                </div>
            </div>
             <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label-wrap"> <label><?php _e('Description',APEXNB_TD);?></label></div>
                        <div class="edn-field-input-wrap">
                          <textarea  name="edn_subs_custom[description]" placeholder="<?php _e('E.g:Get Latest Deal, Offers & Product Updates via Email',APEXNB_TD);?>"><?php if(isset($edn_bar_setting['edn_subs_custom']['description'] )) echo esc_attr($edn_bar_setting['edn_subs_custom']['description'])?></textarea>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label-wrap"><label><?php _e('Button Text',APEXNB_TD);?></label></div>
                        <div class="edn-field-input-wrap">
                           <input type="text" name="edn_subs_custom[but_text]" 
                           placeholder="<?php _e('E.g: Subscribe',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_subs_custom']['but_text']) && $edn_bar_setting['edn_subs_custom']['but_text'] != ''){  
                            echo esc_attr($edn_bar_setting['edn_subs_custom']['but_text']); } ?>" />
                        </div>
                        </div>
                    </div>
                </div>

                 <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label-wrap"><label><?php _e('Email Placeholder',APEXNB_TD);?></label></div>
                        <div class="edn-field-input-wrap">
                        <input type="text" name="edn_subs_custom[but_email_placeholder]" placeholder="<?php _e('e.g.,Email Address',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_subs_custom']['but_email_placeholder'])) echo esc_attr($edn_bar_setting['edn_subs_custom']['but_email_placeholder'])?>"  />
                        </div>
                        </div>
                    </div>
                </div>

                 <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label-wrap"> <label><?php _e('Email Error Message',APEXNB_TD);?></label></div>
                        <div class="edn-field-input-wrap">
                           <input type="text" name="edn_subs_custom[but_email_err]" placeholder="<?php _e('e.g.,Please enter valid email address.',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_subs_custom']['but_email_error_message'])) echo esc_attr($edn_bar_setting['edn_subs_custom']['but_email_error_message'])?>" />
                        </div>
                        </div>
                    </div>
                </div>
                 <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label-wrap"><label><?php _e('Already Subscibed Error Message',APEXNB_TD);?></label>
                        <p class="edn-note"><?php _e('Success message to users if email address provided is already subscibed one.',APEXNB_TD);?></p></div>
                        <div class="edn-field-input-wrap">
                          <input type="text" name="edn_subs_custom[but_already_subs]" 
                          placeholder="<?php _e('e.g.,You have already subscribed.',APEXNB_TD);?>" 
                          value="<?php if(isset($edn_bar_setting['edn_subs_custom']['but_already_subs'])) echo esc_attr($edn_bar_setting['edn_subs_custom']['but_already_subs'])?>" />
                        </div>
                        </div>
                    </div>
                </div>
                 <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label-wrap"> 
                          <label><?php _e('Mail Confirmation Success Message',APEXNB_TD);?></label>
                          <p class="edn-note"><?php _e('Success message to users for confirmation to check mail.',APEXNB_TD);?></p>
                        </div>
                        <div class="edn-field-input-wrap">
                         <input type="text" name="edn_subs_custom[but_check_to_conform]" placeholder="<?php _e('e.g.,Please check your mail to confirm.',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_subs_custom']['but_check_to_conform'])) echo esc_attr($edn_bar_setting['edn_subs_custom']['but_check_to_conform'])?>"  />
                        </div>
                        </div>
                    </div>
                </div>
                    <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field"> <div class="edn-field">
                       <div class="edn-field-label-wrap"> 
                          <label><?php _e('Sending Fail Error Message',APEXNB_TD);?></label>
                        </div>
                        <div class="edn-field-input-wrap">
                         <input type="text" name="edn_subs_custom[but_sending_fail]" placeholder="<?php _e('e.g.,Confirmation sending fail.',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_subs_custom']['but_sending_fail'])) echo esc_attr($edn_bar_setting['edn_subs_custom']['but_sending_fail'])?>" />
                        </div>
                        </div>
                    </div>
                </div>
              
                <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field">
                    <div class="edn-field">
                        <div class="edn-field-label-wrap">
                        <label><?php _e('Thank You Note',APEXNB_TD);?></label>
                         <p class="edn-note"><?php _e('Note: If above fields left empty, default value set will be placeholder value.',APEXNB_TD);?></p>
                         </div>
                                    <div class="edn-field-input-wrap">
                        <?php $thank_text = (isset($edn_bar_setting['edn_subs_custom']['thank_text']))?$edn_bar_setting['edn_subs_custom']['thank_text']:''; ?>
                            <input type="text" placeholder="<?php _e('e.g.,Thank you for subscribe us.',APEXNB_TD);?>" 
                            name="edn_subs_custom[thank_text]" value="<?php echo $thank_text;?>">   
                       
                        </div>
                        </div>
                    </div>
                </div>     



                <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field">
                        <div class="edn-field">
                               <div class="edn-field-label-wrap">
                                <label class="edn-label-inline" for="custom_confirm">
                                <?php _e('Enable Check Confirmation', APEXNB_TD); ?>
                                 </label>
                                  <p class="edn-note"><?php _e('Check if you want users to send confirmation email.',APEXNB_TD);?></p>
                                </div>
                              <div class="edn-field-input-wrap">
                        <div class="apexnb-switch">
                                <input type="checkbox" class="edn_subs_confirm" id="custom_confirm" name="edn_subs_custom[confirm]" value="1" <?php if(isset($edn_bar_setting['edn_subs_custom']['confirm']) && $edn_bar_setting['edn_subs_custom']['confirm'] == 1){echo 'checked="checked"';}?> />
                                 <label for="custom_confirm"></label>
                              
                           </div>
                           </div>
                        </div>
                    </div>
                         <div class="edn-subs-confirm-fields" id="edn-subs-confirm-fields" style="display: none;"> 
                                <div class="edn-field">
                                    <div class="edn-field-label-wrap">
                                       <label class="edn-label-inline"><?php _e('From Name', APEXNB_TD); ?></label>
                                        <p class="edn-note"><?php _e('Fill the site name you want to display in confirmation email.If left empty, default value will be set as your site name.',APEXNB_TD);?></p>
                                    </div>
                                    <div class="edn-field-input-wrap">
                                        <input type="text" class="edn_subs_confirm_name" name="edn_subs_custom[from_name]" value="<?php if(isset($edn_bar_setting['edn_subs_custom']['from_name'])) echo $edn_bar_setting['edn_subs_custom']['from_name'];?>" placeholder="<?php echo get_bloginfo( 'name' ); ?>"/>
                                       
                                    </div>
                                </div>
                
                                <div class="edn-field">
                                <div class="edn-field-label-wrap">
                                    <label class="edn-label-inline"><?php _e('From Email', APEXNB_TD); ?> </label>
                                     <p class="edn-note"><?php _e('Fill email you want to display in confirmation email.If left empty, default value will be set as noreply@siteurl.com',APEXNB_TD);?></p>
                                   </div>
                                    <div class="edn-field-input-wrap">
                                  <input type="text" class="edn_subs_confirm_email" name="edn_subs_custom[from_email]" value="<?php if(isset($edn_bar_setting['edn_subs_custom']['from_email'])) echo $edn_bar_setting['edn_subs_custom']['from_email'];?>" placeholder="noreply@siteurl.com"/>
                                       
                                   </div>
                               </div>
                 </div>
                </div>
             