<?php defined('ABSPATH') or die("No script kiddies please!");
/*
 * Posted Data
 */
// $this->edn_pro_print_array($_POST);
$_POST = array_map('stripslashes_deep', $_POST);
foreach($_POST as $key=>$val)
{
    if($key=='icons' || $key=='edn_multiple' || $key=='edn_logo_section' || $key =='edn_background_image' || $key=='edn_static' || $key=='edn_subs_custom' || $key=='edn_constant' || $key=='edn_mailchimp' ||
    $key=='edn_contact_custom' || $key=='edn_twitter' || $key=='edn_recentposts'  ||  $key=='edn_rssfeed' ||  $key=='edn_countdowntimer'  ||  $key=='edn_video' || $key == 'edn_search_form' || $key=='edn_custom_html' || $key=='edn_display' || $key=='edn_ticker' || $key=='edn_slider' ||
    $key=='edn_date' || $key=='edn_multi' || $key=='edn_scroll' || $key == 'custom_css' || $key == 'custom_js' || $key == 'edn_open_panel')
    {
         $$key = $val;   
    }
    else
    {
        $$key = sanitize_text_field($val);              
    }

}

if(isset($icons)){
    foreach($icons as $key=>$val)
    {
        $icon_detail_array = array();
        foreach($val as $k=>$v)
        {
            if($k=='image' || $k=='link')
            {
                $icon_detail_array[$k] = esc_url($v);
            }
            else
            {
                $icon_detail_array[$k] = sanitize_text_field($v);
            }
        }
    $icons[$key] = $icon_detail_array;
    }
}else{
    $icons = array();
}

if(isset($edn_mailchimp)){
    foreach($edn_mailchimp as $key=>$val)
    {
        if($key=='lists')
        {
            foreach($val as $k=>$v)
            {
                $edn_mailchimp['lists'][$k] = sanitize_text_field($v);
            }
        }
        else
        {
            if($key=='markup')
            {
                $edn_mailchimp[$key] = $val;
            }
            else
            {
                if($key=='thank_text'){
                    $edn_mailchimp[$key] = $val;
                }else{
                    $edn_mailchimp[$key] = sanitize_text_field($val);
                }
            }        
        }
    }
}

if(isset($edn_constant)){
    foreach($edn_constant as $key=>$val)
    {
        if($key=='lists')
        {
            foreach($val as $k=>$v)
            {
                $edn_constant['lists'][$k] = sanitize_text_field($v);
            }
        }
        else
        {
            if($key=='markup')
            {
                $edn_constant[$key] = $val;
            }
            else
            {
                if($key=='success_text'){
                    $edn_constant[$key] = $val;
                }else{
                    $edn_constant[$key] = sanitize_text_field($val);
                }
            }        
        }
    }
}

if(isset($edn_date)){
    foreach($edn_date as $key=>$val)
    {
        $edn_date_array = array();
        $edn_date_array = sanitize_text_field($val);
        $edn_date[$key] = $edn_date_array;
    }
}else{
    $edn_date = array();
}

if(isset($edn_social_optons)){$edn_social_optons = $edn_social_optons;}else{$edn_social_optons = '';}
if(isset($edn_right_optons)){$edn_right_optons = $edn_right_optons;}else{$edn_right_optons = '';}

if(isset($edn_multiple)){$edn_multiple = $edn_multiple;}else{$edn_multiple = array();}
if(isset($edn_display)){$edn_display = $edn_display;}else{$edn_display = array();}
if(isset($edn_bar_effect_option)){$edn_bar_effect_option = $edn_bar_effect_option;}else{$edn_bar_effect_option = '';}
if(isset($edn_social_heading_text)){$edn_social_heading_text = $edn_social_heading_text;}else{$edn_social_heading_text = '';}
if(isset($edn_social_heading_color)){$edn_social_heading_color = $edn_social_heading_color;}else{$edn_social_heading_color = '';}
if(isset($edn_bar_template)){$edn_bar_template = $edn_bar_template;}else{$edn_bar_template = '';}
if(isset($edn_contact_choose)){$edn_contact_choose = $edn_contact_choose;}else{$edn_contact_choose = '';}
if(isset($edn_contact_custom)){$edn_contact_custom = $edn_contact_custom;}else{$edn_contact_custom = '';}
if(isset($edn_form_shortcode)){$edn_form_shortcode = $edn_form_shortcode;}else{$edn_form_shortcode = '';}
if(isset($icon_type)){$icon_type = $icon_type;}else{$icon_type = '';}

