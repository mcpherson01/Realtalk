<?php
/**
 * The default template for download page content
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
global $post;
$author = get_user_by( 'id', get_query_var( 'author' ) );
$author_id=$post->post_author;
$productgallerytype= get_theme_mod( 'product_gallery_type','one');
$download_id = get_the_ID();
$photovtemplate= get_theme_mod( 'photo_promobar_type', 'color');
$photographyby= get_theme_mod( 'photography_by', 'Photography By');
$download_cats = get_the_term_list( get_the_ID(), 'download_category', '', _x(' , ', '', 'mayosis' ), '' );
$promoshow= get_theme_mod( 'photo_template_promo','hide' );
$authormetashow= get_theme_mod( 'photo_template_author_enable','enable' );
$photozoom= get_theme_mod( 'photo_zoom_disable','enable' );
$mediasubscribe= get_theme_mod( 'media_subscription_box','disable' );
$mediastyle= get_theme_mod( 'media_subscription_style','stylea' );
$mediasubscrib= get_theme_mod( 'media_subscription_text','Download Unlimited Stock Videos at $99/month' );
$mediasubscribtitle= get_theme_mod( 'media_subscription_btn_text','Subscribe' );
$mediasubscriblink= get_theme_mod( 'media_subscription_url','' );
$pricealign= get_theme_mod( 'media_price_align','center' );
$priceabovetext= get_theme_mod( 'media_price_desc_txt','' );
$relatedtdownloadstyle= get_theme_mod( 'related_download_style','justified' );
$productthumbvideo= get_theme_mod( 'thumbnail_video_play','show' );
$productthumbposter= get_theme_mod( 'thumbnail_video_poster','show' );
$productrelnumber= get_theme_mod( 'related_product_number','8' );
$productreltitle= get_theme_mod( 'related_product_title','Similar Images' );
$commentmode= get_theme_mod( 'media_coment','normal' );
$productvcontrol= get_theme_mod( 'thumb_video_control','minimal' );
$productcartshow= get_theme_mod( 'thumb_cart_button','hide' );
$mayosis_video = get_post_meta($post->ID, 'video_url',true); 


?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <!-- Begin Page Headings Layout -->
        <?php if($promoshow == 'show') :?>
            <div class="photo-video-template product-main-header container-fluid">
                <?php if ($photovtemplate=='featured'): ?>
                    <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                    <div class="container-fluid featuredimagebg" style="background:url(<?php echo esc_url($feat_image); ?>) center center;">
                    </div>
                <?php elseif ($photovtemplate=='video'): ?>
                <div class="header-video-template-box">
                    <div class="header_video_part_main">
              
                            <?php echo do_shortcode('[video src="'.$mayosis_video.'" autoplay="true" fullscreen="false" duration="false" volume="false" progress="false"]'); ?>
                            </div>
                            </div>
                <?php endif; ?>

                <div class="photo--tempalte--top-space"></div>
            </div>

        <?php endif; ?>
        <section class="container">
            <div class="photo-template-author">
                
                    <div class="row">
                        <div class="col-md-8 col-xs-12 photo--section--image">
                            <div class="photo-video-box-shadow">
                        <?php if ( has_post_format( 'video' )) { ?>
                         
                            <?php if ($mayosis_video){?>
                          <?php get_template_part( 'library/mayosis-video-box' ); ?>
                          <?php } else { ?>
                           <?php $thumb_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                           <img src="<?php echo esc_url($thumb_image); ?>" alt="featured-image" class="featured-img img-responsive">
                          <?php }?>
                         <?php } elseif ( has_post_format( 'audio' )) { ?>
                            <?php get_template_part( 'library/mayosis_audio' ); ?>
                         <?php } else { ?>
                            <?php $thumb_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>

                            <?php $thumb_image_lity = wp_get_attachment_url( get_post_thumbnail_id($post->ID),'thumbnail' ); ?>
                            <?php if($photozoom == 'enable') :?>
                            <a class="photo-image-zoom" data-lity href="<?php echo esc_url($thumb_image_lity); ?>" data-lity-desc="<?php the_title();?>"><i class="zil zi-search"></i></a>
                            <?php endif; ?>
                            <img src="<?php echo esc_url($thumb_image); ?>" alt="featured-image" class="featured-img img-responsive">
                            <?php  } ?>
                            
                           
                            </div>
                            
                        </div>
                        <div class="col-md-4 col-xs-12 no-paading-left-desktop no-paading-right-desktop photo--credential--box">
                            <div class="photo-credential">
                                <div class="photo--title-block">
                                      <?php if($mediastyle =='stylea' ){ ?>
                              <div class="media-style-subcs-text hidden-md hidden-lg hidden-sm">
                             <h1><?php the_title(); ?></h1>
                                    <span class="opacitydown75"><?php esc_html_e("by","mayosis"); ?></span> <a href="<?php echo mayosis_fes_author_url( get_the_author_meta( 'ID',$author_id ) ) ?>">
								     <?php echo get_the_author_meta( 'display_name',$author_id);?>
								     </a><span class="opacitydown75"><?php esc_html_e("in","mayosis"); ?></span> <?php echo '<span>' . $download_cats . '</span>'; ?>
                                    <span class="opacitydown75"><?php esc_html_e("on","mayosis"); ?> </span><span><?php echo esc_html(get_the_date()); ?></span>
                          
                             </div>
                                <?php } ?>
                                    <?php if($mediastyle =='stylea' ){ ?>
                                        <div class="photo-subscription-box">
                                        <h3><?php echo esc_html($mediasubscrib);?></h3>
                                        <a href="<?php echo esc_html($mediasubscriblink);?>" class="btn button subscribe-block-btn"><?php echo esc_html($mediasubscribtitle);?></a>
                                        </div>
                                    <?php } else { ?>
                                    <h1><?php the_title(); ?></h1>
                                    <span class="photo-toolspan"><?php esc_html_e("in","mayosis"); ?></span> <?php echo '<span>' . $download_cats . '</span>'; ?>
                                    <span class="photo-toolspan"><?php esc_html_e("on","mayosis"); ?> <?php echo esc_html(get_the_date()); ?></span>
                                    <?php } ?>
                                </div>

                                <div class="photo--price--block">
                                    <?php if($priceabovetext){?>
                                        <p><?php echo esc_html($priceabovetext);?></p>
                                    <?php } ?>
                                    <h3 style="text-align:<?php echo esc_html($pricealign);?>"><?php
                                        if(edd_has_variable_prices($download_id)){
                                            echo edd_price_range( $download_id );
                                        }
                                        else{
                                            edd_price($download_id);
                                        }
                                        ?></h3>
                                          <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>
                                        <div class="photo--button--wishlistset photo-wishlist-fav">
                    <?php if ( function_exists( 'edd_favorites_load_link' ) ) {
                        edd_favorites_load_link( $download_id );
                    } ?>

 <?php if ( function_exists( 'edd_wl_load_wish_list_link' ) ) { ?>
<?php if(edd_has_variable_prices($download_id)):?>
                                <a class="photo_edd_el_button edd-wl-button" href="#variablepricemodal">
                                    <i class="glyphicon glyphicon-add"></i> <?php esc_html_e('Add to Wishlist','mayosis'); ?>
                                </a>

                            <?php else: ?>
                            <?php edd_wl_load_wish_list_link( $download_id ); ?>
                            <?php endif; ?>
                   
                        
                    <?php } ?>
                </div>
                                  

                                </div>
                                <?php if(function_exists('mayosis_photosocial')){
                                    mayosis_photosocial();
                                } ?>
                                <?php if($authormetashow == 'enable') :?>
                                <div class="photo--template--author--meta">
                                    <div class="photo--author--photo">
                                        <?php echo get_avatar( get_the_author_meta('email'), '40' ); ?>
                                    </div>
                                    <div class="photo--author--details">
                                        <p><?php echo esc_html($photographyby); ?></p>
                                        <h4 class="author--name--photo--template"><?php echo get_the_author_meta( 'display_name');?></h4>
                                    </div>
                                    <div class="photo--author--button">
                                        <a href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID')) )); ?>" class="photo--template--button"><?php esc_html_e('View Portfolio','mayosis'); ?></a>
                                    </div>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 col-xs-12">
                            
                              <?php if($mediastyle =='stylea' ){ ?>
                              <div class="media-style-subcs-text hidden-xs">
                             <h1><?php the_title(); ?></h1>
                                    <span class="opacitydown75"><?php esc_html_e("by","mayosis"); ?></span> <a href="<?php echo mayosis_fes_author_url( get_the_author_meta( 'ID',$author_id ) ) ?>">
								     <?php echo get_the_author_meta( 'display_name',$author_id);?>
								     </a><span class="opacitydown75"><?php esc_html_e("in","mayosis"); ?></span> <?php echo '<span>' . $download_cats . '</span>'; ?>
                                    <span class="opacitydown75"><?php esc_html_e("on","mayosis"); ?> </span><span><?php echo esc_html(get_the_date()); ?></span>
                          
                             </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>

        </section>
        <!-- End Page Headings Layout -->
        <!-- Begin Blog Main Post Layout -->
         <?php if($mediastyle =='styleb' ){ ?>
         <?php $subscriptionoption = get_theme_mod( 'photoz_subscription_options', $defaults );?>
         <section class="container stylebphotos">
             <div class="row">
                 <div class="col-md-8 col-xs-12">
                     <div class="xtra-desktop-padding">
                     <?php get_template_part( 'includes/photo-template-style-b' ); ?>
                     </div>
                 </div>
                 <div class="col-md-4 col-xs-12 no-paading-left-desktop no-paading-right-desktop subscribe-box-photo-main">
                     <div class="subscribe-box-photo">
                         <h4><?php echo esc_html($mediasubscrib);?></h4>
                         <div class="photo-subscribe--content">
                             <ul>
                                  <?php foreach( $subscriptionoption as $setting ) : ?>
                                 <li><i class="zil zi-check"></i>  <?php echo esc_html($setting['subscription_option']); ?></li>
                                 <?php endforeach; ?>
                             </ul>
                             <a href="<?php echo esc_html($mediasubscriblink);?>" class="btn button subscribe-block-btn"><?php echo esc_html($mediasubscribtitle);?></a>
                         </div>
                     </div>
                     <?php if ( is_active_sidebar( 'media-template-product' ) ) : ?>
                    
                    		<?php dynamic_sidebar( 'media-template-product' ); ?>
                    
                    <?php endif; ?>
                 </div>
             </div>
         </section>
         <?php } else { ?>
        <?php if( '' !== get_post()->post_content ) { ?>
        <section class="container blog-main-content photo-template-main-content">
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

        <section class="container-fluid bottom-post-footer-widget photo-template-footer-bg">
            <div class="container bottom-product-sidebar photo-template-bottom-similar">
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
                          <div class="col-md-3 col-xs-12">
                              
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
                 <div class="container <?php if ($commentmode=='compact'){ ?>compact-container<?php }?>" id="comment_box">
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
        <?php } ?>
        <!-- End Blog Main Post Layout-->
          <!-- Modal -->
    <div id="variablepricemodal" class="mayosis-overlay">
        <div class="mayosis-popup">
            <div class="modal-header">
                <h4><?php esc_html_e('Choose Your Desired Option(s)','mayosis'); ?></h4>
                <a class="close" href="#">&times;</a>
            </div>
            <div class="modal-body">
                <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID()) ); ?>
            </div>
        </div>
    </div>
    </article>