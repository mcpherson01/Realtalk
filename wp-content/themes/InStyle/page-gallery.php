<?php
/*
Template Name: Gallery Page
*/
?>
<?php
$et_ptemplate_settings = array();
$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : (bool) $et_ptemplate_settings['et_fullwidthpage'];

$gallery_cats = isset( $et_ptemplate_settings['et_ptemplate_gallerycats'] ) ? $et_ptemplate_settings['et_ptemplate_gallerycats'] : array();
$et_ptemplate_gallery_perpage = isset( $et_ptemplate_settings['et_ptemplate_gallery_perpage'] ) ? (int) $et_ptemplate_settings['et_ptemplate_gallery_perpage'] : 12;
?>

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

				<div id="et_pt_gallery" class="clearfix">
					<?php $gallery_query = '';
					if ( !empty($gallery_cats) ) $gallery_query = '&cat=' . implode(",", $gallery_cats);
					else echo '<!-- gallery category is not selected -->'; ?>
					<?php
						$et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
					?>
					<?php query_posts("posts_per_page=$et_ptemplate_gallery_perpage&paged=" . $et_paged . $gallery_query); ?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<?php $width = 207;
						$height = 136;
						$titletext = get_the_title();

						$thumbnail = get_thumbnail($width,$height,'portfolio',$titletext,$titletext,true,'Portfolio');
						$thumb = $thumbnail["thumb"]; ?>

						<div class="et_pt_gallery_entry">
							<div class="et_pt_item_image">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, 'portfolio'); ?>
								<span class="overlay"></span>

								<a class="zoom-icon fancybox" title="<?php the_title_attribute(); ?>" rel="gallery" href="<?php echo($thumbnail['fullpath']); ?>"><?php esc_html_e('Zoom in','InStyle'); ?></a>
								<a class="more-icon" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more','InStyle'); ?></a>
							</div> <!-- end .et_pt_item_image -->
						</div> <!-- end .et_pt_gallery_entry -->

					<?php endwhile; ?>
						<div class="page-nav clearfix">
							<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
							else { ?>
								 <?php get_template_part('includes/navigation'); ?>
							<?php } ?>
						</div> <!-- end .entry -->
					<?php else : ?>
						<?php get_template_part('includes/no-results'); ?>
					<?php endif; wp_reset_query(); ?>

				</div> <!-- end #et_pt_gallery -->

				<?php edit_post_link(esc_html__('Edit this page','InStyle')); ?>
			</div> <!-- end .entry -->

			<?php if (get_option('instyle_integration_single_bottom') <> '' && get_option('instyle_integrate_singlebottom_enable') == 'on') echo(get_option('instyle_integration_single_bottom')); ?>
		</div> <!-- end #content-area -->

		<?php if (!$fullwidth) get_sidebar(); ?>
	</div> <!--end #content-->
	<div id="content-bottom"></div>

	<div class="clear"></div>
	<?php endwhile; endif; ?>
<?php get_footer(); ?>