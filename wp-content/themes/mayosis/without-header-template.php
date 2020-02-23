<?php
/**
 * Template Name:Without Header & Footer
 *
 * This is a Simple Full screen Template
 *
 * @package mayosis-digital-marketplace-theme
 */
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} 
get_header('blank');
?>

  <?php $mayosis_bg_color = get_post_meta($post->ID, 'page_bg_color',true); ?>
 <div class="container-fluid full-screen-blank" style="background-color:<?php echo esc_html($mayosis_bg_color); ?>; background-image:url(<?php echo esc_url( get_post_meta( get_the_ID(), 'w_page_bg', true ) ); ?>);">
<?php while ( have_posts() ) : the_post(); ?>
	<?php the_content()?>
	<?php endwhile; ?>
					
</div>
<?php get_footer('blank'); ?>