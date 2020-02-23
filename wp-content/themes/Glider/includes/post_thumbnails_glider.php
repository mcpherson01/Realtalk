<?php
	add_theme_support( 'post-thumbnails' );

	global $et_theme_image_sizes;

	$et_theme_image_sizes = array(
		'173x173' 	=> 'et-header-thumb',
		'133x133' 	=> 'et-home-thumb',
		'103x103' 	=> 'et-index-thumb',
	);

	$et_theme_image_sizes = apply_filters( 'et_theme_image_sizes', $et_theme_image_sizes );
	$crop = apply_filters( 'et_post_thumbnails_crop', true );

	if ( is_array( $et_theme_image_sizes ) ){
		foreach ( $et_theme_image_sizes as $image_size_dimensions => $image_size_name ){
			$dimensions = explode( 'x', $image_size_dimensions );
			add_image_size( $image_size_name, $dimensions[0], $dimensions[1], $crop );
		}
	}
?>