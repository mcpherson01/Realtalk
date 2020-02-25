<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
if (!defined('ABSPATH')) {
    exit;
}
class NjtFbPr
{
    private static $_instance = null;
    private $settings_page_slug = 'njt-facebook-pr-settings.php';
    private $analytics_page_slug = 'njt-facebook-pr-analytics.php';
    private $spam_defender_page_slug = 'njt-fb-pr-spam-defender.php';
    private $reply_commment_page_slug = 'njt-fb-pr-reply-comments';
    private $dashboard_page_slug = 'njt-facebook-pr.php';
    private $fb_account_page_slug = 'njt-facebook-pr-accounts.php';
    private $premium_support_slug = 'njt-fbpr-premium-support';

    private $routes = array();

    private $dashboard_hook_suffix;
    private $analytics_hook_suffix;
    private $fb_account_hook_suffix;
    private $spam_defender_hook_suffix;
    private $setting_hook_suffix;
    private $reply_commment_hook_suffix;
    private $preminum_support_hook_suffix;
    private $more_plugin_hook_suffix;

    public $tmp_post_post_types = array();

    private $shortcuts = array();
    private $public_reply_shortcuts = array();

    private $case_sensitve;

    public function __construct()
    {
    	update_option('njt_fbpr_is_verified', 1);
        $this->shortcuts = array(
            '[user_comment]' => __('User Comment', NJT_FB_PR_I18N),
            '[sender_name]' => __('Sender Name', NJT_FB_PR_I18N),
            '[first_name]' => __('First Name', NJT_FB_PR_I18N),
            '[last_name]' => __('Last Name', NJT_FB_PR_I18N),
            '[spin][/spin]' => __('Spin Text', NJT_FB_PR_I18N),
        );
        $this->public_reply_shortcuts = array(
            '[sender_name]' => __('Sender Name', NJT_FB_PR_I18N),
            '[first_name]' => __('First Name', NJT_FB_PR_I18N),
            '[last_name]' => __('Last Name', NJT_FB_PR_I18N),
            '[spin][/spin]' => __('Spin Text', NJT_FB_PR_I18N),
        );
        $this->tmp_post_post_types = array(
            'njt_fb_pr_tmp_posts' => array(
                'name' => __('FB Posts', NJT_FB_PR_I18N),
                'slug' => 'njt_fb_pr_tmp_posts',
            ),
            'njt_fb_pr_pages' => array(
                'name' => __('FB Pages', NJT_FB_PR_I18N),
                'slug' => 'njt_fb_pr_pages',
            ),
            'njt_fb_histories' => array(
                'name' => __('Histories', NJT_FB_PR_I18N),
                'slug' => 'njt_fb_histories',
            ),
            'njt_fb_admins' => array(
                'name' => __('Fb Admin', NJT_FB_PR_I18N),
                'slug' => 'njt_fb_admins',
            ),
        );

        add_action('init', array($this, 'registerCustomPostType'));

        $this->setRoutes();

        add_action('plugins_loaded', array($this, 'loadTextDomain'));

        register_activation_hook(NJT_FB_PR_FILE, array($this, 'pluginActived'));
        register_deactivation_hook(NJT_FB_PR_FILE, array($this, 'pluginDeactived'));

        add_action('admin_enqueue_scripts', array($this, 'registerAdminEnqueue'));

        add_action('admin_menu', array($this, 'registerMenu'));

        add_action('admin_init', array($this, 'registerSettings'));

        add_action('init', array($this, 'customRewriteRule'));
        add_action('init', array($this, 'customRewriteTag'), 10, 0);

        add_action('template_redirect', array($this, 'templateRedirect'));

        //add_action('init', array($this, 'startSession'), 1);

        add_filter('set-screen-option', array($this, 'setScreenOption'), 10, 3);

        add_action('admin_head', array($this, 'adminHeader'));

        add_action('restrict_manage_posts', array($this, 'restrictManagePosts'));
        add_filter('parse_query', array($this, 'parseQuery'));

        add_filter('disable_months_dropdown', array($this, 'disableMonthsDropdown'), 999, 1);

        add_filter('views_edit-njt_fb_pr_tmp_posts', array($this, 'removeSubSubSub'));

        add_action('wp_ajax_njt_fb_pr_get_posts', array($this, 'ajaxGetPosts'));
        add_action('wp_ajax_njt_fb_pr_get_posts_by_url', array($this, 'ajaxGetPostsByUrl'));
        add_action('wp_ajax_njt_fb_pr_subscribe_page', array($this, 'ajaxSubscribePage'));
        add_action('wp_ajax_njt_fb_pr_unsubscribe_page', array($this, 'ajaxUnSubscribePage'));
        add_action('wp_ajax_njt_fb_pr_find_fb_post', array($this, 'ajaxFindFBPost'));
        add_action('wp_ajax_njt_fb_pr_new_fb_post', array($this, 'ajaxNewFBPost'));
        add_action('wp_ajax_njt_fb_pr_add_new_admin', array($this, 'ajaxAddNewAdmin'));
        add_action('wp_ajax_njt_fb_pr_remove_page', array($this, 'ajaxRemovePage'));
        add_action('wp_ajax_njt_fb_pr_update_old_posts', array($this, 'ajaxUpdateOldPosts'));

        add_action('wp_ajax_njt_fb_pr_premium_support_check', array($this, 'ajaxCheckPremiumSupport'));

        add_action('wp_ajax_njt_fbpr_get_comments', array($this, 'ajaxGetComments'));
        add_action('wp_ajax_njt_fbpr_replycomments_getposts', array($this, 'ajaxReplyCommentsGetPosts'));
        add_action('wp_ajax_njt_fbpr_reply_comment', array($this, 'ajaxReplyCommentsReply'));

        add_action('wp_ajax_njt_fbpr_sending_info', array($this, 'ajaxSendingInfo'));

        add_action('wp_ajax_njt_fbpr_check_code', array($this, 'ajaxCheckCode'));

        add_filter('post_row_actions', array($this, 'postRowActions'), 10, 2);

        add_filter('display_post_states', array($this, 'displayPostStates'), 10, 2);

        add_filter('bulk_actions-edit-njt_fb_pr_tmp_posts', array($this, 'postBulkActions'));

        add_action('add_meta_boxes', array($this, 'registerMetaBoxes'));
        add_action('save_post', array($this, 'savePost'));

        add_action('admin_footer-edit.php', array($this, 'adminFooterEdit'));

        add_action('admin_footer-post.php', array($this, 'singlePostFooter'));

        add_action('admin_footer', array($this, 'adminFooter'));

        add_shortcode('njt_fbpr_spin_text', array($this, 'shortcodeSpinText')); //deprecated
        add_shortcode('spin', array($this, 'shortcodeSpinText'));

        add_action('post_submitbox_misc_actions', array($this, 'postSubmitboxMiscActions'));

        add_action('edit_form_top', array($this, 'editFormTop'));
        add_action('the_title', array($this, 'adminTheTitle'));

        add_filter('manage_posts_columns', array($this, 'customPostTypeColumn'), 10, 2);
        add_action('manage_njt_fb_pr_tmp_posts_posts_custom_column', array($this, 'customPostTypeContent'), 10, 2);

        add_action('admin_notices', array($this, 'addAdminNotices'));

        add_filter('parent_file', array($this, 'selectedAdminMenu'));

        $this->case_sensitve = (get_option('njt_fb_pr_case_sensitive', '') == '1');

        add_filter('months_dropdown_results', array($this, 'removeMonthsDropdown'), 10, 2);
    }
    public function selectedAdminMenu($file)
    {
        global $plugin_page, $post, $submenu_file;

        if (isset($_GET['post_type']) && ($_GET['post_type'] == 'njt_fb_pr_tmp_posts')) {
            $plugin_page = $this->dashboard_page_slug;
            $submenu_file = $this->dashboard_page_slug;
        } elseif (is_object($post) && ($post->post_type == 'njt_fb_pr_tmp_posts')) {
            $plugin_page = $this->dashboard_page_slug;
            $submenu_file = $this->dashboard_page_slug;
        }
        return $file;
    }
    public function editFormTop()
    {
        global $post;
        if (($post->post_type == 'njt_fb_pr_tmp_posts') && (get_option('njt_fb_pr_is_using_utf8encode', '0') == '1')) {
            $post->post_title = utf8_decode($post->post_title);
        }
    }
    public function adminTheTitle($title)
    {
        global $post;
        if (is_admin()) {
            if (($post->post_type == 'njt_fb_pr_tmp_posts') && (get_option('njt_fb_pr_is_using_utf8encode', '0') == '1') && is_admin()) {
                $title = utf8_decode($title);
            }
        }
        return $title;
    }
    public function shortcodeSpinText($atts, $content = "")
    {
        return $this->spinText($content);
    }
    public function adminHeader()
    {
        ?>
        <style>
            #adminmenu a[href$="njt-fb-pr-reply-comments"] {
                display: none !important;
            }
        </style>
        <?php
}
    public function registerMenu()
    {
        global $submenu;
        $this->dashboard_hook_suffix = add_menu_page(
            __('FB Private Replies', NJT_FB_PR_I18N),
            __('FB Private Replies', NJT_FB_PR_I18N),
            'manage_options',
            $this->dashboard_page_slug,
            array($this, 'njtFBPrMenuCallBack'),
            NJT_FB_PR_URL . '/assets/img/bulksender-icon.svg'
        );
        add_action("load-" . $this->dashboard_hook_suffix, array($this, 'dashboardPageLoaded'));

        $this->fb_account_hook_suffix = add_submenu_page(
            $this->dashboard_page_slug,
            __('FB Accounts', NJT_FB_PR_I18N),
            __('FB Accounts', NJT_FB_PR_I18N),
            'manage_options',
            $this->fb_account_page_slug,
            array($this, 'njtFBPrFbAccPageCallBack')
        );
        add_action("load-" . $this->fb_account_hook_suffix, array($this, 'fbAccPageLoaded'));

        $this->analytics_hook_suffix = add_submenu_page(
            $this->dashboard_page_slug,
            __('Analytics', NJT_FB_PR_I18N),
            __('Analytics', NJT_FB_PR_I18N),
            'manage_options',
            $this->analytics_page_slug,
            array($this, 'njtFBPrAnalyticsPageCallBack')
        );
        add_action("load-" . $this->analytics_hook_suffix, array($this, 'analyticsPageLoaded'));

        $this->spam_defender_hook_suffix = add_submenu_page(
            $this->dashboard_page_slug,
            __('Spam Defender', NJT_FB_PR_I18N),
            __('Spam Defender', NJT_FB_PR_I18N),
            'manage_options',
            $this->spam_defender_page_slug,
            array($this, 'njtFBPrSpamDefenderMenuCallBack')
        );
        add_action("load-" . $this->spam_defender_hook_suffix, array($this, 'spamDefenderPageLoaded'));

        $this->reply_commment_hook_suffix = add_submenu_page(
            $this->dashboard_page_slug,
            __('Reply Comments', NJT_FB_PR_I18N),
            __('Reply Comments', NJT_FB_PR_I18N),
            'manage_options',
            $this->reply_commment_page_slug,
            array($this, 'njtFBPrReplyCommentsMenuCallBack')
        );
        add_action("load-" . $this->reply_commment_hook_suffix, array($this, 'replyCommentsPageLoaded'));

        $this->setting_hook_suffix = add_submenu_page(
            $this->dashboard_page_slug,
            __('Facebook Private Replies Settings', NJT_FB_PR_I18N),
            __('Settings', NJT_FB_PR_I18N),
            'manage_options',
            $this->settings_page_slug,
            array($this, 'njtFBPrSettingsMenuCallBack')
        );
        add_action("load-" . $this->setting_hook_suffix, array($this, 'settingsPageLoaded'));

        /*$this->preminum_support_hook_suffix = add_submenu_page(
        $this->dashboard_page_slug,
        __('Premium Support', NJT_FB_PR_I18N),
        __('Premium Support', NJT_FB_PR_I18N),
        'manage_options',
        $this->premium_support_slug,
        array($this, 'premimumSupportCallback')
        );*/

        $submenu[$this->dashboard_page_slug][] = array(
            __('Documentation', NJT_FB_PR_I18N),
            'manage_options',
            esc_url('https://ninjateam.org/how-to-setup-facebook-auto-reply-plugin/'),
        );

        $this->more_plugin_hook_suffix = add_submenu_page(
            $this->dashboard_page_slug,
            __('More Plugins', NJT_FB_PR_I18N),
            __('More Plugins', NJT_FB_PR_I18N),
            'manage_options',
            'njt-fbpr-more-plugins',
            array($this, 'morePluginsCallback')
        );
    }
    public function premimumSupportCallback()
    {
        $data = array(
            'nonce' => wp_create_nonce('njt_fb_pr_nonce'),
        );
        echo NjtFbPrView::load('admin.premium-support', $data);
    }
    public function morePluginsCallback()
    {
        echo NjtFbPrView::load('admin.more-plugins', array());
    }
    public function dashboardPageLoaded()
    {
        global $wpdb, $njt_fb_pr_api;
        $nonce = ((isset($_GET['_nonce'])) ? $_GET['_nonce'] : '');
        /*
         * Delete this account and it's pages
         */
        if (isset($_GET['reload_pages'])) {
            if (!wp_verify_nonce($nonce, 'njt_fb_pr_nonce')) {
                wp_die(sprintf(__('Please go <a href="%1$s">here</a> and try again.', NJT_FB_PR_I18N), $this->getDashboardPageUrl()));
            }
            $user_id = ((isset($_GET['user_id'])) ? $_GET['user_id'] : null);
            if (!is_null($user_id)) {
                NjtFbPrPage::deleteAllPages($user_id);
                NjtFbPrAdmin::deleteAdmin($user_id);
            }
            $redirect_to = $this->getDashboardPageUrl();
            if (isset($_GET['return_url'])) {
                $redirect_to = $_GET['return_url'];
            }
            wp_safe_redirect($redirect_to);
        }
        /*
         * Get new pages
         */
        //UPDATE WHEN CHANGE USER TOKEN -- UPDATE 26/12/2018
        $user_id = ((isset($_GET['user_id'])) ? $_GET['user_id'] : null);
        if (!empty($user_id)) {
            $admin_info = NjtFbPrAdmin::adminInfo($user_id);
            $_pages = $njt_fb_pr_api->getAllPages($admin_info->fb_token);
            foreach ($_pages as $k => $page) {
                $page = (object) $page;
                $page->user_id = $user_id;
                $page->page_name = $page->name;
                $page->page_id = $page->id;
                $page->page_token = $page->access_token;
                $page->is_subscribed = 'no';

                $check = NjtFbPrPage::isExists($page->id, $page->user_id);
                if (!$check) {
                    //no doing
                } else {
                    $njt_post_id = NjtFbPrPage::Get_Post_ID_Exists($page->id, $page->user_id);
                    update_post_meta($njt_post_id, 'fb_page_token', $page->access_token);
                    //file_put_contents(dirname(__FILE__) . "/log.txt",json_encode($njt_post_id) . "\n", FILE_APPEND);
                    //file_put_contents(dirname(__FILE__) . "/log.txt",$njt_post_id."---".$page->name."-Update-".json_encode($page->access_token) . "\n", FILE_APPEND);
                }
            }
        }
        //UPDATE WHEN CHANGE USER TOKEN -- UPDATE 26/12/2018
        if (isset($_GET['get_new_pages'])) {
            if (!wp_verify_nonce($nonce, 'njt_fb_pr_nonce')) {
                wp_die(sprintf(__('Please go <a href="%1$s">here</a> and try again.', NJT_FB_PR_I18N), $this->getDashboardPageUrl()));
            }
            $user_id = ((isset($_GET['user_id'])) ? $_GET['user_id'] : null);

            if (!is_null($user_id)) {
                $admin_info = NjtFbPrAdmin::adminInfo($user_id);
                $_pages = $njt_fb_pr_api->getAllPages($admin_info->fb_token);
                foreach ($_pages as $k => $page) {
                    $page = (object) $page;
                    $page->user_id = $user_id;
                    $page->page_name = $page->name;
                    $page->page_id = $page->id;
                    $page->page_token = $page->access_token;
                    $page->is_subscribed = 'no';

                    if (!NjtFbPrPage::isExists($page->id, $page->user_id)) {
                        $insert_id = NjtFbPrPage::insert(array(
                            'fb_page_id' => $page->id,
                            'fb_page_name' => $page->name,
                            'fb_page_token' => $page->access_token,
                            'fb_user_id' => $page->user_id,
                        ));
                    }
                }
            }
            wp_safe_redirect(add_query_arg(array('_subscribe' => true), $this->getDashboardPageUrl()));
        }

        /*
         * Import or delete old posts
         */
        if (isset($_GET['delete_old_posts']) || isset($_GET['import_new_posts'])) {
            if (!wp_verify_nonce($nonce, 'njt_fb_pr_nonce')) {
                wp_die(sprintf(__('Please go <a href="%1$s">here</a> and try again.', NJT_FB_PR_I18N), $this->getDashboardPageUrl()));
            }
            if (isset($_GET['user_id']) && isset($_GET['fb_page_id']) && isset($_GET['s_page_id'])) {
                $user_id = $_GET['user_id'];
                $fb_page_id = $_GET['fb_page_id'];
                $s_page_id = $_GET['s_page_id'];
                $old_posts = NjtFbPrPost::findOldPostsWithSamePageId($fb_page_id, $s_page_id, $user_id);
                //action
                if (isset($_GET['delete_old_posts'])) {
                    foreach ($old_posts as $k => $v) {
                        wp_delete_post($v->post_id);
                    }
                } elseif (isset($_GET['import_new_posts'])) {
                    foreach ($old_posts as $k => $v) {
                        update_post_meta($v->post_id, 's_page_id', $s_page_id);
                    }
                }
            }
            wp_safe_redirect(add_query_arg(array('post_type' => 'njt_fb_pr_tmp_posts', 's_page_id' => $_GET['s_page_id']), admin_url('edit.php')));
        }

        if (isset($_GET['force_delete_all']) && ($_GET['force_delete_all'] == 'true')) {
            set_time_limit(0);
            foreach ($this->tmp_post_post_types as $k => $v) {
                $posts = $wpdb->get_results("SELECT `ID` FROM " . $wpdb->prefix . "posts WHERE `post_type` = '" . $k . "'");
                foreach ($posts as $k2 => $v2) {
                    wp_delete_post($v2->ID, true);
                    /*
                $wpdb->delete($wpdb->prefix."posts", array('ID' => $k2->ID));
                $wpdb->delete($wpdb->prefix."postmeta", array('post_id' => $k2->ID));
                 */
                }
            }
            wp_safe_redirect($this->getDashboardPageUrl());
        }
    }
    public function spamDefenderPageLoaded()
    {

    }
    public function settingsPageLoaded()
    {

    }
    public function njtFBPrMenuCallBack()
    {
        global $njt_fb_pr_api, $wpdb, $wp_rewrite;
        if (get_option('njt_fbpr_is_verified', '0') != '1') {
            echo NjtFbPrView::load('admin.verify');
            return;
        }

        //check if website has posts with old db
        $posts_with_old_db = $this->getPostsWithOldDb();
        if ($posts_with_old_db !== false) {
            echo NjtFbPrView::load(
                'admin.update-old-posts',
                array('post_ids' => $posts_with_old_db, 'update_type' => 'rules')
            );
            return;
        }
        if (get_option('njt_fbpr_is_updated_status', '') != '1') {
            $posts_with_old_db = array();
            $posts = get_posts(array(
                'post_type' => 'njt_fb_pr_tmp_posts',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            ));
            foreach ($posts as $k => $v) {
                $posts_with_old_db[] = $v->ID;
            }
            echo NjtFbPrView::load(
                'admin.update-old-posts',
                array('post_ids' => $posts_with_old_db, 'update_type' => 'status')
            );
            return;
        }
        //end checking

        $this->insertVerifyToken();
        $data = array(
            'pluginHasSettings' => $this->pluginHasSettings(),
            'settings_page_url' => $this->getSettingsPageUrl(),
            'njt_fb_pr_api' => $njt_fb_pr_api,
            'login_callback_url' => $this->getLoginCallBackUrl(),
        );
        extract($data);
        if (!$pluginHasSettings) {
            echo sprintf(__('Please go to <a href="%s">settings page</a> to complete required fields.', NJT_FB_PR_I18N), $settings_page_url);
        } else {
            /*
             * List all pages
             */
            $user_id = null;
            $all_admins = NjtFbPrAdmin::getAll();
            if (isset($_GET['user_id'])) {
                $user_id = $_GET['user_id'];
            } else {
                if (count($all_admins) > 0) {
                    foreach ($all_admins as $key_admin => $value_admin) {
                        $user_id = $key_admin;
                        break;
                    }
                }
            }
            if (!is_null($user_id)) {
                $pages = array();
                $pages_from_db = NjtFbPrPage::getAllPages($user_id);

                if (count($pages_from_db) > 0) {
                    //$pages = $pages_from_db;
                    $admin_info = NjtFbPrAdmin::adminInfo($user_id);
                    $pages_from_token = $njt_fb_pr_api->getAllPages($admin_info->fb_token);
                    $pages = NjtFbPrAdmin::showListPageWithToken($user_id, $pages_from_db, $pages_from_token);
                    //$pages[] = $page;
                } else {
                    $admin_info = NjtFbPrAdmin::adminInfo($user_id);
                    $_pages = $njt_fb_pr_api->getAllPages($admin_info->fb_token);
                    foreach ($_pages as $k => $page) {
                        $page = (object) $page;
                        $page->user_id = $user_id;
                        $page->page_name = $page->name;
                        $page->page_id = $page->id;
                        $page->page_token = $page->access_token;
                        $page->is_subscribed = 'no';

                        $insert_id = NjtFbPrPage::insert(array(
                            'fb_page_id' => $page->id,
                            'fb_page_name' => $page->name,
                            'fb_page_token' => $page->access_token,
                            'fb_user_id' => $page->user_id,
                        ));
                        $page->sql_post_id = $insert_id;
                        $pages[] = $page;
                    }
                }

                $connect_to_facebook_btn = NjtFbPrView::load('admin.generate-token', array(
                    'login_facebook_url' => $njt_fb_pr_api->generateLoginUrl($login_callback_url),
                    'header' => false,
                ));
                $data = array(
                    'pages' => $pages,
                    'get_new_pages_url' => add_query_arg(array('get_new_pages' => 'true', 'user_id' => $user_id, '_nonce' => wp_create_nonce('njt_fb_pr_nonce')), $this->getDashboardPageUrl()),
                    'reload_pages_url' => add_query_arg(array('reload_pages' => 'true', 'user_id' => $user_id, '_nonce' => wp_create_nonce('njt_fb_pr_nonce')), $this->getDashboardPageUrl()),
                    'reload_pages_title' => __('Delete this account and its pages ?', NJT_FB_PR_I18N),
                    'dashboard_page_url' => $this->getDashboardPageUrl(),
                    'connect_to_facebook_btn' => $connect_to_facebook_btn,
                    'all_admins' => $all_admins,
                    'user_id' => $user_id,
                    'page_slug' => $this->dashboard_page_slug,
                    'is_subscribe' => false,
                );
                if (isset($_GET['_subscribe'])) {
                    $data['is_subscribe'] = true;
                    $data['reload_url'] = add_query_arg(
                        array('page' => $this->dashboard_page_slug),
                        admin_url('admin.php')
                    );
                }
                echo NjtFbPrView::load('admin.list-pages', $data);
            } else {
                /*
                 * Check if user just updated from older version (single user), it means we have to convert old pages,
                 * add user to them
                 */
                $app_id = get_option('njt_fb_pr_fb_app_id', '');
                $app_secret = get_option('njt_fb_pr_fb_app_secret', '');
                $old_user_token = get_option('njt_fb_pr_fb_user_token', '');
                if (!empty($app_id) && !empty($app_secret) && !empty($old_user_token)) {
                    $admin_info = $njt_fb_pr_api->getUserInfo($old_user_token);
                    $admin_s_id = NjtFbPrAdmin::insert(array(
                        'id' => $admin_info->id,
                        'name' => $admin_info->name,
                        'token' => $accessToken,
                    ));
                    //update pages, set fb_user_id = $admin_info->id
                    $all_pages = new WP_Query(array(
                        'post_type' => 'njt_fb_pr_pages',
                        'post_status' => 'any',
                        'posts_per_page' => '-1',
                    ));
                    if ($all_pages->have_posts()) {
                        while ($all_pages->have_posts()) {
                            $all_pages->the_post();
                            $s_page_id = get_the_id();
                            $fb_page_id = get_post_meta($s_page_id, 'fb_page_id', true);
                            update_post_meta($s_page_id, 'fb_user_id', $admin_info->id);
                            //update posts of this page, set s_page_id = $s_page_id
                            $all_posts = new WP_Query(array(
                                'post_type' => 'njt_fb_pr_tmp_posts',
                                'post_status' => 'any',
                                'posts_per_page' => '-1',
                                'meta_key' => 'fb_page_id',
                                'meta_value' => $fb_page_id,
                            ));
                            if ($all_posts->have_posts()) {
                                while ($all_posts->have_posts()) {
                                    $all_posts->the_post();
                                    update_post_meta(get_the_id(), 's_page_id', $s_page_id);
                                }
                            }
                            wp_reset_postdata();
                            //end update post
                        }
                    }
                    wp_reset_postdata();
                    update_option('njt_fb_pr_fb_user_token', '');
                    //wp_safe_redirect($this->getDashboardPageUrl());
                    echo '<script>location.replace("' . $this->getDashboardPageUrl() . '")</script>';
                } else {
                    /*
                     * Connect-to-facebook button
                     */
                    $connect_to_facebook_btn = NjtFbPrView::load('admin.generate-token', array(
                        'login_facebook_url' => $njt_fb_pr_api->generateLoginUrl($login_callback_url),
                        'header' => true,
                    ));
                    echo $connect_to_facebook_btn;
                }
            }
        }

        $wp_rewrite->flush_rules(false);

        //echo NjtFbPrView::load('admin.dashboard', $data);
    }
    public function njtFBPrFbAccPageCallBack()
    {
        global $njt_fb_pr_api;

        $admins = NjtFbPrAdmin::getAll();
        $connect_to_facebook_btn = NjtFbPrView::load('admin.generate-token', array(
            'login_facebook_url' => $njt_fb_pr_api->generateLoginUrl($this->getLoginCallBackUrl()),
            'header' => false,
        ));
        $data = array(
            'admins' => $admins,
            'dashboard_page_slug' => $this->dashboard_page_slug,
            'fbaccount_page' => add_query_arg(array('page' => $this->fb_account_page_slug), admin_url('admin.php')),
            'nonce' => wp_create_nonce('njt_fb_pr_nonce'),
            'connect_to_facebook_btn' => $connect_to_facebook_btn,
        );
        echo NjtFbPrView::load('admin.page.fb-accounts', $data);
    }

    public function fbAccPageLoaded()
    {

    }

    public function njtFBPrAnalyticsPageCallBack()
    {
        global $wpdb;
        $admins = NjtFbPrAdmin::getAll();
        $admin_id = null;
        $date = ((isset($_GET['date'])) ? $_GET['date'] : '');
        if (isset($_GET['account'])) {
            $admin_id = $_GET['account'];
        } else {
            foreach ($admins as $k => $v) {
                $admin_id = $k;
                break;
            }
        }
        if (!is_null($admin_id)) {
            $pages = NjtFbPrPage::getAllPages($admin_id);
            $page_id = ((isset($_GET['page_id'])) ? $_GET['page_id'] : $pages[0]->page_id);

            $years = range(2017, date('Y'));

            //conver to facebook page id
            $fb_page_id = get_post_meta($page_id, 'fb_page_id', true);
            $year = ((isset($_GET['year'])) ? (int) $_GET['year'] : date('Y'));
            $analytics = $this->getAnalytics($fb_page_id, $year);

            $data = array(
                'admins' => $admins,
                'admin_id' => $admin_id,
                'pages' => $pages,
                'page_id' => $page_id,
                'years' => $years,
                'year' => $year,
                'page_slug' => $this->analytics_page_slug,
                'date' => ((isset($_GET['date'])) ? $_GET['date'] : ''),
                'analytics' => $analytics,
            );
            echo NjtFbPrView::load('admin.page.analytics', $data);
        } else {
            echo '<span style="color: #ff0000">Account not found.</span>';
        }
    }
    public function analyticsPageLoaded()
    {
        /*$admins = NjtFbPrAdmin::getAll();
    $admin = null;
    $admin_id = null;
    $date = ((isset($_GET['date'])) ? $_GET['date'] : '');
    if (isset($_GET['account'])) {
    $admin = ((isset($admins[$_GET['account']])) ? $admins[$_GET['account']] : null);
    $admin_id = $_GET['account'];
    } else {
    foreach ($admins as $k => $v) {
    $admin = $v;
    $admin_id = $k;
    break;
    }
    }*/
    }

    public function njtFBPrSpamDefenderMenuCallBack()
    {
        $data = array();
        echo NjtFbPrView::load('admin.spam-defender.settings', $data);
    }
    public function njtFBPrReplyCommentsMenuCallBack()
    {
        /*$users = NjtFbPrAdmin::getAll();
        $selected_user = ((isset($_GET['user_id'])) ? $_GET['user_id'] : '');
        if (empty($selected_user)) {
        foreach ($users as $k => $v) {
        $selected_user = $k;
        break;
        }
        }
        if (empty($selected_user)) {
        //connect facebook now
        exit('connect facebook now');
        } else {
        $pages = NjtFbPrPage::getAllPages($selected_user);
        $selected_page = ((isset($_GET['page_id'])) ? $_GET['page_id'] : '');

        $data = array(
        'page' => $this->reply_commment_page_slug,
        'pages' => $pages,
        'selected_page' => $selected_page,
        'users' => $users,
        'selected_user' => $selected_user,
        );
        echo NjtFbPrView::load('admin.page.reply-comments', $data);
        }*/
        if (isset($_GET['s_page_id'])) {
            $s_page_id = ((isset($_GET['s_page_id'])) ? $_GET['s_page_id'] : '');
            $data = array(
                'post_type' => 'njt_fb_pr_tmp_posts',
                's_page_id' => $s_page_id,
                'page_token' => NjtFbPrPage::getPageTokenFromPageId($s_page_id),
                'page_name' => get_post_meta($s_page_id, 'fb_page_name', true),
                'page' => '',
            );

            echo NjtFbPrView::load('admin.page.reply-comments', $data);
        } else {
            echo sprintf(__('Click <a href="%1$s">here</a> to choose your page first.', NJT_FB_PR_I18N), add_query_arg(array('page' => $this->dashboard_page_slug), admin_url('admin.php')));
        }
    }
    public function replyCommentsPageLoaded()
    {

    }
    public function njtFBPrSettingsMenuCallBack()
    {
        $this->insertVerifyToken();

        global $wp_rewrite;
        $wp_rewrite->flush_rules(false);

        $data = array(
            'login_callback_url' => $this->getLoginCallBackUrl(),
            'webhook_callback_url' => $this->getWebHookCallBackUrl(),
        );

        echo NjtFbPrView::load('admin.settings', $data);
    }
    public function registerSettings()
    {
        $settings = array(
            'njt_fb_pr_fb_app_id',
            'njt_fb_pr_fb_app_secret',
            'njt_fb_pr_fb_verify_token',
            'njt_fb_pr_is_testmode',
            'njt_fb_pr_is_using_utf8encode',
            'njt_fb_pr_case_sensitive',
        );
        foreach ($settings as $k => $v) {
            register_setting('njt_fb_pr', $v);
        }

        /*
         * Spam Defender
         */
        register_setting('njt_fb_pr_spam_defender', 'njt_fb_pr_spam_defender_enable');
        register_setting('njt_fb_pr_spam_defender', 'njt_fb_pr_spam_defender_bad_words');
    }
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function loadTextDomain()
    {
        load_plugin_textdomain('njt_fb_pr', false, plugin_basename(NJT_FB_PR_DIR) . '/languages/');
    }
    public function startSession()
    {
        if (!session_id()) {
            session_start();
        }
    }
    public function pluginDeactived()
    {
        global $wp_rewrite;
        $wp_rewrite->flush_rules(false);
    }
    public function pluginActived()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        /*
         * Create facebook_pages table
         */
        $table = $wpdb->prefix . 'njt_fbpr_analytics';
        if ($wpdb->get_var("show tables like '$table'") != $table) {
            $sql = 'CREATE TABLE ' . $table . ' (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `post_id` varchar(250) NOT NULL,
            `auto_public` int(11) NOT NULL DEFAULT 0,
            `auto_private` int(11) NOT NULL DEFAULT 0,
            `manual_public` int(11) NOT NULL DEFAULT 0,
            `manual_private` int(11) NOT NULL DEFAULT 0,
            `created` timestamp NOT NULL,
            UNIQUE KEY `id` (id)) ' . $charset_collate . ';';

            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);
        }
        if (!get_option('njt_fbpr_is_verified')) {
            update_option('njt_fbpr_is_verified', 1);
        }
        //insert default options
        if (get_option('njt_fb_pr_is_using_utf8encode') === false) {
            update_option('njt_fb_pr_is_using_utf8encode', '1');
        }
        $this->insertVerifyToken();

        //request current_site
        /*$response = wp_remote_post(
    'http://update.ninjateam.org/auto-reply/',
    array(
    'method' => 'POST',
    'timeout' => 45,
    'redirection' => 5,
    'httpversion' => '1.0',
    'blocking' => true,
    'headers' => array(),
    'body' => array(
    'co-data' => array(
    'current_site' => njt_get_current_site()
    )
    ),
    )
    );*/
    }
    private function increaseAnalytic($post_id, $type)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'njt_fbpr_analytics';
        $today = date('Y-m-d');
        $check = $wpdb->get_results("SELECT `id`, `" . $type . "` FROM " . $table . " WHERE `post_id` = '" . $post_id . "' AND date(created) = '" . $today . "' LIMIT 0,1");
        if (count($check) == 0) {
            $wpdb->insert($table, array('post_id' => $post_id, $type => 1, 'created' => date('Y-m-d H:i:s')));
        } else {
            $wpdb->update($table, array($type => $check[0]->{$type}+1), array('post_id' => $post_id));
        }
    }
    private function getAnalytics($page_id, $year = null)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'njt_fbpr_analytics';
        $year = ((is_null($year)) ? date('Y') : $year);
        $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $_data = array();
        foreach ($months as $k_m => $month) {
            $query = "SELECT sum(auto_public) as auto_public, sum(auto_private) as auto_private, sum(manual_public) as manual_public, sum(manual_private) as manual_private FROM " . $table . " WHERE `post_id` LIKE '" . $page_id . "%' AND year(created) = '" . $year . "' AND month(created) = '" . $month . "'";
            $results = $wpdb->get_results($query);
            if (count($results) > 0) {
                $result = $results[0];
                if (!isset($_data['auto_public'][$month])) {
                    $_data['auto_public'][$month] = 0;
                }
                $_data['auto_public'][$month] += $result->auto_public;

                if (!isset($_data['auto_private'][$month])) {
                    $_data['auto_private'][$month] = 0;
                }
                $_data['auto_private'][$month] += $result->auto_private;

                if (!isset($_data['manual_public'][$month])) {
                    $_data['manual_public'][$month] = 0;
                }
                $_data['manual_public'][$month] += $result->manual_public;

                if (!isset($_data['manual_private'][$month])) {
                    $_data['manual_private'][$month] = 0;
                }
                $_data['manual_private'][$month] += $result->manual_private;
            } else {
                $_data['auto_public'][$month] = $_data['auto_private'][$month] = $_data['manual_public'][$month] = $_data['manual_private'][$month] = 0;
            }
        }
        $datasets = array();
        foreach ($_data as $k => $v) {
            $label = '';
            $backgroundColor = '';
            if ($k == 'auto_public') {
                $label = __('Auto Public', NJT_FB_PR_I18N);
                $backgroundColor = __('rgb(255, 99, 132)', NJT_FB_PR_I18N); //red
            } elseif ($k == 'auto_private') {
                $label = __('Auto Private', NJT_FB_PR_I18N);
                $backgroundColor = __('rgb(255, 159, 64)', NJT_FB_PR_I18N); //orange
            } elseif ($k == 'manual_public') {
                $label = __('Manual Public', NJT_FB_PR_I18N);
                $backgroundColor = __('rgb(255, 205, 86)', NJT_FB_PR_I18N); //yellow
            } elseif ($k == 'manual_private') {
                $label = __('Manual Private', NJT_FB_PR_I18N);
                $backgroundColor = __('rgb(75, 192, 192)', NJT_FB_PR_I18N); //green
            }

            $datasets[] = array(
                'label' => $label,
                'data' => array_values($v),
                'backgroundColor' => $backgroundColor,
                'borderColor' => $backgroundColor,
                'borderWidth' => 1,
                'fill' => false,
            );
        }
        return json_encode($datasets);
    }
    private static function generateRandomVerifyToken()
    {
        return rand(100000, 999999);
    }
    private function insertVerifyToken()
    {
        $token = get_option('njt_fb_pr_fb_verify_token', false);
        if (!$token || empty($token)) {
            update_option('njt_fb_pr_fb_verify_token', self::generateRandomVerifyToken());
        }
    }
    private function pluginHasSettings()
    {
        $app_id = get_option('njt_fb_pr_fb_app_id', false);
        $app_secret = get_option('njt_fb_pr_fb_app_secret', false);
        if (!$app_id || empty($app_id) || !$app_secret || empty($app_secret)) {
            return false;
        } else {
            return true;
        }
    }
    public function getSettingsPageUrl()
    {
        return esc_url(add_query_arg(array(
            'page' => $this->settings_page_slug,
        ), admin_url('admin.php')));
    }
    public function getDashboardPageUrl()
    {
        return esc_url(add_query_arg(array(
            'page' => $this->dashboard_page_slug,
        ), admin_url('admin.php')));
    }

    public function registerAdminEnqueue($hook_suffix)
    {
        global $post;

        if (in_array($hook_suffix, array('edit.php', 'post.php', $this->dashboard_hook_suffix, $this->setting_hook_suffix, $this->reply_commment_hook_suffix, $this->more_plugin_hook_suffix, $this->analytics_hook_suffix))) {
            if ($hook_suffix == 'edit.php') {
                if (!isset($_GET['post_type']) || !in_array($_GET['post_type'], array('njt_fb_pr_tmp_posts'))) {
                    return;
                }
            }
            if ($hook_suffix == 'post.php') {
                if ($post->post_type != 'njt_fb_pr_tmp_posts') {
                    return;
                }
            }
            add_thickbox();
            wp_enqueue_media();
            wp_enqueue_script('jquery-ui-datepicker');

            wp_register_style('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css');
            wp_enqueue_style('jquery-ui');

            wp_register_style('njt-fb-pr', NJT_FB_PR_URL . '/assets/css/njt-fb-pr.css');
            wp_enqueue_style('njt-fb-pr');

            wp_register_script('njt-fb-pr-chart', NJT_FB_PR_URL . '/assets/js/Chart.bundle.js', array('jquery'));
            wp_enqueue_script('njt-fb-pr-chart');

            wp_register_script('njt-fb-pr', NJT_FB_PR_URL . '/assets/js/njt-fb-pr.js', array('jquery'));
            wp_enqueue_script('njt-fb-pr');

            wp_register_script('njt-fb-pr-reply-to-all', NJT_FB_PR_URL . '/assets/js/njt-fb-pr-reply-to-all.js', array('jquery'));
            wp_enqueue_script('njt-fb-pr-reply-to-all');

            $new_parent_group_template = array(
                'parent_id' => '{parent_id}',
                'input_name' => 'njt_fb_pr_con',
                'group' => array(
                    'groups' => array(
                        '{group_id}' => array(
                            '{rule_id}' => array(
                                'operator' => '',
                                'value' => '',
                            ),
                        ),
                    ),
                ),
                'shortcuts' => $this->shortcuts,
            );
            $new_parent_group_template_has_photo = $new_parent_group_template;
            $new_parent_group_template_has_photo['input_name'] = 'njt_fb_normal_con';
            $new_parent_group_template_has_photo['has_photo'] = true;
            $new_parent_group_template_has_photo['reply_type'] = 'text';
            $new_parent_group_template_has_photo['shortcuts'] = $this->public_reply_shortcuts;

            $new_rule_group_template = array(
                'group' => array(
                    '{rule_id}' => array(
                        'operator' => '',
                        'value' => '',
                    ),
                ),
                'id' => '{group_id}',
                'input_name' => '{input_name}',
            );
            $new_and_rule = array(
                'rule' => array(
                    'operator' => '',
                    'value' => '',
                ),
                'id' => '{rule_id}',
                'group_id' => '{group_id}',
                'input_name' => '{input_name}',
            );
            wp_localize_script(
                'njt-fb-pr',
                'njt_fb_pr',
                array(
                    'nonce' => wp_create_nonce("njt_fb_pr"),
                    'at_least_one_condition_error' => __('You must have at least 1 condition.', NJT_FB_PR_I18N),
                    'new_parent_group_template' => NjtFbPrView::load('admin.conditional-parent-group', $new_parent_group_template),
                    'new_parent_group_template_has_photo' => NjtFbPrView::load('admin.conditional-parent-group', $new_parent_group_template_has_photo),
                    'new_rule_group_template' => NjtFbPrView::load('admin.conditional-group', $new_rule_group_template),
                    'new_and_rule' => NjtFbPrView::load('admin.conditional-rule', $new_and_rule),
                    'found_post_confirm' => __('Your post was found, click OK to view.', NJT_FB_PR_I18N),
                    'add_media_text_title' => __('Choose image', NJT_FB_PR_I18N),
                    'add_media_text_button' => __('Insert', NJT_FB_PR_I18N),
                    'nonce_error' => __('Nonce is invalid, please reload and try again.'),
                    'are_you_sure' => __('Are you sure?'),
                    'can_not_delete_parent_group' => __('Can\'t delete this one.', NJT_FB_PR_I18N),
                    'spin_photo_template' => njt_spin_photo_template(array('url' => '{url}', 'input_name' => '{input_name}')),
                    'subscribe_has_error' => __('Some pages couldn\'t subscribe, please go to your app and subscribe.', NJT_FB_PR_I18N),
                )
            );
        }
    }
    private function setRoutes()
    {
        $this->routes = array(
            'login-callback' => array(
                'url' => 'njt-fbpr-login-callback',
                'var' => 'njt_fb_pr_login_callback',
                'tag_regex' => '[^&]+',
            ),
            'webhook-callback' => array(
                'url' => 'njt-fbpr-webhook-callback',
                'var' => 'njt_fb_pr_webhook_callback',
                'tag_regex' => '[^&]+',
            ),
        );
    }
    private function getRouteUrl($name)
    {
        return ((isset($this->routes[$name])) ? $this->routes[$name]['url'] : '');
    }
    private function getRouteVar($name)
    {
        return ((isset($this->routes[$name])) ? $this->routes[$name]['var'] : '');
    }
    public function setScreenOption($status, $option, $value)
    {
        return $value;
    }
    public function templateRedirect()
    {
        global $wp_query, $wpdb, $njt_fb_pr_api;
        /*
         * Login callback
         */
        if ((isset($wp_query->query_vars[$this->getRouteVar('login-callback')])) && !is_null($wp_query->query_vars[$this->getRouteVar('login-callback')])) {
            $fb = $njt_fb_pr_api->fb_var;

            $helper = $fb->getRedirectLoginHelper();
            if (isset($_GET['state'])) {
                $helper->getPersistentDataHandler()->set('state', $_GET['state']);
            }
            try {
                $accessToken = $helper->getAccessToken();
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                //echo 'Graph returned an error 1: ' . $e->getMessage();
                //exit;
                $mess = $e->getMessage();
                if (isset($_GET['code'])) {
                    $code = $_GET['code'];
                    $accessToken = $njt_fb_pr_api->codeToToken($code, $this->getLoginCallBackUrl());
                }
                if (!isset($accessToken)) {
                    echo 'Graph returned an error #1-1: ' . $mess;
                    exit;
                } elseif (is_object($accessToken)) {
                    echo 'Graph returned an error #1-2:' . $accessToken->error->message . '|||' . $mess;
                    exit;
                }
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                // When Graph returns an error
                $mess = $e->getMessage();
                if (isset($_GET['code']) && !isset($accessToken)) {
                    $code = $_GET['code'];
                    $accessToken = $njt_fb_pr_api->codeToToken($code, $this->getLoginCallBackUrl());
                }
                if (!isset($accessToken)) {
                    echo 'Graph returned an error #2-1: ' . $mess;
                    exit;
                } elseif (is_object($accessToken)) {
                    echo 'Graph returned an error #2-2:' . $accessToken->error->message . '|||' . $mess;
                    exit;
                }
            }

            if (!isset($accessToken)) {
                if ($helper->getError()) {
                    header('HTTP/1.0 401 Unauthorized');
                    echo 'Error: ' . $helper->getError() . "\n";
                    echo 'Error Code: ' . $helper->getErrorCode() . "\n";
                    echo 'Error Reason: ' . $helper->getErrorReason() . "\n";
                    echo 'Error Description: ' . $helper->getErrorDescription() . "\n";
                } else {
                    header('HTTP/1.0 400 Bad Request');
                    echo 'Bad request';
                }
                exit;
            }

            /*
             * Add webhook
             */

            $add_web_hook = $njt_fb_pr_api->addPageWebhooks($this->getWebHookCallBackUrl());
            /*
             * End adding webhook
             */

            /*
             * get user's information
             */
            $admin_info = $njt_fb_pr_api->getUserInfo($accessToken);
            NjtFbPrAdmin::insert(array(
                'id' => $admin_info->id,
                'name' => $admin_info->name,
                'token' => $accessToken,
            ));

            wp_safe_redirect(add_query_arg(array('_subscribe' => true), $this->getDashboardPageUrl()));
        }
        /*
         * Webhook callback
         */
        if ((isset($wp_query->query_vars[$this->getRouteVar('webhook-callback')])) && !is_null($wp_query->query_vars[$this->getRouteVar('webhook-callback')])) {
            $hub_mode = ((isset($_REQUEST['hub_mode'])) ? $_REQUEST['hub_mode'] : '');
            $hub_challenge = ((isset($_REQUEST['hub_challenge'])) ? $_REQUEST['hub_challenge'] : '');
            $hub_verify_token = ((isset($_REQUEST['hub_verify_token'])) ? $_REQUEST['hub_verify_token'] : '');
            /*
             * For verifing
             */
            if (($hub_mode === 'subscribe') && (get_option('njt_fb_pr_fb_verify_token') === $hub_verify_token)) {
                echo $hub_challenge;
            }
            /*
             * For doing stuff
             */
            $data = json_decode(file_get_contents("php://input"), true);

            /*
             * Someone commented
             */

            if (isset($data['entry'][0]['changes'])) {
                $id_user_send = $data["entry"][0]["changes"][0]["value"]["from"]["id"];
                foreach ($data['entry'][0]['changes'] as $k => $v) {
                    if ($v['field'] == 'feed') {
                        if (($v['value']['item'] == 'comment') && ($v['value']['verb'] == 'add')) {
                            $page = $data['entry'][0]['id'];

                            $parent_id = $v['value']['parent_id'];
                            $post_id = $v['value']['post_id'];
                            if (isset($v['value']['sender_name'])) {
                                $sender_name = $v['value']['sender_name'];
                            } else {
                                $sender_name = $v['value']['from']['name'];
                            }
                            $comment_id = $v['value']['comment_id'];
                            $sender_id = $v['value']['sender_id'];
                            $message = $v['value']['message'];
                            $created_time = $v['value']['created_time'];

                            if ($sender_id == $page) {
                                return;
                            }

                            /*
                             * Spam Defender
                             */
                            if (get_option('njt_fb_pr_spam_defender_enable', '') == '1') {
                                if ($this->isSpamComment($message)) {
                                    $page_token = NjtFbPrPage::getPageTokenFromFacebookPageId($page);

                                    $njt_fb_pr_api->deleteComment($comment_id, $page_token);
                                    return;
                                }
                            }

                            /*if (false === (get_transient('njt_fb_pr_is_insert_history_' . $comment_id))) {
                            set_transient('njt_fb_pr_is_insert_history_' . $comment_id, 'yes', DAY_IN_SECONDS);
                            $find_post = NjtFbPrPost::findPostWithFbId($post_id, $page);
                            if (apply_filters('njt_fb_pr_will_insert_history', true, $find_post, $v)) {
                            $post_content = $v['value'];
                            $post_content = maybe_serialize($post_content);
                            NjtFbPrHistory::insert(array(
                            'post_title' => wp_trim_words($post_content, 200),
                            'post_date' => date('Y-m-d H:i:s', $created_time),
                            'post_content' => $post_content,
                            'fb_post_wpid' => $find_post
                            ));
                            }
                            }*/

                            /******************************************************************
                             *
                             * Check if this post is able to send private reply
                             *
                             ******************************************************************/

                            $found_post = NjtFbPrPost::checkIfPostEnabledPrivateReplies($post_id);
                            if ($found_post !== false) {

                                $will_be_send = false;
                                $reply_when = get_post_meta($found_post, '_njt_fb_pr_reply_when', true);
                                $message_template = get_post_meta($found_post, '_njt_fb_pr_reply_content', true);
                                $message_template_if_not = get_post_meta($found_post, '_njt_fb_pr_reply_content_if_not', true);
                                $message_will_be_sent = $message_template;
                                if ($reply_when == 'if') {
                                    $rules = get_post_meta($found_post, '_njt_fb_pr_new_post_rules', true);
                                    $message_will_be_sent = $this->arrToCondition($message, $rules, $message_template_if_not);
                                    if (empty($message_will_be_sent)) {
                                        $will_be_send = false;
                                    } else {
                                        $will_be_send = true;
                                    }
                                } elseif ($reply_when == 'anytime') {
                                    $will_be_send = true;
                                }

                                /*
                                 * If able to sent
                                 */

                                if (count($this->shortcuts) > 0) {
                                    $message_will_be_sent = str_replace('[user_comment]', $message, $message_will_be_sent);
                                    $message_will_be_sent = str_replace('[sender_name]', $sender_name, $message_will_be_sent);
                                    $message_will_be_sent = str_replace('[first_name]', $this->fNameLname($sender_name, 'first_name'), $message_will_be_sent);
                                    $message_will_be_sent = str_replace('[last_name]', $this->fNameLname($sender_name, 'last_name'), $message_will_be_sent);
                                }
                                $page_token = NjtFbPrPage::getPageTokenFromFacebookPageId($page);
                                $message_will_be_sent = apply_filters('njt_fb_pre_private_reply_message', $message_will_be_sent, $found_post, $v);

                                $message_will_be_sent = do_shortcode($message_will_be_sent);

                                //check for reply to second level
                                $reply_to_second_level = get_post_meta($found_post, 'njt_fbpr_post_ms_en_nd_level_rep', true);
                                if ($reply_to_second_level != '1') {
                                    if ($parent_id != $post_id) {
                                        $will_be_send = false;
                                    }
                                }

                                //auto like comment
                                if (get_post_meta($found_post, 'njt_fbpr_post_ms_like_comment', true) == '1') {
                                    $njt_fb_pr_api->likeComment($comment_id, $page_token);
                                    $already_liked = true;
                                }
                                //auto hide comment
                                if (get_post_meta($found_post, 'njt_fbpr_post_ms_hide_comment', true) == '1') {
                                    $njt_fb_pr_api->hideComment($comment_id, $page_token);
                                    $already_hided = true;
                                }

                                if ($will_be_send === true) {
                                    $sent = $njt_fb_pr_api->privateReply($comment_id, $message_will_be_sent, $page_token);
                                    //file_put_contents(NJT_FB_PR_DIR."/log.txt", json_encode($sent)."\n", FILE_APPEND);
                                    if (!isset($sent->error)) {
                                        $this->increaseAnalytic($post_id, 'auto_private');
                                    }
                                }
                            }
                            /******************************************************************
                             *
                             * Check if this post's enabled auto comment
                             *
                             ******************************************************************/
                            $found_post = NjtFbPrPost::checkIfPostEnabledNormalReplies($post_id);
                            if ($found_post !== false) {
                                //check for reply to second level
                                $reply_to_second_level = get_post_meta($found_post, 'njt_fbpr_post_ms_en_nd_level_rep', true);
                                $will_send = true;
                                if ($reply_to_second_level != '1') {
                                    if ($parent_id != $post_id) {
                                        $will_send = false;
                                    }
                                }
                                if ($will_send === true) {
                                    if (false === (get_transient('njt_fb_pr_is_reply_' . $comment_id))) {
                                        $reply_when = get_post_meta($found_post, '_njt_fb_normal_reply_when', true);

                                        /*
                                         * Check type, text or photo
                                         */
                                        if ($reply_when == 'anytime') {
                                            $message_will_be_sent = get_post_meta($found_post, '_njt_fb_normal_pr_reply_content', true);
                                            if (!empty($message_will_be_sent)) {
                                                $_njt_fb_normal_pr_reply_type = get_post_meta($found_post, '_njt_fb_normal_pr_reply_type', true);
                                                //validate type
                                                if (!in_array($_njt_fb_normal_pr_reply_type, array('text', 'photo'))) {
                                                    $_njt_fb_normal_pr_reply_type = 'text';
                                                }

                                                if ($_njt_fb_normal_pr_reply_type == 'photo') {
                                                    $spin_photos = get_post_meta($found_post, '_njt_fb_normal_pr_reply_content_photos', true);
                                                    $message_will_be_sent = 'attachment_url=' . $this->getSpinPhotoFromArr(maybe_unserialize($spin_photos));
                                                } elseif ($_njt_fb_normal_pr_reply_type == 'text') {
                                                    $message_will_be_sent = str_replace('[sender_name]', $sender_name, $message_will_be_sent);
                                                    $message_will_be_sent = str_replace('[first_name]', $this->fNameLname($sender_name, 'first_name'), $message_will_be_sent);
                                                    $message_will_be_sent = str_replace('[last_name]', $this->fNameLname($sender_name, 'last_name'), $message_will_be_sent);
                                                    $message_will_be_sent = 'message=' . urlencode(do_shortcode($message_will_be_sent));
                                                }
                                            } else {
                                                $will_send = false;
                                            }
                                        } elseif ($reply_when == 'if') {
                                            $rules = get_post_meta($found_post, '_njt_fb_normal_new_post_rules', true);
                                            $check = $this->arrToConditionWithType(
                                                $message,
                                                $rules,
                                                array(
                                                    'content' => get_post_meta($found_post, '_njt_fb_normal_pr_reply_content_if_not', true),
                                                    'content_photos' => get_post_meta($found_post, '_njt_fb_normal_pr_reply_content_if_not_photos', true),
                                                    'type' => get_post_meta($found_post, '_njt_fb_normal_pr_if_not_reply_type', true),
                                                )
                                            );
                                            if (!empty($check['content'])) {
                                                $will_send = true;
                                                $message_will_be_sent = $check['content'];
                                                /*
                                                 * Check type, text or photo
                                                 */
                                                if ($check['type'] == 'photo') {
                                                    $spin_photos = $check['content_photos'];
                                                    $message_will_be_sent = 'attachment_url=' . $this->getSpinPhotoFromArr(maybe_unserialize($spin_photos));
                                                } elseif ($check['type'] == 'text') {
                                                    $message_will_be_sent = str_replace('[sender_name]', $sender_name, $message_will_be_sent);
                                                    $message_will_be_sent = str_replace('[first_name]', $this->fNameLname($sender_name, 'first_name'), $message_will_be_sent);
                                                    $message_will_be_sent = str_replace('[last_name]', $this->fNameLname($sender_name, 'last_name'), $message_will_be_sent);

                                                    $message_will_be_sent = 'message=' . urlencode(do_shortcode($message_will_be_sent));
                                                }
                                            } else {
                                                $will_send = false;
                                            }
                                        }

                                        /*
                                         * If able to sent
                                         */

                                        /*if (count($this->shortcuts) > 0) {
                                        $message_template = str_replace('[user_comment]', $message, $message_template);
                                        $message_template = str_replace('[sender_name]', $sender_name, $message_template);
                                        }*/
                                        $page_token = NjtFbPrPage::getPageTokenFromFacebookPageId($page);

                                        $message_will_be_sent = apply_filters('njt_fb_pre_public_reply_message', $message_will_be_sent, $found_post, $v);

                                        //auto like comment
                                        if (get_post_meta($found_post, 'njt_fbpr_post_ms_like_comment', true) == '1') {
                                            if (!isset($already_liked)) {
                                                $njt_fb_pr_api->likeComment($comment_id, $page_token);
                                                $already_liked = true;
                                            }
                                        }
                                        //auto hide comment
                                        if (get_post_meta($found_post, 'njt_fbpr_post_ms_hide_comment', true) == '1') {
                                            if (!isset($already_hided)) {
                                                $njt_fb_pr_api->hideComment($comment_id, $page_token);
                                                $already_hided = true;
                                            }
                                        }
                                        set_transient('njt_fb_pr_is_reply_' . $comment_id, '1', DAY_IN_SECONDS);
                                        if ($will_send === true && !empty($message_will_be_sent)) {
                                            $sent = $njt_fb_pr_api->postComment($comment_id, $message_will_be_sent, $page_token);
                                            // file_put_contents(NJT_FB_PR_DIR."/log.txt", json_encode($sent)."\n", FILE_APPEND);
                                            if (!isset($sent->error)) {
                                                $this->increaseAnalytic($post_id, 'auto_public');
                                            }
                                        }
                                    } //if not cached yet
                                }
                            }
                            do_action('njt_fb_pr_play_with_fb_post', $post_id);
                            break;
                        }
                    }
                }
            }
            status_header(200);
            exit();
        }
    }

    public function customRewriteRule()
    {
        foreach ($this->routes as $k => $v) {
            add_rewrite_rule('^' . $v['url'] . '/?', 'index.php?' . $v['var'], 'top');
        }
    }
    public function customRewriteTag()
    {
        foreach ($this->routes as $k => $v) {
            add_rewrite_tag('%' . $v['var'] . '%', '(' . $v['tag_regex'] . ')');
        }
    }
    public function getLoginCallBackUrl()
    {
        return esc_url(home_url('/' . $this->getRouteUrl('login-callback'), 'https')) . '/';
    }
    public function getWebHookCallBackUrl()
    {
        return esc_url(home_url('/' . $this->getRouteUrl('webhook-callback'), 'https')) . '/';
    }
    public function registerCustomPostType()
    {
        foreach ($this->tmp_post_post_types as $k => $v) {
            $labels = array(
                'name' => $v['name'],
            );

            $args = array(
                'labels' => $labels,
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'show_in_menu' => false,
                'query_var' => false,
                'rewrite' => array('slug' => $v['slug']),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'menu_position' => null,
                'can_export' => false,
                'supports' => array('title'), //array('title', 'custom-fields'),
                'capabilities' => array(
                    'create_posts' => 'do_not_allow', // false < WP 4.5
                ),
                'map_meta_cap' => true, // Set to `false`, if users are not allowed to edit/delete existing posts
            );

            register_post_type($k, $args);
        }
    }

    private function getLastestPostsFromApi($fb_page_id, $s_page_id, $delete_old_posts = false)
    {
        global $njt_fb_pr_api;
        /*
         * Delete old posts
         */
        if ($delete_old_posts) {
            NjtFbPrPost::deleteOldPosts($s_page_id);
        }
        /*
         * End deleting
         */
        $posts_from_api = $njt_fb_pr_api->getNewPosts($fb_page_id, NjtFbPrPage::getPageTokenFromPageId($s_page_id));
        $posts = $this->insertRawDataToDatabase($posts_from_api->data, $fb_page_id, $s_page_id);

        $return = array('posts' => $posts, 'fb_page_id' => $fb_page_id);
        if (isset($posts_from_api->paging)) {
            if (isset($posts_from_api->paging->next)) {
                $return['next'] = $posts_from_api->paging->next;
            }
        }
        return $return;
    }

    private function insertRawDataToDatabase($data, $fb_page_id, $s_page_id)
    {
        $posts = array();
        foreach ($data as $k => $v) {
            $fb_post_id = $v->id;
            $post_date = date_i18n('Y-m-d H:i:s', strtotime($v->created_time));
            $mess = '';
            if (isset($v->message)) {
                $mess = $v->message;
            } else {
                if (isset($v->story)) {
                    $mess = $v->story;
                }
            }
            //$mess = ((isset($v->message)) ? $v->message : ((isset($v->story)) ? $v->story : ''));
            if (!NjtFbPrPost::isExists($fb_post_id, $s_page_id)) {
                NjtFbPrPost::insert(array(
                    'mess' => $mess,
                    'post_date' => $post_date,
                    'fb_post_id' => $fb_post_id,
                    'fb_page_id' => $fb_page_id,
                    's_page_id' => $s_page_id,
                    '_fb_attachment' => $v->picture,
                ));
            }

            /*
             * For returning
             */
            $posts[] = (object) array(
                'id' => $fb_post_id,
                'message' => $mess,
                'created_time' => $post_date,
            );
        }
        return $posts;
    }
    /*
     * Create filter for custom post type: njt_fb_pr_tmp_posts
     */
    public function restrictManagePosts()
    {
        $type = 'post';
        if (isset($_GET['post_type'])) {
            $type = $_GET['post_type'];
        }
        //only add filter to post type you want
        if ($type == 'njt_fb_pr_tmp_posts') {
            $from = ((isset($_GET['from'])) ? $_GET['from'] : '');
            $to = ((isset($_GET['to'])) ? $_GET['to'] : '');
            ?>
            <input type="text" name="from" value="<?php echo esc_attr($from); ?>" class="regular-text njt_fb_pr_from" placeholder="<?php _e('From', NJT_FB_PR_I18N);?>" />
            <input type="text" name="to" value="<?php echo esc_attr($to); ?>" class="regular-text njt_fb_pr_to" placeholder="<?php _e('To', NJT_FB_PR_I18N);?>" />
            <?php
//fillter by page
            $admins = NjtFbPrAdmin::getAll();
            ?>
            <select name="s_page_id">
            <option value=""><?php _e('Select FB Page ', NJT_FB_PR_I18N);?></option>
            <?php
$current_v = isset($_GET['s_page_id']) ? $_GET['s_page_id'] : '';
            foreach ($admins as $k_admin => $admin) {
                echo sprintf('<optgroup label="%1$s">', $admin . ' (' . $k_admin . ')');

                $pages = NjtFbPrPage::getAllPages($k_admin);
                foreach ($pages as $k => $v) {
                    printf(
                        '<option value="%s"%s>%s</option>',
                        $v->sql_post_id,
                        selected($v->sql_post_id, $current_v, false),
                        $v->page_name
                    );
                }

                echo sprintf('</optgroup>');
            }
            ?>
            </select>
            <?php
//fillter by status
            $s_status = ((isset($_GET['s_status'])) ? $_GET['s_status'] : '');
            ?>
            <select name="s_status">
                <option value="" <?php selected($s_status, '');?>><?php _e('All', NJT_FB_PR_I18N);?></option>
                <option value="activated" <?php selected($s_status, 'activated');?>><?php _e('Activated', NJT_FB_PR_I18N);?></option>
                <option value="inactivate" <?php selected($s_status, 'inactivate');?>><?php _e('Inactivate', NJT_FB_PR_I18N);?></option>
            </select>
            <?php
}
    }
    public function parseQuery($query)
    {
        global $pagenow;
        $type = 'post';
        if (isset($_GET['post_type'])) {
            $type = $_GET['post_type'];
        }
        if ('njt_fb_pr_tmp_posts' == $type && is_admin() && $pagenow == 'edit.php' && isset($_GET['s_page_id']) && $_GET['s_page_id'] != '' && $query->query_vars['post_type'] == 'njt_fb_pr_tmp_posts') {
            /*$query->query_vars['meta_key'] = 's_page_id';
            $query->query_vars['meta_value'] = $_GET['s_page_id'];*/
            $query->query_vars['meta_query'][] = array(
                'key' => 's_page_id',
                'value' => $_GET['s_page_id'],
                'compare' => '=',
            );
        }
        if ('njt_fb_pr_tmp_posts' == $type && is_admin() && $pagenow == 'edit.php' && isset($_GET['s_status']) && $_GET['s_status'] != '' && $query->query_vars['post_type'] == 'njt_fb_pr_tmp_posts') {
            $s_status = $_GET['s_status'];
            if ($s_status == 'activated') {
                $s_status = 1;
            } elseif ($s_status == 'inactivate') {
                $s_status = 0;
            }
            $query->query_vars['meta_query'][] = array(
                'key' => '_is_activated',
                'value' => $s_status,
                'compare' => '=',
            );
            //_is_activated
        }
        if ('njt_fb_pr_tmp_posts' == $type && is_admin() && $pagenow == 'edit.php' && $query->query_vars['post_type'] == 'njt_fb_pr_tmp_posts') {
            $from = ((isset($_GET['from'])) ? $_GET['from'] : '');
            $to = ((isset($_GET['to'])) ? $_GET['to'] : '');
            if (!isset($query->query_vars['date_query'])) {
                $query->query_vars['date_query'] = array();
            }
            if (!empty($from) || !empty($to)) {
                if (!is_array($query->query_vars['date_query'])) {
                    $query->date_query = array();
                }

                if (empty($to)) {
                    $from = explode('-', $from);
                    $query->query_vars['date_query'] = array(
                        array(
                            'after' => array(
                                'year' => $from[2],
                                'month' => $from[1],
                                'day' => $from[0],
                            ),
                            'inclusive' => true,
                        ),
                    );
                } elseif (empty($from)) {
                    $to = explode('-', $to);
                    $query->query_vars['date_query'] = array(
                        array(
                            'before' => array(
                                'year' => $to[2],
                                'month' => $to[1],
                                'day' => $to[0],
                            ),
                            'inclusive' => true,
                        ),
                    );
                } else {
                    $from = explode('-', $from);
                    $to = explode('-', $to);
                    $query->query_vars['date_query'] = array(
                        array(
                            'before' => array(
                                'year' => $to[2],
                                'month' => $to[1],
                                'day' => $to[0],
                            ),
                            'after' => array(
                                'year' => $from[2],
                                'month' => $from[1],
                                'day' => $from[0],
                            ),
                            'inclusive' => true,
                        ),
                    );
                }
            }
        }
    }
    /*
     * Disable month dropdown
     */
    public function disableMonthsDropdown($post_type)
    {
        if (in_array($post_type, array_keys($this->tmp_post_post_types))) {
            return true;
        }
    }

    /*
     * Remove subsubsub
     */
    public function removeSubSubSub($views)
    {
        $views = array();

        $s_page_id = ((isset($_GET['s_page_id'])) ? $_GET['s_page_id'] : '');
        $data = array('s_page_id' => $s_page_id);

        if (!empty($s_page_id)) {
            $views = array(
                'njt_fb_pr_get_posts' => NjtFbPrView::load('admin.get-posts-btn', $data),
                'njt_fb_pr_find_post' => NjtFbPrView::load('admin.find-post-btn', $data),
                'njt_fb_pr_reply_comments' => NjtFbPrView::load('admin.reply-comments-btn', ($data + array('page_slug' => $this->reply_commment_page_slug))),
                'njt_fb_pr_new_post' => NjtFbPrView::load('admin.new-post-btn', $data),
            );
        }
        return $views;
    }

    /*
     * Ajax functions
     */
    public function ajaxGetPosts()
    {
        check_ajax_referer('njt_fb_pr', 'nonce', false);
        if (isset($_POST['s_page_id'])) {
            $s_page_id = $_POST['s_page_id'];
            $fb_page_id = get_post_meta($s_page_id, 'fb_page_id', true);
            $delete_old_posts = false;

            if (isset($_POST['delete_old_posts'])) {
                NjtFbPrPost::deleteOldPosts($s_page_id);
                $delete_old_posts = true;
            }
            $get = $this->getLastestPostsFromApi($fb_page_id, $s_page_id, $delete_old_posts);
            unset($get['posts']);
            wp_send_json_success($get);
        }
    }
    public function ajaxGetPostsByUrl()
    {
        global $njt_fb_pr_api;

        check_ajax_referer('njt_fb_pr', 'nonce', false);
        if (isset($_POST['url']) && isset($_POST['fb_page_id'])) {
            $url = $_POST['url'];
            $fb_page_id = $_POST['fb_page_id'];
            $s_page_id = $_POST['s_page_id'];

            /*
             * Gets from facebook API
             */
            $obj = $njt_fb_pr_api->getNewPostsByUrl($url);

            /*
             * Inserts to database
             */
            $posts_inserted = $this->insertRawDataToDatabase($obj->data, $fb_page_id, $s_page_id);
            if (isset($obj->paging)) {
                if (isset($obj->paging->next)) {
                    wp_send_json_success(array('next' => $obj->paging->next, 'fb_page_id' => $fb_page_id, 's_page_id' => $s_page_id));
                }
            } else {
                wp_send_json_success(array('finish' => true));
            }
        }
    }
    public function ajaxSubscribePage()
    {
        global $njt_fb_pr_api;

        check_ajax_referer('njt_fb_pr', 'nonce', false);
        if (isset($_POST['s_page_id'])) {
            $s_page_id = $_POST['s_page_id'];
            $page_token = NjtFbPrPage::getPageTokenFromPageId($s_page_id, true);
            $subscribe = $njt_fb_pr_api->subscribeAppToPage($page_token->token);
            //$subscribe = true;
            if ($subscribe === true) {
                update_post_meta($page_token->wp_id, 'is_subscribed', 'yes');
                wp_send_json_success(array(
                    'reload_url' => add_query_arg(array('page' => $this->dashboard_page_slug), admin_url('admin.php')),
                ));
            } else {
                wp_send_json_error(array(
                    'mess' => $subscribe,
                    'reload_url' => add_query_arg(array('page' => $this->dashboard_page_slug), admin_url('admin.php')),
                ));
            }
        }
    }
    public function ajaxUnSubscribePage()
    {
        global $njt_fb_pr_api;

        check_ajax_referer('njt_fb_pr', 'nonce', false);
        if (isset($_POST['s_page_id'])) {
            $s_page_id = $_POST['s_page_id'];
            $fb_page_id = get_post_meta($s_page_id, 'fb_page_id', true);
            $page_token = NjtFbPrPage::getPageTokenFromPageId($s_page_id, true);

            $unsubscribe = $njt_fb_pr_api->deleteSubscribe($fb_page_id, $page_token->token);

            update_post_meta($page_token->wp_id, 'is_subscribed', 'no');
            wp_send_json_success();
        }
    }
    public function ajaxFindFBPost()
    {
        global $njt_fb_pr_api;

        check_ajax_referer('njt_fb_pr', 'nonce', false);
        if (isset($_POST['url']) && isset($_POST['s_page_id'])) {
            $fb_url = $_POST['url'];
            $s_page_id = $_POST['s_page_id'];
            $fb_page_id = get_post_meta($s_page_id, 'fb_page_id', true);

            if (!filter_var($fb_url, FILTER_VALIDATE_URL)) {
                wp_send_json_error(array('mess' => __('The url is not valid.', NJT_FB_PR_I18N)));
                exit();
            }
            preg_match('#https?:\/\/(?:www\.)?(?:m\.)?facebook.com\/(?:.+)(?:(?:\/)|(?:album_id\=))([0-9]+)\/?#', $fb_url, $m);
            if (isset($m[1])) {
                $fb_id = $m[1];
                /* Find in database first */
                $find = NjtFbPrPost::findPostWithFbId($fb_id, $fb_page_id);
                if ($find === false) {
                    /*
                     * If not found in database, continue with find on facebook
                     */
                    $page_token = NjtFbPrPage::getPageTokenFromPageId($s_page_id);
                    $find_from_fb = $njt_fb_pr_api->findFBPost($fb_page_id . '_' . $fb_id, $page_token);
                    if (!isset($find_from_fb->id)) {
                        wp_send_json_error(array(
                            'mess' => sprintf(
                                __('Can not find post. Error %1$s', NJT_FB_PR_I18N),
                                $find_from_fb->error->message
                            ),
                        ));
                        exit();
                    } else {
                        /*
                         * Insert to database
                         */
                        $mess = '';
                        if (isset($find_from_fb->name)) {
                            $mess = $find_from_fb->name;
                        } else {
                            if (isset($find_from_fb->message)) {
                                $mess = $find_from_fb->message;
                            } else {
                                if (isset($find_from_fb->story)) {
                                    $mess = $find_from_fb->story;
                                } else {
                                    $mess = $find_from_fb->id;
                                }
                            }
                        }
                        $insert = NjtFbPrPost::insert(array(
                            'mess' => $mess,
                            'fb_post_id' => $find_from_fb->id,
                            'fb_page_id' => $fb_page_id,
                            's_page_id' => $s_page_id,
                            'post_date' => $post_date = date_i18n('Y-m-d H:i:s', strtotime($find_from_fb->created_time)),
                        ));
                        wp_send_json_success(array(
                            'html' => sprintf(
                                '<p class="_result"><label>%1$s</label><a class="button" href="%3$s">%2$s</a></p>',
                                __('Success', NJT_FB_PR_I18N),
                                __('View Post', NJT_FB_PR_I18N),
                                esc_url(add_query_arg(array('post' => $insert, 'action' => 'edit'), admin_url('post.php')))
                            ),
                            'url' => add_query_arg(array('post' => $insert, 'action' => 'edit'), admin_url('post.php')),
                        ));
                    }
                } else {
                    wp_send_json_success(array(
                        'html' => sprintf(
                            '<p class="_result"><label>%1$s</label><a class="button" href="%3$s">%2$s</a></p>',
                            __('Success', NJT_FB_PR_I18N),
                            __('View Post', NJT_FB_PR_I18N),
                            esc_url(add_query_arg(array('post' => $find, 'action' => 'edit'), admin_url('post.php')))
                        ),
                        'url' => add_query_arg(array('post' => $find, 'action' => 'edit'), admin_url('post.php')),
                    ));
                }
            } else {
                wp_send_json_error(array('mess' => __('Can not find post with this url.', NJT_FB_PR_I18N)));
                exit();
            }
        }
    }
    public function ajaxNewFBPost() {
        global $njt_fb_pr_api;

        check_ajax_referer('njt_fb_pr', 'nonce', false);
        if (isset($_POST['s_page_id']) && isset($_POST['message']) && trim($_POST['message']) != '') {
            $message = trim($_POST['message']);
            $s_page_id = $_POST['s_page_id'];
            $fb_page_id = get_post_meta($s_page_id, 'fb_page_id', true);
            $page_token = NjtFbPrPage::getPageTokenFromPageId($s_page_id, false);
            $new_post = $njt_fb_pr_api->newPost($message, $fb_page_id, $page_token);
            if(isset($new_post->id)) {
                wp_send_json_success(array(
                    'html' => sprintf('<p>Success!. <a href="https://facebook.com/%1$s" target="_blank">View Your Post</a></p>', $new_post->id)
                ));
            } else {
                wp_send_json_error(array(
                    'mess' => $new_post->error->message
                ));
            }
        }
        exit();
    }
    public function ajaxAddNewAdmin()
    {
        if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['token'])) {
            NjtFbPrAdmin::insert(array(
                'id' => $_GET['id'],
                'name' => $_GET['name'],
                'token' => $_GET['token'],
            ));
        }
    }
    public function ajaxRemovePage()
    {
        check_ajax_referer('njt_fb_pr', 'nonce');
        if (isset($_POST['s_page_id'])) {
            $s_page_id = (int) $_POST['s_page_id'];
            NjtFbPrPage::deletePage($s_page_id);
            wp_send_json_success();
        } else {
            wp_send_json_error(array('mess' => __('Invalid page', NJT_FB_PR_I18N)));
        }
        exit();
    }
    public function ajaxUpdateOldPosts()
    {
        check_ajax_referer('njt_fb_pr', 'nonce');
        $post_id = ((isset($_POST['post_id'])) ? $_POST['post_id'] : '');
        $update_type = ((isset($_POST['update_type'])) ? $_POST['update_type'] : '');
        if ($update_type == 'rules') {
            //private rules
            $old_pr_rules = get_post_meta($post_id, '_njt_fb_pr_post_rules', true);
            if (is_array($old_pr_rules)) {
                $new_pr_rules = array(
                    'parent_group_1' => array(
                        'groups' => $old_pr_rules,
                        'reply' => get_post_meta($post_id, '_njt_fb_normal_pr_reply_content', true),
                    ),
                );
                update_post_meta($post_id, '_njt_fb_pr_new_post_rules', $new_pr_rules);
                delete_post_meta($post_id, '_njt_fb_pr_post_rules', '');
            }

            //normal rules
            $old_normal_rules = get_post_meta($post_id, '_njt_fb_normal_post_rules', true);
            if (is_array($old_normal_rules)) {
                $new_normal_rules = array(
                    'parent_group_1' => array(
                        'groups' => $old_normal_rules,
                        'reply' => get_post_meta($post_id, '_njt_fb_normal_pr_reply_content_if_not', true),
                    ),
                );
                update_post_meta($post_id, '_njt_fb_normal_new_post_rules', $new_normal_rules);
                delete_post_meta($post_id, '_njt_fb_normal_post_rules', '');
            }
            wp_send_json_success();
        } elseif ($update_type == 'status') {
            $is_active_private = (int) get_post_meta($post_id, '_njt_fb_pr_enable', true);
            $is_active_public = (int) get_post_meta($post_id, '_njt_fb_normal_pr_enable', true);
            if (($is_active_private == 1) || ($is_active_public == 1)) {
                update_post_meta($post_id, '_is_activated', 1);
            } else {
                update_post_meta($post_id, '_is_activated', 0);
            }
        } elseif ($update_type == 'update_status_last_post') {
            update_option('njt_fbpr_is_updated_status', '1');
        }
        exit();
    }
    public function ajaxGetComments()
    {
        global $njt_fb_pr_api;

        check_ajax_referer('njt_fb_pr', 'nonce', false);
        $fb_post_id = ((isset($_POST['fb_post_id'])) ? $_POST['fb_post_id'] : '');
        $page_token = ((isset($_POST['page_token'])) ? $_POST['page_token'] : '');
        $url = ((isset($_POST['url'])) ? $_POST['url'] : '');
        if (!empty($fb_post_id) && !empty($page_token)) {
            if (!empty($url)) {
                $obj = $njt_fb_pr_api->getComments($url);
            } else {
                $obj = $njt_fb_pr_api->getComments($fb_post_id, $page_token);
            }
            $data = array('comments' => array());
            if (isset($obj->data)) {
                foreach ($obj->data as $k => $v) {
                    $data['comments'][] = array(
                        'id' => $v->id,
                        'message' => $v->message,
                        'sender' => $v->from->name,
                    );
                }
                if (isset($obj->paging)) {
                    if (isset($obj->paging->next)) {
                        $data['url'] = $obj->paging->next;
                    }
                }
                wp_send_json_success($data);
            } else {
                wp_send_json_error(array('mess' => $obj->error->message));
            }
        }
    }
    public function ajaxReplyCommentsGetPosts()
    {
        check_ajax_referer('njt_fb_pr', 'nonce', false);

        $from = ((isset($_POST['from'])) ? $_POST['from'] : '');
        $to = ((isset($_POST['to'])) ? $_POST['to'] : '');
        $s = ((isset($_POST['s'])) ? $_POST['s'] : '');
        $s_page_id = ((isset($_POST['s_page_id'])) ? $_POST['s_page_id'] : '');

        //$m = ((isset($_POST['m'])) ? $_POST['m'] : '');
        //$my = njt_fbpr_m_to_monthyear($m);
        $args = array(
            'post_type' => 'njt_fb_pr_tmp_posts',
            'post_status' => 'published',
            'posts_per_page' => -1,
            'meta_key' => 's_page_id',
            'meta_value' => $s_page_id,
        );
        /*if (is_array($my)) {
        $args['date_query'] = array(
        array(
        'year'  => $my['year'],
        'month' => $my['month'],
        ),
        );
        }*/
        if (!empty($from) || !empty($to)) {
            if (empty($to)) {
                $from = explode('-', $from);
                $args['date_query'] = array(
                    array(
                        'after' => array(
                            'year' => $from[2],
                            'month' => $from[1],
                            'day' => $from[0],
                        ),
                        'inclusive' => true,
                    ),
                );
            } elseif (empty($from)) {
                $to = explode('-', $to);
                $args['date_query'] = array(
                    array(
                        'before' => array(
                            'year' => $to[2],
                            'month' => $to[1],
                            'day' => $to[0],
                        ),
                        'inclusive' => true,
                    ),
                );
            } else {
                $from = explode('-', $from);
                $to = explode('-', $to);
                $args['date_query']['date_query'] = array(
                    array(
                        'before' => array(
                            'year' => $to[2],
                            'month' => $to[1],
                            'day' => $to[0],
                        ),
                        'after' => array(
                            'year' => $from[2],
                            'month' => $from[1],
                            'day' => $from[0],
                        ),
                        'inclusive' => true,
                    ),
                );
            }
        }

        if (!empty($s)) {
            $args['s'] = $s;
        }
        $posts = get_posts($args);

        $data = array();
        if (count($posts) > 0) {
            $data['html'] = NjtFbPrView::load('admin.reply-comments.get-posts', array('posts' => $posts));
            $data['html_form'] = NjtFbPrView::load('admin.reply-comments.form-send', array('posts' => $posts));
        } else {
            $data['html'] = sprintf(__('Not posts found, click <a href="%1$s">here</a> to get posts', NJT_FB_PR_I18N), add_query_arg(array('post_type' => 'njt_fb_pr_tmp_posts', 's_page_id' => $s_page_id), admin_url('edit.php')));
            $data['html'] = sprintf('<div class="color-red">%1$s</div>', $data['html']);
        }
        wp_send_json_success($data);
        exit();
    }
    public function ajaxReplyCommentsReply()
    {
        global $njt_fb_pr_api;
        check_ajax_referer('njt_fb_pr', 'nonce', false);
        $page_token = ((isset($_POST['page_token'])) ? $_POST['page_token'] : '');
        $public_mess = ((isset($_POST['public_mess'])) ? $_POST['public_mess'] : '');
        $private_mess = ((isset($_POST['private_mess'])) ? $_POST['private_mess'] : '');
        $object_id = ((isset($_POST['object_id'])) ? $_POST['object_id'] : '');

        if (!empty($page_token) && !empty($object_id) && ((!empty($public_mess)) || (!empty($private_mess)))) {
            $data = array();
            /*
             * Send public reply
             */
            if (!empty($public_mess)) {
                //$public_reply = json_decode(json_encode(['error' => ['message' => '#' . rand(1, 99)]]));
                $public_mess = 'message=' . urlencode($public_mess);
                $public_reply = $njt_fb_pr_api->postComment($object_id, $public_mess, $page_token);
                if (isset($public_reply->error)) {
                    $data['public'] = array(
                        'success' => false,
                        'mess' => $public_reply->error->message,
                    );
                } else {
                    $this->increaseAnalytic($object_id, 'manual_public');
                    $data['public'] = array(
                        'success' => true,
                        'mess' => __('Sent', NJT_FB_PR_I18N),
                    );
                }
            }

            /*
             * Send private reply
             */
            if (!empty($private_mess)) {
                //$private_reply = json_decode(json_encode(['error' => ['message' => '#' . rand(1, 99)]]));
                $private_reply = $njt_fb_pr_api->privateReply($object_id, $private_mess, $page_token);
                if (isset($private_reply->error)) {
                    $data['private'] = array(
                        'success' => false,
                        'mess' => $private_reply->error->message,
                    );
                } else {
                    $this->increaseAnalytic($object_id, 'manual_private');
                    $data['private'] = array(
                        'success' => true,
                        'mess' => __('Sent', NJT_FB_PR_I18N),
                    );
                }
            }
            wp_send_json($data);
        } else {
            //hacking ?
        }
    }
    public function ajaxSendingInfo()
    {
        $current_user = wp_get_current_user();
        $response = wp_remote_post(
            'https://update.ninjateam.org/auto-reply/',
            array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(),
                'body' => array(
                    'co-data' => array(
                        'current_site' => njt_get_current_site(),
                        'email' => $current_user->user_email,
                        'firstname' => $current_user->user_firstname,
                        'lastname' => $current_user->user_lastname,
                    ),
                ),
            )
        );
        if (!is_wp_error($response)) {
            update_option('njt_auto_reply_already_send_info', '1');
            wp_send_json_success();
        }
    }

    public function ajaxCheckCode()
    {
        check_ajax_referer('njt_fb_pr', 'nonce', false);
        if (isset($_POST['_code'])) {
            $current_user = wp_get_current_user();
            $response = wp_remote_post(
                'https://update.ninjateam.org/check-auto-reply/',
                array(
                    'method' => 'POST',
                    'timeout' => 45,
                    'redirection' => 5,
                    'httpversion' => '1.0',
                    'blocking' => true,
                    'headers' => array(),
                    'body' => array(
                        'co-data' => array(
                            'current_site' => njt_get_current_site(),
                            'email' => $current_user->user_email,
                            'firstname' => $current_user->user_firstname,
                            'lastname' => $current_user->user_lastname,
                            'code' => $_POST['_code'],
                        ),
                    ),
                )
            );
            if (!is_wp_error($response)) {
                $json = json_decode($response['body']);
                if ($json->success == 'true') {
                    update_option('njt_fbpr_is_verified', 1);
                    wp_send_json_success();
                } else {
                    wp_send_json_error(array('mess' => 'Your code is invalid!'));
                }
            } else {
                wp_send_json_error(array('mess' => 'Server error, please try again later (#2)!'));
            }
        } else {
            wp_send_json_error(array('mess' => 'Server error, please try again later (#1)!'));
        }
    }

    public function ajaxCheckPremiumSupport()
    {
        check_ajax_referer('njt_fb_pr_nonce', 'nonce', false);
        $code = ((isset($_POST['code'])) ? $_POST['code'] : '');
        if (!empty($code)) {
            $json = @file_get_contents(sprintf('https://update.ninjateam.org/validate/%s', $code));
            if ($json) {
                $json = json_decode($json);
                if ($json->status !== false) {
                    if ($json->data == '19516884') {
                        $html = sprintf('<a target="_blank" class="button button-primary" href="%1$s">%2$s</a>', 'https://m.me/ninjateam.org', __('Chat With Support', NJT_FB_PR_I18N));
                        wp_send_json_success(array('html' => $html));
                    } else {
                        wp_send_json_error(array('html' => __('Your Purchase Code is invalid.', NJT_FB_PR_I18N)));
                    }
                } else {
                    wp_send_json_error(array('html' => __('Your Purchase Code is invalid.', NJT_FB_PR_I18N)));
                }
            } else {
                wp_send_json_error(array('html' => __('Couldn\'t check, please try again later.', NJT_FB_PR_I18N)));
            }
        } else {
            wp_send_json_error(array('html' => __('Error #1', NJT_FB_PR_I18N)));
        }
    }
    public function postRowActions($actions, $post)
    {
        if ($post->post_type == 'njt_fb_pr_tmp_posts') {
            if (isset($actions['trash'])) {
                unset($actions['trash']);
            }
            if (isset($actions['inline hide-if-no-js'])) {
                unset($actions['inline hide-if-no-js']);
            }
            $actions['delete'] = sprintf(
                '<a href="%s" class="submitdelete" aria-label="%s">%s</a>',
                get_delete_post_link($post->ID, '', true),
                /* translators: %s: post title */
                esc_attr(
                    sprintf(
                        __('Delete &#8220;%s&#8221; permanently', NJT_FB_PR_I18N),
                        $post->post_title
                    )
                ),
                __('Delete Permanently', NJT_FB_PR_I18N)
            );
        }
        return $actions;
    }

    /*
     * Adds meta boxes
     */
    public function registerMetaBoxes()
    {
        global $post;
        add_meta_box('njt_fb_pr_tmp_posts_detail_posts', __('Your FB post', NJT_FB_PR_I18N), array($this, 'postsTypePostDetailMetaBox'), 'njt_fb_pr_tmp_posts', 'normal', 'low');

        add_meta_box('njt_fb_pr_tmp_posts_private_reply', __('Private Reply Settings', NJT_FB_PR_I18N), array($this, 'postsTypePrivateReplyMetaBox'), 'njt_fb_pr_tmp_posts', 'normal', 'low');

        add_meta_box('njt_fb_pr_tmp_posts_public_reply', __('Normal Reply Settings', NJT_FB_PR_I18N), array($this, 'postsTypePublicReplyMetaBox'), 'njt_fb_pr_tmp_posts', 'normal', 'low');

        add_meta_box('njt_fb_pr_tmp_posts_more_settings', __('More Settings', NJT_FB_PR_I18N), array($this, 'postsTypeMoreSettingsMetaBox'), 'njt_fb_pr_tmp_posts', 'normal', 'low');

        /*add_meta_box(
    'njt_fb_pr_tmp_posts_histories',
    __('Comments', NJT_FB_PR_I18N),
    array($this, 'postsTypeHistoriesMetaBox'),
    'njt_fb_pr_tmp_posts',
    'normal',
    'low'
    );*/
    }
    private function arrToCondition($mess, $arr, $else_content = '')
    {
        if ($this->case_sensitve === false) {
            $mess = strtolower($mess);
        }
        $return = $else_content;
        foreach ($arr as $k => $parent_group) {
            $check_this_parent_group = $this->checkSingleGroup($parent_group, $mess);
            if ($check_this_parent_group === true) {
                $return = $parent_group['reply'];
                break;
            }
        }
        return $return;
    }

    /**
     * Check if a string valid with conditional
     *
     * @param  String $mess          String to check
     * @param  Array $rules          Rules
     * @param  Array $else_content   If not valid, return this. Eg: ['content' => 'Some String', 'type' => 'text']
     *
     * @return Array
     */

    private function arrToConditionWithType($mess, $rules, $else_content = array())
    {
        if ($this->case_sensitve === false) {
            $mess = strtolower($mess);
        }
        $return = $else_content;
        foreach ($rules as $k => $parent_group) {
            $check_this_parent_group = $this->checkSingleGroup($parent_group, $mess);
            if ($check_this_parent_group === true) {
                $return['content'] = $parent_group['reply'];
                $return['content_photos'] = $parent_group['reply_photos'];
                $return['type'] = $parent_group['reply_type'];
                break;
            }
        }
        return $return;
    }
    private function checkSingleGroup($parent_group, $mess)
    {
        $true_false = false;
        foreach ($parent_group['groups'] as $k => $group) {
            $total_true = $total_false = 0;
            foreach ($group as $k_rule => $rule) {
                $_check = false;
                if ($this->case_sensitve === false) {
                    $rule['value'] = strtolower($rule['value']);
                }
                switch ($rule['operator']) {
                    case '=':
                        $_check = ($mess == $rule['value']);
                        break;
                    case 'contain':
                        $rule['value'] = str_replace(
                            array('\\', '+', '.', '?', '*'),
                            array('\\\\', '\+', '\.', '\?', '\*'),
                            $rule['value']
                        );
                        $_check = (boolean) preg_match('#' . $rule['value'] . '#', $mess);
                        break;
                    case '^':
                        $_check = substr($mess, 0, strlen($rule['value'])) == $rule['value'];
                        break;
                    case '$':
                        $_check = substr($mess, 0 - strlen($rule['value'])) == $rule['value'];
                        break;
                }
                if ($_check === true) {
                    $total_true++;
                } elseif ($_check === false) {
                    $total_false++;
                }
            }
            if ($total_true == count($group)) {
                $true_false = true;
                break;
            }
        }
        return $true_false;
    }
    public function postsTypePostDetailMetaBox()
    {
        global $post;
        $fb_post_id = get_post_meta($post->ID, 'fb_post_id', true);
        $page_id = explode('_', $fb_post_id);
        $page_id = $page_id[0];
        $data = array(
            'post' => $post,
            'fb_post_id' => $fb_post_id,
            'page_token' => NjtFbPrPage::getPageTokenFromFacebookPageId($page_id, true),
        );

        echo NjtFbPrView::load('admin.post-detail-metabox', $data);

    }
    public function postsTypePrivateReplyMetaBox()
    {
        global $post;
        //old _njt_fb_pr_post_rules
        $groups = get_post_meta($post->ID, '_njt_fb_pr_new_post_rules', true);

        $reply_when = get_post_meta($post->ID, '_njt_fb_pr_reply_when', true);
        if ($reply_when == '') {
            $reply_when = 'anytime';
        }
        /*
         * Set default rules if there are no any rules
         */
        if (empty($groups)) {
            $groups = array(
                'parent_group_1' => array(
                    'groups' => array(
                        'group_1' => array(
                            'rule_1' => array('operator' => '', 'value' => ''),
                        ),
                    ),
                    'reply' => '',
                ),
            );
        }
        $data = array(
            'post' => $post,
            'groups' => $groups,
            'shortcuts' => $this->shortcuts,
            'reply_when' => $reply_when,
            'post_id' => $post->ID,
        );

        echo NjtFbPrView::load('admin.private-reply-settings-metabox', $data);
    }
    public function postsTypePublicReplyMetaBox()
    {
        global $post;
        /*
         * Normal reply
         */
        $data = array();

        $normal_reply_when = get_post_meta($post->ID, '_njt_fb_normal_reply_when', true);
        if ($normal_reply_when == '') {
            $normal_reply_when = 'anytime';
        }

        //old _njt_fb_normal_post_rules
        $normal_groups = get_post_meta($post->ID, '_njt_fb_normal_new_post_rules', true);

        /*
         * Set default rules if there are no any rules
         */
        if (empty($normal_groups)) {
            $normal_groups = array(
                'parent_group_1' => array(
                    'groups' => array(
                        'group_1' => array(
                            'rule_1' => array('operator' => '', 'value' => ''),
                        ),
                    ),
                    'reply' => '',
                ),
            );
        }
        $data['post'] = $post;
        $data['post_id'] = $post->ID;
        $data['normal_reply_when'] = $normal_reply_when;
        $data['normal_groups'] = $normal_groups;
        $data['shortcuts'] = $this->public_reply_shortcuts;

        echo NjtFbPrView::load('admin.public-reply-settings-metabox', $data);
    }
    public function postsTypeMoreSettingsMetaBox()
    {
        global $post;
        $data = array('post' => $post);
        echo NjtFbPrView::load('admin.more-settings-metabox', $data);
    }
    public function postsTypeHistoriesMetaBox()
    {
        global $post;

        $histories = NjtFbPrHistory::getHistory($post->ID);

        $data = array(
            'post' => $post,
            'histories' => $histories,
        );
        echo NjtFbPrView::load('admin.post-histories-metabox', $data);
    }
    public function savePost($_post_id)
    {
        global $post;
        if (is_null($post) || ($post->post_type != 'njt_fb_pr_tmp_posts')) {
            return;
        }
        $ids = array($_post_id => $_post_id);

        if (isset($_POST['_njt_fb_pr_apply_to_all_posts']) && ($_POST['_njt_fb_pr_apply_to_all_posts'] == 'yes')) {
            //get fb_page of this post
            $s_page_id = get_post_meta($_post_id, 's_page_id', true);
            //get all post id in this page: $s_page_id
            $all_post = NjtFbPrPost::getAllPosts($s_page_id);
            foreach ($all_post as $post_k => $post_v) {
                $ids[$post_v->post_id] = $post_v->post_id;
            }
        }
        //now, update
        foreach ($ids as $k => $post_id) {
            //---------------------------------------------
            //
            // Private Replies
            //
            //---------------------------------------------
            $update_active = false;
            if (isset($_POST['_njt_fb_pr_enable'])) {
                update_post_meta($post_id, '_njt_fb_pr_enable', '1');
                $update_active = true;
            } else {
                update_post_meta($post_id, '_njt_fb_pr_enable', '0');
            }
            if (isset($_POST['_njt_fb_pr_reply_content'])) {
                update_post_meta($post_id, '_njt_fb_pr_reply_content', $_POST['_njt_fb_pr_reply_content']);
            }
            if (isset($_POST['_njt_fb_pr_reply_content_if_not'])) {
                update_post_meta($post_id, '_njt_fb_pr_reply_content_if_not', $_POST['_njt_fb_pr_reply_content_if_not']);
            }
            if (isset($_POST['_njt_fb_pr_reply_when'])) {
                update_post_meta($post_id, '_njt_fb_pr_reply_when', $_POST['_njt_fb_pr_reply_when']);
            }

            //---------------------------------------------
            //
            // Normal Replies
            //
            //---------------------------------------------
            if (isset($_POST['_njt_fb_normal_pr_enable'])) {
                update_post_meta($post_id, '_njt_fb_normal_pr_enable', '1');
                $update_active = true;
            } else {
                update_post_meta($post_id, '_njt_fb_normal_pr_enable', '0');
            }
            if (isset($_POST['_njt_fb_normal_pr_reply_content'])) {
                update_post_meta($post_id, '_njt_fb_normal_pr_reply_content', $_POST['_njt_fb_normal_pr_reply_content']);
            }
            // spin photos for "any"
            if (isset($_POST['_njt_fb_normal_pr_reply_content_photos'])) {
                update_post_meta($post_id, '_njt_fb_normal_pr_reply_content_photos', $_POST['_njt_fb_normal_pr_reply_content_photos']);
            }

            if (isset($_POST['_njt_fb_normal_pr_reply_content_if_not'])) {
                update_post_meta($post_id, '_njt_fb_normal_pr_reply_content_if_not', $_POST['_njt_fb_normal_pr_reply_content_if_not']);
            }
            //spin photo for if-not
            if (isset($_POST['_njt_fb_normal_pr_reply_content_if_not_photos'])) {
                update_post_meta($post_id, '_njt_fb_normal_pr_reply_content_if_not_photos', $_POST['_njt_fb_normal_pr_reply_content_if_not_photos']);
            } else {
                update_post_meta($post_id, '_njt_fb_normal_pr_reply_content_if_not_photos', array());
            }

            if (isset($_POST['_njt_fb_normal_reply_when'])) {
                update_post_meta($post_id, '_njt_fb_normal_reply_when', $_POST['_njt_fb_normal_reply_when']);
            }
            //normal reply anytime
            if (isset($_POST['_njt_fb_normal_pr_reply_type'])) {
                update_post_meta($post_id, '_njt_fb_normal_pr_reply_type', $_POST['_njt_fb_normal_pr_reply_type']);
            }
            //normal reply if not
            if (isset($_POST['_njt_fb_normal_pr_if_not_reply_type'])) {
                update_post_meta($post_id, '_njt_fb_normal_pr_if_not_reply_type', $_POST['_njt_fb_normal_pr_if_not_reply_type']);
            }

            /*
             * Updates Private Conditional
             */
            $con = array();
            if (isset($_POST['njt_fb_pr_con'])) {
                $h = 1;
                foreach ($_POST['njt_fb_pr_con'] as $k_p_group => $v_p_group) {
                    $i = 1;
                    foreach ($v_p_group as $k => $v) {
                        if ($k == 'reply') {
                            $con['parent_group_' . $h]['reply'] = $v;
                        } else {
                            $v_group_new = array();
                            $j = 1;
                            foreach ($v as $k_rule => $rule) {
                                $v_group_new['rule_' . $j] = array(
                                    'operator' => $rule['operator'],
                                    'value' => $rule['value'],
                                );
                                $j++;
                            }
                            $con['parent_group_' . $h]['groups']['group_' . $i] = $v_group_new;
                            $i++;
                        }
                    }
                    $h++;
                }
            }

            //update_post_meta($post_id, '_njt_fb_pr_post_rules', $con); //the old one
            update_post_meta($post_id, '_njt_fb_pr_new_post_rules', $con);

            /*
             * Updates Normal Conditional
             */
            $con = array();
            if (isset($_POST['njt_fb_normal_con'])) {
                $h = 1;
                foreach ($_POST['njt_fb_normal_con'] as $k_p_group => $v_p_group) {
                    $i = 1;
                    foreach ($v_p_group as $k => $v) {
                        if ($k == 'reply') {
                            $con['parent_group_' . $h]['reply'] = $v;
                        } elseif ($k == 'reply_photos') {
                            $con['parent_group_' . $h]['reply_photos'] = $v;
                        } elseif ($k == 'reply_type') {
                            $con['parent_group_' . $h]['reply_type'] = $v;
                        } else {
                            $v_group_new = array();
                            $j = 1;
                            foreach ($v as $k_rule => $rule) {
                                $v_group_new['rule_' . $j] = array(
                                    'operator' => $rule['operator'],
                                    'value' => $rule['value'],
                                );
                                $j++;
                            }
                            $con['parent_group_' . $h]['groups']['group_' . $i] = $v_group_new;
                            $i++;
                        }
                    }
                    $h++;
                }
            }
            //update_post_meta($post_id, '_njt_fb_normal_post_rules', $con);//the old one
            update_post_meta($post_id, '_njt_fb_normal_new_post_rules', $con);

            /*
             * more settings
             */

            //enable reply to second level
            if (isset($_POST['njt_fbpr_post_ms_en_nd_level_rep'])) {
                update_post_meta($post_id, 'njt_fbpr_post_ms_en_nd_level_rep', '1');
            } else {
                update_post_meta($post_id, 'njt_fbpr_post_ms_en_nd_level_rep', '0');
            }
            //auto like comment
            if (isset($_POST['njt_fbpr_post_ms_like_comment'])) {
                update_post_meta($post_id, 'njt_fbpr_post_ms_like_comment', '1');
            } else {
                update_post_meta($post_id, 'njt_fbpr_post_ms_like_comment', '0');
            }

            //auto hide comment
            if (isset($_POST['njt_fbpr_post_ms_hide_comment'])) {
                update_post_meta($post_id, 'njt_fbpr_post_ms_hide_comment', '1');
            } else {
                update_post_meta($post_id, 'njt_fbpr_post_ms_hide_comment', '0');
            }

            //update active or inactive
            if ($update_active === true) {
                update_post_meta($post_id, '_is_activated', '1');
            } else {
                update_post_meta($post_id, '_is_activated', '0');
            }
        }
    }
    /*
     * Removes post state
     */
    public function displayPostStates($post_states, $post)
    {
        if ($post->post_type == 'njt_fb_pr_tmp_posts') {
            $post_states = array();
        }
        return $post_states;
    }
    public function postBulkActions($actions)
    {
        if (isset($actions['trash'])) {
            unset($actions['trash']);
        }
        $actions['delete'] = __('Delete', NJT_FB_PR_I18N);
        return $actions;
    }
    public function adminFooterEdit()
    {
        global $post;
        echo NjtFbPrView::load('admin.tmp-posts-footer', array());
    }
    public function adminFooter()
    {
        echo NjtFbPrView::load('admin.footer', array());
    }
    public function singlePostFooter()
    {
        global $post;
        if (is_object($post)) {
            if ($post->post_type == 'njt_fb_pr_tmp_posts') {
                echo NjtFbPrView::load('admin.tmp-posts-footer-single', array());
            }
        }
    }
    private function isSpamComment($comment)
    {
        $bad_words = explode(',', get_option('njt_fb_pr_spam_defender_bad_words', ''));
        $is_spam = false;
        if (count($bad_words)) {
            foreach ($bad_words as $k => $v) {
                if (strpos($comment, trim($v)) !== false) {
                    $is_spam = true;
                    break;
                }
            }
        }
        return $is_spam;
    }

    public function postSubmitboxMiscActions($post)
    {
        if ($post->post_type != 'njt_fb_pr_tmp_posts') {
            return;
        }
        ?>
        <div class="misc-pub-section">
            <input type="checkbox" name="_njt_fb_pr_apply_to_all_posts" value="yes" id="_njt_fb_pr_apply_to_all_posts" />
            <label for="_njt_fb_pr_apply_to_all_posts"><?php _e('Apply to all posts in this page?', NJT_FB_PR_I18N);?></label>
        </div>
        <?php
}
    /*
     * Spint text functions
     */

    public function spinText($spin)
    {
        $spins_k = array();
        $sprin_v = array();
        preg_match_all('#({(?:[^}]+)})?+#', $spin, $m);
        foreach ($m[0] as $k => $v) {
            if (!empty($v)) {
                $spins_k[] = $v;
                $sprin_v[] = $this->strToRandStr($v);
            }
        }
        return str_replace($spins_k, $sprin_v, $spin);
    }
    public function strToRandStr($str)
    {
        $str = str_replace(array('{', '}'), '', $str);
        $arr = explode('|', $str);
        $k = rand(0, (count($arr) - 1));
        return $arr[$k];
    }

    public function customPostTypeColumn($posts_columns, $post_type)
    {
        if ($post_type == 'njt_fb_pr_tmp_posts') {
            $title = $posts_columns['title'];
            $date = $posts_columns['date'];
            unset($posts_columns['title']);
            unset($posts_columns['date']);
            $posts_columns['thumbnail'] = __('Image', NJT_FB_PR_I18N);
            $posts_columns['title'] = $title;
            $posts_columns['status'] = __('Status', NJT_FB_PR_I18N);
            $posts_columns['date'] = $date;
        }
        return $posts_columns;
    }
    public function customPostTypeContent($column_name, $post_id)
    {
        if ($column_name == 'thumbnail') {
            $_fb_attachment = get_post_meta($post_id, '_fb_attachment', true);
            if ($_fb_attachment == '') {
                $_fb_attachment = NJT_FB_PR_URL . '/assets/img/no-image.png';
            }
            echo sprintf('<img style="width: 100px;" src="%1$s" alt="" />', $_fb_attachment);
        }
        if ($column_name == 'status') {
            echo ((get_post_meta($post_id, '_is_activated', true) == '1') ?
                '<span class="njt-fbpr-activated">' . __('Activated', NJT_FB_PR_I18N) . '</span>' :
                '<span class="njt-fbpr-inactivate">' . __('Inactivate', NJT_FB_PR_I18N) . '</span>');
        }
    }
    public function customPostTypeSortable($sortable_columns)
    {
        $sortable_columns['status'] = '_is_activated';
        return $sortable_columns;
    }
    public function customOrderBy($clauses, $wp_query)
    {
        global $wpdb;
        if (isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == '_is_activated') {
            $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC)";
            if (strtoupper($wp_query->get('order')) == 'ASC') {
                $clauses['orderby'] .= 'ASC';
            } else {
                $clauses['orderby'] .= 'DESC';
            }
        }

        return $clauses;
    }
    public function addAdminNotices()
    {
        global $pagenow;
        if ($pagenow == 'edit.php') {
            if (isset($_GET['post_type']) && ($_GET['post_type'] == 'njt_fb_pr_tmp_posts') && isset($_GET['s_page_id'])) {
                $s_page_id = $_GET['s_page_id'];

                $page_info = get_post($s_page_id);
                $page_meta = get_post_meta($s_page_id);

                $finding_posts = NjtFbPrPost::findOldPostsWithSamePageId($page_meta['fb_page_id'][0], $s_page_id, $page_meta['fb_user_id'][0], true);
                if ($finding_posts > 0) {
                    $count_post = $finding_posts;
                    $delete_link = add_query_arg(array('delete_old_posts' => 'true', 'user_id' => $page_meta['fb_user_id'][0], 'fb_page_id' => $page_meta['fb_page_id'][0], 's_page_id' => $s_page_id, '_nonce' => wp_create_nonce('njt_fb_pr_nonce')), $this->getDashboardPageUrl());
                    $import_link = add_query_arg(array('import_new_posts' => 'true', 'user_id' => $page_meta['fb_user_id'][0], 'fb_page_id' => $page_meta['fb_page_id'][0], 's_page_id' => $s_page_id, '_nonce' => wp_create_nonce('njt_fb_pr_nonce')), $this->getDashboardPageUrl());

                    echo '<div class="warning notice notice-warning">';

                    echo sprintf(
                        __('<p>Found %1$d post(s) with this facebook page. Do you want to <a href="%2$s" class="njt_fb_pr_old_post_import">Import</a> or <a href="%3$s" class="njt_fb_pr_old_post_delete">Delete</a></p>', NJT_FB_PR_I18N),
                        $count_post,
                        $import_link,
                        $delete_link
                    );
                    echo '</div>';
                }
            }
        }
        if (!get_option('njt_auto_reply_already_send_info', '')) {
            ?>
            <div class="warning notice notice-warning">
                <?php
echo '<p><strong>If you don’t want to miss exclusive offers from us, join our newsletter.</strong></p><a class="button button-primary njt_fbpr_allow_sending_info" href="javascript:void(0)">Sure! I want to get latest news.</a></p>';
            ?>
            </div>
            <?php
}
    }

    public function removeMonthsDropdown($months, $post_type)
    {
        if ($post_type == 'njt_fb_pr_tmp_posts') {
            $months = array();
        }
        return $months;
    }
    /**
     * After rendering page
     *
     * @param  Object $page
     * @return Void
     */

    public function adminAfterPage($page)
    {
        $finding_posts = NjtFbPrPost::findOldPostsWithSamePageId($page->page_id, $page->sql_post_id, $page->user_id, true);
        if ($finding_posts > 0) {
            echo NjtFbPrView::load(
                'admin.page.found_old_posts',
                array(
                    'count_post' => $finding_posts,
                    'delete_link' => add_query_arg(array('delete_old_posts' => 'true', 'user_id' => $page->user_id, 'fb_page_id' => $page->page_id, 's_page_id' => $page->sql_post_id, '_nonce' => wp_create_nonce('njt_fb_pr_nonce')), $this->getDashboardPageUrl()),
                    'import_link' => add_query_arg(array('import_new_posts' => 'true', 'user_id' => $page->user_id, 'fb_page_id' => $page->page_id, 's_page_id' => $page->sql_post_id, '_nonce' => wp_create_nonce('njt_fb_pr_nonce')), $this->getDashboardPageUrl()),
                )
            );
        }
    }
    private function fNameLname($name, $type = 'first_name')
    {
        $e = explode(' ', $name);
        if ($type == 'first_name') {
            return ((isset($e[0])) ? $e[0] : $name);
        } elseif ($type == 'last_name') {
            if (isset($e[count($e) - 1])) {
                return $e[count($e) - 1];
            }
        }
        return $name;
    }
    private function getPostsWithOldDb()
    {
        global $wpdb;
        $sql = $wpdb->get_results("SELECT `meta_id`, `post_id` FROM " . $wpdb->prefix . "postmeta WHERE `meta_key` = '_njt_fb_pr_post_rules' OR `meta_key` = '_njt_fb_normal_post_rules'");
        if (count($sql) > 0) {
            $ids = array();
            foreach ($sql as $k => $v) {
                $ids[] = $v->post_id;
            }
            return array_unique($ids);
        } else {
            return false;
        }
    }
    private function getSpinPhotoFromArr($spin_photos)
    {
        $spin_photo = '';
        if (is_array($spin_photos)) {
            $spin_photo = $spin_photos[rand(0, count($spin_photos) - 1)];
        }
        return $spin_photo;
    }
}
