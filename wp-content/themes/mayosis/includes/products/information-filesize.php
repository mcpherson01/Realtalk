<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

  ?>
   
    <?php $file_size = get_post_meta($post->ID, 'file_size',true ); if ( $file_size) { ?>
                        <li class="release-info-block">
                        <div class="rel-info-tag released--info--flex"><?php esc_html_e('File Size','mayosis'); ?></div> <span class="released--info--flex">:</span> <div class="rel-info-value released--info--flex"><p><?php echo esc_html($file_size); ?></p></div>
                         <div class="clearfix"></div>
                        </li>
                        <?php } ?>