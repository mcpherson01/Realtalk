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
$productmascol= get_theme_mod( 'product_masonry_column','3' );
$productmastitle= get_theme_mod( 'product_masonry_title_hover','1' );
?>
<div class="row">
  <div class="product-masonry product-masonry-gutter product-masonry-style-2 product-masonry-masonry product-masonry-full product-masonry-<?php echo esc_html($productmascol);?>-column">
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
 <div class="product-masonry-item ">
                            <div class="product-masonry-item-content">
                                <div class="item-thumbnail">
                                    <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'large');?>
                                    <a href="<?php the_permalink();?>"><img src="<?php echo $thumbnail['0']; ?>" alt=""></a>
                                </div>
                                <?php if ($productmastitle==1){?>
                                <div class="product-masonry-description">
                                    <h5><a href="<?php the_permalink();?>" ><?php the_title()?></a></h5>
                                    
                                </div>
                                <?php } ?>
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
</div>