<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if (get_option('tidalforce_show_home_tabarea') == 'on') { ?>
				<!--Begin Homepage Tabs Menu-->
				<ul class="idTabs">
					<?php if (get_option('tidalforce_show_tabarea_featured') == 'on') { ?>
						<li><a href="#featured"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-featured.gif" alt="icon" style="float: left; border: none; margin-top: 5px;" /><?php esc_html_e('Featured','TidalForce'); ?></a></li>
					<?php }; ?>
					<?php if (get_option('tidalforce_show_tabarea_popular') == 'on') { ?>
						<li><a href="#mostcomments"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-popular.gif" alt="icon" style="float: left; border: none; margin-top: 5px;" /><?php esc_html_e('Popular','TidalForce'); ?></a></li>
					<?php }; ?>
					<?php if (get_option('tidalforce_show_tabarea_recentcomments') == 'on') { ?>
						<li><a href="#recentcomments2"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-comments.gif" alt="icon" style="float: left; border: none; margin-top: 5px;" /><?php esc_html_e('Comments','TidalForce'); ?></a></li>
					<?php }; ?>
					<?php if (get_option('tidalforce_show_tabarea_recententries') == 'on') { ?>
						<li><a href="#recententries"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-recent.png" alt="icon" style="float: left; border: none; margin-top: 5px;" /><?php esc_html_e('Recent','TidalForce'); ?></a></li>
					<?php }; ?>
					<?php if (get_option('tidalforce_show_tabarea_randomarticles') == 'on') { ?>
						<li><a href="#randomarticles"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-random.gif" alt="icon" style="float: left; border: none; margin-top: 5px;" /><?php esc_html_e('Random','TidalForce'); ?></a></li>
					<?php }; ?>
				</ul>

				<?php if (get_option('tidalforce_show_tabarea_featured') == 'on') { ?>
					<!--Begin Featured Posts-->
					<div id="featured">
						<?php
							$width = 200;
							$height = 200;

							$featured_cat = get_option('tidalforce_feat_cat');
							$featured_num = 1;

							query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));

							$post_title = get_the_title();

							while (have_posts()) : the_post();

                     		$thumbnail = get_thumbnail($width,$height,'border-none',$post_title,$post_title,false,'Featured');
                     		$thumb = $thumbnail["thumb"]; ?>
								<?php if($thumb <> '') { ?>
									<div class="thumbnail-div-featured">
										<a href="<?php the_permalink() ?>">
											<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $post_title, $width, $height, 'border-none'); ?>
										</a>
									</div> <!-- end .thumbnail-div-featured -->
								<?php }; ?>

								<div id="featured-content">
									<h1 class="titles-featured">
										<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
									</h1>

									<div>
										<?php truncate_post(460); ?>
									</div>

									<div class="readmore">
										<a href="<?php the_permalink() ?>"><?php esc_html_e('Read More','TidalForce'); ?></a>
									</div>
								</div> <!-- end #featured-content -->
								<div style="clear: both;"></div>
							<?php endwhile; wp_reset_query(); ?>
					</div> <!-- end #featured -->
					<!--End Featured Posts-->
				<?php }; ?>


				<?php if (get_option('tidalforce_show_tabarea_recententries') == 'on') { ?>
					<!--Begin Recent Posts-->
					<?php $recentPostsNum = (int) get_option('tidalforce_recentposts_num'); ?>
					<div id="recententries">
						<span class="toptitle"><?php esc_html_e('Recent Posts','TidalForce'); ?></span>
						<ul>
							<?php wp_get_archives("title_li=&type=postbypost&limit=$recentPostsNum"); ?>
						</ul>
					</div>
					<!--End Recent Posts-->
				<?php }; ?>


				<?php if (get_option('tidalforce_show_tabarea_recentcomments') == 'on') { ?>
					<!--Begin Recent Comments-->
					<div id="recentcomments2">
						<span class="toptitle"><?php esc_html_e('Recent Comments','TidalForce'); ?></span>
						<?php get_template_part('simple_recent_comments'); /* recent comments plugin by: www.g-loaded.eu */ ?>
						<?php $recentCommentsNum = (int) get_option('tidalforce_recentcomments_num'); ?>
						<?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments($recentCommentsNum, 70, '', ''); } ?>
					</div>
					<!--End Recent Comments-->
				<?php }; ?>


				<?php if (get_option('tidalforce_show_tabarea_popular') == 'on') { ?>
					<!--Begin Most Comments-->
					<div id="mostcomments">
						<span class="toptitle"><?php esc_html_e('Popular Articles','TidalForce'); ?></span>
						<?php $popularNum = get_option('tidalforce_popular_posts_num'); ?>
						<ul class="list2">
							<?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $popularNum");
							foreach ($result as $post) {
								#setup_postdata($post);
								$postid = (int) $post->ID;
								$title = $post->post_title;
								$commentcount = (int) $post->comment_count;
								if ($commentcount != 0) { ?>
									<li><a href="<?php echo esc_url(get_permalink($postid)); ?>" title="<?php echo esc_attr($title); ?>">
									<?php echo esc_html($title); ?></a> (<?php echo esc_html($commentcount); ?>)</li>
							<?php } } ?>
						</ul>
					</div>
					<!--End Most Comments-->
				<?php }; ?>


				<?php if (get_option('tidalforce_show_tabarea_randomarticles') == 'on') { ?>
					<!--Begin Random Articles-->
					<div id="randomarticles">
						<span class="toptitle"><?php esc_html_e('Random Articles','TidalForce'); ?></span>
						<?php $randomPostsNum = (int) get_option('tidalforce_randomposts_num'); ?>
						<?php query_posts("orderby=rand&posts_per_page=$randomPostsNum");
						while (have_posts()) : the_post(); ?>
							<div class="random">
								<?php $width = 44;
								$height = 44;

								$post_title = get_the_title();

								$thumbnail = get_thumbnail($width,$height,'border-none',$post_title,$post_title,false,'Random');
								$thumb = $thumbnail["thumb"]; ?>

								<?php if ($thumb <> '' && get_option('tidalforce_thumbnails_index') == 'on') { ?>
									<div class="random-image">
										<a href="<?php the_permalink() ?>">
											<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $post_title, $width, $height, 'border-none'); ?>
										</a>
									</div>
								<?php }; ?>
								<div class="random-content">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','TidalForce'), the_title()) ?>">
										<?php truncate_title(50); ?>
									</a>
								</div>
							</div>
						<?php endwhile; wp_reset_query(); ?>
						<div style="clear: both;"></div>
					</div>
					<!--End Random Articles-->
				<?php }; ?>

				<img src="<?php echo get_template_directory_uri(); ?>/images/content-white-bottom.gif" alt="bottom" style="margin-bottom: 7px; float: left;" />

			<?php }; ?>

			<?php if (get_option('tidalforce_show_about_box') == 'on') { ?>
				<!--Begin About Us-->
				<div class="recentposts">
					<div class="abouttitle"><?php esc_html_e('About Us','TidalForce'); ?></div>
					<?php echo(get_option('tidalforce_abouttext')); ?>
				</div>
				<!--End About Us-->
				<img src="<?php echo get_template_directory_uri(); ?>/images/content-blue-bottom.gif" alt="bottom" style="margin-bottom: 7px; float: left;" />
			<?php }; ?>

			<div class="recentposts">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<div class="home-post-wrap">
						<div class="entry">
							<?php $width = 84;
								$height = 84;

								$post_title = get_the_title();

								$thumbnail = get_thumbnail($width,$height,'border-none',$post_title,$post_title,false);
								$thumb = $thumbnail["thumb"]; ?>

							<?php if ($thumb <> '' && get_option('tidalforce_thumbnails_index') == 'on') { ?>
								<div class="thumbnail-div">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $post_title, $width, $height, 'border-none'); ?>
								</div>
							<?php }; ?>

							<h2 class="titles">
								<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','TidalForce'), the_title()) ?>">
									<?php truncate_title(17); ?>
								</a>
							</h2>

							<div>
								<?php truncate_post(90); ?>
							</div>
						</div> <!-- end .entry -->
					</div> <!-- end .home-post-wrap -->
					<!--End Recent Posts-->

				<?php endwhile; ?>
					<div style="clear: both;"></div>
					<?php get_template_part('includes/navigation'); ?>
				<?php else : ?>
					<?php get_template_part('includes/no-results'); ?>
				<?php endif; ?>
			</div> <!-- end .recentposts -->
			<img src="<?php echo get_template_directory_uri(); ?>/images/content-blue-bottom.gif" alt="bottom" style="margin-bottom: 7px; float: left;" />

		</div> <!-- end#left-inside -->
	</div> <!-- end#left-div -->

	<!--Begin Sidebar-->
	<?php get_sidebar(); ?>
	<!--End Sidebar-->
</div> <!-- end #container -->

<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>