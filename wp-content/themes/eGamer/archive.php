<?php get_header(); ?>

<div id="container">
<div id="left-div">
    <?php if (get_option('egamer_blog_style') == 'Blog Style') { ?>
    <?php get_template_part('includes/blogstyle'); ?>
    <?php } else { get_template_part('includes/defaultindex'); } ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>