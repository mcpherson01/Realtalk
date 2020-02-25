<?php
if ($enable == 1) {
    if ($opanel_ebgimage == 1) {
        $addbgclass = "opanel_enable_bgimage";
    } else {
        $addbgclass = "";
    }
    ?>
    <!-- open panel content-->
    <style type="text/css">
    <?php if ($bg_opacity_color != '') { ?> 
            .opanel_enable_bgimage:before{
                background-color: <?php echo $bg_opacity_color; ?> !important;
            }
    <?php } ?>
    </style>
    <div class="ednpro-opanel-main-wrap <?php echo $enbale_snowflakes_class; ?>">
        <div class="ednpro-open-panel ednpro-content mCustomScrollbar <?php echo $addbgclass; ?>" <?php if ($opanel_ebgimage == 1 && $opanel_bgimage_url != '') {
        echo 'style="background-image: url(' . $opanel_bgimage_url . ')"';
    }; ?>>
            <!-- <div class="opanel-bgoverlay"></div> -->

        <div class="ednpro-opanel-cmain-wrap">      
            <div class="ednpro-opanel-inner-content">
                <div class="ednpro-opanel-inner-wrap">
                    <div class="ednpro-close-panel">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </div>
    <?php if (isset($edn_show_header) && $edn_show_header == 1) { ?>
                        <div class="main_top_header_txt">
                            <div class="headertext"><?php echo $edn_header_text; ?></div>
                        </div>
                    <?php } ?>

                        <?php if ($edn_panel_content_type == "html_text") { ?>
                        <div class="middle_columns clearfix"> 
                        <?php echo $edn_panel_content_text; ?>
                        </div> 
                    <?php } else {
                        if (isset($edn_widgets) && !empty($edn_widgets)) {
                            ?>
                            <div class="middle_columns <?php echo 'ednpro-columns-' . $edn_panel_columns; ?> clearfix">
                                <?php
                                $count = count($edn_widgets['widget_id']);
                                for ($i = 0; $i < $count; $i++) {
                                    if ($i < $edn_panel_columns) {
                                        $widget_data = APEXNB_Class::show_widget($edn_widgets['widget_id'][$i]);
                                        ?>
                                        <div class="ednpro_widgets_content" id="ednpro_column_<?php echo $i; ?>">
                                        <?php echo $widget_data; ?>
                                        </div>

                                <?php }
                            } ?>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <?php if (isset($edn_show_footer) && $edn_show_footer == 1) { ?>
                        <div class="main_top_footer_txt">
                            <div class="footertext"><?php echo $edn_footer_text; ?></div>
                        </div>
    <?php } ?>
                </div>
            </div>
        </div>
        </div>
    </div>

            <?php if ($trigger_enable != 1) { ?>
        <div class="apexnb-open-panel-wrapper">
            <div class="ednpro-top-panel-open">
                <i class="fa fa-angle-down" aria-hidden="true"></i>
        <?php if ($edn_enable_hover_text == 1) { ?><span><?php echo $edn_hover_panel_text; ?></span><?php } ?>
            </div>
        </div>
    <?php
    } else {
        //show trigger image
        if ($trigger_layout == "available_image") {
            $trigger_layout_class = "opanel_timage_available";
            $trigger_template_class = "opanel-timage-" . $trigger_template;
            if ($template_trigger_number == 3) {
                if ($postion == "left") {
                    $timage_url = APEXNB_IMAGE_DIR . '/trigger_available_images/frontend/triggerimg3_left.png';
                } else if ($postion == "right") {
                    $timage_url = APEXNB_IMAGE_DIR . '/trigger_available_images/frontend/triggerimg3.png';
                }
            } else if ($template_trigger_number == 4) {
                if ($postion == "left") {
                    $timage_url = APEXNB_IMAGE_DIR . '/trigger_available_images/frontend/triggerimg4.png';
                } else if ($postion == "right") {
                    $timage_url = APEXNB_IMAGE_DIR . '/trigger_available_images/frontend/triggerimg4_right.png';
                }
            } else if ($template_trigger_number == 16) {
                if ($postion == "left") {
                    $timage_url = APEXNB_IMAGE_DIR . '/trigger_available_images/frontend/triggerimg16_left.png';
                } else if ($postion == "right") {
                    $timage_url = APEXNB_IMAGE_DIR . '/trigger_available_images/frontend/triggerimg16_right.png';
                }
            } else if ($template_trigger_number == 13) {
                if ($postion == "top") {
                    //if($btn_class = "edn-btn-position-right"){
                    $timage_url = APEXNB_IMAGE_DIR . '/trigger_available_images/frontend/triggerimg13_top_left.png';
                    // }else{
                    //  $timage_url =  APEXNB_IMAGE_DIR.'/trigger_available_images/frontend/triggerimg13_top_left.png';
                    // }  
                } else if ($postion == "bottom") {
                    //if($btn_class = "edn-btn-position-right"){
                    $timage_url = APEXNB_IMAGE_DIR . '/trigger_available_images/frontend/triggerimg13_bottom_left.png';
                    //  }else{
                    // $timage_url =  APEXNB_IMAGE_DIR.'/trigger_available_images/frontend/triggerimg13_bottom_left.png';
                    // } 
                }
            } else {
                $timage_url = APEXNB_IMAGE_DIR . '/trigger_available_images/frontend/triggerimg' . $template_trigger_number . '.png';
            }
            $custom_image_width = "120";
            $custom_image_height = "120";
            $custom_animation = "";
        } else {
            $custom_image_width = (isset($edn_bar_data['edn_open_panel']['custom_image_width']) && $edn_bar_data['edn_open_panel']['custom_image_width'] != '')?intval($edn_bar_data['edn_open_panel']['custom_image_width']):'';
            $custom_image_height = (isset($edn_bar_data['edn_open_panel']['custom_image_height']) && $edn_bar_data['edn_open_panel']['custom_image_height'] != '')?intval($edn_bar_data['edn_open_panel']['custom_image_height']):'';
             $custom_animation = (isset($edn_bar_data['edn_open_panel']['custom_opanel_animation']) && $edn_bar_data['edn_open_panel']['custom_opanel_animation'] != '')?esc_attr($edn_bar_data['edn_open_panel']['custom_opanel_animation']):'';
            $trigger_layout_class = " opanel_timage_custom ";
            $trigger_template_class = "";
            $timage_url = $trigger_image;
        }
        ?>
        <div class="apexnb-open-panel-trigger-wrap <?php echo $trigger_layout_class; ?> <?php echo $trigger_template_class;?>">
            <div class="ednpro-top-panel-open <?php echo $custom_animation;?>">
                <img src="<?php echo $timage_url; ?>" class="edn-opanel-trigger-image" 
                width="<?php echo $custom_image_width;?>" height="<?php echo $custom_image_height;?>"/>
            </div>
        </div>
    <?php } ?>
    <!-- open panel content end--> 
<?php
}?>