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

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<!--Begin Article Single-->
			<div class="post-wrapper<?php if ($fullwidth) echo(' no_sidebar'); ?>">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h1 class="post-title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','EarthlyTouch'), the_title()) ?>">
						<?php the_title(); ?>
					</a>
				</h1>
				<div style="clear: both;"></div>

				<?php if (get_option('earthlytouch_page_thumbnails') == 'on') { ?>

					<?php $thumb = '';

					$width = (int) get_option('earthlytouch_thumbnail_width_pages');
					$height = (int) get_option('earthlytouch_thumbnail_height_pages');
					$classtext = '';
					$titletext = get_the_title();

					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					$thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '') { ?>
						<div class="thumbnail-div">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
						</div>
					<?php }; ?>

				<?php }; ?>

				<?php the_content(); ?>
				<div style="clear: both;"></div>

				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','EarthlyTouch').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

				<div id="sitemap">
					<div class="sitemap-col">
						<h2><?php esc_html_e('Pages','EarthlyTouch'); ?></h2>
						<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
					</div> <!-- end .sitemap-col -->

					<div class="sitemap-col">
						<h2><?php esc_html_e('Categories','EarthlyTouch'); ?></h2>
						<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
					</div> <!-- end .sitemap-col -->

					<div class="sitemap-col<?php echo ' last'; ?>">
						<h2><?php esc_html_e('Tags','EarthlyTouch'); ?></h2>
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
						<h2><?php esc_html_e('Authors','EarthlyTouch'); ?></h2>
						<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
					</div> <!-- end .sitemap-col -->
				</div> <!-- end #sitemap -->

				<div class="clear"></div>

				<?php edit_post_link(esc_html__('Edit this page','EarthlyTouch')); ?>
			<?php endwhile; endif; ?>
			</div> <!-- end .post-wrapper -->
			<!--End Article Single-->
		</div> <!-- end #left-inside -->
	</div> <!-- end #left-div -->
	<!--Begin sidebar-->
	<?php if (!$fullwidth) get_sidebar(); ?>
	<!--End sidebar-->
</div> <!-- end #container -->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>