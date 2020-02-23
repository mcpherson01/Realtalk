			</div> <!-- end #content -->

		</div> <!-- end .container -->
	</div>	<!-- end #bg2 -->
</div> 	<!-- end #bg -->


<div id="footer">
	<div class="container clearfix">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
		<?php endif; ?>

		<div class="clear"></div>

		<p id="copyright"><?php esc_html_e('Designed by ','DelicateNews'); ?> <a href="http://www.elegantthemes.com" title="Elegant Themes">Elegant Themes</a> | <?php esc_html_e('Powered by ','DelicateNews'); ?> <a href="http://www.wordpress.org">Wordpress</a></p>
	</div> <!--end .container -->
</div> <!-- end #footer -->

	<?php get_template_part('includes/scripts'); ?>

	<?php wp_footer(); ?>
</body>
</html>