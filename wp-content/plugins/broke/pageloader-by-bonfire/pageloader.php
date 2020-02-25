<?php
/*
Plugin Name: PageLoader by Bonfire 
Plugin URI: http://bonfirethemes.com/
Description: Loading Screen and Progress Bar for WordPress. Customize under Appearance → Customize → PageLoader Plugin.
Version: 4.0
Author: Bonfire Themes
Author URI: http://bonfirethemes.com/
License: GPL2
*/

    //
	// WORDPRESS LIVE CUSTOMIZER
	//
    function pageloader_theme_customizer( $wp_customize ) {

        //
        // ADD "PAGELOADER" PANEL TO LIVE CUSTOMIZER 
        //
        $wp_customize->add_panel('pageloader_panel', array('title' => __('PageLoader Plugin', 'pageloader'),'priority' => 10,));
        
        //
        // ADD "Image" SECTION TO "PAGELOADER" PANEL 
        //
        $wp_customize->add_section('pageloader_image_section',array('title' => __( 'Image', 'pageloader' ),'panel' => 'pageloader_panel','priority' => 10));

        /* custom loading image */
        $wp_customize->add_setting('pageloader_custom_loading_image');
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'pageloader_custom_loading_image',
            array(
                'label' => 'Image',
                'section' => 'pageloader_image_section',
                'settings' => 'pageloader_custom_loading_image'
        )
        ));
        
        /* loading image from url */
        $wp_customize->add_setting('pageloader_custom_loading_image_url',array('sanitize_callback' => 'sanitize_pageloader_custom_loading_image_url',));
        function sanitize_pageloader_custom_loading_image_url($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_custom_loading_image_url',array(
            'type' => 'text',
            'label' => 'Image from URL',
            'description' => 'If you need to use an off-site image as your loading image, enter its URL here (will override image selection above).',
            'section' => 'pageloader_image_section',
        ));

        /* image vertical position */
        $wp_customize->add_setting('pageloader_image_vertical_position',array(
            'default' => 'middle',
        ));
        $wp_customize->add_control('pageloader_image_vertical_position',array(
            'type' => 'select',
            'label' => 'Image vertical position',
            'section' => 'pageloader_image_section',
            'choices' => array(
                'top' => 'Top',
                'middle' => 'Middle',
                'bottom' => 'Bottom',
        ),
        ));

        /* image vertical fine-tune */
        $wp_customize->add_setting('pageloader_image_vertical_position_finetune',array('sanitize_callback' => 'sanitize_pageloader_image_vertical_position_finetune',));
        function sanitize_pageloader_image_vertical_position_finetune($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_image_vertical_position_finetune',array(
            'type' => 'text',
            'label' => 'Fine-tune image vertical position (in pixels)',
            'description' => 'Negative values accepted. Example: 50 or -50',
            'section' => 'pageloader_image_section',
        ));
        
        /* image horizontal position */
        $wp_customize->add_setting('pageloader_image_horizontal_position',array(
            'default' => 'center',
        ));
        $wp_customize->add_control('pageloader_image_horizontal_position',array(
            'type' => 'select',
            'label' => 'Image horizontal position',
            'section' => 'pageloader_image_section',
            'choices' => array(
                'left' => 'Left',
                'center' => 'Center',
                'right' => 'Right',
        ),
        ));

        /* image horizontal fine-tune */
        $wp_customize->add_setting('pageloader_image_horizontal_position_finetune',array('sanitize_callback' => 'sanitize_pageloader_image_horizontal_position_finetune',));
        function sanitize_pageloader_image_horizontal_position_finetune($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_image_horizontal_position_finetune',array(
            'type' => 'text',
            'label' => 'Fine-tune image horizontal position (in pixels)',
            'description' => 'Negative values accepted. Example: 50 or -50',
            'section' => 'pageloader_image_section',
        ));
        
        /* loading image size */
        $wp_customize->add_setting('pageloader_custom_loading_image_size',array('sanitize_callback' => 'sanitize_pageloader_custom_loading_image_size',));
        function sanitize_pageloader_custom_loading_image_size($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_custom_loading_image_size',array(
            'type' => 'text',
            'label' => 'Image size (in pixels)',
            'description' => 'By default, the default size of the image is used (but gets sized down gradually depending on screen size to prevent it from going beyond screen bounds).',
            'section' => 'pageloader_image_section',
        ));

        /* loading image alt text */
        $wp_customize->add_setting('pageloader_custom_loading_image_alt_text',array('sanitize_callback' => 'sanitize_pageloader_custom_loading_image_alt_text',));
        function sanitize_pageloader_custom_loading_image_alt_text($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_custom_loading_image_alt_text',array(
            'type' => 'text',
            'label' => 'Image ALT text',
            'description' => 'If you would like ALT text added to the image, add it here.',
            'section' => 'pageloader_image_section',
        ));

        /* pulsating loading image */
        $wp_customize->add_setting('pageloader_custom_loading_image_pulsate',array('sanitize_callback' => 'sanitize_pageloader_custom_loading_image_pulsate',));
        function sanitize_pageloader_custom_loading_image_pulsate($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_custom_loading_image_pulsate',array(
            'type' => 'text',
            'label' => 'Image pulsating speed (in seconds)',
            'description' => 'Example: 0.75 or 2.5. If empty, pulsating is disabled.',
            'section' => 'pageloader_image_section',
        ));

        /* loading image blur effect */
        $wp_customize->add_setting('pageloader_image_blur',array('sanitize_callback' => 'sanitize_pageloader_image_blur',));
        function sanitize_pageloader_image_blur($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_image_blur',array(
            'type' => 'text',
            'label' => 'Blur effect (in pixels)',
            'description' => 'Adds blur effect to loading image on load start. Note: effect may not yet be perfectly supported by all browsers. Example: 10',
            'section' => 'pageloader_image_section',
        ));
        
        /* loading image opacity */
        $wp_customize->add_setting('pageloader_image_opacity',array('sanitize_callback' => 'sanitize_pageloader_image_opacity',));
        function sanitize_pageloader_image_opacity( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_image_opacity',array('type' => 'checkbox','label' => 'Fade in image on load start.','section' => 'pageloader_image_section',));
        
        /* loading image animation effect animation speed */
        $wp_customize->add_setting('pageloader_image_fade_blur_animation_speed',array('sanitize_callback' => 'sanitize_pageloader_image_fade_blur_animation_speed',));
        function sanitize_pageloader_image_fade_blur_animation_speed($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_image_fade_blur_animation_speed',array(
            'type' => 'text',
            'label' => 'Blur/opacity animation speeds (in seconds)',
            'description' => 'Example: 5. If empty, defaults to 2.',
            'section' => 'pageloader_image_section',
        ));

        //
        // ADD "Icon" SECTION TO "PAGELOADER" PANEL 
        //
        $wp_customize->add_section('pageloader_icon_section',array('title' => __( 'Icon', 'pageloader' ),'panel' => 'pageloader_panel','priority' => 10));

        /* hide icon */
        $wp_customize->add_setting('pageloader_hide_icon',array('sanitize_callback' => 'sanitize_pageloader_hide_icon',));
        function sanitize_pageloader_hide_icon( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_hide_icon',array('type' => 'checkbox','label' => 'Hide icon','description' => 'If checked, the loading icon will not be displayed.','section' => 'pageloader_icon_section',));
        
        /* icon selection */
        $wp_customize->add_setting('pageloader_icon_selection',array(
            'default' => 'icon1',
        ));
        $wp_customize->add_control('pageloader_icon_selection',array(
            'type' => 'select',
            'label' => 'Icon style',
            'section' => 'pageloader_icon_section',
            'choices' => array(
                'icon1' => 'Icon 1',
                'icon2' => 'Icon 2',
                'icon3' => 'Icon 3',
                'icon4' => 'Icon 4',
                'icon5' => 'Icon 5',
                'icon6' => 'Icon 6',
                'icon7' => 'Icon 7',
                'icon8' => 'Icon 8',
                'icon9' => 'Icon 9',
                'icon10' => 'Icon 10',
        ),
        ));

        /* icon vertical position */
        $wp_customize->add_setting('pageloader_icon_vertical_position',array(
            'default' => 'middle',
        ));
        $wp_customize->add_control('pageloader_icon_vertical_position',array(
            'type' => 'select',
            'label' => 'Icon vertical position',
            'section' => 'pageloader_icon_section',
            'choices' => array(
                'top' => 'Top',
                'middle' => 'Middle',
                'bottom' => 'Bottom',
        ),
        ));

        /* icon vertical fine-tune */
        $wp_customize->add_setting('pageloader_icon_vertical_position_finetune',array('sanitize_callback' => 'sanitize_pageloader_icon_vertical_position_finetune',));
        function sanitize_pageloader_icon_vertical_position_finetune($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_icon_vertical_position_finetune',array(
            'type' => 'text',
            'label' => 'Fine-tune icon vertical position (in pixels)',
            'description' => 'Negative values accepted. Example: 50 or -50',
            'section' => 'pageloader_icon_section',
        ));
        
        /* icon horizontal position */
        $wp_customize->add_setting('pageloader_icon_horizontal_position',array(
            'default' => 'center',
        ));
        $wp_customize->add_control('pageloader_icon_horizontal_position',array(
            'type' => 'select',
            'label' => 'Icon horizontal position',
            'section' => 'pageloader_icon_section',
            'choices' => array(
                'left' => 'Left',
                'center' => 'Center',
                'right' => 'Right',
        ),
        ));

        /* icon horizontal fine-tune */
        $wp_customize->add_setting('pageloader_icon_horizontal_position_finetune',array('sanitize_callback' => 'sanitize_pageloader_icon_horizontal_position_finetune',));
        function sanitize_pageloader_icon_horizontal_position_finetune($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_icon_horizontal_position_finetune',array(
            'type' => 'text',
            'label' => 'Fine-tune icon horizontal position (in pixels)',
            'description' => 'Negative values accepted. Example: 50 or -50',
            'section' => 'pageloader_icon_section',
        ));

        /* icon animation speed */
        $wp_customize->add_setting('pageloader_icon_animation_speed',array('sanitize_callback' => 'sanitize_pageloader_icon_animation_speed',));
        function sanitize_pageloader_icon_animation_speed($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_icon_animation_speed',array(
            'type' => 'text',
            'label' => 'Icon animation speed (in seconds)',
            'description' => 'Example: 0.5 or 2.5. If empty, defaults to icon default speed',
            'section' => 'pageloader_icon_section',
        ));

        /* icon scaling */
        $wp_customize->add_setting('pageloader_icon_scaling',array('sanitize_callback' => 'sanitize_pageloader_icon_scaling',));
        function sanitize_pageloader_icon_scaling($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_icon_scaling',array(
            'type' => 'text',
            'label' => 'Icon scaling',
            'description' => 'Change size of the loading icon. Example: 0.5 or 2.5. If empty, defaults to 1',
            'section' => 'pageloader_icon_section',
        ));
        
        /* icon color (primary) */
        $wp_customize->add_setting('pageloader_icon_color', array('sanitize_callback' => 'sanitize_hex_color' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pageloader_icon_color',array(
            'label' => 'Icon color (primary)', 'settings' => 'pageloader_icon_color', 'section' => 'pageloader_icon_section' )
        ));

        /* icon color (secondary) */
        $wp_customize->add_setting('pageloader_secondary_icon_color', array('sanitize_callback' => 'sanitize_hex_color' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pageloader_secondary_icon_color',array(
            'label' => 'Icon color (secondary, when applicable)', 'settings' => 'pageloader_secondary_icon_color', 'section' => 'pageloader_icon_section' )
        ));
        
        /* loading icon blur effect */
        $wp_customize->add_setting('pageloader_icon_blur',array('sanitize_callback' => 'sanitize_pageloader_icon_blur',));
        function sanitize_pageloader_icon_blur($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_icon_blur',array(
            'type' => 'text',
            'label' => 'Blur effect (in pixels)',
            'description' => 'Adds blur effect to loading icon on load start. Note: effect may not yet be perfectly supported by all browsers. Example: 10',
            'section' => 'pageloader_icon_section',
        ));
        
        /* loading icon opacity */
        $wp_customize->add_setting('pageloader_icon_opacity',array('sanitize_callback' => 'sanitize_pageloader_icon_opacity',));
        function sanitize_pageloader_icon_opacity( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_icon_opacity',array('type' => 'checkbox','label' => 'Fade in loading icon on load start.','section' => 'pageloader_icon_section',));
        
        /* loading icon animation effect animation speed */
        $wp_customize->add_setting('pageloader_icon_fade_blur_animation_speed',array('sanitize_callback' => 'sanitize_pageloader_icon_fade_blur_animation_speed',));
        function sanitize_pageloader_icon_fade_blur_animation_speed($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_icon_fade_blur_animation_speed',array(
            'type' => 'text',
            'label' => 'Blur/fade animation speeds (in seconds)',
            'description' => 'Example: 5. If empty, defaults to 2.',
            'section' => 'pageloader_icon_section',
        ));
        
        //
        // ADD "Text" SECTION TO "PAGELOADER" PANEL 
        //
        $wp_customize->add_section('pageloader_text_section',array('title' => __( 'Text', 'pageloader' ),'panel' => 'pageloader_panel','priority' => 10));
        
        /* loading text #1 */
        $wp_customize->add_setting('pageloader_custom_loading_text',array('sanitize_callback' => 'sanitize_pageloader_custom_loading_text',));
        function sanitize_pageloader_custom_loading_text($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_custom_loading_text',array(
            'type' => 'text',
            'label' => 'Loading text',
            'description' => 'A short sentence to display under the loading icon. If empty, no text will be shown. If multiple fields are filled, sentences will be randomized.',
            'section' => 'pageloader_text_section',
        ));

        /* loading text #2 */
        $wp_customize->add_setting('pageloader_custom_loading_text2',array('sanitize_callback' => 'sanitize_pageloader_custom_loading_text2',));
        function sanitize_pageloader_custom_loading_text2($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_custom_loading_text2',array(
            'type' => 'text',
            'section' => 'pageloader_text_section',
        ));
        
        /* loading text #3 */
        $wp_customize->add_setting('pageloader_custom_loading_text3',array('sanitize_callback' => 'sanitize_pageloader_custom_loading_text3',));
        function sanitize_pageloader_custom_loading_text3($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_custom_loading_text3',array(
            'type' => 'text',
            'section' => 'pageloader_text_section',
        ));

        /* loading text vertical position */
        $wp_customize->add_setting('pageloader_loading_text_vertical_position',array(
            'default' => 'middle',
        ));
        $wp_customize->add_control('pageloader_loading_text_vertical_position',array(
            'type' => 'select',
            'label' => 'Text vertical position',
            'section' => 'pageloader_text_section',
            'choices' => array(
                'top' => 'Top',
                'middle' => 'Middle',
                'bottom' => 'Bottom',
        ),
        ));

        /* loading text vertical fine-tune */
        $wp_customize->add_setting('pageloader_loading_text_vertical_position_finetune',array('sanitize_callback' => 'sanitize_pageloader_loading_text_vertical_position_finetune',));
        function sanitize_pageloader_loading_text_vertical_position_finetune($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_loading_text_vertical_position_finetune',array(
            'type' => 'text',
            'label' => 'Fine-tune text vertical position (in pixels)',
            'description' => 'Negative values accepted. Example: 50 or -50',
            'section' => 'pageloader_text_section',
        ));
        
        /* loading text horizontal position */
        $wp_customize->add_setting('pageloader_loading_text_horizontal_position',array(
            'default' => 'center',
        ));
        $wp_customize->add_control('pageloader_loading_text_horizontal_position',array(
            'type' => 'select',
            'label' => 'Text horizontal position',
            'section' => 'pageloader_text_section',
            'choices' => array(
                'left' => 'Left',
                'center' => 'Center',
                'right' => 'Right',
        ),
        ));

        /* loading text horizontal fine-tune */
        $wp_customize->add_setting('pageloader_loading_text_horizontal_position_finetune',array('sanitize_callback' => 'sanitize_pageloader_loading_text_horizontal_position_finetune',));
        function sanitize_pageloader_loading_text_horizontal_position_finetune($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_loading_text_horizontal_position_finetune',array(
            'type' => 'text',
            'label' => 'Fine-tune text horizontal position (in pixels)',
            'description' => 'Negative values accepted. Example: 50 or -50',
            'section' => 'pageloader_text_section',
        ));
        
        /* text color */
        $wp_customize->add_setting('pageloader_text_color', array('sanitize_callback' => 'sanitize_hex_color' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pageloader_text_color',array(
            'label' => 'Text', 'settings' => 'pageloader_text_color', 'section' => 'pageloader_text_section' )
        ));

        /* loading text font size */
        $wp_customize->add_setting('pageloader_loading_text_font_size',array('sanitize_callback' => 'sanitize_pageloader_loading_text_font_size',));
        function sanitize_pageloader_loading_text_font_size($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_loading_text_font_size',array(
            'type' => 'text',
            'label' => 'Text font size (in pixels)',
            'description' => 'Font size for the loading text. If empty, will default to 14',
            'section' => 'pageloader_text_section',
        ));

        /* loading text letter spacing */
        $wp_customize->add_setting('pageloader_loading_text_letter_spacing',array('sanitize_callback' => 'sanitize_pageloader_loading_text_letter_spacing',));
        function sanitize_pageloader_loading_text_letter_spacing($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_loading_text_letter_spacing',array(
            'type' => 'text',
            'label' => 'Text letter spacing (in pixels)',
            'description' => 'If empty, will default to 0',
            'section' => 'pageloader_text_section',
        ));
        
        /* use theme font */
        $wp_customize->add_setting('pageloader_text_theme_font',array('default' => '','sanitize_callback' => 'sanitize_pageloader_text_theme_font',));
        function sanitize_pageloader_text_theme_font($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_text_theme_font',array('type' => 'text','label' => 'Advanced feature: Use theme font','description' => 'If you know the name of and would like to use one of your theme fonts, enter it in the textfield below as it appears in the theme stylesheet.','section' => 'pageloader_text_section',));
        
        //
        // ADD "Close Function" SECTION TO "PAGELOADER" PANEL 
        //
        $wp_customize->add_section('pageloader_close_function_section',array('title' => __( 'Close Function', 'pageloader' ),'panel' => 'pageloader_panel','priority' => 10));
        
        /* close function text */
        $wp_customize->add_setting('pageloader_custom_close_delay',array('sanitize_callback' => 'sanitize_pageloader_custom_close_delay',));
        function sanitize_pageloader_custom_close_delay($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_custom_close_delay',array(
            'type' => 'text',
            'label' => 'Close function delay (in milliseconds)',
            'description' => 'Example: 2000 or 3500 (2 and 3.5 seconds respectively). If empty, feature is disabled.',
            'section' => 'pageloader_close_function_section',
        ));
        
        /* close function text */
        $wp_customize->add_setting('pageloader_custom_close_text',array('sanitize_callback' => 'sanitize_pageloader_custom_close_text',));
        function sanitize_pageloader_custom_close_text($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_custom_close_text',array(
            'type' => 'text',
            'label' => 'Close function text',
            'description' => 'If empty, will default to "Taking too long? Close loading screen."',
            'section' => 'pageloader_close_function_section',
        ));
        
        /* close function color */
        $wp_customize->add_setting('pageloader_close_color', array( 'sanitize_callback' => 'sanitize_hex_color'));
        $wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize, 'pageloader_close_color',array(
            'label' => 'Close function text', 'settings' => 'pageloader_close_color', 'section' => 'pageloader_close_function_section')
        ));

        /* use theme font */
        $wp_customize->add_setting('pageloader_close_theme_font',array('default' => '','sanitize_callback' => 'sanitize_pageloader_close_theme_font',));
        function sanitize_pageloader_close_theme_font($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_close_theme_font',array('type' => 'text','label' => 'Advanced feature: Use theme font','description' => 'If you know the name of and would like to use one of your theme fonts, enter it in the textfield below as it appears in the theme stylesheet.','section' => 'pageloader_close_function_section',));

        //
        // ADD "Progress Bar" SECTION TO "PAGELOADER" PANEL 
        //
        $wp_customize->add_section('pageloader_progressbar_section',array('title' => __( 'Progress Bar', 'pageloader' ),'panel' => 'pageloader_panel','priority' => 10));
        
        /* disable progress bar */
        $wp_customize->add_setting('pageloader_progressbar_disable',array('sanitize_callback' => 'sanitize_pageloader_progressbar_disable',));
        function sanitize_pageloader_progressbar_disable( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_progressbar_disable',array('type' => 'checkbox','label' => 'Disable progress bar','section' => 'pageloader_progressbar_section',));
        
        /* disable progress bar on touch devices only */
        $wp_customize->add_setting('pageloader_progressbar_disable_touch',array('sanitize_callback' => 'sanitize_pageloader_progressbar_disable_touch',));
        function sanitize_pageloader_progressbar_disable_touch( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_progressbar_disable_touch',array('type' => 'checkbox','label' => 'Disable progress bar (on touch devices only)','description'=>'Due to some mobile browsers already having a built-in loading bar, you may wish to enable this option to hide the PageLoader bar on touch devices.','section' => 'pageloader_progressbar_section',));
        
        /* progress bar vertical position */
        $wp_customize->add_setting('pageloader_progressbar_vertical_position',array(
            'default' => 'top',
        ));
        $wp_customize->add_control('pageloader_progressbar_vertical_position',array(
            'type' => 'select',
            'label' => 'Progress bar vertical position',
            'section' => 'pageloader_progressbar_section',
            'choices' => array(
                'top' => 'Top',
                'middle' => 'Middle',
                'bottom' => 'Bottom',
        ),
        ));

        /* progress bar vertical fine-tune */
        $wp_customize->add_setting('pageloader_progressbar_vertical_position_finetune',array('sanitize_callback' => 'sanitize_pageloader_progressbar_vertical_position_finetune',));
        function sanitize_pageloader_progressbar_vertical_position_finetune($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_progressbar_vertical_position_finetune',array(
            'type' => 'text',
            'label' => 'Fine-tune progress bar vertical position (in pixels)',
            'description' => 'Negative values accepted. Example: 50 or -50',
            'section' => 'pageloader_progressbar_section',
        ));
        
        /* progress bar horizontal position */
        $wp_customize->add_setting('pageloader_progressbar_horizontal_position',array(
            'default' => 'center',
        ));
        $wp_customize->add_control('pageloader_progressbar_horizontal_position',array(
            'type' => 'select',
            'label' => 'Progress bar horizontal position',
            'section' => 'pageloader_progressbar_section',
            'choices' => array(
                'left' => 'Left',
                'center' => 'Center',
                'right' => 'Right',
        ),
        ));

        /* progress bar horizontal fine-tune */
        $wp_customize->add_setting('pageloader_progressbar_horizontal_position_finetune',array('sanitize_callback' => 'sanitize_pageloader_progressbar_horizontal_position_finetune',));
        function sanitize_pageloader_progressbar_horizontal_position_finetune($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_progressbar_horizontal_position_finetune',array(
            'type' => 'text',
            'label' => 'Fine-tune progress bar horizontal position (in pixels)',
            'description' => 'Negative values accepted. Example: 50 or -50',
            'section' => 'pageloader_progressbar_section',
        ));

        /* progress bar width */
        $wp_customize->add_setting('pageloader_progressbar_width',array('sanitize_callback' => 'sanitize_pageloader_progressbar_width',));
        function sanitize_pageloader_progressbar_width($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_progressbar_width',array(
            'type' => 'text',
            'label' => 'Progress bar width (in pixels)',
            'description' => 'Example: 500. If empty, defaults to full width.',
            'section' => 'pageloader_progressbar_section',
        ));
        
        /* progress bar height */
        $wp_customize->add_setting('pageloader_progressbar_height',array('sanitize_callback' => 'sanitize_pageloader_progressbar_height',));
        function sanitize_pageloader_progressbar_height($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_progressbar_height',array(
            'type' => 'text',
            'label' => 'Progress bar height (in pixels)',
            'description' => 'Example: 5 or 10. If empty, defaults to 3.',
            'section' => 'pageloader_progressbar_section',
        ));

        /* progress bar padding */
        $wp_customize->add_setting('pageloader_progressbar_padding',array('sanitize_callback' => 'sanitize_pageloader_progressbar_padding',));
        function sanitize_pageloader_progressbar_padding($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_progressbar_padding',array(
            'type' => 'text',
            'label' => 'Progress bar padding (in pixels)',
            'description' => 'Example: 10. If empty, defaults to 0.',
            'section' => 'pageloader_progressbar_section',
        ));

        /* progress bar color */
        $wp_customize->add_setting('pageloader_progressbar_color', array('sanitize_callback' => 'sanitize_hex_color' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pageloader_progressbar_color',array(
            'label' => 'Progress bar', 'settings' => 'pageloader_progressbar_color', 'section' => 'pageloader_progressbar_section' )
        ));
        
        /* progress bar gradient color */
        $wp_customize->add_setting('pageloader_progressbar_color_gradient', array('sanitize_callback' => 'sanitize_hex_color' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pageloader_progressbar_color_gradient',array(
            'label' => 'Progress bar gradient', 'description' => 'To add a gradient effect to the progress bar, pick a secondary color here.', 'settings' => 'pageloader_progressbar_color_gradient', 'section' => 'pageloader_progressbar_section' )
        ));
        
        /* progress bar background color */
        $wp_customize->add_setting('pageloader_progressbar_background_color', array('sanitize_callback' => 'sanitize_hex_color' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pageloader_progressbar_background_color',array(
            'label' => 'Progress bar background', 'settings' => 'pageloader_progressbar_background_color', 'section' => 'pageloader_progressbar_section' )
        ));

        /* progress bar corner roundness */
        $wp_customize->add_setting('pageloader_progressbar_corner',array('sanitize_callback' => 'sanitize_pageloader_progressbar_corner',));
        function sanitize_pageloader_progressbar_corner($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_progressbar_corner',array(
            'type' => 'text',
            'label' => 'Progress bar corner roundness (in pixels)',
            'description' => 'Example: 5 or 10. If empty, defaults to 0.',
            'section' => 'pageloader_progressbar_section',
        ));

        /* show progressbar only */
        $wp_customize->add_setting('pageloader_progressbar_only',array('sanitize_callback' => 'sanitize_pageloader_progressbar_only',));
        function sanitize_pageloader_progressbar_only( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_progressbar_only',array('type' => 'checkbox','label' => 'Show progress bar only','description' => 'If ticked, all other elements (the loading screen, icon/image etc.) will be hidden. Only the progress bar will be displayed.','section' => 'pageloader_progressbar_section',));
        
        /* show progressbar full screen */
        $wp_customize->add_setting('pageloader_progressbar_fullscreen',array('sanitize_callback' => 'sanitize_pageloader_progressbar_fullscreen',));
        function sanitize_pageloader_progressbar_fullscreen( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_progressbar_fullscreen',array('type' => 'checkbox','label' => 'Show progress bar full-screen','description' => 'If ticked, all other positioning settings will be ignored.','section' => 'pageloader_progressbar_section',));

        //
        // ADD "Background" SECTION TO "PAGELOADER" PANEL 
        //
        $wp_customize->add_section('pageloader_background_section',array('title' => __( 'Background', 'pageloader' ),'panel' => 'pageloader_panel','priority' => 10));
        
        /* background animation */
        $wp_customize->add_setting('pageloader_background_animation',array(
            'default' => 'fade',
        ));
        $wp_customize->add_control('pageloader_background_animation',array(
            'type' => 'select',
            'label' => 'Background animation',
            'section' => 'pageloader_background_section',
            'choices' => array(
                'fade' => 'Fade away',
                'top' => 'Slide Top',
                'left' => 'Slide Left',
                'right' => 'Slide Right',
                'bottom' => 'Slide Bottom',
        ),
        ));
        
        /* disappearance speed */
        $wp_customize->add_setting('pageloader_disappearance_speed',array('sanitize_callback' => 'sanitize_pageloader_disappearance_speed',));
        function sanitize_pageloader_disappearance_speed($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_disappearance_speed',array(
            'type' => 'text',
            'label' => 'Disappearance speed (in seconds)',
            'description' => 'The speed at which the loading screen disappears. Example: 0.75 or 2. If empty, defaults to 1.',
            'section' => 'pageloader_background_section',
        ));
        
        /* disappearance scaling */
        $wp_customize->add_setting('pageloader_background_scaling',array('sanitize_callback' => 'sanitize_pageloader_background_scaling',));
        function sanitize_pageloader_background_scaling($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_background_scaling',array(
            'type' => 'text',
            'label' => 'Disappearance scaling',
            'description' => 'The scale to which the loading screen disappears. Example: 0.75 or 1.25. If empty, defaults to 1 (no scaling).',
            'section' => 'pageloader_background_section',
        ));
        
        /* background color */
        $wp_customize->add_setting('pageloader_background_color', array('sanitize_callback' => 'sanitize_hex_color' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pageloader_background_color',array(
            'label' => 'Background color', 'settings' => 'pageloader_background_color', 'section' => 'pageloader_background_section' )
        ));

        /* background color (secondary) */
        $wp_customize->add_setting('pageloader_background_color_secondary', array('sanitize_callback' => 'sanitize_hex_color' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pageloader_background_color_secondary',array(
            'label' => 'Background color (secondary)', 'description' => 'When secondary color chosen, background will fade between the two colors.', 'settings' => 'pageloader_background_color_secondary', 'section' => 'pageloader_background_section' )
        ));

        /* background color fade speed */
        $wp_customize->add_setting('pageloader_background_color_fade_speed',array('sanitize_callback' => 'sanitize_pageloader_background_color_fade_speed',));
        function sanitize_pageloader_background_color_fade_speed($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_background_color_fade_speed',array(
            'type' => 'text',
            'label' => 'Background color fade speed (in seconds)',
            'description' => 'Example: 1.5 or 5. If empty, defaults to 3.',
            'section' => 'pageloader_background_section',
        ));
        
        /* background opacity */
        $wp_customize->add_setting('pageloader_background_opacity',array('sanitize_callback' => 'sanitize_pageloader_background_opacity',));
        function sanitize_pageloader_background_opacity($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_background_opacity',array(
            'type' => 'text',
            'label' => 'Background opacity (from 0-1)',
            'description' => 'Example: 0.25 or 0.5. If empty, defaults to 1.',
            'section' => 'pageloader_background_section',
        ));
        
        /* background image */
        $wp_customize->add_setting('pageloader_background_image');
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'pageloader_background_image',
            array(
                'label' => 'Background image',
                'section' => 'pageloader_background_section',
                'settings' => 'pageloader_background_image'
        )
        ));
        
        /* background as cover */
        $wp_customize->add_setting('pageloader_background_cover',array('sanitize_callback' => 'sanitize_pageloader_background_cover',));
        function sanitize_pageloader_background_cover( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_background_cover',array('type' => 'checkbox','label' => 'Show background image in full screen','section' => 'pageloader_background_section',));
        
        /* background image opacity */
        $wp_customize->add_setting('pageloader_background_image_opacity',array('sanitize_callback' => 'sanitize_pageloader_background_image_opacity',));
        function sanitize_pageloader_background_image_opacity($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_background_image_opacity',array(
            'type' => 'text',
            'label' => 'Background image opacity (from 0-1)',
            'description' => 'Example: 0.4 or 0.95. If empty, defaults to .2.',
            'section' => 'pageloader_background_section',
        ));
        
        //
        // ADD "Content Slide-in" SECTION TO "PAGELOADER" PANEL 
        //
        $wp_customize->add_section('pageloader_slidein_section',array('title' => __( 'Content Slide-in, Scaling', 'pageloader' ),'description' => __( 'Note: This feature might cause styling conflicts with some themes/plugins, for example ones that override default browser behavior or ones that already have their own content animations.' ),'panel' => 'pageloader_panel','priority' => 10));
        
        /* slide-in content */
        $wp_customize->add_setting('pageloader_slidein_content',array('sanitize_callback' => 'sanitize_pageloader_slidein_content',));
        function sanitize_pageloader_slidein_content( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_slidein_content',array('type' => 'checkbox','label' => 'Content animation','description' => 'Enables content animation as loading screen closes.','section' => 'pageloader_slidein_section',));
        
        /* custom elements */
        $wp_customize->add_setting('pageloader_slidein_custom_elements',array('sanitize_callback' => 'sanitize_pageloader_slidein_custom_elements',));
        function sanitize_pageloader_slidein_custom_elements($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_slidein_custom_elements',array(
            'type' => 'text',
            'label' => 'Only target specific elements',
            'description' => 'By default, PageLoader will attempt to apply animation to your entire site body. If you find some elements acting up though, or if you want to apply animation only to specific elements, then use this text field to target those elements. Separate classes/IDs by comma.',
            'section' => 'pageloader_slidein_section',
        ));
        
        /* content animation speed */
        $wp_customize->add_setting('pageloader_slidein_speed',array('sanitize_callback' => 'sanitize_pageloader_slidein_speed',));
        function sanitize_pageloader_slidein_speed($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_slidein_speed',array(
            'type' => 'text',
            'label' => 'Animation speed (in seconds)',
            'description' => 'Example: 0.75 or 2. If empty, defaults to 1.',
            'section' => 'pageloader_slidein_section',
        ));
        
        /* slide-in distance */
        $wp_customize->add_setting('pageloader_slidein_distance',array('sanitize_callback' => 'sanitize_pageloader_slidein_distance',));
        function sanitize_pageloader_slidein_distance($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_slidein_distance',array(
            'type' => 'text',
            'label' => 'Slide-in distance (in pixels)',
            'description' => 'Example: 50 or -250 (enter negative value to slide-in from the top). If empty, defaults to -100.',
            'section' => 'pageloader_slidein_section',
        ));
        
        /* content scaling */
        $wp_customize->add_setting('pageloader_content_scaling',array('sanitize_callback' => 'sanitize_pageloader_content_scaling',));
        function sanitize_pageloader_content_scaling($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_content_scaling',array(
            'type' => 'text',
            'label' => 'Content scaling',
            'description' => 'Example: 0.95 or 1.25. If empty, defaults to 1 (no scaling).',
            'section' => 'pageloader_slidein_section',
        ));
        
        /* content opacity */
        $wp_customize->add_setting('pageloader_content_opacity',array('sanitize_callback' => 'sanitize_pageloader_content_opacity',));
        function sanitize_pageloader_content_opacity($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_content_opacity',array(
            'type' => 'text',
            'label' => 'Content opacity (0-1)',
            'description' => 'Example: 0.5. If empty, defaults to 1.',
            'section' => 'pageloader_slidein_section',
        ));
        
        //
        // ADD "Misc." SECTION TO "PAGELOADER" PANEL 
        //
        $wp_customize->add_section('pageloader_misc_section',array('title' => __( 'Misc.', 'pageloader' ),'panel' => 'pageloader_panel','priority' => 10));
        
        /* show on mobile only */
        $wp_customize->add_setting('pageloader_mobile_only',array('sanitize_callback' => 'sanitize_pageloader_mobile_only',));
        function sanitize_pageloader_mobile_only( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_mobile_only',array('type' => 'checkbox','label' => 'Show on touch devices only','description' => 'The loading screen will be shown on touch devices only.','section' => 'pageloader_misc_section',));
        
        /* show on front page only */
        $wp_customize->add_setting('pageloader_front_page_only',array('sanitize_callback' => 'sanitize_pageloader_front_page_only',));
        function sanitize_pageloader_front_page_only( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_front_page_only',array('type' => 'checkbox','label' => 'Show on front page only','description' => 'The loading screen will be shown on the front page only.','section' => 'pageloader_misc_section',));
        
        /* show once per browser session */
        $wp_customize->add_setting('pageloader_browser_session',array('sanitize_callback' => 'sanitize_pageloader_browser_session',));
        function sanitize_pageloader_browser_session( $input ) {if ( $input === true ) {return 1;} else {return '';}}
        $wp_customize->add_control('pageloader_browser_session',array('type' => 'checkbox','label' => 'Show once per session','description' => 'The loading screen is shown only once per visitor browser session.','section' => 'pageloader_misc_section',));
        
        /* loading elements slide-in*/
        $wp_customize->add_setting('pageloader_elements_slidein',array('sanitize_callback' => 'sanitize_pageloader_elements_slidein',));
        function sanitize_pageloader_elements_slidein( $input ) {if ( $input === true ) {return 1;} else {return '';}}
        $wp_customize->add_control('pageloader_elements_slidein',array('type' => 'checkbox','label' => 'Loading elements slide-in','description' => 'When enabled, the loading icon/image and other loading elements have a brief slide-in animation.','section' => 'pageloader_misc_section',));
        
        /* unload GFont */
        $wp_customize->add_setting('pageloader_unload_gfont',array('sanitize_callback' => 'sanitize_pageloader_unload_gfont',));
        function sanitize_pageloader_unload_gfont( $input ) { if ( $input === true ) { return 1; } else { return ''; } }
        $wp_customize->add_control('pageloader_unload_gfont',array('type' => 'checkbox','label' => 'Unload GoogleFont','description' => 'Useful when not making use of the loading or close function text features, or when using the theme font feature.','section' => 'pageloader_misc_section',));

        /* custom delay */
        $wp_customize->add_setting('pageloader_custom_delay',array('sanitize_callback' => 'sanitize_pageloader_custom_delay',));
        function sanitize_pageloader_custom_delay($input) {return wp_kses_post(force_balance_tags($input));}
        $wp_customize->add_control('pageloader_custom_delay',array(
            'type' => 'text',
            'label' => 'Custom delay (in milliseconds)',
            'description' => 'Upon load completion, the loading screen will remain visible for the specified amount of time. Example: 500 or 1500 (0.5 and 1.5 seconds respectively).',
            'section' => 'pageloader_misc_section',
        ));

    }
    add_action('customize_register', 'pageloader_theme_customizer');
    
    //
	// Once per session option
	//
    if( get_theme_mod('pageloader_browser_session', '') !== '') {
        add_action('init', 'pageloader_register_session');
        function pageloader_register_session() {
            if( !session_id() ) {
                session_start();
            }
        }
    }

	//
	// Insert PageLoader into the header
	//
	function bonfire_pageloader_header() {

        if (!isset($_SESSION['pageloader_session'])) { $_SESSION['pageloader_session'] = '0';
            if( get_theme_mod('pageloader_front_page_only', '') !== '') {
                if( is_front_page() || is_home() ) {
                    if( get_theme_mod('pageloader_mobile_only', '') !== '') {
                        if ( wp_is_mobile() ) {
                            include( plugin_dir_path( __FILE__ ) . 'include.php');
                        }
                    } else {
                        include( plugin_dir_path( __FILE__ ) . 'include.php');
                    }
                }
            } else {
                // BEGIN GET POST ID (FOR PER-POST/PAGE PageLoader HIDE)
                global $post;
                $bonfire_pageloader_display = get_post_meta($post->ID, 'bonfire_pageloader_display', true);
                //END GET POST ID (FOR PER-POST/PAGE PageLoader HIDE)
                
                if( get_theme_mod('pageloader_mobile_only', '') !== '') {
                    if ( wp_is_mobile() ) {
                        include( plugin_dir_path( __FILE__ ) . 'include.php');
                    }
                } else {
                    include( plugin_dir_path( __FILE__ ) . 'include.php');
                }
            }
        } $_SESSION['pageloader_session']++;
	
	}
	add_action('wp_head','bonfire_pageloader_header');

    //
	// ENQUEUE Google WebFonts
	//
    if( get_theme_mod('pageloader_unload_gfont', '') === '') {
        function pageloader_fonts_url() {
            $font_url = '';

            if ( 'off' !== _x( 'on', 'Google font: on or off', 'pageloader' ) ) {
                $font_url = add_query_arg( 'family', urlencode( 'Muli:700' ), "//fonts.googleapis.com/css" );
            }
            return $font_url;
        }
        function pageloader_scripts() {
            if (!isset($_SESSION['pageloader_session_gfont'])) { $_SESSION['pageloader_session_gfont'] = '0';
                wp_enqueue_style( 'pageloader-fonts', pageloader_fonts_url(), array(), '1.0.0' );
            } $_SESSION['pageloader_session_gfont']++;
        }
        add_action( 'wp_enqueue_scripts', 'pageloader_scripts' );
    }


	//
	// ENQUEUE pageloader.css (only when loading screen visible)
	//   
	function bonfire_pageloader_css() {
        if (!isset($_SESSION['pageloader_session_css'])) { $_SESSION['pageloader_session_css'] = '0';
            if( get_theme_mod('pageloader_front_page_only', '') !== '') {
                if( is_front_page() || is_home() ) {
                    if( get_theme_mod('pageloader_mobile_only', '') !== '') {
                        if ( wp_is_mobile() ) {
                            wp_register_style( 'bonfire-pageloader-css', plugins_url( '/pageloader.css', __FILE__ ) . '', array(), '1', 'all' );
                            wp_enqueue_style( 'bonfire-pageloader-css' );
                        }
                    } else {
                        wp_register_style( 'bonfire-pageloader-css', plugins_url( '/pageloader.css', __FILE__ ) . '', array(), '1', 'all' );
                        wp_enqueue_style( 'bonfire-pageloader-css' );
                    }
                }
            } else {
                // BEGIN GET POST ID (FOR PER-POST/PAGE PageLoader HIDE)
                global $post;
                $bonfire_pageloader_display = get_post_meta($post->ID, 'bonfire_pageloader_display', true);
                //END GET POST ID (FOR PER-POST/PAGE PageLoader HIDE)
                
                if( get_theme_mod('pageloader_mobile_only', '') !== '') {
                    if ( wp_is_mobile() ) {
                        wp_register_style( 'bonfire-pageloader-css', plugins_url( '/pageloader.css', __FILE__ ) . '', array(), '1', 'all' );
                        wp_enqueue_style( 'bonfire-pageloader-css' );
                    }
                } else {
                    wp_register_style( 'bonfire-pageloader-css', plugins_url( '/pageloader.css', __FILE__ ) . '', array(), '1', 'all' );
                    wp_enqueue_style( 'bonfire-pageloader-css' );
                }
            }
        } $_SESSION['pageloader_session_css']++;
	}
	add_action( 'wp_enqueue_scripts', 'bonfire_pageloader_css' );


	//
	// ENQUEUE pageloader.js (only when loading screen visible)
	//
	function bonfire_pageloader_js() {
        if (!isset($_SESSION['pageloader_session_js'])) { $_SESSION['pageloader_session_js'] = '0';
            if( get_theme_mod('pageloader_front_page_only', '') !== '') {
                if( is_front_page() || is_home() ) {
                    if( get_theme_mod('pageloader_mobile_only', '') !== '') {
                        if ( wp_is_mobile() ) {
                            wp_register_script( 'bonfire-pageloader-js', plugins_url( '/pageloader.js', __FILE__ ) . '', array( 'jquery' ), '1' );  
                            wp_enqueue_script( 'bonfire-pageloader-js' );
                        }
                    } else {
                        wp_register_script( 'bonfire-pageloader-js', plugins_url( '/pageloader.js', __FILE__ ) . '', array( 'jquery' ), '1' );  
                        wp_enqueue_script( 'bonfire-pageloader-js' );
                    }
                }
            } else {
                // BEGIN GET POST ID (FOR PER-POST/PAGE PageLoader HIDE)
                global $post;
                $bonfire_pageloader_display = get_post_meta($post->ID, 'bonfire_pageloader_display', true);
                //END GET POST ID (FOR PER-POST/PAGE PageLoader HIDE)
                
                if( get_theme_mod('pageloader_mobile_only', '') !== '') {
                    if ( wp_is_mobile() ) {
                        wp_register_script( 'bonfire-pageloader-js', plugins_url( '/pageloader.js', __FILE__ ) . '', array( 'jquery' ), '1' );  
                        wp_enqueue_script( 'bonfire-pageloader-js' );
                    }
                } else {
                    wp_register_script( 'bonfire-pageloader-js', plugins_url( '/pageloader.js', __FILE__ ) . '', array( 'jquery' ), '1' );  
                    wp_enqueue_script( 'bonfire-pageloader-js' );
                }
            }
        } $_SESSION['pageloader_session_js']++;
	}
	add_action( 'wp_enqueue_scripts', 'bonfire_pageloader_js' );

    //
	// Allow Shortcodes in Text Widget
	//
	add_filter('widget_text', 'do_shortcode');
	
	//
	// Register Widgets
	//
	function bonfire_pageloader_widgets_init() {

		register_sidebar( array(
		'name' => __( 'PageLoader Widgets', 'bonfire' ),
		'id' => 'pageloader-widgets',
		'description' => __( 'Drag widgets here', 'bonfire' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
		));

	}
	add_action( 'widgets_init', 'bonfire_pageloader_widgets_init' );
    
	//
	// Insert theme customizer options into the header
	//
	function bonfire_pageloader_header_customize() {
	?>
    
    <?php if (!isset($_SESSION['pageloader_session_customizer'])) { $_SESSION['pageloader_session_customizer'] = '0'; ?>

		<style>
        /* loading elements slide-in */
        <?php if( get_theme_mod('pageloader_elements_slidein', '') !== '') { ?>
        .pageloader-image-wrapper,
        .pageloader-icon-wrapper,
        .pageloader-sentence-wrapper {
            animation-name:loading-elements-slide-in;
            animation-duration:1s;
        }
        <?php } ?>
        /* icon position */
        .pageloader-icon-inner {
            vertical-align:<?php if( get_theme_mod('pageloader_icon_vertical_position', '') === '') { ?>middle<?php } ?><?php $bonfire_pageloader_icon_vertical_position = get_theme_mod('pageloader_icon_vertical_position'); if($bonfire_pageloader_icon_vertical_position !== '') { switch ($bonfire_pageloader_icon_vertical_position) { ?><?php case 'top': ?>top<?php break; case 'middle': ?>middle<?php break; case 'bottom': ?>bottom<?php break; } } ?>;
            text-align:<?php if( get_theme_mod('pageloader_icon_horizontal_position', '') === '') { ?>center<?php } ?><?php $bonfire_pageloader_icon_horizontal_position = get_theme_mod('pageloader_icon_horizontal_position'); if($bonfire_pageloader_icon_horizontal_position !== '') { switch ($bonfire_pageloader_icon_horizontal_position) { ?><?php case 'left': ?>left<?php break; case 'center': ?>center<?php break; case 'right': ?>right<?php break; } } ?>;
        }
        .pageloader-icon {
            top:<?php echo get_theme_mod('pageloader_icon_vertical_position_finetune'); ?>px;
            left:<?php echo get_theme_mod('pageloader_icon_horizontal_position_finetune'); ?>px;
        }
        /* image position */
        .pageloader-image-inner {
            vertical-align:<?php if( get_theme_mod('pageloader_image_vertical_position', '') === '') { ?>middle<?php } ?><?php $bonfire_pageloader_image_vertical_position = get_theme_mod('pageloader_image_vertical_position'); if($bonfire_pageloader_image_vertical_position !== '') { switch ($bonfire_pageloader_image_vertical_position) { ?><?php case 'top': ?>top<?php break; case 'middle': ?>middle<?php break; case 'bottom': ?>bottom<?php break; } } ?>;
            text-align:<?php if( get_theme_mod('pageloader_image_horizontal_position', '') === '') { ?>center<?php } ?><?php $bonfire_pageloader_image_horizontal_position = get_theme_mod('pageloader_image_horizontal_position'); if($bonfire_pageloader_image_horizontal_position !== '') { switch ($bonfire_pageloader_image_horizontal_position) { ?><?php case 'left': ?>left<?php break; case 'center': ?>center<?php break; case 'right': ?>right<?php break; } } ?>;
        }
        .pageloader-image {
            top:<?php echo get_theme_mod('pageloader_image_vertical_position_finetune'); ?>px;
            left:<?php echo get_theme_mod('pageloader_image_horizontal_position_finetune'); ?>px;
        }
        /* loading text position */
        .pageloader-sentence-inner {
            vertical-align:<?php if( get_theme_mod('pageloader_loading_text_vertical_position', '') === '') { ?>middle<?php } ?><?php $bonfire_pageloader_loading_text_vertical_position = get_theme_mod('pageloader_loading_text_vertical_position'); if($bonfire_pageloader_loading_text_vertical_position !== '') { switch ($bonfire_pageloader_loading_text_vertical_position) { ?><?php case 'top': ?>top<?php break; case 'middle': ?>middle<?php break; case 'bottom': ?>bottom<?php break; } } ?>;
            text-align:<?php if( get_theme_mod('pageloader_loading_text_horizontal_position', '') === '') { ?>center<?php } ?><?php $bonfire_pageloader_loading_text_horizontal_position = get_theme_mod('pageloader_loading_text_horizontal_position'); if($bonfire_pageloader_loading_text_horizontal_position !== '') { switch ($bonfire_pageloader_loading_text_horizontal_position) { ?><?php case 'left': ?>left<?php break; case 'center': ?>center<?php break; case 'right': ?>right<?php break; } } ?>;
        }
        .pageloader-sentence {
            top:<?php echo get_theme_mod('pageloader_loading_text_vertical_position_finetune'); ?>px;
            left:<?php echo get_theme_mod('pageloader_loading_text_horizontal_position_finetune'); ?>px;
        }
        /* image size */
        .pageloader-image img {
            width:<?php echo get_theme_mod('pageloader_custom_loading_image_size'); ?>px;
        }
        /* image pulsating animation */
        .pageloader-image {
            animation:pulsateAnimation <?php echo get_theme_mod('pageloader_custom_loading_image_pulsate'); ?>s infinite;
            -moz-animation:pulsateAnimation <?php echo get_theme_mod('pageloader_custom_loading_image_pulsate'); ?>s infinite;
            -webkit-animation:pulsateAnimation <?php echo get_theme_mod('pageloader_custom_loading_image_pulsate'); ?>s infinite;
        }
		/* background and icon color + background opacity */
		.bonfire-pageloader-background {
            background-color:<?php echo get_theme_mod('pageloader_background_color'); ?>;
            opacity:<?php echo get_theme_mod('pageloader_background_opacity'); ?>;
        }

        /* secondary background color + fade between background colors */
        <?php if( get_theme_mod('pageloader_background_color_secondary', '') !== '') { ?>
            .bonfire-pageloader-background {
                animation:plbganimation <?php if( get_theme_mod('pageloader_background_color_fade_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_color_fade_speed'); ?><?php } else { ?>3<?php } ?>s infinite;
                -moz-animation:plbganimation <?php if( get_theme_mod('pageloader_background_color_fade_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_color_fade_speed'); ?><?php } else { ?>3<?php } ?>s infinite;
                -webkit-animation:plbganimation <?php if( get_theme_mod('pageloader_background_color_fade_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_color_fade_speed'); ?><?php } else { ?>3<?php } ?>s infinite;
            }
            @-moz-keyframes plbganimation {
                0% {background:<?php if( get_theme_mod('pageloader_background_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_color'); ?><?php } else { ?>#1FB6DB<?php } ?>;}
                50% {background:<?php echo get_theme_mod('pageloader_background_color_secondary'); ?>;}
                100% {background:<?php if( get_theme_mod('pageloader_background_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_color'); ?><?php } else { ?>#1FB6DB<?php } ?>;}
            }
            @-webkit-keyframes plbganimation {
                0% {background:<?php if( get_theme_mod('pageloader_background_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_color'); ?><?php } else { ?>#1FB6DB<?php } ?>;}
                50% {background:<?php echo get_theme_mod('pageloader_background_color_secondary'); ?>;}
                100% {background:<?php if( get_theme_mod('pageloader_background_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_color'); ?><?php } else { ?>#1FB6DB<?php } ?>;}
            }
        <?php } ?>

        .bonfire-pageloader-background-image { opacity:<?php echo get_theme_mod('pageloader_background_image_opacity'); ?>; }
        
        /* icon animation speed */
        .loader1 rect,
        .loader2 svg circle:first-of-type,
        .loader2 svg circle:last-of-type,
        .loader3 svg rect,
        .loader4 svg,
        .loader5 svg circle,
        .loader6 circle:first-of-type,
        .loader6 circle:nth-child(2),
        .loader6 circle:nth-child(3),
        .loader7 svg,
        .loader8 svg,
        .loader9 svg,
        .loader9 svg circle:nth-of-type(2),
        .loader9 svg circle:nth-of-type(3),
        .loader10 svg,
        .loader10 svg circle:first-of-type,
        .loader10 svg circle:nth-of-type(2),
        .loader10 svg circle:nth-of-type(3),
        .loader10 svg circle:last-of-type {
            animation-duration:<?php echo get_theme_mod('pageloader_icon_animation_speed'); ?>s;
        }
        /* icon scaling */
        .pageloader-icon {
            -webkit-transform:scale(<?php echo get_theme_mod('pageloader_icon_scaling'); ?>);
            -moz-transform:scale(<?php echo get_theme_mod('pageloader_icon_scaling'); ?>);
            transform:scale(<?php echo get_theme_mod('pageloader_icon_scaling'); ?>);
        }
        /* primary icon color */
		.loader1 svg,
        .loader2 circle:nth-child(2),
        .loader3 rect,
        .loader4 path,
        .loader6 circle,
        .loader7 path:nth-child(2),
        .loader8 circle,
        .loader9 svg,
        .loader10 svg {
            fill:<?php echo get_theme_mod('pageloader_icon_color'); ?>;
        }
        .loader5 circle {
            stroke:<?php echo get_theme_mod('pageloader_icon_color'); ?>;
        }
        @keyframes loader6dot1 {
            0% { transform:scale(1); fill:<?php if( get_theme_mod('pageloader_secondary_icon_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_secondary_icon_color'); ?><?php } else { ?>#2A2A2A<?php } ?>; }
            16% { transform:scale(1.5); fill:<?php if( get_theme_mod('pageloader_icon_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_icon_color'); ?><?php } else { ?>#9AA366<?php } ?>; }
            70%, 100% { transform:scale(1); fill:<?php if( get_theme_mod('pageloader_secondary_icon_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_secondary_icon_color'); ?><?php } else { ?>#2A2A2A<?php } ?>; }
        }
        @keyframes loader6dot2 {
            0%, 30% { transform:scale(1); fill:<?php if( get_theme_mod('pageloader_secondary_icon_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_secondary_icon_color'); ?><?php } else { ?>#2A2A2A<?php } ?>; }
            47% { transform:scale(1.5); fill:<?php if( get_theme_mod('pageloader_icon_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_icon_color'); ?><?php } else { ?>#9AA366<?php } ?>; }
            75%, 100% { transform:scale(1); fill:<?php if( get_theme_mod('pageloader_secondary_icon_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_secondary_icon_color'); ?><?php } else { ?>#2A2A2A<?php } ?>; }
        }
        @keyframes loader6dot3 {
            0%, 47% { transform:scale(1); fill:<?php if( get_theme_mod('pageloader_secondary_icon_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_secondary_icon_color'); ?><?php } else { ?>#2A2A2A<?php } ?>; }
            83% { transform:scale(1.5); fill:<?php if( get_theme_mod('pageloader_icon_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_icon_color'); ?><?php } else { ?>#9AA366<?php } ?>; }
            100% { transform:scale(1); fill:<?php if( get_theme_mod('pageloader_secondary_icon_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_secondary_icon_color'); ?><?php } else { ?>#2A2A2A<?php } ?>; }
        }
        /* secondary icon color */
		.loader2 circle:first-child,
        .loader3 circle,
        .loader7 path:first-child,
        .loader8 path {
            fill:<?php echo get_theme_mod('pageloader_secondary_icon_color'); ?>;
        }
        /* loading sentence */
		.pageloader-sentence {
            font-size:<?php echo get_theme_mod('pageloader_loading_text_font_size'); ?>px;
            letter-spacing:<?php echo get_theme_mod('pageloader_loading_text_letter_spacing'); ?>px;
            color:<?php echo get_theme_mod('pageloader_text_color'); ?>;
            font-family:<?php echo get_theme_mod('pageloader_text_theme_font'); ?>;
        }
        /* close function */
        .pageloader-close {
            color:<?php echo get_theme_mod('pageloader_close_color'); ?>;
            font-family:<?php echo get_theme_mod('pageloader_close_theme_font'); ?>;
        }
        /* progress bar */
        #nprogress-wrapper {
            padding:<?php echo get_theme_mod('pageloader_progressbar_padding'); ?>px;
        }
        #nprogress-inner {
            vertical-align:<?php if( get_theme_mod('pageloader_progressbar_vertical_position', '') === '') { ?>top<?php } ?><?php $bonfire_pageloader_progressbar_vertical_position = get_theme_mod('pageloader_progressbar_vertical_position'); if($bonfire_pageloader_progressbar_vertical_position !== '') { switch ($bonfire_pageloader_progressbar_vertical_position) { ?><?php case 'top': ?>top<?php break; case 'middle': ?>middle<?php break; case 'bottom': ?>bottom<?php break; } } ?>;
            text-align:<?php if( get_theme_mod('pageloader_progressbar_horizontal_position', '') === '') { ?>center<?php } ?><?php $bonfire_pageloader_progressbar_horizontal_position = get_theme_mod('pageloader_progressbar_horizontal_position'); if($bonfire_pageloader_progressbar_horizontal_position !== '') { switch ($bonfire_pageloader_progressbar_horizontal_position) { ?><?php case 'left': ?>left<?php break; case 'center': ?>center<?php break; case 'right': ?>right<?php break; } } ?>;
        }
        #nprogress {
            <?php if( get_theme_mod('pageloader_progressbar_fullscreen', '') !== '') { ?>
                top:0;
                left:0;
                vertical-align:top;
                max-width:100%;
                height:100%;
                height:100vh;
            <?php } else { ?>
                top:<?php echo get_theme_mod('pageloader_progressbar_vertical_position_finetune'); ?>px;
                left:<?php echo get_theme_mod('pageloader_progressbar_horizontal_position_finetune'); ?>px;
                vertical-align:<?php if( get_theme_mod('pageloader_progressbar_vertical_position', '') === 'bottom') { ?>bottom<?php } else { ?>top<?php } ?>;
                max-width:<?php if( get_theme_mod('pageloader_progressbar_width', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_width'); ?>px<?php } else { ?>100%<?php } ?>;
                height:<?php if( get_theme_mod('pageloader_progressbar_height', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_height'); ?><?php } else { ?>3<?php } ?>px;
            <?php } ?>
            background-color:<?php echo get_theme_mod('pageloader_progressbar_background_color'); ?>;
        }
        /* progress bar border radius */
        #nprogress,
        #nprogress .bar {
            border-radius:<?php echo get_theme_mod('pageloader_progressbar_corner'); ?>px;
        }
        /* progress bar colors (regular and gradient) */
        #nprogress .bar {
            background:<?php if( get_theme_mod('pageloader_progressbar_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } else { ?>#4B6A87<?php } ?>;
            background:-moz-linear-gradient(left, <?php if( get_theme_mod('pageloader_progressbar_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } else { ?>#4B6A87<?php } ?> 0%, <?php if( get_theme_mod('pageloader_progressbar_color_gradient', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color_gradient'); ?><?php } else { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } ?> 100%);
            background:-webkit-gradient(left top, right top, color-stop(0%, <?php if( get_theme_mod('pageloader_progressbar_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } else { ?>#4B6A87<?php } ?>), color-stop(100%, <?php if( get_theme_mod('pageloader_progressbar_color_gradient', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color_gradient'); ?><?php } else { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } ?>));
            background:-webkit-linear-gradient(left, <?php if( get_theme_mod('pageloader_progressbar_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } else { ?>#4B6A87<?php } ?> 0%, <?php if( get_theme_mod('pageloader_progressbar_color_gradient', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color_gradient'); ?><?php } else { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } ?> 100%);
            background:-o-linear-gradient(left, <?php if( get_theme_mod('pageloader_progressbar_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } else { ?>#4B6A87<?php } ?> 0%, <?php if( get_theme_mod('pageloader_progressbar_color_gradient', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color_gradient'); ?><?php } else { ?>#4B6A87<?php } ?> 100%);
            background:-ms-linear-gradient(left, <?php if( get_theme_mod('pageloader_progressbar_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } else { ?>#4B6A87<?php } ?> 0%, <?php if( get_theme_mod('pageloader_progressbar_color_gradient', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color_gradient'); ?><?php } else { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } ?> 100%);
            background:linear-gradient(to right, <?php if( get_theme_mod('pageloader_progressbar_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } else { ?>#4B6A87<?php } ?> 0%, <?php if( get_theme_mod('pageloader_progressbar_color_gradient', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color_gradient'); ?><?php } else { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } ?> 100%);
            filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php if( get_theme_mod('pageloader_progressbar_color', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } else { ?>#4B6A87<?php } ?>', endColorstr='<?php if( get_theme_mod('pageloader_progressbar_color_gradient', '') !== '') { ?><?php echo get_theme_mod('pageloader_progressbar_color_gradient'); ?><?php } else { ?><?php echo get_theme_mod('pageloader_progressbar_color'); ?><?php } ?>', GradientType=1 );
        }
        /* hide nProgress if PageLoader disabled (singular) */
        <?php if(is_singular() ) { ?>
        <?php $meta_value = get_post_meta( get_the_ID(), 'bonfire_pageloader_display', true ); if( !empty( $meta_value ) ) { ?>
        #nprogress { display:none !important; }
        <?php } ?>
        <?php } ?>
		</style>
		<!-- END CUSTOM COLORS (WP THEME CUSTOMIZER) -->
	
    <?php } $_SESSION['pageloader_session_customizer']++; ?>
    
	<?php
	}
	add_action('wp_head','bonfire_pageloader_header_customize');
    
    //
	// Add 'Settings' link to plugin page
	//
    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );
    function add_action_links ( $links ) {
        $mylinks = array(
        '<a href="' . admin_url( 'customize.php?autofocus[panel]=pageloader_panel' ) . '">Settings</a>',
        );
    return array_merge( $links, $mylinks );
    }

	///////////////////////////////////////
	// Yes/No drop-down selector on 'write post/page' pages
	///////////////////////////////////////
	add_action( 'add_meta_boxes', 'bonfire_pageloader_custom_class_add' );
	function bonfire_pageloader_custom_class_add() {
		add_meta_box( 'bonfire-pageloader-meta-box-id', __( 'Show PageLoader loading screen on this post?', 'bonfire' ), 'bonfire_pageloader_custom_class', 'post', 'normal', 'high' );
		add_meta_box( 'bonfire-pageloader-meta-box-id', __( 'Show PageLoader loading screen on this page?', 'bonfire' ), 'bonfire_pageloader_custom_class', 'page', 'normal', 'high' );
	}

	function bonfire_pageloader_custom_class( $post ) {
		$values = get_post_custom( $post->ID );
		$bonfire_pageloader_selected_class = isset( $values['bonfire_pageloader_display'] ) ? esc_attr( $values['bonfire_pageloader_display'][0] ) : '';
		?>		
		<p>
			<select name="bonfire_pageloader_display">
				<option value="" <?php selected( $bonfire_pageloader_selected_class, 'yes' ); ?>>Yes</option>
				<!-- You can add and remove options starting from here -->				
				<option value="pageloader-hide" <?php selected( $bonfire_pageloader_selected_class, 'pageloader-hide' ); ?>>No</option>
				<!-- Options end here -->	
			</select>		
		</p>
		<?php	
	}

	add_action( 'save_post', 'bonfire_pageloader_custom_class_save' );
	function bonfire_pageloader_custom_class_save( $post_id ) {
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if( !current_user_can( 'edit_post' ) ) {
			return;
		}
			
		if( isset( $_POST['bonfire_pageloader_display'] ) ) {
			update_post_meta( $post_id, 'bonfire_pageloader_display', esc_attr( $_POST['bonfire_pageloader_display'] ) );
		}
	}

?>