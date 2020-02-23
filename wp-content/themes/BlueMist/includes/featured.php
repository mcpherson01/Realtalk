<div id="featured">
    <div id="featured-bg">
		<?php
		$width = 384;
		$height = 122;

		$featured_cat = get_option('bluemist_feat_cat');
		$featured_num = 1; ?>

        <?php query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
		while (have_posts()) : the_post(); ?>
			<span class="titles">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','BlueMist'), get_the_title()) ?>">
					<?php the_title(); ?>
				</a>
			</span>

			<div id="featured-left">
				<a href="<?php the_permalink() ?>">
					<?php
					$post_title = get_the_title();

					$thumbnail = get_thumbnail($width,$height,'thumb',$post_title,$post_title,false,'Featured');
					$thumb = $thumbnail["thumb"];

					print_thumbnail($thumb, $thumbnail["use_timthumb"], $post_title, $width, $height, 'thumb'); ?>
				</a>
			</div> <!-- end #featured-left -->

			<div id="featured-right">
				<?php truncate_post(510); ?>
			</div> <!-- end #featured-right -->

			<div style="clear: both;"></div>

		<?php endwhile; wp_reset_query();	?>
    </div> <!-- end #featured-bg -->
</div> <!-- end #featured -->