<?php

namespace TheLion\UseyourDrive;

class Notification {

    /**
     * Kind of notification
     * @var string  
     */
    public $type;

    /**
     * Addresses of recipients
     * @var array 
     */
    public $recipients = array();

    /**
     * Subject of notification
     * @var string 
     */
    public $subject;

    /**
     * Message of notification
     * @var string 
     */
    public $message;

    /**
     * HTML list of entries for in message
     * @var string 
     */
    public $entry_list;

    /**
     * Array of entries
     * @var array 
     */
    public $entries;

    /**
     * List containing the placeholders and its values
     * @var array 
     */
    public $placeholders;

    /**
     * The Root folder used when the notification is triggered (e.g. the upload folder)
     * @var \TheLion\UseyourDrive\CacheNode 
     */
    public $folder;

    /**
     * True if the user who triggers the notification doesn't need to receive it, while listed as recipient
     * @var boolean 
     */
    public $skip_notification_for_current_user = false;

    public function __construct(\TheLion\UseyourDrive\Processor $_processor, $notification_type, $entries) {
        $this->_processor = $_processor;
        $this->type = $notification_type;
        $this->entries = $entries;

        /* Load current folder */
        $result = $this->get_client()->get_folder(false, false);

        if (!empty($result)) {
            $this->folder = $result['folder'];
        }

        if (count($entries) > 0) {
            $first_entry = reset($entries);
            $parents = $first_entry->get_parents();
            if (!empty($parents)) {
                $this->folder = reset($parents);
            }
        }

        if ($this->get_processor()->get_shortcode_option('notification_skip_email_currentuser') === '1' && is_user_logged_in()) {
            $this->skip_notification_for_current_user = true;
        }

        $this->_process_subject();
        $this->_process_message();
        $this->_process_entry_list();
        $this->_process_recipients();
    }

    /**
     * Set subject of notification using the Global Template setting
     */
    private function _process_subject() {
        switch ($this->type) {
            case 'download':
                if (count($this->entries) === 1) {
                    $template_key = 'download_template_subject';
                } else {
                    $template_key = 'download_template_subject_zip';
                }
                break;
            case 'upload':
                $template_key = 'upload_template_subject';
                break;
            case 'deletion':
            case 'deletion_multiple':
                $template_key = 'delete_template_subject';
                break;
            default:
                $template_key = '';
        }

        $subject_template = $this->get_processor()->get_setting($template_key);
        $subject = apply_filters('useyourdrive_notification_set_subject', $subject_template, $this);

        $this->set_subject(trim($subject));
    }

    /**
     * Set message of notification using the Global Template setting
     */
    private function _process_message() {
        switch ($this->type) {
            case 'download':
                $message_key = 'download_template';
                break;
            case 'upload':
                $message_key = 'upload_template';
                break;
            case 'deletion':
            case 'deletion_multiple':
                $message_key = 'delete_template';
                break;
            default:
                $message_key = '';
        }

        $message_template = $this->get_processor()->get_setting($message_key);
        $message = apply_filters('useyourdrive_notification_set_message', $message_template, $this);

        $this->set_message(trim($message));
    }

    /**
     * Set file list of notification using the Global Template setting
     * This list is used inside the message
     */
    private function _process_entry_list() {
        $entry_list_template = $this->get_processor()->get_setting('filelist_template');
        $entry_list = apply_filters('useyourdrive_notification_set_entry_list', $entry_list_template, $this);

        $this->set_entry_list(trim($entry_list));
    }

    /**
     * Set recipients of notification using the shortcode setting
     */
    private function _process_recipients() {

        $recipients_template_str = $this->get_processor()->get_shortcode_option('notificationemail');
        $recipients_template_arr = array_map('trim', explode(',', $recipients_template_str));

        /* Add addresses of linked users if needed */
        $linked_users_key = array_search('%linked_user_email%', $recipients_template_arr);
        if ($linked_users_key !== false) {
            unset($recipients_template_arr[$linked_users_key]);

            $linked_users = $this->folder->get_linked_users();

            foreach ($linked_users as $userdata) {
                $recipients_template_arr[] = $userdata->user_email;
            }
        }

        $recipients_template_arr = array_unique($recipients_template_arr);
        $recipients = apply_filters('useyourdrive_notification_set_recipients', $recipients_template_arr, $this);

        $this->set_recipients($recipients);
    }

