<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class WpsolAddonSpeedOptimization
 */
class WpsolAddonSpeedOptimization
{
    /**
     * Init allowed directory params
     *
     * @var array
     */
    private $allowed_dir = array('wp-content', 'wp-includes');
    /**
     * Init unallowed directory params
     *
     * @var array
     */
    private $unallowed_dir = array(
        'wp-admin',
        'wp-content/cache',
        'wp-content/languages',
        'wp-content/uploads',
        'wp-content/upgrade'
    );
    /**
     * Init allowed extension params
     *
     * @var array
     */
    private $allowed_ext = array('js', 'css', 'eot', 'ttf', 'woff', 'otf');

    /**
     * WpsolAddonSpeedOptimization constructor.
     */
    public function __construct()
    {
        // Action hook
        add_action(
            'wpsol_addon_add_advanced_file_popup',
            array('WpsolAddonSpeedOptimizationViews', 'addAdvancedFilePopup'),
            10,
            1
        );

        add_action('wpsol_addon_storage_exclude_file', array($this, 'storageExcludeFile'));
        add_action('wpsol_addon_storage_advanced_optimization', array($this, 'storageAdvancedOptimization'));
        add_action('wpsol_addon_preload_cache', array('WpsolAddonAdvancedOptimization', 'preloadCache'));

        // Filter hook
        add_filter('wpsol_addon_check_group_google_fonts', array($this, 'checkGroupGoogleFonts'), 10, 1);
        add_filter('wpsol_addon_storage_settings_speedup', array($this, 'storageSettingsSpeedup'), 10, 2);
        add_filter('wpsol_addon_storage_settings_minify', array($this, 'storageSettingsMinify'), 10, 2);
        add_filter('wpsol_addon_check_exclude_inline_script', array($this,'checkExcludeInlineScript'), 10, 1);
        add_filter('wpsol_addon_check_move_script_to_footer', array($this,'checkMoveScriptToFooter'), 10, 1);
        add_filter('wpsol_addon_get_exclude_script_move_to_footer', array($this,'getExcludeScriptMoveToFooter'), 10, 1);
        // Ajax handle
        add_action('wp_ajax_wpsol_addon_scan_dir', array($this, 'scanDir'));
        add_action('wp_ajax_wpsol_addon_scan_exclude_files', array($this, 'scanExcludeFiles'));
        add_action('wp_ajax_wpsol_get_folder', array($this, 'getFolder'));
        add_action('wp_ajax_wpsol_display_exclude_file', array($this, 'displayExcludeFile'));
        add_action('wp_ajax_wpsol_change_minify', array($this, 'changeMinify'));
        add_action('wp_ajax_wpsol_toggle_minify', array($this, 'toggleMinify'));
    }

    /**
     * Save settings
     *
     * @param array $settings Option of speedup settings
     * @param array $request  Request save
     *
     * @return mixed
     */
    public function storageSettingsSpeedup($settings, $request)
    {
        if (isset($request['cleanup-on-save'])) {
            $settings['speed_optimization']['cleanup_on_save'] = 1;
        } else {
            $settings['speed_optimization']['cleanup_on_save'] = 0;
        }

        return $settings;
    }
    /**
     * Save settings
     *
     * @param array $settings Option of minify settings
     * @param array $request  Request save
     *
     * @return mixed
     */
    public function storageSettingsMinify($settings, $request)
    {

        if (isset($request['fontgroup-minification'])) {
            $settings['advanced_features']['fontgroup_minification'] = 1;
        } else {
            $settings['advanced_features']['fontgroup_minification'] = 0;
        }
        if (isset($request['exclude-inline-script'])) {
            $settings['advanced_features']['exclude_inline_script'] = 1;
        } else {
            $settings['advanced_features']['exclude_inline_script'] = 0;
        }
        if (isset($request['move-script-to-footer'])) {
            $settings['advanced_features']['move_script_to_footer'] = 1;
        } else {
            $settings['advanced_features']['move_script_to_footer'] = 0;
        }
        if (isset($request['excludeFiles-minification'])) {
            $settings['advanced_features']['excludefiles_minification'] = 1;
        } else {
            $settings['advanced_features']['excludefiles_minification'] = 0;
        }
        $exclude = array();
        // phpcs:disable WordPress.Security.NonceVerification -- Check request, have 2 filter call this function
        if (!empty($_REQUEST['exclude-move-script-to-footer'])) {
            $exclude = explode("\r\n", trim($_REQUEST['exclude-move-script-to-footer']));
        }
        // phpcs:enable
        $settings['advanced_features']['exclude_move_to_footer'] = $exclude;
        return $settings;
    }

