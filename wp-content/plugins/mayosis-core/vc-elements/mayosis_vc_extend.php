<?php
/*** Removing shortcodes ***/
vc_remove_element("vc_wp_search");
vc_remove_element("vc_wp_meta");
vc_remove_element("vc_wp_recentcomments");
vc_remove_element("vc_wp_calendar");
vc_remove_element("vc_wp_pages");
vc_remove_element("vc_wp_tagcloud");
vc_remove_element("vc_wp_custommenu");
vc_remove_element("vc_wp_text");
vc_remove_element("vc_wp_posts");
vc_remove_element("vc_wp_links");
vc_remove_element("vc_wp_categories");
vc_remove_element("vc_wp_archives");
vc_remove_element("vc_wp_rss");
vc_remove_element("vc_teaser_grid");
vc_remove_element("vc_button");
vc_remove_element("vc_cta_button");
vc_remove_element("vc_cta_button2");
vc_remove_element("vc_message");
vc_remove_element("vc_tour");
vc_remove_element("vc_accordion");
vc_remove_element("vc_tabs");
vc_remove_element("vc_progress_bar");
vc_remove_element("vc_pie");
vc_remove_element("vc_posts_slider");
vc_remove_element("vc_toggle");
vc_remove_element("vc_images_carousel");
vc_remove_element("vc_posts_grid");
vc_remove_element("vc_carousel");
vc_remove_element("vc_cta");
vc_remove_element("vc_round_chart");
vc_remove_element("vc_line_chart");
vc_remove_element("vc_tta_tour");


/*** Remove unused parameters ***/

vc_remove_param("vc_row", "font_color");
vc_remove_param("vc_row", "bg_image");
vc_remove_param("vc_row", "full_width");
vc_remove_param("vc_row", "equal_height");
vc_remove_param("vc_row", "parallax");
vc_remove_param("vc_row", "parallax_image");
vc_remove_param("vc_row", "parallax_speed_bg");
vc_remove_param("vc_row", "parallax_speed_video");
vc_remove_param("vc_row", "video_bg_parallax");
vc_remove_param("vc_row", "video_bg_url");
vc_remove_param("vc_row", "video_bg");
vc_remove_param('vc_row', 'columns_placement');
vc_remove_param('vc_row_inner', 'content_placement');


/*** Row ***/
/* VC settings */
/*-----------------------------------------------------------------------------------*/
/*	Add news params to vc_Row
/*-----------------------------------------------------------------------------------*/
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Padding Top",
	"value" => "80",
	"param_name" => "padding_top",
	"description" => "Add Integer Value Without Px. If add value in Design options this will be Overwritten",
	
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Padding Bottom",
	"value" => "80",
	"param_name" => "padding_bottom",
	"description" => "Add Integer Value Without Px. If add value in Design options this will be Overwritten",
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Section Layout", 'mayosis'),
	"param_name" => "to_section_layout",
	"value" => array(
		__("Boxed", 'mayosis') => "boxed",
		__("Full width", 'mayosis') => "full-width",
		__("Post/Product Grid", 'mayosis') => "product-grid",
		),
	"description" => __("Choose the type of layout. In most of case you should use boxed layout.",'mayosis'),
	"dependency" => array("element" => "to_para_bg", "value" => array("no_bg","image","youtube","gradient-bg","single-color"))
));

vc_add_param('vc_row',array(
	"type" => "checkbox",
	"class" => "",
	"heading" => __("Equal height columns", 'mayosis'),
	"param_name" => "to_equal_column",
	"value" => array("Equal Height"=>__("Equal Height", 'mayosis')),
	"description" => __("Check this option if you want to have all children columns at the same height", 'mayosis'),
));


vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Text alignment", 'mayosis'),
	"param_name" => "txt_section_align",
	"value" => array(
		__("Choose Alignment", 'mayosis') => "",
		__("Left", 'mayosis') => "text-left",
		__("Center", 'mayosis') => "text-center",
		__("Right", 'mayosis') => "text-right"
		),
	"description" => __("Choose the text alignment",'mayosis'),
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Top Section Decoration", 'mayosis'),
	"param_name" => "top_section_deco",
	"value" => array(
		"" => "",
		__("Slope Left", 'mayosis') => "slope-left",
		__("Slope Right", 'mayosis') => "slope-right",
		__("Rounded Outer", 'mayosis') => "rounded-outer",
		__("Rounded Inner", 'mayosis') => "rounded-inner",
		__("Triangle Outer", 'mayosis') => "triangle-outer",
		__("Triangle Inner", 'mayosis') => "triangle-inner",
		__("Arrow", 'mayosis') => "arrow",
		__("Circle", 'mayosis') => "circle",
		__("Clouds", 'mayosis') => "clouds",
		__("circle", 'mayosis') => "repeat-triangle",
		__("Triangle Pattern", 'mayosis') => "repeat-triangle",
		__("Half Circle Pattern", 'mayosis') => "repeat-circle",
		),
	"description" => __("If you want to style the section separator instead of a straight line, choose a decoration for the top section.",'mayosis'),
	"dependency" => array("element" => "to_para_bg", "value" => array("single-color"))
));
vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Bottom Section Decoration", 'mayosis'),
	"param_name" => "bot_section_deco",
	"value" => array(
		"" => "",
		__("Slope Left", 'mayosis') => "slope-left",
		__("Slope Right", 'mayosis') => "slope-right",
		__("Rounded Outer", 'mayosis') => "rounded-outer",
		__("Rounded Inner", 'mayosis') => "rounded-inner",
		__("Triangle Outer", 'mayosis') => "triangle-outer",
		__("Triangle Inner", 'mayosis') => "triangle-inner",
		__("Arrow", 'mayosis') => "arrow",
		__("Circle", 'mayosis') => "circle",
		__("Clouds", 'mayosis') => "clouds",
		__("circle", 'mayosis') => "repeat-triangle",
		__("Triangle Pattern", 'mayosis') => "repeat-triangle",
		__("Half Circle Pattern", 'mayosis') => "repeat-circle",
		),
	"description" => __("If you want to style the section separator instead of a straight line, choose a decoration for the bottom section.",'mayosis'),
	"dependency" => array("element" => "to_para_bg", "value" => array("single-color"))
));
vc_add_param('vc_row',array(
	"type" => "dropdown",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Background Style", 'mayosis'),
	"param_name" => "to_para_bg",
	"value" => array(
		__("None", 'mayosis') => "no_bg",
		__("Single Color", 'mayosis') => "single-color",
		__("Gradient", 'mayosis') => "gradient-bg",
		__("Image", 'mayosis') => "image",
		__("Side Image", 'mayosis') => "side-image",
		__("YouTube Video", 'mayosis') => "youtube",
		__("Self hosted Video", 'mayosis') => "self",
		),
	"description" => __("Select what kind of background would you like to set for this row.", 'mayosis')
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Video Link",
	"value" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"param_name" => "self_video_url",
	"description" => "Add Video Url",
	"dependency" => Array("element" => "to_para_bg", "value" => array("self")),
	
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Video section height",
	"value" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"param_name" => "self_video_height",
	"description" => "Add Height(i.e 600)",
	"dependency" => Array("element" => "to_para_bg", "value" => array("self")),
	
));
vc_add_param('vc_row',array(
	"type" => "colorpicker",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Single background Color", 'mayosis'),
	"param_name" => "single_color_bg",
	"value" => "",
	"description" => __("Select Single Color.", 'mayosis'),
	"dependency" => Array("element" => "to_para_bg", "value" => array("single-color")),
));
vc_add_param('vc_row',array(
	"type" => "colorpicker",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Gradient background Color A", 'mayosis'),
	"param_name" => "gradient_color_a",
	"value" => "",
	"description" => __("Select Gradient Color A.", 'mayosis'),
	"dependency" => Array("element" => "to_para_bg", "value" => array("gradient-bg")),
));

vc_add_param('vc_row',array(
	"type" => "colorpicker",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Gradient background Color B", 'mayosis'),
	"param_name" => "gradient_color_b",
	"value" => "",
	"description" => __("Select Gradient Color B.", 'mayosis'),
	"dependency" => Array("element" => "to_para_bg", "value" => array("gradient-bg")),
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Gradient Angle",
	"value" => "80",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"param_name" => "gradient_angle",
	"description" => "Add Integer Value Without Deg",
	"dependency" => Array("element" => "to_para_bg", "value" => array("gradient-bg")),
	
));

vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Parallax", 'mayosis'),
	"param_name" => "to_parallax",
	"value" => array(__("parallax", 'mayosis') => "parallax"),
	"description" => __("Check this box ",'mayosis'),
	"dependency" => array("element" => "to_para_bg", "value" => array("image")),
));	
vc_add_param('vc_row',array(
	"type" => "attach_image",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Background Image", 'mayosis'),
	"param_name" => "to_para_img",
	"description" => __("Upload or select background image from media gallery.", 'mayosis'),
	"dependency" => array("element" => "to_para_bg", "value" => array("side-image","image")),
));
vc_add_param('vc_row',array(
	"type" => "dropdown",
	"class" => "",
	'group' => __('Layout options', 'mayosis'),
	"heading" => __("Side Image Position", 'mayosis'),
	"param_name" => "to_side_img_position",
	"value" => array(
			__("Left", 'mayosis') => "left",
			__("Right", 'mayosis') => "right",
		),
	"description" => __("Choose the image position in the row (left or right position)",'mayosis'),
	"dependency" => Array("element" => "to_para_bg", "value" => array("side-image")),
));
vc_add_param('vc_row',array(
	"type" => "dropdown",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Background Image Repeat", 'mayosis'),
	"param_name" => "to_para_img_repeat",
	"value" => array(
			__("No Repeat", 'mayosis') => "no-repeat",
			__("Repeat", 'mayosis') => "repeat",
		),
	"description" => __("Options to control repeatation of the background image.",'mayosis'),
	"dependency" => Array("element" => "to_para_bg", "value" => array("side-image","image")),
));
vc_add_param('vc_row',array(
	"type" => "checkbox",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Background Blur", 'mayosis'),
	"param_name" => "to_para_blur",
	"value" => array("blur"=>__("blur", 'mayosis')),
	"description" => __("Check this option if you want to apply a blur effect on your image.", 'mayosis'),
	"dependency" => Array("element" => "to_para_bg", "value" => array("side-image","image")),
));
vc_add_param('vc_row',array(
	"type" => "attach_image",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Placehoder Image for the video", 'mayosis'),
	"param_name" => "to_para_poster",
	"value" => "",
	"description" => __("Select the placehoder image that will be display while video is loading.", 'mayosis'),
	"dependency" => Array("element" => "to_para_bg", "value" => array("self","youtube")),
));

vc_add_param('vc_row',array(
	"type" => "textfield",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Youtube URL", 'mayosis'),
	"param_name" => "to_para_youtube_url",
	"value" => "",
	"description" => __("Enter YouTube url. Example - YouTube (https://www.youtube.com/watch?v=LjCzPp-MK48) ", 'mayosis'),
	"dependency" => Array("element" => "to_para_bg", "value" => array("youtube")),
));

vc_add_param('vc_row',array(
	"type" => "checkbox",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Background Overlay", 'mayosis'),
	"param_name" => "to_para_over_set",
	"value" => array("overlay"=>__("overlay", 'mayosis')),
	"description" => __("Hide or Show overlay on background images.", 'mayosis'),
	"dependency" => Array("element" => "to_para_bg", "value" => array("image","self","youtube")),
));
vc_add_param('vc_row',array(
	"type" => "attach_image",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Overlay Background Pattern", 'mayosis'),
	"param_name" => "to_para_over_img",
	"value" => "",
	"description" => __("Upload or select background pattern overlay from media gallery.", 'mayosis'),
	"dependency" => Array("element" => "to_para_over_set", "value" => array("overlay")),
));
vc_add_param('vc_row',array(
	"type" => "colorpicker",
	"class" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Overlay Color", 'mayosis'),
	"param_name" => "to_para_over_color",
	"value" => "",
	"description" => __("Select color for background overlay.", 'mayosis'),
	"dependency" => Array("element" => "to_para_over_set", "value" => array("overlay")),
));
vc_add_param('vc_row',array(
	"type" => "textfield",
	"class" => "",
	"value" => "0.8",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Overlay Opacity", 'mayosis'),
	"param_name" => "to_para_over_opacity",
	"description" => __("Set an opacity to the background overlay.", 'mayosis'),
	"dependency" => Array("element" => "to_para_over_set", "value" => array("overlay")),
));

vc_add_param('vc_row',array(
	"type" => "textfield",
	"class" => "",
	"value" => "",
	'group' => __( 'Mayosis Options', 'mayosis'),
	"heading" => __("Z Index", 'mayosis'),
	"param_name" => "z_index_custom",
	"description" => __("Set a z index value.", 'mayosis'),
));
