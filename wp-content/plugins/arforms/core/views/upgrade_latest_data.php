<?php

global $wpdb, $db_record, $MdlDb, $armainhelper, $arfieldhelper, $arsettingcontroller, $arfsettings;

if (version_compare($newdbversion, '1.0', '>') || version_compare($newdbversion, '1', '=')) {
    global $wpdb;

    delete_option('arftempsetting');

    $resval = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "options WHERE option_name = 'arf_options' ", OBJECT_K);
    foreach ($resval as $mykey => $myval) {
        $mynewarrsetting = addslashes($myval->option_value);
        $ins = $wpdb->query("insert into " . $wpdb->prefix . "options (option_name,option_value,autoload) VALUES ('arftempsetting','" . $mynewarrsetting . "','yes') ");
    }

    if (version_compare($newdbversion, '1.2', '<')) {
        global $wpdb;
        $wpdb->query("RENAME TABLE " . $wpdb->prefix . "arf_items TO " . $MdlDb->entries);
        $wpdb->query("RENAME TABLE " . $wpdb->prefix . "arf_item_metas TO " . $MdlDb->entry_metas);

        delete_option('arfa_db_version');
    }

    if (version_compare($newdbversion, '2.0', '<')) {
        require_once(MODELS_PATH . '/arsettingmodel.php');
        require_once(MODELS_PATH . '/arstylemodel.php');

        global $wpdb;

        $updateoptionsetting = new arsettingmodel();
        update_option('arf_options', $updateoptionsetting);
        set_transient('arf_options', $updateoptionsetting);

        $res = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "options WHERE option_name = 'arftempsetting' ", OBJECT_K);
        foreach ($res as $key => $val) {
            $optionval = $val->option_value;

            $optionval = str_replace("settingmodel", "arsettingmodel", $optionval);
            $optionval = str_replace("O:12:", "O:14:", $optionval);
            $myarr = unserialize($optionval);

            $res1 = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "options WHERE option_name = 'arf_options' ", OBJECT_K);
            foreach ($res1 as $key1 => $val1) {
                $mynewarr = unserialize($val1->option_value);
            }

            $mynewarr->pubkey = $myarr->pubkey;
            $mynewarr->privkey = $myarr->privkey;
            $mynewarr->re_theme = $myarr->re_theme;
            $mynewarr->re_lang = $myarr->re_lang;
            $mynewarr->re_msg = $myarr->re_msg;
            $mynewarr->success_msg = $myarr->success_msg;
            $mynewarr->failed_msg = $myarr->failed_msg;
            $mynewarr->blank_msg = $myarr->blank_msg;

            $mynewarr->invalid_msg = $myarr->invalid_msg;
            $mynewarr->submit_value = $myarr->submit_value;
            $mynewarr->reply_to_name = $myarr->reply_to_name;
            $mynewarr->reply_to = $myarr->reply_to;
            $mynewarr->brand = $myarr->brand;
            $mynewarr->form_submit_type = $myarr->form_submit_type;


            update_option('arf_options', $mynewarr);
            set_transient('arf_options', $mynewarr);
        }
        delete_option('arftempsetting');

        $updateoptionsetting->set_default_options();

        $updatestylesettings = new arstylemodel();

        update_option('arfa_options', $updatestylesettings);
        set_transient('arfa_options', $updatestylesettings);

        $updatestylesettings->set_default_options();
        $updatestylesettings->store();



        $cssoptions = get_option("arfa_options");
        $new_values = array();

        foreach ($cssoptions as $k => $v)
            $new_values[$k] = $v;

        $arfssl = (is_ssl()) ? 1 : 0;

        $filename = FORMPATH . '/core/css_create_main.php';

        if (is_file($filename)) {
            $uploads = wp_upload_dir();
            $target_path = $uploads['basedir'];
            $target_path .= "/arforms";
            $target_path .= "/css";
            $use_saved = true;
            $form_id = '';
            $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
            $css .= "\n";
            ob_start();
            include $filename;
            $css .= ob_get_contents();
            ob_end_clean();
            $css .= "\n " . $warn;
            $css_file = $target_path . '/arforms.css';

            WP_Filesystem();
            global $wp_filesystem;
            $wp_filesystem->put_contents($css_file, $css, 0777);

            update_option('arfa_css', $css);
            delete_transient('arfa_css');
            set_transient('arfa_css', $css);
        }


        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE status!=%s order by id desc",draft), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $form_id = $val->id;
            $cssoptions = maybe_unserialize($form_css_res[0]['form_css']);

            $cssoptions['arffieldinnermarginssetting'] = '6px 10px 6px 10px';
            $cssoptions['bg_inavtive_color_pg_break'] = '7ec3fc';

            $cssoptions['arfsubmitfontfamily'] = $cssoptions['check_font'];
            $cssoptions['arfmainfieldsetpadding_1'] = '30';
            $cssoptions['arfmainfieldsetpadding_2'] = '10';
            $cssoptions['arfmainfieldsetpadding_3'] = '30';
            $cssoptions['arfmainfieldsetpadding_4'] = '10';
            $cssoptions['arfmainformtitlepaddingsetting_1'] = '0';
            $cssoptions['arfmainformtitlepaddingsetting_2'] = '0';
            $cssoptions['arfmainformtitlepaddingsetting_3'] = '15';
            $cssoptions['arfmainformtitlepaddingsetting_4'] = '45';
            $cssoptions['arffieldinnermarginssetting_1'] = '6';
            $cssoptions['arffieldinnermarginssetting_2'] = '10';
            $cssoptions['arffieldinnermarginssetting_3'] = '6';
            $cssoptions['arffieldinnermarginssetting_4'] = '10';
            $cssoptions['arfsubmitbuttonmarginsetting_1'] = '10';
            $cssoptions['arfsubmitbuttonmarginsetting_2'] = '0';
            $cssoptions['arfsubmitbuttonmarginsetting_3'] = '0';
            $cssoptions['arfsubmitbuttonmarginsetting_4'] = '10';
            $cssoptions['arfformtitlealign'] = 'left';

            $cssoptions['arfcheckradiostyle'] = 'minimal';
            $cssoptions['arfcheckradiocolor'] = 'default';

            $sernewarr = serialize($cssoptions);
            $res = $wpdb->update($MdlDb->forms, array('form_css' => $sernewarr), array('id' => $val->id));

            if (count($cssoptions) > 0) {
                $new_values = array();

                foreach ($cssoptions as $k => $v)
                    $new_values[$k] = str_replace("#", '', $v);

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id . '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);
            }


            $unserarr = array();
            $unserarr = maybe_unserialize($val->options);
            $unserarr["arf_form_outer_wrapper"] = '';
            $unserarr["arf_form_inner_wrapper"] = '';
            $unserarr["arf_form_title"] = '';
            $unserarr["arf_form_description"] = '';
            $unserarr["arf_form_element_wrapper"] = '';
            $unserarr["arf_form_element_label"] = '';
            $unserarr["arf_form_submit_button"] = '';
            $unserarr["arf_form_success_message"] = '';
            $unserarr["arf_form_elements"] = '';
            $unserarr["arf_submit_outer_wrapper"] = '';
            $unserarr["arf_form_next_button"] = '';
            $unserarr["arf_form_previous_button"] = '';
            $unserarr["arf_form_error_message"] = '';
            $unserarr["arf_form_page_break"] = '';
            $unserarr["arf_form_fly_sticky"] = '';
            $unserarr["arf_form_modal_css"] = '';
            $unserarr["arf_form_other_css"] = $unserarr["form_custom_css"];


            $seriarr = serialize($unserarr);
            $res = $wpdb->update($MdlDb->forms, array('options' => $seriarr), array('id' => $val->id));



            $arsetting = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->ar . " WHERE frm_id = %d", $val->id), ARRAY_A);
            $aweber_settings = maybe_unserialize($arsetting[0]["aweber"]);
            $mailchimp_settings = maybe_unserialize($arsetting[0]["mailchimp"]);
            $getresponse_settings = maybe_unserialize($arsetting[0]["getresponse"]);
            $gvo_settings = maybe_unserialize($arsetting[0]["gvo"]);
            $ebizac_settings = maybe_unserialize($arsetting[0]["ebizac"]);
            $icontact_settings = maybe_unserialize($arsetting[0]["icontact"]);
            $constant_contact_settings = maybe_unserialize($arsetting[0]["constant_contact"]);

            $aweber_arr = array();
            $aweber_arr['enable'] = $aweber_settings['enable'];
            $aweber_arr['type'] = $aweber_settings['type'];
            $aweber_arr['type_val'] = $aweber_settings['type_val'];
            $ar_aweber = serialize($aweber_arr);

            $mailchimp_arr = array();
            $mailchimp_arr['enable'] = $mailchimp_settings['enable'];
            $mailchimp_arr['type'] = $mailchimp_settings['type'];
            $mailchimp_arr['type_val'] = $mailchimp_settings['type_val'];
            $ar_mailchimp = serialize($mailchimp_arr);

            $getresponse_arr = array();
            $getresponse_arr['enable'] = $getresponse_settings['enable'];
            $getresponse_arr['type'] = $getresponse_settings['type'];
            $getresponse_arr['type_val'] = $getresponse_settings['type_val'];
            $ar_getresponse = serialize($getresponse_arr);

            $gvo_arr = array();
            $gvo_arr['enable'] = $gvo_settings['enable'];
            $gvo_arr['type'] = $gvo_settings['type'];
            $gvo_arr['type_val'] = $gvo_settings['type_val'];
            $ar_gvo = serialize($gvo_arr);

            $ebizac_arr = array();
            $ebizac_arr['enable'] = $ebizac_settings['enable'];
            $ebizac_arr['type'] = $ebizac_settings['type'];
            $ebizac_arr['type_val'] = $ebizac_settings['type_val'];
            $ar_ebizac = serialize($ebizac_arr);

            $icontact_arr = array();
            $icontact_arr['enable'] = $icontact_settings['enable'];
            $icontact_arr['type'] = $icontact_settings['type'];
            $icontact_arr['type_val'] = $icontact_settings['type_val'];
            $ar_icontact = serialize($icontact_arr);

            $constant_contact_arr = array();
            $constant_contact_arr['enable'] = $constant_contact_settings['enable'];
            $constant_contact_arr['type'] = $constant_contact_settings['type'];
            $constant_contact_arr['type_val'] = $constant_contact_settings['type_val'];
            $ar_constant_contact = serialize($constant_contact_arr);


            $wpdb->query("ALTER TABLE " . $MdlDb->ar . " ADD `enable_ar` TEXT DEFAULT NULL ");

            $ar_global_autoresponder = array(
                'aweber' => $aweber_arr['enable'],
                'mailchimp' => $mailchimp_arr['enable'],
                'getresponse' => $getresponse_arr['enable'],
                'gvo' => $gvo_arr['enable'],
                'ebizac' => $ebizac_arr['enable'],
                'icontact' => $icontact_arr['enable'],
                'constant_contact' => $constant_contact_arr['enable'],
            );

            $enable_ar = serialize($ar_global_autoresponder);
            $res = $wpdb->update($MdlDb->ar, array('enable_ar' => $enable_ar), array('frm_id' => $form_id));

            $res = $wpdb->update($MdlDb->ar, array('aweber' => $ar_aweber, 'mailchimp' => $ar_mailchimp, 'getresponse' => $ar_getresponse, 'gvo' => $ar_gvo, 'ebizac' => $ar_ebizac, 'icontact' => $ar_icontact, 'constant_contact' => $ar_constant_contact), array('frm_id' => $form_id));



            global $arffield;
            $form_fields = $arffield->getAll("fi.form_id = " . $form_id, " ORDER BY id");
            foreach ($form_fields as $key => $val) {
                $val->field_options['is_recaptcha'] = 'recaptcha';
                $val->field_options['file_upload_text'] = 'Upload';
                $val->field_options['file_remove_text'] = 'Remove';
                $val->field_options['upload_btn_color'] = '#077bdd';
                $val->field_options['inline_css'] = '';
                $val->field_options['css_outer_wrapper'] = '';
                $val->field_options['css_label'] = '';
                $val->field_options['css_input_element'] = '';
                $val->field_options['css_description'] = '';

                $val->field_options['arf_divider_font'] = 'Helvetica';
                $val->field_options['arf_divider_font_size'] = '16';
                $val->field_options['arf_divider_font_style'] = 'bold';

                $val->field_options['arf_divider_bg_color'] = '#ffffff';

                $optionsnewval = serialize($val->field_options);
                $res = $wpdb->update($MdlDb->fields, array('field_options' => $optionsnewval), array('id' => $val->id));
            }
        }


        $wpdb->query("ALTER TABLE " . $MdlDb->fields . " ADD conditional_logic longtext default NULL");




        $wpdb->query("ALTER TABLE " . $MdlDb->entry_metas . " CHANGE `meta_value` `entry_value` LONGTEXT DEFAULT NULL");
        $wpdb->query("ALTER TABLE " . $MdlDb->entry_metas . " CHANGE `item_id` `entry_id` INT( 11 ) NOT NULL");
        $wpdb->query("ALTER TABLE " . $MdlDb->entry_metas . " CHANGE `created_at` `created_date` DATETIME NOT NULL ");


        $wpdb->query("ALTER TABLE " . $MdlDb->views . " CHANGE `ip` `ip_address` VARCHAR(255) DEFAULT NULL");
        $wpdb->query("ALTER TABLE " . $MdlDb->views . " CHANGE `browser` `browser_info` VARCHAR(255) DEFAULT NULL");
        $wpdb->query("ALTER TABLE " . $MdlDb->views . " DROP `referer` ");


        $wpdb->query("ALTER TABLE " . $MdlDb->entries . " CHANGE `item_key` `entry_key` VARCHAR( 255 ) DEFAULT NULL ");
        $wpdb->query("ALTER TABLE " . $MdlDb->entries . " CHANGE `ip` `ip_address` TEXT DEFAULT NULL");
        $wpdb->query("ALTER TABLE " . $MdlDb->entries . " CHANGE `browser` `browser_info` TEXT DEFAULT NULL");
        $wpdb->query("ALTER TABLE " . $MdlDb->entries . " DROP `referer` ");
        $wpdb->query("ALTER TABLE " . $MdlDb->entries . " DROP `parent_item_id` ");
        $wpdb->query("ALTER TABLE " . $MdlDb->entries . " CHANGE `post_id` `attachment_id` INT( 11 ) DEFAULT NULL ");
        $wpdb->query("ALTER TABLE " . $MdlDb->entries . " CHANGE `created_at` `created_date` DATETIME NOT NULL ");


        $wpdb->query("ALTER TABLE " . $MdlDb->forms . " CHANGE `created_at` `created_date` DATETIME NOT NULL ");
        $wpdb->query("ALTER TABLE " . $MdlDb->forms . " DROP `default_template` ");

        $wpdb->query("ALTER TABLE " . $MdlDb->fields . " CHANGE `created_at` `created_date` DATETIME NOT NULL");


        $wpdb->query("DELETE FROM " . $MdlDb->forms . " WHERE `form_id` > 0 ");


        $charset_collate = '';
        if ($wpdb->has_cap('collation')) {
            if (!empty($wpdb->charset))
                $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
            if (!empty($wpdb->collate))
                $charset_collate .= " COLLATE $wpdb->collate";
        }


          $sql = "CREATE TABLE " . $MdlDb->ref_forms." (
          id int(11) NOT NULL auto_increment,
          form_key varchar(255) default NULL,
          name varchar(255) default NULL,
          description text default NULL,
          is_template boolean default 0,
          status varchar(255) default NULL,
          options longtext default NULL,
          created_date datetime NOT NULL,
          autoresponder_id VARCHAR(255),
          autoresponder_fname VARCHAR(255),
          autoresponder_lname VARCHAR(255),
          autoresponder_email VARCHAR(255),
          columns_list text default NULL,
          form_css longtext default NULL,
          form_id int(11) NOT NULL default 0,
          PRIMARY KEY  (id),
          UNIQUE KEY form_key (form_key)
          ) {$charset_collate};";

          $wpdb->query($sql);

          $wpdb->query("ALTER TABLE " .$MdlDb->ref_forms." AUTO_INCREMENT = 10000");
          
         
    }

    if (version_compare($newdbversion, '2.0.5', '<')) {

        global $wpdb;
        /*         * **** reposnder_id column not req. in form table
          $wpdb->query("ALTER TABLE ".$MdlDb->forms." MODIFY `autoresponder_id` VARCHAR(255) NULL DEFAULT NULL");
         */

        $updatestylesettings = new arstylemodel();

        update_option('arfa_options', $updatestylesettings);
        set_transient('arfa_options', $updatestylesettings);

        $updatestylesettings->set_default_options();
        $updatestylesettings->store();


        $cssoptions = get_option("arfa_options");
        $new_values = array();

        foreach ($cssoptions as $k => $v)
            $new_values[$k] = $v;
        $arfssl = (is_ssl()) ? 1 : 0;
        $filename = FORMPATH . '/core/css_create_main.php';

        if (is_file($filename)) {
            $uploads = wp_upload_dir();
            $target_path = $uploads['basedir'];
            $target_path .= "/arforms";
            $target_path .= "/css";
            $use_saved = true;
            $form_id = '';
            $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
            $css .= "\n";
            ob_start();
            include $filename;
            $css .= ob_get_contents();
            ob_end_clean();
            $css .= "\n " . $warn;
            $css_file = $target_path . '/arforms.css';

            WP_Filesystem();
            global $wp_filesystem;
            $wp_filesystem->put_contents($css_file, $css, 0777);

            update_option('arfa_css', $css);
            delete_transient('arfa_css');
            set_transient('arfa_css', $css);
        }


        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE status!=%s order by id desc",'draft'), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $form_id = $val->id;
            $cssoptions = maybe_unserialize($form_css_res[0]['form_css']);


            $formoptions = maybe_unserialize($form_css_res[0]['options']);
            $formoptions['admin_email_subject'] = '[form_name] ' . addslashes(__('Form submitted on', 'ARForms')) . ' [site_name] ';

            $sernewoptarr = serialize($formoptions);

            $res = $wpdb->update($MdlDb->forms, array('options' => $sernewoptarr), array('id' => $val->id));


            if (count($cssoptions) > 0) {
                $new_values = array();

                foreach ($cssoptions as $k => $v)
                    $new_values[$k] = str_replace("#", '', $v);

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id . '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);
            }



            global $arffield;
            $form_fields = $arffield->getAll("fi.form_id = " . $form_id, " ORDER BY id");
            foreach ($form_fields as $key => $val) {
                $val->field_options['upload_font_color'] = '#ffffff';

                $optionsnewval = serialize($val->field_options);
                $res = $wpdb->update($MdlDb->fields, array('field_options' => $optionsnewval), array('id' => $val->id));
            }
        }
    }

    if (version_compare($newdbversion, '2.5', '<')) {

        $wpdb->query("ALTER TABLE " . $MdlDb->fields . " ADD option_order text default NULL");



        $updatestylesettings = new arstylemodel();

        update_option('arfa_options', $updatestylesettings);
        set_transient('arfa_options', $updatestylesettings);

        $updatestylesettings->set_default_options();
        $updatestylesettings->store();


        $cssoptions = get_option("arfa_options");
        $new_values = array();

        foreach ($cssoptions as $k => $v)
            $new_values[$k] = $v;

        $arfssl = (is_ssl()) ? 1 : 0;

        $filename = FORMPATH . '/core/css_create_main.php';

        if (is_file($filename)) {
            $uploads = wp_upload_dir();
            $target_path = $uploads['basedir'];
            $target_path .= "/arforms";
            $target_path .= "/css";
            $use_saved = true;
            $form_id = '';
            $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
            $css .= "\n";
            ob_start();
            include $filename;
            $css .= ob_get_contents();
            ob_end_clean();
            $css .= "\n " . $warn;
            $css_file = $target_path . '/arforms.css';

            WP_Filesystem();
            global $wp_filesystem;
            $wp_filesystem->put_contents($css_file, $css, 0777);

            update_option('arfa_css', $css);
            delete_transient('arfa_css');
            set_transient('arfa_css', $css);
        }


        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE status!='draft' order by id desc",'draft'), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $form_id = $val->id;
            $cssoptions = maybe_unserialize($form_css_res[0]['form_css']);


            $cssoptions['arferrorstyle'] = 'advance';
            $cssoptions['arferrorstylecolor'] = '#ed4040|#FFFFFF|#ed4040';
            $cssoptions['arferrorstylecolor2'] = '#ed4040|#FFFFFF|#ed4040';
            $cssoptions['arferrorstyleposition'] = 'bottom';
            $cssoptions['arfsubmitautowidth'] = '100';
            $cssoptions['arftitlefontfamily'] = 'Helvetica';

            if ($cssoptions['width_unit'] == "%") {
                $cssoptions['width'] = '130';
                $cssoptions['width_unit'] = 'px';
            }

            $sernewarr = serialize($cssoptions);

            $formoptions = maybe_unserialize($form_css_res[0]['options']);

            $shortcodes = $armainhelper->get_shortcodes($formoptions['ar_email_message'], $val->id);
            if (count($shortcodes[3]) > 0 && is_array($shortcodes[3])) {
                global $arffield;
                foreach ($shortcodes[3] as $fieldkey => $fieldval) {
                    $field = $arffield->getOne($fieldval);
                    $myfieldname = $field->name;

                    $replacewith = '[' . $myfieldname . ':' . $fieldval . ']';

                    $formoptions['ar_email_message'] = str_replace('[' . $fieldval . ']', $replace_with, $formoptions['ar_email_message']);
                }
            }

            $shortcodes = $armainhelper->get_shortcodes($formoptions['ar_email_subject'], $val->id);
            if (count($shortcodes[3]) > 0 && is_array($shortcodes[3])) {
                global $arffield;
                foreach ($shortcodes[3] as $fieldkey => $fieldval) {
                    $field = $arffield->getOne($fieldval);
                    $myfieldname = $field->name;

                    $replacewith = '[' . $myfieldname . ':' . $fieldval . ']';

                    $formoptions['ar_email_subject'] = str_replace('[' . $fieldval . ']', $replace_with, $formoptions['ar_email_subject']);
                }
            }

            $shortcodes = $armainhelper->get_shortcodes($formoptions['ar_user_from_email'], $val->id);
            if (count($shortcodes[3]) > 0 && is_array($shortcodes[3])) {
                global $arffield;
                foreach ($shortcodes[3] as $fieldkey => $fieldval) {
                    $field = $arffield->getOne($fieldval);
                    $myfieldname = $field->name;

                    $replacewith = '[' . $myfieldname . ':' . $fieldval . ']';

                    $formoptions['ar_user_from_email'] = str_replace('[' . $fieldval . ']', $replace_with, $formoptions['ar_user_from_email']);
                }
            }

            $shortcodes = $armainhelper->get_shortcodes($formoptions['ar_admin_from_email'], $val->id);
            if (count($shortcodes[3]) > 0 && is_array($shortcodes[3])) {
                global $arffield;
                foreach ($shortcodes[3] as $fieldkey => $fieldval) {
                    $field = $arffield->getOne($fieldval);
                    $myfieldname = $field->name;

                    $replacewith = '[' . $myfieldname . ':' . $fieldval . ']';

                    $formoptions['ar_admin_from_email'] = str_replace('[' . $fieldval . ']', $replace_with, $formoptions['ar_admin_from_email']);
                }
            }

            $sernewoptarr = serialize($formoptions);

            $res = $wpdb->update($MdlDb->forms, array('form_css' => $sernewarr, 'options' => $sernewoptarr), array('id' => $val->id));

            if (count($cssoptions) > 0) {
                $new_values = array();

                foreach ($cssoptions as $k => $v)
                    $new_values[$k] = str_replace("#", '', $v);

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id . '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);
            }



            global $arffield;
            $form_fields = $arffield->getAll("fi.form_id = " . $form_id, " ORDER BY id");
            foreach ($form_fields as $key => $val) {
                $val->field_options['lbllike'] = addslashes(__('Like', 'ARForms'));
                $val->field_options['lbldislike'] = addslashes(__('Dislike', 'ARForms'));
                $val->field_options['slider_handle'] = 'round';
                $val->field_options['slider_step'] = '1';
                $val->field_options['slider_bg_color'] = '#d1dee5';
                $val->field_options['slider_handle_color'] = '#0480BE';
                $val->field_options['slider_value'] = '1';
                $val->field_options['like_bg_color'] = '#087ee2';
                $val->field_options['dislike_bg_color'] = '#ff1f1f';
                $val->field_options['slider_bg_color2'] = '#bcc7cd';
                $val->field_options['upload_font_color'] = '#ffffff';
                $val->field_options['confirm_password'] = '0';
                $val->field_options['password_strenth'] = '0';
                $val->field_options['invalid_password'] = addslashes(__('Confirm Password does not match with password', 'ARForms'));
                $val->field_options['placehodertext'] = '';
                $val->field_options['phone_validation'] = 'international';
                $val->field_options['confirm_password_label'] = addslashes(__('Confirm Password', 'ARForms'));


                if ($val->field_options['custom_width_field'] == '0') {
                    $val->field_options['field_width'] = '';
                }

                $optionsnewval = serialize($val->field_options);
                $res = $wpdb->update($MdlDb->fields, array('field_options' => $optionsnewval), array('id' => $val->id));
            }
        }




        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE id =%d and is_template = %d ",1,1), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_id = $val->id;

            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $formoptions = maybe_unserialize($form_css_res[0]['options']);

            $formoptions['display_title_form'] = '1';
            $sernewoptarr = serialize($formoptions);

            $res = $wpdb->update($MdlDb->forms, array('options' => $sernewoptarr), array('id' => $val->id));

            $cssoptions = get_option("arfa_options");

            $new_values = array();

            foreach ($cssoptions as $k => $v)
                $new_values[$k] = $v;

            $new_values['arfmainformwidth'] = "550";
            $new_values['form_width_unit'] = "px";
            $new_values['form_border_shadow'] = "shadow";
            $new_values['arfmainformbordershadowcolorsetting'] = "#d4d2d4";
            $new_values['arfmainformtitlecolorsetting'] = "#696969";
            $new_values['arfformtitlealign'] = "center";
            $new_values['check_weight_form_title'] = "bold";
            $new_values['form_title_font_size'] = 26;
            $new_values['arfmainformtitlepaddingsetting_3'] = 25;
            $new_values['width'] = 90;
            $new_values['arfdescfontsizesetting'] = 14;
            $new_values['arfbgactivecolorsetting'] = "#fafafa";
            $new_values['arfborderactivecolorsetting'] = "#20bfe3";
            $new_values['arffieldborderwidthsetting'] = "2";
            $new_values['arffieldinnermarginssetting_1'] = "10";
            $new_values['arffieldinnermarginssetting_3'] = "10";
            $new_values['arfsubmitalignsetting'] = "auto";
            $new_values['arfsubmitbuttonwidthsetting'] = "150";
            $new_values['arfsubmitbuttonheightsetting'] = "42";
            $new_values['submit_bg_color'] = "#20bfe3";
            $new_values['arfsubmitbuttonbgcolorhoversetting'] = "#19adcf";
            $new_values['arfsubmitbordercolorsetting'] = "#e1e1e3";
            $new_values['arfsubmitshadowcolorsetting'] = "#f0f0f0";
            $new_values['arfsubmitbuttonmarginsetting_4'] = "-20";
            $new_values['arffieldmarginssetting'] = 20;
            $new_values['arferrorstyle'] = "normal";

            $new_values1 = maybe_serialize($new_values);

            $res = $wpdb->update($MdlDb->forms, array('form_css' => $new_values1), array('id' => $val->id));


            if (!empty($new_values)) {

                $query_results = $wpdb->query($wpdb->prepare("update " . $MdlDb->forms . " set form_css = '%s' where id = '%d'", $new_values1, $form_id));

                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $wp_upload_dir = wp_upload_dir();
                $target_path = $wp_upload_dir['basedir'] . '/arforms/maincss';
                $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $css .= "\n";
                ob_start();
                include $filename;
                $css .= ob_get_contents();
                ob_end_clean();
                $css .= "\n " . $warn;
                $css_file = $target_path . '/maincss_' . $form_id . '.css';
                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file, $css, 0777);
            }

            $query_results_r1 = $wpdb->query($wpdb->prepare("DELETE FROM " . $MdlDb->fields . " WHERE `form_id` = %d", $form_id));

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
            $field_values['name'] = 'First Name';
            $field_values['default_value'] = 'First Name';
            $field_values['description'] = '';
            $field_values['required'] = 1;

            $field_values['field_options']['classes'] = '';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
            $field_values['name'] = 'Last Name';
            $field_values['default_value'] = 'Last Name';
            $field_values['description'] = '';
            $field_values['required'] = 1;

            $field_values['field_options']['classes'] = '';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('email', $form_id));
            $field_values['name'] = 'Email';
            $field_values['default_value'] = 'Email Address';
            $field_values['required'] = 1;
            $field_values['field_options']['invalid'] = 'Please enter a valid email address';
            $field_values['field_options']['classes'] = '';
            $arffield->create($field_values);
            unset($field_values);
            unset($values);
        }





        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE id = %d and is_template = %d ",3,1), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_id = $val->id;

            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $formoptions = maybe_unserialize($form_css_res[0]['options']);

            $formoptions['display_title_form'] = '1';
            $sernewoptarr = serialize($formoptions);

            $res = $wpdb->update($MdlDb->forms, array('options' => $sernewoptarr), array('id' => $val->id));

            $cssoptions = get_option("arfa_options");

            $new_values = array();

            foreach ($cssoptions as $k => $v)
                $new_values[$k] = $v;

            $new_values['arfmainformtitlecolorsetting'] = "#0d0e12";
            $new_values['arfmainformtitlepaddingsetting_3'] = 30;
            $new_values['border_radius'] = 2;
            $new_values['arffieldmarginssetting'] = 18;
            $new_values['arffieldinnermarginssetting_1'] = 10;
            $new_values['arffieldinnermarginssetting_3'] = 10;
            $new_values['arfsubmitbuttonwidthsetting'] = 120;
            $new_values['arfsubmitbuttonheightsetting'] = 40;
            $new_values['arfsubmitbuttonmarginsetting_1'] = 20;
            $new_values['arfsubmitbuttonmarginsetting_4'] = "-46";

            $new_values1 = maybe_serialize($new_values);

            $res = $wpdb->update($MdlDb->forms, array('form_css' => $new_values1), array('id' => $val->id));

            if (!empty($new_values)) {

                $query_results = $wpdb->query($wpdb->prepare("update " . $MdlDb->forms . " set form_css = '%s' where id = '%d'", $new_values1, $form_id));

                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $wp_upload_dir = wp_upload_dir();
                $target_path = $wp_upload_dir['basedir'] . '/arforms/maincss';
                $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $css .= "\n";
                ob_start();
                include $filename;
                $css .= ob_get_contents();
                ob_end_clean();
                $css .= "\n " . $warn;
                $css_file = $target_path . '/maincss_' . $form_id . '.css';
                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file, $css, 0777);
            }

            $query_results_r1 = $wpdb->query($wpdb->prepare("DELETE FROM " . $MdlDb->fields . " WHERE `form_id` = %d", $form_id));

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
            $field_values['name'] = 'First Name';
            $field_values['description'] = '';
            $field_values['required'] = 1;
            // $field_values['field_order'] = '1';
            $field_values['field_options']['classes'] = '';
            $field_id = $arffield->create($field_values, true);
            $field_order[$field_id] = '1';
            unset($field_values);
            unset($field_id);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
            $field_values['name'] = 'Last Name';
            $field_values['required'] = 1;
            //$field_values['field_order'] = '2';
            $field_values['field_options']['label'] = 'hidden';
            $field_values['field_options']['classes'] = '';
            $field_id = $arffield->create($field_values, true);
            $field_order[$field_id] = '2';
            unset($field_values);
            unset($field_id);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('email', $form_id));
            $field_values['name'] = addslashes(__('Email', 'ARForms'));
            $field_values['required'] = 1;
            $field_values['field_options']['invalid'] = addslashes(__('Please enter a valid email address', 'ARForms'));
            //$field_values['field_order'] = '3';
            $field_values['field_options']['classes'] = '';
            $field_id = $arffield->create($field_values, true);
            $field_order[$field_id] = '3';
            unset($field_values);
            unset($field_id);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('url', $form_id));
            $field_values['name'] = addslashes(__('Website', 'ARForms'));
            $field_values['field_options']['invalid'] = addslashes(__('Please enter a valid website', 'ARForms'));
            //$field_values['field_order'] = '4';
            $field_values['field_options']['classes'] = '';
            $field_id = $arffield->create($field_values, true);
            $field_order[$field_id] = '4';
            unset($field_values);
            unset($field_id);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
            $field_values['name'] = addslashes(__('Subject', 'ARForms'));
            $field_values['required'] = 1;
            //$field_values['field_order'] = '5';
            $field_values['field_options']['classes'] = '';
            $field_id = $arffield->create($field_values, true);
            $field_order[$field_id] = '5';
            unset($field_values);
            unset($field_id);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('textarea', $form_id));
            $field_values['name'] = addslashes(__('Message', 'ARForms'));
            $field_values['required'] = 1;
            //$field_values['field_order'] = '6';
            $field_values['field_options']['classes'] = '';
            $field_id = $arffield->create($field_values, true);
            $field_order[$field_id] = '6';
            unset($field_values);
            unset($field_id);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('captcha', $form_id));
            $field_values['name'] = addslashes(__('Captcha', 'ARForms'));
            $field_values['field_options']['label'] = 'none';
            $field_values['field_options']['is_recaptcha'] = 'custom-captcha';
            //$field_values['field_order'] = '7';
            $field_id = $arffield->create($field_values, true);
            $field_order[$field_id] = '7';
            unset($field_values);
            unset($field_id);
            unset($values);

            $field_options = $wpdb->get_results($wpdb->prepare("SELECT `options` FROM `" . $MdlDb->forms . "` WHERE `id` = %d", $form_id));

            $form_opt = maybe_unserialize($field_options[0]->options);

            $form_opt['arf_field_order'] = json_encode($field_order);

            $form_options = maybe_serialize($form_opt);

            $wpdb->update($MdlDb->forms, array('options' => $form_options), array('id' => $form_id));
            unset($field_order);
        }


        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE id = %d and is_template = %d ",4,1), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_id = $val->id;

            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $formoptions = maybe_unserialize($form_css_res[0]['options']);

            $formoptions['display_title_form'] = '1';
            $formoptions['arf_form_title'] = "border-bottom:1px solid #4a494a;padding-bottom:5px;";
            $sernewoptarr = serialize($formoptions);

            $res = $wpdb->update($MdlDb->forms, array('options' => $sernewoptarr), array('id' => $val->id));

            $cssoptions = get_option("arfa_options");

            $new_values = array();

            foreach ($cssoptions as $k => $v)
                $new_values[$k] = $v;

            $new_values['fieldset'] = "0";
            $new_values['arfformtitlealign'] = "center";
            $new_values['check_weight_form_title'] = "bold";
            $new_values['form_title_font_size'] = "32";

            $new_values1 = maybe_serialize($new_values);

            $res = $wpdb->update($MdlDb->forms, array('form_css' => $new_values1), array('id' => $val->id));

            if (!empty($new_values)) {

                $query_results = $wpdb->query($wpdb->prepare("update " . $MdlDb->forms . " set form_css = '%s' where id = '%d'", $new_values1, $form_id));

                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $wp_upload_dir = wp_upload_dir();
                $target_path = $wp_upload_dir['basedir'] . '/arforms/maincss';
                $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $css .= "\n";
                ob_start();
                include $filename;
                $css .= ob_get_contents();
                ob_end_clean();
                $css .= "\n " . $warn;
                $css_file = $target_path . '/maincss_' . $form_id . '.css';
                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file, $css, 0777);
            }

            $query_results_r1 = $wpdb->query($wpdb->prepare("DELETE FROM " . $MdlDb->fields . " WHERE `form_id` = %d", $form_id));

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('radio', $form_id));
            $field_values['name'] = '1. When you visit ARForms, do you see it as... (choose one)';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $field_values['options'] = maybe_serialize(array('Problem solvers', 'An inspiration', 'Ideas generator', 'Solution'));
            $field_values['field_options']['css_input_element'] = 'padding-top:10px;padding-left:20px;';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('checkbox', $form_id));
            $field_values['name'] = '2. Which words best describe ARForms? (choose as many that apply)';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $field_values['options'] = maybe_serialize(array('Unhelpful', 'Difficult to use', 'Supportive', 'Solutions focused', 'Good value', 'Global', 'Community based', 'Friendly', 'Creative', 'Inspiring', 'Developer world'));
            $field_values['field_options']['css_input_element'] = 'padding-top:10px;padding-left:20px;';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('radio', $form_id));
            $field_values['name'] = '3. Which best describes your relationship with ARForms?';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $field_values['options'] = maybe_serialize(array('I am aware of it', 'Rarely use it', 'Use it sometimes', 'Frequent user', 'Do not know it'));
            $field_values['field_options']['css_input_element'] = 'padding-top:10px;padding-left:20px;';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('radio', $form_id));
            $field_values['name'] = '4. When I visit ARForms for something I need to work on, I feel...(choose one)';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $field_values['options'] = maybe_serialize(array('Concerned I won\'t be able to find what I am looking for', 'Inspired', 'Reluctant', 'Indifferent', 'Excited to be starting a project', 'Know I will end up browsing lots of things'));
            $field_values['field_options']['css_input_element'] = 'padding-top:10px;padding-left:20px;';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('radio', $form_id));
            $field_values['name'] = '5. Which of the following best describes your area of work?';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $field_values['options'] = maybe_serialize(array('Administrative', 'Computing', 'Web Design', 'Creative', 'Web Development', 'Marketing', 'Technical'));
            $field_values['field_options']['css_input_element'] = 'padding-top:10px;padding-left:20px;';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('radio', $form_id));
            $field_values['name'] = '6. How often do you use ARForms?';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $field_values['options'] = maybe_serialize(array('It is my first time', 'Weekly', 'Monthly', 'Quarterly', 'Annually', 'Occasionally'));
            $field_values['field_options']['css_input_element'] = 'padding-top:10px;padding-left:20px;';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('textarea', $form_id));
            $field_values['name'] = 'Other Comments About ARForms';
            $field_values['required'] = 0;
            $field_values['field_options']['classes'] = '';
            $arffield->create($field_values);
            unset($field_values);

            unset($values);
        }


        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE id = %d and is_template = %d ",6,1), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_id = $val->id;

            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $formoptions = maybe_unserialize($form_css_res[0]['options']);

            $formoptions['display_title_form'] = '1';
            $formoptions['arf_form_title'] = "background-color:rgb(147, 217, 226);padding: 10px;border-radius:5px;-webkit-border-radius:5px;-o-border-radius:5px;-moz-border-radius:5px;";
            $sernewoptarr = serialize($formoptions);

            $res = $wpdb->update($MdlDb->forms, array('options' => $sernewoptarr), array('id' => $val->id));

            $cssoptions = get_option("arfa_options");

            $new_values = array();

            foreach ($cssoptions as $k => $v)
                $new_values[$k] = $v;

            $new_values['form_border_shadow'] = "shadow";
            $new_values['form_border_shadow'] = 1;
            $new_values['arfmainfieldsetcolor'] = "#c9c7c9";
            $new_values['arfmainformbordershadowcolorsetting'] = "#ebebeb";
            $new_values['arfmainformtitlecolorsetting'] = "#ffffff";
            $new_values['arfformtitlealign'] = "center";
            $new_values['arftitlefontfamily'] = "Courier";
            $new_values['check_weight_form_title'] = "bold";
            $new_values['form_title_font_size'] = 28;
            $new_values['arfmainformtitlepaddingsetting_3'] = 30;
            $new_values['check_font'] = "sans-serif";
            $new_values['text_color'] = "#384647";
            $new_values['arfborderactivecolorsetting'] = "#6fdeed";
            $new_values['arferrorbordercolorsetting'] = "#f28888";
            $new_values['arfcheckradiocolor'] = "aero";
            $new_values['arfsubmitfontfamily'] = "Verdana";
            $new_values['arfsubmitweightsetting'] = "bold";
            $new_values['arfsubmitbuttonfontsizesetting'] = "19";
            $new_values['arfsubmitbuttonwidthsetting'] = "140";
            $new_values['arfsubmitbuttonheightsetting'] = "44";
            $new_values['submit_bg_color'] = "#84d1db";
            $new_values['arfsubmitbuttonbgcolorhoversetting'] = "#6ac7d4";
            $new_values['arfsubmitshadowcolorsetting'] = "#f0f0f0";
            $new_values['arfsubmitbuttonmarginsetting_1'] = "15";
            $new_values['arfsubmitbuttonmarginsetting_4'] = "-45";
            $new_values['arferrorstylecolor'] = "#F2DEDE|#A94442|#508b27";

            $new_values1 = maybe_serialize($new_values);

            $res = $wpdb->update($MdlDb->forms, array('form_css' => $new_values1), array('id' => $val->id));

            if (!empty($new_values)) {

                $query_results = $wpdb->query($wpdb->prepare("update " . $MdlDb->forms . " set form_css = '%s' where id = '%d'", $new_values1, $form_id));

                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $wp_upload_dir = wp_upload_dir();
                $target_path = $wp_upload_dir['basedir'] . '/arforms/maincss';
                $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $css .= "\n";
                ob_start();
                include $filename;
                $css .= ob_get_contents();
                ob_end_clean();
                $css .= "\n " . $warn;
                $css_file = $target_path . '/maincss_' . $form_id . '.css';
                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file, $css, 0777);
            }

            $query_results_r1 = $wpdb->query($wpdb->prepare("DELETE FROM " . $MdlDb->fields . " WHERE `form_id` = %d", $form_id));

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
            $field_values['name'] = 'Full Name';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('email', $form_id));
            $field_values['name'] = 'Email';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('phone', $form_id));
            $field_values['name'] = 'Phone';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('textarea', $form_id));
            $field_values['name'] = 'Address';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
            $field_values['name'] = 'City';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('select', $form_id));
            $field_values['name'] = 'Your Meal Selection';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $field_values['options'] = maybe_serialize(array('Chicken', 'Steak', 'Vegetarian'));
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('select', $form_id));
            $field_values['name'] = 'Are you bringing a guest?';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $field_values['options'] = maybe_serialize(array('Yes', 'No'));
            $bringing_guest_field_id = $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('select', $form_id));
            $field_values['name'] = 'How many guests will be there?';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $field_values['options'] = maybe_serialize(array('One', 'Two', 'Three', 'Four'));
            $conditional_rule = array(
                '1' => array(
                    'id' => 1,
                    'field_id' => $bringing_guest_field_id,
                    'field_type' => 'select',
                    'operator' => 'equals',
                    'value' => 'Yes',
                ),
            );
            $conditional_logic_exp = array(
                'enable' => 1,
                'display' => 'show',
                'if_cond' => 'all',
                'rules' => $conditional_rule,
            );
            $field_values['conditional_logic'] = maybe_serialize($conditional_logic_exp);

            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('time', $form_id));
            $field_values['name'] = 'Which is your suitable time?';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $arffield->create($field_values);
            unset($field_values);

            $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('radio', $form_id));
            $field_values['name'] = 'How much interested in our ARForms?';
            $field_values['required'] = 1;
            $field_values['field_options']['classes'] = '';
            $field_values['options'] = maybe_serialize(array('Extremely', 'Very', 'Moderately', 'Slightly', 'Not Excited'));
            $arffield->create($field_values);
            unset($field_values);
            unset($values);
        }


        global $arffield, $arfform, $MdlDb, $wpdb;

        $values['name'] = addslashes(__('Job Application Form', 'ARForms'));
        $values['description'] = '';
        $values['options']['custom_style'] = 1;
        $values['options']['display_title_form'] = 1;
        $values['is_template'] = '1';
        $values['status'] = 'published';
        $values['form_key'] = 'JobApplication';
        $values['options']['display_title_form'] = "1";
        $values['options']['arf_form_description'] = "margin:0px !important;";

        $form_id = $arfform->create($values);

        $updatestat = $wpdb->query($wpdb->prepare("update " . $MdlDb->forms . " set id = '7' where id = %d", $form_id));

        $form_id = '7';

        $cssoptions = get_option("arfa_options");

        $new_values = array();

        foreach ($cssoptions as $k => $v)
            $new_values[$k] = $v;

        $new_values['arfmainformwidth'] = "800";
        $new_values['arfmainformbgcolorsetting'] = "#fcfcfc";
        $new_values['form_width_unit'] = "px";
        $new_values['form_border_shadow'] = "shadow";
        $new_values['fieldset'] = "1";
        $new_values['arfmainfieldsetcolor'] = "#e0e0de";
        $new_values['arfmainformbordershadowcolorsetting'] = "#dedede";
        $new_values['arfmainfieldsetpadding_1'] = "20";
        $new_values['arfmainfieldsetpadding_2'] = "30";
        $new_values['arfmainfieldsetpadding_4'] = "30";
        $new_values['arfmainformtitlecolorsetting'] = "#767a74";
        $new_values['arfformtitlealign'] = "center";
        $new_values['check_weight_form_title'] = "bold";
        $new_values['arfmainformtitlepaddingsetting_3'] = "30";
        $new_values['label_color'] = "#787778";
        $new_values['weight'] = "bold";
        $new_values['font_size'] = "14";
        $new_values['text_color'] = "#565657";
        $new_values['bg_color'] = "#fffcff";
        $new_values['arfbgactivecolorsetting'] = "#f5f9fc";
        $new_values['arferrorbordercolorsetting'] = "#ebc173";
        $new_values['border_radius'] = "2";
        $new_values['border_color'] = "#b0b0b5";
        $new_values['arffieldmarginssetting'] = "18";
        $new_values['arfcheckradiostyle'] = "square";
        $new_values['arfcheckradiocolor'] = "yellow";
        $new_values['arfsubmitalignsetting'] = "auto";
        $new_values['arfsubmitbuttonwidthsetting'] = "100";
        $new_values['arfsubmitbuttonheightsetting'] = "45";
        $new_values['arfsubmitbuttontext'] = "Apply Now";
        $new_values['submit_bg_color'] = "#a969e0";
        $new_values['arfsubmitbuttonbgcolorhoversetting'] = "#9249d1";
        $new_values['arfsubmitbuttonmarginsetting_1'] = "0";
        $new_values['error_font'] = "Verdana";
        $new_values['arffontsizesetting'] = "11";
        $new_values['arferrorstylecolor'] = "#FAEBCC|#8A6D3B|#af7a0c";
        $new_values['arferrorstyleposition'] = "right";
        $new_values['arfborderactivecolorsetting'] = '#a969e0';




        $new_values1 = maybe_serialize($new_values);

        if (!empty($new_values)) {

            $query_results = $wpdb->query($wpdb->prepare("update " . $MdlDb->forms . " set form_css = '%s' where id = '%d'", $new_values1, $form_id));

            $use_saved = true;
            $arfssl = (is_ssl()) ? 1 : 0;
            $filename = FORMPATH . '/core/css_create_main.php';

            $wp_upload_dir = wp_upload_dir();

            $target_path = $wp_upload_dir['basedir'] . '/arforms/maincss';

            $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";


            $css .= "\n";


            ob_start();


            include $filename;


            $css .= ob_get_contents();


            ob_end_clean();


            $css .= "\n " . $warn;

            $css_file = $target_path . '/maincss_' . $form_id . '.css';

            WP_Filesystem();
            global $wp_filesystem;
            $wp_filesystem->put_contents($css_file, $css, 0777);

            wp_cache_delete($form_id, 'arfform');
        } else {

            $query_results = true;
        }


        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
        $field_values['name'] = addslashes(__('First Name', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['default_value'] = 'First Name';
        $field_values['field_options']['blank'] = 'Please Enter First Name';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
        $field_values['name'] = addslashes(__('Last name', 'ARForms'));
        $field_values['required'] = 0;
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['default_value'] = 'Last Name';
        $field_values['field_options']['blank'] = 'Please Enter Last Name';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('email', $form_id));
        $field_values['name'] = addslashes(__('Email', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['default_value'] = 'Email';
        $field_values['field_options']['blank'] = 'Please Enter Email';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('phone', $form_id));
        $field_values['name'] = addslashes(__('Contact No', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['default_value'] = 'Contact No';
        $field_values['field_options']['blank'] = 'Please Enter Contact No';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('textarea', $form_id));
        $field_values['name'] = addslashes(__('Address', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = '';
        $field_values['field_options']['blank'] = 'Please Enter Address';
        $field_values['field_options']['max'] = '2';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('select', $form_id));
        $field_values['name'] = addslashes(__('Position apply for?', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['options'] = maybe_serialize(array('', addslashes(__('Developer', 'ARForms')), addslashes(__('Manager', 'ARForms')), addslashes(__('Clerk', 'ARForms')), addslashes(__('Representative', 'ARForms'))));
        $field_values['field_options']['blank'] = 'Please Select Position';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('select', $form_id));
        $field_values['name'] = addslashes(__('Are you applying for?', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['options'] = maybe_serialize(array('', addslashes(__('Full Time', 'ARForms')), addslashes(__('Part Time', 'ARForms'))));
        $field_values['field_options']['blank'] = 'Please Select Applying for';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('divider', $form_id));
        $field_values['name'] = addslashes(__('Education and Experience Details', 'ARForms'));
        $field_values['required'] = 0;
        $field_values['field_options']['css_label'] = 'padding-top:20px;margin-bottom:20px;';
        $field_values['field_options']['arf_divider_font'] = 'Arial';
        $field_values['field_options']['arf_divider_font_size'] = '18';
        $field_values['field_options']['arf_divider_bg_color'] = '#fcfcfc';
        $field_values['field_options']['classes'] = '';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
        $field_values['name'] = addslashes(__('Diploma / Degree Name', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['field_options']['blank'] = 'Please Enter Diploma / Degree';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
        $field_values['name'] = addslashes(__('College / University Name', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['field_options']['blank'] = 'Please Enter College / University';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('number', $form_id));
        $field_values['name'] = addslashes(__('Graduation Year', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['field_options']['blank'] = 'Please Enter Graduation Year';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
        $field_values['name'] = addslashes(__('Percentage', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['field_options']['blank'] = 'Please Enter Percentage';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('textarea', $form_id));
        $field_values['name'] = addslashes(__('Skills & Qualification', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = '';
        $field_values['field_options']['blank'] = 'Please Enter Skills & Qualification';
        $field_values['field_options']['max'] = '2';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('number', $form_id));
        $field_values['name'] = addslashes(__('Desired Salary', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['field_options']['blank'] = 'Please Enter Desired Salary';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('radio', $form_id));
        $field_values['name'] = addslashes(__('Fresher / Experienced', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['options'] = maybe_serialize(array(addslashes(__('Fresher', 'ARForms')), addslashes(__('Experienced', 'ARForms'))));
        $field_values['field_options']['align'] = 'inline';
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['field_options']['blank'] = 'Please Select Fresher / Experienced';
        $frsh_exp_id = $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('text', $form_id));
        $field_values['name'] = addslashes(__('Experience', 'ARForms'));
        $field_values['description'] = addslashes(__('(e.g. 3 months, 2 years etc)', 'ARForms'));
        $field_values['required'] = 1;
        $conditional_rule = array(
            '1' => array(
                'id' => 1,
                'field_id' => $frsh_exp_id,
                'field_type' => 'radio',
                'operator' => 'equals',
                'value' => addslashes(__('Experienced', 'ARForms')),
            ),
        );
        $conditional_logic_exp = array(
            'enable' => 1,
            'display' => 'show',
            'if_cond' => 'all',
            'rules' => $conditional_rule,
        );
        $field_values['conditional_logic'] = maybe_serialize($conditional_logic_exp);
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['field_options']['blank'] = 'Please Enter Experience';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('number', $form_id));
        $field_values['name'] = addslashes(__('Current Salary', 'ARForms'));
        $field_values['required'] = 1;
        $conditional_rule = array(
            '1' => array(
                'id' => 1,
                'field_id' => $frsh_exp_id,
                'field_type' => 'radio',
                'operator' => 'equals',
                'value' => addslashes(__('Experienced', 'ARForms'))
            ),
        );
        $conditional_logic_exp = array(
            'enable' => 1,
            'display' => 'show',
            'if_cond' => 'all',
            'rules' => $conditional_rule
        );
        $field_values['conditional_logic'] = maybe_serialize($conditional_logic_exp);
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['field_options']['blank'] = 'Please Enter Current Salary';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('textarea', $form_id));
        $field_values['name'] = addslashes(__('Current Company Detail', 'ARForms'));
        $field_values['required'] = 1;
        $conditional_rule = array(
            '1' => array(
                'id' => 1,
                'field_id' => $frsh_exp_id,
                'field_type' => 'radio',
                'operator' => 'equals',
                'value' => addslashes(__('Experienced', 'ARForms'))
            ),
        );
        $conditional_logic_exp = array(
            'enable' => 1,
            'display' => 'show',
            'if_cond' => 'all',
            'rules' => $conditional_rule
        );
        $field_values['conditional_logic'] = maybe_serialize($conditional_logic_exp);
        $field_values['field_options']['classes'] = '';
        $field_values['field_options']['blank'] = 'Please Enter Current Company Detail';
        $arffield->create($field_values);
        unset($field_values);

        $field_values = apply_filters('arfbeforefieldcreated', $arfieldhelper->setup_new_variables('file', $form_id));
        $field_values['name'] = addslashes(__('Upload Resume', 'ARForms'));
        $field_values['required'] = 1;
        $field_values['field_options']['restrict'] = 1;
        $field_values['field_options']['upload_btn_color'] = '#a969e0';
        $field_values['field_options']['ftypes'] = array('doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'pdf' => 'application/pdf', 'txt|asc|c|cc|h' => 'text/plain', 'rtf' => 'application/rtf');
        $field_values['field_options']['classes'] = 'arf_2';
        $field_values['field_options']['blank'] = 'Please Select Resume';
        $arffield->create($field_values);
        unset($field_values);
        unset($values);
    }

    if (version_compare($newdbversion, '2.5.2', '<')) {

        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE status!=%s order by id desc",'draft'), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $form_id = $val->id;
            $cssoptions = maybe_unserialize($form_css_res[0]['form_css']);

            if (count($cssoptions) > 0) {
                $new_values = array();

                foreach ($cssoptions as $k => $v)
                    $new_values[$k] = str_replace("#", '', $v);

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id . '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);
            }
        }
    }


    if (version_compare($newdbversion, '2.5.3', '<')) {

        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE status!=%s order by id desc",'draft'), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $form_id = $val->id;
            $cssoptions = maybe_unserialize($form_css_res[0]['form_css']);

            if (count($cssoptions) > 0) {
                $new_values = array();

                foreach ($cssoptions as $k => $v)
                    $new_values[$k] = str_replace("#", '', $v);

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id . '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);
            }
        }
    }

    if (version_compare($newdbversion, '2.5.4', '<')) {

        require_once(MODELS_PATH . '/arstylemodel.php');

        $updatestylesettings = new arstylemodel();

        update_option('arfa_options', $updatestylesettings);
        set_transient('arfa_options', $updatestylesettings);

        $updatestylesettings->set_default_options();
        $updatestylesettings->store();

        $cssoptions = get_option("arfa_options");
        $new_values = array();

        foreach ($cssoptions as $k => $v)
            $new_values[$k] = $v;
        $arfssl = (is_ssl()) ? 1 : 0;
        $filename = FORMPATH . '/core/css_create_main.php';

        if (is_file($filename)) {
            $uploads = wp_upload_dir();
            $target_path = $uploads['basedir'];
            $target_path .= "/arforms";
            $target_path .= "/css";
            $use_saved = true;
            $form_id = '';
            $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
            $css .= "\n";
            ob_start();
            include $filename;
            $css .= ob_get_contents();
            ob_end_clean();
            $css .= "\n " . $warn;
            $css_file = $target_path . '/arforms.css';

            WP_Filesystem();
            global $wp_filesystem;
            $wp_filesystem->put_contents($css_file, $css, 0777);

            update_option('arfa_css', $css);
            delete_transient('arfa_css');
            set_transient('arfa_css', $css);
        }


        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE status!=%s order by id desc",'draft'), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $form_id = $val->id;
            $cssoptions = maybe_unserialize($form_css_res[0]['form_css']);

            if (count($cssoptions) > 0) {
                $new_values = array();

                foreach ($cssoptions as $k => $v)
                    $new_values[$k] = str_replace("#", '', $v);

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id . '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);
            }
        }
    }

    if (version_compare($newdbversion, '2.6', '<')) {


        require_once(MODELS_PATH . '/arstylemodel.php');
        $updatestylesettings = new arstylemodel();

        update_option('arfa_options', $updatestylesettings);
        set_transient('arfa_options', $updatestylesettings);

        $updatestylesettings->set_default_options();
        $updatestylesettings->store();

        $cssoptions = get_option("arfa_options");
        $new_values = array();

        foreach ($cssoptions as $k => $v)
            $new_values[$k] = $v;

        $arfssl = (is_ssl()) ? 1 : 0;

        $filename = FORMPATH . '/core/css_create_main.php';

        if (is_file($filename)) {
            $uploads = wp_upload_dir();
            $target_path = $uploads['basedir'];
            $target_path .= "/arforms";
            $target_path .= "/css";
            $use_saved = true;
            $form_id = '';
            $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
            $css .= "\n";
            ob_start();
            include $filename;
            $css .= ob_get_contents();
            ob_end_clean();
            $css .= "\n " . $warn;
            $css_file = $target_path . '/arforms.css';

            WP_Filesystem();
            global $wp_filesystem;
            $wp_filesystem->put_contents($css_file, $css, 0777);

            update_option('arfa_css', $css);
            delete_transient('arfa_css');
            set_transient('arfa_css', $css);
        }


        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE status!=%s order by id desc",'draft'), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $form_id = $val->id;
            $cssoptions = maybe_unserialize($form_css_res[0]['form_css']);

            $cssoptions['bar_color_survey'] = '#007ee4';
            $cssoptions['bg_color_survey'] = '#dadde2';
            $cssoptions['text_color_survey'] = '#333333';

            $sernewarr = serialize($cssoptions);

            $res = $wpdb->update($MdlDb->forms, array('form_css' => $sernewarr), array('id' => $val->id));

            if (count($cssoptions) > 0) {
                $new_values = array();

                foreach ($cssoptions as $k => $v)
                    $new_values[$k] = str_replace("#", '', $v);

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id . '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);
            }


            global $arffield, $MdlDb;
            $form_fields = $arffield->getAll("fi.form_id = " . $form_id, " ORDER BY id");
            foreach ($form_fields as $key => $val) {
                $val->field_options['image_url'] = ARFURL . '/images/no-image.png';
                $val->field_options['image_left'] = '0px';
                $val->field_options['image_top'] = '0px';
                $val->field_options['image_height'] = '';
                $val->field_options['image_width'] = '';
                $val->field_options['image_center'] = 'no';
                $val->field_options['enable_total'] = '0';
                $val->field_options['colorpicker_type'] = 'advanced';
                $val->field_options['show_year_month_calendar'] = '0';

                $optionsnewval = serialize($val->field_options);
                $res = $wpdb->update($MdlDb->fields, array('field_options' => $optionsnewval), array('id' => $val->id));
            }
        }
    }

    if (version_compare($newdbversion, '2.6.2', '<')) {

        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE status!='%s order by id desc",'draft'), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_id = $val->id;


            global $arffield;
            $form_fields = $arffield->getAll("fi.form_id = " . $form_id, " ORDER BY id");
            foreach ($form_fields as $key => $val) {
                $val->field_options['password_placeholder'] = '';

                $optionsnewval = serialize($val->field_options);
                $res = $wpdb->update($MdlDb->fields, array('field_options' => $optionsnewval), array('id' => $val->id));
            }
        }
    }

    if (version_compare($newdbversion, '2.7', '<')) {



        require_once(MODELS_PATH . '/arstylemodel.php');
        $updatestylesettings = new arstylemodel();

        update_option('arfa_options', $updatestylesettings);
        set_transient('arfa_options', $updatestylesettings);

        $updatestylesettings->set_default_options();
        $updatestylesettings->store();



        $cssoptions = get_option("arfa_options");
        $new_values = array();

        foreach ($cssoptions as $k => $v)
            $new_values[$k] = $v;
        $arfssl = (is_ssl()) ? 1 : 0;
        $filename = FORMPATH . '/core/css_create_main.php';

        if (is_file($filename)) {
            $uploads = wp_upload_dir();
            $target_path = $uploads['basedir'];
            $target_path .= "/arforms";
            $target_path .= "/css";
            $use_saved = true;
            $form_id = '';
            $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
            $css .= "\n";
            ob_start();
            include $filename;
            $css .= ob_get_contents();
            ob_end_clean();
            $css .= "\n " . $warn;
            $css_file = $target_path . '/arforms.css';

            WP_Filesystem();
            global $wp_filesystem;
            $wp_filesystem->put_contents($css_file, $css, 0777);

            update_option('arfa_css', $css);
            delete_transient('arfa_css');
            set_transient('arfa_css', $css);
        }



        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE status!=%s order by id desc",'draft'), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $form_id = $val->id;
            $cssoptions = maybe_unserialize($form_css_res[0]['form_css']);

            $cssoptions['prefix_suffix_bg_color'] = '#e7e8ec';
            $cssoptions['prefix_suffix_icon_color'] = '#808080';
            $cssoptions['submit_hover_bg_img'] = '';

            $cssoptions['arfsectionpaddingsetting_1'] = '15';
            $cssoptions['arfsectionpaddingsetting_2'] = '10';
            $cssoptions['arfsectionpaddingsetting_3'] = '15';
            $cssoptions['arfsectionpaddingsetting_4'] = '10';

            $sernewarr = serialize($cssoptions);

            $res = $wpdb->update($MdlDb->forms, array('form_css' => $sernewarr), array('id' => $val->id));



            $formoptions = maybe_unserialize($form_css_res[0]['options']);
            $formoptions['ar_admin_email_message'] = '[ARF_form_all_values]';

            $sernewoptarr = serialize($formoptions);

            $res = $wpdb->update($MdlDb->forms, array('options' => $sernewoptarr), array('id' => $val->id));

            if (count($cssoptions) > 0) {
                $new_values = array();

                foreach ($cssoptions as $k => $v)
                    $new_values[$k] = str_replace("#", '', $v);

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id . '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);
            }
        }
    }

    if (version_compare($newdbversion, '2.7.4', '<')) {


        require_once(MODELS_PATH . '/arstylemodel.php');
        $updatestylesettings = new arstylemodel();

        update_option('arfa_options', $updatestylesettings);
        set_transient('arfa_options', $updatestylesettings);

        $updatestylesettings->set_default_options();
        $updatestylesettings->store();



        $cssoptions = get_option("arfa_options");
        $new_values = array();

        foreach ($cssoptions as $k => $v)
            $new_values[$k] = $v;
        $arfssl = (is_ssl()) ? 1 : 0;
        $filename = FORMPATH . '/core/css_create_main.php';

        if (is_file($filename)) {
            $uploads = wp_upload_dir();
            $target_path = $uploads['basedir'];
            $target_path .= "/arforms";
            $target_path .= "/css";
            $use_saved = true;
            $form_id = '';
            $css = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
            $css .= "\n";
            ob_start();
            include $filename;
            $css .= ob_get_contents();
            ob_end_clean();
            $css .= "\n " . $warn;
            $css_file = $target_path . '/arforms.css';

            WP_Filesystem();
            global $wp_filesystem;
            $wp_filesystem->put_contents($css_file, $css, 0777);

            update_option('arfa_css', $css);
            delete_transient('arfa_css');
            set_transient('arfa_css', $css);
        }



        global $wpdb, $db_record, $MdlDb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->forms . " WHERE status!=%s order by id desc",'draft'), OBJECT_K);

        foreach ($res as $key => $val) {
            $form_css_res = $wpdb->get_results($wpdb->prepare("SELECT id, form_css, options FROM " . $MdlDb->forms . " WHERE id = %d", $val->id), ARRAY_A);
            $form_id = $val->id;
            $cssoptions = maybe_unserialize($form_css_res[0]['form_css']);

            $cssoptions['arf_checked_checkbox_icon'] = '';
            $cssoptions['enable_arf_checkbox'] = '0';
            $cssoptions['arf_checked_radio_icon'] = '';
            $cssoptions['enable_arf_radio'] = '0';
            $cssoptions['checked_checkbox_icon_color'] = '#666666';
            $cssoptions['checked_radio_icon_color'] = '#666666';

            $cssoptions['date_format'] = 'MMM D, YYYY';
            $cssoptions['cal_date_format'] = 'MMM D, YYYY';

            $cssoptions['arfcalthemename'] = 'default_theme';
            $cssoptions['arfcalthemecss'] = 'default_theme';
            $cssoptions['theme_nicename'] = 'default_theme';


            $sernewarr = serialize($cssoptions);

            $res = $wpdb->update($MdlDb->forms, array('form_css' => $sernewarr), array('id' => $val->id));



            if (count($cssoptions) > 0) {
                $new_values = array();

                foreach ($cssoptions as $k => $v)
                    $new_values[$k] = str_replace("#", '', $v);

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;
                $filename = FORMPATH . '/core/css_create_main.php';
                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id . '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);
            }



            global $arffield;
            $form_fields = $arffield->getAll("fi.form_id = " . $form_id, " ORDER BY id");
            foreach ($form_fields as $key => $val) {
                if ($val->type == "slider") {
                    $val->type = "arfslider";
                }
                $field_options = maybe_unserialize($val->field_options);


                if ($field_options['arf_prefix_icon'] != "") {
                    $field_options['arf_prefix_icon'] = "ar" . $field_options['arf_prefix_icon'];
                }
                if ($field_options['arf_suffix_icon'] != "") {
                    $field_options['arf_suffix_icon'] = "ar" . $field_options['arf_suffix_icon'];
                }

                $fieldtype = $val->type;
                $optionsnewval = maybe_serialize($field_options);
                $res = $wpdb->update($MdlDb->fields, array('type' => $fieldtype, 'field_options' => $optionsnewval), array('id' => $val->id));
            }
        }
    }
    

    if (version_compare($newdbversion, '3.0', '<')) {
        require FORMPATH . '/core/views/upgrade_latest_data_v3.0.php';
    }

    if( version_compare($newdbversion, '3.1', '<')){

        $arf_forms = $wpdb->get_results( $wpdb->prepare( "SELECT form_css FROM `".$MdlDb->forms."` WHERE status = %s", 'published' ) );

        foreach($arf_forms as $form ){

            $new_form_css = maybe_unserialize($form->form_css);

            if( count($new_form_css) > 0 ){
                $new_values = array();
                foreach ($new_form_css as $k => $v) {
                    $new_values[$k] = $v;
                    if( preg_match("/auto/",$new_values[$k]) ){
                        $new_values[$k] = str_replace("px","",$new_values[$k]);
                    }
                }

                update_option('arf_form_css_'.$form_id,json_encode( $new_values) );

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;

                $filename = FORMPATH . '/core/css_create_main.php';

                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id. '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);

                $filename1 = FORMPATH . '/core/css_create_materialize.php';
                $temp_css_file1 = $warn1 = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file1 .= "\n";
                ob_start();
                include $filename1;
                $temp_css_file1 .= ob_get_contents();
                ob_end_clean();
                $temp_css_file1 .= "\n " . $warn1;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new1 = $dest_dir . 'maincss_materialize_' . $form_id. '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new1, $temp_css_file1, 0777);
            }
        }

        $arf_update_templates = true;

        $wpdb->query( $wpdb->prepare("DELETE FROM `".$MdlDb->forms."` WHERE id < %d",12) );

        $wpdb->query( $wpdb->prepare("DELETE FROM `".$MdlDb->fields."` WHERE form_id < %d", 12));

        $arfsettings = get_transient('arf_options');

        if (!is_object($arfsettings)) {
            if ($arfsettings) {
                $arfsettings = unserialize(serialize($arfsettings));
            } else {
                $arfsettings = get_option('arf_options');

                if (!is_object($arfsettings)) {
                    if ($arfsettings){
                        $arfsettings = unserialize(serialize($arfsettings));
                    } else {
                        $arfsettings = new arsettingmodel();
                    }
                    update_option('arf_options', $arfsettings);
                    set_transient('arf_options', $arfsettings);
                }
            }
        }

        $arfsettings->set_default_options();

        $style_settings = get_transient('arfa_options');
        if (!is_object($style_settings)) {
            if ($style_settings) {
                $style_settings = unserialize(serialize($style_settings));
            } else {
                $style_settings = get_option('arfa_options');
                if (!is_object($style_settings)) {
                    if ($style_settings)
                        $style_settings = unserialize(serialize($style_settings));
                    else
                        $style_settings = new arstylemodel();
                    update_option('arfa_options', $style_settings);
                    set_transient('arfa_options', $style_settings);
                }
            }
        }
        $style_settings = get_option('arfa_options');
        if (!is_object($style_settings)) {
            if ($style_settings)
                $style_settings = unserialize(serialize($style_settings));
            else
                $style_settings = new arstylemodel();
            update_option('arfa_options', $style_settings);
        }

        $style_settings->set_default_options();
        $style_settings->store();

        include(MODELS_PATH."/artemplate.php");

    }

    if( version_compare($newdbversion, '3.2', '<') ){

        $all_forms = $wpdb->get_results($wpdb->prepare("SELECT id,options FROM `".$MdlDb->forms."` WHERE is_template = %d AND status = %s ",0,'published'));

        foreach($all_forms as $key => $form ){
            
            $form_opts = maybe_unserialize($form->options);

            $new_conditional_rule = $form_opts['arf_conditional_logic_rules'];
            $new_conditional_mail = $form_opts['arf_conditional_mail_rules'];
            $new_conditional_redirect = $form_opts['arf_conditional_redirect_rules'];
            $new_conditional_subscription = $form_opts['arf_condition_on_subscription_rules'];
            $new_submit_cl = $form_opts['submit_conditional_logic'];

            $conditional_rules = $form_opts['arf_conditional_logic_rules'];
            if(isset($conditional_rules) && is_array($conditional_rules)){
                foreach( $conditional_rules as $k => $cs ){
                    $cl_conditions = $cs['condition'];
                    $cl_results = $cs['result'];

                    foreach($cl_conditions as $ck => $clc ){
                        $clc_field_id = $clc['field_id'];
                        $types = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$clc_field_id) );
                        if( isset($types) && $clc['field_type'] != $types->type ){
                            $new_conditional_rule[$k]['condition'][$ck]['field_type'] = $types->type;
                        }
                    }

                    foreach($cl_results as $cr => $clr ){
                        $clr_field_id = $clr['field_id'];
                        $types = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$clr_field_id) );
                        if( isset($types) && $clc['field_type'] != $types->type ){
                            $new_conditional_rule[$k]['result'][$cr]['field_type'] = $types->type;
                        }
                    }
                }
            }

            $conditional_mail = $form_opts['arf_conditional_mail_rules'];
            if(isset($conditional_rules) && is_array($conditional_rules)){
                foreach($conditional_mail as $i => $ce){
                    $cle_field_type = $ce['field_type_mail'];
                    $cle_field_id = $ce['field_id_mail'];
                    $etypes = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$cle_field_id));

                    if( isset($etypes) && $cle_field_type != $etypes->type ){
                        $new_conditional_mail[$i]['field_type_mail'] = $etypes->type;
                    }
                }
            }

            $conditional_redirect = $form_opts['arf_conditional_redirect_rules'];
            if( isset($conditional_redirect) && is_array($conditional_redirect) ){
                foreach($conditional_redirect as $i => $cr){
                    $clr_field_type = $cr['field_type'];
                    $clr_field_id = $cr['field_id'];
                    $etypes = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$clr_field_id));

                    if( isset($etypes) && $clr_field_type != $etypes->type ){
                        $new_conditional_redirect[$i]['field_type_mail'] = $etypes->type;
                    }
                }
            }


            $conditional_subscription = $form_opts['arf_condition_on_subscription_rules'];
            if( isset($conditional_subscription) && is_array($conditional_subscription) ){
                foreach($conditional_subscription as $i => $csub){
                    $cls_field_type = $csub['field_type'];
                    $cls_field_id = $csub['field_id'];
                    $etypes = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$cls_field_id));

                    if( isset($etypes) && $cls_field_type != $etypes->type ){
                        $new_conditional_subscription[$i]['field_type'] = $etypes->type;
                    }
                }
            }

            $submit_cl_logic = $form_opts['submit_conditional_logic'];
            if( isset($submit_cl_logic) && is_array($submit_cl_logic) ){
                foreach($submit_cl_logic as $s => $submit_cl){
                    if( isset($submit_cl['enable']) && $submit_cl['enable'] == 1 ){
                        $cls_results = $submit_cl['rules'];
                        foreach($cls_results as $r => $rule){
                            $clsub_field_type = $rule['field_type'];
                            $clsub_field_id = $rule['field_id'];
                            $sub_type = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$clsub_field_id));

                            if( isset($sub_type) && $clsub_field_type != $sub_type->type ){
                                $new_submit_cl[$s]['rules'][$r]['field_type'] = $sub_type->type;
                            }
                        }
                    }
                }
            }


            $form_opts['arf_conditional_logic_rules'] = $new_conditional_rule;
            $form_opts['arf_conditional_mail_rules'] = $new_conditional_mail;
            $form_opts['arf_conditional_redirect_rules'] = $new_conditional_redirect;
            $form_opts['arf_condition_on_subscription_rules'] = $new_conditional_subscription;

            $wpdb->update($MdlDb->forms, array('options'=>maybe_serialize($form_opts)), array('id'=>$form->id) );

        }

    }

    if( version_compare($newdbversion, '3.3', '<') ){

        $arf_forms = $wpdb->get_results( $wpdb->prepare( "SELECT id,form_css FROM `".$MdlDb->forms."` WHERE is_template = %d AND status = %s ", 0, 'published' ) );

        foreach($arf_forms as $form ){

            $new_form_css = maybe_unserialize($form->form_css);
            $form_id = $form->id;

            if( count($new_form_css) > 0 ){
                $new_values = array();
                foreach ($new_form_css as $k => $v) {
                    $new_values[$k] = $v;
                    if( preg_match("/auto/",$new_values[$k]) ){
                        $new_values[$k] = str_replace("px","",$new_values[$k]);
                    }
                }

                update_option('arf_form_css_'.$form_id,json_encode( $new_values) );

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;

                $filename = FORMPATH . '/core/css_create_main.php';

                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id. '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);

                $filename1 = FORMPATH . '/core/css_create_materialize.php';
                $temp_css_file1 = $warn1 = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file1 .= "\n";
                ob_start();
                include $filename1;
                $temp_css_file1 .= ob_get_contents();
                ob_end_clean();
                $temp_css_file1 .= "\n " . $warn1;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new1 = $dest_dir . 'maincss_materialize_' . $form_id. '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new1, $temp_css_file1, 0777);
            }
        }

        $all_forms = $wpdb->get_results($wpdb->prepare("SELECT id,options FROM `".$MdlDb->forms."` WHERE is_template = %d AND status = %s ",0,'published'));

        foreach($all_forms as $key => $form ){
            
            $form_opts = maybe_unserialize($form->options);

            $new_conditional_rule = $form_opts['arf_conditional_logic_rules'];
            $new_conditional_mail = $form_opts['arf_conditional_mail_rules'];
            $new_conditional_redirect = $form_opts['arf_conditional_redirect_rules'];
            $new_conditional_subscription = $form_opts['arf_condition_on_subscription_rules'];
            $new_submit_cl = $form_opts['submit_conditional_logic'];

            $conditional_rules = $form_opts['arf_conditional_logic_rules'];
            if(isset($conditional_rules) && is_array($conditional_rules)){
                foreach( $conditional_rules as $k => $cs ){
                    $cl_conditions = $cs['condition'];
                    $cl_results = $cs['result'];

                    foreach($cl_conditions as $ck => $clc ){
                        $clc_field_id = $clc['field_id'];
                        $types = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$clc_field_id) );
                        if( isset($types) && $clc['field_type'] != $types->type ){
                            $new_conditional_rule[$k]['condition'][$ck]['field_type'] = $types->type;
                        }
                    }

                    foreach($cl_results as $cr => $clr ){
                        $clr_field_id = $clr['field_id'];
                        $types = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$clr_field_id) );
                        if( isset($types) && $clr['field_type'] != $types->type ){
                            $new_conditional_rule[$k]['result'][$cr]['field_type'] = $types->type;
                        }
                    }
                }
            }

            $conditional_mail = $form_opts['arf_conditional_mail_rules'];
            if(isset($conditional_rules) && is_array($conditional_rules)){
                foreach($conditional_mail as $i => $ce){
                    $cle_field_type = $ce['field_type_mail'];
                    $cle_field_id = $ce['field_id_mail'];
                    $etypes = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$cle_field_id));

                    if( isset($etypes) && $cle_field_type != $etypes->type ){
                        $new_conditional_mail[$i]['field_type_mail'] = $etypes->type;
                    }
                }
            }

            $conditional_redirect = $form_opts['arf_conditional_redirect_rules'];
            if( isset($conditional_redirect) && is_array($conditional_redirect) ){
                foreach($conditional_redirect as $i => $cr){
                    $clr_field_type = $cr['field_type'];
                    $clr_field_id = $cr['field_id'];
                    $etypes = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$clr_field_id));

                    if( isset($etypes) && $clr_field_type != $etypes->type ){
                        $new_conditional_redirect[$i]['field_type_mail'] = $etypes->type;
                    }
                }
            }

            $conditional_subscription = $form_opts['arf_condition_on_subscription_rules'];
            if( isset($conditional_subscription) && is_array($conditional_subscription) ){
                foreach($conditional_subscription as $i => $csub){
                    $cls_field_type = $csub['field_type'];
                    $cls_field_id = $csub['field_id'];
                    $etypes = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$cls_field_id));

                    if( isset($etypes) && $cls_field_type != $etypes->type ){
                        $new_conditional_subscription[$i]['field_type'] = $etypes->type;
                    }
                }
            }

            $submit_cl_logic = $form_opts['submit_conditional_logic'];
            if( isset($submit_cl_logic) && is_array($submit_cl_logic) ){

                $operator = $submit_cl_logic['if_cond'];

                $operator_arr = array('all','كل','All','alle','todo','tous','すべて','모든','Все','Tüm','所有');

                if( in_array($operator,$operator_arr) ){
                    $operator = 'all';
                } else {
                    $operator = 'any';
                }

                $new_submit_cl['if_cond'] = $operator;

                foreach($submit_cl_logic as $s => $submit_cl){
                    if( isset($submit_cl['enable']) && $submit_cl['enable'] == 1 ){
                        $cls_results = $submit_cl['rules'];
                        foreach($cls_results as $r => $rule){
                            $clsub_field_type = $rule['field_type'];
                            $clsub_field_id = $rule['field_id'];
                            $sub_type = $wpdb->get_row($wpdb->prepare("SELECT type FROM `".$MdlDb->fields."` WHERE id = %d",$clsub_field_id));

                            if( isset($sub_type) && $clsub_field_type != $sub_type->type ){
                                $new_submit_cl[$s]['rules'][$r]['field_type'] = $sub_type->type;
                            }
                        }
                    }
                }
            }

            $form_opts['arf_conditional_logic_rules'] = $new_conditional_rule;
            $form_opts['arf_conditional_mail_rules'] = $new_conditional_mail;
            $form_opts['arf_conditional_redirect_rules'] = $new_conditional_redirect;
            $form_opts['arf_condition_on_subscription_rules'] = $new_conditional_subscription;
            $form_opts['submit_conditional_logic'] = $new_submit_cl;

            $wpdb->update($MdlDb->forms, array('options'=>maybe_serialize($form_opts)), array('id'=>$form->id) );

        }      

        $arf_update_templates = true;

        $wpdb->query( $wpdb->prepare("DELETE FROM `".$MdlDb->forms."` WHERE id < %d",12) );

        $wpdb->query( $wpdb->prepare("DELETE FROM `".$MdlDb->fields."` WHERE form_id < %d", 12));

        $arfsettings = get_transient('arf_options');

        if (!is_object($arfsettings)) {
            if ($arfsettings) {
                $arfsettings = unserialize(serialize($arfsettings));
            } else {
                $arfsettings = get_option('arf_options');

                if (!is_object($arfsettings)) {
                    if ($arfsettings){
                        $arfsettings = unserialize(serialize($arfsettings));
                    } else {
                        $arfsettings = new arsettingmodel();
                    }
                    update_option('arf_options', $arfsettings);
                    set_transient('arf_options', $arfsettings);
                }
            }
        }

        $arfsettings->set_default_options();
        
        global $style_settings;

        $style_settings = get_transient('arfa_options');
        if (!is_object($style_settings)) {
            if ($style_settings) {
                $style_settings = unserialize(serialize($style_settings));
            } else {
                $style_settings = get_option('arfa_options');
                if (!is_object($style_settings)) {
                    if ($style_settings)
                        $style_settings = unserialize(serialize($style_settings));
                    else
                        $style_settings = new arstylemodel();
                    update_option('arfa_options', $style_settings);
                    set_transient('arfa_options', $style_settings);
                }
            }
        }

        $style_settings = get_option('arfa_options');
        if (!is_object($style_settings)) {
            if ($style_settings)
                $style_settings = unserialize(serialize($style_settings));
            else
                $style_settings = new arstylemodel();
            update_option('arfa_options', $style_settings);
        }

        $style_settings->set_default_options();
        $style_settings->store();

        include(MODELS_PATH."/artemplate.php");

        $updateoptionsetting = get_option('arf_options');

        $updateoptionsetting->arf_file_uplod_dir_path = 'wp-content/uploads/arforms/userfiles';

        update_option('arf_options',$updateoptionsetting);

        set_transient('arf_options', $updateoptionsetting);

    }

    if( version_compare($newdbversion, '3.4', '<') ){
        $updateoptionsetting = get_option('arf_options');
        $updateoptionsetting->arfprivacyguidline = 1;
        $updateoptionsetting->arfprivacyguidlinetext = '<b> Who we are? </b>
            <p> ARForms is a WordPress Premium Form Builder Plugin to create stylish and modern style form withing few clicks.</p>
            <br/>
            <b> What Personal Data we collect and why we collect it </b>
            <p> ARForms stores ip address and country of visitor. However, ARForms provide an option to prevent storing visitor data. </p>
            <p> ARForms will not store any personal data except user_id (only if user is logged in), ip address, country, browser user_agent, referrer only when submit the form </p>
            <p> We store this data to provide the analytics of the visitor and the user who submit the form. </p>
            <p> ARForms will also store the all type of data (this may contain personal data as well as subscribe user to third party opt-in like MailChimp, Aweber, etc) in the database which plugin user has included in the form. These data are editable as well as removable from form entry section of ARForms </p>';

        update_option('arf_options',$updateoptionsetting);
        set_transient('arf_options',$updateoptionsetting);

        $wpdb->query("ALTER TABLE `" . $MdlDb->ar . "`  ADD `mailerlite` TEXT NOT NULL");

        $wpdb->query("INSERT INTO `" . $MdlDb->autoresponder. "` (responder_id) VALUES (14)");

        $ar_types = maybe_unserialize(get_option('arf_ar_type'));
        $ar_types['mailerlite_type'] = 1;
        $ar_types = maybe_serialize($ar_types);
        update_option('arf_ar_type', $ar_types);

    }

    if( version_compare($newdbversion, '3.5', '<') ){

        $res = $wpdb->get_results($wpdb->prepare("SELECT `id`, `form_css` FROM " . $MdlDb->forms . " WHERE status = %s order by id desc",'published'), OBJECT_K);

        foreach ($res as $key => $val) {
            $arform_id = $val->id;
            $arform_css = maybe_unserialize($val->form_css);

            if( isset($arform_css['arf_checked_checkbox_icon']) && $arform_css['arf_checked_checkbox_icon'] != '' ){
                $arform_css['arf_checked_checkbox_icon'] = $armainhelper->arf_update_fa_font_class( $arform_css['arf_checked_checkbox_icon'] );
            }

            if( isset($arform_css['arf_checked_radio_icon']) && $arform_css['arf_checked_radio_icon'] != '' ){
                $arform_css['arf_checked_radio_icon'] = $armainhelper->arf_update_fa_font_class( $arform_css['arf_checked_radio_icon'] );
            }

            $wpdb->update($MdlDb->forms, array('form_css'=>maybe_serialize($arform_css)), array('id'=>$arform_id) );

            $arform_fields = $wpdb->get_results($wpdb->prepare("SELECT `id`, `type`, `field_options` FROM `".$MdlDb->fields."` WHERE form_id = %d",$arform_id), OBJECT_K);
            foreach ($arform_fields as $fk => $f_val) {
                if(isset($f_val->field_options)){
                    $field_options = json_decode($f_val->field_options,true);
                    if( json_last_error() != JSON_ERROR_NONE ){
                        $field_options = maybe_unserialize($f_val->field_options);
                    }
                    $field_id = $f_val->id;

                    if( isset($field_options['arf_prefix_icon']) && $field_options['arf_prefix_icon'] != '' ){
                        $field_options['arf_prefix_icon'] = $armainhelper->arf_update_fa_font_class( $field_options['arf_prefix_icon'] );
                    }

                    if( isset($field_options['arf_suffix_icon']) && $field_options['arf_suffix_icon'] != '' ){
                        $field_options['arf_suffix_icon'] = $armainhelper->arf_update_fa_font_class( $field_options['arf_suffix_icon'] );
                    }

                    $wpdb->update($MdlDb->fields, array('field_options'=>json_encode($field_options)), array('id'=>$field_id) );

                    if( $f_val->type == 'html' && $field_options['enable_total'] == 1  ){
                        $html_content = $field_options['description'];
                        $formula_pattern = "/\<arftotal\>(.*?)\<\/arftotal\>/is";
                        $new_description = $html_content;

                        if(preg_match($formula_pattern,$html_content,$matches)) {
                            $formula_content = $matches[0];
                            $ids_pattern = "/\[(.*?)\:(\d+)(|\.(\d+))\]/";
                            preg_match_all($ids_pattern,$formula_content,$match_ids);
                            if(isset($match_ids[2]) && is_array($match_ids[2]) && !empty($match_ids[2]) ){
                                foreach($match_ids[2] as $matched_id ){
                                    $n_field_id = $matched_id;
                                    $wpdb->update( $MdlDb->fields, array('enable_running_total' => $field_id), array('id' => $n_field_id) );
                                }
                            }

                        }
                    }
                }
            }

        }

    }

    if( version_compare($newdbversion, '3.5.2', '<') ){

        global $arsettingcontroller;

        $wp_upload_dir = wp_upload_dir();

        $directory = $wp_upload_dir['basedir'] . '/arforms/import_forms/';

        $arsettingcontroller->arf_remove_directory($directory);

    }

    if( version_compare($newdbversion, '3.6', '<') ){

        global $wpdb, $MdlDb;

        $arf_forms = $wpdb->get_results( $wpdb->prepare( "SELECT id,form_css FROM `".$MdlDb->forms."` WHERE is_template = %d AND status = %s ", 0, 'published' ) );

        foreach($arf_forms as $form ){

            $new_form_css = maybe_unserialize($form->form_css);
            $form_id = $form->id;

            if( count($new_form_css) > 0 ){
                $new_values = array();

                $new_form_css['arf_bg_position_x'] = "left";
                $new_form_css['arf_bg_position_input_x'] = "";
                $new_form_css['arf_bg_position_y'] = "top";
                $new_form_css['arf_bg_position_input_y'] = "";

                foreach ($new_form_css as $k => $v) {
                    $new_values[$k] = $v;
                }

                $saving = true;
                $use_saved = true;
                $arfssl = (is_ssl()) ? 1 : 0;

                $filename = FORMPATH . '/core/css_create_main.php';

                $temp_css_file = $warn = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file .= "\n";
                ob_start();
                include $filename;
                $temp_css_file .= ob_get_contents();
                ob_end_clean();
                $temp_css_file .= "\n " . $warn;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new = $dest_dir . 'maincss_' . $form_id. '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new, $temp_css_file, 0777);

                $filename1 = FORMPATH . '/core/css_create_materialize.php';
                $temp_css_file1 = $warn1 = "/* WARNING: Any changes made to this file will be lost when your ARForms settings are updated */";
                $temp_css_file1 .= "\n";
                ob_start();
                include $filename1;
                $temp_css_file1 .= ob_get_contents();
                ob_end_clean();
                $temp_css_file1 .= "\n " . $warn1;
                $wp_upload_dir = wp_upload_dir();
                $dest_dir = $wp_upload_dir['basedir'] . '/arforms/maincss/';
                $css_file_new1 = $dest_dir . 'maincss_materialize_' . $form_id. '.css';

                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->put_contents($css_file_new1, $temp_css_file1, 0777);
            }
        }

        $arf_update_templates = true;

        $wpdb->query( $wpdb->prepare("DELETE FROM `".$MdlDb->forms."` WHERE id < %d",12) );

        $wpdb->query( $wpdb->prepare("DELETE FROM `".$MdlDb->fields."` WHERE form_id < %d", 12));

        $arf_update_templates = true;

        $wpdb->query( $wpdb->prepare("DELETE FROM `".$MdlDb->forms."` WHERE id < %d",12) );

        $wpdb->query( $wpdb->prepare("DELETE FROM `".$MdlDb->fields."` WHERE form_id < %d", 12));

        $arfsettings = get_transient('arf_options');

        if (!is_object($arfsettings)) {
            if ($arfsettings) {
                $arfsettings = unserialize(serialize($arfsettings));
            } else {
                $arfsettings = get_option('arf_options');

                if (!is_object($arfsettings)) {
                    if ($arfsettings){
                        $arfsettings = unserialize(serialize($arfsettings));
                    } else {
                        $arfsettings = new arsettingmodel();
                    }
                    update_option('arf_options', $arfsettings);
                    set_transient('arf_options', $arfsettings);
                }
            }
        }

        $arfsettings->set_default_options();
        
        global $style_settings;

        $style_settings = get_transient('arfa_options');
        if (!is_object($style_settings)) {
            if ($style_settings) {
                $style_settings = unserialize(serialize($style_settings));
            } else {
                $style_settings = get_option('arfa_options');
                if (!is_object($style_settings)) {
                    if ($style_settings)
                        $style_settings = unserialize(serialize($style_settings));
                    else
                        $style_settings = new arstylemodel();
                    update_option('arfa_options', $style_settings);
                    set_transient('arfa_options', $style_settings);
                }
            }
        }

        $style_settings = get_option('arfa_options');
        if (!is_object($style_settings)) {
            if ($style_settings)
                $style_settings = unserialize(serialize($style_settings));
            else
                $style_settings = new arstylemodel();
            update_option('arfa_options', $style_settings);
        }

        $style_settings->set_default_options();
        $style_settings->store();

        include(MODELS_PATH."/artemplate.php");

    }


    update_option('arf_db_version', '3.6.1');

    global $newdbversion;
    $newdbversion = '3.6.1';

    update_option('arf_new_version_installed', 1);
}
?>