    /**
     * Create the placeholder which can be used in the different notification templates
     */
    private function _create_placeholders() {

        $cloud_root_id = $this->get_processor()->get_client()->get_root_folder()->get_id();

        $this->placeholders = array(
            "%admin_email%" => get_option('admin_email'),
            "%site_name%" => get_bloginfo(),
            "%number_of_files%" => count($this->entries),
            "%ip%" => Helpers::get_user_ip(),
            "%folder_name%" => $this->get_folder()->get_name(),
            "%folder_relative_path%" => $this->get_folder()->get_path($this->get_processor()->get_root_folder()),
            "%folder_absolute_path%" => $this->get_folder()->get_path($cloud_root_id),
            "%folder_url" => $this->get_folder()->get_entry()->get_preview_link(),
        );

        /* Current user data */
        $this->placeholders['%user_name%'] = (is_user_logged_in()) ? wp_get_current_user()->display_name : __('An anonymous user', 'useyourdrive');
        $this->placeholders['%user_email%'] = (is_user_logged_in()) ? wp_get_current_user()->user_email : '';


        /* Location data */
        $location_data_required = $this->_is_placeholder_needed('%location%');
        if ($location_data_required) {
            $this->placeholders['%location%'] = Helpers::get_user_location();
        }

        /* File list */
        $filelist = '';
        foreach ($this->entries as $cached_node) {
            $entry = $cached_node->get_entry();

            $direct_download_link = $entry->get_direct_download_link();

            $fileline = strtr($this->_update_depricated_placeholders($this->entry_list), array(
                "%file_name%" => $entry->get_name(),
                "%file_size%" => Helpers::bytes_to_size_1024($entry->get_size()),
                "%file_url%" => (!empty($direct_download_link) ? $entry->get_direct_download_link() : $entry->get_preview_link()),
                "%file_relative_path%" => $cached_node->get_path($this->get_processor()->get_root_folder()),
                "%file_absolute_path%" => $cached_node->get_path($cloud_root_id),
                "%folder_relative_path%" => $this->get_folder()->get_path($this->get_processor()->get_root_folder()),
                "%folder_absolute_path%" => $this->get_folder()->get_path($cloud_root_id),
                "%folder_url" => $this->get_folder()->get_entry()->get_preview_link(),
                "%file_icon%" => $entry->get_default_icon(),
            ));
            $filelist .= $fileline;
        }
        $this->placeholders['%file_list%'] = $filelist;

        /* Set entry placeholders for notifications with a single entry */
        $cached_entry = reset($this->entries);
        $this->placeholders["%file_name%"] = $cached_entry->get_name();
        $this->placeholders["%file_size%"] = Helpers::bytes_to_size_1024($cached_entry->get_entry()->get_size());
        $this->placeholders["%file_relative_path%"] = $cached_entry->get_path($this->get_processor()->get_root_folder());
        $this->placeholders["%file_absolute_path%"] = $cached_entry->get_path($cloud_root_id);
        $this->placeholders["%file_icon%"] = $cached_entry->get_entry()->get_default_thumbnail_icon();
        $this->placeholders["%file_url%"] = (!empty($entry->direct_download_link) ? $entry->get_direct_download_link() : $entry->get_preview_link());

        /* Set page url */
        $current_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $this->placeholders["%current_url%"] = $current_url;
        $this->placeholders["%page_name%"] = get_bloginfo();

        $post_id = url_to_postid($current_url);

        if ($post_id > 0) {
            $this->placeholders["%page_name%"] = get_the_title($post_id);
        }

        /* Add filter for custom placeholders */
        $this->placeholders = apply_filters('useyourdrive_notification_create_placeholders', $this->placeholders, $this);
    }

    /**
     * Update depricated placeholders in template to their new values
     * 
     * @param string $template
     * @return string
     */
    private function _update_depricated_placeholders($template) {

        $template = str_replace('%sitename%', '%site_name%', $template);
        $template = str_replace('%user%', '%user_name%', $template);
        $template = str_replace('%visitor%', '%user_name%', $template);
        $template = str_replace('%filename%', '%file_name%', $template);
        $template = str_replace('%filesize%', '%file_size%', $template);
        $template = str_replace('%filepath%', '%file_path%', $template);
        $template = str_replace('%file_path%', '%file_relative_path%', $template);
        $template = str_replace('%fileicon%', '%file_icon%', $template);
        $template = str_replace('%fileurl%', '%file_url%', $template);
        $template = str_replace('%filelist%', '%file_list%', $template);
        $template = str_replace('%folder%', '%folder_name%', $template);
        $template = str_replace('%folderpath%', '%folder_path%', $template);
        $template = str_replace('%folder_path%', '%folder_relative_path%', $template);
        $template = str_replace('%currenturl%', '%current_url%', $template);

        return $template;
    }

