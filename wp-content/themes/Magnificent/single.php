<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php get_template_part('includes/breadcrumbs'); ?>

<?php if (get_option('magnificent_integration_single_top') <> '' && get_option('magnificent_integrate_singletop_enable') == 'on') echo(get_option('magnificent_integration_single_top')); ?>

	<div id="entries">
		<div class="entry post entry-full">
			<div class="border">
				<div class="bottom">
					<div class="entry-content clearfix nobottom">
						<h1 class="title"><?php the_title(); ?></h1>
						<p class="meta-info"><?php the_time(get_option('magnificent_date_format')) ?> <span><?php esc_html_e('by','Magnificent'); ?></span> <?php the_author_posts_link(); ?></p>

						<?php if (get_option('magnificent_thumbnails') == 'on') { ?>

							<?php $thumb = '';
							$width = 218;
							$height = 218;
							$classtext = '';
							$titletext = get_the_title();

							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							$thumb = $thumbnail["thumb"]; ?>

							<?php if($thumb <> '') { ?>
								<div class="thumbnail">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
									<span class="overlay"></span>
								</div> 	<!-- end .thumbnail -->
							<?php }; ?>

						<?php }; ?>

						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Magnificent').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php edit_post_link(esc_html__('Edit this page','Magnificent')); ?>

						<div class="clear"></div>

						<div class="info-panel clearfix">
							<?php get_template_part('includes/infopanel'); ?>
						</div> <!-- end .info-panel -->

					</div> <!-- end .entry-content -->
				</div> <!-- end .bottom -->
			</div> <!-- end .border -->
		</div> <!-- end .entry -->

		<div class="clear"></div>

		<?php if (get_option('magnificent_integration_single_bottom') <> '' && get_option('magnificent_integrate_singlebottom_enable') == 'on') echo(get_option('magnificent_integration_single_bottom')); ?>

		<?php if (get_option('magnificent_468_enable') == 'on') { ?>
			<?php if(get_option('magnificent_468_adsense') <> '') echo(get_option('magnificent_468_adsense'));
			else { ?>
				<a href="<?php echo esc_url(get_option('magnificent_468_url')); ?>"><img src="<?php echo esc_attr(get_option('magnificent_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
			<?php } ?>
		<?php } ?>

		<?php if (get_option('magnificent_show_postcomments') == 'on') comments_template('', true); ?>

	</div> <!-- end #entries -->

<?php endwhile; endif; ?>

	<div id="sidebar-right" class="sidebar">
		<div class="block">
			<div class="block-border">
				<div class="block-content">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Right Top') ) : ?>
					<?php endif; ?>
				</div> <!-- end .block-content -->
			</div> <!-- end .block-border -->
		</div> <!-- end .block -->

		<div class="block">
			<div class="block-border">
				<div class="block-content">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Right Bottom') ) : ?>
					<?php endif; ?>
				</div> <!-- end .block-content -->
			</div> <!-- end .block-border -->
		</div> <!-- end .block -->
	</div> <!-- end #sidebar-right -->

<?php get_footer(); ?>