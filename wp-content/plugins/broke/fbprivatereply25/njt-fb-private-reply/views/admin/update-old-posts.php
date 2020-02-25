<?php
//$post_ids
?>
<div class="warning notice notice-warning">
    <p>
        <?php _e('Updating database, please wait and DO NOT CLOSE OR REFRESH browser <span class="njt-fb-dot-updating"></span>', NJT_FB_PR_I18N) ?>
    </p>
</div>
<script type="text/javascript">
    var njt_fb_pr_old_posts = <?php echo json_encode($post_ids); ?>;
    var update_type = '<?php echo $update_type; ?>';
    function njt_fb_pr_update_old_posts(index)
    {
        if (typeof njt_fb_pr_old_posts[index] != 'undefined') {
            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'njt_fb_pr_update_old_posts',
                    'update_type' : update_type,
                    'post_id': njt_fb_pr_old_posts[index],
                    'nonce': njt_fb_pr.nonce
                }
            })
            .done(function(json) {
                njt_fb_pr_update_old_posts(index + 1)
            })
            .fail(function() {
                njt_fb_pr_update_old_posts(index + 1)
                console.log("error");
            });
            
        } else {
            if (update_type == 'status') {
                jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        'action': 'njt_fb_pr_update_old_posts',
                        'update_type' : 'update_status_last_post',
                        'nonce': njt_fb_pr.nonce
                    }
                })
                .done(function(json) {
                    location.reload();
                })
                .fail(function() {
                    location.reload();
                });
            } else {
                location.reload();
            }
        }
    }
    jQuery(document).ready(function($) {
        var d = '.';
        setInterval(function(){
            if (d == '.......') {
                d = '';
            }
            $('.njt-fb-dot-updating').text(d);
            d += '.';
        }, 500);
        njt_fb_pr_update_old_posts(0);
    });
</script>
