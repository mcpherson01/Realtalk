<?php $mayosis_video = get_post_meta($post->ID, 'video_url',true); ?>
<?php if ($mayosis_video){ ?>
    <a href="<?php echo esc_attr($mayosis_video); ?>" class="mayosis-play--button-video icon-play" data-lity>
        </a>

<?php } else { ?>

 <?php $thumb_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
 
  <a href="<?php echo esc_attr($thumb_image); ?>" class="mayosis-play--button-video icon-play" data-lity>
        </a>
<?php }?>