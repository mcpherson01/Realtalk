 <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field">
                <div class="edn-field-label-wrap"><label><?php _e('Twitter Consumer Key',APEXNB_TD);?></label>
                   <p class="edn-note"><?php _e('Please create an app on Twitter through this link: <a href="https://dev.twitter.com/apps">https://dev.twitter.com/apps</a> and get this information.',APEXNB_TD)?></p>
                   </div>
                  <div class="edn-field-input-wrap">
                       <input type="text" name="edn_twitter[consumer_key]" value="<?php if(isset($edn_bar_setting['edn_twitter']['consumer_key'])){echo esc_attr($edn_bar_setting['edn_twitter']['consumer_key']);}?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field">
                <div class="edn-field-label-wrap">  <label><?php _e('Twitter Consumer Secret',APEXNB_TD);?></label>
               <p class="edn-note"><?php _e('Please create an app on Twitter through this link: <a href="https://dev.twitter.com/apps">https://dev.twitter.com/apps</a> and get this information.',APEXNB_TD)?></p>
                </div>
                <div class="edn-field-input-wrap">
                    <input type="text" name="edn_twitter[consumer_secret_key]" value="<?php if(isset($edn_bar_setting['edn_twitter']['consumer_secret_key'])){echo esc_attr($edn_bar_setting['edn_twitter']['consumer_secret_key']);}?>" />
                </div></div>
            </div>
        </div>
        <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field">
              <div class="edn-field-label-wrap">  <label><?php _e('Twitter Access Token',APEXNB_TD);?></label>
                <p class="edn-note"><?php _e('Please create an app on Twitter through this link: <a href="https://dev.twitter.com/apps">https://dev.twitter.com/apps</a> and get this information.',APEXNB_TD)?></p></div>
                <div class="edn-field-input-wrap">
                    <input type="text" name="edn_twitter[access_token_key]" value="<?php if(isset($edn_bar_setting['edn_twitter']['access_token_key'])){echo esc_attr($edn_bar_setting['edn_twitter']['access_token_key']);}?>" />  
                </div></div>
            </div>
        </div>
        <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field">
                <div class="edn-field-label-wrap"> <label><?php _e('Twitter Access Token Secret',APEXNB_TD);?></label>
                    <p class="edn-note"><?php _e('Please create an app on Twitter through this link: <a href="https://dev.twitter.com/apps">https://dev.twitter.com/apps</a> and get this information.',APEXNB_TD)?></p>
              </div>
               <div class="edn-field-input-wrap"> 
                    <input type="text" name="edn_twitter[access_token_secret_key]" value="<?php if(isset($edn_bar_setting['edn_twitter']['access_token_secret_key'])){echo esc_attr($edn_bar_setting['edn_twitter']['access_token_secret_key']);}?>" />
                </div></div>
            </div>
        </div>
        <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
              <div class="edn-field">
                <div class="edn-field-label-wrap"> <label><?php _e('Twitter Username',APEXNB_TD);?></label>
                    <p class="edn-note"><?php _e('Please enter the username of twitter account from which the feeds need to be fetched.For example:@accesspressthemes',APEXNB_TD)?></p>
             </div>
                 <div class="edn-field-input-wrap"> 
                    <input type="text" placeholder="<?php _e('e.g: @accesspressthemes',APEXNB_TD);?>" name="edn_twitter[username]" value="<?php if(isset($edn_bar_setting['edn_twitter']['username'])){echo esc_attr($edn_bar_setting['edn_twitter']['username']);}?>" />
                </div>
                </div>
            </div>
        </div>
        <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field">
                <div class="edn-field-label-wrap">  <label><?php _e('Cache Period',APEXNB_TD);?></label>
                  <p class="edn-note"><?php _e('Please enter the time period in minutes in which the feeds should be fetched.Default is 60 Minutes',APEXNB_TD)?></p></div>
               <div class="edn-field-input-wrap"> 
                    <input type="text" placeholder="<?php _e('e.g: 60',APEXNB_TD);?>" name="edn_twitter[cache_period]" value="<?php if(isset($edn_bar_setting['edn_twitter']['cache_period'])){echo esc_attr($edn_bar_setting['edn_twitter']['cache_period']);}?>" />
                </div>
                </div>
            </div>
        </div>
        <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
             <div class="edn-field">
               <div class="edn-field-label-wrap">   
                  <label><?php _e('Total Number of Feed',APEXNB_TD);?></label>
                   <p class="edn-note"><?php _e("Please enter the number of feeds to be fetched.Default number of feeds is 5.",APEXNB_TD)?></p></div>
                   <div class="edn-field-input-wrap">  
                        <input type="text" name="edn_twitter[total_feed]" value="<?php if(isset($edn_bar_setting['edn_twitter']['total_feed'])){echo esc_attr($edn_bar_setting['edn_twitter']['total_feed']);}?>" />               
                    </div>
                </div>
            </div>
        </div>