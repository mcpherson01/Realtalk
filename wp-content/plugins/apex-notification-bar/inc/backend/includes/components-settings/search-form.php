     <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                         
                                <div class="edn-field">
                                        <div class="edn-field-label-wrap"> 
                                          <label><?php _e('Search Form Layout',APEXNB_TD);?>
                                          </label>
                                        <p class="edn-note"><?php _e('Choose search form layout.',APEXNB_TD)?></p>
                                       </div>
                                        <div class="edn-field-input-wrap">
                                        <select name="edn_search_form[layout_type]" class="apex_searchlayout apexnb-selection">
                                         <option value="layout1" <?php if(isset($edn_bar_setting['edn_search_form']['layout_type']) && $edn_bar_setting['edn_search_form']['layout_type'] == "layout1") echo "selected='selected'";?>><?php _e('Layout1',APEXNB_TD);?></option>
                                         <option value="layout2" <?php if(isset($edn_bar_setting['edn_search_form']['layout_type']) && $edn_bar_setting['edn_search_form']['layout_type'] == "layout2") echo "selected='selected'";?>><?php _e('Layout2',APEXNB_TD);?></option>
                                         <option value="layout3" <?php if(isset($edn_bar_setting['edn_search_form']['layout_type']) && $edn_bar_setting['edn_search_form']['layout_type'] == "layout3") echo "selected='selected'";?>><?php _e('Layout3',APEXNB_TD);?></option>
                                         <option value="layout4" <?php if(isset($edn_bar_setting['edn_search_form']['layout_type']) && $edn_bar_setting['edn_search_form']['layout_type'] == "layout4") echo "selected='selected'";?>><?php _e('Layout4',APEXNB_TD);?></option>
                                         <option value="layout5" <?php if(isset($edn_bar_setting['edn_search_form']['layout_type']) && $edn_bar_setting['edn_search_form']['layout_type'] == "layout5") echo "selected='selected'";?>><?php _e('Layout5',APEXNB_TD);?></option>
                                       
                                       </select>
                                  
                                     </div>
                                </div>
                            </div>
                        </div>
                     <div class="preview-search apexbar-bpreview" style="display:none;">
                         <div id="search_layout1" class="preview_image_search">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/search-layout1.JPG"/>
                         </div>
                         <div id="search_layout2" class="preview_image_search">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/search-layout2.JPG"/>
                         </div>
                         <div id="search_layout3" class="preview_image_search">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/search-layout3.JPG"/>
                         </div>
                         <div id="search_layout4" class="preview_image_search">
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/search-layout4.JPG"/>
                         </div>
                         <div id="search_layout5" class="preview_image_search">
                            <h4>Without Background Image:</h4>
                             <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/search-layout5.JPG"/>
                           
                              <h4>With Background Image:</h4>
                              <img src="<?php echo APEXNB_IMAGE_DIR;?>/preview/search-layout11.jpg"/>
                         </div>
                          
                      </div>

   <div class="clear"></div>
                      
    <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
         <div class="edn-field">
             <div class="edn-field-label-wrap">
               <label><?php _e('Description',APEXNB_TD)?></label>
                <p class="edn-note"><?php _e('Fill description for search form.',APEXNB_TD);?></p>
                </div>
              <div class="edn-field-input-wrap">
                <textarea name="edn_search_form[description]"><?php if(isset($edn_bar_setting['edn_search_form']['description'])){echo esc_attr($edn_bar_setting['edn_search_form']['description']);}?></textarea>
               </div>
            </div>
        </div><!--edn-field-wrapper-->
     </div>  
     <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field">
                 <div class="edn-field-label-wrap">
                <label><?php _e('Search Input Field Placeholder',APEXNB_TD)?></label>
                </div>
                 <div class="edn-field-input-wrap">
                    <input type="text" name="edn_search_form[input_placeholder]"
                     value="<?php if(isset($edn_bar_setting['edn_search_form']['input_placeholder'])){echo esc_attr($edn_bar_setting['edn_search_form']['input_placeholder']);}?>" placeholder="<?php _e('Type Here..',APEXNB_TD);?>"/>
                </div>
            </div>
        </div><!--edn-field-wrapper-->
     </div>   
        <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
           <div class="edn-field">
               <div class="edn-field-label-wrap">
                    <label for="edn_sfhide_button_text"><?php _e('Hide Search Button Text',APEXNB_TD)?></label>
                    <p class="edn-note"><?php _e('Check True to hide button text on search button to display only icon.',APEXNB_TD);?></p>
               </div>
             <div class="edn-field-input-wrap">
               <div class="apexnb-switch">
               <input type="checkbox" id="edn_sfhide_button_text" name="edn_search_form[hide_button_text]" value="1" <?php if(isset($edn_bar_setting['edn_search_form']['hide_button_text']) && $edn_bar_setting['edn_search_form']['hide_button_text'] == 1) echo 'checked="checked"'; ?>/>
                 <label for="edn_sfhide_button_text"></label>
               </div>
              </div>
            </div>
        </div><!--edn-field-wrapper-->
     </div> 
       <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
           <div class="edn-field">
               <div class="edn-field-label-wrap">
                    <label for="edn_sfhide_icon"><?php _e('Hide Icon',APEXNB_TD)?></label>
                    <p class="edn-note"><?php _e('Check True to hide icon on search layout.',APEXNB_TD);?></p>
               </div>
             <div class="edn-field-input-wrap">
               <div class="apexnb-switch">
               <input type="checkbox" id="edn_sfhide_icon" name="edn_search_form[hide_icon]" value="1" <?php if(isset($edn_bar_setting['edn_search_form']['hide_icon']) && $edn_bar_setting['edn_search_form']['hide_icon'] == 1) echo 'checked="checked"'; ?>/>
                 <label for="edn_sfhide_icon"></label>
               </div>
              </div>
            </div>
        </div><!--edn-field-wrapper-->
     </div> 
        <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
           <div class="edn-field">
            <div class="edn-field-label-wrap">
               <label><?php _e('Button Text',APEXNB_TD)?></label>
            </div>
            <div class="edn-field-input-wrap">
              
                <input type="text" name="edn_search_form[button_name]"
                 value="<?php if(isset($edn_bar_setting['edn_search_form']['button_name'])){echo esc_attr($edn_bar_setting['edn_search_form']['button_name']);}?>" placeholder="<?php _e('Search',APEXNB_TD);?>"/>
             
             </div>
              </div>
        </div><!--edn-field-wrapper-->
     </div>  

       <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
          <div class="edn-field">
              <div class="edn-field-label-wrap">
               <label><?php _e('Search Font Icon',APEXNB_TD)?></label>
               <p class="description"><?php _e('Set custom font icons here to display before button name.',APEXNB_TD);?></p>
               </div>
             <div class="edn-field-input-wrap">
                <input type="text" name="edn_search_form[font_icon]"
                 value="<?php if(isset($edn_bar_setting['edn_search_form']['font_icon'])){echo esc_attr($edn_bar_setting['edn_search_form']['font_icon']);}?>" placeholder="<?php _e('fa fa-search',APEXNB_TD);?>"/>
                </div>
            </div>
        </div><!--edn-field-wrapper-->
     </div>

      <div class="edn-custom-hide">
                 <div class="edn-inner-main-title"><?php _e('Search Form Custom Design Layout',APEXNB_TD);?></div>
                       <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Description Font Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_search_form[desccolor]"
                                     value="<?php if(isset($edn_bar_setting['edn_search_form']['desccolor'])){echo esc_attr($edn_bar_setting['edn_search_form']['desccolor']);}?>" />
                                 <p class="description"><?php _e('Set description font color for search layout.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                          <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Button Background Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_search_form[bg_color]"
                                     value="<?php if(isset($edn_bar_setting['edn_search_form']['bg_color'])){echo esc_attr($edn_bar_setting['edn_search_form']['bg_color']);}?>" />
                                 <p class="description"><?php _e('Set search button background color.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                          <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Button Background Hover Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_search_form[bg_hover_color]"
                                     value="<?php if(isset($edn_bar_setting['edn_search_form']['bg_hover_color'])){echo esc_attr($edn_bar_setting['edn_search_form']['bg_hover_color']);}?>" />
                                 <p class="description"><?php _e('Set search button background hover color.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                           <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Button Font Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_search_form[btnfont_color]"
                                     value="<?php if(isset($edn_bar_setting['edn_search_form']['btnfont_color'])){echo esc_attr($edn_bar_setting['edn_search_form']['btnfont_color']);}?>" />
                                 <p class="description"><?php _e('Set search button font color.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                          <div class="clear"></div>
                         <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Button Font Hover Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_search_form[btnfont_hover_color]"
                                     value="<?php if(isset($edn_bar_setting['edn_search_form']['btnfont_hover_color'])){echo esc_attr($edn_bar_setting['edn_search_form']['btnfont_hover_color']);}?>" />
                                 <p class="description"><?php _e('Set search button font hover color.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                          <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Icon Font Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_search_form[icon_fontcolor]"
                                     value="<?php if(isset($edn_bar_setting['edn_search_form']['icon_fontcolor'])){echo esc_attr($edn_bar_setting['edn_search_form']['icon_fontcolor']);}?>" />
                                 <p class="description"><?php _e('Set search icon font color.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>

                         <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Input Border Color',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="text" class="edn-color-picker" name="edn_search_form[input_border_color]"
                                     value="<?php if(isset($edn_bar_setting['edn_search_form']['input_border_color'])){echo esc_attr($edn_bar_setting['edn_search_form']['input_border_color']);}?>" />
                                 <p class="description"><?php _e('Set search input field border color.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                         
                          <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Description Font Size',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="number" name="edn_search_form[desc_fontsize]"
                                     value="<?php if(isset($edn_bar_setting['edn_search_form']['desc_fontsize'])){echo esc_attr($edn_bar_setting['edn_search_form']['desc_fontsize']);}?>" />
                                <p class="description"><?php _e('Set description font size in px.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                        <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Button Font Size',APEXNB_TD)?></label>
                                <div class="edn-field">
                                    <input type="number" name="edn_search_form[btn_fontsize]"
                                     value="<?php if(isset($edn_bar_setting['edn_search_form']['btn_fontsize'])){echo esc_attr($edn_bar_setting['edn_search_form']['btn_fontsize']);}?>" />
                                <p class="description"><?php _e('Set button font size in px.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>
                           
                           <div class="edn-col-one-fourth edn-font-wrap">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Button Font Transform',APEXNB_TD)?></label>
                                <div class="edn-field">
                               <select name="edn_search_form[btn_transform]" class="apexnb-selection">
                                   <option value="normal" <?php echo (isset($edn_bar_setting['edn_search_form']['btn_transform']) && $edn_bar_setting['edn_search_form']['btn_transform'] == 'normal')?'selected="selected"':'';?>><?php _e('Normal',APEXNB_TD);?></option>
                                   <option value="capitalize" <?php echo (isset($edn_bar_setting['edn_search_form']['btn_transform']) && $edn_bar_setting['edn_search_form']['btn_transform'] == 'capitalize')?'selected="selected"':'';?>><?php _e('Capitalize',APEXNB_TD);?></option>
                                   <option value="uppercase" <?php echo (isset($edn_bar_setting['edn_search_form']['btn_transform']) && $edn_bar_setting['edn_search_form']['btn_transform'] == 'uppercase')?'selected="selected"':'';?>><?php _e('Uppercase',APEXNB_TD);?></option>
                                   <option value="lowercase" <?php echo (isset($edn_bar_setting['edn_search_form']['btn_transform']) && $edn_bar_setting['edn_search_form']['btn_transform'] == 'lowercase')?'selected="selected"':'';?>><?php _e('Lowercase',APEXNB_TD);?></option>
                                </select>
                                   
                                 <p class="description"><?php _e('choose button font transform.',APEXNB_TD);?></p>
                                </div>
                            </div><!--edn-field-wrapper-->
                         </div>  
                </div>     
<div class="clear"></div>
