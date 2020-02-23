<?php get_header(); ?>

<div id="container">
<div id="left-div">
    <?php if (get_option('egamer_blog_style') == 'on') { ?>
    <?php get_template_part('includes/blogstylehome'); ?>
    <?php } else { get_template_part('includes/default'); } ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>