<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>

<div id="container" class="no_sidebar">
<div id="left-div">
    <div id="left-inside">
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <!--Start Post-->
        <div class="post-wrapper">
            <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','LightSource'), get_the_title()) ?>">
                <?php the_title(); ?>
                </a></h1>
            <?php if (get_option('lightsource_page_thumbnails') == 'on') { get_template_part('includes/thumbnail'); } ?>
            <?php the_content(); ?>
            <div style="clear: both;"></div>
            <?php if (get_option('lightsource_show_pagescomments') == 'on') { ?>
                <?php comments_template('', true); ?>
            <?php }; ?>
        </div>
        <?php endwhile; ?>
        <!--End Post-->
        <?php else : ?>
        <!--If no results are found-->
        <h1><?php esc_html_e('No Results Found','LightSource') ?></h1>
        <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','LightSource') ?></p>
        <!--End if no results are found-->
        <?php endif; ?>
    </div>
</div>
</div>
<!--Begin Sidebar-->

<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>