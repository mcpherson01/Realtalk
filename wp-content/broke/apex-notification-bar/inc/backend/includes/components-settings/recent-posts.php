   <div class="choosefilter">
      <div class="edn-col-full">
          <div class="edn-field-wrapper edn-form-field">
              <div class="edn-field">
              <div class="edn-field-label-wrap">
                <label><?php _e('Choose Post Layout',APEXNB_TD);?></label>
                <p class="edn-note"><?php _e("Choose recent posts or filter by category with 3 different effects as slider, ticker or scroller effect.",APEXNB_TD)?></p>
              </div>
              
                 <div class="edn-field-input-wrap">
                <?php $filterby = (isset($edn_bar_setting['edn_recentposts']['edn_choose_filter_posts']))?$edn_bar_setting['edn_recentposts']['edn_choose_filter_posts']:'bycategory';?>
                 <select name="edn_recentposts[edn_choose_filter_posts]" id="ednchoosepostsby" class="apexnb-selection">
                     <option value="recent-posts" <?php selected('recent-posts', $filterby); ?>><?php _e('Show Recent Posts',APEXNB_TD);?></option>
                     <option value="bycategory" <?php selected('bycategory', $filterby); ?>><?php _e('Filter By Category',APEXNB_TD);?></option>
                 </select>
                  </div>
              </div>
          </div>
      </div>
    </div> 
     <div class="apexnb-filterbycat">
            <?php
                $categories = get_categories(array('hide_empty' => 0));
                $taxonomies = $this->get_bar_taxonomy_lists();        
            ?>
        <div class="edn-row">
            <div class="edn-col-full">
                <div class="edn-field-wrapper edn-form-field edn-field-bottom-space">
                 <div class="edn-field">
                     <div class="edn-field-label-wrap"><label><?php _e('Filter From Category',APEXNB_TD);?></label></div>
                    <div class="edn-field-input-wrap">
                        <select class="edn-title-filter">
                            <option value="all">All</option>
                            <optgroup label="Category">
                                <?php
                                    foreach($categories as $categry){
                                        ?>
                                            <option value="<?php echo 'category='.$categry->slug?>"><?php echo $categry->name?></option>
                                        <?php
                                    }
                                ?>
                            </optgroup> 
                            <optgroup label="Terms">
                                <?php
                                    foreach($taxonomies as $tax) {
                                       $ex_taxonomy = explode(' ',$tax);
                                       $imp_taxonomy = strtolower(implode('_',$ex_taxonomy));
                                       $imp_taxonomy = strtolower(implode('-',$ex_taxonomy));
                                       // $ex_taxonomy = explode(' ',$tax);
                                       // $imp_taxonomy = strtolower(implode('-',$ex_taxonomy));
                                        $args = array( 'parent'=>'0','hide_empty' => 0);
                                           $terms = get_terms( $tax, $args );
                                        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                                            foreach ( $terms as $term ) {
                                                echo '<option value="terms='.$imp_taxonomy.'='.$term->slug.'">'.$term->name.'</option>';
                                            }
                                        }
                                    }
                                ?>
                            </optgroup>                         
                        </select>
                         <img src="<?php echo APEXNB_IMAGE_DIR ?>/templates_ajaxloader/ajax-loader1.gif" id="edn-filter-loader" class="edn-ajax-loader" style="display: none;" />
                      </div>
                       
                    </div>
                </div>
            </div>
        </div>
      <div class="edn-row">
          <div class="edn-col-full">

        <div class="edn-post-wrapper">
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

                           <label><input type="checkbox" name="edn_nb-add-check[]" 
                           class="nb-add-check" 
                           value="<?php echo $postsID; ?>"
                            data-postname="<?php echo $posts_name;?>"/><?php the_title(); ?></label>

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
                              <input type="button" class="button button-primary" id="edn_add_posts" 
                              value="<?php _e('ADD POSTS',APEXNB_TD);?>" />
                          </div>
                     
                            <div id="edn-nb-list-wrapper" style="display:<?php if(isset($edn_bar_setting['edn_display']) && count($edn_bar_setting['edn_display'])>0){echo 'block';}else{echo 'none';}?>">
                                  <h4><?php _e('Lists of Selected Posts',APEXNB_TD); ?></h4>
                                  <p class="edn-note">
                                  <?php _e('<p>You can custom sort posts to display as below.</p>',APEXNB_TD); ?></p>
                                  <div class="edn-nb-list">
                                      <?php 
                                      if(isset($edn_bar_setting['edn_display']) && !empty($edn_bar_setting['edn_display'])){
                                           $total = count($edn_bar_setting['edn_display']); 
                                         
                                           if($total>0){
                                              $count1=0;
                                              for($i=1; $i<=$total; $i++){
                                           $list_val =  $edn_bar_setting['edn_display'][$count1];
                                           ?>

                                           <div class="edn-indiv-nb-disp-id ui-sortable" val="<?php echo $list_val;?>" 
                                               id="end_pro-list-<?php echo $list_val;?>">
                                               <input type="hidden" name="edn_display[]" value="<?php echo $list_val;?>"/>
                                               <span class="ednpro_cusrom-arrows">
                                               <i class="fa fa-arrows"></i></span>
                                               <span class="edn-by-id"><?php echo get_the_title($list_val);?></span>
                                               <a href="#" class="remove_field">
                                               <i class="dashicons dashicons-trash"></i></a>
                                           </div>
                                           <?php 
                                           $count1++;  } 
                                           }else{
                                              _e('No any Posts Selected.',APEXNB_TD);
                                              }
                                          }else{
                                               _e('No any Posts Selected.',APEXNB_TD);
                                          }
                                            ?>
                                              </div>
                                       
                                  </div>
                          </div>
              
          </div>
      </div>
