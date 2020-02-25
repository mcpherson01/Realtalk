<div class="njt-fb-pr-reply-comment-send-form">
    <p>
        <span class="njt-small-note"><?php _e('2.1: Your PUBLIC reply content (let empty to skip): ', NJT_FB_PR_I18N); ?></span>
        <label for="njt-fb-pr-reply-comment-public-content"><?php _e('Public Reply: ', NJT_FB_PR_I18N); ?></label>
        <textarea name="njt-fb-pr-reply-comment-public-content" id="njt-fb-pr-reply-comment-public-content" cols="30" rows="10"></textarea>
    </p>
    <p>
        <span class="njt-small-note"><?php _e('2.2: Your PRIVATE reply content (let empty to skip): ', NJT_FB_PR_I18N); ?></span>
        <label for="njt-fb-pr-reply-comment-private-content"><?php _e('Private Reply: ', NJT_FB_PR_I18N); ?></label>
        <textarea name="njt-fb-pr-reply-comment-private-content" id="njt-fb-pr-reply-comment-private-content" cols="30" rows="10"></textarea>
    </p>
</div>
<div class="njt-fb-pr-reply-comment-btns">
    <span class="njt-small-note"><?php _e('3: Send', NJT_FB_PR_I18N); ?></span>
    <button type="button" class="njt-fb-pr-reply-comment-btn-send-now button button-primary" data-btn_title="<?php echo esc_attr(__('Send To %s Posts Now', NJT_FB_PR_I18N)); ?>">
        <?php printf(__('Send To %1$s Posts Now', NJT_FB_PR_I18N), count($posts)); ?>    
    </button>
</div>