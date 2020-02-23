<?php
/**
 * @package mayosis
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $post;
$productmetaoptions= get_theme_mod( 'product_grid_options','one' );
$productmetadisplayop= get_theme_mod( 'product_meta_options' ,'vendorcat');
$productpricingoptions= get_theme_mod( 'product_pricing_options','price' );
$productfreeoptins= get_theme_mod( 'product_free_options','custom' );
$productcustomtext= get_theme_mod( 'free_text','FREE' );
$author = get_user_by( 'id', get_query_var( 'author' ) );
$author_id=$post->post_author;
$productvideoiconhide= get_theme_mod( 'title_play_button','show' );
?>
<?php if ($productmetaoptions=='two'): ?>
<div class="without-meta-box">
    
</div>
<?php else : ?>

<div class="product-tag">
                                                                  <?php 
																	global $edd_logs;
															$single_count = $edd_logs->get_log_count(66, 'file_download');
															$total_count  = $edd_logs->get_log_count('*', 'file_download');
                                                            $sales = edd_get_download_sales_stats( get_the_ID() );
                                                            $sales = $sales > 1 ? $sales . ' sales' : $sales . ' sale';
                                        $price = edd_get_download_price(get_the_ID());
																	?>
							
							<?php if ( has_post_format( 'audio' )) { 
								get_template_part( 'includes/edd_title_audio');
							} ?>
							 <?php if ($productvideoiconhide=='show') { ?>
							<?php if ( has_post_format( 'video' )) { 
								get_template_part( 'includes/edd_title_video');
							} ?>
							<?php } ?>
							<h4 class="product-title"><a href="<?php the_permalink(); ?>">
								    <?php 
                                       the_title();
                                        ?>
								</a></h4>
								<?php 
									$download_cats = get_the_term_list( get_the_ID(), 'download_category', '', _x(' , ', '', 'mayosis' ), '' );
							     ?>
								
								 <?php if ($productmetadisplayop=='vendor'): ?>
								 <span><a href="<?php echo mayosis_fes_author_url( get_the_author_meta( 'ID',$author_id ) ) ?>">
								     
								     <?php echo get_the_author_meta( 'display_name',$author->ID );?>
								 </a></span>		
								 <?php elseif ($productmetadisplayop=='category'): ?>
								 <span><?php echo '<span>' . $download_cats . '</span>'; ?></span>
								 <?php elseif ($productmetadisplayop=='vendorcat'): ?>
								 <span class="opacitydown75"><?php esc_html_e("by","mayosis"); ?></span> <a href="<?php echo mayosis_fes_author_url( get_the_author_meta( 'ID',$author_id ) ) ?>">
								     
								     
								     <?php echo get_the_author_meta( 'display_name',$author_id);?>
								     </a>
								 <?php if ($download_cats):?>
								 <span class="opacitydown75"><?php esc_html_e("in","mayosis"); ?></span> <span><?php echo '<span>' . $download_cats . '</span>'; ?></span>
								 <?php endif; ?>
								 <?php elseif ($productmetadisplayop=='sales'): ?>
								   <?php if( $price == "0.00"  ){ ?>
                                   <p><span><?php $download = $edd_logs->get_log_count(get_the_ID(), 'file_download'); echo ( is_null( $download ) ? '0' : $download ); ?> <?php esc_html_e('Downloads','mayosis');?></span></p>
                                   <?php } else { ?>
                                   <p><span><?php echo esc_html($sales); ?></span></p>
                                   <?php } ?>
								 <?php else: ?>
								 <?php endif; ?>
									
				           
				                
								</div>
				 <?php if ($productpricingoptions=='price'): ?>								
																	
								<div class="count-download">
								 <?php if( $price == "0.00"  ){ ?>
								 <?php if ($productfreeoptins=='none'): ?>		
									<span><?php edd_price(get_the_ID()); ?></span>
								<?php else: ?>
								    <span><?php echo esc_html($productcustomtext); ?></span>
								<?php endif;?>
								
								
									 <?php } else { ?>
                       <div class="product-price promo_price"><?php edd_price(get_the_ID()); ?></div>
                    <?php } ?>
									
								</div>
								<?php endif; ?>
						
								<div class="clearfix"></div>
								<?php endif; ?>