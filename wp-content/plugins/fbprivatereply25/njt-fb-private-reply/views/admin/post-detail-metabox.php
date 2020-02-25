<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="njt_fb_pr_post_content njt-fb-pr-row">
    <?php
        $content = $post->post_content;
        if (get_option('njt_fb_pr_is_using_utf8encode') == '1') {
            $content = utf8_decode($content);
        }
        echo $content;
    ?>
</div>
<a href="<?php echo esc_url('https://facebook.com/' . $fb_post_id); ?>" target="_blank" class="button"><?php _e('View Post', NJT_FB_PR_I18N); ?></a>
<?php /*
<a href="#TB_inline?width=600&height=550&inlineId=njt_fbpr_reply_allcomments_popup" title="<?php echo esc_attr('Reply All Comments'); ?>" data-fb_post_id="<?php echo esc_attr($fb_post_id); ?>" class="button thickbox  njt-fbpr-reply-all-btn">
    <?php _e('Reply To All Comments', NJT_FB_PR_I18N); ?>    
</a>
*/
?>
<?php
/*
 * Reply all comments popup
 */
/*njt_fb_pr_send_popup(array(
    'alias' => 'njt_fbpr_reply_allcomments',//eg: njt_fb_pr_reply_allcomments
    'send_now_attr' => sprintf('fb_post_id="%1$s" page_token="%2$s"', $fb_post_id, $page_token),
));*/
?>
