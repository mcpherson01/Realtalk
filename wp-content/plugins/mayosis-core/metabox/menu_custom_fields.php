<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5c7299e14fa57',
	'title' => 'Menu Custom Fields',
	'fields' => array(
		array(
			'key' => 'field_5c729a4849142',
			'label' => '',
			'name' => '_mayosis_menu_icon',
			'type' => 'text',
			'instructions' => 'Menu Icon [Add icon Class Form Fontawesome(v4.7.0). i.e (fa-500px)]',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5c729a91a46e2',
			'label' => '',
			'name' => '_mayosis_menu_label',
			'type' => 'text',
			'instructions' => 'Menu Label Text',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5c729b0234ba1',
			'label' => '',
			'name' => '_mayosis_menu_label_bg',
			'type' => 'select',
			'instructions' => 'Menu Label Background',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'label-green' => 'Green',
				'label-blue' => 'Blue',
				'label-red' => 'Red',
				'label-purple' => 'Purple',
				'label-brown' => 'Brown',
				'label-maroon' => 'Maroon',
				'label-cyan' => 'Cyan',
				'label-pink' => 'Pink',
				'label-black' => 'Black',
			),
			'default_value' => array(
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'nav_menu_item',
				'operator' => '==',
				'value' => 'all',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;