<?php get_header(); ?>

<div id="main-content">
	<div class="container clearfix">
		<div id="entries-area">
			<div id="entries-area-inner">
				<div id="entries-area-content" class="clearfix">
					<div id="content-area">
						<?php get_template_part('includes/breadcrumbs'); ?>

						<div class="entry post clearfix">
							<h1 class="title"><?php esc_html_e('No Results Found','Nova'); ?></h1>
							<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Nova'); ?></p>
						</div>
					</div> <!-- end #content-area -->

					<?php get_sidebar(); ?>
				</div> <!-- end #entries-area-content -->
			</div> <!-- end #entries-area-inner -->
		</div> <!-- end #entries-area -->
	</div> <!-- end .container -->
</div> <!-- end #main-content -->

<?php get_footer(); ?>