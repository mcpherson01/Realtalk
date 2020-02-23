<?php if (get_option('simplism_blog_style') == 'false') { ?>

	<div class="home-post-wrap">
		<div class="post">
			<?php $width = 263;
			$height = 108;
			$classtext = '';
			$titletext = get_the_title();

			$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
			$thumb = $thumbnail["thumb"]; ?>
			<?php if($thumb != '' && get_option('simplism_thumbnails_index') == 'on') { ?>
				<div class="thumbnail-div" style="width: 263px; margin-bottom: 10px;">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				</div>
			<?php }; ?>

			<h2 class="titles">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Simplism'), the_title()) ?>">
					<?php truncate_title(23); ?>
				</a>
			</h2>

			<?php truncate_post(290); ?>
			<div style="clear: both;"></div>

			<div class="readmore">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Simplism'), the_title()) ?>"><?php esc_html_e('Read More','Simplism'); ?></a>
			</div>
		</div> <!-- end .post -->
	</div> <!-- end .home-post-wrap -->

<?php } else { ?>

	<div class="post-wrapper" style="padding-top: 5px !important; margin-top: 15px;">
		<h2 class="titles2">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Simplism'), the_title()) ?>">
				<?php the_title(); ?>
			</a>
		</h2>

		<?php if (get_option('simplism_postinfo1') ) { ?>
			<div class="articleinfo"><?php esc_html_e('Posted','Simplism'); ?> <?php if (in_array('author', get_option('simplism_postinfo1'))) { ?> <?php esc_html_e('by','Simplism'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('simplism_postinfo1'))) { ?> <?php esc_html_e('on','Simplism'); ?> <?php the_time(get_option('simplism_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('simplism_postinfo1'))) { ?> <?php esc_html_e('in','Simplism'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('simplism_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','Simplism'), esc_html__('1 comment','Simplism'), '% '.esc_html__('comments','Simplism')); ?><?php }; ?></div>
		<?php }; ?>

		<div style="clear: both;"></div>

		<?php the_content(); ?>
		<div style="clear: both;"></div>
	</div> <!-- end .post-wrapper -->

<?php }; ?>