    /**
     * Save advanced optimization
     *
     * @return void
     */
    public function storageAdvancedOptimization()
    {
        check_admin_referer('wpsol_speed_optimization', '_wpsol_nonce');
        $settings = get_option('wpsol_advanced_settings');
        if (isset($_REQUEST['cache-preload'])) {
            $settings['cache_preload'] = 1;
        } else {
            $settings['cache_preload'] = 0;
        }
        if (isset($_REQUEST['dns-prefetching'])) {
            $settings['dns_prefetching'] = 1;
        } else {
            $settings['dns_prefetching'] = 0;
        }
        $settings['preload_url'] = $this->strtoarray($_REQUEST['preload-url']);
        $settings['prefetching_domain'] = $this->strtoarray($_REQUEST['prefetching-domain']);
        update_option('wpsol_advanced_settings', $settings);
    }

    /**
     * Storage exclude files settings
     *
     * @return void
     */
    public function storageExcludeFile()
    {
        $files_select = WpsolAddonSpeedOptimizationQuery::getExcludeFiles();
        $arr = array(
            'js-exclude' => array(),
            'css-font-exclude' => array()
        );
        if (!is_null($files_select)) {
            foreach ($files_select as $k => $file) {
                if ($file->filetype === '2') {
                    //JS
                    $arr['js-exclude'][] = $file->filename;
                } else {
                    $arr['css-font-exclude'][] = $file->filename;
                }
            }
        }

        update_option('wpsol_addon_exclude_file_lists', $arr);
    }

    /**
     * Scan dir to get url
     *
     * @return void
     */
    public function scanDir()
    {
        if (!current_user_can('manage_options')) {
            wp_send_json(false);
        }
        check_ajax_referer('folder-minify-nonce', 'ajaxnonce');

        if (isset($_POST['folders'])) {
            $folders = $_POST['folders'];
        }
        $path = $this->wpsolValidatePath(ABSPATH);
        $allowed_folder = array();
        // update optimize settings
        $optimization = get_option('wpsol_optimization_settings');
        $optimization['advanced_features']['excludefiles_minification'] = 1;
        update_option('wpsol_optimization_settings', $optimization);
        // Save folder select memories
        update_option('wpsol_folder_scan_selected', $folders);

        if (!empty($folders)) {
            foreach ($folders as $folder) {
                if (strpos($folder, '/') === false) {
                    //  Parrent folder
                    if (in_array($folder, $this->unallowed_dir)) {
                        //exclude wp-admin
                        continue;
                    }
                    if (file_exists($path . '/' . $folder)) {
                        $files = scandir($path . '/' . $folder);
                        $files = array_diff($files, array('..', '.'));
                        foreach ($files as $file) {
                            if (is_dir($path . '/' . $folder . '/' . $file)) {
                                // Exclude unallowd dir
                                if (in_array($folder . '/' . $file, $this->unallowed_dir)) {
                                    continue;
                                }
                                $allowed_folder[] = $folder . '/' . $file;
                            }
                        }
                    }
                } else {
                    if (strpos($folder, 'wp-admin') !== false) {
                        continue;
                    }
                    if (in_array($folder, $this->unallowed_dir)) {
                        //exclude child folder
                        continue;
                    }
                    $allowed_folder[] = $folder;
                }
            }
            $allowed_folder = array_unique($allowed_folder);

            // Remove column when start scan
            WpsolAddonSpeedOptimizationQuery::deleteMinifyFile();

            wp_send_json($allowed_folder);
        }

        wp_send_json(false);
    }

