 <?php
/**
 * @package mayosis
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$producthoverbottom= get_theme_mod( 'product_hover_bottom','share' );
?>
                                                           
                                                           <?php if ($producthoverbottom =='cart'): ?>
                                                            <?php 
															$eddOptionAddtocart=edd_get_option( 'add_to_cart_text' );
															$addCartText=(isset($eddOptionAddtocart) && $eddOptionAddtocart  != '') ?$eddOptionAddtocart:esc_html__("Add to cart","mayosis");
															if(edd_has_variable_prices(get_the_ID())){														
																$defaultPriceID=edd_get_default_variable_price( get_the_ID() );
																$mayosisPricecart=array('edd_action'=>'add_to_cart','download_id'=>get_the_ID(),'edd_options[price_id]'=>$defaultPriceID);
															}
															else{
																$mayosisPricecart=array('edd_action'=>'add_to_cart','download_id'=>get_the_ID());
															}	
															?>
													
														
												<a href="<?php echo esc_url(add_query_arg($mayosisPricecart)); ?>" class="overlay_cart_btn">
											<i class="fa fa-shopping-cart"></i>	 <?php esc_html_e('Add To Cart', 'mayosis'); ?></a>   
						
							 <?php elseif ($producthoverbottom=='share'): ?>
							
                                            <div class="product-hover-social-share">
                                                <?php get_template_part( 'includes/social-share-grid' ); ?>
                                            </div>
                                            
                    <?php elseif ($producthoverbottom=='sales'): ?>
                    	                                    <?php 
																	global $edd_logs;
															$single_count = $edd_logs->get_log_count(66, 'file_download');
															$total_count  = $edd_logs->get_log_count('*', 'file_download');
                                                            $sales = edd_get_download_sales_stats( get_the_ID() );
                                                            $sales = $sales > 1 ? $sales . ' sales' : $sales . ' sale';
                                        $price = edd_get_download_price(get_the_ID());
																	?>
                   
                    <div class="download-count-hover">
                       <?php if( $price == "0.00"  ){ ?>
                       <p><i class="fas fa-cloud-download-alt"></i> <span><?php $download = $edd_logs->get_log_count(get_the_ID(), 'file_download'); echo ( is_null( $download ) ? '0' : $download ); ?></span></p>
                       <?php } else { ?>
                       <p><i class="fas fa-cloud-download-alt"></i> <span><?php echo esc_html($sales); ?></span></p>
                       <?php } ?>
                        
                    </div>
						<?php else: ?>
						<?php endif; ?>