<?php
/*
Template Name: Gallery Page
*/
?>
<?php get_header(); ?>
<?php
$et_ptemplate_settings = array();
$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : (bool) $et_ptemplate_settings['et_fullwidthpage'];

$gallery_cats = isset( $et_ptemplate_settings['et_ptemplate_gallerycats'] ) ? $et_ptemplate_settings['et_ptemplate_gallerycats'] : array();
$et_ptemplate_gallery_perpage = isset( $et_ptemplate_settings['et_ptemplate_gallery_perpage'] ) ? (int) $et_ptemplate_settings['et_ptemplate_gallery_perpage'] : 12;
?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div id="post-top">
	<div class="breadcrumb">
		<?php if(function_exists('bcn_display')) { bcn_display(); }
		else { ?>
			<?php esc_html_e('You are currently viewing','eNews') ?>: <em><?php the_title() ?></em>
		<?php }; ?>
	</div> <!-- end breadcrumb -->
</div> <!-- end post-top -->

<div id="main-area-wrap" <?php if($fullwidth) echo ('class="no_sidebar"');?>>
	<div id="wrapper">
		<div id="main" class="noborder">
			<h1 class="page-title"><?php the_title() ?></h1>
			<div id="post-content">

				<?php $width = (int) get_option('enews_thumbnail_width_pages');
					  $height = (int) get_option('enews_thumbnail_height_pages');
					  $classtext = 'thumbnail alignleft';
					  $titletext = get_the_title();

				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				$thumb = $thumbnail["thumb"];  ?>

				<?php if($thumb <> '' && get_option('enews_page_thumbnails') == 'on') { ?>
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				<?php }; ?>

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

									<a class="zoom-icon fancybox" title="<?php the_title_attribute(); ?>" rel="gallery" href="<?php echo($thumbnail['fullpath']); ?>"><?php esc_html_e('Zoom in','eNews'); ?></a>
									<a class="more-icon" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more','eNews'); ?></a>
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
				<?php edit_post_link(esc_html__('Edit this page','eNews')); ?>

			</div> <!-- end post-content -->
			<br class="clearfix"/>
			<?php if (get_option('enews_show_pagescomments') == 'on') comments_template('', true); ?>

		</div> <!-- end main -->
<?php endwhile; endif; ?>
<?php if (!$fullwidth) get_sidebar(); ?>
<?php get_footer(); ?>