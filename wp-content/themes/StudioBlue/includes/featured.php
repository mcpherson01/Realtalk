<?php
	  $featured_cat = get_option('studioblue_feat_cat');
	  query_posts("posts_per_page=".get_option('studioblue_featured_num')."&cat=".get_catId($featured_cat));
	  while (have_posts()) : the_post();  ?>
			<?php $thumb = '';
				  $width = 580;
				  $height = 160;
				  $classtext = 'no_border';
				  $titletext = get_the_title();

				  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				  $thumb = $thumbnail["thumb"]; ?>

			<div class="featured">
				<?php if($thumb != '') { ?>
					<div class="thumbnail-div-featured">
						<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
						</a>
					</div>
				<?php } ?>

				<?php get_template_part('includes/postinfo'); ?>

				<h1 class="titles-featured"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>">
					<?php the_title(); ?>
					</a></h1>
				<?php truncate_post(510) ?>
				<div style="clear: both;"></div>

				<div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>"><?php esc_html_e('Read More','StudioBlue')?></a></div>
				<div style="clear: both;"></div>
			</div>
	<?php endwhile; wp_reset_query(); ?>