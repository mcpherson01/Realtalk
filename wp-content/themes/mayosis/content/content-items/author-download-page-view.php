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
                                global $wp_query;

                                $author_id = get_the_author_meta( 'ID',$author->ID );
                                
                                $author_posts = get_posts( array('post_type'=>'download' ,'author' => $author_id,'numberposts' => -1) );
                                
                                $counter = 0; // needed to collect the total sum of views
                                
                                foreach ( $author_posts as $post ) {
                                
                                    $views =  get_post_meta( $post->ID, 'hits', true);
                                
                                   
                                
                                    $counter += $views;
                                }
                                echo esc_html($counter);
                                

                                ?>
                            </h4>
                            <p><?php esc_html_e('Page Views','mayosis')?></p>
                        </div>