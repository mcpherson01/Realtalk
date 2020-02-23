<?php
/*
Template Name: Sitemap Page
*/
?>

<?php if (is_front_page()) { ?>
	<?php get_template_part('home'); ?>
<?php } else { ?>

<?php
$et_ptemplate_settings = array();
$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
?>

	<?php get_header(); ?>


		<div id="main-content" <?php if($fullwidth) echo (' class="no_sidebar"');?>>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="entry post clearfix">
					<?php $width = (int) get_option('myapptheme_thumbnail_width_pages');
						  $height = (int) get_option('myapptheme_thumbnail_height_pages');
						  $classtext = 'thumb alignleft';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '' && get_option('myapptheme_page_thumbnails') == 'on') { ?>
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
					<?php }; ?>

					<h1 class="title"><?php the_title(); ?></h1>
					<?php the_content(); ?>
						<div id="sitemap">
							<div class="sitemap-col">
								<h2><?php esc_html_e('Pages','MyAppTheme'); ?></h2>
								<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
							</div> <!-- end .sitemap-col -->

							<div class="sitemap-col">
								<h2><?php esc_html_e('Categories','MyAppTheme'); ?></h2>
								<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
							</div> <!-- end .sitemap-col -->

							<div class="sitemap-col">
								<h2><?php esc_html_e('Tags','MyAppTheme'); ?></h2>
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
								<h2><?php esc_html_e('Authors','MyAppTheme'); ?></h2>
								<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
							</div> <!-- end .sitemap-col -->
						</div> <!-- end #sitemap -->

					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','MyAppTheme').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','MyAppTheme')); ?>
					<div class="clear"></div>
				</div> <!-- end .post -->

				<?php if (get_option('myapptheme_show_pagescomments') == 'on') comments_template('', true); ?>
			<?php endwhile; endif; ?>
		</div> <!-- end #main-content -->
	<?php if (!$fullwidth) get_sidebar(); ?>
	<?php get_footer(); ?>
<?php } ?>