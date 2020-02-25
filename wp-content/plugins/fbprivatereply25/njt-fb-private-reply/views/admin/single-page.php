<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1>
        <?php echo $page->page_name; ?>                
    </h1>
    <form action="" method="POST">
        <h3>
            <?php _e('Page\'s Posts', NJT_FB_PR_I18N); ?>
            <a onclick="return confirm('<?php _e('Are you sure ?', NJT_FB_PR_I18N); ?>')" href="<?php echo esc_url($reget_posts_url); ?>" class="button button-primary" data-page_id="<?php echo $page->page_id; ?>">
            <?php _e('Re-get new posts', NJT_FB_PR_I18N); ?>
        </a>    
        </h3>
        <ul class="njt-fb-pr-posts">
            <?php
            foreach ($posts as $k => $v) {
                echo sprintf('<li><label><input type="checkbox" name="post_id[]" value="%1$s" />%2$s</label></li>', esc_attr($v->id), $v->message);
            }
            ?>
        </ul>
    </form>
</div>