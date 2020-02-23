				<div id="footer">
					<div id="footer-wrapper">
						<div id="footer-center">
							<div class="container">
								<?php if (!is_home()) { ?>
									<div id="footer-widgets" class="clearfix">
										<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
										<?php endif; ?>
									</div> <!-- end #footer-widgets -->
								<?php } ?>

								<p id="copyright"><?php esc_html_e('Designed by ','DeepFocus'); ?> <a href="http://www.elegantthemes.com" title="Elegant Themes">Elegant Themes</a> | <?php esc_html_e('Powered by ','DeepFocus'); ?> <a href="http://www.wordpress.org">Wordpress</a></p>
							</div> <!-- end .container -->
						</div> <!-- end #footer-center -->
					</div> <!-- end #footer-wrapper -->
				</div> <!-- end #footer -->

			</div> <!-- end .center-highlight -->

	</div> <!-- end #content-full -->

	<?php get_template_part('includes/scripts'); ?>

	<?php wp_footer(); ?>
</body>
</html>