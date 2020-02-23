<?php
/**
 * The page file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mayosis
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
$breadcrumb_image = get_post_meta($post->ID, 'breadcrumb_image', true );

$custom_page_title = get_post_meta( $post->ID, 'custom_page_title', true );

$custom_page_padding_on= get_post_meta( $post->ID, 'custom_padding', true );

$custom_page_padding_top = get_post_meta( $post->ID, 'custom_page_padding_top', true );

$custom_page_padding_bottom = get_post_meta( $post->ID, 'custom_page_padding_bottom', true );
$custom_bd_bg_image = get_post_meta( $post->ID, 'breadcrumb_image', true );
?>
<?php if ( is_home() ) {
    $breadcrumb_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_hide', true );
    $breadcrumb_menu_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_menu_hide', true );
    $sidebar_hide = get_post_meta(get_queried_object_id(), 'page_sidebar', true );
} else {
    $breadcrumb_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_hide', true );
     $breadcrumb_menu_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_menu_hide', true );
    $sidebar_hide = get_post_meta(get_the_ID(), 'page_sidebar', true );
} ?>

<?php if ($custom_page_padding_on =="Yes") { ?>
<style>
    .page_breadcrumb{
        padding-top:<?php echo esc_html($custom_page_padding_top); ?>;
        padding-bottom:<?php echo esc_html($custom_page_padding_bottom); ?>;
    }
</style>
<?php } ?>

    <div class="container-fluid">
<?php while ( have_posts() ) : the_post(); ?>
<?php  if($breadcrumb_hide == 'No'){ ?>
<?php } else { ?>
<?php  if($mayosis_gradient == "Yes"){ ?>
    <div class="row page_breadcrumb" style="background:linear-gradient(45deg, <?php echo esc_html($mayosis_gradient_a); ?> , <?php echo esc_html($mayosis_gradient_b); ?>);">
    <?php } else { ?>
    <div class="row page_breadcrumb" style="background-color:<?php echo esc_html($mayosis_breadcrumb_color); ?>; <?php  if($breadcrumb_image){ ?>background-image:url(<?php echo get_post_meta(get_the_ID(), 'breadcrumb_image', true ); ?>); <?php }?>">
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
        <?php } ?>
    </div>
     </div>
    <?php } ?>
    <?php  if($sidebar_hide == "Show"){ ?>
        <!-- Load post content from format-standard.php -->
        <div class="container" style="background:<?php echo esc_html($mayosis_page_bg); ?>;">
            <div class="row">
                <div class="col-md-8">
                    <?php the_content()?>
                </div>
                <div class="col-md-4">
                    <?php if ( is_active_sidebar( 'page-sidebar' ) ) : ?>
                        <?php dynamic_sidebar( 'page-sidebar' ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="container" style="background:<?php echo esc_html($mayosis_page_bg); ?>;padding:30px 15px;">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <?php the_content()?>
                    <?php // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    } ?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php endwhile; ?>

    </div>
    <div class="container">
    <div class="entry-content default-pagination-page ">
<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'mayosis' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<p class="pagi-box-default">',
				'link_after'  => '</p>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'mayosis' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
</div>

</div>
<?php get_footer(); ?>