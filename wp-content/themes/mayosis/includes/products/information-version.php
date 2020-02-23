<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

  ?>
   
                        
        <?php $product_version = get_field( 'product_version' ); if ( $product_version ) { ?>
        <li class="release-info-block">
        <div class="rel-info-tag released--info--flex"><?php esc_html_e('Version','mayosis'); ?></div> <span class="released--info--flex">:</span> <div class="rel-info-value released--info--flex"><p><?php echo esc_html($product_version); ?></p></div>
         <div class="clearfix"></div>
        </li>
        <?php } ?>