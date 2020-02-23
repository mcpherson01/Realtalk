<?php 

$preset_url = get_template_directory_uri().'/images/header-preset/';

Mayosis_Option::add_section( 'header-presets', array(
    'title' => __( 'Prebuilt Header', 'mayosis-admin' ),
    'panel' => 'header',
    'priority' => '16',
    'description' => __( 'Here are the mayosis prebuilt header.you can switch them to check. Remind that after choose another preset & save your site header will be changed', 'mayosis' ),
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'preset',
    'settings'    => 'preset_demo',
    'label'       => __( 'Prebuilt Headers', 'mayosis' ),
    'section'     => 'header-presets',
    'transport' => 'postMessage',
    'choices'     => get_mayosis_header_presets()
) );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'custom',
    'settings' => 'select_preset',
    'section'     => 'header-presets',
    'default'     => '
    <div class="preset-click">
    <h3 class="preset-title">Prebuilt Headers</h3>
	    <img data-preset="header-default" title="Header Default" src="'.$preset_url.'Header-01.png"/>
	     <img data-preset="header-photo" title="Header Photo" src="'.$preset_url.'Header-02.png"/>
	     
	      <img data-preset="header-multivendor" title="Header Multivendor" src="'.$preset_url.'Header-03.png"/>
	      
	      <img data-preset="header-template-shop" title="Header Template Shop" src="'.$preset_url.'Header-03.png"/>
    </div>
    ',
) );