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
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="post-wrapper <?php if($fullwidth) echo (' no_sidebar');?>">
					<?php get_template_part('includes/buttons'); ?>

					<?php if (get_option('artsee_page_thumbnails') == 'on') { ?>

						<?php $thumb = '';

						$width = 573;
						$height = 187;
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

					<h1 class="titles">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','ArtSee'), the_title()) ?>">
							<?php the_title(); ?>
						</a>
					</h1>
					<div style="clear: both;"></div>

					<?php the_content(); ?>
					<div id="sitemap">
						<div class="sitemap-col">
							<h2><?php esc_html_e('Pages','ArtSee'); ?></h2>
							<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col">
							<h2><?php esc_html_e('Categories','ArtSee'); ?></h2>
							<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col">
							<h2><?php esc_html_e('Tags','ArtSee'); ?></h2>
							<ul id="sitemap-tags">
								<?php $tags = get_tags();
								if ($tags) {
									foreach ($tags as $tag) {
										echo '<li><a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a></li> ';
									}
								} ?>
							</ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col<?php  echo ' last'; ?>">
							<h2><?php esc_html_e('Authors','ArtSee'); ?></h2>
							<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
						</div> <!-- end .sitemap-col -->
					</div> <!-- end #sitemap -->

					<div style="clear: both;"></div>

					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','ArtSee').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','ArtSee')); ?>

					<?php if (get_option('artsee_show_pagescomments') == 'on') { ?>
						<!--Begin Comments Template-->
						<div class="recentposts">
							<?php comments_template('', true); ?>
						</div>
						<!--End Comments Template-->
					<?php }; ?>
				</div> <!-- end .post-wrapper -->
			<?php endwhile; endif; ?>
		</div> <!-- end #left-inside -->
    </div> <!-- end #left-div -->

	<!--Begin Sidebar-->
	<?php if (!$fullwidth) get_sidebar(); ?>
	<!--End Sidebar-->
</div> <!-- end #container -->

<div style="clear: both;"></div>
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>