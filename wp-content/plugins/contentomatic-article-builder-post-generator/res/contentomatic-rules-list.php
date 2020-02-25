<?php
   function contentomatic_items_panel()
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
   $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
   if(isset($contentomatic_Main_Settings['app_id']) && $contentomatic_Main_Settings['app_id'] != '')
   {
   }
   else
   {
   ?>
<h1><?php echo esc_html__("You must add a ArticleBuilder API Key before you can use this feature!", 'contentomatic-article-builder-post-generator');?></h1>
<?php
   return;
   }
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
   <div>
      <form id="myForm" method="post" action="admin.php?page=contentomatic_items_panel">
         <?php
            wp_nonce_field('contentomatic_save_rules', '_contentomaticr_nonce');
            
            
            if (isset($_GET['settings-updated'])) {
            ?>
         <div>
            <p class="cr_saved_notif"><strong><?php echo esc_html__("Settings saved.", 'contentomatic-article-builder-post-generator');?></strong></p>
         </div>
         <?php
            }
            ?>
         <div>
            <div class="hideMain">
               <hr/>
               <div class="table-responsive">
                  <table id="mainRules" class="responsive table cr_main_table">
                     <thead>
                        <tr>
                           <th>
                              <?php echo esc_html__("ID", 'contentomatic-article-builder-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This is the ID of the rule. ", 'contentomatic-article-builder-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Article Niche", 'contentomatic-article-builder-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the niche of the article.", 'contentomatic-article-builder-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Schedule", 'contentomatic-article-builder-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       $unlocker = get_option('contentomatic_minute_running_unlocked', false);
                                       if($unlocker == '1')
                                       {
                                           echo esc_html__("Select the interval in minutes after which you want this rule to run. Defined in minutes.", 'contentomatic-article-builder-post-generator');
                                       }
                                       else
                                       {
                                           echo esc_html__("Select the interval in hours after which you want this rule to run. Defined in hours.", 'contentomatic-article-builder-post-generator');
                                       }
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Max # Posts", 'contentomatic-article-builder-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the maximum number of posts that this rule can create at once. 0-100 interval allowed.", 'contentomatic-article-builder-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("More Options", 'contentomatic-article-builder-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Shows advanced settings for this rule.", 'contentomatic-article-builder-post-generator');
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
                           <th class="cr_max_55">
                              <?php echo esc_html__("Active", 'contentomatic-article-builder-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Do you want to enable this rule? You can deactivate any rule (you don't have to delete them to deactivate them).", 'contentomatic-article-builder-post-generator');
                                       ?>
                                 </div>
                              </div>
                              <br/>
                              <input type="checkbox" onchange="thisonChangeHandler(this)" id="exclusion">
                           </th>
                           <th class="cr_max_42">
                              <?php echo esc_html__("Info", 'contentomatic-article-builder-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("The number of items (posts, pages) this rule has generated so far.", 'contentomatic-article-builder-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th class="cr_actions">
                              <?php echo esc_html__("Actions", 'contentomatic-article-builder-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Do you want to run this rule now? Note that only one instance of a rule is allowed at once.", 'contentomatic-article-builder-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                        </tr>
                        
                     </thead>
                     <tbody>
                        <?php
                           echo contentomatic_expand_rules_manual();
                           ?>
                        
                        <tr>
                           <td class="cr_width_70 cr_center">-</td>
                           <td class="cr_sz">
                              <select id="date" name="contentomatic_rules_list[date][]" class="cr_width_full">
                                 <option value="" disabled selected><?php echo esc_html__("Select an option", 'contentomatic-article-builder-post-generator');?></option> 
                                 <?php
                                    $cats = contentomatic_get_categories();
                                    if($cats !== false && isset($cats['category_list']) && is_array($cats['category_list']))
                                    {
                                        foreach($cats['category_list'] as $key => $cat)
                                        {
                                            echo'<option value="' . esc_attr($cat) . '">' . esc_html($cat) . '</option>';
                                        }
                                    }
                                    ?> 
                              </select>
                           </td>
                           <td class="cr_comm_td cr_center"><input type="number" step="1" min="1" name="contentomatic_rules_list[schedule][]" class="cr_width_full" placeholder="Select the rule schedule interval" value="24"/></td>
                           <td class="cr_comm_td cr_center"><input type="number" step="1" min="0" max="100" name="contentomatic_rules_list[max][]" placeholder="Select the max # of generated posts" value="10" class="cr_width_full"/></td>
                           <td class="cr_width_70">
                              <div class="cr_center">
                              <input type="button" id="mybtnfzr" value="Settings">
                              </div>
                              <div id="mymodalfzr" class="codemodalfzr">
                                 <div class="codemodalfzr-content">
                                    <div class="codemodalfzr-header">
                                       <span id="contentomatic_close" class="codeclosefzr">&times;</span>
                                       <h2><span class="cr_color_white"><?php echo esc_html__("New Rule", 'contentomatic-article-builder-post-generator');?></span> <?php echo esc_html__("Advanced Settings", 'contentomatic-article-builder-post-generator');?></h2>
                                    </div>
                                    <div class="codemodalfzr-body">
                                       <div class="table-responsive">
                                          <table class="responsive table cr_main_table_nowr">
                                          <tr>
                                             <td colspan="2">
                                                <h3><?php echo esc_html__("ArticleBuilder Advanced Settings:", 'contentomatic-article-builder-post-generator');?></h3>
                                             </td>
                                          </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the minimum word count for articles. If you do not specify a value for this field, the default value is 1000 words.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Minimum Article Word Count:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="300" step="100" max="1000" id="min_word" name="contentomatic_rules_list[min_word][]" value="1000" placeholder="Minimum article word count" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the maximum word count for articles. If you do not specify a value for this field, the default value is 1000 words.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Maximum Article Word Count:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="300" step="100" max="1000" id="max_word" name="contentomatic_rules_list[max_word][]" value="1000" placeholder="Maximum article word count" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to spin generated article using The Best Spinner?", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Spin Content:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="spin_content" name="contentomatic_rules_list[spin_content][]">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to spin phrases only from the article using The Best Spinner?", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Spin Phrases Only:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="spin_phrases" name="contentomatic_rules_list[spin_phrases][]">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to generate superspun content?", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Generate SuperSpun Content:", 'contentomatic-article-builder-post-generator');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select id="enable_superspun" name="contentomatic_rules_list[enable_superspun][]" class="cr_width_full">
                                                <option value="0" selected><?php echo esc_html__("UnSpun", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="1"><?php echo esc_html__("SuperSpun", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="2"><?php echo esc_html__("Extended SuperSpun", 'contentomatic-article-builder-post-generator');?></option>
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
                                                               echo esc_html__("Insert a comma separated list of subtopics relevant to your niche, for which the plugin should get articles.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Article Subtopics:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="text" id="query_string" name="contentomatic_rules_list[query_string][]" value="" placeholder="Insert a comma separated list of subtopics" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                              <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("With this feature you can replace the phrase \"weight loss\" in the blog posts with, say, \"fast weight loss\", or \"weight loss in Dallas, Texas\". The format is: [OldKeyword],[NewKeyword]. You can also use Spintax in content. Example: lose weight,{lose weight fast|burn fat fast|lose weight in Dallas, Texas}", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Custom Keyword Replacement:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="contentomatic_rules_list[kw_replace][]" value="" placeholder="Keyword replacement" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Make a LSI keyword replacement on the articles? Generated articles will be more unique.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Latent Semantic Indexing Replacement:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="enable_lsi" name="contentomatic_rules_list[enable_lsi][]">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select if you wish to also generate comments for imported posts.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Generate Comments For Posts:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="0" step="1" max="100" id="contentomatic_comments" name="contentomatic_rules_list[contentomatic_comments][]" value="" placeholder="Number of comments to import" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                             <td colspan="2">
                                                <h3><?php echo esc_html__("Generated Post Customizations:", 'contentomatic-article-builder-post-generator');?></h3>
                                             </td>
                                          </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the title of the generated posts for user rules. You can use the following shortcodes: %%random_sentence%%, %%random_sentence2%%, %%item_date%%, %%author%%, %%item_title%%, %%item_description%%, %%item_content%%, %%item_original_content%%, %%item_cat%%, %%item_tags%%", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Generated Post Title:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="contentomatic_rules_list[post_title][]" value="%%item_title%%" placeholder="Please insert your desired post title. Example: %%item_title%%" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the content of the generated posts for user rules. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%item_title%%, %%item_content%%, %%item_date%%, %%author%%, %%item_description%%, %%item_content_plain_text%%, %%item_original_content%%, %%royalty_free_image_attribution%%, %%item_image_URL%%, %%item_show_image%%", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Generated Post Content:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="contentomatic_rules_list[post_content][]" placeholder="Please insert your desired post content. Example: %%item_content%%" class="cr_width_full">%%item_content%%</textarea>
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the author that you want to assign for the automatically generated posts.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Author:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <select id="post_author" name="contentomatic_rules_list[post_author][]" class="cr_width_full">
                                                 <?php
                                                    $blogusers = get_users( [ 'role__in' => [ 'contributor', 'author', 'editor', 'administrator' ] ] );
                                                    foreach ($blogusers as $user) {
                                                        echo '<option value="' . esc_html($user->ID) . '"';
                                                        echo '>' . esc_html($user->display_name) . '</option>';
                                                    }
                                                    ?>
                                                 <option value="rand"><?php echo esc_html__("Random User", 'contentomatic-article-builder-post-generator');?></option>
                                              </select></div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the type (post/page) for your automatically generated item.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Item Type:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <select id="default_type" name="contentomatic_rules_list[default_type][]" class="cr_width_auto">
                                              <?php
                                                 $is_first = true;
                                                 foreach ( get_post_types( '', 'names' ) as $post_type ) {
                                                    echo '<option value="' . esc_attr($post_type) . '"';
                                                    if($is_first === true)
                                                    {
                                                        echo ' selected';
                                                        $is_first = false;
                                                    }
                                                    echo '>' . esc_html($post_type) . '</option>';
                                                 }
                                                 ?>
                                              </select>  </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the status that you want for the automatically generated posts to have.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Status:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <select id="submit_status" name="contentomatic_rules_list[submit_status][]" class="cr_width_70">
                                                     <option value="pending"><?php echo esc_html__("Pending -> Moderate", 'contentomatic-article-builder-post-generator');?></option>
                                                     <option value="draft"><?php echo esc_html__("Draft -> Moderate", 'contentomatic-article-builder-post-generator');?></option>
                                                     <option value="publish" selected><?php echo esc_html__("Published", 'contentomatic-article-builder-post-generator');?></option>
                                                     <option value="private"><?php echo esc_html__("Private", 'contentomatic-article-builder-post-generator');?></option>
                                                     <option value="trash"><?php echo esc_html__("Trash", 'contentomatic-article-builder-post-generator');?></option>
                                                  </select>  </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to limit the title's lenght to a specific word count? To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Limit Title Word Count:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="1" step="1" id="limit_title_word_count" name="contentomatic_rules_list[limit_title_word_count][]" value="" placeholder="Please insert a limit for title" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                             <td>
                                                <div>
                                                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                      <div class="bws_hidden_help_text cr_min_260px">
                                                         <?php
                                                            echo esc_html__("Run regex on post content. To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator');
                                                            ?>
                                                      </div>
                                                   </div>
                                                   <b><?php echo esc_html__("Run Regex On Content:", 'contentomatic-article-builder-post-generator');?></b>
                                             </td>
                                             <td>
                                             <textarea rows="1" class="cr_width_full" name="contentomatic_rules_list[strip_by_regex][]" placeholder="regex expression" class="cr_width_full"></textarea>
                                             </div>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                <div>
                                                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                      <div class="bws_hidden_help_text cr_min_260px">
                                                         <?php
                                                            echo esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank.", 'contentomatic-article-builder-post-generator');
                                                            ?>
                                                      </div>
                                                   </div>
                                                   <b><?php echo esc_html__("Replace Matches From Regex (Content):", 'contentomatic-article-builder-post-generator');?></b>
                                             </td>
                                             <td>
                                             <textarea rows="1" class="cr_width_full" name="contentomatic_rules_list[replace_regex][]" placeholder="regex replacement" class="cr_width_full"></textarea>
                                             </div>
                                             </td>
                                          </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to disable post excerpt generation?", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Disable Post Excerpt:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="disable_excerpt" name="contentomatic_rules_list[disable_excerpt][]">   
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("If your template supports 'Post Formats', than you can select one here. If not, leave this at it's default value.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Generated Post Format:", 'contentomatic-article-builder-post-generator');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select id="post_format" name="contentomatic_rules_list[post_format][]" class="cr_width_full">
                                                <option value="post-format-standard"  selected><?php echo esc_html__("Standard", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="post-format-aside"><?php echo esc_html__("Aside", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="post-format-gallery"><?php echo esc_html__("Gallery", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="post-format-link"><?php echo esc_html__("Link", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="post-format-image"><?php echo esc_html__("Image", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="post-format-quote"><?php echo esc_html__("Quote", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="post-format-status"><?php echo esc_html__("Status", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="post-format-video"><?php echo esc_html__("Video", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="post-format-audio"><?php echo esc_html__("Audio", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="post-format-chat"><?php echo esc_html__("Chat", 'contentomatic-article-builder-post-generator');?></option>
                                                </select>     
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the post category that you want for the automatically generated posts to have. To select more categories, hold down the CTRL key.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Additional Post Category:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <select multiple id="default_category" name="contentomatic_rules_list[default_category][]" class="cr_width_full">
                                                <option value="contentomatic_no_category_12345678" selected><?php echo esc_html__("Do Not Add a Category", 'contentomatic-article-builder-post-generator');?></option>
                                                <?php
                                                   $cat_args   = array(
                                                       'orderby' => 'name',
                                                       'hide_empty' => 0,
                                                       'order' => 'ASC'
                                                   );
                                                   $categories = get_categories($cat_args);
                                                   foreach ($categories as $category) {
                                                   ?>
                                                <option value="<?php
                                                   echo esc_html($category->term_id);
                                                   ?>"><?php
                                                   echo esc_html(sanitize_text_field($category->name)) . ' - ID ' . esc_html($category->term_id);
                                                   ?></option>
                                                <?php
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
                                                               echo esc_html__("Do you want to automatically add post categories from the News items?", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Auto Add Categories:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <select id="auto_categories" name="contentomatic_rules_list[auto_categories][]" class="cr_width_full">
                                                <option value="disabled" selected><?php echo esc_html__("Disabled", 'contentomatic-article-builder-post-generator');?></option>
                                                <option value="title"><?php echo esc_html__("Title", 'contentomatic-article-builder-post-generator');?></option>                  
                                                </div>
                                                </td>
                                             </tr>
                                             <tr><td>
                                             <div>
                                             <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                             <div class="bws_hidden_help_text cr_min_260px">
                                             <?php
                                                echo esc_html__("This feature will try to remove the WordPress's default post category. This may fail in case no additional categories are added, because WordPress requires at least one post category for every post.", 'contentomatic-article-builder-post-generator');
                                                ?>
                                             </div>
                                             </div>
                                             <b><?php echo esc_html__("Remove WP Default Post Category:", 'contentomatic-article-builder-post-generator');?></b>
                                             </td><td>
                                             <input type="checkbox" id="remove_default" name="contentomatic_rules_list[remove_default][]" checked>
                                             </div>
                                             </td></tr><tr><td>
                                             <div>
                                             <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                             <div class="bws_hidden_help_text cr_min_260px">
                                             <?php
                                                echo esc_html__("Do you want to automatically add post tags from the News items?", 'contentomatic-article-builder-post-generator');
                                                ?>
                                             </div>
                                             </div>
                                             <b><?php echo esc_html__("Auto Add Tags:", 'contentomatic-article-builder-post-generator');?></b>
                                             </td><td>
                                             <select id="auto_tags" name="contentomatic_rules_list[auto_tags][]" class="cr_width_full">
                                             <option value="disabled" selected><?php echo esc_html__("Disabled", 'contentomatic-article-builder-post-generator');?></option>
                                             <option value="title"><?php echo esc_html__("Title", 'contentomatic-article-builder-post-generator');?></option></select>                   
                                             </div>
                                             </td></tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the post tags that you want for the automatically generated posts to have.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Additional Post Tags:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="contentomatic_rules_list[default_tags][]" value="" placeholder="Please insert your additional post tags here" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to enable comments for the generated posts?", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Enable Comments For Posts:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="enable_comments" name="contentomatic_rules_list[enable_comments][]" checked>
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to enable pingbacks/trackbacks for the generated posts?", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Enable Pingback/Trackback:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="enable_pingback" name="contentomatic_rules_list[enable_pingback][]" checked>
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the custom fields that will be set for generated posts. The syntax for this field is the following: custom_field_name1 => custom_field_value1, custom_field_name2 => custom_field_value2, ... . In custom_field_valueX, you can use shortcodes, same like in post content. Example (without quotes): 'title_custom_field => %%item_title%%'. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%item_title%%, %%item_content%%, %%item_date%%, %%author%%, %%item_description%%, %%item_content_plain_text%%, %%item_original_content%%, %%royalty_free_image_attribution%%, %%item_image_URL%%, %%item_show_image%%", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Custom Fields:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" cols="70" name="contentomatic_rules_list[custom_fields][]" placeholder="Please insert your desired custom fields. Example: title_custom_field => %%item_title%%" class="cr_width_full"></textarea>
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the custom taxonomies that will be set for generated posts. The syntax for this field is the following: custom_taxonomy_name1 => custom_taxonomy_value1A, custom_taxonomy_value1B; custom_taxonomy_name2 => custom_taxonomy_value2A, custom_taxonomy_value2B; ... . In custom_taxonomy_valueX, you can use shortcodes. Example (without quotes): 'cats_taxonomy_field => %%item_title%%; tags_taxonomy_field => manualtax2, %%item_title%%'. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%item_title%%, %%item_content%%, %%item_date%%, %%author%%, %%item_description%%, %%item_content_plain_text%%, %%item_original_content%%, %%royalty_free_image_attribution%%, %%item_image_URL%%, %%item_show_image%%", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Post Custom Taxonomies:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <textarea rows="1" cols="70" name="contentomatic_rules_list[custom_tax][]" placeholder="Please insert your desired custom taxonomies. Example: custom_taxonomy_name => %%item_cats%%" class="cr_width_full"></textarea>
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to set featured image for generated post (to the first image that was found in the post)? If you don't check the 'Get Image From Pixabay' checkbox, this will work only when 'Get Full Content' is also checked.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Auto Get Royalty Free Image:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="royalty_free" name="contentomatic_rules_list[royalty_free][]" checked>
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                      <div class="bws_hidden_help_text cr_min_260px">
                                                         <?php
                                                            echo esc_html__("Insert a comma separated list of links to valid images that will be set randomly for the featured image for the posts that do not have a valid image attached or if you disabled automatical featured image generation. You can also use image numeric IDs from images found in the Media Gallery. To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator');
                                                            ?>
                                                      </div>
                                                   </div>
                                                   <b><?php echo esc_html__("Default Featured Image List:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                   <input class="cr_width_60p" type="text" name="contentomatic_rules_list[image_url][]" placeholder="Please insert the link to a valid image" id="cr_input_box"  value=""/>
                                                   <input class="cr_width_33p contentomatic_image_button" type="button" value=">>>"/>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to skip spinning/translating of posts generated by this rule?", 'contentomatic-article-builder-post-generator');?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Do Not Spin/Translate Posts Generated By This Rule:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="skip_spin_translate" name="contentomatic_rules_list[skip_spin_translate][]">               
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to automatically translate generated content using Google Translate? If set, this will overwrite the 'Automatically Translate Content To' option from plugin's 'Main Settings'.", 'contentomatic-article-builder-post-generator');?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Automatically Translate Content To:", 'contentomatic-article-builder-post-generator');?></b><br/><b><?php echo esc_html__("Info:", 'contentomatic-article-builder-post-generator');?></b> <?php echo esc_html__("for translation, the plugin also supports WPML.", 'contentomatic-article-builder-post-generator');?> <b><a href="https://wpml.org/?aid=238195&affiliate_key=ix3LsFyq0xKz" target="_blank"><?php echo esc_html__("Get WPML now!", 'contentomatic-article-builder-post-generator');?></a></b>
                                                </td>
                                                <td>
                                                <select id="translate" name="contentomatic_rules_list[rule_translate][]" >
                                                <?php
                                                   $i = 0;
                                                   foreach ($language_names as $lang) {
                                                       echo '<option value="' . esc_attr($language_codes[$i]) . '"';
                                                       if ($i == 0) {
                                                           echo ' selected';
                                                       }
                                                       echo '>' . esc_html($language_names[$i]) . '</option>';
                                                       $i++;
                                                   }
                                                   if(isset($contentomatic_Main_Settings['deepl_auth']) && $contentomatic_Main_Settings['deepl_auth'] != '')
                                                   {
                                                       $i = 0;
                                                       foreach ($language_names_deepl as $lang) {
                                                           echo '<option value="' . esc_attr($language_codes_deepl[$i]) . '"';
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
                                                         <div class="bws_hidden_help_text cr_min_260px"><?php echo esc_html__("Do you want to automatically translate generated content using Google Translate? Here you can define the translation's source language. If set, this will overwrite the 'Automatically Translate Content To' option from plugin's 'Main Settings'.", 'contentomatic-article-builder-post-generator');?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Translation Source Language:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <select id="translate" name="contentomatic_rules_list[rule_translate_source][]" >
                                                <?php
                                                   $i = 0;
                                                   foreach ($language_names as $lang) {
                                                       echo '<option value="' . esc_attr($language_codes[$i]) . '"';
                                                       if ($i == 0) {
                                                           echo ' selected';
                                                       }
                                                       echo '>' . esc_html($language_names[$i]) . '</option>';
                                                       $i++;
                                                   }
                                                   if(isset($contentomatic_Main_Settings['deepl_auth']) && $contentomatic_Main_Settings['deepl_auth'] != '')
                                                   {
                                                       $i = 0;
                                                       foreach ($language_names_deepl as $lang) {
                                                           echo '<option value="' . esc_attr($language_codes_deepl[$i]) . '"';
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
                                                               echo esc_html__("Input a short description for the current rule. This will appear in the help for for the current rule, next to rule's ID. This field is not used in plugin's activity and running.", 'contentomatic-article-builder-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Short Rule Description:", 'contentomatic-article-builder-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="text" id="rule_description" name="contentomatic_rules_list[rule_description][]" value="" placeholder="Input a description" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                          </table>
                                       </div>
                                    </div>
                                    <div class="codemodalfzr-footer">
                                       <br/>
                                       <h3 class="cr_inline">Contentomatic Automatic Post Generator</h3>
                                       <span id="contentomatic_ok" class="codeokfzr cr_inline">OK&nbsp;</span>
                                       <br/><br/>
                                    </div>
                                 </div>
                              </div>
                           </td>
                           <td class="cr_width_70 cr_center"><span class="cr_gray20">X</span></td>
                           <td class="cr_width_70 cr_center"><input type="checkbox" name="contentomatic_rules_list[active][]" value="1" checked />
                              <input type="hidden" name="contentomatic_rules_list[last_run][]" value="1988-01-27 00:00:00"/>
                           </td>
                           <td class="cr_width_70 cr_center">
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("No info.", 'contentomatic-article-builder-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </td>
                           <td class="cr_center">
                              <div>
                                 <img src="<?php
                                    echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'images/running.gif');
                                    ?>" alt="Running" class="cr_running">
                                 <div class="codemainfzr cr_gray_back">
                                    <select id="actions" class="actions" name="actions" disabled>
                                       <option value="select" disabled selected><?php echo esc_html__("Select an Action", 'contentomatic-article-builder-post-generator');?></option>
                                       <option value="run" onclick=""><?php echo esc_html__("Run This Rule Now", 'contentomatic-article-builder-post-generator');?></option>
                                       <option value="trash" onclick=""><?php echo esc_html__("Move All Posts To Trash", 'contentomatic-article-builder-post-generator');?></option>
                                       <option value="duplicate" onclick=""><?php echo esc_html__("Duplicate This Rule", 'contentomatic-article-builder-post-generator');?></option>
                                       <option value="delete" onclick=""><?php echo esc_html__("Permanently Delete All Posts", 'contentomatic-article-builder-post-generator');?></option>
                                    </select>
                                 </div>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <hr/>
         <div>
            <p class="submit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'contentomatic-article-builder-post-generator');?>"/></p>
         </div>
         <div>
            <a href="https://www.youtube.com/watch?v=5rbnu_uis7Y" target="_blank"><?php echo esc_html__("Nested Shortcodes also supported!", 'contentomatic-article-builder-post-generator');?></a><br/><?php echo esc_html__("Confused about rule running status icons?", 'contentomatic-article-builder-post-generator');?> <a href="http://coderevolution.ro/knowledge-base/faq/how-to-interpret-the-rule-running-visual-indicators-red-x-yellow-diamond-green-tick-from-inside-plugins/" target="_blank"><?php echo esc_html__("More info", 'contentomatic-article-builder-post-generator');?></a><br/>
            <div class="cr_none" id="midas_icons">
               <table>
                  <tr>
                     <td><img id="run_img" src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'images/running.gif');?>" alt="Running" title="status"></td>
                     <td><?php echo esc_html__("In Progress", 'contentomatic-article-builder-post-generator');?> - <b><?php echo esc_html__("Importing is Running", 'contentomatic-article-builder-post-generator');?></b></td>
                  </tr>
                  <tr>
                     <td><img id="ok_img" src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'images/ok.gif');?>" alt="OK"  title="status"></td>
                     <td><?php echo esc_html__("Success", 'contentomatic-article-builder-post-generator');?> - <b><?php echo esc_html__("New Posts Created", 'contentomatic-article-builder-post-generator');?></b></td>
                  </tr>
                  <tr>
                     <td><img id="fail_img" src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'images/failed.gif');?>" alt="Faield" title="status"></td>
                     <td><?php echo esc_html__("Failed", 'contentomatic-article-builder-post-generator');?> - <b><?php echo esc_html__("An Error Occurred.", 'contentomatic-article-builder-post-generator');?> <b><?php echo esc_html__("Please check 'Activity and Logging' plugin menu for details.", 'contentomatic-article-builder-post-generator');?></b></td>
                  </tr>
                  <tr>
                     <td><img id="nochange_img" src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'images/nochange.gif');?>" alt="NoChange" title="status"></td>
                     <td><?php echo esc_html__("No Change - No New Posts Created", 'contentomatic-article-builder-post-generator');?> - <b><?php echo esc_html__("Possible reasons:", 'contentomatic-article-builder-post-generator');?></b></td>
                  </tr>
                  <tr>
                     <td></td>
                     <td>
                        <ul>
                           <li>&#9658; <?php echo esc_html__("Already all posts are published that match your search and posts will be posted when new content will be available", 'contentomatic-article-builder-post-generator');?></li>
                           <li>&#9658; <?php echo esc_html__("Some restrictions you defined in the plugin's 'Main Settings'", 'contentomatic-article-builder-post-generator');?> <i>(<?php echo esc_html__("example: 'Minimum Content Word Count', 'Maximum Content Word Count', 'Minimum Title Word Count', 'Maximum Title Word Count', 'Banned Words List', 'Reuired Words List', 'Skip Posts Without Images'", 'contentomatic-article-builder-post-generator');?>)</i> <?php echo esc_html__("prevent posting of new posts.", 'contentomatic-article-builder-post-generator');?></li>
                        </ul>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
      </form>
   </div>
</div>
<?php
   }
   if (isset($_POST['contentomatic_rules_list'])) {
       add_action('admin_init', 'contentomatic_save_rules_manual');
   }
   
   function contentomatic_save_rules_manual($data2)
   {
       check_admin_referer('contentomatic_save_rules', '_contentomaticr_nonce');
       
       $data2 = $_POST['contentomatic_rules_list'];
       $rules = array();
       $cont  = 0;
       $cat_cont = 0;
       if (isset($data2['date'][0])) {
           for ($i = 0; $i < sizeof($data2['date']); ++$i) {
               $bundle = array();
               if (isset($data2['schedule'][$i]) && $data2['schedule'][$i] != '' && $data2['date'][$i] != '') {
                   $bundle[] = trim(sanitize_text_field($data2['limit_title_word_count'][$i]));
                   $bundle[] = trim(sanitize_text_field($data2['schedule'][$i]));
                   if (isset($data2['active'][$i])) {
                       $bundle[] = trim(sanitize_text_field($data2['active'][$i]));
                   } else {
                       $bundle[] = '0';
                   }
                   $bundle[]     = trim(sanitize_text_field($data2['last_run'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['submit_status'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['default_type'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['post_author'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['default_tags'][$i]));
                   if($i == sizeof($data2['schedule']) - 1)
                   {
                       if(isset($data2['default_category']))
                       {
                           $bundle[]     = $data2['default_category'];
                       }
                       else
                       {
                           if(!isset($data2['default_category' . $cat_cont]))
                           {
                               $cat_cont++;
                           }
                           if(!isset($data2['default_category' . $cat_cont]))
                           {
                               $bundle[]     = array('contentomatic_no_category_12345678');
                           }
                           else
                           {
                               $bundle[]     = $data2['default_category' . $cat_cont];
                           }
                       }
                   }
                   else
                   {
                       if(!isset($data2['default_category' . $cat_cont]))
                       {
                           $cat_cont++;
                       }
                       if(!isset($data2['default_category' . $cat_cont]))
                       {
                           $bundle[]     = array('contentomatic_no_category_12345678');
                       }
                       else
                       {
                           $bundle[]     = $data2['default_category' . $cat_cont];
                       }
                   }
                   $bundle[]     = trim(sanitize_text_field($data2['auto_categories'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['auto_tags'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['enable_comments'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['royalty_free'][$i]));
                   $bundle[]     = trim($data2['image_url'][$i]);
                   $bundle[]     = $data2['post_title'][$i];
                   $bundle[]     = $data2['post_content'][$i];
                   $bundle[]     = trim(sanitize_text_field($data2['enable_pingback'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['post_format'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['date'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['query_string'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['max'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['disable_excerpt'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['remove_default'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['skip_spin_translate'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['rule_translate'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['rule_translate_source'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['custom_fields'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['custom_tax'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['rule_description'][$i]));
                   $bundle[]     = trim($data2['strip_by_regex'][$i]);
                   $bundle[]     = trim($data2['replace_regex'][$i]);
                   $bundle[]     = trim(sanitize_text_field($data2['min_word'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['max_word'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['enable_lsi'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['enable_superspun'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['kw_replace'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['spin_content'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['spin_phrases'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['contentomatic_comments'][$i]));
                   $rules[$cont] = $bundle;
                   $cont++;
                   $cat_cont++;
               }
           }
       }
       update_option('contentomatic_rules_list', $rules, false);
   }
   function contentomatic_expand_rules_manual()
   {
       $cat_args   = array(
                   "orderby" => "name",
                   "hide_empty" => 0,
                   "order" => "ASC"
       );
       $categories = get_categories($cat_args);
       $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
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
           "Polish (Deepl)"
       );
       $language_codes_deepl = array(
           "EN-",
           "DE-",
           "FR-",
           "ES-",
           "IT-",
           "NL-",
           "PL-"
       );
       $GLOBALS['wp_object_cache']->delete('contentomatic_running_list', 'options');
       if (!get_option('contentomatic_running_list', false)) {
           $running = array();
       } else {
           $running = get_option('contentomatic_running_list');
       }
       
       $GLOBALS['wp_object_cache']->delete('contentomatic_rules_list', 'options');
       $rules  = get_option('contentomatic_rules_list');
       $output = '';
       $cont   = 0;
       if (!empty($rules)) {
           $posted_items = array();
           $counted_vals = array();
           if (isset($contentomatic_Main_Settings['no_check']) && $contentomatic_Main_Settings['no_check'] == 'on')
           {
           }
           else
           {
               $post_list = array();
               $postsPerPage = 50000;
               $paged = 0;
               do
               {
                   $postOffset = $paged * $postsPerPage;
                   $query = array(
                       'post_status' => array(
                           'publish',
                           'draft',
                           'pending',
                           'trash',
                           'private',
                           'future'
                       ),
                       'post_type' => array(
                           'any'
                       ),
                       'numberposts' => $postsPerPage,
                       'meta_key' => 'contentomatic_parent_rule',
                       'fields' => 'ids',
                       'offset'  => $postOffset
                   );
                   $got_me = get_posts($query);
                   $post_list = array_merge($post_list, $got_me);
                   $paged++;
               }while(!empty($got_me));
               wp_suspend_cache_addition(true);
               foreach ($post_list as $post) {
                   $rule_id = get_post_meta($post, 'contentomatic_parent_rule', true);
                   $exp = explode('-', $rule_id);
                   if(isset($exp[0]) && isset($exp[1]) && $exp[0] == '0')
                   {
                       $posted_items[] = $exp[1];
                   }
               }
               wp_suspend_cache_addition(false);
               $counted_vals = array_count_values($posted_items);
           }
           if(array_sum($counted_vals) > 100)
           {
               $get_me = get_option('contentomatic_rating_trigger', false);
               if($get_me === false)
               {
                   update_option('contentomatic_rating_trigger', '1');
               }
           }
           $unlocker = get_option('contentomatic_minute_running_unlocked', false);
           foreach ($rules as $request => $bundle[]) {
               if (isset($counted_vals[$cont])) {
                   $generated_posts = $counted_vals[$cont];
               } else {
                   $generated_posts = 0;
               }
               $bundle_values          = array_values($bundle);
               $myValues               = $bundle_values[$cont];
               $array_my_values        = array_values($myValues);for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}}
               $limit_title_word_count = $array_my_values[0];
               $schedule               = $array_my_values[1];
               $active                 = $array_my_values[2];
               $last_run               = $array_my_values[3];
               $status                 = $array_my_values[4];
               $def_type               = $array_my_values[5];
               $post_user_name         = $array_my_values[6];
               $default_tags           = $array_my_values[7];
               $default_category       = $array_my_values[8];
               $auto_categories        = $array_my_values[9];
               $auto_tags              = $array_my_values[10];
               $enable_comments        = $array_my_values[11];
               $royalty_free           = $array_my_values[12];
               $image_url              = $array_my_values[13];
               $post_title             = $array_my_values[14];
               $post_content           = $array_my_values[15];
               $enable_pingback        = $array_my_values[16];
               $post_format            = $array_my_values[17];
               $date                   = $array_my_values[18];
               $query_string           = $array_my_values[19];
               $max                    = $array_my_values[20];
               $disable_excerpt        = $array_my_values[21];
               $remove_default         = $array_my_values[22];
               $skip_spin_translate    = $array_my_values[23];
               $rule_translate         = $array_my_values[24];
               $rule_translate_source  = $array_my_values[25];
               $custom_fields          = $array_my_values[26];
               $custom_tax             = $array_my_values[27];
               $rule_description       = $array_my_values[28];
               $strip_by_regex         = $array_my_values[29];
               $replace_regex          = $array_my_values[30];
               $min_word               = $array_my_values[31];
               $max_word               = $array_my_values[32];
               $enable_lsi             = $array_my_values[33];
               $enable_superspun       = $array_my_values[34];
               $kw_replace             = $array_my_values[35];
               $spin_content           = $array_my_values[36];
               $spin_phrases           = $array_my_values[37];
               $contentomatic_comments = $array_my_values[38];
               wp_add_inline_script('contentomatic-footer-script', 'createAdmin(' . esc_html($cont) . ');', 'after');
               $output .= '<tr>
                           <td class="cr_short_td">' . esc_html($cont);
               if($rule_description != '')
               {
                   $output .= '&nbsp;<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px">' . esc_html__($rule_description, 'fbomatic-facebook-post-generator') . '</div></div>';
               }
               $output .= '</td>
                           <td class="cr_sz"><select id="date" name="contentomatic_rules_list[date][]" class="cr_width_full">';
           $cats = contentomatic_get_categories();
           if($cats !== false && isset($cats['category_list']) && is_array($cats['category_list']))
           {
               foreach($cats['category_list'] as $key => $cat)
               {
                   $output .= '<option value="' . esc_attr($cat) . '"';
                   if($date == $cat)
                   {
                       $output .= ' selected';
                   }
                   $output .= '>' . esc_html($cat) . '</option>';
               }
           }
   $output .= '</select></td>
   						<td class="cr_comm_td"><input type="number" step="1" min="1" placeholder="# h" name="contentomatic_rules_list[schedule][]" value="' . esc_attr($schedule) . '" class="cr_width_full" required></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="0" placeholder="# max" max="100" name="contentomatic_rules_list[max][]" value="' . esc_attr($max) . '"  class="cr_width_full" required></td>
                       <td class="cr_width_70">
                       <div class="cr_center"><input type="button" id="mybtnfzr' . esc_html($cont) . '" value="Settings"></div>
                       <div id="mymodalfzr' . esc_html($cont) . '" class="codemodalfzr">
     <div class="codemodalfzr-content">
       <div class="codemodalfzr-header">
         <span id="contentomatic_close' . esc_html($cont) . '" class="codeclosefzr">&times;</span>
         <h2>' . esc_html__('Rule', 'contentomatic-article-builder-post-generator') . ' <span class="cr_color_white">ID ' . esc_html($cont) . '</span> ' . esc_html__('Advanced Settings', 'contentomatic-article-builder-post-generator') . '</h2>
       </div>
       <div class="codemodalfzr-body">
       <div class="table-responsive">
         <table class="responsive table cr_main_table_nowr">
         <tr><td colspan="2">
       <h3>' . esc_html__("ArticleBuilder Advanced Settings:", 'contentomatic-article-builder-post-generator') . '</h3></td></tr>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the minimum word count for articles. If you do not specify a value for this field, the default value is 1000 words.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Minimum Article Word Count", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="number" min="300" step="100" max="1000"  id="min_word" name="contentomatic_rules_list[min_word][]" value="' . esc_attr($min_word) . '" placeholder="Minimum article word count" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the maximum word count for articles. If you do not specify a value for this field, the default value is 1000 words.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Maximum Article Word Count", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="number" min="300" step="100" max="1000"  id="max_word" name="contentomatic_rules_list[max_word][]" value="' . esc_attr($max_word) . '" placeholder="Maximum article word count" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to spin the generated article using The Best Spinner?", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Spin Content", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="spin_content" name="contentomatic_rules_list[spin_content][]"';
               if ($spin_content == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to spin phrases only from the article using The Best Spinner?", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Spin Phrases Only", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="spin_phrases" name="contentomatic_rules_list[spin_phrases][]"';
               if ($spin_phrases == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__('Do you want to generate superspun content?', 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Generate SuperSpun Content", 'contentomatic-article-builder-post-generator') . ':</b>   
                       </td><td>
                       <select id="enable_superspun" name="contentomatic_rules_list[enable_superspun][]" class="cr_width_full">
                       <option value="0"';
               if ($enable_superspun == '0') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("UnSpun", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="1"';
               if ($enable_superspun == '1') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("SuperSpun", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="2"';
               if ($enable_superspun == '2') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Extended SuperSpun", 'contentomatic-article-builder-post-generator') . '</option>
                   </select>     
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Insert a comma separated list of subtopics relevant to your niche, for which the plugin should get articles.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Article Subtopics", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="text" id="query_string" name="contentomatic_rules_list[query_string][]" value="' . esc_attr($query_string) . '" placeholder="Insert a comma separated list of subtopics" class="cr_width_full">
                           
           </div>
           <tr><td class="cr_min_width_200">
       <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("With this feature you can replace the phrase \"weight loss\" in the blog posts with, say, \"fast weight loss\", or \"weight loss in Dallas, Texas\". The format is: [OldKeyword],[NewKeyword]. You can also use Spintax in content. Example: lose weight,{lose weight fast|burn fat fast|lose weight in Dallas, Texas}", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Custom Keyword Replacement", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="text" name="contentomatic_rules_list[kw_replace][]" value="' . htmlspecialchars($kw_replace) . '" placeholder="Keyword replacement" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Make a LSI keyword replacement on the articles? Generated articles will be more unique.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Latent Semantic Indexing Replacement", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="enable_lsi" name="contentomatic_rules_list[enable_lsi][]"';
               if ($enable_lsi == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select if you wish to also generate comments for imported posts.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Generate Comments For Posts", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="number" min="0" step="1" max="100"  id="contentomatic_comments" name="contentomatic_rules_list[contentomatic_comments][]" value="' . esc_attr($contentomatic_comments) . '" placeholder="Number of comments to import" class="cr_width_full">
                           
           </div>
           </td></tr>
       <tr><td colspan="2">
       <h3>' . esc_html__("Generated Post Customizations:", 'contentomatic-article-builder-post-generator') . '</h3></td></tr>
       <tr><td class="cr_min_width_200">
       <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the title of the generated posts for user rules. You can use the following shortcodes:  %random_sentence%%, %%random_sentence2%%, %%item_title%%, %%author%%, %%item_description%%, %%item_content%%, %%item_original_content%%, %%item_cat%%, %%item_tags%%", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Generated Post Title", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="text" name="contentomatic_rules_list[post_title][]" value="' . htmlspecialchars($post_title) . '" placeholder="Please insert your desired post title. Example: %%item_title%%" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the content of the generated posts for user rules. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%item_title%%, %%item_content%%, %%item_date%%, %%author%%, %%item_description%%, %%item_content_plain_text%%, %%item_original_content%%, %%royalty_free_image_attribution%%, %%item_image_URL%%, %%item_show_image%%", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Generated Post Content", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <textarea rows="2" cols="70" name="contentomatic_rules_list[post_content][]" placeholder="Please insert your desired post content. Example:%%item_content%%" class="cr_width_full">' . htmlspecialchars($post_content) . '</textarea>
                           
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the author that you want to assign for the automatically generated posts.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Author", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <select id="post_author" name="contentomatic_rules_list[post_author][]" class="cr_width_full">';
               $blogusers = get_users( [ 'role__in' => [ 'contributor', 'author', 'editor', 'administrator' ] ] );
               foreach ($blogusers as $user) {
                   $output .= '<option value="' . esc_html($user->ID) . '"';
                   if ($post_user_name == $user->ID) {
                       $output .= " selected";
                   }
                   $output .= '>' . esc_html($user->display_name) . '</option>';
               }
               $output .= '<option value="rand"';
               if ($post_user_name == "rand") {
                       $output .= " selected";
                   }
               $output .= '>' . esc_html__("Random User", 'contentomatic-article-builder-post-generator') . '</option>';
               $output .= '</select>   
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the type (post/page) for your automatically generated item.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Item Type", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <select id="default_type" name="contentomatic_rules_list[default_type][]" class="cr_width_auto">';
               foreach ( get_post_types( '', 'names' ) as $post_type ) {
                  $output .= '<option value="' . esc_attr($post_type) . '"';
                  if ($def_type == $post_type) {
                       $output .= ' selected';
                   }
                  $output .= '>' . esc_html($post_type) . '</option>';
               }
               $output .= '</select>  
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the status that you want for the automatically generated posts to have.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Status", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <select id="submit_status" name="contentomatic_rules_list[submit_status][]" class="cr_width_70">
                                     <option value="pending"';
               if ($status == 'pending') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Pending -> Moderate", 'contentomatic-article-builder-post-generator') . '</option>
                                     <option value="draft"';
               if ($status == 'draft') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Draft -> Moderate", 'contentomatic-article-builder-post-generator') . '</option>
                                     <option value="publish"';
               if ($status == 'publish') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Published", 'contentomatic-article-builder-post-generator') . '</option>
                                     <option value="private"';
               if ($status == 'private') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Private", 'contentomatic-article-builder-post-generator') . '</option>
                                     <option value="trash"';
               if ($status == 'trash') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Trash", 'contentomatic-article-builder-post-generator') . '</option>
                       </select>
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to limit the title's lenght to a specific word count? To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Limit Title Word Count", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="number" min="1" step="1" id="limit_title_word_count" name="contentomatic_rules_list[limit_title_word_count][]" value="' . esc_attr($limit_title_word_count) . '" placeholder="Please insert a title limit count" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Run regex on post content. To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Run Regex On Content", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <textarea rows="1" class="cr_width_full" name="contentomatic_rules_list[strip_by_regex][]" placeholder="regex" class="cr_width_full">' . esc_textarea($strip_by_regex) . '</textarea>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Replace the above regex matches with this regex expression. If you want to strip matched content, leave this field blank.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Replace Matches From Regex (Content)", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <textarea rows="1" class="cr_width_full" name="contentomatic_rules_list[replace_regex][]" placeholder="regex replacement" class="cr_width_full">' . esc_textarea($replace_regex) . '</textarea>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to disable post excerpt generation?", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Disable Post Excerpt", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="disable_excerpt" name="contentomatic_rules_list[disable_excerpt][]"';
               if ($disable_excerpt == '1') {
                   $output .= ' checked';
               }
               $output .= '>   
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__('If your template supports "Post Formats", than you can select one here. If not, leave this at it\'s default value.', 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Generated Post Format", 'contentomatic-article-builder-post-generator') . ':</b>   
                       </td><td>
                       <select id="post_format" name="contentomatic_rules_list[post_format][]" class="cr_width_full">
                       <option value="post-format-standard"';
               if ($post_format == 'post-format-standard') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Standard", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="post-format-aside"';
               if ($post_format == 'post-format-aside') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Aside", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="post-format-gallery"';
               if ($post_format == 'post-format-gallery') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Gallery", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="post-format-link"';
               if ($post_format == 'post-format-link') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Link", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="post-format-image"';
               if ($post_format == 'post-format-image') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Image", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="post-format-quote"';
               if ($post_format == 'post-format-quote') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Quote", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="post-format-status"';
               if ($post_format == 'post-format-status') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Status", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="post-format-video"';
               if ($post_format == 'post-format-video') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Video", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="post-format-audio"';
               if ($post_format == 'post-format-audio') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Audio", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="post-format-chat"';
               if ($post_format == 'post-format-chat') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Chat", 'contentomatic-article-builder-post-generator') . '</option>
                   </select>     
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the post category that you want for the automatically generated posts to have. To select more categories, hold down the CTRL key.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Additional Post Category", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <select multiple class="cr_width_full" id="default_category" name="contentomatic_rules_list[default_category' . esc_html($cont) . '][]">
                       <option value="contentomatic_no_category_12345678"';
                       if(!is_array($default_category))
                       {
                           $default_category = array();
                       }
                       foreach($default_category as $dc)
                       {
                           if ("contentomatic_no_category_12345678" == $dc) {
                               $output .= ' selected';
                           }
                       }
                       $output .= '>' . esc_html__("Do Not Add a Category", 'contentomatic-article-builder-post-generator') . '</option>';
               foreach ($categories as $category) {
                   $output .= '<option value="' . esc_attr($category->term_id) . '"';
                   foreach($default_category as $dc)
                   {
                       if ($category->term_id == $dc) {
                           $output .= ' selected';
                       }
                   }
                   
                   $output .= '>' . sanitize_text_field($category->name) . ' - ID: ' . esc_html($category->term_id) . '</option>';
               }
               $output .= '</select>     
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to automatically add post categories, from the feed items?", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Auto Add Categories", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td> 
                       <select id="auto_categories" name="contentomatic_rules_list[auto_categories][]" class="cr_width_full">
                       <option value="disabled"';
               if ($auto_categories == 'disabled') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Disabled", 'contentomatic-article-builder-post-generator') . '</option>
               <option value="title"';
               if ($auto_categories == 'title') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Title", 'contentomatic-article-builder-post-generator') . '</option></select>              
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("This feature will try to remove the WordPress\'s default post category. This may fail in case no additional categories are added, because WordPress requires at least one post category for every post.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Remove WP Default Post Category", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="remove_default" name="contentomatic_rules_list[remove_default][]"';
           if($remove_default == '1')
           {
               $output .= ' checked';
           }
           $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to automatically add post tags from the feed items?", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Auto Add Tags", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <select id="auto_tags" name="contentomatic_rules_list[auto_tags][]" class="cr_width_full">
                       <option value="disabled"';
               if ($auto_tags == 'disabled') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Disabled", 'contentomatic-article-builder-post-generator') . '</option>
                       <option value="title"';
               if ($auto_tags == 'title') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Title", 'contentomatic-article-builder-post-generator') . '</option>';
               $output .= '</select>        
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the post tags that you want for the automatically generated posts to have.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Additional Post Tags", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input class="cr_width_full" type="text" name="contentomatic_rules_list[default_tags][]" value="' . esc_attr($default_tags) . '" placeholder="Please insert your additional post tags here" >
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to enable comments for the generated posts?", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Enable Comments For Posts", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="enable_comments" name="contentomatic_rules_list[enable_comments][]"';
               if ($enable_comments == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to enable pingbacks and trackbacks for the generated posts?", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Enable Pingback/Trackback", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="enable_pingback" name="contentomatic_rules_list[enable_pingback][]"';
               if ($enable_pingback == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the custom fields that will be set for generated posts. The syntax for this field is the following: custom_field_name1 => custom_field_value1, custom_field_name2 => custom_field_value2, ... . In custom_field_valueX, you can use shortcodes, same like in post content. Example (without quotes): \'title_custom_field => %%item_title%%\'. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%item_title%%, %%item_content%%, %%item_date%%, %%author%%, %%item_description%%, %%item_content_plain_text%%, %%item_original_content%%, %%royalty_free_image_attribution%%, %%item_image_URL%%, %%item_show_image%%", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Custom Fields", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <textarea rows="1" cols="70" name="contentomatic_rules_list[custom_fields][]" placeholder="Please insert your desired custom fields. Example: title_custom_field => %%item_title%%" class="cr_width_full">' . esc_textarea($custom_fields) . '</textarea>
                           
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the custom taxonomies that will be set for generated posts. The syntax for this field is the following: custom_taxonomy_name1 => custom_taxonomy_value1A, custom_taxonomy_value1B; custom_taxonomy_name2 => custom_taxonomy_value2A, custom_taxonomy_value2B; ... . In custom_taxonomy_valueX, you can use shortcodes. Example (without quotes): \'cats_taxonomy_field => %%item_title%%; tags_taxonomy_field => manualtax2, %%item_title%%\'. You can use the following shortcodes: %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%item_title%%, %%item_content%%, %%item_date%%, %%author%%, %%item_description%%, %%item_content_plain_text%%, %%item_original_content%%, %%royalty_free_image_attribution%%, %%item_image_URL%%, %%item_show_image%%", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Post Custom Taxonomies", 'contentomatic-article-builder-post-generator') . ':</b>
                       </td><td>
                           <textarea rows="1" cols="70" name="contentomatic_rules_list[custom_tax][]" placeholder="Please insert your desired custom taxonomies. Example: custom_taxonomy_name => %%item_cats%%" class="cr_width_full">' . esc_textarea($custom_tax) . '</textarea>
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to set featured image for generated post (to the first image that was found in the post)? This works only when \'Get Full Content\' is also checked.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Auto Get Royalty Free Image", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="royalty_free" name="contentomatic_rules_list[royalty_free][]"';
               if ($royalty_free == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Insert a comma separated list of links to valid images that will be set randomly for the featured image for the posts that do not have a valid image attached or if you disabled automatical featured image generation. You can also use image numeric IDs from images found in the Media Gallery. To disable this feature, leave this field blank.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Default Featured Image List", 'contentomatic-article-builder-post-generator') . ':</b>
                       </td><td>
                       <input class="cr_width_full" type="text" name="contentomatic_rules_list[image_url][]" placeholder="Please insert the link to a valid image" value="' . esc_attr($image_url) . '"/>
                       
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to skip spinning/traslating of posts generated by this rule?", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Do Not Spin/Translate Posts Generated By This Rule", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="skip_spin_translate" name="contentomatic_rules_list[skip_spin_translate][]"';
           if($skip_spin_translate == '1')
           {
               $output .= ' checked';
           }
           $output .= '>               
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to automatically translate generated content using Google Translate? If set, this will overwrite the \'Automatically Translate Content To\' option from plugin\'s \'Main Settings\'.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Automatically Translate Content To", 'contentomatic-article-builder-post-generator') . ':</b><br/><b>' . esc_html__("Info:", 'contentomatic-article-builder-post-generator') . '</b> ' . esc_html__("for translation, the plugin also supports WPML.", 'contentomatic-article-builder-post-generator') . ' <b><a href="https://wpml.org/?aid=238195&affiliate_key=ix3LsFyq0xKz" target="_blank">' . esc_html__("Get WPML now!", 'contentomatic-article-builder-post-generator') . '</a></b>
                       
                       </td><td>
                       <select id="translate" name="contentomatic_rules_list[rule_translate][]" >';
       $i = 0;
       foreach ($language_names as $lang) {
           $output .= '<option value="' . esc_attr($language_codes[$i]) . '"';
           if ($rule_translate == $language_codes[$i]) {
               $output .= ' selected';
           }
           $output .= '>' . esc_html($language_names[$i]) . '</option>';
           $i++;
       }
       if(isset($contentomatic_Main_Settings['deepl_auth']) && $contentomatic_Main_Settings['deepl_auth'] != '')
       {
           $i = 0;
           foreach ($language_names_deepl as $lang) {
               $output .= '<option value="' . esc_attr($language_codes_deepl[$i]) . '"';
               if ($rule_translate == $language_codes_deepl[$i]) {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html($language_names_deepl[$i]) . '</option>';
               $i++;
           }
       }
               $output .= '</select>               
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to automatically translate generated content using Google Translate? Here you can define the translation\'s source language. If set, this will overwrite the \'Automatically Translate Content To\' option from plugin\'s \'Main Settings\'.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Translation Source Language", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <select id="translate" name="contentomatic_rules_list[rule_translate_source][]" >';
       $i = 0;
       foreach ($language_names as $lang) {
           $output .= '<option value="' . esc_attr($language_codes[$i]) . '"';
           if ($rule_translate_source == $language_codes[$i]) {
               $output .= ' selected';
           }
           $output .= '>' . esc_html($language_names[$i]) . '</option>';
           $i++;
       }
       if(isset($contentomatic_Main_Settings['deepl_auth']) && $contentomatic_Main_Settings['deepl_auth'] != '')
       {
           $i = 0;
           foreach ($language_names_deepl as $lang) {
               $output .= '<option value="' . esc_attr($language_codes_deepl[$i]) . '"';
               if ($rule_translate_source == $language_codes_deepl[$i]) {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html($language_names_deepl[$i]) . '</option>';
               $i++;
           }
       }
               $output .= '</select>               
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Input a short description for the current rule. This will appear in the help for for the current rule, next to rule's ID. This field is not used in plugin\'s activity and running.", 'contentomatic-article-builder-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Short Rule Description", 'contentomatic-article-builder-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="text" id="rule_description" name="contentomatic_rules_list[rule_description][]" value="' . esc_attr($rule_description) . '" placeholder="Input a description" class="cr_width_full">
                           
           </div>
           </td></tr></table></div> 
       </div>
       <div class="codemodalfzr-footer">
         <br/>
         <h3 class="cr_inline">Contentomatic Automatic Post Generator</h3><span id="contentomatic_ok' . esc_html($cont) . '" class="codeokfzr cr_inline">OK&nbsp;</span>
         <br/><br/>
       </div>
     </div>
   
   </div>       
                       </td>
   						<td class="cr_shrt_td2"><span class="wpcontentomatic-delete">X</span></td>
                           <td class="cr_short_td"><input type="checkbox" name="contentomatic_rules_list[active][]" class="activateDeactivateClass" value="1"';
               if (isset($active) && $active === '1') {
                   $output .= ' checked';
               }
               $output .= '/>
                           <input type="hidden" name="contentomatic_rules_list[last_run][]" value="' . esc_attr($last_run) . '"/></td>
                           <td class="cr_shrt_td2"><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">' . sprintf( wp_kses( __( 'Shortcode for this rule<br/>(to cross-post from this plugin in other plugins):', 'contentomatic-article-builder-post-generator'), array(  'br' => array( ) ) ) ) . '<br/><b>%%contentomatic_0_' . esc_html($cont) . '%%</b><br/>' . esc_html__('Posts Generated:', 'contentomatic-article-builder-post-generator') . ' ' . esc_html($generated_posts) . '<br/>';
               if ($generated_posts != 0) {
                   $output .= '<a href="' . get_admin_url() . 'edit.php?coderevolution_post_source=Contentomatic_0_' . esc_html($cont) . '&post_type=' . esc_html($def_type) . '" target="_blank">' . esc_html__('View Generated Posts', 'contentomatic-article-builder-post-generator') . '</a><br/>';
               }
               $output .= esc_html__('Last Run: ', 'contentomatic-article-builder-post-generator');
               if ($last_run == '1988-01-27 00:00:00') {
                   $output .= 'Never';
               } else {
                   $output .= $last_run;
               }
               $output .= '<br/>' . esc_html__('Next Run: ', 'contentomatic-article-builder-post-generator');
               if($unlocker == '1')
               {
                   $nextrun = contentomatic_add_minute($last_run, $schedule);
               }
               else
               {
                   $nextrun = contentomatic_add_hour($last_run, $schedule);
               }
               $now     = contentomatic_get_date_now();
               if ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) {
                   $output .= esc_html__('WP-CRON Disabled. Rules will not automatically run!', 'contentomatic-article-builder-post-generator');
               }
               else
               {
                   if (isset($active) && $active === '1') {
                       if($unlocker == '1')
                       {
                           $contentomatic_hour_diff = (int)contentomatic_minute_diff($now, $nextrun);
                       }
                       else
                       {
                           $contentomatic_hour_diff = (int)contentomatic_hour_diff($now, $nextrun);
                       }
                       if ($contentomatic_hour_diff >= 0) {
                           $append = 'Now.';
                           $cron   = _get_cron_array();
                           if ($cron != FALSE) {
                               $date_format = _x('Y-m-d H:i:s', 'Date Time Format1', 'contentomatic-article-builder-post-generator');
                               foreach ($cron as $timestamp => $cronhooks) {
                                   foreach ((array) $cronhooks as $hook => $events) {
                                       if ($hook == 'contentomaticaction') {
                                           foreach ((array) $events as $key => $event) {
                                               $append = date_i18n($date_format, $timestamp);
                                           }
                                       }
                                   }
                               }
                           }
                           $output .= $append;
                       } else {
                           $output .= $nextrun;
                       }
                   } else {
                       $output .= esc_html__('Rule Disabled', 'contentomatic-article-builder-post-generator');
                   }
               }
               $output .= '<br/>' . esc_html__('Local Time: ', 'contentomatic-article-builder-post-generator') . $now;
               $output .= '</div>
                       </div></td>
                           <td class="cr_center">
                           <div>
                           <img id="run_img' . esc_html($cont) . '" src="' . plugin_dir_url(dirname(__FILE__)) . 'images/running.gif' . '" alt="Running" class="cr_status_icon';
               if (!empty($running)) {           
                   if (!in_array(array($cont => '0'), $running)) {
                       $output .= ' cr_hidden';
                   }
                   else
                   {
                       $f = fopen(get_temp_dir() . 'contentomatic_0_' . $cont, 'w');
                       if($f !== false)
                       {
                           if (!flock($f, LOCK_EX | LOCK_NB)) {
                           }
                           else
                           {
                               flock($f, LOCK_UN);
                               $output .= ' cr_hidden';
                               if (($xxkey = array_search(array($cont => '0'), $running)) !== false) {
                                   unset($running[$xxkey]);
                                   update_option('contentomatic_running_list', $running);
                               }
                           }
                       }
                   }
               } else {
                   $output .= ' cr_hidden';
               }
               $output .= '" title="status">
                           <div class="codemainfzr">
                           <select id="actions" class="actions" name="actions" onchange="actionsChangedManual(' . esc_html($cont) . ', this.value, 0);" onfocus="this.selectedIndex = 0;">
                               <option value="select" disabled selected>' . esc_html__("Select an Action", 'contentomatic-article-builder-post-generator') . '</option>
                               <option value="run">' . esc_html__("Run This Rule Now", 'contentomatic-article-builder-post-generator') . '</option>
                               <option value="trash">' . esc_html__("Move All Posts To Trash", 'contentomatic-article-builder-post-generator') . '</option>
                               <option value="duplicate">' . esc_html__("Duplicate This Rule", 'contentomatic-article-builder-post-generator') . '</option>
                               <option value="delete">' . esc_html__("Permanently Delete All Posts", 'contentomatic-article-builder-post-generator') . '</option>
                           </select>
                           </div>
                           </div>
                           </td>
   					</tr>	
   					';
               $cont = $cont + 1;
           }
       }
       return $output;
   }
   ?>