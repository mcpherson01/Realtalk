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

<div class="single_wrap <?php if($fullwidth) echo (' no_sidebar');?>">

    <div class="single_post">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h1><a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
            </a></h1>
		<?php if (get_option('coldstone_page_thumbnails') == 'on') { get_template_part( 'includes/thumbnail'); } ?>
        <?php the_content();?>
					<div id="sitemap">
						<div class="sitemap-col">
							<h2><?php esc_html_e('Pages','ColdStone'); ?></h2>
							<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col">
							<h2><?php esc_html_e('Categories','ColdStone'); ?></h2>
							<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->

						<div class="sitemap-col">
							<h2><?php esc_html_e('Tags','ColdStone'); ?></h2>
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
							<h2><?php esc_html_e('Authors','ColdStone'); ?></h2>
							<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
						</div> <!-- end .sitemap-col -->
					</div> <!-- end #sitemap -->

		<?php edit_post_link(); ?>
		<div style="clear: both;"></div>
		<?php if (get_option('coldstone_show_pagescomments') == 'on') { ?>
			<?php comments_template('', true); ?>
		<?php }; ?>
		<?php endwhile; endif; ?>
    </div>
    <!-- /single_post -->
    <?php if (!$fullwidth) get_sidebar(); ?>
</div>
<div class="footer" style="height:15px;margin-bottom:0;"></div>
<?php get_footer(); ?>