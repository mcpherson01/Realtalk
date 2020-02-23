<?php include(TEMPLATEPATH . '/header.php'); ?>

	<div id="main-rightarea">
		<div class="topbg"></div>

		<?php for($i=0; $i < $home_pages_num; $i++) { ?>
			<div class="block" id="<?php if ($i==0) echo('home'); else echo esc_attr($pagesContent[$i]['hash']); ?>">

				<?php if ($i==0) { ?>
					<?php if (get_option('glider_quote') == 'on') {?>
						<div id="tagline">
							<p id="quote1"><?php echo html_entity_decode( get_option('glider_quote_one'), ENT_QUOTES ); ?></p>
							<p id="quote2"><?php echo html_entity_decode( get_option('glider_quote_two'), ENT_QUOTES ); ?></p>
						</div> <!-- #tagline -->
					<?php } ?>
				<?php } ?>

				<?php if ( isset($pagesContent[$i]['portfolio']) && !$pagesContent[$i]['portfolio'] ) { ?>
					<div class="content-area">
						<?php if ($pagesContent[$i]['thumbnail'] <> '' && get_option('glider_page_thumbnails') == 'on') { ?>
							<div class="thumb">
							<?php print_thumbnail($pagesContent[$i]['thumbnail'], $pagesContent[$i]['use_timthumb'], $pagesContent[$i]['title'], $width, $height, ''); ?>
								<span class="overlay"></span>
							</div> <!-- .thumb -->
						<?php } ?>
						<h2 class="title"><?php echo esc_html( $pagesContent[$i]['title'] ); ?></h2>
						<?php echo $pagesContent[$i]['content']; ?>
					</div> <!-- .content-area -->
				<?php } else { ?>
					<?php
						if ( isset($pagesContent[$i]['title']) ){ ?>
							<h2 class="gallery-title"><?php echo esc_html($pagesContent[$i]['title']); ?></h2>
					<?php } ?>

					<div class="gallery-area clearfix">
						<?php $j = 0;
							$glider_portfolio_categories = isset($pagesContent[$i]['portfolio_categories']) ? $pagesContent[$i]['portfolio_categories'] : '';
						?>
						<?php query_posts("posts_per_page=100&cat=".$glider_portfolio_categories); ?>
							<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
								<?php
									$thumb = '';
									$width2 = 133;
									$height2 = 133;
									$classtext = '';
									$titletext = get_the_title();
									$thumbnail = get_thumbnail($width2,$height2,$classtext,$titletext,$titletext,true);

									$thumb = $thumbnail['thumb']; ?>
								<?php if ($thumb <> '') { ?>
									<?php $j++; ?>
                                    <div class="thumb-wrap">
                                        <div class="thumb<?php if ($j % 4 == 0) echo(' last'); ?>">
                                            <div class="image">
                                                <a href="<?php echo esc_attr($thumbnail['fullpath']); ?>" rel="gallery" title="<?php the_title_attribute(); ?>" class="fancybox">
                                                    <?php print_thumbnail($thumb, $thumbnail['use_timthumb'], $titletext, $width2, $height2, ''); ?>
                                                    <span class="overlay"></span>
                                                    <span class="magnify"></span>
                                                </a>
                                            </div>
                                        </div> <!-- .thumb -->
                                    </div>
									<?php if ($j % 4 == 0) { ?>
										<div class="separate clear"></div>
									<?php } ?>
								<?php } ?>
							<?php endwhile; endif; wp_reset_query(); ?>
					</div> <!-- .gallery-area -->
				<?php } ?>
			</div> <!-- .block -->
		<?php } ?>

	</div> <!-- #main-rightarea -->

<?php get_footer(); ?>