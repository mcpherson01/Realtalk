<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<a href="#TB_inline?width=300&height=300&inlineId=njt_fb_pr_findpost_thickbox" class="thickbox button button-primary" data-s_page_id="<?php echo esc_attr($s_page_id); ?>" title="<?php _e('Find Facebook Post', NJT_FB_PR_I18N); ?>">
    <span class="dashicons dashicons-search"></span>
    <?php _e('Can not find your post?', NJT_FB_PR_I18N); ?>
</a>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        var menu = $('ul#adminmenu li.toplevel_page_njt-facebook-pr.wp-has-submenu');
        menu.addClass('wp-menu-open').removeClass('wp-not-current-submenu');
        menu.find('a.toplevel_page_njt-facebook-pr').addClass('wp-menu-open');
    });
</script>