<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class mayosis_edd_masonary_Elementor extends Widget_Base {

    public function get_name() {
        return 'mayosis-edd-masonary';
    }

    public function get_title() {
        return __( 'Mayosis EDD Masonry Grid', 'mayosis' );
    }
    public function get_categories() {
        return [ 'mayosis-ele-cat' ];
    }
    public function get_icon() {
        return 'eicon-elementor';
    }

    protected function _register_controls() {

        $this->add_control(
            'section_edd',
            [
                'label' => __( 'mayosis EDD Masonry', 'mayosis' ),
                'type' => Controls_Manager::SECTION,
            ]
        );



        $this->add_control(
            'item_per_page',
            [
                'label'   => esc_html_x( 'Amount of item to display', 'Admin Panel', 'mayosis' ),
                'type'    => Controls_Manager::NUMBER,
                'default' =>  "10",
                'section' => 'section_edd',
            ]
        );
        $this->add_control(
            'list_layout',
            [
                'label'     => esc_html_x( 'Layout', 'Admin Panel','mayosis' ),
                'description' => esc_html_x('Column layout for the list"', 'mayosis' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'    =>  "3",
                'section' => 'section_edd',
                "options"    => array(
                    "2" => "Two",
                    "3" => "Three",
                    "4" => "Four",
                    "5" => "Five",
                ),
            ]

        );

        $this->add_control(
            'show_category',
            [
                'label'     => esc_html_x( 'Filter Category Wise', 'Admin Panel','mayosis' ),
                'description' => esc_html_x('Select if want to show product by category', 'mayosis' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'    =>  "no",
                'section' => 'section_edd',
                "options"    => array(
                    "yes" => "Yes",
                    "no" => "No",

                ),
            ]

        );


        $this->add_control(
            'category',
            [
                'label' => __( 'Category Slug', 'mayosis' ),
                'description' => __('Add one category slug','mayosis'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'section' => 'section_edd',
            ]
        );
        $this->add_control(
            'filter-product',
            [
                'label' => __( 'Show Product Filter', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_edd',
                'options' => [
                    'show' => 'Show',
                    'hide' => 'Hide'
                ],
                'default' => 'hide',

            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __( 'Order', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_edd',
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'desc',

            ]
        );
        
        $this->add_control(
            'titilebox',
            [
                'label' => __( 'Title Hover Box', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_edd',
                'options' => [
                    'show' => 'Show',
                    'hide' => 'Hide'
                ],
                'default' => 'hide',

            ]
        );
        
        $this->add_control(
            'bottommetabox',
            [
                'label' => __( 'Grid Meta Box', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_edd',
                'options' => [
                    'show' => 'Show',
                    'hide' => 'Hide'
                ],
                'default' => 'hide',

            ]
        );
     

        $this->add_control(
            'custom_css',
            [
                'label' => __( 'Custom CSS', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Custom CSS name', 'mayosis' ),
                'section' => 'section_edd',
            ]
        );

    }

    protected function render( $instance = [] ) {

        // get our input from the widget settings.

        $settings = $this->get_settings();
        $post_count = ! empty( $settings['item_per_page'] ) ? (int)$settings['item_per_page'] : 5;
        $post_order_term=$settings['order'];
        $downloads_category=$settings['category'];
        $filterproduct = $settings['filter-product'];
        $titlebox = $settings['titilebox'];
        $custom_css = $settings['custom_css'];
        $product_column= $settings['list_layout'];
        $bottommetabox = $settings['bottommetabox'];
        ?>


        <div class="<?php
        echo esc_attr($custom_css); ?>">
            <div class="row">
                <div class="col-md-12">
                      <?php  if( $filterproduct == 'show' ) : ?>
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
<?php endif; ?>

                    <div class="product-masonry product-masonry-gutter product-masonry-style-2 product-masonry-masonry product-masonry-full product-masonry-<?php echo $product_column;?>-column">

        <?php
        global $post;
        if($settings['show_category'] == 'no') {
            $args = array('post_type' => 'download', 'numberposts' => $post_count, 'order' => (string)trim($post_order_term),);
        } else {
            $args = array(
                'post_type' => 'download',
                'numberposts' => $post_count,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'download_category',
                        'field' => 'slug',
                        'terms' => $downloads_category,
                    ),
                ),
                'order' => (string)trim($post_order_term),);
        }
        $recent_posts = get_posts( $args );
        foreach( $recent_posts as $post ){?>
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
                                <?php if ($titlebox=="show"){?>
                                <div class="product-masonry-description">
                                    <h5><a href="<?php the_permalink();?>" ><?php the_title()?></a></h5>
                                    
                                </div>
                                <?php } ?>
                                
                                <?php if ($bottommetabox=="show"){?>
                                <div class="product-meta">
                                <?php get_template_part( 'includes/product-meta' ); ?>
                            </div>
                            <?php } ?>
                            
                            
                            </div>
                            
                        </div>

        <?php } ?>



                        <div class="clearfix"></div>
                        <?php  wp_reset_postdata();
                        ?>




                </div>
                </div>
            </div>
        </div>


        <?php

    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new mayosis_edd_masonary_Elementor );
?>