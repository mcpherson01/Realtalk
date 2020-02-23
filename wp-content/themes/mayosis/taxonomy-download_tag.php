<?php
/**
 * The template for displaying the download tags.
 *
 * 
 * 
 * @package Mayosis
 */
get_header(); ?>

<article content='<?php the_ID(); ?>' id="post-<?php the_ID(); ?>" >
                        <?php  $productarchivetype = get_theme_mod( 'archive_bg_type','gradient' ); ?>


                        <!-- Begin Page Headings Layout -->

                        <div class="product-archive-breadcrumb container-fluid">
                            <?php if ($productarchivetype=='featured'): ?>
                                <?php
                                $category_grid_image = get_term_meta( get_queried_object_id(), 'category_image_main', true); ?>
                                <div class="container-fluid featuredimageparchive" style="background:url(<?php echo esc_url($category_grid_image); ?>) center center;">
                                </div>

                            <?php endif; ?>
                            <div class="container">
                                <h1 class="parchive-page-title"><?php single_cat_title( __( '', 'mayosis' ) ); ?></h1>
                                <p class="product-cat-desc"> <?php echo category_description(); ?> </p>
                                <?php if (function_exists('mayosis_breadcrumbs')) mayosis_breadcrumbs(); ?>

                            </div>
                        </div>
                        <?php
                        $allproducttext= get_theme_mod( 'all_product_text','ALL PRODUCTS FROM' );
                        $productgridsystem= get_theme_mod( 'product_grid_system','one' );
                        $archivetitledisable= get_theme_mod( 'archive_title_disable','enable' );
                        $productarchivetype= get_theme_mod( 'product_archive_type','one' );
                        ?>
                        <!-- End Page Headings Layout -->
                        <!-- Begin Blog Main Post Layout -->

                        <section class="container product-main-content">
                            <div class="row">
                                <?php if ($productarchivetype=='one'): ?>
                                <div class="col-md-12">
                                    <?php else: ?>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <?php endif;?>

                                        <?php if ($archivetitledisable=='enable'): ?>
                                            <div class="side-main-title">
                                                <h2 class="section-title"><?php echo esc_html($allproducttext); ?> <?php single_cat_title( __( '', 'mayosis' ) ); ?></h2>

                                                <?php if(function_exists('mayosis_cat_filter')){
                                                    mayosis_cat_filter();
                                                } ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="mayosis-archive-wrapper container">
                                            <?php if ($productgridsystem=='two'): ?>
                                                <?php get_template_part( 'content/content-product-tag-masonary' ); ?>
                                            <?php else : ?>
                                                <?php get_template_part( 'content/content-product-tag-grid' ); ?>
                                            <?php endif; ?>
                                            <?php mayosis_page_navs(); ?>
                                        </div>
                                    </div>

                                    <?php if ($productarchivetype=='two'): ?>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <?php if ( is_active_sidebar( 'product-archive-sidebar' ) ) : ?>
                                                <?php dynamic_sidebar( 'product-archive-sidebar' ); ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                        </section>
                    </article>

<?php get_footer();?>