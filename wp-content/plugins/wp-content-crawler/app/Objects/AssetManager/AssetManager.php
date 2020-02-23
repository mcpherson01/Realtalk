<?php
/**
 * Created by PhpStorm.
 * User: turgutsaricam
 * Date: 13/04/16
 * Time: 23:13
 */

namespace WPCCrawler\Objects\AssetManager;


use Illuminate\Contracts\Filesystem\FileNotFoundException;
use WPCCrawler\Environment;
use WPCCrawler\Objects\Docs;
use WPCCrawler\Objects\Enums\PageType;
use WPCCrawler\Objects\File\FileService;
use WPCCrawler\Objects\Guides\GuideTranslations;
use WPCCrawler\Objects\Informing\Informer;
use WPCCrawler\PostDetail\PostDetailsService;

class AssetManager extends BaseAssetManager {

    private $scriptApp                      = 'wcc_app_js';
    private $scriptUtils                    = 'wcc_utils_js';

    private $stylePostSettings              = 'wcc_post_settings_css';

    private $scriptTooltip                  = 'wcc_tooltipjs';

    private $scriptClipboard                = 'wcc_clipboardjs';

    private $styleGeneralSettings           = 'wcc_general_settings_css';

    private $styleSiteTester                = 'wcc_site_tester_css';

    private $styleTools                     = 'wcc_tools_css';

    private $styleDashboard                 = 'wcc_dashboard_css';

    private $styleDevTools                  = 'wcc_dev_tools_css';

    private $styleOptionsBox                = 'wcc_options_box_css';

    private $styleFeatherlight              = 'wcc_featherlight_css';
    private $scriptFeatherlight             = 'wcc_featherlight_js';
    private $scriptOptimalSelect            = 'wcc_optimal_select_js';
    private $scriptJSDetectElementResize    = 'wcc_js_detect_element_size_js';

    private $scriptNotifyJs                 = 'wcc_notifyjs_js';
    private $scriptFormSerializer           = 'wcc_form_serializer_js';

    private $styleBootstrapGrid             = 'wcc_bootstrap_grid_css';

    private $styleAnimate                   = 'wcc_animate_css';

    private $styleFeatureRequest            = 'wcc_feature_request_css';

    private $styleSelect2                   = 'wcc_select2_css';
    private $scriptSelect2                  = 'wcc_select2_js';

    private $styleGuides                    = 'wcc_guides_css';
    private $styleShepherd                  = 'wcc_shepherd_css';

    /**
     * @return string A string that will be the variable name of the JavaScript localization values. E.g. if this is
     *                'wpcc', localization values defined in {@link getLocalizationValues()} will be available under
     *                'wpcc' variable in the JS window.
     * @since 1.8.0
     */
    protected function getLocalizationName() {
        return 'wpcc';
    }

