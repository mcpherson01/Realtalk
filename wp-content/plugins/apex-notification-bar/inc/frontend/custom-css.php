<style type="text/css">
<?php if(isset($edn_bar_data['edn_cp_type']) && $edn_bar_data['edn_cp_type']=='countdown-timer'){ 
/*Countdown timer design*/
   if(isset($edn_bar_data['edn_countdowntimer']['enable']) && $edn_bar_data['edn_countdowntimer']['enable'] == 1){ 
      $timerbgcolor = (isset($edn_bar_data['edn_countdowntimer']['bgcolor']) && $edn_bar_data['edn_countdowntimer']['bgcolor'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['bgcolor']):'#000';
      $timerfontcolor = (isset($edn_bar_data['edn_countdowntimer']['fontcolor']) && $edn_bar_data['edn_countdowntimer']['fontcolor'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['fontcolor']):'#000';
      $textcolor = (isset($edn_bar_data['edn_countdowntimer']['textcolor']) && $edn_bar_data['edn_countdowntimer']['textcolor'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['textcolor']):'#000';
      $textsize = (isset($edn_bar_data['edn_countdowntimer']['textsize']) && $edn_bar_data['edn_countdowntimer']['textsize'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['textsize']):'14';
      $buttonbgcolor = (isset($edn_bar_data['edn_countdowntimer']['buttonbgcolor']) && $edn_bar_data['edn_countdowntimer']['buttonbgcolor'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['buttonbgcolor']):'#fff';
      $buttonfontcolor = (isset($edn_bar_data['edn_countdowntimer']['buttonfontcolor']) && $edn_bar_data['edn_countdowntimer']['buttonfontcolor'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['buttonfontcolor']):'#000';
      $buttonhoverbgcolor = (isset($edn_bar_data['edn_countdowntimer']['buttonhoverbgcolor']) && $edn_bar_data['edn_countdowntimer']['buttonhoverbgcolor'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['buttonhoverbgcolor']):'#000';
      $buttonhoverfcolor = (isset($edn_bar_data['edn_countdowntimer']['buttonhoverfcolor']) && $edn_bar_data['edn_countdowntimer']['buttonhoverfcolor'] != '')?esc_attr($edn_bar_data['edn_countdowntimer']['buttonhoverfcolor']):'#fff';
      $custombgcolor = $timerbgcolor;
      $darker = APEXNB_Class::darken_color($custombgcolor, $darker=2); ?>
       
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_countdown_timer_main_wrapper .countdown-wrap span,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_countdown_timer_main_wrapper .countdown-wrap h4,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_countdown_timer_main_wrapper .countdown-wrap .apex_countdown p{
          color: <?php echo $timerfontcolor;?>;
        }

        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_countdown_timer_main_wrapper .countdown-wrap .counter_desc{ 
         color: <?php echo $textcolor;?>;
         font-size:  <?php echo $textsize;?>px;
        }
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_countdown_timer_main_wrapper .countdown-wrap .btn_calltoaction{
         background: <?php echo $buttonbgcolor;?>;
         color: <?php echo $buttonfontcolor;?>;
         font-size:  <?php echo $textsize;?>px;
        }
         .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_countdown_timer_main_wrapper .countdown-wrap .btn_calltoaction:hover{
         background: <?php echo $buttonhoverbgcolor;?>;
         color: <?php echo $buttonhoverfcolor;?>;
        }
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb_layout6 #clockdiv > div{
          background: <?php echo $timerbgcolor;?>
        }
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb_layout6 #clockdiv div > span{
         background: <?php echo $darker;?>;
        }
       .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_countdown_timer_main_wrapper .countdown-wrap.apexnb_layout2 .apex_countdown div{
            background: <?php echo $darker;?>
         }
<?php } 
} 
?>

<?php if(isset($edn_bar_data['edn_cp_type']) && $edn_bar_data['edn_cp_type'] =='video-popup'){
  $textcolor = (isset($edn_bar_data['edn_video']['textcolor']) && $edn_bar_data['edn_video']['textcolor'] != '')?esc_attr($edn_bar_data['edn_video']['textcolor']):'';
  $desccolor = (isset($edn_bar_data['edn_video']['desccolor']) && $edn_bar_data['edn_video']['desccolor'] != '')?esc_attr($edn_bar_data['edn_video']['desccolor']):'';
  $descsize = (isset($edn_bar_data['edn_video']['descsize']) && $edn_bar_data['edn_video']['descsize'] != '')?esc_attr($edn_bar_data['edn_video']['descsize']):'';
  $textsize = (isset($edn_bar_data['edn_video']['textsize']) && $edn_bar_data['edn_video']['textsize'] != '')?esc_attr($edn_bar_data['edn_video']['textsize']):'';
  $button_bg_color = (isset($edn_bar_data['edn_video']['button_bg_color']) && $edn_bar_data['edn_video']['button_bg_color'] != '')?esc_attr($edn_bar_data['edn_video']['button_bg_color']):'';
  $button_font_color = (isset($edn_bar_data['edn_video']['button_font_color']) && $edn_bar_data['edn_video']['button_font_color'] != '')?esc_attr($edn_bar_data['edn_video']['button_font_color']):'';
  $button_hover_bg_color = (isset($edn_bar_data['edn_video']['button_hover_bg_color']) && $edn_bar_data['edn_video']['button_hover_bg_color'] != '')?esc_attr($edn_bar_data['edn_video']['button_hover_bg_color']):'';
  $button_hover_font_color = (isset($edn_bar_data['edn_video']['button_hover_font_color']) && $edn_bar_data['edn_video']['button_hover_font_color'] != '')?esc_attr($edn_bar_data['edn_video']['button_hover_font_color']):'';
  $button_font_size = (isset($edn_bar_data['edn_video']['button_font_size']) && $edn_bar_data['edn_video']['button_font_size'] != '')?esc_attr($edn_bar_data['edn_video']['button_font_size']):'';
?>

      <?php if($textcolor != '' || $textsize != ''){?>
      .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-video-popup-section h2{
       <?php if($textcolor != ''){?>  color:  <?php echo $textcolor;?>;<?php } ?>
        <?php if($textsize != ''){?>font-size: <?php echo $textsize;?>px; <?php } ?>
      }
      <?php } ?>
      <?php if($desccolor != '' || $descsize != ''){?>
     .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-video-popup-section p{
        <?php if($desccolor != ''){?> color:  <?php echo $desccolor;?>;<?php } ?>
       <?php if($descsize != ''){?>  font-size: <?php echo $descsize;?>px;<?php } ?>
      }
       <?php } ?>
 <?php if($button_bg_color != '' || $button_font_color != '' || $button_font_size != ''){?>
      .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-video-popup-section.apexnb-video-layout2 .apexnb-video-btn,
      .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-video-popup-section.apexnb-video-layout3 .apexnb-video-btn{
           <?php if($button_bg_color != ''){?>  background-color: <?php echo $button_bg_color;?>; <?php } ?>
           <?php if($button_font_color != ''){?> color: <?php echo $button_font_color;?>; <?php } ?>
       <?php if($button_font_size != ''){?> font-size: <?php echo $button_font_size;?>px; <?php } ?>
       }

      .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-video-popup-section.apexnb-video-layout2 .apexnb-video-btn:hover,
      .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-video-popup-section.apexnb-video-layout3 .apexnb-video-btn:hover{
           <?php if($button_hover_bg_color != ''){?>  background-color: <?php echo $button_hover_bg_color;?>; <?php } ?>
           <?php if($button_hover_font_color != ''){?> color: <?php echo $button_hover_font_color;?>; <?php } ?>
       }

        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-video-popup-section.apexnb-video-layout1 .apexnb-video-btn,
      .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-video-popup-section.apexnb-video-layout4 .apexnb-video-btn{
           <?php if($button_font_color != ''){?> color: <?php echo $button_font_color;?>; <?php } ?>
           <?php if($button_font_size != ''){?> font-size: <?php echo $button_font_size;?>px; <?php } ?>
       }

        <?php } ?>

<?php } ?>

<?php if(isset($edn_bar_data['edn_cp_type']) && $edn_bar_data['edn_cp_type']=='search-form'){ 
    /*Search form design */
    $search_layout_type = ((isset($edn_bar_data['edn_search_form']['layout_type']) && $edn_bar_data['edn_search_form']['layout_type'] != '')?$edn_bar_data['edn_search_form']['layout_type']:'layout1');
    $desccolor = ((isset($edn_bar_data['edn_search_form']['desccolor']) && $edn_bar_data['edn_search_form']['desccolor'] != '')?$edn_bar_data['edn_search_form']['desccolor']:'');
    $btn_bg_color = ((isset($edn_bar_data['edn_search_form']['bg_color']) && $edn_bar_data['edn_search_form']['bg_color'] != '')?$edn_bar_data['edn_search_form']['bg_color']:'');
    $bg_hover_color = ((isset($edn_bar_data['edn_search_form']['bg_hover_color']) && $edn_bar_data['edn_search_form']['bg_hover_color'] != '')?$edn_bar_data['edn_search_form']['bg_hover_color']:'');
    $btnfont_color = ((isset($edn_bar_data['edn_search_form']['btnfont_color']) && $edn_bar_data['edn_search_form']['btnfont_color'] != '')?$edn_bar_data['edn_search_form']['btnfont_color']:'');
    $btnfont_hover_color = ((isset($edn_bar_data['edn_search_form']['btnfont_hover_color']) && $edn_bar_data['edn_search_form']['btnfont_hover_color'] != '')?$edn_bar_data['edn_search_form']['btnfont_hover_color']:'');
    $icon_fontcolor = ((isset($edn_bar_data['edn_search_form']['icon_fontcolor']) && $edn_bar_data['edn_search_form']['icon_fontcolor'] != '')?$edn_bar_data['edn_search_form']['icon_fontcolor']:'');
    $input_border_color = ((isset($edn_bar_data['edn_search_form']['input_border_color']) && $edn_bar_data['edn_search_form']['input_border_color'] != '')?$edn_bar_data['edn_search_form']['input_border_color']:'');
    $desc_fontsize = ((isset($edn_bar_data['edn_search_form']['desc_fontsize']) && $edn_bar_data['edn_search_form']['desc_fontsize'] != '')?$edn_bar_data['edn_search_form']['desc_fontsize']:'');
    $btn_fontsize = ((isset($edn_bar_data['edn_search_form']['btn_fontsize']) && $edn_bar_data['edn_search_form']['btn_fontsize'] != '')?$edn_bar_data['edn_search_form']['btn_fontsize']:'');
    $btn_transform = ((isset($edn_bar_data['edn_search_form']['btn_transform']) && $edn_bar_data['edn_search_form']['btn_transform'] != '')?$edn_bar_data['edn_search_form']['btn_transform']:'');
?>

<?php if($desccolor !== '' || $edn_content_size != ''){ ?>
         .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-searchwrapper .apex-onscreen-description{
                   <?php if($desccolor != ''){?> color:<?php echo esc_attr($desccolor);?>; <?php } ?>
                  <?php if($desc_fontsize != ''){?>  font-size:<?php echo esc_attr($desc_fontsize);?>px; <?php } ?>
          }
<?php } ?>
<?php if($input_border_color != ''){ ?>
      .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-searchwrapper.apexnb-search-layout1 .apex-search-right-section .search-field{
        border-bottom:1px solid <?php echo esc_attr($input_border_color);?>;
      }
<?php }?>

<?php 
$colour = $edn_bar_data['edn_bg_color'];
$brightness = 0.5; // 50% brighter
$search_overlay_darker = APEXNB_Class::colourBrightness($colour,$brightness);
$default_color = "#949f15";
$default_overlay = APEXNB_Class::colourBrightness($default_color,$brightness);
if($search_overlay_darker != ''){?>
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-search-layout4 .apex-search-right-section label:before{
 background-color: <?php echo esc_attr($search_overlay_darker);?>;
}
<?php }else{ ?>
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-search-layout4 .apex-search-right-section label:before{
 background-color: <?php echo esc_attr($default_overlay);?>;
}
<?php }?>


<?php if($input_border_color != ''){ ?>
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-searchwrapper .apex-search-right-section i{
  color:<?php echo esc_attr($icon_fontcolor);?>;
}
<?php }?>

<?php if($btn_bg_color != ''){?>
 .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-searchwrapper .apex-search-right-section .btn-search-now{
       background-color: <?php echo esc_attr($btn_bg_color);?>;
       color:<?php echo esc_attr($btnfont_color);?>;
        <?php if($btn_fontsize != ''){?>  font-size:<?php echo esc_attr($btn_fontsize);?>px; <?php } ?>
      text-transform: <?php echo $btn_transform;?>;
  }

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .apexnb-searchwrapper .apex-search-right-section .btn-search-now:hover{
       background-color: <?php echo esc_attr($bg_hover_color);?>;
       color:<?php echo esc_attr($btnfont_hover_color);?>;
  }
<?php  }
} ?>
/*added custom css*/
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-custom-design-wrapper{
        font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
        color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
        background-color: <?php echo esc_attr($edn_bar_data['edn_bg_color']);?>;

}
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>],
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-contact-lightbox .edn-contact-lightbox-inner-wrap,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-contact-close,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-contact-lightbox-inner-wrap
    {
        font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
        color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
        background-color: <?php echo esc_attr($edn_bar_data['edn_bg_color']);?>;

    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-mulitple-text-content{
        font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
        color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
        display: block;

    }
  .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-contact-form-wrap .edn-contact-close{
        color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
        background-color: <?php echo esc_attr($edn_bar_data['edn_bg_color']);?>;
    }
    /*tweets*/
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_static_text, .slider_template_wrapper .edn-tweet-content, .edn-post-title-wrap .edn-post-title li{
        font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
        color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_static_text, .slider_template_wrapper .edn-tweet-content, .edn-post-title-wrap .edn-post-title li{
        font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
        color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-tweet-content{
      color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
      font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
      font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
      }
      .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-tweet-content a{
       color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
       font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
      }
       .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ticker-wrapper .edn-post-title-readmore{
        font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
        color: <?php echo esc_attr($edn_bar_data['read_more_fcolor']);?> !important;
        background-color: <?php echo esc_attr($edn_bar_data['read_more_bgcolor']);?> !important;
       }
     /*ticker custom design start*/
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ticker-wrapper .ticker-content a, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ticker-wrapper .ticker-content .edn-tweet-content, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ticker-wrapper .edn-mulitple-text-content{
        font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
        color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
    }
      .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ticker-wrapper .ticker-content a{
          margin-left: 8px;
        }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ticker_pattern .edn-ticker-wrapper  .ticker-wrapper  .ticker-swipe{
        background-color:<?php echo esc_attr($edn_bar_data['edn_bg_color']);?>;
     }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ticker-content{
        color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
        font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
     }
     /*ticker custom design end*/
    /*tweets custom design start*/
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-tweet-content{
        font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
        color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
      }
  

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-contact-close, input[type="button"].edn-contact-submit{
        background-color: <?php echo esc_attr($edn_bar_data['edn_bg_color']);?>;
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] a{
        font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
        color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
    }
     .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] a.edn-controls-close{
       color: <?php echo esc_attr($edn_bar_data['cf_font_color']);?>;
    }
  
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-social-heading-title{
        color:<?php echo esc_attr($edn_bar_data['edn_social_heading_color']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
    }
    
    /* Ticker custom design start*/
    <?php if(isset($edn_bar_data['edn_ticker_bg_color']) && $edn_bar_data['edn_ticker_bg_color'] != ''){ ?>
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ticker-title{
      background: <?php echo esc_attr($edn_bar_data['edn_ticker_bg_color']);?>;
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ticker-wrapper .ticker-title:before{
      border-left: 10px solid <?php echo esc_attr($edn_bar_data['edn_ticker_bg_color']);?>;
    }
    <?php } ?>
     <?php if(isset($edn_bar_data['edn_ticker_font_color']) && $edn_bar_data['edn_ticker_font_color'] != ''){ ?>
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ticker-wrapper .ticker-title span{
        color: <?php echo esc_attr($edn_bar_data['edn_ticker_font_color']);?>;
    }
     <?php } ?>
  /* Ticker custom design end*/
    /*Constant Contact Subscribe Form,Custom Subscribe Form,Mailchimp form CSS ADDED*/
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] h1,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] h2,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] h3,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] h4,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] h5,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] h6,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-constant-contact-wrap .edn-front-title h3,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-subscribe-form .edn-front-title h3,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-mailchimp-wrap .edn-front-title h3{
        color:<?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
        <?php if(isset($edn_bar_data['edn_subscribe_header_font_weight'])){ ?>
          font-weight: <?php echo esc_attr($edn_bar_data['edn_subscribe_header_font_weight']);?>;
          <?php } ?>
          <?php if(isset($edn_bar_data['edn_subscribe_header_transform']) && $edn_bar_data['edn_subscribe_header_transform'] != ''){ ?>
          text-transform: <?php echo esc_attr($edn_bar_data['edn_subscribe_header_transform']);?>;
          <?php } ?>
        
    }

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-constant-contact-wrap .edn-front-title span,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-subscribe-form .edn-front-title span,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-mailchimp-wrap .edn-front-title span{
        color:<?php echo esc_attr($edn_bar_data['edn_content_color']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_content_size']);?>px;
    }

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-constant-contact-wrap .edn-front-title .show_icon i,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-subscribe-form .edn-front-title .show_icon i,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-mailchimp-wrap .edn-front-title .show_icon i{
       color:<?php echo esc_attr($edn_bar_data['edn_content_color']);?>;
    }
 
    /*Constant Contact Subscribe Form CSS END*/

    /* For all  CUstom buttons start */
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-form-field .constant_subscribe, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-form-field .edn_mailchimp_submit_ajax, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-subscribe-form .edn-form-field .edn_subs_submit_ajax,   
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-custom-contact-link, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-temp1-static-button, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_static_text .edn-call-action-button a, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-call-action-button a,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-contact-lightbox .edn-form-field .edn-field input.edn-contact-submit{
      background: <?php echo esc_attr($edn_bar_data['cf_bg_color']);?>;
      color: <?php echo esc_attr($edn_bar_data['cf_font_color']);?>;
      font-size: <?php echo esc_attr($edn_bar_data['edn_button_font_size']);?>px;
      font-weight: <?php echo esc_attr($edn_bar_data['edn_btn_font_weight']);?>;
      text-transform:  <?php echo esc_attr($edn_bar_data['edn_btn_transform']);?>;
      font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
    }



      <?php
      $cf_hover_bg_color = (isset($edn_bar_data['cf_hover_bg_color']) && $edn_bar_data['cf_hover_bg_color'] != '')?$edn_bar_data['cf_hover_bg_color']:'';
      $cf_hover_font_color = (isset($edn_bar_data['cf_hover_font_color']) && $edn_bar_data['cf_hover_font_color'] != '')?$edn_bar_data['cf_hover_font_color']:'';
      
      $atag_bg_color = (isset($edn_bar_data['atag_bg_color']) && $edn_bar_data['atag_bg_color'] != '')?$edn_bar_data['atag_bg_color']:'';
      $atag_font_color = (isset($edn_bar_data['atag_font_color']) && $edn_bar_data['atag_font_color'] != '')?$edn_bar_data['atag_font_color']:'';
      $atag_hover_bg_color = (isset($edn_bar_data['atag_hover_bg_color']) && $edn_bar_data['atag_hover_bg_color'] != '')?$edn_bar_data['atag_hover_bg_color']:'';
      $atag_hover_font_color = (isset($edn_bar_data['atag_hover_font_color']) && $edn_bar_data['atag_hover_font_color'] != '')?$edn_bar_data['atag_hover_font_color']:'';
      $atag_hover_font_color = (isset($edn_bar_data['atag_hover_font_color']) && $edn_bar_data['atag_hover_font_color'] != '')?$edn_bar_data['atag_hover_font_color']:'';
      $atag_font_size = (isset($edn_bar_data['atag_font_size']) && $edn_bar_data['atag_font_size'] != '')?$edn_bar_data['atag_font_size']:'';
     
      if($cf_hover_font_color != '' || $cf_hover_bg_color != ''){?>
          .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_static_text .edn-call-action-button a:hover,
          .edn-custom-template.edn-notify-bar .edn-custom-contact-link:hover,
          .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-subscribe-form .edn-form-field .edn_subs_submit_ajax:hover,
          .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-form-field .edn_mailchimp_submit_ajax:hover,
           .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-form-field .constant_subscribe:hover 
          {
              color: <?php echo esc_attr($cf_hover_font_color);?>;
              background: <?php echo esc_attr($cf_hover_bg_color);?>;
          }

    <?php }

    if($atag_font_color != '' || $atag_bg_color != '' || $atag_font_size != ''){ ?>

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_static_text .edn-text-link a, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_multiple_text .edn-mulitple-text-content a,
    edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-multiple-content .edn-mulitple-text-content a,
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-post-title-wrap .edn-post-title li a{
        color: <?php echo esc_attr($atag_font_color);?>;
        background: <?php echo esc_attr($atag_bg_color);?>;
        font-size:  <?php echo esc_attr($atag_font_size);?>px;
    }
    <?php } 
    if($atag_hover_font_color != '' || $atag_hover_bg_color != ''){ ?>

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_static_text .edn-text-link a:hover, 
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_multiple_text .edn-mulitple-text-content a:hover{
        color: <?php echo esc_attr($atag_hover_font_color);?>;
        background: <?php echo esc_attr($atag_hover_bg_color);?>;
    }
    <?php } 

    if($atag_font_color != '' || $atag_bg_color != '' || $atag_font_size != ''){?>

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-mulitple-text-content a {
        color: <?php echo esc_attr($atag_font_color);?>;
        background: <?php echo esc_attr($atag_bg_color);?>;
        font-size:  <?php echo esc_attr($atag_font_size);?>px;
        padding: 2px 8px;
    }
    <?php } if($atag_hover_font_color != '' || $atag_hover_bg_color != ''){ ?>
     .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-mulitple-text-content a:hover {
         color: <?php echo esc_attr($atag_hover_font_color);?>;
         background: <?php echo esc_attr($atag_hover_bg_color);?>;
    }
    <?php } ?>

   
    /* for all custom button end*/

    /*.endpro_main_leftright_wrapper .edn-text-link{
        vertical-align: middle;
     }*/

     /* close button custom css */
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>]  .edn-top-up-arrow.open,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>]  .edn-bottom-down-arrow.open,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>]  .edn-bottom-down-arrow.open,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-left-arrow,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-right-arrow,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-cntrol-wrap.ednpro_user-can-close {
            background-color: <?php echo esc_attr($edn_bar_data['close_bg_color']);?>; 
            background-image:  url("../../images/showhidetoggledown.png") no-repeat scroll 0 0;

        }
         .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-cntrol-wrap.ednpro_user-can-close .fa-close{
          color: <?php echo esc_attr($edn_bar_data['close_font_color']);?>;          
        }

        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-top-up-arrow {
             background-color: <?php echo esc_attr($edn_bar_data['close_bg_color']);?>; 
             background-image: url("../../images/showhidetoggletop.png") no-repeat scroll 0 0;
             border-radius: 14px;
        }
       .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-bottom-down-arrow{
           background-color: <?php echo esc_attr($edn_bar_data['close_bg_color']);?>; 
              border-radius: 14px;
           background-image: url("../../images/showhidetoggledown.png") no-repeat scroll 0 0;
        }
    /* close button custom css */
       .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_error, .edn-error,.edn-constant-error {
            color: <?php echo esc_attr($edn_bar_data['error_font_color']);?>; 
            font-size: 12px;
        }
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-success,.edn-constant-success{
            color: <?php echo esc_attr($edn_bar_data['success_font_color']);?>; 
            font-size: 12px;
        }

       .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_error, .edn-error,.edn-constant-error
       .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-success,.edn-constant-success,
        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-rss-feed li{
          font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        }

        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-rss-feed li{
            font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
            color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
        }
       .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-rss-feed li a {
            color: <?php echo esc_attr($edn_bar_data['read_more_fcolor']);?>;
            background-color: <?php echo esc_attr($edn_bar_data['read_more_bgcolor']);?>;
        }

        .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_rss_feed_wrapper .ticker-wrapper .ticker-content a.edn_temp_link{
            color: <?php echo esc_attr($edn_bar_data['read_more_fcolor']);?> !important;
            background-color: <?php echo esc_attr($edn_bar_data['read_more_bgcolor']);?> !important;
        }


        /*social icons custom design start*/
