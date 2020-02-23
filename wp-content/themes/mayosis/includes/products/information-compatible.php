<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

  ?>
   
   
                        <?php $compatib_with = get_post_meta($post->ID, 'compatible_with',true ); if ( $compatib_with) { ?>
                        <li class="release-info-block">
                        <div class="rel-info-tag released--info--flex"><?php esc_html_e('Compatible With','mayosis'); ?></div> <span class="released--info--flex">:</span> <div class="rel-info-value released--info--flex"><p><?php echo esc_html($compatib_with); ?></p></div>
                         <div class="clearfix"></div>
                        </li>
                        <?php } ?>