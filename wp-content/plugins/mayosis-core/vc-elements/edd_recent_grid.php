<?php
if (!defined('ABSPATH')) die('-1');

class VCsmallgrid
{

    function __construct()
    {
        add_action('init', array($this, 'smallgridWithVC'));
        add_action('wp_enqueue_scripts', array($this, 'smallproductCSSAndJS'));
        add_shortcode('digital_small_recent', array($this, 'rendersmallgrid'));
    }

    public function smallgridWithVC()
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

            "base" => "digital_small_recent",
            "name" => __("Mayosis EDD Small Grid", 'mayosis'),
            "description" => __("Mayosis easy digital download recent product grid", 'mayosis'),
            "class" => "",
            "icon" => get_template_directory_uri() . '/images/DM-Symbol-64px.png',
            "category" => __("Mayosis Elements", 'mayosis'),
            "params" => array(
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Section Title', 'mayosis' ),
                    'param_name' => 'recent_section_title',
                    'value' => __( 'Recent Edd', 'mayosis' ),
                    'description' => __( 'Title for Recent Section', 'mayosis' ),
                ),

                array(
                    "type" => "textfield",
                    "heading" => __("Amount of Edd Recent to display:", 'mayosis'),
                    "param_name" => "num_of_posts",
                    "description" => __("Choose how many news posts you would like to display.", 'mayosis'),
                    'value' => __( '3' , 'mayosis' ),
                ),

                array(
                    "type" => "dropdown",
                    "heading" => __("Post Order", 'mayosis'),
                    "param_name" => "post_order",
                    "description" => __("Set the order in which news posts will be displayed.", 'mayosis'),
                    "value"      => array( 'DESC' => 'DESC', 'ASC' => 'ASC'), //Add default value in $atts
                ),




                array(
                    "heading" => __( "Subtitle", "mayosis" ),
                    "description" => __("Enter Sub title","mayosis"),
                    "param_name" => "sub_title",
                    "type" => "textfield",

                ),

                array(
                    "heading" => __( "Title Margin Bottom", "mayosis" ),
                    "description" => __("Title Section Margin Bottom (With px)","mayosis"),
                    "param_name" => "title_sec_margin",
                    "type" => "textfield",

                ),
                  array(
                    "type" => "dropdown",
                    "heading" => __("Right Side Option", 'mayosis') ,
                    "param_name" => "selectoption",
                    "description" => __("Set the order in which news posts will be displayed.", 'mayosis') ,
                    "value" => array(
                        'Button' => 'Button',
                        'Category Filter' => 'category'
                    ) , //Add default value in $atts
                ) ,
                array(
                    "heading" => __( "Button Text", "mayosis" ),
                    "description" => __("Enter Button Text","mayosis"),
                    "param_name" => "button_text",
                    "type" => "textfield",

                ),

                array(
                    "heading" => __( "Button URL", "mayosis" ),
                    "description" => __("Enter Button URL","mayosis"),
                    "param_name" => "button_link",
                    "type" => "textfield",

                ),

                array(
                    "type" => "dropdown",
                    "heading" => __("Button Style", 'mayosis'),
                    "param_name" => "button_style",
                    "description" => __("Set Button Style", 'mayosis'),
                    "value"      => array( 'Solid' => 'solid', 'Ghost' => 'transparent'), //Add default value in $atts
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Show Product Category", 'mayosis'),
                    "param_name" => "category_product",
                    "description" => __("Show Product By Category", 'mayosis'),
                    "value" => array('No' => 'no','Yes' => 'yes'), //Add default value in $atts
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
                    "type" => "textfield",
                    "heading" => __("Custom Css", 'mayosis'),
                    "param_name" => "custom_css",
                    "description" => __("Custom Css Name", 'mayosis'),
                    'value' => __('', 'mayosis'),
                ),
            )

        ));
    }


    public function rendersmallgrid($atts, $content = null){

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
        $css = '';
        extract(shortcode_atts(array(
            "recent_section_title" => 'Recent EDD',
            "num_of_posts" => '3',
            "column_of_posts" => '3',
            "post_order" => 'DESC',
            'free_product_label' => '1',
            'product_style_option' => '1',
            'sub_title' =>'',
            'title_sec_margin' =>'',
            'button_text' =>'',
            'button_link' =>'',
            'button_style' =>'',
            "category_product" => 'no',
            "downloads_category"=> '',
            'selectoption' => '',
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
        <?php
        global $post;

        ?>
        <!-- Element Code start -->
 
      

        <div class="row fix">
        <div class="col-md-12">

        <div class="title--box--full" style="margin-bottom:<?php echo esc_attr($title_sec_margin); ?>;">
            <div class="title--promo--box">
                <h3 class="section-title"><?php echo esc_attr($recent_section_title); ?> </h3>
                <?php
                if ($sub_title ) { ?>
                    <p><?php echo esc_attr($sub_title); ?></p>
                <?php } ?>
            </div>

            <div class="title--button--box">
                  <?php
                if ($selectoption=='button') { ?>
                <?php
                if ($button_link) { ?>
                    <a href="<?php echo esc_attr($button_link); ?>" class="btn title--box--btn <?php echo esc_attr($button_style);?>"><?php echo esc_attr($button_text); ?></a>
                <?php } ?>
                  <?php } else { ?>
                 <div class="regular-category-search">
            <select class="mayosis-filters-select-small">
                <option value="*"><?php esc_html_e('All Categories','mayosis'); ?></option>
                            <?php

                            $taxonomy = 'download_category';
                            $terms = get_terms($taxonomy); // Get all terms of a taxonomy

                            if ( $terms && !is_wp_error( $terms ) ) :
                                ?>

                                <?php foreach ( $terms as $term ) { ?>
                                <option value=".<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
                            <?php } ?>
                            
                            <?php endif;?>

          
            </select>
        </div>
        <?php } ?>
            </div>
        </div>
        <ul class="recent_image_block gridboxsmall">
        <?php
    if ($post_query->have_posts()):
    while ($post_query->have_posts()):
        $post_query->the_post(); ?>
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
        <li class="grid-product-box <?php echo $cls; ?>">
            <div class="product-thumb grid_dm">
                <figure class="mayosis-fade-in">
                    <?php
                    the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                    ?>
                    <figcaption>
                        <div class="overlay_content_center">
                            <a href="<?php
                            the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                        </div>
                    </figcaption>
                </figure>
            </div>
        </li>
                    <?php
                    endwhile; ?>
        </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- Element Code / END -->
        </div>
        <div class="clearfix"></div>
    <?php
    endif;
        wp_reset_postdata(); ?>

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }


    /*
        Load plugin css and javascript files which you may need on front end of your site
        */
    public function smallproductCSSAndJS()
    {
        //  wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
        // wp_enqueue_style( 'slick-slider-css', get_template_directory_uri() . '/css/slick.css' );

        // If you need any javascript files on front end, here is how you can load them.
    }
}
new VCsmallgrid();
