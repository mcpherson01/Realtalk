<?php defined('ABSPATH') or die("No script kiddies please!");?>
<?php 
$enable_bg_image = (isset($edn_bar_data['edn_background_image']['enable_bgimage']) && $edn_bar_data['edn_background_image']['enable_bgimage'] == true)?1:0;
if($enable_bg_image ==1){
$bg_image = (isset($edn_bar_data['edn_background_image']['bgimage_url']) && $edn_bar_data['edn_background_image']['bgimage_url'] != '')?esc_url_raw($edn_bar_data['edn_background_image']['bgimage_url']):'';
}
?>
<div class="edn-template-wrap edn-template-14 clearfix" <?php if($enable_bg_image == 1){ ?> style="background-image: url('<?php echo $bg_image; ?>')"; <?php } ?>>
<?php if($edn_bar_data['edn_bar_type']==2){ 
?>

<?php 
if(isset($edn_bar_data['edn_right_optons'] ) && $edn_bar_data['edn_right_optons'] == 1){
if(isset($edn_bar_data['edn_cp_type']) && $edn_bar_data['edn_cp_type']=='email-subs'){
  if(isset($edn_bar_data['edn_subs_choose'])){
   $subsc_choose =  $edn_bar_data['edn_subs_choose'];
   switch($subsc_choose){
    case 'subs-c-form':
     $show_mail_icon = 'edn_subsc_show_icon';
     $show_new_class = 'edn_csubscribe_form';
    break;
    case 'mailchip':
     $show_mail_icon = 'edn_mailchimp_show_icon';
      $show_new_class = 'edn_csubscribe_form';
    break;
    case 'constant-contact':
     $show_mail_icon = 'edn_ccshow_icon';
      $show_new_class = '';
    break;
    default:
     $show_mail_icon = '';
      $show_new_class = '';
    break;
   }
  }

}else{
  $show_mail_icon = '';
  $show_new_class = '';
}
}else{
  $show_mail_icon = '';
  $show_new_class = '';
}
?>
<div class="edn-temp-design-wrapper edn-temp3-design-wrapper edn-temp14-design-wrapper_<?php echo $edn_bar_data['edn_logo_section']['enable_logo'];?>">

<?php if(isset($edn_bar_data['edn_logo_section']['enable_logo']) && $edn_bar_data['edn_logo_section']['enable_logo'] == true){
  ?>
  <!-- Logo Section-->
  <?php if(isset($edn_bar_data['edn_logo_section']['image_url']) && $edn_bar_data['edn_logo_section']['image_url'] != '' ){
  $image_url = (isset($edn_bar_data['edn_logo_section']['image_url']) && $edn_bar_data['edn_logo_section']['image_url'] != '')?esc_url($edn_bar_data['edn_logo_section']['image_url']):'';
  $target_url = (isset($edn_bar_data['edn_logo_section']['url_link']) && $edn_bar_data['edn_logo_section']['url_link'] != '')?esc_url($edn_bar_data['edn_logo_section']['url_link']):'#';
  $target_link = (isset($edn_bar_data['edn_logo_section']['link_target']) && $edn_bar_data['edn_logo_section']['link_target'] != '')?esc_attr($edn_bar_data['edn_logo_section']['link_target']):'_self';
  $img_width = (isset($edn_bar_data['edn_logo_section']['image_width']) && $edn_bar_data['edn_logo_section']['image_width'] != '')?esc_attr($edn_bar_data['edn_logo_section']['image_width']):'200';
  $img_height = (isset($edn_bar_data['edn_logo_section']['image_height']) && $edn_bar_data['edn_logo_section']['image_height'] != '')?esc_attr($edn_bar_data['edn_logo_section']['image_height']):'48';
?>
<div class="apexnb-logo-wrapper">
         <div class="logo-image-wrap" style="width:<?php echo $img_width;?>px;height:<?php echo $img_height;?>px;"> 
          <a href="<?php echo $target_url;?>" target="<?php echo $target_link;?>"><img src="<?php echo $image_url;?>" /></a>
        </div>
  </div>
<?php }
 }?>
<?php if(isset($edn_bar_data['edn_social_optons']) && isset($edn_bar_data['edn_right_optons'] ) 
&& $edn_bar_data['edn_social_optons']==1 && $edn_bar_data['edn_right_optons'] ==1){?>
<div class="endpro_main_leftright_wrapper <?php echo $effect_id;?>_leftright_wrapper <?php echo $show_new_class;?>">
<?php } ?>

<?php if($edn_bar_data['edn_social_optons'] != ''){ ?>

       <div class="<?php if(isset($edn_bar_data['edn_right_optons'] ) && $edn_bar_data['edn_right_optons'] == '') echo 'edn_middle_content'; else echo 'edn-temp14-left-section-wrap ednpro_left_section'; ?>">
                    <?php
                        if($edn_bar_data['edn_social_optons']==1){
                        ?>
                            <div class="edn-temp14-social-wrap">
                                <?php if(isset($edn_bar_data['edn_social_heading_text']) && !empty($edn_bar_data['edn_social_heading_text'])){?>
                                    <div class="edn-temp14-social-heading-title edn_pro-social-title"><?php echo esc_attr($edn_bar_data['edn_social_heading_text']);?></div>
                                <?php }?>
                                <div class="ednpro_bar_icons <?php echo $show_mail_icon;?>">
                                <?php
                                    if(isset($edn_bar_data['icon_details']) && $edn_bar_data['icon_details']){
                                        foreach($edn_bar_data['icon_details'] as $icon_list){
                                            $array_name = explode(' ',esc_attr($icon_list['title']));
                                            $class = implode('-',$array_name);
                                            $social_class = strtolower($class);
                                            ?>
                                                <div class="edn-social-icons edn-temp14-social-icon-buttons edn-temp14-<?php echo $social_class;?>-button" style="<?php ?>">
                                                    <a href="<?php echo esc_attr($icon_list['link']);?>" target="_blank" class="edn-social-icons-bg edn-temp14-aclass-<?php echo $social_class;?>">
                                                        <span class="edn-temp14-<?php echo $social_class;?> edn-hover-icons" style="display:none;"><i class="<?php echo esc_attr($icon_list['font_icon']);?> edn-temp14-iclass-<?php echo $social_class;?>"></i></span>
                                                        <i class="<?php echo esc_attr($icon_list['font_icon']);?> edn-icons-set edn-temp14-iclass-<?php echo $social_class;?>"></i>
                                                    </a>
                                                </div>
                                            <?php
                                        }
                                    }
                                ?>
                                </div>
                            </div>
                        <?php
                        }
                    ?>
                </div><!-- end of left-section-wrap -->

<?php } ?>


<!-- right content start -->
<?php if(isset($edn_bar_data['edn_right_optons'] ) && $edn_bar_data['edn_right_optons'] != ''){?>
<div class="<?php if($edn_bar_data['edn_social_optons']=='') echo 'edn_middle_content'; else echo 'edn-temp14-right-section-wrap ednpro_right_section'; ?> <?php echo $effect_id;?>_template_wrapper">

   <div class="edn-temp14-main-content-wrap">

<?php $consumer_key = $edn_bar_data['edn_twitter']['consumer_key'];
if($edn_bar_data['edn_cp_type']=='text'){ ?>

<div class="edn-temp14-text-content-wrap">
  <?php if($edn_bar_data['edn_text_display_mode']=='static'){ ?>
   <div class="edn_static_text">
  <?php
      echo '<div class="edn-text-link">'.$edn_bar_data['edn_static']['text'].'</div>';
     if(isset($edn_bar_data['edn_static']['call-to-action']) && $edn_bar_data['edn_static']['call-to-action']==1){ ?>
   <span class="edn-temp14-call-action-button">
    <?php //check for custom form
     if(isset($edn_bar_data['edn_static']['call_action_button']) && $edn_bar_data['edn_static']['call_action_button']=='custom'){
       
         if($edn_bar_data['edn_static']['but_url'] == '' || $edn_bar_data['edn_static']['but_url'] == '#'){
                        $target = "target='_self'";
                        $url = '#';
                       }else{
                           if(isset($edn_bar_data['edn_static']['link_target'])){
                           $t = $edn_bar_data['edn_static']['link_target'];
                           $target = "target='".$t."'";
                           $url = esc_attr($edn_bar_data['edn_static']['but_url']);
                         }else{
                           $t = '_self';
                           $target = "target='".$t."'";
                           $url = esc_attr($edn_bar_data['edn_static']['but_url']);

                         }
                      }
$but_text = ((isset($edn_bar_data['edn_static']['but_text']) && $edn_bar_data['edn_static']['but_text'] != '')? $edn_bar_data['edn_static']['but_text'] : 'READ MORE');   
               ?>
            <span class="edn-temp14-ca-custom">
                <a class="edn-temp14-static-button edn-static-buttons" href="<?php echo $url;?>" <?php echo $target;?>>
                    <span class="edn-temp14-ca-static-button"><?php echo $but_text;?></span>
                </a>
            </span>

                    <?php  
        //contact form 7 or default form
      }else if(isset($edn_bar_data['edn_static']['call_action_button']) && $edn_bar_data['edn_static']['call_action_button']=='contact'){
        ?>
     <span class="edn-temp14-ca-contact-form">
           <?php
                    if(isset($edn_bar_data['edn_static']['contact_btn_text']) && $edn_bar_data['edn_static']['contact_btn_text'] != ''){
                        ?>
                            <a href="javascript:void(0);" class="edn-custom-contact-link">
                                <span class="edn-temp14-contact-button edn-contact-form-button" data-id="edn-static-cf-btn-<?php echo $nb_id;?>"><?php echo esc_attr($edn_bar_data['edn_static']['contact_btn_text']);?></span>
                            </a>
                        <?php
                    }else{ ?>
                 <a href="javascript:void(0);" class="edn-custom-contact-link">
                <span class="edn-temp14-contact-button edn-contact-form-button" data-id="edn-static-cf-btn-<?php echo $nb_id;?>"><?php _e('Contact',APEXNB_TD);?></span>
                </a>

          <?php   }
            ?>
            
      </span><!-- edn of edn-ca-contact-form -->
      <?php
      }else{ //shortcode  
        $popuptxt = ((isset($edn_bar_data['edn_static']['popup_text']) && $edn_bar_data['edn_static']['popup_text'] != '')?$edn_bar_data['edn_static']['popup_text']:'CUSTOM BUTTON');
                         ?>
        <span class="edn-temp14-ca-contact-form">
          
            <a href="javascript:void(0);" class="edn-custom-contact-link">
                <span class="edn-temp14-contact-button edn-contact-form-button" data-id="edn-static-cf-btn-<?php echo $nb_id;?>">
                <?php echo esc_attr($popuptxt);?></span>
            </a>
            
      </span><!-- edn of edn-ca-contact-form -->

  <?php     }
      ?>
</span>
<?php
}
//check if call to action button exist end 
    ?>
</div>
<?php  
}else if(!empty($edn_bar_data['edn_multiple']['text_content'])){  
 ?>
<div class="edn_multiple_text">
<ul class="edn-multiple-content" id="edn-effect-<?php echo $effect_id;?>-<?php echo $nb_id;?>" data-barid="<?php echo $nb_id;?>">
    <?php $total_data = count($edn_bar_data['edn_multiple']['text_content']);
    for($i=0; $i<$total_data; $i++){ 
          
          if(isset($edn_bar_data['edn_multiple']['link_but_text'][$i])){
             $linktext = esc_attr($edn_bar_data['edn_multiple']['link_but_text'][$i]); 
              $settickerclass = "apexnb_tickercontent_cta";
          }else{   
             $linktext = '';     
             $settickerclass = "";
          }
  ?>
 <li <?php echo ($effect_id == "slider")?'class="clearfix"':'';?>>
 <?php if($effect_id == "ticker"){ ?>
            <div class="<?php echo $settickerclass;?>">
             <div class="edn-mulitple-text-content">
             <?php echo $edn_bar_data['edn_multiple']['text_content'][$i];?>
             </div>
     <?php if(isset($edn_bar_data['edn_multiple']['call_to_action'][$i]) && $edn_bar_data['edn_multiple']['call_to_action'][$i]==1){ 
             if(isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$i]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$i]=='custom'){
              
             if(isset($linktext) && $linktext != ''){
                if($edn_bar_data['edn_multiple']['link_url'][$i] != '#' && $edn_bar_data['edn_multiple']['link_url'][$i] != ''){
                    $target1 = !(isset($edn_bar_data['edn_multiple']['link_target'][$i]))?'_self':$edn_bar_data['edn_multiple']['link_target'][$i];
                    $target = "target='".$target1."'";
                    $link_url = esc_attr($edn_bar_data['edn_multiple']['link_url'][$i]);
                }else{
                    $link_url = '#';
                    $target = "target='_self'";
                }
              }else{
                    $link_url = '';
                    $target = "";
              }

                   ?>
             <?php if(isset($linktext) && $linktext != ''){?>
                     <span class="edn-temp14-ca-custom">
                        <a class="edn-temp14-static-button edn-multiple-button edn-temp14-multiple-btn-<?php echo $i;?> edn-custom-contact-link" href="<?php echo esc_attr($link_url);?>" <?php echo $target;?>>
                            <span class="edn-temp14-ca-static-button edn-temp14-ca-multiple-button edn-temp14-ca-multiple-btn-<?php echo $i;?>"><?php echo esc_attr($linktext);?></span>
                        </a>
                    </span>
           <?php } ?>
             <?php }else if(isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$i]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$i]=='shortcode-popup'){
             ?>
              <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp14-contact-button edn-contact-form-button edn-multiple-cf-btn"
                     data-id="edn-multiple-cf-btn_<?php echo $i;?>">
                     <?php 
                     if(isset($edn_bar_data['edn_multiple']['popup_text'][$i]) && $edn_bar_data['edn_multiple']['popup_text'][$i] != ''){
                          echo esc_attr($edn_bar_data['edn_multiple']['popup_text'][$i]); }
                      else{
                        _e('CLICK ME',APEXNB_TD);
                        }
                     ?>
                     </span>
                </a>

                </span><!-- edn of edn-ca-contact-form -->

            <?php }
             else{ ?>
            <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp14-contact-button edn-contact-form-button edn-multiple-cf-btn"
                     data-id="edn-multiple-cf-btn_<?php echo $i;?>">
                     <?php 
                     if(isset($edn_bar_data['edn_multiple']['contact_btn_text'][$i]) && $edn_bar_data['edn_multiple']['contact_btn_text'][$i] != ''){
                          echo esc_attr($edn_bar_data['edn_multiple']['contact_btn_text'][$i]); }
                      else{
                        _e('Contact',APEXNB_TD);
                        }
                     ?>
                     </span>
                </a>

                </span><!-- edn of edn-ca-contact-form -->


             <?php }

      }?>
 </div>
 
 
 <?php }else if($effect_id == "scroller"){ ?>

<div class="<?php echo $settickerclass;?>">
             <div class="edn-mulitple-text-content">
             <?php echo $edn_bar_data['edn_multiple']['text_content'][$i];?>
             </div>
     <?php if(isset($edn_bar_data['edn_multiple']['call_to_action'][$i]) && $edn_bar_data['edn_multiple']['call_to_action'][$i]==1){ 
             if(isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$i]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$i]=='custom'){
              
             if(isset($linktext) && $linktext != ''){
                if($edn_bar_data['edn_multiple']['link_url'][$i] != '#' && $edn_bar_data['edn_multiple']['link_url'][$i] != ''){
                    $target1 = !(isset($edn_bar_data['edn_multiple']['link_target'][$i]))?'_self':$edn_bar_data['edn_multiple']['link_target'][$i];
                    $target = "target='".$target1."'";
                    $link_url = esc_attr($edn_bar_data['edn_multiple']['link_url'][$i]);
                }else{
                    $link_url = '#';
                    $target = "target='_self'";
                }
              }else{
                    $link_url = '';
                    $target = "";
              }
                  ?>
              <?php if(isset($linktext) && $linktext != ''){?>
                     <span class="edn-temp14-ca-custom">
                        <a class="edn-temp14-static-button edn-multiple-button edn-temp14-multiple-btn-<?php echo $i;?> edn-custom-contact-link" href="<?php echo esc_attr($link_url);?>" <?php echo $target;?>>
                            <span class="edn-temp14-ca-static-button edn-temp14-ca-multiple-button edn-temp14-ca-multiple-btn-<?php echo $i;?>"><?php echo esc_attr($linktext);?></span>
                        </a>
                    </span>
                <?php } ?>

             <?php }else if(isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$i]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$i]=='shortcode-popup'){
             ?>
                 <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp14-contact-button edn-contact-form-button edn-multiple-cf-btn" data-id="edn-multiple-cf-btn_<?php echo $i;?>">
                     <?php 
                     if(isset($edn_bar_data['edn_multiple']['popup_text'][$i]) && $edn_bar_data['edn_multiple']['popup_text'][$i] != ''){
                          echo esc_attr($edn_bar_data['edn_multiple']['popup_text'][$i]);
                           }
                      else{
                        _e('CLICK ME',APEXNB_TD);
                        }
                     ?>
                     </span>
                </a>

            </span><!-- edn of edn-ca-contact-form -->

            <?php } else{ ?>
            <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp14-contact-button edn-contact-form-button edn-multiple-cf-btn" data-id="edn-multiple-cf-btn_<?php echo $i;?>">
                     <?php 
                     if(isset($edn_bar_data['edn_multiple']['contact_btn_text'][$i]) && $edn_bar_data['edn_multiple']['contact_btn_text'][$i] != ''){
                          echo esc_attr($edn_bar_data['edn_multiple']['contact_btn_text'][$i]);
                           }
                      else{
                        _e('Contact',APEXNB_TD);
                        }
                     ?>
                     </span>
                </a>

            </span><!-- edn of edn-ca-contact-form -->


             <?php } 
             } ?>
