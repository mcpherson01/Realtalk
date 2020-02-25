 <div class="edn-row">
<div class="edn-col-full">
<div class="edn-field-wrapper edn-form-field">
<?php if(!isset($constant_lists['xml'])){
  if(is_array($constant_lists) && !empty($constant_lists)){?>
   <label><?php _e( 'Lists this form subscribes to', APEXNB_TD ); ?></label>
   <?php } } ?>
  <div class="list_constant <?php if(!isset($constant_lists['xml'])) echo 'mailchimp-lista-wrapper multiselect'; else echo 'apexnb-notifybar'; ?>">
   <?php #echo "<pre>"; print_r($constant_lists);
        # print_r($edn_bar_setting['edn_constant_contact']['lists']);
    if(isset($constant_lists['xml'])){ ?>
    <p class="edn-note">
   <?php _e('Note: Please fill up your account form with api key and access token correctly from here to get your lists',APEXNB_TD);?>
     <a href="<?php echo admin_url('admin.php?page=apexnb-constant_contact');?>">
     <?php _e('Account Form here',APEXNB_TD);?></a></p>     
         <?php  }else{
    if(is_array($constant_lists) && !empty($constant_lists)){
    foreach ($constant_lists as $lists) {
        if(!empty($lists)){
            foreach ($lists as $li) {
            $listid = $li->id;
            $listss = explode('lists/', $listid);
            $uniquelist_ID = $listss[1];

    if(isset($edn_bar_setting['edn_constant_contact']['lists'])){
      $group_constant_lists = $edn_bar_setting['edn_constant_contact']['lists'];
          if(in_array($uniquelist_ID  ,$group_constant_lists)){
              $checked  = "checked='checked'";          
                }else{
                    $checked  = '';
                }
            }else{
                $checked  = '';
            }?>

            <label for="cc-<?php echo esc_attr($uniquelist_ID); ?>"><input type="checkbox" id="cc-<?php echo esc_attr($uniquelist_ID); ?>" name="edn_constant[lists][<?php echo esc_attr($uniquelist_ID); ?>]"
                   value="<?php echo $uniquelist_ID;?>" <?php echo $checked;?>/><?php echo esc_html( $li->name ); ?></label>
          <?php  
           }
        }
    }
    }else{ ?>
   <p class="edn-note">
   <?php _e('No lists yet.Please fill up your account form from here.',APEXNB_TD);?>
     <a href="<?php echo admin_url('admin.php?page=apexnb-constant_contact');?>">
     <?php _e('Account Form here',APEXNB_TD);?></a></p>         
 <?php  }  } ?>
