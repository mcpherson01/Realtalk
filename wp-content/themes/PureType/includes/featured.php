<?php $feat_cat = (int) get_catId(get_option('puretype_feat_cat'));
$puretype_homepage_featured = (int) get_option( 'puretype_homepage_featured' ); ?>
<?php query_posts("cat=$feat_cat&posts_per_page=$puretype_homepage_featured;");
while (have_posts()) : the_post(); ?>

<div class="featured"> <span class="titles-featured"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
    <?php the_title(); ?>
    </a></span><span class="featured-date">|
    <?php the_time(get_option('puretype_date_format')) ?>
    </span>

	<?php $width = 615;
		  $height = 223;

		  $classtext = 'featured-thumb';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		  $thumb = $thumbnail["thumb"];  ?>

	<?php if($thumb != '') { ?>
		<div class="featured-thumb-wrapper">
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
			</a>
			<div class="featured-categories">
				<?php the_category('') ?>
			</div>
		</div>
    <?php } ?>

    <div style="clear: both;"></div>
    <?php truncate_post(310) ?>
</div>
<?php endwhile; wp_reset_query(); ?>