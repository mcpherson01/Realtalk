<?php get_header(); ?>

<div id="container2">
    <div id="left-div2">
        <?php if (is_category(get_catId(get_option('ephoto_blog_cat'))) ) { ?>
        <?php get_template_part('includes/blogcat'); ?>
        <?php } else { get_template_part('includes/defaultindex'); } ?>
    </div>
    <?php get_sidebar(); ?>
    <div id="bottom">
		<?php get_template_part('includes/footer-area'); ?>
    </div>
</div>
<?php get_footer(); ?>
</body></html>