<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class mayosis_edd_block_Elementor extends Widget_Base {

    public function get_name() {
        return 'mayosis-edd-block';
    }

    public function get_title() {
        return __( 'Mayosis Download Block', 'mayosis' );
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
                'label' => __( 'Mayosis EDD Block', 'mayosis' ),
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
            'show_single',
            [
                'label'     => esc_html_x( 'Product Type', 'Admin Panel','mayosis' ),
                'description' => esc_html_x('Select Product Type', 'mayosis' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'    =>  "no",
                'section' => 'section_edd',
                "options"    => array(
                    "single" => "SINGLE",
                    "recent" => "RECENT",

                ),
            ]

        );
        
        $this->add_control(
            'products_ids',
            [
                'label' => __( 'Product ID', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Product ID', 'mayosis' ),
                'section' => 'section_edd',
                'condition' => [
                    'show_single' => array('single'),
                ],
            ]
        );
        
        $this->add_control(
            'products_custom_text',
            [
                'label' => __( 'Custom Description', 'mayosis' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'title' => __( 'Add Custom Description', 'mayosis' ),
                'section' => 'section_edd',
                'condition' => [
                    'show_single' => array('single'),
                ],
            ]
        );
        
        $this->add_control(
            'item_per_page',
            [
                'label'   => esc_html_x( 'Amount of item to display', 'Admin Panel', 'mayosis' ),
                'type'    => Controls_Manager::NUMBER,
                'default' =>  "10",
                'section' => 'section_edd',
                'condition' => [
                    'show_single' => array('recent'),
                ],
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
            'button_text',
            [
                'label' => __( 'Button Text', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Button Text', 'mayosis' ),
                'section' => 'section_edd',
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
                'condition' => [
                    'show_single' => array('recent'),
                ],

            ]
        );

    }

    protected function render( $instance = [] ) {

        // get our input from the widget settings.

        $settings = $this->get_settings();
        $recent_section_title = $settings['title'];
        $post_count = ! empty( $settings['item_per_page'] ) ? (int)$settings['item_per_page'] : 5;
        $post_order_term=$settings['order'];
        $sub_title = $settings['sub_title'];
        $title_sec_margin = $settings['margin_bottom'];
        $button_text = $settings['button_text'];
        $button_link = $settings['button_link'];
        $products_ids = $settings ['products_ids'];
        $products_textarea = $settings ['products_custom_text'];
        
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
                    if ($button_link) { ?>
                        <a href="<?php echo esc_attr($button_link); ?>" class="btn title--box--btn"><?php echo esc_attr($button_text); ?></a>
                    <?php } ?>
                </div>
            </div>
            <div class="product--grid--elementor">

                <?php
                global $post;
                if($settings['show_single'] == 'single') {
                    	$myarray = array($products_ids);
                    $args = array( 'post_type' => 'download','numberposts' => 1, 'order' => (string) trim($post_order_term),'post__in'      => $myarray );
                } else {
                    $args = array(
                        'post_type' => 'download',
                        'numberposts' => $post_count,
                        'order' => (string)trim($post_order_term),);
                }
                $recent_posts = get_posts( $args ); ?>
              
                    <?php foreach( $recent_posts as $post ){?>
                    <div class="mayosis_block_product">
                                <div class="col-md-6 block_product_thumbnail">
                                   <a href="<?php
                                                the_permalink(); ?>"> <?php
                                        the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                                        ?></a>
                                </div>
                                <div class="col-md-6 block_product_details single-cart-button">
                                    <h4><?php the_title(); ?></h4>
                                    <?php if($settings['show_single'] == 'single') { ?>
                                    <?php echo esc_attr($products_textarea);?>
                                    <?php } else { ?>
                                    <?php the_excerpt(); ?>
                                    <?php } ?>
                                    <div class="block_button_details">
                                        <a href="<?php
                                                the_permalink(); ?>" class="button_accent btn" ><?php esc_html_e('View Details','mayosis');?></a>
                                    </div>
                                </div>
                            </div>

                    <?php } ?>
                
                <?php  wp_reset_postdata();
                ?>
            </div>


        </div>
        <?php

    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new mayosis_edd_block_Elementor );
?>