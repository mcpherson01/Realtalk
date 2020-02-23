<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>

<div id="container" class="no_sidebar">
<div id="left-div">
    <div id="left-inside">
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <!--Start Post-->
        <span class="single-entry-titles" style="margin-top: 18px;"></span>
        <div class="post-wrapper">
                  <?php if (get_option('egamer_integration_single_top') <> '' && get_option('egamer_integrate_singletop_enable') == 'on') { ?>
                  <div style="clear: both;"></div>
          <?php echo(get_option('egamer_integration_single_top')); ?>
          <?php }; ?>
          <div style="clear: both;"></div>
        <?php if (get_option('egamer_page_thumbnails') == 'on') { ?>
            <?php $width = (int) get_option('egamer_thumbnail_width_pages');
                  $height = (int) get_option('egamer_thumbnail_height_pages');

                  $classtext = 'linkimage';
                  $titletext = get_the_title();

                  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'image_value');
                  $thumb = $thumbnail["thumb"];  ?>

            <?php if($thumb <> '') { ?>
                <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
                    <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
                </a>
            <?php } ?>

        <?php }; ?>
            <h1 class="post-title" style="margin-top: 13px;"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
                <?php the_title(); ?>
                </a></h1>
            <?php the_content(); ?>
                      <?php if (get_option('egamer_integration_single_bottom') <> '' && get_option('egamer_integrate_singlebottom_enable') == 'on') { ?>
                  <div style="clear: both;"></div>
          <?php echo(get_option('egamer_integration_single_bottom')); ?>
          <?php }; ?>
        </div>
        <?php $video = get_post_meta($post->ID, 'Video', $single = true); ?>
    <?php
if($video <> '') { ?>
    <span class="single-entry-titles" style="margin-top: 18px;"><?php esc_html_e('Play Video','eGamer') ?></span>
    <div class="post-wrapper" style="padding-top: 14px;"> <?php echo $video; ?> </div>
    <?php }
else { echo ''; } ?>

        <?php if (get_option('egamer_show_pagescomments') == 'on') { ?>
    <span class="single-entry-titles" style="margin-top: 18px;"><?php esc_html_e('Post a Comment','eGamer') ?></span>
    <div class="post-wrapper">
        <div style="clear: both;"></div>
        <?php comments_template('',true); ?>
    </div>
    <?php }; ?>
        <?php endwhile; ?>
        <!--End Post-->
        <?php else : ?>
        <!--If no results are found-->
        <h1><?php esc_html_e('No Results Found','eGamer') ?></h1>
        <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eGamer') ?></p>
        <!--End if no results are found-->
        <?php endif; ?>
    </div>
</div>
<!--Begin Sidebar-->

<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>