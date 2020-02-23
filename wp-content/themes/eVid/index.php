<?php get_header(); ?>
<div id="wrapper2" style="margin-top: -1px; background-position: 0px 0px;">
<div id="container">
<div id="left-div">
    <!--Begind recent post-->
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="home-post-wrap">
        <div class="home-post-wrap-top">
            <div class="comment-buble">
                <?php comments_popup_link('0', '1', '%'); ?>
            </div>
            <div class="date">
                <?php the_time('m jS, Y') ?>
            </div>
        </div>
        <div class="thumbnail-div">

            <?php $width = 189;
                  $height = 175;

                  $classtext = 'linkimage';
                  $titletext = get_the_title();

                  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
                  $thumb = $thumbnail["thumb"]; ?>

            <?php // if there's a thumbnail
                if($thumb != '') { ?>
                    <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
            <?php }; ?>

            <div class="overlay"> </div>
            <div class="post-info2">
                <h2 class="post-info-title"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eVid'), get_the_title()) ?>">
                    <?php truncate_title(30) ?>
                    </a></h2>
                <div style="clear: both;"></div>
                <?php get_template_part('includes/postinfo'); ?>
            </div>
        </div>
        <img src="<?php echo get_template_directory_uri(); ?>/images/post-bottom-<?php echo esc_attr(get_option('evid_color_scheme')); ?>.gif" style="margin: 0px 0px 0px 0px; float: left;" alt="post bottom" /> </div>
    <?php endwhile; ?>
    <div style="clear: both;"></div>
    <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
    <p class="pagination">
        <?php next_posts_link(esc_html__('&laquo; Previous Entries','eVid')) ?>
        <?php previous_posts_link(esc_html__('Next Entries &raquo;','eVid')) ?>
    </p>
    <?php } ?>
    <!--end recent post-->
    <?php else : ?>
    <!--If no results are found-->
    <h1><?php esc_html_e('No Results Found','eVid') ?></h1>
    <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eVid') ?></p>
    <!--End if no results are found-->
    <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>