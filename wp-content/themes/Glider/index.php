<?php $blogStyle = ( get_option('glider_blog_style') == 'on' ) ? true : false; ?>
<?php include(TEMPLATEPATH . '/header.php'); ?>

	<div id="main-rightarea">
		<div class="topbg"></div>

		<div class="block">
			<h2 class="gallery-title"><?php esc_html_e('From The Blog','Glider'); ?></h2>

			<?php $i=0; ?>
				<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
					<?php $i++; ?>
					<div class="content-area<?php if (!$blogStyle) echo ' small'; else echo ' blogstyle' ?> clearfix<?php if ($i % 2 == 0) echo(' last'); ?>">
						<?php
							$thumb = '';
							$width = 103;
							$height = 103;
							if ($blogStyle) {
								$width = 173;
								$height = 173;
							}
							$classtext = '';
							$titletext = get_the_title();
							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);

							$thumb = $thumbnail['thumb']; ?>

						<?php if ($thumb <> '' && $blogStyle && get_option('glider_thumbnails_index') == 'on') { ?>
							<div class="thumb">
								<?php print_thumbnail($thumb, $thumbnail['use_timthumb'], $titletext, $width, $height); ?>
								<span class="overlay"></span>
							</div> <!-- .thumb -->
						<?php } ?>

						<h2 class="<?php if (!$blogStyle) echo 'blog'; ?>title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php if ($blogStyle) get_template_part('includes/postinfo');
						else { ?>
							<p class="postinfo"><?php esc_html_e('Posted by','Glider'); ?> <?php the_author_posts_link(); ?> <?php esc_html_e('on','Glider'); ?> <?php the_time(get_option('glider_date_format')); ?></p>
						<?php } ?>

						<?php if ($thumb <> '' && !$blogStyle && get_option('glider_thumbnails_index') == 'on') { ?>
							<div class="blogthumb">
								<a href="<?php the_permalink(); ?>">
									<?php print_thumbnail($thumb, $thumbnail['use_timthumb'], $titletext, $width, $height, ''); ?>
									<span class="overlay"></span>
								</a>
							</div> <!-- end .blogthumb -->
						<?php } ?>

						<?php if ($blogStyle) the_content();
						else { ?>
							<p><?php truncate_post(115); ?></p>
						<?php } ?>

						<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','Glider'); ?></span></a>

						<div class="shadow"></div>
					</div> <!-- .content-area -->
				<?php endwhile; ?>
					<?php if (function_exists('wp_pagenavi')) { wp_pagenavi(); }
					else { ?>
						<?php get_template_part('includes/navigation'); ?>
					<?php } ?>
				<?php else : ?>
					<?php get_template_part('includes/no-results'); ?>
				<?php endif; ?>
		</div> <!-- .block -->

	</div> <!-- #main-rightarea -->

<?php get_footer(); ?>