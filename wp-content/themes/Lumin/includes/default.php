<div id="main" class="home">
<?php if (!is_page()) { ?>
	<?php if (get_option('lumin_blog_style') == 'on') get_template_part('includes/blogstyle_home'); else { ?>
		<div class="page-block first">
			<?php query_posts('page_id=' . get_pageId(html_entity_decode(get_option('lumin_home_page_1'))) ); while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/homepage_content'); ?>
			<?php endwhile; wp_reset_query(); ?>
		</div> <!-- end page-block -->

		<div class="page-block">
			<?php query_posts('page_id=' . get_pageId(html_entity_decode(get_option('lumin_home_page_2'))) ); while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/homepage_content'); ?>
			<?php endwhile; wp_reset_query(); ?>
		</div> <!-- end page-block -->
	<?php }; ?>
<?php } else { ?>
		<div class="page-block fullwidth">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/homepage_content'); ?>
			<?php endwhile; endif; ?>
		</div> <!-- end page-block -->
<?php } ?>
</div> <!-- end #main -->
<?php if (get_option('lumin_blog_style') == 'false') get_template_part('includes/fromblog'); else get_sidebar(); ?>