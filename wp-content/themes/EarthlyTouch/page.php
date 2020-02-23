<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<!--Begin Article Single-->
			<div class="post-wrapper">
				<h1 class="post-title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','EarthlyTouch'), the_title()) ?>">
						<?php the_title(); ?>
					</a>
				</h1>
				<div style="clear: both;"></div>

				<?php if (get_option('earthlytouch_page_thumbnails') == 'on') { ?>

					<?php $thumb = '';

					$width = (int) get_option('earthlytouch_thumbnail_width_pages');
					$height = (int) get_option('earthlytouch_thumbnail_height_pages');
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

				<?php the_content(); ?>
				<div style="clear: both;"></div>

				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','EarthlyTouch').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(esc_html__('Edit this page','EarthlyTouch')); ?>

				<?php if (get_option('earthlytouch_show_pagescomments') == 'on') { ?>
					<!--Begin Comments Template-->
					<div class="recentposts">
						<?php comments_template('', true); ?>
					</div>
					<!--End Comments Template-->
				<?php }; ?>

			</div> <!-- end .post-wrapper -->
		<?php endwhile; endif; ?>
			<!--End Article Single-->
		</div> <!-- end #left-inside -->
	</div> <!-- end #left-div -->
	<!--Begin sidebar-->
	<?php get_sidebar(); ?>
	<!--End sidebar-->
</div> <!-- end #container -->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>