$edn_bar['edn_bar_type'] = $edn_bar_type;
$edn_bar['edn_social_optons'] = $edn_social_optons;
$edn_bar['edn_right_optons'] = $edn_right_optons;
if(isset($edn_cp_type) && $edn_cp_type == ''){
$right_component_type = '';
}else{
$right_component_type = $edn_cp_type;
}
$edn_bar['edn_cp_type'] = $right_component_type;
$edn_bar['edn_text_display_mode'] = $edn_text_display_mode;
$edn_bar['edn_multiple'] =  stripslashes_deep($edn_multiple);

$edn_logo_section  = array(
      'enable_logo'  => (isset($edn_logo_section['enable_logo']))?sanitize_text_field($edn_logo_section['enable_logo']):'',
      'image_url'    =>  (isset($edn_logo_section['image_url']))?sanitize_text_field($edn_logo_section['image_url']):'',
      'url_link'    => (isset($edn_logo_section['url_link']))?sanitize_text_field($edn_logo_section['url_link']):'',
      'link_target'    => (isset($edn_logo_section['link_target']))?sanitize_text_field($edn_logo_section['link_target']):'',
      'image_width'  => (isset($edn_logo_section['image_width']))?sanitize_text_field($edn_logo_section['image_width']):'',
      'image_height' => (isset($edn_logo_section['image_height']))?sanitize_text_field($edn_logo_section['image_height']):''
    );
$edn_bar['edn_logo_section'] =  $edn_logo_section;

$edn_background_image  = array(
      'enable_bgimage'  => (isset($edn_background_image['enable_bgimage']))?sanitize_text_field($edn_background_image['enable_bgimage']):'',
      'bgimage_url'    => (isset($edn_background_image['bgimage_url']))?sanitize_text_field($edn_background_image['bgimage_url']):'',
    );
$edn_bar['edn_background_image'] =  $edn_background_image;
$edn_bar['edn_static'] =  stripslashes_deep($edn_static);
$edn_bar['edn_subs_choose']   = $edn_subs_choose;
$noreply = "noreply@siteurl.com";
/* update data for custom form */
$confirmation_name = get_bloginfo('name');
$confirmation_name1 = sanitize_text_field($edn_subs_custom['from_name']);
$custom_confirmation_name = (isset($edn_subs_custom['from_name']) && $edn_subs_custom['from_name'] != '')?$confirmation_name1:$confirmation_name;

$confirmation_email = $noreply;
$confirmation_email1 = sanitize_text_field($edn_subs_custom['from_email']);
$custom_confirmation_email = (isset($edn_subs_custom['from_email']) && $edn_subs_custom['from_email'] != '')?$confirmation_email1:$confirmation_email;

$confirmation = 0;
$confirmation1 = (isset($edn_subs_custom['confirm']))?sanitize_text_field($edn_subs_custom['confirm']):'';
$custom_confirm = (isset($edn_subs_custom['confirm']) && $edn_subs_custom['confirm'] != '')?$confirmation1:$confirmation;

$email_subject1 = '';
$email_subject = (isset($edn_subs_custom['email_subject']))?sanitize_text_field($edn_subs_custom['email_subject']):'';
$custom_email_subject = (isset($edn_subs_custom['email_subject']) && $edn_subs_custom['email_subject'] != '')?$email_subject:$email_subject1;

$email_message1 = '';
$email_message = (isset($edn_subs_custom['message']))?wp_kses_post($edn_subs_custom['message']):'';
$custom_email_message = (isset($edn_subs_custom['message']) && $edn_subs_custom['message'] != '')?$email_message:$email_message1;

$edn_subs_custom = array(
            'head_text'                     => sanitize_text_field($edn_subs_custom['head_text']),
            'but_text'                      => sanitize_text_field($edn_subs_custom['but_text']),
            'description'                   => sanitize_text_field($edn_subs_custom['description']),
            'but_email_placeholder'         => sanitize_text_field($edn_subs_custom['but_email_placeholder']),
            'but_email_error_message'       => sanitize_text_field($edn_subs_custom['but_email_err']),
            'but_already_subs'              => sanitize_text_field($edn_subs_custom['but_already_subs']),
            'but_check_to_conform'          => sanitize_text_field($edn_subs_custom['but_check_to_conform']),
            'but_sending_fail'              => sanitize_text_field($edn_subs_custom['but_sending_fail']),
            'email_subject'                 => sanitize_text_field($edn_subs_custom['thank_text']),
            'confirm'                       => $custom_confirm,
            'thank_text'                    => ((isset($edn_subs_custom['thank_text']) && $edn_subs_custom['thank_text'] != '')?sanitize_text_field($edn_subs_custom['thank_text']):''),
            'from_name'                     => $custom_confirmation_name,
            'from_email'                    => $custom_confirmation_email,
            'email_subject'                 => $custom_email_subject,
            'message'                       => $custom_email_message
            );
