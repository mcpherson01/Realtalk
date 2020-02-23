<?php get_header(); ?>

<div id="main-content">
	<div id="main-content-wrap" class="clearfix">
		<div id="left-area">
			<?php get_template_part('includes/breadcrumbs'); ?>

			<div class="entry post clearfix">
				<h1 class="title"><?php esc_html_e('No Results Found','InReview'); ?></h1>
				<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','InReview'); ?></p>
			</div>
		</div> <!-- end #left-area -->

		<?php get_sidebar(); ?>
	</div> <!-- end #main-content-wrap -->
</div> <!-- end #main-content -->
<?php get_footer(); ?>