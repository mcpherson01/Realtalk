<?php
$optimization = get_option('wpsol_optimization_settings');
$text = array(
    'wpsol_scan_folder_title' => __('Select folder to scan', 'wp-speed-of-light-addon'),
    'wpsol_scan_folder_scan_button' => __('Scan now', 'wp-speed-of-light-addon'),
    'wpsol_scan_folder_cancel_button' => __('Cancel', 'wp-speed-of-light-addon'),
    'wpsol_scan_folder_scanning' => __('Scanning...', 'wp-speed-of-light-addon'),
    'wpsol_scan_folder_complete' => __('Complete !', 'wp-speed-of-light-addon'),
    'wpsol_scan_folder_results' => __('View results', 'wp-speed-of-light-addon'),
);
wp_localize_script('wpsol-addon-admin-js', 'optimization_params', $text);

$style = 'display: none';
if (!empty($optimization) && !empty($optimization['advanced_features']['excludefiles_minification'])) {
    $style = '';
}

$folder_selected = get_option('wpsol_folder_scan_selected');
$folders = array('selected' => array('wp-content'));
if (!empty($folder_selected)) {
    $folders['selected'] = $folder_selected;
}
wp_localize_script('wpsol-addon-folder-tree', 'wpsol_addon_folders', $folders);
?>
<li class="ju-settings-option full-width wpsol-exclude-field" style="<?php echo esc_attr($style); ?>">
        <div id="wpsol-exclude-files">
            <label><?php esc_html_e("Don't know how to use it? Check the ", 'wp-speed-of-light-addon') ?><a
                        href="https://www.joomunited.com/documentation/wp-speed-of-light-documentation#toc-4-3-group-and-minify-2"
                        target="_blank"><?php esc_html_e('DOCUMENTATION FIRST >>', 'wp-speed-of-light-addon') ?></a> </label>
            <br><br>
            <input type="hidden" value="all" name="exclude-file-type"/>
            <ul class="wpsol-exclude-files-tabs wpsol-exclude-files-menu">
                <li class="tab-link active" data-tab="all"><?php esc_html_e('All', 'wp-speed-of-light-addon') ?></li>
                <li class="tab-link" data-tab="2"><?php esc_html_e('JavaScript', 'wp-speed-of-light-addon') ?></li>
                <li class="tab-link" data-tab="1"><?php esc_html_e('CSS', 'wp-speed-of-light-addon') ?></li>
                <li class="tab-link" data-tab="0"><?php esc_html_e('Font', 'wp-speed-of-light-addon') ?></li>
            </ul>
            <div class="wpsol-exclude-files-menu">
                <input type="text" class="wpsol-exclude-files-search-input ju-input" id="wpsol-exclude-files-search-input" size="30"/>
                <span class="dashicons dashicons-search wpsol-exclude-files-search-button"></span>
                <a href="#group_and_minify" class="ju-button orange-button waves-effect waves-light wpsol-exclude-files-btn"
                   id="wpsol-exclude-files-toggle-state"><span
                            class="dashicons dashicons-yes exc-icon"></span>
                    <?php esc_html_e('Toggle State', 'wp-speed-of-light-addon') ?>
                </a>
                <a href="#group_and_minify" class="ju-button orange-button waves-effect waves-light wpsol-exclude-files-btn" id="wpsol-exclude-files-scan"><span
                            class="dashicons dashicons-update exc-icon"></span><?php esc_html_e('Scan', 'wp-speed-of-light-addon') ?>
                </a>
            </div>

            <div class="clear"></div>

            <div id="excludes-tab" class="tab-content-exclude active">
                <table width="100%" cellspacing="0" style=" word-wrap: break-word; word-break: break-all;">
                    <thead>
                    <tr>
                        <td width="1%">
                            <input type="checkbox" id="minify-check-all" name="minify[]" value="all_file"/>
                            <label for="minify-check-all"></label>
                        </td>
                        <td width="15%">
                            <span><?php esc_html_e('Type', 'wp-speed-of-light-addon') ?></span>
                        </td>
                        <td width="70%">
                            <span><?php esc_html_e('File', 'wp-speed-of-light-addon') ?></span>
                        </td>
                        <td width="5%">
                            <span><?php esc_html_e('Exclude', 'wp-speed-of-light-addon') ?></span>
                        </td>
                    </tr>
                    </thead>
                    <tbody class="exclude-body">

                    </tbody>
                    <tfoot class="exclude-pagination">

                    </tfoot>
                    <tr class="no-result" style="display: none;">
                        <td colspan="4"><?php esc_html_e('No Matching Results', 'wp-speed-of-light-addon') ?></td>
                    </tr>
                </table>
            </div>
        </div><!-- container -->
    </li>

