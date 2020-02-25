<script>
    jQuery(document).ready(function($) {
        $('.njt_fbpr_allow_sending_info').click(function(event) {
            var $this = $(this);
            $this.addClass('updating-message');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {'action': 'njt_fbpr_sending_info'},
            })
            .done(function(json) {
                $this.closest('.warning').remove();
            })
            .fail(function() {
                console.log("error");
            });
            
        });
        $('a[href^="https://ninjateam.org/how-to-setup-facebook-auto-reply-plugin"]').attr('target', '_blank');
        //$('a[href="admin.php?page=njt-fb-pr-reply-comments"]').hide();
    });
</script>