<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<!--Begin Post Single-->
			<div class="post-wrapper">
				<?php if (get_option('artsee_integration_single_top') <> '' && get_option('artsee_integrate_singletop_enable') == 'on') echo esc_html(get_option('artsee_integration_single_top')); ?>

			    <?php get_template_part('includes/buttons'); ?>

				<?php if (get_option('artsee_thumbnails') == 'on') { ?>
					<?php $thumb = '';

					$width = 573;
					$height = 187;
					$classtext = '';
					$titletext = get_the_title();

					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					$thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '') { ?>
						<div class="thumbnail-div">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
						</div>
					<?php }; ?>
				<?php }; ?>

				<h1 class="titles">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','ArtSee'), the_title()) ?>">
						<?php the_title(); ?>
					</a>
				</h1>

				<?php if (get_option('artsee_postinfo2') ) { ?>
					<div class="post-info"><?php esc_html_e('Posted','ArtSee'); ?> <?php if (in_array('author', get_option('artsee_postinfo2'))) { ?> <?php esc_html_e('by','ArtSee'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('artsee_postinfo2'))) { ?> <?php esc_html_e('on','ArtSee'); ?> <?php the_time( esc_attr(get_option('artsee_date_format'))) ?><?php }; ?><?php if (in_array('categories', get_option('artsee_postinfo2'))) { ?> <?php esc_html_e('in','ArtSee'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('artsee_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','ArtSee'), esc_html__('1 comment','ArtSee'), '% '.esc_html__('comments','ArtSee')); ?><?php }; ?></div>
				<?php }; ?>
				<div style="clear: both;"></div>

				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','ArtSee').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(esc_html__('Edit this page','ArtSee')); ?>

				<?php if (get_option('artsee_integration_single_bottom') <> '' && get_option('artsee_integrate_singlebottom_enable') == 'on') echo esc_html(get_option('artsee_integration_single_bottom')); ?>

				<?php if (get_option('artsee_468_enable') == 'on') { ?>
					<?php if(get_option('artsee_468_adsense') <> '') echo esc_html(get_option('artsee_468_adsense'));
					else { ?>
						<a href="<?php echo esc_url(get_option('artsee_468_url')); ?>"><img src="<?php echo esc_url(get_option('artsee_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
					<?php } ?>
				<?php } ?>

				<?php if (get_option('artsee_show_postcomments') == 'on') { ?>
					<!--Begin Comments Template-->
					<?php comments_template('', true); ?>
					<!--End Comments Template-->
				<?php }; ?>

			</div> <!-- end .post-wrapper -->
			<!--End Post Single-->
		<?php endwhile; endif; ?>
		</div> <!-- end #left-inside -->
	</div> <!-- end #left-div -->
	<!--Begin Sidebar-->
	<?php get_sidebar(); ?>
	<!--End Sidebar-->
</div> <!-- end #container -->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>