<?php get_header(); ?>

<div class="single_wrap">
    <div class="single_post">
        <?php if (get_option('coldstone_integration_single_top') <> '' && get_option('coldstone_integrate_singletop_enable') == 'on') echo(get_option('coldstone_integration_single_top')); ?>

        <?php while (have_posts()) : the_post(); ?>
        <h1><a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
            </a></h1>
        <?php if (get_option('coldstone_postinfo2') ) { ?>
            <div class="post-info"><?php get_template_part('includes/postinfo-create'); ?></div>
        <?php } ?>
        <div style="clear: both;"></div>
        <?php if (get_option('coldstone_thumbnails') == 'on') { get_template_part('includes/thumbnail'); } ?>
        <?php the_content(); edit_post_link(); ?>
        <div style="clear: both;"></div>
        <?php if (get_option('coldstone_integration_single_bottom') <> '' && get_option('coldstone_integrate_singlebottom_enable') == 'on') echo(get_option('coldstone_integration_single_bottom')); ?>
        <?php if (get_option('coldstone_foursixeight') == 'on') { get_template_part('includes/468x60'); } ?>
        <?php if (get_option('coldstone_show_postcomments') == 'on') { ?>
            <?php comments_template('', true); ?>
        <?php }; ?>
        <!-- /single_post -->
        <?php endwhile;?>
    </div>
    <?php get_sidebar(); ?>
</div>
<div class="footer" style="height:15px;margin-bottom:0;"></div>
<?php get_footer(); ?>