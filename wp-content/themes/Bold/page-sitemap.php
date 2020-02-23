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

<div id="content" <?php if($fullwidth) echo (' class="no_sidebar"');?>>
<img src="<?php bloginfo('template_directory'); ?>/images/content-top<?php if($fullwidth) echo ('-full');?>.gif" alt="top" style="float: left;" />
<div id="left-div">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="single-post-wrap">

            <div style="clear: both;"></div>
                        <h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></h2>


        <div style="clear: both;"></div>

		<?php if (get_option('bold_page_thumbnails') == 'on') { ?>

			<?php $width = get_option('bold_thumbnail_width_pages');
					  $height = get_option('bold_thumbnail_height_pages');
					  $classtext = '';
					  $titletext = get_the_title();

				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				$thumb = $thumbnail["thumb"];  ?>

			<?php if($thumb <> '') { ?>
				<div class="thumbnail-div">
					<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					</a>
				</div>
			<?php } ?>

        <?php }; ?>

        <?php the_content(); ?>
					<div id="sitemap">
						<div class="sitemap-col">
							<h2><?php esc_html_e('Pages','Bold'); ?></h2>
							<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col">
							<h2><?php esc_html_e('Categories','Bold'); ?></h2>
							<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col">
							<h2><?php esc_html_e('Tags','Bold'); ?></h2>
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
							<h2><?php esc_html_e('Authors','Bold'); ?></h2>
							<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
						</div> <!-- end .sitemap-col -->
					</div> <!-- end #sitemap -->


        <div style="clear: both;"></div>
        <?php if (get_option('bold_show_pagescomments') == 'on') comments_template('', true); ?>

        <?php if (get_option('bold_foursixeight') == 'Enable') { ?>
        <?php get_template_part('includes/468x60'); ?>
        <?php } else { echo ''; } ?>

	</div>
<?php endwhile; endif; ?>
</div>
<?php if (!$fullwidth) get_sidebar(); ?>
<?php get_footer(); ?>

</body>
</html>