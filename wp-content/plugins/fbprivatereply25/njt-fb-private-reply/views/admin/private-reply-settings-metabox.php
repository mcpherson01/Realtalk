<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="njt-fb-pr-row">
    <label>
        <input type="checkbox" name="_njt_fb_pr_enable" value="1" <?php checked(get_post_meta($post->ID, '_njt_fb_pr_enable', true), '1') ?> />
        <strong><?php _e('Enable Private Reply ?', NJT_FB_PR_I18N); ?></strong>
    </label>
</div>
<div class="njt-fb-pr-row">
    <label class="njt-fb-pr-has-border left">
        <input type="radio" name="_njt_fb_pr_reply_when" value="anytime" <?php checked($reply_when, 'anytime'); ?> /><?php _e('Reply anytime', NJT_FB_PR_I18N); ?>
    </label>
    <label class="njt-fb-pr-has-border <?php echo (($reply_when == 'if') ? 'right' : ''); ?>">
        <input type="radio" name="_njt_fb_pr_reply_when" value="if" <?php checked($reply_when, 'if'); ?> /><?php _e('Reply if: ', NJT_FB_PR_I18N); ?>
    </label>
    <div class="njt-fb-pr-conditon-group njt-fb-pr-depends-on-replywhen" style="<?php echo (($reply_when == 'if') ? 'display: block' : 'display: none'); ?>">
        <?php
        foreach ($groups as $k => $group) {
            $data = array(
                'input_name' => 'njt_fb_pr_con',
                'parent_id' => $k,
                'group' => $group,
                'shortcuts' => $shortcuts,
            );
            echo NjtFbPrView::load('admin.conditional-parent-group', $data);
        }
        ?>        
        <a href="#" class="button njt-fb-pr-add-new-parent-group">
            <?php _e('Add new', NJT_FB_PR_I18N); ?>            
        </a>
        <?php
            njt_fb_pr_textarea_template(
                '_njt_fb_pr_reply_content_if_not',
                get_post_meta($post_id, '_njt_fb_pr_reply_content_if_not', true),
                __('If Not, Reply: ', NJT_FB_PR_I18N),
                $shortcuts
            );
        ?>        
    </div><!--/.njt-fb-pr-depends-on-replywhen-->
    <div class="njt-fb-pr-conditon-group njt-fb-pr-depends-on-replyanytime" style="<?php echo (($reply_when == 'anytime') ? 'display: block' : 'display: none'); ?>">
        <?php
            njt_fb_pr_textarea_template(
                '_njt_fb_pr_reply_content',
                get_post_meta($post_id, '_njt_fb_pr_reply_content', true),
                __('Reply', NJT_FB_PR_I18N),
                $shortcuts
            );
        ?>        
    </div><!--/.njt-fb-pr-depends-on-replyanytime-->
</div>