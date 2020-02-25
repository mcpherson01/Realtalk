<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr data-id="<?php echo $id; ?>" class="njt_fb_pr_row_rule">
    <td><?php _e('Comment ', NJT_FB_PR_I18N); ?></td>
    <td>
        <select name="<?php echo $input_name; ?>[<?php echo $group_id; ?>][<?php echo $id; ?>][operator]" id="" style="width: 100px">
            <option value="=" <?php selected($rule['operator'], '='); ?>><?php _e('is equal to', NJT_FB_PR_I18N); ?></option>
            <option value="contain" <?php selected($rule['operator'], 'contain'); ?>><?php _e('contains', NJT_FB_PR_I18N); ?></option>
            <option value="^" <?php selected($rule['operator'], '^'); ?>><?php _e('begins with', NJT_FB_PR_I18N); ?></option>
            <option value="$" <?php selected($rule['operator'], '$'); ?>><?php _e('ends with', NJT_FB_PR_I18N); ?></option>
        </select>
    </td>
    <td>
        <input type="text" name="<?php echo $input_name; ?>[<?php echo $group_id; ?>][<?php echo $id; ?>][value]" value="<?php echo esc_attr($rule['value']); ?>" class="" style="width: 100px;" />
    </td>
    <td>
        <a href="#" class="button njt_fb_pr_add_and_rule"><?php _e('and ', NJT_FB_PR_I18N); ?></a>
    </td>
    <td>
        <a href="#" class="button njt_fb_pr_remove_and_rule"><?php _e('remove ', NJT_FB_PR_I18N); ?></a>
    </td>
</tr>