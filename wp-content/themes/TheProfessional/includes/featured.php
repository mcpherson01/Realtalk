<div id="featured">
	<?php
	$arr = array();
	$i=1;

	$width = 943;
	$height = 345;
	$width_small = 48;
	$height_small = 48;

	$featured_cat = get_option('professional_feat_cat');
	$featured_num = (int) get_option('professional_featured_num');

	if (get_option('professional_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
	else {
		global $pages_number;

		if (get_option('professional_feat_pages') <> '') $featured_num = count(get_option('professional_feat_pages'));
		else $featured_num = $pages_number;

		$et_featured_pages_args = array(
			'post_type' => 'page',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => (int) $featured_num,
		);

		if ( is_array( et_get_option( 'professional_feat_pages', '', 'page' ) ) )
			$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'professional_feat_pages', '', 'page' ) );

		query_posts( $et_featured_pages_args );
	};

	while (have_posts()) : the_post();
		global $post;
		$arr[$i]["title"] = truncate_title(25,false);
		$arr[$i]["fulltitle"] = truncate_title(250,false);

		$arr[$i]["excerpt"] = truncate_post(420,false);
		$arr[$i]["excerpt_small"] = truncate_post(130,false);

		$arr[$i]["permalink"] = get_permalink();

		$arr[$i]["thumbnail"] = get_thumbnail($width,$height,'',$arr[$i]["fulltitle"],$arr[$i]["fulltitle"]);
		$arr[$i]["thumb"] = $arr[$i]["thumbnail"]["thumb"];

		$arr[$i]["thumbnail_small"] = get_thumbnail($width_small,$height_small,'',$arr[$i]["fulltitle"],$arr[$i]["fulltitle"]);
		$arr[$i]["thumb_small"] = $arr[$i]["thumbnail_small"]["thumb"];

		$arr[$i]["use_timthumb"] = $arr[$i]["thumbnail"]["use_timthumb"];

		$arr[$i]['post_id'] = (int) get_the_ID();

		$i++;
	endwhile; wp_reset_query();	?>

	<div id="slides">
		<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
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
					<h2 class="title"><a href="<?php echo esc_url($arr[$i]["permalink"]); ?>"><?php echo esc_html($arr[$i]["title"]); ?></a></h2>
					<p><?php echo($arr[$i]["excerpt"]); ?></p>
					<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" class="readmore"><span><?php esc_html_e('read more','Professional'); ?></span></a>
				</div> <!-- end .description -->
			</div> <!-- end .slide -->
		<?php }; ?>
	</div> <!-- end #slides-->

	<div id="controllers">
		<div id="controllers-top"></div>

		<div id="controllers-main">
			<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
				<a href="#"<?php if($i == 1) echo(' class="active"'); if($i == $featured_num) echo(' class="last"'); ?> rel="<?php echo($i); ?>">
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
					<span class="overlay"></span>
					<span class="tooltip">
						<span class="heading"><?php echo esc_html($arr[$i]["fulltitle"]); ?></span>
						<span class="excerpt"><?php echo($arr[$i]["excerpt_small"]); ?></span>
						<span class="left-arrow"></span>
					</span> <!-- .tooltip -->
				</a>
			<?php }; ?>
		</div>

	</div> <!-- end #controllers -->

	<a href="#" id="left-arrow"><?php esc_html_e('Previous','Professional'); ?></a>
	<a href="#" id="right-arrow"><?php esc_html_e('Next','Professional'); ?></a>

</div> <!-- end #featured -->