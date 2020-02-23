<?php
$featured_cat = get_option('earthlytouch_feat_cat');
$featured_num = (int) get_option('earthlytouch_featured_num'); ?>

<div id="featured">
	<?php query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
	while (have_posts()) : the_post(); ?>
		<?php $width = 200;
			  $height = 200;
			  $classtext = 'no-border';
			  $titletext = get_the_title();

			  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
			  $thumb = $thumbnail["thumb"]; ?>

		<div class="thumbnail-div-featured">
			<a href="<?php the_permalink() ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
			</a>
		</div>

		<div class="featured-content">
			<span class="titles-featured">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','EarthlyTouch'), get_the_title()) ?>">
					<?php the_title(); ?>
				</a>
			</span>
			<?php truncate_post(460); ?>
			<div style="clear: both;"></div>
			<div class="readmore">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','EarthlyTouch'), get_the_title()) ?>"><?php esc_html_e('Read More','EarthlyTouch'); ?></a>
			</div>
		</div>

		<div style="clear: both;"></div>
    <?php
	endwhile; wp_reset_query(); ?>
</div>