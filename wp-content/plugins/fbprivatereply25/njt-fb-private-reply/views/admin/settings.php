<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php echo __('Settings', NJT_FB_PR_I18N); ?></h1>
    <form action="options.php" method="post">
        <?php settings_fields('njt_fb_pr'); ?>
        <?php do_settings_sections('njt_fb_pr'); ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="njt_fb_pr_fb_app_id"><?php _e('Facebook App ID:', NJT_FB_PR_I18N); ?></label>
                </th>
                <td>
                    <input type="text" name="njt_fb_pr_fb_app_id" id="njt_fb_pr_fb_app_id" class="regular-text" value="<?php echo get_option('njt_fb_pr_fb_app_id'); ?>" />
                </td>                
            </tr>
            <tr>
                <th scope="row">
                    <label for="njt_fb_pr_fb_app_secret"><?php _e('Facebook App Secret:', NJT_FB_PR_I18N); ?></label>
                </th>
                <td>
                    <input type="text" name="njt_fb_pr_fb_app_secret" id="njt_fb_pr_fb_app_secret" class="regular-text" value="<?php echo get_option('njt_fb_pr_fb_app_secret'); ?>" />
                </td>
            </tr>
            <!-- <tr>
                <th scope="row">
                    <label for="njt_fb_pr_is_testmode"><?php _e('Test Mode:', NJT_FB_PR_I18N); ?></label>
                </th>
                <td>
                    <input type="checkbox" name="njt_fb_pr_is_testmode" id="njt_fb_pr_is_testmode"  value="1" <?php checked(get_option('njt_fb_pr_is_testmode'), '1'); ?> />
                </td>
            </tr> -->
            <tr>
                <th scope="row">
                    <label for="njt_fb_pr_is_using_utf8encode"><?php _e('Encode UTF8 characters ?:', NJT_FB_PR_I18N); ?></label>
                </th>
                <td>
                    <input type="checkbox" name="njt_fb_pr_is_using_utf8encode" id="njt_fb_pr_is_using_utf8encode"  value="1" <?php checked(get_option('njt_fb_pr_is_using_utf8encode'), '1'); ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="njt_fb_pr_case_sensitive"><?php _e('Case Sensitive ?:', NJT_FB_PR_I18N); ?></label>
                </th>
                <td>
                    <input type="checkbox" name="njt_fb_pr_case_sensitive" id="njt_fb_pr_case_sensitive"  value="1" <?php checked(get_option('njt_fb_pr_case_sensitive'), '1'); ?> />
                </td>
            </tr>
        </table>
        <?php
            $data = array(
                'login_callback_url' => $login_callback_url,
                'webhook_callback_url' => $webhook_callback_url
            );
            echo NjtFbPrView::load('admin.setting_note', $data);
        ?>
        <input type="hidden" name="njt_fb_pr_fb_verify_token" value="<?php echo get_option('njt_fb_pr_fb_verify_token'); ?>">        
        <?php submit_button(); ?>
    </form>
</div>