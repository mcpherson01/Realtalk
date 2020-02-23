<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="post-wrapper no_sidebar">
					<?php get_template_part('includes/buttons'); ?>

					<?php if (get_option('artsee_page_thumbnails') == 'on') { ?>

						<?php $thumb = '';

						$width = 573;
						$height = 187;
						$classtext = '';
						$titletext = get_the_title();

						$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						$thumb = $thumbnail["thumb"]; ?>

						<?php if($thumb <> '') { ?>
							<div class="thumbnail-div">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							</div>
						<?php }; ?>

					<?php }; ?>

					<h1 class="titles">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','ArtSee'), the_title()) ?>">
							<?php the_title(); ?>
						</a>
					</h1>
					<div style="clear: both;"></div>

					<?php the_content(); ?>
					<div style="clear: both;"></div>

					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','ArtSee').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','ArtSee')); ?>

					<?php if (get_option('artsee_show_pagescomments') == 'on') { ?>
						<!--Begin Comments Template-->
						<div class="recentposts">
							<?php comments_template('', true); ?>
						</div>
						<!--End Comments Template-->
					<?php }; ?>
				</div> <!-- end .post-wrapper -->
			<?php endwhile; endif; ?>
		</div> <!-- end #left-inside -->
    </div> <!-- end #left-div -->

	<!--Begin Sidebar-->

	<!--End Sidebar-->
</div> <!-- end #container -->

<div style="clear: both;"></div>
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>