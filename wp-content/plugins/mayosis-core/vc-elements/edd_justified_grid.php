<?php
if (!defined('ABSPATH')) die('-1');

class VCExtendAddonClassjustifiedgrid
{

    function __construct()
    {
        add_action('init', array($this, 'justifiedWithVC'));
        add_action('wp_enqueue_scripts', array($this, 'productCSSAndJS'));
        add_shortcode('edd_jusitifed_grid', array($this, 'renderJustifiedgrid'));
    }

    public function justifiedWithVC()
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

            "base" => "edd_jusitifed_grid",
            "name" => __("Mayosis EDD Justified Grid", 'mayosis'),
            "description" => __("Mayosis easy digital download justified product grid", 'mayosis'),
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
                    "type" => "dropdown",
                    "heading" => __("Category", 'mayosis'),
                    "param_name" => "downloads_category",
                    "description" => __("Select a category", 'mayosis'),
                    'value' => $categories_array,
                    "dependency" => Array('element' => "category_product", 'value' => array('yes'))

                ),

                array(
                    'type' => 'textfield',
                    'heading' => __('Grid Gap', 'mayosis'),
                    'param_name' => 'grid_gap',
                    'value' => __('2.5', 'mayosis'),
                    'description' => __('Input integer value without px (ie. 5)', 'mayosis'),
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


    public function renderJustifiedgrid($atts, $content = null){

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
        $css = '';
        extract(shortcode_atts(array(
            "num_of_posts" => '3',
            "column_of_posts" => '3',
            "post_order" => 'DESC',
            'category_product' =>'',
            'downloads_category' => '',
            'grid_gap' =>'',
            'filterproduct' => 'yes',
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
                <div class="grid--filter--main">
                    <span class="fil-cat active" data-rel="all"><?php esc_html_e('All Categories','mayosis'); ?></span>
                    <?php

                    $taxonomy = 'download_category';
                    $terms = get_terms($taxonomy); // Get all terms of a taxonomy

                    if ( $terms && !is_wp_error( $terms ) ) :
                        ?>

                        <?php foreach ( $terms as $term ) { ?>
                        <span class="fil-cat" data-rel="<?php echo $term->slug; ?>"><?php echo $term->name; ?></span>
                    <?php } ?>

                    <?php endif;?>
                </div>
            <?php endif;?>
                        

                <div class="justified-grid justified-grid-margin" id="isotope-filter">
                    <?php if ($post_query->have_posts()) : while ($post_query->have_posts()) : $post_query->the_post(); ?>
                        <?php
                        $terms = get_the_terms( $post->ID, 'download_category' );// Get all terms of a taxonomy
                        $cls = '';

                        if ( ! empty( $terms ) ) {
                            foreach ( $terms as $term ) {
                                $cls .= $term->slug . ' ';
                            }
                        }
                        ?>
                        <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'large');?>
                        <a href="<?php
                        the_permalink(); ?>" style="margin:<?php echo esc_attr($grid_gap); ?>px" class="tile scale-anm <?php echo $cls; ?> all">
                            <img src="<?php echo $thumbnail['0']; ?>" />
                        </a>
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
new VCExtendAddonClassjustifiedgrid();
