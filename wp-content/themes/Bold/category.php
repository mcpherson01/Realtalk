<?php get_header(); ?>
<div id="content">
<img src="<?php echo get_template_directory_uri(); ?>/images/content-top.gif" alt="top" style="float: left;" />
<div id="left-div">
    <?php if (get_option('bold_blog_style') == 'on') { ?>
		<?php get_template_part('includes/blogstylecat'); ?>
    <?php } else { get_template_part('includes/defaultcat'); } ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

</body>
</html>