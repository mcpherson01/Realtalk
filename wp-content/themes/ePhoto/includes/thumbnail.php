<?php $width = 141;
	  $height = 141;
	  $classtext = '';
	  $titletext = get_the_title();

	  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
	  $thumb = $thumbnail["thumb"]; ?>

<div class="thumbnail-wrap">
    <div class="thumbnail-div">
    <div style="background-image: url('<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, '', true, true); ?>'); width: 141px; height: 141px;">
		<img src="<?php echo get_template_directory_uri(); ?>/images/thumbnail-shadow.png" alt="bottom" class="thumbnail-shadow" />
     <div class="sections-overlay">
     <?php $video = get_post_meta($post->ID, 'Video', $single = true); ?>
<?php if($video != '') : ?>
          <a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/play.png" alt="zoom" class="zoom" /></a>
	 <?php else : ?>
		<a href="<?php echo esc_url($thumbnail["fullpath"]); ?>" title="<?php the_title() ?>" rel="gallery" class="fancybox"><img src="<?php echo get_template_directory_uri(); ?>/images/zoom.png" alt="" class="zoom" /></a>
     <?php endif; ?>
     <a href="<?php the_permalink() ?>" class="readmore"><?php esc_html_e('read more >>','ePhoto') ?></a></div> <!-- end section-overlay-->
        </div> <!-- end thumbnail-shadow-->
        </div> <!-- end thumbnail-div-->
</div> <!-- end thumbnail-wrap-->