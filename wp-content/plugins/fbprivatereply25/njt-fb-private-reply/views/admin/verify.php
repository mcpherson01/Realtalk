<div class="wrap">
    <form action="" method="POST" id="njt_fbpr_verify_frm">
        <p>
            <label for="_code" style="display: block; font-weight: bold;"><?php _e('Enter your purchase code to continue: ', NJT_FB_PR_I18N);?></label>
            <input type="text" name="_code" value="" class="regular-text" id="_code" required />
        </p>
        <p>
            <button type="submit" class="button button-primary"><?php _e('Submit', NJT_FB_PR_I18N);?></button>
        </p>

    </form>
</div>
<?php var_dump(get_option('njt_fbpr_is_verified'));?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#njt_fbpr_verify_frm').on('submit', function(event) {
            event.preventDefault();
            var $this = $(this);
            var _code = $this.find('#_code').val();
            var btn = $(this).find('button');
            btn.addClass('updating-message');
            if (_code == '') {
                alert('Please enter your purchase code!');
                return false;
            } else {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {'action': 'njt_fbpr_check_code', '_code': _code, 'nonce': njt_fb_pr.nonce},
                    cache: false
                })
                .done(function(json) {
                    btn.removeClass('updating-message');
                    if (json.success) {
                        location.reload();
                    } else {
                        alert(json.data.mess);
                        return false;
                    }
                })
                .fail(function() {
                    btn.removeClass('updating-message');
                    alert('Server error, please refresh and try again.');
                    return false;
                });
            }
            return false;
        });
    });
</script>