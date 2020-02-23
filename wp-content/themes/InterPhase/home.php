<?php get_header(); ?>

	<div id="container">
		<div id="left-div">
			<div id="left-inside">
				<div class="home-post-wrap">

					<?php $fullwidth = false;
					      if (get_option('interphase_show_popular') == 'false' && get_option('interphase_show_randomposts') == 'false') $fullwidth=true; ?>

					<!--Begins recent posts section of the homepage-->
					<div id="home-left"<?php if($fullwidth) echo(' style="width: 593px;"'); ?>>
						<span class="orange-titles"><?php esc_html_e('recent posts','InterPhase'); ?></span>
						<!--Begin recent post (single)-->
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php $thumb = '';
								  $width = 120;
								  $height = 120;
								  $classtext = '';
								  $titletext = get_the_title();

								  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
								  $thumb = $thumbnail["thumb"]; ?>

							<h2 class="titles">
								<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','InterPhase'), get_the_title()) ?>">
									<?php truncate_title(30); ?>
								</a>
							</h2>

							<?php if($thumb != '') { ?>
								<div class="thumbnail-div">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
								</div>
							<?php } ?>

							<div class="post-inside"<?php if ($fullwidth && ($thumb <> '')) echo(' style="width: 76%;"'); elseif ($thumb == '') echo(' style="width: 100%;"'); ?>>
								<?php if (get_option('interphase_postinfo_homedefault') ) { ?>
									<span class="post-info">
										<?php esc_html_e('Posted','InterPhase'); ?> <?php if (in_array('author', get_option('interphase_postinfo_homedefault'))) { ?> <?php esc_html_e('by','InterPhase'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('interphase_postinfo_homedefault'))) { ?> <?php esc_html_e('on','InterPhase'); ?> <?php the_time(get_option('interphase_date_format')) ?><?php }; ?>
									</span>
								<?php }; ?>
								<div style="clear: both;"></div>

								<?php truncate_post(245); ?>
							</div>
							<div style="clear:both;"></div>

						<?php endwhile; ?>
						<!--end recent post (single)-->
					</div> <!-- #home-left -->

					<?php if (!$fullwidth) { ?>
						<!--The following displays the popular/random posts on homepage-->
						<div id="home-right">

							<?php if (get_option('interphase_show_popular') == 'on') { ?>
								<span class="orange-titles"><?php esc_html_e('popular posts','InterPhase'); ?></span>
								<div style="clear: both;"></div>

								<ul>
									<?php $popular_num = (int) get_option('interphase_popular_num');
									$result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $popular_num");
									foreach ($result as $post) {
										#setup_postdata($post);
										$postid = (int) $post->ID;
										$title = $post->post_title;
										$commentcount = (int) $post->comment_count;
										if ($commentcount != 0) { ?>
											<li><a href="<?php echo esc_url(get_permalink($postid)); ?>" title="<?php echo esc_attr($title); ?>">
											<?php echo esc_html($title); ?></a> (<?php echo esc_html($commentcount); ?>)</li>
										<?php }
									} ?>
								</ul>

								<div style="clear: both;"></div>
							<?php }; ?>

							<?php if (get_option('interphase_show_randomposts') == 'on') { ?>
								<span class="orange-titles"><?php esc_html_e('random posts','InterPhase'); ?></span>
								<div style="clear: both;"></div>

								<ul>
									<?php $my_query = new WP_Query('ignore_sticky_posts=1&orderby=rand&posts_per_page='.get_option('interphase_random_num'));
										  while ($my_query->have_posts()) : $my_query->the_post(); ?>
												<li>
													<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','InterPhase'), get_the_title()) ?>">
														<?php truncate_title(50); ?>
													</a>
												</li>
										  <?php endwhile; ?>
								</ul>
							<?php }; ?>

						</div> <!-- end #home-right -->
						<!--end random/popular posts-->
					<?php }; ?>

				</div> <!-- #home-post-wrap -->

				<?php else : ?>
					<?php get_template_part('includes/no-results'); ?>
				<?php endif; ?>

				<?php global $cat_option; ?>
				<?php if (get_option('interphase_show_catboxes') == 'on') { ?>
					<!--The following code controls the category boxes-->
					<!--Category Box 1-->
					<?php $cat_option='interphase_home_cat_one'; ?>
					<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
						  while (have_posts()) : the_post(); ?>
							  <?php get_template_part('includes/category_box'); ?>
					<?php endwhile; wp_reset_query(); ?>
					<!--End Category Box 1-->

					<!--Category Box 2-->
					<?php $cat_option='interphase_home_cat_two'; ?>
					<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
						  while (have_posts()) : the_post(); ?>
							  <?php get_template_part('includes/category_box'); ?>
					<?php endwhile; wp_reset_query(); ?>
					<!--End Category Box 2-->

					<div style="clear: both;"></div>

					<!--Category Box 3-->
					<?php $cat_option='interphase_home_cat_three'; ?>
					<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
						  while (have_posts()) : the_post(); ?>
							  <?php get_template_part('includes/category_box'); ?>
					<?php endwhile; wp_reset_query(); ?>
					<!--Category Box 3-->

					<!--Category Box 4-->
					<?php $cat_option='interphase_home_cat_four'; ?>
					<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
						  while (have_posts()) : the_post(); ?>
							  <?php get_template_part('includes/category_box'); ?>
					<?php endwhile; wp_reset_query(); ?>
					<!--Category Box 4-->
					<!--End category boxes-->

					<div style="clear: both;"></div>
				<?php }; ?>


				<?php if (get_option('interphase_show_recentcomments') == 'on') { ?>
					<!--Recent Comments-->
					<div class="home-categories-comments">
						<span class="orange-titles"><?php esc_html_e('recent comments','InterPhase'); ?></span>
						<?php get_template_part('simple_recent_comments'); /* recent comments plugin by: www.g-loaded.eu */?>
						<?php $recent_commentsnum = get_option('interphase_recent_comments');
						if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments($recent_commentsnum, 60, '', ''); } ?>
					</div>
					<!--End Recent Comments-->
				<?php }; ?>

				<?php if (get_option('interphase_show_flickr') == 'on') { ?>
					<!--Flickr Photos-->
					<div class="home-categories">
						<span class="orange-titles"><?php esc_html_e('recent flickr photos','InterPhase'); ?></span>
						<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=9&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo(get_option('interphase_flickr')); ?>"></script>
					</div>
					<!--End Flickr Photos-->
				<?php }; ?>

			</div> <!-- #left-inside -->
		</div> <!-- #left-div -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>