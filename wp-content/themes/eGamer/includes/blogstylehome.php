<?php if (get_option('egamer_featured') == 'on') { ?>
<div style="position: relative;">
    <div class="prev"></div>
    <div class="next"></div>
</div>
<div id="sections">
    <ul>

<?php
query_posts("posts_per_page=".get_option('egamer_homepage_featured')."&cat=".get_catId(get_option('egamer_feat_cat')));
while (have_posts()) : the_post(); ?>

    <?php $width = 619;
          $height = 253;

          $classtext = '';
          $titletext = get_the_title();

          $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'image_value');
          $thumb = $thumbnail["thumb"]; ?>

         <li class="thumbnail-div-featured" style="background-image: url('<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, '', true, true); ?>');">
            <div class="featured-inside"> <span class="post-info"><?php esc_html_e('Posted by','eGamer') ?>
                <?php the_author() ?>
                <?php esc_html_e('on','eGamer') ?>
                <?php the_time('F j, Y') ?>
                |
                <?php comments_popup_link(esc_html__('No Comments','eGamer'), esc_html__('1 Comment','eGamer'), '% '.esc_html__('comments','eGamer')); ?>
                </span> <a href="<?php the_permalink() ?>" rel="bookmark" class="titles-featured" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
                <?php truncate_title(36); ?>
                </a>
                <?php truncate_post(220); ?>
            </div>
        </li>
        <?php endwhile; wp_reset_query(); ?>
    </ul>
</div>
<?php }; ?>
<?php
if (have_posts()) : while (have_posts()) : the_post();?>
<!--Begin Post-->
<span class="single-entry-titles" style="margin-top: 18px;"></span>
<div class="post-wrapper">
    <div style="clear: both;"></div>
    <?php if (get_option('egamer_thumbnails') == 'false') { ?>
    <?php { echo ''; } ?>
    <?php } else { get_template_part('includes/thumbnail'); } ?>
    <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
        <?php the_title(); ?>
        </a></h2>

    <?php if (get_option('egamer_postinfo3') ) { ?>
        <div class="post-info"><?php esc_html_e('Posted','eGamer') ?> <?php if (in_array('author', get_option('egamer_postinfo3'))) { ?> <?php esc_html_e('by','eGamer') ?> <?php the_author() ?><?php }; ?><?php if (in_array('date', get_option('egamer_postinfo3'))) { ?> <?php esc_html_e('on','eGamer') ?> <?php the_time(get_option('egamer_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('egamer_postinfo3'))) { ?> <?php esc_html_e('in','eGamer') ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('egamer_postinfo3'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','eGamer'), esc_html__('1 comment','eGamer'), '% '.esc_html__('comments','eGamer')); ?><?php }; ?>
        </div>
    <?php }; ?>

    <?php the_content(); ?>
</div>
<?php endwhile; ?>
<!--End Post-->
<div style="clear: both;"></div>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
<p class="pagination">
    <?php next_posts_link(esc_html__('&laquo; Previous Entries','eGamer')) ?>
    <?php previous_posts_link(esc_html__('Next Entries &raquo;','eGamer')) ?>
</p>
<?php } ?>
<?php else : ?>
<!--If no results are found-->
<h1><?php esc_html_e('No Results Found','eGamer') ?></h1>
<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eGamer') ?></p>
<!--End if no results are found-->
<?php endif; ?>