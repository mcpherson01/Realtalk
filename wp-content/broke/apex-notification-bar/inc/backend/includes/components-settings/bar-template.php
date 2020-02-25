<?php defined('ABSPATH') or die("No script kiddies please!");?>
<div class="edn-row edn-template-chooser" style="display: none;">

    <div class="edn-col-full">
        <div class="edn-field-wrapper">
            <div class="edn-png-template">
                <h3><?php _e('Available Notification Bar Template', APEXNB_TD); ?> <img src="<?php echo APEXNB_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif' ?>" id="edn-icon-template-loader" style="display: none"/></h3>
                 <p class="description"><?php _e('There are altogether 15 Beautifully Designed Pre Available Templates with preview images.', APEXNB_TD); ?></p>
                <div class="edn-well">
                    <div>
                     <label>
                            <select name="edn_bar_template" id="edn_bar_template">
                        <?php
                         for ($i = 1; $i <= 15; $i++) {
                        if($i == 1){
                          $template_name = "Shades of Arsenic Black";
                          }else if($i == 2){
                           $template_name = "Orange Shades";
                          }else if($i == 3){
                             $template_name = "Whisper Grey";
                            }else if($i == 4){
                              $template_name = "Prussian Blue & White";
                            }else if($i == 5){
                              $template_name = "Mountain Meadow";
                            }else if($i == 6){
                              $template_name = "Blue Comet";
                            }else if($i == 7){
                              $template_name = "Dodger Blue & White";
                            }else if($i == 8){
                              $template_name = "Gorse Yellow";
                            }else if($i == 9){
                              $template_name = "Reddish Valencia";
                            }else if($i == 10){
                              $template_name = "Light Green Atlantis";
                            }else if($i == 11){
                              $template_name = "Gulf Blue & White";
                            }else if($i == 12){
                              $template_name = "Medium Turquoise & Yellow";
                            }else if($i == 13){
                              $template_name = "Black Fiord";
                            }else if($i == 14){
                              $template_name = "Pattens Black & Blue";
                            }else if($i == 15){
                             $template_name = "Image Background";
                            }  ?>
                       <option value="<?php echo $i;?>" <?php if (isset($_GET['action']) && $edn_bar_setting['edn_bar_type'] == 2 && 
                            $edn_bar_setting['edn_bar_template'] == $i) { ?>selected="selected"<?php } ?>><?php echo $template_name;?></option>
                          
                           
                       <?php
                        }
                        ?>
                      </select>
                   <div class="edn-backend-inner-title"><?php _e('Template Preview', APEXNB_TD); ?></div>
                      <?php  for ($i = 1; $i <= 15; $i++) { 
                        if (isset($_GET['action']) && $edn_bar_setting['edn_bar_type'] == 2 && 
                            $edn_bar_setting['edn_bar_template'] == $i) {
                               $style="style='display:block'";
                        }else{
                               $style="style='display:none'";
                            }?>
                            <div class="edn-template-preview edn-template-previewbox-<?php echo $i;?>" <?php echo $style;?>>
                                <img src="<?php echo APEXNB_IMAGE_DIR . '/preview/templates/preview'.$i.'.jpg' ?>" alt="template preview" />
                            </div>

                     <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>