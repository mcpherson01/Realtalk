<!--Begind recent Video-->
<?php
 $querystr = "
    SELECT wposts.*
    FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
    WHERE wposts.ID = wpostmeta.post_id
    AND wpostmeta.meta_key = 'Video'
    AND wposts.post_status = 'publish'
    AND wposts.post_type = 'post'
    ORDER BY wposts.post_date DESC
 ";
 $pageposts = $wpdb->get_results($querystr, OBJECT);
  ?>
<?php if ($pageposts): ?>
<?php foreach ($pageposts as $post): ?>
<?php setup_postdata($post); ?>
<?php static $ctr = 0;
if ($ctr == "1") { break; }
else { ?>

<div class="home-post-wrap"> <span class="home-post-titles"> <span style="float: left;"><?php esc_html_e('Recent Videos','eGamer'); ?></span> <span class="comments-bubble">
    <?php comments_popup_link('0', '1', '%'); ?>
    </span> </span>
    <div class="post-inside"> <span class="post-info"><?php esc_html_e('Posted by','eGamer'); ?>
        <?php the_author() ?>
        <?php esc_html_e('on','eGamer'); ?>
        <?php the_time('m jS, Y') ?>
        </span> <?php echo get_post_meta($post->ID, "Video", true); ?> </div>
</div>
<?php $ctr++; } ?>
<?php endforeach; ?>
<?php endif; ?>
<!--end recent Video-->