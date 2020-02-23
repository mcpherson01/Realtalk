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

			<div id="content-area" class="clearfix">

				<div id="left-area">

					<?php if (get_option('deepfocus_integration_single_top') <> '' && get_option('deepfocus_integrate_singletop_enable') == 'on') echo(get_option('deepfocus_integration_single_top')); ?>

					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<div class="entry clearfix post">
							<?php $width = 185;
								  $height = 185;
								  $classtext = '';
								  $titletext = get_the_title();

								  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
								  $thumb = $thumbnail["thumb"]; ?>

							<h1 class="title"><?php the_title(); ?></h1>
							<?php get_template_part('includes/postinfo'); ?>

							<?php if($thumb == '') echo('<div class="clear"></div>'); ?>

							<?php if($thumb <> '' && get_option('deepfocus_page_thumbnails') == 'on') { ?>
									<div class="blog-thumb">
										<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
										<span class="overlay"></span>
									</div> <!-- end .blog-thumb -->
							<?php }; ?>

							<?php the_content(); ?>
							<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','DeepFocus').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
							<?php edit_post_link(esc_html__('Edit this page','DeepFocus')); ?>
						</div> <!-- end .entry -->
					<?php endwhile; endif; ?>

					<?php if (get_option('deepfocus_integration_single_bottom') <> '' && get_option('deepfocus_integrate_singlebottom_enable') == 'on') echo(get_option('deepfocus_integration_single_bottom')); ?>

					<?php if (get_option('deepfocus_show_pagescomments') == 'on') comments_template('', true); ?>

				</div> <!-- end #left-area -->

				<?php get_sidebar(); ?>

			</div> <!-- end #content-area -->

		</div> <!-- end .container -->

		<?php get_footer(); ?>