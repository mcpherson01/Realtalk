<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php $width = (int) get_option('egamer_thumbnail_width_index');
	  $height = (int) get_option('egamer_thumbnail_height_index');

	  $classtext = 'thumbnail';
	  $titletext = get_the_title();

	  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'image_value');
	  $thumb = $thumbnail["thumb"];  ?>

<div class="home-post-wrap2">
    <h2 class="single-entry-titles"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
        <?php the_title() ?>
        </a></h2>
    <div class="single-entry">

		<?php if (get_option('egamer_index_thumbnails') == 'on') { ?>
			<?php if($thumb <> '') { ?>
				<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				</a>
			<?php }; ?>
		<?php }; ?>

        <?php if (get_option('egamer_postinfo3') ) { ?>
			<div class="post-info"><?php esc_html_e('Posted','eGamer') ?> <?php if (in_array('author', get_option('egamer_postinfo3'))) { ?> <?php esc_html_e('by','eGamer') ?> <?php the_author() ?><?php }; ?><?php if (in_array('date', get_option('egamer_postinfo3'))) { ?> <?php esc_html_e('on','eGamer') ?> <?php the_time(get_option('egamer_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('egamer_postinfo3'))) { ?> <?php esc_html_e('in','eGamer') ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('egamer_postinfo3'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','eGamer'), esc_html__('1 comment','eGamer'), '% '.esc_html__('comments','eGamer')); ?><?php }; ?>
			</div>
		<?php }; ?>

        <?php if (get_option('egamer_excerpt') == 'false') { ?>
        <?php truncate_post(310); ?>
        <?php } else { ?>
        <?php the_excerpt(); ?>
        <?php }; ?>
        <div style="clear: both;"></div>
        <a href="<?php the_permalink() ?>" rel="bookmark" style="float: right;" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/readmore.gif" alt="Read More of <?php the_title(); ?>" style="border: none;" /></a> </div>
</div>
<?php endwhile; ?>
<div style="clear: both;"></div>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
<p class="pagination">
    <?php next_posts_link(esc_html__('&laquo; Previous Entries','eGamer')) ?>
	<?php previous_posts_link(esc_html__('Next Entries &raquo;','eGamer')) ?>
</p>
<?php } ?>
<?php else : ?>
<!--If no results are found-->
<h1><?php esc_html_e('No Results Found','eGamer') ?></h1>
<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eGamer') ?></p>
<!--End if no results are found-->
<?php endif; ?>