<div id="sidebar">
	<div id="from-blog" class="clearfix">
		<ul class="control">
			<li class="recent"><a href="#recent-tabbed"><?php esc_html_e('Recent','OnTheGo'); ?></a></li>
			<li class="popular"><a href="#popular-tabbed"><?php esc_html_e('Popular','OnTheGo'); ?></a></li>
			<li class="random last"><a href="#random-tabbed"><?php esc_html_e('Random','OnTheGo'); ?></a></li>
		</ul>

		<div class="entries">
			<h3><span><?php esc_html_e('From the Blog','OnTheGo'); ?></span></h3>

			<div id="recent-tabbed" class="tabcontent">
				<?php query_posts("posts_per_page=".get_option('onthego_fromblog_recent')."&cat=".get_catid(get_option('onthego_blog_cat')));
				if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php get_template_part('includes/fromblog_post'); ?>
				<?php endwhile; endif; wp_reset_query(); ?>
			</div> <!-- end recent-tabbed -->

			<div id="popular-tabbed" class="tabcontent">
				<?php global $wpdb;
				$popular_number = get_option('onthego_fromblog_popular');
				$result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $popular_number");
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

			<div id="random-tabbed" class="tabcontent">
				<?php query_posts("posts_per_page=".get_option('onthego_fromblog_random')."&ignore_sticky_posts=1&orderby=rand&cat=".get_catid(get_option('onthego_blog_cat')));
				if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php get_template_part('includes/fromblog_post'); ?>
				<?php endwhile; endif; wp_reset_query(); ?>
			</div> <!-- end recent-tabbed -->

			<div class="entries-bottom"></div>
		</div> <!-- end entries -->
	</div> <!-- end from-blog -->
</div> <!-- end #sidebar -->