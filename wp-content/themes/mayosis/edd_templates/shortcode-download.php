<?php
/**
 * A single download inside of the [downloads] shortcode.
 *
 * @since 2.8.0
 *
 * @package EDD
 * @category Template
 * @author Easy Digital Downloads
 * @version 1.0.0
 */

global $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i;
$productgridsystem= get_theme_mod( 'product_grid_system','one' );
?>
<?php if ($productgridsystem=='one'): ?>
    <?php $schema = edd_add_schema_microdata() ? 'itemscope itemtype="http://schema.org/Product" ' : ''; ?>

    <div <?php echo esc_html($schema); ?>class="grid_dm ribbon-box group edge <?php echo esc_attr( apply_filters( 'edd_download_class', 'edd_download', get_the_ID(), $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i ) ); ?>" id="edd_download_<?php the_ID(); ?>">

        <div class="product-box <?php echo esc_attr( apply_filters( 'edd_download_inner_class', 'edd_download_inner', get_the_ID(), $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i ) ); ?>">
            <?php
            $postdate = get_the_time('Y-m-d');   // Post date
            $postdatestamp = strtotime($postdate);   // Timestamped post date
            $newness = get_theme_mod('dm_days_products_new', '30');  // Newness in days

            if ((time() - (60 * 60 * 24 * $newness)) < $postdatestamp) { // If the product was published within the newness time frame display the new badge
                echo '<div class="wrap-ribbon left-edge point lblue"><span>'. esc_html(__('New', 'mayosis')) .'</span></div>';
            }
            ?>
            <?php
            do_action( 'edd_download_before' );

            if ( 'false' !== $edd_download_shortcode_item_atts['thumbnails'] ) :
                edd_get_template_part( 'shortcode', 'content-image' );
                do_action( 'edd_download_after_thumbnail' );
            endif;

            edd_get_template_part( 'shortcode', 'content-title' );

            do_action( 'edd_download_after_title' );

            if ( 'yes' === $edd_download_shortcode_item_atts['excerpt'] && 'yes' !== $edd_download_shortcode_item_atts['full_content'] ) :
                edd_get_template_part( 'shortcode', 'content-excerpt' );
                do_action( 'edd_download_after_content' );
            elseif ( 'yes' === $edd_download_shortcode_item_atts['full_content'] ) :
                edd_get_template_part( 'shortcode', 'content-full' );
                do_action( 'edd_download_after_content' );
            endif;

            if ( 'yes' === $edd_download_shortcode_item_atts['price'] ) :
                edd_get_template_part( 'shortcode', 'content-price' );
                do_action( 'edd_download_after_price' );
            endif;

            if ( 'yes' === $edd_download_shortcode_item_atts['buy_button'] ) :
                edd_get_template_part( 'shortcode', 'content-cart-button' );
            endif;

            do_action( 'edd_download_after' );
            ?>

        </div>

    </div>
<?php else: ?>


<?php
do_action( 'edd_download_before' );

if ( 'false' !== $edd_download_shortcode_item_atts['thumbnails'] )
:
?>

<a href="<?php
the_permalink(); ?>" class="masonary-tile"><?php the_post_thumbnail('large');?>
    <?php	do_action( 'edd_download_after_thumbnail' );
    endif;


    do_action( 'edd_download_after' );
    ?>

    <?php endif; ?>