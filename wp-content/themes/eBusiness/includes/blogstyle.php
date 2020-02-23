    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

<div class="home-post-wrap-2">
    <h1 class="titles"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eBusiness'), get_the_title()) ?>">
        <?php the_title(); ?>
        </a></h1>

    <?php if (get_option('ebusiness_postinfo1') ) : ?>
        <div class="post-info-wrap"> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> <span class="post-info"><?php esc_html_e('Posted','eBusiness') ?> <?php if (in_array('author', get_option('ebusiness_postinfo1'))) { ?> <?php esc_html_e('by','eBusiness') ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('ebusiness_postinfo1'))) { ?> <?php esc_html_e('on','eBusiness') ?> <?php the_time(get_option('ebusiness_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('ebusiness_postinfo1'))) { ?> <?php esc_html_e('in','eBusiness') ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('ebusiness_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','eBusiness'), esc_html__('1 comment','eBusiness'), '% '.esc_html__('comments','eBusiness')); ?><?php }; ?></span> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> </div>
    <?php endif; ?>

    <div style="clear: both;"></div>

    <?php if (get_option('ebusiness_thumbnails') == 'on') get_template_part('includes/thumbnail'); ?>

    <?php the_content(); ?>
</div>
<?php endwhile; ?>
<div style="clear: both;"></div>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
<p class="pagination">
    <?php next_posts_link(esc_html__('&laquo; Previous Entries','eBusiness')) ?>
    <?php previous_posts_link(esc_html__('Next Entries &raquo;','eBusiness')) ?>
</p>
<?php } ?>
<?php else : ?>
<!--If no results are found-->
<div class="home-post-wrap-2">
    <h1><?php esc_html_e('No Results Found','eBusiness') ?></h1>
    <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eBusiness') ?></p>
</div>
<!--End if no results are found-->
<?php endif; ?>
<?php if (is_home()) wp_reset_query(); ?>