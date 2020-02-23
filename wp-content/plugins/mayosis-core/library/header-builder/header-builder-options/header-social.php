<?php

Mayosis_Option::add_section( 'follow', array(
	'title'       => __( 'Social', 'mayosis' ),
	'panel'       => 'header',
) );

Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'facebook_enable',
	'label'       => esc_html__( 'Enable Facebook', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '1',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
    Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'twitter_enable',
	'label'       => esc_html__( 'Enable Twitter', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '1',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
      Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'instagram_enable',
	'label'       => esc_html__( 'Enable Instagram', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '1',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
    Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'pinterest_enable',
	'label'       => esc_html__( 'Enable Pinterest', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '1',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
    Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'youtube_enable',
	'label'       => esc_html__( 'Enable Youtube', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '1',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
    Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'linkedin_enable',
	'label'       => esc_html__( 'Enable Linked In', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '2',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
     Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'github_enable',
	'label'       => esc_html__( 'Enable Github', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '2',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
    Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'slack_enable',
	'label'       => esc_html__( 'Enable Slack', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '2',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
    Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'envato_enable',
	'label'       => esc_html__( 'Enable Envato', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '2',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
    Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'behance_enable',
	'label'       => esc_html__( 'Enable Behance', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '2',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
    Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'dribbble_enable',
	'label'       => esc_html__( 'Enable Dribbble', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '2',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
     Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'vimeo_enable',
	'label'       => esc_html__( 'Enable Vimeo', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '2',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));
    
    Mayosis_Option::add_field( 'mayo_config',  array(
    'type'        => 'switch',
	'settings'    => 'spotify_enable',
	'label'       => esc_html__( 'Enable Spotify', 'mayosis' ),
	'section'     => 'follow',
	'default'     => '2',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'mayosis' ),
		'off' => esc_html__( 'Disable', 'mayosis' ),
	],
    
    ));