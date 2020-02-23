<?php
	$arr = array();
	$i=1;

	$width = 140;
	$height = 140;

	$featured_cat = get_option('myproduct_feat_cat');
	$featured_num = (int) get_option('myproduct_featured_num');

	if (get_option('myproduct_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
	else {
		global $pages_number;

		if (get_option('myproduct_feat_pages') <> '') $featured_num = count(get_option('myproduct_feat_pages'));
		else $featured_num = $pages_number;

		$et_featured_pages_args = array(
			'post_type' => 'page',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => (int) $featured_num,
		);

		if ( is_array( et_get_option( 'myproduct_feat_pages', '', 'page' ) ) )
			$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'myproduct_feat_pages', '', 'page' ) );

		query_posts( $et_featured_pages_args );
	};

	while (have_posts()) : the_post();

		$arr[$i]["title"] = truncate_title(350,false);
		$arr[$i]["fulltitle"] = truncate_title(350,false);

		$arr[$i]["excerpt"] = truncate_post(455,false);

		$arr[$i]["tabtitle"] = get_post_meta(get_the_ID(), 'Tab', $single = true);
		$arr[$i]["permalink"] = get_permalink();

		$arr[$i]["thumbnail"] = get_thumbnail($width,$height,'thumbnail alignleft',$arr[$i]["fulltitle"],$arr[$i]["tabtitle"]);
		$arr[$i]["thumb"] = $arr[$i]["thumbnail"]["thumb"];
		$arr[$i]["use_timthumb"] = $arr[$i]["thumbnail"]["use_timthumb"];

		$arr[$i]['post_id'] = (int) get_the_ID();

		$i++;
	endwhile; wp_reset_query();	?>



<div id="featured-wrap">
	<ul id="featured-control">
		<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
			<?php if ($arr[$i]["tabtitle"] == '') $arr[$i]["tabtitle"] = 'Tab Custom field'; ?>
			<li<?php if ($i == 1) echo(' class="active"'); ?>><a href="#"><?php echo esc_html($arr[$i]["tabtitle"]); ?></a></li>
		<?php }; ?>
	</ul>

	<div id="featured">
		<?php for ($i = 1; $i <= $featured_num; $i++) { ?>

			<div class="slide clearfix">
				<h2 class="title"><a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" title="<?php printf(esc_attr__('Permanent Link to %s', 'MyProduct'), $arr[$i]["fulltitle"]) ?>"><?php echo esc_html($arr[$i]["title"]); ?></a></h2>

				<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" title="<?php printf(esc_attr__('Permanent Link to %s', 'MyProduct'), $arr[$i]["fulltitle"]) ?>">
				<?php
					print_thumbnail( array(
						'thumbnail' 	=> $arr[$i]["thumbnail"]["thumb"],
						'use_timthumb' 	=> $arr[$i]["thumbnail"]["use_timthumb"],
						'alttext'		=> $arr[$i]["fulltitle"],
						'width'			=> (int) $width,
						'height'		=> (int) $height,
						'class'			=> 'thumbnail alignleft',
						'et_post_id'	=> $arr[$i]['post_id'],
					) );
				?>
				</a>

				<p><?php echo($arr[$i]["excerpt"]); ?></p>
			</div> <!-- end .slide -->

		<?php }; ?>
	</div> <!-- end #featured -->
</div> <!-- end #featured-wrap -->