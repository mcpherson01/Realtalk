<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if (get_option('influx_integration_single_top') <> '' && get_option('influx_integrate_singletop_enable') == 'on') echo(get_option('influx_integration_single_top')); ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<!--Begin Post-->
			<div class="post-wrapper">
				<?php get_template_part('includes/share'); ?>

				<?php if (get_option('influx_thumbnails') == 'on') { ?>
					<?php $thumb = '';
						  $width = 80;
						  $height = 80;
						  $classtext = 'no_border';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
						  $thumb = $thumbnail["thumb"];

						  if($thumb != '') { ?>
								<div class="thumbnail-div-2">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
								</div>
						  <?php }; ?>
				<?php }; ?>

				<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Influx'), get_the_title()) ?>">
					<?php the_title(); ?></a></h1>

				<?php get_template_part('includes/postinfo'); ?>
				<div style="clear: both;"></div>

					<?php the_content(); ?>
					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Influx').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','Influx')); ?>

					<?php if (get_option('influx_integration_single_bottom') <> '' && get_option('influx_integrate_singlebottom_enable') == 'on') echo(get_option('influx_integration_single_bottom')); ?>

					<?php if (get_option('influx_468_enable') == 'on') { ?>
						<div style="clear: both;"></div>
						<?php if(get_option('influx_468_adsense') <> '') echo(get_option('influx_468_adsense'));
						else { ?>
							<a href="<?php echo esc_url(get_option('influx_468_url')); ?>" class="foursixeight_link"><img src="<?php echo esc_attr(get_option('influx_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
						<?php } ?>
					<?php } ?>

				<div style="clear: both; margin-top: 10px;"></div>
			</div>

			<?php if (get_option('influx_show_postcomments') == 'on') { ?>
				<div class="post-wrapper" style="margin-top: 10px;">
					<?php comments_template('',true); ?>
				</div>
			<?php }; ?>
		<?php endwhile; endif; ?>
		</div>
	</div>
<!--Begin Sidebar-->
<?php get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>