<!-- SUB POST DIVISIONS -->

<div class="subpost_wrap2">
    <div class="subpost_wrap">
        <div class="subpost_left">
		<?php $i = 0; ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php $i++; ?>

            <div class="subpost">

				<?php if ($i <= 4) { ?>
					<?php $width = 470;
						  $height = 110;

						  $classtext = 'large-thumb';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"];  ?>

					<h3><a href="<?php the_permalink(); ?>"><?php truncate_title(50); ?></a></h3>
					<?php if($thumb != '') { ?>
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					<?php } ?>

					<?php if (get_option('coldstone_postinfo1') ) { ?>
						<div class="post-info3"><?php get_template_part('includes/postinfo-create'); ?></div>
					<?php } ?>
					<div style="clear: both;"></div>
					<?php truncate_post(200); ?>
				<?php } else { ?>
					<?php $width = 62;
						  $height = 62;

						  $classtext = '';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"];  ?>

					<?php if($thumb != '') { ?>
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					<?php }; ?>
					<div class="sub_article">
						<h3><a href="<?php the_permalink(); ?>"><?php truncate_title(40); ?></a></h3>
						<?php if ( get_option( 'coldstone_postinfo_bar' ) == 'on' ) { ?>
							<div class="post-info3"><?php get_template_part('includes/postinfo-create'); ?></div>
						<?php } ?>
						<?php truncate_post(210); ?>
					</div>
				<?php } ?>
            </div><!-- subpost -->
            <div style="clear: both;"></div>
            <?php endwhile; ?>
            <?php if (get_option('coldstone_pagenavi') == 'on') { ?>
<div style="clear: both;"></div>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
<p class="pagination">
    <?php next_posts_link(esc_html__('&laquo; Previous Entries','ColdStone')) ?>
	<?php previous_posts_link(esc_html__('Next Entries &raquo;','ColdStone')) ?>
</p>
<?php } ?>
<?php } ?>
<?php endif; wp_reset_query(); ?>
        </div>
        <!-- /subpost_left -->
        <div class="life_wrap">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Main Sidebar") ) : ?>
            <?php endif; ?>
        </div>
        <!-- /life_wrap -->
        <div style="clear: both;"></div>
    </div>
    <div style="clear: both;"></div>
</div>
<!-- /subpost_wrap -->
<img src="<?php echo get_template_directory_uri(); ?>/img/pearl-<?php echo esc_attr(get_option( 'coldstone_color_scheme' )); ?>.jpg" style="float: left;" alt="<?php the_title(); ?>" />