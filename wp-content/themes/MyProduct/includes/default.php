
	<?php if (is_page()) { //if static homepage
			 if (have_posts()) : while (have_posts()) : the_post();
				get_template_part('includes/homepage_content');
			 endwhile; endif;
		  } else {
			 if (get_option('myproduct_blog_style') == 'on') get_template_part('includes/blogstyle_home');
		  }; ?>

	</div> <!-- end #content-left -->

	<?php if (get_option('myproduct_homepage_widgets') == 'on') { ?>
		<div id="sidebar">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Home') ) : ?>
			<?php endif; ?>
		</div> <!-- end #sidebar -->
	<?php } else get_sidebar(); ?>