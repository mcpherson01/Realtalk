<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_author_grid_edd extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
        $css = '';
        extract(shortcode_atts(array(
            "recent_section_title" => 'Author',
            "sub_title" =>'',
            "button_link" => '',
            "button_text" =>'',
            "num_of_authors" => '',
            "author_id_main" => '',
            'css' => ''
        ), $atts));
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );



        /* ================  Render Shortcodes ================ */



        ob_start();


        ?>
        <div class="fes--author---titlebox">
                <div class="fes--author--top-title">
                    <h3 class="section-title"><?php echo esc_attr($recent_section_title); ?></h3>
                    <p><?php echo esc_attr($sub_title); ?></p>
                </div>
                
                <div class="fes--author--buttonbox">
                    <?php
                 if ($button_link) { ?>
                    <a href="<?php echo esc_attr($button_link); ?>" class="btn fes--box-btn"><?php echo esc_attr($button_text); ?></a>
                    <?php } ?>
                </div>
        </div>
        <?php
        $include = $author_id_main; 
        $userarg = array(
            'include' => $include,
             'number' => $num_of_authors,
             'orderby'      => 'include',
            );
        $allUsers = get_users($userarg);
        $users = array();

// Remove subscribers from the list as they won't write any articles

        foreach($allUsers as $vendor)
        {
            if (!in_array( 'author', $vendor->roles))
            {
                $users[] = $vendor;
            }
        }
        ?>

        <?php
        foreach($users as $user)
        {
            global $post;
            $post_count = count_user_posts($user->ID);
            $author = get_user_by( 'id', get_query_var( 'author' ) );
            $authoraddress = get_the_author_meta( 'address',$user->ID );

            $exclude_post_id = $post->ID;
            $taxchoice = isset( $edd_options['related_filter_by_cat'] ) ? 'download_tag' : 'download_category';
            $custom_taxterms = wp_get_object_terms( $post->ID, $taxchoice, array('fields' => 'ids') );
            $author = $post->post_author;
            $authorID= get_the_author_meta('ID', $user->ID );
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

                        <p class="author--address"><?php echo $authoraddress; ?></p>
                        <a class="fes--v-portfolio" href="<?php echo mayosis_fes_author_url( get_the_author_meta( 'ID',$authorID ) ) ?>">
                        <?php esc_html_e('View Portfolio','mayosis'); ?></a>
                   </span>

                    
                    
                   

                </div>

                <div class="fes--author--products">
                    <ul class="fes--author--image--block">
                        <?php



                        $arguments = array(
                            'post_type' => 'download',
                            'post_status' => 'publish',
                            'posts_per_page' =>3,
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

                        <?php endif; ?>

                        <?php wp_reset_postdata(); ?>

                    </ul>
                </div>
            </div>
            <?php
        }

        ?>


        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "author_grid_edd",
    "name"      => __("Mayosis Featured Vendors", 'mayosis'),
    "description"      => __("Mayosis Easy Digital Download Author Vendors", 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __("Mayosis Elements", 'mayosis'),
    "params"    => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Section Title', 'mayosis' ),
            'param_name' => 'recent_section_title',
            'value' => __( '', 'mayosis' ),
            'description' => __( 'Title for author grid section', 'mayosis' ),
        ),
        
        array(
                    'type' => 'textfield',
                    'heading' => __('Section Sub Title', 'mayosis') ,
                    'param_name' => 'sub_title',
                    'value' => __('', 'mayosis') ,
                    'description' => __('Subtitle for author grid', 'mayosis') ,
                ) ,
                
                 array(
                    'type' => 'textfield',
                    'heading' => __('Button URL', 'mayosis') ,
                    'param_name' => 'button_link',
                    'value' => __('', 'mayosis') ,
                    'description' => __('Contributor more button url', 'mayosis') ,
                ) ,
                
                
                array(
                    'type' => 'textfield',
                    'heading' => __('Button Text', 'mayosis') ,
                    'param_name' => 'button_text',
                    'value' => __('', 'mayosis') ,
                    'description' => __('Contributor more button text', 'mayosis') ,
                ) ,



            array(
                    "type" => "textfield",
                    "heading" => __("Amount of Edd Author to display:", 'mayosis') ,
                    "param_name" => "num_of_authors",
                    "description" => __("Choose how many author you would like to display.", 'mayosis') ,
                    'value' => __('3', 'mayosis') ,
                ) ,
                
                
                array(
                    "type" => "textfield",
                    "heading" => __("Author ID Display:", 'mayosis') ,
                    "param_name" => "author_id_main",
                    "description" => __("Put Author ID with commas (i.e : 1,5,6)", 'mayosis') ,
                    'value' => __('1,2,3', 'mayosis') ,
                ) ,
        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),

    )

));