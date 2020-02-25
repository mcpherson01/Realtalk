<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<div class="edn-icon-adder" style="display: block;">
    <div class="edn-row">
        <div class="edn-add-social-icons">
            <input class="button button-secondary" type="button" value="Add Social Icons" id="edn-show-add-fields"/> 
        </div>
        <div class="edn-social-empty" style="display: none;">
            <div class="edn-row">
                <div class="edn-col-one-third">
                    <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Icon Title',APEXNB_TD)?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-icon-title" placeholder="<?php _e('e.g: facebook',APEXNB_TD);?>"  class="edn-sform-text required" data-error-msg="<?php _e('Please enter the icon title',APEXNB_TD)?>" />
                        </div>
                        <div class="edn-error"></div>
                    </div><!--edn-field-wrapper-->
                </div>       
                <div class="edn-col-one-third edn-hide-in-pre-tpl">
                    <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Icon Size',APEXNB_TD)?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-icon-size" placeholder="<?php _e('e.g: 14px',APEXNB_TD)?>">
                        </div>
                    </div><!--edn-field-wrapper-->
                </div>
                <div class="edn-clear"></div>

            <div class="edn-col-icons">
                <div class="edn-col-one-third edn-hide-in-pre-tpl">
                    <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Select Icon',APEXNB_TD)?></label>
                        <div class="edn-field">
                            <select id="edn_icon_types" class="edn_icon_types apexnb-selection">
                                <option value="available_font_icon" selected="selected"><?php _e('Available Font Icon',APEXNB_TD);?></option>
                                <option value="custom_icon"><?php _e('Custom Icon',APEXNB_TD);?></option>
                                
                            </select>
                        </div>
                    </div><!--edn-field-wrapper-->
                    
                </div>
                <div class="edn-col-one-third customicons" style="display:none;">
                     <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Custom Class Icon',APEXNB_TD)?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-custom-icon" placeholder="<?php _e('e.g: fa fa-home',APEXNB_TD)?>">
                        </div>
                    </div><!--edn-field-wrapper-->
                </div>

                <div class="edn-col-one-third available-icons" style="display:none;">
                    <div class="edn-field-wrapper form-field">
                        <label><?php _e('Font Awesome Icon', APEXNB_TD); ?></label>
                        <div class="edn-field">
                            <input type="hidden" id="edn-font-awesome-icon" data-error-msg="<?php _e('Please choose or fill any one font icon', APEXNB_TD) ?>"/>
                            <input type="button" class="button button-secondary edn-font-icon-chooser" value="<?php _e('Select Icon', APEXNB_TD); ?>"/>
                        </div>
                        <div class="edn-error"></div>
                    </div><!--edn-field-wrapper-->
                </div> 

                </div>
            </div>    
            
            <div class="edn-clear"></div>
            
            <div class="edn-col-one-fourth edn-hide-in-pre-tpl">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Icon Background Color',APEXNB_TD)?></label>
                    <div class="edn-field">
                        <input type="text" id="edn-icon-bg-color" class="edn-color-picker" />
                    </div>
                </div>
            </div>
            <div class="edn-col-one-fourth edn-hide-in-pre-tpl">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Icon Font Color',APEXNB_TD)?></label>
                    <div class="edn-field">
                        <input type="text" id="edn-icon-font-color" class="edn-color-picker" />
                    </div>
                </div>
            </div>
            <div class="edn-col-one-fourth edn-hide-in-pre-tpl">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Icon Background Hover Color',APEXNB_TD)?></label>
                    <div class="edn-field">
                        <input type="text" id="edn-icon-bg-hover-color" class="edn-color-picker" />
                    </div>
                </div>
            </div>
            <div class="edn-col-one-fourth edn-hide-in-pre-tpl">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Icon Font Hover Color',APEXNB_TD)?></label>
                    <div class="edn-field">
                        <input type="text" id="edn-icon-font-hover-color" class="edn-color-picker" />
                    </div>
                </div>
            </div>
            
            <div class="edn-clear"></div>
            
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Icon Link', APEXNB_TD); ?></label>
                    <div class="edn-field">
                        <input type="text" id="edn-icon-link" class="required"  data-error-msg="<?php _e('Please enter the icon link', APEXNB_TD); ?>" placeholder="<?php _e('e.g: https://www.facebook.com/accesspressthemes/',APEXNB_TD);?>"/>
                    </div>
                    <div class="edn-error"></div>
                </div><!--edn-field-wrapper-->
            </div>
            <div class="edn-col-full">
                <div class="edn-well">
                    <div class="edn-field-wrapper edn-form-field">
                        <div class="edn-field">
                            <input class="button button-primary" type="button" value="Add Icons" id="edn-social-add"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--edn-row-->
</div>