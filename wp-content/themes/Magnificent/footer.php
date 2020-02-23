			</div> <!-- end .container -->
		</div> <!-- end #content -->

		<div id="footer" class="clearfix">
			<div id="footer-content">
				<div class="container">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
					<?php endif; ?>

					<p id="copyright"><?php esc_html_e('Designed by ','Magnificent'); ?> <a href="http://www.elegantthemes.com" title="Elegant Themes">Elegant Themes</a> | <?php esc_html_e('Powered by ','Magnificent'); ?> <a href="http://www.wordpress.org">WordPress</a></p>
				</div> <!-- end .container -->
			</div> <!-- end #footer-content -->
		</div> <!-- end #footer -->
	</div> <!-- end #top-overlay -->

	<?php get_template_part('includes/scripts'); ?>

	<?php wp_footer(); ?>
</body>
</html>