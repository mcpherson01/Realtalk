
<div id="container2"> <img src="<?php echo get_template_directory_uri(); ?>/images/content-top-home-2.gif" alt="logo" style="float: left;" />
    <div id="left-div">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="post-wrapper" style="margin-bottom: 40px;">
            <h1 class="titles2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_html__('Permanent Link to %s','CherryTruffle'), get_the_title()) ?>">
                <?php the_title(); ?>
                </a></h1>
            <div style="clear: both;"></div>

            <?php if (get_option('cherrytruffle_postinfo') ) { ?>
                <div class="post-info"><?php esc_html_e('Posted','CherryTruffle') ?> <?php if (in_array('author', get_option('cherrytruffle_postinfo'))) { ?> <?php esc_html_e('by','CherryTruffle') ?> <span class="author"><strong><?php the_author() ?></strong></span><?php }; ?><?php if (in_array('date', get_option('cherrytruffle_postinfo'))) { ?> <?php esc_html_e('on','CherryTruffle') ?> <strong><?php the_time(get_option('cherrytruffle_date_format')) ?></strong><?php }; ?><?php if (in_array('categories', get_option('cherrytruffle_postinfo'))) { ?> <?php esc_html_e('in','CherryTruffle') ?> <strong><?php the_category(', ') ?></strong><?php }; ?><?php if (in_array('comments', get_option('cherrytruffle_postinfo'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','CherryTruffle'), esc_html__('1 comment','CherryTruffle'), '% '.esc_html__('comments','CherryTruffle')); ?><?php }; ?>
                </div>
                <img src="<?php echo get_template_directory_uri(); ?>/images/comment-bottom.gif" alt="logo" style="float: left; margin-bottom: 20px;" />
                <div style="clear: both;"></div>
            <?php }; ?>

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

            <?php the_content(); ?>
        </div>
        <?php endwhile; ?>
        <div style="clear: both;"></div>
        <div style="margin-left: 20px; margin-top: 5px;">
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
    <img src="<?php echo get_template_directory_uri(); ?>/images/content-bottom-2.gif" alt="logo" style="float: left;" /> </div>