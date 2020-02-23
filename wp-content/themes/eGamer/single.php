<?php get_header(); ?>
<div id="container">
<div id="left-div">
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    <span class="single-entry-titles" style="margin-top: 18px;">

    <?php if (get_option('egamer_postinfo1') ) { ?>
        <?php if (in_array('author', get_option('egamer_postinfo1')) || in_array('date', get_option('egamer_postinfo1'))) { ?>
            <?php esc_html_e('Posted','eGamer') ?> <?php if (in_array('author', get_option('egamer_postinfo1'))) { ?> <?php esc_html_e('by','eGamer') ?> <?php the_author() ?><?php }; ?><?php if (in_array('date', get_option('egamer_postinfo1'))) { ?> <?php esc_html_e('on','eGamer') ?> <?php the_time(get_option('egamer_date_format')) ?><?php }; ?>
        <?php }; ?>
    <?php }; ?>

    </span>
    <div class="post-wrapper">
          <?php if (get_option('egamer_integration_single_top') <> '' && get_option('egamer_integrate_singletop_enable') == 'on') { ?>
                  <div style="clear: both;"></div>
          <?php echo(get_option('egamer_integration_single_top')); ?>
          <?php }; ?>
          <?php $rating = get_post_meta(get_the_ID(), 'rating_value', $single = true);
$rating2 = get_post_meta(get_the_ID(), 'rating', $single = true); ?>
       <div style="clear: both;"></div>
        <?php if (get_option('egamer_thumbnails') == 'false') { ?>
        <?php { echo ''; } ?>
        <?php } else { get_template_part('includes/thumbnail'); } ?>
        <h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
            <?php the_title(); ?>
            </a></h1>

        <?php if (get_option('egamer_postinfo1') ) { ?>
            <?php if (in_array('categories', get_option('egamer_postinfo1')) || in_array('comments', get_option('egamer_postinfo1'))) { ?>
                <div class="post-info"><?php if (in_array('categories', get_option('egamer_postinfo1'))) { ?><?php esc_html_e('Categories:','eGamer') ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('egamer_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','eGamer'), esc_html__('1 comment','eGamer'), '% '.esc_html__('comments','eGamer')); ?><?php }; ?></div>
            <?php }; ?>
        <?php }; ?>

        <?php $rating = get_post_meta(get_the_ID(), 'rating_value', $single = true); ?>
        <?php if($rating <> '') { ?>
        <img src="<?php bloginfo('template_directory'); ?>/images/star-large-<?php if($rating2 <> '') { ?><?php echo esc_html(get_post_meta(get_the_ID(), "rating", true)); ?><?php } else { ?><?php echo esc_html($rating); ?><?php }; ?>.gif" alt="Post Rating" />
        <?php } else { echo ''; } ?>
        <?php the_content(); ?>

               <div style="clear: both;"></div>
          <?php if (get_option('egamer_integration_single_bottom') <> '' && get_option('egamer_integrate_singlebottom_enable') == 'on') echo(get_option('egamer_integration_single_bottom')); ?>

    </div>
    <?php $video = get_post_meta(get_the_ID(), 'Video', $single = true); ?>
    <?php
if($video <> '') { ?>
    <span class="single-entry-titles" style="margin-top: 18px;"><?php esc_html_e('Play Video','eGamer') ?></span>
    <div class="post-wrapper" style="padding-top: 14px;"> <?php echo $video; ?> </div>
    <?php }
else { echo ''; } ?>

        <?php if (get_option('egamer_show_postcomments') == 'on') { ?>
    <span class="single-entry-titles" style="margin-top: 18px;"><?php esc_html_e('Post a Comment','eGamer') ?></span>
    <div class="post-wrapper">
        <div style="clear: both;"></div>
        <?php comments_template('',true); ?>
    </div>
    <?php }; ?>
    <?php endwhile; ?>
    <?php endif; ?>
</div>
<!--Begin Sidebar-->
<?php get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>