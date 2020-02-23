<div id="featured">
	<div id="featured-bottom">
		<h3 id="recommended"><span><?php esc_html_e('recommended products','InReview'); ?></span></h3>
		<a id="left-arrow" href="#"><?php esc_html_e('Previous','InReview'); ?></a>
		<a id="right-arrow" href="#"><?php esc_html_e('Next','InReview'); ?></a>
	<?php
		$arr = array();
		$i=1;

		$width = 320;
		$height = 204;

		$featured_cat = get_option('inreview_feat_cat');
		$featured_num = (int) get_option('inreview_featured_num');

		if (get_option('inreview_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
		else {
			global $pages_number;

			if (get_option('inreview_feat_pages') <> '') $featured_num = count(get_option('inreview_feat_pages'));
			else $featured_num = $pages_number;

			$et_featured_pages_args = array(
				'post_type' => 'page',
				'orderby' => 'menu_order',
				'order' => 'DESC',
				'posts_per_page' => (int) $featured_num,
			);

			if ( is_array( et_get_option( 'inreview_feat_pages', '', 'page' ) ) )
				$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'inreview_feat_pages', '', 'page' ) );

			query_posts( $et_featured_pages_args );
		};

		while (have_posts()) : the_post();
			global $post, $authordata;

			$arr[$i]["title"] = truncate_title(250,false);
			$arr[$i]["fulltitle"] = truncate_title(250,false);
			$arr[$i]["excerpt"] = truncate_post(290,false);

			$arr[$i]["metainfo"] = '';
			if ( get_option('inreview_postinfo1') <> '' ) {
				$arr[$i]["metainfo"] = esc_html__('Reviewed','InReview') . ' ';
				if ( in_array('author', get_option('inreview_postinfo1')) ) {
					$arr[$i]["metainfo"] .= esc_html__('by','InReview') . ' ' . '<a href="' . esc_attr(get_author_posts_url( $authordata->ID, $authordata->user_nicename )) .'">' . get_the_author() . '</a>' . ' ';
				}
				if (in_array('date', get_option('inreview_postinfo1'))) {
					$arr[$i]["metainfo"] .= esc_html__('on','InReview') . ' ' . get_the_time(get_option('inreview_date_format'))  . ' ';
				}
				if (in_array('categories', get_option('inreview_postinfo1'))) {
					$count = 0;
					$arr[$i]["metainfo"] .= esc_html__('in','InReview');
					foreach( get_the_category() as $category ){
						$count++;
						$arr[$i]["metainfo"] .= ( 1 != $count ? ', ' : ' '  ) . '<a href="' . esc_url( get_category_link( $category->cat_ID  ) ) . '">' . esc_html( $category->name ) . '</a>';
					}
				}
			}

			$et_inreview_settings = maybe_unserialize( get_post_meta(get_the_ID(),'_et_inreview_settings',true) );

			$arr[$i]["et_fs_variation"] = isset( $et_inreview_settings['et_fs_variation'] ) ? (bool) $et_inreview_settings['et_fs_variation'] : false;
			$arr[$i]["permalink"] = isset( $et_inreview_settings['et_fs_link'] ) && !empty($et_inreview_settings['et_fs_link']) ? $et_inreview_settings['et_fs_link'] : get_permalink();
			$arr[$i]["moretext"] = isset( $et_inreview_settings['et_fs_button'] ) && !empty($et_inreview_settings['et_fs_button']) ? $et_inreview_settings['et_fs_button'] : __( 'Click to Read The Full Review', 'InReview' );

			$arr[$i]["thumbnail"] = get_thumbnail($width,$height,'featured-image',$arr[$i]["fulltitle"],$arr[$i]["fulltitle"],true,'Featured');
			$arr[$i]["thumb"] = $arr[$i]["thumbnail"]["thumb"];
			$arr[$i]["use_timthumb"] = $arr[$i]["thumbnail"]["use_timthumb"];

			$arr[$i]["et_author_rating"] = get_post_meta(get_the_ID(),'_et_inreview_user_rating',true) ? get_post_meta(get_the_ID(),'_et_inreview_user_rating',true) : 0;
			$arr[$i]["et_comments_rating"] = get_post_meta(get_the_ID(),'_et_inreview_comments_rating',true) ? get_post_meta(get_the_ID(),'_et_inreview_comments_rating',true) : et_get_post_user_rating(get_the_ID());

			$arr[$i]['post_id'] = (int) get_the_ID();

			$i++;
		endwhile; wp_reset_query();	?>
		<div id="featured-slides">
			<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
				<div class="slide clearfix">
					<div class="featured-img<?php if ( $arr[$i]["et_fs_variation"] ) echo ' pngimage'; ?>">
						<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>">
						<?php
							print_thumbnail( array(
								'thumbnail' 	=> $arr[$i]["thumbnail"]["thumb"],
								'use_timthumb' 	=> $arr[$i]["thumbnail"]["use_timthumb"],
								'alttext'		=> $arr[$i]["fulltitle"],
								'width'			=> (int) $width,
								'height'		=> (int) $height,
								'class'			=> 'featured-image',
								'et_post_id'	=> $arr[$i]['post_id'],
							) );
						?>
							<?php if ( !$arr[$i]["et_fs_variation"] ) { ?>
								<span class="overlay"></span>
							<?php } ?>
						</a>
					</div> 	<!-- end .featured-img -->
					<div class="featured-description">
						<h2 class="featured-title"><a href="<?php echo esc_url($arr[$i]["permalink"]); ?>"><?php echo esc_html($arr[$i]["title"]); ?></a></h2>

						<?php if ( $arr[$i]["metainfo"] <> '' ) { ?>
							<p class="featured-meta"><?php echo $arr[$i]["metainfo"]; ?></p>
						<?php } ?>

						<?php if ( $arr[$i]["et_author_rating"] <> 0 ) { ?>
							<div class="rating-container">
								<div class="rating-inner clearfix">
									<span><?php esc_html_e('Author','InReview'); ?></span>
									<div class="review-rating">
										<div class="review-score" style="width: <?php echo esc_attr(et_get_star_rating($arr[$i]["et_author_rating"])); ?>px;"></div>
									</div>
								</div> <!-- end .rating-inner -->
							</div> <!-- end .rating-container -->
						<?php } ?>

						<?php if ( $arr[$i]["et_comments_rating"] <> 0 ) { ?>
							<div class="rating-container">
								<div class="rating-inner clearfix">
									<span><?php esc_html_e('Users','InReview'); ?></span>
									<div class="review-rating">
										<div class="review-score" style="width: <?php echo esc_attr(et_get_star_rating($arr[$i]["et_comments_rating"])); ?>px;"></div>
									</div>
								</div> <!-- end .rating-inner -->
							</div> <!-- end .rating-container -->
						<?php } ?>

						<div class="clear"></div>

						<p><?php echo $arr[$i]["excerpt"]; ?></p>
					</div> <!-- end .description -->
					<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" class="readmore"><span><?php echo esc_html($arr[$i]["moretext"]); ?></span></a>
				</div> <!-- end .slide -->
			<?php } ?>
		</div> <!-- end #featured-slides -->
	</div> <!-- end #featured-bottom -->
</div> <!-- end #featured -->