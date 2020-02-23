<?php
global $epanelMainTabs, $themename, $shortname, $options;

$epanelMainTabs = array('general','navigation','layout','ad','colorization','seo','integration','support','updates');

$cats_array = get_categories('hide_empty=0');
$pages_array = get_pages('hide_empty=0');
$site_pages = array();
$site_cats = array();
$pages_ids = array();
$cats_ids = array();

foreach ($pages_array as $pagg) {
	$site_pages[$pagg->ID] = htmlspecialchars($pagg->post_title);
	$pages_ids[] = $pagg->ID;
}

foreach ($cats_array as $categs) {
	$site_cats[$categs->cat_ID] = $categs->cat_name;
	$cats_ids[] = $categs->cat_ID;
}

$options = array (

	array( "name" => "wrap-general",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "general-1",
				   "type" => "subnav-tab",
				   "desc" => "General"),

			array( "name" => "general-2",
				   "type" => "subnav-tab",
				   "desc" => "Homepage"),

			array( "name" => "general-3",
				   "type" => "subnav-tab",
				   "desc" => "Slider 1"),

			array( "name" => "general-4",
				   "type" => "subnav-tab",
				   "desc" => "Slider 2"),

			array( "name" => "general-5",
				   "type" => "subnav-tab",
				   "desc" => "Slider 3"),

		array( "type" => "subnavtab-end",),

		array( "name" => "general-1",
			   "type" => "subcontent-start",),

			array( "name" => "Logo",
				   "id" => $shortname."_logo",
				   "type" => "upload",
				   "std" => "",
				   "desc" => "If you would like to use your own custom logo image click the Upload Image button."
			),

			array( "name" => "Favicon",
				   "id" => $shortname."_favicon",
				   "type" => "upload",
				   "std" => "",
				   "desc" => "If you would like to use your own custom favicon image click the Upload Image button."
			),

			array( "name" => "Color Scheme",
				   "id" => $shortname."_color_scheme",
				   "type" => "select",
				   "std" => "Default",
				   "desc" => "This theme comes with multiple color schemes. You can switch between these color schemes at any time using this dropdown menu. Once you click save your theme will be updated with the new color scheme automatically.",
				   "options" => array("Default", "Default-Blue", "Default-Purple", "Radiate-Blue", "Radiate-Red", "Radiate-Green", "Smooth-Blue", "Smooth-Green", "Smooth-Pink")),

			array( "name" => "Blog Style Theme Format",
            "id" => $shortname."_blog_style",
            "type" => "checkbox",
            "std" => "false",
            "desc" => "By default the theme truncates your posts on index/homepages automatically to create post previews. If you would rather show your posts in full on index pages like a traditional blog then you can activate this feature."),

			array( "name" => "Display Footer",
            "id" => $shortname."_footer",
            "type" => "checkbox2",
            "std" => "on",
            "desc" => "If you don't want to use the widgetized area in the footer you can disable it here and it will be removed from all pages. "),

			array( "type" => "clearfix",),

			array( "name" => "Grab the first image from a post",
				   "id" => $shortname."_grab_image",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => "By default thumbnail images are created using custom fields. However, if you would rather use the images that are already in your post for your thumbnail (and bypass using custom fields) you can activate this option. Once activcated thumbnail images will be generated automatically using the first image in your post. The image must be hosted on your own server."),

			array( "type" => "clearfix",),

			array( "name" => "Date format",
				   "id" => $shortname."_date_format",
				   "std" => "M jS, Y",
                   "type" => "text",
                   "validation_type" => "nohtml",
				   "desc" => "This option allows you to change how your dates are displayed. For more information please refer to the WordPress codex here:<a href='http://codex.wordpress.org/Formatting_Date_and_Time' target='_blank'>Formatting Date and Time</a>"),

			array( "name" => "Number of Posts on Category pages",
			       "id" => $shortname."_catnum_posts",
				   "std" => "5",
				   "type" => "text",
				   "validation_type" => "number",
				   "desc" => "Set the number of posts displayed when viewing a category"),

		array( "name" => "Number of Posts displayed on Archive pages",
                   "id" => $shortname."_archivenum_posts",
                   "std" => "5",
                   "type" => "text",
                   "validation_type" => "number",
				   "desc" => "Here you can designate how many recent articles are displayed on the Archive pages. This option works independently from the Settings > Reading options in wp-admin."),

		array( "name" => "Number of Posts displayed on Search pages",
                   "id" => $shortname."_searchnum_posts",
                   "std" => "5",
                   "type" => "text",
                   "validation_type" => "number",
				   "desc" => "Here you can designate how many recent articles are displayed on the Search results pages. This option works independently from the Settings > Reading options in wp-admin."),

		array( "name" => "Number of Posts displayed on Tag pages",
                   "id" => $shortname."_tagnum_posts",
                   "std" => "5",
                   "type" => "text",
                   "validation_type" => "number",
				   "desc" => "Here you can designate how many recent articles are displayed on the Tag pages. This option works independently from the Settings > Reading options in wp-admin."),

		array( "name" => "Use excerpts when defined",
			   "id" => $shortname."_use_excerpt",
			   "type" => "checkbox",
			   "std" => "false",
			   "desc" => "This will enable the use of excerpts in posts or pages."),

		array( "type" => "clearfix",),

		array( "name" => esc_html__( "Custom CSS", $themename ),
			   "id" => $shortname . "_custom_css",
			   "type" => "textarea",
			   "std" => "",
			   "desc" => esc_html__( "Here you can add custom css to override or extend default styles.", $themename ),
				"validation_type" => "nohtml"
		),

		array( "name" => "general-1",
			   "type" => "subcontent-end",),

		array( "name" => "general-2",
			   "type" => "subcontent-start",),

	array( "name" => "Number of Pages to Display on Homepage",
				   "id" => $shortname."_home_page_number",
				   "type" => "select",
				   "std" => "2",
				   "desc" => "Here you can designate the number of pages that will display on the homepage. ",
				   "options" => array("1", "2", "3", "4")),

			array( "name" => "Content Area 1 Page ID",
				   "id" => $shortname."_home_page_1",
				   "std" => "",
				   "type" => "select",
				   "desc" => "Here you can choose the page you would like to display in the content area on the homepage. ",
				   "options" => $site_pages,
				   'et_array_for' => 'pages'),

			array( "name" => "Content Area 2 Page ID",
				   "id" => $shortname."_home_page_2",
				   "std" => "",
				   "type" => "select",
				   "desc" => "Here you can choose the page you would like to display in the content area on the homepage.",
				   "options" => $site_pages,
				   'et_array_for' => 'pages'),

			array( "name" => "Content Area 3 Page ID",
				   "id" => $shortname."_home_page_3",
				   "std" => "",
				   "type" => "select",
				   "desc" => "Here you can choose the page you would like to display in the content area on the homepage.",
				   "options" => $site_pages,
				   'et_array_for' => 'pages'),

			array( "name" => "Content Area 4 Page ID",
				   "id" => $shortname."_home_page_4",
				   "std" => "",
				   "type" => "select",
				   "desc" => "Here you can choose the page you would like to display in the content area on the homepage.",
				   "options" => $site_pages,
				   'et_array_for' => 'pages'),

			array( "name" => "Number of Slider Items to be Displayed",
				   "id" => $shortname."_scroller_number",
				   "type" => "select",
				   "std" => "3",
				   "desc" => "Here you can designate how many articles are displayed in the Featured Articles section on the homepage.",
				   "options" => array("3", "2", "1")),


			array( "name" => "Display Blog Scroller",
				   "id" => $shortname."_home_blog",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => "By default there is a recent posts section on the homepage that lists your most recent blog posts. If you want to remove this blog feed from the homepage then simply disable this option.",),

			array( "type" => "clearfix",),

			array( "name" => "Exclude categories from the 'Blog' feed",
				   "id" => $shortname."_exlcats_recent",
				   "type" => "checkboxes",
				   "std" => '',
				   "desc" => "By default the homepage displays a list of all of your most recent posts. However, if you would like to exlcude certain category from the list you can do so here. ",
				   "usefor" => "categories",
				   "options" => $cats_ids),

			array( "name" => "Number of Recent-Posts Displayed in Blog Feed",
			       "id" => $shortname."_homepage_posts",
				   "std" => "6",
				   "type" => "text",
				   "validation_type" => "number",
				   "desc" => "If you have the blog feed enabled then you can "),

			array( "name" => "Link to RSS or Feedburner",
				   "id" => $shortname."_rss",
				   "std" => "#",
				   "type" => "text",
				   "validation_type" => "url",
				   "desc" => "If you have the blog feed enabled then an RSS icon is added to the top of the feed so that visitors can subscribe. Here you can enter your feedburner URL, or the URL to whatever rss service you use."),

			array( "name" => "Number of Posts on Homepage (in Blog style)",
			       "id" => $shortname."_blogstyle_homeposts",
				   "std" => "6",
				   "type" => "text",
				   "validation_type" => "number",
				   "desc" => "Set the number of posts displayed on homepage in Blog style Theme Format"),

			array( "type" => "clearfix",),

		array( "name" => "general-2",
			   "type" => "subcontent-end",),

		array( "name" => "general-3",
				   "type" => "subcontent-start",),

			array( "name" => "Slider Item 1 - Display Type",
				   "id" => $shortname."_slider_1_type",
				   "type" => "select",
				   "std" => "Image",
				   "desc" => "Within each slider you can include either an image or a video. To change the media type of this slider area simply choose your desired media type from the dropdown menu. You can only have one image or one video per slider.",
				   "options" => array("Image", "Video")),

			array( "name" => "Slider Item 1 - Button Title",
				   "id" => $shortname."_slider_1_button",
				   "std" => "Welcome to eBusiness",
				   "type" => "textlimit",
				   "desc" => "Each slider is assigned a button that appears above the slider. When clicked these buttons toggle their associated slider area. Here you can choose what text is used in the button. Due to limited space only 21 characters are available for use within each button title.",
				   "max" => "21"),

			array( "name" => "Slider Item 1 - Content Title",
				   "id" => $shortname."_slider_1_title",
				   "std" => "Neque porro quisquam est",
				   "type" => "textlimit",
				   "desc" => "Within each slider area there is a large title that appears above the main text content. Enter your desired title here. Due to limited space only 24 characters area available for each title.",
				   "max" => "24"),

			array( "name" => "Slider Item 1 - Thumbnail Image",
				   "id" => $shortname."_slider_1_image",
				   "std" => "http://www.elegantthemes.com/images/eBusiness/thumb-1.jpg",
				   "desc" => "With each slider you can include a thumbnail image which is displayed to the right of the slider text. Simply input the URL to the image you would like to use here. The image must be hosted on the same domain that WordPress is installed to.",
				   "type" => "text",
				   "validation_type" => "url", ),

			array( "name" => "Slider Item 1 - Video Embed Code",
				   "id" => $shortname."_slider_1_video",
				   "std" => "",
				   "desc" => "If you have chosen to add video to your slider you can input your desired video embed code here. You can only embed flash-based videos from video hosts such as youtube.com. Also, your video's wmode must be set to transparent.",
				   "type" => "textarea"),

			array( "name" => "Slider Item 1 - Content Text",
				   "id" => $shortname."_slider_1_content",
				   "std" => "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.",
				   "desc" => "Here is where you should input the main content text of your slder.",
				   "type" => "textarea"),

			array( "name" => "Enable/Disable Read More Button",
				   "id" => $shortname."_slider_1_readmore",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => "With each slider area you can include a read more link that is added to the bottom of the slider. This is useful if you would like your slider to act as a preview for a large section of your website. You can choose where your read more button leads to by inputting the desired URL below.",),

			array( "type" => "clearfix",),

			array( "name" => "Slider Item 1 - Read More URL",
				   "id" => $shortname."_slider_1_readmore_url",
				   "std" => "#",
				   "desc" => "Here you can choose where your read more link, if enabled, leads to. Simply input the full destination URL.",
				   "type" => "text",
				   "validation_type" => "url", ),

		array( "name" => "general-3",
			   "type" => "subcontent-end",),

		array( "name" => "general-4",
			   "type" => "subcontent-start",),

			array( "name" => "Slider Item 2 - Display Type",
				   "id" => $shortname."_slider_2_type",
				   "type" => "select",
				   "std" => "Image",
				   "desc" => "Within each slider you can include either an image or a video. To change the media type of this slider area simply choose your desired media type from the dropdown menu. You can only have one image or one video per slider.",
				   "options" => array("Image", "Video")),

			array( "name" => "Slider Item 2 - Button Title",
				   "id" => $shortname."_slider_2_button",
				   "std" => "Welcome to eBusiness",
				   "type" => "textlimit",
				   "desc" => "Each slider is assigned a button that appears above the slider. When clicked these buttons toggle their associated slider area. Here you can choose what text is used in the button. Due to limited space only 21 characters are available for use within each button title.",
				   "max" => "21"),

			array( "name" => "Slider Item 2 - Content Title",
				   "id" => $shortname."_slider_2_title",
				   "std" => "Neque porro quisquam est",
				   "type" => "textlimit",
				   "desc" => "Within each slider area there is a large title that appears above the main text content. Enter your desired title here. Due to limited space only 24 characters area available for each title.",
				   "max" => "24"),

			array( "name" => "Slider Item 2 - Thumbnail Image",
				   "id" => $shortname."_slider_2_image",
				   "std" => "http://www.elegantthemes.com/images/eBusiness/thumb-2.jpg",
				   "desc" => "With each slider you can include a thumbnail image which is displayed to the right of the slider text. Simply input the URL to the image you would like to use here. The image must be hosted on the same domain that WordPress is installed to.",
				   "type" => "text",
			       "validation_type" => "url", ),

			array( "name" => "Slider Item 2 - Video Embed Code",
				   "id" => $shortname."_slider_2_video",
				   "std" => "",
				   "desc" => "If you have chosen to add video to your slider you can input your desired video embed code here. You can only embed flash-based videos from video hosts such as youtube.com. Also, your video's wmode must be set to transparent.",
				   "type" => "textarea"),

			array( "name" => "Slider Item 2 - Content Text",
				   "id" => $shortname."_slider_2_content",
				   "std" => "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.",
				   "desc" => "Here is where you should input the main content text of your slder.",
				   "type" => "textarea"),

			array( "name" => "Enable/Disable Read More Button",
				   "id" => $shortname."_slider_2_readmore",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => "With each slider area you can include a read more link that is added to the bottom of the slider. This is useful if you would like your slider to act as a preview for a large section of your website. You can choose where your read more button leads to by inputting the desired URL below.",),

			array( "type" => "clearfix",),

			array( "name" => "Slider Item 2 - Read More URL",
				   "id" => $shortname."_slider_2_readmore_url",
				   "std" => "#",
				   "desc" => "Here you can choose where your read more link, if enabled, leads to. Simply input the full destination URL.",
				   "type" => "text",
				   "validation_type" => "url", ),

		array( "name" => "general-4",
			   "type" => "subcontent-end",),

		array( "name" => "general-5",
			   "type" => "subcontent-start",),

			array( "name" => "Slider Item 3 - Display Type",
				   "id" => $shortname."_slider_3_type",
				   "type" => "select",
				   "std" => "Image",
				   "desc" => "Within each slider you can include either an image or a video. To change the media type of this slider area simply choose your desired media type from the dropdown menu. You can only have one image or one video per slider.",
				   "options" => array("Image", "Video")),

			array( "name" => "Slider Item 3 - Button Title",
				   "id" => $shortname."_slider_3_button",
				   "std" => "Welcome to eBusiness",
				   "type" => "textlimit",
				   "desc" => "Each slider is assigned a button that appears above the slider. When clicked these buttons toggle their associated slider area. Here you can choose what text is used in the button. Due to limited space only 21 characters are available for use within each button title.",
				   "max" => "21"),

			array( "name" => "Slider Item 3 - Content Title",
				   "id" => $shortname."_slider_3_title",
				   "std" => "Neque porro quisquam est",
				   "type" => "textlimit",
				   "desc" => "Within each slider area there is a large title that appears above the main text content. Enter your desired title here. Due to limited space only 24 characters area available for each title.",
				   "max" => "24"),

			array( "name" => "Slider Item 3 - Thumbnail Image",
				   "id" => $shortname."_slider_3_image",
				   "std" => "http://www.elegantthemes.com/images/eBusiness/thumb-2.jpg",
				   "desc" => "With each slider you can include a thumbnail image which is displayed to the right of the slider text. Simply input the URL to the image you would like to use here. The image must be hosted on the same domain that WordPress is installed to.",
				   "type" => "text",
				   "validation_type" => "url", ),

			array( "name" => "Slider Item 3 - Video Embed Code",
				   "id" => $shortname."_slider_3_video",
				   "std" => "",
				   "desc" => "If you have chosen to add video to your slider you can input your desired video embed code here. You can only embed flash-based videos from video hosts such as youtube.com. Also, your video's wmode must be set to transparent.",
				   "type" => "textarea"),

			array( "name" => "Slider Item 3 - Content Text",
				   "id" => $shortname."_slider_3_content",
				   "std" => "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.",
				   "desc" => "Here is where you should input the main content text of your slder.",
				   "type" => "textarea"),

			array( "name" => "Enable/Disable Read More Button",
				   "id" => $shortname."_slider_3_readmore",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => "With each slider area you can include a read more link that is added to the bottom of the slider. This is useful if you would like your slider to act as a preview for a large section of your website. You can choose where your read more button leads to by inputting the desired URL below.",),

			array( "type" => "clearfix",),

			array( "name" => "Slider Item 3 - Read More URL",
				   "id" => $shortname."_slider_3_readmore_url",
				   "std" => "#",
				   "desc" => "Here you can choose where your read more link, if enabled, leads to. Simply input the full destination URL.",
				   "type" => "text",
				   "validation_type" => "url", ),

		array( "name" => "general-5",
			   "type" => "subcontent-end",),

	array(  "name" => "wrap-general",
			"type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-navigation",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "navigation-1",
				   "type" => "subnav-tab",
				   "desc" => "Pages"),

			array( "name" => "navigation-2",
				   "type" => "subnav-tab",
				   "desc" => "Categories"),

			array( "name" => "navigation-3",
				   "type" => "subnav-tab",
				   "desc" => "General Settings"),

		array( "type" => "subnavtab-end",),

		array( "name" => "navigation-1",
			   "type" => "subcontent-start",),

			array( "name" => "Exclude pages from the navigation bar",
				   "id" => $shortname."_menupages",
				   "type" => "checkboxes",
				   "std" => '',
				   "desc" => "Here you can choose to remove certain pages from the navigation menu. All pages marked with an X will not appear in your navigation bar. ",
				   "usefor" => "pages",
				   "options" => $pages_ids),

			array( "name" => "Show dropdown menus",
				   "id" => $shortname."_enable_dropdowns",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => "If you would like to remove the dropdown menus from the pages navigation bar disable this feature."),

			array( "name" => "Display Home link",
   				   "id" => $shortname."_home_link",
				   "type" => "checkbox2",
				   "std" => "on",
				   "desc" => "By default the theme creates a Home link that, when clicked, leads back to your blog's homepage. If, however, you are using a static homepage and have already created a page called Home to use, this will result in a duplicate link. In this case you should disable this feature to remove the link."),

			array( "type" => "clearfix",),

			array( "name" => "Number of dropdown tiers shown",
				   "id" => $shortname."_tiers_shown_pages",
				   "type" => "text",
				   "validation_type" => "number",
				   "std" => "3",
				   "desc" => "This options allows you to control how many teirs your pages dropdown menu has. Increasing the number allows for additional menu items to be shown."),

			array( "name" => "Sort Pages Links",
                   "id" => $shortname."_sort_pages",
                   "type" => "select",
                   "std" => "post_title",
				   "desc" => "Here you can choose to sort your pages links.",
                   "options" => array("post_title", "menu_order","post_date","post_modified","ID","post_author","post_name")),

			array( "name" => "Order Pages Links by Ascending/Descending",
                   "id" => $shortname."_order_page",
                   "type" => "select",
                   "std" => "asc",
				   "desc" => "Here you can choose to reverse the order that your pages links are displayed. You can choose between ascending and descending.",
                   "options" => array("asc", "desc")),

			array( "type" => "clearfix",),

		array( "name" => "navigation-1",
			   "type" => "subcontent-end",),

		array( "name" => "navigation-2",
			   "type" => "subcontent-start",),

			array( "name" => "Show Categories Bar",
				   "id" => $shortname."_categories",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => "If you have a Blog section then a categories navigation bar is added to the top of the page. You can disable this bar if you don't feel it is needed. This is useful if you only have one category and don't want to dedicate a large section of the page to displaying a single link."),

			array( "name" => "Show Blog Link",
				   "id" => $shortname."_blog_link",
				   "type" => "checkbox2",
				   "std" => "on",
				   "desc" => "Enabling this option adds a link to your Blog category in your pages navigation bar. If you don't want to have a Blog then you should disable this option.",),

			array( "type" => "clearfix",),

			array( "name" => "Blog Category",
                   "id" => $shortname."_blog_cat",
                   "type" => "select",
                   "std" => "",
				   "desc" => "Even though eBusiness is a page-based theme, you can still have a Blog section. To create a Blog section simply choose which category you would like to use for your blog and make sure the Blog link above is enabled.",
                   "options" => $site_cats),

			array( "name" => "Exclude categories from the categories dropdown menu",
				   "id" => $shortname."_menucats",
				   "type" => "checkboxes",
				   "std" => '',
				   "desc" => "Here you can choose to remove certain categories from the navigation menu. All categories marked with an X will not appear in your navigation bar. ",
				   "usefor" => "categories",
				   "options" => $cats_ids),

			array( "name" => "Show dropdown menus",
				   "id" => $shortname."_enable_dropdowns_categories",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => "If you would like to remove the dropdown menus from the categories navigation bar disable this feature."),

			array( "type" => "clearfix",),

			array( "name" => "Number of dropdown tiers shown",
				   "id" => $shortname."_tiers_shown_categories",
				   "type" => "text",
				   "validation_type" => "number",
				   "std" => "3",
				   "desc" => "This options allows you to control how many teirs your categories dropdown menu has. Increasing the number allows for additional menu items to be shown."),

			array( "name" => "Sort Categories Links",
				   "id" => $shortname."_sort_cat",
				   "type" => "select",
				   "std" => "name",
				   "desc" => '',
				   "options" => array("name", "ID", "slug", "count", "term_group")),

			array( "name" => "Order Category Links by Ascending/Descending",
				   "id" => $shortname."_order_cat",
				   "type" => "select",
				   "std" => "asc",
				   "desc" => '',
				   "options" => array("asc", "desc")),

		array( "name" => "navigation-2",
			   "type" => "subcontent-end",),

		array( "name" => "navigation-3",
			   "type" => "subcontent-start",),

			array( "name" => "Disable top tier dropdown menu links",
            "id" => $shortname."_disable_toptier",
            "type" => "checkbox",
            "std" => "false",
			"desc" => "In some cases users will want to create parent categories or links as placeholders to hold a list of child links or categories. In this case it is not desirable to have the parent links lead anywhere, but instead merely serve an organizational function. Enabling this options will remove the links from all parent pages/categories so that they don't lead anywhere when clicked."),

			array( "type" => "clearfix",),

		array( "name" => "navigation-3",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-navigation",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-layout",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "layout-1",
				   "type" => "subnav-tab",
				   "desc" => "Single Post"),

			array( "name" => "layout-2",
				   "type" => "subnav-tab",
				   "desc" => "Single Page"),

			array( "name" => "layout-3",
				   "type" => "subnav-tab",
				   "desc" => "Index Pages"),

		array( "type" => "subnavtab-end",),

		array( "name" => "layout-1",
			   "type" => "subcontent-start",),

			array( "name" => "Choose which items to display in the single photo postinfo section",
				   "id" => $shortname."_postinfo1",
				   "type" => "different_checkboxes",
				   "std" => array("author","date","comments"),
				   "desc" => "Here you can choose which items appear in the postinfo section on single post pages. This is the area, usually below the post title, which displays basic information about your post. The highlighted itmes shown below will appear. ",
				   "options" => array("author","date","comments")),

			array( "name" => "Show comments on Post Pages",
				   "id" => $shortname."_show_postcomments",
				   "type" => "checkbox",
				   "std" => "on",
				   "desc" => "You can disable this option if you want to remove the comments and comment form from single post pages. "),

			array( "name" => "Display Thumbnails on Post",
            	   "id" => $shortname."_thumbnails",
            	   "type" => "checkbox2",
            	   "std" => "on",
            	   "desc" => "If you don't want to display thumbnail on posts you can disable this option. This is uesful if you already have a full sized image in the post and don't want to add a duplicate."),

			array( "type" => "clearfix",),


			array( "name" => "Size of Thumbnail (pixels)",
            	   "id" => $shortname."_thumbnail_size",
            	   "type" => "text",
            	   "validation_type" => "number",
            	   "std" => "200",
				   "desc" => "Here you can adjust the height/width of thumbnail images on post pages. The value is in pixels. The default size is 200x200 pixels."),

			array( "type" => "clearfix",),

		array( "name" => "layout-1",
			   "type" => "subcontent-end",),

		array( "name" => "layout-2",
			   "type" => "subcontent-start",),

			array( "name" => "Place Thumbs on Pages",
                   "id" => $shortname."_page_thumbnails",
                   "type" => "checkbox",
                   "std" => "false",
                   "desc" => "By default thumbnails are not placed on pages (they are only used on posts). However, if you want to use thumbnails on posts you can! Just enable this option. "),

			array( "name" => "Show comments on pages",
            "id" => $shortname."_show_pagescomments",
            "type" => "checkbox",
            "std" => "false",
			"desc" => "By default comments are not placed on pages, however, if you would like to allow people to comment on your pages simply enable this option. "),

			array( "type" => "clearfix",),

			array( "name" => "Adjust the width of thumbnail images",
				   "id" => $shortname."_thumbnail_width_pages",
				   "type" => "text",
				   "validation_type" => "number",
				   "std" => "200",
				   "desc" => "Here you can adjust the width of your thumbnail images. The width value is in pixels.",),

			array( "name" => "Adjust the height of thumbnail images",
				   "id" => $shortname."_thumbnail_height_pages",
				   "type" => "text",
				   "validation_type" => "number",
				   "std" => "200",
				   "desc" => "Here you can adjust the height of your thumbnail images. The height value is in pixels.",),

		array( "name" => "layout-2",
			   "type" => "subcontent-end",),

		array( "name" => "layout-3",
			   "type" => "subcontent-start",),

			array( "name" => "Excerpt Post Preview Mode",
				   "id" => $shortname."_excerpt",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "By default the theme creates a post preview based off the first few sentences of your post. If you would rather define your own excerpt via wordpress then enable this option and your post excerpts will be used instead of the automatic post preview.",),

			array( "name" => "Full Post Preview Mode",
				   "id" => $shortname."_full_post",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => "By default the theme creates a post preview based off the first few sentences of your post. If you would rather display your entire post content instead of using a preview then enable this option.",),

			array( "type" => "clearfix",),

			array( "name" => "Display Thumbnails",
            	   "id" => $shortname."_thumbnails_index",
            	   "type" => "checkbox",
            	   "std" => "on",
            	   "desc" => "If you don't want to use thumbnail images on index and category pages then simply disbale this option. This removes all thumbnail images."),

			array( "name" => "Display Read More Link",
            	   "id" => $shortname."_readmore_link",
            	   "type" => "checkbox2",
            	   "std" => "on",
            	   "desc" => "If you would like to remove the ReadMore link from index pages then disable this option."),

			array( "type" => "clearfix",),

			array( "name" => "Size of Thumbnail (pixels)",
            	   "id" => $shortname."_thumbnail_size_index",
            	   "type" => "text",
            	   "validation_type" => "number",
            	   "std" => "200",
				   "desc" => "Here you can adjust the height/width of thumbnail images on post pages. The value is in pixels. The default size is 200x200 pixels."),

			array( "type" => "clearfix",),

			array( "name" => "Character length of preview text",
				   "id" => $shortname."_content_limit",
				   "std" => "400",
				   "type" => "text",
				   "validation_type" => "number",
				   "desc" => "Here you can choose how many characters are displayed in your post previews. If you are using excerpt mode then this setting does not apply."),

		array( "name" => "layout-3",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-layout",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-colorization",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "colorization-1",
				   "type" => "subnav-tab",
				   "desc" => "Colorization"),

		array( "type" => "subnavtab-end",),

		array( "name" => "colorization-1",
			   "type" => "subcontent-start",),

			array( "name" => "Color visualizer (this is not setting, just a tool to find hexdecimal values)",
				   "type" => "colorpicker",
				   "desc" => "This is a tool that can be used to find hexdecimal color values. These values can be used to customize the colors of the various elements below. This color picker will also appear which you click in any of the fields below. ",),

			array( "name" => "Enable custom colors",
                   "id" => $shortname."_custom_colors",
                   "type" => "checkbox",
                   "std" => "false",
                   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click in the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value."),

			array( "name" => "Enable child stylesheet",
                   "id" => $shortname."_child_css",
                   "type" => "checkbox2",
                   "std" => "false",
                   "desc" => "If you would like to add a second stylsheet to your blog enable this option and input the link to your stylesheet below."),

			array( "type" => "clearfix",),

			array( "name" => "Child stylesheet URL",
				   "id" => $shortname."_child_cssurl",
				   "type" => "text",
				   "validation_type" => "url",
				   "std" => "",
				   "desc" => "Input the URL to your child stylsheet here.",),

			array( "name" => "Background color",
				   "id" => $shortname."_color_bgcolor",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value.",),

			array( "name" => "Main font color",
				   "id" => $shortname."_color_mainfont",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Main link color (in the post body)",
				   "id" => $shortname."_color_mainlink",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Page menu link color",
				   "id" => $shortname."_color_pagelink",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Categories menu link color",
				   "id" => $shortname."_color_catslink",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "From the blog post info font color",
				   "id" => $shortname."_color_postinfo",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Featured article header color",
				   "id" => $shortname."_color_featheader",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Featured article text color",
				   "id" => $shortname."_color_feattext",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Sidebar title headings background color",
				   "id" => $shortname."_color_sidebarbg_titles",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Sidebar title headings color",
				   "id" => $shortname."_color_sidebar_titles",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

		    array( "name" => "Footer widgets headings color",
				   "id" => $shortname."_color_footer_titles",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Footer links color",
				   "id" => $shortname."_color_footer_links",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Page/Post heading title color",
				   "id" => $shortname."_color_heading",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

		array( "name" => "colorization-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-colorization",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//
	array( "name" => "wrap-seo",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "seo-1",
				   "type" => "subnav-tab",
				   "desc" => "Homepage SEO",),

			array( "name" => "seo-2",
				   "type" => "subnav-tab",
				   "desc" => "Single Post Page SEO",),

			array( "name" => "seo-3",
				   "type" => "subnav-tab",
				   "desc" => "Index Page SEO",),

		array( "type" => "subnavtab-end",),

		array( "name" => "seo-1",
			   "type" => "subcontent-start",),

			array( "name" => " Enable custom title ",
				   "id" => $shortname."_seo_home_title",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "By default the theme uses a combination of your blog name and your blog description, as defined when you created your blog, to create your homepage titles. However if you want to create a custom title then simply enable this option and fill in the custom title field below. ",),

			array( "name" => " Enable meta description",
				   "id" => $shortname."_seo_home_description",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "By default the theme uses your blog description, as defined when you created your blog, to fill in the meta description field. If you would like to use a different description then enable this option and fill in the custom description field below. ",),

			array( "name" => " Enable meta keywords",
				   "id" => $shortname."_seo_home_keywords",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "By default the theme does not add keywords to your header. Most search engines don't use keywords to rank your site anymore, but some people define them anyway just in case. If you want to add meta keywords to your header then enable this option and fill in the custom keywords field below. ",),

			array( "name" => " Enable canonical URL's",
				   "id" => $shortname."_seo_home_canonical",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URLs all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",),

			array( "type" => "clearfix",),

			array( "name" => "Homepage custom title (if enabled)",
				   "id" => $shortname."_seo_home_titletext",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => "",
				   "desc" => "If you have enabled custom titles you can add your custom title here. Whatever you type here will be placed between the < title >< /title > tags in header.php",),

			array( "name" => "Homepage meta description (if enabled)",
				   "id" => $shortname."_seo_home_descriptiontext",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "If you have enabled meta descriptions you can add your custom description here.",),

			array( "name" => "Homepage meta keywords (if enabled)",
				   "id" => $shortname."_seo_home_keywordstext",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => "",
				   "desc" => "If you have enabled meta keywords you can add your custom keywords here. Keywords should be separated by comas. For example: wordpress,themes,templates,elegant",),

			array( "name" => "If custom titles are disabled, choose autogeneration method",
				   "id" => $shortname."_seo_home_type",
				   "type" => "select",
				   "std" => "BlogName | Blog description",
				   "options" => array("BlogName | Blog description", "Blog description | BlogName", "BlogName only"),
				   "desc" => "If you are not using cutsom post titles you can still have control over how your titles are generated. Here you can choose which order you would like your post title and blog name to be displayed, or you can remove the blog name from the title completely.",),

			array( "name" => "Define a character to separate BlogName and Post title",
				   "id" => $shortname."_seo_home_separate",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => " | ",
				   "desc" => "Here you can change which character separates your blog title and post name when using autogenerated post titles. Common values are | or -",),

		array( "name" => "seo-1",
			   "type" => "subcontent-end",),

		array( "name" => "seo-2",
			   "type" => "subcontent-start",),

			array( "name" => "Enable custom titles",
				   "id" => $shortname."_seo_single_title",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "By default the theme creates post titles based on the title of your post and your blog name. If you would like to make your meta title different than your actual post title you can define a custom title for each post using custom fields. This option must be enabled for custom titles to work, and you must choose a custom field name for your title below.",),

			array( "name" => "Enable custom description",
				   "id" => $shortname."_seo_single_description",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => "If you would like to add a meta description to your post you can do so using custom fields. This option must be enabled for descriptions to be displayed on post pages. You can add your meta description using custom fields based off the custom field name you define below.",),

			array( "type" => "clearfix",),

			array( "name" => "Enable custom keywords",
				   "id" => $shortname."_seo_single_keywords",
				   	"type" => "checkbox",
				   "std" => "false",
				   "desc" => "If you would like to add meta keywords to your post you can do so using custom fields. This option must be enabled for keywords to be displayed on post pages. You can add your meta keywords using custom fields based off the custom field name you define below.",),

			array( "name" => "Enable canonical URL's",
				   "id" => $shortname."_seo_single_canonical",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => "Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URL's all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",),

			array( "type" => "clearfix",),

			array( "name" => "Custom field Name to be used for title",
				   "id" => $shortname."_seo_single_field_title",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => "seo_title",
				   "desc" => "When you define your title using custom fields you should use this value for the custom field Name. The Value of your custom field should be the custom title you would like to use.",),

			array( "name" => "Custom field Name to be used for description",
				   "id" => $shortname."_seo_single_field_description",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => "seo_description",
				   "desc" => "When you define your meta description using custom fields you should use this value for the custom field Name. The Value of your custom field should be the custom description you would like to use.",),

			array( "name" => "Custom field Name to be used for keywords",
				   "id" => $shortname."_seo_single_field_keywords",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => "seo_keywords",
				   "desc" => "When you define your keywords using custom fields you should use this value for the custom field Name. The Value of your custom field should be the meta keywords you would like to use, separated by comas.",),

			array( "name" => "If custom titles are disabled, choose autogeneration method",
				   "id" => $shortname."_seo_single_type",
				   "type" => "select",
				   "std" => "Post title | BlogName",
				   "options" => array("Post title | BlogName", "BlogName | Post title", "Post title only"),
				   "desc" => "If you are not using cutsom post titles you can still have control over hw your titles are generated. Here you can choose which order you would like your post title and blog name to be displayed, or you can remove the blog name from the title completely.",),

			array( "name" => "Define a character to separate BlogName and Post title",
				   "id" => $shortname."_seo_single_separate",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => " | ",
				   "desc" => "Here you can change which character separates your blog title and post name when using autogenerated post titles. Common values are | or -",),

		array( "name" => "seo-2",
			   "type" => "subcontent-end",),

		array( "name" => "seo-3",
				   "type" => "subcontent-start",),

			array( "name" => " Enable canonical URL's",
				   "id" => $shortname."_seo_index_canonical",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URL's all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",),

			array( "name" => "Enable meta descriptions",
				   "id" => $shortname."_seo_index_description",
				   	"type" => "checkbox2",
				   "std" => "false",
				   "desc" => "Check this box if you want to display meta descriptions on category/archive pages. The description is based off the category description you choose when creating/edit your category in wp-admin.",),

			array( "type" => "clearfix",),

			array( "name" => "Choose title autogeneration method",
				   "id" => $shortname."_seo_index_type",
				   "type" => "select",
				   "std" => "Category name | BlogName",
				   "options" => array("Category name | BlogName", "BlogName | Category name", "Category name only"),
				   "desc" => "Here you can choose how your titles on index pages are generated. You can change which order your blog name and index title are displayed, or you can remove the blog name from the title completely.",),

			array( "name" => "Define a character to separate BlogName and Post title",
				   "id" => $shortname."_seo_index_separate",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => " | ",
				   "desc" => "Here you can change which character separates your blog title and index page name when using autogenerated post titles. Common values are | or -",),

			array( "type" => "clearfix",),

		array( "name" => "seo-3",
				   "type" => "subcontent-end",),

	array(  "name" => "wrap-seo",
			"type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-integration",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "integration-1",
				   "type" => "subnav-tab",
				   "desc" => "Code Integration"),

		array( "type" => "subnavtab-end",),

		array( "name" => "integration-1",
			   "type" => "subcontent-start",),

			array( "name" => "Disable header code",
                   "id" => $shortname."_integrate_header_enable",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "Disabling this option will remove the header code below from your blog. This allows you to remove the code while saving it for later use."),

			array( "name" => "Disable body code",
                   "id" => $shortname."_integrate_body_enable",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "Disabling this option will remove the body code below from your blog. This allows you to remove the code while saving it for later use."),

			array( "type" => "clearfix",),

			array( "name" => "Disable single top code",
                   "id" => $shortname."_integrate_singletop_enable",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "Disabling this option will remove the single top code below from your blog. This allows you to remove the code while saving it for later use."),

			array( "name" => "Disable single bottom code",
                   "id" => $shortname."_integrate_singlebottom_enable",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "Disabling this option will remove the single bottom code below from your blog. This allows you to remove the code while saving it for later use."),

			array( "type" => "clearfix",),

			array( "name" => "Add code to the < head > of your blog",
				   "id" => $shortname."_integration_head",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "Any code you place here will appear in the head section of every page of your blog. This is useful when you need to add javascript or css to all pages.",),

			array( "name" => "Add code to the < body > (good tracking codes such as google analytics)",
				   "id" => $shortname."_integration_body",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "Any code you place here will appear in body section of all pages of your blog. This is usefull if you need to input a tracking pixel for a state counter such as Google Analytics.",),

			array( "name" => "Add code to the top of your posts",
				   "id" => $shortname."_integration_single_top",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "Any code you place here will be placed at the top of all single posts. This is useful if you are looking to integrating things such as social bookmarking links.",),

			array( "name" => "Add code to the bottom of your posts, before the comments",
				   "id" => $shortname."_integration_single_bottom",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "Any code you place here will be placed at the top of all single posts. This is useful if you are looking to integrating things such as social bookmarking links.",),

		array( "name" => "integration-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-integration",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-support",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "support-1",
				   "type" => "subnav-tab",
				   "desc" => "Documentation"),

		array( "type" => "subnavtab-end",),

		array( "name" => "support-1",
			   "type" => "subcontent-start",),

			array( "name" => "installation",
				   "type" => "support",),

		array( "name" => "support-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-support",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-updates",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "updates-1",
				   "type" => "subnav-tab",
				   "desc" => esc_html__("General",$themename)
			),

		array( "type" => "subnavtab-end",),

		array( "name" => "updates-1",
			   "type" => "subcontent-start",),

			array(
				'name'              => esc_html__( 'Username', $themename ),
				'id'                => 'et_automatic_updates_options_username',
				'std'               => '',
				'type'              => 'password',
				'validation_type'   => 'nohtml',
				'desc'              => et_get_safe_localization( __( 'Before you can receive product updates, you must first authenticate your Elegant Themes subscription. To do this, you need to enter both your Elegant Themes Username and your Elegant Themes API Key. Your username is the same username you use when logging in to <a href="http://elegantthemes.com/" target="_blank">ElegantThemes.com</a>', $themename ) ),
				'is_global'         => true,
				'main_setting_name' => 'et_automatic_updates_options',
				'sub_setting_name'  => 'username',
			),

			array(
				'name'            => esc_html__( 'API Key', $themename ),
				'id'              => 'et_automatic_updates_options_api_key',
				'std'             => '',
				'type'            => 'password',
				'validation_type' => 'nohtml',
				'desc'            => et_get_safe_localization( __( 'Before you can receive product updates, you must first authenticate your Elegant Themes subscription. To do this, you need to enter both your Elegant Themes Username and your Elegant Themes API Key. To locate your API Key, <a href="https://www.elegantthemes.com/members-area/" target="_blank">log in</a> to your Elegant Themes account and navigate to the <strong>Account > API Key</strong> page.', $themename ) ),
				'is_global'         => true,
				'main_setting_name' => 'et_automatic_updates_options',
				'sub_setting_name'  => 'api_key',
			),

		array( "name" => "updates-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-updates",
		   "type" => "contenttab-wrapend",),

	array( "name" => "wrap-advertisements",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "advertisements-1",
				   "type" => "subnav-tab",
				   "desc" => "Manage Un-widgetized Advertisements"),

		array( "type" => "subnavtab-end",),

		array( "name" => "advertisements-1",
			   "type" => "subcontent-start",),

			array( "name" => "Enable 468x60 banner",
				   "id" => $shortname."_foursixeight",
				   	"type" => "checkbox",
				   "std" => "false",
				   "desc" => "Enabling this option will display a 468x60 banner ad on the bottom of your post pages below the single post content. If enabled you must fill in the banner image and destination url below.",),

			array( "type" => "clearfix",),

			array( "name" => "Input 468x60 advertisement banner image",
				   "id" => $shortname."_banner_468",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "If you have the 468x60 banner ad enabled then you should input the URL of the banner image you would like to use here.",),

			array( "name" => "Input 468x60 advertisement destination url",
				   "id" => $shortname."_banner_468_url",
				   "type" => "text",
				   "validation_type" => "url",
				   "std" => "",
				   "desc" => "If you have the 468x60 banner ad enabled then you should input the destination URL of the banner ad here.",),

		array( "name" => "advertisements-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-support",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//
);