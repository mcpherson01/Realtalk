<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
 <div class="edn-col-full edn_nb_title">
        <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field">
            <div class="edn-field-label-wrap apex-header"><label class="edn_labelname"><?php _e('Name of Bar', APEXNB_TD); ?></label></div>
            <div class="edn-field-input-wrap apex-main-title">
                <div class="ednbar_name">
                    <input type="text" name="edn_bar_name" value="<?php if(isset($edn_bar->edn_bar_name)){ echo esc_attr($edn_bar->edn_bar_name); }?>" data-error-msg="<?php _e('Please enter the notification bar name',APEXNB_TD);?>" /> *
                    <div class="edn-error" id="edn-error-name"></div>
                    <input type="hidden" class="edn-hidden-bar-name" value="<?php echo esc_attr($edn_bar->edn_bar_name);?>" />
                </div>
            </div>
            </div>
        </div><!--edn-field-wrapper-->
    </div>

<div class="edn-row">
    <div class="edn-col-full layout_section">
        <div class="edn-group-chooser">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-inner-main-title" id="layout" style="cursor:pointer;">
                <?php _e('Notification Bar Layout', APEXNB_TD); ?>
                        <div class="arrow-up" style="display:none;"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
                         <div class="arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                </div>
                <div class="edn-bar-template apexnb-main-wrapper-toggle" style="display:none;">
                 <p class="description"><?php _e('Choose either pre available template or custom template in order to display
                      notification bar with your own custom designs.', APEXNB_TD); ?></p>
                <div class="edn-field choose-edn-bar">
                    <label class="edn-label-inline">
                        <input type="radio" name="edn_bar_type" value="2" <?php if($edn_bar_setting['edn_bar_type']==2){echo 'checked="checked"';}?> />
                        <?php _e('Pre Available Template', APEXNB_TD); ?>
                    </label>
                    <label class="edn-label-inline">
                        <input type="radio" name="edn_bar_type" id="edn_individual" value="1" <?php if($edn_bar_setting['edn_bar_type']==1){echo 'checked="checked"';}?> />
                        <?php _e('Custom Design', APEXNB_TD); ?>
                    </label>
                   
                </div>
                <?php include_once(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/bar-template.php');?>
                </div>
            </div>
        </div>
    </div>
</div><!-- Edn .edn-row -->



<!-- Logo Image Section -->
<div class="edn-row">
    <div class="edn-col-full logo_section">
        <div class="edn-group-chooser">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-inner-main-title" id="logo_setup" style="cursor:pointer;">
                <?php _e('Logo Section', APEXNB_TD); ?>
                        <div class="arrow-up" style="display:none;"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
                         <div class="arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                </div>
                <div class="apexnb-main-wrapper-toggle apexnb-logo-image" style="display:none;">
                  <p class="description"><?php _e('Note: Please activate Enable Logo Section button in order to display logo on first section i.e on left corner side. This section is fixed for notification bars.', APEXNB_TD); ?></p>
                    <div class="edn-field">
                            <div class="edn-field-label-wrap">
                              <label for="activelogo"><?php _e("Enable Logo Section", APEXNB_TD) ?></label>
                            </div>
                            <div class="edn-field-input-wrap">
                                <div class="apexnb-switch">
                                  <input type='checkbox' id="activelogo" name='edn_logo_section[enable_logo]' value='true' <?php echo checked($edn_bar_setting['edn_logo_section']['enable_logo'],'true', false ); ?>/>
                                  <label for="activelogo"></label>
                                </div>
                            </div>
                    
                    </div>
                      <div class="edn-field">
                              <div class="edn-field-label-wrap">
                                 <label for="uploadlogo"><?php _e("Upload Logo Image", APEXNB_TD) ?></label>
                               </div>
                               <div class="edn-field-input-wrap">
                                    <div class="apexnb-img-bgwrap">
                                    <input type="url" name="edn_logo_section[image_url]" class="apexnb-logo-image-url apexnb-fixed-width" 
                                    value="<?php if(isset($edn_bar_setting['edn_logo_section']['image_url'])){echo esc_url($edn_bar_setting['edn_logo_section']['image_url']);}?>" />
                                    <input type="button" class="apexnb_logoimage_url_button button button-primary"  value="Upload Logo Image" size="25"/> 
                                        
                                        <div class="apexnb-option-field apexnb-image-preview" <?php if(empty($edn_bar_setting['edn_logo_section']['image_url'])) { ?> style="display:none;" <?php } ?>>
                                          <img  class="apexnb-image" src="<?php if(isset($edn_bar_setting['edn_logo_section']['image_url'])){echo esc_url($edn_bar_setting['edn_logo_section']['image_url']);}?>" alt=""  width="250">
                                        </div>
                                    </div> 
                                      <p class="description"><?php _e('Upload logo image here.', APEXNB_TD); ?></p>
                                </div>
                     </div>
                        <div class="edn-field">
                            <div class="edn-field-label-wrap">
                               <label for="url_link"><?php _e("URL LINK", APEXNB_TD) ?></label>
                            </div>
                             <div class="edn-field-input-wrap">
                                <input type="text" class="apexnb-fixed-width"  name="edn_logo_section[url_link]" placeholder="https://www.accesspressthemes.com" value="<?php if(isset($edn_bar_setting['edn_logo_section']['url_link'])){echo esc_url($edn_bar_setting['edn_logo_section']['url_link']);}?>" /> 
                                  <p class="description"><?php _e('Fill the valid url link starts from https://', APEXNB_TD); ?></p>
                              </div> 
                         </div>

                    <div class="edn-field clearfix">
                         <div class="edn-field-label-wrap">
                           <label for="url_target"><?php _e("URL Target", APEXNB_TD) ?></label>
                          </div>

                        <div class="edn-field-input-wrap">
                            <select name="edn_logo_section[link_target]" class="apexnb-selection">
                              <option value="_self" <?php if(isset($edn_bar_setting['edn_logo_section']['link_target']) && $edn_bar_setting['edn_logo_section']['link_target']=='_self'){echo 'selected="selected"';}?>><?php _e('_self',APEXNB_TD);?></option>
                         <option value="_blank" <?php if(isset($edn_bar_setting['edn_logo_section']['link_target']) && $edn_bar_setting['edn_logo_section']['link_target']=='_blank'){echo 'selected="selected"';}?>><?php _e('_blank',APEXNB_TD);?></option>
                         <option value="_parent" <?php if(isset($edn_bar_setting['edn_logo_section']['link_target']) && $edn_bar_setting['edn_logo_section']['link_target']=='_parent'){echo 'selected="selected"';}?>><?php _e('_parent',APEXNB_TD);?></option>
                         <option value="_top" <?php if(isset($edn_bar_setting['edn_logo_section']['link_target']) && $edn_bar_setting['edn_logo_section']['link_target']=='_top'){echo 'selected="selected"';}?>><?php _e('_top',APEXNB_TD);?></option>
                            </select>
                             <p class="description"><?php _e('Set Link Target.', APEXNB_TD); ?></p>
                        </div>
                    </div>
          
                    <div class="edn-field clearfix">
                         <div class="edn-field-label-wrap">
                            <label for="image_width"><?php _e("Image Width", APEXNB_TD) ?></label>
                         </div>
                         <div class="edn-field-input-wrap">
                             <input type="number" name="edn_logo_section[image_width]" value="<?php if(isset($edn_bar_setting['edn_logo_section']['image_width'])){echo esc_attr($edn_bar_setting['edn_logo_section']['image_width']);}?>" /> 
                         <p class="description"><?php _e('Set Custom Image Width in pixel.', APEXNB_TD); ?></p>
                         </div> 
                    </div>
                    
                   
                    <div class="edn-field">
                       <div class="edn-field-label-wrap">
                            <label for="image_height"><?php _e("Image Height", APEXNB_TD) ?></label>
                        </div>
                         <div class="edn-field-input-wrap">
                               <input type="number" name="edn_logo_section[image_height]" value="<?php if(isset($edn_bar_setting['edn_logo_section']['image_height'])){echo esc_attr($edn_bar_setting['edn_logo_section']['image_height']);}?>" />
                          <p class="description"><?php _e('Set Custom Image Width in pixel.', APEXNB_TD); ?></p>
                         </div>
                    </div>
                  
                
                </div>
            </div>
        </div>
    </div>
</div><!-- Edn .edn-row -->
<!-- Logo Image Section End -->

    <!-- Background Image Section -->
<div class="edn-row apexnb_background_image_toggle">
    <div class="edn-col-full logo_section">
        <div class="edn-group-chooser">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-inner-main-title" id="background-image-setup" style="cursor:pointer;">
                <?php _e('Background Image Section', APEXNB_TD); ?>
                        <div class="arrow-up" style="display:none;"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
                         <div class="arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                </div>
                <div class="apexnb-main-wrapper-toggle apexnb-background-image" style="display:none;">
                    <div class="edn-field">
                            <div class="edn-field-label-wrap">
                              <label for="enable_bgimage"><?php _e("Enable Background Image", APEXNB_TD) ?></label>
                            </div>
                            <div class="edn-field-input-wrap">
                                <div class="apexnb-switch">
                                  <input type='checkbox' id="enable_bgimage" name='edn_background_image[enable_bgimage]' value='true' <?php echo checked($edn_bar_setting['edn_background_image']['enable_bgimage'],'true', false ); ?>/>
                                  <label for="enable_bgimage"></label>
                                  <p class="description"><?php _e('Note: If enable background image, background color will not be shown and uploaded background image will be shown instead of color for notification bars.',APEXNB_TD);?></p>
                                </div>
                            </div>
                    
                    </div>
                      <div class="edn-field">
                              <div class="edn-field-label-wrap">
                                 <label for="uploadlogo"><?php _e("Upload Image", APEXNB_TD) ?></label>
                               </div>
                               <div class="edn-field-input-wrap">
                                    <div class="apexnb-img-bgwrap">
                                    <input type="url" name="edn_background_image[bgimage_url]" class="apexnb-logo-image-url apexnb-fixed-width" 
                                    value="<?php if(isset($edn_bar_setting['edn_background_image']['bgimage_url'])){echo esc_url($edn_bar_setting['edn_background_image']['bgimage_url']);}?>" />
                                    <input type="button" class="apexnb_logoimage_url_button button button-primary"  value="Upload Background Image" size="25"/> 
                                        
                                        <div class="apexnb-option-field apexnb-image-preview" <?php if(isset($edn_bar_setting['edn_background_image']['bgimage_url']) && empty($edn_bar_setting['edn_background_image']['bgimage_url'])) { ?> style="display:none;" <?php } ?>>
                                          <img  class="apexnb-image" src="<?php if(isset($edn_bar_setting['edn_background_image']['bgimage_url'])){echo esc_url($edn_bar_setting['edn_background_image']['bgimage_url']);}?>" alt=""  width="250">
                                        </div>
                                    </div> 
                                </div>
                     </div>

                </div>
            </div>
        </div>
    </div>
</div><!-- Edn .edn-row -->
<!--Background Image Section End -->

        
<div class="edn-row components_section">    
<div class="edn-left-controls-wrap">
    <div class="edn-inner-main-title" id="components" style="cursor:pointer;">
    <?php _e('Notification Bars Components', APEXNB_TD); ?>
           <div class="arrow-up" style="display:none;"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
                         <div class="arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
    </div>

  <div class="edn-show-components apexnb-main-wrapper-toggle" style="display:none;"> 
   <p class="description">
  <?php _e('Components Preview :', APEXNB_TD); ?>
             <div class="preview_demo">
             <img src="<?php echo APEXNB_IMAGE_DIR;?>/previeww.jpg"/>
             </div>
           </p>
    <div class="edn-social-icons-section">
      <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
              
                  <div class="edn-field">
                           
                            <div class="edn-field-label-wrap"> 
                                <label class="network" for="edn-social-network"><?php _e('Left Components', APEXNB_TD); ?></label>
                            </div>
                             <div class="edn-field-input-wrap">
                              <div class="apexnb-switch">
                                  <input type='checkbox' id="edn-social-network" name="edn_social_optons" value="1" <?php if(isset($edn_bar_setting['edn_social_optons']) && $edn_bar_setting['edn_social_optons']==1){echo 'checked="checked"';}?>/>
                                  <label for="edn-social-network"></label>
                                </div>
                            </div>

                            
                 </div>

            </div>
        </div> 
<!-- social media start-->    
 <div class="edn-col-half edn-social-panel-wrap" style="display: none;">
   <div class="edn-backend-inner-title">
<?php _e('Add Social Icons', APEXNB_TD); ?></div>
<div class="edn-col-full">
    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Social Heading Text',APEXNB_TD)?></label>
        <div class="edn-field">
            <input type="text"id="edn-social-heading-text" name="edn_social_heading_text" placeholder="<?php _e('E.g: Follow Us On',APEXNB_TD);?>"
            value="<?php if(isset($_GET['action'])){echo esc_attr($edn_bar_setting['edn_social_heading_text']);}?>" placeholder="<?php _e('e.g: Stay with us',APEXNB_TD);?>"  class="edn-sform-text required" data-error-msg="<?php _e('Please enter the icon title',APEXNB_TD)?>" />
        </div>
        <div class="edn-error"></div>
    </div><!--edn-field-wrapper-->
<div class="edn-custom-social-color">
    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Social Heading Text Color',APEXNB_TD)?></label>
        <div class="edn-field">
            <input type="text" id="edn-social-heading-text-color" name="edn_social_heading_color" value="<?php if(isset($edn_bar_setting['edn_social_heading_color'])){echo esc_attr($edn_bar_setting['edn_social_heading_color']);}?>" />
        </div>
    </div><!--edn-field-wrapper-->
</div>
</div>
<div class="edn-col-full">
    <div class="edn-preview-holder-wrap">
        <div class="edn-preview-holder">
            <div class="edn-font-icon-preview" style="display: block">
                <?php _e('Icon Preview', APEXNB_TD); ?><!--font-awesome selected icon-->
            </div>
        </div>
    </div>

    <h3><?php _e('Icon Lists', APEXNB_TD); ?>&nbsp;&nbsp;<img src="<?php echo APEXNB_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-icon-loader"/></h3>
    <div class="edn-expander-controls">
        <a href="javascript:void(0);" class="edn-icon-theme-expand button button-secondary button-small" style="display:<?php if(count($edn_bar_setting['icon_details'])>0){echo 'block';}else{echo 'none';}?>"><?php _e('Expand All', APEXNB_TD); ?></a>
    </div>
    <div class="edn-icon-list-wrapper">
        <p class="edn-empty-icon-note" style="display: none;">Empty List</p>
        <div class="edn-icon-note" style="display: none"><?php _e('Each Icon will only show up in the frontend if icon link is not empty', APEXNB_TD); ?></div>
<ul class="edn-icon-list">
<?php
    $icon_details = $edn_bar_setting['icon_details'];
    //$this->edn_pro_print_array($icon_details);
    $sn = 1;
    foreach ($icon_details as $icon_list){
        ?>
<li class="edn-sortable-icons <?php //echo $icon_main_class; ?>">
    <div class="edn-drag-icon"></div>
    <div class="edn-icon-head">
        <span class="edn-icon-name"><?php echo $icon_list['title'];?></span>
        <span class="edn-icon-list-controls">
            <span class="edn-arrow-down edn-arrow button button-secondary">
                <i class="dashicons dashicons-arrow-down"></i>
            </span>&nbsp;&nbsp;
            <span class="edn-delete-icon button button-secondary" aria-label="delete icon">
                <i class="dashicons dashicons-trash"></i>
            </span>
        </span>
    </div>
    <div class="edn-icon-body" style="display: none;">
        <div class="edn-icon-preview">
            <label><?php _e('Icon Preview', APEXNB_TD); ?></label>
            <i class="<?php echo $icon_list['font_icon'] ?>"></i>
        </div>
        <div class="edn-row">
            <div class="edn-col-one-third">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Icon Title',APEXNB_TD)?></label>
                    <div class="edn-field">
                        <input type="text" name="icons[<?php echo esc_attr($icon_list['title']);?>][title]" value="<?php echo esc_attr($icon_list['title']);?>" />
                    </div>
                    <div class="edn-error"></div>
                </div><!--edn-field-wrapper-->
            </div>           
            <div class="edn-col-one-third edn-hide-in-pre-tpl">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Icon Size',APEXNB_TD)?></label>
                    <div class="edn-field">
                        <input type="text" name="icons[<?php echo esc_attr($icon_list['title']);?>][icon_size]" value="<?php echo esc_attr($icon_list['icon_size']);?>" placeholder="<?php _e('e.g: 14px',APEXNB_TD);?>"/>
                    </div>
                </div><!--edn-field-wrapper-->
            </div>   
                  <div class="edn-clear"></div>

<div class="edn-col-icons">

<div class="edn-col-one-third edn-hide-in-pre-tpl">

    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Select Icon',APEXNB_TD)?></label>
        <div class="edn-field">
        
            <select name="icons[<?php echo esc_attr($icon_list['title']);?>][icon_type]" id="edn_icon_type-<?php echo $sn;?>" class="edn_icon_types apexnb-selection">  
            <option value="available_font_icon" <?php if(isset($icon_list['icon_type']) && $icon_list['icon_type'] == "available_font_icon") echo 'selected="selected"';?>><?php _e('Available Font Icon',APEXNB_TD);?></option>
                <option value="custom_icon" <?php if(isset($icon_list['icon_type']) && $icon_list['icon_type'] == "custom_icon") echo 'selected="selected"';?>><?php _e('Custom Icon',APEXNB_TD);?></option>
                
            </select>
        </div>
    </div><!--edn-field-wrapper-->
   
</div>


<?php 
$icon_display = !(isset($icon_list['icon_type']) && $icon_list['icon_type'] == "available_font_icon")?'style="display:none"':'';
$icon_display2 = !(isset($icon_list['icon_type']) && $icon_list['icon_type'] == "custom_icon")?'style="display:none"':'';
?>

<div class="edn-col-one-third customicons" <?php echo $icon_display2;?>>
     <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Custom Class Icon',APEXNB_TD)?></label>
        <div class="edn-field">
            <input type="text" id="edn-custom-icon-<?php echo $sn;?>" name="icons[<?php echo esc_attr($icon_list['title']);?>][font_icon]" 
            value="<?php if(isset($icon_list['font_icon'])) echo esc_attr($icon_list['font_icon']);?>"
            placeholder="<?php _e('e.g: fa fa-home',APEXNB_TD)?>">
        </div>
    </div><!--edn-field-wrapper-->
</div>


<div class="edn-col-one-third available-icons" <?php echo $icon_display;?>>

    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Font Awesome Icon', APEXNB_TD); ?></label>
        <div class="edn-field">
            <input type="hidden" class="edn-edit-font-awesome-icon" id="edn-fa-socil_<?php echo $sn;?>" name="icons[<?php echo esc_attr($icon_list['title']);?>][font_icon]" value="<?php echo esc_attr($icon_list['font_icon']);?>" />
            <input type="button" id="edn-fa-icons-wrap_<?php echo $sn;?>" class="button button-secondary edn-edit-font-icon-chooser" value="<?php _e('Select Icon', APEXNB_TD); ?>"/>
            <div class="edn-fa-icons-wrap" style="display:none">
                 <?php include(APEXNB_PRO_PATH.'inc/backend/includes/font-awesome-icons.php');?>
            </div>
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
                    <input type="text" class="edn-color-picker" id="edn-bg-picker" name="icons[<?php echo esc_attr($icon_list['title']);?>][bg_color]" value="<?php echo esc_attr($icon_list['bg_color']);?>" />
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth edn-hide-in-pre-tpl">
            <div class="edn-field-wrapper edn-form-field">
                <label><?php _e('Icon Font Color',APEXNB_TD)?></label>
                <div class="edn-field">
                    <input type="text" class="edn-color-picker" id="edn-color-picker" name="icons[<?php echo esc_attr($icon_list['title']);?>][font_color]" value="<?php echo esc_attr($icon_list['font_color']);?>" />
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth edn-hide-in-pre-tpl">
            <div class="edn-field-wrapper edn-form-field">
                <label><?php _e('Icon Background Hover Color',APEXNB_TD)?></label>
                <div class="edn-field">
                    <input type="text" class="edn-color-picker" name="icons[<?php echo esc_attr($icon_list['title']);?>][bg_hover_color]" value="<?php echo esc_attr($icon_list['bg_hover_color']);?>" />
                </div>
            </div>
        </div>
        <div class="edn-col-one-fourth edn-hide-in-pre-tpl">
            <div class="edn-field-wrapper edn-form-field">
                <label><?php _e('Icon Font Hover Color',APEXNB_TD)?></label>
                <div class="edn-field">
                    <input type="text" class="edn-color-picker" name="icons[<?php echo esc_attr($icon_list['title']);?>][font_hover_color]" value="<?php echo esc_attr($icon_list['font_hover_color']);?>" />
                </div>
            </div>
        </div>
        
        <div class="edn-clear"></div>
        
        <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
                <label><?php _e('Icon Link', APEXNB_TD); ?></label>
                <div class="edn-field">
                    <input type="text" name="icons[<?php echo esc_attr($icon_list['title']);?>][link]" value="<?php echo esc_attr($icon_list['link']);?>" />
                </div>
            </div><!--edn-field-wrapper-->
        </div>
    </div>
</li>
        <?php
        $sn++;
    }
?>
</ul>
    </div>
    <!-- Social form panel/column -->
    <div class="edn-social-form-panel">
         <?php include(APEXNB_PRO_PATH.'inc/backend/includes/social-icons-add.php');?>
    </div>
    <!-- Social form panel/column -->
</div>
</div>    

<!-- </div> -->
<!-- social media end-->

      
    </div> 

<div class="edn-second-components-section">    
 <div class="edn-col-full">
                 <div class="edn-field-wrapper edn-form-field">
                      
                        <div class="edn-field">
                           <div class="edn-field-label-wrap">
                              <label class="right_comp" for="edn-notification-comp"><?php _e('Right Components', APEXNB_TD); ?></label> 
                            </div>
                        <div class="edn-field-input-wrap">
                            <div class="apexnb-switch">
                               <input type="checkbox" name="edn_right_optons" id="edn-notification-comp" value="1" <?php if(isset($edn_bar_setting['edn_right_optons']) && $edn_bar_setting['edn_right_optons']==1){echo 'checked="checked"';}?>/>
                                <label for="edn-notification-comp"></label>
                             </div>
                        </div>
                           
                        </div>
                    </div>
                </div>
 <div class="edn-components-wrap" style="display:none;">
    <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
            <label><?php _e('Choose Notification Components', APEXNB_TD); ?></label>
            <div class="edn-field">
                
                        <select name="edn_cp_type" class="edn-label-inline apexnb-selection">
                              <option value="text" <?php if($edn_bar_setting['edn_cp_type']=='text'){echo 'selected="selected"';}?>><?php _e('Text (Custom html codes)',APEXNB_TD);?></option>
                              <option value="email-subs" <?php if($edn_bar_setting['edn_cp_type']=='email-subs'){echo 'selected="selected"';}?>><?php _e('Opt-in form',APEXNB_TD);?></option>
                              <option value="twiter-tweets" <?php if($edn_bar_setting['edn_cp_type']=='twiter-tweets'){echo 'selected="selected"';}?>><?php _e('Twitter tweets',APEXNB_TD);?></option>
                              <option value="post-title" <?php if($edn_bar_setting['edn_cp_type']=='post-title'){echo 'selected="selected"';}?>><?php _e('Post Title',APEXNB_TD);?></option>
                              <option value="rss-feed" <?php if($edn_bar_setting['edn_cp_type']=='rss-feed'){echo 'selected="selected"';}?>><?php _e('RSS Feed',APEXNB_TD);?></option>
                              <option value="countdown-timer" <?php if($edn_bar_setting['edn_cp_type']=='countdown-timer'){echo 'selected="selected"';}?>><?php _e('CountDown Timer',APEXNB_TD);?></option>
                              <option value="video-popup" <?php if($edn_bar_setting['edn_cp_type']=='video-popup'){echo 'selected="selected"';}?>><?php _e('Video Popup',APEXNB_TD);?></option>
                              <option value="custom-html" <?php if($edn_bar_setting['edn_cp_type']=='custom-html'){echo 'selected="selected"';}?>><?php _e('Custom HTML',APEXNB_TD);?></option>
                              <option value="search-form" <?php if($edn_bar_setting['edn_cp_type']=='search-form'){echo 'selected="selected"';}?>><?php _e('Search Form',APEXNB_TD);?></option>

                             </select>

            </div>
        </div>
    </div>
<div class="edn-cp-wrap">
<div class="edn-cp-block" id="edn-cp-text" style="display: block;">
<div class="edn-row">
<div class="edn-col-full edn-contentdisply-mode">
    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Content Display Mode', APEXNB_TD); ?></label>
        <div class="edn-field">
            <label class="edn-label-inline">
                <input type="radio" name="edn_text_display_mode" class="edn-text-mode" value="static" <?php if($edn_bar_setting['edn_text_display_mode']=='static'){echo 'checked="checked"';}?> />
                <?php _e('Static Content', APEXNB_TD); ?>
            </label>
            <label class="edn-label-inline">
                <input type="radio" name="edn_text_display_mode" class="edn-text-mode" value="multiple" <?php if($edn_bar_setting['edn_text_display_mode']=='multiple'){echo 'checked="checked"';}?> />
                <?php _e('Multiple Content', APEXNB_TD); ?>
            </label>
        </div>
    </div>
</div>
</div>
<div class="edn-text-content-wrap">
<div class="edn-static-content-wrap">
    <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field">
                <?php
                    $content = $edn_bar_setting['edn_static']['text'];
                    $settings = array('textarea_name' => 'edn_static[text]','media_buttons' => false);
                    wp_editor($content,'edn-static-text',$settings); 
                ?>
            </div>
            <div class="edn-error"></div>
        </div>
    </div>
    <div class="edn-row">
        <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-field">
                         <div class="edn-field-label-wrap"><label class="edn-label-inline" for="edn_static_cta">
                           <?php _e('Show Call to Action', APEXNB_TD); ?> </label>
                         </div>
                    <div class="edn-field-input-wrap">
                        <div class="apexnb-switch">
                        <input type="checkbox" name="edn_static[call-to-action]" class="edn-show-call-button" id="edn_static_cta" value="1" <?php if(isset($edn_bar_setting['edn_static']['call-to-action']) && $edn_bar_setting['edn_static']['call-to-action']==1){echo 'checked="checked"';}?> />
                     <label for="edn_static_cta"></label>
                     </div>
                     </div>
                </div>
            </div>
        </div>
        <div class="edn-call-to-action-type" style="display: none;">
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Call to Action Type', APEXNB_TD); ?></label>
                    <div class="edn-field">
                        <label class="edn-label-inline">
                            <input type="radio" name="edn_static[call_action_button]" class="edn-call-action-type" value="custom" <?php if($edn_bar_setting['edn_static']['call_action_button']=='custom'){echo 'checked="checked"';}?> />
                            <?php _e('Custom Button', APEXNB_TD); ?>
                        </label>
                        <label class="edn-label-inline">
                            <input type="radio" name="edn_static[call_action_button]" class="edn-call-action-type" value="contact" <?php if($edn_bar_setting['edn_static']['call_action_button']=='contact'){echo 'checked="checked"';}?> />
                            <?php _e('Contact Form', APEXNB_TD); ?>
                        </label>
                         <label class="edn-label-inline">
                            <input type="radio" name="edn_static[call_action_button]" class="edn-call-action-type" value="shortcode-popup" <?php if($edn_bar_setting['edn_static']['call_action_button']=='shortcode-popup'){echo 'checked="checked"';}?>/>
                            <?php _e('Shortcode In Popup', APEXNB_TD); ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="end-call-to-action-block" style="display: none;">
        <div id="edn-custom-button-block" class="edn-call-action">
            <div class="edn-col-full">
                     <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Link Button Text',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" name="edn_static[but_text]" placeholder="<?php _e('e.g: READ MORE',APEXNB_TD);?>" value="<?php echo esc_attr($edn_bar_setting['edn_static']['but_text'])?>" />
                        <p class="edn-note"><?php _e('If link title Left empty,then default value will be set as READ MORE.',APEXNB_TD);?></p>
                        </div>
                    </div>
            </div>   
            <div class="edn-col-full">
                  <div class="edn-field-wrapper edn-form-field">
                      <label><?php _e('Link Button URL',APEXNB_TD);?></label>
                        <div class="edn-field">
                           <input type="text" name="edn_static[but_url]" placeholder="<?php _e('e.g: https://www.accesspressthemes.com',APEXNB_TD);?>" value="<?php echo esc_url_raw($edn_bar_setting['edn_static']['but_url'])?>" />
                        </div>
                    </div>
            </div>    
             <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                     <label><?php _e('Link Target',APEXNB_TD);?></label>
                        <div class="edn-field">
                             <select name="edn_static[link_target]" class="apexnb-selection">
                               <option value="_blank" <?php if(isset($edn_bar_setting['edn_static']['link_target']) && $edn_bar_setting['edn_static']['link_target']=='_blank'){echo 'selected="selected"';}?>><?php _e('_blank',APEXNB_TD);?></option>
                               <option value="_self" <?php if(isset($edn_bar_setting['edn_static']['link_target']) && $edn_bar_setting['edn_static']['link_target']=='_self'){echo 'selected="selected"';}?>><?php _e('_self',APEXNB_TD);?></option>
                               <option value="_parent" <?php if(isset($edn_bar_setting['edn_static']['link_target']) && $edn_bar_setting['edn_static']['link_target']=='_parent'){echo 'selected="selected"';}?>><?php _e('_parent',APEXNB_TD);?></option>
                               <option value="_top" <?php if(isset($edn_bar_setting['edn_static']['link_target']) && $edn_bar_setting['edn_static']['link_target']=='_top'){echo 'selected="selected"';}?>><?php _e('_top',APEXNB_TD);?></option>
                              </select>
                        </div>
                </div>
            </div>
            <div class="edn-col-full edn-hide-in-pre-tpl">
                <div class="edn-field-wrapper edn-form-field">
                 <div class="edn-field">
                    <div class="edn-field-label-wrap"><label><?php _e('Link Button Color',APEXNB_TD);?></label></div>
                    <div class="edn-field-input-wrap">
                        <input type="text" name="edn_static[but_color]" class="edn-color-picker" value="<?php echo esc_attr($edn_bar_setting['edn_static']['but_color'])?>" />
                    </div>
                    </div>
                </div>
            </div>    
            <div class="edn-col-full edn-hide-in-pre-tpl">
                <div class="edn-field-wrapper edn-form-field">
                <div class="edn-field">
                    <div class="edn-field-label-wrap"><label><?php _e('Link Button Font Color',APEXNB_TD);?></label></div>
                    <div class="edn-field-input-wrap">
                        <input type="text" name="edn_static[but_font_color]" class="edn-color-picker" value="<?php echo esc_attr($edn_bar_setting['edn_static']['but_font_color'])?>" />
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- #edn-custom-button-block -->
        <div id="edn-contact-button-block" class="edn-call-action" style="display: none;">
            <div class="edn-row">
                <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Choose Contact Form type', APEXNB_TD); ?></label>
                        <div class="edn-field">
                            <label class="edn-label-inline">
                                <input type="radio" name="edn_static[contact_choose]" class="edn-contact-choose" value="c-form" <?php if($edn_bar_setting['edn_static']['contact_choose']=='c-form'){echo 'checked="checked"';}?> />
                                <?php _e('Default Form',APEXNB_TD);?>
                            </label>
                            <label class="edn-label-inline">
                                <input type="radio" name="edn_static[contact_choose]" class="edn-contact-choose" value="form-7" <?php if($edn_bar_setting['edn_static']['contact_choose']=='form-7'){echo 'checked="checked"';}?> />
                                <?php _e('Contact Form 7',APEXNB_TD);?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="edn-row">
                <div class="edn-contact-form-wrap">
                    <div class="edn-row">
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Contact Button Text',APEXNB_TD);?></label>
                                <div class="edn-field">
                                    <input type="text" name="edn_static[contact_btn_text]" placeholder="<?php _e('e.g:Contact Us',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_static']['contact_btn_text'])){echo esc_attr($edn_bar_setting['edn_static']['contact_btn_text']);}?>" />
                              
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="edn-cotnact-from" id="edn-contact-custom-form">
                        <div class="edn-row">
                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Name Label',APEXNB_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[name_label]" placeholder="<?php _e('e.g:Name',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_static']['name_label'])) echo esc_attr($edn_bar_setting['edn_static']['name_label'])?>" />
                                    </div>
                                   </div>
                                   <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Name Placeholder',APEXNB_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[name_placeholder]" placeholder="<?php _e('e.g:Your Name',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_static']['name_placeholder'])) echo esc_attr($edn_bar_setting['edn_static']['name_placeholder'])?>" />
                                    </div>
                                    </div>
                                   <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Name Error Message',APEXNB_TD);?></label>
                                    <div class="edn-field">
                                     <input type="text" name="edn_static[name_error_msg]" 
                                     placeholder="<?php _e('e.g:Please enter your name.',APEXNB_TD);?>" 
                                     value="<?php if(isset($edn_bar_setting['edn_static']['name_error_msg'])) echo esc_attr($edn_bar_setting['edn_static']['name_error_msg'])?>"/>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-form-field">
                                <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Email Label',APEXNB_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[email_label]" value="<?php if(isset($edn_bar_setting['edn_static']['email_label'])) echo esc_attr($edn_bar_setting['edn_static']['email_label'])?>" placeholder="<?php _e('e.g:Email',APEXNB_TD);?>"/>
                                    </div>
                                    </div>
                                <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Email Placeholder',APEXNB_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[email_placeholder]" value="<?php if(isset($edn_bar_setting['edn_static']['email_placeholder'])) echo esc_attr($edn_bar_setting['edn_static']['email_placeholder'])?>"  placeholder="<?php _e('e.g:Your Email Address',APEXNB_TD);?>"/>
                                    </div>
                                     </div>
                                <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Email Error Message',APEXNB_TD);?></label>
                                    <div class="edn-field">
                                     <input type="text" name="edn_static[email_error_msg]" 
                                     placeholder="<?php _e('e.g: Please enter valid email address',APEXNB_TD);?>"
                                     value="<?php if(isset($edn_bar_setting['edn_static']['email_error_msg'])) echo esc_attr($edn_bar_setting['edn_static']['email_error_msg'])?>"/>
                                    </div>
                                </div>
                                </div>
                            </div>
                        
                        
                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-form-field">
                                    <div class="edn-col-one-fourth edn-default-form">
                                    <div class="edn-field">
                                         <div class="edn-field-label-wrap">
                                        <label class="edn-label-inline" for="edn_static_name_req">
                                            <?php _e('Name Required',APEXNB_TD);?></label>
                                            </div>
                                              <div class="edn-field-input-wrap">
                                        <div class="apexnb-switch">  
                                            <input type="checkbox" id="edn_static_name_req"  name="edn_static[name_required]" value="1" <?php if(isset($edn_bar_setting['edn_static']['name_required'])&&$edn_bar_setting['edn_static']['name_required']==1){echo 'checked="checked"';}?> />
                                         <label for="edn_static_name_req"></label>
                                           </div>
                                     </div>
                                    </div>
                                    </div>
                                    <div class="edn-col-one-fourth edn-default-form">
                                    <div class="edn-field">
                                        <div class="edn-field-label-wrap">
                                        <label class="edn-label-inline" for="edn_static_email_req">
                                            <?php _e('Email Required',APEXNB_TD);?></label>
                                        </div> 
                                    <div class="edn-field-input-wrap">
                                        <div class="apexnb-switch">  
                                            <input type="checkbox" id="edn_static_email_req" name="edn_static[email_required]" value="1" <?php if(isset($edn_bar_setting['edn_static']['email_required'])&&$edn_bar_setting['edn_static']['email_required']==1){echo 'checked="checked"';}?> />
                                        <label for="edn_static_email_req"></label>
                                           </div>
                                     </div>

                                    </div>
                                    </div>
                                     <div class="edn-col-one-fourth edn-default-form">
                                    <div class="edn-field">
                                      <div class="edn-field-label-wrap">
                                        <label class="edn-label-inline" for="edn_static_message_req">
                                            <?php _e('Message Required',APEXNB_TD);?> </label>
                                      </div>
                                     <div class="edn-field-input-wrap">
                                        <div class="apexnb-switch">  
                                        <input type="checkbox"  id="edn_static_message_req" name="edn_static[msg_required]" value="1" <?php if(isset($edn_bar_setting['edn_static']['msg_required'])&&$edn_bar_setting['edn_static']['msg_required']==1){echo 'checked="checked"';}?> />
                                         <label for="edn_static_message_req"></label>
                                           </div>
                                     </div>
                                        
                                    </div>
                                    </div>
                                </div>
                            </div>
                      
                         <div class="edn_clear"></div>
                            <div class="edn-col-half edn-clear">
                                <div class="edn-field-wrapper edn-form-field">
                                 <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Message Label',APEXNB_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[msg_label]" value="<?php if(isset($edn_bar_setting['edn_static']['msg_label'])) echo esc_attr($edn_bar_setting['edn_static']['msg_label'])?>" placeholder="<?php _e('Message',APEXNB_TD);?>"/>
                                    </div>
                                  </div>
                                 <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Message Placeholder',APEXNB_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[msg_placeholder]"  placeholder="<?php _e('Your Message',APEXNB_TD);?>"
                                        value="<?php if(isset($edn_bar_setting['edn_static']['msg_placeholder'])) echo esc_attr($edn_bar_setting['edn_static']['msg_placeholder'])?>" />
                                    </div>
                                    </div>
                                     <div class="edn-col-one-fourth edn-default-form">
                                    <label><?php _e('Message Error Message',APEXNB_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[msg_error]" value="<?php if(isset($edn_bar_setting['edn_static']['msg_error'])) echo esc_attr($edn_bar_setting['edn_static']['msg_error'])?>" 
                                        placeholder="<?php _e('Please enter message.',APEXNB_TD);?>"/>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="edn_clear"></div>
                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-form-field">
                                    <label><?php _e('Send To Email',APEXNB_TD);?></label>
                                    <div class="edn-field">
                                        <input type="text" name="edn_static[send_to_mail]" id="edn-send-mail-field" 
                                        value="<?php echo esc_attr($edn_bar_setting['edn_static']['send_to_mail'])?>" placeholder="<?php _e('E.g:support@accesspressthemes.com',APEXNB_TD);?>"/>
                                    <p class="edn-note"><?php _e('Note: If left empty, email will be send to admin email.',APEXNB_TD);?></p>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-form-field">
                                    <label><?php _e('Success Message',APEXNB_TD);?></label>
                                    <div class="edn-field">
                                    <input type="text" id="edn-success-message"name="edn_static[success_message]"
                                                 value="<?php if(isset($edn_bar_setting['edn_static']['success_message'])) 
                                                 echo esc_attr($edn_bar_setting['edn_static']['success_message']);?>"
                                                 placeholder="<?php _e('e.g:Your message has been successfully sent.',APEXNB_TD);?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="edn-col-half">
                                <div class="edn-field-wrapper edn-form-field">
                                    <label><?php _e('Fail Email Message',APEXNB_TD);?></label>
                                        <div class="edn-field">
                                        <input type="text" id="edn-cc-send-fail-msg" name="edn_static[sendfail_msg]"
                                                 value="<?php if(isset($edn_bar_setting['edn_static']['sendfail_msg']))
                                                  echo esc_attr($edn_bar_setting['edn_static']['sendfail_msg']);?>" 
                                                  placeholder="<?php _e('e.g:Error sending message.',APEXNB_TD);?>"/>
                                                          
                                        </div>
                                </div>
                            </div>
                       
                        </div>
                    </div>
                     <div class="edn-cotnact-from" id="edn-contact-form-7" style="display: none;">
                     <?php  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                     if ( is_plugin_active('contact-form-7/wp-contact-form-7.php') ) { 
                        ?>
                   
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                            <div class="edn-field">
                                <div class="edn-field-label-wrap"> <label><?php _e('Contact Form 7 Shortcode',APEXNB_TD);?></label>
                                  <p class="edn-note"><?php _e('Enter Shortcode generated using Contact form 7 plugin here.',APEXNB_TD);?></p>
                               </div>
                                 <div class="edn-field-input-wrap">
                                    <?php
                                        $short_code = $edn_bar_setting['edn_static']['form_shortcode'];
                                        $final_shortcode = str_replace('\"','"',$short_code);
                                    ?>
                                    <input type="text" name="edn_static[form_shortcode]" value="<?php echo esc_attr($final_shortcode)?>" 
                                    />
                                    </div>
                                    
                                </div>
                            </div>
                        </div> 
                   
                    <?php }else{ ?>
                         <p class="edn-note">
                       <?php  _e('Note: Please activate Contact Form 7 Plugin to integrate your shortcode.',APEXNB_TD); ?>
                        </p>
                        <?php } ?>
                         </div>
                </div>
            </div>
        </div><!-- #edn-contact-button-block -->

             <!-- shortcode support call to action here -->
                     <div id="edn-shortcode-button-block" class="edn-call-action" style="display: none;">
                       <div class="ednshortcode-support" id="ednshortcode-support">
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Popup Button Text',APEXNB_TD);?></label>
                                <div class="edn-field">
                                    <input type="text" value="<?php if(isset($edn_bar_setting['edn_static']['popup_text']))
                                                  echo esc_attr($edn_bar_setting['edn_static']['popup_text']);?>" id="edn-shortcode-button-text" name="edn_static[popup_text]" placeholder="<?php _e('Enter popup button text',APEXNB_TD);?>"/>
                               <p class="description">
                                 <?php  _e('On click Popup Button Text, the shortcode implemented will be displayed on popup.',APEXNB_TD); ?>
                                 </p>
                                </div>
                            </div>
                        </div>
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Shortcode',APEXNB_TD);?></label>
                                <div class="edn-field">
                                    <input type="text" name="edn_static[shortcode_popup]" value="<?php if(isset($edn_bar_setting['edn_static']['shortcode_popup']))
                                                  echo esc_attr($edn_bar_setting['edn_static']['shortcode_popup']);?>" placeholder="<?php _e('Enter any shortcode here.',APEXNB_TD);?>"/>
                                 <p class="description">
                                 <?php  _e('Enter any shortcode here that you will be displayed on popup. ',APEXNB_TD); ?>
                                 </p>
                                </div>
                            </div>
                        </div> 
                        </div>
                     </div>
                <!-- shortcode support call to action end-->  


    </div>
</div> <!-- static content end -->
<div class="edn-multiple-content-wrap" style="display: none;">
    <ul class="edn-append-mcontent-prev">
            <?php 
// echo "<pre>";
            //print_r($edn_bar_setting['edn_multiple']);
                $count = 0;
               // $this->edn_pro_print_array($edn_bar_setting['edn_multiple']);
                if(!empty($edn_bar_setting['edn_multiple'])){
                //if(is_array($edn_bar_setting['edn_multiple']['text_content']) && count(array_filter($edn_bar_setting['edn_multiple']['text_content']))){
                
                if(isset($edn_bar_setting['edn_multiple']['text_content']) && $edn_bar_setting['edn_multiple']['text_content']){
                    foreach($edn_bar_setting['edn_multiple']['text_content'] as $content)
                    {
                        $substr_content = substr(strip_tags($content),0,30);
                        ?>
                        <li class="edn-sortable-content">
                            <div class="edn-content-head" id="edn-c-head_<?php echo $count;?>">
                                <span class="edn-content-title"><?php echo $substr_content.'...';?> </span>
                                <span class="edn-content-list-controls"><span class="edn-arrow-down edn-arrow button button-secondary"><i class="dashicons dashicons-arrow-down"></i></span>&nbsp;&nbsp;<span class="edn-delete-content button button-secondary" aria-label="delete content"><i class="dashicons dashicons-trash"></i></span></span>
                            </div>
                            <div class="edn-multiple-slide-down" style="display: none;">
                                <div class="edn-row">
                                    <div class="edn-col-full">
                                        <div class="edn-field-wrapper edn-form-field">
                                            <div class="edn-field">
                                                <?php
                                                    $settings = array('textarea_name' => 'edn_multiple[text_content]['.$count.']','media_buttons' => false,);
                                                    wp_editor($content,'edn-edit-multiple-text'.$count,$settings); 
                                                ?>
                                            </div>
                                            <div class="edn-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="edn-row">
                                    <div class="edn-col-full">
                                        <div class="edn-field-wrapper edn-form-field">
                                            <div>
                                                <label class="edn-label-inline">
                                                    <?php _e('Show Call to Action', APEXNB_TD); ?>
                                                    <input type="checkbox" name="edn_multiple[call_to_action][<?php echo $count?>]" class="edn-show-slide-call-button" id="edn-sscb_<?php echo $count?>" value="1" <?php if(isset($edn_bar_setting['edn_multiple']['call_to_action'][$count])&&$edn_bar_setting['edn_multiple']['call_to_action'][$count]==1){echo 'checked="checked"';}?> />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="edn-slide-call-to-action-type edn-sctat_<?php echo $count;?>" style="display: none;">
                                        <div class="edn-col-full">
                                            <div class="edn-field-wrapper edn-form-field">
                                                <label><?php _e('Call to Action Type', APEXNB_TD); ?></label>
                                                <div class="edn-field">
                                                    <label class="edn-label-inline">
                                                        <input type="radio" name="edn_multiple[call_to_acction_type][<?php echo $count;?>]" class="edn-slide-call-action-type" id="edn-ca-cu_<?php echo $count?>" value="custom" <?php if($edn_bar_setting['edn_multiple']['call_to_acction_type'][$count]=='custom'){echo 'checked="checked"';}?> />
                                                        <?php _e('Custom Button', APEXNB_TD);?>
                                                    </label>
                                                    <label class="edn-label-inline">
                                                        <input type="radio" name="edn_multiple[call_to_acction_type][<?php echo $count;?>]" class="edn-slide-call-action-type" id="edn-ca-co_<?php echo $count?>" value="contact" <?php if($edn_bar_setting['edn_multiple']['call_to_acction_type'][$count]=='contact'){ echo 'checked="checked"';}?> />
                                                        <?php _e('Contact Form', APEXNB_TD); ?>
                                                    </label>
                                                     <label class="edn-label-inline">
                                                          <input type="radio" name="edn_multiple[call_to_acction_type][<?php echo $count;?>]" class="edn-slide-call-action-type" id="edn-ca-co_<?php echo $count?>" value="shortcode-popup" <?php if($edn_bar_setting['edn_multiple']['call_to_acction_type'][$count]=='shortcode-popup'){echo 'checked="checked"';}?>/>
                                                          <?php _e('Shortcode In Popup', APEXNB_TD); ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    // echo "<pre>";
                                    // print_r($edn_bar_setting['edn_multiple']);
                                    ?>
                                    <div class="end-slide-call-to-action-block edn-sctat_<?php echo $count;?>" style="display: none;">
                                        <div id="edn-slide-custom-button-block" class="edn-slide-call-action edn-slide-call-action-<?php echo $count?> edn-custom-but-block-<?php echo $count?>">
                                            <div class="edn-col-full">
                                                <div class="edn-field-wrapper edn-form-field">
                                                    <label><?php _e('Link Button Text',APEXNB_TD);?></label>
                                                    <div class="edn-field">
                                                        <input type="text" name="edn_multiple[link_but_text][<?php echo $count?>]" placeholder="<?php _e('e.g: READ MORE',APEXNB_TD);?>"
                                                         value="<?php if(isset($edn_bar_setting['edn_multiple']['link_but_text'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['link_but_text'][$count])?>" />
                                                    </div>
                                                </div>
                                            </div>   
                                            <div class="edn-col-full">
                                                <div class="edn-field-wrapper edn-form-field">
                                                    <label><?php _e('Link Button URL',APEXNB_TD);?></label>
                                                    <div class="edn-field">
                                                        <input type="text" name="edn_multiple[link_url][<?php echo $count?>]" value="<?php if(isset($edn_bar_setting['edn_multiple']['link_url'][$count])) echo esc_url_raw($edn_bar_setting['edn_multiple']['link_url'][$count])?>" placeholder="<?php _e('e.g: https://www.accesspressthemes.com',APEXNB_TD);?>"/>
                                                    </div>
                                                </div>
                                            </div>   
                                               <div class="edn-col-full">
                                            <div class="edn-field-wrapper edn-form-field">
                                                <label><?php _e('Link Target',APEXNB_TD);?></label>
                                                <div class="edn-field">
                                                    <select id="edn-link-target" name="edn_multiple[link_target][<?php echo $count?>]">
                                                     <option value="_blank" <?php if(isset($edn_bar_setting['edn_multiple']['link_target'][$count]) && $edn_bar_setting['edn_multiple']['link_target'][$count] == "_blank") echo "selected='selected'";?>><?php _e('_blank',APEXNB_TD);?></option>
                                                     <option value="_self" <?php if(isset($edn_bar_setting['edn_multiple']['link_target'][$count]) && $edn_bar_setting['edn_multiple']['link_target'][$count] == "_self") echo "selected='selected'";?>><?php _e('_self',APEXNB_TD);?></option>
                                                     <option value="_parent" <?php if(isset($edn_bar_setting['edn_multiple']['link_target'][$count]) && $edn_bar_setting['edn_multiple']['link_target'][$count] == "_parent") echo "selected='selected'";?>><?php _e('_parent',APEXNB_TD);?></option>
                                                     <option value="_top" <?php if(isset($edn_bar_setting['edn_multiple']['link_target'][$count]) && $edn_bar_setting['edn_multiple']['link_target'][$count] == "_top") echo "selected='selected'";?>><?php _e('_top',APEXNB_TD);?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>  

                                            <div class="edn-col-one-third edn-hide-in-pre-tpl">
                                                <div class="edn-field-wrapper edn-form-field">
                                                    <label><?php _e('Link Button Color',APEXNB_TD);?></label>
                                                    <div class="edn-field">
                                                        <input type="text" name="edn_multiple[link_but_color][<?php echo $count?>]" class="edn-color-picker" value="<?php echo esc_attr($edn_bar_setting['edn_multiple']['link_but_color'][$count])?>" />
                                                    </div>
                                                </div>
                                            </div>    
                                            <div class="edn-col-half edn-hide-in-pre-tpl">
                                                <div class="edn-field-wrapper edn-form-field">
                                                    <label><?php _e('Link Button Text Color',APEXNB_TD);?></label>
                                                    <div class="edn-field">
                                                        <input type="text" name="edn_multiple[link_but_text_color][<?php echo $count?>]" class="edn-color-picker" value="<?php echo esc_attr($edn_bar_setting['edn_multiple']['link_but_text_color'][$count])?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        


    </div><!-- #edn-slide-custom-button-block -->

    <div id="edn-slide-contact-button-block" class="edn-slide-call-action edn-slide-call-action-<?php echo $count?> edn-contact-but-block-<?php echo $count?>" style="display: none;">
        <div class="edn-row">
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Contact Form Type', APEXNB_TD); ?></label>
                    <div class="edn-field">
                        <label class="edn-label-inline">
                            <input type="radio" name="edn_multiple[contact_form_type][<?php echo $count?>]" class="edn-slide-contact-choose" id="edn-cf_<?php echo $count?>" value="c-form" <?php if(isset($edn_bar_setting['edn_multiple']['contact_form_type'][$count]) && $edn_bar_setting['edn_multiple']['contact_form_type'][$count]=='c-form'){echo 'checked="checked"';}?> />
                            <?php _e('Default Form',APEXNB_TD);?>
                        </label>
                        <label class="edn-label-inline">
                            <input type="radio" name="edn_multiple[contact_form_type][<?php echo $count?>]" class="edn-slide-contact-choose" id="edn-cf7_<?php echo $count?>" value="form-7" <?php if(isset($edn_bar_setting['edn_multiple']['contact_form_type'][$count]) && $edn_bar_setting['edn_multiple']['contact_form_type'][$count]=='form-7'){echo 'checked="checked"';}?> />
                            <?php _e('Contact Form 7',APEXNB_TD);?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="edn-row">
            <div class="edn-contact-form-wrap">
                <div class="edn-row">
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Contact Button Text',APEXNB_TD);?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_multiple[contact_btn_text][]" placeholder="<?php _e('e.g:Contact Us',APEXNB_TD);?>"
                                value="<?php if(isset($edn_bar_setting['edn_multiple']['contact_btn_text'][$count])){echo esc_attr($edn_bar_setting['edn_multiple']['contact_btn_text'][$count]);}?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="edn-slide-cotnact-from edn-slide-cotnact-from-<?php echo $count?> edn-slide-cc-form-<?php echo $count?>" id="edn-slide-contact-custom-form">

<!-- added code for prev button click edit multiple form-->
<div class="edn-row">                 
    <div class="edn-col-half">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-col-one-fourth edn-default-form">
                    <label><?php _e('Name Label',APEXNB_TD);?></label>
                    <div class="edn-field">
                    <input type="text" id="edn-cc-name-label" name="edn_multiple[name_label][<?php echo $count?>]"
                     value="<?php if(isset($edn_bar_setting['edn_multiple']['name_label'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['name_label'][$count]);?>" placeholder="<?php _e('e.g:Name',APEXNB_TD);?>"/>

                    </div>
                </div>
                <div class="edn-col-one-fourth edn-default-form">
                    <label><?php _e('Email Label',APEXNB_TD);?></label>
                    <div class="edn-field">
                    <input type="text" id="edn-cc-email-label" name="edn_multiple[email_label][<?php echo $count?>]"
                     value="<?php if(isset($edn_bar_setting['edn_multiple']['email_label'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['email_label'][$count]);?>" placeholder="<?php _e('e.g:Email',APEXNB_TD);?>"/>
                    </div>
                </div>
                <div class="edn-col-one-fourth edn-default-form">

                    <label><?php _e('Message Label',APEXNB_TD);?></label>
                    <div class="edn-field">
                    <input type="text" id="edn-cc-msg-label" name="edn_multiple[msg_label][<?php echo $count?>]"
                     value="<?php if(isset($edn_bar_setting['edn_multiple']['msg_label'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['msg_label'][$count]);?>" placeholder="<?php _e('Message',APEXNB_TD);?>"/>
                    </div>


                </div>
        </div>
  </div>
<div class="edn_clear"></div>
<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Name Placeholder',APEXNB_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-name-placeholder" name="edn_multiple[name_placeholder][<?php echo $count?>]"
                   placeholder="<?php _e('e.g:Your Name',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_multiple']['name_placeholder'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['name_placeholder'][$count]);?>" 
            placeholder="<?php _e('e.g.,Enter FullName',APEXNB_TD);?>"/>
        </div>
        </div>
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Email Placeholder',APEXNB_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-email-placeholder" name="edn_multiple[email_placeholder][<?php echo $count?>]" placeholder="<?php _e('e.g:Your Email Address',APEXNB_TD);?>"
                     value="<?php if(isset($edn_bar_setting['edn_multiple']['email_placeholder'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['email_placeholder'][$count]);?>"
           placeholder="<?php _e('e.g.,Enter Email Address.',APEXNB_TD);?>"/>
        </div>
        </div>
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Message Placeholder',APEXNB_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-msg-placeholder" name="edn_multiple[message_placeholder][<?php echo $count?>]"
                   placeholder="<?php _e('e.g.,Your Message.',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_multiple']['message_placeholder'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['message_placeholder'][$count]);?>" placeholder="<?php _e('e.g.,Your Message.',APEXNB_TD);?>"/>
        </div>

        </div>
    </div>
</div>
<div class="edn_clear"></div>
<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Name Error Message',APEXNB_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-name-error"name="edn_multiple[name_error_message][<?php echo $count?>]"
                    placeholder="<?php _e('e.g:Please enter your name.',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_multiple']['name_error_message'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['name_error_message'][$count]);?>" placeholder="<?php _e('e.g.,Name field is empty.',APEXNB_TD);?>"/>
        </div>
        </div>
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Email Error Message',APEXNB_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-email-error" name="edn_multiple[email_error_message][<?php echo $count?>]"
                    placeholder="<?php _e('e.g: Please enter valid email address',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_multiple']['email_error_message'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['email_error_message'][$count]);?>" placeholder="<?php _e('e.g.,Email Field is empty.',APEXNB_TD);?>"/>
        </div>
        </div>
        <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Valid Email Error Message',APEXNB_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-email-valid-error" name="edn_multiple[email_valid_error_message][<?php echo $count?>]"
                    placeholder="<?php _e('e.g.,Please enter valid email address.',APEXNB_TD);?>" value="<?php if(isset($edn_bar_setting['edn_multiple']['email_valid_error_message'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['email_valid_error_message'][$count]);?>"
            placeholder="<?php _e('e.g.,Please enter valid email address.',APEXNB_TD);?>"/>
        </div>
     </div>
     <div class="edn-col-one-fourth edn-default-form">
            <label><?php _e('Message Error Message',APEXNB_TD);?></label>
            <div class="edn-field">
                <input type="text" id="edn-cc-msg-error" value="<?php if(isset($edn_bar_setting['edn_multiple']['msg_error'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['msg_error'][$count]);?>" name="edn_multiple[msg_error][<?php echo $count?>]"
                placeholder="<?php _e('Please enter message.',APEXNB_TD);?>"/>
            </div>
            </div>
    </div>
</div>
<div class="edn_clear"></div>

</div>
<!--class=edn-hide-in-pre-tpl-->
<div class="edn_clear"></div>

<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <div class="edn-col-one-fourth edn-default-form">
            <div>
                <label class="edn-label-inline">
                <?php _e('Name Required',APEXNB_TD);?>  
                <input type="checkbox" name="edn_multiple[name_required][<?php echo $count?>]" value="1" <?php if(isset($edn_bar_setting['edn_multiple']['name_required'][$count])&&$edn_bar_setting['edn_multiple']['name_required'][$count]==1){echo 'checked="checked"';}?> />                                                            

                 </label>
            </div>
        </div>
        <div class="edn-col-one-fourth edn-default-form">
            <div>
                <label class="edn-label-inline">
                <?php _e('Email Required',APEXNB_TD);?> 
                <input type="checkbox" name="edn_multiple[email_required][<?php echo $count?>]" value="1" <?php if(isset($edn_bar_setting['edn_multiple']['email_required'][$count])&&$edn_bar_setting['edn_multiple']['email_required'][$count]==1){echo 'checked="checked"';}?> />
                </label>

            </div>
        </div>
         <div class="edn-col-one-fourth edn-default-form">
            <div>
                  <label class="edn-label-inline" for="edn_multiple_message_req">
                   <?php _e('Message Required',APEXNB_TD);?> 
                    <input type="checkbox" id="edn_multiple_message_req" name="edn_multiple[msg_required][<?php echo $count?>]" value="1" <?php if(isset($edn_bar_setting['edn_multiple']['msg_required'][$count])&&$edn_bar_setting['edn_multiple']['msg_required'][$count]==1){echo 'checked="checked"';}?> />                                                            
                 </label>
            </div>
        </div>
    </div>
</div>
<div class="edn_clear"></div>
<div class="edn-row">

<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Send To Email',APEXNB_TD);?></label>
        <div class="edn-field">
        <input type="text" id="edn-cc-send-mail" name="edn_multiple[send_to_email][<?php echo $count?>]" placeholder="<?php _e('E.g:support@accesspressthemes.com',APEXNB_TD);?>"
                     value="<?php if(isset($edn_bar_setting['edn_multiple']['send_to_email'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['send_to_email'][$count]);?>"/>
        <p class="edn-note"><?php _e('Note: If above field left empty,email will be send to admin email.',APEXNB_TD);?></p>
        </div>
    </div>
</div>
<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Success Message',APEXNB_TD);?></label>
        <div class="edn-field">
        <input type="text" id="edn-cc-success-message"name="edn_multiple[success_message][<?php echo $count?>]"
                    placeholder="e.g.,Your message has been successfully sent." value="<?php if(isset($edn_bar_setting['edn_multiple']['success_message'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['success_message'][$count]);?>"placeholder="e.g.,Your message has been successfully sent."/>
        </div>
    </div>
</div>
<div class="edn-col-half">
    <div class="edn-field-wrapper edn-form-field">
        <label><?php _e('Fail Email Message',APEXNB_TD);?></label>
            <div class="edn-field">
            <input type="text" id="edn-cc-send-fail-msg" name="edn_multiple[sendfail_msg][<?php echo $count?>]"
                   placeholder="e.g.,Error sending message." value="<?php if(isset($edn_bar_setting['edn_multiple']['sendfail_msg'][$count])) echo esc_attr($edn_bar_setting['edn_multiple']['sendfail_msg'][$count]);?>" placeholder="e.g.,Error sending message."/>
                              
            </div>
    </div>
</div>
</div>

</div>

     <?php  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                         if ( is_plugin_active('contact-form-7/wp-contact-form-7.php') ) { 
                            ?>
     <div class="edn-slide-cotnact-from edn-slide-cotnact-from-<?php echo $count?> edn-slide-cf7-<?php echo $count?>" id="edn-slide-contact-form-7<?php echo $count?>" style="display: none;">
       
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <label><?php _e('Contact Form 7 Shortcode',APEXNB_TD);?></label>
                    <div class="edn-field">
                        <?php
                        if(isset($edn_bar_setting['edn_multiple']['form_shortcode'][$count])){
                            $short_code = $edn_bar_setting['edn_multiple']['form_shortcode'][$count];
                            $final_shortcode =  str_replace('\"','"',$short_code);
                        }else{
                            $final_shortcode = '';
                        }
                        ?>
                        <input type="text" placeholder="<?php _e('Enter Shortcode generated using Contact form 7 plugin here.',APEXNB_TD);?>" 
                        name="edn_multiple[form_shortcode][<?php echo $count?>]" value="<?php if(isset($edn_bar_setting['edn_multiple']['form_shortcode'][$count]) && $edn_bar_setting['edn_multiple']['form_shortcode'][$count] != ''){echo esc_attr($final_shortcode);}?>" />
                    </div>
                </div>
            </div> 
        </div>
          <?php }else{ ?>
             <p class="edn-note">
           <?php  _e('Note: Please activate Contact Form 7 Plugin to integrate your shortcode.',APEXNB_TD); ?>
            </p>
            <?php } ?>
       
    </div>
</div>
</div><!-- #edn-contact-button-block -->
      <!-- shortcode support call to action here -->
    <div id="edn-slide-shortcode-popup-button-block" class="edn-slide-call-action edn-slide-call-action-<?php echo $count?> edn-shortcode-popup-but-block-<?php echo $count?>" style="display: none;">
                     <div id="edn-m-shortcode-button-block-<?php echo $count?>" class="edn-m-call-action">
                       <div class="ednshortcode-support" id="ednshortcode-support-<?php echo $count?>">
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Popup Button Text',APEXNB_TD);?></label>
                                <div class="edn-field">
                                    <input type="text" id="edn-m-shortcode-button-text" name="edn_multiple[popup_text][]"
                                    value="<?php if(isset($edn_bar_setting['edn_multiple']['popup_text'][$count]) && $edn_bar_setting['edn_multiple']['popup_text'][$count] != ''){echo esc_attr($edn_bar_setting['edn_multiple']['popup_text'][$count]);}?>"
                                    placeholder="<?php _e('Enter popup button text',APEXNB_TD);?>"/>
                               <p class="description">
                                 <?php  _e('On click Popup Button Text, the shortcode implemented will be displayed on popup.',APEXNB_TD); ?>
                                 </p>
                                </div>
                            </div>
                        </div>
                      
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Shortcode',APEXNB_TD);?></label>
                                <div class="edn-field">
                                    <input type="text" id="edn-m-custom-shortcode-<?php echo $count;?>" name="edn_multiple[shortcode_popup][]"
value="<?php if(isset($edn_bar_setting['edn_multiple']['shortcode_popup'][$count]) && $edn_bar_setting['edn_multiple']['shortcode_popup'][$count] != ''){echo esc_attr($edn_bar_setting['edn_multiple']['shortcode_popup'][$count]);}?>"
                                    placeholder="<?php _e('Enter any shortcode here.',APEXNB_TD);?>"/>
                                 <p class="description">
                                 <?php  _e('Enter any shortcode here that you will be displayed on popup. ',APEXNB_TD); ?>
                                 </p>
                                </div>
                            </div>
                        </div> 
                        </div>
                     </div>
</div>
                <!-- shortcode support call to action end-->  
                                                              

                                </div>
                            </div>
                        </div><!-- .edn-multiple-slide-down -->




                    </li>
                    <?php
                    $count++;
                }
            }
        }
        ?>

</ul>
        <div class="edn-col-full edn-add-mbutton">
            <div class="edn-well">
                <div class="edn-field-wrapper edn-form-field">
                    <div class="edn-field">
                        <input class="button button-secondary" id="edn-add-mcontent" type="button" value="Add Content" />
                    </div>
                </div>
            </div>
        </div>
        <div class="edn-add-multiple-content" style="display: none;">
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field">
                    <div class="edn-field">
                        <?php
                            $settings = array('textarea_name' => '','media_buttons' => false,);
                            wp_editor('','edn-multiple-text',$settings); 
                        ?>
                    </div>
                    <div class="edn-error"></div>
                </div>
            </div>
            <div class="edn-row">
                <div class="edn-col-full">
                    <div class="edn-field-wrapper edn-form-field">
                          <div class="edn-field">
                            <div class="edn-field-label-wrap">
                              <label class="edn-label-inline" for="edn-show-mcall">
                                <?php _e('Show call to action', APEXNB_TD); ?> 
                              </label>
                            </div>
                            <div class="edn-field-input-wrap">
                              <div class="apexnb-switch">
                                <input type="checkbox" id="edn-show-mcall" class="edn-show-m-call-button" value="1" />
                                <label for="edn-show-mcall"></label>
                              </div>
                            </div>
                       
                       </div>
                    </div>
                </div>
                <div class="edn-m-call-to-action-type" style="display: none;">
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Call to Action Type', APEXNB_TD); ?></label>
                            <div class="edn-field">
                                <label class="edn-label-inline">
                                    <input type="radio" name="edn_multi[action_button]" class="edn-call-action-type edn-m-call-action-type" value="custom" checked="checked" />
                                    <?php _e('Custom Button', APEXNB_TD); ?>
                                </label>
                                <label class="edn-label-inline">
                                    <input type="radio" name="edn_multi[action_button]" class="edn-call-action-type edn-m-call-action-type" value="contact" />
                                    <?php _e('Contact Form', APEXNB_TD); ?>
                                </label>
                                 <label class="edn-label-inline">
                                  <input type="radio" name="edn_multi[action_button]" class="edn-call-action-type edn-m-call-action-type" value="shortcode-popup" />
                                  <?php _e('Shortcode In Popup', APEXNB_TD); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="end-m-call-to-action-block" style="display: none;">
                <div id="edn-m-custom-button-block" class="edn-m-call-action">
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Link Button Text',APEXNB_TD);?></label>
                            <div class="edn-field">
                                <input type="text" id="edn-link-but-text" value="" placeholder="<?php _e('e.g: READ MORE',APEXNB_TD);?>"/>
                            </div>
                        </div>
                    </div>   
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Link Button URL',APEXNB_TD);?></label>
                            <div class="edn-field">
                                <input type="text" id="edn-link-url" value="" placeholder="<?php _e('e.g: https://www.accesspressthemes.com',APEXNB_TD);?>" />
                            </div>
                        </div>
                    </div>    
                      <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Link Target',APEXNB_TD);?></label>
                            <div class="edn-field">
                                <select id="edn-link-target">
                                 <option value="_blank"><?php _e('_blank',APEXNB_TD);?></option>
                                 <option value="_self"><?php _e('_self',APEXNB_TD);?></option>
                                 <option value="_parent"><?php _e('_parent',APEXNB_TD);?></option>
                                 <option value="_top"><?php _e('_top',APEXNB_TD);?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-third edn-hide-in-pre-tpl">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Link Button Color',APEXNB_TD);?></label>
                            <div class="edn-field">
                                <input type="text" id="edn-link-but-color" class="edn-color-picker" />
                            </div>
                        </div>
                    </div>    
                    <div class="edn-col-half edn-hide-in-pre-tpl">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Link Button Text Color',APEXNB_TD);?></label>
                            <div class="edn-field">
                                <input type="text" id="edn-link-but-text-color" class="edn-color-picker" />
                            </div>
                        </div>
                    </div>
                </div><!-- #edn-m-custom-button-block -->
                <div id="edn-m-contact-button-block" class="edn-m-call-action" style="display: none;">
                    <div class="edn-row">
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Contact Form Type', APEXNB_TD); ?></label>
                                <div class="edn-field">
                                    <label class="edn-label-inline">
                                        <input type="radio" name="edn_multi[choose]" class="edn-contact-choose edn-m-contact-choose" value="c-form" checked="checked"/>
                                        <?php _e('Default Form',APEXNB_TD);?>
                                    </label>
                                    <label class="edn-label-inline">
                                        <input type="radio" name="edn_multi[choose]" class="edn-contact-choose edn-m-contact-choose" value="form-7" />
                                        <?php _e('Contact Form 7',APEXNB_TD);?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
<div class="edn-row">
<div class="edn-contact-form-wrap">
    <div class="edn-row">
        <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
                <label><?php _e('Contact Button Text',APEXNB_TD);?></label>
                <div class="edn-field">
                    <input type="text" id="edn-cc-button-text" placeholder="<?php _e('e.g:Contact Us',APEXNB_TD);?>"/>
                </div>
            </div>
        </div>
    </div>
<!-- custom form for multiple text content start-->
<div class="edn-m-cotnact-from" id="edn-m-contact-custom-form">
    <div class="edn-row">
         <div class="edn-col-half">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-col-one-fourth edn-default-form">
                 <label><?php _e('Name Label',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-name-label" value="" placeholder="<?php _e('e.g:Name',APEXNB_TD);?>"/>
                        </div>
               </div>
               <div class="edn-col-one-fourth edn-default-form">
                <label><?php _e('Email Label',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-email-label" value="" placeholder="<?php _e('e.g:Email',APEXNB_TD);?>"/>
                        </div>
                </div>
               <div class="edn-col-one-fourth edn-default-form">

                 <label><?php _e('Message Label',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-msg-label" value="" placeholder="<?php _e('Message',APEXNB_TD);?>"/>
                        </div>
                  

                </div>
                </div>
            </div>
<div class="edn_clear"></div>
       <div class="edn-col-half">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-col-one-fourth edn-default-form">
                 <label><?php _e('Name Placeholder',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-name-placeholder" value="" 
                            placeholder="<?php _e('e.g:Your Name',APEXNB_TD);?>"/>
                        </div>
               </div>
               <div class="edn-col-one-fourth edn-default-form">
                <label><?php _e('Email Placeholder',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-email-placeholder" value="" 
                            placeholder="<?php _e('e.g:Your Email Address',APEXNB_TD);?>"/>
                        </div>
                </div>
                <div class="edn-col-one-fourth edn-default-form">
                   <label><?php _e('Message Placeholder',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-msg-placeholder" value="" placeholder="<?php _e('e.g.,Your Message.',APEXNB_TD);?>"/>
                        </div>
                   
                  </div>
                </div>
            </div>
  <div class="edn_clear"></div>
        <div class="edn-col-half">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-col-one-fourth edn-default-form">
                 <label><?php _e('Name Error Message',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-name-error" value="" placeholder="<?php _e('e.g:Please enter your name.',APEXNB_TD);?>"/>
                        </div>
               </div>
               <div class="edn-col-one-fourth edn-default-form">
                <label><?php _e('Email Error Message',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-email-error" value="" placeholder="<?php _e('e.g: Please enter email address',APEXNB_TD);?>"/>
                        </div>
                </div>
                <div class="edn-col-one-fourth edn-default-form">
                <label><?php _e('Valid Email Error Message',APEXNB_TD);?></label>
                    <div class="edn-field">
                     <input type="text" id="edn-cc-email-valid-error"
                     placeholder="<?php _e('e.g.,Please enter valid email address.',APEXNB_TD);?>"/>
                    </div>
                  </div>
                   <div class="edn-col-one-fourth edn-default-form">
                            <label><?php _e('Message Error Message',APEXNB_TD);?></label>
                            <div class="edn-field">
                                <input type="text" id="edn-cc-msg-error" value="" 
                                placeholder="<?php _e('Please enter message.',APEXNB_TD);?>"/>
                            </div>
                            </div>
                </div>
            </div>
            <div class="edn_clear"></div>
       
     </div>
            <!--class=edn-hide-in-pre-tpl-->
            <div class="edn_clear"></div>

            <div class="edn-col-half">
                                    <div class="edn-field-wrapper edn-form-field">
                                        <div class="edn-col-one-fourth edn-default-form">
                                        <div>
                                            <label class="edn-label-inline">
                                                 <?php _e('Name Required',APEXNB_TD);?>  
                                                 <input type="checkbox" id="edn-cc-name-required" value="1" />                                                              

                                            </label>
                                        </div>
                                        </div>
                                        <div class="edn-col-one-fourth edn-default-form">
                                        <div>
                                            <label class="edn-label-inline">
                                                <?php _e('Email Required',APEXNB_TD);?> 
                                                 <input type="checkbox" id="edn-cc-email-required" value="1" />   
                                            </label>
                                           
                                        </div>
                                        </div>
                                           <div class="edn-col-one-fourth edn-default-form">
                                            <div>
                                                <label class="edn-label-inline">
                                                    <?php _e('Message Required',APEXNB_TD);?>
                                                    <input type="checkbox" id="edn-cc-msg-required"  value="1" />
                                                </label>
                                                
                                            </div>
                                    </div>
                                    </div>
          </div>
          <div class="edn_clear"></div>
     
            <div class="edn-row">
              
                <div class="edn-col-half">
                    <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Send To Email',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-send-mail" value="" placeholder="<?php _e('E.g:support@accesspressthemes.com',APEXNB_TD);?>"/>
                           <p class="edn-note"><?php _e('Note: If above field left empty,email will be send to admin email.',APEXNB_TD);?></p>
                        </div>
                    </div>
                </div>
                <div class="edn-col-half">
                    <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Success Message',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-success-message" value="" placeholder="e.g.,Your message has been successfully sent."/>
                        </div>
                    </div>
                </div>
                <div class="edn-col-half">
                    <div class="edn-field-wrapper edn-form-field">
                        <label><?php _e('Fail Email Message',APEXNB_TD);?></label>
                        <div class="edn-field">
                            <input type="text" id="edn-cc-send-fail-msg" value="" placeholder="e.g.,Error sending message."/>
                                                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- custom form for multiple text content end-->
                            <div class="edn-m-cotnact-from" id="edn-m-contact-form-7" style="display: none;">
           <?php  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                     if ( is_plugin_active('contact-form-7/wp-contact-form-7.php') ) { 
                        ?>
                            
                                <div class="edn-col-full">
                                    <div class="edn-field-wrapper edn-form-field">
                                        <label><?php _e('Contact Form 7 Shortcode',APEXNB_TD);?></label>
                                        <div class="edn-field">
                                            <input type="text" id="edn-form-shortcode" value="" placeholder="<?php _e('Enter Shortcode generated using Contact form 7 plugin here.',APEXNB_TD);?>"/>
                                        </div>
                                    </div>
                                </div> 
                      
                              <?php }else{ ?>
                                 <p class="edn-note">
                               <?php  _e('Note: Please activate Contact Form 7 Plugin to integrate your shortcode.',APEXNB_TD); ?>
                                </p>
                                <?php } ?>
                                      </div>
                        </div>
                    </div>
                </div><!-- #edn-contact-button-block -->


  <!-- shortcode support call to action here -->
                     <div id="edn-m-shortcode-button-block" class="edn-m-call-action" style="display: none;">
                       <div class="ednshortcode-support" id="ednshortcode-support">
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Popup Button Text',APEXNB_TD);?></label>
                                <div class="edn-field">
                                    <input type="text" id="edn-m-shortcode-button-text" placeholder="<?php _e('Enter popup button text',APEXNB_TD);?>"/>
                               <p class="description">
                                 <?php  _e('On click Popup Button Text, the shortcode implemented will be displayed on popup.',APEXNB_TD); ?>
                                 </p>
                                </div>
                            </div>
                        </div>
                        <div class="edn-col-full">
                            <div class="edn-field-wrapper edn-form-field">
                                <label><?php _e('Shortcode',APEXNB_TD);?></label>
                                <div class="edn-field">
                                    <input type="text" value="" id="edn-m-custom-shortcode" placeholder="<?php _e('Enter any shortcode here.',APEXNB_TD);?>"/>
                                 <p class="description">
                                 <?php  _e('Enter any shortcode here that you will be displayed on popup. ',APEXNB_TD); ?>
                                 </p>
                                </div>
                            </div>
                        </div> 
                        </div>
                     </div>
                <!-- shortcode support call to action end-->    


            </div>
           <div class="edn_clear"></div>
            <div class="edn-col-full edn-clear">
                <div class="edn-well">
                    <div class="edn-field-wrapper edn-form-field">
                        <div class="edn-field">
                            <input class="button button-primary" id="edn-add-mcontent-but" type="button" value="Add" />
                            <input type="hidden" class="edn-button-count" value="0" data-error-text-cont="<?php _e('Please enter some text.',APEXNB_TD);?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end of edn-add-multiple-content -->

    </div>
</div>            
</div>

<!------------------------------------------Subscribe FORM------------------------------------------>
<div class="edn-cp-block" id="edn-cp-subscribe" style="display: none;">
<div class="edn-row">
    <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
            <label><?php _e('Subscribe Form Type', APEXNB_TD); ?></label>
            <div class="edn-field">
                <label class="edn-label-inline">
                    <input type="radio" name="edn_subs_choose" value="subs-c-form" <?php if($edn_bar_setting['edn_subs_choose']=='subs-c-form'){echo 'checked="checked"';}?> />
                    <?php _e('Custom Form',APEXNB_TD);?>
                </label>
                <label class="edn-label-inline">
                    <input type="radio" name="edn_subs_choose" value="mailchip" <?php if($edn_bar_setting['edn_subs_choose']=='mailchip'){echo 'checked="checked"';}?> />
                    <?php _e('Mailchimp Form',APEXNB_TD);?>
                </label>
                <label class="edn-label-inline">
                    <input type="radio" name="edn_subs_choose" value="constant-contact" <?php if($edn_bar_setting['edn_subs_choose']=='constant-contact'){echo 'checked="checked"';}?> />
                    <?php _e('Constant Contact Form',APEXNB_TD);?>
                </label> 
              
            </div>
        </div>
    </div>
</div>
<div class="edn-row">
     <div class="edn-subscribe-form-wrap">
             <!-- SUB custom-form -->
            <div class="edn-subs-from" id="edn-subs-custom-form">    
              <?php include(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/sub-custom.php');?>        
            </div>
            <!-- SUB custom-form -->
            
            <!--Mailchimp form-->  
            <div class="edn-subs-from" id="edn-subs-mailchip-form" style="display: none;">      
               <?php include(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/mailchimp-form.php');?>      
            </div>
            <!--Mailchimp form-->

            <!-- Constant Contact form -->
            <div class="edn-subs-from" id="edn-subs-constant-contact-form" style="display: none;">       
                 <?php include(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/constant-contact.php');?>         
            </div>   

       <div class="apexnb-email-setup">
        <div class="apexnb-notifybar">
          <p class="edn-note"><?php _e("You need to enable email Confirmation to send an email with below subject and message to subscribers.",APEXNB_TD);?></p>
           </div>
         <div class="edn-col-full">
            <div class="edn-field-wrapper edn-form-field">
                <div class="edn-field">
                    <div class="edn-field-label-wrap">
                      <label class="edn-label-inline">
                          <?php _e('Email Subject', APEXNB_TD); ?></label>
                           <p class="edn-note"><?php _e('Fill subject to send subscribe users.If left empty, default value will be set "Subscribe Confirmation Email".',APEXNB_TD);?></p></div>
                           <div class="edn-field-input-wrap">
                          <input type="text" class="edn_subs_email_subject" name="edn_subs_custom[email_subject]" 
                          value="<?php if(isset($edn_bar_setting['edn_subs_custom']['email_subject'])) echo $edn_bar_setting['edn_subs_custom']['email_subject'];?>" placeholder="<?php _e('Subscribe Confirmation Email',APEXNB_TD);?>"/>
                         
                      </div>
                 </div>
                 <div class="edn-field">
                   <div class="edn-field-label-wrap"> <label class="edn-label-inline">
                        <?php _e('Write Message To Subscribers:', APEXNB_TD); ?>
                         </label>
                         <p class="edn-note"><?php _e('Set Message to subscriber and send an email to them.',APEXNB_TD);?></p></div>
                          <div class="edn-field-input-wrap">
                          <?php
                          $message_to_subscribers = (isset($edn_bar_setting['edn_subs_custom']['message']) && $edn_bar_setting['edn_subs_custom']['message'] != '')?$edn_bar_setting['edn_subs_custom']['message']:'';
                        
                           $settingss = array(
                               'textarea_name' => 'edn_subs_custom[message]',
                               'media_buttons' => false,
                               'editor_height' => 180,
                               'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close,br' ), 
                            );
                           wp_editor(html_entity_decode($message_to_subscribers),'apexnb-subscriber-message',$settingss); 
                          ?>
                        
                     </div>
               </div>
            </div>
          </div>
        </div>     
        </div><!-- .edn-subscribe-form-wrap -->
  

</div>

</div>
<!------------------------------------------Subscribe FORM END------------------------------------------>

<!------------------------------------------Twitter FEEDS Start------------------------------------------>                   
<div class="edn-cp-block" id="edn-twitter-feeds" style="display: none;">
         <?php include(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/twitter-setup.php');?>    
</div>
<!------------------------------------------Twitter FEEDS END------------------------------------------> 

<!------------------------------------------POST TITLE Start------------------------------------------>    
<div class="edn-cp-block" id="edn-post-title" style="display: none;">        
        <?php include(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/recent-posts.php');?>                            
</div>
<!------------------------------------------POST TITLE END------------------------------------------>    
<!------------------------------------------RSS FEED START------------------------------------------>   
<div class="edn-cp-block" id="edn-rss-feed" style="display: none;">
        <?php include(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/rss-feed.php');?>               
</div>
<!------------------------------------------RSS FEED END------------------------------------------>  
<!------------------------------------------COUNTDOWN TIMER START------------------------------------------>  
<div class="edn-cp-block" id="edn-countdown-timer">
       <?php include(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/countdown-timer.php');?>            
</div>
<!------------------------------------------COUNTDOWN TIMER END------------------------------------------>  
<!------------------------------------------Video Popup Start------------------------------------------>  
<div class="edn-cp-block" id="edn-video-popup">
     <?php include(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/video-popup.php');?>       
</div>
<!------------------------------------------Video Popup END------------------------------------------>  
<!-- custom html start --> 
<div class="edn-cp-block" id="edn-custom-html-content" style="display: none;">             
    <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
            <div class="edn-field">
                <?php
                $custom_content = (isset($edn_bar_setting['edn_custom_html']['content']) && $edn_bar_setting['edn_custom_html']['content'] != '')?$edn_bar_setting['edn_custom_html']['content']:'';
              
                 $settings = array(
                    'textarea_name' => 'edn_custom_html[content]',
                    'media_buttons' => true,
                    'editor_height' => 180,
                  );
                 wp_editor($custom_content,'edn-html-content',$settings); 
                ?>
                <p class="edn-note"><?php _e("Any custom HTML that you want to display to this notification bar.",APEXNB_TD)?></p>
            </div>
        </div>
    </div>
</div>
 <!-- custom html end --> 
<!-- search form -->
<div class="edn-cp-block" id="edn-search-form-content" style="display: none;">
         <?php include(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/search-form.php');?> 
</div>
<!-- search form end -->

<div class="edn-bar-effects" style="display: none;">
          <div class="edn-row">
              <div class="edn-col-full">
                  <div class="edn-group-chooser">
                      <div class="edn-field-wrapper edn-form-field">
                          <label><?php _e('Notification Bar Effects', APEXNB_TD); ?></label>
                          <div class="edn-field">
                              <label class="edn-label-inline">
                                  <input type="radio" name="edn_bar_effect_option" value="1" <?php if($edn_bar_setting['edn_bar_effect_option']==1){echo 'checked="checked"';}?> />
                                  <?php _e('Ticker', APEXNB_TD); ?>
                              </label>
                              <label class="edn-label-inline">
                                  <input type="radio" name="edn_bar_effect_option" value="2" <?php if($edn_bar_setting['edn_bar_effect_option']==2){echo 'checked="checked"';}?> />
                                  <?php _e('Slider', APEXNB_TD); ?>
                              </label>
                              <label class="edn-label-inline">
                                  <input type="radio" name="edn_bar_effect_option" value="3" <?php if($edn_bar_setting['edn_bar_effect_option']==3){echo 'checked="checked"';}?> />
                                  <?php _e('Scroller', APEXNB_TD); ?>
                              </label>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        <div class="edn-efect-block-wrap">
            <div class="edn-bar-efect-block" id="edn-bar-ticker" style="display: none;">
                <div class="edn-row">
                  
                     <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Title Text', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_ticker[title_text]" placeholder="<?php _e('E.g: Latest', APEXNB_TD); ?>"
                                 value="<?php if(isset($edn_bar_setting['edn_ticker']['title_text'])) echo esc_attr($edn_bar_setting['edn_ticker']['title_text']);?>"/>
                                  <p class="edn-note"><?php _e('Ticker Title text on left side of ticker content',APEXNB_TD);?></p>
                            </div>
                        </div>
                    </div> 
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Speed', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_ticker[speed]" value="<?php echo esc_attr($edn_bar_setting['edn_ticker']['speed']);?>" placeholder="E.g.,0.10"/>
                                <p class="edn-note">
                                <?php _e('Note: Speed of ticker slide should be in point such as 0.10,0.20.Other number will not be used for ticker.Min Speed:0.10 , Max Speed:0.9.Default speed if left empty:0.10', APEXNB_TD); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Direction', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                <select name="edn_ticker[direction]" class="edn-ticker-direction apexnb-selection">
                                    <option value="horizontal" <?php if($edn_bar_setting['edn_ticker']['direction']=='horizontal'){echo 'selected="selected"';}?>><?php _e('Horizontal',APEXNB_TD)?></option>
                                    <option value="vertical" <?php if($edn_bar_setting['edn_ticker']['direction']=='vertical'){echo 'selected="selected"';}?>><?php _e('Vertical',APEXNB_TD)?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                        <div class="edn-col-one-third edn-hide-in-pre-tpl">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Ticker Title Background Color', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                 <input type="text" name="edn_ticker_bg_color" id="edn_ticker_bg_color" class="edn-color-picker" value="<?php if(isset($edn_bar_setting['edn_ticker_bg_color'])){echo esc_attr($edn_bar_setting['edn_ticker_bg_color']);}?>" />
                            </div>
                        </div>
                    </div>
                     <div class="edn-col-one-third edn-hide-in-pre-tpl">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Ticker Title Font Color', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                 <input type="text" name="edn_ticker_font_color" id="edn_ticker_font_color" class="edn-color-picker" value="<?php if(isset($edn_bar_setting['edn_ticker_font_color'])){echo esc_attr($edn_bar_setting['edn_ticker_font_color']);}?>" />
                            </div>
                        </div>
                    </div>
                     <div class="edn-col-one-third edn-hide-in-pre-tpl">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                             <label class="edn-label-inline" for="tickerpause">
                                <?php _e('Ticker Pause on Hover', APEXNB_TD) ?>
                                </label>
                            <div class="edn-field">
                                  <div class="apexnb-switch">
                                <input type="checkbox" id="tickerpause" name="edn_ticker[hover]" value="1" <?php if(isset($edn_bar_setting['edn_ticker']['hover'])&&$edn_bar_setting['edn_ticker']['hover']==1){echo 'checked="checked"';}?> />
                               <label class="edn-label-inline" for="tickerpause"></label>
                              </div>
                            </div>
                        </div>
                    </div>


                </div>
                
                <div class="edn-clear"></div>
  
            </div><!---------------------------->
            
            <div class="edn-bar-efect-block" id="edn-bar-slider" style="display: none;">
                <div class="edn-row">
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Duration', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_slider[duration]" value="<?php echo esc_attr($edn_bar_setting['edn_slider']['duration']);?>" />
                                <p class="edn-note"><?php _e('Note: Duration between each slide in milliseconds(pause).',APEXNB_TD);?></p>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Transition', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_slider[speed]" value="<?php echo esc_attr($edn_bar_setting['edn_slider']['speed']);?>" />
                                <p class="edn-note"><?php _e('Note: Duration of each slide in milliseconds(speed).',APEXNB_TD);?></p>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Auto', APEXNB_TD) ?></label>
                             <div class="edn-field">
                                <select name="edn_slider[auto]" class="apexnb-selection">
                                    <option value="true" <?php if(isset($edn_bar_setting['edn_slider']['auto']) && $edn_bar_setting['edn_slider']['auto']=='true'){echo 'selected="selected"';}?>><?php _e('True',APEXNB_TD)?></option>
                                    <option value="false" <?php if(isset($edn_bar_setting['edn_slider']['auto']) && $edn_bar_setting['edn_slider']['auto']=='false'){echo 'selected="selected"';}?>><?php _e('False',APEXNB_TD)?></option>     
                                </select>
                           <p class="edn-note"><?php _e('Note:If Choose true, slides will automatically transition.Default Value:true',APEXNB_TD);?></p>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Animation type', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                <select name="edn_slider[animation]" class="edn-ticker-direction apexnb-selection">
                                    <option value="horizontal" <?php if($edn_bar_setting['edn_slider']['animation']=='horizontal'){echo 'selected="selected"';}?>><?php _e('Slide',APEXNB_TD)?></option>
                                    <!-- <option value="vertical" < ?php if($edn_bar_setting['edn_slider']['animation']=='vertical'){echo 'selected="selected"';}?>>< ?php _e('Vertical Slide',APEXNB_TD)?></option> -->
                                    <option value="fade" <?php if($edn_bar_setting['edn_slider']['animation']=='fade'){echo 'selected="selected"';}?>><?php _e('Fade',APEXNB_TD)?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-third">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Adaptive Height', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                <select name="edn_slider[adaptive_height]" class="edn-adaptive_height apexnb-selection">
                                    <option value="true" <?php if(isset($edn_bar_setting['edn_slider']['adaptive_height']) && $edn_bar_setting['edn_slider']['adaptive_height']=='true'){echo 'selected="selected"';}?>><?php _e('True',APEXNB_TD)?></option>
                                  
                                    <option value="false" <?php if(isset($edn_bar_setting['edn_slider']['adaptive_height']) && $edn_bar_setting['edn_slider']['adaptive_height']=='false'){echo 'selected="selected"';}?>><?php _e('False',APEXNB_TD)?></option>
                                </select>
                                <p class="edn-note"><?php _e('Dynamically adjust slider height based on each slider height.Default is set as true',APEXNB_TD);?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="edn-clear"></div>
                
                <div class="edn-col-full edn-field-space">
                    <div class="edn-field-wrapper edn-design-reference edn-form-field">
                        <div class="edn-field">
                           <div class="edn-field-label-wrap">
                               <label class="edn-label-inline" for="ednslidercontrols">
                                <?php _e('Slider Controls', APEXNB_TD) ?>
                              </label>
                            </div>
                              <div class="edn-field-input-wrap">
                                  <div class="apexnb-switch">
                                  <input type="checkbox" id="ednslidercontrols"  name="edn_slider[controls]" value="1" <?php if(isset($edn_bar_setting['edn_slider']['controls'])&&$edn_bar_setting['edn_slider']['controls']==1){echo 'checked="checked"';}?> />
                                 <label for="ednslidercontrols"></label>
                                  </div>
                               </div> 
                        </div>
                    </div>
                </div>
            </div><!---------------------------->
            
            <div class="edn-bar-efect-block" id="edn-bar-scroll" style="display: none;">
                <div class="edn-row">
                    <div class="edn-col-one-fourth">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Title Text', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_scroll[title_text]" placeholder="<?php _e('E.g: Latest', APEXNB_TD); ?>" value="<?php if(isset($edn_bar_setting['edn_scroll']['title_text'])){echo esc_attr($edn_bar_setting['edn_scroll']['title_text']);}?>" />
                             <p class="edn-note">
                                <?php _e('Scroller Title text on left side of scroller content',APEXNB_TD);?></p>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-fourth">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Speed', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                <input type="text" name="edn_scroll[speed]" placeholder="<?php _e('eg. 0.10');?>" value="<?php if(isset($edn_bar_setting['edn_scroll']['speed'])){echo esc_attr($edn_bar_setting['edn_scroll']['speed']);}?>" />
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-fourth">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Direction', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                <select name="edn_scroll[direction]" class="apexnb-selection">
                                    <option value="ltr" <?php if(isset($edn_bar_setting['edn_scroll']['direction']) && $edn_bar_setting['edn_scroll']['direction']=='ltr'){echo 'selected="selected"';}?>><?php _e('Left To Right',APEXNB_TD);?></option>
                                    <option value="rtl" <?php if(isset($edn_bar_setting['edn_scroll']['direction']) && $edn_bar_setting['edn_scroll']['direction']=='rtl'){echo 'selected="selected"';}?>><?php _e('Right To Left',APEXNB_TD);?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="edn-col-one-fourth">
                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                            <label><?php _e('Animation type', APEXNB_TD) ?></label>
                            <div class="edn-field">
                                <select name="edn_scroll[animation]" class="apexnb-selection">
                                    <option value="reveal" <?php if(isset($edn_bar_setting['edn_scroll']['animation']) && $edn_bar_setting['edn_scroll']['animation']=='reveal'){echo 'selected="selected"';}?>><?php _e('Reveal',APEXNB_TD)?></option>
                                    <option value="fade" <?php if(isset($edn_bar_setting['edn_scroll']['animation']) && $edn_bar_setting['edn_scroll']['animation']=='fade'){echo 'selected="selected"';}?>><?php _e('Fade',APEXNB_TD)?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="edn-clear"></div>
                
                <div class="edn-col-full edn-field-space">
                    <div class="edn-field-wrapper edn-design-reference edn-form-field">
                        <div class="edn-field">
                           
                        </div>
                    </div>
                </div>
                <div class="edn-clear"></div>
            </div>
        </div><!-- .edn-efect-block-wrap -->
    </div><!-------- .edn-bar-effects -->

      </div>
   </div><!-- edn compontenet wrap -->
 </div>
<?php #include_once dirname(__FILE__) . '/../components-settings/custom_open_panel.php'; ?>
   <?php include_once(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/custom_open_panel.php');?> 
</div><!-- edn-show-compontens clsoe -->


  </div><!-- End .edn-left-controls-wrap -->
</div><!-- Edn .edn-row -->
<!-- <div class="edn-clear"></div> -->
