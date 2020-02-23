			<!-- Featured Area -->
			<div id="featured-area">
				<div id="s1" class="pics" style="position: relative; overflow: hidden;">

<?php 				$ids = array(); $i = 1; $posts_num = (int) get_option('enews_homepage_featured');
					query_posts("posts_per_page=$posts_num&cat=".get_catId(get_option('enews_feat_cat')));
					while (have_posts()) : the_post(); ?>

						<?php
							$titletext = get_the_title();

							$thumbnail = get_thumbnail(510,206,'',$titletext,$titletext);
							$thumb = $thumbnail["thumb"];

							$thumbnail2 = get_thumbnail(45,45,'',$titletext,$titletext);
							$thumb2 = $thumbnail2["thumb"];

							$arr[$i]["thumb"] = $thumb2;
							$arr[$i]["use_timthumb"] = $thumbnail2["use_timthumb"];
							$arr[$i]["titletext"] = $titletext;

							$arr[$i]['post_id'] = (int) get_the_ID();
						?>

						<div style="width: 830px; position: absolute; top: 0px; left: 0px; display: block; z-index: 4; opacity: 1; height: 206px;">

							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, 510, 206); ?>

							<div class="featured-overlay"></div>

							<h5 class="meta">
							<?php if (get_option('enews_postinfo') ) { ?>
								<?php esc_html_e('POSTED','eNews') ?> <?php if (in_array('author', get_option('enews_postinfo'))) { ?> <?php esc_html_e('BY','eNews') ?> <span class="author"><?php the_author() ?></span><?php }; ?><?php if (in_array('categories', get_option('enews_postinfo'))) { ?> <?php esc_html_e('IN','eNews') ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('date', get_option('enews_postinfo'))) { ?> <?php esc_html_e('ON','eNews') ?> <?php the_time(get_option('enews_date_format')) ?><?php }; ?><?php if (in_array('comments', get_option('enews_postinfo'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','eNews'), esc_html__('1 comment','eNews'), '% '.esc_html__('comments','eNews')); ?><?php }; ?>
							<?php }; ?>
							</h5>
							<h1><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eNews'), get_the_title()) ?>"><?php truncate_title(20); ?></a></h1>
							<p><?php truncate_post(150); ?></p>

						</div>
<?php 				$ids[]= get_the_ID(); $i++;
					endwhile; wp_reset_query(); ?>

				</div>

				<!-- Featured posts thumbnails -->
				<ul id="nav">
					<?php $posts_num = $i-1; ?>
					<?php for ($i = 1; $i <= $posts_num; $i++) { ?>
						<li>
							<a href="#" <?php if ($i == 1) echo('class="activeSlide"'); ?>>
							<?php
								print_thumbnail( array(
									'thumbnail' 	=> $arr[$i]["thumb"],
									'use_timthumb' 	=> $arr[$i]["use_timthumb"],
									'alttext'		=> $arr[$i]["titletext"],
									'width'			=> 45,
									'height'		=> 45,
									'et_post_id'	=> $arr[$i]['post_id'],
								) );
							?>
							</a>
						</li>
					<?php } ?>
				</ul> <!-- end ul#nav -->

				<h3><?php esc_html_e('featured news','eNews') ?></h3>
				<div class="clear"></div>
				<a id="prev-item" href="#"><?php esc_html_e('Prev','eNews') ?></a>
				<a id="next-item" href="#"><?php esc_html_e('Next','eNews') ?></a>
			</div> <!-- end featured area -->