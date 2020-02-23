<?php get_header(); ?>
<?php if ( get_option('cion_featured') == 'on' ) get_template_part('includes/featured'); ?>

<!--Begin About Us Section-->

<div class="about">
    <div class="about-div"> <img src="<?php echo esc_attr( et_new_thumb_resize( et_multisite_thumbnail( esc_url( get_option('cion_about_image') ) ), 90, 90, '', true ) ); ?>" alt=""  style="border: none;" /> </div>
    <span class="h3-titles"><?php esc_html_e('About Me','Cion')?></span> <?php echo get_option( 'cion_about' ); ?> </div>
<!--End About Us Section-->
<!--Begin Sidebar Tabbed Menu-->
<div class="about">
    <ul class="idTabs">
        <li><a href="#recententries"><?php esc_html_e('Recent','Cion')?></a></li>
        <li><a href="#recentcomments2"><?php esc_html_e('Comments','Cion')?></a></li>
        <li><a href="#randomarticles"><?php esc_html_e('Random','Cion')?></a></li>
        <li><a href="#populararticles"><?php esc_html_e('Popular','Cion')?></a></li>
    </ul>
    <div style="clear: both;"></div>
    <div id="recententries">
        <ul>
        <?php $my_query = new WP_Query('posts_per_page='.get_option('cion_recent_count').'');
while ($my_query->have_posts()) : $my_query->the_post();
?>
            <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>">
                <?php truncate_title(50) ?>
                </a></li>
            <?php endwhile; ?>
        </ul>
    </div>
    <div id="recentcomments2">
        <?php include (TEMPLATEPATH . '/simple_recent_comments.php'); /* recent comments plugin by: www.g-loaded.eu */ ?>
        <?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments(''.get_option('cion_comment_count').'', 40, '', ''); } ?>
    </div>
    <div id="randomarticles">
        <ul>
        <?php $my_query = new WP_Query('orderby=rand&posts_per_page='.get_option('cion_random_count').'');
while ($my_query->have_posts()) : $my_query->the_post();
?>
            <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>">
                <?php truncate_title(50) ?>
                </a></li>
            <?php endwhile; ?>
        </ul>
    </div>
    <div id="populararticles">
        <ul>
<?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 ,".get_option('cion_popular_count')."");
foreach ($result as $post) {
#setup_postdata($post);
$postid = (int) $post->ID;
$title = $post->post_title;
$commentcount = (int) $post->comment_count;
if ($commentcount != 0) { ?>
<li><a href="<?php echo esc_url(get_permalink($postid)); ?>" title="<?php echo esc_attr( $title ); ?>">
<?php echo esc_html( $title ); ?></a> (<?php echo esc_html( $commentcount ) ?>)</li>
<?php } } ?>
        </ul>
    </div>
</div>
<!--End Sidebar Tabbed Menu-->
<div id="container">
<div id="left-div">
    <!--Begind recent post (single)-->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="home-post-wrap2">
        <h2 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>">
            <?php the_title(); ?>
            </a></h2>

            <?php if (get_option('cion_postinfo3') ) { ?>
                <div class="post-info"><?php esc_html_e('Posted','Cion') ?> <?php if (in_array('author', get_option('cion_postinfo3'))) { ?> <?php esc_html_e('by','Cion') ?> <?php the_author() ?><?php }; ?><?php if (in_array('date', get_option('cion_postinfo3'))) { ?> <?php esc_html_e('on','Cion') ?> <?php the_time(get_option('cion_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('cion_postinfo3'))) { ?> <?php esc_html_e('in','Cion') ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('cion_postinfo3'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','Cion'), esc_html__('1 comment','Cion'), '% '.esc_html__('comments','Cion')); ?><?php }; ?>
                </div>
                <div style="clear: both;"></div>
            <?php }; ?>

        <?php if (get_option('cion_blog_style') == 'on') { ?>
            <?php if (get_option('cion_thumbnails') == 'on') { ?>

                <?php $width = (int) get_option('cion_thumbnail_width_posts');
                      $height = (int) get_option('cion_thumbnail_height_posts');

                      $classtext = 'thumbnail';
                      $titletext = get_the_title();

                      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
                      $thumb = $thumbnail["thumb"]; ?>

                <?php if($thumb != '') { ?>

                    <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>" class="thumbnail-link">
                        <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
                    </a>
                <?php } ?>
            <?php }; ?>
            <?php the_content(); ?>
        <?php } else { ?>
            <?php if (get_option('cion_index_thumbnails') == 'on') { ?>

                <?php $width = (int) get_option('cion_thumbnail_width_index');
                      $height = (int) get_option('cion_thumbnail_height_index');

                      $classtext = 'thumbnail';
                      $titletext = get_the_title();

                      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
                      $thumb = $thumbnail["thumb"]; ?>

                <?php if($thumb != '') { ?>
                    <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>" class="thumbnail-link">
                        <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
                    </a>
                <?php } ?>
            <?php }; ?>
            <?php truncate_post(440); ?>
            <div style="clear: both;"></div>
        <?php }; ?>


        <div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>"><?php esc_html_e('Read More','Cion') ?></a></div>
    </div>
    <?php endwhile; ?>
    <!--end recent post (single)-->
    <div style="clear: both;"></div>
    <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
    <p class="pagination">
        <?php next_posts_link(esc_html__('&laquo; Previous Entries','Cion')) ?>
        <?php previous_posts_link(esc_html__('Next Entries &raquo;','Cion')) ?>
    </p>
    <?php } ?>
    <?php else : ?>
    <!--If no results are found-->
    <div class="home-post-wrap2">
        <h1><?php esc_html_e('No Results Found','Cion') ?></h1>
        <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Cion') ?></p>
    </div>
    <!--End if no results are found-->
    <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>