			</div> <!-- end .container -->
		</div> <!-- end #content-wrap -->
	</div> <!-- end #content -->

	<div id="footer-top">
		<div id="footer" class="clearfix">
			<div class="container">

				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
				<?php endif; ?>
				<div class="clear"></div>

			</div> <!-- end .container -->
		</div> <!-- end #footer -->
	</div> <!-- end #footer-top -->


	<div id="footer-copyright" class="clearfix">
		<div class="container">
			<p id="copyright"><?php esc_html_e('Designed by ','MyProduct'); ?> <a href="http://www.elegantthemes.com" title="Elegant Themes">Elegant Themes</a> | <?php esc_html_e('Powered by ','MyProduct'); ?> <a href="http://www.wordpress.org">Wordpress</a></p>
		</div> <!-- end .container -->
	</div> <!-- end #footer-copyright -->


	<?php get_template_part('includes/scripts'); ?>

	<?php wp_footer(); ?>
</body>
</html>