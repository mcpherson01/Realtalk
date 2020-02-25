<?php

namespace TheLion\UseyourDrive;

class Processor {

    /**
     *
     * @var \TheLion\UseyourDrive\Main 
     */
    private $_main;

    /**
     *
     * @var \TheLion\UseyourDrive\App 
     */
    private $_app;

    /**
     *
     * @var \TheLion\UseyourDrive\Client 
     */
    private $_client;

    /**
     *
     * @var \TheLion\UseyourDrive\User  
     */
    private $_user;

    /**
     *
     * @var \TheLion\UseyourDrive\UserFolders 
     */
    private $_userfolders;

    /**
     *
     * @var \TheLion\UseyourDrive\Cache 
     */
    private $_cache;

    /**
     *
     * @var \TheLion\UseyourDrive\Shortcodes 
     */
    private $_shortcodes;

    /**
     *
     * @var \TheLion\UseyourDrive\Account 
     */
    private $_current_account;
    public $options = array();
    protected $listtoken = '';
    protected $_rootFolder = null;
    protected $_lastFolder = null;
    protected $_folderPath = null;
    protected $_requestedEntry = null;
    protected $_loadscripts = array('general' => false, 'files' => false, 'upload' => false, 'mediaplayer' => false, 'qtip' => false);
    public $userip;
    public $mobile = false;

    /**
     * Construct the plugin object
     */
    public function __construct(Main $_main) {
        $this->_main = $_main;
        register_shutdown_function(array(&$this, 'do_shutdown'));

        $this->settings = get_option('use_your_drive_settings');

        if ($this->is_network_authorized()) {
            $this->settings = array_merge($this->settings, get_site_option('useyourdrive_network_settings', array()));
        }

        $this->userip = Helpers::get_user_ip();

        if (isset($_REQUEST['mobile']) && ($_REQUEST['mobile'] === 'true')) {
            $this->mobile = true;
        }

        /* If the user wants a hard refresh, set this globally */
        if (isset($_REQUEST['hardrefresh']) && $_REQUEST['hardrefresh'] === 'true' && (!defined('FORCE_REFRESH'))) {
            define('FORCE_REFRESH', true);
        }
    }

