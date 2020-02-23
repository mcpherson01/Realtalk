<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class mayosis_edd_grid_Elementor_Thing extends Widget_Base {

    public function get_name() {
        return 'mayosis-edd-grid';
    }

    public function get_title() {
        return __( 'Mayosis Small Grid', 'mayosis' );
    }
    public function get_categories() {
        return [ 'mayosis-ele-cat' ];
    }
    public function get_icon() {
        return 'eicon-posts-grid';
    }

    protected function _register_controls() {

        $this->add_control(
            'section_edd',
            [
                'label' => __( 'Mayosis Small Grid', 'mayosis' ),
                'type' => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Section Title', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Section Title', 'mayosis' ),
                'section' => 'section_edd',
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __( 'Sub Title', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Sub Title', 'mayosis' ),
                'section' => 'section_edd',
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
                'label' => __( 'Category Name', 'mayosis' ),
                'description' => __('Add one category slug','mayosis'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'section' => 'section_edd',
            ]
        );

        $this->add_control(
            'margin_bottom',
            [
                'label' => __( 'Title Section Margin Bottom (With px)', 'mayosis' ),
                'description' => __('Add Margin Bottom','mayosis'),
                'type' => Controls_Manager::TEXT,
                'default' => '20px',
                'section' => 'section_edd',
            ]
        );
        $this->add_control(
            'selectoption',
            [
                'label' => __( 'Right Side Option', 'mayosis' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_edd',
                'options' => [
                    'button' => 'Button',
                    'category' => 'Category Filter'
                ],
                'default' => 'button',

            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Button Text', 'mayosis' ),
                'section' => 'section_edd',
                 'condition' => [
                    'selectoption' => array('button'),
                ],
            ]
        );


                $this->add_control(
                    'button_link',
                    [
                        'label' => __( 'Button URL', 'mayosis' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => '',
                        'title' => __( 'Enter Button URL', 'mayosis' ),
                        'section' => 'section_edd',
                         'condition' => [
                    'selectoption' => array('button'),
                ],
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

    }

    protected function render( $instance = [] ) {

        // get our input from the widget settings.

        $settings = $this->get_settings();
        $recent_section_title = $settings['title'];
        $post_count = ! empty( $settings['item_per_page'] ) ? (int)$settings['item_per_page'] : 5;
        $posts_category= $settings['category'];
        $post_order_term=$settings['order'];
        $sub_title = $settings['sub_title'];
        $title_sec_margin = $settings['margin_bottom'];
        $button_text = $settings['button_text'];
        $button_link = $settings['button_link'];
        $selectoption = $settings['selectoption'];
        ?>


        <div class="edd_recent_ark">

        <div class="full--grid-elementor">
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
                        <a href="<?php echo esc_attr($button_link); ?>" class="btn title--box--btn"><?php echo esc_attr($button_text); ?></a>
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
            <div class="product--grid--elementor <?php
                if ($selectoption=='category') { ?>gridboxsmall<?php }?>">

                <?php
                global $post;
                if($settings['show_category'] == 'no') {
                    $args = array( 'post_type' => 'download','numberposts' => $post_count, 'category_name' => $posts_category,'order' => (string) trim($post_order_term), );
                } else {
                    $args = array(
                        'post_type' => 'download',
                        'numberposts' => $post_count,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'download_category',
                                'field' => 'slug',
                                'terms' => $posts_category,
                            ),
                        ),
                        'order' => (string)trim($post_order_term),);
                }
                $recent_posts = get_posts( $args ); ?>
                
                <ul class="recent_image_block">
                    <?php foreach( $recent_posts as $post ){?>
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

                    <?php } ?>
                </ul>
                <?php  wp_reset_postdata();
                ?>
            </div>


        </div>
        <?php

    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new mayosis_edd_grid_Elementor_Thing );
?>