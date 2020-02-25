<?php 
  $edn_api_key = get_option('edn_api_key');
  $edn_api = ((isset($edn_api_key['edn_mailcimp_api']) && $edn_api_key['edn_mailcimp_api'] !='')?$edn_api_key['edn_mailcimp_api']:'');
  ?>
                <input type="hidden" name="edn_mailchimp[api_key]" id="mailchimp_key" value="<?php echo $edn_api;?>">
                <div class="edn-row">
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                         
                            <div class="edn-field-label"><label><?php _e( 'Lists this form subscribes to', APEXNB_TD ); ?></label></div>
                            <div class="<?php if(!empty($lists)) echo 'mailchimp-lista-wrapper multiselect'; else echo 'apexnb-notifybar'; ?>">

                                <?php #print_r($edn_bar_setting['edn_mailchimp']['lists']);
                               if(!empty($lists)){
                                    foreach($lists as $list) { 
                                        if(!empty($list)){
                                              if(isset($edn_bar_setting['edn_mailchimp']['lists'])){
                                                $mailchimp_lists = $edn_bar_setting['edn_mailchimp']['lists'];
                                                    if(in_array( $list->id ,$mailchimp_lists)){
                                                          $check  = "checked='checked'";
                                                    }else{
                                                            $check = '';
                                                        }
                                                }else{
                                                    $check  = '';
                                                }
                                            ?>
                                         
                                             <label for="list-<?php echo esc_attr( $list->id ); ?>">
                                               <input type="checkbox" id="list-<?php echo esc_attr( $list->id ); ?>" name="edn_mailchimp[lists][<?php echo esc_attr( $list->id ); ?>]" 
                                                value="<?php echo esc_attr( $list->id ); ?>" <?php echo $check;?> />
                                               <?php echo esc_html( $list->name ); ?></label>
                                        
                             <?php   }
                                   }
                                }else{  ?>
                                    <p class="description">  
                                   <?php _e('Please fill mailchimp api key from here in tab Mailchimp API Settings');?> <a href="<?php echo admin_url('admin.php?page=apexnb-settings');?>" target="_blank"><?php _e('SET YOUR API KEY');?></a><br/>
                                   <?php _e('If lists are empty, either you have not enter api key or no subscribe lists are in your mailchimp account.');
                                       ?></p> 
                                  <?php   } ?>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                         <div class="edn-field">
                             <div class="edn-field-label-wrap"><label><?php _e('Form Header Text',APEXNB_TD);?></label></div>
                           <div class="edn-field-input-wrap">
                                <input type="text" name="edn_mailchimp[head_text]" 
                                placeholder="<?php _e('E.g: Subscribe Newsletter',APEXNB_TD);?>"
                                value="<?php if(isset($edn_bar_setting['edn_mailchimp']['head_text']) && $edn_bar_setting['edn_mailchimp']['head_text'] != ''){ echo esc_attr($edn_bar_setting['edn_mailchimp']['head_text']); } ?>" />
                            </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                                <div class="edn-field"> <div class="edn-field-label-wrap">
                                  <label><?php _e('Mailchimp Description',APEXNB_TD);?></label>
                                  </div>
                             <div class="edn-field-input-wrap">
                                <textarea name="edn_mailchimp[description]"  placeholder="<?php _e('E.g:Get Latest Deal, Offers & Product Updates via Email',APEXNB_TD);?>"><?php if(isset($edn_bar_setting['edn_mailchimp']['description'] )) echo esc_attr($edn_bar_setting['edn_mailchimp']['description'])?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                       <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                                <div class="edn-field"> <div class="edn-field-label-wrap">
                                  <label><?php _e('MailChimp Button text',APEXNB_TD);?></label>
                                  </div>
                             <div class="edn-field-input-wrap">
                                  <input type="text" name="edn_mailchimp[botton_text]" value="<?php if(isset($edn_bar_setting['edn_mailchimp']['botton_text']) && $edn_bar_setting['edn_mailchimp']['botton_text'] != ''){ echo esc_attr($edn_bar_setting['edn_mailchimp']['botton_text']); } ?>" placeholder="<?php _e('E.g: Subscribe',APEXNB_TD);?>"/> 
                                </div>
                            </div>
                        </div>
                    </div>
                       <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                                <div class="edn-field"> <div class="edn-field-label-wrap">
                                  <label><?php _e('MailChimp Email Placeholder',APEXNB_TD);?></label>
                                  </div>
                             <div class="edn-field-input-wrap">
                              <input type="text"  name="edn_mailchimp[email_label]" 
                              value="<?php if(isset($edn_bar_setting['edn_mailchimp']['email_label']) && $edn_bar_setting['edn_mailchimp']['email_label'] != ''){
                               echo esc_attr($edn_bar_setting['edn_mailchimp']['email_label']);
                               } ?>" 
                                 placeholder="<?php _e('e.g.,Enter Email here.',APEXNB_TD);?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                                <div class="edn-field"> <div class="edn-field-label-wrap">
                                  <label><?php _e('Email Error Message',APEXNB_TD);?></label>
                                  </div>
                             <div class="edn-field-input-wrap">
                             <input type="text" name="edn_mailchimp[mailchimp_email_err]" placeholder="<?php _e('e.g.,Please enter valid email address.',APEXNB_TD);?>" 
                             value="<?php if(isset($edn_bar_setting['edn_mailchimp']['mailchimp_email_err'])) echo esc_attr($edn_bar_setting['edn_mailchimp']['mailchimp_email_err'])?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                                <div class="edn-field"> <div class="edn-field-label-wrap">
                                  <label><?php _e('Mail Confirmation Success Message',APEXNB_TD);?></label>
                                  </div>
                             <div class="edn-field-input-wrap">
                              <input type="text" name="edn_mailchimp[mailchimp_check_to_conform]" placeholder="<?php _e('e.g.,Please check your mail to confirm.',APEXNB_TD);?>" 
                              value="<?php if(isset($edn_bar_setting['edn_mailchimp']['mailchimp_check_to_conform'])) echo esc_attr($edn_bar_setting['edn_mailchimp']['mailchimp_check_to_conform'])?>"  />
            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                                <div class="edn-field"> <div class="edn-field-label-wrap">
                                  <label><?php _e('Sending Fail Error Message',APEXNB_TD);?></label>
                                  </div>
                             <div class="edn-field-input-wrap">
                              <input type="text" name="edn_mailchimp[mailchimp_sending_fail]" placeholder="<?php _e('e.g.,Confirmation sending fail.',APEXNB_TD);?>" 
                              value="<?php if(isset($edn_bar_setting['edn_mailchimp']['mailchimp_sending_fail'])) echo esc_attr($edn_bar_setting['edn_mailchimp']['mailchimp_sending_fail'])?>" />
                                </div>
                            </div>
                        </div>
                    </div>

                  <div class="clear"></div>
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                            <div class="edn-field">
                           <div class="edn-field-label-wrap"><label><?php _e('Thank You Note',APEXNB_TD);?></label></div>
                           
                             <div class="edn-field-input-wrap">
                                <textarea name="edn_mailchimp[thank_text]" placeholder="<?php _e('e.g.,Thank you for subscribing.',APEXNB_TD);?>"><?php if(isset($edn_bar_setting['edn_mailchimp']['thank_text']) && $edn_bar_setting['edn_mailchimp']['thank_text'] != ''){ echo $edn_bar_setting['edn_mailchimp']['thank_text']; } ?></textarea>
                                
                            </div>
                            </div>
                        </div>
                    </div>                        
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                            <div class="edn-field">
                                 <div class="edn-field-label-wrap">
                                    <label class="edn-label-inline" for="mailchimp_confirm">
                                    <?php _e('Enable Check Confirmation', APEXNB_TD); ?></label>
                                      <p class="edn-note"><?php _e('Check if you want users to send confirmation email.',APEXNB_TD);?></p>
                                </div>
                                 <div class="edn-field-input-wrap">
                                        <div class="apexnb-switch">
                                              <input type="checkbox" class="edn_subs_confirm" id="mailchimp_confirm" name="edn_mailchimp[confirm]" value="1" <?php if(isset($edn_bar_setting['edn_mailchimp']['confirm']) && $edn_bar_setting['edn_mailchimp']['confirm']){echo 'checked="checked"';}?> />
                                               <label for="mailchimp_confirm"></label>
                                            
                                        </div>
                                  </div>
                            </div>
                         <div class="edn-subs-mailchimp-confirm" id="edn-subs-mailchimp-confirm" style="display: none;"> 
                                <div class="edn-field">
                                <div class="edn-field-label-wrap">
                                    <label class="edn-label-inline">
                                        <?php _e('From Name', APEXNB_TD); ?>  </label>
                                          <p class="edn-note"><?php _e('Fill the site name you want to display in confirmation email.If left empty, default value will be set as your site name.',APEXNB_TD);?></p>
                                  </div>
                                  <div class="edn-field-input-wrap">
                                        <input type="text" class="edn_mailchimp_field" name="edn_mailchimp[from_name]" value="<?php if(isset($edn_bar_setting['edn_mailchimp']['from_name'])) echo $edn_bar_setting['edn_mailchimp']['from_name'];?>" placeholder="<?php echo get_bloginfo( 'name' ); ?>"/>
                                      </div>
                                </div>
                
                                <div class="edn-field">
                                    <div class="edn-field-label-wrap"> <label class="edn-label-inline">
                                        <?php _e('From Email', APEXNB_TD); ?> </label>
                                          <p class="edn-note"><?php _e('Fill email you want to display in confirmation email.If left empty, default value will be set as noreply@siteurl.com',APEXNB_TD);?></p>
                                   
                                  </div>
                                   <div class="edn-field-input-wrap">
                                        <input type="text" class="edn_mailchimp_field" name="edn_mailchimp[from_email]" value="<?php if(isset($edn_bar_setting['edn_mailchimp']['from_email'])) echo $edn_bar_setting['edn_mailchimp']['from_email'];?>" placeholder="noreply@siteurl.com"/>
                                      </div>
                               </div>
                          </div>
                        </div>
                    </div>
                </div>