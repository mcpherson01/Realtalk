<?php if (is_front_page()) { ?>
	<?php get_template_part('home'); ?>
<?php } else { ?>
	<?php get_header(); ?>
	<div id="main-content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="entry clearfix">

				<h1 id="post-title"><span><?php the_title(); ?></span></h1>

				<?php $thumb = '';

     				  $width = (int) get_option('onthego_thumbnail_width_pages');
					  $height = (int) get_option('onthego_thumbnail_height_pages');
					  $classtext = 'thumbnail-post alignleft';
					  $titletext = get_the_title();

					  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					  $thumb = $thumbnail["thumb"]; ?>

				<?php if($thumb <> '' && get_option('onthego_page_thumbnails') == 'on') { ?>
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				<?php }; ?>
				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','OnTheGo').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

				<?php edit_post_link(esc_html__('Edit this page','OnTheGo')); ?>

				<?php if (get_option('onthego_show_pagescomments') == 'on') { ?>
					<div id="page-comments">
						<?php comments_template('', true); ?>
					</div> <!-- end #page-comments-->
				<?php }; ?>

			</div> <!-- end .entry -->
		<?php endwhile; endif; ?>
	</div> <!-- end #main-content -->

	<?php get_sidebar(); ?>
	<?php get_footer(); ?>
<?php } ?>