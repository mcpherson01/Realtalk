<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php if (count($all_admins) > 0) : ?>
<div class="njt_fb_pr_pages_btns">
    <a href="<?php echo esc_url($get_new_pages_url); ?>" class="button button-primary">
        <span class="dashicons dashicons-edit"></span>
        <?php _e('Get New Pages', NJT_FB_PR_I18N); ?>
    </a>
    <a onclick="return confirm('<?php _e('Are you sure?', NJT_FB_PR_I18N); ?>');" class="button button-primary" href="<?php echo esc_url($reload_pages_url); ?>" style="display: none !important">
        <span class="dashicons dashicons-trash"></span>
        <?php echo $reload_pages_title; ?>
    </a>    
</div>
<form action="<?php echo admin_url('admin.php'); ?>" method="GET" class="njt-fbpr-choose-account-frm">
    <input type="hidden" name="page" value="<?php echo $page_slug; ?>">
    <p>
        <label for="user_id">
            <?php _e('Choose Account: ', NJT_FB_PR_I18N); ?>
        </label>
        <select name="user_id" id="user_id" style="width: 200px;">
            <?php
            foreach ($all_admins as $admin_k => $admin_v) {
                echo sprintf('<option value="%1$s" %2$s>%3$s (%1$s)</option>', $admin_k, selected($admin_k, $user_id, false), $admin_v);
            }
            ?>
        </select>
    </p>
</form>
<script>
    jQuery(document).ready(function($) {
        var sel = $('.njt-fbpr-choose-account-frm').find('#user_id');
        sel.change(function(event) {
            $('.njt-fbpr-choose-account-frm').submit();
        });
    });
</script>
<?php endif; ?>
<div class="njt-fb-pr-list-pages">
    <?php
    foreach ($pages as $k => $page) {
        $link_page = add_query_arg(
            array(
                //'fb_page_id' => $page->page_id,
                's_page_id' => $page->sql_post_id,
                'post_type' => 'njt_fb_pr_tmp_posts',
            ),
            'edit.php'
        );
        ?>
        <div class="njt-page" data-s_page_id="<?php echo esc_attr($page->sql_post_id); ?>" style="display: <?php  echo (($is_subscribe) ? 'none' : 'block');?>">
            <div class="njt-inner">
                <div class="njt-fbpr-page-image">
                    <a href="<?php echo esc_url($link_page); ?>"><img src="https://graph.facebook.com/<?php echo $page->page_id; ?>/picture/?type=large" alt=""></a>
                </div>
                <h3>
                    <?php
                        echo sprintf('<a data-link="%1$s" href="%2$s">%3$s</a>', esc_attr($link_page), esc_url($link_page), $page->page_name);
                    ?>                    
                </h3>
                <div class="njt-fb-pr-subscribe-wrap" style="display: none;<?php //echo (($page->is_subscribed == 'no') ? 'block' : 'none'); ?>">
                    <a href="javascript:void(0)" class="button njt-fb-pr-subscribe-btn" data-s_page_id="<?php echo esc_attr($page->sql_post_id); ?>">
                        <?php echo __('Subscribe', NJT_FB_PR_I18N); ?>                            
                    </a>
                </div>
                <div class="njt-fb-pr-unsubscribe-wrap" style="display: none;<?php //echo (($page->is_subscribed == 'yes') ? 'block' : 'none'); ?>">
                    <a href="javascript:void(0)" class="button njt-fb-pr-unsubscribe-btn" data-s_page_id="<?php echo esc_attr($page->sql_post_id); ?>">
                        <?php echo __('Unsubscribe', NJT_FB_PR_I18N); ?>                            
                    </a>
                </div>
                <div class="nj-page-actions">
                    <a href="#" class="njt-page-aciton-remove" data-s_page_id="<?php echo esc_attr($page->sql_post_id); ?>">
                        <span class="dashicons dashicons-trash"></span>
                    </a>
                </div>
                <?php do_action('njt_fb_pr_after_page', $page); ?>
            </div>                        
        </div>
        <?php
    }
    ?>
</div>
<?php
if ($is_subscribe === true) {
    ?>
    <script type="text/javascript">
        var njt_fbpr_pages = [];
        var njt_fbpr_has_failed = false;
        var reload_url = '<?php echo $reload_url; ?>';
        jQuery(document).ready(function($) {
            function njt_fb_pr_subscriber_getpages()
            {
                jQuery('.njt-fb-pr-list-pages').find('.njt-page').each(function(index, el) {
                    njt_fbpr_pages.push($(el).data('s_page_id'));
                });
            }
            function njt_fb_pr_subscriber_start(index, reload_url)
            {
                
                if (typeof njt_fbpr_pages[index] != 'undefined') {
                    var s_page_id = njt_fbpr_pages[index];
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {'action': 'njt_fb_pr_subscribe_page', 's_page_id' : s_page_id, 'nonce' : njt_fb_pr.nonce},
                    })
                    .done(function(json) {
                        $('.njt-fb-pr-list-pages').find('div[data-s_page_id="'+s_page_id+'"]').show();
                        if (!json.success) {
                            njt_fbpr_has_failed = true;
                        }
                        //njt_fb_pr_subscriber_start(index + 1, json.data.reload_url);
                        njt_fb_pr_subscriber_start(index + 1, reload_url);
                        
                    })
                    .fail(function() {
                        console.log("error");
                    });
                } else {
                    if (njt_fbpr_has_failed) {
                        alert(njt_fb_pr.subscribe_has_error);
                    }
                    location.replace(reload_url);
                }
            }
            njt_fb_pr_subscriber_getpages();
            njt_fb_pr_subscriber_start(0, reload_url);
        });
    </script>
    <?php
}
?>