<?php
/**
 * Template Name: FES VENDOR LIST
 *
 * This is a fes vendor list Page template.
 *
 * @package mayosis-digital-marketplace-theme
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

$custom_page_title = get_post_meta( $post->ID, 'custom_page_title', true );

$custom_bd_bg_image = get_post_meta( $post->ID, 'breadcrumb_image', true );

$custom_page_padding_on= get_post_meta( $post->ID, 'custom_padding', true );

$custom_page_padding_top = get_post_meta( $post->ID, 'custom_page_padding_top', true );

$custom_page_padding_bottom = get_post_meta( $post->ID, 'custom_page_padding_bottom', true );
?>
<?php if ($custom_page_padding_on =="Yes") { ?>
    <style>
        .page_breadcrumb{
            padding-top:<?php echo esc_html($custom_page_padding_top); ?>;
            padding-bottom:<?php echo esc_html($custom_page_padding_bottom); ?>;
        }
    </style>
<?php } ?>
<?php if ( is_home() ) {
    $breadcrumb_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_hide', true );
} else {
    $breadcrumb_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_hide', true );
} ?>

    <div class="container-fluid">
<?php while ( have_posts() ) : the_post(); ?>
    <?php  if($breadcrumb_hide == "Yes"){ ?>
    <?php  if($mayosis_gradient == "Yes"){ ?>
    <div class="row page_breadcrumb" style="background:linear-gradient(45deg, <?php echo esc_html($mayosis_gradient_a); ?> , <?php echo esc_html($mayosis_gradient_b); ?>);">
    <?php } else { ?>

<?php  if($custom_bd_bg_image){ ?>
    <div class="row page_breadcrumb" style="background-image:url(<?php echo get_post_meta(get_the_ID(), 'breadcrumb_image', true ); ?>);">
        <?php } else { ?>
        <div class="row page_breadcrumb" style="background-color:<?php echo esc_html($mayosis_breadcrumb_color); ?>;">

            <?php } ?>

            <?php } ?>
            <div class="container">
                <h2 class="page_title_single">
                    <?php  if($custom_page_title){ ?>
                        <?php echo esc_html($custom_page_title);?>
                    <?php } else { ?>
                        <?php the_title(); ?>
                    <?php } ?>
                </h2>
                <?php if (function_exists('dm_breadcrumbs')) dm_breadcrumbs(); ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="mayosis-container" style="background:<?php echo esc_html($mayosis_page_bg); ?>">
        
        <?php if ( class_exists( 'EDD_Front_End_Submissions' ) ){ ?>
<div class="fes-contributor-list">
<div class="fes--vendor--searchbar">
   <div class="container">
       <div class="vendor--search--flex vendor--list-searchbar">
           <div class="vendor--search--box">
        
           <form role="search" method="GET" id="searchform" action="<?php echo esc_url(get_search_query( true )); ?>">
    <input type="text" name="search" id="search" placeholder="Search Contributor">

    <span class="search-btn"><input value="" type="submit" placeholder="Submit"></span>
</form>

                
           </div>
           
           <div class="vendor--search-filter--box">
                 <?php
            $old=null;
            $popular=null;
            $recent=null;
            $titleAtoZ=null;
            $titleZtoA=null;
            if(isset($_GET['orderby'])){
                if($_GET['orderby']=="newness_asc"){
                    $recent="selected";
                }

                else if($_GET['orderby']=="newness_desc"){
                    $old="selected";
                }
                else if($_GET['orderby']=="popular"){
                    $popular="selected";
                }
                
                else if($_GET['orderby']=="title_asc"){
                    $titleAtoZ="selected";
                }
                
                else if($_GET['orderby']=="title_desc"){
                    $titleZtoA="selected";
                }
                

            }
            else{
                $recent="selected";
            } ?>
       <select class="product_filter_mayosis resizeselect" id="resizing_select" onchange="if (this.value) window.location.href=this.value">
           
           <option <?php echo esc_html($popular); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'popular'))); ?>"><?php esc_html_e('Popular','mayosis'); ?></option>
           
            <option <?php echo esc_html($old); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'newness_desc'))); ?>"><?php esc_html_e('Recent','mayosis'); ?></option>

            <option <?php echo esc_html($recent); ?>  value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'newness_asc'))); ?>"><?php esc_html_e('Older','mayosis'); ?></option>
            
            <option <?php echo esc_html($titleAtoZ); ?>  value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'title_asc'))); ?>"><?php esc_html_e('Title (A - Z)','mayosis'); ?></option>
            
            <option <?php echo esc_html($titleZtoA); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'title_desc'))); ?>"><?php esc_html_e('Title (Z - A)','mayosis'); ?></option>
        </select>
        
       
           </div>
       </div>
   </div>
</div>
        <div class="container">

    
            <?php
            global $wp_query;
    
            $default_posts_per_page = get_option( 'posts_per_page' );
            $users_per_page = $default_posts_per_page;
            $paged=get_query_var('paged') ? (int) get_query_var('paged') : 1;
            $search = ( isset( $_GET['search'] ) ) ? $_GET['search'] : null;
            
    if (! isset( $wp_query->query['orderby'] ) ) {
            $userarg = array(
                'order' => 'DESC',
                'paged' => $paged ,
                'search' =>$search,
                'number' => $users_per_page, 
                'has_published_posts' => array('download'),
            );
            
    }
   
  else{
     switch ($wp_query->query['orderby']) {
            case 'newness_asc':
              $userarg = array(
                'orderby' => 'newness_asc',
                'order' => 'ASC',
                'paged' => $paged ,
                'search' =>$search,
                'number' => $users_per_page, 
                'has_published_posts' => array('download'),
            );
            
              break;
              
              
              case 'newness_desc':
              $userarg = array(
                'orderby' => 'newness_desc',
                'order' => 'DESC',
                'paged' => $paged ,
                'search' =>$search,
                'number' => $users_per_page, 
                'has_published_posts' => array('download'),
            );
            
              break;
              
              
              case 'popular':
              $userarg = array(
               'orderby' => 'meta_value_num',
               'meta_key' => '_teconce_followers',
                'paged' => $paged ,
                'search' =>$search,
                'number' => $users_per_page, 
                'has_published_posts' => array('download'),
            );
            
              break;
              
              case 'title_asc':
                $userarg = array(
                 'orderby' => 'display_name',
                 'order' => 'ASC',
                'paged' => $paged ,
                'search' =>$search,
                'number' => $users_per_page, 
                'has_published_posts' => array('download'),
            );
                break;
                
                case 'title_desc':
                $userarg = array(
                 'orderby' => 'display_name',
                 'order' => 'DESC',
                'paged' => $paged ,
                'search' =>$search,
                'number' => $users_per_page, 
                'has_published_posts' => array('download'),
            );
                break;
     }
    
  } 
            $users = new WP_User_Query( $userarg );
           
            ?>
            <?php
            if ( ! empty( $users->get_results() ) ) {
            foreach($users->get_results() as $user)
            {
                global $post;
                $post_count = count_user_posts($user->ID);
                $authoraddress = get_the_author_meta( 'address',$user->ID );

                $exclude_post_id = $post->ID;
                $taxchoice = isset( $edd_options['related_filter_by_cat'] ) ? 'download_tag' : 'download_category';
                $custom_taxterms = wp_get_object_terms( $post->ID, $taxchoice, array('fields' => 'ids') );
                $authorID= get_the_author_meta('ID', $user->ID );
                $authordownload =get_the_author_meta( 'ID',$authorID );
                ?>
                <div class="fes--author--block">
                    <div class="fes--author--meta">
                    <span class="fes--author--image">
                    <a href="<?php
                    echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID',$user->ID)) )); ?>">
                        <?php
                        echo get_avatar($user->user_email, '100', array(
                            'class' => array(
                                'd-block',
                                'img-responsive'
                            )
                        )); ?></a>
                         </span>

                        <span class="fes--author--data">
                          <a href=""<?php echo mayosis_fes_author_url( get_the_author_meta( 'ID',$authorID ) ) ?>"> <h4 class="authorName">
                <?php
                echo esc_html($user->display_name); ?></h4></a>

                            <p class="author--address"><?php echo esc_html($authoraddress); ?></p>
                        <a class="fes--v-portfolio" href="<?php echo mayosis_fes_author_url( get_the_author_meta( 'ID',$authorID ) ) ?>">
                        <?php esc_html_e('View Portfolio','mayosis'); ?>(<?php echo count_user_posts($authordownload,'download'); ?>)</a>
                   </span>





                    </div>

                    <div class="fes--author--products">
                        <ul class="fes--author--image--block">
                            <?php



                            $arguments = array(
                                'post_type' => 'download',
                                'post_status' => 'publish',
                                'posts_per_page' =>4,
                                'order' => 'DESC',
                                'ignore_sticky_posts' => 1,
                                'ignore_sticky_posts'=>1,
                                'author'=> $authorID,

                            );

                            $post_query = new WP_Query($arguments); ?>
                            <?php if ( $post_query->have_posts() ) : while ( $post_query->have_posts() ) : $post_query->the_post(); ?>

                                <li class="grid-product-box">
                                    <div class="product-thumb grid_dm">
                                        <figure class="mayosis-fade-in">
                                            <?php
                                            if ( has_post_thumbnail() ) {
                                                the_post_thumbnail('mayosis-product-grid-small');
                                            }
                                            ?>
                                            <figcaption>
                                                <div class="overlay_content_center">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <i class="zil zi-plus"></i>
                                                    </a>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </div>
                                </li>
                            <?php endwhile; else: ?>
                                <?php esc_html_e('No products found','mayosis') ?>
                            <?php endif; ?>

                            <?php wp_reset_postdata(); ?>

                        </ul>

                    </div>
                </div>
              
                
             
     
                <?php
            }

            ?>
 <?php  } else { ?>
  <?php esc_html_e('Nothing Found','mayosis') ?>
 <?php } ?>
 <div class="common-paginav text-center">
 <div class="pagination">
   <?php
               $total_user = $users->total_users;  
              $total_pages=ceil($total_user/$users_per_page);

              echo paginate_links(array(  
                  'base' => get_pagenum_link(1) . '%_%',  
                  'format' => '?paged=%#%',  
                  'current' => $paged,  
                  'total' => $total_pages,  
                  'prev_text' => 'Previous',  
                  'next_text' => 'Next'  
                ));  
        ?>
        </div>
        </div>
</div>
        </div>

    </div>
    <?php 
    } else { ?>
    <div class="fes-contributor-is-disabled">
    <h3><?php esc_html_e('Nothing Found!','mayosis'); ?></h3>
    <h4><?php esc_html_e('Please Install Frontend Submission','mayosis'); ?> </h4>
    </div>
    <?php } ?>
<?php endwhile; // end of the loop. ?>



<?php get_footer(); ?>