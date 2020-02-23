<?php get_header(); ?>

<div id="container">
	<div id="container2">
		<div id="left-div">
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<div class="post-wrapper">
					<div style="float: left; margin-left: -71px;" class="ie6float">
						<?php if (get_option('bluesky_additional_date') == 'on') { ?>
							<div class="date">
								<span class="month">
									<?php the_time('M') ?>
								</span>
								<span class="day">
									<?php the_time('j') ?>
								</span>
							</div> <!-- end .date -->
						<?php } else { ?>
							<div class="date" style="background: none;">
							</div>
						<?php }; ?>

						<div style="float: left; width: 570px; clear: right; margin-top: 3px; margin-bottom: 0px; padding-top: 10px;  margin-left: 5px;" class="iehack">
							<h2 class="h1-link">
								<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Bluesky'), get_the_title()) ?>">
									<?php the_title(); ?>
								</a>
							</h2>

							<?php if (get_option('bluesky_postinfo1') ) { ?>
								<div class="articleinfo"><?php esc_html_e('Posted','Bluesky'); ?> <?php if (in_array('author', get_option('bluesky_postinfo1'))) { ?> <?php esc_html_e('by','Bluesky'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('bluesky_postinfo1'))) { ?> <?php esc_html_e('on','Bluesky'); ?> <?php the_time(get_option('bluesky_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('bluesky_postinfo1'))) { ?> <?php esc_html_e('in','Bluesky'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('bluesky_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','Bluesky'), esc_html__('1 comment','Bluesky'), '% '.esc_html__('comments','Bluesky')); ?><?php }; ?>
								</div>
							<?php }; ?>
							<div style="clear: both;"></div>
						</div> <!-- end .iehack -->

					</div> <!-- end .ie6float -->
					<div style="clear: both;"></div>

					<div class="post">
						<div style="clear: both;"></div>
						<div class="homepost-left">
							<?php $width = 94;
							$height = 94;
							$classtext = 'thumbnail-home';
							$titletext = get_the_title();

							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							$thumb = $thumbnail["thumb"]; ?>

							<?php if($thumb != '' && get_option('bluesky_thumbnails_index') == 'on') { ?>
								<div class="thumbnailwrap">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
								</div> <!-- end .thumbnailwrap -->
							<?php }; ?>

							<?php if (function_exists('Show_Dropdown')) Show_Dropdown(); ?>
						</div> <!-- end .homepost-left -->

						<div class="homepost-right">
							<?php if (get_option('bluesky_blog_style') == 'false') truncate_post(600);
							else the_content(); ?>
						</div> <!-- end .homepost-right -->
					</div> <!-- end .post -->
				</div> <!-- end .post-wrapper -->
			<?php endwhile; ?>
				<div style="clear: both;"></div>
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
				else { ?>
					 <?php get_template_part('includes/navigation'); ?>
				<?php } ?>
			<?php else : ?>
				<?php get_template_part('includes/no-results'); ?>
			<?php endif; ?>
		</div> <!-- end #left-div -->
	</div> <!-- end #container2 -->

	<?php get_sidebar(); ?>
</div> <!-- end #container -->
<?php get_footer(); ?>
</body>
</html>