<?php if (get_option('ebusiness_footer') == 'false') : ?>
<?php else : ?>
	<div id="footer">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer") ) : ?>
		<?php endif; ?>
		<div style="clear: both;"></div>
	</div>
	<img src="<?php echo get_template_directory_uri(); ?>/images/footer-bottom-<?php echo esc_attr(get_option('ebusiness_color_scheme')); ?>.gif" alt="footer" style="float: left;" />
	<div style="clear: both;"></div>
<?php endif; ?>

<div class="credits"><?php esc_html_e('Powered by ','eBusiness'); ?> <a href="http://www.wordpress.com">WordPress</a> | <?php esc_html_e('Designed by ','eBusiness'); ?> <a href="http://www.elegantthemes.com">Elegant Themes</a> </div>
</div>
</div>

<?php get_template_part('includes/scripts'); ?>
<?php wp_footer(); ?>