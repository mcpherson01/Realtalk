<span class="current-category">
<?php single_cat_title(esc_html__('Currently Browsing: ','Basic'), 'display'); ?>
</span>
<!--Begind recent post-->

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="home-post-wrap">
    <h1 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Basic'), get_the_title()) ?>">
        <?php the_title() ?>
        </a></h1>
    <?php get_template_part('includes/postinfo'); ?>
    <div style="clear: both;"></div>

    <?php $width = 190;
          $height = 190;

          $classtext = 'thumbnail';
          $titletext = get_the_title();

          $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
          $thumb = $thumbnail["thumb"];  ?>
    <?php if($thumb != '') { ?>
        <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Basic'), get_the_title()) ?>">
            <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
        </a>
    <?php } ?>

<div>
    <?php truncate_post(610); ?>
</div>
    <a href="<?php the_permalink() ?>" rel="bookmark" class="readmore" title="<?php printf(esc_attr__('Permanent Link to %s','Basic'), get_the_title()) ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/readmore.gif" alt="read more" style="border: none;" /></a> </div>
<?php endwhile; ?>
<div style="clear: both;"></div>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
<p class="pagination">
    <?php next_posts_link(esc_html__('&laquo; Previous Entries','Basic')) ?>
    <?php previous_posts_link(esc_html__('Next Entries &raquo;','Basic')) ?>
</p>
<?php } ?>
<!--end recent post-->
<?php else : ?>
<!--If no results are found-->
<div class="home-post-wrap2">
    <h1><?php esc_html_e('No Results Found','Basic') ?></h1>
    <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Basic') ?></p>
</div>
<!--End if no results are found-->
<?php endif; ?>