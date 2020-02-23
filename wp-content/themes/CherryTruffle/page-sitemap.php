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

<div id="container2"> <img src="<?php echo get_template_directory_uri(); ?>/images/content-top-home-2<?php if($fullwidth) echo ('-full');?>.gif" alt="logo" style="float: left;" />
    <div id="left-div">
        <!--Start Post-->
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="post-wrapper">
				<h1 class="titles2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','CherryTruffle'), get_the_title()) ?>">
					<?php the_title(); ?>
					</a></h1>
				<div style="clear: both;"></div>

				<?php if (get_option('cherrytruffle_page_thumbnails') == 'on') { ?>
					<?php $width = get_option('cherrytruffle_thumbnail_width_pages');
						  $height = get_option('cherrytruffle_thumbnail_height_pages');
						  $classtext = 'thumbnail';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"];  ?>

					<?php if($thumb != '') { ?>
						<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','CherryTruffle'), get_the_title()) ?>">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
						</a>
					<?php } ?>
				<?php }; ?>

				<?php the_content(); ?>
						<div id="sitemap">
							<div class="sitemap-col">
								<h2><?php esc_html_e('Pages','CherryTruffle'); ?></h2>
								<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
							</div> <!-- end .sitemap-col -->

							<div class="sitemap-col">
								<h2><?php esc_html_e('Categories','CherryTruffle'); ?></h2>
								<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
							</div> <!-- end .sitemap-col -->

							<div class="sitemap-col">
								<h2><?php esc_html_e('Tags','CherryTruffle'); ?></h2>
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
								<h2><?php esc_html_e('Authors','CherryTruffle'); ?></h2>
								<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
							</div> <!-- end .sitemap-col -->
						</div> <!-- end #sitemap -->

				<div style="clear: both;"></div>

				<?php if (get_option('cherrytruffle_show_pagescomments') == 'on') { ?>
					<div class="comment-bg">
						<?php comments_template('',true); ?>
						<div style="clear: both;"></div>
					</div>
					<img src="<?php echo get_template_directory_uri(); ?>/images/comment-bottom.gif" alt="logo" style="float: left; margin-bottom: 20px;" />
				<?php }; ?>

			</div>
		<?php endwhile; endif; ?>
    </div>
    <?php if (!$fullwidth) get_sidebar(); ?>
    <img src="<?php echo get_template_directory_uri(); ?>/images/content-bottom-2<?php if($fullwidth) echo ('-full');?>.gif" alt="logo" style="float: left;" /> </div>
<?php get_footer(); ?>
</body></html>