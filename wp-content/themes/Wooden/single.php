<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div class="post-wrapper clearfix">
				<?php if (get_option('wooden_integration_single_top') <> '' && get_option('wooden_integrate_singletop_enable') == 'on') echo(get_option('wooden_integration_single_top')); ?>

				<?php get_template_part('includes/postinfo'); ?>
				<?php if (get_option('wooden_show_share') == 'on') get_template_part('includes/share');  ?>

				<h1 class="titles2">
					<a href="<?php the_permalink() ?>" rel="bookmark">
						<?php the_title(); ?>
					</a>
				</h1>
				<div style="clear: both;"></div>

				<?php if (get_option('wooden_thumbnails') == 'on') { ?>

					<?php $thumb = '';

					$width = 111;
					$height = 111;
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
				<div style="clear: both; margin-bottom: 20px;"></div>

				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Wooden').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(esc_html__('Edit this page','Wooden')); ?>

				<?php if (get_option('wooden_integration_single_bottom') <> '' && get_option('wooden_integrate_singlebottom_enable') == 'on') echo(get_option('wooden_integration_single_bottom')); ?>

				<?php if (get_option('wooden_468_enable') == 'on') { ?>
					<?php if(get_option('wooden_468_adsense') <> '') echo(get_option('wooden_468_adsense'));
					else { ?>
						<a href="<?php echo esc_url(get_option('wooden_468_url')); ?>"><img src="<?php echo esc_attr(get_option('wooden_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
					<?php } ?>
				<?php } ?>

				<?php if (get_option('wooden_show_postcomments') == 'on') comments_template('', true); ?>

			</div> <!-- end .post-wrapper -->
		<?php endwhile; endif; ?>
		</div> <!-- end .left-inside -->
	</div> <!-- end .left-div -->

	<!--Begin Sidebar-->
	<?php get_sidebar(); ?>
	<!--End Sidebar-->

</div> <!-- end #container -->

<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>