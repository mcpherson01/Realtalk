<div class="edn-design-options  ednpro_nb_bar_designs custom_support_section">
 <div class="edn-inner-main-title custom-support" id="custom" style="cursor:pointer;">
    <?php _e('Custom Support', APEXNB_TD);?>
       <div class="arrow-up" style="display:none;"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
       <div class="arrow-down"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
</div>
        
<div class="edn-col-full edn-custom-content apexnb-main-wrapper-toggle" style="display:none;">

    <div class="nav-tab-wrapper">
        <a href="javascript:void(0);" class="nav-tab nav-tab-active ednnb-tabs-trigger" id="custom-css"><?php _e('Custom CSS',APEXNB_TD);?></a>
        <a href="javascript:void(0);" class="nav-tab ednnb-tabs-trigger" id="custom-js"><?php _e('Custom Javascript',APEXNB_TD);?></a>
      
    </div>
 <div class="edn-panel-body1">
    <div class='ednnb-tab-contents ednnb-active-tab' id='tab-custom-css'>
            <div class="edn-field">
               <div class="edn-field-label-wrap">
                  <label for="enable_custom_css"><?php _e('Enable Custom CSS',APEXNB_TD);?> </label>
                   <p class="edn-note"><?php _e('Do you want to enable below custom css for this notification bar?',APEXNB_TD)?></p>
                </div>
               <div class="edn-field-input-wrap">
                 <div class="apexnb-switch">
                 <input type="checkbox" name="enable_custom_css" id="enable_custom_css" value="1" <?php if(isset($edn_bar_setting['enable_custom_css']) && $edn_bar_setting['enable_custom_css'] == 1) echo "checked='checked'";?>/>
                  <label for="enable_custom_css"></label>
               </div>
               </div>
             </div>
            <textarea name="custom_css" id="ednnb_customcss" class="large-text code" dir="ltr" cols="30" rows="10"><?php if(isset($edn_bar_setting['custom_css'])){ echo esc_attr($edn_bar_setting['custom_css']);}?></textarea>
           
            <script type="text/javascript">var editor = CodeMirror.fromTextArea(document.getElementById("ednnb_customcss"), { lineNumbers: true });</script>
            <p class="edn-note"><?php _e( 'Please write your custom css here that you want to be included with this notification bar.', APEXNB_TD ); ?> </p>
    </div>
         <div class='ednnb-tab-contents' id='tab-custom-js' style="display:none">
            <div class="edn-field">
              <div class="edn-field-label-wrap">
                <label for="enable_custom_js"><?php _e('Enable Custom Javascript',APEXNB_TD);?> </label>
                <p class="edn-note"><?php _e('Do you want to enable below custom javascript/jquery for this notification bar?',APEXNB_TD)?></p>
                </div>
                 <div class="edn-field-input-wrap">
                 <div class="apexnb-switch">
                  <input type="checkbox" name="enable_custom_js" id="enable_custom_js" value="1" <?php if(isset($edn_bar_setting['enable_custom_js']) && $edn_bar_setting['enable_custom_js'] == 1) echo "checked='checked'";?>/>
                  <label for="enable_custom_js"></label>
               </div>
               </div>
            </div>
                <textarea name="custom_js" id="ednnb_customjs" class="large-text code" dir="ltr" cols="30" rows="10"><?php if(isset($edn_bar_setting['custom_js'])){ echo $edn_bar_setting['custom_js'];}?></textarea>
        
             <script type="text/javascript">var editor = CodeMirror.fromTextArea(document.getElementById("ednnb_customjs"), { lineNumbers: true });</script>
           <p class="edn-note"><?php _e( 'Please write your custom javascript / jQuery here that you want to be included with this notification bar.', APEXNB_TD ); ?> </p>
        </div>


   </div>     
  </div>
</div>