<?php
/**
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
 $productgridsystem= get_theme_mod( 'product_grid_system','one' );
?>
 <?php if ($productgridsystem=='two'): ?>
                                                <?php get_template_part( 'content/content-search-masonary' ); ?>
                                            <?php else : ?>
                                                <?php get_template_part( 'content/content-search-grid' ); ?>
                                            <?php endif; ?>