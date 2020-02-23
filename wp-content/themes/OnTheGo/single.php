<?php get_header(); ?>

	<div id="main-content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php if (get_option('onthego_integration_single_top') <> '' && get_option('onthego_integrate_singletop_enable') == 'on') echo(get_option('onthego_integration_single_top')); ?>
				<div class="entry category clearfix">

					<h1 id="post-title"><span><?php the_title(); ?></span></h1>

					<?php if (get_option('onthego_postinfo2') ) get_template_part( 'includes/postinfo'); ?>

					<?php if (get_option('onthego_thumbnails') == 'on') { ?>
						<?php $thumb = '';

     					      $width = (int) get_option('onthego_thumbnail_width_posts');
							  $height = (int) get_option('onthego_thumbnail_height_posts');
							  $classtext = 'thumbnail-post alignleft';
							  $titletext = get_the_title();

							  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							  $thumb = $thumbnail["thumb"]; ?>

						<?php if($thumb <> '') print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>

					<?php }; ?>

					<?php the_content(); ?>

					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','OnTheGo').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

					<?php edit_post_link(esc_html__('Edit this page','OnTheGo')); ?>

				</div> <!-- end .entry -->

				<?php if (get_option('onthego_integration_single_bottom') <> '' && get_option('onthego_integrate_singlebottom_enable') == 'on') echo(get_option('onthego_integration_single_bottom')); ?>
				<?php if (get_option('onthego_468_enable') == 'on') { ?>
					<?php if(get_option('onthego_468_adsense') <> '') echo(get_option('onthego_468_adsense'));
					else { ?>
						<a href="<?php echo esc_url(get_option('onthego_468_url')); ?>"><img src="<?php echo esc_attr(get_option('onthego_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
					<?php } ?>
				<?php } ?>

				<?php if (get_option('onthego_show_postcomments') == 'on') comments_template('', true); ?>
		<?php endwhile; endif; ?>
	</div> <!-- #main-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>