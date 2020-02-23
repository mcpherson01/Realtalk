<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php if (get_option('dailyjournal_integration_single_top') <> '' && get_option('dailyjournal_integrate_singletop_enable') == 'on') echo (get_option('dailyjournal_integration_single_top')); ?>

	<article class="note-block entry post">
		<div class="note">
			<div class="note-inner">
				<div class="note-content">
					<div class="post-title">
						<span class="post-meta"><?php echo get_the_time( get_option('dailyjournal_date_format') ); ?></span>
						<h1><?php the_title(); ?></h1>
					</div>
					<div class="post-content clearfix">
						<?php
							$thumb = '';
							$width = (int) apply_filters('et_image_width',113);
							$height = (int) apply_filters('et_image_height',113);
							$classtext = '';
							$titletext = get_the_title();
							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Single');
							$thumb = $thumbnail["thumb"];
						?>
						<?php if ( '' <> $thumb && 'on' == get_option( 'dailyjournal_thumbnails' ) ) { ?>
							<div class="post-image">
								<a href="<?php the_permalink(); ?>">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
									<span class="overlay"></span>
								</a>
							</div> 	<!-- end .post-image -->
						<?php } ?>
						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.esc_attr__('Pages','DailyJournal').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php edit_post_link(esc_attr__('Edit this page','DailyJournal')); ?>
					</div> <!-- end .post-content -->
				</div> <!-- end .note-content-->
			</div> <!-- end .note-inner-->
		</div> <!-- end .note-->
		<div class="note-bottom-left">
			<div class="note-bottom-right">
				<div class="note-bottom-center"></div>
			</div>
		</div>
	</article> 	<!-- end .post-->

	<?php if (get_option('dailyjournal_integration_single_bottom') <> '' && get_option('dailyjournal_integrate_singlebottom_enable') == 'on') echo(get_option('dailyjournal_integration_single_bottom')); ?>

	<?php
		if ( get_option('dailyjournal_468_enable') == 'on' ){
			if ( get_option('dailyjournal_468_adsense') <> '' ) echo( get_option('dailyjournal_468_adsense') );
			else { ?>
			   <a href="<?php echo esc_url(get_option('dailyjournal_468_url')); ?>"><img src="<?php echo esc_attr(get_option('dailyjournal_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
	<?php 	}
		}
	?>

	<?php
		if ( 'on' == get_option('dailyjournal_show_postcomments') ) comments_template('', true);
	?>
<?php endwhile; // end of the loop. ?>