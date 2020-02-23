<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class mayosis_edd_author_Elementor extends Widget_Base {

    public function get_name() {
        return 'mayosis-edd-author';
    }

    public function get_title() {
        return __( 'Mayosis Download Vendor', 'mayosis' );
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
                'label' => __( 'Mayosis Vendor Settings', 'mayosis' ),
                'type' => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Title', 'mayosis' ),
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
            'author_id',
            [
                'label' => __( 'Author ID (i.e 1,2,3)', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Author ID', 'mayosis' ),
                'section' => 'section_edd',
            ]
        );

        $this->add_control(
            'author_count',
            [
                'label' => __( 'Number of Author', 'mayosis' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => __( 'Enter Author Number', 'mayosis' ),
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
        $custom_css = $settings['custom_css'];
        $recent_section_title = $settings['title'];
        $author_id_main = $settings['author_id'];
        $num_of_authors = $settings['author_count'];
        $sub_title = $settings['sub_title'];
        $button_text = $settings['button_text'];
        $button_link = $settings['button_link'];
        $title_sec_margin = $settings['margin_bottom'];

        ?>


        <div class="<?php
        echo esc_attr($custom_css); ?>">

            <div class="fes--author---titlebox" style="margin-bottom:<?php echo esc_attr($title_sec_margin); ?>;">
                <div class="fes--author--top-title">
                    <h3 class="section-title"><?php echo esc_attr($recent_section_title); ?> </h3>
                    <?php
                    if ($sub_title ) { ?>
                        <p><?php echo esc_attr($sub_title); ?></p>
                    <?php } ?>
                </div>

                <div class="fes--author--buttonbox">
                    <?php
                    if ($button_link) { ?>
                        <a href="<?php echo esc_attr($button_link); ?>" class="btn fes--box-btn"><?php echo esc_attr($button_text); ?></a>
                    <?php } ?>
                </div>
            </div>


            <?php
            $include =  $author_id_main;
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
                    <a href="<?php echo mayosis_fes_author_url( get_the_author_meta( 'ID',$authorID ) ) ?>">
                        <?php
                        echo get_avatar($user->user_email, '100', array(
                            'class' => array(
                                'd-block',
                                'img-responsive'
                            )
                        )); ?></a>
                         </span>

                        <span class="fes--author--data">
                          <a href="<?php echo mayosis_fes_author_url( get_the_author_meta( 'ID',$authorID ) ) ?>"> <h4 class="authorName">
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
                                'posts_per_page' => 4,
                                'order' => 'DESC',
                                'ignore_sticky_posts' => 1,
                                'ignore_sticky_posts'=>1,
                                'author'=> $authorID,

                            );

                            $post_query = new \WP_Query($arguments); ?>
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

        </div>


        <?php

    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new mayosis_edd_author_Elementor );
?>