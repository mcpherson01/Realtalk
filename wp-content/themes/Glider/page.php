<?php get_template_part('header'); ?>

	<div id="main-rightarea">
		<div class="topbg"></div>

		<div class="block">
			<?php get_template_part('includes/breadcrumbs'); ?>

			<div class="content-area clearfix post">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php if (get_option('glider_integration_single_top') <> '' && get_option('glider_integrate_singletop_enable') == 'on') echo(get_option('glider_integration_single_top')); ?>
				<?php
					$thumb = '';
					$width = 173;
					$height = 173;
					$classtext = '';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);

					$thumb = $thumbnail['thumb']; ?>

				<?php if ($thumb <> '' && get_option('glider_page_thumbnails') == 'on') { ?>
					<div class="thumb">
						<?php print_thumbnail($thumb, $thumbnail['use_timthumb'], $titletext, $width, $height); ?>
						<span class="overlay"></span>
					</div> <!-- .thumb -->
				<?php } ?>

				<h1 class="title"><?php the_title(); ?></h1>

				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Glider').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(esc_html__('Edit this page','Glider')); ?>

				<?php if (get_option('glider_integration_single_bottom') <> '' && get_option('glider_integrate_singlebottom_enable') == 'on') echo(get_option('glider_integration_single_bottom')); ?>

				<div class="shadow"></div>
			<?php endwhile; endif; ?>
			</div> <!-- .content-area -->

			<?php if (get_option('glider_show_pagescomments') == 'on') comments_template('', true); ?>

		</div> <!-- .block -->

	</div> <!-- #main-rightarea -->

<?php get_footer(); ?>