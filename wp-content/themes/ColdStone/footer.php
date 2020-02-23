<div class="footer">
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer") ) : ?>
    <?php endif; ?>
    <div style="clear: both;"></div>
    <p><?php esc_html_e('Powered by ','ColdStone'); ?> <a href="http://www.wordpress.com">WordPress</a> | <?php esc_html_e('Designed by ','ColdStone'); ?> <a href="http://www.elegantthemes.com">Elegant Themes</a></p>
</div>
<!-- /footer -->
</div>
<!-- /wrapp_ -->

<?php get_template_part('includes/scripts'); ?>
<?php wp_footer(); ?>
</body></html>