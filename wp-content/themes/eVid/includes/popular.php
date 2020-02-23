<!--Begin Popular Articles-->

<div class="home-post-wrap-box" style="margin-top: 15px;"> <span class="headings"><?php esc_html_e('Popular Articles','eVid') ?></span>
    <div class="cat-box-items2">
<ul>
<?php
$evid_homepage_popular = (int) get_option('evid_homepage_popular');
$result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0, ".$evid_homepage_popular);
foreach ($result as $post) {
#setup_postdata($post);
$postid = (int) $post->ID;
$title = $post->post_title;
$commentcount = (int) $post->comment_count;
if ($commentcount != 0) { ?>
<li><a href="<?php echo esc_url(get_permalink($postid)); ?>" title="<?php echo esc_attr($title); ?>">
<?php echo esc_html($title); ?></a> (<?php echo esc_html($commentcount); ?>)</li>
<?php } } ?>
</ul>
    </div>
</div>
<!--End Popular Articles-->
<!--Begin Random Articles-->
<div class="home-post-wrap-box" style="margin-top: 15px;"> <span class="headings"><?php esc_html_e('Random Articles','eVid') ?></span>
    <div class="cat-box-items2">
        <ul>
            <?php $evid_homepage_random = (int) get_option('evid_homepage_random');
            query_posts("orderby=rand&posts_per_page=$evid_homepage_random&ignore_sticky_posts=1");
  while (have_posts()) : the_post(); ?>
            <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eVid'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></li>
            <?php endwhile; wp_reset_query(); ?>
        </ul>
    </div>
</div>
<!--End Random Articles-->