    /**
     * Check if a placeholder needs to be created for the notification
     * Prevent using too many resources when it's needed. (e.g. receiving user location)
     */
    private function _is_placeholder_needed($placeholder) {
        if (strpos($this->subject, $placeholder) !== false) {
            return true;
        }

        if (strpos($this->message, $placeholder) !== false) {
            return true;
        }

        if (strpos($this->entry_list, $placeholder) !== false) {
            return true;
        }

        foreach ($this->recipients as $recipient) {
            if (strpos($recipient, $placeholder) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Fill the placeholders before sending the notification
     */
    private function _fill_placeholders() {
        $this->subject = strtr($this->_update_depricated_placeholders($this->subject), $this->placeholders);
        $this->message = strtr($this->_update_depricated_placeholders($this->message), $this->placeholders);

        $recipients = array();
        foreach ($this->recipients as $key => $recipient) {
            $recipients[$key] = strtr($this->_update_depricated_placeholders($recipient), $this->placeholders);
        }
        $this->recipients = $recipients;
    }

    /**
     * Send the actual notification
     */
    public function send_notification() {

        /* Create and set placeholders */
        $this->_create_placeholders();
        $this->_fill_placeholders();

        /* Skip notification of current user if needed */
        if ($this->skip_notification_for_current_user) {
            $current_user = wp_get_current_user();
            $this->recipients = array_diff($this->recipients, array($current_user->user_email));
        }

        do_action('useyourdrive_notification_before_send', $this);

        $colors = $this->get_processor()->get_setting('colors');
        $template = apply_filters('useyourdrive_notification_set_template', USEYOURDRIVE_ROOTDIR . '/templates/notifications/default_notification.php', $this);

        $subject = $this->get_subject();
        $message = $this->get_message();

        ob_start();
        include_once $template;
        $htmlmessage = Helpers::compress_html(ob_get_clean());

        /* Send mail */
        try {
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $recipients = array_unique($this->get_recipients());

            foreach ($recipients as $recipient) {
                $result = wp_mail($recipient, $subject, $htmlmessage, $headers);
            }
        } catch (\Exception $ex) {
            error_log('[Use-your-Drive message]: ' . sprintf('Could not send notification email on line %s: %s', __LINE__, $ex->getMessage()));
        }

        do_action('useyourdrive_notification_sent', $this);
    }

    function get_type() {
        return $this->type;
    }

    function get_recipients() {
        return $this->recipients;
    }

    function get_subject() {
        return $this->subject;
    }

    function get_message() {
        return $this->message;
    }

    function get_entries() {
        return $this->entries;
    }

    function set_type($type) {
        $this->type = $type;
    }

    function add_recipient($recipient, $id = null) {
        if ($id !== null) {
            $this->recipients[$id] = $recipient;
        } else {
            $this->recipients[] = $recipient;
        }
    }

    function set_recipients($recipients) {
        $this->recipients = $recipients;
    }

    function set_subject($subject) {
        $this->subject = $subject;
    }

    function set_message($message) {
        $this->message = $message;
    }

    function set_entries($entries) {
        $this->entries = $entries;
    }

    function get_entry_list() {
        return $this->entry_list;
    }

    function get_placeholders() {
        return $this->placeholders;
    }

    function get_folder() {
        return $this->folder;
    }

    function get_skip_notification_for_current_user() {
        return $this->skip_notification_for_current_user;
    }

    function set_entry_list($entry_list) {
        $this->entry_list = $entry_list;
    }

    function set_placeholders($placeholders) {
        $this->placeholders = $placeholders;
    }

    function set_folder($folder) {
        $this->folder = $folder;
    }

    function set_skip_notification_for_current_user($skip_notification_for_current_user) {
        $this->skip_notification_for_current_user = $skip_notification_for_current_user;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\Processor
     */
    public function get_processor() {
        return $this->_processor;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\App
     */
    public function get_app() {
        return $this->get_processor()->get_app();
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\Client
     */
    public function get_client() {
        return $this->get_processor()->get_client();
    }

}