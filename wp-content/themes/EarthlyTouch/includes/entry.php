<div class="home-post-wrap">
	<div class="entry">
		<?php $width = 90;
		$height = 150;
		$classtext = 'no-border';
		$titletext = get_the_title();

		$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		$thumb = $thumbnail["thumb"]; ?>
		<?php if($thumb != '' && get_option('earthlytouch_thumbnails_index') == 'on') { ?>
			<div class="thumbnail-div" style="margin-bottom: 10px;">
				<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				</a>
			</div>
		<?php }; ?>
		<div class="post-content">
			<?php if (get_option('earthlytouch_blog_style') == 'on') { ?>
				<h1 class="titles">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','EarthlyTouch'), the_title()) ?>">
						<?php truncate_title(50) ?>
					</a>
				</h1>

				<?php if (get_option('earthlytouch_postinfo1') ) { ?>
					<div class="articleinfo"><?php esc_html_e('Posted','EarthlyTouch'); ?> <?php if (in_array('author', get_option('earthlytouch_postinfo1'))) { ?> <?php esc_html_e('by','EarthlyTouch'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('earthlytouch_postinfo1'))) { ?> <?php esc_html_e('on','EarthlyTouch'); ?> <?php the_time(get_option('earthlytouch_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('earthlytouch_postinfo1'))) { ?> <?php esc_html_e('in','EarthlyTouch'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('earthlytouch_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','EarthlyTouch'), esc_html__('1 comment','EarthlyTouch'), '% '.esc_html__('comments','EarthlyTouch')); ?><?php }; ?></div>
				<?php }; ?>

				<?php the_content(''); ?>
			<?php } else { ?>
				<h2 class="titles">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','EarthlyTouch'), the_title()) ?>">
						<?php truncate_title(50); ?>
					</a>
				</h2>
				<?php truncate_post(430); ?>
			<?php }; ?>

			<div style="clear: both;"></div>
			<div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','EarthlyTouch'), get_the_title()) ?>"><?php esc_html_e('Read More','EarthlyTouch'); ?></a></div>
		</div> <!-- end .post-content -->
	</div> <!-- end .entry -->
</div> <!-- end .home-post-wrap -->