    /**
     * Get script localization values.
     *
     * @return array
     */
    protected function getLocalizationValues() {
        $values = [
            'an_error_occurred'                     =>  _wpcc("An error occurred."),
            'press_to_copy'                         =>  _wpcc("Press {0} to copy"),
            'copied'                                =>  _wpcc("Copied!"),
            'no_result'                             =>  _wpcc("No result."),
            'found'                                 =>  _wpcc("Found"),
            'required_for_test'                     =>  _wpcc("This is required to perform the test."),
            'required'                              =>  _wpcc("This is required."),
            'css_selector_found'                    =>  _wpcc("CSS selector found"),
            'delete_all_test_history'               =>  _wpcc("Do you want to delete all test history?"),
            'url_data_not_exist'                    =>  _wpcc("URL data cannot be found."),
            'currently_crawling'                    =>  _wpcc("Currently crawling"),
            'retrieving_urls_from'                  =>  _wpcc("Retrieving URLs from {0}"),
            'pause'                                 =>  _wpcc('Pause'),
            'continue'                              =>  _wpcc('Continue'),
            'test_data_not_retrieved'               =>  _wpcc('Test data could not be retrieved.'),
            'content_retrieval_response_not_valid'  =>  _wpcc("Response of content retrieval process is not valid."),
            'test_data_retrieval_failed'            =>  _wpcc("Test data retrieval failed."),
            'no_urls_found'                         =>  _wpcc("No URLs found."),
            'this_is_not_valid'                     =>  _wpcc("This is not valid."),
            'url_data_not_exist_for_this'           =>  _wpcc("URL data does not exist for this."),
            'this_url_not_crawled_yet'              =>  _wpcc("This URL has not been crawled yet."),
            'url_cannot_be_retrieved'               =>  _wpcc("The URL cannot be retrieved."),
            'cache_invalidated'                     =>  _wpcc("The cache has been invalidated."),
            'cache_could_not_be_invalidated'        =>  _wpcc("The cache could not be invalidated."),
            'all_cache_invalidated'                 =>  _wpcc("All caches have been invalidated."),
            'all_cache_could_not_be_invalidated'    =>  _wpcc("All caches could not be invalidated."),
            'custom_short_code'                     =>  _wpcc("Custom short code"),
            'post_id_not_found'                     =>  _wpcc("Post ID could not be found."),
            'settings_not_retrieved'                =>  _wpcc("Settings could not be retrieved."),
            'settings_saved'                        =>  _wpcc("The settings have been saved."),
            'state_not_parsed'                      =>  _wpcc("The state could not be parsed."),
            'top'                                   =>  _wpcc("Top"),
            'x_element_selected'                    =>  _wpcc("{0} element selected"),
            'x_elements_selected'                   =>  _wpcc("{0} elements selected"),
            'clear'                                 =>  _wpcc("Clear"),
            'or'                                    =>  _wpcc("or"),
            'select_category_url'                   =>  _wpcc("Select a category URL"),
            'see_docs_for_this_setting'             =>  _wpcc("See in docs"),

            'previous'                              => _wpcc("Previous"),
            'next'                                  => _wpcc("Next"),
            'complete'                              => _wpcc("Complete"),
            'cancel'                                => _wpcc("Cancel"),
            'skip'                                  => _wpcc("Skip"),
            'enable_x_tab'                          => _wpcc("Enable %s tab"),
            'fix_this_error'                        => _wpcc("Please fix this error"),
            'fix_these_errors'                      => _wpcc("Please fix these errors"),
            'start_guide'                           => _wpcc('Start the guide'),
            'start_from_this_step'                  => _wpcc('Start from this step'),
            'must_enable_tab_by_clicking'           => _wpcc('You must enable this tab by clicking to it'),
            'must_not_enable_tab'                   => _wpcc('You must not enable this tab'),
            'enter_valid_url'                       => _wpcc('Please enter a valid URL.'),
            'open_required_x_page_type_for_step'    => _wpcc('This step cannot be shown in this page. Please open %s page and start the step there.'),
            'no_prev_step'                          => _wpcc('There is no previous step.'),
            'prev_step_requires_x_page_type'        => _wpcc('Previous step cannot be shown in this page. Please open %s page and start the previous step there.'),
            'please_select_x'                       => _wpcc('Please select %s'),

            'no_name'    => _wpcc('(No name)'),
            'page_names' => [
                PageType::SITE_LISTING     => _wpcc('All Sites'),
                PageType::SITE_SETTINGS    => _wpcc('Site Settings'),
                PageType::ADD_NEW_SITE     => _wpcc('Add New Site'),
                PageType::DASHBOARD        => _wpcc('Dashboard'),
                PageType::SITE_TESTER      => _wpcc('Tester'),
                PageType::TOOLS            => _wpcc('Tools'),
                PageType::GENERAL_SETTINGS => _wpcc('General Settings'),
            ],

            'validation' => [
                'must_check_checkbox'           => _wpcc('You must check the checkbox.'),
                'must_uncheck_checkbox'         => _wpcc('You must uncheck the checkbox.'),
                'value_should_be_int'           => _wpcc('The value should be an integer.'),
                'value_not_valid'               => _wpcc('The value is not valid.'),
                'format_not_correct_x_regex'    => _wpcc("Value's format is not correct. (It must match the pattern <code class=\"regex\">%s</code>)"),
                'enter_valid_url_x_regex'       => _wpcc('Enter a valid URL. (It must match the pattern <code class="regex">%s</code>)'),
                'value_must_start_with'         => _wpcc('Value must start with <code>%s</code>.'),
                'remove_duplicate_urls'         => _wpcc('Please remove the duplicate URLs which are highlighted'),
                'value_not_valid_values_x'      => _wpcc('The value is not valid. Valid values: %s'),
                'value_len_between_min_x_max_y' => _wpcc('Length of the value must be between <code class="number">{0}</code> and <code class="number">{1}</code>.'),
                'value_len_gt_or_eq_x'          => _wpcc('Length of the value must be greater than or equal to <code class="number">%s</code>.'),
            ],

            // Variables that are not localization values and that should be available for use by JavaScript
            'vars' => [
                'docs_label_index_url' => Docs::getInstance()->getLocalLabelIndexFileUrl(),
                'docs_site_url'        => Docs::getInstance()->getDocumentationBaseUrl(),
            ]
        ];

        $values = array_merge($values, GuideTranslations::getInstance()->getTranslations());

        return $values;
    }

