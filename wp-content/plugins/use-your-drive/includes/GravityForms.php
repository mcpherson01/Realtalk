<?php
GFForms::include_addon_framework();

class GFUseyourDriveAddOn extends GFAddOn {

    protected $_version = "1.0";
    protected $_min_gravityforms_version = "1.9";
    protected $_slug = "useyourdriveaddon";
    protected $_path = "use-your-drive/includes/GravityForms.php";
    protected $_full_path = __FILE__;
    protected $_title = "Gravity Forms Use-your-Drive Add-On";
    protected $_short_title = "Use-your-Drive Add-On";

    public function init() {
        parent::init();

        if (isset($this->_min_gravityforms_version) && !$this->is_gravityforms_supported($this->_min_gravityforms_version)) {
            return;
        }

        /* Add a Use-your-Drive button to the advanced to the field editor */
        add_filter('gform_add_field_buttons', array($this, "useyourdrive_field"));
        add_filter('admin_enqueue_scripts', array($this, "useyourdrive_extra_scripts"));

        /* Now we execute some javascript technicalitites for the field to load correctly */
        add_action("gform_editor_js", array($this, "gform_editor_js"));
        add_filter('gform_field_input', array($this, "useyourdrive_input"), 10, 5);

        /* Add a custom setting to the field */
        add_action("gform_field_standard_settings", array($this, "useyourdrive_settings"), 10, 2);

        /* Adds title to the custom field */
        add_filter('gform_field_type_title', array($this, 'useyourdrive_title'), 10, 2);

        /* Filter to add the tooltip for the field */
        add_filter('gform_tooltips', array($this, 'add_useyourdrive_tooltips'));

        /* Save some data for this field */
        add_filter('gform_field_validation', array($this, 'useyourdrive_validation'), 10, 4);

        /* Display values in a proper way */
        add_filter('gform_entry_field_value', array($this, 'useyourdrive_entry_field_value'), 10, 4);
        add_filter('gform_entries_field_value', array($this, 'useyourdrive_entries_field_value'), 10, 4);
        add_filter('gform_merge_tag_filter', array($this, 'useyourdrive_merge_tag_filter'), 10, 5);

        /* Integrate with Gravity PDF */
        if (class_exists("GFPDF_Core")) {
            add_action('gfpdf_post_save_pdf', array($this, 'useyourdrive_post_save_pdf'), 10, 5);
            add_filter('gfpdf_form_settings_advanced', array($this, 'useyourdrive_add_pdf_setting'), 10, 1);
            add_filter('useyourdrive_gravitypdf_set_folder_id', array(&$this, 'useyourdrive_gravify_pdf_use_upload_folder'), 10, 5);
        }

        /* Add support for wpDataTables <> Gravity Form integration */
        if (class_exists("WPDataTable")) {
            add_action('wpdatatables_before_get_table_metadata', array($this, 'render_wpdatatables_field'), 10, 1);
        }
    }

    public function useyourdrive_extra_scripts() {
        if (RGForms::is_gravity_page()) {
            add_thickbox();
        }
    }

    public function useyourdrive_field($field_groups) {
        foreach ($field_groups as &$group) {
            if ($group["name"] == "advanced_fields") {
                $group["fields"][] = array(
                    'class' => 'button',
                    'value' => 'Use-your-Drive',
                    'date-type' => 'useyourdrive',
                    'onclick' => "StartAddField('useyourdrive');"
                );
                break;
            }
        }
        return $field_groups;
    }

    public function gform_editor_js() {
        ?>
        <script type='text/javascript'>
            jQuery(document).ready(function ($) {
              /* Which settings field should be visible for our custom field*/
              fieldSettings["useyourdrive"] = ".label_setting, .description_setting, .admin_label_setting, .error_message_setting, .css_class_setting, .visibility_setting, .rules_setting, .label_placement_setting, .useyourdrive_setting, .conditional_logic_field_setting, .conditional_logic_page_setting, .conditional_logic_nextbutton_setting"; //this will show all the fields of the Paragraph Text field minus a couple that I didn't want to appear.

              /* binding to the load field settings event to initialize */
              $(document).bind("gform_load_field_settings", function (event, field, form) {
                if (field["UseyourdriveShortcode"] !== undefined) {
                  jQuery("#field_useyourdrive").val(field["UseyourdriveShortcode"]);
                } else {
                  /* Default value */
                  var defaultvalue = '[useyourdrive mode="upload" upload="1" uploadrole="all" userfolders="auto" viewuserfoldersrole="none"]';
                  jQuery("#field_useyourdrive").val(defaultvalue);
                }
              });

              /* Shortcode Generator Popup */
              $('.UseyourDrive-GF-shortcodegenerator').click(function () {
                var shortcode = jQuery("#field_useyourdrive").val();
                shortcode = shortcode.replace('[useyourdrive ', '').replace('"]', '');
                var query = encodeURIComponent(shortcode).split('%3D%22').join('=').split('%22%20').join('&');
                tb_show("Build Shortcode for Form", ajaxurl + '?action=useyourdrive-getpopup&' + query + '&type=gravityforms&TB_iframe=true&height=600&width=800');
              });
            });

            function SetDefaultValues_useyourdrive(field) {
              field.label = '<?php _e('Upload your Files', 'useyourdrive'); ?>';
            }
        </script>
        <?php
    }

