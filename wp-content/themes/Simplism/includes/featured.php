<?php $featured_cat = get_option('simplism_feat_cat'); ?>

<div id="featured">
    <?php query_posts("posts_per_page=1&cat=".get_catId($featured_cat));
	while (have_posts()) : the_post(); ?>

		<?php $width = 576;
			  $height = 106;
			  $classtext = 'no-border';
			  $titletext = get_the_title();

			  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Featured');
			  $thumb = $thumbnail["thumb"]; ?>

		<h1 class="titles-featured">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Simplism'), the_title()) ?>">
				<?php the_title(); ?>
			</a>
		</h1>

		<div class="featured-content">
			<?php if ($thumb <> '') { ?>
				<div class="thumbnail-div" style="width: 576px; margin-top: 15px; margin-bottom: 15px;">
					<a href="<?php the_permalink() ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					</a>
				</div>
			<?php }; ?>

			<?php truncate_post(510); ?>
			<div style="clear: both;"></div>

			<div class="readmore">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Simplism'), the_title()) ?>"><?php esc_html_e('Read More','Simplism'); ?></a>
			</div>
			<div style="clear: both;"></div>
		</div> <!-- end .featured-content -->
    <?php endwhile; wp_reset_query(); ?>
</div> <!-- end #featured -->