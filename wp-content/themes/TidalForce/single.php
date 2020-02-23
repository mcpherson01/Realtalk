<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<!--Begin Post Single-->
			<div class="post-wrapper">

				<?php if (get_option('tidalforce_integration_single_top') <> '' && get_option('tidalforce_integrate_singletop_enable') == 'on') echo(get_option('tidalforce_integration_single_top')); ?>

				<?php if (get_option('tidalforce_show_share') == 'on') get_template_part('includes/share');  ?>

				<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','TidalForce'), the_title()) ?>">
					<?php the_title(); ?>
					</a></h1>

				<?php if (get_option('tidalforce_postinfo2') ) { ?>
					<div class="post-info"><?php esc_html_e('Posted','TidalForce'); ?> <?php if (in_array('author', get_option('tidalforce_postinfo2'))) { ?> <?php esc_html_e('by','TidalForce'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('tidalforce_postinfo2'))) { ?> <?php esc_html_e('on','TidalForce'); ?> <?php the_time(get_option('tidalforce_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('tidalforce_postinfo2'))) { ?> <?php esc_html_e('in','TidalForce'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('tidalforce_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','TidalForce'), esc_html__('1 comment','TidalForce'), '% '.esc_html__('comments','TidalForce')); ?><?php }; ?>
					</div>
				<?php }; ?>

				<div style="clear: both;"></div>

				<?php if (get_option('tidalforce_thumbnails') == 'on') { ?>

					<?php $thumb = '';

					$width = (int) get_option('tidalforce_thumbnail_width_posts');
					$height = (int) get_option('tidalforce_thumbnail_height_posts');
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

				<?php if (get_option('tidalforce_integration_single_bottom') <> '' && get_option('tidalforce_integrate_singlebottom_enable') == 'on') echo(get_option('tidalforce_integration_single_bottom')); ?>

				<?php if (get_option('tidalforce_468_enable') == 'on') { ?>
					<?php if(get_option('tidalforce_468_adsense') <> '') echo(get_option('tidalforce_468_adsense'));
					else { ?>
						<a href="<?php echo(get_option('tidalforce_468_url')); ?>"><img src="<?php echo esc_attr(get_option('tidalforce_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
					<?php } ?>
				<?php } ?>

			</div> <!-- end .post-wrapper  -->
			<img src="<?php echo get_template_directory_uri(); ?>/images/content-white-bottom.gif" alt="bottom" style="margin-bottom: 7px; float: left;" />
			<!--End Post Single-->

			<?php if (get_option('tidalforce_show_postcomments') == 'on') { ?>
				<!--Begin Comments Template-->
				<div class="recentposts">
					<?php comments_template('', true); ?>
				</div>
				<!--End Comments Template-->
				<img src="<?php echo get_template_directory_uri(); ?>/images/content-blue-bottom.gif" alt="bottom" style="float: left;" />
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