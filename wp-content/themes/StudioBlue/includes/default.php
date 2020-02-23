<!--Begin Featured Article-->
<?php if (get_option('studioblue_featured') == 'on') get_template_part('includes/featured'); ?>
<!--End Featured Article-->

<?php $ctr = 1; ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php $thumb = '';
		  $width = 90;
		  $height = 90;
		  $classtext = 'no_border';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		  $thumb = $thumbnail["thumb"]; ?>

        <?php if (get_option('studioblue_blog_style') == 'false') { ?>
            <div class="home-post-wrap">

				<?php if (get_option('studioblue_postinfo_homedefault') ) { ?>
					<span class="post-info">
						<?php esc_html_e('Posted','StudioBlue'); ?> <?php if (in_array('author', get_option('studioblue_postinfo_homedefault'))) { ?> <?php esc_html_e('by','StudioBlue'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('studioblue_postinfo_homedefault'))) { ?> <?php esc_html_e('on','StudioBlue'); ?> <?php the_time(get_option('studioblue_date_format')) ?><?php }; ?><?php if (in_array('comments', get_option('studioblue_postinfo_homedefault'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','StudioBlue'), esc_html__('1 comment','StudioBlue'), '% '.esc_html__('comments','StudioBlue')); ?><?php }; ?>
					</span>
				<?php }; ?>

				<h2 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>">
					<?php truncate_title(26) ?></a></h2>
				<div style="clear: both;"></div>

				<?php if($thumb != '') { ?>
					<div class="thumbnail-div">
						<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
						</a>
					</div>
				<?php }; ?>

				<?php truncate_post(410) ?>
				<div style="clear: both;"></div>

				<div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>"><?php esc_html_e('Read More','StudioBlue'); ?></a></div>
            </div>

            <?php if (($ctr % 2) == 0) { ?>
                    <div style="clear: both;"></div>
            <?php }; ?>

            <?php $ctr++;  ?>
        <?php } else { get_template_part('includes/blogentry'); } ?>

<?php endwhile; ?>
	<?php if(get_option('studioblue_blog_style') == 'false') { ?>
		<?php if (get_option('studioblue_show_catboxes') == 'on') get_template_part('includes/catbox'); ?>
		<?php if (get_option('studioblue_show_popular') == 'on' || get_option('studioblue_show_random') == 'on') get_template_part('includes/popular'); ?>
	<?php } else { get_template_part('includes/navigation'); } ?>
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>