<?php if(isset($edn_bar_data['icon_details']) && $edn_bar_data['icon_details']){
            foreach($edn_bar_data['icon_details'] as $icon_list){
                $array_name = explode('-',esc_attr($icon_list['font_icon']));
                $social_class = ($array_name[1]);
                ?>
                .edn-notify-bar.edn-custom-template .edn-social-icons-bg{
                  width:34px;
                }
                   .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] a.edn-aclass-<?php echo $social_class;?>{
                        background: <?php echo esc_attr($icon_list['bg_color']);?> !important;                   
                    }
                   .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] a.edn-aclass-<?php echo $social_class;?>:hover{
                        background: <?php echo esc_attr($icon_list['bg_hover_color']);?> !important;
                    }
                    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] a i.edn-iclass-<?php echo $social_class;?>{
                        font-size: <?php echo esc_attr($icon_list['icon_size']);?> !important;
                        color: <?php echo esc_attr($icon_list['font_color']);?> !important;
                    }
                   .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] a.edn-aclass-<?php echo $social_class;?> i.edn-iclass-<?php echo $social_class;?>:hover,
                   .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-<?php echo $social_class;?>-button:hover,
                    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-aclass-<?php echo $social_class;?>:hover
                    {
                        color: <?php echo esc_attr($icon_list['font_hover_color']);?> !important;
                    }
                   
                <?php
            }
        }
        /*social icons custom design end*/
        if(isset($edn_bar_data['edn_static']['call_action_button']) && $edn_bar_data['edn_static']['call_action_button']=='custom' && $edn_bar_data['edn_text_display_mode'] != "multiple"){
            ?>


                .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn_static_text, .slider_template_wrapper .edn-tweet-content,
                 .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-post-title-wrap .edn-post-title li{
                 color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
                }
     
            <?php 
        }else{
            if(isset($edn_bar_data['edn_multiple']['text_content'])){
            $total_data = count($edn_bar_data['edn_multiple']['text_content']);
            for($i=0; $i<$total_data; $i++){
                ?>
                    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-multiple-btn-<?php echo $i;?>{
                        background: <?php echo esc_attr($edn_bar_data['edn_multiple']['link_but_color'][$i]);?>;
                        color: <?php echo esc_attr($edn_bar_data['edn_multiple']['link_but_text_color'][$i]);?>;
                        padding: 5px 10px 5px 10px;
                    }
                    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-multiple-btn-<?php echo $i;?>:hover
                    {                 
                        background-color: #fff;
                        color: #000;                      
                    }      
                <?php
            }
           
            }
        }
    ?>

    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>].edn-visibility-show-time{
        display: none;
    }
    .edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .visibility_show-time{
        display: none;
    }
