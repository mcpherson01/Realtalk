<?php
/**
 * Template Name: Full Width Template
 *
 * This is a 100% Width Page template.
 *
 * @package mayosis-digital-marketplace-theme
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
get_header();
$mayosis_breadcrumb_color = get_post_meta( $post->ID, 'mayosis_breadcrumb_color', true );
$mayosis_page_bg = get_post_meta( $post->ID, 'mayosis_page_bg', true );

$mayosis_gradient= get_post_meta( $post->ID, 'breadcrumb_gradient', true );

$mayosis_gradient_a = get_post_meta( $post->ID, 'mayosis_gradient_a', true );

$mayosis_gradient_b = get_post_meta( $post->ID, 'mayosis_gradient_b', true );

$custom_page_title = get_post_meta( $post->ID, 'custom_page_title', true );

$custom_bd_bg_image = get_post_meta( $post->ID, 'breadcrumb_image', true );

$custom_page_padding_on= get_post_meta( $post->ID, 'custom_padding', true );

$custom_page_padding_top = get_post_meta( $post->ID, 'custom_page_padding_top', true );

$custom_page_padding_bottom = get_post_meta( $post->ID, 'custom_page_padding_bottom', true );
?>
<?php if ($custom_page_padding_on =="Yes") { ?>
<style>
    .page_breadcrumb{
        padding-top:<?php echo esc_html($custom_page_padding_top); ?>;
        padding-bottom:<?php echo esc_html($custom_page_padding_bottom); ?>;
    }
</style>
<?php } ?>
<?php if ( is_home() ) {
    $breadcrumb_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_hide', true );
     $breadcrumb_menu_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_menu_hide', true );
} else {
    $breadcrumb_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_hide', true );
     $breadcrumb_menu_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_menu_hide', true );
} ?>
<?php while ( have_posts() ) : the_post(); ?>
 <?php  if($breadcrumb_hide == "Yes"){ ?>
    <div class="container-fluid">

   
    <?php  if($mayosis_gradient == "Yes"){ ?>
    <div class="row page_breadcrumb" style="background:linear-gradient(45deg, <?php echo esc_html($mayosis_gradient_a); ?> , <?php echo esc_html($mayosis_gradient_b); ?>);">
    <?php } else { ?>

<?php  if($custom_bd_bg_image){ ?>
      <div class="row page_breadcrumb" style="background-image:url(<?php echo get_post_meta(get_the_ID(), 'breadcrumb_image', true ); ?>);">
        <?php } else { ?>
 <div class="row page_breadcrumb" style="background-color:<?php echo esc_html($mayosis_breadcrumb_color); ?>;">
     
            <?php } ?>

            <?php } ?>
            <div class="container">
            <h2 class="page_title_single">
                <?php  if($custom_page_title){ ?>
                    <?php echo esc_html($custom_page_title);?>
                <?php } else { ?>
                    <?php the_title(); ?>
                <?php } ?>
            </h2>
            <?php  if($breadcrumb_menu_hide == 'Yes'){ ?>
            <?php if (function_exists('dm_breadcrumbs')) dm_breadcrumbs(); ?>
            <?php }?>
            </div>
        </div>
      
    </div>
      <?php } ?>
    <div class="mayosis-container" style="background:<?php echo esc_html($mayosis_page_bg); ?>">

        <?php the_content()?>
        <?php // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        } ?>

    </div>

<?php endwhile; // end of the loop. ?>



<?php get_footer(); ?>