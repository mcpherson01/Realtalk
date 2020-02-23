<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class WpsolAddonSpeedOptimizationViews
 */
class WpsolAddonSpeedOptimizationViews
{
    /**
     * WpsolAddonSpeedOptimizationViews constructor.
     */
    public function __construct()
    {
    }

    /**
     * Add popup for exclude files minification
     *
     * @return void
     */
    public static function addAdvancedFilePopup()
    {
        echo '
            <div id="wpsol_check_exclude_file_modal" class="check-minify-dialog" style="display: none">
                 <div class="check-minify-icon"><i class="material-icons">info_outline</i></div>
                 <div class="check-minify-content">
                 <span>' . esc_html__('Using individual file exclusion require 
                 to run a website scan first', 'wp-speed-of-light-addon') . '</span></div>
                 <div class="check-minify-sucess">
                 <button type="button" data-type="" id="run-scan-file-popup" class="ju-button orange-button waves-effect waves-light agree">
                 <span>' . esc_html__('Run Scan', 'wp-speed-of-light-addon') . '</span>
                 </button>
                 <br>
                 <input type="button" data-type="" id="stop-scan-file-popup" class="scan-file-popup-btn cancel" 
                 value="' . esc_html__('Cancel', 'wp-speed-of-light-addon') . '">
                </div>
            </div>
        ';
    }
}