</div>
          
 <?php }else if($effect_id == "slider"){ ?>
  
   <?php if(isset($edn_bar_data['edn_multiple']['call_to_action'][$i]) && $edn_bar_data['edn_multiple']['call_to_action'][$i]==1){ 
     
      if(isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$i]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$i]=='custom'){
        //custom link 
         if(isset($edn_bar_data['edn_multiple']['link_but_text'][$i])){
                    $linktext = esc_attr($edn_bar_data['edn_multiple']['link_but_text'][$i]); 
                   }else{   
                      $linktext = 'View Link';     
                  }
                  if(isset($linktext) && $edn_bar_data['edn_multiple']['link_url'][$i] != '#' && $edn_bar_data['edn_multiple']['link_url'][$i] != ''){
                     $target1 = !(isset($edn_bar_data['edn_multiple']['link_target'][$i]))?'_self':$edn_bar_data['edn_multiple']['link_target'][$i];
                   
                    $target = "target='".$target1."'";
                    $link_url = esc_attr($edn_bar_data['edn_multiple']['link_url'][$i]);
                  }else{
                    $link_url = '#';
                    $target = "target='_self'";

                  }   ?>
              <div class="edn-mulitple-text-content">
             <?php echo $edn_bar_data['edn_multiple']['text_content'][$i];?>
             </div>
              <a href="<?php echo $link_url; ?>" <?php echo $target;?> class="edn-custom-contact-link">
                <span class="edn-temp14-ca-custom"><?php echo $linktext;?></span>
             </a>

       <?php }else if(isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$i]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$i]=='shortcode-popup'){
             ?>
                 <div class="edn-mulitple-text-content">
             <?php echo $edn_bar_data['edn_multiple']['text_content'][$i];?>
             </div>
                 <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp14-contact-button edn-contact-form-button edn-multiple-cf-btn" data-id="edn-multiple-cf-btn_<?php echo $i;?>">
                     <?php 
                     if(isset($edn_bar_data['edn_multiple']['popup_text'][$i]) && $edn_bar_data['edn_multiple']['popup_text'][$i] != ''){
                          echo esc_attr($edn_bar_data['edn_multiple']['popup_text'][$i]);
                           }
                      else{
                        _e('CLICK ME',APEXNB_TD);
                        }
                     ?>
                     </span>
                </a>

            </span><!-- edn of edn-ca-contact-form -->

            <?php } else{ ?>
         
             <div class="edn-mulitple-text-content">
             <?php echo $edn_bar_data['edn_multiple']['text_content'][$i];?>
             </div>
                <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp14-contact-button edn-contact-form-button edn-multiple-cf-btn"
                     data-id="edn-multiple-cf-btn_<?php echo $i;?>">
                     <?php if(isset($edn_bar_data['edn_multiple']['contact_btn_text'][$i]) && $edn_bar_data['edn_multiple']['contact_btn_text'][$i] != ''){
                      echo esc_attr($edn_bar_data['edn_multiple']['contact_btn_text'][$i]); }
                      else{
                      _e('Contact',APEXNB_TD);
                        }?>
                     </span>
                </a>

                </span><!-- edn of edn-ca-contact-form -->

      <?php   } //contact form popup  ?>

  <?php }else{ ?>
              <div class="edn-mulitple-text-content">
             <?php echo $edn_bar_data['edn_multiple']['text_content'][$i];?>
             </div>

 <?php } 
  }?>