$edn_bar['edn_subs_custom'] = $edn_subs_custom;
/* update data for custom form */
/* update data for mailchimp form */
$mailchimpname = get_bloginfo('name');
$mailchimpsavedname = (isset($edn_mailchimp['from_name']))?sanitize_text_field($edn_mailchimp['from_name']):''; 
$mailchimp_confirmation_name = (isset($edn_mailchimp['from_name']) && $edn_mailchimp['from_name'] != '')?$mailchimpsavedname:$mailchimpname;

$mailchimpemail = $noreply;
$mailchimpsavedemail = (isset($edn_mailchimp['from_email']))?sanitize_text_field($edn_mailchimp['from_email']):''; 

$mailchimp_confirmation_email = (isset($edn_mailchimp['from_email']) && $edn_mailchimp['from_email'] != '')?$mailchimpsavedemail:$mailchimpemail;

$mailchimp_confirm1 = '0';
$mailchimp_confirm2 = (isset($edn_mailchimp['confirm']))?sanitize_text_field($edn_mailchimp['confirm']):''; 
$mailchimp_confirm = (isset($edn_mailchimp['confirm']) && $edn_mailchimp['confirm'] != '')?$mailchimp_confirm2:$mailchimp_confirm1;

if(isset($edn_mailchimp['lists']) && !empty($edn_mailchimp['lists']) && is_array($edn_mailchimp['lists'])){
   $mailchimp_lists =  $edn_mailchimp['lists'];
}else{
    $mailchimp_lists = array();
}
$edn_mailchimp = array(
            'api_key'                     =>   sanitize_text_field($edn_mailchimp['api_key']),
            'head_text'                   =>   sanitize_text_field($edn_mailchimp['head_text']),
            'description'                 =>   sanitize_text_field($edn_mailchimp['description']),
            'lists'                       =>   $mailchimp_lists,
            'email_label'                 =>   sanitize_text_field($edn_mailchimp['email_label']),         
            'mailchimp_email_err'         =>   sanitize_text_field($edn_mailchimp['mailchimp_email_err']),
            'mailchimp_check_to_conform'  =>   sanitize_text_field($edn_mailchimp['mailchimp_check_to_conform']),
            'mailchimp_sending_fail'      =>   sanitize_text_field($edn_mailchimp['mailchimp_sending_fail']),
            'thank_text'                  =>   sanitize_text_field($edn_mailchimp['thank_text']),
            'botton_text'                 =>   sanitize_text_field($edn_mailchimp['botton_text']),
            'confirm'                     =>   $mailchimp_confirm,
            'from_name'                   =>   $mailchimp_confirmation_name,
            'from_email'                  =>   $mailchimp_confirmation_email
            );
$edn_bar['edn_mailchimp'] = $edn_mailchimp;
/* update data for mailchimp form */
/* update data for constant contact form */
if(isset($edn_constant['from_name']) && $edn_constant['from_name'] != ''){
   $cc_confirmation_name =  sanitize_text_field($edn_constant['from_name']);
}else{
    $cc_confirmation_name = get_bloginfo('name');
}

if(isset($edn_constant['from_email']) && $edn_constant['from_email'] != ''){
    $cc_confirmation_email =  sanitize_text_field($edn_constant['from_email']);
}else{
    $cc_confirmation_email = $noreply;
}
if(isset($edn_constant['confirm']) && $edn_constant['confirm'] != ''){
    $cc_confirm =  sanitize_text_field($edn_constant['confirm']);
}else{
    $cc_confirm = '0';
}
if(isset($edn_constant['lists']) && !empty($edn_constant['lists']) && is_array($edn_constant['lists'])){
   $cc_lists =  $edn_constant['lists'];
}else{
    $cc_lists = array();
}
$edn_constant = array(
            'lists'                  => $cc_lists,
            'title_text'             => sanitize_text_field($edn_constant['title_text']),
            'description_label'      => sanitize_text_field($edn_constant['description_label']),
            'name_placeholder'       => sanitize_text_field($edn_constant['name_placeholder']),
            'email_placeholder'      => sanitize_text_field($edn_constant['email_placeholder']),
            'button_text'            => sanitize_text_field($edn_constant['button_text']),
            'constant_sending_fail'  => sanitize_text_field($edn_constant['constant_sending_fail']),
            'constant_name_error'    => sanitize_text_field($edn_constant['constant_name_error']),
            'constant_email_error'   => sanitize_text_field($edn_constant['constant_email_error']),
            'success_text'           => sanitize_text_field($edn_constant['success_text']),
            'confirm'                => $cc_confirm,
            'from_name'              => $cc_confirmation_name,
            'from_email'             => $cc_confirmation_email
            );
