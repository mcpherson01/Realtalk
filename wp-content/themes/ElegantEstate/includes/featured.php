<!-- Start Featured -->
<div id="featured">

	<?php
	$arr = array();
	$i=1;

	$width = 954;
	$height = 289;
	$width_small = 49;
	$height_small = 49;

	$featured_cat = get_option('elegantestate_feat_cat');
	$featured_num = (int) get_option('elegantestate_featured_num');

	if (get_option('elegantestate_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
	else {
		global $pages_number;

		if (get_option('elegantestate_feat_pages') <> '') $featured_num = count(get_option('elegantestate_feat_pages'));
		else $featured_num = $pages_number;

		$et_featured_pages_args = array(
			'post_type' => 'page',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => (int) $featured_num,
		);

		if ( is_array( et_get_option( 'elegantestate_feat_pages', '', 'page' ) ) )
			$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'elegantestate_feat_pages', '', 'page' ) );

		query_posts( $et_featured_pages_args );
	};

	while (have_posts()) : the_post();
		$arr[$i]["title"] = truncate_title(20,false);
		$arr[$i]["fulltitle"] = truncate_title(250,false);

		$arr[$i]["excerpt"] = truncate_post(320,false);

		$arr[$i]["permalink"] = get_permalink();

		$arr[$i]["thumbnail"] = get_thumbnail($width,$height,'',$arr[$i]["fulltitle"],$arr[$i]["fulltitle"],false,'featured_image');
		$arr[$i]["thumb"] = $arr[$i]["thumbnail"]["thumb"];
		$arr[$i]["thumbnail_small"] = get_thumbnail($width_small,$height_small,'',$arr[$i]["fulltitle"],$arr[$i]["fulltitle"]);
		$arr[$i]["thumb_small"] = $arr[$i]["thumbnail_small"]["thumb"];

		$arr[$i]["use_timthumb"] = $arr[$i]["thumbnail"]["use_timthumb"];

		$custom = get_post_custom( get_the_ID() );
		$arr[$i]["price"] = isset($custom["price"][0]) ? $custom["price"][0] : '';

		$arr[$i]['post_id'] = (int) get_the_ID();

		$i++;
	endwhile; wp_reset_query();	?>

	<div id="slides">
		<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
			<?php if ($arr[$i]["title"] == '') break; ?>
			<div class="slide">
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
				<div class="overlay"></div>

				<div class="description">
					<div class="slide-info">
						<?php if ($arr[$i]["price"] != '') { ?>
							<span class="price"><span><?php echo esc_html($arr[$i]["price"]); ?></span></span>
						<?php }; ?>
						<h2 class="title"><a href="<?php echo esc_url($arr[$i]["permalink"]); ?>"><?php echo esc_html($arr[$i]["title"]); ?></a></h2>
						<div class="hr"></div>
						<p><?php echo ($arr[$i]["excerpt"]); ?></p>
						<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" class="readmore"><span><?php esc_html_e('view the listing','ElegantEstate'); ?></span></a>
					</div> <!-- end .slide-info -->
				</div> <!-- end .description -->
			</div> <!-- end .slide -->
		<?php }; ?>
	</div> <!-- end #slides -->

	<div id="controllers">
		<a href="#" id="left-arrow"><?php esc_html_e('Previous','ElegantEstate');?></a>

		<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
			<?php if ($arr[$i]["title"] == '') break; ?>
			<a href="#" class="smallthumb<?php if ($i==1) echo(' active'); if ($i == $featured_num) echo(' last'); ?>">
			<?php
				print_thumbnail( array(
					'thumbnail' 	=> $arr[$i]["thumb_small"],
					'use_timthumb' 	=> $arr[$i]["thumbnail"]["use_timthumb"],
					'alttext'		=> $arr[$i]["fulltitle"],
					'width'			=> (int) $width_small,
					'height'		=> (int) $height_small,
					'et_post_id'	=> $arr[$i]['post_id'],
				) );
			?>
			</a>
		<?php }; ?>

		<a href="#" id="right-arrow"><?php esc_html_e('Next','ElegantEstate');?></a>
		<span id="active-arrow"></span>
	</div> <!-- end #controllers -->
</div> <!-- end #featured -->
<!-- End Featured -->