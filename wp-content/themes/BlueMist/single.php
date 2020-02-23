<?php get_header(); ?>

<div id="container">
	<div id="container2">
		<div id="left-div">
				<div class="post-wrapper">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php if (get_option('bluemist_integration_single_top') <> '' && get_option('bluemist_integrate_singletop_enable') == 'on') echo(get_option('bluemist_integration_single_top')); ?>

					<h1 class="titles2">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','BlueMist'), the_title()) ?>">
							<?php the_title(); ?>
						</a>
					</h1>

					<?php if (get_option('bluemist_postinfo2') ) { ?>
						<div class="articleinfo"><img src="<?php echo get_template_directory_uri(); ?>/images/icon1.gif" alt="icon1" /><?php esc_html_e('Posted','BlueMist'); ?> <?php if (in_array('author', get_option('bluemist_postinfo2'))) { ?> <?php esc_html_e('by','BlueMist'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('bluemist_postinfo2'))) { ?> <?php esc_html_e('on','BlueMist'); ?> <?php the_time(get_option('bluemist_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('bluemist_postinfo2'))) { ?> <?php esc_html_e('in','BlueMist'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('bluemist_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','BlueMist'), esc_html__('1 comment','BlueMist'), '% '.esc_html__('comments','BlueMist')); ?><?php }; ?>
						</div>
					<?php }; ?>
					<div style="clear: both;"></div>

					<?php if (get_option('bluemist_thumbnails') == 'on') { ?>

						<?php $thumb = '';

						$width = (int) get_option('bluemist_thumbnail_width_posts');
						$height = (int) get_option('bluemist_thumbnail_height_posts');
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

					<?php if (get_option('bluemist_integration_single_bottom') <> '' && get_option('bluemist_integrate_singlebottom_enable') == 'on') echo(get_option('bluemist_integration_single_bottom')); ?>

					<?php if (get_option('bluemist_468_enable') == 'on') { ?>
						<?php if(get_option('bluemist_468_adsense') <> '') echo(get_option('bluemist_468_adsense'));
						else { ?>
							<a href="<?php echo esc_url(get_option('bluemist_468_url')); ?>"><img src="<?php echo esc_url(get_option('bluemist_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
						<?php } ?>
					<?php } ?>

				</div> <!-- end .post-wrapper -->

				<?php if (get_option('bluemist_show_postcomments') == 'on') { ?>
					<?php comments_template('',true); ?>
				<?php };?>
			<?php endwhile; endif; ?>
		</div> <!-- end #left-div -->
	</div> <!-- end #container2 -->
	<?php get_sidebar(); ?>
</div> <!-- end #container -->
<?php get_footer(); ?>
</body>
</html>