    public function useyourdrive_input($input, $field, $value, $lead_id, $form_id) {
        if ($field->type == "useyourdrive") {
            if (!$this->is_form_editor()) {
                $return = do_shortcode($field->UseyourdriveShortcode);
                $return .= "<input type='hidden' name='input_" . $field->id . "' id='input_" . $form_id . "_" . $field->id . "'  class='fileupload-filelist fileupload-input-filelist' value='" . (isset($_REQUEST['input_' . $field->id]) ? stripslashes($_REQUEST['input_' . $field->id]) : '') . "'>";
                return $return;
            } else {
                $style = 'background: #176cff url(' . USEYOURDRIVE_ROOTPATH . '/css/images/shortcode_image.png) no-repeat center center; height: 150px;  width: 99%;  border: 1px solid #aaa;  outline: 0;  cursor: pointer;';
                return '<div style="' . $style . '"></div>';
            }
        }
        return $input;
    }

    public function useyourdrive_settings($position, $form_id) {
        if ($position == 1430) {
            ?>
            <li class="useyourdrive_setting field_setting">
              <label for="field_useyourdrive">Use-your-Drive Shortcode <?php echo gform_tooltip("form_field_useyourdrive"); ?></label>
              <a href="#" class='button-primary UseyourDrive-GF-shortcodegenerator '><?php _e('Build your Use-your-Drive shortcode', 'useyourdrive'); ?></a>
              <textarea id="field_useyourdrive" class="fieldwidth-3 fieldheight-2" onchange="SetFieldProperty('UseyourdriveShortcode', this.value)"></textarea>
              <br/><small>Missing a Use-your-Drive Gravity Form feature? Please let me <a href="https://florisdeleeuwnl.zendesk.com/hc/en-us/requests/new" target="_blank">know</a>!</small>
            </li>
            <?php
        }
    }

    function useyourdrive_title($title, $field_type) {
        if ($field_type === 'useyourdrive') {
            return __('Use-your-Drive Upload', 'useyourdrive');
        }
        return $title;
    }

    public function add_useyourdrive_tooltips($tooltips) {
        $tooltips["form_field_useyourdrive"] = "<h6>Use-your-Drive Shortcode</h6>" . __('Build here your Use-your-Drive shortcode', 'useyourdrive');
        return $tooltips;
    }

    public function useyourdrive_validation($result, $value, $form, $field) {
        if ($field->type !== 'useyourdrive') {
            return $result;
        }

        if ($field->isRequired === false) {
            return $result;
        }

        /* Get information uploaded files from hidden input */
        $filesinput = rgpost('input_' . $field->id);
        $uploadedfiles = json_decode($filesinput);

        if (empty($uploadedfiles)) {
            $result['is_valid'] = false;
            $result['message'] = __('This field is required. Please upload your files.', 'gravityforms');
        } else {
            $result['is_valid'] = true;
            $result['message'] = '';
        }

        return $result;
    }

    public function useyourdrive_entry_field_value($value, $field, $lead, $form) {
        if ($field->type !== "useyourdrive") {
            return $value;
        }

        return $this->renderUploadedFiles(html_entity_decode($value));
    }

    public function render_wpdatatables_field($tableId) {
        add_filter('gform_get_input_value', array($this, 'useyourdrive_get_input_value'), 10, 4);
    }

    public function useyourdrive_get_input_value($value, $entry, $field, $input_id) {
        if ($field->type !== "useyourdrive") {
            return $value;
        }

        return $this->renderUploadedFiles(html_entity_decode($value));
    }

