<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div id="njt_fb_pr_findpost_thickbox" style="display:none;">
    <div class="njt_fb_pr_findpost_thickbox_inner">
        <p>
            <label for="njt_fb_pr_findpost_tb_url"><?php _e('Facebook Post URL: ', NJT_FB_PR_I18N); ?></label>
            <input type="text" name="njt_fb_pr_findpost_tb_url" class="regular-text" value="" id="njt_fb_pr_findpost_tb_url" />
        </p>
        <p>
            <button type="button" data-s_page_id="<?php echo ((isset($_GET['s_page_id'])) ? $_GET['s_page_id'] : ''); ?>" class="button button-primary njt_fb_pre_find_now"><?php _e('Find Now', NJT_FB_PR_I18N); ?></button>
        </p>
    </div>
</div>
<div id="njt_fb_pr_newpost_thickbox" style="display:none;">
    <div class="njt_fb_pr_newpost_thickbox_inner">
        <div class="njt-fb-pr-new-post-mess"></div>
        <p>
            <label for="njt_fb_pr_newpost_tb_message"><?php _e('Message: ', NJT_FB_PR_I18N); ?></label>
        </p>
        <p>
            <textarea name="njt_fb_pr_newpost_tb_message" id="njt_fb_pr_newpost_tb_message"></textarea>
        </p>
        <p>
            <button type="button" data-s_page_id="<?php echo ((isset($_GET['s_page_id'])) ? $_GET['s_page_id'] : ''); ?>" class="button button-primary njt_fb_new_post_now"><?php _e('Post', NJT_FB_PR_I18N); ?></button>
        </p>
    </div>
</div>