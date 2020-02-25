                     <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                         
                                <div class="edn-field">
                                    <div class="edn-field-label-wrap">    
                                       <label for="edn_countdowntimer_enable"><?php _e('Enable CountDown Timer',APEXNB_TD);?>
                                        </label> 
                                   <p class="edn-note"><?php _e('Do you want to enable the countdown timer.',APEXNB_TD)?></p>
                                   </div>
                                    <div class="edn-field-input-wrap"> 
                                      <div class="apexnb-switch">
                                       <input type="checkbox" id="edn_countdowntimer_enable" name="edn_countdowntimer[enable]" value="1" <?php if(isset($edn_bar_setting['edn_countdowntimer']['enable']) && $edn_bar_setting['edn_countdowntimer']['enable'] == 1) echo 'checked="checked"'; ?>/>
                                       <label for="edn_countdowntimer_enable"></label>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                             <div class="edn-field">
                               <div class="edn-field-label-wrap">     
                                  <label><?php _e('Text Description',APEXNB_TD);?></label>
                                </div>
                               <div class="edn-field-input-wrap"> 
                                    <textarea name="edn_countdowntimer[text_description]"><?php if(isset($edn_bar_setting['edn_countdowntimer']['text_description'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['text_description']);}?></textarea>
                               </div>
                                </div>
                            </div>
                        </div>

                        <div class="edn-col-full edn-font-wrap">
                         <div class="edn-custom-countdown-color">
                            <div class="edn-field-wrapper edn-form-field">
                               <div class="edn-field">
                                 <div class="edn-field-label-wrap">     
                                 <label><?php _e('Text Font Color',APEXNB_TD)?></label>
                                      <p class="edn-note"><?php _e('Set text description font color.',APEXNB_TD);?></p>
                                 </div>
                             
                                 <div class="edn-field-input-wrap"> 
                                    <input type="text" class="edn-color-picker" name="edn_countdowntimer[textcolor]"
                                     value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['textcolor'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['textcolor']);}?>" />
                                 </div>
                                </div>
                            </div><!--edn-field-wrapper-->
                        </div>
                         </div>
                          <div class="edn-col-full edn-font-wrap">
                         <div class="edn-custom-countdown-color">
                            <div class="edn-field-wrapper edn-form-field">
                              <div class="edn-field">
                                <div class="edn-field-label-wrap">     
                                <label><?php _e('Text Font Size',APEXNB_TD)?></label>
                                 <p class="edn-note"><?php _e('Set text description font size in px.',APEXNB_TD);?></p>
                                </div>
                               <div class="edn-field-input-wrap"> 
                                    <input type="number" name="edn_countdowntimer[textsize]"
                                     value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['textsize'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['textsize']);}?>" />
                               
                                </div>
                                </div>
                            </div><!--edn-field-wrapper-->
                        </div>
                         </div>

                       <div class="edn-col-full edn-font-wrap">
                         <div class="edn-custom-countdown-color">
                            <div class="edn-field-wrapper edn-form-field">
                                 <div class="edn-field">
                                  <div class="edn-field-label-wrap"> 
                                  <label><?php _e('Timer Background Color',APEXNB_TD)?></label>
                                  </div>

                                  <div class="edn-field-input-wrap"> 
                                    <input type="text" id="edn-bg-countdown-color" class="edn-color-picker" name="edn_countdowntimer[bgcolor]" value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['bgcolor'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['bgcolor']);}?>" />
                                  </div>
                                </div>
                            </div><!--edn-field-wrapper-->
                        </div>
                      </div>

                       <div class="edn-col-full edn-font-wrap">
                         <div class="edn-custom-countdown-color">
                            <div class="edn-field-wrapper edn-form-field">
                                 <div class="edn-field">
                                  <div class="edn-field-label-wrap"> 
                                  <label><?php _e('Timer Background Outer Color',APEXNB_TD)?></label>
                                  </div>
                                  <div class="edn-field-input-wrap"> 
                                    <input type="text" id="edn-bg-countdown-outercolor" class="edn-color-picker" data-alpha="true" name="edn_countdowntimer[bgoutercolor]" value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['bgoutercolor'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['bgoutercolor']);}?>" />
                                  </div>
                                </div>
                            </div>
                        </div>
                      </div>

                       <div class="edn-col-full edn-font-wrap">
                          <div class="edn-custom-countdown-color">
                            <div class="edn-field-wrapper edn-form-field">
                                
                                  <div class="edn-field">
                                   <div class="edn-field-label-wrap"> <label><?php _e('Timer Font Color',APEXNB_TD)?></label>
                                   </div>
                                      <div class="edn-field-input-wrap"> 
                                    <input type="text" id="edn-font-countdown-color" class="edn-color-picker" 
                                    name="edn_countdowntimer[fontcolor]" value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['fontcolor'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['fontcolor']);}?>" />
                                   </div>
                                </div>
                            </div><!--edn-field-wrapper-->
                        </div></div>
                         <div class="clear"></div>
                           <div class="edn-col-full edn-font-wrap">
                                 <div class="edn-custom-countdown-color">
                                    <div class="edn-field-wrapper edn-form-field">
                                        <div class="edn-field">
                                       <div class="edn-field-label-wrap">
                                        <label><?php _e('Call To Action Button Background Color',APEXNB_TD)?></label>
                                        </div>
                                         <div class="edn-field-input-wrap"> 
                                            <input type="text" name="edn_countdowntimer[buttonbgcolor]" class="edn-color-picker"
                                             value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['buttonbgcolor'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['buttonbgcolor']);}?>" />
                                          </div> 
                                        </div>
                                    </div><!--edn-field-wrapper-->
                                </div>
                              </div>
                                 <div class="edn-col-full edn-font-wrap">
                                 <div class="edn-custom-countdown-color">
                                    <div class="edn-field-wrapper edn-form-field">
                                      <div class="edn-field">
                                        <div class="edn-field-label-wrap">
                                          <label><?php _e('Call To Action Button Font Color',APEXNB_TD)?></label>
                                        </div>
                                          <div class="edn-field-input-wrap"> 
                                            <input type="text" name="edn_countdowntimer[buttonfontcolor]" class="edn-color-picker"
                                             value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['buttonfontcolor'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['buttonfontcolor']);}?>" />
                                          </div>
                                        </div>
                                    </div><!--edn-field-wrapper-->
                                </div>
                                 </div>
                                    <div class="edn-col-full edn-font-wrap">
                                 <div class="edn-custom-countdown-color">
                                    <div class="edn-field-wrapper edn-form-field">
                                        <div class="edn-field">
                                       <div class="edn-field-label-wrap">
                                        <label><?php _e('Call To Action Button Hover Background Color',APEXNB_TD)?></label>
                                        </div>
                                         <div class="edn-field-input-wrap"> 
                                            <input type="text" name="edn_countdowntimer[buttonhoverbgcolor]" class="edn-color-picker"
                                             value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['buttonhoverbgcolor'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['buttonhoverbgcolor']);}?>" />
                                          </div> 
                                        </div>
                                    </div><!--edn-field-wrapper-->
                                </div>
                              </div>
                                 <div class="edn-col-full edn-font-wrap">
                                 <div class="edn-custom-countdown-color">
                                    <div class="edn-field-wrapper edn-form-field">
                                        <div class="edn-field">
                                       <div class="edn-field-label-wrap">
                                        <label><?php _e('Call To Action Button Hover font Color',APEXNB_TD)?></label>
                                        </div>
                                         <div class="edn-field-input-wrap"> 
                                            <input type="text" name="edn_countdowntimer[buttonhoverfcolor]" class="edn-color-picker"
                                             value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['buttonhoverfcolor'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['buttonhoverfcolor']);}?>" />
                                          </div> 
                                        </div>
                                    </div><!--edn-field-wrapper-->
                                </div>
                              </div>
                      <div class="clear"></div>
          <?php 
       $enable_repeat = (isset($edn_bar_setting['edn_countdowntimer']['enable_repeat']) && $edn_bar_setting['edn_countdowntimer']['enable_repeat'] == 1)?1:0;
          ?>
                       <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                         
                                <div class="edn-field">
                                    <div class="edn-field-label-wrap">    
                                       <label for="edn_countdowntimer_enable_repeat"><?php _e('Repeat Countdown?',APEXNB_TD);?>
                                        </label> 
                                   <p class="edn-note"><?php _e('Enable to repeat this countdown timer again automatically.',APEXNB_TD)?></p>
                                   </div>
                                    <div class="edn-field-input-wrap"> 
                                      <div class="apexnb-switch">
                                       <input type="checkbox" id="edn_countdowntimer_enable_repeat" name="edn_countdowntimer[enable_repeat]" value="1" <?php if($enable_repeat == 1) echo 'checked="checked"'; ?>/>
                                       <label for="edn_countdowntimer_enable_repeat"></label>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="edn-show-one" <?php if($enable_repeat == 1) echo ''; else echo 'style="display:none;"';?>>
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                         
                                <div class="edn-field">
                                        <div class="edn-field-label-wrap"> 
                                          <label><?php _e('Countdown Timer Layout',APEXNB_TD);?>
                                          </label>
                                        <p class="edn-note"><?php _e('Choose countdown timer layout.',APEXNB_TD)?></p>
                                       </div>
                                        <div class="edn-field-input-wrap">
                                        <select name="edn_countdowntimer[layout_type2]" class="apex_countlayout2 apexnb-selection">
                                         <option value="layout2" <?php if(isset($edn_bar_setting['edn_countdowntimer']['layout_type2']) && $edn_bar_setting['edn_countdowntimer']['layout_type2'] == "layout2") echo "selected='selected'";?>><?php _e('Layout 1',APEXNB_TD);?></option>
                                         <option value="layout3" <?php if(isset($edn_bar_setting['edn_countdowntimer']['layout_type2']) && $edn_bar_setting['edn_countdowntimer']['layout_type2'] == "layout3") echo "selected='selected'";?>><?php _e('Layout 2',APEXNB_TD);?></option>
                                         <option value="layout4" <?php if(isset($edn_bar_setting['edn_countdowntimer']['layout_type2']) && $edn_bar_setting['edn_countdowntimer']['layout_type2'] == "layout4") echo "selected='selected'";?>><?php _e('Layout 3',APEXNB_TD);?></option>
                                         <option value="layout5" <?php if(isset($edn_bar_setting['edn_countdowntimer']['layout_type2']) && $edn_bar_setting['edn_countdowntimer']['layout_type2'] == "layout5") echo "selected='selected'";?>><?php _e('Layout 4',APEXNB_TD);?></option>
                                         <option value="layout6" <?php if(isset($edn_bar_setting['edn_countdowntimer']['layout_type2']) && $edn_bar_setting['edn_countdowntimer']['layout_type2'] == "layout6") echo "selected='selected'";?>><?php _e('Layout 5',APEXNB_TD);?></option>
                                       </select>
                                  
                                     </div>
                                </div>
                            </div>
                        </div>
                         <div class="preview-counter2 apexbar-bpreview">
                         <div id="counter2_layout2" class="preview_image2">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/counter/counter-layout2.JPG"/>
                         </div>
                         <div id="counter2_layout3" class="preview_image2">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/counter/counter-layout3.JPG"/>
                         </div>
                         <div id="counter2_layout4" class="preview_image2">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/counter/counter-layout4.JPG"/>
                         </div>
                         <div id="counter2_layout5" class="preview_image2">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/counter/counter-layout5.JPG"/>
                         </div>
                          <div id="counter2_layout6" class="preview_image2">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/counter/counter-layout6.JPG"/>
                         </div>
                        </div>
                     </div>

                      <div class="edn-show-two" <?php if($enable_repeat == 1) echo 'style="display:none;"'; else echo '';?>>
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                         
                                <div class="edn-field">
                                        <div class="edn-field-label-wrap"> 
                                          <label><?php _e('Countdown Timer Layout',APEXNB_TD);?>
                                          </label>
                                        <p class="edn-note"><?php _e('Choose countdown timer layout.',APEXNB_TD)?></p>
                                       </div>
                                        <div class="edn-field-input-wrap">
                                        <select name="edn_countdowntimer[layout_type]" class="apex_countlayout apexnb-selection">
                                         <option value="layout1" <?php if(isset($edn_bar_setting['edn_countdowntimer']['layout_type']) && $edn_bar_setting['edn_countdowntimer']['layout_type'] == "layout1") echo "selected='selected'";?>><?php _e('Layout1',APEXNB_TD);?></option>
                                         <option value="layout2" <?php if(isset($edn_bar_setting['edn_countdowntimer']['layout_type']) && $edn_bar_setting['edn_countdowntimer']['layout_type'] == "layout2") echo "selected='selected'";?>><?php _e('Layout2',APEXNB_TD);?></option>
                                         <option value="layout3" <?php if(isset($edn_bar_setting['edn_countdowntimer']['layout_type']) && $edn_bar_setting['edn_countdowntimer']['layout_type'] == "layout3") echo "selected='selected'";?>><?php _e('Layout3',APEXNB_TD);?></option>
                                         <option value="layout4" <?php if(isset($edn_bar_setting['edn_countdowntimer']['layout_type']) && $edn_bar_setting['edn_countdowntimer']['layout_type'] == "layout4") echo "selected='selected'";?>><?php _e('Layout4',APEXNB_TD);?></option>
                                         <option value="layout5" <?php if(isset($edn_bar_setting['edn_countdowntimer']['layout_type']) && $edn_bar_setting['edn_countdowntimer']['layout_type'] == "layout5") echo "selected='selected'";?>><?php _e('Layout5',APEXNB_TD);?></option>
                                         <option value="layout6" <?php if(isset($edn_bar_setting['edn_countdowntimer']['layout_type']) && $edn_bar_setting['edn_countdowntimer']['layout_type'] == "layout6") echo "selected='selected'";?>><?php _e('Layout6',APEXNB_TD);?></option>
                                       </select>
                                  
                                     </div>
                                </div>
                            </div>
                        </div>
                         <div class="preview-counter apexbar-bpreview">
                         <div id="counter_layout1" class="preview_image">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/counter/counter-layout1.JPG"/>
                         </div>
                         <div id="counter_layout2" class="preview_image">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/counter/counter-layout2.JPG"/>
                         </div>
                         <div id="counter_layout3" class="preview_image">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/counter/counter-layout3.JPG"/>
                         </div>
                         <div id="counter_layout4" class="preview_image">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/counter/counter-layout4.JPG"/>
                         </div>
                         <div id="counter_layout5" class="preview_image">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/counter/counter-layout5.JPG"/>
                         </div>
                          <div id="counter_layout6" class="preview_image">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/counter/counter-layout6.JPG"/>
                         </div>
                        </div>
                     </div>
                        
                   <div class="edn-field-wrapper edn-form-field">
                          

                      <div class="mywrapper">
                        <div class="edn-field apexnb-relative">
                           <div class="edn-field-label-wrap"> 
                             <label><?php _e('Countdown Date',APEXNB_TD);?></label>
                            <p class="edn-note"><?php _e('Choose expiry date.',APEXNB_TD)?></p>
                            </div>
                          
                            <div class="edn-field-input-wrap">
                              <input type="text" class="edn-countdowntimer-datepicker" name="edn_countdowntimer[expirydate]"  value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['expirydate'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['expirydate']);}?>" />
                             <span class="dashicons dashicons-calendar-alt apexnb-calendar-icon"></span>
                            </div>
                          </div>
                     </div>
                       
                      <div class="mywrapper edn-field">    
                           <div class="edn-field-label-wrap">  
                                <label><?php _e('Countdown Animation',APEXNB_TD);?></label>
                                   <p class="edn-note"><?php _e('Choose countdown animation.',APEXNB_TD);?></p>
                            </div>
                                <div class="edn-field-input-wrap apexnb-relative">
                                   <select name="edn_countdowntimer[animation]" class="apexnb-selection">
                                     <option value="smooth" <?php if(isset($edn_bar_setting['edn_countdowntimer']['animation']) && $edn_bar_setting['edn_countdowntimer']['animation'] == "smooth") echo "selected='selected'";?>><?php _e('Smooth',APEXNB_TD);?></option>
                                     <option value="ticks" <?php if(isset($edn_bar_setting['edn_countdowntimer']['animation']) && $edn_bar_setting['edn_countdowntimer']['animation'] == "ticks") echo "selected='selected'";?>><?php _e('Ticks',APEXNB_TD);?></option>
                                    </select>
                                   
                                </div>  
                       </div>  
                       </div>
                       <div class="clear"></div>
               <div class="edn-col-full">
                        <ul class="apexnb-section-fields-wrap">
                         <li>
                            <div class="single-counttimer-bar">
                                <label class="first-wrap"><?php _e('Days',APEXNB_TD);?></label>
                                <label class="strong_texts">
                               <input type="checkbox" name="edn_countdowntimer[enable_days]" value="1" <?php if(isset($edn_bar_setting['edn_countdowntimer']['enable_days']) && $edn_bar_setting['edn_countdowntimer']['enable_days'] == 1) echo 'checked="checked"'; ?>/>Show</label>
                                <label class="label"><?php _e('Label',APEXNB_TD);?>
                                <input type="text" name="edn_countdowntimer[enable_days_label]" placeholder="<?php _e('days',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['enable_days_label'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['enable_days_label']);}?>" />
                                </label>
                            </div>
                        </li>
                          <li>
                            <div class="single-counttimer-bar">
                                <label class="first-wrap"><?php _e('Hours',APEXNB_TD);?></label>
                                <label class="strong_texts">
                                <input type="checkbox" name="edn_countdowntimer[enable_hours]" value="1" <?php if(isset($edn_bar_setting['edn_countdowntimer']['enable_hours']) && $edn_bar_setting['edn_countdowntimer']['enable_hours'] == 1) echo 'checked="checked"'; ?>/>Show</label>
                                <label class="label"><?php _e('Label',APEXNB_TD);?>
                                <input type="text" name="edn_countdowntimer[enable_hours_label]" placeholder="<?php _e('hour',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['enable_hours_label'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['enable_hours_label']);}?>" />
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="single-counttimer-bar">
                                <label class="first-wrap"><?php _e('Minutes',APEXNB_TD);?></label>
                                <label class="strong_texts">
                                 <input type="checkbox" name="edn_countdowntimer[enable_minute]" value="1" <?php if(isset($edn_bar_setting['edn_countdowntimer']['enable_minute']) && $edn_bar_setting['edn_countdowntimer']['enable_minute'] == 1) echo 'checked="checked"'; ?>/>Show</label>
                                <label class="label"><?php _e('Label',APEXNB_TD);?>
                                <input type="text" name="edn_countdowntimer[enable_minute_label]" placeholder="<?php _e('min',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['enable_minute_label'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['enable_minute_label']);}?>" />
                                </label>
                            </div>
                        </li>
                         <li>
                            <div class="single-counttimer-bar">
                                <label class="first-wrap"><?php _e('Second',APEXNB_TD);?></label>
                                <label class="strong_texts">
                                <input type="checkbox" name="edn_countdowntimer[enable_seconds]" value="1" <?php if(isset($edn_bar_setting['edn_countdowntimer']['enable_seconds']) && $edn_bar_setting['edn_countdowntimer']['enable_seconds'] == 1) echo 'checked="checked"'; ?>/>Show</label>
                                <label class="label"><?php _e('Label',APEXNB_TD);?>
                                <input type="text" name="edn_countdowntimer[enable_seconds_label]" placeholder="<?php _e('sec',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['enable_seconds_label'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['enable_seconds_label']);}?>" />
                                </label>
                            </div>
                        </li>
                          <li>
                            <div class="single-counttimer-bar ">
                                <label class="first-wrap"><?php _e('Call To Action Button',APEXNB_TD);?></label>
                                <label class="strong_texts">
                                <input type="checkbox" name="edn_countdowntimer[show_button]" value="1" <?php if(isset($edn_bar_setting['edn_countdowntimer']['show_button']) && $edn_bar_setting['edn_countdowntimer']['show_button'] == 1) echo 'checked="checked"'; ?>/>Show</label>
                                <label class="label"><?php _e('Label',APEXNB_TD);?>
                               <input type="text" name="edn_countdowntimer[btnlabel]" placeholder="<?php _e('GRAB YOUR PLUGIN NOW!',APEXNB_TD);?>"
                                value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['btnlabel'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['btnlabel']);}?>" />
                                </label>
                            </div>
                            <div class="apx-count-url-wrap edn-field">
                              <label class="label"><?php _e('URL Link',APEXNB_TD);?>
                                <input type="url" name="edn_countdowntimer[link]" placeholder="<?php _e('https://..',APEXNB_TD);?>"
                                value="<?php if(isset($edn_bar_setting['edn_countdowntimer']['link'])){echo esc_attr($edn_bar_setting['edn_countdowntimer']['link']);}?>" />
                                </label>
                              <label class="label" ><?php _e('URL Link Target',APEXNB_TD);?>
                                 <select id="edn-link-target3" name="edn_countdowntimer[url_target]" class="apexnb-selection">
                                     <option value="_blank" <?php if(isset($edn_bar_setting['edn_countdowntimer']['url_target']) && $edn_bar_setting['edn_countdowntimer']['url_target'] =="_blank"){ echo "selected='selected'";} ?>><?php _e('_blank',APEXNB_TD);?></option>
                                     <option value="_self" <?php if(isset($edn_bar_setting['edn_countdowntimer']['url_target']) && $edn_bar_setting['edn_countdowntimer']['url_target'] =="_self"){ echo "selected='selected'";} ?>><?php _e('_self',APEXNB_TD);?></option>
                                     <option value="_parent" <?php if(isset($edn_bar_setting['edn_countdowntimer']['url_target']) && $edn_bar_setting['edn_countdowntimer']['url_target'] =="_parent"){ echo "selected='selected'";} ?>><?php _e('_parent',APEXNB_TD);?></option>
                                     <option value="_top" <?php if(isset($edn_bar_setting['edn_countdowntimer']['url_target']) && $edn_bar_setting['edn_countdowntimer']['url_target'] =="_top"){ echo "selected='selected'";} ?>><?php _e('_top',APEXNB_TD);?></option>
                                    </select>
                                </label>
                            </div>
                        </li>
                                               
                         </ul>
                </div>