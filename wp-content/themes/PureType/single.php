<?php get_header(); ?>

<div id="container">
<div id="left-div">
    <?php if (get_option('puretype_integration_single_top') <> '' && get_option('puretype_integrate_singletop_enable') == 'on') echo(get_option('puretype_integration_single_top')); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <!--Begin Post-->
    <div class="post-wrapper">
        <?php get_template_part('includes/postinfo'); ?>
        <?php if (get_option('puretype_integration_single_bottom') <> '' && get_option('puretype_integrate_singlebottom_enable') == 'on') echo(get_option('puretype_integration_single_bottom')); ?>
        <?php if (get_option('puretype_foursixeight') == 'on') { ?>
            <?php get_template_part('includes/468x60'); ?>
        <?php } ?>
        <div style="clear: both;"></div>
        <?php if (get_option('puretype_show_postcomments') == 'on') { ?>
            <?php comments_template('', true); ?>
        <?php }; ?>
    </div>
    <?php endwhile; ?>
    <?php else : ?>
        <?php get_template_part('includes/no-results'); ?>
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