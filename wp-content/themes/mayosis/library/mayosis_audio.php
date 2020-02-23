 <?php $mayosis_audio = get_post_meta($post->ID, 'audio_url',true); ?>
                          
<audio id="mayosisplayer" controls>
    <source src="<?php echo esc_url($mayosis_audio);?>" type="audio/mp3" />
   
</audio>