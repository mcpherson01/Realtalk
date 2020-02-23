<?php
$featured_cat = get_option('quadro_feat_cat');
$featured_num = (int) get_option('quadro_featured_num'); ?>

<div id="featured">
    <?php query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
	while (have_posts()) : the_post(); ?>
		<?php $width = 159;
			  $height = 212;
			  $classtext = 'no-border';
			  $titletext = get_the_title();

			  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Featured');
			  $thumb = $thumbnail["thumb"]; ?>

		<?php if ($thumb <> '' ) { ?>
			<div class="thumbnail-div-featured">
				<a href="<?php the_permalink() ?>">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				</a>
			</div> <!-- end .thumbnail-div-featured -->
		<?php }; ?>

		<div class="featured-content">
			<h1 class="titles-featured">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Quadro'), the_title()) ?>">
					<?php the_title(); ?>
				</a>
			</h1>
			<?php truncate_post(510); ?>
			<div style="clear: both;"></div>

			<div class="readmore">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Quadro'), the_title()) ?>"><?php esc_html_e('Read More','Quadro'); ?></a>
			</div>
		</div> <!-- end #featured-content -->

		<div style="clear: both;"></div>
    <?php endwhile; wp_reset_query(); ?>
</div> <!-- end #featured -->