$edn_bar['edn_constant_contact'] = $edn_constant;
/* update data for constant contact form */
$edn_video = array(
            'title'                       =>   sanitize_text_field($edn_video['title']),
            'description'                 =>   sanitize_text_field($edn_video['description']),
            'font-icon'                   =>   sanitize_text_field($edn_video['font-icon']),
            'layout_type'                 =>   sanitize_text_field($edn_video['layout_type']),
            'video_type'                  =>   sanitize_text_field($edn_video['video_type']),
            'video_url'                   =>   sanitize_text_field($edn_video['video_url']),
            'vimeo_url'                   =>   sanitize_text_field($edn_video['vimeo_url']),
            'upload_url'                  =>   sanitize_text_field($edn_video['upload_url']),
            'button_title'                =>   sanitize_text_field($edn_video['button_title']),
            'textcolor'                   =>   sanitize_text_field($edn_video['textcolor']),
            'desccolor'                   =>   sanitize_text_field($edn_video['desccolor']),
            'textsize'                    =>   sanitize_text_field($edn_video['textsize']),
            'descsize'                    =>   sanitize_text_field($edn_video['descsize']),
            'button_bg_color'             =>   sanitize_text_field($edn_video['button_bg_color']),
            'button_font_color'           =>   sanitize_text_field($edn_video['button_font_color']),        
            'button_hover_bg_color'           =>   sanitize_text_field($edn_video['button_hover_bg_color']),
            'button_hover_font_color'           =>   sanitize_text_field($edn_video['button_hover_font_color']),
            'button_font_size'            =>   sanitize_text_field($edn_video['button_font_size']),
            'popup_animation_speed'            =>   sanitize_text_field($edn_video['popup_animation_speed']),
            'video_autoplay'            =>   sanitize_text_field($edn_video['video_autoplay']),
            'show_title_on_popup'            =>   sanitize_text_field($edn_video['show_title_on_popup']),
            'video_popup_theme'            =>   sanitize_text_field($edn_video['video_popup_theme']),
            'video_popup_width'            =>   sanitize_text_field($edn_video['video_popup_width']),
            'video_popup_height'            =>   sanitize_text_field($edn_video['video_popup_height']),
    );
