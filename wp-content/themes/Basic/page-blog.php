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

									<p class="et_pt_blogmeta"><?php esc_html_e('Posted','Basic'); ?> <?php esc_html_e('by','Basic'); ?> <?php the_author_posts_link(); ?> <?php esc_html_e('on','Basic'); ?> <?php the_time(get_option('basic_date_format')) ?> <?php esc_html_e('in','Basic'); ?> <?php the_category(', ') ?> | <?php comments_popup_link(esc_html__('0 comments','Basic'), esc_html__('1 comment','Basic'), '% '.esc_html__('comments','Basic')); ?></p>

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
										<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','Basic'); ?></span></a>
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