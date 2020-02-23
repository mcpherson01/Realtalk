
		</div> 	<!-- end .container -->

		<div id="content-shadow"></div>
	</div> <!-- end #content -->

	<div id="footer" >
		<div class="container clearfix">
			<p id="copyright"><?php esc_html_e('Designed by ','MyAppTheme'); ?> <a href="http://www.elegantthemes.com" title="Elegant Themes">Elegant Themes</a> | <?php esc_html_e('Powered by ','MyAppTheme'); ?> <a href="http://www.wordpress.org">Wordpress</a></p>

			<?php global $is_footer;
			$is_footer = true; ?>

			<?php $menuClass = 'bottom-nav';
			$footerNav = '';

			if (function_exists('wp_nav_menu')) $footerNav = wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false, 'depth' => '1' ) );
			if ($footerNav == '') show_page_menu($menuClass);
			else echo($footerNav); ?>

		</div> 	<!-- end .container -->
	</div> <!-- end #footer -->

	<?php get_template_part('includes/scripts'); ?>
	<?php wp_footer(); ?>
</body>
</html>