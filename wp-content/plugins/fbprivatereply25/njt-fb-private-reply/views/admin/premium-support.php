<div class="wrap">

    <h1>Enter your item purchase code to get Premium Support</h1>
    <p><a href="https://ninjateam.org/can-find-item-purchase-code/" target="_blank">Where can I find my item purchase code?</a></p>

    <form action="" class="njt-fbpr-check-purchase-frm" method="POST">
        <ul class="njt-fbpr-check-purchase-wrap">
            <input type="hidden" name="nonce" value="<?php echo $nonce; ?>" />
            <li>
                <input type="text" name="njt-fbpr-check-purchase-code" value="" id="njt-fbpr-check-purchase-code" required="required" class="regular-text" placeholder="<?php _e('Enter your purchase code', NJT_FB_PR_I18N); ?>" />
            </li>
            <li>
                <?php submit_button(__('Submit', NJT_FB_PR_I18N)); ?>
            </li>
        </ul>
        <div class="njt-fbpr-check-purchase-result"></div>
    </form>
</div>
<script>
    jQuery(document).ready(function($) {
        /*
         * Premium Support checking
         */
        $('.njt-fbpr-check-purchase-frm').on('submit', function(event) {
            var $this = $(this);
            var code = $this.find('input[name="njt-fbpr-check-purchase-code"]').val();
            if (code != '') {
                $this.addClass('updating-message');
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {'action': 'njt_fb_pr_premium_support_check', 'code': code, 'nonce': $this.find('input[name="nonce"]').val()},
                })
                .done(function(json) {
                    $this.removeClass('updating-message');
                    if (json.success) {
                        $('.njt-fbpr-check-purchase-wrap').hide();
                    } else {
                        $this.find('input[name="njt-fbpr-check-purchase-code"]').val('');
                    }
                    $('.njt-fbpr-check-purchase-result').html(json.data.html);
                })
                .fail(function() {
                    $this.removeClass('updating-message');
                    console.log("error");
                });
            }
            return false;
        });
    });
</script>