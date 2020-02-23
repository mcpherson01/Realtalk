<?php

add_filter('videopro_thumbnail_sizes', 'videopro_thumbnail_sizes_filter', 5, 1);

function videopro_thumbnail_sizes_filter($sizes){
	$ratio = 41 / 27;
	$arr_sizes = array(
				'videopro_misc_thumb_1' => array(50, 50, true, esc_html__('Thumb 50x50px', 'videopro'), esc_html__('This thumb size is used for: ...', 'videopro')),
				'videopro_misc_thumb_2' => array(100, 75, true, esc_html__('Thumb 100x75px', 'videopro'), esc_html__('This thumb size is used for: ...', 'videopro')),
				'videopro_misc_thumb_3' => array(205, floor(205 * $ratio), true, esc_html__('Thumb 205x'.floor(205 * $ratio).'px', 'videopro'), esc_html__('This thumb size is used for: ...', 'videopro')),
				'videopro_misc_thumb_4' => array(277, floor(277 * $ratio), true, esc_html__('Thumb 277x'.floor(277 * $ratio).'px', 'videopro'), esc_html__('This thumb size is used for: ...', 'videopro')),
				'videopro_misc_thumb_5' => array(298, 298, true, esc_html__('Thumb 298x298px', 'videopro'), esc_html__('This thumb size is used for: ...', 'videopro')),
				'videopro_misc_thumb_6' => array(320, floor(320 * $ratio), true, esc_html__('Thumb 320x'.floor(320 * $ratio).'px', 'videopro'), esc_html__('This thumb size is used for: ...', 'videopro')),
				'videopro_misc_thumb_7' => array(407, floor(407 * $ratio), true, esc_html__('Thumb 407x'.floor(407 * $ratio).'px', 'videopro'), esc_html__('This thumb size is used for: ...', 'videopro')),
				'videopro_misc_thumb_8' => array(565, floor(565 * $ratio), true, esc_html__('Thumb 565x'.floor(565 * $ratio).'px', 'videopro'), esc_html__('This thumb size is used for: ...', 'videopro')),
				'videopro_misc_thumb_9' => array(636, floor(636 * $ratio), true, esc_html__('Thumb 636x'.floor(636 * $ratio).'px', 'videopro'), esc_html__('This thumb size is used for: ...', 'videopro')),
				'videopro_misc_thumb_10' => array(800, 450, true, esc_html__('Thumb 800x450px', 'videopro'), esc_html__('This thumb size is used for: ...', 'videopro')),
				'videopro_misc_thumb_11' => array(1280, 720, true, esc_html__('Thumb 1280x720px', 'videopro'), esc_html__('This thumb size is used for: ...', 'videopro')),
				'videopro_misc_thumb_12' => array(636, 358, true, esc_html__('Thumb 636x358px', 'videopro'), esc_html__('This thumb size is used for Channel Listing Item', 'videopro')),
				'videopro_misc_thumb_13' => array(407, 229, true, esc_html__('Thumb 407x229px', 'videopro'), esc_html__('This thumb size is used for Playlist Listing Item', 'videopro'))
			);
	
	return $arr_sizes;
}

add_filter('videopro_thumb_mapping', 'videopro_thumb_mapping_filter', 5, 1);

function videopro_thumb_mapping_filter($mapping_array){
	$mapping = array(
				'1280x720' => 'videopro_misc_thumb_11',
				'1140x641' => 'videopro_misc_thumb_11',
				'800x450'  => 'videopro_misc_thumb_10',
				'760x428'  => 'videopro_misc_thumb_10',
				'636x358'  => 'videopro_misc_thumb_9',
				'565x318'  => 'videopro_misc_thumb_8',
				'555x312'  => 'videopro_misc_thumb_8',
				'407x229'  => 'videopro_misc_thumb_7',
				'395x222'  => 'videopro_misc_thumb_7',
				'385x216'  => 'videopro_misc_thumb_7',
				'375x211'  => 'videopro_misc_thumb_7',
				'365x205'  => 'videopro_misc_thumb_7',
				'360x202'  => 'videopro_misc_thumb_7',
				'320x180'  => 'videopro_misc_thumb_6',
				'326x180'  => 'videopro_misc_thumb_6',
				'312x175'  => 'videopro_misc_thumb_6',
				'298x168'  => 'videopro_misc_thumb_6',
				'277x156'  => 'videopro_misc_thumb_4',
				'270x152'  => 'videopro_misc_thumb_4',
				'251x141'  => 'videopro_misc_thumb_4',
				'246x138'  => 'videopro_misc_thumb_4',
				'240x135'  => 'videopro_misc_thumb_4',
				'233x131'  => 'videopro_misc_thumb_4',
				'205x115'  => 'videopro_misc_thumb_3',
				'192x108'  => 'videopro_misc_thumb_3',
				'182x102'  => 'videopro_misc_thumb_3',
				'100x75'  => 'videopro_misc_thumb_3',
				'298x298'  => 'videopro_misc_thumb_5',
				'50x50'  => 'videopro_misc_thumb_1',
					);
	
	return $mapping;
}

add_filter('videopro_thumbnail_size_filter', 'videopro_thumbnail_size_do_filter', 10, 2);
function videopro_thumbnail_size_do_filter($size, $post_id){
	$post_type = get_post_type($post_id);
	
	if($post_type == 'ct_channel'){
		switch($size){
			case 'videopro_misc_thumb_9':
			case 'videopro_misc_thumb_7':
				$size = 'videopro_misc_thumb_12';
				break;
		}
	}
	
	if($post_type == 'ct_playlist'){
		switch($size){
			case 'videopro_misc_thumb_7':
				$size = 'videopro_misc_thumb_13';
				break;
		}
	}
	
	if($post_type == 'ct_actor'){
		switch($size){
			case 'videopro_misc_thumb_5':
				$size = 'videopro_misc_thumb_7';
				break;
		}
	}
	
	return $size;
}

add_filter('videopro_image_placeholder_url','videopro_image_placeholder_url_filter', 10, 2);
function videopro_image_placeholder_url_filter($url, $image_size){
	switch($image_size){
		case 'videopro_misc_thumb_10':
		case 'videopro_misc_thumb_11':
		case 'videopro_misc_thumb_12':
		case 'videopro_misc_thumb_13':
		case 'videopro_misc_thumb_1':
		case 'videopro_misc_thumb_2':
		case 'videopro_misc_thumb_5':
			break;
		default:
			$url = get_stylesheet_directory_uri() . '/images/img-placeholder.jpg';
			break;
	}
	
	return $url;
}