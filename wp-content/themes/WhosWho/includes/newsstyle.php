<div class="home-post-wrap">
    <!--Begins recent posts section of the homepage-->
    <div id="home-left"<?php if (get_option('whoswho_show_popular') == 'false' && get_option('whoswho_show_recentcomments') == 'false') echo(' style="width: 600px;"'); ?>>
		<span class="headings"><?php esc_html_e('recent posts','WhosWho')?></span>

		<!--Begind recent post (single)-->
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<h2 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','WhosWho'), get_the_title()) ?>">
				<?php truncate_title(30) ?></a></h2>

			<?php $thumb = '';
				  $width = 120;
				  $height = 120;
				  $classtext = '';
				  $titletext = get_the_title();

				  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
				  $thumb = $thumbnail["thumb"]; ?>

			<?php if($thumb != '') { ?>
				<div class="thumbnail-div">
					<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','WhosWho'), get_the_title()) ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
					</a>
				</div>
			<?php }; ?>

			<?php if (get_option('whoswho_postinfo_homedefault') ) { ?>
				<span class="post-info">
					<?php esc_html_e('Posted','WhosWho'); ?> <?php if (in_array('author', get_option('whoswho_postinfo_homedefault'))) { ?> <?php esc_html_e('by','WhosWho'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('whoswho_postinfo_homedefault'))) { ?> <?php esc_html_e('on','WhosWho'); ?> <?php the_time(get_option('whoswho_date_format')) ?><?php }; ?>
				</span>
			<?php }; ?>

			<div><?php truncate_post(270) ?></div>
			<div style="clear:both;"></div>

        <?php endwhile; ?>
        <!--end recent post (single)-->
    </div>

    <?php if (get_option('whoswho_show_popular') == 'on' || get_option('whoswho_show_recentcomments') == 'on') { ?>
		<!--Begin Popular Posts-->
		<div id="home-right">

			<?php if (get_option('whoswho_show_popular') == 'on') { ?>
				<span class="headings"><?php esc_html_e('popular posts','WhosWho'); ?></span>
				<div style="clear: both;"></div>

				<ul>
					<?php $popular_num = (int) get_option('whoswho_popular_num');
					$result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $popular_num");
					foreach ($result as $post) {
						#setup_postdata($post);
						$postid = $post->ID;
						$title = $post->post_title;
						$commentcount = $post->comment_count;
						if ($commentcount != 0) { ?>
							<li><a href="<?php echo esc_url(get_permalink($postid)); ?>" title="<?php echo esc_attr($title); ?>">
							<?php echo esc_html($title); ?></a> (<?php echo esc_html($commentcount); ?>)</li>
						<?php }
					} ?>
				</ul>
				<!--End popular posts-->
				<div style="clear:both;"></div>
			<?php }; ?>

			<?php if (get_option('whoswho_show_recentcomments') == 'on') { ?>
				<!--Begin Recent Comments-->
				<span class="headings"><?php esc_html_e('recent comments','WhosWho'); ?></span>
				<?php get_template_part('simple_recent_comments'); /* recent comments plugin by: www.g-loaded.eu */?>
				<?php $recent_commentsnum = get_option('whoswho_recent_comments');
				if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments($recent_commentsnum, 60, '', ''); } ?>
				<!--End Recent Comments-->
			<?php }; ?>

		</div>
	<?php }; ?>

</div> <!-- end #home-post-wrap -->
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>

<?php if (get_option('whoswho_show_catboxes') == 'on') { ?>
	<!--Category Box 1-->
	<?php global $cat_option;
	$cat_option='whoswho_home_cat_one'; ?>
	<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
		  while (have_posts()) : the_post(); ?>
			  <?php get_template_part('includes/category_box'); ?>
	<?php endwhile; wp_reset_query(); ?>
	<!--End Category Box 1-->

	<!--Category Box 2-->
	<?php $cat_option='whoswho_home_cat_two'; ?>
	<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
		  while (have_posts()) : the_post(); ?>
			  <?php get_template_part('includes/category_box'); ?>
	<?php endwhile; wp_reset_query(); ?>
	<!--End Category Box 2-->

	<div style="clear: both;"></div>

	<!--Category Box 3-->
	<?php $cat_option='whoswho_home_cat_three'; ?>
	<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
		  while (have_posts()) : the_post(); ?>
			  <?php get_template_part('includes/category_box'); ?>
	<?php endwhile; wp_reset_query(); ?>
	<!--Category Box 3-->

	<!--Category Box 4-->
	<?php $cat_option='whoswho_home_cat_four'; ?>
	<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
		  while (have_posts()) : the_post(); ?>
			  <?php get_template_part('includes/category_box'); ?>
	<?php endwhile; wp_reset_query(); ?>
	<!--Category Box 4-->
	<!--End category boxes-->
<?php }; ?>