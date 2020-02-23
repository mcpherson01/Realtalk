<?php get_header(); ?>

<div id="content-full">
	<div id="hr">
		<div id="hr-center">
			<div id="intro">
				<div class="center-highlight">

					<div class="container">

						<?php get_template_part('includes/breadcrumbs'); ?>

					</div> <!-- end .container -->
				</div> <!-- end .center-highlight -->
			</div>	<!-- end #intro -->
		</div> <!-- end #hr-center -->
	</div> <!-- end #hr -->

	<div class="center-highlight">
		<div class="container">

			<?php $blogcat = (int) get_catId(get_option('deepfocus_blog_cat'));
			$isBlogPage = false; ?>

			<?php $post_categories = get_the_category();
			foreach ($post_categories as $category) {
				if (in_subcat($blogcat, $category->cat_ID)) $isBlogPage = true;
			} ?>

			<div id="content-area" class="clearfix">

				<div id="left-area">

					<?php if (get_option('deepfocus_integration_single_top') <> '' && get_option('deepfocus_integrate_singletop_enable') == 'on') echo(get_option('deepfocus_integration_single_top')); ?>
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<div class="entry clearfix post">
							<?php $width = 185;
								  $height = 185;
								  if (!$isBlogPage) {
									  $width = 650;
									  $height = 9999;
								  }

								  $classtext = '';
								  $titletext = get_the_title();

								  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
								  $thumb = $thumbnail["thumb"]; ?>

							<?php if (get_option('deepfocus_blog_thumbnails') == 'on' && $isBlogPage) { ?>

								<?php if($thumb <> '') { ?>
									<div class="blog-thumb">
										<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
										<span class="overlay"></span>
									</div> <!-- end .blog-thumb -->
								<?php } ?>
							<?php } ?>

							<h1 class="title"><?php the_title(); ?></h1>
							<?php get_template_part('includes/postinfo'); ?>

							<?php if($thumb == '' || get_option('deepfocus_gallery_thumbnails') == 'false') echo('<div class="clear"></div>'); ?>

							<?php if (get_option('deepfocus_gallery_thumbnails') == 'on' && !$isBlogPage) { ?>
								<div class="clear"></div>
								<div class="gallery-thumb">
									<a href="<?php echo $thumbnail['fullpath']; ?>" rel="media" class="fancybox" title="<?php the_title(); ?>">
										<?php if ($thumbnail["use_timthumb"]) { ?>
											<img src="<?php echo(print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext, false, false, false)); ?>" alt="<?php the_title(); ?>" />
										<?php } else { ?>
											<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
										<?php } ?>
										<span class="overlay"></span>
									</a>
									<div class="gallery-thumb-bottom">
										<div class="left-shadow"></div>
										<div class="bg"></div>
										<div class="right-shadow"></div>
									</div> <!-- end .gallery-thumb-botton -->
								</div> <!-- end .gallery-thumb -->
								<div class="clear"></div>
							<?php } ?>


							<?php the_content(); ?>
							<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','DeepFocus').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
							<?php edit_post_link(esc_html__('Edit this page','DeepFocus')); ?>
						</div> <!-- end .entry -->
					<?php endwhile; endif; ?>
					<?php if (get_option('deepfocus_integration_single_bottom') <> '' && get_option('deepfocus_integrate_singlebottom_enable') == 'on') echo(get_option('deepfocus_integration_single_bottom')); ?>

					<?php if (get_option('deepfocus_468_enable') == 'on') { ?>
						<?php if(get_option('deepfocus_468_adsense') <> '') echo(get_option('deepfocus_468_adsense'));
						else { ?>
							<a href="<?php echo(get_option('deepfocus_468_url')); ?>"><img src="<?php echo(get_option('deepfocus_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
						<?php } ?>
					<?php } ?>

					<?php if (get_option('deepfocus_show_postcomments') == 'on') comments_template('', true); ?>

				</div> <!-- end #left-area -->

				<?php get_sidebar(); ?>

			</div> <!-- end #content-area -->

		</div> <!-- end .container -->

		<?php get_footer(); ?>