    /**
     * Scan exclude files
     *
     * @return void
     */
    public function scanExcludeFiles()
    {
        if (!current_user_can('manage_options')) {
            wp_send_json(false);
        }
        check_ajax_referer('folder-minify-nonce', 'ajaxnonce');

        $dir = '';
        $files = array();
        if (isset($_POST['dir'])) {
            $dir = ABSPATH . $_POST['dir'];
        }
        if (!empty($dir)) {
            foreach (new RecursiveIteratorIterator(new WpsolIgnorantRecursiveDirectoryIterator($dir)) as $filename) {
                if (!is_file($filename)) {
                    continue;
                }
                $data = array();
                $file = str_replace('\\\\', '/', $filename);
                $data['filename'] = substr($file, strlen(ABSPATH) - 1);
                $data['filetype'] = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                if (!in_array($data['filetype'], $this->allowed_ext)) {
                    continue;
                }
                if (strpos($data['filename'], 'min.css') !== false || strpos($data['filename'], '.min.js') !== false) {
                    continue;
                }
                $data['filename'] = str_replace('\\', '/', $data['filename']);
                $files[] = $data;
            }
        }

        if (empty($files)) {
            echo json_encode(array('status' => 'false'));
            exit();
        }
        $result = array();
        foreach ($files as $file) {
            if ($file['filetype'] === 'css') {
                $data = array('file' => $file['filename'], 'minify' => 0, 'type' => 1);
            } elseif ($file['filetype'] === 'js') {
                $data = array('file' => $file['filename'], 'minify' => 0, 'type' => 2);
            } else {
                $data = array('file' => $file['filename'], 'minify' => 0, 'type' => 0);
            }
            $result[] = $data;
        }
        if (empty($result)) {
            echo json_encode(array('status' => 'false'));
            exit();
        }
        WpsolAddonSpeedOptimizationQuery::insertMinifyFile($result);
        echo json_encode(array('status' => 'true'));
        exit;
    }
    /**
     *  Get root folder
     *
     * @return void
     */
    public function getFolder()
    {
        if (!current_user_can('manage_options')) {
            wp_send_json(false);
        }
        check_ajax_referer('folder-jao-nonce', 'ajaxnonce');

        $uploads_dir = wp_upload_dir();
        $uploads_dir_path = $uploads_dir['path'];
        $selected_folders = array('wp-content', 'wp-includes');
        $path = $this->wpsolValidatePath(ABSPATH);
        $dir = $_REQUEST['dir'];
        $return = array();
        $dirs = array();
        if (file_exists($path . $dir)) {
            $files = scandir($path . $dir);
            $files = array_diff($files, array('..', '.'));
            natcasesort($files);
            if (count($files) > 0) {
                $baseDir = ltrim(rtrim(str_replace(DIRECTORY_SEPARATOR, '/', $dir), '/'), '/');
                if ($baseDir !== '') {
                    $baseDir .= '/';
                }
                foreach ($files as $file) {
                    if (file_exists($path . $dir . $file) &&
                        is_dir($path . $dir . $file) &&
                        ($path . $dir . $file !== $this->wpsolValidatePath($uploads_dir_path))) {
                        $file = iconv('Windows-1252', 'UTF-8', $file);
                        if (in_array($baseDir . $file, $selected_folders)) {
                            $dirs[] = array('type' => 'dir', 'dir' => $dir, 'file' => $file, 'checked' => true);
                        } else {
                            $hasSubFolderSelected = false;
                            foreach ($selected_folders as $selected_folder) {
                                if (strpos($selected_folder, $baseDir . $file) === 1) {
                                    $hasSubFolderSelected = true;
                                }
                            }
                            if ($hasSubFolderSelected) {
                                $dirs[] = array('type' => 'dir', 'dir' => $dir, 'file' => $file, 'pchecked' => true);
                            } else {
                                $dirs[] = array('type' => 'dir', 'dir' => $dir, 'file' => $file);
                            }
                        }
                    }
                }
                $return = $dirs;
            }
        }
        wp_send_json($return);
    }

    /**
     * This function do validate path
     *
     * @param string $path Url to check validate
     *
     * @return string
     */
    public function wpsolValidatePath($path)
    {
        return rtrim(str_replace(DIRECTORY_SEPARATOR, '/', $path), '/');
    }