    public function start_process() {
        if (!isset($_REQUEST['action'])) {
            error_log('[Use-your-Drive message]: ' . " Function start_process() requires an 'action' request");
            die();
        }

        if (isset($_REQUEST['account_id'])) {
            $requested_account = $this->get_accounts()->get_account_by_id($_REQUEST['account_id']);
            if ($requested_account !== null) {
                $this->set_current_account($requested_account);
            } else {
                error_log(sprintf('[Use-your-Drive message]: ' . " Function start_process() cannot use the requested account (ID: %s) as it isn't linked with the plugin", $_REQUEST['account_id']));
                die();
            }
        }

        do_action('useyourdrive_before_start_process', $_REQUEST['action'], $this);

        $authorized = $this->_is_action_authorized();

        if (($authorized === true) && ($_REQUEST['action'] === 'useyourdrive-revoke')) {
            if (Helpers::check_user_role($this->settings['permissions_edit_settings'])) {

                if ($this->get_current_account() === null) {
                    die(-1);
                }

                if ($_REQUEST['force'] === 'true') {
                    $this->get_accounts()->remove_account($this->get_current_account()->get_id());
                } else {
                    $this->get_app()->revoke_token($this->get_current_account());
                }
            }
            die(1);
        }

        if ($_REQUEST['action'] === 'useyourdrive-reset-cache') {
            if (Helpers::check_user_role($this->settings['permissions_edit_settings'])) {
                $this->reset_complete_cache();
            }
            die(1);
        }

        if ($_REQUEST['action'] === 'useyourdrive-reset-statistics') {
            if (Helpers::check_user_role($this->settings['permissions_edit_settings'])) {
                Events::truncate_database();
            }
            die(1);
        }

        if (is_wp_error($authorized)) {
            error_log('[Use-your-Drive message]: ' . " Function start_process() isn't authorized");

            if ($this->options['debug'] === '1') {
                die($authorized->get_error_message());
            } else {
                die();
            }
        }

        if ((!isset($_REQUEST['listtoken']))) {
            error_log('[Use-your-Drive message]: ' . " Function start_process() requires a 'listtoken' request");
            die();
        }

        $this->listtoken = $_REQUEST['listtoken'];
        $this->options = $this->get_shortcodes()->get_shortcode_by_id($this->listtoken);

        if ($this->options === false) {
            $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            error_log('[Use-your-Drive message]: ' . " Function start_process(" . $_REQUEST['action'] . ") hasn't received a valid listtoken (" . $this->listtoken . ") on: $url \n");
            die();
        }

        if ($this->get_current_account() === null || $this->get_current_account()->get_authorization()->has_access_token() === false) {
            error_log('[Use-your-Drive message]: ' . " Function _is_action_authorized() discovered that the plugin doesn't have an access token");
            return new \WP_Error('broke', '<strong>' . __("Use-your-Drive needs your help!", 'useyourdrive') . '</strong> ' . __('Authorize the plugin.', 'useyourdrive') . '.');
        }

        $this->get_client();

        /* Refresh Cache if needed */
        //$this->get_cache()->reset_cache();

        /* Remove all cache files for current shortcode when refreshing, otherwise check for new changes */
        if (defined('FORCE_REFRESH')) {
            CacheRequest::clear_local_cache_for_shortcode($this->get_listtoken());
            $this->get_cache()->pull_for_changes();
        } else {
            /* Pull for changes if needed */
            if ($this->get_setting('cache_update_via_wpcron') === 'No') {
                $this->get_cache()->pull_for_changes();
            }
        }

        /* Set rootFolder */
        if ($this->options['user_upload_folders'] === 'manual') {
            $userfolder = $this->get_user_folders()->get_manually_linked_folder_for_user();
            if ($userfolder === false) {
                error_log('[Use-your-Drive message]: ' . 'Cannot find a manually linked folder for user');
                die('-1');
            }
            $this->_rootFolder = $userfolder->get_id();
        } else if (($this->options['user_upload_folders'] === 'auto') && !Helpers::check_user_role($this->options['view_user_folders_role'])) {
            $userfolder = $this->get_user_folders()->get_auto_linked_folder_for_user();

            if ($userfolder === false) {
                error_log('[Use-your-Drive message]: ' . 'Cannot find a auto linked folder for user');
                die('-1');
            }
            $this->_rootFolder = $userfolder->get_id();
        } else {
            $this->_rootFolder = $this->options['root'];
        }

        if ($this->get_user()->can_view() === false) {
            error_log('[Use-your-Drive message]: ' . " Function start_process() discovered that an user didn't have the permission to view the plugin");
            die();
        }

        $this->_lastFolder = $this->_rootFolder;
        if (isset($_REQUEST['lastFolder']) && $_REQUEST['lastFolder'] !== '') {
            $this->_lastFolder = $_REQUEST['lastFolder'];
        }

        $this->_requestedEntry = $this->_lastFolder;
        if (isset($_REQUEST['id']) && $_REQUEST['id'] !== '') {
            $this->_requestedEntry = $_REQUEST['id'];
        }

        if (!empty($_REQUEST['folderPath'])) {
            $this->_folderPath = json_decode(base64_decode($_REQUEST['folderPath']), true);

            if ($this->_folderPath === false || $this->_folderPath === null || !is_array($this->_folderPath)) {

                /* Build path when starting somewhere in the folder */
                $current_entry = $this->get_client()->get_entry($this->get_requested_entry());

                if (!empty($current_entry)) {
                    $parents = $current_entry->get_all_parent_folders();
                    $folder_path = array();

                    foreach ($parents as $parent_id => $parent) {
                        $is_in_root = $parent->is_in_folder($this->_rootFolder);

                        if ($is_in_root === false) {
                            break;
                        }

                        $folder_path[] = $parent_id;
                    }

                    $this->_folderPath = array_reverse($folder_path);
                } else {
                    $this->_folderPath = array($this->_rootFolder);
                }
            }

            $key = array_search($this->_requestedEntry, $this->_folderPath);
            if ($key !== false) {
                array_splice($this->_folderPath, $key);
                if (count($this->_folderPath) === 0) {
                    $this->_folderPath = array($this->_rootFolder);
                }
            }
        } else {
            $this->_folderPath = array($this->_rootFolder);
        }

        /* Check if the request is cached */
        if (in_array($_REQUEST['action'], array('useyourdrive-get-filelist', 'useyourdrive-get-gallery', 'useyourdrive-get-playlist', 'useyourdrive-thumbnail'))) {

            /* And Set GZIP compression if possible */
            $this->_set_gzip_compression();

            if (!defined('FORCE_REFRESH')) {
                $cached_request = new CacheRequest($this);
                if ($cached_request->is_cached()) {
                    echo $cached_request->get_cached_response();
                    die();
                }
            }
        }

        do_action('useyourdrive_start_process', $_REQUEST['action'], $this);

        switch ($_REQUEST['action']) {

            case 'useyourdrive-get-filelist':

                $filebrowser = new Filebrowser($this);

                if (isset($_REQUEST['query']) && !empty($_REQUEST['query']) && $this->options['search'] === '1') { // Search files
                    $filelist = $filebrowser->search_files();
                } else {
                    $filelist = $filebrowser->get_files_list(); // Read folder
                }

                break;

            case 'useyourdrive-download':
                if ($this->get_user()->can_download() === false) {
                    die();
                }

                $file = $this->get_client()->download_entry();
                break;
            case 'useyourdrive-preview':
                $file = $this->get_client()->preview_entry();
                break;

            case 'useyourdrive-edit':
                if ($this->get_user()->can_edit() === false) {
                    die();
                }

                $file = $this->get_client()->edit_entry();
                break;


            case 'useyourdrive-thumbnail':
                if (isset($_REQUEST['type']) && $_REQUEST['type'] === 'folder-thumbnails') {
                    $thumbnails = $this->get_client()->get_folder_thumbnails();
                    $response = json_encode($thumbnails);

                    $cached_request = new CacheRequest($this);
                    $cached_request->add_cached_response($response);

                    echo $response;
                } else {
                    $file = $this->get_client()->build_thumbnail();
                }
                break;
            case 'useyourdrive-create-zip':
                $file = $this->get_client()->download_entries_as_zip();
                break;


            case 'useyourdrive-embedded':
                $links = $this->get_client()->create_links(false);
                echo json_encode($links);
                break;
            case 'useyourdrive-create-link':

                if (isset($_REQUEST['entries'])) {
                    $links = $this->get_client()->create_links();
                    echo json_encode($links);
                } else {
                    $link = $this->get_client()->create_link();
                    echo json_encode($link);
                }

                break;

            case 'useyourdrive-get-gallery':
                if (is_wp_error($authorized)) {
// No valid token is set
                    echo json_encode(array('lastpath' => base64_encode(json_encode($this->_lastFolder)), 'folder' => '', 'html' => ''));
                    die();
                }

                $gallery = new Gallery($this);

                if (isset($_REQUEST['query']) && !empty($_REQUEST['query']) && $this->options['search'] === '1') { // Search files
                    $imagelist = $gallery->search_image_files();
                } else {
                    $imagelist = $gallery->get_images_list(); // Read folder
                }

                break;

            case 'useyourdrive-upload-file':
                $user_can_upload = $this->get_user()->can_upload();

                if (is_wp_error($authorized) || $user_can_upload === false) {
                    die();
                }

                $upload_processor = new Upload($this);

                switch ($_REQUEST['type']) {
                    case 'do-upload':
                        $upload = $upload_processor->do_upload();
                        break;
                    case 'get-status':
                        $status = $upload_processor->get_upload_status();
                        break;
                    case 'get-direct-url':
                        $status = $upload_processor->do_upload_direct();
                        break;
                    case 'upload-convert':
                        $status = $upload_processor->upload_convert();
                        break;
                    case 'upload-postprocess':
                        $status = $upload_processor->upload_post_process();
                        break;
                }

                die();
                break;

            case 'useyourdrive-delete-entries':
//Check if user is allowed to delete entry
                $user_can_delete = $this->get_user()->can_delete_files() || $this->get_user()->can_delete_folders();

                if (is_wp_error($authorized) || $user_can_delete === false) {
                    echo json_encode(array('result' => '-1', 'msg' => __('Failed to delete entry', 'useyourdrive')));
                    die();
                }

                $entries_to_delete = array();
                foreach ($_REQUEST['entries'] as $requested_id) {
                    $entries_to_delete[] = $requested_id;
                }

                $entries = $this->get_client()->delete_entries($entries_to_delete);

                foreach ($entries as $entry) {
                    if (is_wp_error($entry)) {
                        echo json_encode(array('result' => '-1', 'msg' => __('Not all entries could be deleted', 'useyourdrive')));
                        die();
                    }
                }
                echo json_encode(array('result' => '1', 'msg' => __('Entry was deleted', 'useyourdrive')));

                die();
                break;

            case 'useyourdrive-rename-entry':
//Check if user is allowed to rename entry
                $user_can_rename = $this->get_user()->can_rename_files() || $this->get_user()->can_rename_folders();

                if ($user_can_rename === false) {
                    echo json_encode(array('result' => '-1', 'msg' => __('Failed to rename entry', 'useyourdrive')));
                    die();
                }

//Strip unsafe characters
                $newname = rawurldecode($_REQUEST['newname']);
                $new_filename = Helpers::filter_filename($newname, false);

                $file = $this->get_client()->rename_entry($new_filename);

                if (is_wp_error($file)) {
                    echo json_encode(array('result' => '-1', 'msg' => $file->get_error_message()));
                } else {
                    echo json_encode(array('result' => '1', 'msg' => __('Entry was renamed', 'useyourdrive')));
                }

                die();
                break;

            case 'useyourdrive-move-entries':
                /* Check if user is allowed to move entry */
                $user_can_move = $this->get_user()->can_move_files() || $this->get_user()->can_move_folders();

                if ($user_can_move === false) {
                    echo json_encode(array('result' => '-1', 'msg' => __('Failed to move', 'useyourdrive')));
                    die();
                }

                $entries_to_move = array();
                foreach ($_REQUEST['entries'] as $requested_id) {
                    $entries_to_move[] = $requested_id;
                }


                $entries = $this->get_client()->move_entries($entries_to_move, $_REQUEST['target']);

                foreach ($entries as $entry) {
                    if (is_wp_error($entry) || empty($entry)) {
                        echo json_encode(array('result' => '-1', 'msg' => __('Not all entries could be moved', 'useyourdrive')));
                        die();
                    }
                }
                echo json_encode(array('result' => '1', 'msg' => __('Successfully moved to new location', 'useyourdrive')));

                die();
                break;

            case 'useyourdrive-edit-description-entry':
                //Check if user is allowed to rename entry
                $user_can_editdescription = $this->get_user()->can_edit_description();

                if ($user_can_editdescription === false) {
                    echo json_encode(array('result' => '-1', 'msg' => __('Failed to edit description', 'useyourdrive')));
                    die();
                }

                $newdescription = rawurldecode($_REQUEST['newdescription']);
                $result = $this->get_client()->update_description($newdescription);

                if (is_wp_error($result)) {
                    echo json_encode(array('result' => '-1', 'msg' => $result->get_error_message()));
                } else {
                    echo json_encode(array('result' => '1', 'msg' => __('Description was edited', 'useyourdrive'), 'description' => $result));
                }

                die();
                break;


            case 'useyourdrive-add-folder':

//Check if user is allowed to add folder
                $user_can_addfolder = $this->get_user()->can_add_folders();

                if ($user_can_addfolder === false) {
                    echo json_encode(array('result' => '-1', 'msg' => __('Failed to add folder', 'useyourdrive')));
                    die();
                }

//Strip unsafe characters
                $newfolder = rawurldecode($_REQUEST['newfolder']);
                $new_foldername = Helpers::filter_filename($newfolder, false);

                $file = $this->get_client()->add_folder($new_foldername);

                if (is_wp_error($file)) {
                    echo json_encode(array('result' => '-1', 'msg' => $file->get_error_message()));
                } else {
                    echo json_encode(array('result' => '1', 'msg' => __('Folder', 'useyourdrive') . ' ' . $newfolder . ' ' . __('was added', 'useyourdrive'), 'lastFolder' => $file->get_id()));
                }
                die();
                break;

            case 'useyourdrive-get-playlist':
                $mediaplayer = new Mediaplayer($this);
                $playlist = $mediaplayer->get_media_list();

                break;

            case 'useyourdrive-stream':
                $file = $this->get_client()->stream_entry();
                break;

            default:
                error_log('[Use-your-Drive message]: ' . sprintf('No valid AJAX call: %s', $_REQUEST['action']));
                die('Use-your-Drive: ' . __('no valid AJAX call', 'useyourdrive'));
        }

        die();
    }