</style>

<?php if($enable == 1){?>
<style type="text/css">
<?php 
if($show_border_header == 1){ ?>
.ednpro-open-panel .main_top_header_txt .headertext{  
border-bottom: 0px solid;
}
<?php }?>
<?php 
if($show_border_footer == 1){ ?>
.ednpro-open-panel .main_top_footer_txt{  
border-top: 0px solid;
}
<?php }?>
<?php 
if($edn_bartype  == 'edn-custom-template'){ ?>
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>].ednpro-open-panel .ednpro-open-panel,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-custom-design-wrapper{
        font-family: <?php echo esc_attr($edn_bar_data['edn_fonts']);?>;
        font-size: <?php echo esc_attr($edn_bar_data['edn_font_size']);?>px;
        color: <?php echo esc_attr($edn_bar_data['edn_font_color']);?>;
        background-color: <?php echo esc_attr($edn_bar_data['edn_bg_color']);?>;
}

.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .edn-top-up-arrow{
  background-color: <?php echo esc_attr($edn_bar_data['edn_bg_color']);?>;
}


  <?php if($edn_header_color != ''){?>
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .main_top_header_txt .headertext{
  color:<?php echo $edn_header_color;?>;
}
<?php  }
if($edn_footer_color != ''){?>
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .main_top_footer_txt{
  color:<?php echo $edn_footer_color;?>;
}
<?php }  ?>
<?php 
if($show_border_header != 1 && $edn_border_color != ''){ ?>
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .main_top_header_txt .headertext{  
border-bottom-color: <?php echo $edn_border_color;?> !important;
}
<?php }?>
<?php 
if($show_border_footer != 1  && $edn_border_color != ''){ ?>
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .main_top_footer_txt{  
border-top-color: <?php echo $edn_border_color;?> !important;
}
<?php }?>
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content span,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content p,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content ul li{
color:<?php echo $edn_desc_tag_color;?>;
}

.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content a{
color:<?php echo $edn_hyperlink_color;?>;
}

.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content a:hover{
color:<?php echo $edn_hyperlinkhover_color;?>;
}

.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h4,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h1,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h2,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h3,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h5,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h6{
  color:<?php echo $edn_header_tag_color;?>;
}

<?php if($edn_header_bgcolor != ''){?>
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h4,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h1,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h2,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h3,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h5,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h6{

   background: <?php echo $edn_header_bgcolor;?> none repeat scroll 0 0;
}
<?php } ?>
<?php if($edn_header_bgbordercolor != ''){?>
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h4::after,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h4::after,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h4::after,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h4::after,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h4::after,
.edn-custom-template[data-barid=apexbar-<?php echo $nb_id;?>] .ednpro-open-panel .ednpro_widgets_content h4::after{
  border-bottom-color:<?php echo $edn_header_bgbordercolor;?>;
}
<?php }
} ?>
</style>
<?php } ?>

<!-- END OF OPEN PANEL CUSTOM CSS -->