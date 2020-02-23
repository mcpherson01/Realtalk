<?php $mayosis_audio = get_post_meta($post->ID, 'audio_url',true); ?>
<div class="mayosis-title-audio">
   <?php echo do_shortcode('[audio src="'.$mayosis_audio.'"]'); ?>
</div>