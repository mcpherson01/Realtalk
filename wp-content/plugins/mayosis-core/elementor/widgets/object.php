<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class object_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-shaoe';
   }

   public function get_title() {
      return __( 'Mayosis Graphic Shape', 'mayosis' );
   }
public function get_categories() {
        return [ 'mayosis-ele-cat' ];
    }
   public function get_icon() { 
        return 'eicon-nerd-wink';
   }

   protected function _register_controls() {

      $this->add_control(
         'section_shape',
         [
            'label' => __( 'General', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
      
      $this->add_control(
          'unique_id',
          [
             'label'       => __( 'Unique ID', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( 'circlecx', 'mayosis' ),
             'section' => 'section_shape',
          ]
        );
        
        
    $this->add_control(
         'shape_element',
         [
            'label' => __( 'Type of Shape', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'circlex',
            'title' => __( 'Select Shape Type', 'mayosis' ),
            'section' => 'section_shape',
             'options' => [
                    'none'  => __( 'None', 'mayosis' ),
                    'circlex' => __( 'Circle', 'mayosis' ),
                    'square' => __( 'Square', 'mayosis' ),
                    'squarestroke' => __( 'Square Stroke', 'mayosis' ),
                    'triangle' => __( 'Triangle', 'mayosis' ),
                    'hexagon' => __( 'Hexagon', 'mayosis' ),
                    'strokehexagon' => __( 'Stroke Hexagon', 'mayosis' ),
                    'pentagon' => __( 'Pentagon', 'mayosis' ),
                    'roundplus' => __( 'Round Plus', 'mayosis' ),
                    'custom' => __( 'Custom Image', 'mayosis' ),
                 
                 ],
         ]
      );
      
      
       $this->add_control(
         'custom_image',
         [
            'label' => __( 'Custom Image', 'mayosis' ),
            'type' => Controls_Manager::MEDIA,
            'title' => __( 'Upload Custom Shape or anything', 'mayosis' ),
            'section' => 'section_shape',
             'condition' => [
                    'shape_element' => array('custom'),
                ],
         ]
      );
        $this->add_control(
         'fill',
         [
            'label' => __( 'Fill Type', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'single',
            'title' => __( 'Select Shape Type', 'mayosis' ),
            'section' => 'section_shape',
             'options' => [
                    'none'  => __( 'None', 'mayosis' ),
                    'single' => __( 'Single', 'mayosis' ),
                    'gradient' => __( 'Gradient', 'mayosis' ),
                 
                 ],
             
             'condition' => [
                    'shape_element' => array('circlex','square','hexagon','pentagon','roundplus','triangle'),
                ],
         ]
      );
       
       $this->add_control(
         'shape_color',
         [
            'label' => __( 'Shape Fill color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#2C5C82',
            'title' => __( 'Select Fill Color', 'mayosis' ),
            'section' => 'section_shape',
             
             'condition' => [
                    'fill' => array('single'),
                ],
         ]
      );
       
       $this->add_control(
         'gradient_color_a',
         [
            'label' => __( 'Shape Gradient color A', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#460082',
            'title' => __( 'Select gradient Color A', 'mayosis' ),
            'section' => 'section_shape',
             
             'condition' => [
                    'fill' => array('gradient'),
                ],
         ]
      );
       
       $this->add_control(
         'gradient_color_b',
         [
            'label' => __( 'Shape Gradient color B', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#0e002c',
            'title' => __( 'Select gradient Color B', 'mayosis' ),
            'section' => 'section_shape',
             
             'condition' => [
                    'fill' => array('gradient'),
                ],
         ]
      );
       
       $this->add_control(
         'stroke',
         [
            'label' => __( 'Stroke Type', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'single',
            'title' => __( 'Select Stroke Type', 'mayosis' ),
            'section' => 'section_shape',
             'options' => [
                    'none'  => __( 'None', 'mayosis' ),
                    'single' => __( 'Single', 'mayosis' ),
                    'gradient' => __( 'Gradient', 'mayosis' ),
                 
                 ],
             
             'condition' => [
                    'shape_element' => array('circlex','squarestroke','triangle','strokehexagon'),
                ],
         ]
      );
       
       $this->add_control(
         'stroke_color',
         [
            'label' => __( 'Stroke color', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#2C5C82',
            'title' => __( 'Select Stroke Color', 'mayosis' ),
            'section' => 'section_shape',
             
             'condition' => [
                    'stroke' => array('single'),
                ],
         ]
      );
       
       $this->add_control(
         'stroke_gradient_a',
         [
            'label' => __( 'Stroke Gradient color A', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#460082',
            'title' => __( 'Select gradient Color A', 'mayosis' ),
            'section' => 'section_shape',
             
             'condition' => [
                    'stroke' => array('gradient'),
                ],
         ]
      );
       
       $this->add_control(
         'stroke_gradient_b',
         [
            'label' => __( 'Stroke Gradient color B', 'mayosis' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#0e002c',
            'title' => __( 'Select gradient Color B', 'mayosis' ),
            'section' => 'section_shape',
             
             'condition' => [
                    'stroke' => array('gradient'),
                ],
         ]
      );
      
     
       

       $this->add_control(
          'shape_width',
          [
             'label'       => __( 'Shape width', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '300', 'mayosis' ),
             'section' => 'section_shape',
          ]
        );
       

        $this->add_control(
          'stroked_thikness',
          [
             'label'       => __( 'Shape Stroke Thikness', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '30', 'mayosis' ),
             'section' => 'section_shape',
          ]
        );

        $this->add_control(
          'cicrle_scaling',
          [
             'label'       => __( 'Circle Scaling', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '20', 'mayosis' ),
             'section' => 'section_shape',
             'condition' => [
                    'shape_element' => array('circlex'),
                ],
          ]
        );
       
        $this->add_control(
          'gradient_angle',
          [
             'label'       => __( 'Gradient Angle', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '135', 'mayosis' ),
             'section' => 'section_shape',
          ]
        );
       $this->add_control(
         'section_parallax',
         [
            'label' => __( 'Parallax', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );

       $this->add_control(
         'element_type',
         [
            'label' => __( 'Element Type', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'parallax',
            'title' => __( 'Select Shape Type', 'mayosis' ),
            'section' => 'section_parallax',
             'options' => [
                    'parallax'  => __( 'Parallax', 'mayosis' ),
                    'normal' => __( 'Normal', 'mayosis' ),
                 
                 ],
             
         ]
      );

       $this->add_control(
          'x_trans',
          [
             'label'       => __( 'X Axis Translation', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '100', 'mayosis' ),
             'section' => 'section_parallax',
          ]
        );

       $this->add_control(
          'y_trans',
          [
             'label'       => __( 'Y Axis Translation', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '-50', 'mayosis' ),
             'section' => 'section_parallax',
          ]
        );

       $this->add_control(
         'int_parallax',
         [
            'label' => __( 'Parallax Interaction', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'perspective',
            'title' => __( 'Choose Interaction', 'mayosis' ),
            'section' => 'section_parallax',
             'options' => [
                    'rotateX'  => __( 'Rotate X', 'mayosis' ),
                    'rotateY' => __( 'Rotate Y', 'mayosis' ),
                    'smoothness' => __( 'Smoothness', 'mayosis' ),
                    'perspective' => __( 'Perspective', 'mayosis' ),
                 
                 ],
             
         ]
      );
       
       $this->add_control(
          'int_value',
          [
             'label'       => __( 'Value of Interaction', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '300', 'mayosis' ),
             'section' => 'section_parallax',
          ]
        );

       $this->add_control(
         'section_position',
         [
            'label' => __( 'Position', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );


       $this->add_control(
         'element_align',
         [
            'label' => __( 'Element Align', 'mayosis' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'title' => __( 'Choose Element Align', 'mayosis' ),
            'section' => 'section_position',
             'options' => [
                    'left'  => __( 'Left', 'mayosis' ),
                    'center' => __( 'Center', 'mayosis' ),
                    'right' => __( 'Right', 'mayosis' ),
                 
                 ],
             
         ]
      );


       $this->add_control(
          'top_position',
          [
             'label'       => __( 'Shape Top Position', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '-80', 'mayosis' ),
             'section' => 'section_position',
          ]
        );

       $this->add_control(
          'right_position',
          [
             'label'       => __( 'Shape Right Position', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '-80', 'mayosis' ),
             'section' => 'section_position',
          ]
        );

       $this->add_control(
          'bottom_position',
          [
             'label'       => __( 'Shape Bottom Position', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '-80', 'mayosis' ),
             'section' => 'section_position',
          ]
        );

        $this->add_control(
          'left_position',
          [
             'label'       => __( 'Shape Left Position', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '-80', 'mayosis' ),
             'section' => 'section_position',
          ]
        );

        $this->add_control(
          'rotate_shape',
          [
             'label'       => __( 'Shape Rotate', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '0', 'mayosis' ),
             'section' => 'section_position',
          ]
        );

        $this->add_control(
          'z_index',
          [
             'label'       => __( 'Z Index', 'mayosis' ),
             'type'        => Controls_Manager::TEXT,
             'default'     => __( '1', 'mayosis' ),
             'section' => 'section_position',
          ]
        );
   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
      ?>

 <!-- Element Code start -->
       
<div class="mayosis-shape" style="top:<?php echo $settings['top_position']; ?>px; right:<?php echo $settings['right_position']; ?>px; bottom:<?php echo $settings['bottom_position']; ?>px;left:<?php echo $settings['left_position']; ?>px;text-align:<?php echo $settings['element_align']; ?>;z-index:<?php echo $settings['z_index']; ?>;" >
            
       
              <ul class="hidden-sm hidden-xs">
                  <?php if($settings['element_type']== "parallax"){ ?>
                <li data-parallax='{"x": <?php echo $settings['x_trans']; ?>, "y": <?php echo $settings['y_trans']; ?>, "<?php echo $settings['int_parallax']; ?>": <?php echo $settings['int_value']; ?>}'>
                    <?php } else { ?>
                    <li>
                    <?php } ?>
                    
          <?php if($settings['shape_element'] == "triangle"){ ?>
          <div style="transform: rotate(<?php echo $settings['rotate_shape']; ?>deg)">
                  <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
     viewBox="0 0 143 130.2" width="<?php echo $settings['shape_width']; ?>" xml:space="preserve" patternContentUnits="objectBoundingBox" preserveAspectRatio="xMidYMid slice">

                            <!-- Fill Gradient --><defs>
                            <linearGradient id="gradient" x1="0%" y1="<?php echo $settings['gradient_angle']; ?>%" x2="100%" y2="0%">
                              <stop offset="0%" style="stop-color:<?php echo $settings['gradient_color_a']; ?>;stop-opacity:1" />
                              <stop offset="100%" style="stop-color:<?php echo $settings['gradient_color_b']; ?>;stop-opacity:1" />
                            </linearGradient>
                          </defs><!-- /Fill Gradient -->


                          <!-- Stroke Gradient --><defs>
                            <linearGradient id="gradient2<?php echo $settings['unique_id']; ?>" x1="0%" y1="<?php echo $settings['gradient_angle']; ?>" x2="100%" y2="0%">
                              <stop offset="0%" style="stop-color:<?php echo $settings['stroke_gradient_a']; ?>;stop-opacity:1" />
                              <stop offset="100%" style="stop-color:<?php echo $settings['stroke_gradient_b']; ?>;stop-opacity:1" />
                            </linearGradient>
                          </defs><!-- /Stroke Gradient -->


                        <path 
                        <?php if($settings['fill'] == "none"){ ?>
                            fill="none"
                        <?php } elseif($settings['fill'] == "gradient"){ ?>
                        fill="url(#gradient)" 
                        <?php } else { ?>
                          fill="<?php echo $settings['shape_color'];?>" 
                        <?php } ?>

                        <?php if($settings['stroke'] == "single"){ ?>
                        stroke="<?php echo $settings['stroke_color'];?>" 
                        <?php } elseif($settings['stroke'] == "gradient"){ ?>
                        stroke="url(#gradient2<?php echo $settings['unique_id']; ?>)" 
                        <?php } else {?>
                        stroke="none" 
                        <?php } ?>

                        id="XMLID_1_" class="st0" d="M8.9,97.6l47.6-82.4c6.7-11.6,23.4-11.6,30.1,0l47.6,82.4c6.7,11.6-1.7,26.1-15.1,26.1H23.9
                            C10.5,123.7,2.2,109.2,8.9,97.6z" style="stroke-width:<?php echo $settings['stroked_thikness']; ?>px;stroke-miterlimit:10;"/>


                        </svg>
                    </div>
         <?php } elseif($settings['shape_element'] =="circlex"){ ?>
            <svg "xmlns="http://www.w3.org/2000/svg" 
                 viewBox="0 0 100 100"  width="<?php echo $settings['shape_width']; ?>"  height="<?php echo $settings['shape_width']; ?>" xml:space="preserve" patternContentUnits="objectBoundingBox" preserveAspectRatio="xMidYMid slice">
                 
                    <!-- Fill Gradient --><defs>
                            <linearGradient id="gradientcx<?php echo $settings['unique_id']; ?>" x1="0%" y1="<?php echo $settings['gradient_angle']; ?>%" x2="100%" y2="0%">
                              <stop offset="0%" style="stop-color:<?php echo $settings['gradient_color_a']; ?>;stop-opacity:1" />
                              <stop offset="100%" style="stop-color:<?php echo $settings['gradient_color_b']; ?>;stop-opacity:1" />
                            </linearGradient>
                          </defs><!-- /Fill Gradient -->


                          <!-- Stroke Gradient --><defs>
                            <linearGradient id="gradientcx2<?php echo $settings['unique_id']; ?>" x1="0%" y1="<?php echo $settings['gradient_angle']; ?>%" x2="100%" y2="0%">
                              <stop offset="0%" style="stop-color:<?php echo $settings['stroke_gradient_a']; ?>;stop-opacity:1" />
                              <stop offset="100%" style="stop-color:<?php echo $settings['stroke_gradient_b']; ?>;stop-opacity:1" />
                            </linearGradient>
                          </defs><!-- /Stroke Gradient -->
            <circle
            
           <?php if($settings['fill'] == "none"){ ?>
                            fill="none"
                        <?php } elseif($settings['fill'] == "gradient"){ ?>
                        fill="url(#gradientcx<?php echo $settings['unique_id']; ?>)" 
                        <?php } else { ?>
                          fill="<?php echo $settings['shape_color'];?>" 
                        <?php } ?>

                        <?php if($settings['stroke'] == "single"){ ?>
                        stroke="<?php echo $settings['stroke_color'];?>" 
                        <?php } elseif ($settings['stroke'] == "gradient"){ ?>
                        stroke="url(#gradientcx2<?php echo $settings['unique_id']; ?>)" 
                        <?php } else {?>
                        stroke="none" 
                        <?php } ?> 
            stroke-width="<?php echo $settings['stroked_thikness']; ?>" cx="50" cy="50" r="<?php echo $settings['cicrle_scaling']; ?>"/>
            </svg>
          <?php } elseif($settings['shape_element'] =="square"){ ?>
          <div style="transform: rotate(<?php echo $settings['rotate_shape']; ?>deg)">
                <svg xmlns="http://www.w3.org/2000/svg" width="<?php echo $settings['shape_width']; ?>" height="<?php echo $settings['shape_width']; ?>" viewBox="0 0 315 315" xml:space="preserve" patternContentUnits="objectBoundingBox" preserveAspectRatio="xMidYMid slice">
                    <!-- Fill Gradient --><defs>
                            <linearGradient id="gradientsquare<?php echo $settings['unique_id']; ?>" x1="0%" y1="<?php echo $settings['gradient_angle']; ?>%" x2="100%" y2="0%">
                              <stop offset="0%" style="stop-color:<?php echo $settings['gradient_color_a']; ?>;stop-opacity:1" />
                              <stop offset="100%" style="stop-color:<?php echo $settings['gradient_color_b']; ?>;stop-opacity:1" />
                            </linearGradient>
                          </defs><!-- /Fill Gradient -->


                <path
                
               <?php if($settings['fill'] == "none"){ ?>
                            fill="none"
                        <?php } elseif($settings['fill'] == "gradient"){ ?>
                        fill="url(#gradientsquare<?php echo $settings['unique_id']; ?>)" 
                        <?php } else { ?>
                          fill="<?php echo $settings['shape_color'];?>" 
                        <?php } ?>

                
                d="M269.7,0H45.3C20.3,0,0,20.3,0,45.3v224.4c0,25,20.3,45.3,45.3,45.3h224.4c25,0,45.3-20.3,45.3-45.3V45.3
                    C315,20.3,294.7,0,269.7,0z"/>
                </svg>
            </div>
       <?php } elseif($settings['shape_element'] =="squarestroke"){ ?>
       
       <div style="transform: rotate(<?php echo $settings['rotate_shape']; ?>deg)">
       <svg xmlns="http://www.w3.org/2000/svg" width="<?php echo $settings['shape_width']; ?>" height="<?php echo $settings['shape_width']; ?>"
     viewBox="0 0 287 287"  xml:space="preserve" patternContentUnits="objectBoundingBox" preserveAspectRatio="xMidYMid slice">
     
     
                          <!-- Stroke Gradient --><defs>
                            <linearGradient id="gradientstrokesquare<?php echo $settings['unique_id']; ?>" x1="0%" y1="<?php echo $settings['gradient_angle']; ?>" x2="100%" y2="0%">
                              <stop offset="0%" style="stop-color:<?php echo $settings['stroke_gradient_a']; ?>;stop-opacity:1" />
                              <stop offset="100%" style="stop-color:<?php echo $settings['stroke_gradient_b']; ?>;stop-opacity:1" />
                            </linearGradient>
                          </defs><!-- /Stroke Gradient -->


            <path 
            
                <?php if($settings['stroke'] == "single"){ ?>
                                    fill="<?php echo $settings['stroke_color'];?>" 
                                    <?php } elseif($settings['stroke'] == "gradient"){ ?>
                                    fill="url(#gradientstrokesquare<?php echo $settings['unique_id']; ?>)" 
                                    <?php } else {?>
                                    fill="none" 
                                    <?php } ?>
            
            d="M287,41.3C287,18.5,268.5,0,245.7,0H41.3C18.5,0,0,18.5,0,41.3v204.4C0,268.5,18.5,287,41.3,287h204.4
                c22.8,0,41.3-18.5,41.3-41.3V41.3z M214,193.7c0,11.2-9.1,20.3-20.3,20.3H93.3c-11.2,0-20.3-9.1-20.3-20.3V93.3
                C73,82.1,82.1,73,93.3,73h100.4c11.2,0,20.3,9.1,20.3,20.3V193.7z"/>
            </svg>
            </div>
        <?php } elseif($settings['shape_element'] =="hexagon"){ ?>
        <div style="transform: rotate(<?php echo $settings['rotate_shape']; ?>deg)">
        <svg xmlns="http://www.w3.org/2000/svg" width="<?php echo $settings['shape_width']; ?>" height="<?php echo $settings['shape_width']; ?>"
             viewBox="0 0 350 350" xml:space="preserve" patternContentUnits="objectBoundingBox" preserveAspectRatio="xMidYMid slice">
             
                <!-- Fill Gradient --><defs>
                            <linearGradient id="gradientheaxa<?php echo $settings['unique_id']; ?>" x1="0%" y1="<?php echo $settings['gradient_angle']; ?>%" x2="100%" y2="0%">
                              <stop offset="0%" style="stop-color:<?php echo $settings['gradient_color_a']; ?>;stop-opacity:1" />
                              <stop offset="100%" style="stop-color:<?php echo $settings['gradient_color_b']; ?>;stop-opacity:1" />
                            </linearGradient>
                          </defs><!-- /Fill Gradient -->
        <path 
           <?php if($settings['fill'] == "none"){ ?>
                            fill="none"
                        <?php } elseif($settings['fill'] == "gradient"){ ?>
                        fill="url(#gradientheaxa<?php echo $settings['unique_id']; ?>)" 
                        <?php } else { ?>
                          fill="<?php echo $settings['shape_color'];?>" 
                        <?php } ?>
        d="M291.7,70.8L179.1,5.9C165.5-2,148.7-2,135,5.9L22.3,70.8C8.7,78.7,0,93.2,0,109v129.9
            c0,15.7,8.6,30.3,22.3,38.1l112.6,64.9c13.6,7.9,30.5,7.9,44.1,0L291.7,277c13.6-7.9,22.3-22.4,22.3-38.1V109
            C314,93.2,305.4,78.7,291.7,70.8z"/>
        </svg>
        </div>
    <?php } elseif($settings['shape_element'] =="strokehexagon"){ ?>
    <div style="transform: rotate(<?php echo $settings['rotate_shape']; ?>deg)">
    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
     viewBox="0 0 350 350"  width="<?php echo $settings['shape_width']; ?>" height="<?php echo $settings['shape_width']; ?>"
             viewBox="0 0 300 300" xml:space="preserve" patternContentUnits="objectBoundingBox" preserveAspectRatio="xMidYMid slice">
     <!-- Stroke Gradient --><defs>
                            <linearGradient id="gradientstrokehexa<?php echo $settings['unique_id']; ?>" x1="0%" y1="<?php echo $settings['gradient_angle']; ?>%" x2="100%" y2="0%">
                              <stop offset="0%" style="stop-color:<?php echo $settings['stroke_gradient_a']; ?>;stop-opacity:1" />
                              <stop offset="100%" style="stop-color:<?php echo $settings['stroke_gradient_b']; ?>;stop-opacity:1" />
                            </linearGradient>
                          </defs><!-- /Stroke Gradient -->
<path fill-rule="evenodd" clip-rule="evenodd"

                        <?php if($settings['stroke'] == "single"){ ?>
                        fill="<?php echo $settings['stroke_color'];?>" 
                        <?php } elseif($settings['stroke'] == "gradient"){ ?>
                        fill="url(#gradientstrokehexa<?php echo $settings['unique_id']; ?>)" 
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
    <?php } elseif($settings['shape_element'] =="pentagon"){ ?>
    <div style="transform: rotate(<?php echo $settings['rotate_shape']; ?>deg)">
            <svg xmlns="http://www.w3.org/2000/svg" width="<?php echo $settings['shape_width']; ?>" height="<?php echo $settings['shape_width']; ?>"
             viewBox="0 0 313.7 302.8"  xml:space="preserve">
             
                <!-- Fill Gradient --><defs>
                            <linearGradient id="gradientpenta<?php echo $settings['unique_id']; ?>" x1="0%" y1="<?php echo $settings['gradient_angle']; ?>%" x2="100%" y2="0%">
                              <stop offset="0%" style="stop-color:<?php echo $settings['gradient_color_a']; ?>;stop-opacity:1" />
                              <stop offset="100%" style="stop-color:<?php echo $settings['gradient_color_b']; ?>;stop-opacity:1" />
                            </linearGradient>
                          </defs><!-- /Fill Gradient -->
        <path 
        <?php if($settings['fill'] == "none"){ ?>
                            fill="none"
                        <?php } elseif($settings['fill'] == "gradient"){ ?>
                        fill="url(#gradientpenta<?php echo $settings['unique_id']; ?>)" 
                        <?php } else { ?>
                          fill="<?php echo $settings['shape_color'];?>" 
                        <?php } ?>
        
        d="M296.3,91.4L181.6,8c-14.8-10.7-34.7-10.7-49.5,0L17.4,91.4C2.6,102.1-3.6,121.1,2.1,138.5l43.8,135.1
            c5.6,17.3,21.8,29.2,40,29.2h141.8c18.2,0,34.4-11.9,40-29.2l43.8-135C317.2,121.2,311.1,102.1,296.3,91.4z"/>
        </svg>
</div>

        <?php } elseif($settings['shape_element'] =="custom"){ ?>
        
        <div style="transform: rotate(<?php echo $settings['rotate_shape']; ?>deg)">
        <img src="<?php echo $settings['custom_image']['url']; ?>">
        </div>
         <?php } else { ?>
         
         <div style="transform: rotate(<?php echo $settings['rotate_shape']; ?>deg)">
         <svg xmlns="http://www.w3.org/2000/svg" width="<?php echo $settings['shape_width']; ?>" height="<?php echo $settings['shape_width']; ?>"
             viewBox="0 0 400 400"  xml:space="preserve" patternContentUnits="objectBoundingBox" preserveAspectRatio="xMidYMid slice">
             
                <!-- Fill Gradient --><defs>
                            <linearGradient id="gradientplus<?php echo $settings['unique_id']; ?>" x1="0%" y1="<?php echo $settings['gradient_angle']; ?>%" x2="100%" y2="0%">
                              <stop offset="0%" style="stop-color:<?php echo $settings['gradient_color_a']; ?>;stop-opacity:1" />
                              <stop offset="100%" style="stop-color:<?php echo $settings['gradient_color_b']; ?>;stop-opacity:1" />
                            </linearGradient>
                          </defs><!-- /Fill Gradient -->
                          
        <path 
        <?php if($settings['fill'] == "none"){ ?>
                            fill="none"
                        <?php } elseif($settings['fill'] == "gradient"){ ?>
                        fill="url(#gradientplus<?php echo $settings['unique_id']; ?>)" 
                        <?php } else { ?>
                          fill="<?php echo $settings['shape_color'];?>" 
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

      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new object_Elementor_Thing );
?>