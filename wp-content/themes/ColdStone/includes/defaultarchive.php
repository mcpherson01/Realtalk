<?php get_header(); ?>

<div class="single_wrap">
    <div style="float:left;margin-top:25px;width:600px;">
            <div class="browsing">
            <h2>
                <?php esc_html_e('Browsing &raquo;','ColdStone') ?> <?php single_month_title(" ") ?>
            </h2>
        </div>

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="subpost" style="background:none;">

            <?php $width = 62;
                  $height = 62;

                  $classtext = 'catimage';
                  $titletext = get_the_title();

                  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
                  $thumb = $thumbnail["thumb"];  ?>

            <?php if($thumb != '') { ?>
                <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
            <?php } ?>

            <div class="sub_article" style="width: 420px;">
                <h3><a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                    </a></h3>
                <?php if (get_option('coldstone_postinfo1') ) { ?>
                    <div class="post-info2"><?php get_template_part('includes/postinfo-create'); ?></div>
                <?php } ?>
                <div style="color:#333;">
                    <?php the_excerpt(); ?>
                </div>
            </div>
            <!-- subpost -->
        </div>
        <?php endwhile; ?>
        <div style="clear: both;"></div>
        <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
        <p class="pagination">
            <?php next_posts_link(esc_html__('&laquo; Previous Entries','ColdStone')) ?>
            <?php previous_posts_link(esc_html__('Next Entries &raquo;','ColdStone')) ?>
        </p>
        <?php } ?>
        <?php else : ?>
        <h2 ><?php esc_html_e('No Results Found','ColdStone') ?></h2>
        <p><?php esc_html_e('Sorry, your search returned zero results.','ColdStone') ?> </p>
        <?php endif; ?>
    </div>
    <?php get_sidebar(); ?>
</div>
<div class="footer" style="height:15px;margin-bottom:0;"></div>
<?php get_footer(); ?>