<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<table class="form-table">
    <tr>
        <th scope="row">
            <label for="njt_fbpr_post_ms_en_nd_level_rep">
                <?php _e('Enable second level replies? ', NJT_FB_PR_I18N); ?>    
            </label>
        </th>
        <td>
            <input type="checkbox" name="njt_fbpr_post_ms_en_nd_level_rep" id="njt_fbpr_post_ms_en_nd_level_rep" value="1" <?php checked(get_post_meta($post->ID, 'njt_fbpr_post_ms_en_nd_level_rep', true), '1'); ?> />
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="njt_fbpr_post_ms_like_comment">
                <?php _e('Auto LIKE Comment? ', NJT_FB_PR_I18N); ?>    
            </label>
        </th>
        <td>
            <input type="checkbox" name="njt_fbpr_post_ms_like_comment" id="njt_fbpr_post_ms_like_comment" value="1" <?php checked(get_post_meta($post->ID, 'njt_fbpr_post_ms_like_comment', true), '1'); ?> />
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="njt_fbpr_post_ms_hide_comment">
                <?php _e('Auto HIDE Comment? ', NJT_FB_PR_I18N); ?>    
            </label>
        </th>
        <td>
            <input type="checkbox" name="njt_fbpr_post_ms_hide_comment" id="njt_fbpr_post_ms_hide_comment" value="1" <?php checked(get_post_meta($post->ID, 'njt_fbpr_post_ms_hide_comment', true), '1'); ?> />
        </td>
    </tr>
</table>