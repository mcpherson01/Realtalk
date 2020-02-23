<span class="current-category">
<?php single_cat_title(esc_html__('Currently Browsing: ','Bold'), 'display'); ?>
</span>
        <!--Begind recent post-->
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <div class="cat-post-wrap">

        <span class="post-info">

            <span class="post-date">
            <span class="post-date-inside"><?php the_time(get_option('bold_date_format')) ?></span><span class="date-right"></span>
            </span>

            <span class="post-author">
            <?php esc_html_e('Posted by','Bold') ?> <strong><?php the_author() ?></strong>
            </span>

            </span>
            <div style="clear: both;"></div>
                        <h2 class="post-title-2"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></h2>
            <div style="clear: both;"></div>

    <?php $width = 85;
          $height = 85;
          $classtext = 'featured-thumb';
          $titletext = get_the_title();

          $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
          $thumb = $thumbnail["thumb"]; ?>

    <?php if($thumb <> '') { ?>
        <div class="featured-thumb-wrapper">
            <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
                <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
            </a>
        </div>
    <?php } ?>

            <?php truncate_post(410); ?>

                <a href="<?php the_permalink() ?>" rel="bookmark" class="readmore" title="Permanent Link to <?php the_title(); ?>">
    <?php esc_html_e('read more','Bold') ?>
    </a>
    <div style="clear: both;"></div>
        </div>
        <?php endwhile; ?>
        <div style="clear: both;"></div>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
<p class="pagination">
    <?php next_posts_link(esc_html__('&laquo; Previous Entries','Bold')) ?>
    <?php previous_posts_link(esc_html__('Next Entries &raquo;','Bold')) ?>
</p>
<?php } ?>
    <?php else : ?>
    <!--If no results are found-->
    <div class="single-post-wrap">
    <h1><?php esc_html_e('No Results Found','Bold') ?></h1>
    <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Bold') ?></p>
    </div>
    <!--End if no results are found-->
    <?php endif; ?>
        <!--End recent post-->