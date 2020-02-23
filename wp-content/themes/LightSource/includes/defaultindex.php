
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<!--Begin Post-->

<div class="home-post-wrap">
    <h2 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','LightSource'), get_the_title()) ?>">
        <?php the_title() ?>
        </a></h2>
    <div style="clear: both;"></div>
    <?php get_template_part('includes/postinfo'); ?>
    <div style="clear: both;"></div>
    <?php get_template_part('includes/thumbnail'); ?>
    <?php truncate_post(610); ?>
</div>
<!--End Post-->
<?php endwhile; ?>
<div style="clear: both;"></div>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
<p class="pagination">
    <?php next_posts_link(esc_html__('&laquo; Previous Entries','LightSource')) ?>
    <?php previous_posts_link(esc_html__('Next Entries &raquo;','LightSource')) ?>
</p>
<?php } ?>
<?php else : ?>
<!--If no results are found-->
<h1><?php esc_html_e('No Results Found','LightSource') ?></h1>
<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','LightSource') ?></p>
<!--End if no results are found-->
<?php endif; ?>