    /*
     *
     */

    /**
     * Add app.js
     * @since 1.10.0
     */
    public function addApp() {
        $this->addAnimate();
        $this->addjQueryAnimationAssets();
        $this->addScript($this->scriptApp, Environment::appDir() . '/public/dist/js/app.js', ['jquery', $this->scriptUtils], false, true);
    }

    /**
     * Add post-settings.css, app.js and utils.js, along with the site settings assets of the registered detail
     * factories.
     */
    public function addPostSettings() {
        $this->addSortable();

        $this->addStyle($this->stylePostSettings, Environment::appDir() . '/public/dist/css/post-settings.css', false);

        $this->addUtils();
        $this->addNotificationJs();
        $this->addSelect2();

        $this->addApp();
    }

    /**
     * Add tooltip.js
     */
    public function addTooltip() {
        // Utils is required because it defines emulateTransitionEnd function for jQuery. This function is required for
        // tooltip to work.
        $this->addScript($this->scriptTooltip, Environment::appDir() . '/public/scripts/tooltip.min.js', ['jquery', $this->scriptUtils], '3.3.6', true);
    }

    /**
     * Add clipboard.js
     */
    public function addClipboard() {
        $this->addScript($this->scriptClipboard, Environment::appDir() . '/public/scripts/clipboard.min.js', false, '1.5.9', true);
    }

    /**
     * Add app.js and utils.js
     */
    public function addPostList() {
        $this->addUtils();
        $this->addApp();
    }

    /**
     * Add general-settings.css
     */
    public function addGeneralSettings() {
        $this->addStyle($this->styleGeneralSettings, Environment::appDir() . '/public/dist/css/general-settings.css', false);
    }

    /**
     * Add site-tester.css, app.js and utils.js, along with the site tester assets of the registered detail factories.
     */
    public function addSiteTester() {
        $this->addStyle($this->styleSiteTester, Environment::appDir() . '/public/dist/css/site-tester.css', false);
        $this->addUtils();

        $this->addApp();

        // Add tester assets of the registered factories
        PostDetailsService::getInstance()->addSiteTesterAssets();
    }

    /**
     * Add tools.css, app.js and utils.js
     */
    public function addTools() {
        $this->addStyle($this->styleTools, Environment::appDir() . '/public/dist/css/tools.css', false);
        $this->addUtils();
        $this->addTooltip();
        $this->addFormSerializer();

        $this->addApp();
    }

    /**
     * Add dashboard.css and app.js
     */
    public function addDashboard() {
        $this->addStyle($this->styleDashboard, Environment::appDir() . '/public/dist/css/dashboard.css', false);
        $this->addApp();
    }

    /**
     * Add app.js and dev-tools.css
     */
    public function addDevTools() {
        $this->addStyle($this->styleDevTools, Environment::appDir() . '/public/dist/css/dev-tools.css', false);

        // Add the lightbox library after the dev-tools style so that we can override the styles of the library.
        // Also, the lib should be added before the dev-tools script so that we can refer to the lib's script.
        $this->addFeatherlight();

        $this->addScript($this->scriptOptimalSelect, Environment::appDir() . '/public/node_modules/optimal-select/dist/optimal-select.js', [], false, true);
        $this->addScript($this->scriptJSDetectElementResize, Environment::appDir() . '/public/node_modules/javascript-detect-element-resize/jquery.resize.js', ['jquery'], false, true);

        $this->addApp();

    }

    /**
     * Add app.js and options-box.css
     */
    public function addOptionsBox() {
        $this->addStyle($this->styleOptionsBox, Environment::appDir() . '/public/dist/css/options-box.css', false);

        $this->addFormSerializer();

        $this->addApp();
    }

