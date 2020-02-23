<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<!--Begin Article Single-->
			<div class="post-wrapper">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php if (get_option('earthlytouch_integration_single_top') <> '' && get_option('earthlytouch_integrate_singletop_enable') == 'on') echo(get_option('earthlytouch_integration_single_top')); ?>

				<h1 class="post-title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','EarthlyTouch'), the_title()) ?>">
						<?php the_title(); ?>
					</a>
				</h1>

				<?php if (get_option('earthlytouch_postinfo2') ) { ?>
					<div class="articleinfo"><?php esc_html_e('Posted','EarthlyTouch'); ?> <?php if (in_array('author', get_option('earthlytouch_postinfo2'))) { ?> <?php esc_html_e('by','EarthlyTouch'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('earthlytouch_postinfo2'))) { ?> <?php esc_html_e('on','EarthlyTouch'); ?> <?php the_time(get_option('earthlytouch_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('earthlytouch_postinfo2'))) { ?> <?php esc_html_e('in','EarthlyTouch'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('earthlytouch_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','EarthlyTouch'), esc_html__('1 comment','EarthlyTouch'), '% '.esc_html__('comments','EarthlyTouch')); ?><?php }; ?></div>
				<?php }; ?>
				<div style="clear: both;"></div>

				<?php if (get_option('earthlytouch_thumbnails') == 'on') { ?>

					<?php $thumb = '';

					$width = (int) get_option('earthlytouch_thumbnail_width_posts');
					$height = (int) get_option('earthlytouch_thumbnail_height_posts');
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

				<?php if (get_option('earthlytouch_integration_single_bottom') <> '' && get_option('earthlytouch_integrate_singlebottom_enable') == 'on') echo(get_option('earthlytouch_integration_single_bottom')); ?>

				<?php if (get_option('earthlytouch_468_enable') == 'on') { ?>
					<?php if(get_option('earthlytouch_468_adsense') <> '') echo(get_option('earthlytouch_468_adsense'));
					else { ?>
						<a href="<?php echo esc_url(get_option('earthlytouch_468_url')); ?>"><img src="<?php echo esc_attr(get_option('earthlytouch_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
					<?php } ?>
				<?php } ?>

				<?php if (get_option('earthlytouch_show_postcomments') == 'on') { ?>
					<!--Begin Comments Template-->
					<?php comments_template('',true); ?>
					<!--End Comments Template-->
				<?php }; ?>
			<?php endwhile; endif; ?>
			</div> <!-- end .post-wrapper -->

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