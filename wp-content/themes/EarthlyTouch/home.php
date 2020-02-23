<?php get_header(); ?>
<div id="container">

	<div id="left-div">
		<div id="left-inside">
			<?php if (get_option('earthlytouch_featured') == 'on') get_template_part('includes/featured'); ?>

			<?php if (get_option('earthlytouch_show_recent_comments') == 'on') { ?>
				<div class="home-squares">
					<div class="home-headings"><?php esc_html_e('Recent Comments','EarthlyTouch'); ?></div>
					<div class="recent-comments">
						<?php $recentCommentsNum = (int) get_option('earthlytouch_recentcomments_num'); ?>
						<?php get_template_part('simple_recent_comments'); /* recent comments plugin by: www.g-loaded.eu */?>
						<?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments($recentCommentsNum, 60, '', ''); } ?>
					</div> <!-- end .recent-comments -->
				</div> <!-- end .home-squares -->
			<?php }; ?>

			<?php if (get_option('earthlytouch_show_random_posts') == 'on') { ?>
				<div class="home-squares">
					<div class="home-headings"><?php esc_html_e('Random Articles','EarthlyTouch'); ?></div>
					<?php $randomArticlesNum = (int) get_option('earthlytouch_randomposts_num');
					query_posts("orderby=rand&posts_per_page=$randomArticlesNum&ignore_sticky_posts=1");
					while (have_posts()) : the_post(); ?>
						<div class="random">
							<?php $width = 70;
							$height = 80;
							$classtext = 'no-border';
							$titletext = get_the_title();

							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							$thumb = $thumbnail["thumb"]; ?>

							<?php if($thumb != '') { ?>
								<div class="random-image">
									<a href="<?php the_permalink() ?>">
										<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
									</a>
								</div>
							<?php }; ?>

							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','EarthlyTouch'), the_title()) ?>">
								<?php truncate_title(25); ?>
							</a>
							<?php truncate_post(80); ?>
						</div> <!-- end .random -->
					<?php endwhile; wp_reset_query(); ?>
				</div> <!-- end .home-squares -->
			<?php }; ?>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/entry'); ?>
			<?php endwhile; ?>
				<div style="clear: both;"></div>
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
				else { ?>
				     <?php get_template_part('includes/navigation'); ?>
				<?php } ?>
			<?php else : ?>
				<?php get_template_part('includes/no-results'); ?>
			<?php endif; ?>
		</div> <!-- end #left-inside -->
	</div> <!-- end #left-div -->

	<!--Begin Sidebar-->
	<?php get_sidebar(); ?>
	<!--End Sidebar-->

</div> <!-- end #container -->

<?php get_footer(); ?>

</body>
</html>