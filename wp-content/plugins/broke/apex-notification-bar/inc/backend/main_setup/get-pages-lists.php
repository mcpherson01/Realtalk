<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<div class="show_pages_lists" style="display:none;">
<p class="description"><?php _e('Choose multiple pages or posts title from above dropdown and click on below Add Specific Pages button.
All the selected lists of post/pages title will be listed below "Lists of Selected Pages" section which simply means the notification bar will be
displayed only on choosed pages.',APEXNB_TD);?></p>
<div class="edn-row">
<div class="edn-col-full">

<div class="edn-post-wrapper ">
  <div class="edn-apend-titles"></div>
     <?php 
            $query = $this->edn_get_postsdata();
            $total_rows = $query->found_posts;
            //initialize pagination class
            $pagConfig = array(
                'baseURL'=> APEXNB_CLASS_DIR_PAGINATION.'edn_show_posts_with_pagination.php',
                'totalRows'=>$total_rows, 
                'perPage'=>APEXNB_PAGE_LIMIT, 
                'contentDiv'=>'posts_content');
            $pagination =  new ApexNb_Pagination($pagConfig);?>
    
           
            <?php if($total_rows  > 0){ ?>
                <div id="posts_content">
                   <div class="multiselect edn-display-title" id="showpages">
                  <?php while ($query->have_posts()) : $query->the_post();
                  $posts_name = get_the_title();
                  $postsID =  get_the_ID(); 
                 ?>

                     <label>
                     <input type="checkbox" name="edn_add_spage[]" multiple value="<?php echo $postsID; ?>"
                      data-postname="<?php echo $posts_name;?>" class="nb-add-check" /><?php the_title(); ?>
                    </label>

                        <?php endwhile;
                            wp_reset_postdata();
                        ?>
                    </div>
                    <?php echo $pagination->createLinks(); ?>
                
                  </div>
             
            <?php }else{
                _e('No any Posts.',APEXNB_TD);
                } ?>
                     <div class="clear"></div>

                    <div class="edn_pro_add_posts">
                        <input type="button" class="button button-primary" id="edn_add_pages" 
                        value="<?php _e('ADD SPECIFIC PAGES',APEXNB_TD);?>" />
                    </div>
               
                      <div id="edn-nb-list-wrapper" style="display:<?php if(isset( $showpages_array) && !empty( $showpages_array)){echo 'block';}else{echo 'none';}?>">
                            <h4><?php _e('Lists of Selected Pages',APEXNB_TD); ?></h4>
                            <div class="edn-nb-list2">
                                <?php 
                                if(isset($showpages_array) && !empty($showpages_array)){
                                     $total = count($showpages_array); 
                                   
                                     if($total>0){
                                        $count1=0;
                                        for($i=1; $i<=$total; $i++){
                                     $list_val =  $showpages_array[$count1];
                                     ?>

                                     <div class="edn-indiv-nb-disp-id edn-indiv-nb-disp-pages" val="<?php echo $list_val;?>" 
                                         id="end_pro-list-<?php echo $list_val;?>">
                                         <input type="hidden" name="edn_showpages[]" value="<?php echo $list_val;?>"/>
                                         <span class="ednpro_cusrom-arrows">
                                         <i class="fa fa-arrows"></i></span>
                                         <span class="edn-by-id"><?php echo get_the_title($list_val);?></span>
                                         <a href="#" class="remove_field">
                                         <i class="dashicons dashicons-trash"></i></a>
                                     </div>
                                     <?php 
                                     $count1++;  } 
                                     }else{
                                        _e('No any Pages Selected.',APEXNB_TD);
                                        }
                                    }else{
                                         _e('No any Pages Selected.',APEXNB_TD);
                                    }
                                      ?>
                           </div>
                                 
      </div>
</div>




<p class="edn-note"><?php _e('Note: You can select multiple posts, pages, post types title from this multiple selection fields.',APEXNB_TD);?></p>
<div class="edn-apend-titles"></div>
</div>
</div>
</div>