	<footer id="main-footer">
		<div class="container">
			<?php if ( is_active_sidebar('footer-area') ) { ?>
				<div id="footer-widgets" class="clearfix">
					<?php dynamic_sidebar('footer-area'); ?>
				</div> <!-- end #footer-widgets -->
			<?php } ?>
		</div> <!-- end .container -->
	</footer> <!-- end #main-footer -->

	<div id="footer-bottom">
		<div class="container clearfix">
			<p id="copyright"><?php esc_html_e('Designed by ','eList'); ?> <a href="http://www.elegantthemes.com" title="Premium WordPress Themes">Elegant Themes</a> | <?php esc_html_e('Powered by ','eList'); ?> <a href="http://www.wordpress.org">WordPress</a></p>
		</div> <!-- end .container -->
	</div> <!-- end #footer-bottom -->

	<?php wp_footer(); ?>
</body>
</html>