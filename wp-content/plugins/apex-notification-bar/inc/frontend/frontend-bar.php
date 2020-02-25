<?php 
 $random_num = rand(10000,99999);
if(isset($get_data_from_table[0]) && !empty($get_data_from_table[0])){
	$edn_data = $get_data_from_table[0];
    $nb_id = $edn_data->nb_id;
    $edn_bar_data = unserialize($edn_data->edn_bar);
    $edn_bar_date = unserialize($edn_data->edn_date);
    if(isset($check_me) && $check_me == "checkshow"){
    if(intval($nb_id)){
    if(!empty($edn_bar_date['start_date'])){
        $edn_start_date = $edn_bar_date['start_date'];
        $start_date = strtotime($edn_start_date);
        $edn_end_date = $edn_bar_date['end_date'];
        $end_date = strtotime($edn_end_date);
        $today_date = strtotime(date('Y-m-d'));
         if($today_date == $start_date){
            $display = ''; 
            $data_wise_class = "show_bar_class";
         }else if($today_date > $end_date){
            $display = 'style="display:none;"'; 
            $data_wise_class = "apexbar_hide_bar_bydate";
         }else if($today_date<$start_date){
            $display = 'style="display:none;"'; 
            $data_wise_class = "apexbar_hide_bar_bydate";
         }else{
             $display = ''; 
             $data_wise_class = "show_bar_class";
         }
     }else{
          $display = '';
          $data_wise_class = "show_bar_class";
     }
    }
  }else{
    $display = '';
    $data_wise_class = "show_bar_class";
  }
       
    $edn_postion = $edn_data->edn_position;
    $edn_visibility = $edn_data->edn_visibility;
    $edn_close_button = $edn_data->edn_close_button;
    $closebtn_position = (isset($edn_bar_data['closebtn_position']) && $edn_bar_data['closebtn_position'] == 'left')?'left':'right';
    $closebtn_rtposition = (isset($edn_bar_data['closebtn_rtposition']) && $edn_bar_data['closebtn_rtposition'] == 'top')?'top':'bottom';

    $visibility_type =  esc_attr($edn_data->edn_visibility);
    $click_btn_id = (isset($edn_bar_data['edn_click_btn_id']) && $edn_bar_data['edn_click_btn_id'] != '')?esc_attr($edn_bar_data['edn_click_btn_id']):'';

    $postion =  esc_attr($edn_postion);
    
     $cptype = $edn_bar_data['edn_cp_type'];
        switch($cptype){
           case 'email-subs':
           $effect_id2 ="ednpro_opt_settings";
           $effect_id = 'ednpro_opt_settings';
           break;
            case 'countdown-timer':
           $effect_id2 ="ednpro_timer_settings";
           $effect_id = 'ednpro_timer_settings';
           break;
            case 'video-popup':
           $effect_id2 ="ednpro_videopopup_settings";
           $effect_id = 'ednpro_videopopup_settings';
           break;
            case 'custom-html':
           $effect_id2 ="ednpro_customhtml_settings";
           $effect_id = 'ednpro_customhtml_settings';
           break;
             case 'search-form':
           $effect_id2 ="ednpro_searchform_settings";
           $effect_id = 'ednpro_searchform_settings';
           break;
           case 'text':
           if($edn_bar_data['edn_text_display_mode'] == 'static'){
             $effect_id2 ="ednpro_static";
             $effect_id = 'edn_pro_static';
           }else{
              if($edn_bar_data['edn_bar_effect_option']==1){
                $effect_id2 = 'ticker';
                $effect_id = 'ticker';
              }else if($edn_bar_data['edn_bar_effect_option']==2){
                $effect_id2 = 'slider';
                $effect_id = 'slider';
             }else{
                $effect_id2 = 'scroller';
                $effect_id = 'scroller';
             }
           }    
           break;
           case 'twiter-tweets':
              if($edn_bar_data['edn_bar_effect_option']==1){
                    $effect_id2 = 'ticker';
                    $effect_id = 'ticker';
                  }else if($edn_bar_data['edn_bar_effect_option']==2){
                    $effect_id2 = 'slider';
                    $effect_id = 'slider';
                 }else{
                    $effect_id2 = 'scroller';
                    $effect_id = 'scroller';
                 }
           break;
           case 'post-title':
               if($edn_bar_data['edn_bar_effect_option']==1){
                    $effect_id2 = 'ticker';
                    $effect_id = 'ticker';
                  }else if($edn_bar_data['edn_bar_effect_option']==2){
                    $effect_id2 = 'slider';
                     $effect_id = 'slider';
                 }else{
                    $effect_id2 = 'scroller';
                    $effect_id = 'scroller';
                 }
           break;
           case 'rss-feed':
               if($edn_bar_data['edn_bar_effect_option']==1){
                    $effect_id2 = 'ticker';
                    $effect_id = 'ticker';
                  }else if($edn_bar_data['edn_bar_effect_option']==2){
                    $effect_id2 = 'slider';
                     $effect_id = 'slider';
                 }else{
                    $effect_id2 = 'scroller';
                    $effect_id = 'scroller';
                 }
           break;
           default:
           $effect_id2 ="ednpro";
           $effect_id = 'ednpro';
           break;

        }
         if($edn_bar_data['edn_bar_type'] == 1){
             $edn_bartype  = 'edn-custom-template';
         }else{
            $edn_bartype  = 'edn-pre-template';
         }

       $template = $edn_bar_data['edn_bar_template'];

        if(!empty($template) && $edn_bar_data['edn_bar_type'] == 2){
           $pretemplate_classname = "edn_main_template".$template;
        } else{
            $pretemplate_classname = 'edn_custom_template';
        }
        $consumer_key = $edn_bar_data['edn_twitter']['consumer_key'];
        $fonts =  esc_attr($edn_bar_data['edn_fonts']);
        $fonts_final = str_replace(' ', '+', $fonts);

/* open panel section */
$edn_widgets = (isset($edn_bar_data['edn_open_panel']['edn_widgets']) && !empty($edn_bar_data['edn_open_panel']['edn_widgets'])?$edn_bar_data['edn_open_panel']['edn_widgets']:array());


$enable = isset($edn_bar_data['edn_open_panel']['enable_openpanel'])?$edn_bar_data['edn_open_panel']['enable_openpanel']:'0';
$opanel_ebgimage  = (isset($edn_bar_data['edn_open_panel']['enable_bgimage']) && $edn_bar_data['edn_open_panel']['enable_bgimage'] == 1)?1:0;
$opanel_bgimage_url     = isset($edn_bar_data['edn_open_panel']['bgimage_url'])?esc_url($edn_bar_data['edn_open_panel']['bgimage_url']):'';
$bg_opacity_color     = isset($edn_bar_data['edn_open_panel']['bg_opacity_color'])?esc_attr($edn_bar_data['edn_open_panel']['bg_opacity_color']):'';
//trigger image option
$trigger_enable  = (isset($edn_bar_data['edn_open_panel']['trigger_enable']) && $edn_bar_data['edn_open_panel']['trigger_enable'] == 1)?1:0;
$trigger_layout = (isset($edn_bar_data['edn_open_panel']['trigger_layout']) && $edn_bar_data['edn_open_panel']['trigger_layout'] == 'available_image')?'available_image':'upload_custom'; //trigger template image Type
$template_trigger_number = (isset($edn_bar_data['edn_open_panel']['trigger_template']) && $edn_bar_data['edn_open_panel']['trigger_template'] != '')?esc_attr($edn_bar_data['edn_open_panel']['trigger_template']):'1'; 
$trigger_template = (isset($edn_bar_data['edn_open_panel']['trigger_template']) && $edn_bar_data['edn_open_panel']['trigger_template'] != '')?esc_attr('trigger_template'.$edn_bar_data['edn_open_panel']['trigger_template']):'trigger_template1'; 

$trigger_image = (isset($edn_bar_data['edn_open_panel']['trigger_image']) && $edn_bar_data['edn_open_panel']['trigger_image'] != '')?esc_url($edn_bar_data['edn_open_panel']['trigger_image']):''; //custom image
//trigger image option end

$edn_enable_hover_text        = isset($edn_bar_data['edn_open_panel']['enable_hover_text'])?$edn_bar_data['edn_open_panel']['enable_hover_text']:'0';
$edn_hover_panel_text     = isset($edn_bar_data['edn_open_panel']['edn_hover_panel_text'])?esc_attr($edn_bar_data['edn_open_panel']['edn_hover_panel_text']):'';

/*header*/
$edn_show_header          = isset($edn_bar_data['edn_open_panel']['edn_show_header'])?$edn_bar_data['edn_open_panel']['edn_show_header']:'0';
$edn_header_text          = isset($edn_bar_data['edn_open_panel']['edn_header_text'])?esc_attr($edn_bar_data['edn_open_panel']['edn_header_text']):'';
$edn_header_color         = isset($edn_bar_data['edn_open_panel']['edn_header_color'])?esc_attr($edn_bar_data['edn_open_panel']['edn_header_color']):'';
$show_border_header       =  isset($edn_bar_data['edn_open_panel']['show_border_header'])?$edn_bar_data['edn_open_panel']['show_border_header']:'0';


/*footer*/
$edn_show_footer          = isset($edn_bar_data['edn_open_panel']['edn_show_footer'])?$edn_bar_data['edn_open_panel']['edn_show_footer']:'0';
$edn_footer_text          = isset($edn_bar_data['edn_open_panel']['edn_footer_text'])?esc_attr($edn_bar_data['edn_open_panel']['edn_footer_text']):'';
$edn_footer_color         = isset($edn_bar_data['edn_open_panel']['edn_footer_color'])?esc_attr($edn_bar_data['edn_open_panel']['edn_footer_color']):'';
$show_border_footer       =  isset($edn_bar_data['edn_open_panel']['show_border_footer'])?$edn_bar_data['edn_open_panel']['show_border_footer']:'0';


$edn_border_color         = isset($edn_bar_data['edn_open_panel']['edn_border_color'])?$edn_bar_data['edn_open_panel']['edn_border_color']:'0';
$edn_header_tag_color     = isset($edn_bar_data['edn_open_panel']['edn_header_tag_color'])?$edn_bar_data['edn_open_panel']['edn_header_tag_color']:'';
$edn_desc_tag_color       = isset($edn_bar_data['edn_open_panel']['edn_desc_tag_color'])?$edn_bar_data['edn_open_panel']['edn_desc_tag_color']:'';
$edn_hyperlink_color      = isset($edn_bar_data['edn_open_panel']['edn_hyperlink_color'])?$edn_bar_data['edn_open_panel']['edn_hyperlink_color']:'';
$edn_hyperlinkhover_color = isset($edn_bar_data['edn_open_panel']['edn_hyperlinkhover_color'])?$edn_bar_data['edn_open_panel']['edn_hyperlinkhover_color']:'';

$edn_panel_content_type   = (isset($edn_bar_data['edn_open_panel']['edn_content_type']) && $edn_bar_data['edn_open_panel']['edn_content_type'] != '')?esc_attr($edn_bar_data['edn_open_panel']['edn_content_type']):'html_text';
$edn_panel_content_text   = (isset($edn_bar_data['edn_open_panel']['edn_content_text']) && $edn_bar_data['edn_open_panel']['edn_content_text'] != '')?$edn_bar_data['edn_open_panel']['edn_content_text']:'';

$edn_panel_columns        = isset($edn_bar_data['edn_open_panel']['edn_panel_columns'])?$edn_bar_data['edn_open_panel']['edn_panel_columns']:'3';

$edn_header_bgcolor       =    isset($edn_bar_data['edn_open_panel']['edn_header_bgcolor'])?$edn_bar_data['edn_open_panel']['edn_header_bgcolor']:'';
$edn_header_bgbordercolor = isset($edn_bar_data['edn_open_panel']['edn_header_bgbordercolor'])?$edn_bar_data['edn_open_panel']['edn_header_bgbordercolor']:'';

$show_once_loggedusers = (isset($edn_bar_data['show_once_loggedusers']) && $edn_bar_data['show_once_loggedusers'] == 1)?'1':'0';

$enbale_snowflakes = (isset($edn_bar_data['enbale_snowflakes']) && $edn_bar_data['enbale_snowflakes'] == 1)?'1':'0';
if($enbale_snowflakes == 1){
  $enbale_snowflakes_class = " ednpro_show_snow ";
}else{
  $enbale_snowflakes_class = "";
}

$dstyle= !(isset($_COOKIE["cookie_set_time_".$nb_id]))?'':'style="display:none;"';
// echo "dtsylt=".$dstyle;
?>
<?php $edn_general_options = array();
if ( is_user_logged_in() ) {
    $user_id = get_current_user_id();
    $loggedin  = "1";
  }else{
    $user_id = '0';
    $loggedin  = "0";
  }
  $edn_general_options = get_option('edn_general_options');

  
if(isset($edn_general_options) && !empty($edn_general_options)){
     foreach ($edn_general_options as $key => $val) {
         if ($val['nb_id'] == $nb_id && $val['userid'] == $user_id) {
         $res = '1';

     }else{
      $res = '2';
     }
   }
  }else{
      $res = '2';
     }

if($edn_close_button == "show-hide" || $edn_close_button == "user-can-close"){
if($res == 1){
   $hide_bar = "display:none;";
}else{
    $hide_bar = "";
}
}else{
   $hide_bar = "";
}
?>
<div class="ednpro_main_wrapper ednpro_section <?php echo $enbale_snowflakes_class;?>" style="<?php echo $hide_bar;?>">
<?php  // check custom css and load
if(isset($edn_bar_data['enable_custom_css']) && $edn_bar_data['enable_custom_css'] == 1){
if(isset($edn_bar_data['custom_css']) && $edn_bar_data['custom_css'] != ''){ ?>
<style type="text/css">
<?php echo $edn_bar_data['custom_css'];?>
</style>
<?php }
}
if(isset($edn_bar_data['enable_custom_js']) && $edn_bar_data['enable_custom_js'] == 1){
if(isset($edn_bar_data['custom_js']) && $edn_bar_data['custom_js'] != ''){ ?>
<script type="text/javascript">
<?php echo $edn_bar_data['custom_js'];?>
</script>
<?php }
}
?>

<?php if(isset($disable_mobile_bar) && $disable_mobile_bar == '' && $disable_mobile_bar == 0){?>
<style type="text/css">
  @media (max-width: 480px) { 
      .edn-notify-bar{
          display:none; 
      }   
  }
</style>
<?php } ?>
<?php if ( is_user_logged_in() ) { ?>
<style type="text/css">
.edn-bottom-up-arrow.open{top:42px;}
.edn-notify-bar.edn-visibility-show-time{
  display: none;
}

</style>
<?php  } ?>
<div class="edn-close-section" id="apex_cookie_<?php echo $nb_id;?>" <?php echo $dstyle;?>>  
<?php 
if($edn_bartype  == 'edn-custom-template'){ 
include('custom-css.php');
} ?>
<?php if($fonts_final !="default"){ ?>
<link rel='stylesheet' id='edn-google-fonts-style-css' href='//fonts.googleapis.com/css?family=<?php echo $fonts_final;?>' type='text/css' media='all' /> 
<?php } 
if($edn_close_button == "show-hide" || $edn_close_button == "user-can-close"){
   $addClass = "edn_close_button_show";
}else{
  $addClass = "edn_no_close_button";
} ?>

<?php if(isset($edn_bar_data['edn_social_optons']) && isset($edn_bar_data['edn_right_optons'] ) 
  && $edn_bar_data['edn_logo_section']['enable_logo'] && $edn_bar_data['edn_logo_section']['enable_logo'] != true 
  && $edn_bar_data['edn_social_optons'] !=1 && $edn_bar_data['edn_right_optons'] !=1){
   $style = "style='display:none;'";
   $checkcomponents = 1;
   }else if(isset($edn_bar_data['edn_logo_section']['enable_logo']) && $edn_bar_data['edn_logo_section']['enable_logo'] == true){ 
     $style = "";
     $checkcomponents = 0;  
    }else{
 $style = "";
     $checkcomponents = 0;  
      } ?>
<?php 
/* Class added if open panel enabled */
if($enable == 1){
$addopenclass = "edn-pro-open-panel-active";
}else{
$addopenclass = "edn-pro-open-panel-disabled";
} 

/* Class added for only open panel display*/
$enable_logo_image = (isset($edn_bar_data['edn_logo_section']['enable_logo']) && $edn_bar_data['edn_logo_section']['enable_logo'] == true)?1:0;
$edn_social_optons = (isset($edn_bar_data['edn_social_optons']) && $edn_bar_data['edn_social_optons'] != '')?1:0;
$edn_right_optons = (isset($edn_bar_data['edn_right_optons']) && $edn_bar_data['edn_right_optons'] != '')?1:0;

if($enable_logo_image == 1 && $edn_social_optons == 0 && $edn_right_optons == 0 && $enable == 0){
  $only_open_panel = "apexnb-single-logo"; // only logo
}else if($enable_logo_image == 0 && $edn_social_optons == 1 && $edn_right_optons == 0 && $enable == 0){
  $only_open_panel = "apexnb-single-social-icons-left"; // only social icons
}else if($enable_logo_image == 0 && $edn_social_optons == 0 && $edn_right_optons == 1 && $enable == 0){
  $only_open_panel = "apexnb-single-right";  // only right components
}else if($enable_logo_image == 0 && $edn_social_optons == 0 && $edn_right_optons == 0 && $enable == 1){
   $only_open_panel = "apexnb-single-open-panel"; // only open panel
}else if($enable_logo_image == 1 && $edn_social_optons == 1 && $edn_right_optons == 1 && $enable == 1){
   $only_open_panel = "apexnb-all-components";  //all 
}else if($enable_logo_image == 1 && $edn_social_optons == 1 && $edn_right_optons == 0 && $enable == 0){
   $only_open_panel = "apexnb-logo-social-section"; // logo and social icons
}else if($enable_logo_image == 1 && $edn_social_optons == 0 && $edn_right_optons == 1 && $enable == 0){
   $only_open_panel = "apexnb-logo-right-section"; // logo and right comp
}else if($enable_logo_image == 1 && $edn_social_optons == 0 && $edn_right_optons == 0 && $enable == 1){
   $only_open_panel = "apexnb-logo-panel-section";  // logo and open panel
}else if($enable_logo_image == 1 && $edn_social_optons == 1 && $edn_right_optons == 1 && $enable == 0){
   $only_open_panel = "apexnb-logo-social-right-section";  // logo , right, social 
}else if($enable_logo_image == 0 && $edn_social_optons == 1 && $edn_right_optons == 1 && $enable == 1){
   $only_open_panel = "apexnb-social-right-panel-section"; //  right, social, open panel 
}else if($enable_logo_image == 0 && $edn_social_optons == 1 && $edn_right_optons == 1 && $enable == 0){
   $only_open_panel = "apexnb-social-right-section"; //  right, social
}else if($enable_logo_image == 0 && $edn_social_optons == 1 && $edn_right_optons == 0 && $enable == 1){
   $only_open_panel = "apexnb-social-openpanel-section"; //   social, open
}else if($enable_logo_image == 0 && $edn_social_optons == 0 && $edn_right_optons == 1 && $enable == 1){
   $only_open_panel = "apexnb-right-openpanel-section"; //   right, openelse{}
}else if($enable_logo_image == 1 && $edn_social_optons == 1 && $edn_right_optons == 0 && $enable == 1){
   $only_open_panel = "apexnb-right-openpanel-section"; //  logo , social icons, open panel
}else if($enable_logo_image == 1 && $edn_social_optons == 0 && $edn_right_optons == 1 && $enable == 1){
   $only_open_panel = "apexnb-right-openpanel-section"; //  logo , right, open panel
}else{
  $only_open_panel ='';
}

if($postion == "top" || $postion == "top_absolute" || $postion == "bottom"){
  if($closebtn_position == "right"){
   $btn_class = "edn-btn-position-right";
  }else{
   $btn_class = "edn-btn-position-left";
  }
}else{
  $btn_class = "";
}
?>
<div data-clickattribute="<?php echo $click_btn_id;?>" class="edn-notify-bar <?php echo $btn_class;?> edn-position-<?php echo $postion; ?> edn-visibility-<?php echo $visibility_type;?> <?php if(isset($edn_bartype)){
 echo $edn_bartype;} ?> <?php echo $addClass;?> <?php echo $addopenclass ;?> <?php echo $only_open_panel;?> <?php echo $data_wise_class;?>" <?php if(isset($display)){ echo $display;}?> 
 id="<?php echo $pretemplate_classname;?>" data-barid="apexbar-<?php echo $nb_id;?>" data-postid="<?php echo $post->ID;?>">