    public function create_from_shortcode($atts) {

        $atts = (is_string($atts)) ? array() : $atts;
        $atts = $this->remove_deprecated_options($atts);

        $defaults = array(
            'singleaccount' => '1',
            'account' => false,
            'startaccount' => false,
            'dir' => false,
            'class' => '',
            'startid' => false,
            'mode' => 'files',
            'userfolders' => '0',
            'usertemplatedir' => '',
            'viewuserfoldersrole' => 'administrator',
            'userfoldernametemplate' => '',
            'showfiles' => '1',
            'maxfiles' => '-1',
            'showfolders' => '1',
            'filesize' => '1',
            'filedate' => '1',
            'filelayout' => 'grid',
            'showcolumnnames' => '1',
            'showext' => '1',
            'sortfield' => 'name',
            'sortorder' => 'asc',
            'showbreadcrumb' => '1',
            'candownloadzip' => '0',
            'canpopout' => '0',
            'lightboxnavigation' => '1',
            'showsharelink' => '0',
            'showrefreshbutton' => '1',
            'roottext' => __('Start', 'useyourdrive'),
            'search' => '1',
            'searchcontents' => '0',
            'searchfrom' => 'parent',
            'include' => '*',
            'includeext' => '*',
            'exclude' => '*',
            'excludeext' => '*',
            'maxwidth' => '100%',
            'maxheight' => '',
            'viewrole' => 'administrator|editor|author|contributor|subscriber|pending|guest',
            'downloadrole' => 'administrator|editor|author|contributor|subscriber|pending|guest',
            'sharerole' => 'all',
            'edit' => '0',
            'editrole' => 'administrator|editor|author',
            'previewinline' => '1',
            'forcedownload' => '0',
            'maximages' => '25',
            'quality' => '90',
            'slideshow' => '0',
            'pausetime' => '5000',
            'showfilenames' => '0',
            'targetheight' => '200',
            'mediaskin' => '',
            'mediabuttons' => 'prevtrack|playpause|nexttrack|volume|current|duration|fullscreen',
            'autoplay' => '0',
            'hideplaylist' => '0',
            'showplaylistonstart' => '1',
            'playlistinline' => '0',
            'playlistthumbnails' => '1',
            'linktomedia' => '0',
            'linktoshop' => '',
            'ads' => '0',
            'ads_tag_url' => '',
            'ads_skipable' => '1',
            'ads_skipable_after' => '',
            'notificationupload' => '0',
            'notificationdownload' => '0',
            'notificationdeletion' => '0',
            'notificationemail' => '%admin_email%',
            'notification_skipemailcurrentuser' => '0',
            'upload' => '0',
            'upload_folder' => '1',
            'uploadext' => '.',
            'uploadrole' => 'administrator|editor|author|contributor|subscriber',
            'upload_encryption' => '0',
            'upload_encryption_passphrase' => '',
            'minfilesize' => '0',
            'maxfilesize' => '0',
            'maxnumberofuploads' => '-1',
            'convert' => '0',
            'convertformats' => 'all',
            'overwrite' => '0',
            'delete' => '0',
            'deletefilesrole' => 'administrator|editor',
            'deletefoldersrole' => 'administrator|editor',
            'deletetotrash' => '1',
            'rename' => '0',
            'renamefilesrole' => 'administrator|editor',
            'renamefoldersrole' => 'administrator|editor',
            'move' => '0',
            'movefilesrole' => 'administrator|editor',
            'movefoldersrole' => 'administrator|editor',
            'editdescription' => '0',
            'editdescriptionrole' => 'administrator|editor',
            'addfolder' => '0',
            'addfolderrole' => 'administrator|editor',
            'mcepopup' => '0',
            'debug' => '0',
            'demo' => '0'
        );

        //Create a unique identifier
        $this->listtoken = md5(serialize($defaults) . serialize($atts));

        //Read shortcode
        extract(shortcode_atts($defaults, $atts));

        $cached_shortcode = $this->get_shortcodes()->get_shortcode_by_id($this->listtoken);

        if ($cached_shortcode === false) {

            switch ($mode) {
                case 'gallery':
                    $includeext = ($includeext == '*') ? 'gif|jpg|jpeg|png|bmp' : $includeext;
                    $uploadext = ($uploadext == '.') ? 'gif|jpg|jpeg|png|bmp' : $uploadext;
                case 'search':
                    $searchfrom = 'root';
                default:
                    break;
            }

            if (!empty($account)) {
                $singleaccount = '1';
            }

            if ($singleaccount === '0') {
                $dir = 'drive';
                $account = false;
            }

            if (empty($account)) {
                $primary_account = $this->get_accounts()->get_primary_account();
                if ($primary_account !== null) {
                    $account = $primary_account->get_id();
                }
            }

            $account_class = $this->get_accounts()->get_account_by_id($account);
            if ($account_class === null) {
                error_log('[Use-your-Drive message]: shortcode cannot be rendered as the requested account is not linked with the plugin');
                return '<i>>>> ' . __('ERROR: Contact the Administrator to see this content', 'useyourdrive') . ' <<<</i>';
            }

            $this->set_current_account($account_class);

            $rootfolder = $this->get_client()->get_root_folder();
            if (is_wp_error($rootfolder)) {
                if ($debug === '1') {
                    return "<div id='message' class='error'><p>" . $rootfolder->get_error_message() . "</p></div>";
                }
                return false;
            } elseif (empty($rootfolder)) {
                if ($debug === '1') {
                    return "<div id='message' class='error'><p>" . __('Please authorize Use-your-Drive', 'useyourdrive') . "</p></div>";
                }
                return false;
            }
            $rootfolderid = $rootfolder->get_id();

            if (empty($dir)) {
                $dir = $this->get_client()->get_my_drive()->get_id();
            }

//Force $candownloadzip = 0 if we can't use ZipArchive
            if (!class_exists('ZipArchive')) {
                $candownloadzip = '0';
            }

            if ($upload_encryption === '1' && (version_compare(phpversion(), '7.1.0', '>'))) {
                $upload_encryption = '0';
            }

            $convertformats = explode('|', $convertformats);

// Explode roles
            $viewrole = explode('|', $viewrole);
            $downloadrole = explode('|', $downloadrole);
            $sharerole = explode('|', $sharerole);
            $editrole = explode('|', $editrole);
            $uploadrole = explode('|', $uploadrole);
            $deletefilesrole = explode('|', $deletefilesrole);
            $deletefoldersrole = explode('|', $deletefoldersrole);
            $renamefilesrole = explode('|', $renamefilesrole);
            $renamefoldersrole = explode('|', $renamefoldersrole);
            $movefilesrole = explode('|', $movefilesrole);
            $movefoldersrole = explode('|', $movefoldersrole);
            $editdescriptionrole = explode('|', $editdescriptionrole);
            $addfolderrole = explode('|', $addfolderrole);
            $viewuserfoldersrole = explode('|', $viewuserfoldersrole);
            $mediabuttons = explode('|', $mediabuttons);

            $this->options = array(
                'single_account' => $singleaccount,
                'account' => $account,
                'startaccount' => $startaccount,
                'root' => $dir,
                'class' => $class,
                'base' => $rootfolderid,
                'startid' => $startid,
                'mode' => $mode,
                'user_upload_folders' => $userfolders,
                'user_template_dir' => $usertemplatedir,
                'view_user_folders_role' => $viewuserfoldersrole,
                'user_folder_name_template' => $userfoldernametemplate,
                'mediaskin' => $mediaskin,
                'mediabuttons' => $mediabuttons,
                'autoplay' => $autoplay,
                'hideplaylist' => $hideplaylist,
                'showplaylistonstart' => $showplaylistonstart,
                'playlistinline' => $playlistinline,
                'playlistthumbnails' => $playlistthumbnails,
                'linktomedia' => $linktomedia,
                'linktoshop' => $linktoshop,
                'ads' => $ads,
                'ads_tag_url' => $ads_tag_url,
                'ads_skipable' => $ads_skipable,
                'ads_skipable_after' => $ads_skipable_after,
                'show_files' => $showfiles,
                'show_folders' => $showfolders,
                'show_filesize' => $filesize,
                'show_filedate' => $filedate,
                'max_files' => $maxfiles,
                'filelayout' => $filelayout,
                'show_columnnames' => $showcolumnnames,
                'show_ext' => $showext,
                'sort_field' => $sortfield,
                'sort_order' => $sortorder,
                'show_breadcrumb' => $showbreadcrumb,
                'can_download_zip' => $candownloadzip,
                'can_popout' => $canpopout,
                'lightbox_navigation' => $lightboxnavigation,
                'show_sharelink' => $showsharelink,
                'show_refreshbutton' => $showrefreshbutton,
                'root_text' => $roottext,
                'search' => $search,
                'searchcontents' => $searchcontents,
                'searchfrom' => $searchfrom,
                'include' => explode('|', htmlspecialchars_decode($include)),
                'include_ext' => explode('|', strtolower($includeext)),
                'exclude' => explode('|', htmlspecialchars_decode($exclude)),
                'exclude_ext' => explode('|', strtolower($excludeext)),
                'maxwidth' => $maxwidth,
                'maxheight' => $maxheight,
                'view_role' => $viewrole,
                'download_role' => $downloadrole,
                'share_role' => $sharerole,
                'edit' => $edit,
                'edit_role' => $editrole,
                'previewinline' => $previewinline,
                'forcedownload' => $forcedownload,
                'maximages' => $maximages,
                'notificationupload' => $notificationupload,
                'notificationdownload' => $notificationdownload,
                'notificationdeletion' => $notificationdeletion,
                'notificationemail' => $notificationemail,
                'notification_skip_email_currentuser' => $notification_skipemailcurrentuser,
                'upload' => $upload,
                'upload_folder' => $upload_folder,
                'upload_ext' => strtolower($uploadext),
                'upload_role' => $uploadrole,
                'upload_encryption' => $upload_encryption,
                'upload_encryption_passphrase' => $upload_encryption_passphrase,
                'minfilesize' => $minfilesize,
                'maxfilesize' => $maxfilesize,
                'maxnumberofuploads' => $maxnumberofuploads,
                'convert' => $convert,
                'convert_formats' => $convertformats,
                'overwrite' => $overwrite,
                'delete' => $delete,
                'delete_files_role' => $deletefilesrole,
                'delete_folders_role' => $deletefoldersrole,
                'deletetotrash' => $deletetotrash,
                'rename' => $rename,
                'rename_files_role' => $renamefilesrole,
                'rename_folders_role' => $renamefoldersrole,
                'move' => $move,
                'move_files_role' => $movefilesrole,
                'move_folders_role' => $movefoldersrole,
                'editdescription' => $editdescription,
                'editdescription_role' => $editdescriptionrole,
                'addfolder' => $addfolder,
                'addfolder_role' => $addfolderrole,
                'quality' => $quality,
                'show_filenames' => $showfilenames,
                'targetheight' => $targetheight,
                'slideshow' => $slideshow,
                'pausetime' => $pausetime,
                'mcepopup' => $mcepopup,
                'debug' => $debug,
                'demo' => $demo,
                'expire' => strtotime('+1 weeks'),
                'listtoken' => $this->listtoken);

            $this->options = apply_filters('useyourdrive_shortcode_add_options', $this->options, $this, $atts);

            $this->save_shortcodes();

            $this->options = apply_filters('useyourdrive_shortcode_set_options', $this->options, $this, $atts);

//Create userfolders if needed

            if (($this->options['user_upload_folders'] === 'auto')) {
                if ($this->settings['userfolder_onfirstvisit'] === 'Yes') {

                    $allusers = array();
                    $roles = $this->options['view_role'];

                    foreach ($roles as $role) {
                        $users_query = new \WP_User_Query(array(
                            'fields' => 'all_with_meta',
                            'role' => $role,
                            'orderby' => 'display_name'
                        ));
                        $results = $users_query->get_results();
                        if ($results) {
                            $allusers = array_merge($allusers, $results);
                        }
                    }

                    $userfolder = $this->get_user_folders()->create_user_folders($allusers);
                }
            }
        } else {
            $this->options = apply_filters('useyourdrive_shortcode_set_options', $cached_shortcode, $this, $atts);
        }

        if ($this->get_current_account() === null || $this->get_current_account()->get_authorization()->has_access_token() === false) {
            return '<i>>>> ' . __('ERROR: Contact the Administrator to see this content', 'useyourdrive') . ' <<<</i>';
        }

        ob_start();
        $this->render_template();

        return ob_get_clean();
    }

