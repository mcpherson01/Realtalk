<!--Begin Most Commented Articles-->

<span class="headings"><?php esc_html_e('popular articles','PureType') ?></span>
<div class="home-sidebar-box">
<ul>
<?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , 8");
foreach ($result as $post) {
#setup_postdata($post);
$postid = (int) $post->ID;
$title = $post->post_title;
$commentcount = (int) $post->comment_count;
if ($commentcount != 0) { ?>
<li><a href="<?php echo esc_url(get_permalink($postid)); ?>" title="<?php echo esc_attr($title); ?>">
<?php echo esc_html($title); ?> (<?php echo esc_html($commentcount); ?>)</a> </li>
<?php } } ?>
</ul>
</div>
<!--End Most Commented Articles-->
<!--Begin Random Articles-->
<span class="headings"><?php esc_html_e('random articles','PureType') ?></span>
<div class="home-sidebar-box">
    <ul>
        <?php $puretype_random = (int) get_option( 'puretype_random' );
		$my_query = new WP_Query("orderby=rand&posts_per_page=$puretype_random;");
while ($my_query->have_posts()) : $my_query->the_post();
?>
        <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
            <?php truncate_title(40) ?>
            </a></li>
        <?php endwhile; ?>
    </ul>
</div>
<!--End Random Articles-->