<?php get_header(); ?>
<div id="container">
<div id="left-div">
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

    <!--Begin Post-->
    <div class="home-post-wrap2">
        <?php if (get_option('cion_share_this_pages') == 'on') { ?>
            <?php get_template_part( 'includes/share' ); ?>
        <?php }; ?>
                 <?php if (get_option('cion_integration_single_top') <> '' && get_option('cion_integrate_singletop_enable') == 'on') echo(get_option('cion_integration_single_top')); ?>
        <h1 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>">
            <?php the_title(); ?>
            </a></h1>

        <?php if (get_option('cion_postinfo1') ) { ?>
            <div class="post-info"><?php esc_html_e('Posted','Cion') ?> <?php if (in_array('author', get_option('cion_postinfo1'))) { ?> <?php esc_html_e('by','Cion') ?> <?php the_author() ?><?php }; ?><?php if (in_array('date', get_option('cion_postinfo1'))) { ?> <?php esc_html_e('on','Cion') ?> <?php the_time(get_option('cion_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('cion_postinfo1'))) { ?> <?php esc_html_e('in','Cion') ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('cion_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','Cion'), esc_html__('1 comment','Cion'), '% '.esc_html__('comments','Cion')); ?><?php }; ?></div>
        <?php }; ?>

        <div style="clear: both;"></div>

        <?php if (get_option('cion_thumbnails') == 'on') { ?>
            <?php $width = (int) get_option('cion_thumbnail_width_posts');
                  $height = (int) get_option('cion_thumbnail_height_posts');

                  $classtext = 'thumbnail';
                  $titletext = get_the_title();

                  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
                  $thumb = $thumbnail["thumb"]; ?>

            <?php if($thumb != '') { ?>
                <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>" class="thumbnail-link">
                    <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
                </a>
            <?php } ?>
        <?php }; ?>

        <?php the_content(); ?>
    </div>
    <!--Begin 468x60 Ad Block-->
    <?php if (get_option('cion_468_enable') == 'on') { ?>
    <?php get_template_part('includes/468x60'); ?>
    <?php } else { echo ''; } ?>
    <!--End 468x60 Ad Block-->

    <div style="clear: both;"></div>
          <?php if (get_option('cion_integration_single_bottom') <> '' && get_option('cion_integrate_singlebottom_enable') == 'on') echo(get_option('cion_integration_single_bottom')); ?>
        <div style="clear: both;"></div>
        <?php if (get_option('cion_show_postcomments') == 'on') { ?>
    <div class="home-post-wrap2" style="margin-top: 10px;">
        <?php comments_template('',true); ?>
    </div>
    <?php }; ?>

    <?php endwhile; ?>
    <?php else : ?>
    <!--If no results are found-->
    <div class="home-post-wrap2">
        <h1><?php esc_html_e('No Results Found','Cion') ?></h1>
        <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Cion') ?></p>
    </div>
    <!--End if no results are found-->
    <?php endif; ?>
</div>
<!--Begin Sidebar-->
<?php get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>