<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<a href="<?php echo esc_url('https://facebook.com/' . $fb_post_id); ?>" target="_blank" class="button"><?php _e('View Post', NJT_FB_PR_I18N); ?></a>
<div class="njt_fb_pr_post_content njt-fb-pr-row">
    <?php echo $post->post_content; ?>
</div>
<div class="njt-fb-pr-row">
    <label>
        <input type="checkbox" name="_njt_fb_pr_enable" value="1" <?php checked(get_post_meta($post->ID, '_njt_fb_pr_enable', true), '1') ?> />
        <strong><?php _e('Enable Private Reply ?', NJT_FB_PR_I18N); ?></strong>
    </label>
</div>
<div class="njt-fb-pr-row">
    <label>
        <input type="radio" name="_njt_fb_pr_reply_when" value="anytime" <?php checked($reply_when, 'anytime'); ?> /><?php _e('Reply anytime', NJT_FB_PR_I18N); ?>
    </label>
    <label>
        <input type="radio" name="_njt_fb_pr_reply_when" value="if" <?php checked($reply_when, 'if'); ?> /><?php _e('Reply if: ', NJT_FB_PR_I18N); ?>
    </label>

    <div class="njt-fb-pr-list-groups njt-fb-pr-depends-on-replywhen" data-input_name="njt_fb_pr_con" style="<?php echo (($reply_when == 'if') ? 'display: block' : 'display: none'); ?>">
    <?php
    foreach ($groups as $k => $group) {
        $data = array('group' => $group, 'id' => $k, 'input_name' => 'njt_fb_pr_con');
        echo NjtFbPrView::load('admin.conditional-group', $data);
    }
    ?>
    </div>
    <a href="#" class="button njt-fb-pr-add-new-group njt-fb-pr-depends-on-replywhen" style="<?php echo (($reply_when == 'if') ? 'display: inline-block' : 'display: none'); ?>">
        <?php _e('Add new', NJT_FB_PR_I18N); ?>            
    </a>
</div>
<div class="njt-fb-pr-row">
    <label for="_njt_fb_pr_reply_content">
        <strong><?php _e('Reply: ', NJT_FB_PR_I18N); ?></strong>
    </label>
    <br />
    <textarea name="_njt_fb_pr_reply_content" id="_njt_fb_pr_reply_content"><?php echo get_post_meta($post->ID, '_njt_fb_pr_reply_content', true); ?></textarea>
    <span class="njt_fb_pr_shortcut_wrap">
    <?php
    if (count($shortcuts) > 0) {
        $shortcut_html = array();
        foreach ($shortcuts as $k => $v) {
            $shortcut_html[] = sprintf('<a href="javascript:njt_fb_pr_shortcut_click(\'%1$s\', \'#_njt_fb_pr_reply_content\')">%2$s</a>', $k, $v);
        }
        echo implode(', ', $shortcut_html);
    }
    ?>
    </span>

    <!-- If not -->
    <br />
    <label for="_njt_fb_pr_reply_content_if_not">
        <strong><?php _e('If not, reply: ', NJT_FB_PR_I18N); ?></strong>
    </label>
    <br />
    <textarea name="_njt_fb_pr_reply_content_if_not" id="_njt_fb_pr_reply_content_if_not"><?php echo get_post_meta($post->ID, '_njt_fb_pr_reply_content_if_not', true); ?></textarea>
    <span class="njt_fb_pr_shortcut_wrap">
    <?php
    if (count($shortcuts) > 0) {
        $shortcut_html = array();
        foreach ($shortcuts as $k => $v) {
            $shortcut_html[] = sprintf('<a href="javascript:njt_fb_pr_shortcut_click(\'%1$s\', \'#_njt_fb_pr_reply_content_if_not\')">%2$s</a>', $k, $v);
        }
        echo implode(', ', $shortcut_html);
    }
    ?>
    </span>

</div>

<!-- Normal Reply-->
<div class="njt-fb-pr-row">
    <label>
        <input type="checkbox" name="_njt_fb_normal_pr_enable" value="1" <?php checked(get_post_meta($post->ID, '_njt_fb_normal_pr_enable', true), '1') ?> />
        <strong><?php _e('Enable Public Reply?', NJT_FB_PR_I18N); ?></strong>
    </label>
</div>

<div class="njt-fb-pr-row">
    <label>
        <input type="radio" name="_njt_fb_normal_reply_when" value="anytime" <?php checked($normal_reply_when, 'anytime'); ?> /><?php _e('Reply anytime', NJT_FB_PR_I18N); ?>
    </label>
    <label>
        <input type="radio" name="_njt_fb_normal_reply_when" value="if" <?php checked($normal_reply_when, 'if'); ?> /><?php _e('Reply if: ', NJT_FB_PR_I18N); ?>
    </label>

    <div class="njt-fb-pr-list-groups njt-fb-normal-depends-on-replywhen" data-input_name="njt_fb_normal_con" style="<?php echo (($normal_reply_when == 'if') ? 'display: block' : 'display: none'); ?>">
    <?php
    foreach ($normal_groups as $k => $group) {
        $data = array('group' => $group, 'id' => $k, 'input_name' => 'njt_fb_normal_con');
        echo NjtFbPrView::load('admin.conditional-group', $data);
    }
    ?>
    </div>
    <a href="#" class="button njt-fb-pr-add-new-group njt-fb-normal-depends-on-replywhen" style="<?php echo (($normal_reply_when == 'if') ? 'display: inline-block' : 'display: none'); ?>">
        <?php _e('Add new', NJT_FB_PR_I18N); ?>            
    </a>
</div>

<div class="njt-fb-pr-row">
    <label for="_njt_fb_normal_pr_reply_content">
        <strong><?php _e('Reply content: ', NJT_FB_PR_I18N); ?></strong>
    </label>
    <br />
    <textarea name="_njt_fb_normal_pr_reply_content" id="_njt_fb_normal_pr_reply_content"><?php echo get_post_meta($post->ID, '_njt_fb_normal_pr_reply_content', true); ?></textarea>
    <br />
    <!-- If not, reply -->
    <label for="_njt_fb_normal_pr_reply_content_if_not">
        <strong><?php _e('If not, reply: ', NJT_FB_PR_I18N); ?></strong>
    </label>
    <br />
    <textarea name="_njt_fb_normal_pr_reply_content_if_not" id="_njt_fb_normal_pr_reply_content_if_not"><?php echo get_post_meta($post->ID, '_njt_fb_normal_pr_reply_content_if_not', true); ?></textarea>
    <br />
    <i>
        <?php
        echo sprintf(
            __('If you just update plugin and this feature doesn\'t work, please go <a target="_blank" href="%1$s">there</a> to reload pages, then try again.', NJT_FB_PR_I18N),
            esc_url($reload_pages)
        );
        ?>    
    </i>
</div>

<?php do_action('njt_fb_pr_reply_after_post_setting', $data); ?>