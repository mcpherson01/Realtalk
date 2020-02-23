<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<!--Begin Post Single-->
			<div class="post-wrapper">
				<?php if (get_option('tidalforce_show_share') == 'on') get_template_part('includes/share');  ?>
				<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','TidalForce'), the_title()) ?>">
					<?php the_title(); ?>
					</a></h1>
				<div style="clear: both;"></div>

				<?php if (get_option('tidalforce_page_thumbnails') == 'on') { ?>

					<?php $thumb = '';

					$width = (int) get_option('tidalforce_thumbnail_width_pages');
					$height = (int) get_option('tidalforce_thumbnail_height_pages');
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

				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','TidalForce').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(esc_html__('Edit this page','TidalForce')); ?>

			</div>
			<img src="<?php echo get_template_directory_uri(); ?>/images/content-white-bottom.gif" alt="bottom" style="margin-bottom: 7px; float: left;" />
			<!--End Post Single-->

			<?php if (get_option('tidalforce_show_pagescomments') == 'on') { ?>
				<!--Begin Comments Template-->
				<div class="recentposts">
					<?php comments_template('', true); ?>
				</div>
				<!--End Comments Template-->
			<?php }; ?>
		<?php endwhile; endif; ?>
		</div>
	</div>
	<!--Begin Sidebar-->
	<?php get_sidebar(); ?>
	<!--End Sidebar-->

</div>
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>