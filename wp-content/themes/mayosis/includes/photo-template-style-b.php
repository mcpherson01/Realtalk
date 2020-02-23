 <?php
 $relatedtdownloadstyle= get_theme_mod( 'related_download_style','justified' );
$productthumbvideo= get_theme_mod( 'thumbnail_video_play','show' );
$productthumbposter= get_theme_mod( 'thumbnail_video_poster','show' );
$productvcontrol= get_theme_mod( 'thumb_video_control','minimal' );
$productcartshow= get_theme_mod( 'thumb_cart_button','hide' );
$productrelnumber= get_theme_mod( 'related_product_number','8' );
$productreltitle= get_theme_mod( 'related_product_title','Similar Images' );
 ?>
 <?php if( '' !== get_post()->post_content ) { ?>
        <section class="blog-main-content photo-template-main-content">
            <div class="row">
                <div class="col-md-12">
                    
                        <div class="photo--template--content">
                            <?php get_template_part( 'includes/product-gallery' ); ?>
                            <?php the_content(); ?>
                        </div>
                  
                </div>
            </div>
        </section>
          <?php } ?>

        <section class="bottom-post-footer-widget photo-template-footer-bg">
            <div class="bottom-product-sidebar photo-template-bottom-similar photo-style-b-box">
                <h3><?php echo esc_html($productreltitle); ?></h3>
                 <?php if($relatedtdownloadstyle == 'normal') {?>
                    <div class="row fix">
                 <?php } else { ?>
                    <div class="justified-grid justified-grid-margin" id="isotope-filter">
                 <?php } ?>
             
                    <?php
                    //Fetch data
                    $exclude_post_id = $post->ID;
                    $taxchoice = isset( $edd_options['related_filter_by_cat'] ) ? 'download_tag' : 'download_category';
                    $custom_taxterms = wp_get_object_terms( $post->ID, $taxchoice, array('fields' => 'ids') );

                    $arguments = array(
                        'post_type' => 'download',
                        'post_status' => 'publish',
                        'posts_per_page' => $productrelnumber,
                        'order' => 'DESC',
                        'ignore_sticky_posts' => 1,
                        'post__not_in' => array($post->ID),
                        'ignore_sticky_posts'=>1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => $taxchoice,
                                'field' => 'id',
                                'terms' => $custom_taxterms
                            )
                        ),
                    );

                    $post_query = new WP_Query($arguments); ?>
                    <?php if ( $post_query->have_posts() ) : while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
                        <?php $thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                        
                         <?php if($relatedtdownloadstyle == 'normal') {?>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                              
                            <div class="grid_dm ribbon-box group
                                        edge">
                    <div class="product-box">
                        <?php
                                $postdate = get_the_time('Y-m-d'); // Post date
                                $postdatestamp = strtotime($postdate); 
                                
                                $riboontext = get_theme_mod('recent_ribbon_text', 'New'); // Newness in days
                                
                                $newness = get_theme_mod('recent_ribbon_time', '30'); // Newness in days
                                if ((time() - (60 * 60 * 24 * $newness)) < $postdatestamp) { // If the product was published within the newness time frame display the new badge
                                    echo '<div class="wrap-ribbon left-edge point lblue"><span>' . esc_html($riboontext) . '</span></div>';
                                }
                        ?>
                     <figure class="mayosis-fade-in">


    <?php if ($productthumbvideo=='show'){ ?>
    <?php if ( has_post_format( 'video' )) { ?>

    <div class="mayosis--video--box">
        <div class="video-inner-box-promo">

            <a href="<?php the_permalink();?>" class="mayosis-video-url"></a>
            <div class="video-inner-main">
                <?php get_template_part( 'library/mayosis-video-box-thumb' ); ?>
            </div>
            <div class="clearfix"></div>
            <?php if ($productcartshow=='show'){ ?>
                <div class="product-cart-on-hover">
                    <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>
                </div>
            <?php }?>
            <?php if ($productvcontrol=='minimal'){ ?>
                <div class="minimal-video-control">
                    <div class="minimal-control-left">

                        <?php if ( function_exists( 'edd_favorites_load_link' ) ) {
                            edd_favorites_load_link( $download_id );
                        } ?>
                    </div>



                    <div class="minimal-control-right">
                        <ul>
                            <li>	<?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>  </li>
                            <?php $mayosis_video = get_post_meta($post->ID, 'video_url',true);?>
                            <li><a href="<?php echo esc_attr($mayosis_video); ?>" data-lity>
                                    <i class="fa fa-arrows-alt" aria-hidden="true"></i></a></li>

                        </ul>
                    </div>

                </div>
            <?php } ?>
        </div>






        <?php } else { ?>
        <div class="mayosis--thumb">
            <?php
            // display featured image?
            if ( has_post_thumbnail() ) :
                the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
            endif;

            ?>
            <?php } ?>

            <?php } else { ?>

            <div class="mayosis--thumb">
                <?php
                // display featured image?
                if ( has_post_thumbnail() ) :
                    the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                endif;

                ?>
                <?php } ?>
                <figcaption>
                    <div class="overlay_content_center">
                        <?php get_template_part( 'includes/product-hover-content-top' ); ?>

                        <div class="product_hover_details_button">
                            <a href="<?php the_permalink(); ?>" class="button-fill-color"><?php esc_html_e('View Details', 'mayosis'); ?></a>
                        </div>
                        <?php
                        $demo_link = get_post_meta(get_the_ID(), 'demo_link', true);
                        $livepreviewtext= get_theme_mod( 'live_preview_text','Live Preview' );
                        ?>
                        <?php if ( $demo_link ) { ?>
                            <div class="product_hover_demo_button">
                                <a href="<?php echo esc_url($demo_link); ?>" class="live_demo_onh" target="_blank"><?php echo esc_html($livepreviewtext); ?></a>
                            </div>
                        <?php } ?>

                        <?php get_template_part( 'includes/product-hover-content-bottom' ); ?>
                    </div>
                </figcaption>
            </div>
</figure>
                        <div class="product-meta">
                            <?php get_template_part( 'includes/product-meta' ); ?>

                        </div>
                    </div>
                </div>
            </div>
                         <?php } else { ?>
                        <a href="<?php
                        the_permalink(); ?>">
                            <img src="<?php echo esc_url($thumbnail); ?>" />
                        </a>
                        <?php }?>
                    <?php endwhile; else: ?>
                        <div class="col-lg-12 pm-column-spacing">
                            <p><?php esc_html_e('No posts were found.', 'mayosis'); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php wp_reset_postdata(); ?>
                </div>
                <div class="bottom_meta product--bottom--tag photo-bottom--tag">
                    <h3><?php esc_html_e('Keywords','mayosis'); ?></h3>
                    <?php $download_tags = get_the_term_list( get_the_ID(), 'download_tag',  ' ', ' '); ?>
                    <?php echo '<span class="tags">' . $download_tags . '</span>'; ?>
                </div>
                 <div id="comment_box">
                  <?php if ( class_exists( 'EDD_Reviews' ) ) { ?>
                <div class="mayosis-review-tabs">
			      <div class="tabbable-line">
                    <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#commentmain" role="tab" data-toggle="tab">Comments</a></li>
                    <li><a href="#mayosisreview" role="tab" data-toggle="tab">Customer Reviews</a></li>
                  </ul>
                    </div>
                  
                   <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="commentmain">
                        	<?php if ( comments_open() || '0' != get_comments_number() ) { ?>
                    <?php comments_template(); ?>
                <?php } ?>
                        
                    </div>
                    <div role="tabpanel" class="tab-pane" id="mayosisreview">
                        
                         <?php if ( class_exists( 'EDD_Reviews' ) ) {
								global $post;
								$user = wp_get_current_user();
								$user_id = ( isset( $user->ID ) ? (int) $user->ID : 0 );

								if ( ! edd_reviews()->is_review_status( 'disabled' ) ) {
								?>
								<div class="mayosis-review-section reviews-section">
									<div class="comments">
										<div class="comments-wrap">
										<?php
											edd_get_template_part( 'reviews' );
											if ( get_option( 'thread_comments' ) ) {
												edd_get_template_part( 'reviews-reply' );
											}
										?>
										</div>
									</div>
								</div>
							<?php } }?>
                    </div>
                   
                  </div>
                </div>
              
                
                <?php } else { ?>
                 
                 
                 <?php if ( comments_open() || '0' != get_comments_number() ) { ?>
                    <?php comments_template(); ?>
                <?php } ?>
							
							
			<?php } ?>
            </div>
            </div>
        </section>
        