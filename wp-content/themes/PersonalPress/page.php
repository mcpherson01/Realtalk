<?php get_header(); ?>
		<div id="main">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="entry-wrap post">
				<div class="entry">

					<h1 class="title page"><?php the_title(); ?></h1>

					<div class="entry-content clearfix post">

						<?php $thumb = '';
							  $width = 175;
							  $height = 175;
							  $classtext = '';
							  $titletext = get_the_title();

							  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							  $thumb = $thumbnail["thumb"]; ?>

						<?php if($thumb <> '' && get_option('personalpress_page_thumbnails') == 'on') { ?>
							<div class="thumb">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>

								<span class="overlay"></span>
							</div> <!-- end .thumb -->
						<?php }; ?>

						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','PersonalPress').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php edit_post_link(esc_html__('Edit this page','PersonalPress')); ?>

					</div> <!-- end .entry-content -->

					<div class="entry-bottom"></div>

				</div> <!-- end .entry -->
			</div> <!-- end .entry-wrap -->

			<?php if (get_option('personalpress_show_pagescomments') == 'on') comments_template('', true); ?>
		<?php endwhile; endif; ?>
		</div> <!-- end #main -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>