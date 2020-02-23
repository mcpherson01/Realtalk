<?php get_header(); ?>

<div id="container">
	<div id="container2">
		<div id="left-div">
				<div class="post-wrapper">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<h1 class="titles2">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','BlueMist'), get_the_title()) ?>">
							<?php the_title(); ?>
						</a>
					</h1>
					<div style="clear: both;"></div>

					<?php if (get_option('bluemist_page_thumbnails') == 'on') { ?>

						<?php $thumb = '';

						$width = (int) get_option('bluemist_thumbnail_width_pages');
						$height = (int) get_option('bluemist_thumbnail_height_pages');
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

					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','BlueMist').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','BlueMist')); ?>

				</div> <!-- end .post-wrapper -->

				<?php if (get_option('bluemist_show_pagescomments') == 'on') { ?>
					<?php comments_template('', true); ?>
				<?php }; ?>
			<?php endwhile; endif; ?>
		</div> <!-- end #left-div -->
	</div> <!-- end #container2 -->
	<?php get_sidebar(); ?>
</div>	<!-- end #container -->
<?php get_footer(); ?>
</body>
</html>