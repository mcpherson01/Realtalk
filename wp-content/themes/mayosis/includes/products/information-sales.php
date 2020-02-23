<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
 global $edd_logs;
$single_count = $edd_logs->get_log_count(66, 'file_download');
$total_count  = $edd_logs->get_log_count('*', 'file_download');
$sales = edd_get_download_sales_stats( get_the_ID() );
$sales = $sales > 1 ? $sales . ' sales' : $sales . ' sale';
$price = edd_get_download_price(get_the_ID());
  ?>
   
             
                        <li class="release-info-block">
                        <div class="rel-info-tag released--info--flex">
                             <?php if( $price == "0.00"  ){ ?>
                              <?php esc_html_e('Downloads','mayosis'); ?>
                             <?php } else { ?>
                              <?php esc_html_e('Sales','mayosis'); ?>
                             <?php }?>
                           
                            </div> 
                            
                            <span class="released--info--flex">:</span>
                        
                        <div class="rel-info-value released--info--flex"> 
                        
                        <?php if( $price == "0.00"  ){ ?>
                                   <p><span><?php $download = $edd_logs->get_log_count(get_the_ID(), 'file_download'); echo ( is_null( $download ) ? '0' : $download ); ?> <?php esc_html_e('Downloads','mayosis');?></span></p>
                                   <?php } else { ?>
                                   <p><span><?php echo esc_html($sales); ?></span></p>
                                   <?php } ?>
                        
                        </div>
                          <div class="clearfix"></div>
                        </li>