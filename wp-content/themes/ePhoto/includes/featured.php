<?php $feat_cat = (int) get_catId(get_option('ephoto_feat_cat')); ?>
<div style="clear: both;"></div>
<div class="featured">
    <div id="sections">
        <ul><?php
            $ephoto_homepage_featured = (int) get_option('ephoto_homepage_featured');
        ?>
            <?php $my_query = new WP_Query("cat=$feat_cat&posts_per_page=$ephoto_homepage_featured;");
while ($my_query->have_posts()) : $my_query->the_post(); ?>

            <?php $width = 655;
                  $height = 364;
                  $classtext = '';
                  $titletext = get_the_title();

                  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
                  $thumb = $thumbnail["thumb"]; ?>

            <li style="background-image: url('<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, '', true, true); ?>');">
                <div class="sections-overlay">
                    <?php $video = get_post_meta(get_the_ID(), 'Video', $single = true); ?>
                    <?php if($video <> '') : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title() ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/play.png" alt="zoom" class="zoom" /></a>
                    <?php else : ?>
                        <a href="<?php echo esc_url($thumbnail["fullpath"]); ?>" title="<?php the_title() ?>" rel="featured" class="fancybox"><img src="<?php echo get_template_directory_uri(); ?>/images/zoom.png" alt="" class="zoom" /></a>
                    <?php endif; ?>
                </div>
            </li>
            <?php endwhile; wp_reset_postdata(); ?>
        </ul>
    </div> <!-- -end sections -->
    <div id="featured-right">
        <div id="sections2">
            <ul>
                <?php $my_query = new WP_Query("cat=$feat_cat&posts_per_page=$ephoto_homepage_featured;");
while ($my_query->have_posts()) : $my_query->the_post(); ?>

                <li>
                    <h2 class="featured-title"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','ePhoto'), get_the_title()) ?>">
                        <?php truncate_title(20) ?>
                        </a></h2>
                    <div class="featured-info"><?php esc_html_e('Posted by','ePhoto') ?>
                        <?php the_author() ?>
                        |
                        <?php the_time(get_option('ephoto_date_format')) ?>
                    </div>
                    <?php truncate_post(250); ?>
                    <div style="clear: both;"></div>
                    <a href="<?php the_permalink() ?>" class="featured-readmore"><?php esc_html_e('read more','ePhoto') ?></a> </li>
                <?php endwhile; wp_reset_postdata(); ?>
            </ul>
        </div> <!-- -end sections2 -->
        <div style="clear: both;"></div>
        <div id="featured-button">
            <div class="prev">
                <div class="prev-hover"> </div>
            </div>
            <div class="next">
                <div class="next-hover"></div>
            </div>
        </div> <!-- -end featured-bottom -->
    </div> <!-- -end featured-right -->
</div> <!-- -end featured -->