$enable_repeat_check = (isset($edn_countdowntimer['enable_repeat']) && $edn_countdowntimer['enable_repeat'] == 1)?1:0;
$edn_countdowntimer = array(    
            'enable'=> (isset($edn_countdowntimer['enable']))?sanitize_text_field($edn_countdowntimer['enable']):'',
            'text_description' => sanitize_text_field($edn_countdowntimer['text_description']),
            'textcolor' => sanitize_text_field($edn_countdowntimer['textcolor']),
            'textsize' => sanitize_text_field($edn_countdowntimer['textsize']),
            'bgcolor' => sanitize_text_field($edn_countdowntimer['bgcolor']),
            'bgoutercolor' => sanitize_text_field($edn_countdowntimer['bgoutercolor']),
            'fontcolor' => sanitize_text_field($edn_countdowntimer['fontcolor']),
            'buttonbgcolor' => sanitize_text_field($edn_countdowntimer['buttonbgcolor']),
            'buttonfontcolor' => sanitize_text_field($edn_countdowntimer['buttonfontcolor']),
            'buttonhoverbgcolor' => sanitize_text_field($edn_countdowntimer['buttonhoverbgcolor']),
            'buttonhoverfcolor' => sanitize_text_field($edn_countdowntimer['buttonhoverfcolor']),
            'layout_type' => sanitize_text_field($edn_countdowntimer['layout_type']),
            'layout_type2' => sanitize_text_field($edn_countdowntimer['layout_type2']),
            'expirydate' => sanitize_text_field($edn_countdowntimer['expirydate']),
            'enable_repeat'=> $enable_repeat_check,
            'animation' => sanitize_text_field($edn_countdowntimer['animation']),
            'enable_days' => (isset($edn_countdowntimer['enable_days']))?sanitize_text_field($edn_countdowntimer['enable_days']):'',
            'enable_hours' => (isset($edn_countdowntimer['enable_hours']))?sanitize_text_field($edn_countdowntimer['enable_hours']):'',
            'enable_minute' => (isset($edn_countdowntimer['enable_minute']))?sanitize_text_field($edn_countdowntimer['enable_minute']):'',
            'enable_seconds' => (isset($edn_countdowntimer['enable_seconds']))?sanitize_text_field($edn_countdowntimer['enable_seconds']):'', 
            'show_button' => (isset($edn_countdowntimer['show_button']))?sanitize_text_field($edn_countdowntimer['show_button']):'', 
            'enable_days_label' => sanitize_text_field($edn_countdowntimer['enable_days_label']),
            'enable_hours_label' => sanitize_text_field($edn_countdowntimer['enable_hours_label']),
            'enable_minute_label' => sanitize_text_field($edn_countdowntimer['enable_minute_label']),
            'enable_seconds_label' => sanitize_text_field($edn_countdowntimer['enable_seconds_label']),
            'btnlabel' => sanitize_text_field($edn_countdowntimer['btnlabel']),
            'link' => sanitize_text_field($edn_countdowntimer['link']),
            'url_target' => sanitize_text_field($edn_countdowntimer['url_target']),
        );
  $edn_search_form = array(    
            'layout_type'         => sanitize_text_field($edn_search_form['layout_type']),
            'description'         => sanitize_text_field($edn_search_form['description']),
            'hide_button_text'    =>(isset($edn_search_form['hide_button_text']) && $edn_search_form['hide_button_text'] == 1)?1:0,
            'hide_icon'    =>(isset($edn_search_form['hide_icon']) && $edn_search_form['hide_icon'] == 1)?1:0,
            'input_placeholder'   => sanitize_text_field($edn_search_form['input_placeholder']),
            'button_name'         => sanitize_text_field($edn_search_form['button_name']),
            'font_icon'           => sanitize_text_field($edn_search_form['font_icon']),
            'desccolor'           => sanitize_text_field($edn_search_form['desccolor']),
            'bg_color'            => sanitize_text_field($edn_search_form['bg_color']),
            'bg_hover_color'      => sanitize_text_field($edn_search_form['bg_hover_color']),
            'btnfont_color'       => sanitize_text_field($edn_search_form['btnfont_color']),
            'btnfont_hover_color' => sanitize_text_field($edn_search_form['btnfont_hover_color']),
            'icon_fontcolor'      => sanitize_text_field($edn_search_form['icon_fontcolor']),
            'input_border_color'  => sanitize_text_field($edn_search_form['input_border_color']),
            'desc_fontsize'       => sanitize_text_field($edn_search_form['desc_fontsize']),
            'btn_fontsize'        => sanitize_text_field($edn_search_form['btn_fontsize']),
            'btn_transform'       => sanitize_text_field($edn_search_form['btn_transform'])
        );
$edn_bar['edn_contact_choose']    = $edn_contact_choose;
$edn_bar['edn_contact_custom']    = $edn_contact_custom;
$edn_bar['edn_twitter']           = $edn_twitter;
$edn_bar['edn_recentposts']       = $edn_recentposts;
$edn_bar['edn_rssfeed']           = $edn_rssfeed;
$edn_bar['edn_countdowntimer']    = $edn_countdowntimer;
$edn_bar['edn_search_form']       = $edn_search_form;
$edn_bar['edn_video']             = $edn_video;
$edn_bar['edn_custom_html']       = stripslashes_deep($edn_custom_html);
$edn_bar['edn_display']           = $edn_display;
$edn_bar['edn_bar_effect_option'] = $edn_bar_effect_option;
$edn_bar['edn_ticker']            = $edn_ticker;
$edn_bar['edn_slider']            = $edn_slider;
$edn_bar['edn_scroll']            = $edn_scroll;
$edn_bar['edn_bg_color']          = $edn_bg_color;
$edn_bar['edn_font_color']        = $edn_font_color;
$edn_bar['edn_fonts']             = $edn_fonts;
$edn_bar['edn_font_size']         = $edn_font_size;
$edn_bar['edn_button_font_size']                 = $edn_button_font_size;
$edn_bar['edn_btn_transform']                    = $edn_btn_transform;
$edn_bar['edn_btn_font_weight']                  = $edn_btn_font_weight;
$edn_bar['edn_subscribe_header_transform']       = $edn_subscribe_header_transform;
$edn_bar['edn_subscribe_header_font_weight']     = $edn_subscribe_header_font_weight;
$edn_bar['edn_ticker_bg_color']                  = $edn_ticker_bg_color;
$edn_bar['edn_ticker_font_color']                = $edn_ticker_font_color;

