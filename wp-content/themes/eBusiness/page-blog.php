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

<?php if (get_option('ebusiness_blog_style') == 'Blog Based') : ?>

	<?php if (get_option('ebusiness_categories') == 'on') : ?>
	<div id="categories"> <img src="<?php echo get_template_directory_uri(); ?>/images/categories-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="float: left;" />
		<?php $menuClass = 'nav superfish';
		$menuID = 'nav2';
		$secondaryNav = '';
		if (function_exists('wp_nav_menu')) {
			$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
		};
		if ($secondaryNav == '') { ?>
			<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
				<?php show_categories_menu($menuClass,false); ?>
			</ul> <!-- end ul#nav -->
		<?php }
		else echo($secondaryNav); ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/categories-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="float: left;" /> </div>
	<?php endif; ?>

<?php endif; ?>

<div id="container">

	<div id="left-div<?php if ($fullwidth) echo('-full'); ?>">
        <!--Start Post-->
        <div class="home-post-wrap-2">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <h1 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eBusiness'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></h1>
            <?php $desc = get_post_meta($post->ID, 'Description', $single = true); ?>
            <?php if($desc != '') { ?>
            <div class="post-info-wrap"> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> <span class="post-info"><?php echo esc_html($desc); ?></span> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> </div>
            <?php } ?>
            <div style="clear: both;"></div>

			<?php if (get_option('ebusiness_page_thumbnails') == 'on') { ?>

				<?php $width = (int) get_option('ebusiness_thumbnail_width_pages');
					  $height = (int) get_option('ebusiness_thumbnail_height_pages');
					  $classtext = 'thumbnail';
					  $titletext = get_the_title();

				      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					  $thumb = $thumbnail["thumb"];  ?>

				<?php if($thumb != '') { ?>
					<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eBusiness'), get_the_title()) ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					</a>
				<?php } ?>

			<?php } ?>

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

						<p class="et_pt_blogmeta"><?php esc_html_e('Posted','eBusiness'); ?> <?php esc_html_e('by','eBusiness'); ?> <?php the_author_posts_link(); ?> <?php esc_html_e('on','eBusiness'); ?> <?php the_time(get_option('ebusiness_date_format')) ?> <?php esc_html_e('in','eBusiness'); ?> <?php the_category(', ') ?> | <?php comments_popup_link(esc_html__('0 comments','eBusiness'), esc_html__('1 comment','eBusiness'), '% '.esc_html__('comments','eBusiness')); ?></p>

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
							<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','eBusiness'); ?></span></a>
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

            <?php if (get_option('ebusiness_foursixeight') == 'on') { ?>
            <?php get_template_part('includes/468x60'); ?>
            <?php } else { echo ''; } ?>
		<?php endwhile; endif; ?>
	</div>
	</div>

	<?php if (!$fullwidth) { ?>
		<!--Begin Sidebar-->
		<div id="sidebar">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Pages") ) : ?>
			<?php endif; ?>
		</div>
		<!--End Sidebar-->
	<?php } ?>
    <img src="<?php echo get_template_directory_uri(); ?>/images/content-bg-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="float: left; margin-top: 15px;" /> </div>
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body></html>