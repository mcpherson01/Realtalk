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

                            <?php
                            $authordownload =get_the_author_meta( 'ID',$author->ID );
                            ?>
                            <h4><?php echo count_user_posts($authordownload,'download'); ?></h4>
                            <p><?php esc_html_e('Products','mayosis')?></p>
                        </div>