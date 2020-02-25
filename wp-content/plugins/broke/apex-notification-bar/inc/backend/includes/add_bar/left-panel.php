<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
     <div class="edn-col-full edn_nb_title">
            <div class="edn-field-wrapper edn-form-field">
                 <div class="edn-field">
                 <div class="edn-field-label-wrap apex-header"><label class="edn_labelname"><?php _e('Name of Bar', APEXNB_TD); ?></label></div>
                 <div class="edn-field-input-wrap apex-main-title">
                    <div class="ednbar_name">
                        <input type="text" name="edn_bar_name" value=""
                         data-error-msg="<?php _e('Please enter the notification bar name',APEXNB_TD);?>" /> *
                        <div class="edn-error" id="edn-error-name"></div>
                        <input type="hidden" class="edn-hidden-bar-name" value="" />
                    </div>
                </div>  
                </div>             
            </div><!--edn-field-wrapper-->
        </div>
    <div class="edn-row">
        <div class="edn-col-full layout_section">
            <div class="edn-group-chooser">
                <div class="edn-field-wrapper edn-form-field">
                    <!-- <label class="ednpro_label"> -->
                     <div class="edn-inner-main-title" id="layout" style="cursor:pointer;">
                       <?php _e('Notification Bar Layout', APEXNB_TD); ?>
                      <div class="arrow-up" style="display:none;"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
                         <div class="arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                    <!-- </label> -->
                    <div class="edn-bar-template apexnb-main-wrapper-toggle" style="display:none;">
                      <p class="description"><?php _e('Choose either pre available template or custom template in order to display
                      notification bar with your own custom designs.', APEXNB_TD); ?></p>
                       <div class="edn-field choose-edn-bar">
                        <label class="edn-label-inline">
                            <input type="radio" name="edn_bar_type" value="2" checked="checked" />
                            <?php _e('Pre available template', APEXNB_TD); ?>
                        </label>
                        <label class="edn-label-inline">
                            <input type="radio" name="edn_bar_type" id="edn_individual" value="1" />
                            <?php _e('Custom design', APEXNB_TD); ?>
                        </label>
                        
                    </div>
                  
                      <?php include_once(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/bar-template.php');?>
                      </div>
                </div>
            </div>
        </div>
    </div><!-- Edn .edn-row -->

<!-- Logo Image Section -->

<div class="edn-row apexnb_logo_toggle_wrapper">
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
                                  <input type='checkbox' id="activelogo" name='edn_logo_section[enable_logo]' value='true'/>
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
                                    value="" />
                                    <input type="button" class="apexnb_logoimage_url_button button button-primary"  value="Upload Logo Image" size="25"/>                                         
                                        <div class="apexnb-option-field apexnb-image-preview" style="display:none;">
                                          <img  class="apexnb-image" src="" alt=""  width="250">
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
                                <input type="url" name="edn_logo_section[url_link]" value=""  placeholder="https://www.accesspressthemes.com" class="apexnb-fixed-width" />
                                 <p class="description"><?php _e('Fill the valid url link starts from https://', APEXNB_TD); ?></p>
                              </div> 
                         </div>

                    <div class="edn-field clearfix">
                         <div class="edn-field-label-wrap">
                           <label for="url_target"><?php _e("URL Target", APEXNB_TD) ?></label>
                          </div>

                        <div class="edn-field-input-wrap">
                            <select name="edn_logo_section[link_target]" class="apexnb-selection">
                             <option value="_self"><?php _e('_self',APEXNB_TD);?></option>
                             <option value="_blank"><?php _e('_blank',APEXNB_TD);?></option>
                             <option value="_parent"><?php _e('_parent',APEXNB_TD);?></option>
                             <option value="_top"><?php _e('_top',APEXNB_TD);?></option>
                            </select>
                             <p class="description"><?php _e('Set Link Target.', APEXNB_TD); ?></p>
                        </div>
                    </div>
          
                    <div class="edn-field clearfix">
                         <div class="edn-field-label-wrap">
                            <label for="image_width"><?php _e("Image Width", APEXNB_TD) ?></label>
                         </div>
                         <div class="edn-field-input-wrap">
                              <input type="number" name="edn_logo_section[image_width]" value="" />
                               <p class="description"><?php _e('Set Custom Image Width in pixel.', APEXNB_TD); ?></p>
                         </div> 
                    </div>
                    
                   
                    <div class="edn-field">
                       <div class="edn-field-label-wrap">
                            <label for="image_height"><?php _e("Image Height", APEXNB_TD) ?></label>
                        </div>
                         <div class="edn-field-input-wrap">
                                <input type="number" name="edn_logo_section[image_height]" value="" />
                               <p class="description"><?php _e('Set Custom Image Height in pixel.', APEXNB_TD); ?></p>
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
                                  <input type='checkbox' id="enable_bgimage" name='edn_background_image[enable_bgimage]' value='true'/>
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
                                    value="" />
                                    <input type="button" class="apexnb_logoimage_url_button button button-primary"  value="Upload Background Image" size="25"/> 
                                        
                                        <div class="apexnb-option-field apexnb-image-preview" style="display:none;">
                                          <img  class="apexnb-image" src="" alt=""  width="250">
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
            <!-- <div class="edn-backend-inner-title"> -->
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
                                        <input type="checkbox" name="edn_social_optons" id="edn-social-network" value="1" />
                                        <label for="edn-social-network"></label>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

               <div class="edn-col-half edn-social-panel-wrap" style="display: none;">
                 <div class="edn-backend-inner-title">
                 <?php _e('Add Social Icons', APEXNB_TD); ?></div>
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Social Heading Text',APEXNB_TD)?></label>
                            <div class="edn-field">
                                <input type="text"id="edn-social-heading-text" name="edn_social_heading_text" value="" placeholder="<?php _e('E.g: Follow Us On',APEXNB_TD);?>"/>
                            </div>
                            <div class="edn-error"></div>
                        </div><!--edn-field-wrapper-->

                    <div class="edn-custom-social-color">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Social Heading Text Color',APEXNB_TD)?></label>
                            <div class="edn-field">
                                <input type="text" id="edn-social-heading-text-color" name="edn_social_heading_color" value="" />
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
                            <a href="javascript:void(0);" class="edn-icon-theme-expand button button-secondary button-small" style="display:none"><?php _e('Expand All', APEXNB_TD); ?></a>
                        </div>
                        <div class="edn-icon-list-wrapper">
                            <p class="edn-empty-icon-note">Empty List</p>
                            <div class="edn-icon-note" style="display: none"><?php _e('Each Icon will only show up in the frontend if icon link is not empty', APEXNB_TD); ?></div>
                            <ul class="edn-icon-list">
                            </ul>
                        </div>
                        <!-- Social form panel/column -->
                        <div class="edn-social-form-panel">
                              <?php include(APEXNB_PRO_PATH.'inc/backend/includes/social-icons-add.php');?>
                        </div>
                        <!-- Social form panel/column -->
                    </div>
                </div>



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
                               <input type="checkbox" name="edn_right_optons" id="edn-notification-comp" value="1" />
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
                              <option value="text"><?php _e('Text (Custom html codes)',APEXNB_TD);?></option>
                              <option value="email-subs"><?php _e('Opt-in form',APEXNB_TD);?></option>
                              <option value="twiter-tweets"><?php _e('Twitter tweets',APEXNB_TD);?></option>
                              <option value="post-title"><?php _e('Post Title',APEXNB_TD);?></option>
                              <option value="rss-feed"><?php _e('RSS Feed',APEXNB_TD);?></option>
                              <option value="countdown-timer"><?php _e('CountDown Timer',APEXNB_TD);?></option>
                              <option value="video-popup"><?php _e('Video Popup',APEXNB_TD);?></option>
                              <option value="custom-html"><?php _e('Custom HTML',APEXNB_TD);?></option>
                              <option value="search-form"><?php _e('Search Form',APEXNB_TD);?></option>
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
                                            <input type="radio" name="edn_text_display_mode" class="edn-text-mode" value="static" checked="checked" />
                                            <?php _e('Static Content', APEXNB_TD); ?>
                                        </label>
                                        <label class="edn-label-inline">
                                            <input type="radio" name="edn_text_display_mode" class="edn-text-mode" value="multiple" />
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
                                                $settings = array('textarea_name' => 'edn_static[text]','media_buttons' => false);
                                                wp_editor('','edn-static-text',$settings); 
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
                                                   <label class="edn-label-inline" for="edn_static_cta">
                                                    <?php _e('Show call to action', APEXNB_TD); ?>
                                                    </label>
                                                   </div>
                                                    <div class="edn-field-input-wrap">
                                                    <div class="apexnb-switch">
                                                      <input type="checkbox" name="edn_static[call-to-action]" 
                                                      class="edn-show-call-button" value="1" id="edn_static_cta"/>
                                                     <label for="edn_static_cta"></label>
                                                   </div>
                                                   </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="edn-call-to-action-type" style="display: none;">
                                        <div class="edn-col-full">
                                            <div class="edn-field-wrapper edn-form-field">
                                                <label><?php _e('Call to action type', APEXNB_TD); ?></label>
                                                <div class="edn-field">
                                                    <label class="edn-label-inline">
                                                        <input type="radio" name="edn_static[call_action_button]" class="edn-call-action-type" value="custom" checked="checked" />
                                                        <?php _e('Custom Button', APEXNB_TD); ?>
                                                    </label>
                                                    <label class="edn-label-inline">
                                                        <input type="radio" name="edn_static[call_action_button]" class="edn-call-action-type" value="contact" />
                                                        <?php _e('Contact Button', APEXNB_TD); ?>
                                                    </label>
                                                     <label class="edn-label-inline">
                                                        <input type="radio" name="edn_static[call_action_button]" class="edn-call-action-type" value="shortcode-popup" />
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
                                                    <input type="text" name="edn_static[but_text]" placeholder="<?php _e('e.g: READ MORE',APEXNB_TD);?>" value="" />
                                                <p class="edn-note"><?php _e('If link title Left empty,then default value will be set as READ MORE.',APEXNB_TD);?></p>
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="edn-col-full">
                                        <div class="edn-field-wrapper edn-form-field">
                                            <label><?php _e('Link Button URL',APEXNB_TD);?></label>
                                              <div class="edn-field">
                                                 <input type="text" name="edn_static[but_url]" placeholder="<?php _e('e.g: https://www.accesspressthemes.com',APEXNB_TD);?>" value="" />
                                              </div>
                                          </div>
                                        </div>   
                                        <div class="edn-col-full">
                                         <div class="edn-field-wrapper edn-form-field">
                                               <label><?php _e('Link Target',APEXNB_TD);?></label>
                                                  <div class="edn-field">
                                                       <select name="edn_static[link_target]" class="apexnb-selection">
                                                     <option value="_blank"><?php _e('_blank',APEXNB_TD);?></option>
                                                     <option value="_self"><?php _e('_self',APEXNB_TD);?></option>
                                                     <option value="_parent"><?php _e('_parent',APEXNB_TD);?></option>
                                                     <option value="_top"><?php _e('_top',APEXNB_TD);?></option>
                                                    </select>
                                                  </div>
                                          </div>
                                        </div>     
                                    <div class="edn-col-full edn-hide-in-pre-tpl">
                                      <div class="edn-field-wrapper edn-form-field">
                                           <div class="edn-field">
                                              <div class="edn-field-label-wrap"><label><?php _e('Link Button Color',APEXNB_TD);?></label></div>
                                              <div class="edn-field-input-wrap">
                                                  <input type="text" name="edn_static[but_color]" class="edn-color-picker" value="" />
                                              </div>
                                              </div>
                                          </div>
                                      </div>    
                                      <div class="edn-col-full edn-hide-in-pre-tpl">
                                          <div class="edn-field-wrapper edn-form-field">
                                          <div class="edn-field">
                                              <div class="edn-field-label-wrap"><label><?php _e('Link Button Font Color',APEXNB_TD);?></label></div>
                                              <div class="edn-field-input-wrap">
                                                  <input type="text" name="edn_static[but_font_color]" class="edn-color-picker" value="" />
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
                                                            <input type="radio" name="edn_static[contact_choose]" class="edn-contact-choose" value="c-form" checked="checked"/>
                                                            <?php _e('Default Form',APEXNB_TD);?>
                                                        </label>
                                                        <label class="edn-label-inline">
                                                            <input type="radio" name="edn_static[contact_choose]" class="edn-contact-choose" value="form-7" />
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
                                                                <input type="text" name="edn_static[contact_btn_text]" placeholder="<?php _e('e.g:Contact Us',APEXNB_TD);?>"/>
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
                                                                    <input type="text" name="edn_static[name_label]" value="" placeholder="<?php _e('e.g:Name',APEXNB_TD);?>"/>
                                                                </div>
                                                               </div>
                                                               <div class="edn-col-one-fourth edn-default-form">
                                                                <label><?php _e('Name Placeholder',APEXNB_TD);?></label>
                                                                <div class="edn-field">
                                                                    <input type="text" name="edn_static[name_placeholder]" value="" placeholder="<?php _e('e.g:Your Name',APEXNB_TD);?>"/>
                                                                </div>
                                                                </div>
                                                               <div class="edn-col-one-fourth edn-default-form">
                                                                <label><?php _e('Name Error Message',APEXNB_TD);?></label>
                                                                <div class="edn-field">
                                                                  <input type="text" name="edn_static[name_error_msg]" 
                                                                  placeholder="<?php _e('e.g:Please enter your name.',APEXNB_TD);?>" value=""/>

                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="edn-col-half">
                                                            <div class="edn-field-wrapper edn-form-field">
                                                            <div class="edn-col-one-fourth edn-default-form">
                                                                <label><?php _e('Email Label',APEXNB_TD);?></label>
                                                                <div class="edn-field">
                                                                    <input type="text" name="edn_static[email_label]" value="" placeholder="<?php _e('e.g:Email',APEXNB_TD);?>"/>
                                                                </div>
                                                                </div>
                                                            <div class="edn-col-one-fourth edn-default-form">
                                                                <label><?php _e('Email Placeholder',APEXNB_TD);?></label>
                                                                <div class="edn-field">
                                                                    <input type="text" name="edn_static[email_placeholder]" value="" placeholder="<?php _e('e.g:Your Email Address',APEXNB_TD);?>"/>                                                                </div>
                                                                 </div>
                                                            <div class="edn-col-one-fourth edn-default-form">
                                                                <label><?php _e('Email Error Message',APEXNB_TD);?></label>
                                                                <div class="edn-field">
                                                                <input type="text" name="edn_static[email_error_msg]" 
                                                                placeholder="<?php _e('e.g: Please enter valid email address',APEXNB_TD);?>" value=""/>
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
                                                                        <?php _e('Name Required',APEXNB_TD);?> </label>
                                                                    </div>
                                                                    <div class="edn-field-input-wrap">
                                                                           <div class="apexnb-switch">
                                                                        <input type="checkbox" id="edn_static_name_req" name="edn_static[name_required]" value="1"/>
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
                                                                        <input type="checkbox" id="edn_static_email_req" name="edn_static[email_required]" value="1"/>
                                                                       <label for="edn_static_email_req"></label>
                                                                    </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                </div>
                                                                <div class="edn-col-one-fourth edn-default-form">
                                                                <div class="edn-field">
                                                                  <div class="edn-field-label-wrap">
                                                                    <label class="edn-label-inline" for="edn_static_message_req">
                                                                        <?php _e('Message Required',APEXNB_TD);?></label></div>
                                                                       <div class="edn-field-input-wrap">
                                                                           <div class="apexnb-switch">  
                                                                            <input type="checkbox" id="edn_static_message_req" name="edn_static[msg_required]" value="1"/>
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
                                                                    <input type="text" name="edn_static[msg_label]" value=""  placeholder="<?php _e('Message',APEXNB_TD);?>"/>
                                                                </div>
                                                              </div>
                                                             <div class="edn-col-one-fourth edn-default-form">
                                                                <label><?php _e('Message Placeholder',APEXNB_TD);?></label>
                                                                <div class="edn-field">
                                                                    <input type="text" name="edn_static[msg_placeholder]" value="" placeholder="<?php _e('Your Message',APEXNB_TD);?>"/>
                                                                </div>
                                                                </div>
                                                                   <div class="edn-col-one-fourth edn-default-form">
                                                                <label><?php _e('Message Error Message',APEXNB_TD);?></label>
                                                                <div class="edn-field">
                                                                    <input type="text" name="edn_static[msg_error]" value="" placeholder="<?php _e('Please enter message.',APEXNB_TD);?>"/>
                                                                </div>
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                        <div class="edn_clear"></div>
                                                        <div class="edn-col-half">
                                                            <div class="edn-field-wrapper edn-form-field">
                                                                <label><?php _e('Send To Email',APEXNB_TD);?></label>
                                                                <div class="edn-field">
                                                                    <input type="text" name="edn_static[send_to_mail]" id="edn-send-mail-field" value="" placeholder="<?php _e('E.g:support@accesspressthemes.com',APEXNB_TD);?>"/>
                                                                </div>
                                                                <p class="edn-note"><?php _e('Note: If left empty, email will be send to admin email.',APEXNB_TD);?></p>
                                                            </div>
                                                        </div>
                                                          <div class="edn-col-half">
                                                            <div class="edn-field-wrapper edn-form-field">
                                                                <label><?php _e('Success Message',APEXNB_TD);?></label>
                                                                <div class="edn-field">
                                                                <input type="text" id="edn-success-message"name="edn_static[success_message]" value="" placeholder="<?php _e('e.g:Your message has been successfully sent.',APEXNB_TD);?>"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="edn-col-half">
                                                            <div class="edn-field-wrapper edn-form-field">
                                                                <label><?php _e('Fail Email Message',APEXNB_TD);?></label>
                                                                    <div class="edn-field">
                                                                    <input type="text" id="edn-cc-send-fail-msg" name="edn_static[sendfail_msg]" value="" placeholder="<?php _e('e.g:Error sending message.',APEXNB_TD);?>"/>
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
                                                                    <label><?php _e('Contact Form 7 Shortcode',APEXNB_TD);?></label>
                                                                    <div class="edn-field">
                                                                        <input type="text" name="edn_static[form_shortcode]" value="" placeholder="<?php _e('Enter Shortcode generated using Contact form 7 plugin here.',APEXNB_TD);?>"/>
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
                                    <input type="text" id="edn-shortcode-button-text" name="edn_static[popup_text]" placeholder="<?php _e('Enter popup button text',APEXNB_TD);?>"/>
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
                                    <input type="text" name="edn_static[shortcode_popup]" value="" placeholder="<?php _e('Enter any shortcode here.',APEXNB_TD);?>"/>
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

            <!-- static content end -->
             <div class="edn-multiple-content-wrap" style="display: none;">
                                <ul class="edn-append-mcontent-prev"></ul>

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
                                                    <label><?php _e('Call to action type', APEXNB_TD); ?></label>
                                                    <div class="edn-field">
                                                        <label class="edn-label-inline">
                                                            <input type="radio" name="edn_multi[action_button]" class="edn-call-action-type" value="custom" checked="checked" />
                                                            <?php _e('Custom Button', APEXNB_TD); ?>
                                                        </label>
                                                        <label class="edn-label-inline">
                                                            <input type="radio" name="edn_multi[action_button]" class="edn-call-action-type" value="contact" />
                                                            <?php _e('Contact Form', APEXNB_TD); ?>
                                                        </label>
                                                        <label class="edn-label-inline">
                                                          <input type="radio" name="edn_multi[action_button]" class="edn-call-action-type" value="shortcode-popup" />
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
                                                        <input type="text" id="edn-link-url" value="" placeholder="<?php _e('e.g: https://www.accesspressthemes.com',APEXNB_TD);?>"/>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="edn-col-full">
                                            <div class="edn-field-wrapper edn-form-field">
                                                <label><?php _e('Link Target',APEXNB_TD);?></label>
                                                <div class="edn-field">
                                                    <select id="edn-link-target" class="apexnb-selection">
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
                               

            </div><!-- #edn-custom-button-block -->
            <div id="edn-m-contact-button-block" class="edn-m-call-action" style="display: none;">
                <div class="edn-row">
                    <div class="edn-col-full">
                        <div class="edn-field-wrapper edn-form-field">
                            <label><?php _e('Choose Contact Form type', APEXNB_TD); ?></label>
                            <div class="edn-field">
                                <label class="edn-label-inline">
                                    <input type="radio" name="edn_multi[choose]" class="edn-contact-choose" value="c-form" checked="checked"/>
                                    <?php _e('Default Form',APEXNB_TD);?>
                                </label>
                                <label class="edn-label-inline">
                                    <input type="radio" name="edn_multi[choose]" class="edn-contact-choose" value="form-7" />
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
                                                    <input type="text" id="edn-cc-name-error" value="" 
                                                    placeholder="<?php _e('e.g:Please enter your name.',APEXNB_TD);?>"/>
                                                </div>
                                       </div>
                                       <div class="edn-col-one-fourth edn-default-form">
                                        <label><?php _e('Email Error Message',APEXNB_TD);?></label>
                                                <div class="edn-field">
                                                    <input type="text" id="edn-cc-email-error" value="" 
                                                    placeholder="<?php _e('e.g: Please enter email address',APEXNB_TD);?>"/>
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
                                                    <input type="text" id="edn-cc-send-mail" value="" placeholder="<?php _e('E.g: support@accesspressthemes.com',APEXNB_TD);?>"/>
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



            </div>
        </div>
    </div>            
</div>
<!------------------------------------------Subscribe FORM------------------------------------------>
 <div class="edn-cp-block" id="edn-cp-subscribe" style="display: none;">
          <div class="edn-row">
              <div class="edn-col-full">
                  <div class="edn-field-wrapper edn-form-field">
                      <label><?php _e('Choose Contact Form', APEXNB_TD); ?></label>
                      <div class="edn-field">
                          <label class="edn-label-inline">
                              <input type="radio" id="radio1" name="edn_subs_choose" value="subs-c-form" checked="checked"/>
                              <?php _e('Custom Form',APEXNB_TD);?>
                          </label>
                          <label class="edn-label-inline">
                              <input type="radio" id="radio2" name="edn_subs_choose" value="mailchip" />
                              <?php _e('Mailchimp Form',APEXNB_TD);?>
                          </label>
     
                          <label class="edn-label-inline">
                              <input type="radio" name="edn_subs_choose" value="constant-contact" />
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
                      $settings = array('textarea_name' => 'edn_custom_html[content]','media_buttons' => true);
                      wp_editor('','edn-html-content',$settings); 
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
                                                <input type="radio" checked name="edn_bar_effect_option" value="1" />
                                                <?php _e('Ticker', APEXNB_TD); ?>
                                            </label>
                                            <label class="edn-label-inline">
                                                <input type="radio" name="edn_bar_effect_option" value="2" />
                                                <?php _e('Slider', APEXNB_TD); ?>
                                            </label>
                                            <label class="edn-label-inline">
                                                <input type="radio" name="edn_bar_effect_option" value="3" />
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
                                                <input type="text" name="edn_ticker[title_text]" placeholder="<?php _e('E.g: Latest', APEXNB_TD); ?>"/>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="edn-col-one-third">
                                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                                            <label><?php _e('Speed', APEXNB_TD) ?></label>
                                            <div class="edn-field">
                                                <input type="text" name="edn_ticker[speed]" value="" placeholder="E.g.,0.10"/>

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
                                                    <option value="horizontal" selected="selected"><?php _e('Horizontal',APEXNB_TD)?></option>
                                                    <option value="vertical"><?php _e('Vertical',APEXNB_TD)?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                 <div class="clear"></div>
                                  <div class="edn-col-one-third edn-hide-in-pre-tpl">
                                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                                            <label><?php _e('Ticker Title Background Color', APEXNB_TD) ?></label>
                                            <div class="edn-field">
                                                 <input type="text" name="edn_ticker_bg_color" id="edn_ticker_bg_color" class="edn-color-picker"/>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="edn-col-one-third edn-hide-in-pre-tpl">
                                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                                            <label><?php _e('Ticker Title Font Color', APEXNB_TD) ?></label>
                                            <div class="edn-field">
                                                 <input type="text" name="edn_ticker_font_color" id="edn_ticker_font_color" class="edn-color-picker"/>
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
                                                <input type="checkbox" id="tickerpause" name="edn_ticker[hover]"/>
                                                <label class="edn-label-inline" for="tickerpause"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="edn-clear"></div>
                                </div>
                    
                            </div><!---------------------------->
                            <div class="edn-bar-efect-block" id="edn-bar-slider" style="display: none;">
                                <div class="edn-row">
                                    <div class="edn-col-one-third">
                                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                                            <label><?php _e('Duration', APEXNB_TD) ?></label>
                                            <div class="edn-field">
                                                <input type="text" name="edn_slider[duration]"/>
                                                <p class="edn-note"><?php _e('Note: Duration between each slide in milliseconds(pause).',APEXNB_TD);?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="edn-col-one-third">
                                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                                            <label><?php _e('Transition', APEXNB_TD) ?></label>
                                            <div class="edn-field">
                                                <input type="text" name="edn_slider[speed]"/>
                                                <p class="edn-note"><?php _e('Note: Duration of each slide in milliseconds(speed).',APEXNB_TD);?></p>
                                            </div>
                                        </div>
                                    </div>
                                       <div class="edn-col-one-third">
                                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                                            <label><?php _e('Auto', APEXNB_TD) ?></label>
                                             <div class="edn-field">
                                                <select name="edn_slider[auto]" class="apexnb-selection">
                                                    <option value="true"><?php _e('True',APEXNB_TD)?></option>
                                                    <option value="false"><?php _e('False',APEXNB_TD)?></option>
                                                   
                                                </select>
                                           <p class="edn-note"><?php _e('Note:If Choose true, slides will automatically transition.Default Value:true',APEXNB_TD);?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="edn-col-one-third">
                                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                                            <label><?php _e('Animation', APEXNB_TD) ?></label>
                                            <div class="edn-field">
                                                <select name="edn_slider[animation]" class="edn-ticker-direction apexnb-selection">
                                                    <option value="horizontal"><?php _e('Slide',APEXNB_TD)?></option>
                                                    <!-- <option value="vertical" >< ?php _e('Vertical Slide',APEXNB_TD)?></option> -->
                                                    <option value="fade"><?php _e('Fade',APEXNB_TD)?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="edn-col-one-third">
                                        <div class="edn-field-wrapper edn-design-reference edn-form-field">
                                            <label><?php _e('Adaptive Height', APEXNB_TD) ?></label>
                                            <div class="edn-field">
                                                <select name="edn_slider[adaptive_height]" class="edn-adaptive_height apexnb-selection">
                                                    <option value="true"><?php _e('True',APEXNB_TD)?></option>
                                                  
                                                    <option value="false"><?php _e('False',APEXNB_TD)?></option>
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
                                                <input type="checkbox" id="ednslidercontrols" name="edn_slider[controls]" value="1"/>
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
                                                <input type="text" name="edn_scroll[title_text]" value="<?php if(isset($edn_bar_setting['edn_scroll']['title_text'])){echo esc_attr($edn_bar_setting['edn_scroll']['title_text']);}?>" />
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
                             
                            </div>
                        </div><!-- .edn-efect-block-wrap -->
                    </div><!-------- .edn-bar-effects -->
            

            </div><!-- edn compontenet wrap -->
   </div>

</div><!-- edn-show-compontens clsoe -->

    <?php include_once(APEXNB_PRO_PATH.'inc/backend/includes/components-settings/custom_open_panel.php');?> 

    
        </div><!-- End .edn-left-controls-wrap -->
    </div><!-- Edn .edn-row -->
<!--     <div class="edn-clear"></div> -->



