<?php
/*
Template Name: Sitemap Page
*/
?>
<?php
$et_ptemplate_settings = array();
$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
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
					<div id="sitemap">
						<div class="sitemap-col">
							<h2><?php esc_html_e('Pages','ePhoto'); ?></h2>
							<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col">
							<h2><?php esc_html_e('Categories','ePhoto'); ?></h2>
							<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col">
							<h2><?php esc_html_e('Tags','ePhoto'); ?></h2>
							<ul id="sitemap-tags">
								<?php $tags = get_tags();
								if ($tags) {
									foreach ($tags as $tag) {
										echo '<li><a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a></li> ';
									}
								} ?>
							</ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col<?php echo ' last'; ?>">
							<h2><?php esc_html_e('Authors','ePhoto'); ?></h2>
							<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
						</div> <!-- end .sitemap-col -->
					</div> <!-- end #sitemap -->
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