    public function render_template() {

        /* Reload User Object for this new shortcode */
        $user = $this->get_user('reload');


        if ($this->get_user()->can_view() === false) {
            do_action('useyourdrive_shortcode_no_view_permission', $this);
            return;
        }

        /* Render the  template */
        $dataid = ''; //(($this->options['user_upload_folders'] !== '0') && !Helpers::check_user_role($this->options['view_user_folders_role'])) ? '' : $this->options['root'];

        $colors = $this->get_setting('colors');

        if ($this->options['user_upload_folders'] === 'manual') {
            $userfolder = get_user_option('use_your_drive_linkedto');
            if (is_array($userfolder) && isset($userfolder['folderid'])) {
                $dataid = $userfolder['folderid'];
            } else {
                $defaultuserfolder = get_site_option('use_your_drive_guestlinkedto');
                if (is_array($defaultuserfolder) && isset($defaultuserfolder['folderid'])) {
                    $dataid = $defaultuserfolder['folderid'];
                } else {
                    echo "<div id='UseyourDrive' class='{$colors['style']}'>";
                    $this->load_scripts('general');
                    include(sprintf("%s/templates/noaccess.php", USEYOURDRIVE_ROOTDIR));
                    echo "</div>";
                    return;
                }
            }
        }

        $dataorgid = $dataid;
        $dataid = ($this->options['startid'] !== false) ? $this->options['startid'] : $dataid;
        $dataaccountid = ($this->options['startaccount'] !== false) ? $this->options['startaccount'] : $this->options['account'];

        $shortcode_class = ($this->options['mcepopup'] === 'shortcode') ? 'initiate' : '';

        do_action('useyourdrive_before_shortcode', $this);

        echo "<div id='UseyourDrive' class='{$colors['style']} {$this->options['class']} {$this->options['mode']} {$shortcode_class}' style='display:none'>";
        echo "<noscript><div class='UseyourDrive-nojsmessage'>" . __('To view the Google Drive folders, you need to have JavaScript enabled in your browser', 'useyourdrive') . ".<br/>";
        echo "<a href='http://www.enable-javascript.com/' target='_blank'>" . __('To do so, please follow these instructions', 'useyourdrive') . "</a>.</div></noscript>";

        switch ($this->options['mode']) {
            case 'files':

                $this->load_scripts('files');

                echo "<div id='UseyourDrive-$this->listtoken' class='UseyourDrive files uyd-{$this->options['filelayout']} jsdisabled' data-list='files' data-token='$this->listtoken' data-account-id='$dataaccountid' data-id='$dataid' data-path='" . base64_encode(json_encode($this->_folderPath)) . "' data-sort='{$this->options['sort_field']}:{$this->options['sort_order']}' data-org-id='{$dataorgid}' data-org-path='" . base64_encode(json_encode($this->_folderPath)) . "' data-layout='{$this->options['filelayout']}' data-popout='{$this->options['can_popout']}' data-lightboxnav='{$this->options['lightbox_navigation']}'>";


                if ($this->options['mcepopup'] === 'shortcode') {
                    echo "<div class='selected-folder'><strong>" . __('Selected folder', 'useyourdrive') . ": </strong><span class='current-folder-raw'></span></div>";
                }

                if ($this->get_shortcode_option('mcepopup') === 'linkto' || $this->get_shortcode_option('mcepopup') === 'linktobackendglobal') {
                    $rootfolder = $this->get_client()->get_root_folder();
                    $button_text = __('Use the Root Folder of your Account', 'useyourdrive');

                    if ($rootfolder->get_id() !== 'drive') {
                        echo '<div data-id="' . $rootfolder->get_id() . '" data-name="' . $rootfolder->get_name() . '">';
                        echo '<div class="entry_linkto entry_linkto_root">';
                        echo '<span><input class="button-secondary" type="submit" title="' . $button_text . '" value="' . $button_text . '"></span>';
                        echo "</div>";
                        echo "</div>";
                    }
                }

                include(sprintf("%s/templates/frontend.php", USEYOURDRIVE_ROOTDIR));
                $this->render_uploadform();

                echo "</div>";
                break;

            case 'upload':

                echo "<div id='UseyourDrive-$this->listtoken' class='UseyourDrive upload jsdisabled'  data-token='$this->listtoken' data-account-id='{$this->options['account']}' data-id='" . $dataid . "' data-path='" . base64_encode(json_encode($this->_folderPath)) . "' >";
                $this->render_uploadform();
                echo "</div>";
                break;


            case 'gallery':

                $this->load_scripts('files');

                $nextimages = '';
                if (($this->options['maximages'] !== '0')) {
                    $nextimages = "data-loadimages='" . $this->options['maximages'] . "'";
                }

                echo "<div id='UseyourDrive-$this->listtoken' class='UseyourDrive gridgallery jsdisabled' data-list='gallery' data-token='$this->listtoken' data-account-id='{$this->options['account']}' data-id='" . $dataid . "' data-path='" . base64_encode(json_encode($this->_folderPath)) . "' data-sort='" . $this->options['sort_field'] . ":" . $this->options['sort_order'] . "' data-org-id='" . $dataid . "' data-org-path='" . base64_encode(json_encode($this->_folderPath)) . "' data-targetheight='" . $this->options['targetheight'] . "' data-slideshow='" . $this->options['slideshow'] . "' data-pausetime='" . $this->options['pausetime'] . "' $nextimages data-lightboxnav='" . $this->options['lightbox_navigation'] . "'>";
                include(sprintf("%s/templates/gallery.php", USEYOURDRIVE_ROOTDIR));
                $this->render_uploadform();
                echo "</div>";
                break;

            case 'search':
                echo "<div id='UseyourDrive-$this->listtoken' class='UseyourDrive files uyd-" . $this->options['filelayout'] . " searchlist jsdisabled' data-list='search' data-token='$this->listtoken' data-account-id='{$this->options['account']}' data-id='" . $dataid . "' data-path='" . base64_encode(json_encode($this->_folderPath)) . "' data-sort='" . $this->options['sort_field'] . ":" . $this->options['sort_order'] . "' data-org-id='" . $dataorgid . "' data-org-path='" . base64_encode(json_encode($this->_folderPath)) . "' data-layout='" . $this->options['filelayout'] . "' data-popout='" . $this->options['can_popout'] . "' data-lightboxnav='" . $this->options['lightbox_navigation'] . "'>";
                $this->load_scripts('files');
                include(sprintf("%s/templates/search.php", USEYOURDRIVE_ROOTDIR));
                echo "</div>";
                break;

            case 'video':
            case 'audio':
                $mediaplayer = $this->load_mediaplayer($this->options['mediaskin']);

                echo "<div id='UseyourDrive-$this->listtoken' class='UseyourDrive media " . $this->options['mode'] . " jsdisabled' data-list='media' data-token='$this->listtoken' data-account-id='{$this->options['account']}' data-id='" . $dataid . "' data-sort='" . $this->options['sort_field'] . ":" . $this->options['sort_order'] . "'>";
                $mediaplayer->load_player();
                echo "</div>";
                $this->load_scripts('mediaplayer');
                break;
        }

        echo "<script type='text/javascript'>if (typeof(jQuery) !== 'undefined' && typeof(jQuery.cp) !== 'undefined' && typeof(jQuery.cp.UseyourDrive) === 'function') { jQuery('#UseyourDrive-$this->listtoken').UseyourDrive(UseyourDrive_vars); };</script>";
        echo "</div>";

        do_action('useyourdrive_after_shortcode', $this);

        $this->load_scripts('general');
    }

