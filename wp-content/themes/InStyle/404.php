<?php get_header(); ?>

	<?php get_template_part('includes/top_info'); ?>

	<div id="content-top"></div>
	<div id="content" class="clearfix">
		<div id="content-area">
			<?php get_template_part('includes/breadcrumbs'); ?>

			<div class="entry post">
				<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','InStyle'); ?></p>
			</div>

		</div> <!-- end #content-area -->

		<?php get_sidebar(); ?>
	</div> <!--end #content-->
	<div id="content-bottom"></div>

<?php get_footer(); ?>