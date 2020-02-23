<?php get_header(); ?>
<?php if (get_option('cherrytruffle_blog_style') == 'on') { ?>
<?php get_template_part('includes/blogstylecat'); ?>
<?php } else { get_template_part('includes/defaultcat'); } ?>
<?php get_footer(); ?>
</body>
</html>