    public function render_uploadform() {
        $user_can_upload = $this->get_user()->can_upload();

        if ($user_can_upload === false) {
            return;
        }

        $own_limit = ($this->options['maxfilesize'] !== '0');
        $post_max_size_bytes = min(Helpers::return_bytes(ini_get('post_max_size')), Helpers::return_bytes(ini_get('upload_max_filesize')));
        $max_file_size = ($this->options['maxfilesize'] !== '0') ? Helpers::return_bytes($this->options['maxfilesize']) : ($post_max_size_bytes);
        $min_file_size = (!empty($this->options['minfilesize'])) ? Helpers::return_bytes($this->options['minfilesize']) : '0';

        $post_max_size_str = Helpers::bytes_to_size_1024($max_file_size);
        $min_file_size_str = Helpers::bytes_to_size_1024($min_file_size);

        $acceptfiletypes = '.(' . $this->options['upload_ext'] . ')$';
        $max_number_of_uploads = $this->options['maxnumberofuploads'];
        $upload_encryption = ($this->options['upload_encryption'] === '1' && (version_compare(phpversion(), '7.1.0', '<=')));

        $this->load_scripts('upload');
        include(sprintf("%s/templates/uploadform.php", USEYOURDRIVE_ROOTDIR));
    }

    public function get_last_folder() {
        return $this->_lastFolder;
    }

    public function get_last_path() {
        return $this->_lastPath;
    }

    protected function set_last_path($path) {
        $this->_lastPath = $path;
        if ($this->_lastPath === '') {
            $this->_lastPath = null;
        }
        return $this->_lastPath;
    }

    public function get_root_folder() {
        return $this->_rootFolder;
    }

    public function get_folder_path() {
        return $this->_folderPath;
    }

    public function get_listtoken() {
        return $this->listtoken;
    }

