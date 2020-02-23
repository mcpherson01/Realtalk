<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>

<div id="container">
<div id="left-div">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <!--Start Post-->
    <div class="post-wrapper">
        <h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
            <?php the_title(); ?></a></h1>
        <div style="clear: both;"></div>
        <?php if (get_option('puretype_page_thumbnails') == 'on') { get_template_part( 'includes/thumbnail'); } ?>
        <?php the_content(); ?>
        <div style="clear: both;"></div>
        <?php if (get_option('puretype_show_pagescomments') == 'on') { ?>
            <?php comments_template('', true); ?>
        <?php }; ?>
    </div>
    <?php endwhile; ?>
    <!--End Post-->
    <?php else : ?>
        <?php get_template_part('includes/no-results'); ?>
    <?php endif; ?>
</div>
</div>
<!--Begin Sidebar-->

<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>