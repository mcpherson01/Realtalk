<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<div class="edn-row">
    <div class="edn-col-half">
        <div class="edn-field-wrapper edn-form-field">
            <label><?php _e('Page list', APEXNB_TD) ?></label>
            <div class="edn-field">
            <?php 
                //echo '<pre>';
//                print_r($this->bar_page_lists());
//                echo '</pre>';
                $pages = $this->get_bar_page_lists();
            ?>
                <select name="edn_selected_page[]" multiple="multiple" id="edn-select-pages" class="edn-select" data-page-placeholder="<?php _e('Select Pages',APEXNB_TD)?>">
                    <option value="all-pages"><?php _e('All Pages',APEXNB_TD)?></option>
                    <?php
                        if(count($pages) > 0){
                            foreach($pages as $page){
                                ?>
                                    <option value="<?php echo $page;?>"><?php _e($page,APEXNB_TD)?></option>
                                <?php
                            }
                        }else{
                            ?>
                                <option><?php _e('Empty!',APEXNB_TD);?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="edn-col-half">
        <div class="edn-field-wrapper edn-form-field">
            <label><?php _e('Post list', APEXNB_TD) ?></label>
            <div class="edn-field">
            <?php 
                $posts = $this->get_bar_post_lists();
            ?>
                <select name="edn_selected_post[]" multiple="multiple" id="edn-select-posts" class="edn-select" data-post-placeholder="<?php _e('Select Posts',APEXNB_TD)?>">
                    <option value="all-posts"><?php _e('All Posts',APEXNB_TD)?></option>
                    <?php
                        if(count($posts) > 0){ 
                            foreach($posts as $post){
                                ?>
                                    <option value="<?php echo $post;?>"><?php _e($post,APEXNB_TD)?></option>
                                <?php
                            }
                        }else{
                            ?>
                                <option><?php _e('Empty!',APEXNB_TD);?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="edn-clear"></div>
</div>
<div class="edn-row">
    <div class="edn-col-half">
        <div class="edn-field-wrapper edn-form-field">
            <label><?php _e('Category list', APEXNB_TD) ?></label>
            <div class="edn-field">
            <?php 
                $categories = $this->get_bar_category_lists();
                //echo '<pre>';
//                print_r($categories);
//                echo '</pre>';
            ?>
                <select name="edn_selected_category[]" multiple="multiple" id="edn-select-categories" class="edn-select" data-category-placeholder="<?php _e('Select Category',APEXNB_TD)?>">
                    <option value="all-category"><?php _e('All Category',APEXNB_TD)?></option>
                    <?php
                        if(count($categories) > 0){
                            foreach($categories as $category){
                                ?>
                                    <option value="<?php echo $category;?>"><?php _e($category,APEXNB_TD)?></option>
                                <?php
                            }
                        }else{
                            ?>
                                <option><?php _e('Empty!',APEXNB_TD);?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <!-- <div class="edn-col-half">
        <div class="edn-field-wrapper edn-form-field">
            <label><?php _e('Taxonomy list', APEXNB_TD) ?></label>
            <div class="edn-field">
                <?php
                    $taxonomies = $this->get_bar_taxonomy_lists();
                ?>
                <select name="edn_selected_taxonomy[]" multiple="multiple" id="edn-select-taxonomies" class="edn-select" data-taxonomy-placeholder="<?php _e('Select Taxonomy',APEXNB_TD)?>">
                    <option value="all-taxonomy"><?php _e('All Taxonomy',APEXNB_TD)?></option>
                    <?php
                        foreach($taxonomies as $taxonomy){
                            ?>
                                <option value="<?php echo $taxonomy;?>"><?php _e($taxonomy,APEXNB_TD)?></option>
                            <?php
                        }                    
                    ?>
                </select>
            </div>
        </div>
    </div> -->
    <div class="edn-clear"></div>
</div>
<div class="edn-row">
    <div class="edn-col-half">
        <div class="edn-field-wrapper edn-form-field">
            <label><?php _e('Terms list', APEXNB_TD) ?></label>
            <div class="edn-field">
                <?php
                    $taxonomies = $this->get_bar_taxonomy_lists();
                    if(count($taxonomies) > 0){
                        $placeholder = __('Select terms',APEXNB_TD);
                        $taxo = '<select name="edn_selected_terms[]" multiple="multiple" id="edn-select-terms" class="edn-select" data-term-placeholder="'.$placeholder.'"><option value="all-terms">'.__('All Terms',APEXNB_TD).'</option>';
                        foreach($taxonomies as $tax) {
                            $taxo .= '<optgroup label="'.$tax.'">';
                            $ex_taxonomy = explode(' ',$tax);
                            $imp_taxonomy = strtolower(implode('-',$ex_taxonomy));
                            $args = array( 'parent'=>'0','hide_empty' => 0);
                            $terms = get_terms( $imp_taxonomy, $args );
                            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                                foreach ( $terms as $term ) {
                                    $taxo .= '<option value="'.$term->name.'">'.$term->name.'</option>';
                                }
                            }
                            $taxo .= '</optgroup>';
                        }
                       $taxo .= '</select>';
                       echo $taxo;
                    }else{
                        $taxo = '<select name="edn_selected_terms[]" multiple="multiple" id="edn-select-terms" class="edn-select">';
                        $taxo .= '<option>'.__('Empty!',APEXNB_TD).'</option>';
                        $taxo .= '</select>';
                        echo $taxo;
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="edn-col-half">
        <div class="edn-field-wrapper edn-form-field">
            <label><?php _e('Post types list', APEXNB_TD) ?></label>
            <div class="edn-field">
                <?php 
                   $post_types = $this->get_bar_post_types();
//                   echo '<pre>';
//                   print_r($post_types);
//                   echo '</pre>';

                ?>
                <select name="edn_selected_post_type[]" multiple="multiple" id="edn-select-post-types" class="edn-select" data-post-type-placeholder="<?php _e('Select Post Type',APEXNB_TD)?>">
                    <option value="all-post-type"><?php _e('All Post Type',APEXNB_TD)?></option>
                    <?php
                        if(count($post_types) > 0){
                            foreach($post_types as $post_type){
                                ?>
                                    <option value="<?php echo $post_type;?>"><?php _e($post_type,APEXNB_TD)?></option>
                                <?php
                            }
                        }else{
                            ?>
                                <option><?php _e('Empty!',APEXNB_TD);?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>
</div>