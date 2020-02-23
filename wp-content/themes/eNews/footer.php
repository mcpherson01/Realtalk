		</div> <!-- end wrapper -->
	</div> <!-- end main area wrap -->
	<div id="footer-widgets-wrap">
		<div id="footer-widgets-inside">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
			<?php endif; ?>
		</div> <!-- end footer-widgets-inside -->
		<div id="footer-bottom"><p><?php esc_html_e('Powered by ','eNews'); ?> <a href="http://www.wordpress.com">WordPress</a> | <?php esc_html_e('Designed by ','eNews'); ?> <a href="http://www.elegantthemes.com">Elegant Themes</a></p></div>
	</div> <!-- end footer-widgets-wrap -->
</div> <!-- end container -->
</div> <!-- end content -->

<?php get_template_part('includes/scripts'); ?>
<?php wp_footer(); ?>
</body>
</html>