<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="njt-fb-pr-note-wrap">
    <h1><?php _e('Please make sure:', NJT_FB_PR_I18N); ?></h1>
    <div class="njt-fb-pr-note">
        <ul>
            <li><?php _e('1. Your website need to use https. You can get <a target="_blank" href="https://letsencrypt.org/">Free SSL here</a> ', NJT_FB_PR_I18N); ?></li>
            <br />
            <li>
                <?php _e('2. IMPORTANT: After inserting your App ID and App Secret, go to your <strong>App Setting</strong>, insert the URL bellow to <strong>Valid OAuth redirect URIs</strong>.', NJT_FB_PR_I18N); ?>
                <?php echo sprintf(__('<a href="%s" target="_blank">See image</a>', NJT_FB_PR_I18N), NJT_FB_PR_URL . '/assets/img/oauth.jpg') ?>
                <br />
                <input type="text" name="" value="<?php echo $login_callback_url; ?>" class="regular-text" onclick="this.select()" />
            </li>
            <li class="njt-fb-pr-opa">
                <br />
                <?php _e('3. The app\'s Webhooks setting is inserted AUTOMATICALLY. If not, go to your <strong>App setting</strong> => <strong>Add a Product</strong> => <strong>Webhooks</strong> => <strong>Set up</strong>. Choose <strong>Page</strong> => click <strong>Subscribe to this topic</strong>.' , NJT_FB_PR_I18N); ?>
                <?php echo sprintf(__('<a href="%s" target="_blank">See image</a>', NJT_FB_PR_I18N), NJT_FB_PR_URL . '/assets/img/webhooks.png') ?>
                <br />
                <strong><?php _e('Callback URL:', NJT_FB_PR_I18N); ?></strong><br />
                <input type="text" name="" value="<?php echo $webhook_callback_url; ?>" class="regular-text" onclick="this.select()" /><br />
                <strong><?php _e('Verify Token:', NJT_FB_PR_I18N); ?></strong><br />
                <input type="text" name="" value="<?php echo get_option('njt_fb_pr_fb_verify_token'); ?>" class="regular-text" onclick="this.select()" /><br />
                <p><strong><?php _e('=> Verify and save', NJT_FB_PR_I18N) ?></strong></p>
                <p><?php _e(' => Subscribe :', NJT_FB_PR_I18N); ?> <strong>feed</strong></p>
                <p>Go to : https://developers.facebook.com/apps/<?php echo ((!empty(get_option('njt_fb_pr_fb_app_id', ''))) ? get_option('njt_fb_pr_fb_app_id', '') : 'your-app-id'); ?>/messenger/settings/</p>
                <p>=> click <strong>Edit Events</strong></p>
                <strong><?php _e('Subscription Fields:', NJT_FB_PR_I18N); ?></strong><br />
                <span>message_deliveries, messages, messaging_optins, messaging_postbacks</span><br />
                => click <strong>Save</strong>
            </li>
        </ul>
    </div>

</div>