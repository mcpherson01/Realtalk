<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

  ?>
        <li class="release-info-block">
                        <div class="rel-info-tag released--info--flex"><?php esc_html_e('Released','mayosis'); ?></div> <span class="released--info--flex">:</span><div class="rel-info-value released--info--flex"> <p><?php echo esc_html(get_the_date()); ?></p></div>
                         <div class="clearfix"></div>
                       </li>