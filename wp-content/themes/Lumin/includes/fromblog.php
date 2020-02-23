<div id="from-blog">
	<ul class="control">
		<li class="recent"><a href="#recent-tabbed"><img src="<?php echo get_template_directory_uri(); ?>/images/recent.png" alt=""/><?php esc_html_e('Recent','Lumin'); ?></a></li>
		<li class="popular"><a href="#popular-tabbed"><img src="<?php echo get_template_directory_uri(); ?>/images/popular.png" alt=""/><?php esc_html_e('Popular','Lumin'); ?></a></li>
		<li class="comments last"><a href="#random-tabbed"><img src="<?php echo get_template_directory_uri(); ?>/images/random.png" alt=""/><?php esc_html_e('Random','Lumin'); ?></a></li>
	</ul>

	<div class="content">
		<?php $lumin_blog_cat = get_option('lumin_blog_cat'); ?>
		<h3><?php esc_html_e('From the Blog','Lumin'); ?></h3>
		<a href="<?php echo esc_url(get_category_feed_link(get_catid($lumin_blog_cat), '')); ?>
"><img src="<?php echo get_template_directory_uri(); ?>/images/subscribe.png" id="subscribe" alt="Subscribe"/></a>

		<div id="recent-tabbed">
			<?php $lumin_fromblog_recent = (int) get_option('lumin_fromblog_recent');
			query_posts("posts_per_page=$lumin_fromblog_recent&cat=".get_catid($lumin_blog_cat));
			if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/fromblog_post'); ?>
			<?php endwhile; endif; wp_reset_query(); ?>
		</div> <!-- end recent-tabbed -->

		<div id="popular-tabbed">
			<?php global $wpdb;
			$lumin_fromblog_popular = (int) get_option('lumin_fromblog_popular');
			$result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $lumin_fromblog_popular");
			foreach ($result as $post) {
				#setup_postdata($post);
				$postid = (int) $post->ID;
				$title = $post->post_title;
				$commentcount = (int) $post->comment_count;
				if ($commentcount != 0) { ?>
					<?php query_posts("p=$postid"); ?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php get_template_part('includes/fromblog_post'); ?>
					<?php endwhile; endif; wp_reset_query(); ?>
				<?php };
			}; ?>
		</div> <!-- end popular-tabbed -->

		<div id="random-tabbed">
			<?php $lumin_fromblog_random = (int) get_option('lumin_fromblog_random');
			query_posts("posts_per_page=$lumin_fromblog_random&ignore_sticky_posts=1&orderby=rand&cat=".get_catid($lumin_blog_cat));
			if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/fromblog_post'); ?>
			<?php endwhile; endif; wp_reset_query(); ?>
		</div> <!-- end recent-tabbed -->

		<div id="content-bottom"></div>
	</div> <!-- end content -->
</div> <!-- end from-blog -->