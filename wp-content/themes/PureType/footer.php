<div id="footer">
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer") ) : ?>
    <?php endif; ?>
    <div style="clear: both;"></div>
</div>
<div style="clear: both;"></div>
<div style="clear: both; margin-bottom: 20px; margin-top: 20px; float: left; font-size: 10px; width: 636px;" class="bluefooter"><?php esc_html_e('Powered by ','PureType'); ?> <a href="http://www.wordpress.com">WordPress</a> | <?php esc_html_e('Designed by ','PureType'); ?> <a href="http://www.elegantthemes.com">Elegant Themes</a></div>
</div>

<?php get_template_part('includes/scripts'); ?>
<?php wp_footer(); ?>