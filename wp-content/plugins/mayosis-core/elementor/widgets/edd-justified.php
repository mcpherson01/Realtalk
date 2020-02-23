<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class mayosis_edd_justified_Elementor extends Widget_Base {

    public function get_name() {
        return 'mayosis-edd-justified';
    }

    public function get_title() {
        return __( 'Mayosis EDD Justified Grid', 'mayosis' );
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
                'label' => __( 'Mayosis EDD Justified', 'mayosis' ),
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
            'grid_gap',
            [
                'label' => __( 'Grid Gap', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Grid gap Without PX', 'mayosis' ),
                'section' => 'section_edd',
                'default' => '2.5',
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
        $custom_css = $settings['custom_css'];
        $grid_gap= $settings['grid_gap'];
        ?>

   
        <div class="<?php
        echo esc_attr($custom_css); ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php  if( $filterproduct == 'show' ) : ?>
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
                            <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'large');?>
                           <a href="<?php
                        the_permalink(); ?>" style="margin:<?php
		echo esc_attr($grid_gap); ?>px" class="tile scale-anm <?php echo $cls; ?> all">
                            <img src="<?php echo $thumbnail['0']; ?>" />
                        </a>


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
Plugin::instance()->widgets_manager->register_widget_type( new mayosis_edd_justified_Elementor );
?>