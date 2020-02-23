<div class="clearfix" style="margin-left: 100px;margin-top: 18px;">
    <?php if(get_option('studioblue_728_adsense') <> '') echo(get_option('studioblue_728_adsense'));
          else { ?>
                <a href="<?php echo esc_url(get_option('studioblue_728_url')); ?>"><img src="<?php echo esc_attr(get_option('studioblue_728_image')); ?>" alt="728 ad" style="border: none;" alt="advertisement" /></a>
          <?php }; ?>
</div>