    protected function load_scripts($template) {
        if ($this->_loadscripts[$template] === true) {
            return false;
        }

        switch ($template) {
            case 'general':
                if (defined('WPCP_DISABLE_FONTAWESOME') === false) {
                    wp_enqueue_style('Awesome-Font-5-css');
                    if ($this->get_setting('fontawesomev4_shim') === 'Yes') {
                        wp_enqueue_style('Awesome-Font-4-shim-css');
                    }
                }

                wp_enqueue_style('UseyourDrive');
                wp_enqueue_script('UseyourDrive');

                add_action('wp_footer', array($this->get_main(), 'load_custom_css'), 100);
                add_action('admin_footer', array($this->get_main(), 'load_custom_css'), 100);
                break;
            case 'files':
                wp_enqueue_style('qtip');

                if ($this->get_user()->can_move_files() || $this->get_user()->can_move_folders()) {
                    wp_enqueue_script('jquery-ui-droppable');
                    wp_enqueue_script('jquery-ui-draggable');
                }

                wp_enqueue_script('jquery-effects-core');
                wp_enqueue_script('jquery-effects-fade');
                wp_enqueue_style('ilightbox');
                wp_enqueue_style('ilightbox-skin-useyourdrive');
                wp_enqueue_script('google-recaptcha');
                break;
            case 'mediaplayer':
                break;
            case 'upload':
                wp_enqueue_script('jquery-ui-droppable');
                wp_enqueue_script('jquery-ui-button');
                wp_enqueue_script('jquery-ui-progressbar');
                wp_enqueue_script('jQuery.iframe-transport');
                wp_enqueue_script('jQuery.fileupload-uyd');
                wp_enqueue_script('jQuery.fileupload-process');
                wp_enqueue_script('google-recaptcha');
                break;
        }

        $this->_loadscripts[$template] = true;
    }

    public function load_mediaplayer($mediaplayer) {
        if (empty($mediaplayer)) {
            $mediaplayer = $this->get_setting('mediaplayer_skin');
        }

        if (file_exists(USEYOURDRIVE_ROOTDIR . '/skins/' . $mediaplayer . '/Player.php')) {
            require_once USEYOURDRIVE_ROOTDIR . '/skins/' . $mediaplayer . '/Player.php';
        } else {
            error_log('[Use-your-Drive message]: ' . sprintf('Media Player Skin %s is missing', $mediaplayer));
            return $this->load_mediaplayer(null);
        }

        try {
            $class = '\TheLion\UseyourDrive\MediaPlayers\\' . $mediaplayer;
            return new $class($this);
        } catch (\Exception $ex) {
            error_log('[Use-your-Drive message]: ' . sprintf('Media Player Skin %s is invalid', $mediaplayer));
            return false;
        }
    }

    protected function remove_deprecated_options($options = array()) {
        /* Deprecated Shuffle, v1.3 */
        if (isset($options['shuffle'])) {
            unset($options['shuffle']);
            $options['sortfield'] = 'shuffle';
        }
        /* Changed Userfolders, v1.3 */
        if (isset($options['userfolders']) && $options['userfolders'] === '1') {
            $options['userfolders'] = 'auto';
        }

        if (isset($options['partiallastrow'])) {
            unset($options['partiallastrow']);
        }

        /* Changed Rename/Delete/Move Folders & Files v1.5.2 */
        if (isset($options['move_role'])) {
            $options['move_files_role'] = $options['move_role'];
            $options['move_folders_role'] = $options['move_role'];
            unset($options['move_role']);
        }

        if (isset($options['rename_role'])) {
            $options['rename_files_role'] = $options['rename_role'];
            $options['rename_folders_role'] = $options['rename_role'];
            unset($options['rename_role']);
        }

        if (isset($options['delete_role'])) {
            $options['delete_files_role'] = $options['delete_role'];
            $options['delete_folders_role'] = $options['delete_role'];
            unset($options['delete_role']);
        }

        /* Changed 'ext' to 'include_ext' v1.5.2 */
        if (isset($options['ext'])) {
            $options['include_ext'] = $options['ext'];
            unset($options['ext']);
        }

        if (isset($options['maxfiles']) && empty($options['maxfiles'])) {
            unset($options['maxfiles']);
        }

        /* Convert bytes in version before 1.8 to MB */
        if (isset($options['maxfilesize']) && !empty($options['maxfilesize']) && ctype_digit($options['maxfilesize'])) {
            $options['maxfilesize'] = Helpers::bytes_to_size_1024($options['maxfilesize']);
        }

        /* Changed 'covers' to 'playlistthumbnails' */
        if (isset($options['covers'])) {
            $options['playlistthumbnails'] = $options['covers'];
            unset($options['covers']);
        }

        return $options;
    }

    protected function save_shortcodes() {
        $this->get_shortcodes()->set_shortcode($this->listtoken, $this->options);
        $this->get_shortcodes()->update_cache();
    }

    public function sort_filelist($foldercontents) {

        $sort_field = 'name';
        $sort_order = SORT_ASC;

        if (count($foldercontents) > 0) {
// Sort Filelist, folders first
            $sort = array();

            if (isset($_REQUEST['sort'])) {
                $sort_options = explode(':', $_REQUEST['sort']);

                if ($sort_options[0] === 'shuffle') {
                    shuffle($foldercontents);
                    return $foldercontents;
                }

                if (count($sort_options) === 2) {

                    switch ($sort_options[0]) {
                        case 'name':
                            $sort_field = 'name';
                            break;
                        case 'size':
                            $sort_field = 'size';
                            break;
                        case 'modified':
                            $sort_field = 'last_edited';
                            break;
                        case 'created':
                            $sort_field = 'created_time';
                            break;
                    }

                    switch ($sort_options[1]) {
                        case 'asc':
                            $sort_order = SORT_ASC;
                            break;
                        case 'desc':
                            $sort_order = SORT_DESC;
                            break;
                    }
                }
            }

            list($sort_field, $sort_order) = apply_filters('useyourdrive_sort_filelist_settings', array($sort_field, $sort_order), $foldercontents, $this);

            foreach ($foldercontents as $k => $v) {
                if ($v instanceof EntryAbstract) {
                    $sort['is_dir'][$k] = $v->is_dir();
                    $sort['sort'][$k] = strtolower($v->{'get_' . $sort_field}());
                } else {
                    $sort['is_dir'][$k] = $v['is_dir'];
                    $sort['sort'][$k] = $v[$sort_field];
                }
            }

            /* Sort by dir desc and then by name asc */
            if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
                array_multisort($sort['is_dir'], SORT_DESC, SORT_REGULAR, $sort['sort'], $sort_order, SORT_NATURAL, $foldercontents, SORT_ASC, SORT_NATURAL);
            } else {
                array_multisort($sort['is_dir'], SORT_DESC, $sort['sort'], $sort_order, $foldercontents);
            }
        }

        $foldercontents = apply_filters('useyourdrive_sort_filelist', $foldercontents, $sort_field, $sort_order, $this);

