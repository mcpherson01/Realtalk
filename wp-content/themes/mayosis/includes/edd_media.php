
<?php if ( has_post_format( 'audio' )) { ?>

 <div class="mayosis-main-media">
<?php get_template_part( 'library/mayosis_audio' ); ?>
</div>
<?php } ?>

<?php if ( has_post_format( 'video' )) { ?>
<div class="mayosis-main-media">
<?php get_template_part( 'library/mayosis-video-box' ); ?>
</div>
<?php } ?>
