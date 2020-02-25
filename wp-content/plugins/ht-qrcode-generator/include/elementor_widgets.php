<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Htqrcode_Elementor_Widget_QRCode extends Widget_Base {

    public function get_name() {
        return 'htqrcode-addons';
    }
    
    public function get_title() {
        return esc_html__( 'HT: QR Code', 'ht-qrcode' );
    }

    public function get_icon() {
        return 'fas fa-qrcode';
    }

    public function get_categories() {
        return [ 'general' ];
    }
    protected function _register_controls() {
       

        $this->start_controls_section(
                'ht_qr_alignment',
                [
                    'label' => esc_html__( 'QR Code', 'ht-qrcode' ),
                    'tab' => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
            'ht_qr_align',
                [
                    'label' => esc_html__( 'Alignment', 'ht-qrcode' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'ht-qrcode' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'ht-qrcode' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'ht-qrcode' ),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'default' => 'center',
                    'toggle' => true,
                ]
            );

            $this->add_control(
            'ht_qr_style_titel',
                [
                    'label' => esc_html__( 'HT QR Code Style:', 'ht-qrcode' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
            'ht_qr_hr_style_2',
                [
                    'type' => Controls_Manager::DIVIDER,
                ]
            );

            $this->add_control(
                'ht_qr_style',
                [
                    'label' => esc_html__( 'QR Code Style:', 'ht-qrcode' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '0',
                    'options' => [
                        '0' => esc_html__( 'Custom', 'ht-qrcode' ),
                        '1' => esc_html__( 'Normal', 'ht-qrcode' ),
                        '2' => esc_html__( 'Color', 'ht-qrcode' ),
                        '3' => esc_html__( 'Dot Scale', 'ht-qrcode' ),
                        '4' => esc_html__( 'Position Color + Alignment Color', 'ht-qrcode' ),
                        '5' => esc_html__( 'Position Color + Dot Scale', 'ht-qrcode' ),
                        '6' => esc_html__( 'Timing + Dot Scale', 'ht-qrcode' ),
                        '7' => esc_html__( 'Background Image', 'ht-qrcode' ),
                        '8' => esc_html__( 'Auto Color + Background Image + Dot Scale', 'ht-qrcode' ),
                        '9' => esc_html__( 'AutoColor + background Image Alpha', 'ht-qrcode' ),
                        '10' => esc_html__( 'Logo + quietZone Color', 'ht-qrcode' ),
                        '11' => esc_html__( 'Logo + Dot Scale', 'ht-qrcode' ),
                        '12' => esc_html__( 'Logo + Colorful Style 1', 'ht-qrcode' ),
                        '13' => esc_html__( 'Logo + Colorful Style 2', 'ht-qrcode' ),
                        '14' => esc_html__( 'QuietZone + Logo + Background', 'ht-qrcode' ),
                    ],
                ]
            );

            
            $this->add_control(
            'ht_qr_general_options_titel',
                [
                    'label' => esc_html__( 'General Options:', 'ht-qrcode' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
            'ht_qr_general_options_hr',
                [
                    'type' => Controls_Manager::DIVIDER,
                ]
            );

           
            $this->add_control(
                'ht_custom_qrcode_text',
                [
                    'label' => esc_html__( 'Custom URL Or Text:', 'ht-qrcode' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'rows' => 3,
                    'placeholder' => esc_html__( 'Type your URL or Text here.', 'ht-qrcode' ),
                ]
            );

            $this->add_control(
            'ht_qr_size',
                [
                    'label' => esc_html__( 'QR Code Size:', 'ht-qrcode' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 50,
                    'max' => 600,
                    'step' => 50,
                    'default' => 300,
                    'placeholder' => esc_html__( 'Example: 300 ', 'ht-qrcode' ),
                ]
            );

            $this->add_control(
            'ht_qr_dot_scale',
                [
                    'label' => esc_html__( 'QR Code Dot Scale:', 'ht-qrcode' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0.1,
                    'max' => 1,
                    'step' => 0.1,
                    'default' => 1,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_zone',
                [
                    'label' => esc_html__( 'QR Quiet Zone:', 'ht-qrcode' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'default' => 0,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_zone_color',
                [
                    'label' => esc_html__( 'QR Quiet Zone Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => "#00CED1",
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );
            

            $this->add_control(
                'ht_qr_ec_level',
                [
                    'label' => esc_html__( 'QR EC Level', 'ht-qrcode' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'H',
                    'options' => [
                        'L'  => esc_html__( 'Low', 'ht-qrcode' ),
                        'M' => esc_html__( 'Medium ', 'ht-qrcode' ),
                        'Q' => esc_html__( 'Quartile', 'ht-qrcode' ),
                        'H' => esc_html__( 'High', 'ht-qrcode' ),
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_more_options_logo',
                [
                    'label' => esc_html__( 'QR Code Logo', 'ht-qrcode' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
            'ht_qr_hr',
                [
                    'type' => Controls_Manager::DIVIDER,
                ]
            );

            $this->add_control(
            'ht_qr_logo',
                [
                    'label' => esc_html__( 'Choose Logo', 'ht-qrcode' ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                    'url' => HTQRCODE_PL_URL."assets/img/logo.png",
                ],
                ]
            );

            $this->add_control(
            'ht_qr_logo_size',
                [
                    'label' => esc_html__( 'Logo size: (Max Size 100px)', 'ht-qrcode' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                    'default' => 50,
                ]
            );

            $this->add_control(
                'ht_qr_logo_bg_transparent',
                [
                    'label' => esc_html__( 'Background Transparent', 'ht-qrcode' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'true',
                    'options' => [
                        'true'  => esc_html__( 'True', 'ht-qrcode' ),
                        'false' => esc_html__( 'False ', 'ht-qrcode' ),
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_logo_bg_color',
                [
                    'label' => esc_html__( 'Logo Background Color', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => "#ffffff",
                    'condition' =>[
                        'ht_qr_logo_bg_transparent' => 'false',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_bg_image',
                [
                    'label' => esc_html__( 'Choose Background Image:', 'ht-qrcode' ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => HTQRCODE_PL_URL."assets/img/background_logo.png",
                    ],
                ]
            );
            
             $this->add_control(
            'ht_qr_bg_opacity',
                [
                    'label' => esc_html__( 'Background Image Opacity:', 'ht-qrcode' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.1,
                    'default' => 0.5,
                ]
            );

            $this->add_control(
                'ht_qr_bg_autocolor',
                [
                    'label' => esc_html__( 'Background Auto Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'false',
                    'options' => [
                        'true'  => esc_html__( 'True', 'ht-qrcode' ),
                        'false' => esc_html__( 'False ', 'ht-qrcode' ),
                    ],
                ]
            );


            /*
            * QR code Style
            */
            $this->add_control(
            'more_options_style',
                [
                    'label' => esc_html__( 'QR Code Style', 'ht-qrcode' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_hr_style',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_colordark_dot',
                [
                    'label' => esc_html__( 'QR Dot Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => "#000000",
                    
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_colorlight_bg',
                [
                    'label' => esc_html__( 'Background Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => "#FFFFFF",
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            /*
            * Pasotion Pattern Global Color:
            */
             $this->add_control(
            'ht_pattern_global_style',
                [
                    'label' => esc_html__( 'Pasotion Pattern Global Style', 'ht-qrcode' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_hr_pattern_global_style',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_po',
                [
                    'label' => esc_html__( 'Pattern Outer Global Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_pi',
                [
                    'label' => esc_html__( 'Pattern Inner Global Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            /*
            * Pasotion Pattern Individual Color:
            */
             $this->add_control(
            'ht_pattern_individual_style',
                [
                    'label' => esc_html__( 'Pasotion Pattern Individual Style', 'ht-qrcode' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_hr_pattern_individual_style',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_po_tl',
                [
                    'label' => esc_html__( 'Pattern Outer Top Left Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_pi_tl',
                [
                    'label' => esc_html__( 'Pattern Inner Top Left Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_po_tr',
                [
                    'label' => esc_html__( 'Pattern Outer Top Right Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_pi_tr',
                [
                    'label' => esc_html__( 'Pattern Inner Top Right Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_po_bl',
                [
                    'label' => esc_html__( 'Pattern Outer Bottom Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_pi_bl',
                [
                    'label' => esc_html__( 'Pattern Inner Bottom Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            /*
            *  Aligment color
            */
            $this->add_control(
            'ht_qr_hr_aligment_style',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_ao',
                [
                    'label' => esc_html__( 'Aligment Outer Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_ai',
                [
                    'label' => esc_html__( 'Aligment Inner Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            /*
            *  Timing Pattern Color
            */
             $this->add_control(
            'ht_timing_pattern_style',
                [
                    'label' => esc_html__( 'Timing Pattern Style (Global & Individual)', 'ht-qrcode' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_hr_timing_style_1',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_timing',
                [
                    'label' => esc_html__( 'Timing Global Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_timing_h',
                [
                    'label' => esc_html__( 'Timing Horizontal Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

            $this->add_control(
            'ht_qr_timing_v',
                [
                    'label' => esc_html__( 'Timing Vertical Color:', 'ht-qrcode' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' =>[
                        'ht_qr_style' => '0',
                    ],
                ]
            );

        $this->end_controls_section();
    }
  
    protected function render( $instance = [] ) {
        $settings = $this->get_settings_for_display();

        if( empty( $settings['ht_custom_qrcode_text'] ) ) { $settings['ht_custom_qrcode_text'] = get_permalink(); }
        if( empty( $settings['ht_qr_size'] )) { $settings['ht_qr_size'] = 300; }
        if( empty( $settings['ht_qr_dot_scale'] ) ) { $settings['ht_qr_dot_scale'] = 1; }
        if( empty( $settings['ht_qr_logo_size'] ) ) { $settings['ht_qr_logo_size'] = 0; }
        if( empty( $settings['ht_qr_colordark_dot'] ) ) { $settings['ht_qr_colordark_dot'] = "#000000"; }
        if( empty( $settings['ht_qr_colorlight_bg'] ) ) { $settings['ht_qr_colorlight_bg'] = "#ffffff"; }
        if( empty( $settings['ht_qr_bg_opacity'] ) ) { $settings['ht_qr_bg_opacity'] = 0; }

        switch ($settings['ht_qr_style']) {
            case "1":
                $settings['ht_qr_dot_scale'] = 1;
                $settings['ht_qr_logo']['url']= "";
                $settings['ht_qr_bg_image']['url'] = "";
                $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] ="#ffffff";
                $settings['ht_qr_po'] ="";
                $settings['ht_qr_pi'] ="";
                $settings['ht_qr_po_tl'] ="";
                $settings['ht_qr_pi_tl'] ="";
                $settings['ht_qr_po_tr'] ="";
                $settings['ht_qr_pi_tr'] ="";
                $settings['ht_qr_po_bl'] ="";
                $settings['ht_qr_pi_bl'] ="";
                $settings['ht_qr_ao'] ="";
                $settings['ht_qr_ai'] ="";
                $settings['ht_qr_timing'] ="";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_zone'] = 0;
                break;

            case "2":
                $settings['ht_qr_dot_scale'] = 1;
                $settings['ht_qr_colordark_dot'] = "#473C8B";
                $settings['ht_qr_colorlight_bg'] ="#FFFACD";
                $settings['ht_qr_logo']['url'] = "";
                $settings['ht_qr_bg_image']['url'] = "";
                $settings['ht_qr_po'] ="";
                $settings['ht_qr_pi'] ="";
                $settings['ht_qr_po_tl'] ="";
                $settings['ht_qr_pi_tl'] ="";
                $settings['ht_qr_po_tr'] ="";
                $settings['ht_qr_pi_tr'] ="";
                $settings['ht_qr_po_bl'] ="";
                $settings['ht_qr_pi_bl'] ="";
                $settings['ht_qr_ao'] ="";
                $settings['ht_qr_ai'] ="";
                $settings['ht_qr_timing'] ="";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_zone'] = 0;
                break;

            case "3":
                $settings['ht_qr_dot_scale'] = 0.4;
                $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] ="#ffffff";
                $settings['ht_qr_logo']['url'] = "";
                $settings['ht_qr_bg_image']['url'] = "";
                $settings['ht_qr_po'] ="";
                $settings['ht_qr_pi'] ="";
                $settings['ht_qr_po_tl'] ="";
                $settings['ht_qr_pi_tl'] ="";
                $settings['ht_qr_po_tr'] ="";
                $settings['ht_qr_pi_tr'] ="";
                $settings['ht_qr_po_bl'] ="";
                $settings['ht_qr_pi_bl'] ="";
                $settings['ht_qr_ao'] ="";
                $settings['ht_qr_ai'] ="";
                $settings['ht_qr_timing'] ="";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_zone'] = 0;
                break;

            case "4":
                $settings['ht_qr_dot_scale'] = 0.4;
                $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] ="#ffffff";
                $settings['ht_qr_logo']['url'] = "";
                $settings['ht_qr_bg_image']['url'] = "";
                $settings['ht_qr_po'] ="#269926";
                $settings['ht_qr_pi'] ="#BF3030";
                $settings['ht_qr_po_tl'] ="";
                $settings['ht_qr_pi_tl'] ="";
                $settings['ht_qr_po_tr'] ="";
                $settings['ht_qr_pi_tr'] ="";
                $settings['ht_qr_po_bl'] ="";
                $settings['ht_qr_pi_bl'] = "";
                $settings['ht_qr_ao'] = "#B03060";
                $settings['ht_qr_ai'] = "#009ACD";
                $settings['ht_qr_timing'] ="";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_zone'] = 0;
                break;

            case "5":
                $settings['ht_qr_dot_scale'] = 0.4;
                $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] = "#ffffff";
                $settings['ht_qr_logo']['url'] = "";
                $settings['ht_qr_bg_image']['url'] = "";
                $settings['ht_qr_po'] = "";
                $settings['ht_qr_pi'] = "#f55066";
                $settings['ht_qr_po_tl'] = "#aa5b71";
                $settings['ht_qr_pi_tl'] = "#b7d28d";
                $settings['ht_qr_po_tr'] = "";
                $settings['ht_qr_pi_tr'] = "";
                $settings['ht_qr_po_bl'] = "";
                $settings['ht_qr_pi_bl'] = "";
                $settings['ht_qr_ao'] = "";
                $settings['ht_qr_ai'] = "";
                $settings['ht_qr_timing'] = "";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_zone'] = 0;
                break;

            case "6":
                $settings['ht_qr_dot_scale'] = 0.4;
                $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] = "#ffffff";
                $settings['ht_qr_logo']['url'] = "";
                $settings['ht_qr_bg_image']['url'] = "";
                $settings['ht_qr_po'] = "";
                $settings['ht_qr_pi'] = "";
                $settings['ht_qr_po_tl'] = "";
                $settings['ht_qr_pi_tl'] = "";
                $settings['ht_qr_po_tr'] = "";
                $settings['ht_qr_pi_tr'] = "";
                $settings['ht_qr_po_bl'] = "";
                $settings['ht_qr_pi_bl'] = "";
                $settings['ht_qr_ao'] = "";
                $settings['ht_qr_ai'] = "";
                $settings['ht_qr_timing'] = "#e1622f";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_timing_v'] ="#00C12B";
                $settings['ht_qr_zone'] = 0;
                break;

            case "7":
                $settings['ht_qr_dot_scale'] = 1;
                $settings['ht_qr_bg_opacity'] = 1;
                $settings['ht_qr_logo']['url'] = "";
                $settings['ht_qr_bg_autocolor'] = "false";
                $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] = "#ffffff";
                $settings['ht_qr_po'] = "";
                $settings['ht_qr_pi'] = "";
                $settings['ht_qr_po_tl'] = "";
                $settings['ht_qr_pi_tl'] = "";
                $settings['ht_qr_po_tr'] = "";
                $settings['ht_qr_pi_tr'] = "";
                $settings['ht_qr_po_bl'] = "";
                $settings['ht_qr_pi_bl'] = "";
                $settings['ht_qr_ao'] = "";
                $settings['ht_qr_ai'] = "";
                $settings['ht_qr_timing'] = "";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_timing_v'] ="";
                $settings['ht_qr_zone'] = 0;
                break;

            case "8":
                $settings['ht_qr_dot_scale'] = 0.5;
                $settings['ht_qr_bg_opacity'] = 1;
                $settings['ht_qr_bg_autocolor'] = "true";
                $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] = "#ffffff";
                $settings['ht_qr_po'] = "";
                $settings['ht_qr_pi'] = "#f55066";
                $settings['ht_qr_po_tl'] = "";
                $settings['ht_qr_pi_tl'] = "";
                $settings['ht_qr_po_tr'] = "";
                $settings['ht_qr_pi_tr'] = "";
                $settings['ht_qr_po_bl'] = "";
                $settings['ht_qr_pi_bl'] = "";
                $settings['ht_qr_ao'] = "";
                $settings['ht_qr_ai'] = "";
                $settings['ht_qr_timing'] = "";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_timing_v'] ="";
                $settings['ht_qr_zone'] = 0;
                break;

            case "9":
                $settings['ht_qr_dot_scale'] = 0.5;
                $settings['ht_qr_bg_opacity'] = 0.3;
                $settings['ht_qr_bg_image']['url'] = "";
                $settings['ht_qr_bg_autocolor'] = "true";
                $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] = "#ffffff";
                $settings['ht_qr_po'] = "";
                $settings['ht_qr_pi'] = "#f55066";
                $settings['ht_qr_po_tl'] = "";
                $settings['ht_qr_pi_tl'] = "";
                $settings['ht_qr_po_tr'] = "";
                $settings['ht_qr_pi_tr'] = "";
                $settings['ht_qr_po_bl'] = "";
                $settings['ht_qr_pi_bl'] = "";
                $settings['ht_qr_ao'] = "";
                $settings['ht_qr_ai'] = "";
                $settings['ht_qr_timing'] = "";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_timing_v'] ="";
                $settings['ht_qr_zone'] = 0;
                break;

             case "10":
                $settings['ht_qr_dot_scale'] = 1;
                $settings['ht_qr_logo_bg_color'] = "ffffff";
                $settings['ht_qr_logo_bg_transparent'] = "false";
                $settings['ht_qr_bg_opacity'] = 1;
                $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] = "#ffffff";
                $settings['ht_qr_po'] = "";
                $settings['ht_qr_pi'] = "";
                $settings['ht_qr_po_tl'] = "";
                $settings['ht_qr_pi_tl'] = "";
                $settings['ht_qr_po_tr'] = "";
                $settings['ht_qr_pi_tr'] = "";
                $settings['ht_qr_po_bl'] = "";
                $settings['ht_qr_pi_bl'] = "";
                $settings['ht_qr_ao'] = "";
                $settings['ht_qr_ai'] = "";
                $settings['ht_qr_timing'] = "";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_timing_v'] ="";
                $settings['ht_qr_zone'] = 10;
                $settings['ht_qr_zone_color'] = "#00CED1";
                break;

            case "11":
                 $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] = "#ffffff";
                $settings['ht_qr_dot_scale'] = 0.5;
                $settings['ht_qr_bg_image']['url'] = "";
                $settings['ht_qr_bg_opacity'] = 1;
                $settings['ht_qr_bg_autocolor'] = "false";
                $settings['ht_qr_po'] = "";
                $settings['ht_qr_pi'] = "";
                $settings['ht_qr_po_tl'] = "";
                $settings['ht_qr_pi_tl'] = "";
                $settings['ht_qr_po_tr'] = "";
                $settings['ht_qr_pi_tr'] = "";
                $settings['ht_qr_po_bl'] = "";
                $settings['ht_qr_pi_bl'] = "";
                $settings['ht_qr_ao'] = "";
                $settings['ht_qr_ai'] = "";
                $settings['ht_qr_timing'] = "";
                $settings['ht_qr_timing_h'] ="";
                $settings['ht_qr_timing_v'] ="#00B2EE";
                $settings['ht_qr_zone'] = 0;
                break;

            case "12":
                 $settings['ht_qr_colordark_dot'] = "#27408B";
                $settings['ht_qr_colorlight_bg'] = "#FFF8DC";
                $settings['ht_qr_dot_scale'] = 0.5;
                $settings['ht_qr_bg_image']['url'] = "";
                $settings['ht_qr_bg_opacity'] = 1;
                $settings['ht_qr_bg_autocolor'] = "false";
                $settings['ht_qr_po'] = "#e1622f";
                $settings['ht_qr_pi'] = "#aa5b71";
                $settings['ht_qr_po_tl'] = "";
                $settings['ht_qr_pi_tl'] = "#b7d28d";
                $settings['ht_qr_po_tr'] = "#aa5b71";
                $settings['ht_qr_pi_tr'] = "#c17e61";
                $settings['ht_qr_po_bl'] = "";
                $settings['ht_qr_pi_bl'] = "";
                $settings['ht_qr_ao'] = "";
                $settings['ht_qr_ai'] = "";
                $settings['ht_qr_timing'] = "";
                $settings['ht_qr_timing_h'] ="#ff6600";
                $settings['ht_qr_timing_v'] ="#cc0033";
                $settings['ht_qr_zone'] = 0;
                break;

             case "13":
                 $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] = "#FFFACD";
                $settings['ht_qr_dot_scale'] = 0.5;
                $settings['ht_qr_bg_image']['url'] = "";
                $settings['ht_qr_bg_opacity'] = 1;
                $settings['ht_qr_bg_autocolor'] = "false";
                $settings['ht_qr_po'] = "#e1622f";
                $settings['ht_qr_pi'] = "#aa5b71";
                $settings['ht_qr_po_tl'] = "#aa5b71";
                $settings['ht_qr_pi_tl'] = "#b7d28d";
                $settings['ht_qr_po_tr'] = "";
                $settings['ht_qr_pi_tr'] = "#c17e61";
                $settings['ht_qr_po_bl'] = "";
                $settings['ht_qr_pi_bl'] = "";
                $settings['ht_qr_ao'] = "#27408B";
                $settings['ht_qr_ai'] = "#7D26CD";
                $settings['ht_qr_timing'] = "";
                $settings['ht_qr_timing_h'] ="#ff6600";
                $settings['ht_qr_timing_v'] ="#cc0033";
                $settings['ht_qr_zone'] = 0;
                break;

            case "14":
                $settings['ht_qr_colordark_dot'] = "#000000";
                $settings['ht_qr_colorlight_bg'] = "#FFF8DC";
                $settings['ht_qr_dot_scale'] = 0.7;
                $settings['ht_qr_bg_opacity'] = 0.1;
                $settings['ht_qr_bg_autocolor'] = "true";
                $settings['ht_qr_po'] = "#e1622f";
                $settings['ht_qr_pi'] = "#aa5b71";
                $settings['ht_qr_po_tl'] = "#aa5b71";
                $settings['ht_qr_pi_tl'] = "#b7d28d";
                $settings['ht_qr_po_tr'] = "";
                $settings['ht_qr_pi_tr'] = "#c17e61";
                $settings['ht_qr_po_bl'] = "";
                $settings['ht_qr_pi_bl'] = "";
                $settings['ht_qr_ao'] = "#27408B";
                $settings['ht_qr_ai'] = "#7D26CD";
                $settings['ht_qr_timing'] = "";
                $settings['ht_qr_timing_h'] ="#ff6600";
                $settings['ht_qr_timing_v'] ="#cc0033";
                $settings['ht_qr_zone'] = 10;
                $settings['ht_qr_zone_color'] = "#00CED1";
                break;  
        }

        echo do_shortcode('[htqrcode alignment = "'.esc_attr_x( $settings['ht_qr_align'],'ht-qrcode' ).'" qrcode = "'.esc_html__( $settings['ht_custom_qrcode_text'],'ht-qrcode' ).'" size = "'.esc_html__( $settings['ht_qr_size'],'ht-qrcode' ).'" dot_scale = "'.esc_html__( $settings['ht_qr_dot_scale'],'ht-qrcode' ).'" qr_level = "'.esc_html__( $settings['ht_qr_ec_level'],'ht-qrcode' ).'" logo = "'.esc_html__( $settings['ht_qr_logo']['url'],'ht-qrcode' ).'" logo_size = "'.esc_html__( $settings['ht_qr_logo_size'],'ht-qrcode' ).'" logo_bg_color = "'.esc_html__( $settings['ht_qr_logo_bg_color'],'ht-qrcode' ).'" logo_bg_transparent = "'.esc_html__( $settings['ht_qr_logo_bg_transparent'],'ht-qrcode' ).'" qr_bg_image ="'.esc_html__( $settings['ht_qr_bg_image']['url'],'ht-qrcode' ).'" qr_bg_opacity = "'.esc_html__( $settings['ht_qr_bg_opacity'],'ht-qrcode' ).'" qr_bg_autocolor = "'.esc_html__( $settings['ht_qr_bg_autocolor'],'ht-qrcode' ).'" colordark = "'.esc_html__( $settings['ht_qr_colordark_dot'],'ht-qrcode' ).'" colorlight = "'.esc_html__( $settings['ht_qr_colorlight_bg'],'ht-qrcode' ).'" po = "'.esc_html__( $settings['ht_qr_po'],'ht-qrcode' ).'" pi = "'.esc_html__( $settings['ht_qr_pi'],'ht-qrcode' ).'" po_tl = "'.esc_html__( $settings['ht_qr_po_tl'],'ht-qrcode' ).'" pi_tl = "'.esc_html__( $settings['ht_qr_pi_tl'],'ht-qrcode' ).'" po_tr = "'.esc_html__( $settings['ht_qr_po_tr'],'ht-qrcode' ).'" pi_tr = "'.esc_html__( $settings['ht_qr_pi_tr'],'ht-qrcode' ).'" po_bl = "'.esc_html__( $settings['ht_qr_po_bl'],'ht-qrcode' ).'" pi_bl = "'.esc_html__( $settings['ht_qr_pi_bl'],'ht-qrcode' ).'" ao = "'.esc_html__( $settings['ht_qr_ao'],'ht-qrcode' ).'" ai = "'.esc_html__( $settings['ht_qr_ai'],'ht-qrcode' ).'" timing = "'.esc_html__( $settings['ht_qr_timing'],'ht-qrcode' ).'" timing_h = "'.esc_html__( $settings['ht_qr_timing_h'],'ht-qrcode' ).'" timing_v = "'.esc_html__( $settings['ht_qr_timing_v'],'ht-qrcode' ).'" quietzone="'.esc_html__( $settings['ht_qr_zone'],'ht-qrcode' ).'" 
            quietzonecolor = "'.esc_html__( $settings['ht_qr_zone_color'],'ht-qrcode' ).'"]');

    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Htqrcode_Elementor_Widget_QRCode() );