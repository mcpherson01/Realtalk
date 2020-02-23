			<div id="footer_top_part">
				<div></div>
			</div>

			<footer id="main_footer">
				<div id="footer_bg">
					<div id="footer-widgets">
						<?php dynamic_sidebar('Footer'); ?>
					</div> <!-- end #footer-widgets -->

					<p id="copyright"><?php printf( __('Designed by %s | Powered by %s', 'Notebook'), '<a href="http://www.elegantthemes.com" title="Premium WordPress Themes">Elegant Themes</a>', '<a href="http://www.wordpress.org">WordPress</a>' ); ?></p>
				</div> <!-- end #footer_bg -->
			</footer> <!-- end #main_footer -->
		</div> <!-- end #content_right -->
	</div> <!-- end #content-area -->

	<?php wp_footer(); ?>

</body>
</html>
