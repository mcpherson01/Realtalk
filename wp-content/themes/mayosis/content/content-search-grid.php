<?php
/**
 * search grid
 * @package mayosis
 */
  if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
global $post;
$productthumbvideo= get_theme_mod( 'thumbnail_video_play','show' );
$productthumbposter= get_theme_mod( 'thumbnail_video_poster','show' );
$productvcontrol= get_theme_mod( 'thumb_video_control','minimal' );
$productcartshow= get_theme_mod( 'thumb_cart_button','hide' );
$productthumbhoverstyle= get_theme_mod( 'product_thmub_hover_style','style1' );
?>
<div class="row fix">

<?php
                    $taxquery=array();
                    if(isset($_GET['download_cats']) && $_GET['download_cats'] !== 'all'){
                        $download_category = $_GET['download_cats'];

                        $taxquery =    array(
                            array(
                                'taxonomy' => 'download_category',
                                'field'    => 'slug',
                                'terms'    => $download_category
                                )
                            );
                    }
                    
                    $paged=( get_query_var( 'paged')) ? get_query_var( 'paged') : 1;
                    
                        
                            $argument = array(
                            's'            => get_search_query(),
                            'order'     => 'DESC',
                            'post_type' => 'download',
                            'paged'     => $paged,
                            'tax_query' => $taxquery
                            );
            
                    $wp_query = new WP_Query(); $wp_query->query($argument);
                    
                    if($wp_query->have_posts()){
                        while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
  <div class="col-md-4">
	<div class="grid_dm ribbon-box group edge">
		<div class="product-box">
			<?php
            $postdate = get_the_time('Y-m-d');   // Post date
            $postdatestamp = strtotime($postdate);   // Timestamped post date
            $newness = get_theme_mod('dm_days_products_new', '30');  // Newness in days

            if ((time() - (60 * 60 * 24 * $newness)) < $postdatestamp) { // If the product was published within the newness time frame display the new badge
                echo '
			<div class="wrap-ribbon left-edge point lblue">
				<span>'. esc_html__('New', 'mayosis') .'</span>
			</div>';
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
            <?php get_template_part( 'includes/product-grid-thumbnail' ); ?>
            <?php } ?>

            <?php } else { ?>

            <div class="mayosis--thumb">
                <?php get_template_part( 'includes/product-grid-thumbnail' ); ?>
                <?php } ?>
                <figcaption>
                    <?php
                if ($productthumbhoverstyle=='style2') { ?>
                <a href="<?php the_permalink();?>" class="full-thumb-hover-plus">
                <i class="zil zi-plus"></i>
                </a>
                <?php } else { ?>
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
                    <?php } ?>
                </figcaption>
            </div>
</figure>
			<div class="product-meta">
				<?php get_template_part( 'includes/product-meta' ); ?>
			</div>
		</div>
		<!-- .product box -->
	</div>
</div>
<?php endwhile; ?>
<?php }
                    else { ?>
<h5>
	<?php esc_html_e("No product found","mayosis"); ?>
</h5>
<?php } ?>
<div class="col-md-12">
	<?php mayosis_page_navs(); ?>
</div>
</div>