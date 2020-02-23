<?php
/**
 * Footer Product Widget
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>

<div class="row">

    <div class="col-md-4 col-sm-4 col-xs-12 bottom--post--block">
        <h4><?php esc_html_e('Related Blog Post','mayosis'); ?></h4>
        <?php $orig_post = $post;
        global $post;
        $categories = get_the_category($post->ID);
        if ($categories) {
            $category_ids = array();
            foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
            $args=array(
                'category__in' => $category_ids,
                'post__not_in' => array($post->ID),
                'posts_per_page'=> 3, // Number of related posts that will be shown.
                'ignore_sticky_posts'=>1
            );
            $my_query = new wp_query( $args );
            if( $my_query->have_posts() ) {
                while( $my_query->have_posts() ) {
                    $my_query->the_post();?>
                    <div class="bottom-widget-product ">
                        <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail paading-left-0">
                            <div class="product-thumb grid_dm">
                                <figure class="mayosis-fade-in">
                                    <?php
                                    the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                                    ?>
                                    <figcaption>
                                        <div class="overlay_content_center">
                                            <a href="<?php
                                            the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
                            <h3><a href="<?php the_permalink(); ?>"><?php
                                    $title  = the_title('','',false);
                                    if(strlen($title) > 40):
                                        echo trim(substr($title, 0, 32)).'...';
                                    else:
                                        echo esc_html($title);
                                    endif;
                                    ?></a></h3>
                            <p> <?php if(function_exists('mayosis_views')){ ?>
                                   <?php echo(ajax_hits_counter_get_hits(get_the_ID())); ?> <?php esc_html_e('Views','mayosis');?> <?php } ?> </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                }
            }
            else {
                echo'<div class="col-lg-12 pm-column-spacing">';
                echo'<p>No posts were found</p>';
                echo' </div>';
            }
        }
        $post = $orig_post;
        wp_reset_postdata(); ?>
    </div>



    <div class="col-md-4 col-sm-4 col-xs-12 bottom--post--block">
        <h4><?php esc_html_e('Popular Blog Post','mayosis'); ?></h4>

        <?php if(function_exists('mayosis_most_viewed_posts_footer')){ ?>
            <?php  mayosis_most_viewed_posts_footer( );?>
        <?php } ?>
        <div class="clearfix"></div>


    </div>


    <div class="col-md-4 col-sm-4 col-xs-12 bottom--post--block">
        <h4><?php esc_html_e('Featured Products','mayosis'); ?></h4>
        <?php   	//Fetch data
        $arguments = array(
            'post_type' => 'download',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'order' => 'DESC',
            'ignore_sticky_posts' => 1,
            'tag' => get_query_var('tag'),
            'meta_key' => 'edd_feature_download',
        );

        $post_query = new WP_Query($arguments);?>
        <?php $featured_downloads = new WP_Query( $arguments );

        if( $featured_downloads->have_posts() ) : ?>
            <?php while( $featured_downloads->have_posts() ) : $featured_downloads->the_post(); ?>

                <div class="bottom-widget-product ">
                    <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail paading-left-0">
                        <div class="product-thumb grid_dm">
                            <figure class="mayosis-fade-in">
                                <?php
                                the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                                ?>
                                <figcaption>
                                    <div class="overlay_content_center">
                                        <a href="<?php
                                        the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
                        <h3><a href="<?php the_permalink(); ?>">
                                <?php
                                $title  = the_title('','',false);
                                if(strlen($title) > 40):
                                    echo trim(substr($title, 0, 37)).'...';
                                else:
                                    echo esc_html($title);
                                endif;
                                ?>
                            </a></h3>
                        <?php get_template_part( 'includes/product-additional-meta'); ?>

                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php endwhile; else: ?>
            <div class="col-lg-12 pm-column-spacing">
                <p><?php esc_html_e('No posts were found.', 'mayosis'); ?></p>
            </div>
        <?php endif; ?>
        <!--Sidebar Product-->
        <?php wp_reset_postdata(); ?>
    </div>
</div>