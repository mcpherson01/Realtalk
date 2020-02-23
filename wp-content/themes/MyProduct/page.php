<?php if (is_front_page()) { ?>
	<?php get_template_part('home'); ?>
<?php } else { ?>
	<?php get_header(); ?>

	<div id="content-left">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="entry post clearfix">
			<?php $width = 140;
				  $height = 140;
				  $classtext = 'thumbnail alignleft';
				  $titletext = get_the_title();

				  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				  $thumb = $thumbnail["thumb"]; ?>

			<?php if($thumb <> '' && get_option('myproduct_page_thumbnails') == 'on') { ?>
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
			<?php }; ?>
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(esc_html__('Edit this page','MyProduct')); ?>
			<div class="clear"></div>
		</div> <!-- end .post -->

		<?php if (get_option('myproduct_show_pagescomments') == 'on') comments_template('', true); ?>
	<?php endwhile; endif; ?>
	</div> <!-- end #content-left -->

	<?php get_sidebar(); ?>
	<?php get_footer(); ?>
<?php } ?>