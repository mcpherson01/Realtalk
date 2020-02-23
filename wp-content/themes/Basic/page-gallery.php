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
<?php if($fullwidth) echo ('<style>#wrapper2 {background-image:none; }</style>');?>

<div id="container">
<div id="left-div"<?php if($fullwidth) echo (' style="width: 900px;');?>>
    <div id="left-inside">

        <!--Start Post-->
        <div class="home-post-wrap" <?php if($fullwidth) echo ('style="width: 880px;');?>>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h1 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Basic'), get_the_title()) ?>">
					<?php the_title() ?>
					</a></h1>
				<div style="clear: both;"></div>
				<?php if (get_option('basic_page_thumbnails') == 'on') { get_template_part( 'includes/thumbnail'); } ?>
				<?php the_content(''); ?>
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

										<a class="zoom-icon fancybox" title="<?php the_title_attribute(); ?>" rel="gallery" href="<?php echo($thumbnail['fullpath']); ?>"><?php esc_html_e('Zoom in','Basic'); ?></a>
										<a class="more-icon" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more','Basic'); ?></a>
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

				<div style="clear: both;"></div>
				<?php if (get_option('basic_show_pagescomments') == 'on') { ?>
					<?php comments_template('', true); ?>
				<?php }; ?>
			<?php endwhile; endif; ?>
        </div>

    </div>
</div>
<!--Begin Sidebar-->
<?php if (!$fullwidth) get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>