</div>
</div>
</div>
<div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
         <div class="edn-field">
             <div class="edn-field-label-wrap"> <label><?php _e('Form Title Text',APEXNB_TD);?></label></div>
           <div class="edn-field-input-wrap">
                <input type="text" name="edn_constant[title_text]"  placeholder="<?php _e('E.g:Join Our Mailing List',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_constant_contact']['title_text'])) echo $edn_bar_setting['edn_constant_contact']['title_text']; ?>" />
            </div>
            </div>
        </div>
    </div>
    <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
        <div class="edn-field">
           <div class="edn-field-label-wrap"> <label><?php _e('Constant Contact Description', APEXNB_TD); ?></label></div>
              <div class="edn-field-input-wrap">
               <textarea type="text"  name="edn_constant[description_label]" placeholder="<?php _e('E.g:Get Latest Deal, Offers & Product Updates via Email',APEXNB_TD);?>"><?php if(isset($edn_bar_setting['edn_constant_contact']['description_label'])) echo $edn_bar_setting['edn_constant_contact']['description_label']?></textarea>
            </div>
            </div>
        </div>
    </div>
   

     <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
         <div class="edn-field">
             <div class="edn-field-label-wrap"><label><?php _e('Constant Contact Button text', APEXNB_TD); ?></label></div>
           
             <div class="edn-field-input-wrap">
                <input type="text" name="edn_constant[button_text]" placeholder="<?php _e('E.g: Subscribe',APEXNB_TD);?>"
                value="<?php if(isset($edn_bar_setting['edn_constant_contact']['button_text'])) echo $edn_bar_setting['edn_constant_contact']['button_text']?>"/> 
            </div>
            </div>
        </div>
    </div>

     <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
         <div class="edn-field">
             <div class="edn-field-label-wrap">
               <label><?php _e('Name Field Placeholder',APEXNB_TD);?></label>
               </div>
           
             <div class="edn-field-input-wrap">
                 <input type="text" name="edn_constant[name_placeholder]" placeholder="<?php _e('E.g: Your Name',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_constant_contact']['name_placeholder'])) echo $edn_bar_setting['edn_constant_contact']['name_placeholder']?>"/>
            </div>
            </div>
        </div>
    </div>
     <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
         <div class="edn-field">
             <div class="edn-field-label-wrap">
               <label><?php _e('Email Field Placeholder',APEXNB_TD);?></label>
               </div>
           
             <div class="edn-field-input-wrap">
                   <input type="text" name="edn_constant[email_placeholder]" placeholder="<?php _e('E.g: Your Email',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_constant_contact']['email_placeholder'])) echo $edn_bar_setting['edn_constant_contact']['email_placeholder']?>"/>
            </div>
            </div>
        </div>
    </div>
    <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
         <div class="edn-field">
             <div class="edn-field-label-wrap">
               <label><?php _e('Sending Fail Error Message',APEXNB_TD);?></label>
               </div>
           
             <div class="edn-field-input-wrap">
                  <input type="text" name="edn_constant[constant_sending_fail]" placeholder="<?php _e('e.g.,Sending fail.',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_constant_contact']['constant_sending_fail'])) echo $edn_bar_setting['edn_constant_contact']['constant_sending_fail']?>"/>
            </div>
            </div>
        </div>
    </div>

     <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
         <div class="edn-field">
             <div class="edn-field-label-wrap">
               <label><?php _e('Name Error Message',APEXNB_TD);?></label>
               <p class="edn-note"><?php _e('e.g.,Name field is empty.',APEXNB_TD);?></p>
               </div>
           
             <div class="edn-field-input-wrap">
                  <input type="text" name="edn_constant[constant_name_error]" placeholder="<?php _e('e.g.,Name field is empty.',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_constant_contact']['constant_name_error'])) echo esc_attr($edn_bar_setting['edn_constant_contact']['constant_name_error'])?>"  />
            </div>
            </div>
        </div>
    </div>
      <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
         <div class="edn-field">
             <div class="edn-field-label-wrap">
                <label><?php _e('Email Error Message',APEXNB_TD);?></label>
               </div>
           
             <div class="edn-field-input-wrap">
                 <input type="text" name="edn_constant[constant_email_error]" placeholder="<?php _e('e.g.,Please enter valid email address.',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_constant_contact']['constant_email_error'])) echo esc_attr($edn_bar_setting['edn_constant_contact']['constant_email_error'])?>" />
            </div>
            </div>
        </div>
    </div>
      <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
         <div class="edn-field">
             <div class="edn-field-label-wrap">
                <label><?php _e('Success Message/URL:',APEXNB_TD);?></label>
               </div>
           
             <div class="edn-field-input-wrap">
                <textarea type="text" name="edn_constant[success_text]" placeholder="<?php _e('e.g.,Thank you for subscribing.',APEXNB_TD);?>"><?php if(isset($edn_bar_setting['edn_constant_contact']['success_text'])) echo $edn_bar_setting['edn_constant_contact']['success_text']?></textarea>
            </div>
            </div>
        </div>
    </div>

                   
    <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field">
                <div class="edn-field-label-wrap">
                  <label class="edn-label-inline" for="cc_confirm">
                    <?php _e('Enable Check Confirmation', APEXNB_TD); ?></label>
                     <p class="edn-note"><?php _e('Check if you want users to confirm their address before subscription.',APEXNB_TD);?></p>
                </div>
                 <div class="edn-field-input-wrap">
                   <div class="apexnb-switch">
                    <input type="checkbox" class="edn_subs_confirm" id="cc_confirm" name="edn_constant[confirm]" value="1" <?php if(isset($edn_bar_setting['edn_constant_contact']['confirm']) && $edn_bar_setting['edn_constant_contact']['confirm']){echo 'checked="checked"';}?>/>
                     <label for="cc_confirm"></label>
                   </div>
                </div>
            </div>
             <div class="edn-subs-cc-confirm" id="edn-subs-cc-confirm" style="display: none;"> 
                <div class="edn-field">
                    <div class="edn-field-label-wrap">
                       <label class="edn-label-inline">
                        <?php _e('From Name', APEXNB_TD); ?> 
                    </label>
                     <p class="edn-note"><?php _e('Fill the site name you want to display in confirmation email.If left empty, default value will be set as your site name.',APEXNB_TD);?></p>
                     </div>
                     <div class="edn-field-input-wrap">
                        <input type="text" class="edn_constant_name" name="edn_constant[from_name]" value="<?php if(isset($edn_bar_setting['edn_constant_contact']['from_name'])) echo $edn_bar_setting['edn_constant_contact']['from_name'];?>" placeholder="<?php echo get_bloginfo( 'name' ); ?>"/>
                    </div>
                </div>

                <div class="edn-field">
                 <div class="edn-field-label-wrap">
                    <label class="edn-label-inline">
                        <?php _e('From Email', APEXNB_TD); ?>
                    </label>
                        <p class="edn-note"><?php _e('Fill email you want to display in confirmation email.If left empty, default value will be set as noreply@siteurl.com',APEXNB_TD);?></p>
                       </div>
                        <div class="edn-field-input-wrap">
                        <input type="text" class="edn_constant_email" name="edn_constant[from_email]" value="<?php if(isset($edn_bar_setting['edn_constant_contact']['from_email'])) echo $edn_bar_setting['edn_constant_contact']['from_email'];?>" placeholder="noreply@siteurl.com"/>
                      </div>
                 </div>
             </div>
        </div>
    </div>
</div>