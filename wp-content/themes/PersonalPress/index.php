<?php get_header(); ?>
	<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php $thumb = '';

				  $width = 175;
				  $height = 175;
				  $classtext = '';
				  $titletext = get_the_title();

				  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				  $thumb = $thumbnail["thumb"]; ?>

			<?php global $post;
				  $page_result = is_search() && ($post->post_type == 'page') ? true : false; ?>

			<div class="entry-wrap<?php if ($page_result) echo(' page_result'); ?>">
				<div class="entry">
					<h2 class="title"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s', 'PersonalPress'), $titletext) ?>"><?php the_title(); ?></a></h2>

					<?php if (get_option('personalpress_postinfo1') ) { ?>
						<?php if ( in_array('date', get_option('personalpress_postinfo1')) ) { ?>
							<p class="date">
								<span class="month"><?php the_time('M'); ?></span>
								<span class="day"><?php the_time('d'); ?></span>
							</p>
						<?php }; ?>
					<?php }; ?>

					<div class="entry-content clearfix">
						<?php if($thumb <> '' && get_option('personalpress_thumbnails_index') == 'on') { ?>
							<div class="thumb">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>

								<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s', 'PersonalPress'), $titletext) ?>"><span class="overlay"></span></a>
							</div> <!-- end .thumb -->
						<?php }; ?>

						<?php if (get_option('personalpress_blog_style') == 'on') the_content(""); else { ?>
							<p><?php truncate_post(370); ?></p>
						<?php }; ?>

						<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s', 'PersonalPress'), $titletext) ?>" class="readmore"><span><?php esc_html_e('Read More','PersonalPress'); ?></span></a>
					</div> <!-- end .entry-content -->

					<div class="post-meta-top"></div>

					<div class="post-meta clearfix">
					<?php if (get_option('personalpress_postinfo1') ) { ?>
						<?php if ( in_array('author', get_option('personalpress_postinfo1')) || in_array('comments', get_option('personalpress_postinfo1')) || in_array('categories', get_option('personalpress_postinfo1')) ) { ?>

								<?php if ( in_array('author', get_option('personalpress_postinfo1')) ) { ?>
									<span class="meta-info author">
										<span class="right-sep">
											<?php the_author_posts_link(); ?>
										</span>
									</span>
								<?php }; ?>

								<?php if ( in_array('comments', get_option('personalpress_postinfo1')) ) { ?>
									<span class="meta-info comments-number">
										<span class="right-sep">
											<?php comments_popup_link(esc_html__('0 comments','PersonalPress'), esc_html__('1 comment','PersonalPress'), '% '.esc_html__('comments','PersonalPress')); ?>
										</span>
									</span>
								<?php }; ?>

								<?php if ( in_array('categories', get_option('personalpress_postinfo1')) ) { ?>
									<span class="meta-info categories">
										<span class="right-sep">
											<?php the_category(', ') ?>
										</span>
									</span>
								<?php }; ?>

						<?php }; ?>
					<?php }; ?>
					</div> <!-- end .post-meta -->

				</div> <!-- end .entry -->
			</div> <!-- end .entry-wrap -->

		<?php endwhile; ?>

			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
				else { ?>
					<?php get_template_part('includes/navigation'); ?>
			<?php } ?>

		<?php else : ?>
			<?php get_template_part('includes/no-results'); ?>
		<?php endif; ?>

	</div> <!-- end #main -->

	<?php get_sidebar(); ?>

	<?php get_footer(); ?>