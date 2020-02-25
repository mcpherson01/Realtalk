<?php echo sprintf(__('<h3>Found %1$s posts</h3>', NJT_FB_PR_I18N), count($posts)); ?>
<span class="njt-small-note"><?php _e('1: Choose posts you want to reply: ', NJT_FB_PR_I18N); ?></span>
<label>
    <input type="checkbox" name="checkall" id="checkall" value="" checked="checked" />
    <?php _e('Check All', NJT_FB_PR_I18N); ?>
</label>
<hr />
<ul class="njt-fb-pr-reply-comment-posts" data-result_template="<?php _e('Total Comments: %1 | Sent: %2 | Fail: %3', NJT_FB_PR_I18N); ?>">
    <?php
    foreach ($posts as $k => $v) {
        $fb_post_id = get_post_meta($v->ID, 'fb_post_id', true);
        ?>
        <li class="post-<?php echo $fb_post_id; ?>">
            <label>
                <input checked="checked" type="checkbox" name="posts[]" value="<?php echo $v->ID; ?>" data-fb_post_id="<?php echo $fb_post_id; ?>" />
                <?php echo wp_trim_words($v->post_title); ?>
            </label>
        </li>
        <?php
    }
    ?>
</ul>
<script type="text/html" id="njt-fb-pr-reply-comment-result-template">
    <ul>
        <li class="full"><?php _e('Total Comments: ', NJT_FB_PR_I18N); ?><strong>%1</strong></li>
        <li class="count count-public-sent"><?php _e('Public Reply Sent: ', NJT_FB_PR_I18N); ?><strong>%2</strong></li>
        <li class="count count-public-fail"><?php _e('Public Reply Fail: ', NJT_FB_PR_I18N); ?><strong>%3</strong></li>
        <li class="count count-private-sent"><?php _e('Private Reply Sent: ', NJT_FB_PR_I18N); ?><strong>%4</strong></li>
        <li class="count count-private-fail"><?php _e('Private Reply Fail: ', NJT_FB_PR_I18N); ?><strong>%5</strong></li>
    </ul>
</script>