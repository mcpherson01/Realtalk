<?php get_header(); ?>
	<h1 id="post-title"><span>
		<?php esc_html_e('No results found','Lumin'); ?> <em><?php the_search_query() ?></em>
	</span></h1>

	<div id="main">
		<div class="post index">
			<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Lumin'); ?></p>
			<div class="clear"></div>
		</div> <!-- end .post -->
	</div> <!-- end #main-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>