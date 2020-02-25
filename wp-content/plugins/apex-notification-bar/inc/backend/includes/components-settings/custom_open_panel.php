<?php 
// echo "<pre>";
// print_r($edn_bar_setting['edn_open_panel']);
?>
<div class="edn-custom-panel-section">
                 <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field">
                       
                        <div class="edn-field">
                            <div class="edn-field-label-wrap">
                                 <label for="edn-open-panel"><?php _e('Add Open Panel',APEXNB_TD); ?></label>
                              </div>
                             <div class="edn-field-input-wrap">
                               <div class="apexnb-switch">
                                <input type="checkbox" name="edn_open_panel[enable_openpanel]" id="edn-open-panel" 
                                value="1" <?php if(isset($edn_bar_setting['edn_open_panel']['enable_openpanel']) && $edn_bar_setting['edn_open_panel']['enable_openpanel']==1){echo 'checked="checked"';}?>/>
                             <label class="edn-label-inline" for="edn-open-panel"></label>
                             </div>
                             </div>
                        </div>
                    </div>
                </div>
<div class="edn-col-half edn-open-panel-wrap" style="display: none;">
               <table>
                  <tr>
                       <td><label for="edn-enable_hover_text"><?php _e('Enable Hover Text',APEXNB_TD)?></label></td>
                       <td><div class="edn-field">
                        <div class="apexnb-switch">
                       <input type="checkbox" id="edn-enable_hover_text" name="edn_open_panel[enable_hover_text]" value="1" <?php if(isset($edn_bar_setting['edn_open_panel']['enable_hover_text']) && $edn_bar_setting['edn_open_panel']['enable_hover_text']==1){echo 'checked="checked"';}?> title="<?php _e('Enable Hover Text',APEXNB_TD);?>"/>
                      <label for="edn-enable_hover_text"></label>
                      </div>
                       </div>
                      </td>
                   </tr>
                   <tr>
                       <td><label for="edn-hover-panel-text"><?php _e('Hover Text',APEXNB_TD)?></label></td>
                       <td><div class="edn-field">
                       <input type="text" id="edn-hover-panel-text" name="edn_open_panel[edn_hover_panel_text]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_hover_panel_text'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_hover_panel_text']):'');?>" class="edn-text-show"
                                placeholder="<?php _e('E.g: Open Panel',APEXNB_TD);?>"/>
                       </div>
                      </td>
                   </tr>
              </table>

              <div class="header_section"><?php _e('Background Image',APEXNB_TD);?></div>
                    <?php
                     $enable_op_bgimg = (isset($edn_bar_setting['edn_open_panel']['enable_bgimage']) && $edn_bar_setting['edn_open_panel']['enable_bgimage'] == 1)?1:0;
                     $opanel_bgimg = (isset($edn_bar_setting['edn_open_panel']['bgimage_url']) && $edn_bar_setting['edn_open_panel']['bgimage_url'] != '')?esc_url($edn_bar_setting['edn_open_panel']['bgimage_url']):'';
                    ?>
              <div class="apexnb-background-image">
                    <div class="edn-field">
                            <div class="edn-field-label-wrap">
                              <label for="upload_openpanel_bgimage"><?php _e('Enable Background Image',APEXNB_TD);?></label>
                               <p class="description"><?php _e('Enable background image for open panel.',APEXNB_TD);?></p>
                            </div>
                            <div class="edn-field-input-wrap">
                                <div class="apexnb-switch">
                                  <input type="checkbox" id="upload_openpanel_bgimage" name="edn_open_panel[enable_bgimage]" value="1" <?php if($enable_op_bgimg == 1){echo 'checked="checked"';}?>>
                                  <label for="upload_openpanel_bgimage"></label>
                                </div>
                            </div>
                    
                    </div>

                   <div class="edn-field show_uploadbgimage_opanel" <?php if($enable_op_bgimg != 1) echo 'style="display: none;"';?>>
                              <div class="edn-field-label-wrap">
                                 <label><?php _e('Upload Background Image',APEXNB_TD);?></label>
                               </div>
                               <div class="edn-field-input-wrap">
                                    <div class="apexnb-img-bgwrap">
                                    <input type="url" name="edn_open_panel[bgimage_url]" class="apexnb-bg-image-url" value="<?php echo $opanel_bgimg;?>">
                                    <input type="button" class="apexnb_bgimage_url_button button button-primary" value="Upload Background Image" size="25"> 
                                        
                                        <div class="apexnb-option-field apexnb-bgimage-preview" <?php if($enable_op_bgimg == 0 && $opanel_bgimg == '') echo 'style="display:none;"';?>>
                                          <img class="apexnb-bgimage" src="<?php echo $opanel_bgimg;?>" width="250">
                                        </div>
                                    </div> 
                                </div>
                     </div>
                     <div class="edn-field show_uploadbgimage_opanel" <?php if($enable_op_bgimg != 1) echo 'style="display: none;"';?>>
                              <div class="edn-field-label-wrap">
                                 <label><?php _e('Background Color For Opacity',APEXNB_TD);?></label>
                               </div>
                               <div class="edn-field-input-wrap">
                                  <input type="text" name="edn_open_panel[bg_opacity_color]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['bg_opacity_color'])?esc_attr($edn_bar_setting['edn_open_panel']['bg_opacity_color']):'');?>" id="bg_opacity_color" class="edn-color-picker" data-alpha="true" />
                               </div>
                     </div>

                </div>

              <div class="header_section"><?php _e('Trigger Image',APEXNB_TD);?></div>
                <?php
                 $trigger_enable = (isset($edn_bar_setting['edn_open_panel']['trigger_enable']) && $edn_bar_setting['edn_open_panel']['trigger_enable'] == 1)?1:0;
                 $trigger_image = (isset($edn_bar_setting['edn_open_panel']['trigger_image']) && $edn_bar_setting['edn_open_panel']['trigger_image'] != '')?esc_url($edn_bar_setting['edn_open_panel']['trigger_image']):'';
                 $custom_image_width = (isset($edn_bar_setting['edn_open_panel']['custom_image_width']) && $edn_bar_setting['edn_open_panel']['custom_image_width'] != '')?esc_attr($edn_bar_setting['edn_open_panel']['custom_image_width']):'';
                 $custom_image_height = (isset($edn_bar_setting['edn_open_panel']['custom_image_height']) && $edn_bar_setting['edn_open_panel']['custom_image_height'] != '')?esc_attr($edn_bar_setting['edn_open_panel']['custom_image_height']):'';
                ?>
              <div class="apexnb-background-image">
                    <div class="edn-field">
                            <div class="edn-field-label-wrap">
                              <label for="trigger_enable"><?php _e('Enable Trigger Image',APEXNB_TD);?></label>
                                 <p class="description"><?php _e('Enable trigger image for open panel for show/hide panel. If disable, then default show/hide arrow will be displayed instead of uploaded trigger image.',APEXNB_TD);?></p>
                            </div>
                            <div class="edn-field-input-wrap">
                                <div class="apexnb-switch">
                                  <input type="checkbox" id="trigger_enable" name="edn_open_panel[trigger_enable]" value="1" <?php if($trigger_enable == 1){echo 'checked="checked"';}?>>
                                  <label for="trigger_enable"></label>
                               
                                </div>
                            </div>
                    </div>
                  
            <?php
                 $trigger_layout = (isset($edn_bar_setting['edn_open_panel']['trigger_layout']) && $edn_bar_setting['edn_open_panel']['trigger_layout'] == 'available_image')?'available_image':'upload_custom';
                 $trigger_template = (isset($edn_bar_setting['edn_open_panel']['trigger_template']) && $edn_bar_setting['edn_open_panel']['trigger_template'] != '')?intval($edn_bar_setting['edn_open_panel']['trigger_template']):'1';
                ?>
                     <div class="edn-field">
                            <div class="edn-field-label-wrap">
                              <label><?php _e('Choose Trigger Image',APEXNB_TD);?></label>
                            </div>
                            <div class="edn-field-input-wrap">
                                <div class="apexnb-switch">
                                 <select name="edn_open_panel[trigger_layout]" class="apexnb-selection edn_choose_timage_type">
                                   <option value="available_image" <?php selected('available_image',$trigger_layout); ?>>Available Image</option>
                                   <option value="upload_custom" <?php selected('upload_custom',$trigger_layout); ?>>Upload Custom Image</option>
                                 </select>
                                </div>
                            </div>
                    
                    </div>

                <div class="edn-field ednpro-available-timage" <?php if($trigger_layout != "available_image") echo "style='display:none'";?>>
                      <div class="edn-field-label-wrap">
                           <label><?php _e('Choose Template Images',APEXNB_TD);?></label>
                      </div>
                      <div class="edn-field-input-wrap">
                       <div class="ednfield-available-timage">
                         <?php 
                         for($i = 1; $i <= 22;$i++){ 
                          if($i == 1 || $i == 2 || $i == 21 || $i == 22){
                            $triggerclass="edn-ptop";
                          }else if($i == 9 || $i == 10 || $i == 18){
                             $triggerclass="edn-pbottom";
                            }else if($i == 3 || $i == 4 || $i == 16){
                             $triggerclass="edn-leftright";
                            }else if($i == 5 || $i == 6 || $i == 7 || $i == 8  || $i == 12 || $i == 14 || $i == 15 || $i == 17 || $i == 19 || $i == 20){
                             $triggerclass="edn-allposition";
                            }else if($i == 13 || $i == 11){
                              $triggerclass="edn-ptopbottom";
                            }

                         ?>
                        <div class="ednpro-avimage <?php if($trigger_template == $i){ echo ' edn_ctimage_active ';}?> <?php echo $triggerclass;?>" id="trigger_template<?php echo $i;?>">
                            <input type="radio" id="edn_ctimage<?php echo $i;?>" name="edn_open_panel[trigger_template]" class="ednpro-statusmode" value="<?php echo $i;?>" <?php if($trigger_template == $i){ echo 'checked';}?>>
                          <label for="edn_ctimage<?php echo $i;?>">
                            <?php if($i == 21 || $i == 22){?>
                            <img height="73" src="<?php echo APEXNB_IMAGE_DIR;?>/trigger_available_images/backend/triggerimg<?php echo $i;?>.png"/>
                            <?php }else{ ?>
                           <img src="<?php echo APEXNB_IMAGE_DIR;?>/trigger_available_images/backend/triggerimg<?php echo $i;?>.jpg"/>
                            <?php }?>
                          </label>
                        </div>
                         <?php  }?>
                      </div>
                      </div>
                </div>

                <!-- custom image upload start-->
                <div class="edn-field show_timage_opanel" <?php if($trigger_layout != "upload_custom") echo "style='display:none'";?>>
                              <div class="edn-field-label-wrap">
                                 <label><?php _e('Upload Trigger Image',APEXNB_TD);?></label>
                               </div>
                               <div class="edn-field edn-field-input-wrap">
                                    <div class="apexnb-timg-bgwrap">
                                    <input type="url" name="edn_open_panel[trigger_image]" class="apexnb-bg-timage-url" value="<?php echo $trigger_image;?>">
                                    <input type="button" class="apexnb_trigger_image_button button button-primary" value="Upload Trigger Image" size="25"> 
                                      <div class="apexnb-option-field apexnb-timage-preview" <?php if($trigger_enable == 0 && $trigger_layout != "upload_custom" && $trigger_image == '') echo 'style="display:none;"';?>>
                                      <?php 
                                      if($trigger_image != ''){
                                       $trigger_image_url = $trigger_image;
                                      }else{
                                       $trigger_image_url = APEXNB_IMAGE_DIR.'/no_preview.jpg';
                                      }
                                    ?>
                                        <img class="apexnb-bgtimage" src="<?php echo $trigger_image_url;?>" width="250">
                                      
                                      </div>
                                  </div> 
                                </div>

                                <div class="edn-field-label-wrap">
                                 <label><?php _e('Custom Width/Height (in px)',APEXNB_TD);?></label>
                               </div>
                               <div class="edn-field edn-field-input-wrap">
                                     <input style="width: 16%;" type="number" name="edn_open_panel[custom_image_width]" class="apexnb-bg-image-width" value="<?php echo $custom_image_width;?>"> Width 
                                      <input style="width: 16%;" type="number" name="edn_open_panel[custom_image_height]" class="apexnb-bg-image-height" value="<?php echo $custom_image_height;?>"> Height
                                </div>
                                <div class="edn-field-label-wrap">
                                 <label><?php _e('Custom Image Animation',APEXNB_TD);?></label>
                               </div>
                
                               <div class="edn-field edn-field-input-wrap">
                                  <select class="apexnb-selection" name="edn_open_panel[custom_opanel_animation]">
                                    <option value="" <?php if(isset($edn_bar_setting['edn_open_panel']['custom_opanel_animation']) && $edn_bar_setting['edn_open_panel']['custom_opanel_animation']==''){echo 'selected="selected"';}?>>No Animation</option>
                                    <option value="ednpro-animi1" <?php if(isset($edn_bar_setting['edn_open_panel']['custom_opanel_animation']) && $edn_bar_setting['edn_open_panel']['custom_opanel_animation']=='ednpro-animi1'){echo 'selected="selected"';}?>>Animation 1 (Swing)</option>
                                    <option value="ednpro-animi2" <?php if(isset($edn_bar_setting['edn_open_panel']['custom_opanel_animation']) && $edn_bar_setting['edn_open_panel']['custom_opanel_animation']=='ednpro-animi2'){echo 'selected="selected"';}?>>Animation 2 (BounceX Infinite)</option>
                                   <option value="ednpro-animi3" <?php if(isset($edn_bar_setting['edn_open_panel']['custom_opanel_animation']) && $edn_bar_setting['edn_open_panel']['custom_opanel_animation']=='ednpro-animi3'){echo 'selected="selected"';}?>>Animation 3 (Bottom-Up)</option>
                                  </select>
                                </div>
                    
                    </div>
                 <!-- custom image upload end-->
                </div>

              <div class="header_section"><?php _e('Header',APEXNB_TD);?></div>
               <table>
                    <tr>
                       <td>
                       <label for="enable_headertext"> <?php _e('Enable Header Text',APEXNB_TD);?></label></td>
                       <td><div class="edn-field">
                       <div class="apexnb-switch">
                        <input type="checkbox" id="enable_headertext" name="edn_open_panel[edn_show_header]" value="1" <?php if(isset($edn_bar_setting['edn_open_panel']['edn_show_header']) && $edn_bar_setting['edn_open_panel']['edn_show_header']==1){echo 'checked="checked"';}?>/>       
                        <label for="enable_headertext"></label>
                       </div>
                       </div>
                      </td>
                   </tr>
                   <tr>
                       <td><label for="edn_header_text"><?php _e('Header Text',APEXNB_TD)?></label></td>
                       <td>
                       <div class="edn-field">
                       <input type="text" id="edn_header_text" name="edn_open_panel[edn_header_text]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_header_text'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_header_text']):'');?>" class="edn-text-show"
                                placeholder="<?php _e('Enter header text here.',APEXNB_TD);?>"/>
                       </div>
                      </td>
                   </tr>
                    <tr class="edn-show-border-color">
                       <td><label for="edn_header_color"><?php _e('Header Text Color',APEXNB_TD)?></label>
                       <p class="description"><?php _e('Choose header text color.',APEXNB_TD);?></p></td>
                       <td><div class="edn-field">
                         <input type="text" name="edn_open_panel[edn_header_color]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_header_color'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_header_color']):'');?>" id="edn_header_color" 
                         class="edn-color-picker" />
                       </div>
                      </td>
                   </tr>
                     <tr>
                       <td><label for="show_border_header"><?php _e('Hide Border after Header',APEXNB_TD)?></label>
                       <p class="description"><?php _e('Please check to show border after header.',APEXNB_TD);?></p></td>
                       <td><div class="edn-field">
                         <div class="apexnb-switch">
                         <input type="checkbox" id="show_border_header" name="edn_open_panel[show_border_header]" value="1" <?php if(isset($edn_bar_setting['edn_open_panel']['show_border_header']) && $edn_bar_setting['edn_open_panel']['show_border_header']==1){echo 'checked="checked"';}?>/>
                         <label for="show_border_header"></label>
                       </div>
                      </div>
                      </td>
                   </tr>

              </table>

 <div class="header_section"><?php _e('Footer',APEXNB_TD);?></div>
                <table>
                     <tr>
                       <td>
                       <label for="enable_footertext"> <?php _e('Enable Footer Text',APEXNB_TD);?></label></td>
                       <td><div class="edn-field">
                         <div class="apexnb-switch">
                        <input type="checkbox" id="enable_footertext" name="edn_open_panel[edn_show_footer]" value="1" <?php if(isset($edn_bar_setting['edn_open_panel']['edn_show_footer']) && $edn_bar_setting['edn_open_panel']['edn_show_footer']==1){echo 'checked="checked"';}?>/>       
                      <label for="enable_footertext"></label>
                       </div>
                       </div>
                      </td>
                   </tr>
                   <tr>
                       <td><label for="edn_footer_text"><?php _e('Footer Text',APEXNB_TD)?></label></td>
                       <td><div class="edn-field">
                       <input type="text" id="edn_footer_text" name="edn_open_panel[edn_footer_text]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_footer_text'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_footer_text']):'');?>" class="edn-text-show" 
                                placeholder="<?php _e('Enter footer text here.',APEXNB_TD);?>"/>
                       </div>
                      </td>
                   </tr>
                 <tr class="edn-show-border-color">
                       <td><label for="edn_footer_color"><?php _e('Footer Text Color',APEXNB_TD)?></label>
                       <p class="description"><?php _e('Choose footer text color.',APEXNB_TD);?></p></td>
                       <td><div class="edn-field">
                         <input type="text" name="edn_open_panel[edn_footer_color]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_footer_color'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_footer_color']):'');?>" id="edn_footer_color" 
                         class="edn-color-picker" />
                       </div>
                      </td>
                   </tr>

                    <tr>
                       <td><label for="show_border_footer"><?php _e('Hide Border Above Footer',APEXNB_TD)?></label>
                       <p class="description"><?php _e('Please check to show border above footer.',APEXNB_TD);?></p></td>
                       <td>
                       <div class="edn-field">
                         <div class="apexnb-switch">
                         <input type="checkbox" id="show_border_footer" name="edn_open_panel[show_border_footer]" value="1" <?php if(isset($edn_bar_setting['edn_open_panel']['show_border_footer']) && $edn_bar_setting['edn_open_panel']['show_border_footer']==1){echo 'checked="checked"';}?>/>
                         <label for="show_border_footer"></label>
                       </div>
                      </td>
                   </tr>

                </table>

                 <div class="header_section edn-show-border-color"><?php _e('Display Settings',APEXNB_TD);?></div>
                 <table>

                    <tr class="edn-show-border-color">
                       <td><label><?php _e('Border Color',APEXNB_TD)?></label>
                        <p class="description"><?php _e('Choose common border bottom color for header and border top color footer section.',APEXNB_TD);?></p></td>
                       <td><div class="edn-field">
                         <input type="text" name="edn_open_panel[edn_border_color]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_border_color'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_border_color']):'');?>" id="edn_border_color" class="edn-color-picker" />
                       </div>
                      </td>
                   </tr>
                 <tr class="edn-show-border-color">
                       <td><label><?php _e('Header Tag Color',APEXNB_TD)?></label>
                       <p class="description"><?php _e('This includes color for header tag such as h1,h2,h3,h4,h5.',APEXNB_TD);?></p></td>
                       <td><div class="edn-field">
                         <input type="text" name="edn_open_panel[edn_header_tag_color]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_header_tag_color'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_header_tag_color']):'');?>" id="edn_header_tag_color" 
                         class="edn-color-picker" />
                       </div>
                      </td>
                   </tr>

                    <tr class="edn-show-border-color">
                       <td><label><?php _e('Background Header Color',APEXNB_TD)?></label>
                        <p class="description"><?php _e('Choose background color for header tag such as h1,h2,h3,h4,h5.',APEXNB_TD);?></p></td>
                       <td><div class="edn-field">
                         <input type="text" name="edn_open_panel[edn_header_bgcolor]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_header_bgcolor'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_header_bgcolor']):'');?>" id="edn_header_bgcolor" class="edn-color-picker" />
                       </div>
                      </td>
                   </tr>

                  <tr class="edn-show-border-color">
                       <td><label><?php _e('Background Header Border Color',APEXNB_TD)?></label>
                        <p class="description"><?php _e('Choose background side border color for header tag such as h1,h2,h3,h4,h5.',APEXNB_TD);?></p></td>
                       <td><div class="edn-field">
                         <input type="text" name="edn_open_panel[edn_header_bgbordercolor]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_header_bgbordercolor'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_header_bgbordercolor']):'');?>" id="edn_header_bgbordercolor" class="edn-color-picker" />
                       </div>
                      </td>
                   </tr>



                   <tr class="edn-show-border-color">
                       <td><label><?php _e('Description Tag Color',APEXNB_TD)?></label>
                       <p class="description"><?php _e('This includes color for description tag such as p,span,li,list arrow color.',APEXNB_TD);?></p></td>
                       <td><div class="edn-field">
                         <input type="text" name="edn_open_panel[edn_desc_tag_color]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_desc_tag_color'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_desc_tag_color']):'');?>" id="edn_desc_tag_color" 
                         class="edn-color-picker" />
                       </div>
                      </td>
                   </tr>

                  <tr class="edn-show-border-color">
                       <td><label><?php _e('Hyperlink Color',APEXNB_TD)?></label>
                       <p class="description"><?php _e('This includes color for hyperlink tag such as <a href=""></a> tag.',APEXNB_TD);?></p></td>
                       <td><div class="edn-field">
                         <input type="text" name="edn_open_panel[edn_hyperlink_color]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_hyperlink_color'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_hyperlink_color']):'');?>" id="edn_hyperlink_color" 
                         class="edn-color-picker" />
                       </div>
                      </td>
                   </tr>


                  <tr class="edn-show-border-color">
                       <td><label><?php _e('Hyperlink Hover Color',APEXNB_TD)?></label>
                       <p class="description"><?php _e('This includes color for hyperlink tag on hover such as <a href=""></a> tag.',APEXNB_TD);?></p></td>
                       <td><div class="edn-field">
                         <input type="text" name="edn_open_panel[edn_hyperlinkhover_color]" value="<?php echo (isset($edn_bar_setting['edn_open_panel']['edn_hyperlinkhover_color'])?esc_attr($edn_bar_setting['edn_open_panel']['edn_hyperlinkhover_color']):'');?>" id="edn_hyperlinkhover_color" 
                         class="edn-color-picker" />
                       </div>
                      </td>
                   </tr>