    public function useyourdrive_entries_field_value($value, $form_id, $field_id, $entry) {
        $form = RGFormsModel::get_form_meta($form_id);

        if (is_array($form["fields"])) {
            foreach ($form["fields"] as $field) {
                if ($field->type === 'useyourdrive' && $field_id == $field->id) {
                    if (!empty($value)) {
                        return $this->renderUploadedFiles(html_entity_decode($value));
                    }
                }
            }
        }

        return $value;
    }

    public function useyourdrive_set_export_values($value, $form_id, $field_id, $lead) {
        $form = RGFormsModel::get_form_meta($form_id);

        if (is_array($form["fields"])) {
            foreach ($form["fields"] as $field) {
                if ($field->type === 'useyourdrive' && $field_id == $field->id) {
                    return $this->renderUploadedFiles(html_entity_decode($value), false);
                }
            }
        }

        return $value;
    }

    public function useyourdrive_merge_tag_filter($value, $merge_tag, $modifier, $field, $rawvalue) {

        if ($field->type == 'useyourdrive') {
            return $this->renderUploadedFiles(html_entity_decode($value));
        } else {
            return $value;
        }
    }

    public function renderUploadedFiles($data, $ashtml = true) {

        $uploadedfiles = json_decode($data);

        if (($uploadedfiles !== NULL) && (count((array) $uploadedfiles) > 0)) {

            $first_entry = current($uploadedfiles);
            $folder_location = ($ashtml && isset($first_entry->folderurl)) ? '<a href="' . urldecode($first_entry->folderurl) . '">' . dirname($first_entry->path) . '</a>' : dirname($first_entry->path);

            /* Fill our custom field with the details of our upload session */
            $html = sprintf(__('%d file(s) uploaded to %s:', 'useyourdrive'), count((array) $uploadedfiles), $folder_location);
            $html .= ($ashtml) ? '<ul>' : "\r\n";

            foreach ($uploadedfiles as $fileid => $file) {
                $html .= ($ashtml) ? '<li><a href="' . urldecode($file->link) . '">' : "";
                $html .= basename($file->path);
                $html .= ($ashtml) ? '</a>' : "";
                $html .= ' (' . $file->size . ')';
                $html .= ($ashtml) ? '</li>' : "\r\n";
            }

            $html .= ($ashtml) ? '</ul>' : "";
        } else {
            return $data;
        }

        return $html;
    }

    /*
     * GravityPDF 
     * Basic configuration in Form Settings -> PDF:
     * 
     * Always Save PDF = YES
     * [GOOGLE  DRIVE] Export PDF = YES
     * [[GOOGLE  DRIVE] ID = ID where the PDFs need to be stored
     */

    public function useyourdrive_add_pdf_setting($fields) {
        $fields['useyourdrive_save_to_googledrive'] = array(
            'id' => 'useyourdrive_save_to_googledrive',
            'name' => '[GOOGLE  DRIVE] Export PDF',
            'desc' => 'Save the created PDF to Google Drive',
            'type' => 'radio',
            'options' => array(
                'Yes' => __('Yes'),
                'No' => __('No'),
            ),
            'std' => __('No'),
        );

        global $UseyourDrive;


        $main_account = $UseyourDrive->get_accounts()->get_primary_account();

        $account_id = '';
        if (!empty($main_account)) {
            $account_id = $main_account->get_id();
        }

        $fields['useyourdrive_save_to_account_id'] = array(
            'id' => 'useyourdrive_save_to_account_id',
            'name' => '[GOOGLE  DRIVE] Account ID',
            'desc' => 'Account ID where the PDFs need to be stored. E.g. <code>' . $account_id . '</code>',
            'type' => 'text',
            'std' => $main_account,
        );

        $fields['useyourdrive_save_to_googledrive_id'] = array(
            'id' => 'useyourdrive_save_to_googledrive_id',
            'name' => '[GOOGLE  DRIVE] Folder ID',
            'desc' => 'Folder ID where the PDFs need to be stored. E.g. <code>0AfuC9ad2CCWUk9PVB</code>',
            'type' => 'text',
            'std' => '',
        );


        return $fields;
    }

