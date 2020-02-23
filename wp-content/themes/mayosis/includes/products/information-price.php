<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
 $download_id = get_the_ID();
  ?>
     <li class="release-info-block">
                        <div class="rel-info-tag released--info--flex"><?php esc_html_e('Price','mayosis'); ?></div> <span class="released--info--flex">:</span><div class="rel-info-value released--info--flex"> <p><?php edd_price($download_id); ?></p></div>
                         <div class="clearfix"></div>
                       </li>