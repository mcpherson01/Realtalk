<?php
if (!defined('ABSPATH')) die('-1');

class VCExtendAddonClassmasonarygrid
{

    function __construct()
    {
        add_action('init', array($this, 'masonaryWithVC'));
        add_action('wp_enqueue_scripts', array($this, 'productCSSAndJS'));
        add_shortcode('edd_masonary_grid', array($this, 'renderMasonarygrid'));
    }

    public function masonaryWithVC()
    {
        $categories_array = array(esc_html__('Select Category', 'mayosis') => '');
        $category_list = get_terms('download_category', array('hide_empty' => false));

        if (is_array($category_list) && !empty($category_list)) {
            foreach ($category_list as $category_details) {
                $begin = __(' (ID: ', 'mayosis');
                $end = __(')', 'mayosis');
                $categories_array[$category_details->name . $begin . $category_details->term_id . $end] = $category_details->term_id;
            }
        }

        vc_map(array(

            "base" => "edd_masonary_grid",
            "name" => __("Mayosis EDD Masonry Grid", 'mayosis'),
            "description" => __("Mayosis easy digital download masonary product grid", 'mayosis'),
            "class" => "",
            "icon" => get_template_directory_uri() . '/images/DM-Symbol-64px.png',
            "category" => __("Mayosis Elements", 'mayosis'),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Amount of Edd Recent to display:", 'mayosis'),
                    "param_name" => "num_of_posts",
                    "description" => __("Choose how many news posts you would like to display.", 'mayosis'),
                    'value' => __('3', 'mayosis'),
                ),

                array(
                    "type" => "dropdown",
                    "heading" => __("Post Order", 'mayosis'),
                    "param_name" => "post_order",
                    "description" => __("Set the order in which news posts will be displayed.", 'mayosis'),
                    "value" => array('DESC' => 'DESC', 'ASC' => 'ASC'), //Add default value in $atts
                ),

                array(
                    "type" => "dropdown",
                    "heading" => __("Show Product Category", 'mayosis'),
                    "param_name" => "category_product",
                    "description" => __("Show Product By Category", 'mayosis'),
                    "value" => array('Yes' => 'yes', 'No' => 'no'), //Add default value in $atts
                ),
                
                 array(
                    "type" => "dropdown",
                    "heading" => __("Show Product Category Filter", 'mayosis'),
                    "param_name" => "filterproduct",
                    "description" => __("Show Product Filter", 'mayosis'),
                    "value" => array('Yes' => 'yes', 'No' => 'no'), //Add default value in $atts
                ),
                
                array(
                    "type" => "checkbox",
                    "heading" => __("Grid Bottom Meta", 'mayosis'),
                    "param_name" => "bottommetabox",
                    "description" => __("Show Bottom meta", 'mayosis'),
                    'value' => array(
	                    esc_html__( 'Show Grid Meta Box', 'mayosis' ) => 'one',
	                    
					),
                ),
                
                
                array(
                    "type" => "dropdown",
                    "heading" => __("Show Title hover box", 'mayosis'),
                    "param_name" => "titlebox",
                    "value" => array('Yes' => '1', 'No' => '2'), //Add default value in $atts
                ),

                array(
                    "type" => "dropdown",
                    "heading" => __("Category", 'mayosis'),
                    "param_name" => "downloads_category",
                    "description" => __("Select a category", 'mayosis'),
                    'value' => $categories_array,
                    "dependency" => Array('element' => "category_product", 'value' => array('yes'))

                ),

                array(
                    "type" => "dropdown",
                    "heading" => __("Product Column (Desktop Only)", 'mayosis'),
                    "param_name" => "product_column",
                    "description" => __("Choose Product Column", 'mayosis'),
                    "value" => array('Two' => '2', 'Three' => '3','Four' => '4','Five' => '5'), //Add default value in $atts
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Grid Gap", 'mayosis'),
                    "param_name" => "grid_gap",
                    "description" => __("Add Grid Gap Without Px", 'mayosis'),
                    'value' => __('', 'mayosis'),
                ),
        		array(
                    "type" => "textfield",
                    "heading" => __("Custom Css", 'mayosis'),
                    "param_name" => "custom_css",
                    "description" => __("Custom Css Name", 'mayosis'),
                    'value' => __('', 'mayosis'),
                ),
            )

        ));
    }


    public function renderMasonarygrid($atts){

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
        $css = '';
        extract(shortcode_atts(array(
            "num_of_posts" => '3',
            "column_of_posts" => '3',
            "post_order" => 'DESC',
            'category_product' =>'',
            'downloads_category' => '',
            'filterproduct' => 'yes',
            'product_column' => '3',
            'titlebox' => '2',
            'grid_gap' => '30',
            'bottommetabox' => '',
            'custom_css' => ''

        ), $atts));
        


        /* ================  Render Shortcodes ================ */



        ob_start();

        if( $category_product == 'no' ) {
            //Fetch data
            $arguments = array(
                'post_type' => 'download',
                'post_status' => 'publish',
                //'posts_per_page' => -1,
                'order' => (string) trim($post_order),
                'posts_per_page' => $num_of_posts,
                'ignore_sticky_posts' => 1,

            );

            $post_query = new WP_Query($arguments);


        } else {

            //Fetch data
            $arguments = array(
                'post_type' => 'download',
                'post_status' => 'publish',
                //'posts_per_page' => -1,
                'order' => (string) trim($post_order),
                'posts_per_page' => $num_of_posts,
                'ignore_sticky_posts' => 1,

                'tax_query' => array(
                    array(
                        'taxonomy' => 'download_category',
                        'field' => 'term_id',
                        'terms' => $downloads_category,
                    )
                )
                //'tag' => get_query_var('tag')
            );
            $post_query = new WP_Query($arguments);
        }




        ?>
       
         <div class="<?php
		echo esc_attr($custom_css); ?>">
        <div class="row">
            <div class="col-md-12">
            <?php  if( $filterproduct == 'yes' ) : ?>
                      <div class="product-filter-wrap text-center">
                    <ul class="product-masonry-filter">
                        <li class="active"><a href="#" data-filter="*"> All</a></li>
        <?php

        $taxonomy = 'download_category';
        $terms = get_terms($taxonomy); // Get all terms of a taxonomy

        if ( $terms && !is_wp_error( $terms ) ) :
            ?>

            <?php foreach ( $terms as $term ) { ?>
                        <li><a href="#" data-filter=".<?php echo $term->slug; ?>"><?php echo $term->name; ?></a></li>
        <?php } ?>

        <?php endif;?>
                    </ul>
</div>
            <?php endif;?>
                        

              <div class="product-masonry product-masonry-gutter product-masonry-style-2 product-masonry-masonry product-masonry-full product-masonry-<?php echo $product_column;?>-column">
                  
                    <?php if ($post_query->have_posts()) : while ($post_query->have_posts()) : $post_query->the_post(); ?>
                        <?php
                        global $post;
                        $downlodterms = get_the_terms( $post->ID, 'download_category' );// Get all terms of a taxonomy
                        $cls = '';

                        if ( ! empty( $downlodterms ) ) {
                            foreach ($downlodterms as $term ) {
                                $cls .= $term->slug . ' ';
                            }
                        }
                        ?>
                        
                        <div class="product-masonry-item <?php echo $cls; ?> ">
                            <div class="product-masonry-item-content">
                                <div class="item-thumbnail">
                                    <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'large');?>
                                    <a href="<?php the_permalink();?>"><img src="<?php echo $thumbnail['0']; ?>" alt=""></a>
                                </div>
                                <?php if ($titlebox == "1"){?>
                                <div class="product-masonry-description">
                                    <h5><a href="<?php the_permalink();?>" ><?php the_title()?></a></h5>
                                    
                                </div>
                                <?php } ?>
                                   <?php if ($bottommetabox=="one"){?>
                                <div class="product-meta">
                                <?php get_template_part( 'includes/product-meta' ); ?>
                            </div>
                            <?php } ?>
                            
                                
                                
                            </div>
                        </div>
                    <?php endwhile; ?>





                        <div class="clearfix"></div>
                    <?php endif; wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
        </div>
        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }


    /*
        Load plugin css and javascript files which you may need on front end of your site
        */
    public function productCSSAndJS()
    {
        //  wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
        // wp_enqueue_style( 'slick-slider-css', get_template_directory_uri() . '/css/slick.css' );

        // If you need any javascript files on front end, here is how you can load them.
    }
}
new VCExtendAddonClassmasonarygrid();