    public function useyourdrive_post_save_pdf($pdf_path, $filename, $settings, $entry, $form) {

        global $UseyourDrive;
        $processor = $UseyourDrive->get_processor();

        if (!isset($settings['useyourdrive_save_to_googledrive']) || $settings['useyourdrive_save_to_googledrive'] === "No") {
            return false;
        }

        $file = array(
            'tmp_path' => $pdf_path,
            'type' => mime_content_type($pdf_path),
            'name' => $entry['id'] . '-' . $filename
        );

        if (!isset($settings['useyourdrive_save_to_account_id'])) {
            /* Fall back for older PDF configurations */
            $settings['useyourdrive_save_to_account_id'] = $UseyourDrive->get_accounts()->get_primary_account()->get_id();
        }

        $account_id = apply_filters("useyourdrive_gravitypdf_set_account_id", $settings['useyourdrive_save_to_account_id'], $settings, $entry, $form, $processor);
        $folder_id = apply_filters("useyourdrive_gravitypdf_set_folder_id", $settings['useyourdrive_save_to_googledrive_id'], $settings, $entry, $form, $processor);

        return $this->useyourdrive_upload_gravify_pdf($file, $account_id, $folder_id);
    }

    public function useyourdrive_upload_gravify_pdf($file, $account_id, $folder_id) {

        global $UseyourDrive;
        $processor = $UseyourDrive->get_processor();

        $requested_account = $processor->get_accounts()->get_account_by_id($account_id);
        if ($requested_account !== null) {
            $processor->set_current_account($requested_account);
        } else {
            error_log(sprintf("[Use-your-Drive message]: Google Drive account (ID: %s) as it isn't linked with the plugin", $account_id));
            die();
        }


        /* Write file */
        $chunkSizeBytes = 20 * 320 * 1000; // Multiple of 320kb, the recommended fragment size is between 5-10 MB.

        $processor->get_app()->get_client()->setDefer(true);

        /* Create new Google Drive File */
        /* Create new Google File */
        $googledrive_file = new \UYDGoogle_Service_Drive_DriveFile();
        $googledrive_file->setName($file['name']);
        $googledrive_file->setMimeType($file['type']);
        $googledrive_file->setParents(array($folder_id));

        try {
            $request = $processor->get_app()->get_drive()->files->create($googledrive_file, array('supportsAllDrives' => true));
        } catch (\Exception $ex) {
            error_log('[Use-your-Drive message]: ' . sprintf('Not uploaded to Google Drive: %s', $ex->getMessage()));
            return false;
        }

        /* Create a media file upload to represent our upload process. */
        $media = new \UYDGoogle_Http_MediaFileUpload(
                $processor->get_app()->get_client(), $request, null, null, true, $chunkSizeBytes
        );


        $filesize = filesize($file['tmp_path']);
        $media->setFileSize($filesize);

        try {
            $upload_status = false;
            $bytesup = 0;
            $handle = fopen($file['tmp_path'], "rb");
            while (!$upload_status && !feof($handle)) {
                @set_time_limit(60);
                $chunk = fread($handle, $chunkSizeBytes);
                $upload_status = $media->nextChunk($chunk);
                $bytesup += $chunkSizeBytes;
            }

            fclose($handle);
        } catch (\Exception $ex) {
            error_log('[Use-your-Drive message]: ' . sprintf('Not uploaded to Google Drive: %s', $ex->getMessage()));
            return false;
        }

        $processor->get_app()->get_client()->setDefer(false);
    }

    public function useyourdrive_gravify_pdf_use_upload_folder($folder_id, $settings, $entry, $form, $processor) {

        if ($folder_id !== '%upload_folder%') {
            return $folder_id;
        }

        if (is_array($form["fields"])) {
            foreach ($form["fields"] as $field) {
                if ($field->type === 'useyourdrive') {
                    if (isset($entry[$field->id])) {

                        $uploadedfiles = json_decode($entry[$field->id]);

                        if (($uploadedfiles !== NULL) && (count((array) $uploadedfiles) > 0)) {
                            $first_entry = reset($uploadedfiles);

                            if (isset($first_entry->account_id)) {
                                $requested_account = $processor->get_accounts()->get_account_by_id($first_entry->account_id);
                            } else {
                                $requested_account = $processor->get_accounts()->get_primary_account();
                            }

                            if ($requested_account !== null) {
                                $processor->set_current_account($requested_account);
                            } else {
                                error_log("[Use-your-Drive message]: Google Drive account (ID: %s) as it isn't linked with the plugin");
                                return $folder_id;
                            }

                            $cached_entry = $processor->get_client()->get_entry($first_entry->hash, false);

                            $parents = $cached_entry->get_parents();
                            $parent_folder = reset($parents);

                            return $parent_folder->get_id();
                        }
                    }
                }
            }
        }

        return $folder_id;
    }

}

$GFUseyourDriveAddOn = new GFUseyourDriveAddOn();
/* This filter isn't fired if inside class */
add_filter('gform_export_field_value', array($GFUseyourDriveAddOn, 'useyourdrive_set_export_values'), 10, 4);
