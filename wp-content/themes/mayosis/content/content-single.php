<?php
/**
 * The template used for displaying single post content in single.php
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$blogbgtype= get_theme_mod( 'blog_bg_type', 'color');
$authorsinglepost= get_theme_mod( 'author_single_post', 'hide');
$blogcommentsize= get_theme_mod( 'blog_comment_size','two' );
$blogsidebarremove= get_theme_mod( 'blog_sidebar_remove','on' );
$blogbottomwidget = get_theme_mod('blog_bottom_widget','on')
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="entry-content">
        <div class="page-main-header container-fluid main-post-promo main-blog-promo">

            <?php if ($blogbgtype=='featured'): ?>
                <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                <div class="container-fluid featuredimagebgblog" style="background:url(<?php echo esc_url($feat_image); ?>) center center;">
                </div>

            <?php endif; ?>
            <?php get_template_part( 'includes/blog_header' ); ?>

        </div>
        <!-- Begin Blog Main Post Layout -->
        <div class="container blog-main-content">
            <div class="mayosis-floating-share">
                <div class="theiaStickySidebar">
                    <?php if(function_exists('mayosis_floatsocial')){ ?>
                        <?php mayosis_floatsocial(); ?>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <?php if ($blogsidebarremove =='on'): ?>
                <div class="col-md-8 col-sm-7 col-xs-12 single-post-block post--boxed--width">
                    <?php else: ?>
                    <div class="col-md-8 col-sm-12 col-md-offset-2  col-xs-12 single-post-block post--full--width">
                        <?php endif; ?>
                        <div class="post-main-content">
                            <?php the_content(); ?>
                        </div>
                        <div class="bottom_meta">
                            <p class="bottom--cat--meta"><?php esc_html_e('Categories:', 'mayosis'); ?> <?php the_category(' '); ?></p>
                            <!-- everythings fine til here -->
                            <?php the_tags( 'Tags: ',' '); ?>
                        </div>

                        <?php if($blogcommentsize == 'two') :?>
                            <div class="comment-fullwidth sidebar--comment--main">
                                <?php
                                // If comments are open or we have at least one comment, load up the comment template
                                if ( comments_open() || '0' != get_comments_number() ) :
                                    comments_template();
                                endif;
                                ?>



                            </div>
                        <?php endif; ?>
                        <div class="post--arrow-nav">
                            <?php
                            $defaults = array(
                                'before'           => '<p class="footer-link-page-post" >' . __( 'Pages:', 'mayosis' ),
                                'after'            => '</p>',
                                'link_before'      => '<span class="footer-page-post-link">',
                                'link_after'       => '</span>',
                                'next_or_number'   => 'number',
                                'separator'        => ' ',
                                'nextpagelink'     => __( 'Next page', 'mayosis'),
                                'previouspagelink' => __( 'Previous page', 'mayosis' ),
                                'pagelink'         => '%',
                                'echo'             => 1
                            );

                            wp_link_pages( $defaults );

                            ?>
                        </div>
                        <div class="clearfix"></div>
                        <?php if($authorsinglepost == 'show') : ?>
                            <div class="single_author_post">
                                <div class="col-md-2 no-padding-right">
                                    <?php echo get_avatar( get_the_author_meta('email'), '90' ); ?>
                                </div>
                                <div class="col-md-10 author_single_box_padding">
                                    <h2><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') )); ?>"><?php echo esc_html(get_the_author()); ?></a></h2>
                                    <div class="author-description">
                                        <?php
                                        $authordesc = get_the_author_meta('description');
                                        if ($authordesc)
                                            echo esc_html($authordesc);
                                        else
                                            echo '';
                                        ?>

                                    </div>

                                    <ul class="icons">
                                        <?php if ( get_the_author_meta('user_url') ) : ?>
                                            <li class="rss"> <a href="<?php esc_url( the_author_meta('user_url')); ?>" class="profile-url"><i class="fas fa-globe"></i></a></li>
                                        <?php endif; ?>
                                        <?php
                                        $rss_url = get_the_author_meta( 'rss_url' );
                                        if ( $rss_url && $rss_url != '' ) {
                                            echo '<li class="rss"><a href="' . esc_url($rss_url) . '"><i class="fas fa-rss" aria-hidden="true"></i>
</a></li>';
                                        }

                                        $google_profile = get_the_author_meta( 'google_profile' );
                                        if ( $google_profile && $google_profile != '' ) {
                                            echo '<li class="google"><a href="' . esc_url($google_profile) . '" rel="author"><i class="fab fa-google-plus-g" aria-hidden="true"></i>
</a></li>';
                                        }

                                        $twitter_profile = get_the_author_meta( 'twitter_profile' );
                                        if ( $twitter_profile && $twitter_profile != '' ) {
                                            echo '<li class="twitter"><a href="' . esc_url($twitter_profile) . '"><i class="fab fa-twitter" aria-hidden="true"></i>
</a></li>';
                                        }

                                        $facebook_profile = get_the_author_meta( 'facebook_profile' );
                                        if ( $facebook_profile && $facebook_profile != '' ) {
                                            echo '<li class="facebook"><a href="' . esc_url($facebook_profile) . '"><i class="fa fa-facebook-f" aria-hidden="true"></i>
</a></li>';
                                        }

                                        $linkedin_profile = get_the_author_meta( 'linkedin_profile' );
                                        if ( $linkedin_profile && $linkedin_profile != '' ) {
                                            echo '<li class="linkedin"><a href="' . esc_url($linkedin_profile) . '"><i class="fab fa-linkedin" aria-hidden="true"></i>
</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php  endif;?>
                    </div>
                    <?php if ($blogsidebarremove =='on'): ?>
                        <div class="col-md-4 col-sm-5 col-xs-12 blog-sidebar">
                            <?php if ( is_active_sidebar( 'single-post' ) ) : ?>
                                <?php dynamic_sidebar( 'single-post' ); ?>
                            <?php else: ?>
                                <?php dynamic_sidebar( 'sidebar-1' ); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- End Blog Main Post Layout-->

            <div class="clearfix"></div>
            <!-- Begin Blog div -->
            <?php if ($blogbottomwidget =='on'): ?>
                <div class="container-fluid bottom-post-footer-widget">
                    <div class="container bottom-product-sidebar">
                        <?php get_template_part( 'content/content', 'post-footer' ); ?>

                    </div>

                </div>
            <?php endif; ?>
            <!-- End Blog div-->
        </div>


</article>