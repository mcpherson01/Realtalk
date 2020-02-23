<?php $ebusiness_home_page_1 = str_replace('&amp;','&',get_option('ebusiness_home_page_1'));
      $ebusiness_home_page_2 = str_replace('&amp;','&',get_option('ebusiness_home_page_2'));
      $ebusiness_home_page_3 = str_replace('&amp;','&',get_option('ebusiness_home_page_3'));
      $ebusiness_home_page_4 = str_replace('&amp;','&',get_option('ebusiness_home_page_4'));
?>
<?php get_header(); ?>
<?php get_template_part('includes/scroller-' . esc_attr( get_option('ebusiness_scroller_number') ) ); ?>

<div id="home-container">
    <div id="home-wrap">
        <?php if (get_option('ebusiness_home_blog') == 'on') : ?>
        <div id="home-left">
            <?php query_posts('page_id=' . get_pageId(get_option('ebusiness_home_page_1')) ); while (have_posts()) : the_post(); ?>
            <div class="post-info-wrap-home"> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-1-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" />
                <h2 class="home-title-1">
                    <?php the_title(); ?>
                </h2>
                <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-1-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> </div>
            <div style="clear: both;"></div>
            <?php global $more;
$more = 0;
the_content(); ?>
            <?php endwhile; wp_reset_query(); ?>
        </div>
        <div id="home-right"> <img src="<?php echo get_template_directory_uri(); ?>/images/recent-top-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" />
            <div class="recent">
                <div style="position: relative;">
                    <div class="prev2"></div>
                    <div class="next2"></div>
                </div>
                <span class="blog-title"><?php esc_html_e('From the Blog','eBusiness') ?></span> <a href="<?php echo esc_attr(get_option('ebusiness_rss')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/rss.gif" alt="home title" class="rss-button" /></a>

                <div class="recent-scroll">
                    <ul>
                        <?php while (have_posts()) : the_post(); ?>

                        <?php $width = 35;
                              $height = 35;
                              $classtext = 'recent-thumb';
                              $titletext = get_the_title();

                              $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
                              $thumb = $thumbnail["thumb"];  ?>
                        <li>
                            <?php if($thumb != '') { ?>
                                <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eBusiness'), get_the_title()) ?>">
                                    <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
                                </a>
                            <?php } ?>

                            <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eBusiness'), get_the_title()) ?>" class="recent-link">
                                <?php truncate_title(42) ?>
                            </a>
                            <div class="recent-info">
                                <?php the_time(get_option('ebusiness_date_format')) ?>
                                |
                                <?php comments_popup_link(esc_html__('No Comments','eBusiness'), esc_html__('1 Comment','eBusiness'), esc_html__('% Comments','eBusiness')); ?>
                            </div>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>

            </div>
            <img src="<?php echo get_template_directory_uri(); ?>/images/recent-bottom-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> </div>
        <?php else : ?>
        <?php query_posts('page_id=' . get_pageId(get_option('ebusiness_home_page_1')) ); while (have_posts()) : the_post(); ?>
        <div class="post-info-wrap-home"> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" />
            <h2 class="home-title-1">
                <?php the_title(); ?>
            </h2>
            <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> </div>
        <div style="clear: both;"></div>
        <?php global $more;
$more = 0;
the_content(); ?>
        <?php endwhile; wp_reset_query(); ?>
        <?php endif; ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/line-bg-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-line" />
        <div style="clear: both;"></div>

        <?php if (get_option('ebusiness_home_page_number') != '1') : ?>
        <?php query_posts('page_id=' . get_pageId(get_option('ebusiness_home_page_2')) ); while (have_posts()) : the_post(); ?>
        <div class="post-info-wrap-home"> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" />
            <h2 class="home-title-1">
                <?php the_title(); ?>
            </h2>
            <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> </div>
        <div style="clear: both;"></div>
        <?php global $more;
$more = 0;
the_content(); ?>
        <?php endwhile; wp_reset_query(); ?>
        <?php endif; ?>

        <?php if (get_option('ebusiness_home_page_number') == '3') : ?>
        <?php query_posts('page_id=' . get_pageId(get_option('ebusiness_home_page_3')) ); while (have_posts()) : the_post(); ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/line-bg-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-line" />
        <div style="clear: both;"></div>
        <div class="post-info-wrap-home"> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" />
            <h2 class="home-title-1">
                <?php the_title(); ?>
            </h2>
            <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> </div>
        <div style="clear: both;"></div>
        <?php global $more;
$more = 0;
the_content(); ?>
        <?php endwhile; wp_reset_query(); ?>
        <?php else : ?>
        <?php endif; ?>
        <?php if (get_option('ebusiness_home_page_number') == '4') : ?>
        <?php query_posts('page_id=' . get_pageId(get_option('ebusiness_home_page_3')) ); while (have_posts()) : the_post(); ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/line-bg-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-line" />
        <div style="clear: both;"></div>
        <div class="post-info-wrap-home"> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" />
            <h2 class="home-title-1">
                <?php the_title(); ?>
            </h2>
            <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> </div>
        <div style="clear: both;"></div>
        <?php global $more;
$more = 0;
the_content(); ?>
        <?php endwhile; wp_reset_query(); ?>
        <?php query_posts('page_id=' . get_pageId(get_option('ebusiness_home_page_4')) ); while (have_posts()) : the_post(); ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/line-bg-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-line" />
        <div style="clear: both;"></div>
        <div class="post-info-wrap-home"> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" />
            <h2 class="home-title-1">
                <?php the_title(); ?>
            </h2>
            <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> </div>
        <div style="clear: both;"></div>
        <?php global $more;
$more = 0;
the_content(); ?>
        <?php endwhile; wp_reset_query(); ?>
        <?php else : ?>
        <?php endif; ?>
    </div>
    <div style="clear: both;"></div>
    <img src="<?php echo get_template_directory_uri(); ?>/images/content-bg-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="margin-top: 15px;" class="iehack" /> </div>
<?php get_footer(); ?>
</body></html>