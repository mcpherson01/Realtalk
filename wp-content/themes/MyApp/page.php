<?php if (is_front_page()) { ?>
	<?php get_template_part('home'); ?>
<?php } else { ?>
	<?php get_header(); ?>
		<div id="main-content">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="entry post clearfix">
					<?php $width = (int) get_option('myapptheme_thumbnail_width_pages');
						  $height = (int) get_option('myapptheme_thumbnail_height_pages');
						  $classtext = 'thumb alignleft';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '' && get_option('myapptheme_page_thumbnails') == 'on') { ?>
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
					<?php }; ?>

					<h1 class="title"><?php the_title(); ?></h1>
					<?php the_content(); ?>
					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','MyAppTheme').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','MyAppTheme')); ?>
					<div class="clear"></div>
				</div> <!-- end .post -->

				<?php if (get_option('myapptheme_show_pagescomments') == 'on') comments_template('', true); ?>
			<?php endwhile; endif; ?>
		</div> <!-- end #main-content -->

	<?php get_sidebar(); ?>
	<?php get_footer(); ?>
<?php } ?>