$edn_bar['cf_bg_color']           = $cf_bg_color;
$edn_bar['cf_font_color']         = $cf_font_color;
$edn_bar['cf_hover_bg_color']     = $cf_hover_bg_color;
$edn_bar['cf_hover_font_color']   = $cf_hover_font_color;
$edn_bar['success_font_color']    = $success_font_color;
$edn_bar['error_font_color']      = $error_font_color;
$edn_bar['close_bg_color']        = $close_bg_color;
$edn_bar['close_font_color']      = $close_font_color;

$edn_bar['atag_bg_color']                = $atag_bg_color;
$edn_bar['atag_font_color']              = $atag_font_color;
$edn_bar['atag_hover_bg_color']          = $atag_hover_bg_color;
$edn_bar['atag_hover_font_color']        = $atag_hover_font_color;
$edn_bar['atag_font_size'] = $atag_font_size;

if($edn_content_size == ''){
$edn_bar['edn_content_size']      = '12px';
}else{
$edn_bar['edn_content_size']      = $edn_content_size;
}
$edn_bar['edn_content_color']     = $edn_content_color;
if($read_more_fcolor == ''){
$edn_bar['read_more_fcolor']      = '#ffffff';
}else{
$edn_bar['read_more_fcolor']      = $read_more_fcolor;
}
if($read_more_bgcolor == ''){
$edn_bar['read_more_bgcolor']      = '#999';
}else{
$edn_bar['read_more_bgcolor']      = $read_more_bgcolor;
}

$edn_bar['edn_social_heading_text']    = $edn_social_heading_text;
$edn_bar['edn_social_heading_color']   = $edn_social_heading_color;
$edn_bar['icon_details']               = $icons;
$edn_bar['social_counter']             = $social_counter;

$edn_bar['custom_css']                 = $custom_css;
$edn_bar['custom_js']                  = stripslashes($custom_js);
$edn_bar['enable_custom_css']          = (isset($enable_custom_css))?$enable_custom_css:'';
$edn_bar['enable_custom_js']           = (isset($enable_custom_js))?$enable_custom_js:'';


/* open panel data saved */
if(isset($edn_open_panel['edn_widgets']) && !empty($edn_open_panel['edn_widgets']) && is_array($edn_open_panel['edn_widgets'])){
   $edn_widgets =  $edn_open_panel['edn_widgets'];
}else{
    $edn_widgets = array();
}
$enable_openpanel         = isset($edn_open_panel['enable_openpanel'])?$edn_open_panel['enable_openpanel']:'0';

$enable_opanel_bgimage = (isset($edn_open_panel['enable_bgimage']) && $edn_open_panel['enable_bgimage'] == 1)?1:0;
$opanel_bgimage_url     = (isset($edn_open_panel['bgimage_url']) && $edn_open_panel['bgimage_url'] != '')?esc_url($edn_open_panel['bgimage_url']):'';
$bg_opacity_color     = (isset($edn_open_panel['bg_opacity_color']) && $edn_open_panel['bg_opacity_color'] != '')?sanitize_text_field($edn_open_panel['bg_opacity_color']):'';
//trigger image 
$trigger_enable = (isset($edn_open_panel['trigger_enable']) && $edn_open_panel['trigger_enable'] == 1)?1:0;
$trigger_layout     = (isset($edn_open_panel['trigger_layout']) && $edn_open_panel['trigger_layout'] == 'available_image')?'available_image':'upload_custom';
$trigger_image     = (isset($edn_open_panel['trigger_image']) && $edn_open_panel['trigger_image'] != '')?sanitize_url($edn_open_panel['trigger_image']):''; //custom image
$custom_image_width     = (isset($edn_open_panel['custom_image_width']) && $edn_open_panel['custom_image_width'] != '')?intval($edn_open_panel['custom_image_width']):''; 
$custom_image_height     = (isset($edn_open_panel['custom_image_height']) && $edn_open_panel['custom_image_height'] != '')?intval($edn_open_panel['custom_image_height']):''; 
$custom_opanel_animation     = (isset($edn_open_panel['custom_opanel_animation']) && $edn_open_panel['custom_opanel_animation'] != '')?esc_attr($edn_open_panel['custom_opanel_animation']):''; 
$trigger_template     = (isset($edn_open_panel['trigger_template']) && $edn_open_panel['trigger_template'] != '')?intval($edn_open_panel['trigger_template']):'1'; //available trigger image

