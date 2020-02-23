 <?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
global $post;
$productgridsystem= get_theme_mod( 'product_grid_system','one' );
$author = get_user_by( 'id', get_query_var( 'author' ) );

?>

   <div class="single--metabox--info">
                            <h4>

                                <?php
                                $follower_count = teconce_get_follower_count( get_the_author_meta( 'ID',$author->ID ) );

                                echo esc_html($follower_count);


                                ?>
                            </h4>
                            <p><?php esc_html_e('Followers','mayosis')?></p>
                        </div>