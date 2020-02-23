<?php get_header(); ?>

	<div id="container">
		<div id="left-div">
			<div id="left-inside">
				<?php if(is_category()) { ?>
					<span class="current-category">
						<?php single_cat_title(esc_html__('Currently Browsing: ','eGallery'), 'display'); ?>
					</span>
				<?php }; ?>
				<!--Begin recent post (single)-->

				<?php if (have_posts()) : while (have_posts()) : the_post();  ?>
					<?php $width = 190; $height = 159;
						  $classtext = '';
						  $titletext = get_the_title();
						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"];	?>

					<div class="home-post-wrap">
						<div class="thumbnail-div" style="background-image: url('<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, '', true, true); ?>');">
							<div class="info"> <span class="info-titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eGallery'), get_the_title()) ?>">
								<?php truncate_title(18); ?>
								</a></span>
								<?php truncate_post(145); ?>
							</div>
							<img src="<?php echo get_template_directory_uri(); ?>/images/slider-button.png" alt="more info" class="info-button" /> </div>
							<div class="bar">
								<div class="ratingbox"> <img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="delete" class="delete" />
									<div style="clear: both;"></div>
									<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
								</div>
								<a href="#" class="rating" style="float: left;" title="<?php esc_attr_e('Click here to rate this post','eGallery'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/star.gif" alt="rate this post" style="border: none;" /></a>
								<div class="comments-bubble">
									<?php comments_popup_link('0', '1', '% '); ?>
								</div>
								<a href="#" class="rating" style="float: left; cursor: pointer; margin-left: 9px;" title="<?php esc_attr_e('This article was posted on:','eGallery'); ?> <?php the_time('m jS, Y') ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/date.png" alt="date" style="border: none;" /></a> <a href="<?php the_permalink() ?>" style="float: right;" title="<?php esc_attr_e('Click here to read the rest of:','eGallery'); ?> <?php truncate_title(30); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/read-more.gif" style="border: none;" alt="read more" /></a> </div>
					</div>
					<?php endwhile; ?>
					<!--end recent post (single)-->

					<div style="clear: both;"></div>
					<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
						  else { ?>
							  <?php get_template_part('includes/navigation'); ?>
						  <?php } ?>
				<?php else : ?>
					<?php get_template_part('includes/no-results'); ?>
				<?php endif; ?>
			</div>
		</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>