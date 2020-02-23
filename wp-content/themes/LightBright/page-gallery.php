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
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="entry<?php if($fullwidth) echo(' no_sidebar');?>">
			<div class="entry-top"></div>

			<?php get_template_part('includes/share'); ?>

			<div class="post clearfix">
				<div class="content clearfix">

					<h1 class="title"><?php the_title(); ?></h1>

					<div class="clear"></div>

					<?php $thumb = '';
						  $width = 184;
						  $height = 184;
						  $classtext = '';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'thumb');
						  $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '' && get_option('lightbright_page_thumbnails') == 'on') { ?>
						<div class="thumb">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>

							<span class="overlay"></span>
						</div> <!-- end .thumb -->
					<?php }; ?>

					<?php the_content(); ?>
					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','LightBright').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

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

									<a class="zoom-icon fancybox" title="<?php the_title_attribute(); ?>" rel="gallery" href="<?php echo($thumbnail['fullpath']); ?>"><?php esc_html_e('Zoom in','LightBright'); ?></a>
									<a class="more-icon" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more','LightBright'); ?></a>
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

					<?php edit_post_link(esc_html__('Edit this page','LightBright')); ?>

				</div> <!-- end .content -->

				<div class="entry-bottom-top"></div>

				<div class="entry-meta clearfix">
					<p class="meta"><span class="main"><?php esc_html_e('Posted by','LightBright');?> <?php the_author_posts_link(); ?></span> <span class="comment-count"><?php comments_popup_link('0','1','%'); ?></span></p>
					<?php if(!is_single()) { ?>
						<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','LightBright'); ?></span></a>
					<?php }; ?>
				</div> <!-- end .entry-meta -->

			</div> <!-- end .post -->

			<div class="entry-bottom"></div>
		</div> <!-- end .entry -->
	<?php endwhile; endif; ?>
	</div> <!-- end #main-area -->

	<?php if (!$fullwidth) get_sidebar(); ?>

<?php get_footer(); ?>