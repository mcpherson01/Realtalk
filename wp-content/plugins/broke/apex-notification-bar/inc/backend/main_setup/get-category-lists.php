<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
 <div class="show_cat_lists" style="display:none;">
   <div class="edn-row">
      <div class="edn-col-full">
      <?php
      $category_listss = array();
      $posttypes = $edn_pro_object->apexnb_get_registered_post_types();
      unset($posttypes['product']);

      foreach ($posttypes as $key) {
        $taxonomy_objects = get_object_taxonomies( $key, 'objects' );
        foreach ($taxonomy_objects as $value) {
         $taxn = $value->name;
         if($taxn != "post_tag" || $taxn != "post_format"){
              $category_lists = array('name' => $key,
               'taxonomy' => $taxn);
             array_push($category_listss,$category_lists);
          }
         
        }
      }
  
      ?>
  <select name="edn_showterm[]" multiple="multiple" id="edn-showterms" class="edn-display-title">
     <?php 
     if(isset($category_listss) && !empty($category_listss)){ 
         foreach ($category_listss as $key => $value) {
         $taxonomy = $value['taxonomy']; 
         $name = $value['name']; 
         $terms = get_terms($taxonomy); // Get all terms of a taxonomy

         if ( $terms && !is_wp_error( $terms ) ) : ?>
         <optgroup label="Category: <?php echo ucwords($name);?>">
 <?php foreach ( $terms as $term ) { ?>
         <option value="<?php echo $term->term_id;?>" <?php if(!empty( $showcat_array) && in_array($term->term_id ,$showcat_array)) { echo "selected='selected'"; } ?>><?php echo $term->name; ?></option>
         <?php
      } ?>

      </optgroup>   
      <?php
         endif;
       } 
   } ?>
         
    </select>
         <p class="edn-note"><?php _e('Note: You can select multiple category from post, post type from above multiple selection fields to display notification bars on specific selected cateogry only.',APEXNB_TD);?></p>
         <div class="edn-apend-titles"></div>
      </div>
   </div>
</div>