<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>

<div id="container">
	<div id="container2">
		<div id="left-div">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="post-wrapper no_sidebar">
					<h1 class="titles2">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Simplism'), the_title()) ?>">
							<?php the_title(); ?>
						</a>
					</h1>
					<div style="clear: both;"></div>

					<?php if (get_option('simplism_page_thumbnails') == 'on') { ?>

						<?php $thumb = '';

						$width = (int) get_option('simplism_thumbnail_width_pages');
						$height = (int) get_option('simplism_thumbnail_height_pages');
						$classtext = '';
						$titletext = get_the_title();

						$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						$thumb = $thumbnail["thumb"]; ?>

						<?php if($thumb <> '') { ?>
							<div style="float: left; margin: 15px 15px 10px 0px;">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							</div>
						<?php }; ?>

					<?php }; ?>

					<?php the_content(); ?>
					<div style="clear: both;"></div>

					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Simplism').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','Simplism')); ?>

					<?php if (get_option('simplism_show_pagescomments') == 'on') { ?>
						<?php comments_template('', true); ?>
					<?php }; ?>

				</div> <!-- end .post-wrapper -->
			<?php endwhile; endif; ?>
		</div> <!-- end #left-div -->
	</div> <!-- end #container2 -->

</div> <!-- end #container -->
<?php get_footer(); ?>
</body>
</html>