<?php
$loopcounter = 0;
query_posts("posts_per_page=".get_option('bold_homepage_featured')."&cat=".get_catId(get_option('bold_feat_cat')));
while (have_posts()) : the_post(); $loopcounter++; ?>

<?php if (($loopcounter % 2) <> 0) : ?>
<div class="featured-block2">
<?php else : ?>
<div class="featured-block">
<?php endif; ?>
<div class="featured-block-inside">

<div class="featured-date"><span class="featured-date-left"></span><span class="featured-date-inside"><?php the_time(get_option('bold_date_format')) ?></span></div>

<span class="titles-featured"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
    <?php truncate_title(28) ?>
    </a></span>
    <span class="featured-line"></span>

	<?php $width = 85;
		  $height = 85;
		  $classtext = 'featured-thumb';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		  $thumb = $thumbnail["thumb"]; ?>

	<?php if($thumb <> '') { ?>
        <div class="featured-thumb-wrapper">
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
			</a>
    </div>
	<?php } ?>

	<div>
	<?php truncate_post(200); ?>
    </div>
    <a href="<?php the_permalink() ?>" rel="bookmark" class="featured-readmore" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
    <?php esc_html_e('read more','Bold') ?>
    </a>
        </div>
</div>

<?php endwhile; ?>
<?php wp_reset_query(); ?>