//trigger image option end
$enable_hover_text        = isset($edn_open_panel['enable_hover_text'])?$edn_open_panel['enable_hover_text']:'0';
$edn_hover_panel_text     = isset($edn_open_panel['edn_hover_panel_text'])?sanitize_text_field($edn_open_panel['edn_hover_panel_text']):'';
/*header*/
$edn_show_header          = isset($edn_open_panel['edn_show_header'])?$edn_open_panel['edn_show_header']:'0';
$edn_header_text          = isset($edn_open_panel['edn_header_text'])?sanitize_text_field($edn_open_panel['edn_header_text']):'';
$edn_header_color         = isset($edn_open_panel['edn_header_color'])?sanitize_text_field($edn_open_panel['edn_header_color']):'';
$show_border_header       =  isset($edn_open_panel['show_border_header'])?$edn_open_panel['show_border_header']:'0';

/*footer*/
$edn_show_footer          = isset($edn_open_panel['edn_show_footer'])?$edn_open_panel['edn_show_footer']:'0';
$edn_footer_text          = isset($edn_open_panel['edn_footer_text'])?sanitize_text_field($edn_open_panel['edn_footer_text']):'';
$edn_footer_color         = isset($edn_open_panel['edn_footer_color'])?sanitize_text_field($edn_open_panel['edn_footer_color']):'';
$show_border_footer       =  isset($edn_open_panel['show_border_footer'])?$edn_open_panel['show_border_footer']:'0';
$edn_border_color         = isset($edn_open_panel['edn_border_color'])?$edn_open_panel['edn_border_color']:'0';
$edn_header_tag_color     = isset($edn_open_panel['edn_header_tag_color'])?$edn_open_panel['edn_header_tag_color']:'';

$edn_header_bgcolor     = isset($edn_open_panel['edn_header_bgcolor'])?$edn_open_panel['edn_header_bgcolor']:'';
$edn_header_bgbordercolor     = isset($edn_open_panel['edn_header_bgbordercolor'])?$edn_open_panel['edn_header_bgbordercolor']:'';
$edn_desc_tag_color       = isset($edn_open_panel['edn_desc_tag_color'])?$edn_open_panel['edn_desc_tag_color']:'';
$edn_hyperlink_color      = isset($edn_open_panel['edn_hyperlink_color'])?$edn_open_panel['edn_hyperlink_color']:'';
$edn_hyperlinkhover_color = isset($edn_open_panel['edn_hyperlinkhover_color'])?$edn_open_panel['edn_hyperlinkhover_color']:'';
$edn_panel_columns        = isset($edn_open_panel['edn_panel_columns'])?$edn_open_panel['edn_panel_columns']:'3';
$content_type        = (isset($edn_open_panel['content_type']) && $edn_open_panel['content_type'] != '')?$edn_open_panel['content_type']:'html_text';
$content_text        = (isset($edn_open_panel['text']) && $edn_open_panel['text'] != '')?stripslashes_deep($edn_open_panel['text']):'';

$edn_open_panel = array(
            'edn_widgets'               => $edn_widgets,
            'enable_openpanel'          => $enable_openpanel,
            'enable_bgimage'            => $enable_opanel_bgimage,
            'bgimage_url'               => $opanel_bgimage_url,
            'bg_opacity_color'          => $bg_opacity_color,
            'trigger_enable'            => $trigger_enable,
            'trigger_image'             => $trigger_image,
            'custom_image_width'        => $custom_image_width,
            'custom_image_height'       => $custom_image_height,
            'custom_opanel_animation'   => $custom_opanel_animation,
            'trigger_layout'            => $trigger_layout,
            'trigger_template'          => $trigger_template,
            'enable_hover_text'         => $enable_hover_text,
            'edn_hover_panel_text'      => $edn_hover_panel_text,
            'edn_border_color'          => $edn_border_color,
            'edn_show_header'           => $edn_show_header,
            'edn_show_footer'           => $edn_show_footer,
            'edn_content_type'         => $content_type,
            'edn_content_text'         => $content_text,
            'edn_panel_columns'         => $edn_panel_columns,
            'edn_header_text'           => $edn_header_text, 
            'edn_footer_text'           => $edn_footer_text,
            'show_border_header'        => $show_border_header,
            'show_border_footer'        => $show_border_footer,
            'edn_header_color'         => $edn_header_color,
            'edn_footer_color'         => $edn_footer_color,
            'edn_header_tag_color'      => $edn_header_tag_color,
            'edn_desc_tag_color'        => $edn_desc_tag_color,
            'edn_hyperlink_color'       => $edn_hyperlink_color,
            'edn_hyperlinkhover_color'  => $edn_hyperlinkhover_color,
            'edn_header_bgcolor'          => $edn_header_bgcolor,
            'edn_header_bgbordercolor'          => $edn_header_bgbordercolor,

           
            );
