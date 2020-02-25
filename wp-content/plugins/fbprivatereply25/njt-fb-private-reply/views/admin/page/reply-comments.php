<div class="wrap">
    <h1><?php echo sprintf(__('Reply To %1$s\'s Comments', NJT_FB_PR_I18N), $page_name); ?></h1>
    <form action="<?php echo esc_url(admin_url('admin.php')); ?>" class="njt-fbpr-reply-comments-frm">
        <input type="hidden" name="page" value="<?php echo esc_attr($page); ?>">
        <input type="hidden" name="s_page_id" value="<?php echo $s_page_id; ?>" />
        <input type="hidden" name="page_token" value="<?php echo $page_token; ?>" />
        <div class="tablenav top">
            <div class="alignleft actions">
                <?php //echo njt_fb_pr_months_dropdown($post_type); ?>
                <span><?php _e('From', NJT_FB_PR_I18N); ?></span>
                <input type="text" name="from" value="" class="njt-fbpr-input-date" />
                <span><?php _e('To', NJT_FB_PR_I18N); ?></span>
                <input type="text" name="to" value="" class="njt-fbpr-input-date" />
                <input placeholder="<?php _e('Search', NJT_FB_PR_I18N); ?>" type="search" id="post-search-input" name="s" value="<?php echo ((isset($_GET['s'])) ? $_GET['s'] : ''); ?>" />
                <button type="submit" name="filter_action" id="njt-fbpr-reply-comment-get-posts" class="button"><?php _e('Get Posts', NJT_FB_PR_I18N); ?></button>
            </div>
            <div style="clear: both"></div>
            <div class="njt-fb-pr-row">
                <div class="njt-fb-pr-col-6">
                    <div class="njt-fbpr-reply-comment-results-step1"></div>
                </div>
                <div class="njt-fb-pr-col-6">
                    <div class="njt-fbpr-reply-comment-results-step2"></div>
                </div>
            </div>
            
        </div>
    </form>
</div>