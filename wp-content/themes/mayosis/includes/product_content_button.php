<?php
defined('ABSPATH') or die();
$download_id = get_the_ID();
$producttopsocialbuttons= get_theme_mod( 'product_top_social_share','show' );
$livepreviewtext= get_theme_mod( 'live_preview_text','Live Preview' );
$showcartonfree= get_theme_mod( 'free_product_cart_button','hide' );

?>
	
 <div class="single-product-buttons product-top-button-flex">
                         <?php 
                                global $edd_logs;
                                $single_count = $edd_logs->get_log_count(66, 'file_download');
                                $total_count  = $edd_logs->get_log_count('*', 'file_download');
                                $price = edd_get_download_price(get_the_ID());
                                ?>
                           <?php if( $price == "0.00"  ){ ?>
                           <?php if ($showcartonfree=='show'){?>
                           <div class="product_top_flex product-cart-flex-button">
                               <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>
                               </div>
                           <?php }?>
                           <?php } else { ?>
                   
                           <div class="product_top_flex product-cart-flex-button">
                            <?php if(edd_has_variable_prices($download_id)):?>
        					<a class="btn btn-primary multiple_button_v" href="#variablepricemodal">
                                 <?php esc_html_e('Purchase','mayosis'); ?>
                                </a>
				
				<?php else: ?>
				<?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>
                     
			<?php endif; ?>
			
		
                             
                           </div>
                           
                           	<?php } ?>
                           <?php $demo_link =  get_post_meta($post->ID, 'demo_link', true); ?>
       <?php if ( $demo_link ) { ?>
                      <div class="product_top_flex comment-button">
                         
                               <a href="<?php echo esc_html($demo_link); ?>" class="btn btn-default" target="_blank"><?php echo esc_html($livepreviewtext); ?></a>
                                 
                        
                     </div>
                     <?php } ?>
                           <?php if ($producttopsocialbuttons=='show'): ?>
                         <div class="product_top_flex">
                         <?php if(function_exists('mayosis_productbreadcrubm')){
                               mayosis_productbreadcrubm();
                            } ?>  
                        
                            </div>
                            <?php endif; ?>
                   </div>