$edn_bar['edn_open_panel']             = $edn_open_panel;
/* open panel data saved end */
$edn_bar['edn_bar_template']            = $edn_bar_template;
$twtun                                  = sanitize_text_field($edn_bar['edn_twitter']['username']);
$edn_visible_type  = sanitize_text_field($edn_visibility); // Always show , Show After some time, Hide after some time
$edn_close_button  = sanitize_text_field($edn_close_button);  //disable,show-hide,user-can-close 
$edn_show_duration = sanitize_text_field($edn_visibility_show_duration); 
$edn_hide_duration = sanitize_text_field($edn_visibility_hide_duration); 

$edn_bar['edn_click_btn_id']= (isset($edn_visibility_click_btn_id))?sanitize_text_field($edn_visibility_click_btn_id):'';
$edn_bar['show_once']              = (isset($show_once))?sanitize_text_field($show_once):'';
$edn_bar['duration_show_once']     = sanitize_text_field($duration_show_once); 

$edn_bar['show_once_hideshow']     = (isset($show_once_hideshow))?sanitize_text_field($show_once_hideshow):''; 
$edn_bar['show_once_loggedusers'] = (isset($show_once_loggedusers) && $show_once_loggedusers == 1) ?'1':'0'; 
$edn_bar['enbale_snowflakes']     = (isset($enbale_snowflakes) && $enbale_snowflakes == 1)?'1':'0'; 
$edn_bar['closebtn_position']     = (isset($closebtn_position) && $closebtn_position != '')?sanitize_text_field($closebtn_position):'right'; 
$edn_bar = serialize($edn_bar);
$edn_date = serialize($edn_date);

global $wpdb;
$table_name = $wpdb->prefix . "apex_notification_bar";
if(isset($nb_id))
{
 $get_data_from_table = $wpdb->get_results("SELECT * FROM $table_name where nb_id = $nb_id");

 $edn_data = $get_data_from_table[0];
 
 /*reset specific show only once flag set on db*/
 $edn_previous_closebtn = $edn_data->edn_close_button;
 $edn_general_options = get_option('edn_general_options');

 if( $edn_previous_closebtn != $edn_close_button){

 foreach($edn_general_options as $subKey => $subArray){
          if($subArray['nb_id'] == $nb_id){
               unset($edn_general_options[$subKey]);
          }
     }
 } 
update_option('edn_general_options', $edn_general_options);
 /*reset specific show only once flag set on db end on change close button*/
 $edn_bar_data = unserialize($edn_data->edn_bar);
 $previous_twt_username = $edn_bar_data['edn_twitter']['username'];
 if($twtun != '' && $twtun != $previous_twt_username){
    delete_transient('aptf_tweets'); 
 }

$nb_modified_date = date( 'Y-m-d H:i:s:u' );

$update = $wpdb->update( 
    $table_name, 
    array(
            'edn_bar_name'     => $edn_bar_name,
            'edn_position'     => $edn_position,
            'edn_visibility'   => $edn_visible_type,
            'edn_show_duration' =>  $edn_show_duration,
            'edn_hide_duration' =>  $edn_hide_duration,
            'edn_close_button' => $edn_close_button,
            'edn_date'         => $edn_date,
            'edn_bar'          => $edn_bar,
            'nb_modified'      => $nb_modified_date
        ),
    array('nb_id'=>$nb_id), 
    array(
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s'
    ),
    array('%d')
);
$message_status = 1;
//$_SESSION['edn_message'] = __('Notification Bar Updated Successfully',APEXNB_TD);
}
else
{
$nb_created_date  =  date( 'Y-m-d H:i:s:u' );
$nb_modified_date =  date( 'Y-m-d H:i:s:u' );
    $wpdb->insert( 
    $table_name, 
    array(
            'edn_bar_name'     => $edn_bar_name,
            'edn_position'     => $edn_position,
            'edn_visibility'   => $edn_visible_type,
            'edn_show_duration' =>  $edn_show_duration,
            'edn_hide_duration' =>  $edn_hide_duration,
            'edn_close_button' => $edn_close_button,
            'edn_date'         => $edn_date,
            'edn_bar'          => $edn_bar,
            'nb_created'       => $nb_created_date,
            'nb_modified'      => $nb_modified_date
        ),
    array(
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s'
    )
);
$message_status = 2;
//$_SESSION['edn_message'] = __('Notification Bar Added Successfully',APEXNB_TD);
}
// if(isset($_POST['current_page']))
// {
//     wp_redirect($_POST['current_page']);
// }
// else
// {
wp_redirect(admin_url('admin.php?page=apexnb-pro&message='.$message_status));
// }
exit();