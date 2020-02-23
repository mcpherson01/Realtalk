<?php get_header(); ?>

<div id="container">
<div id="left-div">
    <div id="left-inside">
		<?php if (get_option('egallery_integration_single_top') <> '' && get_option('egallery_integrate_singletop_enable') == 'on') echo(get_option('egallery_integration_single_top')); ?>
       <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php if (get_option('egallery_thumbnails') == 'on') { ?>
				<?php $width = 330;
					  $height = 330;
					  $classtext = 'single-image';
					  $titletext = get_the_title();

					  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
					  $thumb = $thumbnail["thumb"]; ?>

			<?php }; ?>

			<!--Begin Post-->
			<div class="post-wrapper">
				<div style="clear: both;"></div>
				<div class="lightbox">
					<div style="margin-left: 30%; margin-top: 10%;"> <img src="<?php bloginfo('template_directory'); ?>/images/lightboxdelete.png" class="lightboxdelete" />
						<div style="clear: both;"></div>
						<img src="<?php echo $thumbnail["fullpath"]; ?>" alt="" class="lightbox-image" />
					</div>
				</div>

				<?php if($thumb != '') { ?>
					<a href="#" class="lightboxclick" title="<?php printf(esc_attr__('Permanent Link to %s','eGallery'), get_the_title()) ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
					</a>
				<?php } ?>

				<div class="single-info">
					<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eGallery'), get_the_title()) ?>">
						<?php the_title(); ?>
						</a></h1>
				</div>

				<?php if (get_option('egallery_postinfo2') ) { ?>
					<div class="single-info2">
						<?php esc_html_e('Posted','eGallery'); ?> <?php if (in_array('author', get_option('egallery_postinfo2'))) { ?> <?php esc_html_e('by','eGallery'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('egallery_postinfo2'))) { ?> <?php esc_html_e('on','eGallery'); ?> <?php the_time(get_option('egallery_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('egallery_postinfo2'))) { ?> <?php esc_html_e('in','eGallery'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('egallery_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','eGallery'), esc_html__('1 comment','eGallery'), '% '.esc_html__('comments','eGallery')); ?><?php }; ?>
					</div>
				<?php }; ?>

				<?php if(function_exists('the_ratings')) { ?>
					<div class="single-info3">
						 <?php the_ratings(); ?>
					</div>
				<?php }; ?>

				<?php the_content(); ?>
				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','eGallery').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

				<?php edit_post_link(esc_html__('Edit this page','eGallery')); ?>

				<?php if (get_option('egallery_integration_single_bottom') <> '' && get_option('egallery_integrate_singlebottom_enable') == 'on') echo(get_option('egallery_integration_single_bottom')); ?>

				<?php if (get_option('egallery_468_enable') == 'on') { ?>
					<?php if(get_option('egallery_468_adsense') <> '') echo(get_option('egallery_468_adsense'));
					else { ?>
						<a href="<?php echo(get_option('egallery_468_url')); ?>" class="foursixeight_link"><img src="<?php echo(get_option('egallery_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
					<?php } ?>
				<?php } ?>

				<div style="clear: both;"></div>
			</div>

			<?php if (get_option('egallery_show_postcomments') == 'on') { ?>
				<div class="post-wrapper">
					<?php comments_template('', true); ?>
				</div>
			<?php }; ?>
		<?php endwhile; endif; ?>
    </div>
</div>
<!--Begin Sidebar-->
<?php get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>