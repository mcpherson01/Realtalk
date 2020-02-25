<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="njt-fb-pr-row">
    <label>
        <input type="checkbox" name="_njt_fb_normal_pr_enable" value="1" <?php checked(get_post_meta($post->ID, '_njt_fb_normal_pr_enable', true), '1') ?> />
        <strong><?php _e('Enable Public Reply?', NJT_FB_PR_I18N); ?></strong>
    </label>
</div>

<div class="njt-fb-pr-row">
    <label class="njt-fb-pr-has-border">
        <input type="radio" name="_njt_fb_normal_reply_when" value="anytime" <?php checked($normal_reply_when, 'anytime'); ?> /><?php _e('Reply anytime', NJT_FB_PR_I18N); ?>
    </label>
    <label class="njt-fb-pr-has-border <?php echo (($normal_reply_when == 'if') ? 'right' : ''); ?>">
        <input type="radio" name="_njt_fb_normal_reply_when" value="if" <?php checked($normal_reply_when, 'if'); ?> /><?php _e('Reply if: ', NJT_FB_PR_I18N); ?>
    </label>

    <div class="njt-fb-pr-conditon-group njt-fb-normal-depends-on-replywhen" style="<?php echo (($normal_reply_when == 'if') ? 'display: block' : 'display: none'); ?>">
        <?php
        foreach ($normal_groups as $k => $group) {
            $data = array(
                'input_name' => 'njt_fb_normal_con',
                'parent_id' => $k,
                'group' => $group,
                'shortcuts' => $shortcuts,
                'has_photo' => true,
                'reply_type' => (!in_array($group['reply_type'], array('text', 'photo')) ? 'text' : $group['reply_type']),
            );
            echo NjtFbPrView::load('admin.conditional-parent-group', $data);
        }
        ?>        
        <a href="#" class="button njt-fb-pr-add-new-parent-group njt-fb-pr-add-new-parent-group-has-photo">
            <?php _e('Add new', NJT_FB_PR_I18N); ?>            
        </a>
        <?php
            $_njt_fb_normal_pr_if_not_reply_type = get_post_meta($post_id, '_njt_fb_normal_pr_if_not_reply_type', 'text');
            if (!in_array($_njt_fb_normal_pr_if_not_reply_type, array('text', 'photo'))) {
                $_njt_fb_normal_pr_if_not_reply_type = 'text';
            }
            $args = array(
                'id' => '_njt_fb_normal_pr_reply_content_if_not',
                'id_photo' => '_njt_fb_normal_pr_reply_content_if_not_photos[]',
                'checkbox_id' => '_njt_fb_normal_pr_if_not_reply_type',
                'reply_type' => $_njt_fb_normal_pr_if_not_reply_type,
                'value' => get_post_meta($post_id, '_njt_fb_normal_pr_reply_content_if_not', true),
                'value_photos' => get_post_meta($post_id, '_njt_fb_normal_pr_reply_content_if_not_photos', true),
                'label' => __('If Not, Reply: ', NJT_FB_PR_I18N),
                'shortcuts' => $shortcuts,
            );
            $args['value_photos'] = maybe_unserialize($args['value_photos']);
            njt_fb_pr_textarea_template_with_photo($args);
        ?>
    </div><!--/.njt-fb-normal-depends-on-replywhen-->
    <div class="njt-fb-normal-depends-on-replyanytime" style="<?php echo (($normal_reply_when == 'if') ? 'display: none' : 'display: block'); ?>">
        <?php
            $_njt_fb_normal_pr_reply_type = get_post_meta($post_id, '_njt_fb_normal_pr_reply_type', 'text');
            if (!in_array($_njt_fb_normal_pr_reply_type, array('text', 'photo'))) {
                $_njt_fb_normal_pr_reply_type = 'text';
            }
            $args = array(
                'id' => '_njt_fb_normal_pr_reply_content',
                'id_photo' => '_njt_fb_normal_pr_reply_content_photos[]',
                'checkbox_id' => '_njt_fb_normal_pr_reply_type',
                'reply_type' => $_njt_fb_normal_pr_reply_type,
                'value' => get_post_meta($post_id, '_njt_fb_normal_pr_reply_content', true),
                'value_photos' => get_post_meta($post_id, '_njt_fb_normal_pr_reply_content_photos', true),
                'label' => __('Reply', NJT_FB_PR_I18N),
                'shortcuts' => $shortcuts,
            );
            $args['value_photos'] = maybe_unserialize($args['value_photos']);
            njt_fb_pr_textarea_template_with_photo($args);
        ?>
    </div><!-- /.njt-fb-normal-depends-on-replyanytime -->
</div>