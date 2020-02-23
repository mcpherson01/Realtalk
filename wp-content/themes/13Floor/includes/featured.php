<?php
	$ids = array();
	$arr = array();
	$i=1;

	$width = 335;
	$height = 220;
	$maxSlides = 4;

	$featured_cat = get_option('13floor_feat_cat');
	$featured_num = (int) get_option('13floor_featured_num');
	if ($featured_num > $maxSlides) $featured_num = $maxSlides;

	if (get_option('13floor_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
	else {
		global $pages_number;

		if (get_option('13floor_feat_pages') <> '') $featured_num = count(get_option('13floor_feat_pages'));
		else $featured_num = $pages_number;

		if ($featured_num > $maxSlides) $featured_num = $maxSlides;

		$et_featured_pages_args = array(
			'post_type' => 'page',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => $featured_num,
		);

		if ( is_array( et_get_option( '13floor_feat_pages', '', 'page' ) ) )
			$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( '13floor_feat_pages', '', 'page' ) );

		query_posts( $et_featured_pages_args );
	};

	while (have_posts()) : the_post();

		$arr[$i]["title"] = truncate_title(25,false);
		$arr[$i]["small_title_default"] = truncate_title(10,false);
		$arr[$i]["fulltitle"] = truncate_title(250,false);

		$arr[$i]["excerpt"] = truncate_post(430,false);
		$arr[$i]["small_excerpt_default"] = truncate_post(45,false);
		$arr[$i]["button_text"] = get_post_meta(get_the_ID(), 'Button', true);

		$arr[$i]["small_title"] = get_post_meta(get_the_ID(), 'Title', true);
		$arr[$i]["small_excerpt"] = get_post_meta(get_the_ID(), 'Excerpt', true);

		$arr[$i]["permalink"] = get_permalink();

		$arr[$i]["thumbnail"] = get_thumbnail($width,$height,'featured_image',$arr[$i]["fulltitle"],$arr[$i]["fulltitle"]);

		$arr[$i]["thumb"] = $arr[$i]["thumbnail"]["thumb"];

		$arr[$i]["use_timthumb"] = $arr[$i]["thumbnail"]["use_timthumb"];

		$arr[$i]['post_id'] = get_the_ID();

		$i++;
		$ids[]= get_the_ID();

	endwhile; wp_reset_query();	?>


	<div id="featured-area">

		<div id="feat-content" class="clearfix<?php if(get_option('13floor_custom_animation') == 'on') echo(' custom_animation'); ?>">

			<?php for ($i = 1; $i <= $featured_num; $i++) { ?>

				<div class="slide">
					<div class="description">
						<h2 class="title"><a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" title="<?php printf(esc_attr__('Permanent Link to %s', '13floor'), $arr[$i]["fulltitle"]) ?>"><?php echo esc_html($arr[$i]["title"]); ?></a></h2>
						<p><?php echo($arr[$i]["excerpt"]); ?></p>

						<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" class="readmore"><span><?php if($arr[$i]["button_text"] <> '') echo esc_html($arr[$i]["button_text"]); else echo(esc_html__('Sign Up Today', '13floor')); ?></span></a>
					</div>

					<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" title="<?php printf(esc_attr__('Permanent Link to %s', '13floor'), $arr[$i]["fulltitle"]) ?>">
						<?php print_thumbnail( array(
								'thumbnail' 	=> $arr[$i]["thumbnail"]["thumb"],
								'use_timthumb' 	=> $arr[$i]["thumbnail"]["use_timthumb"],
								'alttext'		=> $arr[$i]["fulltitle"],
								'width'			=> (int) $width,
								'height'		=> (int) $height,
								'class'			=> 'featured_image',
								'et_post_id'	=> $arr[$i]['post_id'],
						) ); ?>
					</a>
				</div> <!-- end .slide -->

			<?php }; ?>

		</div> <!-- end #feat-content -->

		<div id="control-bg"></div>


		<div id="controls" class="clearfix">
			<span id="et_active_tab_bg"></span>

			<a href="" id="prevlink"><?php esc_html_e('Prev','13floor'); ?></a>
			<a href="" id="nextlink"><?php esc_html_e('Next','13floor'); ?></a>

			<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
				<a class="control_tab<?php if($i == 1) echo(" active"); if($i == $maxSlides) echo(' last'); ?>" href="#">
					<span class="heading"><?php if($arr[$i]["small_title"] <> '') echo($arr[$i]["small_title"]); else echo($arr[$i]["small_title_default"]); ?></span>
					<span class="excerpt"><?php if($arr[$i]["small_excerpt"] <> '') echo($arr[$i]["small_excerpt"]); else echo($arr[$i]["small_excerpt_default"]); ?></span>
				</a>
			<?php }; ?>

		</div> <!-- end #controls -->

	</div> <!-- end #featured-area -->