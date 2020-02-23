<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>
<div id="container" class="no_sidebar">
	<div id="left-div">
		<div id="left-inside">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<!--Start Post-->
				<div class="post-wrapper">
					<?php if (get_option('interphase_show_share') == 'on') get_template_part('includes/share'); ?>

					<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','InterPhase'), get_the_title()) ?>">
						<?php the_title(); ?>
						</a></h1>
					<div style="clear: both;"></div>

					<?php $width = (int) get_option('interphase_thumbnail_width_pages');
						  $height = (int) get_option('interphase_thumbnail_height_pages');
						  $classtext = 'alignleft';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '' && get_option('interphase_page_thumbnails') == 'on') { ?>
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
					<?php }; ?>

					<?php the_content(); ?>

					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','InterPhase').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','InterPhase')); ?>

					<div style="clear: both;"></div>

					<?php if (get_option('interphase_show_pagescomments') == 'on') { ?>
						<?php comments_template('', true); ?>
					<?php }; ?>

				</div> <!-- #post-wrapper -->
			<?php endwhile; endif; ?>
		</div> <!-- #left-inside -->
	</div> <!-- #left-div -->
<!--Begin Sidebar-->

<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>