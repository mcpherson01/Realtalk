<?php
if (!defined('ABSPATH')) {
    exit;
}
$has_photo = (isset($has_photo) && ($has_photo === true));
?>
<div class="njt-fb-pr-parent-group <?php echo (($has_photo === true) ? 'njt-fb-pr-parent-group-has-photo' : ''); ?>">
    <span class="njt-fb-pr-close-btn-parent-group">x</span>
    <div class="njt-fb-pr-list-groups" data-input_name="<?php echo $input_name; ?>[<?php echo $parent_id; ?>]">
    <?php
    foreach ($group['groups'] as $k2 => $v) {
        $data = array('group' => $v, 'id' => $k2, 'input_name' => $input_name . '['.$parent_id.']');
        echo NjtFbPrView::load('admin.conditional-group', $data);
    }
    ?>
    </div>
    <a href="#" class="button njt-fb-pr-add-new-group">
        <?php _e('Add new', NJT_FB_PR_I18N); ?>            
    </a>
    <?php
        $value = ((isset($group['reply'])) ? $group['reply'] : '');
        $value_photos = ((isset($group['reply_photos'])) ? maybe_unserialize($group['reply_photos']) : array());
        if ($has_photo === true) {
            $args = array(
                'id' => $input_name . '['.$parent_id.'][reply]',
                'id_photo' => $input_name . '['.$parent_id.'][reply_photos][]',
                'checkbox_id' => $input_name . '['.$parent_id.'][reply_type]',
                'reply_type' => $reply_type,
                'value' => $value,
                'value_photos' => $value_photos,
                'label' => __('Reply: ', NJT_FB_PR_I18N),
                'shortcuts' => $shortcuts,
            );
            njt_fb_pr_textarea_template_with_photo($args);
        } else {
            njt_fb_pr_textarea_template(
                $input_name . '['.$parent_id.'][reply]',
                $value,
                __('Reply: ', NJT_FB_PR_I18N),
                $shortcuts
            );
        }
    ?>
</div><!--/.njt-fb-pr-parent-group-->