</table>

          
<div class="header_section"><?php _e('Content Settings',APEXNB_TD);?></div>     
<div> 
 <table>
    <tr>
       <td><label for="panel_columns"><?php _e('Choose Content Type',APEXNB_TD)?></label>
       <p class="description"><?php _e('Choose Content type.',APEXNB_TD);?></p></td>
       <td><div class="edn-field">
         <select name="edn_open_panel[content_type]" id="content_type" class="apexnb-selection">
             <option value="html_text" <?php if(isset($edn_bar_setting['edn_open_panel']['edn_content_type']) && $edn_bar_setting['edn_open_panel']['edn_content_type']=='html_text'){echo 'selected="selected"';}?>>HTML Text</option>
             <option value="widget" <?php if(isset($edn_bar_setting['edn_open_panel']['edn_content_type']) && $edn_bar_setting['edn_open_panel']['edn_content_type']=='widget'){echo 'selected="selected"';}?>>Widget</option>
         </select>
       </div>
      </td>
    </tr> 
</table>
    
<div class="apexbar-text-opanel-options">
<table>
    <tr>
       <td><label for="panel_columns"><?php _e('HTML Text',APEXNB_TD)?></label>
       <p class="description"><?php _e('Fill html content.',APEXNB_TD);?></p></td>
       <td><div class="edn-field">
         <?php

            $htmlcontent = (isset($edn_bar_setting['edn_open_panel']['edn_content_text']) && $edn_bar_setting['edn_open_panel']['edn_content_text'] != '')?$edn_bar_setting['edn_open_panel']['edn_content_text']:'';
            $settings_data = array('textarea_name' => 'edn_open_panel[text]','media_buttons' => true);
            wp_editor($htmlcontent,'edn-opanel-html-text',$settings_data); 
        ?>
       </div>
      </td>
   </tr>

 <tr>
