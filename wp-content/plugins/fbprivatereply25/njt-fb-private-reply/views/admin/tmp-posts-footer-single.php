<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
$w_html = '<div class="njt_fb_pr_spin_w_small_wrap"><input type="text" name="njt_fb_pr_spin_w[]" class="njt_fb_pr_spin_w" /><span>|</span></div>';
$word_html = '<div class="njt_fb_pr_spin_w_row">
                <span>{</span>
                <div class="njt_fb_pr_spin_w_wrap">
                    '.$w_html.'
                </div>
                <span>}</span>
                <a href="#" class="njt_fb_pr_spin_add_w">
                    <span class="dashicons dashicons-plus"></span>
                </a>
            </div>';
?>
<div id="njt_fb_pr_spin_thickbox" style="display: none;">
    <div class="njt_fb_pr_spin_thickbox_inner">
        <div class="njt_fb_pr_spin_thickbox_body">
            <div class="njt_fb_pr_spin_word_wrap">
                <?php echo $word_html; ?>            
            </div>
            <a href="#" class="njt_fb_pr_spin_add_word">
                <span class="dashicons dashicons-plus"></span>
            </a>
        </div>
        <div class="njt_fb_pr_spin_thickbox_footer">
            <a class="njt_fb_pr_spin_thickbox_question_mark" target="_blank" href="<?php echo NJT_FB_PR_URL; ?>/assets/img/njt_spin.gif">?</a>
            <button class="button button-primary njt_fb_pr_spin_insert_now"><?php _e('Insert', NJT_FB_PR_I18N); ?></button>
        </div>
    </div>
</div>
<script type="text/html" id="njt_fb_pr_spin_w_html"><?php echo $w_html; ?></script>
<script type="text/html" id="njt_fb_pr_spin_word_html"><?php echo $word_html; ?></script>