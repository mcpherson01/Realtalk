<?php
/*
Template Name: Blog Page
*/
?>
<?php
$et_ptemplate_settings = array();
$et_ptemplate_settings = maybe_unserialize( get_post_meta( get_the_ID(), 'et_ptemplate_settings', true ) );

$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;

$et_ptemplate_blogstyle = isset( $et_ptemplate_settings['et_ptemplate_blogstyle'] ) ? (bool) $et_ptemplate_settings['et_ptemplate_blogstyle'] : false;

$et_ptemplate_showthumb = isset( $et_ptemplate_settings['et_ptemplate_showthumb'] ) ? (bool) $et_ptemplate_settings['et_ptemplate_showthumb'] : false;

$blog_cats = isset( $et_ptemplate_settings['et_ptemplate_blogcats'] ) ? (array) $et_ptemplate_settings['et_ptemplate_blogcats'] : array();
$et_ptemplate_blog_perpage = isset( $et_ptemplate_settings['et_ptemplate_blog_perpage'] ) ? (int) $et_ptemplate_settings['et_ptemplate_blog_perpage'] : 10;
?>

<?php get_header(); ?>

<div id="container"<?php if ($fullwidth) echo ' class="no_sidebar"'; ?>>
<div id="left-div">
    <div id="left-inside">
		<!--Start Post-->
        <span class="single-entry-titles" style="margin-top: 18px;"></span>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="post-wrapper">
                  <?php if (get_option('egamer_integration_single_top') <> '' && get_option('egamer_integrate_singletop_enable') == 'on') { ?>
                  <div style="clear: both;"></div>
		  <?php echo(get_option('egamer_integration_single_top')); ?>
          <?php }; ?>
          <div style="clear: both;"></div>
        <?php if (get_option('egamer_page_thumbnails') == 'on') { ?>
			<?php $width = (int) get_option('egamer_thumbnail_width_pages');
				  $height = (int) get_option('egamer_thumbnail_height_pages');

				  $classtext = 'linkimage';
				  $titletext = get_the_title();

				  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'image_value');
				  $thumb = $thumbnail["thumb"];  ?>

			<?php if($thumb <> '') { ?>
				<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				</a>
			<?php } ?>

        <?php }; ?>
            <h1 class="post-title" style="margin-top: 13px;"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
                <?php the_title(); ?>
                </a></h1>
            <?php the_content(); ?>

                  <div style="clear: both;"></div>

				<div id="et_pt_blog">
					<?php $cat_query = '';
					if ( !empty($blog_cats) ) $cat_query = '&cat=' . implode(",", $blog_cats);
					else echo '<!-- blog category is not selected -->'; ?>
					<?php
						$et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
					?>
					<?php query_posts("posts_per_page=$et_ptemplate_blog_perpage&paged=" . $et_paged . $cat_query); ?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<div class="et_pt_blogentry clearfix">
							<h2 class="et_pt_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

							<p class="et_pt_blogmeta"><?php esc_html_e('Posted','eGamer'); ?> <?php esc_html_e('by','eGamer'); ?> <?php the_author_posts_link(); ?> <?php esc_html_e('on','eGamer'); ?> <?php the_time(get_option('egamer_date_format')) ?> <?php esc_html_e('in','eGamer'); ?> <?php the_category(', ') ?> | <?php comments_popup_link(esc_html__('0 comments','eGamer'), esc_html__('1 comment','eGamer'), '% '.esc_html__('comments','eGamer')); ?></p>

							<?php $thumb = '';
							$width = 184;
							$height = 184;
							$classtext = '';
							$titletext = get_the_title();

							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							$thumb = $thumbnail["thumb"]; ?>

							<?php if ( $thumb <> '' && !$et_ptemplate_showthumb ) { ?>
								<div class="et_pt_thumb alignleft">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
									<a href="<?php the_permalink(); ?>"><span class="overlay"></span></a>
								</div> <!-- end .thumb -->
							<?php }; ?>

							<?php if (!$et_ptemplate_blogstyle) { ?>
								<p><?php truncate_post(550);?></p>
								<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','eGamer'); ?></span></a>
							<?php } else { ?>
								<?php
									global $more;
									$more = 0;
								?>
								<?php the_content(); ?>
							<?php } ?>
						</div> <!-- end .et_pt_blogentry -->

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

				</div> <!-- end #et_pt_blog -->


        </div>
		<?php endwhile; endif; ?>
        <?php $video = get_post_meta($post->ID, 'Video', $single = true); ?>
    <?php
if($video <> '') { ?>
    <span class="single-entry-titles" style="margin-top: 18px;"><?php esc_html_e('Play Video','eGamer') ?></span>
    <div class="post-wrapper" style="padding-top: 14px;"> <?php echo $video; ?> </div>
    <?php }
else { echo ''; } ?>

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