<?php get_header(); ?>

<div id="content">
<img src="<?php echo get_template_directory_uri(); ?>/images/content-top.gif" alt="top" style="float: left;" />
<div id="left-div">
    <div style="font-size: 20px; margin: 50px;"><?php esc_html_e('Sorry, the page your requested could not be found, or no longer exists.','Bold'); ?> </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>