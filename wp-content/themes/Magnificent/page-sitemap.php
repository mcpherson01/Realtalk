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

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php get_template_part('includes/breadcrumbs'); ?>

<?php if (get_option('magnificent_integration_single_top') <> '' && get_option('magnificent_integrate_singletop_enable') == 'on') echo(get_option('magnificent_integration_single_top')); ?>

	<div id="entries"<?php if ($fullwidth) echo ' class="fullwidth"'; ?>>
		<div class="entry post entry-full">
			<div class="border">
				<div class="bottom">
					<div class="entry-content clearfix">
						<h1 class="title"><?php the_title(); ?></h1>


						<?php if (get_option('magnificent_page_thumbnails') == 'on') { ?>

							<?php $thumb = '';
							$width = 218;
							$height = 218;
							$classtext = '';
							$titletext = get_the_title();

							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							$thumb = $thumbnail["thumb"]; ?>

							<?php if($thumb <> '') { ?>
								<div class="thumbnail">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
									<span class="overlay"></span>
								</div> 	<!-- end .thumbnail -->
							<?php }; ?>

						<?php }; ?>

						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Magnificent').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

						<div id="sitemap">
							<div class="sitemap-col">
								<h2><?php esc_html_e('Pages','Magnificent'); ?></h2>
								<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
							</div> <!-- end .sitemap-col -->

							<div class="sitemap-col">
								<h2><?php esc_html_e('Categories','Magnificent'); ?></h2>
								<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
							</div> <!-- end .sitemap-col -->

							<div class="sitemap-col">
								<h2><?php esc_html_e('Tags','Magnificent'); ?></h2>
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
								<h2><?php esc_html_e('Authors','Magnificent'); ?></h2>
								<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
							</div> <!-- end .sitemap-col -->
						</div> <!-- end #sitemap -->

						<div class="clear"></div>

						<?php edit_post_link(esc_html__('Edit this page','Magnificent')); ?>

					</div> <!-- end .entry-content -->
				</div> <!-- end .bottom -->
			</div> <!-- end .border -->
		</div> <!-- end .entry -->

		<div class="clear"></div>

		<?php if (get_option('magnificent_integration_single_bottom') <> '' && get_option('magnificent_integrate_singlebottom_enable') == 'on') echo(get_option('magnificent_integration_single_bottom')); ?>

	</div> <!-- end #entries -->

<?php endwhile; endif; ?>

	<?php if (!$fullwidth) { ?>
		<div id="sidebar-right" class="sidebar">
			<div class="block">
				<div class="block-border">
					<div class="block-content">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Right Top') ) : ?>
						<?php endif; ?>
					</div> <!-- end .block-content -->
				</div> <!-- end .block-border -->
			</div> <!-- end .block -->

			<div class="block">
				<div class="block-border">
					<div class="block-content">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Right Bottom') ) : ?>
						<?php endif; ?>
					</div> <!-- end .block-content -->
				</div> <!-- end .block-border -->
			</div> <!-- end .block -->
		</div> <!-- end #sidebar-right -->
	<?php }  ?>

<?php get_footer(); ?>