</table>
</div>

<div class="apexbar-widget-opanel-options">
<table>
                    <tr>
                       <td><label for="panel_columns"><?php _e('Choose Columns',APEXNB_TD)?></label>
                       <p class="description"><?php _e('Choose columns for content display on panel.Maximum of 3 columns is available.',APEXNB_TD);?></p></td>
                       <td><div class="edn-field">
                         <select name="edn_open_panel[edn_panel_columns]" id="panel_columns" class="apexnb-selection">
                             <option value="1" <?php if(isset($edn_bar_setting['edn_open_panel']['edn_panel_columns']) && $edn_bar_setting['edn_open_panel']['edn_panel_columns']=='1'){echo 'selected="selected"';}?>>1</option>
                             <option value="2" <?php if(isset($edn_bar_setting['edn_open_panel']['edn_panel_columns']) && $edn_bar_setting['edn_open_panel']['edn_panel_columns']=='2'){echo 'selected="selected"';}?>>2</option>
                             <option value="3" <?php if(isset($edn_bar_setting['edn_open_panel']['edn_panel_columns']) && $edn_bar_setting['edn_open_panel']['edn_panel_columns']=='3'){echo 'selected="selected"';}?>>3</option>
                         </select>
                       </div>
                      </td>
                   </tr>

                 <tr>
                       <td><label><?php _e('Add Widgets',APEXNB_TD)?></label></td>
                       <td>
                       <div class="edn-field">
                      
                         <input class="button button-secondary edn_add_widgets" type="button" value="Select Widgets">
                       </div>
                      </td>
                   </tr>
                    <?php 

                    if(isset($edn_bar_setting['edn_open_panel']['edn_widgets'])){
                     if(is_array($edn_bar_setting['edn_open_panel']['edn_widgets']) && !empty($edn_bar_setting['edn_open_panel']['edn_widgets'])){ 
                    $style = "";
                    }else{
                      $style = "style='display:none;'";
                    }
                    }else{
                    $style = "style='display:none;'";
                      }?>

                <tr class="edn_listed_widgets" <?php echo $style;?>>
                     <td><label><?php _e('Listed Widgets',APEXNB_TD)?></label></td>
                     <td>
                     <div>
                          <div class="ednpro_save_data" style="display:none;">
                            <img src='<?php echo APEXNB_IMAGE_DIR;?>/ajaxloader.gif'/>
                          <span class="saving_msg"></span>
                          </div>
                         <div class="listed_selected_widgets">
                             <?php 
                               if(isset($edn_bar_setting['edn_open_panel']['edn_widgets'])){
                                if(is_array($edn_bar_setting['edn_open_panel']['edn_widgets']) && !empty($edn_bar_setting['edn_open_panel']['edn_widgets'])){ 
                                    
                              $array_widgets = $edn_bar_setting['edn_open_panel']['edn_widgets'];
                               for($i=0;$i<count($array_widgets['widget_id']);$i++) {
                                  $widget_id = $array_widgets['widget_id'][$i];
                                  $widget_title = $array_widgets['widget_title'][$i];
                                               ?>

                                <div class="ednpro_widget_area ui-sortable" data-title="<?php echo esc_attr( $widget_title  );?>" 
                                data-id="<?php echo esc_attr( $widget_id );?>">
                                <input type="hidden" name="edn_open_panel[edn_widgets][widget_id][]" value="<?php echo esc_attr( $widget_id );?>"/>
                                <input type="hidden" name="edn_open_panel[edn_widgets][widget_title][]" value="<?php echo esc_attr( $widget_title  );?>"/>
                                <div class="widget_area">
                                <div class="widget_title">
                                <span><i class="fa fa-arrows" aria-hidden="true"></i></span>
                                <span class="wptitle"><?php echo esc_attr( $widget_title  );?></div></span>
                                <div class="widget_right_action">
                                <a class="widget-option widget-action" title="<?php echo esc_attr( __("Edit",APEXNB_TD) );?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                </div>
                                </div>
                                <div class="widget_inner"></div>
                                </div>
                                <?php    }
                                }
                               }
 
                             ?>



                         </div>
                         </div>
                     </td>

                </tr>

 </table>
</div>   

</div> 
 </div>


</div>