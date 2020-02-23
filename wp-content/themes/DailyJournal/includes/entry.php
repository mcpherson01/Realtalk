<?php
	if ( ! is_home() ) get_template_part( 'includes/top_info' );
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article class="note-block entry post">
		<div class="note">
			<div class="note-inner">
				<div class="note-content">
					<div class="post-title">
						<span class="post-meta"><?php echo get_the_time( get_option('dailyjournal_date_format') ); ?></span>
						<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					</div>
					<div class="post-content clearfix">
						<?php
							$thumb = '';
							$width = (int) apply_filters('et_image_width',113);
							$height = (int) apply_filters('et_image_height',113);
							$classtext = '';
							$titletext = get_the_title();
							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
							$thumb = $thumbnail["thumb"];
						?>
						<?php if ( '' != $thumb && 'on' == get_option('dailyjournal_thumbnails_index') ) { ?>
							<div class="post-image">
								<a href="<?php the_permalink(); ?>">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
									<span class="overlay"></span>
								</a>
							</div> 	<!-- end .post-image -->
						<?php } ?>

						<div class="entry_content">
							<?php if (get_option('dailyjournal_blog_style') == 'on') the_content(''); else { ?>
								<p><?php truncate_post(450); ?></p>
							<?php } ?>
						</div> <!-- end .entry_content -->
					</div>
					<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e('Read More', 'DailyJournal'); ?></a>
				</div> <!-- end .note-content-->
			</div> <!-- end .note-inner-->
		</div> <!-- end .note-->
		<div class="note-bottom-left">
			<div class="note-bottom-right">
				<div class="note-bottom-center"></div>
			</div>
		</div>
	</article> 	<!-- end .post-->
<?php
endwhile;
	if (function_exists('wp_pagenavi')) { wp_pagenavi(); }
	else { get_template_part('includes/navigation','entry'); }
else:
	get_template_part('includes/no-results','entry');
endif; ?>