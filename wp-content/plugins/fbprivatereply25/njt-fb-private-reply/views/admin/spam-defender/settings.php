<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php _e('Spam Defender', NJT_FB_PR_I18N); ?></h1>
    <form action="options.php" method="post">
        <?php settings_fields('njt_fb_pr_spam_defender'); ?>
        <?php do_settings_sections('njt_fb_pr_spam_defender'); ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="njt_fb_pr_spam_defender_enable"><?php _e('Enable Spam Defender ?', NJT_FB_PR_I18N); ?></label>
                </th>
                <td>
                    <input type="checkbox" value="1" name="njt_fb_pr_spam_defender_enable" id="njt_fb_pr_spam_defender_enable" <?php checked(get_option('njt_fb_pr_spam_defender_enable'), '1'); ?> />
                </td>                
            </tr>
            <tr>
                <th scope="row">
                    <label for="njt_fb_pr_spam_defender_bad_words"><?php _e('Bad Words:', NJT_FB_PR_I18N); ?></label>
                </th>
                <td>
                    <textarea name="njt_fb_pr_spam_defender_bad_words" id="njt_fb_pr_spam_defender_bad_words" cols="30" rows="10" style="width: 100%"><?php echo get_option('njt_fb_pr_spam_defender_bad_words', ''); ?></textarea>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>