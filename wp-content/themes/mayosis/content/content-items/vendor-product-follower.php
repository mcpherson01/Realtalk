 <?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
global $post;
$productgridsystem= get_theme_mod( 'product_grid_system','one' );
if ( is_singular( 'download' ) ) {
			$author = new WP_User( $post->post_author );
		} else {
			$author = fes_get_vendor();
		}

		if ( ! $author ) {
			$author = get_current_user_id();
		}
$vendor =new FES_Vendor( $author->ID ,true );
$author_id = get_the_author_meta('ID');

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