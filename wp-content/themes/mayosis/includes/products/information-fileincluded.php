<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

  ?>
      <?php $file_type = get_post_meta( $post->ID,'file_type',true ); if ( $file_type) { ?>
                        <li class="release-info-block">
                        <div class="rel-info-tag released--info--flex"><?php esc_html_e('File Included','mayosis'); ?></div> <span class="released--info--flex">:</span> <div class="rel-info-value released--info--flex"><p><?php echo esc_html($file_type); ?></p></div>
                         <div class="clearfix"></div>
                        </li>
                        <?php } ?>