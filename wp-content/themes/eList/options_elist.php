<?php
global $epanelMainTabs, $themename, $shortname, $options, $et_bg_texture_urls, $et_google_fonts, $epanel_texture_urls;

$epanelMainTabs = array('general','navigation','layout','ad','colorization','seo','integration','support','updates');

$cats_array = get_categories('hide_empty=0');
$pages_array = get_pages('hide_empty=0');
$pages_number = count($pages_array);

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

$shortname 	= esc_html( $shortname );
$pages_ids 	= array_map( 'intval', $pages_ids );
$cats_ids 	= array_map( 'intval', $cats_ids );

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
				   "desc" => "Featured Slider"),

			array( "name" => "general-4",
				   "type" => "subnav-tab",
				   "desc" => "Paid Listings Options"),

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

			array( "name" => "Background Color",
				   "id" => $shortname."_bgcolor",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This will enable a custom background color. Selecting the field will bring up the color picker which will allow you to choose a custom color.",),

			array( "name" => "Background Texture",
				   "id" => $shortname."_bgtexture_url",
				   "type" => "select",
				   "std" => "Default",
				   "options" => $epanel_texture_urls,
				   "desc" => "Choose a background texture from the drop down menu.",),

			array( "name" => "Background Image",
				   "id" => $shortname."_bgimage",
				   "type" => "upload",
				   "std" => "",
				   "desc" => "If you would like to upload your own background image click the Upload Image button."
			),

			array( "name" => "Header Font",
				   "id" => $shortname."_header_font",
				   "type" => "select",
				   "std" => "Lobster",
				   "options" => $et_google_fonts,
				   "desc" => "Choose a font from the drop down menu.",),

			array( "name" => "Header Font Color",
				   "id" => $shortname."_header_font_color",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This will enable a custom header font color. Selecting the field will bring up the color picker which will allow you to choose a custom color.",),

			array( "name" => "Body Font",
				   "id" => $shortname."_body_font",
				   "type" => "select",
				   "std" => "Droid Sans",
				   "options" => $et_google_fonts,
				   "desc" => "Choose a font from the drop down menu.",),

			array( "name" => "Body Font Color",
				   "id" => $shortname."_body_font_color",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This will enable a custom body font color. Selecting the field will bring up the color picker which will allow you to choose a custom color.",),

			array( "name" => "Grab the first post image",
				   "id" => $shortname."_grab_image",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "By default thumbnail images are created using custom fields. However, if you would rather use the images that are already in your post for your thumbnail (and bypass using custom fields) you can activate this option. Once activcated thumbnail images will be generated automatically using the first image in your post. The image must be hosted on your own server."),

			array( "name" => "Admin should publish submitted listings",
				   "id" => $shortname."_sumbit_as_drafts",
				   "type" => "checkbox2",
				   "std" => "on",
				   "desc" => "Disable this option if you want submitted listings to post without Admin approval. "),

			array( "type" => "clearfix",),

			array( "name" => "Show Twitter Icon",
                   "id" => $shortname."_show_twitter_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "Here you can choose to display the Twitter icon on the homepage. "),

			array( "name" => "Show RSS Icon",
                   "id" => $shortname."_show_rss_icon",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "Here you can choose to display the RSS icon on the homepage. "),

			array( "type" => "clearfix",),

			array( "name" => "Show Facebook Icon",
                   "id" => $shortname."_show_facebook_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "Here you can choose to display the Facebook icon on the homepage. "),

			array( "type" => "clearfix",),

			array( "name" => "Twitter Profile Url",
                   "id" => $shortname."_twitter_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => "Place your Twitter Profile URL here. "),

			array( "name" => "RSS Icon Url",
                   "id" => $shortname."_rss_url",
                   "std" => "",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => "Place your RSS URL here. "),

			array( "name" => "Facebook Profile Url",
                   "id" => $shortname."_facebook_url",
                   "std" => "#",
                   "type" => "text",
                   "validation_type" => "url",
				   "desc" => "Place your Facebook Profile URL here. "),

			array( "name" => "Submit Listing Page",
				   "id" => $shortname."_submit_listing_page",
				   "std" => "",
				   "type" => "select",
				   "desc" => "Here you can choose the page for the Submit Listings as outlined in the theme readme. ",
				   "options" => $site_pages,
				   'et_array_for' => 'pages'),

			array(
				"name"              => esc_html__( "Google API Key", $themename ),
				"id"                => "et_google_api_settings_api_key",
				"std"               => "",
				"type"              => "text",
				"validation_type"   => "nohtml",
				'is_global'         => true,
				'main_setting_name' => 'et_google_api_settings',
				'sub_setting_name'  => 'api_key',
				"desc"              => et_get_safe_localization( sprintf( __( 'The theme uses the Google Maps API and requires a valid Google API Key in order to function. Learn more about how to create your Google API Key <a target="_blank" href="%1$s">here</a>.', $themename ), 'http://www.elegantthemes.com/gallery/divi/documentation/map/#gmaps-api-key' ) ),
			),

			array( "name" => "Show Google Address Field in 'Submit a Listing' Form",
                   "id" => $shortname."_show_google_maps_field",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "Here you can choose to display the Google Address field in the Submit Listings form. "),

			array( "name" => "Show Company Website Field in 'Submit a Listing' Form",
                   "id" => $shortname."_show_company_website_field",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "Here you can choose to display the Company Website field in the Submit Listings form. "),

			array( "type" => "clearfix",),

			array( "name" => "Number of Posts displayed on Category page",
                   "id" => $shortname."_catnum_posts",
                   "std" => "6",
                   "type" => "text",
                   "validation_type" => "number",
				   "desc" => "Here you can designate how many recent articles are displayed on the Category page. This option works independently from the Settings > Reading options in wp-admin."),

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

			array( "name" => "Date format",
				   "id" => $shortname."_date_format",
				   "std" => "n-j-y",
                   "type" => "text",
                   "validation_type" => "nohtml",
				   "desc" => "This option allows you to change how your dates are displayed. For more information please refer to the WordPress codex here:<a href='http://codex.wordpress.org/Formatting_Date_and_Time' target='_blank'>Formatting Date and Time</a>"),

			array( "type" => "clearfix",),

			array( "name" => "Use excerpts when defined",
				   "id" => $shortname."_use_excerpt",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "This will enable the use of excerpts in posts or pages."),

			array( "name" => "Show Control Panel",
				   "id" => $shortname."_show_control_panel",
				   "type" => "checkbox2",
				   "std" => "on",
				   "desc" => "Here you can choose to show the CSS Control Panel on your homepage. It will only be visible to Administrators that are logged into your Wordpress Dashboard."),

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

			array( "name" => "Hide empty listing categories",
				   "id" => $shortname."_listings_hide_empty",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "Here you can choose to hide or display empty listing categories from the homeapge. "),

			array( "type" => "clearfix",),

			array( "name" => "Number of Recent Listings displayed on homepage",
                   "id" => $shortname."_recent_listings_num",
                   "std" => "3",
                   "type" => "text",
                   "validation_type" => "number",
				   "desc" => "Here you can designate how many recent listings are displayed on the homepage. This option works independently from the Settings > Reading options in wp-admin."),

		array( "name" => "general-2",
			   "type" => "subcontent-end",),

		array( "name" => "general-3",
				   "type" => "subcontent-start",),

			array( "name" => "Display Featured Slider on Homepage",
                   "id" => $shortname."_featured",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "You can choose whether or not to display the Featured Articles section on the homepge. If you don't want to utilize this feature simply disable this option."),

			array( "name" => "Display Featured Slider on Listing Category pages",
                   "id" => $shortname."_featured_index",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "You can choose whether or not to display the Featured Articles section on the homepge. If you don't want to utilize this feature simply disable this option."),

			array( "type" => "clearfix",),

			array( "name" => "Number of Featured Slides on Homepage",
                   "id" => $shortname."_featured_num",
                   "std" => "4",
                   "type" => "text",
                   "validation_type" => "number",
				   "desc" => "This setting controls how menu tabs are added to the Featured Articles slider on the homepage."),

			array( "name" => "Number of Featured Slides on Listing Category pages",
                   "id" => $shortname."_listings_featured_num",
                   "std" => "4",
                   "type" => "text",
                   "validation_type" => "number",
				   "desc" => "This setting controls how menu tabs are added to the Featured Articles slider on the homepage."),

			array( "name" => "Automatic Slider Animation",
                   "id" => $shortname."_slider_auto",
                   "type" => "checkbox",
                   "std" => "false",
                   "desc" => "If you would like the Featured Articles slider to slide automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired."),

			array( "name" => "Pause Autoscroll on hover",
                   "id" => $shortname."_slider_pause",
                   "type" => "checkbox2",
                   "std" => "false",
                   "desc" => "If you have enabled Auto Rotation of Featured Articles, then you can enable this option to have the rotation stop while the user's mouse is hovered over the slider."),

			array( "type" => "clearfix",),

			array( "name" => "Automatic Animation Speed (in ms)",
                   "id" => $shortname."_slider_autospeed",
                   "type" => "text",
                   "validation_type" => "number",
			       "std" => "7000",
				   "desc" => "Here you can designate how fast the slider fades between each article. The higher the number the longer the pause between each rotation."),

		array( "name" => "general-3",
			   "type" => "subcontent-end",),

		array( "name" => "general-4",
				"type" => "subcontent-start",),

			array( "name" => "Enable paid listings",
				   "id" => $shortname."_paid_listings",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "Enable this option if you would like to use Paid Listings. "),

			array( "name" => "Paypal Test Mode",
				   "id" => $shortname."_paypal_test_mode",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => "Here you can choose to enable PayPal test mode. "),

			array( "type" => "clearfix",),

			array( "name" => "Paypal email",
				   "id" => $shortname."_paypal_email",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => "",
				   "desc" => "Enter your paypal email here"),

			array( "name" => "Paypal currency",
				   "id" => $shortname."_paypal_currency",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => "USD",
				   "desc" => "Enter paypal currency here"),

			array( "name" => "Paypal currency sign",
				   "id" => $shortname."_paypal_currency_sign",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => "$",
				   "desc" => "Enter paypal currency sign here"),

			array( "name" => "Standard subscription",
				   "id" => $shortname."_standart_subscription",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => "19.99",
				   "desc" => "Enter the price you would like the Standard Subscription to be. "),

			array( "name" => "Featured subscription add-on",
				   "id" => $shortname."_featured_subscription",
				   "type" => "text",
				   "validation_type" => "nohtml",
				   "std" => "9.99",
				   "desc" => "Enter the price you would like the the Featured Subscription to be. "),

			array( "name" => "Number of days a paid listing stays featured",
				   "id" => $shortname."_paid_listing_expire_days",
				   "type" => "text",
				   "validation_type" => "number",
				   "std" => "10",
				   "desc" => "Here you can choose the number of paid listings you would like to display on the homepage. "),

			array( "type" => "clearfix",),

		array( "name" => "general-4",
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
				   "std" => "",
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

			array( "name" => "Number of dropdown tiers shown",
            "id" => $shortname."_tiers_shown_pages",
            "type" => "text",
            "validation_type" => "number",
            "std" => "3",
			"desc" => "This options allows you to control how many teirs your pages dropdown menu has. Increasing the number allows for additional menu items to be shown."),

			array( "type" => "clearfix",),


		array( "name" => "navigation-1",
			   "type" => "subcontent-end",),

		array( "name" => "navigation-2",
			   "type" => "subcontent-start",),

			array( "name" => "Exclude categories from the navigation bar",
				   "id" => $shortname."_menucats",
				   "type" => "checkboxes",
				   "std" => "",
				   "desc" => "Here you can choose to remove certain categories from the navigation menu. All categories marked with an X will not appear in your navigation bar. ",
				   "usefor" => "categories",
				   "options" => $cats_ids),

			array( "name" => "Show dropdown menus",
            "id" => $shortname."_enable_dropdowns_categories",
            "type" => "checkbox",
            "std" => "on",
			"desc" => "If you would like to remove the dropdown menus from the categories navigation bar disable this feature."),

			array( "name" => "Hide empty categories",
            "id" => $shortname."_categories_empty",
            "type" => "checkbox",
            "std" => "on",
			"desc" => "If you would like categories to be displayed in your navigation bar that don't have any posts in them then disable this option. By default empty categories are hidden"),

			array( "type" => "clearfix",),

			array( "name" => "Number of dropdown tiers shown",
            "id" => $shortname."_tiers_shown_categories",
            "type" => "text",
            "validation_type" => "number",
            "std" => "3",
			"desc" => "This options allows you to control how many teirs your pages dropdown menu has. Increasing the number allows for additional menu items to be shown."),

			array( "type" => "clearfix",),

		    array( "name" => "Sort Categories Links by Name/ID/Slug/Count/Term Group",
                   "id" => $shortname."_sort_cat",
                   "type" => "select",
                   "std" => "name",
				   "desc" => "By default pages are sorted by name. However if you would rather have them sorted by ID you can adjust this setting.",
                   "options" => array("name", "ID", "slug", "count", "term_group")),

			array( "name" => "Order Category Links by Ascending/Descending",
                   "id" => $shortname."_order_cat",
                   "type" => "select",
                   "std" => "asc",
				   "desc" => "Here you can choose to reverse the order that your categories links are displayed. You can choose between ascending and descending.",
                   "options" => array("asc", "desc")),

		array( "name" => "navigation-2",
			   "type" => "subcontent-end",),

		array( "name" => "navigation-3",
			   "type" => "subcontent-start",),

			array( "name" => "Disable top tier dropdown menu links",
            "id" => $shortname."_disable_toptier",
            "type" => "checkbox2",
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
				   "desc" => "Single Post Layout"),

			array( "name" => "layout-2",
				   "type" => "subnav-tab",
				   "desc" => "Single Page Layout"),

			array( "name" => "layout-3",
				   "type" => "subnav-tab",
				   "desc" => "General Settings"),

		array( "type" => "subnavtab-end",),

		array( "name" => "layout-1",
			   "type" => "subcontent-start",),

			array( "name" => "Choose which items to display in the postinfo section",
				   "id" => $shortname."_postinfo2",
				   "type" => "different_checkboxes",
				   "std" => array("author","date","categories","comments"),
				   "desc" => "Here you can choose which items appear in the postinfo section on single post pages. This is the area, usually below the post title, which displays basic information about your post. The highlighted itmes shown below will appear. ",
				   "options" => array("author","date","categories","comments")),

			array( "name" => "Place Thumbs on Posts",
                   "id" => $shortname."_thumbnails",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "By default thumbnails are placed at the beginning of your post on single post pages. If you would like to remove this initial thumbnail image to avoid repetition simply disable this option. "),

			array( "name" => "Show comments on posts",
            "id" => $shortname."_show_postcomments",
            "type" => "checkbox2",
            "std" => "on",
			"desc" => "You can disable this option if you want to remove the comments and comment form from single post pages. "),

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

		array( "name" => "layout-2",
			   "type" => "subcontent-end",),

		array( "name" => "layout-3",
			   "type" => "subcontent-start",),

			array( "name" => "Post info section",
				   "id" => $shortname."_postinfo1",
				   "type" => "different_checkboxes",
				   "std" => array("author","date","categories","comments"),
				   "desc" => "Here you can choose which items appear in the postinfo section on pages. This is the area, usually below the post title, which displays basic information about your post. The highlighted itmes shown below will appear. ",
				   "options" => array("author","date","categories","comments")),

			array( "type" => "clearfix",),

			array( "name" => "Show Thumbs on Index pages",
                   "id" => $shortname."_thumbnails_index",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "Enable this option to show thumbnails on Index Pages."),

			array( "type" => "clearfix",),

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

			array( "name" => "Main font color",
				   "id" => $shortname."_color_mainfont",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Link color",
				   "id" => $shortname."_color_mainlink",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Menu link color",
				   "id" => $shortname."_color_pagelink",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Menu active link color",
				   "id" => $shortname."_color_pagelink_active",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Headings color",
				   "id" => $shortname."_color_headings",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Sidebar links color",
				   "id" => $shortname."_color_sidebar_links",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Footer text color",
				   "id" => $shortname."_footer_text",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

		    array( "name" => "Footer links color",
				   "id" => $shortname."_color_footerlinks",
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

			array( "name" => "Enable header code",
                   "id" => $shortname."_integrate_header_enable",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "Disabling this option will remove the header code below from your blog. This allows you to remove the code while saving it for later use."),

			array( "name" => "Enable body code",
                   "id" => $shortname."_integrate_body_enable",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "Disabling this option will remove the body code below from your blog. This allows you to remove the code while saving it for later use."),

			array( "type" => "clearfix",),

			array( "name" => "Enable single top code",
                   "id" => $shortname."_integrate_singletop_enable",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "Disabling this option will remove the single top code below from your blog. This allows you to remove the code while saving it for later use."),

			array( "name" => "Enable single bottom code",
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

			array( "name" => "Add code to the < body > (good for tracking codes such as google analytics)",
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
				   "id" => $shortname."_468_enable",
				   	"type" => "checkbox",
				   "std" => "false",
				   "desc" => "Enabling this option will display a 468x60 banner ad on the bottom of your post pages below the single post content. If enabled you must fill in the banner image and destination url below.",),

			array( "type" => "clearfix",),

			array( "name" => "Input 468x60 advertisement banner image",
				   "id" => $shortname."_468_image",
				   "type" => "text",
				   "validation_type" => "url",
				   "std" => "",
				   "desc" => "Here you can change which character separates your blog title and index page name when using autogenerated post titles. Common values are | or -",),

			array( "name" => "Input 468x60 advertisement destination url",
				   "id" => $shortname."_468_url",
				   "type" => "text",
				   "validation_type" => "url",
				   "std" => "",
				   "desc" => "Here you can change which character separates your blog title and index page name when using autogenerated post titles. Common values are | or -",),

			array( "name" => "Input 468x60 adsense code",
				   "id" => $shortname."_468_adsense",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "Place your adsense code here.",),

		array( "name" => "advertisements-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-support",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

);