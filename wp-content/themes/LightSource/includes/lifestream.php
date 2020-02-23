<div class="home-box-container3"> <span class="heading2"><?php esc_html_e('Lifestream','LightSource') ?></span>
    <div style="clear: both;"></div>
    <div class="prev"></div>
    <div class="home-box3">
        <?php if (function_exists('lifestream')) lifestream(); else echo('Please, activate plugins that come with the theme.'); ?>
    </div>
    <div class="next"></div>
</div>