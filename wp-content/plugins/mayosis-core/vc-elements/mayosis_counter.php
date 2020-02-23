<?php

if (!class_exists('WPBakeryShortCode')) return;
class WPBakeryShortCode_digital_theme_counter extends WPBakeryShortCode

{
    protected
    function content($atts, $content = null)
    {

        // $custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;

        $css = '';
        extract(shortcode_atts(array(
            "edd_counter_title" => '',
            "type_of_counter" => '',
            "edd_custom_count" => '',
            "title_align" => '',
            "title_color" => '',
            "count_color" => '',
            "custom_class" => '',
            'css' => ''
        ) , $atts));
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' ') , $this->settings['base'], $atts);
        /* ================  Render Shortcodes ================ */
        ob_start();
        ?>

        <?php

        // $img = wp_get_attachment_image_src($el_image, "large");
        // $imgSrc = $img[0];

        ?>
        
        <!-- Element Code start -->
        <div class="counter-box <?php echo esc_attr( $css_class ); ?> <?php echo esc_attr( $custom_class ); ?>" style="text-align: <?php
        echo esc_attr($title_align); ?>;" >
            <?php
            if ($type_of_counter == "4")
            { ?>
                 <h4 class="statistic-counter" style="color:<?php
                echo esc_attr($count_color); ?>"><?php
                    echo esc_attr($edd_custom_count); ?></h4>
                <p style="color:<?php
                echo esc_attr($title_color); ?>"><?php
                    echo esc_attr($edd_counter_title); ?></p>
                <?php
            }
            elseif ($type_of_counter == "2")
            { ?>
                <?php
                $args = array(
                    'post_type' => 'download',
                    'posts_per_page' => - 1,
                    'download_category' => ''
                );
                $query = new WP_Query($args);
                ?>
                <h4 class="statistic-counter" style="color:<?php
                echo esc_attr($count_color); ?>"><?php
                    echo $query->found_posts; ?></h4>
                <p style="color:<?php
                echo esc_attr($title_color); ?>"><?php
                    echo esc_attr($edd_counter_title); ?></p>

                <?php
            }
            elseif ($type_of_counter == "3")
            { ?>
                <h4 class="statistic-counter" style="color:<?php
                echo esc_attr($count_color); ?>"><?php
                    echo edd_count_total_file_downloads(); ?></h4>
                <p style="color:<?php
                echo esc_attr($title_color); ?>"><?php
                    echo esc_attr($edd_counter_title); ?></p>
                <?php
            }
            else
            { ?>
            <h4 class="statistic-counter" style="color:<?php
                echo esc_attr($count_color); ?>">
                    <?php
                    $result = count_users();
                    echo  $result['total_users'];

                    ?>
                </h4>
                <p style="color:<?php
                echo esc_attr($title_color); ?>"><?php
                    echo esc_attr($edd_counter_title); ?></p>
               
                <?php
            } ?>

        </div>
        <?php
        echo $this->endBlockComment('digital_theme_counter'); ?>
        <div class="clearfix"></div>
        <!-- Element Code / END -->

        <?php
        $output = ob_get_clean();
        /* ================  Render Shortcodes ================ */
        return $output;
    }
}

vc_map(array(
    "base" => "digital_theme_counter",
    "name" => __('Mayosis Stats Counter', 'mayosis') ,
    "description" => __('Mayosis Jquery Counter', 'mayosis') ,
    "class" => "",
    "icon" => get_template_directory_uri() . '/images/DM-Symbol-64px.png',
    "category" => __('Mayosis Elements', 'mayosis') ,
    "params" => array(
        array(
            'type' => 'textfield',
            'heading' => __('Counter Title', 'mayosis') ,
            'param_name' => 'edd_counter_title',
            'value' => __('Products', 'mayosis') ,
            'description' => __('Title of Counter', 'mayosis') ,
        ) ,
        array(
            "type" => "dropdown",
            "heading" => __('Counter Type:', 'mayosis') ,
            "param_name" => "type_of_counter",
            "description" => __('Type of Counter', 'mayosis') ,
            "value" => array(
                'Total User' => '1',
                'Total Products' => '2',
                'Total Download' => '3',
                'Custom Download' => '4'
            ) , //Add default value in $atts
        ) ,
        array(
            'type' => 'textfield',
            'heading' => __('Custom Count', 'mayosis') ,
            'param_name' => 'edd_custom_count',
            'value' => __('2532', 'mayosis') ,
            'description' => __('Input Integear Value', 'mayosis') ,
        ) ,
        array(
            "type" => "dropdown",
            "heading" => __('Alignment of Text', 'mayosis') ,
            "param_name" => "title_align",
            "description" => __('Choose Alignement Of Text', 'mayosis') ,
            "value" => array(
                'Left' => 'left',
                'Center' => 'center',
                'Right' => 'right'
            ) , //Add default value in $atts
            "group" => 'Style',
        ) ,
        array(
            "type" => "colorpicker",
            "heading" => __('Color Of title', 'mayosis') ,
            "param_name" => "title_color",

            // "description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),

            "value" => '#ffffff',
            "group" => 'Style',
        ) ,
        array(
            "type" => "colorpicker",
            "heading" => __('Color Of Count', 'mayosis') ,
            "param_name" => "count_color",

            // "description" => __("Accepts a FontAwesome value. (Ex. fa fa-thumbs-o-up)", 'mayosis'),

            "value" => '#ffffff',
            "group" => 'Style',
        ) ,
        array(
            "type" => "textfield",
            "heading" => __("Custom Class", 'mayosis'),
            "param_name" => "custom_class",
            "description" => __("Add a custom Class.", 'mayosis'),
            "value" => '',
            "group" => 'Style'
        ),

        array(
            'type' => 'css_editor',
            'heading' => __('Css', 'mayosis') ,
            'param_name' => 'css',
            'group' => __('Design options', 'mayosis') ,
        ) ,
    )
));