        return $foldercontents;
    }

    public function send_notification_email($notification_type, $entries) {
        $notification = new Notification($this, $notification_type, $entries);
        $notification->send_notification();
    }

    private function _is_action_authorized($hook = false) {
        $nonce_verification = ($this->get_setting('nonce_validation') === 'Yes');
        $allow_nonce_verification = apply_filters("use_your_drive_allow_nonce_verification", $nonce_verification);

        if ($allow_nonce_verification && isset($_REQUEST['action']) && ($hook === false) && is_user_logged_in()) {

            $is_authorized = false;

            switch ($_REQUEST['action']) {
                case 'useyourdrive-upload-file':
                case 'useyourdrive-get-filelist':
                case 'useyourdrive-get-gallery':
                case 'useyourdrive-get-playlist':
                case 'useyourdrive-rename-entry':
                case 'useyourdrive-move-entries':
                case 'useyourdrive-edit-description-entry':
                case 'useyourdrive-add-folder':
                case 'useyourdrive-create-zip':
                case 'useyourdrive-delete-entries':
                    $is_authorized = check_ajax_referer($_REQUEST['action'], false, false);
                    break;

                case 'useyourdrive-create-link':
                case 'useyourdrive-embedded':
                    $is_authorized = check_ajax_referer('useyourdrive-create-link', false, false);
                    break;
                case 'useyourdrive-reset-cache':
                case 'useyourdrive-reset-statistics':
                    $is_authorized = check_ajax_referer('useyourdrive-admin-action', false, false);
                    break;
                case 'useyourdrive-revoke':
                    return (check_ajax_referer('useyourdrive-admin-action', false, false) !== false);
                    break;
                case 'useyourdrive-download':
                case 'useyourdrive-stream':
                case 'useyourdrive-preview':
                case 'useyourdrive-thumbnail':
                case 'useyourdrive-edit':
                case 'useyourdrive-getpopup':
                    $is_authorized = true;
                    break;

                case 'edit': // Required for integration one Page/Post pages
                    $is_authorized = true;
                    break;
                case 'editpost': // Required for Yoast SEO Link Watcher trying to build the shortcode
                case 'wpseo_filter_shortcodes':
                case 'elementor':
                case 'elementor_ajax':
                    return false;
                default:
                    error_log('[Use-your-Drive message]: ' . " Function _is_action_authorized() didn't receive a valid action: " . $_REQUEST['action']);
                    die();
            }

            if ($is_authorized === false) {
                error_log('[Use-your-Drive message]: ' . " Function _is_action_authorized() didn't receive a valid nonce");
                die();
            }
        }

        return true;
    }

    /*
     * Check if $entry is allowed
     */

    public function _is_entry_authorized(CacheNode $cachedentry) {
        $entry = $cachedentry->get_entry();

        if (empty($entry)) {
            return false;
        }
        /* Return in case a direct call is being made, and no shortcode is involved */
        if (empty($this->options)) {
            return true;
        }

        /* Action for custom filters */
        $is_authorized_hook = apply_filters('useyourdrive_is_entry_authorized', true, $cachedentry, $this);
        if ($is_authorized_hook === false) {
            return false;
        }

        /* Skip entry if its a file, and we dont want to show files */
        if (($entry->is_file()) && ($this->get_shortcode_option('show_files') === '0')) {
            return false;
        }
        /* Skip entry if its a folder, and we dont want to show folders */
        if (($entry->is_dir()) && ($this->get_shortcode_option('show_folders') === '0') && ($entry->get_id() !== $this->get_requested_entry())) {
            return false;
        }

        /* Only add allowed files to array */
        $extension = $entry->get_extension();
        $allowed_extensions = $this->get_shortcode_option('include_ext');
        if (($entry->is_file()) && (!in_array(strtolower($extension), $allowed_extensions)) && $allowed_extensions[0] != '*') {
            return false;
        }

        /* Hide files with extensions */
        $hide_extensions = $this->get_shortcode_option('exclude_ext');
        if (($entry->is_file()) && !empty($extension) && (in_array(strtolower($extension), $hide_extensions)) && $hide_extensions[0] != '*') {
            return false;
        }

        /* skip excluded folders and files */
        $hide_entries = $this->get_shortcode_option('exclude');
        if ($hide_entries[0] != '*') {

            $match = false;
            foreach ($hide_entries as $hide_entry) {
                if (fnmatch($hide_entry, $entry->get_name())) {
                    $match = true;
                    break; // Entry matches by expression (wildcards * , ?)
                } elseif ($hide_entry === $entry->get_id()) {
                    $match = true;
                    break; //Entry matches by ID
                }
            }

            if ($match === true) {
                return false;
            }
        }

        /* only allow included folders and files */
        $include_entries = $this->get_shortcode_option('include');
        if ($include_entries[0] != '*') {
            if ($entry->is_dir() && ($entry->get_id() === $this->get_requested_entry())) {
                
            } else {
                $match = false;
                foreach ($include_entries as $include_entry) {
                    if (fnmatch($include_entry, $entry->get_name())) {
                        $match = true;
                        break; // Entry matches by expression (wildcards * , ?)
                    } elseif ($include_entry === $entry->get_id()) {
                        $match = true;
                        break; //Entry matches by ID
                    }
                }

                if ($match === false) {
                    return false;
                }
            }
        }

        /* Make sure that files and folders from hidden folders are not allowed */
        if ($hide_entries[0] != '*') {
            foreach ($hide_entries as $hidden_entry) {
                $cached_hidden_entry = $this->get_cache()->get_node_by_name($hidden_entry);

                if ($cached_hidden_entry === false) {
                    $cached_hidden_entry = $this->get_cache()->get_node_by_id($hidden_entry);
                }

                if ($cached_hidden_entry !== false && $cached_hidden_entry->get_entry()->is_dir()) {
                    if ($cachedentry->is_in_folder($cached_hidden_entry->get_id())) {
                        return false;
                    }
                }
            }
        }

        /* If only showing Shared Files */
        /* if (1) {
          if ($entry->is_file()) {
          if (!$entry->getShared() && $entry->getOwnedByMe()) {
          return false;
          }
          }
          } */

        /* Is file in the selected root Folder? */
        if (!$cachedentry->is_in_folder($this->get_root_folder())) {
            return false;
        }
        return true;
    }

    public function embed_image($entryid) {
        $cachedentry = $this->get_client()->get_entry($entryid, false);

        if ($cachedentry === false) {
            return false;
        }

        if (in_array($cachedentry->get_entry()->get_extension(), array('jpg', 'jpeg', 'gif', 'png'))) {

            // Redirect to thumbnail itself
            header("Location: https://drive.google.com/thumbnail?id={$cachedentry->get_id()}&sz=w1920");

            // Dec 2019: Google can block image downloads if it detects automated queries
            //$download = new Download($cachedentry, $this);
            //$download->start_download();
            die();
        }

        return true;
    }

    public function set_requested_entry($entry_id) {
        return $this->_requestedEntry = $entry_id;
    }

    public function get_requested_entry() {
        return $this->_requestedEntry;
    }

    public function get_import_formats() {

        $importFormats = array(
            "application/x-vnd.oasis.opendocument.presentation" =>
            "application/vnd.google-apps.presentation"
            ,
            "text/tab-separated-values" =>
            "application/vnd.google-apps.spreadsheet"
            ,
            "image/jpeg" =>
            "application/vnd.google-apps.document"
            ,
            "image/bmp" =>
            "application/vnd.google-apps.document"
            ,
            "image/gif" =>
            "application/vnd.google-apps.document"
            ,
            "application/vnd.ms-excel.sheet.macroenabled.12" =>
            "application/vnd.google-apps.spreadsheet"
            ,
            "application/vnd.openxmlformats-officedocument.wordprocessingml.template" =>
            "application/vnd.google-apps.document"
            ,
            "application/vnd.ms-powerpoint.presentation.macroenabled.12" =>
            "application/vnd.google-apps.presentation"
            ,
            "application/vnd.ms-word.template.macroenabled.12" =>
            "application/vnd.google-apps.document"
            ,
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document" =>
            "application/vnd.google-apps.document"
            ,
            "image/pjpeg" =>
            "application/vnd.google-apps.document"
            ,
            "application/vnd.google-apps.script+text/plain" =>
            "application/vnd.google-apps.script"
            ,
            "application/vnd.ms-excel" =>
            "application/vnd.google-apps.spreadsheet"
            ,
            "application/vnd.sun.xml.writer" =>
            "application/vnd.google-apps.document"
            ,
            "application/vnd.ms-word.document.macroenabled.12" =>
            "application/vnd.google-apps.document"
            ,
            "application/vnd.ms-powerpoint.slideshow.macroenabled.12" =>
            "application/vnd.google-apps.presentation"
            ,
            "text/rtf" =>
            "application/vnd.google-apps.document"
            ,
            "text/plain" =>
            "application/vnd.google-apps.document"
            ,
            "application/vnd.oasis.opendocument.spreadsheet" =>
            "application/vnd.google-apps.spreadsheet"
            ,
            "application/x-vnd.oasis.opendocument.spreadsheet" =>
            "application/vnd.google-apps.spreadsheet"
            ,
            "image/png" =>
            "application/vnd.google-apps.document"
            ,
            "application/x-vnd.oasis.opendocument.text" =>
            "application/vnd.google-apps.document"
            ,
            "application/msword" =>
            "application/vnd.google-apps.document"
            ,
            "application/pdf" =>
            "application/vnd.google-apps.document"
            ,
            "application/json" =>
            "application/vnd.google-apps.script"
            ,
            "application/x-msmetafile" =>
            "application/vnd.google-apps.drawing"
            ,
            "application/vnd.openxmlformats-officedocument.spreadsheetml.template" =>
            "application/vnd.google-apps.spreadsheet"
            ,
            "application/vnd.ms-powerpoint" =>
            "application/vnd.google-apps.presentation"
            ,
            "application/vnd.ms-excel.template.macroenabled.12" =>
            "application/vnd.google-apps.spreadsheet"
            ,
            "image/x-bmp" =>
            "application/vnd.google-apps.document"
            ,
            "application/rtf" =>
            "application/vnd.google-apps.document"
            ,
            "application/vnd.openxmlformats-officedocument.presentationml.template" =>
            "application/vnd.google-apps.presentation"
            ,
            "image/x-png" =>
            "application/vnd.google-apps.document"
            ,
            "text/html" =>
            "application/vnd.google-apps.document"
            ,
            "application/vnd.oasis.opendocument.text" =>
            "application/vnd.google-apps.document"
            ,
            "application/vnd.openxmlformats-officedocument.presentationml.presentation" =>
            "application/vnd.google-apps.presentation"
            ,
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" =>
            "application/vnd.google-apps.spreadsheet"
            ,
            "application/vnd.google-apps.script+json" =>
            "application/vnd.google-apps.script"
            ,
            "application/vnd.openxmlformats-officedocument.presentationml.slideshow" =>
            "application/vnd.google-apps.presentation"
            ,
            "application/vnd.ms-powerpoint.template.macroenabled.12" =>
            "application/vnd.google-apps.presentation"
            ,
            "text/csv" =>
            "application/vnd.google-apps.spreadsheet"
            ,
            "application/vnd.oasis.opendocument.presentation" =>
            "application/vnd.google-apps.presentation"
            ,
            "image/jpg" =>
            "application/vnd.google-apps.document"
            ,
            "text/richtext" =>
            "application/vnd.google-apps.document"
        );

        return $importFormats;
    }

    public function is_mobile() {
        return $this->mobile;
    }

    public function get_setting($key, $default = null) {
        if (!isset($this->settings[$key])) {
            return $default;
        }

        return $this->settings[$key];
    }

    public function set_setting($key, $value) {
        $this->settings[$key] = $value;
        $success = update_option('use_your_drive_settings', $this->settings);
        $this->settings = get_option('use_your_drive_settings');
        return $success;
    }

    public function get_network_setting($key, $default = null) {
        $network_settings = get_site_option('useyourdrive_network_settings', array());

        if (!isset($network_settings[$key])) {
            return $default;
        }

        return $network_settings[$key];
    }

    public function set_network_setting($key, $value) {
        $network_settings = get_site_option('useyourdrive_network_settings', array());
        $network_settings[$key] = $value;
        return update_site_option('useyourdrive_network_settings', $network_settings);
    }

    public function get_shortcode() {
        return $this->options;
    }

    public function get_shortcode_option($key) {
        if (!isset($this->options[$key])) {
            return null;
        }
        return $this->options[$key];
    }

    public function set_shortcode($listtoken) {

        $cached_shortcode = $this->get_shortcodes()->get_shortcode_by_id($listtoken);

        if ($cached_shortcode) {
            $this->options = $cached_shortcode;
            $this->listtoken = $listtoken;
        }

        return $this->options;
    }

    public function _set_gzip_compression() {
        /* Compress file list if possible */
        if ($this->settings['gzipcompression'] === 'Yes') {
            $zlib = (ini_get('zlib.output_compression') == '' || !ini_get('zlib.output_compression')) && (ini_get('output_handler') != 'ob_gzhandler');
            if ($zlib === true) {
                if (extension_loaded('zlib')) {
                    if (!in_array('ob_gzhandler', ob_list_handlers())) {
                        ob_start('ob_gzhandler');
                    }
                }
            }
        }
    }

    public function is_network_authorized() {
        if (!function_exists('is_plugin_active_for_network')) {
            require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
        }

        $network_settings = get_site_option('useyourdrive_network_settings', array());

        return (isset($network_settings['network_wide']) && is_plugin_active_for_network(USEYOURDRIVE_SLUG) && ($network_settings['network_wide'] === 'Yes'));
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\Main
     */
    public function get_main() {
        return $this->_main;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\App
     */
    public function get_app() {
        if (empty($this->_app)) {
            $this->_app = new \TheLion\UseyourDrive\App($this);
            try {
                $this->_app->start_client($this->get_current_account());
            } catch (\Exception $ex) {
                return $this->_app;
            }
        } elseif ($this->get_current_account() !== null && $this->get_current_account()->get_authorization()->has_access_token()) {
            $this->_app->get_client()->setAccessToken($this->get_current_account()->get_authorization()->get_access_token());
        }

        return $this->_app;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\Accounts
     */
    public function get_accounts() {
        return $this->get_main()->get_accounts();
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\Account
     */
    public function get_current_account() {
        if (empty($this->_current_account)) {
            if ($this->get_shortcode('account') !== null) {
                $this->_current_account = $this->get_accounts()->get_account_by_id($this->get_shortcode_option('account'));
            }
        }

        return $this->_current_account;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\Account
     */
    public function set_current_account(\TheLion\UseyourDrive\Account $account) {
        $this->_current_account = $account;
    }

    public function clear_current_account() {
        $this->_current_account = null;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\Client
     */
    public function get_client() {
        if (empty($this->_client)) {
            $this->_client = new \TheLion\UseyourDrive\Client($this->get_app(), $this);
        } elseif ($this->get_current_account() !== null) {
            $this->_app->get_client()->setAccessToken($this->get_current_account()->get_authorization()->get_access_token());
        }

        return $this->_client;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\Cache
     */
    public function get_cache() {
        if (empty($this->_cache)) {
            $this->_cache = new \TheLion\UseyourDrive\Cache($this);
        }

        return $this->_cache;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\Shortcodes
     */
    public function get_shortcodes() {
        if (empty($this->_shortcodes)) {
            $this->_shortcodes = new \TheLion\UseyourDrive\Shortcodes($this);
        }

        return $this->_shortcodes;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\User
     */
    public function get_user($force_reload = false) {
        if (empty($this->_user) || $force_reload) {
            $this->_user = new \TheLion\UseyourDrive\User($this);
        }

        return $this->_user;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\UserFolders
     */
    public function get_user_folders() {
        if (empty($this->_userfolders)) {
            $this->_userfolders = new \TheLion\UseyourDrive\UserFolders($this);
        }

        return $this->_userfolders;
    }

    public function get_user_ip() {
        return $this->userip;
    }

    public function reset_complete_cache() {

        // Remove all out-dated transients
        delete_expired_transients(true);

        if (!file_exists(USEYOURDRIVE_CACHEDIR)) {
            return false;
        }

        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(USEYOURDRIVE_CACHEDIR, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST) as $path) {

            if ($path->isDir()) {
                continue;
            }
            if ($path->getFilename() === '.htaccess') {
                continue;
            }

            if ($path->getExtension() === 'access_token') {
                continue;
            }

            if ($path->getExtension() === 'log') {
                continue;
            }

            try {
                @unlink($path->getPathname());
            } catch (\Exception $ex) {
                continue;
            }
        }
        return true;
    }

    public function do_shutdown() {
        $error = error_get_last();

        if ($error['type'] !== E_ERROR) {
            return;
        }

        if (isset($error['file']) && strpos($error['file'], USEYOURDRIVE_ROOTDIR) !== false) {

            error_log('[Use-your-Drive message]: Complete reset. Reason: ' . var_export($error, true));

            /* fatal error has occured */
            $this->get_cache()->reset_cache();
        }
    }

}