    /**
     * Add featherlight.css and featherlight.js
     */
    public function addFeatherlight() {
        $this->addStyle($this->styleFeatherlight, Environment::appDir() . '/public/node_modules/featherlight/release/featherlight.min.css', false);
        $this->addScript($this->scriptFeatherlight, Environment::appDir() . '/public/node_modules/featherlight/release/featherlight.min.js', ['jquery'], false, true);
    }

    /**
     * Add utils.js
     */
    public function addUtils() {
        $this->addScript($this->scriptUtils, Environment::appDir() . '/public/scripts/utils.js', ['jquery'], false, true);
    }

    /**
     * Adds bootstrap-grid.css
     */
    public function addBootstrapGrid() {
        $this->addStyle($this->styleBootstrapGrid, Environment::appDir() . '/public/styles/bootstrap-grid.css', false);
    }

    /**
     * Adds WordPress' default jquery UI sortable library
     */
    public function addSortable() {
        $this->addScript('jquery-ui-sortable', null, [], false, true);
    }

    /**
     * Adds notification library
     */
    public function addNotificationJs() {
        $this->addScript($this->scriptNotifyJs, Environment::appDir() . '/public/node_modules/notifyjs-browser/dist/notify.js', [], false, true);
    }

    /**
     * Adds jquery.serialize-object.min.js
     */
    public function addFormSerializer() {
        $this->addScript($this->scriptFormSerializer, Environment::appDir() . '/public/node_modules/form-serializer/dist/jquery.serialize-object.min.js', ['jquery'], false, true);
    }

    /**
     * Adds animate.min.css
     * @since 1.8.0
     */
    public function addAnimate() {
        $this->addStyle($this->styleAnimate, Environment::appDir() . '/public/node_modules/animate.css/animate.min.css');
    }

    /**
     * Adds feature-request.css and app.js
     * @since 1.9.0
     */
    public function addFeatureRequest() {
        $this->addStyle($this->styleFeatureRequest, Environment::appDir() . '/public/dist/css/feature-request.css');
        $this->addApp();
    }

    /**
     * Adds select2.css and select2.min.js
     * @since 1.9.0
     */
    public function addSelect2() {
        $this->addStyle($this->styleSelect2, Environment::appDir() . '/public/node_modules/select2/dist/css/select2.min.css');
        $this->addScript($this->scriptSelect2, Environment::appDir() . '/public/node_modules/select2/dist/js/select2.min.js', ['jquery'], false, true);
    }

    /**
     * Adds shepherd.min.js and app.js
     * @since 1.9.0
     */
    public function addGuides() {
        $this->addStyle($this->styleGuides, Environment::appDir() . '/public/dist/css/guides.css');
        $this->addStyle($this->styleShepherd, Environment::appDir() . '/public/node_modules/shepherd.js/dist/css/shepherd.css');
        $this->addApp();
    }

    /*
     *
     */

    /**
     * Get contents of the iframe style file.
     *
     * @return string
     * @since 1.9.0
     */
    public function getDevToolsIframeStyle() {
        return $this->getFileContent('/public/dist/css/dev-tools-iframe.css');
    }

    /**
     * Get contents of info.css
     *
     * @return string
     */
    public function getInformationStyle() {
        return $this->getFileContent('/public/dist/css/info.css');
    }

    /*
     * PRIVATE HELPERS
     */

    /**
     * Get contents of a file in app directory of the plugin
     *
     * @param string $pathRelativeToAppDir A path relative to the app directory of the plugin
     * @return null|string Contents of the file if the file exists. Otherwise, null.
     * @since 1.9.0
     */
    private function getFileContent($pathRelativeToAppDir) {
        $path = WP_CONTENT_CRAWLER_PATH . Environment::appDirName() . '/' . ltrim($pathRelativeToAppDir, '/');
        $fs = FileService::getInstance()->getFileSystem();

        if (!$fs->exists($path) || !$fs->isFile($path)) {
            Informer::addError(sprintf(_wpcc('File "%1$s" could not be found.'), $path))->addAsLog();
            return null;
        }

        try {
            return $fs->get($path);

        } catch (FileNotFoundException $e) {
            Informer::addError($e->getMessage())->setException($e)->addAsLog();
            return null;
        }
    }

    private function addjQueryAnimationAssets() {
        // These are required for using animate feature of jQuery.
        $this->addScript('jquery-ui-core');
        $this->addScript('jquery-color');
    }
}