    /**
    * Display content
     *
     * @return void
    */
    public static function displayExcludeFile()
    {
        if (!current_user_can('manage_options')) {
            wp_send_json(false);
        }
        check_ajax_referer('addon-admin-nonce', 'ajaxnonce');

        $page = 1;
        $filetype = 'all';
        $search = '';
        if (isset($_POST['page'])) {
            $page = (int)$_POST['page'];
        }
        if (isset($_POST['filetype'])) {
            $filetype = $_POST['filetype'];
        }
        if (isset($_POST['search'])) {
            $search = $_POST['search'];
        }
        $items = WpsolAddonSpeedOptimizationQuery::getItems($page, $filetype, $search);
        $html = '';
        $pagination = '';
        $result = array();
        $total_records = WpsolAddonSpeedOptimizationQuery::getTotalItems($filetype, $search);
        $total_pages = ceil($total_records / 10);
        // Get 10 paging for pagination
        $start = (max(1, $page) - ($total_pages - 9) >= 0) ?
            $page - (max(1, $page) - ($total_pages - 9)) :
            max(1, $page);
        $end = min($page + 9, $total_pages);

        if ($start <= 0) {
            $start = 1;
        }
        if (!empty($items)) {
            foreach ($items as $i => $item) {
                if ($item->filetype === '0') {
                    $type = 'FONT';
                } elseif ($item->filetype === '1') {
                    $type = 'CSS';
                } else {
                    $type = 'JS';
                }
                $checked = '';
                if ($item->minify) {
                    $checked = 'checked="checked"';
                }

                $html .= '<tr>';
                $html .= '<td >
                            
                          <input type="checkbox"  id="minify-check-' . $i . '" class="minify-check" class="filled-in" 
                          name="minify[]" value="' . $item->id . '"/>
                         <label for="minify-check-' . $i . '"></label>
                      </td>';

                $html .= '<td><span class="wpsol-filename-extension wpsol-filename-extension-' . strtolower($type) . '">
                            ' . $type . '</span></td>';
                $html .= '<td><span class="file">' . $item->filename . '</span></td>';
                $html .= '<td>
                        <div class="ju-switch-button">
                            <label class="switch ">
                                <input data-id=' . $item->id . ' type="checkbox"
                                       class="wpsol-optimization" id="active-minify"
                                       name="active-minify"
                                       value="' . $item->minify . '" ' . $checked . '>
                                <div class="slider"></div>
                            </label>
                        </div>
                    </td>';
                $html .= '</tr>';
            }
            $result['body'] = $html;
            $pagination .= '<tr>';
            $pagination .= '<td colspan="4">';
            $pagination .= '<ul>';
            /* Print PREV link if there is one */
            if ($page > 1) {
                $prev = $page - 1;
                $pagination .= '<li class="paging" data-id="1"><span>First</span></li>';
                $pagination .= '<li class="paging" data-id="' . $prev . '"><span><<</span></li>';
            }

            for ($i = $start; $i <= $end; $i++) {
                $choose = '';

                if (((int)$page) === (int)$i) {
                    $choose = 'choose';
                }
                $pagination .= '<li class="paging ' . $choose . '" data-id="' . $i . '" ><span>' . $i . '</span></li> ';
            };
            /* Print NEXT link if there is one */
            if ($page < $total_pages) {
                $next = $page + 1;
                $pagination .= '<li class="paging" data-id="' . $next . '"><span>>></span></li>';
                $pagination .= '<li class="paging" data-id="' . $total_pages . '"><span>Last</span></li>';
            }
            $pagination .= '</ul>';
            $pagination .= '</td>';
            $pagination .= '</tr>';
            $result['pagging'] = $pagination;
        }

        if (!empty($result)) {
            wp_send_json($result);
        } else {
            wp_send_json(false);
        }
    }


