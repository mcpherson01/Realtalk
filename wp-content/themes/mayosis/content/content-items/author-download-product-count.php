<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
global $post;
$author = get_user_by( 'id', get_query_var( 'author' ) );

?>
                <div class="single--metabox--info">

                            <?php
                            $authordownload =get_the_author_meta( 'ID',$author->ID );
                            ?>
                            <h4><?php echo count_user_posts($authordownload,'download'); ?></h4>
                            <p><?php esc_html_e('Products','mayosis')?></p>
                        </div>