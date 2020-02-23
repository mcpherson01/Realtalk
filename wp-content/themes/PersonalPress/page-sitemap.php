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
		<div id="main"<?php if ($fullwidth) echo ' class="fullwidth"'; ?>>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="entry-wrap post">
				<div class="entry">

					<h1 class="title page"><?php the_title(); ?></h1>

					<div class="entry-content clearfix post">

						<?php $thumb = '';
							  $width = 175;
							  $height = 175;
							  $classtext = '';
							  $titletext = get_the_title();

							  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							  $thumb = $thumbnail["thumb"]; ?>

						<?php if($thumb <> '' && get_option('personalpress_page_thumbnails') == 'on') { ?>
							<div class="thumb">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>

								<span class="overlay"></span>
							</div> <!-- end .thumb -->
						<?php }; ?>

						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','PersonalPress').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

						<div id="sitemap">
							<div class="sitemap-col">
								<h2><?php esc_html_e('Pages','PersonalPress'); ?></h2>
								<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
							</div> <!-- end .sitemap-col -->

							<div class="sitemap-col">
								<h2><?php esc_html_e('Categories','PersonalPress'); ?></h2>
								<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
							</div> <!-- end .sitemap-col -->

							<div class="sitemap-col">
								<h2><?php esc_html_e('Tags','PersonalPress'); ?></h2>
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
								<h2><?php esc_html_e('Authors','PersonalPress'); ?></h2>
								<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
							</div> <!-- end .sitemap-col -->
						</div> <!-- end #sitemap -->

						<div class="clear"></div>

						<?php edit_post_link(esc_html__('Edit this page','PersonalPress')); ?>

					</div> <!-- end .entry-content -->

					<div class="entry-bottom"></div>

				</div> <!-- end .entry -->
			</div> <!-- end .entry-wrap -->
		<?php endwhile; endif; ?>
		</div> <!-- end #main -->
<?php if (!$fullwidth) get_sidebar(); ?>
<?php get_footer(); ?>