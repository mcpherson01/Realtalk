<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

  ?>
        <li class="release-info-block">
                        <div class="rel-info-tag released--info--flex"><?php esc_html_e('Last Updated','mayosis'); ?></div> <span class="released--info--flex">:</span><div class="rel-info-value released--info--flex"> <p><?php esc_html(the_modified_date()); ?></p></div>
                          <div class="clearfix"></div>
                        </li>