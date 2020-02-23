<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$download_cats = get_the_term_list( get_the_ID(), 'download_category', '', _x('  ', '', 'mayosis' ), '' );
 
  ?>
   
             <li class="release-info-block">
                        <div class="rel-info-tag released--info--flex"><?php esc_html_e('Categories','mayosis'); ?></div> <span class="released--info--flex">:</span><div class="rel-info-value released--info--flex"> <p><?php echo '<span>' . $download_cats . '</span>'; ?></p></div>
                          <div class="clearfix"></div>
                        </li>