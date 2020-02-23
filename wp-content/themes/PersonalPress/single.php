<?php get_header(); ?>
		<div id="main">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="entry-wrap post">
				<div class="entry">
					<?php if (get_option('personalpress_integration_single_top') <> '' && get_option('personalpress_integrate_singletop_enable') == 'on') echo(get_option('personalpress_integration_single_top')); ?>

					<h1 class="title"><?php the_title(); ?></h1>
					<?php if (get_option('personalpress_postinfo2') ) { ?>
						<?php if ( in_array('author', get_option('personalpress_postinfo2')) || in_array('comments', get_option('personalpress_postinfo2')) || in_array('categories', get_option('personalpress_postinfo2')) ) { ?>
							<div class="post-meta clearfix">
								<?php if ( in_array('author', get_option('personalpress_postinfo2')) ) { ?>
									<span class="meta-info author">
										<span class="right-sep">
											<?php the_author_posts_link(); ?>
										</span>
									</span>
								<?php }; ?>

								<?php if ( in_array('comments', get_option('personalpress_postinfo2')) ) { ?>
									<span class="meta-info comments-number">
										<span class="right-sep">
											<?php comments_popup_link(esc_html__('0 comments','PersonalPress'), esc_html__('1 comment','PersonalPress'), '% '.esc_html__('comments','PersonalPress')); ?>
										</span>
									</span>
								<?php }; ?>

								<?php if ( in_array('categories', get_option('personalpress_postinfo2')) ) { ?>
									<span class="meta-info categories">
										<span class="right-sep">
											<?php the_category(', ') ?>
										</span>
									</span>
								<?php }; ?>
							</div> <!-- end .post-meta -->
						<?php }; ?>
					<?php }; ?>

					<?php if (get_option('personalpress_postinfo2') ) { ?>
						<?php if ( in_array('date', get_option('personalpress_postinfo2')) ) { ?>
							<p class="date">
								<span class="month"><?php the_time('M'); ?></span>
								<span class="day"><?php the_time('d'); ?></span>
							</p>
						<?php }; ?>
					<?php }; ?>

					<div class="entry-content clearfix post">

						<?php $thumb = '';
							  $width = 175;
							  $height = 175;
							  $classtext = '';
							  $titletext = get_the_title();

							  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							  $thumb = $thumbnail["thumb"]; ?>

						<?php if($thumb <> '' && get_option('personalpress_thumbnails') == 'on') { ?>
							<div class="thumb">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>

								<span class="overlay"></span>
							</div> <!-- end .thumb -->
						<?php }; ?>

						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','PersonalPress').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php edit_post_link(esc_html__('Edit this page','PersonalPress')); ?>

						<?php if (get_option('personalpress_integration_single_bottom') <> '' && get_option('personalpress_integrate_singlebottom_enable') == 'on') echo(get_option('personalpress_integration_single_bottom')); ?>
						<?php if (get_option('personalpress_468_enable') == 'on') { ?>
							<?php if(get_option('personalpress_468_adsense') <> '') echo(get_option('personalpress_468_adsense'));
							else { ?>
								<a href="<?php echo esc_url(get_option('personalpress_468_url')); ?>"><img src="<?php echo esc_attr(get_option('personalpress_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
							<?php } ?>
						<?php } ?>

					</div> <!-- end .entry-content -->

					<div class="entry-bottom"></div>

				</div> <!-- end .entry -->
			</div> <!-- end .entry-wrap -->

			<?php if (get_option('personalpress_show_postcomments') == 'on') comments_template('', true); ?>
		<?php endwhile; endif; ?>
		</div> <!-- end #main -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>