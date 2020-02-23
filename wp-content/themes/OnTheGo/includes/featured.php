<?php
	$arr = array();
	$i=1;

	$width = 307;
	$height = 195;

	$featured_cat = get_option('onthego_feat_cat');
	$featured_num = (int) get_option('onthego_featured_num');

	if (get_option('onthego_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
	else {
		global $pages_number;
		if (get_option('onthego_feat_pages') <> '') $featured_num = count(get_option('onthego_feat_pages'));
		else $featured_num = $pages_number;

		$et_featured_pages_args = array(
			'post_type' => 'page',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => (int) $featured_num,
		);

		if ( is_array( et_get_option( 'onthego_feat_pages', '', 'page' ) ) )
			$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'onthego_feat_pages', '', 'page' ) );

		query_posts( $et_featured_pages_args );
	};

	while (have_posts()) : the_post();

		$arr[$i]["title"] = truncate_title(50,false);
		$arr[$i]["fulltitle"] = truncate_title(250,false);
		$arr[$i]["excerpt"] = truncate_post(345,false);
		$arr[$i]["tab_title"] = get_post_meta(get_the_ID(), 'Tab', $single = true);
		if ($arr[$i]["tab_title"] == '') $arr[$i]["tab_title"] = 'Tab custom field';
		$arr[$i]["permalink"] = get_permalink();

		$arr[$i]["thumbnail"] = get_thumbnail($width,$height,'',$arr[$i]["fulltitle"],$arr[$i]["tab_title"]);
		$arr[$i]["thumb"] = $arr[$i]["thumbnail"]["thumb"];
		$arr[$i]["use_timthumb"] = $arr[$i]["thumbnail"]["use_timthumb"];

		$arr[$i]['post_id'] = (int) get_the_ID();

		$i++;
	endwhile; wp_reset_query();	?>

<!-- Featured Slider -->
<div id="featured-slider">
	<div id="buildings"></div>
	<ul id="slider-control">
		<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
			<li<?php if ($i == 1) echo(' class="active"');?>><a href="#"><span><?php echo esc_html($arr[$i]["tab_title"]); ?></span></a></li>
		<?php }; ?>
	</ul> <!-- #slider-control -->
	<div id="featured-area">

		<div id="feat-content">
			<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
				<div class="featitem clearfix">

					<div class="featured-image">
						<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" title="<?php printf(esc_attr__('Permanent Link to %s', 'OnTheGo'), $arr[$i]["fulltitle"]) ?>">
						<?php
							print_thumbnail( array(
								'thumbnail' 	=> $arr[$i]["thumbnail"]["thumb"],
								'use_timthumb' 	=> $arr[$i]["thumbnail"]["use_timthumb"],
								'alttext'		=> $arr[$i]["fulltitle"],
								'width'			=> (int) $width,
								'height'		=> (int) $height,
								'et_post_id'	=> $arr[$i]['post_id'],
							) );
						?>
						</a>
					</div> <!-- .featured-image -->

					<div class="description">
						<h2><a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" title="<?php printf(esc_attr__('Permanent Link to %s', 'OnTheGo'), $arr[$i]["fulltitle"]) ?>"><span><?php echo esc_html($arr[$i]["title"]); ?></span></a></h2>
						<p><?php echo($arr[$i]["excerpt"]); ?></p>
					</div> <!-- .description -->

					<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" title="<?php printf(esc_attr__('Permanent Link to %s', 'OnTheGo'), $arr[$i]["fulltitle"]) ?>" class="readmore"><span><?php esc_html_e('Read More','OnTheGo'); ?></span></a>

				</div> <!-- .featitem -->
			<?php }; ?>

		</div> <!-- #feat-content -->

		<a href="#" id="prevlink"><?php esc_html_e('Previous','OnTheGo'); ?></a>
		<a href="#" id="nextlink"><?php esc_html_e('Next','OnTheGo'); ?></a>

	</div> <!-- #featured area -->

</div> <!-- #featured slider -->