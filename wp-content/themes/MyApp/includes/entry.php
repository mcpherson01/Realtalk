<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php $thumb = '';
	$width = (int) get_option('myapptheme_thumbnail_width_usual');
	$height = (int) get_option('myapptheme_thumbnail_height_usual');
	$classtext = 'thumb alignleft';
	$titletext = get_the_title();

	$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
	$thumb = $thumbnail["thumb"]; ?>

	<div class="entry clearfix">
		<?php if ($thumb <> '' && get_option('myapptheme_thumbnails_index') == 'on') { ?>
			<a href="<?php the_permalink(); ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
			</a>
		<?php }; ?>

		<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<?php if (get_option('myapptheme_blog_style') == 'on') the_content(""); else { ?>
			<p><?php truncate_post(535); ?></p>
		<?php }; ?>

		<?php if(get_option('myapptheme_postinfo1') <> '') { ?>
			<div class="meta-info">
				<?php if ( in_array('author', get_option('myapptheme_postinfo1')) || in_array('date', get_option('myapptheme_postinfo1')) ) { ?>
					<p class="meta"><?php esc_html_e('Posted ','MyAppTheme');?>
						<?php if ( in_array('author', get_option('myapptheme_postinfo1')) ) { esc_html_e('by ','MyAppTheme'); the_author_posts_link(); } ?>
						<?php if ( in_array('date', get_option('myapptheme_postinfo1')) ) { esc_html_e(' on ','MyAppTheme'); the_time(get_option('myapptheme_date_format')); } ?>
					</p>
				<?php }; ?>

				<?php if ( in_array('comments', get_option('myapptheme_postinfo1')) ) { ?>
					<p class="meta3">
						<?php comments_popup_link(esc_html__('0 comments','MyAppTheme'), esc_html__('1 comment','MyAppTheme'), '% '.esc_html__('comments','MyAppTheme')); ?>
					</p>
				<?php }; ?>

				<?php if ( in_array('categories', get_option('myapptheme_postinfo1')) ) { ?>
					<p class="meta2">
						<?php the_category(', '); ?>
					</p>
				<?php }; ?>

			</div>
		<?php }; ?>

		<a href="<?php the_permalink(); ?>" class="readmore2"><span><?php esc_html_e('Read More','MyAppTheme'); ?></span></a>

	</div> <!-- end .entry -->
<?php endwhile; ?>
	<div class="hr"></div>

	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
		else { ?>
			<?php get_template_part('includes/navigation'); ?>
	<?php } ?>
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>