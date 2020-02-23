<div id="sidebar-wrapper">
	<?php if(get_option('artsee_show_about') == 'on') { ?>
		<p class="slide2"><a href="#" class="btn-slide2"><?php esc_html_e('about us','ArtSee'); ?></a></p>
		<div id="panel2">
			<p class="panel-inside"><?php echo esc_html(get_option('artsee_about_us')); ?></p>
		</div>
		<!--End About Us Box-->
		<div style="clear: both;"></div>
	<?php }; ?>

	<?php if(get_option('artsee_show_random') == 'on') { ?>
		<!--Begin Random Posts-->
		<p class="slide3"><a href="#" class="btn-slide3"><?php esc_html_e('random posts','ArtSee'); ?></a></p>
		<div id="panel3">
			<?php $randomNum = (int) get_option('artsee_random_posts_num'); ?>
			<?php query_posts("orderby=rand&posts_per_page=$randomNum&ignore_sticky_posts=1");
			while (have_posts()) : the_post(); ?>
				<div class="random">
					<?php $width = 44;
						$height = 44;
						$classtext = '';
						$titletext = get_the_title();

						$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						$thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb != '') { ?>
						<div class="random-image">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
						</div>
					<?php }; ?>
					<div class="random-content">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','ArtSee'), the_title()) ?>">
							<?php truncate_title(50) ?>
						</a>
					</div>
				</div> <!-- end .random -->
			<?php endwhile; wp_reset_query(); ?>
			<div style="clear: both;"></div>
		</div> <!-- end #panel3 -->
		<!--End Random Posts-->
		<div style="clear: both;"></div>
	<?php }; ?>

	<?php if(get_option('artsee_show_recent_comments') == 'on') { ?>
		<!--Begin Recent Comments-->
		<p class="slide4"><a href="#" class="btn-slide4"><?php esc_html_e('recent comments','ArtSee'); ?></a></p>
		<div id="panel4">
			<div class="recent-comments">
				<?php $recentNum = get_option('artsee_recentcomments_num'); ?>
				<?php get_template_part('simple_recent_comments'); /* recent comments plugin by: www.g-loaded.eu */?>
				<?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments($recentNum, 60, '', ''); } ?>
			</div>
		</div> <!-- end #panel4 -->
		<!--End Recent Comments-->
		<div style="clear: both;"></div>
    <?php }; ?>

	<div id="sidebar">
        <?php if ( !function_exists('dynamic_sidebar') | !dynamic_sidebar('Sidebar') ) : ?>
        <?php endif; ?>
    </div> <!-- end #sidebar -->

</div> <!-- end #sidebar-wrapper -->