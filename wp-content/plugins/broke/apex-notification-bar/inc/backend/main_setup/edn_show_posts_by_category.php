<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if(isset($_POST['page'])){

  $category_type = $_POST['cat_type'];
  $category_slug = $_POST['cate'];

  $items_per_page = APEXNB_PAGE_LIMIT;   //limit


/*Case 1: catgory type */
  if($category_type == "category"){
  $start = !empty($_POST['page'])?$_POST['page']:0; //offset
  //get number of rows
  $edn_pro_object = new APEXNB_Class(); //initialization of plugin
  $querys         = $edn_pro_object->edn_get_postsdata_by_category($category_slug);
  $totalrows      = $querys->found_posts;

 //initialize pagination class
$pagConfig = array(
        'baseURL'       => APEXNB_CLASS_DIR_PAGINATION.'edn_show_posts_by_category.php', 
        'cat_slug'      => $category_slug,
        'category_type' => $category_type,
        'taxonomy'      => '',
        'totalRows'     => $totalrows, 
        'currentPage'   => $start, 
        'perPage'       => $items_per_page,
        'contentDiv'    => 'posts_content_category'
        );

$pagination =  new ApexNb_Pagination($pagConfig);

// $query = new WP_Query( $args );
 if($totalrows  > 0){ ?>
    <div id="posts_content_category">
        <div class="multiselect edn-display-title" id="showpages">
        <?php while ($querys->have_posts()) : $querys->the_post(); 
         $posts_name = get_the_title();
          $postsID =  get_the_ID();  ?>

           <label><input type="checkbox" name="edn_nb-add-check[]"  class="nb-add-check" value="<?php echo $postsID; ?>"
              data-postname="<?php echo $posts_name;?>"/><?php the_title(); ?></label>



        <?php endwhile;
              wp_reset_postdata();
        ?>
        </div>
     </div>
  <?php echo $pagination->createLinks(); ?>
 <?php 
 }else{
_e('No any Posts of this category found.',APEXNB_TD);
}

}else if($category_type == "terms"){
    $start1 = !empty($_POST['page'])?$_POST['page']:0; //offset
    $taxonomy = $_POST['taxonomy'];
        //get number of rows
                         $args = array(
                                'tax_query' =>array(
                                    array('taxonomy' => $taxonomy,
                                        'field' => 'slug',
                                        'terms' => $category_slug)
                                    ),
                                'orderby'        => 'id',
                                'order'          => 'desc',
                             'offset'         =>  $start1,
                             'post_status'    => array( 'publish' ),
                             'posts_per_page' =>  APEXNB_PAGE_LIMIT
                            );
                        $loop = new WP_Query($args);
                        $total_count = $loop->found_posts;
                       //initialize pagination class
                         $pagConfigs = array(
                        'baseURL'       => APEXNB_CLASS_DIR_PAGINATION.'edn_show_posts_by_category.php',
                        'cat_slug'      => $category_slug,
                        'category_type' => $category_type,
                        'taxonomy'      => $taxonomy,
                        'totalRows'     => $total_count, 
                        'currentPage'   => $start1,
                        'perPage'       => APEXNB_PAGE_LIMIT, 
                        'contentDiv'    =>'posts_content_terms');
                        $paginations         =  new ApexNb_Pagination($pagConfigs);

                     if($total_count  > 0){ ?>
                        <div id="posts_content_terms">
                            <div class="multiselect edn-display-title" id="showpages">
                            <?php while ($loop->have_posts()) : $loop->the_post(); 
                             $posts_name = get_the_title();
                              $postsID =  get_the_ID();  ?>

                               <label><input type="checkbox" name="edn_nb-add-check[]"  class="nb-add-check" value="<?php echo $postsID; ?>"
                                  data-postname="<?php echo $posts_name;?>"/><?php the_title(); ?></label>



                            <?php endwhile;
                                  wp_reset_postdata();
                            ?>
                            </div>
                         </div>
                      <?php echo $paginations->createLinks(); ?>
                     <?php 
                     }else{
                    _e('No any Posts of this terms category found.',APEXNB_TD);
                    }
 
      }
}
