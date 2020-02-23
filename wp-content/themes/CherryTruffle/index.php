<?php get_header(); ?>
<?php if (get_option('cherrytruffle_blog_style') == 'on') { ?>
<?php get_template_part('includes/blogstyle'); ?>
<?php } else { get_template_part('includes/default'); } ?>
<?php get_footer(); ?>
</body>
</html>