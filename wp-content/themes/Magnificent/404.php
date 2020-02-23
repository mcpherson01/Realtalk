<?php get_header(); ?>

<?php get_template_part('includes/breadcrumbs'); ?>

	<div id="entries">
		<div class="entry post entry-full">
			<div class="border">
				<div class="bottom">
					<div class="entry-content clearfix">
						<h1 class="title"><?php esc_html_e('No Results Found','Magnificent'); ?></h1>

						<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Magnificent'); ?></p>

					</div> <!-- end .entry-content -->
				</div> <!-- end .bottom -->
			</div> <!-- end .border -->
		</div> <!-- end .entry -->

		<div class="clear"></div>
	</div> <!-- end #entries -->

	<div id="sidebar-right" class="sidebar">
		<div class="block">
			<div class="block-border">
				<div class="block-content">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Right Top') ) : ?>
					<?php endif; ?>
				</div> <!-- end .block-content -->
			</div> <!-- end .block-border -->
		</div> <!-- end .block -->

		<div class="block">
			<div class="block-border">
				<div class="block-content">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Right Bottom') ) : ?>
					<?php endif; ?>
				</div> <!-- end .block-content -->
			</div> <!-- end .block-border -->
		</div> <!-- end .block -->
	</div> <!-- end #sidebar-right -->

<?php get_footer(); ?>