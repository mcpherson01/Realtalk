<?php $i=1; ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="entry<?php if ( ( $i % 2 == 0 && is_home() ) || ( $i % 3 == 0 && !is_home() ) ) echo(' last'); ?>">
		<div class="border">
			<div class="bottom">
				<div class="entry-content clearfix">
					<h3 class="title"><a href="<?php the_permalink(); ?>"><?php truncate_title(30); ?></a></h3>
					<p class="meta-info"><?php the_time(get_option('magnificent_date_format')) ?> <span><?php esc_html_e('by','Magnificent'); ?></span> <?php the_author_posts_link(); ?></p>
					<?php
						$thumb = '';
						$width = 73;
						$height = 73;
						$classtext = '';
						$titletext = get_the_title();

						$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						$thumb = $thumbnail["thumb"]; ?>
					<?php if ($thumb != '')	{?>
						<div class="thumbnail">
							<a href="<?php the_permalink(); ?>">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
								<span class="overlay"></span>
							</a>
						</div> 	<!-- end .thumbnail -->
					<?php } ?>
					<p><?php truncate_post(135); ?> </p>
					<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','Magnificent'); ?></span></a>
				</div> <!-- end .entry-content -->
			</div> <!-- end .bottom -->
		</div> <!-- end .border -->
	</div> <!-- end .entry -->
	<?php $i++; ?>
<?php endwhile; ?>
	<?php get_template_part('includes/navigation'); ?>
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>