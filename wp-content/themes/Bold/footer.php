<div style="clear: both;"></div>
<img src="<?php echo get_template_directory_uri(); ?>/images/content-bottom<?php global $fullwidth; if (is_page_template('page-full.php') || ($fullwidth)) echo"-full"; ?>.gif" alt="top" style="float: left;" />
</div>
<div style="clear: both;"></div>
</div>
</div>

<?php if (get_option('bold_display_footer') == 'on') { ?>
<div id="footer">
<div id="footer-inside">
<div id="footer-inside-2">
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer") ) : ?>
    <?php endif; ?>
</div>
</div>
</div>
    <div class="footer-bottom">
    <div class="footer-bottom-inside">
   <?php esc_html_e('Powered by ','Bold'); ?> <a href="http://www.wordpress.com">WordPress</a> | <?php esc_html_e('Designed by ','Bold'); ?> <a href="http://www.elegantthemes.com">Elegant Themes</a> </div>
    </div>
    </div>
<?php }; ?>

<?php get_template_part('includes/scripts'); ?>
<?php wp_footer(); ?>