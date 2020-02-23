<?php get_header(); ?>

	<?php get_template_part('includes/top_info'); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div id="content-top"></div>
	<div id="content" class="clearfix">
		<div id="content-area">
			<?php get_template_part('includes/breadcrumbs'); ?>
			<?php if (get_option('instyle_integration_single_top') <> '' && get_option('instyle_integrate_singletop_enable') == 'on') echo(get_option('instyle_integration_single_top')); ?>

			<div class="entry clearfix post">
				<?php $thumb = '';
				$width = 211;
				$height = 211;
				$classtext = '';
				$titletext = get_the_title();
				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
				$thumb = $thumbnail["thumb"]; ?>

				<?php if($thumb <> '' && get_option('instyle_page_thumbnails') == 'on') { ?>
					<div class="post-thumbnail alignleft">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
						<span class="post-overlay"></span>
					</div> 	<!-- end .post-thumbnail -->
				<?php } ?>

				<?php
					echo apply_filters('the_content',et_create_dropcaps(get_the_content()));
				?>
				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','InStyle').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(esc_html__('Edit this page','InStyle')); ?>
			</div> <!-- end .entry -->

			<?php if (get_option('instyle_integration_single_bottom') <> '' && get_option('instyle_integrate_singlebottom_enable') == 'on') echo(get_option('instyle_integration_single_bottom')); ?>
		</div> <!-- end #content-area -->

		<?php get_sidebar(); ?>
	</div> <!--end #content-->
	<div id="content-bottom"></div>

	<?php if (get_option('instyle_show_pagescomments') == 'on') comments_template('', true); ?>
	<div class="clear"></div>
	<?php endwhile; endif; ?>
<?php get_footer(); ?>