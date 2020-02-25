<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<a href="<?php echo esc_url(add_query_arg(array('page' => $page_slug, 's_page_id' => $s_page_id), admin_url('admin.php'))) ?>" class="button button-primary" data-s_page_id="<?php echo esc_attr($s_page_id); ?>">
    <?php _e('Reply Comments', NJT_FB_PR_I18N); ?>
</a>