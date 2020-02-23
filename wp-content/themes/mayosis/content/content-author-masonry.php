<?php
/**
 * @package mayosis
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $post;
$author = get_user_by( 'id', get_query_var( 'author' ) );
?>
       <div class="row">
        <div class="masonary-brick">
            <?php
    $term=get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    $authordownload =get_the_author_meta( 'ID',$author->ID );
    $paged=( get_query_var( 'paged')) ? get_query_var( 'paged') : 1;
    $CatTerms=(isset($term->slug))?$term->slug:null;
    $cat = ( isset( $_GET['download_category'] ) ) ? $_GET['download_category'] : null;
    
     $search = ( isset( $_GET['search'] ) ) ? $_GET['search'] : null;


    
     
    if (! isset( $wp_query->query['orderby'] ) ) {
       
         $args = array(
            'order' => 'DESC',
            'post_type' => 'download',
            'author' => $authordownload,
            'paged' => $paged ,
            'download_category'=>$cat,
            's' =>$search,
             
            );
     
   }
   
  else{
   switch ($wp_query->query['orderby']) {
            case 'newness_asc':
                $args = array(
                    'orderby' => 'newness_asc',
                    'order' => 'ASC',
                    'post_type' => 'download',
                    'download_category'=>$cat,
                    'author' => $authordownload,
                     's' =>$search,
                    'paged' => $paged );
                break;
            case 'newness_desc':
                $args = array(
                    'orderby' => 'newness_desc',
                    'order' => 'DESC',
                    'post_type' => 'download',
                    'download_category'=>$cat,
                    'author' => $authordownload,
                     's' =>$search,
                    'paged' => $paged );
                break;
            case 'sales':
                $args = array(
                    'meta_key'=>'_edd_download_sales',
                    'order' => 'DESC',
                    'orderby' => 'meta_value_num',
                    'download_category'=>$cat,
                    'post_type' => 'download',
                    'author' => $authordownload,
                     's' =>$search,
                    'paged' => $paged );
                break;
            case 'price_asc':
                $args = array(
                    'meta_key'=>'edd_price',
                    'order' => 'ASC',
                    'orderby' => 'meta_value_num',
                    'download_category'=>$cat,
                    'post_type' => 'download',
                    'author' => $authordownload,
                     's' =>$search,
                    'paged' => $paged );
                break;
                
                case 'price_desc':
                $args = array(
                    'meta_key'=>'edd_price',
                    'order' => 'DESC',
                    'orderby' => 'meta_value_num',
                    'download_category'=>$cat,
                    'post_type' => 'download',
                    'author' => $authordownload,
                     's' =>$search,
                    'paged' => $paged );
                break;
                
                case 'title_asc':
                $args = array(
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'download_category'=>$cat,
                    'post_type' => 'download',
                    'author' => $authordownload,
                     's' =>$search,
                    'paged' => $paged );
                break;
                
                case 'title_desc':
                $args = array(
                    'orderby' => 'title',
                    'order' => 'DESC',
                    'download_category'=>$cat,
                    'post_type' => 'download',
                    'author' => $authordownload,
                     's' =>$search,
                    'paged' => $paged );
                break;
        } }
    $temp = $wp_query; $wp_query = null;
    $wp_query = new WP_Query(); $wp_query->query($args); ?>
    <?php if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                                    <?php $thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
                       <a href="<?php
                        the_permalink(); ?>" class="masonary-tile">
                        <img src="<?php echo esc_html($thumbnail);?>" alt="<?php the_title();?>">
                        </a>
                         <?php endwhile; else : ?>
<?php endif; ?>


                            </div>
    </div>