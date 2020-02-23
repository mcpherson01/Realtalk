<?php get_header(); ?>

<div id="container">
<div id="left-div">
    <div id="left-inside">
        <?php if (get_option('lightsource_integration_single_top') <> '' && get_option('lightsource_integrate_singletop_enable') == 'on') echo(get_option('lightsource_integration_single_top')); ?>
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <!--Begin Post-->
        <div class="post-wrapper">
            <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','LightSource'), get_the_title()) ?>">
                <?php the_title(); ?>
                </a></h1>
            <?php if(get_option('lightsource_postinfo2') ) { ?>
                <?php get_template_part('includes/postinfo'); ?>
            <?php } ?>
            <div style="clear: both;"></div>
            <?php if (get_option('lightsource_thumbnails') == 'on') { get_template_part( 'includes/thumbnail'); } ?>
            <?php the_content(); ?>
            <?php if (get_option('lightsource_integration_single_bottom') <> '' && get_option('lightsource_integrate_singlebottom_enable') == 'on') echo(get_option('lightsource_integration_single_bottom')); ?>
            <?php if (get_option('lightsource_foursixeight') == 'on') { get_template_part( 'includes/468x60'); } ?>
            <div style="clear: both;"></div>
            <?php if (get_option('lightsource_show_postcomments') == 'on') { ?>
                <?php comments_template('', true); ?>
            <?php }; ?>
            <?php endwhile; ?>
        </div>
        <?php else : ?>
        <!--If no results are found-->
        <h1><?php esc_html_e('No Results Found','LightSource') ?></h1>
        <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','LightSource') ?></p>
        <!--End if no results are found-->
        <?php endif; ?>
    </div>
</div>
<!--Begin Sidebar-->
<?php get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>