</li>
<?php    
} ?>
</ul>
</div>
<?php  
    } ?>

</div>



<?php }elseif($edn_bar_data['edn_cp_type']=='email-subs'){ ?>
<div class="edn-type-newsletter-wrap">
    <?php
        if($edn_bar_data['edn_subs_choose']=='subs-c-form'){
            ?>
                <div class="edn-subscribe-form">
                    
                    <div class="edn-form-field">

                      <div class="edn-front-title">
                             <div class="show_icon">
                              <i class="fa fa-envelope-o" aria-hidden="true"></i>
                             </div>
                            <h3><?php 
                             $head_txt = ((isset($edn_bar_data['edn_subs_custom']['head_text']) && $edn_bar_data['edn_subs_custom']['head_text'] != '')?$edn_bar_data['edn_subs_custom']['head_text']:'SUBSCRIBE NEWSLETTER');
                             echo esc_attr($head_txt);
                            ?>
                               <?php if(isset($edn_bar_data['edn_subs_custom']['description'])){ ?>
                                   <span>
                                   <?php echo esc_attr($edn_bar_data['edn_subs_custom']['description']);?>
                                   </span>
                                   <?php } ?></h3>
                        </div>
                      <div class="edn-left-subscribe-content">
                          
                          <input type="email" name="edn_email" placeholder="<?php if(isset($edn_bar_data['edn_subs_custom']['but_email_placeholder']) && $edn_bar_data['edn_subs_custom']['but_email_placeholder'] !=''){ 
                            echo esc_attr($edn_bar_data['edn_subs_custom']['but_email_placeholder']); 
                          }else{  _e('Email Address', APEXNB_TD); }?>" class="edn_subs_email_r" />
                        
                      <!--     <input type="button" class="edn_subs_submit_ajax" id="edn_subs_submit_ajax-<?php echo $nb_id;?>" 
                          value="<?php if(isset($edn_bar_data['edn_subs_custom']['but_text']) && $edn_bar_data['edn_subs_custom']['but_text'] != ''){
                            echo esc_attr($edn_bar_data['edn_subs_custom']['but_text']);
                            }else(_e('Go',APEXNB_TD))?>" /> -->
                            <button type="button" class="edn_subs_submit_ajax" id="edn_subs_submit_ajax-<?php echo $nb_id;?>" ><?php if(isset($edn_bar_data['edn_subs_custom']['but_text']) && $edn_bar_data['edn_subs_custom']['but_text'] != ''){
                            echo esc_attr($edn_bar_data['edn_subs_custom']['but_text']);
                            }else(_e('Go',APEXNB_TD))?></button>
                        <div class="edn-error">
                          <?php
                              if(isset($_SESSION['edn-subs-sms'])){echo $_SESSION['edn-subs-sms'];unset($_SESSION['edn-subs-sms']);}
                          ?>
                        </div>
                         <div class="edn-subs-success edn-success"></div>                   
                        <div class="loader_view">
                       <img src="<?php echo APEXNB_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-ajax-loader"/>
                       </div>
                       </div>
                    </div>
                   
                   
                    <input type="hidden" class="edn-subs-email-confirm" value="<?php if(isset($edn_bar_data['edn_subs_custom']['confirm'])){echo esc_attr($edn_bar_data['edn_subs_custom']['confirm']);}?>" />
                    <input type="hidden" class="edn-page-id" value="<?php the_ID();?>" />

                    <input type="hidden" class="edn-success-note" value="<?php if(isset($edn_bar_data['edn_subs_custom']['thank_text'])){echo esc_attr($edn_bar_data['edn_subs_custom']['thank_text']);}?>" />
                    <input type="hidden" class="edn-subs-email-error-msg" value="<?php if(isset($edn_bar_data['edn_subs_custom']['but_email_error_message'])){echo esc_attr($edn_bar_data['edn_subs_custom']['but_email_error_message']);}?>" />
                    <input type="hidden" class="edn-subs-already-subscribed" value="<?php if(isset($edn_bar_data['edn_subs_custom']['but_already_subs'])){echo esc_attr($edn_bar_data['edn_subs_custom']['but_already_subs']);}?>" />
                    <input type="hidden" class="edn-subs-sending-fail" value="<?php if(isset($edn_bar_data['edn_subs_custom']['but_sending_fail'])){echo esc_attr($edn_bar_data['edn_subs_custom']['but_sending_fail']);}?>" />
                    <input type="hidden" class="edn-subs-checktoconfirmmsg" value="<?php if(isset($edn_bar_data['edn_subs_custom']['but_check_to_conform'])){echo esc_attr($edn_bar_data['edn_subs_custom']['but_check_to_conform']);}?>" />
                    <input type="hidden" class="apexnb-bar-id" value="<?php echo $nb_id;?>" />

                </div>
            <?php
        }else if($edn_bar_data['edn_subs_choose']=='mailchip'){
            ?>
                <div class="edn-mailchimp-wrap">
                    <div class="edn-front-title">
                      <div class="show_icon">
                              <i class="fa fa-envelope-o" aria-hidden="true"></i>
                      </div>
                      <h3><?php 
                            $head_txt1 = ((isset($edn_bar_data['edn_mailchimp']['head_text']) && $edn_bar_data['edn_mailchimp']['head_text'] != '')?$edn_bar_data['edn_mailchimp']['head_text']:'SUBSCRIBE NEWSLETTER');
                             echo esc_attr($head_txt1);
                      ?>
                      <?php if(isset($edn_bar_data['edn_mailchimp']['description'])){?>
                         <span><?php echo esc_attr($edn_bar_data['edn_mailchimp']['description']);?></span>
                         <?php } ?> 
                      </h3> 
                      
                      </div>
                    <div class="edn-form-field">
                       <div class="edn-left-subscribe-content">
                          <input type="email" name="edn_mailchimp_email" class="edn-mailchimp-email" placeholder="<?php echo esc_attr($edn_bar_data['edn_mailchimp']['email_label']);?>" />
                          <input type="hidden" class="edn-mailchimp-email-confirm" value="<?php if(isset($edn_bar_data['edn_mailchimp']['confirm'])){echo esc_attr($edn_bar_data['edn_mailchimp']['confirm']);}?>" />
                         <input type="hidden" class="edn-mc-success-note" value="<?php if(isset($edn_bar_data['edn_mailchimp']['thank_text'])){echo esc_attr($edn_bar_data['edn_mailchimp']['thank_text']);}?>" />  
                          <input type="hidden" class="edn-mc-email-err" value="<?php if(isset($edn_bar_data['edn_mailchimp']['mailchimp_email_err'])){echo esc_attr($edn_bar_data['edn_mailchimp']['mailchimp_email_err']);}?>" />
                          <input type="hidden" class="edn-mc-sending-fail" value="<?php if(isset($edn_bar_data['edn_mailchimp']['mailchimp_sending_fail'])){echo esc_attr($edn_bar_data['edn_mailchimp']['mailchimp_sending_fail']);}?>" />
                          <input type="hidden" class="edn-mc-check-to-conform" value="<?php if(isset($edn_bar_data['edn_mailchimp']['mailchimp_check_to_conform'])){echo esc_attr($edn_bar_data['edn_mailchimp']['mailchimp_check_to_conform']);}?>" />
                          <input type="hidden" class="apexnbbarid" value="<?php echo $nb_id;?>" />
                          <input type="hidden" class="edn-api-key" value="<?php if(isset($edn_bar_data['edn_mailchimp']['api_key'])){echo esc_attr($edn_bar_data['edn_mailchimp']['api_key']);}?>" />
                          <?php
                              if(isset($edn_bar_data['edn_mailchimp']['lists']) && $edn_bar_data['edn_mailchimp']['lists']){
                                  $mailchimp_list = implode(",",$edn_bar_data['edn_mailchimp']['lists']);
                              }
                          ?>
                          <input type="hidden" class="edn-mailchimp-list" value="<?php if(isset($edn_bar_data['edn_mailchimp']['lists']) && $edn_bar_data['edn_mailchimp']['lists']){echo $mailchimp_list;}?>" />
                          <input type="hidden" class="edn-page-id" value="<?php the_ID();?>" />
                         <!--  <input type="button" id="edn_mailchimp_submit_ajax-<?php echo $nb_id;?>" class="edn_mailchimp_submit_ajax" value="<?php if(isset($edn_bar_data['edn_mailchimp']['botton_text']) && $edn_bar_data['edn_mailchimp']['botton_text'] !=''){echo esc_attr($edn_bar_data['edn_mailchimp']['botton_text']);}else(_e('Go',APEXNB_TD))?>" /> -->
                          <button type="button" id="edn_mailchimp_submit_ajax-<?php echo $nb_id;?>" class="edn_mailchimp_submit_ajax"><?php if(isset($edn_bar_data['edn_mailchimp']['botton_text']) && $edn_bar_data['edn_mailchimp']['botton_text'] !=''){echo esc_attr($edn_bar_data['edn_mailchimp']['botton_text']);}else(_e('Go',APEXNB_TD))?></button>
                          <div class="edn-error">
                                <?php
                                    if(isset($_SESSION['edn-mailchimp-sms'])){echo $_SESSION['edn-mailchimp-sms'];unset($_SESSION['edn-mailchimp-sms']);}
                                ?>
                            </div>
                            <div class="edn-subs-success edn-success"></div>
                            <div class="loader_view">
                           <img src="<?php echo APEXNB_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-ajax-loader"/>
                           </div>
                        </div>
                        
                       
                   </div>
                  
                </div>
            <?php
        }else{ ?>

<div class="edn-constant-contact-wrap">
    <div class="edn-front-title">
      <h3><?php 
            $head_txt3 = ((isset($edn_bar_data['edn_constant_contact']['title_text']) && $edn_bar_data['edn_constant_contact']['title_text'] != '')?$edn_bar_data['edn_constant_contact']['title_text']:'JOIN OUR MAIL NOW');
            echo esc_attr($head_txt3);
           ?>
       <span><?php if(isset($edn_bar_data['edn_constant_contact']['description_label'])){
        echo esc_attr($edn_bar_data['edn_constant_contact']['description_label']);}?></span>
       </h3>
  
    </div>

<div class="edn-form-field">
 <div class="edn-left-subscribe-content">
    <input type="text" name="edn_fnm" class="edn-constantcontact-firstname" placeholder="<?php echo esc_attr($edn_bar_data['edn_constant_contact']['name_placeholder']);?>" />
    <input type="email" name="edn_eml" class="edn-constantcontact-email"  placeholder="<?php echo esc_attr($edn_bar_data['edn_constant_contact']['email_placeholder']);?>" />                               
    <input type="hidden" class="edn-constant-page-id" value="<?php the_ID();?>" />
    <input type="hidden" class="edn-success-message" value="<?php if(isset($edn_bar_data['edn_constant_contact']['success_text'])){
        echo esc_attr($edn_bar_data['edn_constant_contact']['success_text']);}?>" />
    <input type="hidden" class="edn-constantcontact-email-confirm" value="<?php if(isset($edn_bar_data['edn_constant_contact']['confirm'])){
    echo esc_attr($edn_bar_data['edn_constant_contact']['confirm']);}?>"/>  

   <div class="edn_constant_message" data-send-fail="<?php if(isset($edn_bar_data['edn_constant_contact']['constant_sending_fail']) && $edn_bar_data['edn_constant_contact']['constant_sending_fail'] !=''){
    echo esc_attr($edn_bar_data['edn_constant_contact']['constant_sending_fail']);}else{ _e('Sending fail.',APEXNB_TD); }?>" 
    data-email-error="<?php if(isset($edn_bar_data['edn_constant_contact']['constant_email_error']) && $edn_bar_data['edn_constant_contact']['constant_email_error'] !=''){
    echo esc_attr($edn_bar_data['edn_constant_contact']['constant_email_error']);}else{ _e('Please Enter Your valid Email Address!!',APEXNB_TD); }?>"
     data-name-error="<?php if(isset($edn_bar_data['edn_constant_contact']['constant_name_error']) && $edn_bar_data['edn_constant_contact']['constant_name_error'] !=''){
    echo esc_attr($edn_bar_data['edn_constant_contact']['constant_name_error']);}else{ _e('Please Enter Your Firstname!!',APEXNB_TD); }?>" style="display:none;"></div>
     <input type="hidden" class="apex_nb_cc_barid" value="<?php echo $nb_id;?>" />
    <?php #echo "<pre>"; print_r($edn_bar_data['edn_constant_contact']['lists']);
       if(isset($edn_bar_data['edn_constant_contact']['lists'])){                 
             $edn_lsits = $edn_bar_data['edn_constant_contact']['lists'];
                        $i=1; foreach ($edn_lsits as $list_id) { 
                           $listid = $list_id;?>
       <input type="hidden" name="edn_grp" id="edn_grp_<?php echo $i;?>_<?php echo $nb_id;?>" value="<?php echo $listid ;?>" />
       <?php $i++; } } 
    ?>
    
                                   
    <?php if(isset($edn_bar_data['edn_constant_contact']['button_text'])){
     $btn_txt = $edn_bar_data['edn_constant_contact']['button_text'];
     }else{
    $btn_txt = 'Subsribe';
    } ?>
    <!-- <input type="submit" id="constant_subscribe_<?php echo $nb_id;?>" class="constant_subscribe" value="<?php _e($btn_txt,APEXNB_TD);?>" /> -->
    <button type="submit" id="constant_subscribe_<?php echo $nb_id;?>" class="constant_subscribe"><?php _e($btn_txt,APEXNB_TD);?></button>
    <div class="edn-constant-error"></div>
    <div class="edn-constant-success"></div>
    <div class="loader_view">
     <img src="<?php echo APEXNB_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-constant-ajax-loader"/>
     </div>
   
    </div>
