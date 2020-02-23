
<div id="container"> <img src="<?php echo get_template_directory_uri(); ?>/images/content-top-home.gif" alt="logo" style="float: left;" />
    <div id="left-div">
        <!--Begind recent post-->
        <span class="current-category">
        <?php single_cat_title(esc_html__('Currently Browsing: ','CherryTruffle'), 'display'); ?>
        </span>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="home-post-wrap">
            <div class="date">
                <div class="month">
                    <?php the_time('M') ?>
                </div>
                <div style="clear: both;"></div>
                <div class="day">
                    <?php the_time('j') ?>
                </div>
            </div>
            <div class="post-right">
            <?php if (get_option('cherrytruffle_index_info') == 'on') { ?>
                <div class="featured-categories">
                    <?php the_category('') ?>
                </div>
                <span class="author-link">
                <?php the_author_posts_link(); ?>
                </span>
                <?php }; ?>
                <div style="clear: both;"></div>
                <h2 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','CherryTruffle'), get_the_title()) ?>">
                    <?php the_title() ?>
                    </a></h2>
                <div style="clear: both;"></div>

                <?php if (get_option('cherrytruffle_thumbnails_index') == 'on') { ?>
                    <?php $width = (int) get_option('cherrytruffle_thumbnail_width_index');
                          $height = (int) get_option('cherrytruffle_thumbnail_height_index');
                          $classtext = 'thumbnail';
                          $titletext = get_the_title();

                          $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
                          $thumb = $thumbnail["thumb"];  ?>

                    <?php if($thumb != '') { ?>
                        <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','CherryTruffle'), get_the_title()) ?>">
                            <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
                        </a>
                    <?php } ?>
                <?php }; ?>

                <?php truncate_post(410); ?>
            </div>
        </div>
        <?php endwhile; ?>
        <div style="clear: both;"></div>
        <div style="margin-left: 110px; margin-top: 5px;">
            <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
            <p class="pagination">
                <?php next_posts_link(esc_html__('&laquo; Previous Entries','CherryTruffle')) ?>
                <?php previous_posts_link(esc_html__('Next Entries &raquo;','CherryTruffle')) ?>
            </p>
            <?php } ?>
        </div>
        <?php else : ?>
        <!--If no results are found-->
        <h1><?php esc_html_e('No Results Found','CherryTruffle') ?></h1>
        <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','CherryTruffle') ?></p>
        <!--End if no results are found-->
        <?php endif; ?>
    </div>
    <?php get_sidebar(); ?>
    <img src="<?php echo get_template_directory_uri(); ?>/images/content-bottom.gif" alt="logo" style="float: left;" /> </div>