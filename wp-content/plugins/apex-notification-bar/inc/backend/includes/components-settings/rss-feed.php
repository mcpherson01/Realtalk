               <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                         
                                <div class="edn-field">
                                      <div class="edn-field-label-wrap">  
                                        <label for="rss_enable"><?php _e('Enable RSS',APEXNB_TD);?></label>
                                        <p class="edn-note"><?php _e('Do you want to enable the RSS.',APEXNB_TD)?></p>
                                      </div>
                                   <div class="edn-field-input-wrap"> 
                                        <div class="apexnb-switch">
                                       <input type="checkbox"  id="rss_enable" name="edn_rssfeed[enable]" value="1" <?php if(isset($edn_bar_setting['edn_rssfeed']['enable']) && $edn_bar_setting['edn_rssfeed']['enable'] == 1) echo 'checked="checked"'; ?>/>
                                       <label for="rss_enable"></label>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                            <div class="edn-field">
                               <div class="edn-field-label-wrap">   <label><?php _e('RSS URL',APEXNB_TD);?></label>
                                  <p class="edn-note"><?php _e('The URL to the RSS feed you want to load.',APEXNB_TD)?></p>
                                  </div>
                                <div class="edn-field-input-wrap"> 
                                    <input type="text" name="edn_rssfeed[rss_url]" placeholder="<?php _e('E.g: https://...',APEXNB_TD)?>" value="<?php if(isset($edn_bar_setting['edn_rssfeed']['rss_url'])){echo esc_attr($edn_bar_setting['edn_rssfeed']['rss_url']);}?>" />
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                                 <div class="edn-field">
                               <div class="edn-field-label-wrap"> <label><?php _e('Link Text',APEXNB_TD);?></label>
                                 <p class="edn-note"><?php _e('The text displayed as link after the article.',APEXNB_TD)?></p>
                               </div>
                                <div class="edn-field-input-wrap"> 
                                    <input type="text" name="edn_rssfeed[link_text]" placeholder="<?php _e('Read More',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_rssfeed']['link_text'])){echo esc_attr($edn_bar_setting['edn_rssfeed']['link_text']);}?>" />
                                  
                                </div>
                                     </div>
                            </div>
                        </div>
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                            <div class="edn-field">
                                <div class="edn-field-label-wrap"> <label><?php _e('Link Target',APEXNB_TD);?></label>
                                 <p class="edn-note"><?php _e('The target for the rss links (e.g. _blank)',APEXNB_TD)?></p>
                                 </div>
                                <div class="edn-field-input-wrap"> 
                                    <select id="edn-link-target2" class="apexnb-selection" name="edn_rssfeed[link_target]">
                                     <option value="_blank"><?php _e('_blank',APEXNB_TD);?></option>
                                     <option value="_self"><?php _e('_self',APEXNB_TD);?></option>
                                     <option value="_parent"><?php _e('_parent',APEXNB_TD);?></option>
                                     <option value="_top"><?php _e('_top',APEXNB_TD);?></option>
                                    </select>
                                   </div>
                                </div>
                            </div>
                        </div>
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                            <div class="edn-field">
                                 <div class="edn-field-label-wrap">  <label><?php _e('Total Number of Feed',APEXNB_TD);?></label>
                                   <p class="edn-note"><?php _e("Please enter the number of feeds to be fetched.Default number of feeds is 5.",APEXNB_TD)?></p>
                                  </div>
                                 <div class="edn-field-input-wrap"> 
                                    <input type="text" name="edn_rssfeed[total_feed]" value="<?php if(isset($edn_bar_setting['edn_rssfeed']['total_feed'])){echo esc_attr($edn_bar_setting['edn_rssfeed']['total_feed']);}?>" />
                                  </div>
                                </div>
                            </div>
                        </div>