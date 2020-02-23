<?php get_header(); ?>

<?php $projects_cat = get_catid(get_option('lumin_projects_cat')); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php if (get_option('lumin_integration_single_top') <> '' && get_option('lumin_integrate_singletop_enable') == 'on') echo(get_option('lumin_integration_single_top')); ?>
	<h1 id="post-title"><span><?php the_title(); ?></span></h1>
	<?php get_template_part('includes/postinfo'); ?>
	<div id="main">
		<div class="post">
			<?php if (in_subcat($projects_cat) || in_category($projects_cat)) { ?>
				<?php if (get_option('lumin_thumbnails_post') == 'on') { ?>

					<?php $width = 595;
					      $height = 328;
					      $classtext = 'thumbnail-post';
					      $titletext = get_the_title();

					      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
					      $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '') { ?>
						<div class="gallery-postimage">
							<a href="<?php echo $thumbnail["fullpath"]; ?>" title="<?php the_title(); ?>" class="fancybox">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
								<span class="overlay"></span>
							</a>
						</div>
					<?php };

				}; ?>
			<?php } else { ?>
				<?php if (get_option('lumin_thumbnails') == 'on') { ?>

					<?php $width = (int) get_option('lumin_thumbnail_width_posts');
					      $height = (int) get_option('lumin_thumbnail_height_posts');
					      $classtext = 'thumbnail-post alignleft';
					      $titletext = get_the_title();

					      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					      $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '') { ?>
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					<?php };

				}; ?>
			<?php }; ?>

			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(esc_html__('Edit this page','Lumin')); ?>
			<div class="clear"></div>
		</div> <!-- end .post -->

		<?php if (get_option('lumin_integration_single_bottom') <> '' && get_option('lumin_integrate_singlebottom_enable') == 'on') echo(get_option('lumin_integration_single_bottom')); ?>
        <?php if (get_option('lumin_468_enable') == 'on') { ?>
			<a href="<?php echo esc_url(get_option('lumin_468_url')); ?>"><img src="<?php echo esc_attr(get_option('lumin_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
        <?php } ?>

		<?php if (get_option('lumin_show_postcomments') == 'on') comments_template('', true); ?>

	</div> <!-- end #main -->
<?php endwhile; ?>
<?php else : ?>
	<?php get_template_part('includes/noresults'); ?>
<?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>