    /**
     * Change minify
     *
     * @return void
     */
    public static function changeMinify()
    {
        if (!current_user_can('manage_options')) {
            wp_send_json(false);
        }
        check_ajax_referer('addon-admin-nonce', 'ajaxnonce');

        $state = false;
        $ids = array();
        if (isset($_POST['ids'])) {
            $ids = $_POST['ids'];
        }
        if (isset($_POST['state'])) {
            $state = $_POST['state'];
        }
        if (!empty($ids)) {
            if ($state) {
                WpsolAddonSpeedOptimizationQuery::changeMinifyFile($ids, 0);
            } else {
                WpsolAddonSpeedOptimizationQuery::changeMinifyFile($ids, 1);
            }
        }
        wp_send_json(true);
    }

    /**
     * Toogle minify
     *
     * @return void
     */
    public static function toggleMinify()
    {
        if (!current_user_can('manage_options')) {
            wp_send_json(false);
        }
        check_ajax_referer('addon-admin-nonce', 'ajaxnonce');

        $ids = array();
        $arr = array();
        if (isset($_POST['ids'])) {
            $ids = $_POST['ids'];
        }

        if (!empty($ids)) {
            foreach ($ids as $id) {
                if ($id !== 'on' && $id !== '1' && $id !== '' && $id !== '0' && $id !== 'all_file') {
                    $arr[] = (int)$id;
                }
            }

            if (!empty($arr)) {
                $state = WpsolAddonSpeedOptimizationQuery::getStateMinify($arr[0]);

                if ($state) {
                    WpsolAddonSpeedOptimizationQuery::changeMinifyFile($arr, 0);
                } else {
                    WpsolAddonSpeedOptimizationQuery::changeMinifyFile($arr, 1);
                }
            }
        }
        wp_send_json(true);
    }

    /**
     * Check google font to group
     *
     * @param array $settings Option of advanced
     *
     * @return boolean
     */
    public function checkGroupGoogleFonts($settings)
    {
        if (!empty($settings['advanced_features']['fontgroup_minification'])) {
            return true;
        }
        return false;
    }


    /**
     * Check exclude inline script
     *
     * @param array $return Option advanced
     *
     * @return boolean
     */
    public function checkExcludeInlineScript($return)
    {
        $settings = get_option('wpsol_optimization_settings');
        if (!empty($settings['advanced_features']['exclude_inline_script'])) {
            return true;
        }
        return false;
    }

    /**
     * Check script move to footer
     *
     * @param array $return Option advanced to check
     *
     * @return boolean
     */
    public function checkMoveScriptToFooter($return)
    {
        $settings = get_option('wpsol_optimization_settings');
        if (!empty($settings['advanced_features']['move_script_to_footer'])) {
            return true;
        }
        return false;
    }

    /**
     * Get Exclude script to move footer
     *
     * @param array $arr Result return
     *
     * @return mixed
     */
    public function getExcludeScriptMoveToFooter($arr)
    {
        $settings = get_option('wpsol_optimization_settings');
        if (!empty($settings['advanced_features']['exclude_move_to_footer'])) {
            $arr = $settings['advanced_features']['exclude_move_to_footer'];
        }
        return $arr;
    }
    /**
     * Convert str to array
     *
     * @param string $input String to convert
     *
     * @return array
     */
    private function strtoarray($input = '')
    {
        $input = sanitize_textarea_field($input);
        $output = array();
        if (!empty($input)) {
            $input = rawurldecode($input);
            $input = trim($input);
            $input = str_replace(' ', '', $input);
            $input = explode("\n", $input);

            foreach ($input as $k => $v) {
                $output[] = trim($v);
            }
        }
        return $output;
    }
}


//phpcs:disable Generic.Files.OneClassPerFile -- Class need to use
/**
 * Class WpsolIgnorantRecursiveDirectoryIterator
 */
class WpsolIgnorantRecursiveDirectoryIterator extends RecursiveDirectoryIterator
{
    /**
     * Class children IgnorantRecursiveDirectoryIterator
     *
     * @return RecursiveArrayIterator|WpsolIgnorantRecursiveDirectoryIterator
     */
    public function getChildren()
    {
        try {
            return new WpsolIgnorantRecursiveDirectoryIterator($this->getPathname());
        } catch (UnexpectedValueException $e) {
            return new RecursiveArrayIterator(array());
        }
    }
}
//phpcs:enable