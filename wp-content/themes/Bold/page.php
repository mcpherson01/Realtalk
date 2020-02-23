<?php get_header(); ?>
<div id="content">
<img src="<?php echo get_template_directory_uri(); ?>/images/content-top.gif" alt="top" style="float: left;" />
<div id="left-div">

    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

 <div class="single-post-wrap">

            <div style="clear: both;"></div>
                        <h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></h2>


        <div style="clear: both;"></div>

        <?php if (get_option('bold_page_thumbnails') == 'on') { ?>

            <?php $width = (int) get_option('bold_thumbnail_width_pages');
                      $height = (int) get_option('bold_thumbnail_height_pages');
                      $classtext = '';
                      $titletext = get_the_title();

                $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
                $thumb = $thumbnail["thumb"];  ?>

            <?php if($thumb <> '') { ?>
                <div class="thumbnail-div">
                    <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
                        <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
                    </a>
                </div>
            <?php } ?>

        <?php }; ?>

        <?php the_content(); ?>

        <div style="clear: both;"></div>
        <?php if (get_option('bold_show_pagescomments') == 'on') comments_template('', true); ?>

        <?php if (get_option('bold_foursixeight') == 'Enable') { ?>
        <?php get_template_part('includes/468x60'); ?>
        <?php } else { echo ''; } ?>

        </div>




        <?php endwhile; ?>

    <?php else : ?>
    <!--If no results are found-->
    <h1><?php esc_html_e('No Results Found','Bold') ?></h1>
    <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Bold') ?></p>
    <!--End if no results are found-->
    <?php endif; ?>

</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

</body>
</html>