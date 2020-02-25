
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                         
                                <div class="edn-field">
                                        <div class="edn-field-label-wrap"> 
                                          <label><?php _e('Video Layout',APEXNB_TD);?>
                                          </label>
                                        <p class="edn-note"><?php _e('Choose Video layout.',APEXNB_TD)?></p>
                                       </div>
                                        <div class="edn-field-input-wrap">
                                        <select name="edn_video[layout_type]" class="apex_videolayout apexnb-selection">
                                         <option value="layout1" <?php if(isset($edn_bar_setting['edn_video']['layout_type']) && $edn_bar_setting['edn_video']['layout_type'] == "layout1") echo "selected='selected'";?>><?php _e('Layout1',APEXNB_TD);?></option>
                                         <option value="layout2" <?php if(isset($edn_bar_setting['edn_video']['layout_type']) && $edn_bar_setting['edn_video']['layout_type'] == "layout2") echo "selected='selected'";?>><?php _e('Layout2',APEXNB_TD);?></option>
                                         <option value="layout3" <?php if(isset($edn_bar_setting['edn_video']['layout_type']) && $edn_bar_setting['edn_video']['layout_type'] == "layout3") echo "selected='selected'";?>><?php _e('Layout3',APEXNB_TD);?></option>
                                         <option value="layout4" <?php if(isset($edn_bar_setting['edn_video']['layout_type']) && $edn_bar_setting['edn_video']['layout_type'] == "layout4") echo "selected='selected'";?>><?php _e('Layout4',APEXNB_TD);?></option>
                                        
                                       </select>
                                  
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="preview-video apexbar-bpreview" style="display:none;">
                         <div id="video_layout1" class="preview_video">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/video-layout1.JPG"/>
                         </div>
                         <div id="video_layout2" class="preview_video">
                             <h4>Without Background Image:</h4>
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/video-layout2.JPG"/>
                             <br/>
                             <h4>With Background Image:</h4>
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/video-layout5.JPG"/>
                         </div>
                         <div id="video_layout3" class="preview_video">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/video-layout3.JPG"/>
                         </div>
                         <div id="video_layout4" class="preview_video">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/video-layout4.JPG"/>
                         </div>
                      
                            

                        </div>

                    <div class="clear"></div>
                      <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                               <div class="edn-field">
                                <div class="edn-field-label-wrap"> <label><?php _e('Video Title',APEXNB_TD)?></label>
                                 <p class="description"><?php _e('Fill video title.',APEXNB_TD);?></p>
                                 </div>
                             
                               <div class="edn-field-input-wrap">
                                    <input type="text" name="edn_video[title]"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['title'])){echo esc_attr($edn_bar_setting['edn_video']['title']);}?>" />
                                </div>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>

                          <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                             <div class="edn-field">
                                <div class="edn-field-label-wrap">
                                  <label><?php _e('Video Description',APEXNB_TD)?></label>
                                  <p class="description"><?php _e('Fill video description.',APEXNB_TD);?></p>
                                </div>
                                  <div class="edn-field-input-wrap">
                                      <textarea rows="6" cols="70" name="edn_video[description]"><?php if(isset($edn_bar_setting['edn_video']['description'])){echo esc_attr($edn_bar_setting['edn_video']['description']);}?></textarea>
                                  </div>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>

                          <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                               <div class="edn-field">
                                <div class="edn-field-label-wrap"> <label><?php _e('Video Icon',APEXNB_TD)?></label>
                                 <p class="description"><?php _e('Set Video Icon such as fa fa-play-circle, fa fa-vimeo, fa fa-youtube-play.',APEXNB_TD);?></p>
                                 </div>
                             
                               <div class="edn-field-input-wrap">
                                    <input type="text" name="edn_video[font-icon]" placeholder="<?php _e('fa fa-play-circle',APEXNB_TD);?>"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['font-icon'])){echo esc_attr($edn_bar_setting['edn_video']['font-icon']);}?>" />
                                </div>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>



                           <div class="edn-col-full">
                                    <div class="edn-field-wrapper edn-form-field">
                                      <div class="edn-field">
                                         <div class="edn-field-label-wrap"><label><?php _e('Video Type',APEXNB_TD)?></label></div>
                                         <div class="edn-field-input-wrap">
                                         <select name="edn_video[video_type]" class="apexnb-vidtype-bg apexnb-selection">
                                            <option value="youtube" <?php if(isset($edn_bar_setting['edn_video']['video_type']) && $edn_bar_setting['edn_video']['video_type'] =="youtube"){ echo "selected='selected'";} ?>><?php _e('Youtube', APEXNB_TD );?></option>
                                            <option value="vimeo" <?php if(isset($edn_bar_setting['edn_video']['video_type']) && $edn_bar_setting['edn_video']['video_type'] =="vimeo"){ echo "selected='selected'";} ?>><?php _e('Vimeo', APEXNB_TD );?></option>
                                            <option value="own" <?php if(isset($edn_bar_setting['edn_video']['video_type']) && $edn_bar_setting['edn_video']['video_type'] =="own"){ echo "selected='selected'";} ?>><?php _e('Upload your own',APEXNB_TD);?></option>
                                        </select>
                                 </div>
                                        </div>
                                    </div><!--edn-field-wrapper-->
                          </div>

                           <div class="edn-col-full apexnb-youtubeurl">
                            <div class="edn-field-wrapper edn-form-field">
                             <div class="edn-field">
                                <div class="edn-field-label-wrap"> <label><?php _e('Video URL',APEXNB_TD)?></label>
                                <p class="desciption"><?php _e('Fill youtube video url link.',APEXNB_TD);?></p>
                                </div>
                               
                                 <div class="edn-field-input-wrap">
                                    <input type="url" name="edn_video[video_url]" placeholder="https://"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['video_url'])){echo esc_url($edn_bar_setting['edn_video']['video_url']);}?>" />
                                    </div>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                         <div class="edn-col-full apexnb-vimeo-url">
                            <div class="edn-field-wrapper edn-form-field">
                             <div class="edn-field">
                                 <div class="edn-field-label-wrap"><label><?php _e('Vimeo URL',APEXNB_TD)?></label>
                                   <p class="desciption"><?php _e('Fill vimeo url link.',APEXNB_TD);?></p>
                                   </div>
                                <div class="edn-field-input-wrap">
                                    <input type="url" name="edn_video[vimeo_url]" placeholder="https://"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['vimeo_url'])){echo esc_url($edn_bar_setting['edn_video']['vimeo_url']);}?>" />
                               </div>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                          <div class="edn-col-full apexnb-upload-own-video">
                            <div class="edn-field-wrapper edn-form-field">
                                  <div class="edn-field">
                                  <div class="edn-field-label-wrap">
                                    <label><?php _e('Upload Your Own',APEXNB_TD)?></label>
                                    <p class="desciption"><?php _e('Upload own video from media.',APEXNB_TD);?></p>
                                  </div>
                                <div class="edn-field-input-wrap">
                                  <input type="text" class="apexnb-cvideo-html-url" name="edn_video[upload_url]"  
                                  value="<?php if(isset($edn_bar_setting['edn_video']['upload_url'])){echo esc_url($edn_bar_setting['edn_video']['upload_url']);}?>" />
                                  <input type="button" class="button button-primary apexnb-video-html-url-button" name="apexnb-video-html-url-button"  
                                  value="Upload Video" size="25"/> 
                                 </div>
                                 </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                    
                     <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                            <div class="edn-field">
                               <div class="edn-field-label-wrap">
                                 <label><?php _e('Video Button Title',APEXNB_TD)?></label>
                                  <p class="description"><?php _e('Fill video button title.',APEXNB_TD);?></p>
                              </div>
                                <div class="edn-field-input-wrap">
                                    <input type="text" name="edn_video[button_title]"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['button_title'])){echo esc_attr($edn_bar_setting['edn_video']['button_title']);}?>" />
                                
                                </div>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>     
                        
                        <div class="edn-inner-main-title apexnb-popup-settings"><?php _e('Popup Settings',APEXNB_TD);?></div>
                      <div class="popup-settings-features">
                           <div class="edn-col-one-fourth">
                                    <div class="edn-field-wrapper edn-form-field">
                                        <label><?php _e('Popup Animation Speed',APEXNB_TD)?></label>
                                        <div class="edn-field">
                                         <select name="edn_video[popup_animation_speed]" class="apexnb-selection">
                                            <option value="fast" <?php if(isset($edn_bar_setting['edn_video']['popup_animation_speed']) && $edn_bar_setting['edn_video']['popup_animation_speed'] =="fast"){ echo "selected='selected'";} ?>><?php _e('Fast', APEXNB_TD );?></option>
                                            <option value="slow" <?php if(isset($edn_bar_setting['edn_video']['popup_animation_speed']) && $edn_bar_setting['edn_video']['popup_animation_speed'] =="slow"){ echo "selected='selected'";} ?>><?php _e('Slow', APEXNB_TD );?></option>
                                            <option value="normal" <?php if(isset($edn_bar_setting['edn_video']['popup_animation_speed']) && $edn_bar_setting['edn_video']['popup_animation_speed'] =="normal"){ echo "selected='selected'";} ?>><?php _e('Normal',APEXNB_TD);?></option>
                                        </select>
                                      <p class="description"><?php _e('Choose popup animation speed for video.',APEXNB_TD);?></p>

                                        </div>
                                    </div><!--edn-field-wrapper-->
                          </div>
                           <div class="edn-col-one-fourth">
                                    <div class="edn-field-wrapper edn-form-field">
                                        <label><?php _e('Video Autoplay',APEXNB_TD)?></label>
                                        <div class="edn-field">
                                         <select name="edn_video[video_autoplay]" class="apexnb-selection">
                                            <option value="true" <?php if(isset($edn_bar_setting['edn_video']['video_autoplay']) && $edn_bar_setting['edn_video']['video_autoplay'] =="true"){ echo "selected='selected'";} ?>><?php _e('True', APEXNB_TD );?></option>
                                            <option value="false" <?php if(isset($edn_bar_setting['edn_video']['video_autoplay']) && $edn_bar_setting['edn_video']['video_autoplay'] =="false"){ echo "selected='selected'";} ?>><?php _e('False', APEXNB_TD );?></option>
                                        </select>
                                        <p class="description"><?php _e('Choose popup animation speed for video.',APEXNB_TD);?></p>
                                        </div>
                                    </div><!--edn-field-wrapper-->
                          </div>
                          <div class="edn-col-one-fourth">
                                    <div class="edn-field-wrapper edn-form-field">
                                        <label><?php _e('Show Popup Video Title',APEXNB_TD)?></label>
                                        <div class="edn-field">
                                         <select name="edn_video[show_title_on_popup]" class="apexnb-selection">
                                            <option value="true" <?php if(isset($edn_bar_setting['edn_video']['show_title_on_popup']) && $edn_bar_setting['edn_video']['show_title_on_popup'] =="true"){ echo "selected='selected'";} ?>><?php _e('True', APEXNB_TD );?></option>
                                            <option value="false" <?php if(isset($edn_bar_setting['edn_video']['show_title_on_popup']) && $edn_bar_setting['edn_video']['show_title_on_popup'] =="false"){ echo "selected='selected'";} ?>><?php _e('False', APEXNB_TD );?></option>
                                        </select>
                                 <p class="description"><?php _e('Set true to show video title on popup.<br/> Default Set as True.',APEXNB_TD);?></p>
                                        </div>
                                    </div><!--edn-field-wrapper-->
                          </div>
                         <div class="edn-col-one-fourth">
                                    <div class="edn-field-wrapper edn-form-field">
                                        <label><?php _e('Video Popup Theme',APEXNB_TD)?></label>
                                        <div class="edn-field">
                                         <select name="edn_video[video_popup_theme]" class="apexnb-selection">
                                            <option value="facebook" <?php if(isset($edn_bar_setting['edn_video']['video_popup_theme']) && $edn_bar_setting['edn_video']['video_popup_theme'] =="facebook"){ echo "selected='selected'";} ?>><?php _e('Facebook Theme', APEXNB_TD );?></option>
                                            <option value="light_rounded" <?php if(isset($edn_bar_setting['edn_video']['video_popup_theme']) && $edn_bar_setting['edn_video']['video_popup_theme'] =="light_rounded"){ echo "selected='selected'";} ?>><?php _e('Light Rounded', APEXNB_TD );?></option>
                                            <option value="dark_rounded" <?php if(isset($edn_bar_setting['edn_video']['video_popup_theme']) && $edn_bar_setting['edn_video']['video_popup_theme'] =="dark_rounded"){ echo "selected='selected'";} ?>><?php _e('Dark Rounded', APEXNB_TD );?></option>
                                            <option value="light_square" <?php if(isset($edn_bar_setting['edn_video']['video_popup_theme']) && $edn_bar_setting['edn_video']['video_popup_theme'] =="light_square"){ echo "selected='selected'";} ?>><?php _e('Light Square', APEXNB_TD );?></option>
                                            <option value="dark_square" <?php if(isset($edn_bar_setting['edn_video']['video_popup_theme']) && $edn_bar_setting['edn_video']['video_popup_theme'] =="dark_square"){ echo "selected='selected'";} ?>><?php _e('Dark Square', APEXNB_TD );?></option> 
                                        </select>
                                 <p class="description"><?php _e('Choose theme to display video on popup.<br/> Default Set as Facebook.',APEXNB_TD);?></p>
                                        </div>
                                    </div><!--edn-field-wrapper-->
                          </div>
                      </div>
                           <div class="edn-col-full">
                                    <div class="edn-field-wrapper edn-form-field">
                                     <div class="edn-field">
                                        <div class="edn-field-label-wrap">
                                        <label><?php _e('Popup Width',APEXNB_TD)?></label>
                                        <p class="description"><?php _e('Choose Set Width for Video Popup.<br/> Default Set as 500.',APEXNB_TD);?></p>
                                        </div>
                                        <div class="edn-field-input-wrap">
                                          <input type="number" name="edn_video[video_popup_width]"
                                         value="<?php if(isset($edn_bar_setting['edn_video']['video_popup_width'])){echo esc_attr($edn_bar_setting['edn_video']['video_popup_width']);}?>" />
                                          </div>
                                        </div>
                                    </div><!--edn-field-wrapper-->
                            </div>
                                <div class="edn-col-full">
                                    <div class="edn-field-wrapper edn-form-field">
                                      <div class="edn-field">
                                     <div class="edn-field-label-wrap">
                                        <label><?php _e('Popup Height',APEXNB_TD)?></label>
                                         <p class="description"><?php _e('Choose Set Height for Video Popup. <br/>Default Set as 344.',APEXNB_TD);?></p>
                                        </div>
                                       <div class="edn-field-input-wrap">
                                          <input type="number" name="edn_video[video_popup_height]"
                                         value="<?php if(isset($edn_bar_setting['edn_video']['video_popup_height'])){echo esc_attr($edn_bar_setting['edn_video']['video_popup_height']);}?>" />
                                          </div>
                                        </div>
                                    </div><!--edn-field-wrapper-->
                            </div>

                  <div class="clear"></div>
            
            <div class="edn-custom-hide">
                 <div class="edn-inner-main-title"><?php _e('Popup Custom Design Layout',APEXNB_TD);?></div>
                       <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Title Font Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_video[textcolor]"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['textcolor'])){echo esc_attr($edn_bar_setting['edn_video']['textcolor']);}?>" />
                                 <p class="description"><?php _e('Set title text font color.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                           <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Description Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_video[desccolor]"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['desccolor'])){echo esc_attr($edn_bar_setting['edn_video']['desccolor']);}?>" />
                                 <p class="description"><?php _e('Set description font color.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                         
                          <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Title Font Size',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="number" name="edn_video[textsize]"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['textsize'])){echo esc_attr($edn_bar_setting['edn_video']['textsize']);}?>" />
                                <p class="description"><?php _e('Set text font size in px.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                        <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Description Font Size',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="number" name="edn_video[descsize]"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['descsize'])){echo esc_attr($edn_bar_setting['edn_video']['descsize']);}?>" />
                                <p class="description"><?php _e('Set description font size in px.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                           <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Button Background Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_video[button_bg_color]"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['button_bg_color'])){echo esc_attr($edn_bar_setting['edn_video']['button_bg_color']);}?>" />
                                 <p class="description"><?php _e('Set Button background color.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                           <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Button Font Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_video[button_font_color]"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['button_font_color'])){echo esc_attr($edn_bar_setting['edn_video']['button_font_color']);}?>" />
                                 <p class="description"><?php _e('Set Button font color.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>

                             <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Button Hover Background Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_video[button_hover_bg_color]"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['button_hover_bg_color'])){echo esc_attr($edn_bar_setting['edn_video']['button_hover_bg_color']);}?>" />
                                 <p class="description"><?php _e('Set Button hover background color as per template button design wise.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                           <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Button Hover Font Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_video[button_hover_font_color]"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['button_hover_font_color'])){echo esc_attr($edn_bar_setting['edn_video']['button_hover_font_color']);}?>" />
                                 <p class="description"><?php _e('Set Button hover font color as per template button design wise.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                           <div class="clear"></div>
                         
                          <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Button Font Size',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="number" name="edn_video[button_font_size]"
                                     value="<?php if(isset($edn_bar_setting['edn_video']['button_font_size'])){echo esc_attr($edn_bar_setting['edn_video']['button_font_size']);}?>" />
                                <p class="description"><?php _e('Set Button font size in px.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                </div>     
<div class="clear"></div>

             