</div>

</div>                
 <?php  }
?>
</div>
<?php  }elseif($edn_bar_data['edn_cp_type']=='twiter-tweets' && $consumer_key != ''){ ?>
<div class="edn-twitter-feed-wrap">
<?php 
    
    $username = $edn_bar_data['edn_twitter']['username'];
    $total_feed = $edn_bar_data['edn_twitter']['total_feed'];
     $consumer_key = $edn_bar_data['edn_twitter']['consumer_key'];
    $consumer_secret_key = $edn_bar_data['edn_twitter']['consumer_secret_key'];
    $access_token_key = $edn_bar_data['edn_twitter']['access_token_key'];
    $access_token_secret_key = $edn_bar_data['edn_twitter']['access_token_secret_key'];
    $cache_period = $edn_bar_data['edn_twitter']['cache_period'];
    $tweets = $this->get_twitter_tweets($nb_id,$username,$total_feed,$consumer_key,$consumer_secret_key,$access_token_key,$access_token_secret_key,$cache_period);
    if(!empty($tweets)){
    foreach ($tweets as $tweet) {
        // $this->edn_pro_print_array($tweet);
        // exit();
        foreach ($tweet as $tw){
        if(isset($tw->message)  && $tw->message != ''){
         $tweets_error = $tw->message;
              }
          }
         }
        }
?>

<?php if(isset($tweets_error)){ 
        echo $tweets_error;
    }else{ ?>
<ul class="edn-twitter-feed" id="edn-twitter-effect-<?php echo $effect_id;?>-<?php echo $nb_id;?>" data-barid="<?php echo $nb_id;?>">
<?php
    if(!empty($tweets)){
    foreach ($tweets as $tweet) {

        ?>
            <li <?php echo ($effect_id == "slider")?'class="clearfix"':'';?>>
                <div class="edn-tweet-content">
                    <?php

                        if (isset($tweet->full_text) && $tweet->full_text != '' || isset($tweet->text) && $tweet->text != '') {
                          if(isset($tweet->full_text) && $tweet->full_text != ''){
                            $the_tweet = ' '.$tweet->full_text . ' ';
                          }else{
                            $the_tweet = ' '.$tweet->text . ' ';
                          } //adding an extra space to convert hast tag into links
                            /*
                              Twitter Developer Display Requirements
                              https://dev.twitter.com/terms/display-requirements

                              2.b. Tweet Entities within the Tweet text must be properly linked to their appropriate home on Twitter. For example:
                              i. User_mentions must link to the mentioned user's profile.
                              ii. Hashtags must link to a twitter.com search with the hashtag as the query.
                              iii. Links in Tweet text must be displayed using the display_url
                              field in the URL entities API response, and link to the original t.co url field.
                             */

                            // i. User_mentions must link to the mentioned user's profile.
                            if (is_array($tweet->entities->user_mentions)) {
                                foreach ($tweet->entities->user_mentions as $key => $user_mention) {
                                    $the_tweet = preg_replace(
                                            '/@' . $user_mention->screen_name . '/i', '<a href="http://www.twitter.com/' . $user_mention->screen_name . '" target="_blank">@' . $user_mention->screen_name . '</a>', $the_tweet);
                                }
                            }

                            // ii. Hashtags must link to a twitter.com search with the hashtag as the query.
                            if (is_array($tweet->entities->hashtags)) {
                                foreach ($tweet->entities->hashtags as $hashtag) {
                                    $the_tweet = str_replace(' #' . $hashtag->text . ' ', ' <a href="https://twitter.com/search?q=%23' . $hashtag->text . '&src=hash" target="_blank">#' . $hashtag->text . '</a> ', $the_tweet);
                                }
                            }

                            // iii. Links in Tweet text must be displayed using the display_url
                            //      field in the URL entities API response, and link to the original t.co url field.
                            if (is_array($tweet->entities->urls)) {
                                foreach ($tweet->entities->urls as $key => $link) {
                                    $the_tweet = preg_replace(
                                            '`' . $link->url . '`', '<a href="' . $link->url . '" target="_blank">' . $link->url . '</a>', $the_tweet);
                                }
                            }

                            echo $the_tweet . ' ';
                        } else {
                            ?>
                            <p><a href="http://twitter.com/'<?php echo $username; ?> " class="edn-aptf-tweet-name" target="_blank"><?php _e('Click here to read ' . $username . '\'S Twitter feed', APEXNB_TD); ?></a></p>
                        <?php
                        }
                    ?>
                </div>
            </li>
        <?php 
    }
}
?>
</ul>
<?php } ?>
</div>

<?php  }else if($edn_bar_data['edn_cp_type']=='post-title'){ 
   if(isset($edn_bar_data['edn_recentposts']['edn_choose_filter_posts']) && $edn_bar_data['edn_recentposts']['edn_choose_filter_posts'] == "recent-posts"){ ?>
    <div class="edn-post-title-wrap">
                  <?php if(isset($edn_bar_data['edn_bar_effect_option']) && $edn_bar_data['edn_bar_effect_option']==1){;?><div class="edn-ticker-wrapper"><?php }?>
                   <?php 
                      $posts_per_page = (isset($edn_bar_data['edn_recentposts']['posts_per_page']) && $edn_bar_data['edn_recentposts']['posts_per_page'] != '')?$edn_bar_data['edn_recentposts']['posts_per_page']:'3';
                      $edn_posttype_value = (isset($edn_bar_data['edn_recentposts']['edn_posttype_value']) && $edn_bar_data['edn_recentposts']['edn_posttype_value'] != '')?$edn_bar_data['edn_recentposts']['edn_posttype_value']:'post';
                      $edn_recentposts_orderby = (isset($edn_bar_data['edn_recentposts']['edn_recentposts_orderby']) && $edn_bar_data['edn_recentposts']['edn_recentposts_orderby'] != '')?$edn_bar_data['edn_recentposts']['edn_recentposts_orderby']:'date';
                      $edn_recentposts_order = (isset($edn_bar_data['edn_recentposts']['edn_recentposts_order']) && $edn_bar_data['edn_recentposts']['edn_recentposts_order'] != '')?$edn_bar_data['edn_recentposts']['edn_recentposts_order']:'desc';
                      $show_read_more_btn = (isset($edn_bar_data['edn_recentposts']['show_read_more_btn']) && $edn_bar_data['edn_recentposts']['show_read_more_btn'] == 1)?1:0;
                      $read_more_label = (isset($edn_bar_data['edn_recentposts']['read_more_label']) && $edn_bar_data['edn_recentposts']['read_more_label'] != '')?$edn_bar_data['edn_recentposts']['read_more_label']:'';
                      $read_more_target =  (isset($edn_bar_data['edn_recentposts']['read_more_target']))?$edn_bar_data['edn_recentposts']['read_more_target']:'_self';
                             $args = array( 'numberposts' => $posts_per_page,
                              'orderby' => $edn_recentposts_orderby,
                              'order' => $edn_recentposts_order,
                              'post_type' => $edn_posttype_value,
                              'post_status' => 'publish');
                             $recent_posts = wp_get_recent_posts( $args );
                   ?>
                      <ul class="edn-post-title" id="edn-post-effect-<?php echo $effect_id;?>-<?php echo $nb_id;?>" data-barid="<?php echo $nb_id;?>">
                          <?php
                                foreach( $recent_posts as $recent ){  
                                  ?>
                                      <li <?php echo ($effect_id == "slider")?'class="clearfix"':'';?>>
                                        <?php echo $recent["post_title"];?>
                                       <?php if($show_read_more_btn == 1){ ?>
                                       <a class="edn-post-title-readmore" href="<?php echo get_permalink($recent["ID"]);?>" target="<?php echo $read_more_target;?>"><?php echo esc_attr($read_more_label);?></a>
                                       <?php } ?>
                                      </li>
                                  <?php
                                  }
                             wp_reset_query();
                            
                          ?>
                      </ul>
                  <?php if(isset($edn_bar_data['edn_bar_effect_option']) && $edn_bar_data['edn_bar_effect_option']==1){;?></div><?php }?>
              </div>
          <?php }else{ ?>
<div class="edn-post-title-wrap">
    <ul class="edn-post-title" id="edn-post-effect-<?php echo $effect_id;?>-<?php echo $nb_id;?>" data-barid="<?php echo $nb_id;?>">
        <?php
            foreach($edn_bar_data['edn_display'] as $post_title){
                // $title_array = explode('*-*',$post_title);
                // $title = $title_array[0];
                // $title_id = $title_array[1];
              $title_id = $post_title;
              $title = get_the_title($post_title);
                ?>
                    <li <?php echo ($effect_id == "slider")?'class="clearfix"':'';?>><?php echo $title;?> <a class="edn-post-title-readmore" href="<?php echo get_permalink($title_id);?>"><?php _e('Read more',APEXNB_TD);?></a></li>
                <?php
            }
        ?>
    </ul>
</div>

<?php } 
}else if($edn_bar_data['edn_cp_type']=='rss-feed'){ 
  //rss feed section
  if(isset($edn_bar_data['edn_rssfeed']['enable']) && $edn_bar_data['edn_rssfeed']['enable'] == 1){ ?>
<div class="edn_rss_feed_wrapper">
    <?php 
      $rss_url = ((isset($edn_bar_data['edn_rssfeed']['rss_url']) && $edn_bar_data['edn_rssfeed']['rss_url'] != '')?$edn_bar_data['edn_rssfeed']['rss_url']:'#');
      $link_text = ((isset($edn_bar_data['edn_rssfeed']['link_text']) && $edn_bar_data['edn_rssfeed']['link_text'] != '')?$edn_bar_data['edn_rssfeed']['link_text']:'Read More >>');
       $link_target = ((isset($edn_bar_data['edn_rssfeed']['link_target']) && $edn_bar_data['edn_rssfeed']['link_target'] != '')?$edn_bar_data['edn_rssfeed']['link_target']:'_self');
       $total_feed = ((isset($edn_bar_data['edn_rssfeed']['total_feed']) && $edn_bar_data['edn_rssfeed']['total_feed'] != '')?$edn_bar_data['edn_rssfeed']['total_feed']:'10');
         if($rss_url != '#'){
          $feeds_results = $this->edn_validateRssFeed($rss_url);
       if(isset($feeds_results->channel->item)){
         ?>
      <ul class="edn-rss-feed" id="edn-rss-effect-<?php echo $effect_id;?>-<?php echo $nb_id;?>" data-barid="<?php echo $nb_id;?>">
       <?php 
          $count = 1;
          foreach($feeds_results->channel->item as $entry) {
            if($count <= $total_feed ){ ?>
          <li <?php echo ($effect_id == "slider")?'class="clearfix"':'';?>>
             <?php echo $entry->title;?>
            <a href='<?php echo $entry->link;?>' class="edn_temp_link" target="<?php echo $link_target;?>" title='<?php echo $entry->title;?>'>
             <?php echo $link_text;?>
            </a>
            </li>
        <?php    }
            $count++;
          } 
       ?>
    </ul>
    <?php 
       }else{
       
            _e('<div class="edn-error">Invalid RSS URL.</div>',APEXNB_TD);
          }
        }
    ?>
</div>

<?php }
}else if($edn_bar_data['edn_cp_type']=='countdown-timer'){ 
  //countdown timer section
  if(isset($edn_bar_data['edn_countdowntimer']['enable']) && $edn_bar_data['edn_countdowntimer']['enable'] == 1){ ?>
<div class="edn_countdown_timer_main_wrapper">
 <?php
        //$enable_countdown = $settings_data['show_countdown'];

       // if ( $enable_countdown == '1' ) {
            $text_description = (isset($edn_bar_data['edn_countdowntimer']['text_description']) && $edn_bar_data['edn_countdowntimer']['text_description'] != '')?$edn_bar_data['edn_countdowntimer']['text_description']:'';
            $expirydate = (isset($edn_bar_data['edn_countdowntimer']['expirydate']) && $edn_bar_data['edn_countdowntimer']['expirydate'] != '')?$edn_bar_data['edn_countdowntimer']['expirydate']:'';
            $enable_repeat = (isset($edn_bar_data['edn_countdowntimer']['enable_repeat']) && $edn_bar_data['edn_countdowntimer']['enable_repeat'] == 1)?1:0;
            $enable_days = (isset($edn_bar_data['edn_countdowntimer']['enable_days']) && $edn_bar_data['edn_countdowntimer']['enable_days'] == 1)?1:0;
            $enable_hours = (isset($edn_bar_data['edn_countdowntimer']['enable_hours']) && $edn_bar_data['edn_countdowntimer']['enable_hours'] == 1)?1:0;
            $enable_minute = (isset($edn_bar_data['edn_countdowntimer']['enable_minute']) && $edn_bar_data['edn_countdowntimer']['enable_minute'] == 1)?1:0;
            $enable_seconds = (isset($edn_bar_data['edn_countdowntimer']['enable_seconds']) && $edn_bar_data['edn_countdowntimer']['enable_seconds'] == 1)?1:0;
            $enable_days_label = (isset($edn_bar_data['edn_countdowntimer']['enable_days_label']) && $edn_bar_data['edn_countdowntimer']['enable_days_label'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['enable_days_label']):'';
            $enable_hours_label = (isset($edn_bar_data['edn_countdowntimer']['enable_hours_label']) && $edn_bar_data['edn_countdowntimer']['enable_hours_label'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['enable_hours_label']):'';
            $enable_minute_label = (isset($edn_bar_data['edn_countdowntimer']['enable_minute_label']) && $edn_bar_data['edn_countdowntimer']['enable_minute_label'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['enable_minute_label']):'';
            $enable_seconds_label = (isset($edn_bar_data['edn_countdowntimer']['enable_seconds_label']) && $edn_bar_data['edn_countdowntimer']['enable_seconds_label'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['enable_seconds_label']):'';
           
            $animation = (isset($edn_bar_data['edn_countdowntimer']['animation']) && $edn_bar_data['edn_countdowntimer']['animation'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['animation']):'smooth';
            $layout_type = (isset($edn_bar_data['edn_countdowntimer']['layout_type']) && $edn_bar_data['edn_countdowntimer']['layout_type'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['layout_type']):'layout1';
            $layout_type2 = (isset($edn_bar_data['edn_countdowntimer']['layout_type2']) && $edn_bar_data['edn_countdowntimer']['layout_type2'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['layout_type2']):'layout2';
            $show_button = (isset($edn_bar_data['edn_countdowntimer']['show_button']) && $edn_bar_data['edn_countdowntimer']['show_button'] == 1)?1:0;
            $btnlabel = (isset($edn_bar_data['edn_countdowntimer']['btnlabel']) && $edn_bar_data['edn_countdowntimer']['btnlabel'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['btnlabel']):'';
            $link = (isset($edn_bar_data['edn_countdowntimer']['link']) && $edn_bar_data['edn_countdowntimer']['link'] != '')?esc_url($edn_bar_data['edn_countdowntimer']['link']):'';
            $url_target = (isset($edn_bar_data['edn_countdowntimer']['url_target']) && $edn_bar_data['edn_countdowntimer']['url_target'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['url_target']):'_self';
            ?> 
            <?php if($enable_repeat == 1){
               $layouttype = $layout_type2;
            }else{
               $layouttype = $layout_type;
            }?>
            <!--Countdown Timer Section--> 

             <div class="countdown-wrap apexnb_<?php echo $layouttype;?>"> 
                <input type="hidden" name="hidden_date" class="date_val" value="<?php echo $expirydate; ?>" />
                <?php 
                  $timestamp = strtotime($expirydate);
                  $day_number = date('w', $timestamp);
                  $time1 = strtotime($expirydate);
                  $time_number = date('H', $time1);
                  ?>
                <input type="hidden" name="hidden_day_number" class="day_number" value="<?php echo $day_number; ?>" />
                <input type="hidden" name="hidden_time_number" class="time_number" value="<?php echo $time_number; ?>" />
                <input type="hidden" name="hidden_enable_repeat" class="enable_repeat" value="<?php echo $enable_repeat; ?>" />
                <input type="hidden" name="hidden_days" class="days_val" value="<?php echo $enable_days_label; ?>" />
                <input type="hidden" name="hidden_hour" class="hour_val" value="<?php echo $enable_hours_label; ?>" />
                <input type="hidden" name="hidden_minute" class="minute_val" value="<?php echo $enable_minute_label; ?>" />
                <input type="hidden" name="hidden_second" class="second_val" value="<?php echo $enable_seconds_label; ?>" />
              
                <input type="hidden" name="hidden_animation" class="animation_val" value="<?php echo $animation; ?>" />

                <input type="hidden" name="enable_days" class="enable_days" value="<?php echo $enable_days; ?>" />
                <input type="hidden" name="enable_hours" class="enable_hours" value="<?php echo $enable_hours; ?>" />
                <input type="hidden" name="enable_minute" class="enable_minute" value="<?php echo $enable_minute; ?>" />
                <input type="hidden" name="enable_seconds" class="enable_seconds" value="<?php echo $enable_seconds; ?>" />   

             <p class="counter_desc"><?php echo  $text_description;?></p>       
            <?php if($layouttype == "layout1"){ ?>
                      <div class="ApexDateCountdown" data-date="<?php echo $expirydate; ?>" style="width: 360px; height: 90px;padding: 0px; box-sizing: border-box;" 
                      data-background-color="#888" data-template="14"></div>
            <?php }
           else{ ?>       
             <div id="clockdiv" class="apex_countdown clearfix countdown_<?php echo $layouttype;?>">
                       <?php if($enable_days ==1){?>
                       <div>
                        <!-- <li class="days-countdown-wrap"> -->
                            <span class="days lay2-days" id="daysss">00</span>
                            <p class="smalltext days_ref days-layout2" id="dayss"><?php echo $enable_days_label;?></p>
                        <!-- </li> -->
                        </div>
                        <?php } ?>
                         <?php if($enable_hours ==1){?>
                          <div>
                        <!-- <li class="hours-countdown-wrap"> -->
                            <span class="hours lay2-hours" id="hourss">00</span>
                            <p class="smalltext hours_ref hours-layout2" id="hours"><?php echo $enable_hours_label;?></p>
                        <!-- </li> -->
                        </div>
                            <?php } ?>
                             <?php if($enable_minute ==1){?>
                        <div>
                        <!-- <li class="minutes-countdown-wrap"> -->
                            <span class="minutes lay2-minute" id="mins">00</span>
                            <p class="smalltext minutes_ref minute-layout2"><?php echo $enable_minute_label;?></p>
                        <!-- </li> -->
                        </div>
                        <?php } ?>
                             <?php if($enable_seconds ==1){?>
                           <div>
                        <!-- <li class="seconds-countdown-wrap"> -->
                            <span class="seconds last lay2-second" id="secs">00</span>
                            <p class="smalltext seconds_ref seconds-layout2"><?php echo $enable_seconds_label;?></p>
                        <!-- </li> -->
                        </div>
                         <?php } ?>
                    </div> 
       <?php } ?>
           <?php if($show_button == 1){ ?>
           <a href="<?php echo $link;?>" target="<?php echo $url_target;?>" class="btn_calltoaction"><?php echo $btnlabel;?></a>
           <?php } ?>
           </div>  
</div>
<?php }
}else if($edn_bar_data['edn_cp_type']=='video-popup'){  
 $title = (isset($edn_bar_data['edn_video']['title']) && $edn_bar_data['edn_video']['title'] != '')?esc_attr($edn_bar_data['edn_video']['title']):'';
 $layout_type = (isset($edn_bar_data['edn_video']['layout_type']) && $edn_bar_data['edn_video']['layout_type'] != '')?esc_attr($edn_bar_data['edn_video']['layout_type']):'layout1';
 $fonticons = (isset($edn_bar_data['edn_video']['font-icon']) && $edn_bar_data['edn_video']['font-icon'] != '')?esc_attr($edn_bar_data['edn_video']['font-icon']):'';
 $description  = (isset($edn_bar_data['edn_video']['description']) && $edn_bar_data['edn_video']['description'] != '')?esc_attr($edn_bar_data['edn_video']['description']):'';
 $video_type   = (isset($edn_bar_data['edn_video']['video_type']) && $edn_bar_data['edn_video']['video_type'] != '')?esc_attr($edn_bar_data['edn_video']['video_type']):'';
 $video_url    = (isset($edn_bar_data['edn_video']['video_url']) && $edn_bar_data['edn_video']['video_url'] != '')?esc_url($edn_bar_data['edn_video']['video_url']):'';
 $vimeo_url    = (isset($edn_bar_data['edn_video']['vimeo_url']) && $edn_bar_data['edn_video']['vimeo_url'] != '')?esc_url($edn_bar_data['edn_video']['vimeo_url']):'';
 $upload_url   = (isset($edn_bar_data['edn_video']['upload_url']) && $edn_bar_data['edn_video']['upload_url'] != '')?esc_url($edn_bar_data['edn_video']['upload_url']):'';
 $ext          = pathinfo($upload_url, PATHINFO_EXTENSION); 
 $button_title = (isset($edn_bar_data['edn_video']['button_title']) && $edn_bar_data['edn_video']['button_title'] != '')?esc_attr($edn_bar_data['edn_video']['button_title']):'';
 
 $popup_animation_speed = (isset($edn_bar_data['edn_video']['popup_animation_speed']) && $edn_bar_data['edn_video']['popup_animation_speed'] != '')?esc_attr($edn_bar_data['edn_video']['popup_animation_speed']):'slow';
 $video_autoplay = (isset($edn_bar_data['edn_video']['video_autoplay']) && $edn_bar_data['edn_video']['video_autoplay'] != '')?esc_attr($edn_bar_data['edn_video']['video_autoplay']):'false';
 $show_title_on_popup = (isset($edn_bar_data['edn_video']['show_title_on_popup']) && $edn_bar_data['edn_video']['show_title_on_popup'] != '')?esc_attr($edn_bar_data['edn_video']['show_title_on_popup']):'true';
 $video_popup_theme = (isset($edn_bar_data['edn_video']['video_popup_theme']) && $edn_bar_data['edn_video']['video_popup_theme'] != '')?esc_attr($edn_bar_data['edn_video']['video_popup_theme']):'facebook';
 $video_popup_width = (isset($edn_bar_data['edn_video']['video_popup_width']) && $edn_bar_data['edn_video']['video_popup_width'] != '')?esc_attr($edn_bar_data['edn_video']['video_popup_width']):'500';
 $video_popup_height = (isset($edn_bar_data['edn_video']['video_popup_height']) && $edn_bar_data['edn_video']['video_popup_height'] != '')?esc_attr($edn_bar_data['edn_video']['video_popup_height']):'344';
    if( $show_title_on_popup == "false"){
     $title_name =  "";
 }else{
    $title_name =  $title;
 }
 ?>
 <div class="apexnb-video-popup-section clearfix <?php echo 'apexnb-video-'.$layout_type;?> <?php echo 'apexnb-'.$video_type;?>">
  <?php if($layout_type != "layout4" && $fonticons != '' ){?>
   <div class="apexnb-vicon video-font-icon-left"><i class="<?php echo $fonticons;?>"></i></div>
  <?php } ?>
  <div class="apexnb-video-section">
    <div class="apexnb-video-rt-wrapper">
      <h2><?php echo $title;?></h2>
      <?php if($description != ''){ ?>
      <p><?php echo substr($description, 0, 160);?>...</p>
      <?php } ?>
    </div>
   <?php if($video_type == "youtube"){
      $visit_url =  $video_url;
      ?>
      <div class="apexnb-video-view-btn">
          <a class="apexnb-video-btn" href="<?php echo $visit_url;?>" title="<?php echo $title_name;?>" data-speed="<?php echo  $popup_animation_speed;?>"
          data-autoplay="<?php echo  $video_autoplay;?>" data-showtitle="<?php echo  $show_title_on_popup;?>" data-popuptheme="<?php echo  $video_popup_theme;?>"
          data-width="<?php echo  $video_popup_width;?>" data-height="<?php echo  $video_popup_height;?>">
             <?php echo $button_title;?>
          </a>
        </div>
      <?php 
   }else if($video_type == "vimeo"){
      $urlParts = explode("/", parse_url($vimeo_url, PHP_URL_PATH));
      $visit_url = (int)$urlParts[count($urlParts)-1];  ?>
  <div class="apexnb-video-view-btn">
      <a class="apexnb-video-btn" href="https://vimeo.com/<?php echo esc_attr($visit_url); ?>" title="<?php echo $title_name;?>" data-speed="<?php echo  $popup_animation_speed;?>"
      data-autoplay="<?php echo  $video_autoplay;?>" data-showtitle="<?php echo  $show_title_on_popup;?>" data-popuptheme="<?php echo  $video_popup_theme;?>"
      data-width="<?php echo  $video_popup_width;?>" data-height="<?php echo $video_popup_height;?>">
         <?php echo $button_title;?>
      </a>
    </div>
 <?php 
   }else{ ?>
   <div class="apexnb-video-view-btn">
             <a class="apexnb-video-btn" href="#apex-inline-<?php echo $random_num;?>" title="<?php echo $title_name;?>" data-speed="<?php echo  $popup_animation_speed;?>"
            data-autoplay="<?php echo  $video_autoplay;?>" data-showtitle="<?php echo $show_title_on_popup;?>" data-popuptheme="<?php echo  $video_popup_theme;?>"
            data-width="<?php echo  $video_popup_width;?>" data-height="<?php echo  $video_popup_height;?>"><?php echo $button_title;?></a>
    </div>
                <div id="apex-inline-<?php echo $random_num;?>" class="hide" style="display:none;">
                <video  style="width:<?php echo $video_popup_width;?>px;height:<?php echo $video_popup_height;?>px;" class="apexnb-html5-video-wrapper" <?php if( $video_autoplay == "true") echo "autoplay";?> loop controls >
                    <source src="<?php echo esc_url($upload_url); ?>" type="video/<?php echo $ext; ?>">
                </video>
                </div>
      <?php 
    } ?>
  

     <?php if($layout_type == "layout4" && $fonticons != '' ){?>
     <div class="apexnb-vicon video-font-icon-right"><i class="<?php echo $fonticons;?>"></i></div>
      <?php } ?>

  </div>

  </div>

<?php
}
else if($edn_bar_data['edn_cp_type']=='search-form'){
 $btnname = __('Search',APEXNB_TD);
 $search_layout_type = ((isset($edn_bar_data['edn_search_form']['layout_type']) && $edn_bar_data['edn_search_form']['layout_type'] != '')?$edn_bar_data['edn_search_form']['layout_type']:'layout1');
 $description = ((isset($edn_bar_data['edn_search_form']['description']) && $edn_bar_data['edn_search_form']['description'] != '')?$edn_bar_data['edn_search_form']['description']:'');
 $input_placeholder = ((isset($edn_bar_data['edn_search_form']['input_placeholder']) && $edn_bar_data['edn_search_form']['input_placeholder'] != '')?$edn_bar_data['edn_search_form']['input_placeholder']:'');
 $hide_button_text = (isset($edn_bar_data['edn_search_form']['hide_button_text']) && $edn_bar_data['edn_search_form']['hide_button_text'] == 1)?1:0;
 $hide_icon = (isset($edn_bar_data['edn_search_form']['hide_icon']) && $edn_bar_data['edn_search_form']['hide_icon'] == 1)?1:0;
 $button_name = ((isset($edn_bar_data['edn_search_form']['button_name']) && $edn_bar_data['edn_search_form']['button_name'] != '')?$edn_bar_data['edn_search_form']['button_name']:'');
 $font_icon = ((isset($edn_bar_data['edn_search_form']['font_icon']) && $edn_bar_data['edn_search_form']['font_icon'] != '')?$edn_bar_data['edn_search_form']['font_icon']:'');

?>
<?php 
if($hide_button_text == 1 && $hide_icon != 1 ){
   $addclasss ="apexnb_show_icononly";
}else if($hide_button_text != 1 && $hide_icon == 1 ){
    $addclasss ="apexnb_show_btnonly";

}else if($hide_button_text == 1 && $hide_icon == 1 ){
    $addclasss = "apexnb_hideallbutton";
 }else{
      $addclasss = "apexnb_show_both_sbtn";
  }?>
<div class="apexnb-searchwrapper <?php echo 'apexnb-search-'.$search_layout_type; ?>">
   <form role="search" method="get" class="searchform" action="<?php echo home_url( '/' ); ?>">
        <p class="apex-onscreen-description"><?php echo _x( $description , APEXNB_TD) ?></p>
        <div class="apex-search-right-section <?php echo $addclasss;?> clearfix">
            <label>
              <?php if($search_layout_type == "layout1" || $search_layout_type == "layout4"){ ?>
               <i class='<?php echo $font_icon;?>'></i>
               <?php  }?>
              <input type="search" class="search-field" placeholder="<?php echo esc_attr_x($input_placeholder ,APEXNB_TD) ?>" 
               value="<?php echo get_search_query() ?>" name="s" />
            </label>

            <button type='submit' class="btn-search-now">
            <?php if($hide_icon != 1 && $font_icon != ''){ ?>
            <i class='<?php echo $font_icon;?>'></i>
            <?php }
             if($hide_button_text != 1){ 
             echo esc_attr_x( $button_name, APEXNB_TD );
             } ?>
          </button>
      </div>
  </form>
</div>
<?php  
}
else{ 
  //custom html section ?>
<div class="edn_custom_html_wrapper">
<?php 
 $content = ((isset($edn_bar_data['edn_custom_html']['content']) && $edn_bar_data['edn_custom_html']['content'] != '')?$edn_bar_data['edn_custom_html']['content']:'');
 // echo $content;
echo do_shortcode( $content);
 ?>
</div>
<?php }
?>
</div>
</div><!-- edn of right-section-wrap -->  

<?php if(isset($edn_bar_data['edn_social_optons']) && isset($edn_bar_data['edn_right_optons'] ) 
&& $edn_bar_data['edn_social_optons']==1 && $edn_bar_data['edn_right_optons'] ==1){?>
</div>
<?php } ?>
<?php } ?>
<!-- right content end -->

</div><!-- Template 14 Pre Design End -->
<?php
}
?>
</div>

