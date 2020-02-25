<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if(isset($_POST['page'])){
$start = !empty($_POST['page'])?$_POST['page']:0; //offset
$items_per_page = APEXNB_PAGE_LIMIT;   //limit
//get number of rows
$edn_pro_object = new APEXNB_Class(); //initialization of plugin
$querys = $edn_pro_object->edn_get_postsdata();
$totalrows = $querys->found_posts;

 //initialize pagination class
$pagConfig = array(
        'baseURL'     => APEXNB_CLASS_DIR_PAGINATION.'edn_show_posts_with_pagination.php', 
        'totalRows'   => $totalrows, 
        'currentPage' => $start, 
        'perPage'     => $items_per_page,
        'contentDiv'  => 'posts_content'
        );
$pagination =  new ApexNb_Pagination($pagConfig);

//get all data usign wp_query    
$args = array(
    'post_type'      => array( 'post', 'page' , 'post_type'),
    'post_status'    => array( 'publish' ),
    'posts_per_page' => $items_per_page,
    'orderby'        => 'id',
    'order'          => 'desc',
    'offset'         =>  $start
    );
$query = new WP_Query( $args );
 if($totalrows  > 0){ ?>
    <div id="posts_content">
        <div class="multiselect edn-display-title" id="showpages">
        <?php while ($query->have_posts()) : $query->the_post(); 
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
_e('No any Posts.',APEXNB_TD);
}
}