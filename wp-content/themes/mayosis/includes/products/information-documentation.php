<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

  ?>
   
        
                        <?php $documentation = get_post_meta( $post->ID,'documentation',true ); if ( $documentation) { ?>
                        <li class="release-info-block">
                        <div class="rel-info-tag released--info--flex"><?php esc_html_e('Documentation','mayosis'); ?></div> <span class="released--info--flex">:</span> <div class="rel-info-value released--info--flex"><p><?php echo esc_html($documentation); ?></p></div>
                         <div class="clearfix"></div>
                        </li>
                        <?php } ?>