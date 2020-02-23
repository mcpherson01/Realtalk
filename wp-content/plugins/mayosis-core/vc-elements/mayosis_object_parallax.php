<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_mayosis_shape extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
        $css = '';
        extract(shortcode_atts(array(
            'shape_element' => '',
            'shape_color' => '#5a00f0',
            'shape_width' => '300',
            'stroked_thikness' =>'80',
            'element_type' => 'parallax',
            'element_align' => 'left',
            'top_position' => '-80',
            'right_position' => '-80',
            'bottom_position' => '-80',
            'left_position' => '-80',
            'x_trans' => '100',
            'y_trans' => '-50',
            'int_parallax' => 'rotateX',
            'int_value' => '300',
            'fill' => 'none',
            'shape_color' =>'#460082',
            'gradient_color_a' =>'#460082',
            'gradient_color_b' =>'#0e002c',
            'stroke' => 'none',
            'stroke_color' => '#0e002c',
            'stroke_gradient_a' => '#460082',
            'stroke_gradient_b' => '#460082',
            'gradient_angle' =>'30',
            'rotate_shape'=>'0',
            'cicrle_scaling' => '20',
            'z_index' => '1',
            'unique_ud'=>'',
            'custom_image' => '',
            'css' => ''
        ), $atts));
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );


        /* ================  Render Shortcodes ================ */

        ob_start();

        ?>

        <div class="mayosis-shape <?php echo esc_attr( $css_class ); ?>" style="top:<?php echo esc_attr($top_position); ?>px; right:<?php echo esc_attr($right_position); ?>px; bottom:<?php echo esc_attr($bottom_position); ?>px;left:<?php echo esc_attr($left_position); ?>px;text-align:<?php echo esc_attr($element_align); ?>;z-index:<?php echo esc_attr($z_index); ?>;" >


            <ul class="hidden-sm hidden-xs">
                <?php if($element_type== "parallax"){ ?>
                <li data-parallax='{"x": <?php echo esc_attr($x_trans); ?>, "y": <?php echo esc_attr($y_trans); ?>, "<?php echo esc_attr($int_parallax); ?>": <?php echo esc_attr($int_value); ?>}'>
                    <?php } else { ?>
                <li>
                    <?php } ?>

                    <?php if($shape_element == "triangle"){ ?>
                        <div style="transform: rotate(<?php echo esc_attr($rotate_shape); ?>deg)">
                            <svg  x="0px" y="0px"
                                  viewBox="0 0 143 130.2" width="<?php echo esc_attr($shape_width); ?>" xml:space="preserve"  preserveAspectRatio="xMidYMid slice">

     						<!-- Fill Gradient --><defs>
                                    <linearGradient id="gradient<?php echo esc_attr($unique_ud);?>" x1="0%" y1="<?php echo esc_attr($gradient_angle); ?>%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:<?php echo esc_attr($gradient_color_a); ?>;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:<?php echo esc_attr($gradient_color_b); ?>;stop-opacity:1" />
                                    </linearGradient>
                                </defs><!-- /Fill Gradient -->


                                <!-- Stroke Gradient --><defs>
                                    <linearGradient id="gradient2<?php echo esc_attr($unique_ud);?>" x1="0%" y1="<?php echo esc_attr($gradient_angle); ?>" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:<?php echo esc_attr($stroke_gradient_a); ?>;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:<?php echo esc_attr($stroke_gradient_b); ?>;stop-opacity:1" />
                                    </linearGradient>
                                </defs><!-- /Stroke Gradient -->


                                <path
                                    <?php if($fill == "none"){ ?>
                                        fill="none"
                                    <?php } elseif($fill == "gradient"){ ?>
                                        fill="url(#gradient<?php echo esc_attr($unique_ud);?>)"
                                    <?php } else { ?>
                                        fill="<?php echo esc_attr($shape_color);?>"
                                    <?php } ?>

                                    <?php if($stroke == "single"){ ?>
                                        stroke="<?php echo esc_attr($stroke_color);?>"
                                    <?php } elseif($stroke == "gradient"){ ?>
                                        stroke="url(#gradient2<?php echo esc_attr($unique_ud);?>)"
                                    <?php } else {?>
                                        stroke="none"
                                    <?php } ?>

                                    id="XMLID_1_" class="st0" d="M8.9,97.6l47.6-82.4c6.7-11.6,23.4-11.6,30.1,0l47.6,82.4c6.7,11.6-1.7,26.1-15.1,26.1H23.9
						    C10.5,123.7,2.2,109.2,8.9,97.6z" style="stroke-width:<?php echo esc_attr($stroked_thikness); ?>px;stroke-miterlimit:10;"/>


						</svg>
                        </div>
                    <?php } elseif($shape_element =="circlex"){ ?>
                        <svg viewBox="0 0 100 100"  width="<?php echo esc_attr($shape_width); ?>"  height="<?php echo esc_attr($shape_width); ?>" xml:space="preserve"  preserveAspectRatio="xMidYMid slice">

                 	<!-- Fill Gradient --><defs>
                                <linearGradient id="gradientcx<?php echo esc_attr($unique_ud);?>" x1="0%" y1="<?php echo esc_attr($gradient_angle); ?>%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:<?php echo esc_attr($gradient_color_a); ?>;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:<?php echo esc_attr($gradient_color_b); ?>;stop-opacity:1" />
                                </linearGradient>
                            </defs><!-- /Fill Gradient -->


                            <!-- Stroke Gradient --><defs>
                                <linearGradient id="gradientcx2<?php echo esc_attr($unique_ud);?>" x1="0%" y1="<?php echo esc_attr($gradient_angle); ?>%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:<?php echo esc_attr($stroke_gradient_a); ?>;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:<?php echo esc_attr($stroke_gradient_b); ?>;stop-opacity:1" />
                                </linearGradient>
                            </defs><!-- /Stroke Gradient -->
                            <circle

                                <?php if($fill == "none"){ ?>
                                    fill="none"
                                <?php } elseif($fill == "gradient"){ ?>
                                    fill="url(#gradientcx<?php echo esc_attr($unique_ud);?>)"
                                <?php } else { ?>
                                    fill="<?php echo esc_attr($shape_color);?>"
                                <?php } ?>

                                <?php if($stroke == "single"){ ?>
                                    stroke="<?php echo esc_attr($stroke_color);?>"
                                <?php } elseif($stroke == "gradient"){ ?>
                                    stroke="url(#gradientcx2<?php echo esc_attr($unique_ud);?>)"
                                <?php } else {?>
                                    stroke="none"
                                <?php } ?>
                                stroke-width="<?php echo esc_attr($stroked_thikness); ?>" cx="50" cy="50" r="<?php echo esc_attr($cicrle_scaling); ?>"/>
            </svg>
                    <?php } elseif($shape_element =="square"){ ?>
                        <div style="transform: rotate(<?php echo esc_attr($rotate_shape); ?>deg)">
                            <svg  width="<?php echo esc_attr($shape_width); ?>" height="<?php echo esc_attr($shape_width); ?>" viewBox="0 0 315 315" xml:space="preserve"  preserveAspectRatio="xMidYMid slice">
                	<!-- Fill Gradient --><defs>
                                    <linearGradient id="gradientsquare<?php echo esc_attr($unique_ud);?>" x1="0%" y1="<?php echo esc_attr($gradient_angle); ?>%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:<?php echo esc_attr($gradient_color_a); ?>;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:<?php echo esc_attr($gradient_color_b); ?>;stop-opacity:1" />
                                    </linearGradient>
                                </defs><!-- /Fill Gradient -->


                                <path

                                    <?php if($fill == "none"){ ?>
                                        fill="none"
                                    <?php } elseif($fill == "gradient"){ ?>
                                        fill="url(#gradientsquare<?php echo esc_attr($unique_ud);?>)"
                                    <?php } else { ?>
                                        fill="<?php echo esc_attr($shape_color);?>"
                                    <?php } ?>


                                    d="M269.7,0H45.3C20.3,0,0,20.3,0,45.3v224.4c0,25,20.3,45.3,45.3,45.3h224.4c25,0,45.3-20.3,45.3-45.3V45.3
                	C315,20.3,294.7,0,269.7,0z"/>
                </svg>
                        </div>
                    <?php } elseif($shape_element =="squarestroke"){ ?>

                        <div style="transform: rotate(<?php echo esc_attr($rotate_shape); ?>deg)">
                            <svg  width="<?php echo esc_attr($shape_width); ?>" height="<?php echo esc_attr($shape_width); ?>"
                                  viewBox="0 0 287 287"  xml:space="preserve"  preserveAspectRatio="xMidYMid slice">


                          <!-- Stroke Gradient --><defs>
                                    <linearGradient id="gradientstrokesquare<?php echo esc_attr($unique_ud);?>" x1="0%" y1="<?php echo esc_attr($gradient_angle); ?>" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:<?php echo esc_attr($stroke_gradient_a); ?>;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:<?php echo esc_attr($stroke_gradient_b); ?>;stop-opacity:1" />
                                    </linearGradient>
                                </defs><!-- /Stroke Gradient -->


                                <path

                                    <?php if($stroke == "single"){ ?>
                                        fill="<?php echo esc_attr($stroke_color);?>"
                                    <?php } elseif($stroke == "gradient"){ ?>
                                        fill="url(#gradientstrokesquare<?php echo esc_attr($unique_ud);?>)"
                                    <?php } else {?>
                                        fill="none"
                                    <?php } ?>

                                    d="M287,41.3C287,18.5,268.5,0,245.7,0H41.3C18.5,0,0,18.5,0,41.3v204.4C0,268.5,18.5,287,41.3,287h204.4
            	c22.8,0,41.3-18.5,41.3-41.3V41.3z M214,193.7c0,11.2-9.1,20.3-20.3,20.3H93.3c-11.2,0-20.3-9.1-20.3-20.3V93.3
            	C73,82.1,82.1,73,93.3,73h100.4c11.2,0,20.3,9.1,20.3,20.3V193.7z"/>
            </svg>
                        </div>
                    <?php } elseif($shape_element =="hexagon"){ ?>
                        <div style="transform: rotate(<?php echo esc_attr($rotate_shape); ?>deg)">
                            <svg  width="<?php echo esc_attr($shape_width); ?>" height="<?php echo esc_attr($shape_width); ?>"
                                  viewBox="0 0 350 350" xml:space="preserve"  preserveAspectRatio="xMidYMid slice">

        	 	<!-- Fill Gradient --><defs>
                                    <linearGradient id="gradientheaxa<?php echo esc_attr($unique_ud);?>" x1="0%" y1="<?php echo esc_attr($gradient_angle); ?>%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:<?php echo esc_attr($gradient_color_a); ?>;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:<?php echo esc_attr($gradient_color_b); ?>;stop-opacity:1" />
                                    </linearGradient>
                                </defs><!-- /Fill Gradient -->
                                <path
                                    <?php if($fill == "none"){ ?>
                                        fill="none"
                                    <?php } elseif($fill == "gradient"){ ?>
                                        fill="url(#gradientheaxa<?php echo esc_attr($unique_ud);?>)"
                                    <?php } else { ?>
                                        fill="<?php echo esc_attr($shape_color);?>"
                                    <?php } ?>
                                    d="M291.7,70.8L179.1,5.9C165.5-2,148.7-2,135,5.9L22.3,70.8C8.7,78.7,0,93.2,0,109v129.9
        	c0,15.7,8.6,30.3,22.3,38.1l112.6,64.9c13.6,7.9,30.5,7.9,44.1,0L291.7,277c13.6-7.9,22.3-22.4,22.3-38.1V109
        	C314,93.2,305.4,78.7,291.7,70.8z"/>
        </svg>
                        </div>
                    <?php } elseif($shape_element =="strokehexagon"){ ?>
                        <div style="transform: rotate(<?php echo esc_attr($rotate_shape); ?>deg)">
                            <svg  x="0px" y="0px"
                                  width="<?php echo esc_attr($shape_width); ?>" height="<?php echo esc_attr($shape_width); ?>"
                                  viewBox="0 0 300 300" xml:space="preserve"  preserveAspectRatio="xMidYMid slice">
	 <!-- Stroke Gradient --><defs>
                                    <linearGradient id="gradientstrokehexa<?php echo esc_attr($unique_ud);?>" x1="0%" y1="<?php echo esc_attr($gradient_angle); ?>%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:<?php echo esc_attr($stroke_gradient_a); ?>;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:<?php echo esc_attr($stroke_gradient_b); ?>;stop-opacity:1" />
                                    </linearGradient>
                                </defs><!-- /Stroke Gradient -->
                                <path fill-rule="evenodd" clip-rule="evenodd"

                                    <?php if($stroke == "single"){ ?>
                                        fill="<?php echo esc_attr($stroke_color);?>"
                                    <?php } elseif($stroke == "gradient"){ ?>
                                        fill="url(#gradientstrokehexa<?php echo esc_attr($unique_ud);?>)"
                                    <?php } else {?>
                                        fill="none"
                                    <?php } ?>


                                      d="M255.2,228.8l-93.4,53.8c-11.3,6.5-25.3,6.5-36.6,0l-93.4-53.8
	c-11.3-6.5-18.3-18.6-18.3-31.6V89.7c0-13,7-25.1,18.3-31.6l93.4-53.8c11.3-6.5,25.3-6.5,36.6,0l93.4,53.8
	c11.3,6.5,18.3,18.6,18.3,31.6v107.5C273.5,210.3,266.5,222.3,255.2,228.8z M204.7,117.3c0-6.2-3.3-11.9-8.6-15l-44-25.5
	c-5.3-3.1-11.9-3.1-17.2,0l-44,25.5c-5.3,3.1-8.6,8.8-8.6,15v50.9c0,6.2,3.3,11.9,8.6,15l44,25.5c5.3,3.1,11.9,3.1,17.2,0l44-25.5
	c5.3-3.1,8.6-8.8,8.6-15V117.3z"/>
</svg>
                        </div>
                    <?php } elseif($shape_element =="pentagon"){ ?>
                        <div style="transform: rotate(<?php echo esc_attr($rotate_shape); ?>deg)">
                            <svg  width="<?php echo esc_attr($shape_width); ?>" height="<?php echo esc_attr($shape_width); ?>"
                                  viewBox="0 0 313.7 302.8"  xml:space="preserve">

        	 	<!-- Fill Gradient --><defs>
                                    <linearGradient id="gradientpenta<?php echo esc_attr($unique_ud);?>" x1="0%" y1="<?php echo esc_attr($gradient_angle); ?>%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:<?php echo esc_attr($gradient_color_a); ?>;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:<?php echo esc_attr($gradient_color_b); ?>;stop-opacity:1" />
                                    </linearGradient>
                                </defs><!-- /Fill Gradient -->
                                <path
                                    <?php if($fill == "none"){ ?>
                                        fill="none"
                                    <?php } elseif($fill == "gradient"){ ?>
                                        fill="url(#gradientpenta<?php echo esc_attr($unique_ud);?>)"
                                    <?php } else { ?>
                                        fill="<?php echo esc_attr($shape_color);?>"
                                    <?php } ?>

                                    d="M296.3,91.4L181.6,8c-14.8-10.7-34.7-10.7-49.5,0L17.4,91.4C2.6,102.1-3.6,121.1,2.1,138.5l43.8,135.1
        	c5.6,17.3,21.8,29.2,40,29.2h141.8c18.2,0,34.4-11.9,40-29.2l43.8-135C317.2,121.2,311.1,102.1,296.3,91.4z"/>
        </svg>
                        </div>

                    <?php } elseif($shape_element =="custom"){ ?>

                        <div style="transform: rotate(<?php echo esc_attr($rotate_shape); ?>deg)">
                            <?php $customicon = wp_get_attachment_image_src($custom_image, 'full'); ?>
                            <img src="<?php echo $customicon[0]; ?>">
                        </div>
                    <?php } else { ?>

                        <div style="transform: rotate(<?php echo esc_attr($rotate_shape); ?>deg)">
                            <svg  width="<?php echo esc_attr($shape_width); ?>" height="<?php echo esc_attr($shape_width); ?>"
                                  viewBox="0 0 400 400"  xml:space="preserve"  preserveAspectRatio="xMidYMid slice">

        	 	<!-- Fill Gradient --><defs>
                                    <linearGradient id="gradientplus<?php echo esc_attr($unique_ud);?>" x1="0%" y1="<?php echo esc_attr($gradient_angle); ?>%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:<?php echo esc_attr($gradient_color_a); ?>;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:<?php echo esc_attr($gradient_color_b); ?>;stop-opacity:1" />
                                    </linearGradient>
                                </defs><!-- /Fill Gradient -->

                                <path
                                    <?php if($fill == "none"){ ?>
                                        fill="none"
                                    <?php } elseif($fill == "gradient"){ ?>
                                        fill="url(#gradientplus<?php echo esc_attr($unique_ud);?>)"
                                    <?php } else { ?>
                                        fill="<?php echo esc_attr($shape_color);?>"
                                    <?php } ?>

                                    d="M389,134.3H276.7c-6.2,0-11.1-5-11.1-11.1V11c0-6.2-5-11.1-11.1-11.1h-109c-6.2,0-11.1,5-11.1,11.1v112.3
        	c0,6.2-5,11.1-11.1,11.1H11c-6.1,0-11.1,5-11.1,11.2v108.9c0,6.2,5,11.1,11.1,11.1h112.3c6.2,0,11.1,5,11.1,11.1V389
        	c0,6.2,5,11.1,11.1,11.1h109c6.2,0,11.1-5,11.1-11.1V276.6c0-6.2,5-11.1,11.1-11.1H389c6.2,0,11.1-5,11.1-11.1V145.5
        	C400,139.3,395,134.3,389,134.3z"/>
        </svg>

                        </div>
                    <?php } ?>

                </li>
            </ul>






        </div>

        <?php echo $this->endBlockComment('mayosis_shape'); ?>


        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "mayosis_shape",
    "name"      => __('Mayosis Graphic Shape', 'mayosis'),
    "description"      => __('Mayosis Shape!', 'mayosis'),
    "class"     => "",
    "icon"      => get_template_directory_uri().'/images/DM-Symbol-64px.png',
    "category"  => __('Mayosis Elements', 'mayosis'),
    "params"    => array(
        array(
            "type" => "textfield",
            "heading" => __('Unique Id', 'mayosis'),
            "param_name" => "unique_ud",
            'description' => __( 'Input Unique Id(ex: circlex)', 'mayosis' ),
            "group" => 'Style',
            "value" => 'circlex',

        ),

        array(
            "type" => "dropdown",
            "heading" => __('Type of Shape', 'mayosis'),
            "param_name" => "shape_element",
            "description" => __('Choose Shape Type', 'mayosis'),
            "value"      => array(
                'None' => 'none',
                'Circle' => 'circlex',
                'Square' => 'square',
                'Stroke Square' => 'squarestroke',
                'Triangle' => 'triangle',
                'Hexagon' => 'hexagon' ,
                'Stroked Hexagon' => 'strokehexagon' ,
                'Pentagon' => 'pentagon',
                'Rounded Plus' => 'roundplus',
                'Custom Image' => 'custom',
            ), //Add default value in $atts
            "group" => 'Style',
        ),

        array(
            'type' => 'attach_image',
            'heading' => __( 'Custom Image', 'mayosis' ),
            'param_name' => 'custom_image',
            "group" => 'Style',
            'description' => __( 'Upload Custom Shape', 'mayosis' ),
            "dependency" => Array('element' => "custom" )
        ),

        array(
            "type" => "dropdown",
            "heading" => __('Fill', 'mayosis'),
            "param_name" => "fill",
            "description" => __('Choose Fill Color Type', 'mayosis'),
            "value"      => array(
                'None' => 'none',
                'Single' => 'single',
                'Gradient' => 'gradient',
            ), //Add default value in $atts
            "group" => 'Style',
            "dependency" => Array('element' => "shape_element", 'value' => array('single','circlex','square','hexagon','pentagon','roundplus','triangle'))
        ),
        array(
            "type" => "colorpicker",
            "heading" => __('Shape Color', 'mayosis'),
            "param_name" => "shape_color",
            "value" => '#2C5C82',
            "group" => 'Style',
            "dependency" => Array('element' => "fill", 'value' => array('single'))
        ),

        array(
            "type" => "colorpicker",
            "heading" => __('Shape Gradient Color A', 'mayosis'),
            "param_name" => "gradient_color_a",
            "value" => '#460082',
            "group" => 'Style',

            "dependency" => Array('element' => "fill", 'value' => array('gradient'))
        ),

        array(
            "type" => "colorpicker",
            "heading" => __('Shape Gradient Color B', 'mayosis'),
            "param_name" => "gradient_color_b",
            "value" => '#0e002c',
            "group" => 'Style',
            "dependency" => Array('element' => "fill", 'value' => array('gradient'))
        ),


        array(
            "type" => "dropdown",
            "heading" => __('Stroke', 'mayosis'),
            "param_name" => "stroke",
            "description" => __('Choose Stroke Color Type', 'mayosis'),
            "value"      => array(
                'None' => 'none',
                'Single' => 'single',
                'Gradient' => 'gradient',
            ), //Add default value in $atts
            "group" => 'Style',
            "dependency" => Array('element' => "shape_element", 'value' => array('single','circlex','squarestroke','triangle','strokehexagon'))
        ),
        array(
            "type" => "colorpicker",
            "heading" => __('Stroke Color', 'mayosis'),
            "param_name" => "stroke_color",
            "value" => '#2C5C82',
            "group" => 'Style',
            "dependency" => Array('element' => "stroke", 'value' => array('single'))
        ),

        array(
            "type" => "colorpicker",
            "heading" => __('Shape Gradient Color A', 'mayosis'),
            "param_name" => "stroke_gradient_a",
            "value" => '#460082',
            "group" => 'Style',

            "dependency" => Array('element' => "stroke", 'value' => array('gradient'))
        ),

        array(
            "type" => "colorpicker",
            "heading" => __('Shape Gradient Color B', 'mayosis'),
            "param_name" => "stroke_gradient_b",
            "value" => '#0e002c',
            "group" => 'Style',
            "dependency" => Array('element' => "stroke", 'value' => array('gradient'))
        ),

        array(
            "type" => "textfield",
            "heading" => __('Gradient Angle', 'mayosis'),
            "param_name" => "gradient_angle",
            'description' => __( 'Gradient Angle', 'mayosis' ),
            "value" => '30',
            "group" => 'Style',

        ),

        array(
            "type" => "textfield",
            "heading" => __('Shape Width', 'mayosis'),
            "param_name" => "shape_width",
            'description' => __( 'Input without px', 'mayosis' ),
            "group" => 'Style',
            "value" => '300',

        ),




        array(
            "type" => "textfield",
            "heading" => __('Shape Stroke Thikness', 'mayosis'),
            "param_name" => "stroked_thikness",
            'description' => __( 'Input without px', 'mayosis' ),
            "group" => 'Style',
            "value" => '80',
        ),
        array(
            "type" => "textfield",
            "heading" => __('Circle Scaling', 'mayosis'),
            "param_name" => "cicrle_scaling",
            'description' => __( 'Input without Unit', 'mayosis' ),
            "group" => 'Style',
            "dependency" => Array('element' => "shape_element", 'value' => array('circlex')),
            "value" => '20',
        ),

        array(
            "type" => "dropdown",
            "heading" => __('Element Type', 'mayosis'),
            "param_name" => "element_type",
            "description" => __('Choose Element Type', 'mayosis'),
            "value"      => array(
                ' Parallax' => 'parallax',
                'Normal' => 'normal',
            ), //Add default value in $atts
            "group" => 'Parallax',
        ),

        array(
            "type" => "textfield",
            "heading" => __('X Axis Translation ', 'mayosis'),
            "param_name" => "x_trans",
            'description' => __( 'Input without px', 'mayosis' ),
            "group" => 'Parallax',
            "value" => '100',
        ),

        array(
            "type" => "textfield",
            "heading" => __('Y Axis Translation ', 'mayosis'),
            "param_name" => "y_trans",
            'description' => __( 'Input without px', 'mayosis' ),
            "group" => 'Parallax',
            "value" => '-50',
        ),
        array(
            "type" => "dropdown",
            "heading" => __('Parallax Interaction', 'mayosis'),
            "param_name" => "int_parallax",
            "description" => __('Choose Interaction', 'mayosis'),
            "value"      => array(
                'Rotate X' => 'rotateX',
                'Rotate Y' => 'rotateY',
                'Scale' => 'scale',
                'Scale X' => 'scaleX',
                'Scale Y' => 'scaleY',
                'Smoothness' => 'smoothness' ,
                'Perspective' => 'perspective',
            ), //Add default value in $atts
            "group" => 'Parallax',
        ),

        array(
            "type" => "textfield",
            "heading" => __('Value of Interaction ', 'mayosis'),
            "param_name" => "int_value",
            'description' => __( 'Input without Unit', 'mayosis' ),
            "value" => '300',
            "group" => 'Parallax',
        ),
        array(
            "type" => "dropdown",
            "heading" => __('Element Align', 'mayosis'),
            "param_name" => "element_align",
            "description" => __('Choose Align', 'mayosis'),
            "value"      => array(
                ' Left' => 'left',
                'Center' => 'center',
                'Right' => 'right'
            ), //Add default value in $atts
            "group" => 'Position',
        ),

        array(
            "type" => "textfield",
            "heading" => __('Shape Top Position', 'mayosis'),
            "param_name" => "top_position",
            'description' => __( 'Input with px', 'mayosis' ),
            "group" => 'Position',
            "value" => '-80',
        ),
        array(
            "type" => "textfield",
            "heading" => __('Shape Right Position', 'mayosis'),
            "param_name" => "right_position",
            'description' => __( 'Input with px', 'mayosis' ),
            "group" => 'Position',
            "value" => '-80',
        ),

        array(
            "type" => "textfield",
            "heading" => __('Shape Bottom Position', 'mayosis'),
            "param_name" => "bottom_position",
            'description' => __( 'Input with px', 'mayosis' ),
            "group" => 'Position',
            "value" => '-80',
        ),
        array(
            "type" => "textfield",
            "heading" => __('Shape Left Position', 'mayosis'),
            "param_name" => "left_position",
            'description' => __( 'Input without px', 'mayosis' ),
            "group" => 'Position',
            "value" => '-80',
        ),

        array(
            "type" => "textfield",
            "heading" => __('Shape Rotate', 'mayosis'),
            "param_name" => "rotate_shape",
            'description' => __( 'Input without deg', 'mayosis' ),
            "group" => 'Position',
            "value" => '0',
        ),

        array(
            "type" => "textfield",
            "heading" => __('Z Index', 'mayosis'),
            "param_name" => "z_index",
            'description' => __( 'Input inteager', 'mayosis' ),
            "group" => 'Position',
            "value" => '1',
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'mayosis' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'mayosis' ),
        ),


    )

));
