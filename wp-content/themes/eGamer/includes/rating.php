<!--Begind recent Video-->

<div class="home-post-wrap"> <span class="home-post-titles"> <span style="float: left;"><?php esc_html_e('Recent Reviews','eGamer') ?></span> </span>
    <?php
 $querystr = "
    SELECT wposts.*
    FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
    WHERE wposts.ID = wpostmeta.post_id
    AND (wpostmeta.meta_key = 'rating_value'
    OR wpostmeta.meta_key = 'rating')
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
if ($ctr == "4") { break; }
else { ?>

    <?php $width = 43;
          $height = 43;

          $classtext = 'thumbnail-small';
          $titletext = get_the_title();

          $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'image_value');
          $thumb = $thumbnail["thumb"]; ?>

    <?php $rating = get_post_meta(get_the_ID(), 'rating_value', $single = true);
          $rating2 = get_post_meta(get_the_ID(), 'rating', $single = true); ?>

    <div class="post-inside-small">

        <?php if($thumb <> '') { ?>
            <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
                <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
            </a>
        <?php } ?>

        <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>" style="float: left;">
        <?php truncate_title(26) ?>
        </a> <img src="<?php echo get_template_directory_uri(); ?>/images/star-<?php if($rating2 <> '') { ?><?php echo get_post_meta(get_the_ID(), "rating", true); ?><?php } else { ?><?php echo esc_attr($rating); ?><?php }; ?>.gif" alt="rating" style="float: right;" /> <span class="post-info-small"><?php esc_html_e('Posted by','eGamer') ?>
        <?php the_author() ?>
        <?php esc_html_e('on','eGamer') ?>
        <?php the_time('m jS, Y') ?>
        </span> </div>
    <div style="clear: both;"></div>
    <?php $ctr++; } ?>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
<!--end recent Video-->