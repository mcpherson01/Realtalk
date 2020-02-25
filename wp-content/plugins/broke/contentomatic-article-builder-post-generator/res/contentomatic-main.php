<?php
   function contentomatic_admin_settings()
   {
       $language_names = array(
           esc_html__("Disabled", 'contentomatic-article-builder-post-generator'),
           esc_html__("Afrikaans (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Albanian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Arabic (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Amharic (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Armenian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Belarusian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Bulgarian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Catalan (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Chinese Simplified (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Croatian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Czech (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Danish (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Dutch (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("English (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Estonian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Filipino (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Finnish (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("French (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Galician (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("German (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Greek (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Hebrew (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Hindi (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Hungarian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Icelandic (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Indonesian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Irish (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Italian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Japanese (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Korean (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Latvian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Lithuanian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Norwegian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Macedonian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Malay (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Maltese (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Persian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Polish (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Portuguese (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Romanian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Russian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Serbian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Slovak (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Slovenian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Spanish (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Swahili (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Swedish (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Thai (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Turkish (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Ukrainian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Vietnamese (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Welsh (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Yiddish (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Tamil (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Azerbaijani (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Kannada (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Basque (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Bengali (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Latin (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Chinese Traditional (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Esperanto (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Georgian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Telugu (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Gujarati (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Haitian Creole (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Urdu (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Burmese (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Bosnian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Cebuano (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Chichewa (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Corsican (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Frisian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Scottish Gaelic (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Hausa (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Hawaian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Hmong (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Igbo (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Javanese (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Kazakh (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Khmer (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Kurdish (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Kyrgyz (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Lao (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Luxembourgish (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Malagasy (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Malayalam (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Maori (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Marathi (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Mongolian (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Nepali (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Pashto (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Punjabi (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Samoan (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Sesotho (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Shona (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Sindhi (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Sinhala (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Somali (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Sundanese (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Swahili (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Tajik (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Uzbek (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Xhosa (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Yoruba (Google Translate)", 'contentomatic-article-builder-post-generator'),
           esc_html__("Zulu (Google Translate)", 'contentomatic-article-builder-post-generator')
       );
       $language_codes = array(
           "disabled",
           "af",
           "sq",
           "ar",
           "am",
           "hy",
           "be",
           "bg",
           "ca",
           "zh-CN",
           "hr",
           "cs",
           "da",
           "nl",
           "en",
           "et",
           "tl",
           "fi",
           "fr",
           "gl",
           "de",
           "el",
           "iw",
           "hi",
           "hu",
           "is",
           "id",
           "ga",
           "it",
           "ja",
           "ko",
           "lv",
           "lt",
           "no",
           "mk",
           "ms",
           "mt",
           "fa",
           "pl",
           "pt",
           "ro",
           "ru",
           "sr",
           "sk",
           "sl",
           "es",
           "sw",
           "sv",   
           "th",
           "tr",
           "uk",
           "vi",
           "cy",
           "yi",
           "ta",
           "az",
           "kn",
           "eu",
           "bn",
           "la",
           "zh-TW",
           "eo",
           "ka",
           "te",
           "gu",
           "ht",
           "ur",
           
           "my",
           "bs",
           "ceb",
           "ny",
           "co",
           "fy",
           "gd",
           "ha",
           "haw",
           "hmn",
           "ig",
           "jw",
           "kk",
           "km",
           "ku",
           "ky",
           "lo",
           "lb",
           "mg",
           "ml",
           "mi",
           "mr",
           "mn",
           "ne",
           "ps",
           "pa",
           "sm",
           "st",
           "sn",
           "sd",
           "si",
           "so",
           "su",
           "sw",
           "tg",
           "uz",
           "xh",
           "yo",
           "zu"
       );
       $language_names_deepl = array(
           "English (Deepl)",
           "German (Deepl)",
           "French (Deepl)",
           "Spanish (Deepl)",
           "Italian (Deepl)",
           "Dutch (Deepl)",
           "Polish (Deepl)",
           "Russian (Deepl)",
           "Portuguese (Deepl)"
       );
       $language_codes_deepl = array(
           "EN-",
           "DE-",
           "FR-",
           "ES-",
           "IT-",
           "NL-",
           "PL-",
           "RU-",
           "PT-"
       );
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
<div>
<form id="myForm" method="post" action="<?php if(is_multisite() && is_network_admin()){echo '../options.php';}else{echo 'options.php';}?>">
   <div class="cr_autocomplete">
      <input type="password" id="PreventChromeAutocomplete" 
         name="PreventChromeAutocomplete" autocomplete="address-level4" />
   </div>
   <?php
      settings_fields('contentomatic_option_group');
      do_settings_sections('contentomatic_option_group');
      $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
      if (isset($contentomatic_Main_Settings['contentomatic_enabled'])) {
          $contentomatic_enabled = $contentomatic_Main_Settings['contentomatic_enabled'];
      } else {
          $contentomatic_enabled = '';
      }
      if (isset($contentomatic_Main_Settings['enable_metabox'])) {
          $enable_metabox = $contentomatic_Main_Settings['enable_metabox'];
      } else {
          $enable_metabox = '';
      }
      if (isset($contentomatic_Main_Settings['sentence_list'])) {
          $sentence_list = $contentomatic_Main_Settings['sentence_list'];
      } else {
          $sentence_list = '';
      }
      if (isset($contentomatic_Main_Settings['sentence_list2'])) {
          $sentence_list2 = $contentomatic_Main_Settings['sentence_list2'];
      } else {
          $sentence_list2 = '';
      }
      if (isset($contentomatic_Main_Settings['variable_list'])) {
          $variable_list = $contentomatic_Main_Settings['variable_list'];
      } else {
          $variable_list = '';
      }
      if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
          $enable_detailed_logging = $contentomatic_Main_Settings['enable_detailed_logging'];
      } else {
          $enable_detailed_logging = '';
      }
      if (isset($contentomatic_Main_Settings['enable_logging'])) {
          $enable_logging = $contentomatic_Main_Settings['enable_logging'];
      } else {
          $enable_logging = '';
      }
      if (isset($contentomatic_Main_Settings['auto_clear_logs'])) {
          $auto_clear_logs = $contentomatic_Main_Settings['auto_clear_logs'];
      } else {
          $auto_clear_logs = '';
      }
      if (isset($contentomatic_Main_Settings['rule_timeout'])) {
          $rule_timeout = $contentomatic_Main_Settings['rule_timeout'];
      } else {
          $rule_timeout = '';
      }
      if (isset($contentomatic_Main_Settings['new_category'])) {
          $new_category = $contentomatic_Main_Settings['new_category'];
      } else {
          $new_category = '';
      }
      if (isset($contentomatic_Main_Settings['send_email'])) {
          $send_email = $contentomatic_Main_Settings['send_email'];
      } else {
          $send_email = '';
      }
      if (isset($contentomatic_Main_Settings['email_address'])) {
          $email_address = $contentomatic_Main_Settings['email_address'];
      } else {
          $email_address = '';
      }
      if (isset($contentomatic_Main_Settings['translate'])) {
          $translate = $contentomatic_Main_Settings['translate'];
      } else {
          $translate = '';
      }
      if (isset($contentomatic_Main_Settings['translate_source'])) {
          $translate_source = $contentomatic_Main_Settings['translate_source'];
      } else {
          $translate_source = '';
      }
      if (isset($contentomatic_Main_Settings['spin_text'])) {
          $spin_text = $contentomatic_Main_Settings['spin_text'];
      } else {
          $spin_text = '';
      }
      if (isset($contentomatic_Main_Settings['best_user'])) {
          $best_user = $contentomatic_Main_Settings['best_user'];
      } else {
          $best_user = '';
      }
      if (isset($contentomatic_Main_Settings['no_title_spin'])) {
          $no_title_spin = $contentomatic_Main_Settings['no_title_spin'];
      } else {
          $no_title_spin = '';
      }
      if (isset($contentomatic_Main_Settings['exclude_words'])) {
          $exclude_words = $contentomatic_Main_Settings['exclude_words'];
      } else {
          $exclude_words = '';
      }
      if (isset($contentomatic_Main_Settings['best_password'])) {
          $best_password = $contentomatic_Main_Settings['best_password'];
      } else {
          $best_password = '';
      }
      if (isset($contentomatic_Main_Settings['min_word_title'])) {
          $min_word_title = $contentomatic_Main_Settings['min_word_title'];
      } else {
          $min_word_title = '';
      }
      if (isset($contentomatic_Main_Settings['max_word_title'])) {
          $max_word_title = $contentomatic_Main_Settings['max_word_title'];
      } else {
          $max_word_title = '';
      }
      if (isset($contentomatic_Main_Settings['min_word_content'])) {
          $min_word_content = $contentomatic_Main_Settings['min_word_content'];
      } else {
          $min_word_content = '';
      }
      if (isset($contentomatic_Main_Settings['max_word_content'])) {
          $max_word_content = $contentomatic_Main_Settings['max_word_content'];
      } else {
          $max_word_content = '';
      }
      if (isset($contentomatic_Main_Settings['required_words'])) {
          $required_words = $contentomatic_Main_Settings['required_words'];
      } else {
          $required_words = '';
      }
      if (isset($contentomatic_Main_Settings['banned_words'])) {
          $banned_words = $contentomatic_Main_Settings['banned_words'];
      } else {
          $banned_words = '';
      }
      if (isset($contentomatic_Main_Settings['custom_html2'])) {
          $custom_html2 = $contentomatic_Main_Settings['custom_html2'];
      } else {
          $custom_html2 = '';
      }
      if (isset($contentomatic_Main_Settings['custom_html'])) {
          $custom_html = $contentomatic_Main_Settings['custom_html'];
      } else {
          $custom_html = '';
      }
      if (isset($contentomatic_Main_Settings['deepl_auth'])) {
          $deepl_auth = $contentomatic_Main_Settings['deepl_auth'];
      } else {
          $deepl_auth = '';
      }
      if (isset($contentomatic_Main_Settings['app_id'])) {
          $app_id = $contentomatic_Main_Settings['app_id'];
      } else {
          $app_id = '';
      }
      if (isset($contentomatic_Main_Settings['app_pass'])) {
          $app_pass = $contentomatic_Main_Settings['app_pass'];
      } else {
          $app_pass = '';
      }
      if (isset($contentomatic_Main_Settings['resize_width'])) {
          $resize_width = $contentomatic_Main_Settings['resize_width'];
      } else {
          $resize_width = '';
      }
      if (isset($contentomatic_Main_Settings['no_local_image'])) {
          $no_local_image = $contentomatic_Main_Settings['no_local_image'];
      } else {
          $no_local_image = '';
      }
      if (isset($contentomatic_Main_Settings['resize_height'])) {
          $resize_height = $contentomatic_Main_Settings['resize_height'];
      } else {
          $resize_height = '';
      }
      if (isset($contentomatic_Main_Settings['no_check'])) {
          $no_check = $contentomatic_Main_Settings['no_check'];
      } else {
          $no_check = '';
      }
      if (isset($contentomatic_Main_Settings['secret_word'])) {
          $secret_word = $contentomatic_Main_Settings['secret_word'];
      } else {
          $secret_word = '';
      }
      if (isset($contentomatic_Main_Settings['require_all'])) {
          $require_all = $contentomatic_Main_Settings['require_all'];
      } else {
          $require_all = '';
      }
      if (isset($contentomatic_Main_Settings['no_link_translate'])) {
          $no_link_translate = $contentomatic_Main_Settings['no_link_translate'];
      } else {
          $no_link_translate = '';
      }
      if (isset($contentomatic_Main_Settings['skip_failed_tr'])) {
          $skip_failed_tr = $contentomatic_Main_Settings['skip_failed_tr'];
      } else {
          $skip_failed_tr = '';
      }
      if (isset($contentomatic_Main_Settings['scrapeimg_height'])) {
          $scrapeimg_height = $contentomatic_Main_Settings['scrapeimg_height'];
      } else {
          $scrapeimg_height = '';
      }
      if (isset($contentomatic_Main_Settings['attr_text'])) {
          $attr_text = $contentomatic_Main_Settings['attr_text'];
      } else {
          $attr_text = '';
      }
      if (isset($contentomatic_Main_Settings['scrapeimg_width'])) {
          $scrapeimg_width = $contentomatic_Main_Settings['scrapeimg_width'];
      } else {
          $scrapeimg_width = '';
      }
      if (isset($contentomatic_Main_Settings['scrapeimg_cat'])) {
          $scrapeimg_cat = $contentomatic_Main_Settings['scrapeimg_cat'];
      } else {
          $scrapeimg_cat = '';
      }
      if (isset($contentomatic_Main_Settings['scrapeimg_order'])) {
          $scrapeimg_order = $contentomatic_Main_Settings['scrapeimg_order'];
      } else {
          $scrapeimg_order = '';
      }
      if (isset($contentomatic_Main_Settings['scrapeimg_orientation'])) {
          $scrapeimg_orientation = $contentomatic_Main_Settings['scrapeimg_orientation'];
      } else {
          $scrapeimg_orientation = '';
      }
      if (isset($contentomatic_Main_Settings['imgtype'])) {
          $imgtype = $contentomatic_Main_Settings['imgtype'];
      } else {
          $imgtype = '';
      }
      if (isset($contentomatic_Main_Settings['img_order'])) {
          $img_order = $contentomatic_Main_Settings['img_order'];
      } else {
          $img_order = '';
      }
      if (isset($contentomatic_Main_Settings['scrapeimgtype'])) {
          $scrapeimgtype = $contentomatic_Main_Settings['scrapeimgtype'];
      } else {
          $scrapeimgtype = '';
      }
      if (isset($contentomatic_Main_Settings['pixabay_scrape'])) {
          $pixabay_scrape = $contentomatic_Main_Settings['pixabay_scrape'];
      } else {
          $pixabay_scrape = '';
      }
      if (isset($contentomatic_Main_Settings['img_editor'])) {
          $img_editor = $contentomatic_Main_Settings['img_editor'];
      } else {
          $img_editor = '';
      }
      if (isset($contentomatic_Main_Settings['img_language'])) {
          $img_language = $contentomatic_Main_Settings['img_language'];
      } else {
          $img_language = '';
      }
      if (isset($contentomatic_Main_Settings['img_ss'])) {
          $img_ss = $contentomatic_Main_Settings['img_ss'];
      } else {
          $img_ss = '';
      }
      if (isset($contentomatic_Main_Settings['img_mwidth'])) {
          $img_mwidth = $contentomatic_Main_Settings['img_mwidth'];
      } else {
          $img_mwidth = '';
      }
      if (isset($contentomatic_Main_Settings['img_width'])) {
          $img_width = $contentomatic_Main_Settings['img_width'];
      } else {
          $img_width = '';
      }
      if (isset($contentomatic_Main_Settings['img_cat'])) {
          $img_cat = $contentomatic_Main_Settings['img_cat'];
      } else {
          $img_cat = '';
      }
      if (isset($contentomatic_Main_Settings['pixabay_api'])) {
          $pixabay_api = $contentomatic_Main_Settings['pixabay_api'];
      } else {
          $pixabay_api = '';
      }
      if (isset($contentomatic_Main_Settings['pexels_api'])) {
          $pexels_api = $contentomatic_Main_Settings['pexels_api'];
      } else {
          $pexels_api = '';
      }
      if (isset($contentomatic_Main_Settings['morguefile_secret'])) {
          $morguefile_secret = $contentomatic_Main_Settings['morguefile_secret'];
      } else {
          $morguefile_secret = '';
      }
      if (isset($contentomatic_Main_Settings['morguefile_api'])) {
          $morguefile_api = $contentomatic_Main_Settings['morguefile_api'];
      } else {
          $morguefile_api = '';
      }
      if (isset($contentomatic_Main_Settings['bimage'])) {
          $bimage = $contentomatic_Main_Settings['bimage'];
      } else {
          $bimage = '';
      }
      if (isset($contentomatic_Main_Settings['flickr_order'])) {
          $flickr_order = $contentomatic_Main_Settings['flickr_order'];
      } else {
          $flickr_order = '';
      }
      if (isset($contentomatic_Main_Settings['flickr_license'])) {
          $flickr_license = $contentomatic_Main_Settings['flickr_license'];
      } else {
          $flickr_license = '';
      }
      if (isset($contentomatic_Main_Settings['flickr_api'])) {
          $flickr_api = $contentomatic_Main_Settings['flickr_api'];
      } else {
          $flickr_api = '';
      }
      $get_option_viewed = get_option('coderevolution_settings_viewed', 0);
      if ($get_option_viewed == 0) {
      ?>
   <div id="message" class="updated">
      <p class="cr_saved_notif"><strong>&nbsp;<?php echo sprintf( wp_kses( __( 'Did you see our new <a href="%s" target="_blank">recommendations page</a>? It will help you increase your passive earnings!', 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'admin.php?page=contentomatic_recommendations' ) );?></strong></p>
   </div>
   <?php
      }
      if (isset($_GET['settings-updated'])) {
      ?>
   <div id="message" class="updated">
      <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Settings saved.', 'contentomatic-article-builder-post-generator');?></strong></p>
   </div>
   <?php
      $get = get_option('coderevolution_settings_changed', 0);
      if($get == 1)
      {
          delete_option('coderevolution_settings_changed');
      ?>
   <div id="message" class="updated">
      <p class="cr_failed_notif"><strong>&nbsp;<?php echo esc_html__('Plugin registration failed!', 'contentomatic-article-builder-post-generator');?></strong></p>
   </div>
   <?php 
      }
      elseif($get == 2)
      {
              delete_option('coderevolution_settings_changed');
      ?>
   <div id="message" class="updated">
      <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Plugin registration successful!', 'contentomatic-article-builder-post-generator');?></strong></p>
   </div>
   <?php 
      }
          }
      ?>
   <div>
   <div class="contentomatic_class">
      <table>
         <tr>
            <td>
               <h1>
                  <span class="gs-sub-heading"><b>Contentomatic Automatic Post Generator Plugin - <?php echo esc_html__('Main Switch:', 'contentomatic-article-builder-post-generator');?></b>&nbsp;</span>
                  <span class="cr_07_font">v1.0&nbsp;</span>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Enable or disable this plugin. This acts like a main switch.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
               </h1>
            </td>
            <td>
               <div class="slideThree">	
                  <input class="input-checkbox" type="checkbox" id="contentomatic_enabled" name="contentomatic_Main_Settings[contentomatic_enabled]"<?php
                     if ($contentomatic_enabled == 'on')
                         echo ' checked ';
                     ?>>
                  <label for="contentomatic_enabled"></label>
               </div>
            </td>
         </tr>
      </table>
   </div>
   <div><?php if($contentomatic_enabled != 'on'){echo '<div class="crf_bord cr_color_red cr_auto_update">' . esc_html__('This feature of the plugin is disabled! Please enable it from the above switch.', 'contentomatic-article-builder-post-generator') . '</div>';}?>
      <table>
         <tr>
            <td colspan="2">
               <?php
                  $plugin = plugin_basename(__FILE__);
                  $plugin_slug = explode('/', $plugin);
                  $plugin_slug = $plugin_slug[0]; 
                  $uoptions = get_option($plugin_slug . '_registration', array());
                  if(isset($uoptions['item_id']) && isset($uoptions['item_name']) && isset($uoptions['created_at']) && isset($uoptions['buyer']) && isset($uoptions['licence']) && isset($uoptions['supported_until']))
                  {
                  ?>
               <h3><b><?php echo esc_html__("Plugin Registration Info - Automatic Updates Enabled:", 'contentomatic-article-builder-post-generator');?></b> </h3>
               <ul>
                  <li><b><?php echo esc_html__("Item Name:", 'contentomatic-article-builder-post-generator');?></b> <?php echo esc_html($uoptions['item_name']);?></li>
                  <li>
                     <b><?php echo esc_html__("Item ID:", 'contentomatic-article-builder-post-generator');?></b> <?php echo esc_html($uoptions['item_id']);?>
                  </li>
                  <li>
                     <b><?php echo esc_html__("Created At:", 'contentomatic-article-builder-post-generator');?></b> <?php echo esc_html($uoptions['created_at']);?>
                  </li>
                  <li>
                     <b><?php echo esc_html__("Buyer Name:", 'contentomatic-article-builder-post-generator');?></b> <?php echo esc_html($uoptions['buyer']);?>
                  </li>
                  <li>
                     <b><?php echo esc_html__("License Type:", 'contentomatic-article-builder-post-generator');?></b> <?php echo esc_html($uoptions['licence']);?>
                  </li>
                  <li>
                     <b><?php echo esc_html__("Supported Until:", 'contentomatic-article-builder-post-generator');?></b> <?php echo esc_html($uoptions['supported_until']);?>
                  </li>
               </ul>
               <?php
                  }
                  else
                  {
                  ?>
               <div class="notice notice-error is-dismissible"><p><?php echo esc_html__("Automatic updates for this plugin are disabled. Please activate the plugin from below, so you can benefit of automatic updates for it!", 'contentomatic-article-builder-post-generator');?></b></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo sprintf( wp_kses( __( 'Please input your Envato purchase code, to enable automatic updates in the plugin. To get your purchase code, please follow <a href="%s" target="_blank">this tutorial</a>. Info submitted to the registration server consists of: purchase code, site URL, site name, admin email. All these data will be used strictly for registration purposes.', 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//coderevolution.ro/knowledge-base/faq/how-do-i-find-my-items-purchase-code-for-plugin-license-activation/' ) );
                        ?>
                  </div>
               </div>
               <b><?php echo esc_html__("Register Envato Purchase Code To Enable Automatic Updates:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td><input type="text" name="<?php echo esc_html($plugin_slug);?>_register_code" value="" placeholder="<?php echo esc_html__("Envato Purchase Code", 'contentomatic-article-builder-post-generator');?>"></td>
         </tr>
         <tr>
            <td></td>
            <td><input type="submit" name="<?php echo esc_html($plugin_slug);?>_register" id="<?php echo esc_html($plugin_slug);?>_register" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Register Purchase Code", 'contentomatic-article-builder-post-generator');?>"/>
               <?php
                  }
                  ?>
            </td>
         </tr>
         <tr>
            <td>
               <hr/>
            </td>
            <td>
               <hr/>
            </td>
         </tr>
      <tr><td>
      <h3><?php echo esc_html__("Tips for using the plugin:", 'contentomatic-article-builder-post-generator');?></h3>
         <ul>
            <li><?php echo sprintf( wp_kses( __( 'Need help configuring this plugin? Please check out it\'s <a href="%s" target="_blank">video tutorial</a>.', 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.youtube.com/watch?v=PZcvwwnz2sE' ) );?>
            </li>
            <li><?php echo sprintf( wp_kses( __( 'Having issues with the plugin? Please be sure to check out our <a href="%s" target="_blank">knowledge-base</a> before you contact our support!', 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//coderevolution.ro/knowledge-base' ) );?></li>
            <li><?php echo sprintf( wp_kses( __( 'Do you enjoy our plugin? Please give it a <a href="%s" target="_blank">rating</a>  on CodeCanyon, or even more: <a href="%s" target="_blank">support our innovative plugin development on Patreon</a>', 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//codecanyon.net/downloads' ), esc_url( 'https://www.patreon.com/coderevolution' ) );?></a></li>
         </ul>
      </td></tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your ArticleBuilder User Name. Get one <a href='%s' target='_blank'>here</a>.", 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://paykstrt.com/7177/38910' ) );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red12"><a href='https://paykstrt.com/7177/38910' target='_blank'><?php echo esc_html__("ArticleBuilder User Name", 'contentomatic-article-builder-post-generator');?></a>:</b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" id="app_id" name="contentomatic_Main_Settings[app_id]" value="<?php
                     echo esc_html($app_id);
                     ?>" placeholder="<?php echo esc_html__("Please insert your ArticleBuilder User Name", 'contentomatic-article-builder-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your ArticleBuilder User Password. Get one <a href='%s' target='_blank'>here</a>.", 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://paykstrt.com/7177/38910' ) );
                           ?>
                     </div>
                  </div>
                  <b class="cr_red12"><a href='https://paykstrt.com/7177/38910' target='_blank'><?php echo esc_html__("ArticleBuilder User Password", 'contentomatic-article-builder-post-generator');?></a>:</b>
               </div>
            </td>
            <td>
               <div>
                  <input type="password" autocomplete="off" id="app_pass" name="contentomatic_Main_Settings[app_pass]" value="<?php
                     echo esc_html($app_pass);
                     ?>" placeholder="<?php echo esc_html__("Please insert your ArticleBuilder User Password", 'contentomatic-article-builder-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "If you wish to use Deepl for translation, you must enter first a Deepl 'Authentication Key'. Get one <a href='%s' target='_blank'>here</a>. If you enter a value here, new options will become available in the 'Automatically Translate Content To' and 'Source Language' fields.", 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.deepl.com/subscription.html' ) );
                           ?>
                     </div>
                  </div>
                  <b><a href="https://www.deepl.com/subscription.html" target="_blank"><?php echo esc_html__("Deepl Translator Authentication Key (Optional)", 'contentomatic-article-builder-post-generator');?>:</a></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="password" autocomplete="off" id="deepl_auth" placeholder="<?php echo esc_html__("Auth key (optional)", 'contentomatic-article-builder-post-generator');?>" name="contentomatic_Main_Settings[deepl_auth]" value="<?php
                     echo esc_html($deepl_auth);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td></td>
            <td><br/><input type="submit" name="btnSubmitApp" id="btnSubmitApp" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Info", 'contentomatic-article-builder-post-generator');?>"/>
            </td>
         </tr>
         <tr>
            <td>
               <hr/>
            </td>
            <td>
               <hr/>
            </td>
         </tr>
         <tr>
            <td>
               <h3><?php echo esc_html__("After you entered the API Key, you can start creating rules:", 'contentomatic-article-builder-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td><a name="newest" href="admin.php?page=contentomatic_items_panel">- <?php echo esc_html__("Unique Articles", 'contentomatic-article-builder-post-generator');?> -> <?php echo esc_html__("Blog Posts", 'contentomatic-article-builder-post-generator');?> -</a></td>
            <td>
               (<strong>ArticleBuilder API</strong>)
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Posts will be generated from the latest entries in ArticleBuilder's API response.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <hr/>
            </td>
            <td>
               <hr/>
            </td>
         </tr>
         <tr>
            <td>
               <h3><?php echo esc_html__("Plugin Options:", 'contentomatic-article-builder-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Check this to force the plugin not check generated posts in rule settings. Improves performance if you have 100k posts generated using this plugin.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php echo esc_html__("Do Not Check Generated Posts In Rule Settings:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
               <input type="checkbox" id="no_check" name="contentomatic_Main_Settings[no_check]"<?php
                  if ($no_check == 'on')
                      echo ' checked ';
                  ?>>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select a secret word that will be used when you run the plugin manually/by cron. See details about this below.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Secret Word Used For Manual/Cron Running:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <input type="text" id="secret_word" name="contentomatic_Main_Settings[secret_word]" value="<?php echo esc_html($secret_word);?>" placeholder="<?php echo esc_html__("Input a secret word", 'contentomatic-article-builder-post-generator');?>">
            </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <div>
                  <br/><b><?php echo esc_html__("If you want to schedule the cron event manually in your server, you should schedule this address:", 'contentomatic-article-builder-post-generator');?> <span class="cr_red"><?php if($secret_word != '') { echo get_site_url() . '/?run_contentomatic=' . $secret_word;} else { echo esc_html__('You must enter a secret word above, to use this feature.', 'contentomatic-article-builder-post-generator'); }?></span><br/><?php echo esc_html__("Example:", 'contentomatic-article-builder-post-generator');?> <span class="cr_red"><?php if($secret_word != '') { echo '15,45****wget -q -O /dev/null ' . get_site_url() . '/?run_contentomatic=' . $secret_word;} else { echo esc_html__('You must enter a secret word above, to use this feature.', 'contentomatic-article-builder-post-generator'); }?></span></b>
               </div>
               <br/><br/>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to show an extended information metabox under every plugin generated post.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Show Extended Item Information Metabox in Post:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="enable_metabox" name="contentomatic_Main_Settings[enable_metabox]"<?php
               if ($enable_metabox == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to enable logging for rules?", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Enable Logging for Rules:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="enable_logging" name="contentomatic_Main_Settings[enable_logging]" onclick="mainChanged()"<?php
               if ($enable_logging == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideLog">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to enable detailed logging for rules? Note that this will dramatically increase the size of the log this plugin generates.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Enable Detailed Logging for Rules:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideLog">
                  <input type="checkbox" id="enable_detailed_logging" name="contentomatic_Main_Settings[enable_detailed_logging]"<?php
                     if ($enable_detailed_logging == 'on')
                         echo ' checked ';
                     ?>>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideLog">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to automatically clear logs after a period of time.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Automatically Clear Logs After:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideLog">
                  <select id="auto_clear_logs" name="contentomatic_Main_Settings[auto_clear_logs]" >
                     <option value="No"<?php
                        if ($auto_clear_logs == "No") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Disabled", 'contentomatic-article-builder-post-generator');?></option>
                     <option value="monthly"<?php
                        if ($auto_clear_logs == "monthly") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Once a month", 'contentomatic-article-builder-post-generator');?></option>
                     <option value="weekly"<?php
                        if ($auto_clear_logs == "weekly") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Once a week", 'contentomatic-article-builder-post-generator');?></option>
                     <option value="daily"<?php
                        if ($auto_clear_logs == "daily") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Once a day", 'contentomatic-article-builder-post-generator');?></option>
                     <option value="twicedaily"<?php
                        if ($auto_clear_logs == "twicedaily") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Twice a day", 'contentomatic-article-builder-post-generator');?></option>
                     <option value="hourly"<?php
                        if ($auto_clear_logs == "hourly") {
                            echo " selected";
                        }
                        ?>><?php echo esc_html__("Once an hour", 'contentomatic-article-builder-post-generator');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the timeout (in seconds) for every rule running. I recommend that you leave this field at it's default value (3600).", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Timeout for Rule Running (seconds):", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" id="rule_timeout" step="1" min="0" class="cr_width_full" placeholder="<?php echo esc_html__("Input rule timeout in seconds", 'contentomatic-article-builder-post-generator');?>" name="contentomatic_Main_Settings[rule_timeout]" value="<?php
                     echo esc_html($rule_timeout);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to receive a summary of the rule running in an email.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Send Rule Running Summary in Email:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="send_email" name="contentomatic_Main_Settings[send_email]" onchange="mainChanged()"<?php
               if ($send_email == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideMail">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Input the email adress where you want to send the report. You can input more email addresses, separated by commas.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Email Address:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideMail">
                  <input type="email" id="email_address" placeholder="<?php echo esc_html__("Input a valid email adress", 'contentomatic-article-builder-post-generator');?>" name="contentomatic_Main_Settings[email_address]" value="<?php
                     echo esc_html($email_address);
                     ?>">
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <h3><?php echo esc_html__("Post Content Options:", 'contentomatic-article-builder-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you the plugin to generate new categories if the category does not already exist.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Do Not Generate Inexistent Categories for New Posts:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="new_category" name="contentomatic_Main_Settings[new_category]"<?php
               if ($new_category == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Do you want to automatically translate generated content using? This settings is overwritten if you define translation settings from within the importing rule settings. If you wish to use Deepl for translation, you must enter first a Deepl 'Authentication Key'. Get one <a href='%s' target='_blank'>here</a>.", 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.deepl.com/subscription.html' ) );
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Automatically Translate Content To (Global):", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <select id="translate" name="contentomatic_Main_Settings[translate]" >
                  <?php
                     $i = 0;
                     foreach ($language_names as $lang) {
                         echo '<option value="' . esc_html($language_codes[$i]) . '"';
                         if ($translate == $language_codes[$i]) {
                             echo ' selected';
                         }
                         echo '>' . esc_html($language_names[$i]) . '</option>';
                         $i++;
                     }
                     if($deepl_auth != '')
                     {
                         $i = 0;
                         foreach ($language_names_deepl as $lang) {
                             echo '<option value="' . esc_html($language_codes_deepl[$i]) . '"';
                             if ($translate == $language_codes_deepl[$i]) {
                                 echo ' selected';
                             }
                             echo '>' . esc_html($language_names_deepl[$i]) . '</option>';
                             $i++;
                         }
                     }
                     ?>
                  </select>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to automatically translate generated content using Google Translate? Here you can define the translation's source language. This settings is overwritten if you define translation settings from within the importing rule settings.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Translation Source Language (Global):", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <select id="translate_source" name="contentomatic_Main_Settings[translate_source]" >
                  <?php
                     $i = 0;
                     foreach ($language_names as $lang) {
                         echo '<option value="' . esc_html($language_codes[$i]) . '"';
                         if ($translate_source == $language_codes[$i]) {
                             echo ' selected';
                         }
                         echo '>' . esc_html($language_names[$i]) . '</option>';
                         $i++;
                     }
                     if($deepl_auth != '')
                     {
                         $i = 0;
                         foreach ($language_names_deepl as $lang) {
                             echo '<option value="' . esc_html($language_codes_deepl[$i]) . '"';
                             if ($translate == $language_codes_deepl[$i]) {
                                 echo ' selected';
                             }
                             echo '>' . esc_html($language_names_deepl[$i]) . '</option>';
                             $i++;
                         }
                     }
                     ?>
                  </select>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Choose if you want to import also posts that were not translated correctly - they will be imported in original language. If you check this, posts that failed translation will be not imported.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Skip Posts That Did Not Translate Correctly:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="skip_failed_tr" name="contentomatic_Main_Settings[skip_failed_tr]"<?php
               if ($skip_failed_tr == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to keep original link sources after translation? If you uncheck this, links will point to Google Translate version of the linked website.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Keep Original Link Source After Translation:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="no_link_translate" name="contentomatic_Main_Settings[no_link_translate]"<?php
               if ($no_link_translate == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div id="bestspin">
                  <p><?php echo esc_html__("Don't have an 'The Best Spinner' account yet? Click here to get one:", 'contentomatic-article-builder-post-generator');?> <b><a href="https://paykstrt.com/10313/38910" target="_blank"><?php echo esc_html__("get a new account now!", 'contentomatic-article-builder-post-generator');?></a></b></p>
               </div>
               <div id="wordai">
                  <p><?php echo esc_html__("Don't have an 'WordAI' account yet? Click here to get one:", 'contentomatic-article-builder-post-generator');?> <b><a href="https://wordai.com/?ref=h17f4" target="_blank"><?php echo esc_html__("get a new account now!", 'contentomatic-article-builder-post-generator');?></a></b></p>
               </div>
               <div id="spinrewriter">
                  <p><?php echo esc_html__("Don't have an 'SpinRewriter' account yet? Click here to get one:", 'contentomatic-article-builder-post-generator');?> <b><a href="https://www.spinrewriter.com/?ref=24b18" target="_blank"><?php echo esc_html__("get a new account now!", 'contentomatic-article-builder-post-generator');?></a></b></p>
               </div>
               <div id="spinnerchief">
                  <p><?php echo esc_html__("Don't have an 'SpinnerChief' account yet? Click here to get one:", 'contentomatic-article-builder-post-generator');?> <b><a href="http://www.whitehatbox.com/Agents/SSS?code=iscpuQScOZMi3vGFhPVBnAP5FyC6mPaOEshvgU4BbyoH8ftVRbM3uQ==" target="_blank"><?php echo esc_html__("get a new account now!", 'contentomatic-article-builder-post-generator');?></a></b></p>
              </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to randomize text by changing words of a text with synonyms using one of the listed methods? Note that this is an experimental feature and can in some instances drastically increase the rule running time!", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Spin Text Using Word Synonyms (for automatically generated posts only):", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <select id="spin_text" name="contentomatic_Main_Settings[spin_text]" onchange="mainChanged()">
            <option value="disabled"
               <?php
                  if ($spin_text == 'disabled') {
                      echo ' selected';
                  }
                  ?>
               ><?php echo esc_html__("Disabled", 'contentomatic-article-builder-post-generator');?></option>
            <option value="best"
               <?php
                  if ($spin_text == 'best') {
                      echo ' selected';
                  }
                  ?>
               >The Best Spinner - <?php echo esc_html__("High Quality - Paid", 'contentomatic-article-builder-post-generator');?></option>
            <option value="wordai"
               <?php
                  if($spin_text == 'wordai')
                          {
                              echo ' selected';
                          }
                  ?>
               >Wordai - <?php echo esc_html__("High Quality - Paid", 'contentomatic-article-builder-post-generator');?></option>
            <option value="spinrewriter"
               <?php
                  if($spin_text == 'spinrewriter')
                          {
                              echo ' selected';
                          }
                  ?>
               >SpinRewriter - <?php echo esc_html__("High Quality - Paid", 'contentomatic-article-builder-post-generator');?></option>
               <option value="spinnerchief"
               <?php
                  if($spin_text == 'spinnerchief')
                          {
                              echo ' selected';
                          }
                  ?>
               >SpinnerChief - <?php echo esc_html__("High Quality - Paid", 'contentomatic-article-builder-post-generator');?></option>
            <option value="builtin"
               <?php
                  if ($spin_text == 'builtin') {
                      echo ' selected';
                  }
                  ?>
               ><?php echo esc_html__("Built-in - Medium Quality - Free", 'contentomatic-article-builder-post-generator');?></option>
            <option value="wikisynonyms"
               <?php
                  if ($spin_text == 'wikisynonyms') {
                      echo ' selected';
                  }
                  ?>
               >WikiSynonyms - <?php echo esc_html__("Low Quality - Free", 'contentomatic-article-builder-post-generator');?></option>
            <option value="freethesaurus"
               <?php
                  if ($spin_text == 'freethesaurus') {
                      echo ' selected';
                  }
                  ?>
               >FreeThesaurus - <?php echo esc_html__("Low Quality - Free", 'contentomatic-article-builder-post-generator');?></option>
            </select>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to not spin title (only content)?", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Do Not Spin Title:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="checkbox" id="no_title_spin" name="contentomatic_Main_Settings[no_title_spin]"<?php
                     if ($no_title_spin == 'on')
                         echo ' checked ';
                     ?>>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Select a list of comma separated words that you do not wish to spin (only for built-in spinners).", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Excluded Word List (For Built-In Spinner Only):", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" name="contentomatic_Main_Settings[exclude_words]" value="<?php
                     echo esc_html($exclude_words);
                     ?>" placeholder="<?php echo esc_html__("word1, word2, word3", 'contentomatic-article-builder-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideBest">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert your user name on premium spinner service.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Premium Spinner Service User Name/Email:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideBest">
                  <input type="text" name="contentomatic_Main_Settings[best_user]" value="<?php
                     echo esc_html($best_user);
                     ?>" placeholder="<?php echo esc_html__("Please insert your premium text spinner service user name", 'contentomatic-article-builder-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideBest">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert your password for the selected premium spinner service.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Premium Spinner Service Password/API Key:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideBest">
                  <input type="password" autocomplete="off" name="contentomatic_Main_Settings[best_password]" value="<?php
                     echo esc_html($best_password);
                     ?>" placeholder="<?php echo esc_html__("Please insert your premium text spinner service password", 'contentomatic-article-builder-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <h3><?php echo esc_html__("Posting Restrictions:", 'contentomatic-article-builder-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the minimum word count for post titles. Items that have less than this count will not be published. To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Minimum Title Word Count (Skip Post Otherwise):", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" class="cr_width_full" id="min_word_title" step="1" placeholder="<?php echo esc_html__("Input the minimum word count for the title", 'contentomatic-article-builder-post-generator');?>" min="0" name="contentomatic_Main_Settings[min_word_title]" value="<?php
                     echo esc_html($min_word_title);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the maximum word count for post titles. Items that have more than this count will not be published. To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Maximum Title Word Count (Skip Post Otherwise):", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" id="max_word_title" class="cr_width_full" step="1" min="0" placeholder="<?php echo esc_html__("Input the maximum word count for the title", 'contentomatic-article-builder-post-generator');?>" name="contentomatic_Main_Settings[max_word_title]" value="<?php
                     echo esc_html($max_word_title);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the minimum word count for post content. Items that have less than this count will not be published. To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Minimum Content Word Count (Skip Post Otherwise):", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" id="min_word_content" class="cr_width_full" step="1" min="0" placeholder="<?php echo esc_html__("Input the minimum word count for the content", 'contentomatic-article-builder-post-generator');?>" name="contentomatic_Main_Settings[min_word_content]" value="<?php
                     echo esc_html($min_word_content);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Set the maximum word count for post content. Items that have more than this count will not be published. To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Maximum Content Word Count (Skip Post Otherwise):", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" id="max_word_content" class="cr_width_full" step="1" min="0" placeholder="<?php echo esc_html__("Input the maximum word count for the content", 'contentomatic-article-builder-post-generator');?>" name="contentomatic_Main_Settings[max_word_content]" value="<?php
                     echo esc_html($max_word_content);
                     ?>"/>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do not include posts that's title or content contains at least one of these words. Separate words by comma. To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Banned Words List:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <textarea rows="1" name="contentomatic_Main_Settings[banned_words]" placeholder="<?php echo esc_html__("Do not generate posts that contain at least one of these words", 'contentomatic-article-builder-post-generator');?>"><?php
               echo esc_textarea($banned_words);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do not include posts that's title or content does not contain at least one of these words. Separate words by comma. To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Required Words List:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <textarea rows="1" name="contentomatic_Main_Settings[required_words]" placeholder="<?php echo esc_html__("Do not generate posts unless they contain all of these words", 'contentomatic-article-builder-post-generator');?>"><?php
               echo esc_textarea($required_words);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="hideLog">
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Do you want to all words defined in the required words list? If you uncheck this, if only one word is found, the article will be published.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Require All Words in the 'Required Words List':", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div class="hideLog">
                  <input type="checkbox" id="require_all" name="contentomatic_Main_Settings[require_all]"<?php
                     if ($require_all == 'on')
                         echo ' checked ';
                     ?>>
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <h3><?php echo esc_html__("Featured Image Options:", 'contentomatic-article-builder-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Click this option if your want to set the featured image from the remote image location. This settings can save disk space, but beware that if the remote image gets deleted, your featured image will also be broken.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Do Not Copy Featured Image Locally:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <input type="checkbox" id="no_local_image" name="contentomatic_Main_Settings[no_local_image]"<?php
               if ($no_local_image == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Resize the image that was assigned to be the featured image to the width specified in this text field (in pixels). If you want to disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Featured Image Resize Width:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" min="1" step="1" class="cr_width_full" name="contentomatic_Main_Settings[resize_width]" value="<?php echo esc_html($resize_width);?>" placeholder="<?php echo esc_html__("Please insert the desired width for featured images", 'contentomatic-article-builder-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Resize the image that was assigned to be the featured image to the height specified in this text field (in pixels). If you want to disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Featured Image Resize Height:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="number" min="1" step="1" class="cr_width_full" name="contentomatic_Main_Settings[resize_height]" value="<?php echo esc_html($resize_height);?>" placeholder="<?php echo esc_html__("Please insert the desired height for featured images", 'contentomatic-article-builder-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <h3><?php echo esc_html__("Royalty Free Featured Image Importing Options:", 'contentomatic-article-builder-post-generator');?></h3>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your MorgueFile App ID. Register <a href='%s' target='_blank'>here</a>. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the MorgueFile API.", 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://morguefile.com/?mfr18=37077f5764c83cc98123ef1166ce2aa6" ),  esc_url( "https://morguefile.com/developer" ) );
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("MorgueFile App ID:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" name="contentomatic_Main_Settings[morguefile_api]" value="<?php
                     echo esc_html($morguefile_api);
                     ?>" placeholder="<?php echo esc_html__("Please insert your MorgueFile API key", 'contentomatic-article-builder-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your MorgueFile App Secret. Register <a href='%s' target='_blank'>here</a>. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the MorgueFile API.", 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://morguefile.com/?mfr18=37077f5764c83cc98123ef1166ce2aa6" ),  esc_url( "https://morguefile.com/developer" ) );
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("MorgueFile App Secret:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" name="contentomatic_Main_Settings[morguefile_secret]" value="<?php
                     echo esc_html($morguefile_secret);
                     ?>" placeholder="<?php echo esc_html__("Please insert your MorgueFile API Secret", 'contentomatic-article-builder-post-generator');?>">
               </div>
         <tr>
            <td colspan="2">
               <hr class="cr_dotted"/>
            </td>
         </tr>
         </td></tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your Pexels App ID. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the Pexels API.", 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://www.pexels.com/api/" ));
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Pexels App ID:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" name="contentomatic_Main_Settings[pexels_api]" value="<?php
                     echo esc_html($pexels_api);
                     ?>" placeholder="<?php echo esc_html__("Please insert your Pexels API key", 'contentomatic-article-builder-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <hr class="cr_dotted"/>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo sprintf( wp_kses( __( "Insert your Flickr App ID. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the Flickr API.", 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://www.flickr.com/services/apps/create/apply" ));
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Flickr App ID: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <input type="text" name="contentomatic_Main_Settings[flickr_api]" placeholder="<?php echo esc_html__("Please insert your Flickr APP ID", 'contentomatic-article-builder-post-generator');?>" value="<?php if(isset($flickr_api)){echo esc_html($flickr_api);}?>" class="cr_width_full" />
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("The license id for photos to be searched.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Photo License: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <select name="contentomatic_Main_Settings[flickr_license]" class="cr_width_full">
                  <option value="-1" 
                     <?php
                        if($flickr_license == '-1')
                        {
                            echo ' selected';
                        }
                        ?>
                     ><?php echo esc_html__("Do Not Search By Photo Licenses", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="0"
                     <?php
                        if($flickr_license == '0')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("All Rights Reserved", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="1"
                     <?php
                        if($flickr_license == '1')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution-NonCommercial-ShareAlike License", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="2"
                     <?php
                        if($flickr_license == '2')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution-NonCommercial License", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="3"
                     <?php
                        if($flickr_license == '3')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution-NonCommercial-NoDerivs License", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="4"
                     <?php
                        if($flickr_license == '4')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution License", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="5"
                     <?php
                        if($flickr_license == '5')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution-ShareAlike License", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="6"
                     <?php
                        if($flickr_license == '6')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Attribution-NoDerivs License", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="7"
                     <?php
                        if($flickr_license == '7')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("No known copyright restrictions", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="8"
                     <?php
                        if($flickr_license == '8')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("United States Government Work", 'contentomatic-article-builder-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("The order in which to sort returned photos. Deafults to date-posted-desc (unless you are doing a radial geo query, in which case the default sorting is by ascending distance from the point specified).", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Search Results Order: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <select name="contentomatic_Main_Settings[flickr_order]" class="cr_width_full">
                  <option value="date-posted-desc"
                     <?php
                        if($flickr_order == 'date-posted-desc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Date Posted Descendant", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="date-posted-asc"
                     <?php
                        if($flickr_order == 'date-posted-asc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Date Posted Ascendent", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="date-taken-asc"
                     <?php
                        if($flickr_order == 'date-taken-asc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Date Taken Ascendent", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="date-taken-desc"
                     <?php
                        if($flickr_order == 'date-taken-desc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Date Taken Descendant", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="interestingness-desc"
                     <?php
                        if($flickr_order == 'interestingness-desc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Interestingness Descendant", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="interestingness-asc"
                     <?php
                        if($flickr_order == 'interestingness-asc')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Interestingness Ascendant", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="relevance"
                     <?php
                        if($flickr_order == 'relevance')
                        {
                            echo ' selected';
                        }
                        ?>><?php echo esc_html__("Relevance", 'contentomatic-article-builder-post-generator');?></option>
               </select>
         <tr>
            <td colspan="2">
               <hr class="cr_dotted"/>
            </td>
         </tr>
         </td></tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo sprintf( wp_kses( __( "Insert your Pixabay App ID. Learn how to get one <a href='%s' target='_blank'>here</a>. If you enter an API Key here, you will enable search for images using the Pixabay API.", 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://pixabay.com/api/docs/" ) );
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Pixabay App ID:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <input type="text" name="contentomatic_Main_Settings[pixabay_api]" value="<?php
                     echo esc_html($pixabay_api);
                     ?>" placeholder="<?php echo esc_html__("Please insert your Pixabay API key", 'contentomatic-article-builder-post-generator');?>">
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Filter results by image type.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Image Types To Search:", 'contentomatic-article-builder-post-generator');?></b>
               </div>
            </td>
            <td>
               <div>
                  <select class="cr_width_full" name="contentomatic_Main_Settings[imgtype]" >
                     <option value='all'<?php
                        if ($imgtype == 'all')
                            echo ' selected';
                        ?>><?php echo esc_html__("All", 'contentomatic-article-builder-post-generator');?></option>
                     <option value='photo'<?php
                        if ($imgtype == 'photo')
                            echo ' selected';
                        ?>><?php echo esc_html__("Photo", 'contentomatic-article-builder-post-generator');?></option>
                     <option value='illustration'<?php
                        if ($imgtype == 'illustration')
                            echo ' selected';
                        ?>><?php echo esc_html__("Illustration", 'contentomatic-article-builder-post-generator');?></option>
                     <option value='vector'<?php
                        if ($imgtype == 'vector')
                            echo ' selected';
                        ?>><?php echo esc_html__("Vector", 'contentomatic-article-builder-post-generator');?></option>
                  </select>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Order results by a predefined rule.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Results Order: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <select name="contentomatic_Main_Settings[img_order]" class="cr_width_full">
                  <option value="popular"<?php
                     if ($img_order == "popular") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Popular", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="latest"<?php
                     if ($img_order == "latest") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Latest", 'contentomatic-article-builder-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Filter results by image category.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Category: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <select name="contentomatic_Main_Settings[img_cat]" class="cr_width_full">
                  <option value="all"<?php
                     if ($img_cat == "all") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("All", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="fashion"<?php
                     if ($img_cat == "fashion") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Fashion", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="nature"<?php
                     if ($img_cat == "nature") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Nature", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="backgrounds"<?php
                     if ($img_cat == "backgrounds") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Backgrounds", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="science"<?php
                     if ($img_cat == "science") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Science", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="education"<?php
                     if ($img_cat == "education") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Education", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="people"<?php
                     if ($img_cat == "people") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("People", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="feelings"<?php
                     if ($img_cat == "feelings") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Feelings", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="religion"<?php
                     if ($img_cat == "religion") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Religion", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="health"<?php
                     if ($img_cat == "health") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Health", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="places"<?php
                     if ($img_cat == "places") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Places", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="animals"<?php
                     if ($img_cat == "animals") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Animals", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="industry"<?php
                     if ($img_cat == "industry") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Industry", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="food"<?php
                     if ($img_cat == "food") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Food", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="computer"<?php
                     if ($img_cat == "computer") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Computer", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="sports"<?php
                     if ($img_cat == "sports") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Sports", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="transportation"<?php
                     if ($img_cat == "transportation") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Transportation", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="travel"<?php
                     if ($img_cat == "travel") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Travel", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="buildings"<?php
                     if ($img_cat == "buildings") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Buildings", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="business"<?php
                     if ($img_cat == "business") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Business", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="music"<?php
                     if ($img_cat == "music") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Music", 'contentomatic-article-builder-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Minimum image width.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Min Width: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <input type="number" min="1" step="1" name="contentomatic_Main_Settings[img_width]" value="<?php echo esc_html($img_width);?>" placeholder="<?php echo esc_html__("Please insert image min width", 'contentomatic-article-builder-post-generator');?>" class="cr_width_full">     
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Maximum image width.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Max Width: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <input type="number" min="1" step="1" name="contentomatic_Main_Settings[img_mwidth]" value="<?php echo esc_html($img_mwidth);?>" placeholder="<?php echo esc_html__("Please insert image max width", 'contentomatic-article-builder-post-generator');?>" class="cr_width_full">     
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("A flag indicating that only images suitable for all ages should be returned.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Safe Search: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <input type="checkbox" name="contentomatic_Main_Settings[img_ss]"<?php
                  if ($img_ss == 'on') {
                      echo ' checked="checked"';
                  }
                  ?> >
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Select images that have received an Editor's Choice award.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Editor\'s Choice: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <input type="checkbox" name="contentomatic_Main_Settings[img_editor]"<?php
                  if ($img_editor == 'on') {
                      echo ' checked="checked"';
                  }
                  ?> >
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Specify default language for regional content.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Filter Language: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <select name="contentomatic_Main_Settings[img_language]" class="cr_width_full">
                  <option value="any"<?php
                     if ($img_language == "any") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Any", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="en"<?php
                     if ($img_language == "en") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("English", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="cs"<?php
                     if ($img_language == "cs") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Czech", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="da"<?php
                     if ($img_language == "da") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Danish", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="de"<?php
                     if ($img_language == "de") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("German", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="es"<?php
                     if ($img_language == "es") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Spanish", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="fr"<?php
                     if ($img_language == "fr") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("French", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="id"<?php
                     if ($img_language == "id") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Indonesian", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="it"<?php
                     if ($img_language == "it") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Italian", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="hu"<?php
                     if ($img_language == "hu") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Hungarian", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="nl"<?php
                     if ($img_language == "nl") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Dutch", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="no"<?php
                     if ($img_language == "no") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Norvegian", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="pl"<?php
                     if ($img_language == "pl") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Polish", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="pt"<?php
                     if ($img_language == "pt") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Portuguese", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="ro"<?php
                     if ($img_language == "ro") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Romanian", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="sk"<?php
                     if ($img_language == "sk") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Slovak", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="fi"<?php
                     if ($img_language == "fi") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Finish", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="sv"<?php
                     if ($img_language == "sv") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Swedish", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="tr"<?php
                     if ($img_language == "tr") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Turkish", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="vi"<?php
                     if ($img_language == "vi") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Vietnamese", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="th"<?php
                     if ($img_language == "th") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Thai", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="bg"<?php
                     if ($img_language == "bg") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Bulgarian", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="ru"<?php
                     if ($img_language == "ru") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Russian", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="el"<?php
                     if ($img_language == "el") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Greek", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="ja"<?php
                     if ($img_language == "ja") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Japanese", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="ko"<?php
                     if ($img_language == "ko") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Korean", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="zh"<?php
                     if ($img_language == "zh") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Chinese", 'contentomatic-article-builder-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <hr class="cr_dotted"/>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Select if you want to enable direct scraping of Pixabay website. This will generate different results from the API.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Enable Pixabay Direct Website Scraping: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <input type="checkbox" name="contentomatic_Main_Settings[pixabay_scrape]"<?php
                  if ($pixabay_scrape == 'on') {
                      echo ' checked="checked"';
                  }
                  ?> >
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Filter results by image type.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Types To Search: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <select name="contentomatic_Main_Settings[scrapeimgtype]" class="cr_width_full">
                  <option value="all"<?php
                     if ($scrapeimgtype == "all") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("All", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="photo"<?php
                     if ($scrapeimgtype == "photo") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Photo", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="illustration"<?php
                     if ($scrapeimgtype == "illustration") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Illustration", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="vector"<?php
                     if ($scrapeimgtype == "vector") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Vector", 'contentomatic-article-builder-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Filter results by image orientation.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Orientation: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <select name="contentomatic_Main_Settings[scrapeimg_orientation]" class="cr_width_full">
                  <option value="all"<?php
                     if ($scrapeimg_orientation == "all") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("All", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="horizontal"<?php
                     if ($scrapeimg_orientation == "horizontal") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Horizontal", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="vertical"<?php
                     if ($scrapeimg_orientation == "vertical") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Vertical", 'contentomatic-article-builder-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Order results by a predefined rule.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Results Order: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <select name="contentomatic_Main_Settings[scrapeimg_order]" class="cr_width_full">
                  <option value="any"<?php
                     if ($scrapeimg_order == "any") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Any", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="popular"<?php
                     if ($scrapeimg_order == "popular") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Popular", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="latest"<?php
                     if ($scrapeimg_order == "latest") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Latest", 'contentomatic-article-builder-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Filter results by image category.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Category: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <select name="contentomatic_Main_Settings[scrapeimg_cat]" class="cr_width_full">
                  <option value="all"<?php
                     if ($scrapeimg_cat == "all") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("All", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="fashion"<?php
                     if ($scrapeimg_cat == "fashion") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Fashion", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="nature"<?php
                     if ($scrapeimg_cat == "nature") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Nature", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="backgrounds"<?php
                     if ($scrapeimg_cat == "backgrounds") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Backgrounds", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="science"<?php
                     if ($scrapeimg_cat == "science") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Science", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="education"<?php
                     if ($scrapeimg_cat == "education") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Education", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="people"<?php
                     if ($scrapeimg_cat == "people") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("People", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="feelings"<?php
                     if ($scrapeimg_cat == "feelings") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Feelings", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="religion"<?php
                     if ($scrapeimg_cat == "religion") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Religion", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="health"<?php
                     if ($scrapeimg_cat == "health") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Health", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="places"<?php
                     if ($scrapeimg_cat == "places") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Places", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="animals"<?php
                     if ($scrapeimg_cat == "animals") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Animals", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="industry"<?php
                     if ($scrapeimg_cat == "industry") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Industry", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="food"<?php
                     if ($scrapeimg_cat == "food") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Food", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="computer"<?php
                     if ($scrapeimg_cat == "computer") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Computer", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="sports"<?php
                     if ($scrapeimg_cat == "sports") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Sports", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="transportation"<?php
                     if ($scrapeimg_cat == "transportation") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Transportation", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="travel"<?php
                     if ($scrapeimg_cat == "travel") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Travel", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="buildings"<?php
                     if ($scrapeimg_cat == "buildings") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Buildings", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="business"<?php
                     if ($scrapeimg_cat == "business") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Business", 'contentomatic-article-builder-post-generator');?></option>
                  <option value="music"<?php
                     if ($scrapeimg_cat == "music") {
                         echo " selected";
                     }
                     ?>><?php echo esc_html__("Music", 'contentomatic-article-builder-post-generator');?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Minimum image width.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Min Width: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <input type="number" min="1" step="1" name="contentomatic_Main_Settings[scrapeimg_width]" value="<?php echo esc_html($scrapeimg_width);?>" placeholder="<?php echo esc_html__("Please insert image min width", 'contentomatic-article-builder-post-generator');?>" class="cr_width_full">     
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Maximum image height.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Image Min Height: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <input type="number" min="1" step="1" name="contentomatic_Main_Settings[scrapeimg_height]" value="<?php echo esc_html($scrapeimg_height);?>" placeholder="<?php echo esc_html__("Please insert image min height", 'contentomatic-article-builder-post-generator');?>" class="cr_width_full">     
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <hr class="cr_dotted"/>
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Please set a the image attribution shortcode value. You can use this value, using the %%image_attribution%% shortcode, in 'Prepend Content With' and 'Append Content With' settings fields. You can use the following shortcodes, in this settings field: %%image_source_name%%, %%image_source_website%%, %%image_source_url%%. These will be updated automatically for the respective image source, from where the imported image is from. This will replace the %%royalty_free_image_attribution%% shortcode, in 'Generated Post Content' settings field.", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Royalty Free Image Attribution Text (%%royalty_free_image_attribution%%): ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <input type="text" name="contentomatic_Main_Settings[attr_text]" value="<?php echo esc_html(stripslashes($attr_text));?>" placeholder="<?php echo esc_html__("Please insert image attribution text pattern", 'contentomatic-article-builder-post-generator');?>" class="cr_width_full">     
            </td>
         </tr>
         <tr>
            <td>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Do you want to enable broad search for royalty free images?", 'contentomatic-article-builder-post-generator');
                        ?>
                  </div>
               </div>
               <b><?php esc_html_e('Enable broad image search: ', 'contentomatic-article-builder-post-generator'); ?></b>
            </td>
            <td>
               <input type="checkbox" name="contentomatic_Main_Settings[bimage]" <?php
                  if ($bimage == 'on') {
                      echo 'checked="checked"';
                  }
                  ?> />
            </td>
         </tr>
         <tr>
            <td>
               <hr/>
            </td>
            <td>
               <hr/>
            </td>
         </tr>
         <tr>
            <td>
               <h3><?php echo esc_html__("Random Sentence Generator Settings:", 'contentomatic-article-builder-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("First List of Possible Sentences (%%random_sentence%%):", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <textarea rows="8" cols="70" name="contentomatic_Main_Settings[sentence_list]" placeholder="<?php echo esc_html__("Please insert the first list of sentences", 'contentomatic-article-builder-post-generator');?>"><?php
               echo esc_textarea($sentence_list);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Second List of Possible Sentences (%%random_sentence2%%):", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <textarea rows="8" cols="70" name="contentomatic_Main_Settings[sentence_list2]" placeholder="<?php echo esc_html__("Please insert the second list of sentences", 'contentomatic-article-builder-post-generator');?>"><?php
               echo esc_textarea($sentence_list2);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert some variables you wish to be exchanged for different instances of one sentence. Please format this list as follows:<br/>
                           Variablename => Variables (seperated by semicolon)<br/>Example:<br/>adjective => clever;interesting;smart;huge;astonishing;unbelievable;nice;adorable;beautiful;elegant;fancy;glamorous;magnificent;helpful;awesome<br/>", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("List of Possible Variables:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <textarea rows="8" cols="70" name="contentomatic_Main_Settings[variable_list]" placeholder="<?php echo esc_html__("Please insert the list of variables", 'contentomatic-article-builder-post-generator');?>"><?php
               echo esc_textarea($variable_list);
               ?></textarea>
            </div></td>
         </tr>
         <tr>
            <td>
               <hr/>
            </td>
            <td>
               <hr/>
            </td>
         </tr>
         <tr>
            <td>
               <h3><?php echo esc_html__("Custom HTML Code/ Ad Code:", 'contentomatic-article-builder-post-generator');?></h3>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert a custom HTML code that will replace the %%custom_html%% variable. This can be anything, even an Ad code.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Custom HTML Code #1:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <textarea rows="3" cols="70" name="contentomatic_Main_Settings[custom_html]" placeholder="<?php echo esc_html__("Custom HTML #1", 'contentomatic-article-builder-post-generator');?>"><?php
               echo esc_textarea($custom_html);
               ?></textarea>
            </div>
            </td>
         </tr>
         <tr>
            <td>
               <div>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                     <div class="bws_hidden_help_text cr_min_260px">
                        <?php
                           echo esc_html__("Insert a custom HTML code that will replace the %%custom_html2%% variable. This can be anything, even an Ad code.", 'contentomatic-article-builder-post-generator');
                           ?>
                     </div>
                  </div>
                  <b><?php echo esc_html__("Custom HTML Code #2:", 'contentomatic-article-builder-post-generator');?></b>
            </td>
            <td>
            <textarea rows="3" cols="70" name="contentomatic_Main_Settings[custom_html2]" placeholder="<?php echo esc_html__("Custom HTML #2", 'contentomatic-article-builder-post-generator');?>"><?php
               echo esc_textarea($custom_html2);
               ?></textarea>
            </div>
            </td>
         </tr>
      </table>
      <hr/>
      <h3><?php echo esc_html__("Affiliate Keyword Replacer Tool Settings:", 'contentomatic-article-builder-post-generator');?></h3>
      <div class="table-responsive">
         <table class="responsive table cr_main_table">
            <thead>
               <tr>
                  <th>
                     <?php echo esc_html__("ID", 'contentomatic-article-builder-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("This is the ID of the rule.", 'contentomatic-article-builder-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th class="cr_max_width_40">
                     <?php echo esc_html__("Del", 'contentomatic-article-builder-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Do you want to delete this rule?", 'contentomatic-article-builder-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Search Keyword", 'contentomatic-article-builder-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("This keyword will be replaced with a link you define.", 'contentomatic-article-builder-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Replacement Keyword", 'contentomatic-article-builder-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("This keyword will replace the search keyword you define. Leave this field blank if you only want to add an URL to the specified keyword.", 'contentomatic-article-builder-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Link to Add", 'contentomatic-article-builder-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Define the link you want to appear the defined keyword. Leave this field blank if you only want to replace the specified keyword without linking from it.", 'contentomatic-article-builder-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
                  <th>
                     <?php echo esc_html__("Target Content", 'contentomatic-article-builder-post-generator');?>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Select if you want to make this rule target post title, content or both.", 'contentomatic-article-builder-post-generator');
                              ?>
                        </div>
                     </div>
                  </th>
               </tr>
               <tr>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
               </tr>
            </thead>
            <tbody>
               <?php
                  echo contentomatic_expand_keyword_rules();
                  ?>
               <tr>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
               </tr>
               <tr>
                  <td class="cr_short_td">-</td>
                  <td class="cr_shrt_td2"><span class="cr_gray20">X</span></td>
                  <td class="cr_rule_line"><input type="text" name="contentomatic_keyword_list[keyword][]"  placeholder="<?php echo esc_html__("Please insert the keyword to be replaced", 'contentomatic-article-builder-post-generator');?>" value="" class="cr_width_100" /></td>
                  <td class="cr_rule_line"><input type="text" name="contentomatic_keyword_list[replace][]"  placeholder="<?php echo esc_html__("Please insert the keyword to replace the search keyword", 'contentomatic-article-builder-post-generator');?>" value="" class="cr_width_100" /></td>
                  <td class="cr_rule_line"><input type="url" validator="url" name="contentomatic_keyword_list[link][]" placeholder="<?php echo esc_html__("Please insert the link to be added to the keyword", 'contentomatic-article-builder-post-generator');?>" value="" class="cr_width_100" /></td>
                  <td class="cr_xoq">
                     <select id="contentomatic_keyword_target" name="contentomatic_keyword_list[target][]" class="cr_width_full">
                        <option value="content" selected><?php echo esc_html__("Content", 'contentomatic-article-builder-post-generator');?></option>
                        <option value="title"><?php echo esc_html__("Title", 'contentomatic-article-builder-post-generator');?></option>
                        <option value="both"><?php echo esc_html__("Content and Title", 'contentomatic-article-builder-post-generator');?></option>
                     </select>
                  </td>
               </tr>
            </tbody>
         </table>
         <hr/>
         <p>
            <?php echo esc_html__("Available shortcodes (the plugin also provides Gutenberg blocks for these shortcodes):", 'contentomatic-article-builder-post-generator');?> <strong>[contentomatic-list-posts]</strong> <?php echo esc_html__("to include a list that contains only posts imported by this plugin, and", 'contentomatic-article-builder-post-generator');?> <strong>[contentomatic-display-posts]</strong> <?php echo esc_html__("to include a WordPress like post listing. Usage:", 'contentomatic-article-builder-post-generator');?> [contentomatic-display-posts type='any/post/page/...' title_color='#ffffff' excerpt_color='#ffffff' read_more_text="Read More" order='ASC/DESC' orderby='title/ID/author/name/date/rand/comment_count' title_font_size='19px', excerpt_font_size='19px' posts_per_page=number_of_posts_to_show category='posts_category' ruleid='ID_of_contentomatic_rule' ruletype='0/1'].
            <br/><?php echo esc_html__("Example:", 'contentomatic-article-builder-post-generator');?> <b>[contentomatic-list-posts type='any' order='ASC' orderby='date' posts_per_page=50 category= '' ruleid='0' ruletype='0']</b>
            <br/><?php echo esc_html__("Example 2:", 'contentomatic-article-builder-post-generator');?> <b>[contentomatic-display-posts include_excerpt='true' image_size='thumbnail' wrapper='div' ruleid='0' ruletype='0']</b>.
         </p>
         <div>
            <p class="submit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'contentomatic-article-builder-post-generator');?>"/></p>
         </div>
</form>
</div>
</div>
<?php
   }
   if (isset($_POST['contentomatic_keyword_list'])) {
       add_action('admin_init', 'contentomatic_save_keyword_rules');
   }
   function contentomatic_save_keyword_rules($data2)
   {
       $data2 = $_POST['contentomatic_keyword_list'];
       $rules = array();
       if (isset($data2['keyword'][0])) {
           for ($i = 0; $i < sizeof($data2['keyword']); ++$i) {
               if (isset($data2['keyword'][$i]) && $data2['keyword'][$i] != '') {
                   $index         = trim(sanitize_text_field($data2['keyword'][$i]));
                   $rules[$index] = array(
                       trim(sanitize_text_field($data2['link'][$i])),
                       trim(sanitize_text_field($data2['replace'][$i])),
                       trim(sanitize_text_field($data2['target'][$i]))
                   );
               }
           }
       }
       update_option('contentomatic_keyword_list', $rules);
   }
   function contentomatic_expand_keyword_rules()
   {
       $rules  = get_option('contentomatic_keyword_list');
       $output = '';
       $cont   = 0;
       if (!empty($rules)) {
           foreach ($rules as $request => $value) {
               $output .= '<tr>
                           <td class="cr_short_td">' . esc_html($cont) . '</td>
                           <td class="cr_shrt_td2"><span class="wpcontentomatic-delete">X</span></td>
                           <td class="cr_rule_line"><input type="text" placeholder="' . esc_html__('Input the keyword to be replaced. This field is required', 'contentomatic-article-builder-post-generator') . '" name="contentomatic_keyword_list[keyword][]" value="' . esc_html($request) . '" required class="cr_width_100"></td>
                           <td class="cr_rule_line"><input type="text" placeholder="' . esc_html__('Input the replacement word', 'contentomatic-article-builder-post-generator') . '" name="contentomatic_keyword_list[replace][]" value="' . esc_html($value[1]) . '" class="cr_width_100"></td>
                           <td class="cr_rule_line"><input type="url" validator="url" placeholder="' . esc_html__('Input the URL to be added', 'contentomatic-article-builder-post-generator') . '" name="contentomatic_keyword_list[link][]" value="' . esc_html($value[0]) . '" class="cr_width_100"></td>';
                           if(isset($value[2]))
                           {
                               $target = $value[2];
                           }
                           else
                           {
                               $target = 'content';
                           }
                           $output .= '<td class="cr_xoq"><select id="contentomatic_keyword_target" name="contentomatic_keyword_list[target][]" class="cr_width_full">
                                     <option value="content"';
                           if ($target == "content") {
                               $output .= " selected";
                           }
                           $output .= '>' . esc_html__('Content', 'contentomatic-article-builder-post-generator') . '</option>
                           <option value="title"';
                           if ($target == "title") {
                               $output .=  " selected";
                           }
                           $output .= '>' . esc_html__('Title', 'contentomatic-article-builder-post-generator') . '</option>
                           <option value="both"';
                           if ($target == "both") {
                               $output .=  " selected";
                           }
                           $output .= '>' . esc_html__('Content and Title', 'contentomatic-article-builder-post-generator') . '</option>
                       </select></td>
   					</tr>';
               $cont++;
           }
       }
       return $output;
   }
   ?>