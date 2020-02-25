<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<div class="edn-row duration_section">
    <div class="edn-col-full">
        <div class="edn-inner-main-title" id="duration" style="cursor:pointer;">
        <?php _e('Duration to Display Notification Bar', APEXNB_TD); ?>
           <div class="arrow-up" style="display:none;"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
           <div class="arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
        </div>
        <div class="edn-multiple-bar edn-date-base-bar apexnb-main-wrapper-toggle" style="display:none;">
            <?php include_once(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/date-base-bar.php');?> 
        </div>
    </div>
</div>
<div class="edn-row ednpro_nb_bar_designs designs_bar_section">
    <!-- <div class="edn-backend-inner-title"> -->

    <div class="edn-design-options edn-hide-in-pre-tpl">
         <div class="edn-inner-main-title" id="nb-design" style="cursor:pointer;">
          <?php _e('Notification Bars Design', APEXNB_TD);?>
           <div class="arrow-up" style="display:none;"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
           <div class="arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
        </div>

     <div class="edn-design-content apexnb-main-wrapper-toggle" style="display:none;">
        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Background color', APEXNB_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="edn_bg_color" id="edn_bg_color" class="edn-color-picker"/>
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Font color', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="edn_font_color" id="edn_font_color" class="edn-color-picker"/>
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Notification bar font', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <select name="edn_fonts" id="edn-fonts" class="ednfont">
                        <option value="default"><?php _e('Default',APEXNB_TD)?></option>
                        <?php 
                            $edn_fonts = get_option('apexnb_fonts');
                            foreach ($edn_fonts as $fonts) {
                                ?>
                                    <option value="<?php echo $fonts;?>" <?php if($fonts == 'Roboto') echo "selected";?>><?php echo $fonts;?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth edn-font-wrap">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Font Size', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <span class="edn-fz-wrap">
                        <select class="edn-select-font" id="ednsize" onchange="document.getElementById('edn-displayValue').value=this.options[this.selectedIndex].value;">
                    		<?php
                                $sizes = array('10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','30','32','36','48','72');
                                foreach($sizes as $size){
                                    ?>
                                        <option value="<?php echo $size;?>" <?php if($size == '12') echo "selected";?>><?php echo $size;?></option>
                                    <?php
                                }
                            ?>
                    	</select>
                    	<input type="hidden" name="edn_font_size" value="12" id="edn-displayValue" class="edn-dis-value" onfocus="this.select()" />
                     </span>
                </div>
            </div>
        </div>
         <div class="clear"></div>
         <span><?php _e('Custom Bar Preview ',APEXNB_TD);?>:</span>
              <div class="edn-font-demo-wrap" id="edn-label-font-text">
                The Quick Brown Fox Jumps Over The Lazy Dog. 1234567890
                <div class="btn_preview">Click Me</div>
             </div>
        <div class="clear"></div>
   
      <div class="header_section"><?php _e('Button Custom Design',APEXNB_TD);?></div> 
        <p class="description"><?php _e('Set all type of button font, background color, font size, transform and weight.',APEXNB_TD);?></p>
       <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Button Background color', APEXNB_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="cf_bg_color" id="cf_bg_color" class="edn-color-picker" 
                    value="" />
                </div>
            </div>
        </div>
          <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Button Font Color', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="cf_font_color" id="cf_font_color" class="edn-color-picker" 
                    value="" />
                </div>
            </div>
        </div>

        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Button Hover Background Color', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="cf_hover_bg_color" id="cf_hover_bg_color" class="edn-color-picker" 
                    value="" />
                </div>
            </div>
        </div>

        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Button Hover Font Color', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="cf_hover_font_color" id="cf_hover_font_color" class="edn-color-picker" 
                    value="" />
                </div>
            </div>
        </div>


         <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Hyperlink Background color', APEXNB_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="atag_bg_color" id="atag_bg_color" class="edn-color-picker" 
                    value="" />
                        <p class="description"><?php _e('Set Background color for a tag html element.',APEXNB_TD);?></p>
                </div>
            </div>
        </div>
          <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Hyperlink Font Color', APEXNB_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="atag_font_color" id="atag_font_color" class="edn-color-picker" 
                    value="" />
                         <p class="description"><?php _e('Set Font color for a tag html element.',APEXNB_TD);?></p>
                </div>
            </div>
        </div>

         <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Hyperlink Hover Background Color', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="atag_hover_bg_color" id="atag_hover_bg_color" class="edn-color-picker" 
                    value="" />
                        <p class="description"><?php _e('Set Hover background color for a tag html element.',APEXNB_TD);?></p>
                </div>
            </div>
        </div>

        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Hyperlink Hover Font Color', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="atag_hover_font_color" id="atag_hover_font_color" class="edn-color-picker" 
                    value="" />
                    <p class="description"><?php _e('Set Hover font color for a tag html element.',APEXNB_TD);?></p>
                </div>
                </div>
            </div>
        <!-- </div> -->
       <div class="clear"></div>
        <div class="edn-col-one-fourth edn-font-wrap">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Hyperlink Font Size', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <span class="edn-fz-wrap">
                        <select class="edn-select-font" id="atag_font_size" name="atag_font_size">
                            <?php
                                $atagfontsizes = array('10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','30','32','36','48','72');
                                foreach($atagfontsizes as $btnsize){
                                    ?>
                                        <option value="<?php echo $btnsize;?>"><?php echo $btnsize;?></option>
                                    <?php
                                }
                            ?>
                        </select>
                         <p class="description"><?php _e('Set font size for a tag html element.',APEXNB_TD);?></p>
                     </span>
                </div>
            </div>
        </div>

    <div class="edn-col-one-fourth edn-font-wrap">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Button Font Size', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <span class="edn-fz-wrap">
                        <select class="edn-select-font" id="ednbtnsize" name="edn_button_font_size">
                            <?php
                                $bsizes = array('10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','30','32','36','48','72');
                                foreach($bsizes as $btnsize){
                                    ?>
                                        <option value="<?php echo $btnsize;?>"<?php if(isset($edn_bar_setting['edn_button_font_size']) && $edn_bar_setting['edn_button_font_size']==$btnsize){echo 'selected="selected"';}?>><?php echo $btnsize;?></option>
                                    <?php
                                }
                            ?>
                        </select>
                     </span>
                </div>
            </div>
        </div>
         <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Button Transform', APEXNB_TD) ?></label>
                <div class="edn-field">
                 <select name="edn_btn_transform" class="apexnb_transform apexnb-selection">
                   <option value="normal" <?php echo (isset($edn_bar_setting['edn_btn_transform']) && $edn_bar_setting['edn_btn_transform'] == 'normal')?'selected="selected"':'';?>><?php _e('Normal',APEXNB_TD);?></option>
                   <option value="capitalize" <?php echo (isset($edn_bar_setting['edn_btn_transform']) && $edn_bar_setting['edn_btn_transform'] == 'capitalize')?'selected="selected"':'';?>><?php _e('Capitalize',APEXNB_TD);?></option>
                   <option value="uppercase" <?php echo (isset($edn_bar_setting['edn_btn_transform']) && $edn_bar_setting['edn_btn_transform'] == 'uppercase')?'selected="selected"':'';?>><?php _e('Uppercase',APEXNB_TD);?></option>
                   <option value="lowercase" <?php echo (isset($edn_bar_setting['edn_btn_transform']) && $edn_bar_setting['edn_btn_transform'] == 'lowercase')?'selected="selected"':'';?>><?php _e('Lowercase',APEXNB_TD);?></option>
                  </select>
                </div>
            </div>
        </div>
       
          <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Button Font Weight', APEXNB_TD) ?></label>
                <div class="edn-field">
                    <select name="edn_btn_font_weight" class="apexnb-selection">
                   <option value="normal" <?php echo (isset($edn_bar_setting['edn_btn_font_weight']) && $edn_bar_setting['edn_btn_font_weight'] == 'normal')?'selected="selected"':'';?>><?php _e('Normal(400)',APEXNB_TD);?></option>
                   <option value="bold" <?php echo (isset($edn_bar_setting['edn_btn_font_weight']) && $edn_bar_setting['edn_btn_font_weight'] == 'bold')?'selected="selected"':'';?>><?php _e('Bold(700)',APEXNB_TD);?></option>
                   <option value="light" <?php echo (isset($edn_bar_setting['edn_btn_font_weight']) && $edn_bar_setting['edn_btn_font_weight'] == 'light')?'selected="selected"':'';?>><?php _e('Light(300)',APEXNB_TD);?></option>
                </select>
                </div>
            </div>
        </div>
  <div class="clear"></div>
      <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Close Button Background Color', APEXNB_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="close_bg_color" id="close_bg_color" class="edn-color-picker" 
                    value="" />
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Close Button Font Color', APEXNB_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="close_font_color" id="close_font_color" class="edn-color-picker" 
                    value="" />
                </div>
            </div>
        </div>
       

     <div class="clear"></div>

     <div class="header_section"><?php _e('Description & Read More Button Custom Design',APEXNB_TD);?></div> 
     
        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Description Font Color', APEXNB_TD) ?></label>
                <div class="edn-field">
                    <input type="text" name="edn_content_color" id="edn_content_color" class="edn-color-picker" 
                    value="" />
                       <p class="edn-note"><?php _e('Choose description font size and description font color for Opt In Subscribe form.',APEXNB_TD);?></p>
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth edn-font-wrap">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
               <label><?php _e('Description Font Size', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <span class="edn-fz-wrap">
                        <select class="edn-select-font" id="edn_content_size" 
                        onchange="document.getElementById('edn_subscribe_fontsize').value=
                        this.options[this.selectedIndex].value;">
                            <?php
                                $sizes = array('10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','30','32','36','48','72');
                                foreach($sizes as $size){
                                    ?>
                                        <option value="<?php echo $size;?>"><?php echo $size;?></option>
                                    <?php
                                }
                            ?>
                        </select>
                       <input type="hidden" name="edn_content_size" value="12" id="edn_subscribe_fontsize" 
                       class="edn-dis-value" onfocus="this.select()" />
                     </span>
                   
                </div>
            </div>
        </div>
            <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Header Text Transform', APEXNB_TD) ?></label>
                <div class="edn-field">
                 <select name="edn_subscribe_header_transform" class="apexnb_transform apexnb-selection">
                   <option value="normal" <?php echo (isset($edn_bar_setting['edn_subscribe_header_transform']) && $edn_bar_setting['edn_subscribe_header_transform'] == 'normal')?'selected="selected"':'';?>><?php _e('Normal',APEXNB_TD);?></option>
                   <option value="capitalize" <?php echo (isset($edn_bar_setting['edn_subscribe_header_transform']) && $edn_bar_setting['edn_subscribe_header_transform'] == 'capitalize')?'selected="selected"':'';?>><?php _e('Capitalize',APEXNB_TD);?></option>
                   <option value="uppercase" <?php echo (isset($edn_bar_setting['edn_subscribe_header_transform']) && $edn_bar_setting['edn_subscribe_header_transform'] == 'uppercase')?'selected="selected"':'';?>><?php _e('Uppercase',APEXNB_TD);?></option>
                   <option value="lowercase" <?php echo (isset($edn_bar_setting['edn_subscribe_header_transform']) && $edn_bar_setting['edn_subscribe_header_transform'] == 'lowercase')?'selected="selected"':'';?>><?php _e('Lowercase',APEXNB_TD);?></option>
                  </select>
                  <p class="description"><?php _e('Set header text transform and font weight for all h1,h2,h3,h4,h5,h6 tag such as for subscribe form header text.',APEXNB_TD);?></p>
                </div>
            </div>
        </div>
         <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Header Font Weight', APEXNB_TD) ?></label>
                <div class="edn-field">
                    <select name="edn_subscribe_header_font_weight" class="apexnb-selection">
                   <option value="normal" <?php echo (isset($edn_bar_setting['edn_subscribe_header_font_weight']) && $edn_bar_setting['edn_subscribe_header_font_weight'] == 'normal')?'selected="selected"':'';?>><?php _e('Normal(400)',APEXNB_TD);?></option>
                   <option value="bold" <?php echo (isset($edn_bar_setting['edn_subscribe_header_font_weight']) && $edn_bar_setting['edn_subscribe_header_font_weight'] == 'bold')?'selected="selected"':'';?>><?php _e('Bold(700)',APEXNB_TD);?></option>
                   <option value="light" <?php echo (isset($edn_bar_setting['edn_subscribe_header_font_weight']) && $edn_bar_setting['edn_subscribe_header_font_weight'] == 'light')?'selected="selected"':'';?>><?php _e('Light(300)',APEXNB_TD);?></option>
                </select>
                </div>
            </div>
        </div>
  <div class="clear"></div>

        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Read More Link Font Color', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="read_more_fcolor" id="read_more_fcolor" class="edn-color-picker" value="" />
               <p class="edn-note"><?php _e('Configure Font Color and Background For Read more link button.',APEXNB_TD);?></p>
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Read More Link Background Color', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="read_more_bgcolor" id="read_more_bgcolor" class="edn-color-picker" 
                    value="" />
             
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Success Message Font Color', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="success_font_color" id="success_font_color" class="edn-color-picker" 
                    value="" />
                     <p class="edn-note"><?php _e('Configure Font Color for all  success and error message for notification bar.',APEXNB_TD);?></p>
                </div>
            </div>
        </div>
          <div class="edn-col-one-fourth">
            <div class="edn-field-wrapper edn-design-reference edn-form-field">
                <label><?php _e('Error Message Font Color', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="error_font_color" id="error_font_color" class="edn-color-picker" 
                    value="" />
                </div>
            </div>
        </div>
          <div class="edn-clear"></div>

        
</div>
</div>

    <div class="edn-design-options ednpro_nb_bar_designs position_section">
       <div class="edn-inner-main-title" id="position" style="cursor:pointer;">
                    <?php _e('Notification Bar Position', APEXNB_TD);?>
                     <div class="arrow-up" style="display:none;"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
                       <div class="arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
        </div>
      <div class="edn-position-content apexnb-main-wrapper-toggle clearfix" style="display:none;">          
       <div class="apexnb-left-bar-section clearfix">
            <div class="edn-col-one-fourth">
                <div class="edn-field-wrapper edn-form-field ednpro_nb_bar_designs">
                    <div class="edn-field">
                     <label><?php _e('Notification bar position', APEXNB_TD) ?></label>
                        <select name="edn_position" id="edn-positions" class="edn-position apexnb-selection">              
                            <option value="top"><?php _e('Top Fixed',APEXNB_TD)?></option>
                            <option value="top_absolute" selected="selected"><?php _e('Top Absolute',APEXNB_TD)?></option>
                            <option value="bottom"><?php _e('Bottom',APEXNB_TD)?></option>
                            <option value="left"><?php _e('Left',APEXNB_TD)?></option>
                            <option value="right"><?php _e('Right',APEXNB_TD)?></option>
                        </select>
                          <p class="description"><?php _e('Note:Top Fixed is always visible at top of page and Top Absolute means notification bar will scroll out of view when page is scrolled.', APEXNB_TD); ?></p>
                    </div>
                </div>
            </div>
          </div>
  
        <div class="edn-row edn-position-template">
                   <div class="edn-preview">   
                     <?php 
                       $types = array('top','top_absolute','bottom','left','right');
                                foreach($types as $type){
                                 ?>
                       <div class="edn-position-preview" id="edn-positon-<?php echo $type;?>" style="display:none;">
                       <div class="edn-backend-inner-title"><?php _e('Notification Bar Position Preview: '.ucwords(str_replace('_', ' ',$type)), APEXNB_TD); ?></div>
                                <img src="<?php echo APEXNB_IMAGE_DIR . '/'.$type.'.jpg' ?>" alt="position preview" />
                        </div>
                          <?php
                       } ?>
                   
                  </div>
         </div>
         <div class="edn-row edn-position-template1">
                  <div class="edn-col-one-fourth">
                    <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Notification bar visibility', APEXNB_TD) ?></label>
                        <div class="edn-field">
                            <select name="edn_visibility" id="edn-visibilities" class="edn-visibility apexnb-selection">
                                <option value="sticky"><?php _e('Always Show',APEXNB_TD)?></option>
                                <option value="show-time"><?php _e('Show After some time',APEXNB_TD)?></option>
                                <option value="hide-time"><?php _e('Hide after some time',APEXNB_TD)?></option>
                                <option value="show-on-click"><?php _e('Show Bar On Click',APEXNB_TD)?></option>
                            </select>
                              <div class="edn-show-click-options">
                                 <div class="edn-col edn-show-click-showtime" style="display:none;">
                                  <label>Button Unique ID:</label>
                                  <div class="edn-field">
                                   <input type="text" placeholder="#clickbuttonid" name="edn_visibility_click_btn_id" value=""/>
                                    <p class="edn-note"><?php _e('Set the unique button or link html id attribute value here in order to work dynamically click event to open this notification bar. Note: Use # before ID attribute value.',APEXNB_TD);?></p>
                                  </div>
                                </div>
                            </div>
                            <div class="edn-time">
                                <div class="edn-col edn-visibility-showtime" style="display:none;">
                                  <label><?php _e('Show Time Duration',APEXNB_TD)?></label>
                                  <div class="edn-field">
                                  <input type="text" name="edn_visibility_show_duration" value=""/>
                                <p class="edn-note"><?php _e('Time Duration In milliseconds',APEXNB_TD);?></p>
                                  </div>
                                </div>
                                 <div class="edn-col edn-visibility-hidetime" style="display:none;">
                                  <label><?php _e('Hide Time Duration',APEXNB_TD)?></label>
                                  <div class="edn-field">
                                  <input type="text" name="edn_visibility_hide_duration" value=""/>
                                    <p class="edn-note"><?php _e('Time Duration In milliseconds',APEXNB_TD);?></p>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="edn-col-one-fourth" style="width: 32%;">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Notification bar Close Button', APEXNB_TD) ?></label>
                    <div class="edn-field">
                        <select name="edn_close_button" id="edn-close-button" class="edn-close-button apexnb-selection">           
                            <option value="disable"><?php _e('Disable',APEXNB_TD)?></option>
                            <option value="show-hide"><?php _e('Show/Hide',APEXNB_TD)?></option>
                            <option value="user-can-close"><?php _e('User Can Close',APEXNB_TD)?></option>
                        </select>
                    </div>
               
               <div class="edn_close_once" style="display:none;">
                <label for="show_once"><?php _e('Show only Once?', APEXNB_TD) ?></label>
                   <input type="checkbox" name="show_once" id="show_once" value="1"/>
                     <p class="edn-note"><?php _e('Note: Check to enable to display only once after user close.',APEXNB_TD);?></p>
                </div>
                <div class="duration_time" style="display:none;">
                     <div class="edn-field">
                        <input type="number" min="1" name="duration_show_once" id="duration_show_once" value=""/>
                        <p class="edn-note"><?php _e('Note:Duration to hide in second.Minimum time required is 10 seconds.',APEXNB_TD);?></p>
                     </div>
                </div>

                 <div class="edn_show_hide" style="display:none;">
                    <label><?php _e('Show only Once?', APEXNB_TD) ?></label>
                     <input type="checkbox" name="show_once_hideshow" id="show_once_hideshow" value="1"/>
                     <p class="description"><?php _e('Note: Check to enable to display only once after user show hide but toggle function works.',APEXNB_TD);?></p>
                 </div>

            </div>
          </div>
          <div class="edn-col-one-fourth" style="width: 35%;">
                  <div class="edn-field-wrapper edn-form-field">
                  <div class="edn-field">
                   
                        <label for="show_once_loggedusers"><?php _e('Show Only Once For Logged In Users?', APEXNB_TD) ?></label>
                         <div class="apexnb-switch">
                           <input type="checkbox" name="show_once_loggedusers" id="show_once_loggedusers" value="1"/>
                             <label for="show_once_loggedusers"></label>
                           </div>
                         
                          <p class="edn-note"><?php _e('Note:On check this button, Check to enable hide notification bar forever on click close button once or on 
                             dismiss toggle button once by logged-in Users.',APEXNB_TD);?>
                          <?php _e('To reset this button enabled for all notification bar, simply go to below link on tab General Settings and Click on Reset Button.',APEXNB_TD);?>
                           <a href="<?php echo admin_url('admin.php?page=apexnb-settings');?>" target="_blank"><?php _e('General Settings');?></a></p>
                     
                       </div>
                 </div>
            </div> 
         <div class="edn-col-one-fourth" style="width: 35%;">
              <div class="edn-field-wrapper edn-form-field">
              <div class="edn-field">
               
                    <label for="enbale_snowflakes"><?php _e('Enable Snowflakes', APEXNB_TD) ?></label>
                     <div class="apexnb-switch">
                       <input type="checkbox" name="enbale_snowflakes" id="enbale_snowflakes" value="1"/>
                         <label for="enbale_snowflakes"></label>
                       </div>
                     
                      <p class="description"><?php _e('Enable Snowflakes for this notification bar and open panel if displayed on frontend.',APEXNB_TD);?></p>
                   </div>
             </div>
          </div>

            <div class="edn-col-one-fourth close_tb_position">
                    <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Close Button Position', APEXNB_TD) ?></label>
                        <div class="edn-field">
                            <select name="closebtn_position" id="edn-close-btn-position" class="edn-close-btn-position apexnb-selection">
                                <option value="right"><?php _e('Right',APEXNB_TD)?></option>
                                <option value="left"><?php _e('Left',APEXNB_TD)?></option>
                            </select>
                             <p class="description"><?php _e('Set Position for close button for top,top absolute and bottom notification bar.', APEXNB_TD)?></p>
                        </div>
                    </div>
                 </div>
              </div>
         </div>



      </div> 
              
        </div>

      
    <!-- </div> -->
<?php #include_once('/../custom_support.php');?>
  <?php include_once(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/custom_support.php');?> 
</div>