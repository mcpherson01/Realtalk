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

    <!--Start Post-->
    <div class="post-wrapper">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
            <?php the_title(); ?></a></h1>
        <div style="clear: both;"></div>
		<?php if (get_option('puretype_page_thumbnails') == 'on') { get_template_part( 'includes/thumbnail'); } ?>
        <?php the_content(); ?>
					<div id="sitemap">
						<div class="sitemap-col">
							<h2><?php esc_html_e('Pages','PureType'); ?></h2>
							<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col">
							<h2><?php esc_html_e('Categories','PureType'); ?></h2>
							<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col">
							<h2><?php esc_html_e('Tags','PureType'); ?></h2>
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
							<h2><?php esc_html_e('Authors','PureType'); ?></h2>
							<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
						</div> <!-- end .sitemap-col -->
					</div> <!-- end #sitemap -->
		<div style="clear: both;"></div>
		<?php if (get_option('puretype_show_pagescomments') == 'on') { ?>
			<?php comments_template('', true); ?>
		<?php }; ?>
	<?php endwhile; endif; ?>
    </div>
    <?php if($fullwidth) echo ('</div>');?>
</div>
<!--Begin Sidebar-->
<?php if (!$fullwidth) get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>