<input type="hidden" id='effect_type<?php echo $nb_id;?>' value="<?php echo $effect_id;?>"/>
<input type="hidden" class="apexnb-hide-mobile" value="<?php echo $disable_mobile_bar;?>"/>

<input type="hidden" class='enable_logo_image' value="<?php echo $enable_logo_image;?>"/>
<input type="hidden" class='edn_social_optons' value="<?php echo $edn_social_optons;?>"/>
<input type="hidden" class='edn_right_optons' value="<?php echo $edn_right_optons;?>"/>
<input type="hidden" class='enable_open_panel' value="<?php echo $enable;?>"/>
<?php if( $checkcomponents == 0){?>
  <div class="edn-container <?php echo 'apexnb-bartype'.$effect_id;?>">

<?php if($edn_bar_data['edn_bar_type']==1){ // custom template
$enable_bg_image = (isset($edn_bar_data['edn_background_image']['enable_bgimage']) && $edn_bar_data['edn_background_image']['enable_bgimage'] == true)?1:0;
if($enable_bg_image ==1){
$bg_image = (isset($edn_bar_data['edn_background_image']['bgimage_url']) && $edn_bar_data['edn_background_image']['bgimage_url'] != '')?esc_url_raw($edn_bar_data['edn_background_image']['bgimage_url']):'';
$bgcustomenable = "apexnb-custom-show-bg";
}else{
$bgcustomenable = "";
$bg_image = '';
  }  ?>


<div class="edn-temp-design-wrapper edn-custom-design-wrapper <?php echo $bgcustomenable;?>" <?php if($enable_bg_image == 1){ echo 'style="background-image: url('.$bg_image.')"'; } ?>>

<?php if(isset($edn_bar_data['edn_logo_section']['enable_logo']) && $edn_bar_data['edn_logo_section']['enable_logo'] == true){
  ?>
  <!-- Logo Section-->
  <?php if(isset($edn_bar_data['edn_logo_section']['image_url']) && $edn_bar_data['edn_logo_section']['image_url'] != '' ){
  $image_url = (isset($edn_bar_data['edn_logo_section']['image_url']) && $edn_bar_data['edn_logo_section']['image_url'] != '')?esc_url($edn_bar_data['edn_logo_section']['image_url']):'';
  $target_url = (isset($edn_bar_data['edn_logo_section']['url_link']) && $edn_bar_data['edn_logo_section']['url_link'] != '')?esc_url($edn_bar_data['edn_logo_section']['url_link']):'#';
  $target_link = (isset($edn_bar_data['edn_logo_section']['link_target']) && $edn_bar_data['edn_logo_section']['link_target'] != '')?esc_attr($edn_bar_data['edn_logo_section']['link_target']):'_self';
   $img_width = (isset($edn_bar_data['edn_logo_section']['image_width']) && $edn_bar_data['edn_logo_section']['image_width'] != '')?esc_attr($edn_bar_data['edn_logo_section']['image_width']):'200';
  $img_height = (isset($edn_bar_data['edn_logo_section']['image_height']) && $edn_bar_data['edn_logo_section']['image_height'] != '')?esc_attr($edn_bar_data['edn_logo_section']['image_height']):'140';
?>
  <div class="apexnb-logo-wrapper">
         <div class="logo-image-wrap" style="width:<?php echo $img_width;?>px;height:<?php echo $img_height;?>px;"> 
          <a href="<?php echo $target_url;?>" target="<?php echo $target_link;?>"><img src="<?php echo $image_url;?>" /></a>
        </div> 
  </div>
<?php } ?>
<!-- Logo Section end-->
<?php  }?>
 
<?php if(isset($edn_bar_data['edn_social_optons']) && isset($edn_bar_data['edn_right_optons'] ) 
&& $edn_bar_data['edn_social_optons']==1 && $edn_bar_data['edn_right_optons'] ==1){?>
<div class="endpro_main_leftright_wrapper <?php echo $effect_id2;?>_leftright_wrapper">
<?php } ?>

<?php if($edn_bar_data['edn_social_optons'] != ''){ ?>
  <div class="<?php if(isset($edn_bar_data['edn_right_optons'] ) && $edn_bar_data['edn_right_optons'] == '') echo 'edn_middle_content'; else echo 'edn-left-section-wrap ednpro_left_section'; ?>">
   <?php
    if($edn_bar_data['edn_social_optons']==1){ ?>
                <div class="edn-social-wrap">
                    <?php if(isset($edn_bar_data['edn_social_heading_text']) && !empty($edn_bar_data['edn_social_heading_text'])){?>
                        <div class="edn-social-heading-title"><?php echo esc_attr($edn_bar_data['edn_social_heading_text']);?></div>
                    <?php }?>
                    <div class="ednpro_bar_icons">
                    <?php
                        if(isset($edn_bar_data['icon_details']) && $edn_bar_data['icon_details']){
                            foreach($edn_bar_data['icon_details'] as $icon_list){
                                 $array_name = explode('-',esc_attr($icon_list['font_icon']));
                                 $social_class = ($array_name[1]);
                                // $array_name = explode('-',esc_attr($icon_list['font_icon']));
                                // $social_class = ($array_name[1]);
                                         // $array_name = explode(' ',esc_attr($icon_list['title']));
                                         //    $class = implode('-',$array_name);
                                         //    $social_class = strtolower($class);
                                ?>
                                    <div class="edn-social-icon-buttons edn-<?php echo $social_class;?>-button" style="<?php ?>">
                                        <a href="<?php echo esc_attr($icon_list['link']);?>" target="_blank" class="edn-social-icons-bg edn-aclass-<?php echo $social_class;?>">
                                            <i class="<?php echo esc_attr($icon_list['font_icon']);?> edn-iclass-<?php echo $social_class;?>"></i>
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

<?php if(isset($edn_bar_data['edn_right_optons'] ) && $edn_bar_data['edn_right_optons'] != ''){?>
   <div class="<?php if($edn_bar_data['edn_social_optons']=='') echo 'edn_middle_content'; else echo 'edn-right-section-wrap ednpro_right_section'; ?> <?php echo $effect_id;?>_pattern">
     <?php 
     
     if($edn_bar_data['edn_cp_type']=='text'){
          if(isset($edn_bar_data['edn_text_display_mode'])&& $edn_bar_data['edn_text_display_mode']=='static'){
             $edn_text_content_class = 'edn-text-content-wrap';
          }else{
             $edn_text_content_class = 'edn-multiple-content-wrap';
           }
       ?>
       <div class="<?php echo $edn_text_content_class;?>">
         <?php  if($edn_bar_data['edn_text_display_mode']=='static'){ ?>
           <div class="edn_static_text">
            <?php echo '<div class="edn-text-link">'.$edn_bar_data['edn_static']['text'].'</div>';
            if(isset($edn_bar_data['edn_static']['call-to-action']) && $edn_bar_data['edn_static']['call-to-action']==1){
                        ?>
           <span class="edn-call-action-button">
              <?php 
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
 
                    <span class="edn-ca-custom">
                    <a class="edn-static-button" href="<?php echo $url;?>" <?php echo $target;?>>
                    <span class="edn-ca-static-button"><?php echo esc_attr($but_text);?></span>
                    </a>
                    </span>
                    <?php  
                     }else if(isset($edn_bar_data['edn_static']['call_action_button']) && $edn_bar_data['edn_static']['call_action_button']=='contact'){ ?>
                    <span class="edn-ca-contact-form">
                        <?php
                        if(isset($edn_bar_data['edn_static']['contact_btn_text'])){
                            ?>
                                <a href="javascript:void(0);">
                                    <span class="edn-contact-form-button" data-id="edn-static-cf-btn-<?php echo $nb_id;?>"><?php if($edn_bar_data['edn_static']['contact_btn_text']){echo esc_attr($edn_bar_data['edn_static']['contact_btn_text']);}else{_e('Contact Us',APEXNB_TD);}?></span>
                                </a>
                            <?php
                        }
                        ?>
                       </span>
                    

                    <?php }else{ //shortcode  

                     $popuptxt = ((isset($edn_bar_data['edn_static']['popup_text']) && $edn_bar_data['edn_static']['popup_text'] != '')?$edn_bar_data['edn_static']['popup_text']:'CUSTOM BUTTON');
                         ?>
                             
                       <span class="edn-ca-contact-form">
                                <a href="javascript:void(0);">
                                    <span class="edn-contact-form-button" data-id="edn-static-cf-btn-<?php echo $nb_id;?>">
                                    <?php echo esc_attr( $popuptxt);?></span>
                                </a>
                          
                       </span>
                  <!-- edn of edn-ca-contact-form -->
                    <?php
                    }
                    ?>
        </span>
       
        <?php
        }
       //check call to action button if exist end  ?>
      </div>
        <?php
        }else{
        ?>
<?php if(isset($edn_bar_data['edn_bar_effect_option']) && $edn_bar_data['edn_bar_effect_option']==1){;?>
  <div class="edn-ticker-wrapper"><?php }?>
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
            } ?>
                  <?php if(isset($linktext) && $linktext != ''){?> 
                     <span class="edn-temp1-ca-custom">
                        <a class="edn-temp1-static-button edn-multiple-button edn-temp1-multiple-btn-<?php echo $i;?> edn-custom-contact-link" href="<?php echo esc_attr($link_url);?>" <?php echo $target;?>>
                            <span class="edn-temp1-ca-static-button edn-temp1-ca-multiple-button edn-temp1-ca-multiple-btn-<?php echo $i;?>"><?php echo esc_attr($linktext);?></span>
                        </a>
                    </span>
                      <?php } ?>
             <?php }else if(isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$i]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$i]=='shortcode-popup'){?>

             <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp1-contact-button edn-contact-form-button edn-multiple-cf-btn"
                     data-id="edn-multiple-cf-btn_<?php echo $i;?>">
                     <?php 
                     if(isset($edn_bar_data['edn_multiple']['popup_textpopup_text'][$i]) && $edn_bar_data['edn_multiple']['popup_text'][$i] != ''){
                          echo esc_attr($edn_bar_data['edn_multiple']['popup_text'][$i]); }
                      else{
                        _e('SHORTCODE',APEXNB_TD);
                        }
                     ?>
                     </span>
                </a>

                </span><!-- edn of edn-ca-contact-form -->


            <?php }else{ ?>
            <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp1-contact-button edn-contact-form-button edn-multiple-cf-btn"
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

                  } ?>
             
                     <span class="edn-temp1-ca-custom">
                        <a class="edn-temp1-static-button edn-multiple-button edn-temp1-multiple-btn-<?php echo $i;?> edn-custom-contact-link" href="<?php echo esc_attr($link_url);?>" <?php echo $target;?>>
                            <span class="edn-temp1-ca-static-button edn-temp1-ca-multiple-button edn-temp1-ca-multiple-btn-<?php echo $i;?>"><?php echo esc_attr($linktext);?></span>
                        </a>
                    </span>

             <?php }else if(isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$i]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$i]=='shortcode-popup'){?>

             <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp1-contact-button edn-contact-form-button edn-multiple-cf-btn"
                     data-id="edn-multiple-cf-btn_<?php echo $i;?>">
                     <?php 
                     if(isset($edn_bar_data['edn_multiple']['popup_textpopup_text'][$i]) && $edn_bar_data['edn_multiple']['popup_text'][$i] != ''){
                          echo esc_attr($edn_bar_data['edn_multiple']['popup_text'][$i]); }
                      else{
                        _e('SHORTCODE TEXT',APEXNB_TD);
                        }
                     ?>
                     </span>
                </a>

                </span><!-- edn of edn-ca-contact-form -->


            <?php }else{ ?>
            <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp1-contact-button edn-contact-form-button edn-multiple-cf-btn" data-id="edn-multiple-cf-btn_<?php echo $i;?>">
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


             <?php }  }?>
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

                  }  ?>
              <div class="edn-mulitple-text-content">
             <?php echo $edn_bar_data['edn_multiple']['text_content'][$i];?>
             </div>
              <a href="<?php echo $link_url; ?>" <?php echo $target;?> class="edn-custom-contact-link">
                <span class="edn-temp1-ca-custom"><?php echo $linktext;?></span>
             </a>

       <?php  
         }else if(isset($edn_bar_data['edn_multiple']['call_to_acction_type'][$i]) && $edn_bar_data['edn_multiple']['call_to_acction_type'][$i]=='shortcode-popup'){?>
             <div class="edn-mulitple-text-content">
               <?php echo $edn_bar_data['edn_multiple']['text_content'][$i];?>
             </div>
             <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp1-contact-button edn-contact-form-button edn-multiple-cf-btn"
                     data-id="edn-multiple-cf-btn_<?php echo $i;?>">
                     <?php 
                     if(isset($edn_bar_data['edn_multiple']['popup_textpopup_text'][$i]) && $edn_bar_data['edn_multiple']['popup_text'][$i] != ''){
                          echo esc_attr($edn_bar_data['edn_multiple']['popup_text'][$i]); }
                      else{
                        _e('SHORTCODE TEXT',APEXNB_TD);
                        }
                     ?>
                     </span>
                </a>

                </span><!-- edn of edn-ca-contact-form -->


            <?php }else{ ?>
         
             <div class="edn-mulitple-text-content">
             <?php echo $edn_bar_data['edn_multiple']['text_content'][$i];?>
             </div>
                <span class="edn-ca-contact-form">
                <a href="javascript:void(0);" class="edn-custom-contact-link">
                    <span class="edn-temp1-contact-button edn-contact-form-button edn-multiple-cf-btn"
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
<?php if(isset($edn_bar_data['edn_bar_effect_option']) && $edn_bar_data['edn_bar_effect_option']==1){;?>
</div><?php }?>
<?php
}
?>
</div>
<?php
    }else if($edn_bar_data['edn_cp_type']=='email-subs'){
        
        ?>
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
                                <h3>
                                <?php
                                   $head_txt = ((isset($edn_bar_data['edn_subs_custom']['head_text']) && $edn_bar_data['edn_subs_custom']['head_text'] != '')?$edn_bar_data['edn_subs_custom']['head_text']:'SUBSCRIBE NEWSLETTER');
                                    echo esc_attr($head_txt);
                                   ?>
                                 
                                 <?php if(isset($edn_bar_data['edn_subs_custom']['description'])){ ?>
                                   <span>
                                   <?php echo esc_attr($edn_bar_data['edn_subs_custom']['description']);?>
                                   </span>
                                   <?php } ?>
                                    </h3>
                                  </div>
                                   <div class="edn-left-subscribe-content">
                                         <input type="email" name="edn_email" placeholder="<?php if(isset($edn_bar_data['edn_subs_custom']['but_email_placeholder']) && $edn_bar_data['edn_subs_custom']['but_email_placeholder'] !=''){ 
                                          echo esc_attr($edn_bar_data['edn_subs_custom']['but_email_placeholder']); 
                                      }else{  _e('Email Address', APEXNB_TD); }?>" class="edn_subs_email_r" />
                                                  <input type="hidden" class="edn-subs-email-confirm" value="<?php if(isset($edn_bar_data['edn_subs_custom']['confirm'])){echo esc_attr($edn_bar_data['edn_subs_custom']['confirm']);}?>" />
                                                  <input type="hidden" class="edn-page-id" value="<?php the_ID();?>" />
                                                 
                                                   <input type="hidden" class="edn-success-note" value="<?php if(isset($edn_bar_data['edn_subs_custom']['thank_text'])){echo esc_attr($edn_bar_data['edn_subs_custom']['thank_text']);}?>" />
                                                  <input type="hidden" class="edn-subs-email-error-msg" value="<?php if(isset($edn_bar_data['edn_subs_custom']['but_email_error_message'])){echo esc_attr($edn_bar_data['edn_subs_custom']['but_email_error_message']);}?>" />
                                                  <input type="hidden" class="edn-subs-already-subscribed" value="<?php if(isset($edn_bar_data['edn_subs_custom']['but_already_subs'])){echo esc_attr($edn_bar_data['edn_subs_custom']['but_already_subs']);}?>" />
                                                  <input type="hidden" class="edn-subs-sending-fail" value="<?php if(isset($edn_bar_data['edn_subs_custom']['but_sending_fail'])){echo esc_attr($edn_bar_data['edn_subs_custom']['but_sending_fail']);}?>" />
                                                  <input type="hidden" class="edn-subs-checktoconfirmmsg" value="<?php if(isset($edn_bar_data['edn_subs_custom']['but_check_to_conform'])){echo esc_attr($edn_bar_data['edn_subs_custom']['but_check_to_conform']);}?>" />
                                                  <input type="hidden" class="apexnb-bar-id" value="<?php echo $nb_id;?>" />

                                          
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
                            </div>
                        <?php
                    }else if($edn_bar_data['edn_subs_choose']=='mailchip'){
                        ?>
                            <div class="edn-mailchimp-wrap">
                                <div class="edn-front-title">
                                 <div class="show_icon">
                              <i class="fa fa-envelope-o" aria-hidden="true"></i>
                             </div>
                                <h3><?php  $head_txt1 = ((isset($edn_bar_data['edn_mailchimp']['head_text']) && $edn_bar_data['edn_mailchimp']['head_text'] != '')?$edn_bar_data['edn_mailchimp']['head_text']:'SUBSCRIBE NEWSLETTER');
                                             echo esc_attr($head_txt1);?>
                                   <?php if(isset($edn_bar_data['edn_mailchimp']['description'])){?>
                                   <span><?php echo esc_attr($edn_bar_data['edn_mailchimp']['description']);?></span>
                                   <?php } ?></h3>
                                  </div>
                                <div class="edn-form-field">
                                 <div class="edn-left-subscribe-content">
                                    <input type="email" name="edn_mailchimp_email" class="edn-mailchimp-email" placeholder="<?php echo esc_attr($edn_bar_data['edn_mailchimp']['email_label']);?>" value=""/>
                                    <input type="hidden" class="edn-mailchimp-email-confirm" value="<?php if(isset($edn_bar_data['edn_mailchimp']['confirm'])){echo esc_attr($edn_bar_data['edn_mailchimp']['confirm']);}?>" />
                                    <input type="hidden" class="edn-mc-success-note" value="<?php if(isset($edn_bar_data['edn_mailchimp']['thank_text'])){echo esc_attr($edn_bar_data['edn_mailchimp']['thank_text']);}?>" />  
                                    <input type="hidden" class="edn-mc-email-err" value="<?php if(isset($edn_bar_data['edn_mailchimp']['mailchimp_email_err'])){echo esc_attr($edn_bar_data['edn_mailchimp']['mailchimp_email_err']);}?>" />
                                    <input type="hidden" class="edn-mc-sending-fail" value="<?php if(isset($edn_bar_data['edn_mailchimp']['mailchimp_sending_fail'])){echo esc_attr($edn_bar_data['edn_mailchimp']['mailchimp_sending_fail']);}?>" />
                                    <input type="hidden" class="edn-mc-check-to-conform" value="<?php if(isset($edn_bar_data['edn_mailchimp']['mailchimp_check_to_conform']) && isset($edn_bar_data['edn_mailchimp']['mailchimp_confirm']) && $edn_bar_data['edn_mailchimp']['mailchimp_confirm'] != ''){echo esc_attr($edn_bar_data['edn_mailchimp']['mailchimp_confirm']);}?>" />
                                    <input type="hidden" class="apexnbbarid" value="<?php echo $nb_id;?>" />
                                    <input type="hidden" class="edn-api-key" value="<?php if(isset($edn_bar_data['edn_mailchimp']['api_key'])){echo esc_attr($edn_bar_data['edn_mailchimp']['api_key']);}?>" />
                                    <?php
                                        if(isset($edn_bar_data['edn_mailchimp']['lists']) && $edn_bar_data['edn_mailchimp']['lists']){
                                            $mailchimp_list = implode(",",$edn_bar_data['edn_mailchimp']['lists']);
                                        }
                                    ?>
                                    <input type="hidden" class="edn-mailchimp-list" value="<?php if(isset($edn_bar_data['edn_mailchimp']['lists']) && $edn_bar_data['edn_mailchimp']['lists']){echo $mailchimp_list;}?>" />
                                    <input type="hidden" class="edn-page-id" value="<?php the_ID();?>" />
                                     <button type="button" id="edn_mailchimp_submit_ajax-<?php echo $nb_id;?>" class="edn_mailchimp_submit_ajax"><?php if(isset($edn_bar_data['edn_mailchimp']['botton_text']) && $edn_bar_data['edn_mailchimp']['botton_text'] !=''){echo esc_attr($edn_bar_data['edn_mailchimp']['botton_text']);}else(_e('Go',APEXNB_TD))?></button>
                                    <div class="loader_view">
                                         <img src="<?php echo APEXNB_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-ajax-loader"/>
                                    </div>
                                      <div class="edn-error">
                                          <?php
                                              if(isset($_SESSION['edn-mailchimp-sms'])){echo $_SESSION['edn-mailchimp-sms'];
                                              unset($_SESSION['edn-mailchimp-sms']);}
                                          ?>
                                      </div>
                                     <div class="edn-subs-success edn-success"></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }else{ ?>
                      <div class="edn-constant-contact-wrap">
                                <div class="edn-front-title">
                                  <h3><?php $head_txt3 = ((isset($edn_bar_data['edn_constant_contact']['title_text']) && $edn_bar_data['edn_constant_contact']['title_text'] != '')?$edn_bar_data['edn_constant_contact']['title_text']:'JOIN OUR MAIL NOW');
                                             echo esc_attr($head_txt3);?>
                                      <?php if(isset($edn_bar_data['edn_constant_contact']['description_label'])){ ?>
                                       <span><?php 
                                        echo esc_attr($edn_bar_data['edn_constant_contact']['description_label']);?></span>
                                        <?php } ?>
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
                                          <input type="hidden" class="edn-constantcontact-email-fn" value="<?php if(isset($edn_bar_data['edn_constant_contact']['from_name'])){
                                          echo esc_attr($edn_bar_data['edn_constant_contact']['from_name']);}?>"/>  
                                          <input type="hidden" class="edn-constantcontact-email-fe" value="<?php if(isset($edn_bar_data['edn_constant_contact']['from_email'])){
                                          echo esc_attr($edn_bar_data['edn_constant_contact']['from_email']);}?>"/>   
          <div class="edn_constant_message" data-send-fail="<?php if(isset($edn_bar_data['edn_constant_contact']['constant_sending_fail']) && $edn_bar_data['edn_constant_contact']['constant_sending_fail'] !=''){
              echo esc_attr($edn_bar_data['edn_constant_contact']['constant_sending_fail']);}else{ _e('Sending fail.',APEXNB_TD); }?>" 
              data-email-error="<?php if(isset($edn_bar_data['edn_constant_contact']['constant_email_error']) && $edn_bar_data['edn_constant_contact']['constant_email_error'] !=''){
              echo esc_attr($edn_bar_data['edn_constant_contact']['constant_email_error']);}else{ _e('Please Enter Your valid Email Address!!',APEXNB_TD); }?>"
               data-name-error="<?php if(isset($edn_bar_data['edn_constant_contact']['constant_name_error']) && $edn_bar_data['edn_constant_contact']['constant_name_error'] !=''){
              echo esc_attr($edn_bar_data['edn_constant_contact']['constant_name_error']);}else{ _e('Please Enter Your Firstname!!',APEXNB_TD); }?>" style="display:none;"></div>  

                                <?php #echo "<pre>"; print_r($edn_bar_data['edn_constant_contact']['lists']);
                                   if(isset($edn_bar_data['edn_constant_contact']['lists'])){                 
                                         $edn_lsits = $edn_bar_data['edn_constant_contact']['lists'];
                                                    $i=1; foreach ($edn_lsits as $list_id) { 
                                                       $listid = $list_id;?>
                                   <input type="hidden" name="edn_grp" id="edn_grp_<?php echo $i;?>" value="<?php echo $listid ;?>" />
                                   <?php $i++; } } 
                                ?>
                                
                                                               
                                <?php if(isset($edn_bar_data['edn_constant_contact']['button_text'])){
                                 $btn_txt = $edn_bar_data['edn_constant_contact']['button_text'];
                                 }else{
                                $btn_txt = 'Subsribe';
                                } ?>
                                  <button type="submit" id="constant_subscribe_<?php echo $nb_id;?>" class="constant_subscribe"><?php _e($btn_txt,APEXNB_TD);?></button>
                                     <div class="loader_view">
                                     <img src="<?php echo APEXNB_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-constant-ajax-loader"/>
                                     </div>
                                <div class="edn-constant-error"></div>
                                <div class="edn-constant-success"></div>

                                </div>
                            </div>

                            </div>
                  

                    <?php }
                ?>
            </div>
        <?php
    }else if($edn_bar_data['edn_cp_type']=='twiter-tweets' && $consumer_key != ''){
        ?>
            <div class="edn-twitter-feed-wrap">
                <?php if(isset($edn_bar_data['edn_bar_effect_option']) && $edn_bar_data['edn_bar_effect_option']==1){;?><div class="edn-ticker-wrapper"><?php }?>
                   
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
                      foreach ($tweet as $tw){
                      if(isset($tw->message) && $tw->message != ''){
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
                                //$this->edn_pro_print_array($tweet);
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
                <?php if(isset($edn_bar_data['edn_bar_effect_option']) && $edn_bar_data['edn_bar_effect_option']==1){;?></div><?php }?>
            </div>
        <?php  
        }else if($edn_bar_data['edn_cp_type']=='post-title'){ 
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
                                      <li <?php echo ($effect_id == "slider")?'class="clearfix"':'';?>><?php echo $recent["post_title"];?>
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
                <?php if(isset($edn_bar_data['edn_bar_effect_option']) && $edn_bar_data['edn_bar_effect_option']==1){;?><div class="edn-ticker-wrapper"><?php }?>
                    <ul class="edn-post-title" id="edn-post-effect-<?php echo $effect_id;?>-<?php echo $nb_id;?>" data-barid="<?php echo $nb_id;?>">
                        <?php
                            foreach($edn_bar_data['edn_display'] as $post_title){
                                // $title_array = explode('*-*',$post_title);
                                // $title = $title_array[0];
                                // $title_id = $title_array[1];
                              $title_id = $post_title;
                              $title = get_the_title($post_title);
                                
                                ?>
                                    <li <?php echo ($effect_id == "slider")?'class="clearfix"':'';?>><?php echo $title;?><a class="edn-post-title-readmore" href="<?php echo get_permalink($title_id);?>"><?php _e('Read more',APEXNB_TD);?></a></li>
                                <?php
                            }
                        ?>
                    </ul>
                <?php if(isset($edn_bar_data['edn_bar_effect_option']) && $edn_bar_data['edn_bar_effect_option']==1){;?></div><?php }?>
            </div>
      
       <?php } 
        }
else if($edn_bar_data['edn_cp_type']=='rss-feed'){ 
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
            
            $bgcolor = (isset($edn_bar_data['edn_countdowntimer']['bgcolor']) && $edn_bar_data['edn_countdowntimer']['bgcolor'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['bgcolor']):'';
            $bgoutercolor = (isset($edn_bar_data['edn_countdowntimer']['bgoutercolor']) && $edn_bar_data['edn_countdowntimer']['bgoutercolor'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['bgoutercolor']):'';

            $fontcolor = (isset($edn_bar_data['edn_countdowntimer']['fontcolor']) && $edn_bar_data['edn_countdowntimer']['fontcolor'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['fontcolor']):'';
           
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
                  $time_number = date('H', $timestamp);
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
    <?php if($layouttype == "layout1"){ 
                 /* $tomorrow = date("m/d/Y", strtotime("+1 day"));
                  $enable_check2 = 1;
                  $expirydate = '04/17/2019 23:59:59';
                  if($enable_check2 == 1){
                    $today_date = strtotime("+1 day");
                    $expirydate2 = strtotime($expirydate);
                    $expirydate2 = date('m/d/Y', $expirydate2);
                    $exrydate = strtotime($expirydate2);
                    if($today_date >= $exrydate){
                      $expirydate =  $expirydate;
                    }
                    else{
                      $time = date("H:i:s",strtotime($expirydate));
                      $expirydate = $tomorrow.' '.$time;
                    }
                  }*/
                ?>
              <div class="ApexDateCountdown" data-date="<?php echo $expirydate; ?>" style="width: 360px; height: 90px;padding: 0px; box-sizing: border-box;" 
              data-background-color="<?php echo $bgcolor;?>" data-background-outercolor="<?php echo $bgoutercolor;?>" data-template="custom"></div>
    <?php }else{ ?>      
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
  <?php
$layout_type = (isset($edn_bar_data['edn_video']['layout_type']) && $edn_bar_data['edn_video']['layout_type'] != '')?esc_attr($edn_bar_data['edn_video']['layout_type']):'layout1';
 $fonticons = (isset($edn_bar_data['edn_video']['font-icon']) && $edn_bar_data['edn_video']['font-icon'] != '')?esc_attr($edn_bar_data['edn_video']['font-icon']):'';
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

          <div class="apexnb-video-view-btn custom-popup-vbtn">
               <a class="apexnb-video-btn apexnb-video-btn-<?php echo $random_num;?>" href="<?php echo $visit_url;?>" rel="prettyPhoto" title="<?php echo $title_name;?>" data-speed="<?php echo  $popup_animation_speed;?>"
              data-autoplay="<?php echo  $video_autoplay;?>" data-showtitle="<?php echo  $show_title_on_popup;?>" data-popuptheme="<?php echo  $video_popup_theme;?>"
              data-width="<?php echo  $video_popup_width;?>" data-height="<?php echo  $video_popup_height;?>">
                 <?php echo $button_title;?>
              </a>
          </div>
      <?php 
   }else if($video_type == "vimeo"){
      $urlParts = explode("/", parse_url($vimeo_url, PHP_URL_PATH));
      $visit_url = (int)$urlParts[count($urlParts)-1];  ?>
       <div class="apexnb-video-view-btn custom-popup-vbtn">
          <a class="apexnb-video-btn apexnb-video-btn-<?php echo $random_num;?>" href="https://vimeo.com/<?php echo esc_attr($visit_url); ?>" rel="prettyPhoto" title="<?php echo $title_name;?>" data-speed="<?php echo  $popup_animation_speed;?>"
          data-autoplay="<?php echo  $video_autoplay;?>" data-showtitle="<?php echo  $show_title_on_popup;?>" data-popuptheme="<?php echo  $video_popup_theme;?>"
          data-width="<?php echo  $video_popup_width;?>" data-height="<?php echo  $video_popup_height;?>">
             <?php echo $button_title;?>
          </a>
       </div>
      <?php 
   }else{?>
       <div class="apexnb-video-view-btn custom-popup-vbtn">
             <a class="apexnb-video-btn apexnb-video-btn-<?php echo $random_num;?>" href="#apex-inline-<?php echo $random_num;?>" rel="prettyPhoto" title="<?php echo $title_name;?>" data-speed="<?php echo  $popup_animation_speed;?>"
              data-autoplay="<?php echo $video_autoplay;?>" data-showtitle="<?php echo  $show_title_on_popup;?>" data-popuptheme="<?php echo  $video_popup_theme;?>"
              data-width="<?php echo  $video_popup_width;?>" data-height="<?php echo  $video_popup_height;?>"><?php echo $button_title;?></a>
       </div>
                <div id="apex-inline-<?php echo $random_num;?>" class="hide" style="display:none;">
                <video style="width:<?php echo $video_popup_width;?>px;height:<?php echo $video_popup_height;?>px;" class="apexnb-html5-video-wrapper" <?php if( $video_autoplay == "true") echo "autoplay";?> loop controls>
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
<?php }
else if($edn_bar_data['edn_cp_type']=='search-form'){
 $btnname = __('Search',APEXNB_TD);
 $search_layout_type = ((isset($edn_bar_data['edn_search_form']['layout_type']) && $edn_bar_data['edn_search_form']['layout_type'] != '')?$edn_bar_data['edn_search_form']['layout_type']:'layout1');
 $description = ((isset($edn_bar_data['edn_search_form']['description']) && $edn_bar_data['edn_search_form']['description'] != '')?$edn_bar_data['edn_search_form']['description']:'');
 $input_placeholder = ((isset($edn_bar_data['edn_search_form']['input_placeholder']) && $edn_bar_data['edn_search_form']['input_placeholder'] != '')?$edn_bar_data['edn_search_form']['input_placeholder']:'');
 $hide_button_text = (isset($edn_bar_data['edn_search_form']['hide_button_text']) && $edn_bar_data['edn_search_form']['hide_button_text'] == 1)?1:0;
 $hide_icon = (isset($edn_bar_data['edn_search_form']['hide_icon']) && $edn_bar_data['edn_search_form']['hide_icon'] == 1)?1:0;
 $button_name = ((isset($edn_bar_data['edn_search_form']['button_name']) && $edn_bar_data['edn_search_form']['button_name'] != '')?$edn_bar_data['edn_search_form']['button_name']:'');
 $font_icon = ((isset($edn_bar_data['edn_search_form']['font_icon']) && $edn_bar_data['edn_search_form']['font_icon'] != '')?$edn_bar_data['edn_search_form']['font_icon']:'');
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
<?php }
else{ 
  //custom html section ?>
<div class="edn_custom_html_wrapper">
<?php 
 $content = ((isset($edn_bar_data['edn_custom_html']['content']) && $edn_bar_data['edn_custom_html']['content'] != '')?$edn_bar_data['edn_custom_html']['content']:'');
echo do_shortcode( $content);
 ?>
</div>
<?php }

?>
  </div><!-- edn of right-section-wrap -->

<?php if(isset($edn_bar_data['edn_social_optons']) && isset($edn_bar_data['edn_right_optons'] ) 
&& $edn_bar_data['edn_social_optons']==1 && $edn_bar_data['edn_right_optons'] ==1){?>
</div>
<?php } ?>


<?php } ?>
</div><!-- Custom Design End -->


<?php }else{
            $template = $edn_bar_data['edn_bar_template'];
            if(!empty($template)){
                include('includes/templates/template-'.$template.'.php');
            }     
} ?>


<?php
$template_type = $edn_bar_data['edn_bar_type'];

if($template_type == '1'){
   $template1 = '';
   $template_class = "custom_template";
}else{
    $template1 = $edn_bar_data['edn_bar_template'];
    $template_class = "pre_template_".$template1;
   }?>
</div>

<?php 
if((isset($edn_bar_data['edn_social_optons']) && $edn_bar_data['edn_social_optons'] == 1) || isset($edn_bar_data['edn_right_optons'] ) && $edn_bar_data['edn_right_optons'] == 1){
  $style  = '';
}else{
  $style  = 'style="display:none"';
}
?>
 <!---------- Notification Controls ---------->
    <?php if($edn_data->edn_close_button == 'show-hide' || $edn_data->edn_close_button == 'user-can-close'){?>
    <div class="edn-cntrol-wrap edn-controls-<?php echo esc_attr($edn_data->edn_position);?> 
    ednpro_<?php echo $edn_data->edn_close_button;?> visibility_<?php echo esc_attr($edn_data->edn_visibility);?> <?php echo $template_class;?>" <?php echo $style;?>>
        <?php 
            if($edn_data->edn_close_button == 'show-hide'){
                if($edn_data->edn_position=='top' || $edn_data->edn_position=='top_absolute'){
                ?>  
                    <a href="javascript:void(0)" class="edn-controls edn-controls-dismiss">
                        <div class="edn-single-top-arrow">
                        <div class="edn-top-up-arrow toggle-arrow">
                        </div>
                          </div> 
                    </a>
                <?php
                }else if($edn_data->edn_position=='left'){ ?>
                   <a href="javascript:void(0)" class="edn-controls edn-controls-dismiss">
                       <div class="edn-single-left-arrow">
                            <div class="edn-left-arrow toggle-arrow"> </div>
                        </div> 
                         
                    </a>
                <?php }else if($edn_data->edn_position=='right'){ ?>
                   <a href="javascript:void(0)" class="edn-controls edn-controls-dismiss">
                        <div class="edn-single-right-arrow">
                        <div class="edn-right-arrow toggle-arrow">
                        </div>
                         </div>
                    </a>
             <?php   }

                else{
                    ?>
                        <a href="javascript:void(0)" class="edn-controls edn-controls-dismiss">
                            <div class="edn-single-bottom-arrow">
                            <div class="edn-bottom-down-arrow toggle-arrow">
                            </div>
                        
                        </div> 
                        </a>
                    <?php
                }
            }else{
                ?>
                    <a href="javascript:void(0)" class="edn-controls edn-controls-close">
                    <i class="fa fa-close"></i>
                     <!--  <div class="loader">
                       <img src="< ?php echo APEXNB_IMAGE_DIR . '/templates_ajaxloader/ajax-loader1.gif'; ?>" style="display: none" class="edn-ajax-loader"/>
                      </div> -->
                    </a>     
                <?php
            }
        ?>
    </div><!-- End of Notification Controls -->  
    <?php }?>
  <!-- close if no any components found-->
 <?php } ?>


<?php include('frontend-open-panel.php');?>
<input type="hidden" class="edn-ticker-option" id="apexnb-ticker-<?php echo $nb_id;?>"
    data-ticker-speed="<?php if(isset($edn_bar_data['edn_ticker']['speed'])){echo esc_attr($edn_bar_data['edn_ticker']['speed']);}?>"
    data-ticker-direction="<?php if(isset($edn_bar_data['edn_ticker']['direction'])){echo esc_attr($edn_bar_data['edn_ticker']['direction']);}?>"
    data-ticker-title="<?php if(isset($edn_bar_data['edn_ticker']['title_text'])){echo esc_attr($edn_bar_data['edn_ticker']['title_text']);}?>"
    data-ticker-hover="<?php if(isset($edn_bar_data['edn_ticker']['hover'])){echo esc_attr($edn_bar_data['edn_ticker']['hover']);}?>"
    data-slider-controls="<?php if(isset($edn_bar_data['edn_slider']['controls'])){echo esc_attr($edn_bar_data['edn_slider']['controls']);}?>"
    data-slider-animation="<?php if(isset($edn_bar_data['edn_slider']['animation'])){echo esc_attr($edn_bar_data['edn_slider']['animation']);}?>"
    data-slider-duration="<?php if(isset($edn_bar_data['edn_slider']['duration'])){echo esc_attr($edn_bar_data['edn_slider']['duration']);}?>"
    data-slider-auto="<?php if(isset($edn_bar_data['edn_slider']['auto'])){echo esc_attr($edn_bar_data['edn_slider']['auto']);}?>"
    data-slider-transition="<?php if(isset($edn_bar_data['edn_slider']['speed'])){echo esc_attr($edn_bar_data['edn_slider']['speed']);}?>"
    data-slider-adaptive-height="<?php if(isset($edn_bar_data['edn_slider']['adaptive_height'])){echo esc_attr($edn_bar_data['edn_slider']['adaptive_height']);}?>"
    data-scroll-controls="<?php if(isset($edn_bar_data['edn_scroll']['controls'])){echo esc_attr($edn_bar_data['edn_scroll']['controls']);}?>"
    data-scroll-direction="<?php if(isset($edn_bar_data['edn_scroll']['direction'])){echo esc_attr($edn_bar_data['edn_scroll']['direction']);}?>"
    data-scroll-animation="<?php if(isset($edn_bar_data['edn_scroll']['animation'])){echo esc_attr($edn_bar_data['edn_scroll']['animation']);}?>"
    data-scroll-speed="<?php if(isset($edn_bar_data['edn_scroll']['speed'])){echo esc_attr($edn_bar_data['edn_scroll']['speed']);}?>"
    data-scroll-title="<?php if(isset($edn_bar_data['edn_scroll']['title_text'])){echo esc_attr($edn_bar_data['edn_scroll']['title_text']);}?>"
/>
<input type="hidden" class="edn-visibility-bar-options edn-visibility-option-<?php echo $nb_id;?>" id="apexnb-<?php echo $nb_id;?>"
    data-show-time-duration="<?php if(isset($edn_data->edn_show_duration)){echo esc_attr($edn_data->edn_show_duration);}?>"
    data-hide-time-duration="<?php if(isset($edn_data->edn_hide_duration)){echo esc_attr($edn_data->edn_hide_duration);}?>"
    data-visibility-type = "<?php if(isset($edn_data->edn_visibility)){echo esc_attr($edn_data->edn_visibility);}?>"
    data-close-type = "<?php if(isset($edn_data->edn_close_button)){echo esc_attr($edn_data->edn_close_button);}?>"
    data-close-once = "<?php if(isset($edn_bar_data['show_once'])){echo esc_attr($edn_bar_data['show_once']);}?>"
    data-duration-close = "<?php if(isset($edn_bar_data['duration_show_once'])){echo esc_attr($edn_bar_data['duration_show_once']);}?>"  
    data-show_once_hideshow = "<?php if(isset($edn_bar_data['show_once_hideshow'])){echo esc_attr($edn_bar_data['show_once_hideshow']);}?>"
    data-show_once_loggedusers = "<?php echo $show_once_loggedusers;?>"
    data-check_loggedin = "<?php echo $loggedin;?>"
    data-check_userid = "<?php echo $user_id;?>"
    data-notification_bar_id = "<?php echo $nb_id;?>"
/>
<?php 
include('custom-contact-form.php');
include('multiple-custom-cform.php');
?>
</div><!-- end notify bar-->

</div><!-- end edn-close-section-->
</div><!-- end ednpro_main_wrapper-->
<?php } ?>