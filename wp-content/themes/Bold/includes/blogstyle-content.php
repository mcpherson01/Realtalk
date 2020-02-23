 <div class="single-post-wrap">

        <span class="post-info-single">

            <span class="post-date">
            <span class="post-date-inside"><?php the_time(get_option('bold_date_format')) ?></span><span class="date-right"></span>
            </span>

            <?php if(get_option('bold_postinfo1') ) { ?>
				<span class="post-author">
					<?php esc_html_e('Posted','Bold') ?> <?php if (in_array('author', get_option('bold_postinfo1'))) { ?> <?php esc_html_e('by','Bold') ?> <strong><?php the_author_posts_link(); ?></strong><?php }; ?><?php if (in_array('date', get_option('bold_postinfo1'))) { ?> <?php esc_html_e('on','Bold') ?> <strong><?php the_time(get_option('bold_date_format')) ?></strong><?php }; ?><?php if (in_array('categories', get_option('bold_postinfo1'))) { ?> <?php esc_html_e('in','Bold') ?> <strong><?php the_category(', ') ?></strong><?php }; ?><?php if (in_array('comments', get_option('bold_postinfo1'))) { ?> | <strong><?php comments_popup_link(esc_html__('0 comments','Bold'), esc_html__('1 comment','Bold'), '% '.esc_html__('comments','Bold')); ?></strong><?php }; ?>
				</span>
			<?php }; ?>

        </span>
            <div style="clear: both;"></div>
                        <h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></h2>


        <div style="clear: both;"></div>

	<?php if (get_option('bold_thumbnails') == 'on') { ?>

		<?php $width = (int) get_option('bold_thumbnail_width_posts');
		  $height = (int) get_option('bold_thumbnail_height_posts');
		  $classtext = '';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		  $thumb = $thumbnail["thumb"]; ?>

		<?php if($thumb <> '') { ?>
			<div class="thumbnail-div">
				<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				</a>
			</div>
		<?php } ?>

    <?php }; ?>

	<?php the_content(); ?>
	<div style="clear: both;"></div>

        <?php if (get_option('bold_foursixeight') == 'Enable') { ?>
        <?php get_template_part('includes/468x60'); ?>
        <?php } else { echo ''; } ?>

</div>