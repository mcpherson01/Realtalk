	<div id="sidebar">

		<?php $featured_cat = get_option('egallery_feat_cat');
			  $featured_num = (int) get_option('egallery_featured_num');
			  $ids = array();

			  $width = 53; $height = 53;
			  $width2 = 207; $height2 = 120;
			  $classtext = 'featured';
			  $classtext2 = 'featured-hover'; ?>

		<?php if (get_option('egallery_featured') == 'on') { ?>
			<!--Featured Articles-->
			<div class="sidebar-box2">
				<h3><?php esc_html_e('featured articles','eGallery'); ?> </h3>
				<ul class="menu">
					<?php query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));

					while (have_posts()) : the_post(); ?>
						<?php $titletext = get_the_title();
							  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							  $thumb = $thumbnail["thumb"];

							  $thumbnail2 = get_thumbnail($width2,$height2,$classtext2,$titletext,$titletext);
							  $thumb2 = $thumbnail2["thumb"]; ?>

						<?php if($thumb != '') { ?>
							<li>
								<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eGallery'), get_the_title()) ?>">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
								</a>
								<em>
									<?php print_thumbnail($thumb2, $thumbnail["use_timthumb"], $titletext, $width2, $height2, $classtext2); ?>
								</em>
							</li>
						<?php } ?>
					<?php endwhile; wp_reset_query(); ?>
				</ul>
			</div>
			<!--End Featured Articles-->
		<?php }; ?>

		<?php if (get_option('egallery_random_show') == 'on') { ?>
			<!--Begin Random Articles-->
			<div class="sidebar-box2">
				<h3><?php esc_html_e('random articles','eGallery'); ?></h3>
				<ul class="menu">
					<?php query_posts("orderby=rand&ignore_sticky_posts=1&posts_per_page=".get_option('egallery_random_num'));
					while (have_posts()) : the_post(); ?>
						<?php $titletext = get_the_title();
							  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							  $thumb = $thumbnail["thumb"];

							  $classtext2 = 'featured-hover-random';
							  $thumbnail2 = get_thumbnail($width2,$height2,$classtext2,$titletext,$titletext);
							  $thumb2 = $thumbnail2["thumb"]; ?>
						<?php if($thumb != '') { ?>
							<li>
								<a href="<?php the_permalink() ?>">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
								</a>
								<em>
									<?php print_thumbnail($thumb2, $thumbnail["use_timthumb"], $titletext, $width2, $height2, $classtext2); ?>
								</em>
							</li>
						<?php }; ?>
					<?php endwhile; wp_reset_query(); ?>
				</ul>
			</div>
			<!--End Random Articles-->
		<?php }; ?>

		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
			<div class="sidebar-box">
				<h3><?php esc_html_e('Categories','eGallery'); ?></h3>
				<ul>
					<?php wp_list_categories('sort_column=name&hierarchical=0'); ?>
				</ul>
			</div>
		<?php endif; ?>

	</div> <!-- end #sidebar -->
</div>