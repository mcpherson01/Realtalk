<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<span class="njt_fb_pr_old_post_wrap">
    <span class="njt_fb_pr_old_post_inner">
        <?php
            echo sprintf(
                __('Found %1$d post(s) with this facebook page. Do you want to <a href="%2$s" class="njt_fb_pr_old_post_import">Import</a> or <a href="%3$s" class="njt_fb_pr_old_post_delete">Delete</a>', NJT_FB_PR_I18N),
                $count_post,
                $import_link,
                $delete_link
            );
        ?>
    </span>
</span>