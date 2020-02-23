</div> <!-- end #main-area -->

			</div> <!-- end #content -->
		</div> <!-- end #contentwrap -->

		<div id="footer-widgets-wrap">
			<div id="footer-widgets" class="clearfix">

				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
				<?php endif; ?>

			</div> <!-- end #footer-widgets -->
		</div> <!-- end #footer-widgets-wrap -->

		<div id="footer">
			<p id="copyright"><?php esc_html_e('Powered by ','OnTheGo'); ?> <a href="http://www.wordpress.com">WordPress</a> | <?php esc_html_e('Designed by ','OnTheGo'); ?> <a href="http://www.elegantthemes.com">Elegant Themes</a></p>
		</div> <!-- end #footer -->

	</div> <!-- end container -->

	<?php get_template_part('includes/scripts'); ?>

<?php wp_footer(); ?>
</body>
</html>