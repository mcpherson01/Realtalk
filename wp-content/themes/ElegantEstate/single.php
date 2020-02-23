<?php get_header(); ?>

<div id="content-top">
	<div id="menu-bg"></div>
	<div id="top-index-overlay"></div>

	<div id="content" class="clearfix">
		<div id="main-area">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php if (get_option('elegantestate_integration_single_top') <> '' && get_option('elegantestate_integrate_singletop_enable') == 'on') echo(get_option('elegantestate_integration_single_top')); ?>

			<?php $inBlogCat = false;
			$blogcat = get_catId(get_option('elegantestate_blog_cat'));
			foreach (get_the_category() as $category) {
				if (!$inBlogCat) $inBlogCat = in_subcat($blogcat,$category->cat_ID);
			} ?>

			<?php if (!$inBlogCat) { ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
					<?php get_template_part('includes/single-product'); ?>
				</div> <!-- end .post -->
			<?php } else { ?>
				<?php get_template_part('includes/breadcrumbs'); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class( array('clearfix','full_entry') ); ?>>
					<?php if (get_option('elegantestate_thumbnails') == 'on') { ?>
						<?php $width = 159;
							  $height = 159;
							  $classtext = '';
							  $titletext = get_the_title();

							  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							  $thumb = $thumbnail["thumb"]; ?>
					<?php }; ?>

					<div class="entry_content<?php if ($thumb <> '' && get_option('elegantestate_thumbnails_index') == 'on') echo(' setwidth') ?>">
						<?php if($thumb <> '') { ?>
							<div class="small-thumb">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
								<span class="overlay"></span>
							</div> 	<!-- end .small-thumb -->
						<?php }; ?>
						<h1 class="single-title"><?php the_title(); ?></h1>
						<?php get_template_part('includes/postinfo'); ?>
						<?php the_content(); ?>

						<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','ElegantEstate').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php edit_post_link(esc_html__('Edit this page','ElegantEstate')); ?>
					</div> <!-- end .entry_content -->

					<?php if (get_option('elegantestate_integration_single_bottom') <> '' && get_option('elegantestate_integrate_singlebottom_enable') == 'on') echo(get_option('elegantestate_integration_single_bottom')); ?>

					<?php if (get_option('elegantestate_468_enable') == 'on') { ?>
						<?php if(get_option('elegantestate_468_adsense') <> '') echo(get_option('elegantestate_468_adsense'));
						else { ?>
							<a href="<?php echo(get_option('elegantestate_468_url')); ?>"><img src="<?php echo(get_option('elegantestate_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
						<?php } ?>
					<?php } ?>
				</div> <!-- end .full_entry -->

				<?php if (get_option('elegantestate_show_postcomments') == 'on') comments_template('', true); ?>
			<?php } ?>
		<?php endwhile; endif; ?>
		</div> <!-- end #main-area-->

		<?php get_sidebar(); ?>

	<?php get_footer(); ?>