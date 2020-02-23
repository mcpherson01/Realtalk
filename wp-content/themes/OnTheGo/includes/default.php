<div id="main-content"<?php if (get_option('onthego_blog_style') == 'on') echo " class='blogstyle'"; ?>>
	<div class="entry clearfix">

		<?php if (is_page()) { //if static homepage ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/homepage_content'); ?>
			<?php endwhile; endif; ?>
		<?php } else { ?>
			<?php if (get_option('onthego_blog_style') == 'on') get_template_part( 'includes/blogstyle_home'); else { ?>
				<?php query_posts('page_id=' . get_pageId(html_entity_decode(get_option('onthego_home_page_1'))) ); while (have_posts()) : the_post(); ?>
					<?php get_template_part('includes/homepage_content'); ?>
				<?php endwhile; wp_reset_query(); ?>
			<?php }; ?>
		<?php }; ?>

	</div> <!-- .entry -->
</div> <!-- #main-content -->

<?php if (get_option('onthego_blog_style') == 'false') get_template_part('includes/fromblog'); else get_sidebar(); ?>