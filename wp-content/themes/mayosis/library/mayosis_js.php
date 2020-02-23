<?php
$minimalcontrol= get_theme_mod( 'thumb_video_control','full' );
function mayosis_video_script() { ?>
   <?php if ($minimalcontrol=='minimal') { ?>
<script>
    const playerhidecontrol = new Plyr('#mayosisplayergrid', {
    hideControls: true,
});
</script>  
<?php }?>
<?php }
add_action( 'wp_footer', 'mayosis_video_script' ); ?>