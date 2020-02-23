<div class="info-block">
	<h3 class="infotitle"><?php esc_html_e('Related Posts','Magnificent'); ?></h3>
	<div class="ul-thumb">
		<?php global $post;
		$orig_post = $post;

		$tags = wp_get_post_tags($post->ID);
		if ($tags) {
			$tag_ids = array();

			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			$args=array(
				'tag__in' => $tag_ids,
				'post__not_in' => array($post->ID),
				'posts_per_page'=>4,
				'ignore_sticky_posts'=>1,
			);
			$my_query = new wp_query( $args );

			if( $my_query->have_posts() ) { ?>
				<ul class="related-posts">
					<?php while( $my_query->have_posts() ) {
					$my_query->the_post(); ?>
						<?php $thumb = '';
						$width = 40;
						$height = 40;
						$classtext = '';
						$titletext = get_the_title();
						$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						$thumb = $thumbnail['thumb']; ?>
						<li class="clearfix">
							<?php if ($thumb <> '') { ?>
								<span class="box">
									<a href="<?php the_permalink(); ?>">
										<span class="overlay"></span>
										<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
									</a>
								</span>
							<?php } ?>
							<span class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
							<p class="post-info"><?php esc_html_e('Posted','Magnificent'); _e(' on '); the_time(get_option('magnificent_date_format')); ?></p>
						</li>
					<?php } ?>
				</ul>
			<?php }
		}
		wp_reset_postdata();
		$post = $orig_post; ?>
	</div> <!-- end .ul-thumb -->
</div> <!-- end .info-block -->

<div class="info-block">
	<h3 class="infotitle"><?php esc_html_e('Tags','Magnificent'); ?></h3>
	<div class="tags clearfix">
		<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
	</div> <!-- end .tags -->
</div> <!-- end .info-block -->

<div class="info-block last">
	<h3 class="infotitle"><?php esc_html_e('Share This','Magnificent'); ?></h3>
	<div class="share-panel">
		<?php $permalink = get_permalink(); ?>
		<a href="http://twitter.com/home?status=<?php the_title(); echo(' '); echo esc_url($permalink); ?>"><img src="<?php bloginfo('template_directory');?>/images/twitter.png" alt="" /></a>
		<a href="http://www.facebook.com/sharer.php?u=<?php echo esc_url($permalink); ?>&t=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/facebook.png" alt="" /></a>
		<a href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/delicious.png" alt="" /></a>
		<a href="http://www.digg.com/submit?phase=2&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/digg.png" alt="" /></a>
		<a href="http://www.reddit.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/reddit.png" alt="" /></a>
	</div> <!-- end .share-panel -->
</div> <!-- end .info-block -->