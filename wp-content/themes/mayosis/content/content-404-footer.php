<?php
/**
 * Footer Product Widget
 */
  if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

       <div class="row">
       
           <div class="col-md-4 col-sm-4 col-xs-12 bottom--post--block">
           <h4><?php esc_html_e('Popular Blog Post','mayosis'); ?></h4>
               
              
                        <?php  mayosis_most_viewed_posts_footer( );?>	
                        <div class="clearfix"></div>
           </div>
             

           
           <div class="col-md-4 col-sm-4 col-xs-12 bottom--post--block">
               <h4><?php esc_html_e('Popular &amp; Trending ','mayosis'); ?> </h4>
                 <?php  mayosis_most_viewed_product_footer( );?>	
           </div>
           
           
           <div class="col-md-4 col-sm-4 col-xs-12 bottom--post--block">
               <h4><?php esc_html_e('Featured Products ','mayosis'); ?> </h4>
               <?php   	//Fetch data
		$arguments = array(
			'post_type' => 'download',
			'post_status' => 'publish',
			'posts_per_page' => 3,
			'order' => 'DESC',
			'ignore_sticky_posts' => 1,
			'tag' => get_query_var('tag'),
			 'meta_key' => 'edd_feature_download',
		);
	
		$post_query = new WP_Query($arguments);?>
              <?php $featured_downloads = new WP_Query( $arguments );

if( $featured_downloads->have_posts() ) : ?>
              <?php while( $featured_downloads->have_posts() ) : $featured_downloads->the_post(); ?>
        
               <div class="bottom-widget-product ">
                        <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail paading-left-0"> 
                        	 <div class="product-thumb grid_dm">
                        <figure class="mayosis-fade-in"> 
                              <?php
									the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
								 ?>
                                   	<figcaption>
                                   	    <div class="overlay_content_center">               
                              <a href="<?php
                            	the_permalink(); ?>"><i class="zil-plus"></i></a>
                            	</div>
                            	</figcaption>
                            	     </figure>    
                            	      </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                          <?php 
																	global $edd_logs;
															$single_count = $edd_logs->get_log_count(66, 'file_download');
															$total_count  = $edd_logs->get_log_count('*', 'file_download');
																$price = edd_get_download_price(get_the_ID());
																	?>
                           <?php if( $price == "0.00"  ){ ?>
								
									<p><?php $download = $edd_logs->get_log_count(get_the_ID(), 'file_download'); echo ( is_null( $download ) ? '0' : $download ); ?> Downloads</p>
									
                   
                   
									 <?php } else { ?>
                       <div class="product-price"><?php edd_price(get_the_ID()); ?></div>
                    <?php } ?>
                            
                        </div>
                        <div class="clearfix"></div>
                </div>
                   	 <?php endwhile; else: ?>
                   	 <div class="col-lg-12 pm-column-spacing">
                     <p><?php esc_html_e('No posts were found.', 'mayosis'); ?></p>
                    </div>
                <?php endif; ?>
                    <!--Sidebar Product-->
<?php wp_reset_postdata(); ?>
           </div>
       </div>