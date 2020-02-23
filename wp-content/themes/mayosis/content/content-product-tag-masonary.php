<?php
/**
 * @package mayosis
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$productmascol= get_theme_mod( 'product_masonry_column','3' );
$productmastitle= get_theme_mod( 'product_masonry_title_hover','1' );
?>
       <div class="row">
       <div class="product-masonry product-masonry-gutter product-masonry-style-2 product-masonry-masonry product-masonry-full product-masonry-<?php echo esc_html($productmascol);?>-column">
                                 <?php
    $term=get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    $paged=( get_query_var( 'paged')) ? get_query_var( 'paged') : 1;
    if ( ! isset( $wp_query->query['orderby'] ) ) {
        $args = array(
            'order' => 'DESC',
            'post_type' => 'download',
            'download_tag'=>$term->slug,
            'paged' => $paged );
    } else {
        switch ($wp_query->query['orderby']) {
            case 'newness_asc':
                $args = array(
                    'orderby' => 'newness_asc',
                    'order' => 'ASC',
                    'post_type' => 'download',
                    'download_tag'=>$term->slug,
                    'paged' => $paged );
                break;
            case 'newness_desc':
                $args = array(
                    'orderby' => 'newness_desc',
                    'order' => 'DESC',
                    'post_type' => 'download',
                    'download_tag'=>$term->slug,
                    'paged' => $paged );
                break;
            case 'sales':
                $args = array(
                    'meta_key'=>'_edd_download_sales',
                    'order' => 'DESC',
                    'orderby' => 'meta_value_num',
                    'download_tag'=>$term->slug,
                    'post_type' => 'download',
                    'paged' => $paged );
                break;
            case 'price_asc':
                $args = array(
                    'meta_key'=>'edd_price',
                    'order' => 'ASC',
                    'orderby' => 'meta_value_num',
                    'download_tag'=>$term->slug,
                    'post_type' => 'download',
                    'paged' => $paged );
                break;
                
                case 'price_desc':
                $args = array(
                    'meta_key'=>'edd_price',
                    'order' => 'DESC',
                    'orderby' => 'meta_value_num',
                    'download_tag'=>$term->slug,
                    'post_type' => 'download',
                    'paged' => $paged );
                break;
                
                case 'title_asc':
                $args = array(
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'download_tag'=>$term->slug,
                    'post_type' => 'download',
                    'paged' => $paged );
                break;
                
                case 'title_desc':
                $args = array(
                    'orderby' => 'title',
                    'order' => 'DESC',
                    'download_tag'=>$term->slug,
                    'post_type' => 'download',
                    'paged' => $paged );
                break;
        } }
    $temp = $wp_query; $wp_query = null;
    $wp_query = new WP_Query(); $wp_query->query($args); ?>
    <?php if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                            
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
                         <?php endwhile; else : ?>
<?php endif; ?>


                            </div>
    </div>