<div class="home-post-wrap2">
    <div style="clear: both;"></div>
    <!--Begin Post-->

        <h2 class="titles"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>">
            <?php the_title() ?>
            </a></h2>
        <?php get_template_part('includes/postinfo'); ?>
        <?php the_content(); ?>
    <div style="clear: both; margin-bottom: 10px;"></div>
</div>