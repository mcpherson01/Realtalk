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
<div id="container2">
<div id="left-div2" <?php if($fullwidth) echo ('style="width: 910px;"');?>>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<!--Start Post-->
		<div class="post-wrapper" <?php if($fullwidth) echo ('style="width: 900px;"');?>>
			<h1 class="post-title2"><?php the_title(); ?></h1>
			<div style="clear: both;"></div>

			<?php if (get_option('ephoto_page_thumbnails') == 'on') { ?>
				<?php $width = (int) get_option('ephoto_thumbnail_width_pages');
					  $height = (int) get_option('ephoto_thumbnail_height_pages');
					  $classtext = 'blogthumbnail';
					  $titletext = get_the_title();

				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				$thumb = $thumbnail["thumb"];  ?>

					<?php if($thumb <> '') { ?>
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					<?php } ?>
			<?php } ?>

			<?php the_content(); ?>
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

									<a class="zoom-icon fancybox" title="<?php the_title_attribute(); ?>" rel="gallery" href="<?php echo($thumbnail['fullpath']); ?>"><?php esc_html_e('Zoom in','ePhoto'); ?></a>
									<a class="more-icon" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more','ePhoto'); ?></a>
								</div> <!-- end .et_pt_item_image -->
							</div> <!-- end .et_pt_gallery_entry -->

						<?php endwhile; ?>
							<div class="page-nav clearfix">
								<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
								else { ?>
									 <?php get_template_part('includes/page-navigation'); ?>
								<?php } ?>
							</div> <!-- end .entry -->
						<?php else : ?>
							<?php get_template_part('includes/no-results'); ?>
						<?php endif; wp_reset_query(); ?>

					</div> <!-- end #et_pt_gallery -->
			<br class="clearfix"/>
		</div>
		<?php if (get_option('ephoto_show_pagescomments') == 'on') { ?>
			<div class="comments-wrapper">
				<?php comments_template('', true); ?>
			</div>
			<img src="<?php bloginfo('template_directory'); ?>/images/comments-bottom-<?php echo esc_attr(get_option('ephoto_color_scheme')); ?>.gif" alt="comments-bottom" style="float: left;" />
		<?php }; ?>

    <!--End Post-->
    <?php endwhile; endif; ?>
</div>
<?php if (!$fullwidth) get_sidebar(); ?>

</div>

	<div id="bottom">
		<?php get_template_part('includes/footer-area'); ?>
    </div>

<?php get_footer(); ?>

</body>
</html>