</div>
<?php 
$posts_per_page = (isset($edn_bar_setting['edn_recentposts']['posts_per_page']) && $edn_bar_setting['edn_recentposts']['posts_per_page'] != '')?$edn_bar_setting['edn_recentposts']['posts_per_page']:'3';
$edn_posttype_value = (isset($edn_bar_setting['edn_recentposts']['edn_posttype_value']) && $edn_bar_setting['edn_recentposts']['edn_posttype_value'] != '')?$edn_bar_setting['edn_recentposts']['edn_posttype_value']:'post';
$edn_recentposts_orderby = (isset($edn_bar_setting['edn_recentposts']['edn_recentposts_orderby']) && $edn_bar_setting['edn_recentposts']['edn_recentposts_orderby'] != '')?$edn_bar_setting['edn_recentposts']['edn_recentposts_orderby']:'date';
$edn_recentposts_order = (isset($edn_bar_setting['edn_recentposts']['edn_recentposts_order']) && $edn_bar_setting['edn_recentposts']['edn_recentposts_order'] != '')?$edn_bar_setting['edn_recentposts']['edn_recentposts_order']:'desc';
$show_read_more_btn = (isset($edn_bar_setting['edn_recentposts']['show_read_more_btn']) && $edn_bar_setting['edn_recentposts']['show_read_more_btn'] == 1)?1:0;
$read_more_label = (isset($edn_bar_setting['edn_recentposts']['read_more_label']) && $edn_bar_setting['edn_recentposts']['read_more_label'] != '')?$edn_bar_setting['edn_recentposts']['read_more_label']:'';
$read_more_target =  (isset($edn_bar_setting['edn_recentposts']['read_more_target']))?$edn_bar_setting['edn_recentposts']['read_more_target']:'_self';
?>
<div class="apexnb-recentposts">
      <div class="edn-col-full">
        <div class="edn-field-wrapper edn-form-field">
             <div class="edn-field">
             <div class="edn-field-label-wrap"><label><?php _e('Posts Per Page',APEXNB_TD);?></label></div>
            <div class="edn-field-input-wrap">
                <input type="number" name="edn_recentposts[posts_per_page]" value="<?php echo esc_attr($posts_per_page);?>"/>
           </div>
            </div>
        </div>
        </div>
       <div class="edn-col-full">
          <div class="edn-field-wrapper edn-form-field">
               <div class="edn-field">
              <div class="edn-field-label-wrap"> <label><?php _e('Choose Posts Type',APEXNB_TD);?></label> </div>
                 <div class="edn-field-input-wrap"><?php 
                 $post_types =  APEXNB_Class::apexnb_get_registered_post_types();
                 ?>
                 <select name="edn_recentposts[edn_posttype_value]" class="widefat apexnb-selectbox apexnb-selection">                   
                   <?php if(isset($post_types) && !empty($post_types)){
                    foreach ($post_types as $key => $value) {
                      ?>
                       <option value="<?php echo $value;?>" <?php selected($value, $edn_posttype_value); ?>><?php echo ucfirst($value);?></option>
                      <?php 
                    }
                   } ?>

                 </select>
              </div>
              </div>
          </div>
         </div>
          <div class="edn-col-full">
              <div class="edn-field-wrapper edn-form-field">
                   <div class="edn-field">
                     <div class="edn-field-label-wrap">
                       <label><?php _e('Order By',APEXNB_TD);?></label>
                     </div>
                      <div class="edn-field-input-wrap">
                         <select name="edn_recentposts[edn_recentposts_orderby]" class="widefat apexnb-selectbox apexnb-selection">
                                  <option value="none" <?php selected('none', $edn_recentposts_orderby); ?>>None</option>
                                  <option value="ID" <?php selected('ID', $edn_recentposts_orderby); ?>>ID</option>
                                  <option value="title" <?php selected('title', $edn_recentposts_orderby); ?>>Title</option>
                                  <option value="name" <?php selected('name', $edn_recentposts_orderby); ?>>Name</option>
                                  <option value="date" <?php selected('date', $edn_recentposts_orderby); ?>>Date</option>
                                  <option value="rand" <?php selected('rand', $edn_recentposts_orderby); ?>>Random Number</option>
                                  <option value="menu_order" <?php selected('menu_order', $edn_recentposts_orderby); ?>>Menu Order</option>
                                  <option value="author" <?php selected('author', $edn_recentposts_orderby); ?>>Author</option>
                          </select>
                          </div>
                 
                      
                  </div>
              </div>
          </div>
              <div class="edn-col-full">
              <div class="edn-field-wrapper edn-form-field">
                   <div class="edn-field">
                 <div class="edn-field-label-wrap"> <label><?php _e('Order',APEXNB_TD);
                 ?></label></div>
                   <div class="edn-field-input-wrap">
                         <select name="edn_recentposts[edn_recentposts_order]" class="widefat apexnb-selectbox apexnb-selection">
                                  <option value="asc" <?php selected('asc', $edn_recentposts_order); ?>>Ascending Order</option>
                                  <option value="desc" <?php selected('desc', $edn_recentposts_order); ?>>Descending Order</option>  
                          </select>
                  </div>
                      
                  </div>
              </div>
          </div>
       <div class="edn-col-full">
          <div class="edn-field-wrapper edn-form-field">
               <div class="edn-field">
              <div class="edn-field-label-wrap">  
                  <label for="show_read_more_btn"><?php _e('Display Read More button',APEXNB_TD); ?></label></div>
               <div class="edn-field-input-wrap">
                  <div class="apexnb-switch">
                 <input type="checkbox" id="show_read_more_btn" name="edn_recentposts[show_read_more_btn]" value="1" <?php if($show_read_more_btn ==1 ){echo 'checked';}?>/> 
                   <label for="show_read_more_btn"></label>
                 </div>
               </div>
              </div>
          </div>
      </div>
      <div class="edn-col-full">
          <div class="edn-field-wrapper edn-form-field">
               <div class="edn-field">
              <div class="edn-field-label-wrap">  <label><?php _e('Button Label',APEXNB_TD); ?> </label></div>
                <div class="edn-field-input-wrap">
                <input type="text" name="edn_recentposts[read_more_label]" value="<?php echo esc_attr($read_more_label);?>" placeholder="<?php _e('Read More',APEXNB_TD);?>"/>
             </div>
                  
              </div>
          </div>
      </div>
      <div class="edn-col-full">
          <div class="edn-field-wrapper edn-form-field">
               <div class="edn-field">
              <div class="edn-field-label-wrap">  <label><?php _e('Button Target',APEXNB_TD); ?> </label></div>
                <div class="edn-field-input-wrap">
                 <select name="edn_recentposts[read_more_target]" class="widefat apexnb-selectbox apexnb-selection">
                           <option value="_blank"  <?php selected('_blank', $read_more_target); ?>><?php _e('_blank',APEXNB_TD);?></option>
                           <option value="_self"  <?php selected('_self', $read_more_target); ?>><?php _e('_self',APEXNB_TD);?></option>
                           <option value="_parent" <?php selected('_parent', $read_more_target); ?>><?php _e('_parent',APEXNB_TD);?></option>
                           <option value="_top"  <?php selected('_top', $read_more_target); ?>><?php _e('_top',APEXNB_TD);?></option>
                  </select>
               </div>    
              </div>
          </div>
      </div>
</div>