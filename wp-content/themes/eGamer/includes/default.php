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
                <?php comments_popup_link(esc_html__('No Comments','eGamer'), esc_html__('1 Comment','eGamer'), esc_html__('% Comments','eGamer')); ?>
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

<?php if (get_option('egamer_video') == 'false') { ?>
<?php { echo ''; } ?>
<?php } else { get_template_part('includes/video'); } ?>
<?php if (get_option('egamer_rating') == 'false') { ?>
<?php { echo ''; } ?>
<?php } else { get_template_part('includes/rating'); } ?>

 <div style="clear: both;"></div>
<?php
if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php $width = 90;
      $height = 90;

      $classtext = 'thumbnail';
      $titletext = get_the_title();

      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'image_value');
      $thumb = $thumbnail["thumb"];  ?>

<div class="home-post-wrap">
    <div class="home-post-titles">
        <h2><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
            <?php truncate_title(36); ?>
            </a></h2>

        <?php if (get_option('egamer_postinfo2') ) { ?>
            <?php if (in_array('comments', get_option('egamer_postinfo2'))) { ?>
                <span class="comments-bubble"><?php comments_popup_link('0', '1', '%'); ?></span>
            <?php }; ?>
        <?php }; ?>
    </div>
    <div class="post-inside">

        <?php if (get_option('egamer_postinfo2') ) { ?>
            <?php if (in_array('author', get_option('egamer_postinfo2')) || in_array('date', get_option('egamer_postinfo2'))) { ?>
                <span class="post-info"><?php esc_html_e('Posted','eGamer') ?> <?php if (in_array('author', get_option('egamer_postinfo2'))) { ?> <?php esc_html_e('by','eGamer') ?> <?php the_author() ?><?php }; ?><?php if (in_array('date', get_option('egamer_postinfo2'))) { ?> <?php esc_html_e('on','eGamer') ?> <?php the_time(get_option('egamer_date_format')) ?><?php }; ?>
                </span>
            <?php }; ?>
        <?php }; ?>

        <?php if($thumb <> '') { ?>
            <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
                <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
            </a>
        <?php }; ?>

        <?php truncate_post(385); ?>
        <div style="clear: both;"></div>
        <a href="<?php the_permalink() ?>" rel="bookmark" style="float: right;" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>"><img src="<?php bloginfo('template_directory'); ?>/images/readmore.gif" alt="Read More of <?php the_title(); ?>" style="border: none;" /></a> </div>
</div>
<?php endwhile; ?>
        <div style="clear: both;"></div>
<?php if (get_option('egamer_home_navi') == 'on') { ?>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
<p class="pagination">
    <?php next_posts_link(esc_html__('&laquo; Previous Entries','eGamer')) ?>
    <?php previous_posts_link(esc_html__('Next Entries &raquo;','eGamer')) ?>
</p>
<div style="clear: both;"></div>
<?php } ?>
<?php } ?>
<?php if (get_option('egamer_popular_display') == 'on') { ?>
<!--Begind Popular Articles-->
<div class="home-post-wrap-2"> <span class="home-post-titles"> <span style="float: left;"><?php esc_html_e('Popular Articles','eGamer') ?></span> </span>
    <div class="post-inside-small">
<ul class="list2">
<?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 ,".get_option('egamer_popular_count')."");
foreach ($result as $post) {
#setup_postdata($post);
$postid = (int) $post->ID;
$title = $post->post_title;
$commentcount = (int) $post->comment_count;
if ($commentcount != 0) { ?>
<li><a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title ?>">
<?php echo $title ?></a> (<?php echo esc_html($commentcount); ?>)</li>
<?php } } ?>
</ul>
    </div>
</div>
<!--end Popular Articles-->
<?php }; ?>
<?php if (get_option('egamer_random_display') == 'on') { ?>
<!--Begind Random Articles-->
<div class="home-post-wrap-2"> <span class="home-post-titles"> <span style="float: left;"><?php esc_html_e('Random Articles','eGamer') ?></span> </span>
    <div class="post-inside-small">
        <ul>
        <?php $my_query = new WP_Query('orderby=rand&posts_per_page='.get_option('egamer_random_count').'');
while ($my_query->have_posts()) : $my_query->the_post();
?>
            <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></li>
            <?php endwhile; wp_reset_postdata(); ?>
        </ul>
    </div>
</div>
<!--end Random Articles-->
<?php }; ?>
<?php else : ?>
<!--If no results are found-->
<h1><?php esc_html_e('No Results Found','eGamer') ?></h1>
<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eGamer') ?></p>
<!--End if no results are found-->
<?php endif; ?>