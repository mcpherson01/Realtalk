<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<div class="post-wrapper">
					<?php if (get_option('interphase_show_share') == 'on') get_template_part('includes/share'); ?>

					<?php if (get_option('interphase_thumbnails') == 'on') { ?>
						<?php $thumb = '';
							  $width = 120;
							  $height = 120;
							  $classtext = '';
							  $titletext = get_the_title();

							  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
							  $thumb = $thumbnail["thumb"];

							  if($thumb != '') { ?>
									<div class="thumbnail-div">
										<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
									</div>
							  <?php }; ?>
					<?php }; ?>

					<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','InterPhase'), get_the_title()) ?>">
						<?php the_title(); ?></a></h1>

					<?php get_template_part('includes/postinfo'); ?>

					<?php the_content(); ?>
					<div style="clear: both;"></div>

					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','InterPhase').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','InterPhase')); ?>

					<?php if (get_option('interphase_integration_single_bottom') <> '' && get_option('interphase_integrate_singlebottom_enable') == 'on') echo(get_option('interphase_integration_single_bottom')); ?>

					<div style="clear: both;"></div>

					<?php if (get_option('interphase_468_enable') == 'on') { ?>
						<div style="clear: both;"></div>
						<?php if(get_option('interphase_468_adsense') <> '') echo(get_option('interphase_468_adsense'));
						else { ?>
							<a href="<?php echo esc_url(get_option('interphase_468_url')); ?>" class="foursixeight_link"><img src="<?php echo esc_attr(get_option('interphase_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
						<?php } ?>
					<?php } ?>

					<div style="clear: both;"></div>

					<?php if (get_option('interphase_show_postcomments') == 'on') { ?>
						<?php comments_template('',true); ?>
					<?php }; ?>

				</div> <!-- #post-wrapper -->
			<?php endwhile; endif; ?>
		</div> <!-- #left-inside -->
	</div> <!-- #left-div -->
<!--Begin Sidebar-->
<?php get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>