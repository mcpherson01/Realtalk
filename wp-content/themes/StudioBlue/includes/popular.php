<div class="home-post-wrap2">
    <?php if (get_option('studioblue_show_popular') == 'on') { ?>
		<div style="float: left; width: 49%;">
			<span class="headings"><?php esc_html_e('Popular Articles','StudioBlue'); ?></span>
			<ul class="list2">
				<?php $popular_num = get_option('studioblue_popular_num');
				$result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $popular_num");
				foreach ($result as $post) {
					#setup_postdata($post);
					$postid = (int) $post->ID;
					$title = $post->post_title;
					$commentcount = (int) $post->comment_count;
					if ($commentcount != 0) { ?>
						<li><a href="<?php echo esc_url(get_permalink($postid)); ?>" title="<?php echo esc_attr($title); ?>">
						<?php echo esc_html($title); ?></a> (<?php echo esc_html($commentcount); ?>)</li>
					<?php }
				} ?>
			</ul>
		</div>
	<?php }; ?>

	<?php if (get_option('studioblue_show_random') == 'on') { ?>
		<div style="float: left; width: 49%;">
			<span class="headings"><?php esc_html_e('Random Articles','StudioBlue'); ?></span>
			<ul>
				<?php $my_query = new WP_Query('ignore_sticky_posts=1&orderby=rand&posts_per_page='.get_option('studioblue_random_num'));
	while ($my_query->have_posts()) : $my_query->the_post();
	?>
				<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>">
					<?php the_title() ?>
					</a></li>
				<?php endwhile; ?>
			</ul>
		</div>
		<div style="clear: both;"></div>
	<?php }; ?>
</div>