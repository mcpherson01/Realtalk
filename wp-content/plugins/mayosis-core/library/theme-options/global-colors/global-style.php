<?php
Mayosis_Option::add_panel( 'mayosis_studio', array(
	'title'       => __( 'Global Styles', 'mayosis' ),
	'description' => __( 'Mayosis Global Style Options.', 'mayosis' ),
	'priority' => '1',
) );

Mayosis_Option::add_section( 'common_color', array(
	'title'       => __( 'Common Style', 'mayosis' ),
	'panel'       => 'mayosis_studio',

) );


Mayosis_Option::add_section( 'product_color', array(
	'title'       => __( 'Thumbnail & Label Colors', 'mayosis' ),
	'panel'       => 'mayosis_studio',

) );

Mayosis_Option::add_section( 'widget_color', array(
	'title'       => __( 'Widget Colors', 'mayosis' ),
	'panel'       => 'mayosis_studio',

) );

Mayosis_Option::add_section( 'footer_color', array(
	'title'       => __( 'Footer Colors', 'mayosis' ),
	'panel'       => 'mayosis_studio',

) );

Mayosis_Option::add_section( 'composer_color', array(
	'title'       => __( 'Page Builder Colors', 'mayosis' ),
	'panel'       => 'mayosis_studio',

) );

Mayosis_Option::add_section( 'button_style', array(
	'title'       => __( 'Button Style', 'mayosis' ),
	'panel'       => 'mayosis_studio',

) );

//Start Common Colors
Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'mayosis_body_color',
        'label'       => __( 'Body Color', 'mayosis' ),
        'description' => __( 'Change site background color', 'mayosis' ),
        'section'     => 'common_color',
        'priority'    => 10,
        'default'     => '#ffffff',
        'transport' =>$transport,
        'output' => array(
            	array(
            		'element'  => 'body,.fes-form.fes-submission-form-div,.fes-fields table,#fes-vendor-dashboard table,#fes-product-list tbody tr td,.fes-profile-form',
            		'property' => 'background',
            	),
            	
            	array(
            		'element'  => '.fes-form.fes-submission-form-div,.fes-fields table,#fes-vendor-dashboard table,#fes-product-list tbody tr td,.fes-profile-form',
            		'property' => 'border-color',
            	),
    	),
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#ff6b6b',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
));

Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'mayosis_secondary_color',
        'label'       => __( 'Secondary Background Color', 'mayosis' ),
        'description' => __( 'Change Secondary Backgrounnd Color', 'mayosis' ),
        'section'     => 'common_color',
        'priority'    => 10,
        'default'     => '#f0f1f2',
        'transport' =>$transport,
        'output' => array(
            	array(
            		'element'  => '.bottom-post-footer-widget,.post-view-style,.post-promo-box,.sidebar-theme,.author_meta_single,.single_author_post,.sidebar-product-widget,.single-blog-widget,
        blockquote,table,pre,
        .fes-fields textarea,.single--author--content,.jssortside,#mayosisone_1,#mayosis_side,.theme--sidebar--widget,.photo--price--block a.edd-wl-action.edd-wl-button,.photo--price--block .photo_edd_el_button',
            		'property' => 'background',
            	),
            	
            	array(
            		'element'  => 'table#edd_purchase_receipt, table#edd_purchase_receipt_products,table,pre,code,.photo--price--block a.edd-wl-action.edd-wl-button,.photo--price--block .photo_edd_el_button',
            		'property' => 'border-color',
            	),
            	
    	),
    	
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#ff6b6b',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
    ));
    
    
    Mayosis_Option::add_field( 'mayo_config', array(
                'type'        => 'color',
                'settings'     => 'accent_color',
                'label'       => __( 'Primary Color', 'mayosis' ),
                'description' => __( 'Whole Site Accent Color', 'mayosis' ),
                'section'     => 'common_color',
                'priority'    => 10,
                'default'     => '#5a00f0',
                'transport' =>$transport,
        'output' => array(
            	array(
            		'element'  => '#commentform input[type=submit],.slider_dm_v .carousel-indicators .active, #edd-purchase-button,.edd-submit,input.edd-submit[type="submit"],
        .dm_register_button,.back-to-top:hover,button.fes-cmt-submit-form,.mini_cart .cart_item.edd_checkout a,.photo-image-zoom,
        a.edd-wl-button.edd-wl-save.edd-wl-action,
        .wishlist-with-bg .edd-wl-button.edd-wl-action,
        .edd-wl-create input[type=submit],nav.fes-vendor-menu ul li.active::after,
        .edd-wl-item-purchase .edd-add-to-cart-from-wish-list,.button-sub-right .btn,.fes-product-list-td a, .upload-cover-button, .wpcf7-submit,.status-publish.sticky:before, .footer-link-page-post  .footer-page-post-link,.lSSlideOuter .lSPager.lSpg > li:hover a, .lSSlideOuter .lSPager.lSpg > li.active a,.lSSlideOuter .lSPager.lSpg > li a,.edd-submit.button.blue, .single-cart-button a.btn, .edd_purchase_submit_wrapper a.edd-add-to-cart.edd-has-js, .single-news-letter  .nl__item--submit:hover,.edd-submit.button.blue:hover, .single-cart-button a:hover.btn, .edd_purchase_submit_wrapper a.edd-add-to-cart.edd-has-js:hover,#commentform input[type=submit]:hover,#sidebar-wrapper a#menu-close,#sidebar-wrapper a#menu-close:hover,.mini_cart .main_widget_checout,#basic-user-avatar-form input[type="submit"],#edd_profile_editor_submit,#basic-user-avatar-form input[type="submit"]:hover,#edd_profile_editor_submit:hover,.styleone.btn,.single-product-buttons .multiple_button_v,.button_accent,.fes-url-choose-row .edd-submit.upload_file_button,table.multiple tfoot tr th .edd-submit.insert-file-row,.edd-submit.button.blue.active, .edd-submit.button.blue:focus, .edd-submit.button.blue:hover,.subscribe-block-btn,div.fes-form .fes-submit input[type=submit]',
            		'property' => 'background',
            	),
            	
            	array(
            		'element'  => '#commentform input[type=submit],.slider_dm_v .carousel-indicators .active, #edd-purchase-button,.edd-submit,input.edd-submit[type="submit"],
        .dm_register_button,.back-to-top:hover,button.fes-cmt-submit-form,.mini_cart .cart_item.edd_checkout a,.photo-image-zoom,
        a.edd-wl-button.edd-wl-save.edd-wl-action,
        .wishlist-with-bg .edd-wl-button.edd-wl-action,
        .edd-wl-create input[type=submit],
        .edd-wl-item-purchase .edd-add-to-cart-from-wish-list,.carousel-indicators li,blockquote, #wp-calendar caption,.edd_discount_link, #edd-login-account-wrap a, #edd-new-account-wrap a,.edd-submit.button.blue, .single-cart-button a.btn, .edd_purchase_submit_wrapper a.edd-add-to-cart.edd-has-js, .single-news-letter  .nl__item--submit:hover,.edd-submit.button.blue:hover, .single-cart-button a:hover.btn, .edd_purchase_submit_wrapper a.edd-add-to-cart.edd-has-js:hover,#commentform input[type=submit]:hover,#sidebar-wrapper a#menu-close,#sidebar-wrapper a#menu-close:hover,.mini_cart .main_widget_checout,#basic-user-avatar-form input[type="submit"],#edd_profile_editor_submit,#basic-user-avatar-form input[type="submit"]:hover,#edd_profile_editor_submit:hover,.styleone.btn,.single-product-buttons .multiple_button_v,.button_accent,.fes-url-choose-row .edd-submit.upload_file_button,table.multiple tfoot tr th .edd-submit.insert-file-row,.edd-submit.button.blue.active, .edd-submit.button.blue:focus, .edd-submit.button.blue:hover,div.fes-form .fes-submit input[type=submit],.fes-submit .edd-submit.blue.button',
            		'property' => 'border-color',
            	),
            	
            	
            	array(
            		'element'  => 'p a,.post-viewas> .nav-pills>li.active>a, .post-viewas>.nav-pills>li.active>a:focus, .post-viewas>.nav-pills>li.active>a:hover,.fourzerofour-info a,a:hover,
        .sidebar-blog-categories ul li:hover, .sidebar-blog-categories ul li:hover a,.dm_comment_author a,
        .single-user-info ul li:first-child a:hover,.mayosis-popup .close:hover,.edd_price_options.edd_single_mode ul li label input:checked~span.edd_price_option_name:before,.user-info a:hover,.product-title a:hover,.sidebar-blog-categories ul li:hover,
        .post-promo-box .single-blog-title a:hover,
        .edd_download_purchase_form .edd_price_options li.item-selected label,nav.fes-vendor-menu ul li.active a:before, nav.fes-vendor-menu ul li.active a, nav.fes-vendor-menu ul li:hover a,
        .favorited .glyphicon-add,.mayosel-select .option.selected,#today a,#edd_payment_mode_select_wrap input[type="radio"]:checked::before,.edd_cart_footer_row .edd_cart_total,#edd_checkout_form_wrap input[type=radio]:checked::before, #wp-calendar caption,.edd_discount_link, #edd-login-account-wrap a, #edd-new-account-wrap a,.main-post-promo .single-user-info ul li a:hover,.post-viewas> .nav-pills>li.active>a,.post-viewas> .nav-pills>li>a:hover,.button_ghost.button_accent,.button_link.button_accent,.button_ghost.button_accent:hover,.block-hover:hover,.main_content_licence.youcan table tr td .icon-background1 ,.fes-widget--metabox a,.edd_price_options.edd_single_mode ul li label input:checked~span.edd_price_option_name:before,.edd_price_options.edd_multi_mode ul li label input:checked~span.edd_price_option_name:before,.favorited .glyphicon-add',
            		'property' => 'color',
            	),
            	
            	
            	array(
            		'element'  => '.common-paginav a.next:hover,.common-paginav a.prev:hover,.common-paginav a.page-numbers:hover, .common-paginav span.page-numbers:hover,#edd_download_pagination a.page-numbers:hover,#edd_download_pagination span.page-numbers:hover,#edd_download_pagination span.page-numbers.current:hover,.button-fill-color:hover,.licence_main_title.youcantitle,input[type="submit"],input[type="submit"].wpcf7-submit',
            		'property' => 'background',
            	),
            	
            	array(
            		'element'  => '.common-paginav a.next:hover,.common-paginav a.prev:hover,.common-paginav a.page-numbers:hover, .common-paginav span.page-numbers:hover,#edd_download_pagination a.page-numbers:hover,#edd_download_pagination span.page-numbers:hover,#edd_download_pagination span.page-numbers.current:hover,p.comment-form-comment textarea:focus,#commentform input[type=text]:focus, #commentform input[type=email]:focus, p.comment-form-comment textarea:focus,#edd_login_form .edd-input:focus, #edd_register_form .edd-input:focus,#edd_checkout_form_wrap input.edd-input:focus, #edd_checkout_form_wrap textarea.edd-input:focus,#edd_checkout_form_wrap select.edd-select:focus,#edd_profile_editor_form input:not([type="submit"]):focus,#edd_profile_editor_form select:focus,.dasboard-tab,#contact textarea:focus, .wpcf7-form-control-wrap textarea:focus,input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus,.solid-input input:focus,.product-search-form input[type="text"]:focus, .product-search-form input[type="search"]:focus,.button-fill-color:hover,.licence_main_title.youcantitle,input[type="submit"].wpcf7-submit',
            		'property' => 'border-color',
            	),
            	
            	array(
            		'element'  => 'p.comment-form-comment textarea:hover,#commentform input[type=text]:hover, #commentform input[type=email]:hover, p.comment-form-comment textarea:hover,#edd_login_form .edd-input:hover, #edd_register_form .edd-input:hover,#edd_checkout_form_wrap input.edd-input:hover, #edd_checkout_form_wrap textarea.edd-input:hover,#edd_checkout_form_wrap select.edd-select:hover,#edd_profile_editor_form input:not([type="submit"]):hover,#edd_profile_editor_form select:hover,.dasboard-tab,#contact textarea:hover, .wpcf7-form-control-wrap textarea:hover,input[type="text"]:hover, input[type="email"]:hover, input[type="password"]:hover,.solid-input input:hover,.product-search-form input[type="text"]:hover, .product-search-form input[type="search"]:hover',
            		'property' => 'border-bottom-color',
            	),
    	),
    	
    	
                'choices' => array(
                    'palettes' => array(
                        '#28375a',
                        '#282837',
                        '#5a00f0',
                        '#ff6b6b',
                        '#c44d58',
                        '#ecca2e',
                        '#bada55',
                    ),
                ),
    ));


Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'accent_color_text',
        'label'       => __( 'Primary Text Color', 'mayosis' ),
        'description' => __( 'Accent above text color', 'mayosis' ),
        'section'     => 'common_color',
        'priority'    => 10,
        'default'     => '#ffffff',
        'transport' =>$transport,
        'output' => array(
            	array(
            		'element'  => '#commentform input[type=submit],.slider_dm_v .carousel-indicators .active, #edd-purchase-button,.edd-submit,input.edd-submit[type="submit"],
        .dm_register_button,.back-to-top:hover,button.fes-cmt-submit-form,.mini_cart .cart_item.edd_checkout a,.photo-image-zoom,
        a.edd-wl-button.edd-wl-save.edd-wl-action,
        .wishlist-with-bg .edd-wl-button.edd-wl-action,
        .edd-wl-create input[type=submit],
        .edd-wl-item-purchase .edd-add-to-cart-from-wish-list,header .product-search-form .mayosel-select .current,
        a.edd-wl-button.edd-wl-save.edd-wl-action span,
        .edd-wl-item-purchase .edd-add-to-cart-from-wish-list span,.fes-product-list-td a,.button-sub-right .btn,.upload-cover-button:hover,  .wpcf7-submit,.status-publish.sticky:before, .footer-link-page-post,.upload-cover-button,  .footer-page-post-link,.lSSlideOuter .lSPager.lSpg > li:hover a, .lSSlideOuter .lSPager.lSpg > li.active a,.lSSlideOuter .lSPager.lSpg > li a,.button_accent,input[type="submit"],input[type="submit"].wpcf7-submit,.fes-url-choose-row .edd-submit.upload_file_button,table.multiple tfoot tr th .edd-submit.insert-file-row,.edd-submit.button.blue.active, .edd-submit.button.blue:focus, .edd-submit.button.blue:hover,.subscribe-block-btn,div.fes-form .fes-submit input[type=submit]',
            		'property' => 'color',
            	),
            	
            	array(
            		'element'  => '.button_ghost.button_accent:hover,.block-hover:hover',
            		'property' => 'background',
            	),
            	
            		array(
            		'element'  => '.button_ghost.button_accent:hover,.block-hover:hover',
            		'property' => 'border-color',
            	),
            	
            	array(
            		'element'  => '.edd-submit.button.blue, .single-cart-button a.btn, .edd_purchase_submit_wrapper a.edd-add-to-cart.edd-has-js, .single-news-letter  .nl__item--submit:hover,.edd-submit.button.blue:hover, .single-cart-button a:hover.btn, .edd_purchase_submit_wrapper a.edd-add-to-cart.edd-has-js:hover,#commentform input[type=submit]:hover,#sidebar-wrapper a#menu-close,#sidebar-wrapper a#menu-close:hover,.mini_cart .main_widget_checout,#basic-user-avatar-form input[type="submit"],#edd_profile_editor_submit,#basic-user-avatar-form input[type="submit"]:hover,#edd_profile_editor_submit:hover,.styleone.btn,.single-product-buttons .multiple_button_v,.button-fill-color:hover,.licence_main_title.youcantitle',
            		'property' => 'color',
            	)
    	),
    	
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#ff6b6b',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
    
    ));
    
    
    Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'secondary_accent_color',
        'label'       => __( 'Secondary Color', 'mayosis' ),
        'description' => __( 'Change secondary color', 'mayosis' ),
        'section'     => 'common_color',
        'priority'    => 10,
        'default'     => '#282837',
         'transport' =>$transport,
        'output' => array(
            	array(
            		'element'  => '.single_author_box, .page_breadcrumb, #searchoverlay ,.overlay,h2#sitemap_pages,.mobile--nav-menu,.grid--download--categories a.cat--grid--main::after,.fes_dashboard_menu,.edd-fd-button,#edd_checkout_cart a.edd-cart-saving-button.edd-submit.button.blue,#edd_checkout_cart .edd-submit.button.blue,.mayosis-collapse-btn,#menu-toggle:hover,a.mobile-cart-button:hover,a.mobile-login-button:hover,#sidebar-wrapper,.modal-backdrop,.mayosis-main-media .mejs-controls,.mayosis-main-media .mejs-container, #edd_checkout_cart a.edd-cart-saving-button.edd-submit.button.blue:hover,.fourzerofour-info,
                        #edd_profile_name_label, #edd_profile_billing_address_label, #edd_profile_password_label,
                        .styletwo.btn,.transbutton.btn:hover,.mayosisonet101,.social_share_widget a:hover,.social-button-bottom a:hover i,
                        h2.reciept_heading,.fill .btn,#fes-comments-table tr.heading_tr,#fes-product-list thead,#edd_user_commissions_overview table tr th,
                        #edd_user_commissions_paid thead tr th,#fes-order-list thead tr th,
                        #edd_user_revoked_commissions_table thead tr th, #edd_user_unpaid_commissions_table thead tr th,.photo--template--button:hover,
                        .author--box--btn .follow--au--btn a,
                        .author--box--btn .contact--au--btn a:hover,.title--button--box .btn.title--box--btn.transparent:hover,#mayosis-sidebar a[aria-expanded=true], #mayosis-sidebar ul li.active>a,.btn-file',
                            		'property' => 'background',
            	),
            	
            		array(
            		'element'  => '.edd-fd-button,#edd_checkout_cart a.edd-cart-saving-button.edd-submit.button.blue,#edd_checkout_cart .edd-submit.button.blue,.mayosis-collapse-btn,#menu-toggle:hover,a.mobile-cart-button:hover,a.mobile-login-button:hover,#sidebar-wrapper,.modal-backdrop,.mayosis-main-media .mejs-controls,.mayosis-main-media .mejs-container, #edd_checkout_cart a.edd-cart-saving-button.edd-submit.button.blue:hover,.fourzerofour-info,
                        #edd_profile_name_label, #edd_profile_billing_address_label, #edd_profile_password_label,
                        .styletwo.btn,.transbutton.btn:hover,.mayosisonet101,.social_share_widget a:hover,.social-button-bottom a:hover i,
                        h2.reciept_heading,.fill .btn,#fes-comments-table tr.heading_tr,#fes-product-list thead,#edd_user_commissions_overview table tr th,
                        #edd_user_commissions_paid thead tr th,#fes-order-list thead tr th,
                        #edd_user_revoked_commissions_table thead tr th, #edd_user_unpaid_commissions_table thead tr th,.photo--template--button:hover,
                        .author--box--btn .follow--au--btn a,
                        .author--box--btn .contact--au--btn a:hover,.transbutton.btn,.post-viewas> .nav-pills>li>a,.button_ghost.button_secaccent:hover,.btn-file',
            		'property' => 'border-color',
            	),
            	
            	array(
            		'element'  => '.transbutton.btn,.post-viewas> .nav-pills>li>a,.author--box--btn .contact--au--btn a,.button_ghost.button_secaccent,.button_link.button_secaccent
        ',
            		'property' => 'color',
            	),
            	
            	
            	array(
            		'element'  => '.button_secaccent',
            		'property' => 'background-color',
            	),
            	
            		array(
            		'element'  => '.button_secaccent,.button_ghost.button_secaccent:hover',
            		'property' => 'border-color',
            	),
            ),
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#ff6b6b',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
    ));
    
    Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
            'settings'     => 'secondary_accent_color_text',
            'label'       => __( 'Secondary Text Color', 'mayosis' ),
            'description' => __( 'Secondary color above text color', 'mayosis' ),
            'section'     => 'common_color',
            'priority'    => 10,
            'default'     => '#ffffff',
            'transport' =>$transport,
            'output' => array(
            	array(
            		'element'  => '#edd_checkout_cart a.edd-cart-saving-button.edd-submit.button.blue:hover,.fourzerofour-info,
                            #edd_profile_name_label, #edd_profile_billing_address_label, #edd_profile_password_label,
                            .styletwo.btn,.transbutton.btn:hover,.mayosisonet101,.social_share_widget a:hover,.social-button-bottom a:hover i,
                            h2.reciept_heading,.fill .btn,#fes-comments-table tr.heading_tr,#fes-product-list thead,#edd_user_commissions_overview table tr th,
                            #edd_user_commissions_paid thead tr th,#fes-order-list thead tr th,
                            #edd_user_revoked_commissions_table thead tr th, #edd_user_unpaid_commissions_table thead tr th,.photo--template--button:hover,
                            .author--box--btn .follow--au--btn a,
                            .author--box--btn .contact--au--btn a:hover, #searchoverlay .search input,#searchoverlay .search span,#searchoverlay .search input,
                                #searchoverlay .search input::placeholder,#searchoverlay .close,.overlay,.title--button--box .btn.title--box--btn.transparent:hover,#mayosis-sidebar a[aria-expanded=true], #mayosis-sidebar ul li.active>a,.btn-file',
            		'property' => 'color',
            	),
            	
            	
            	array(
            		'element'  => '#searchoverlay .search input,#searchoverlay .search span,#searchoverlay .search input,
        #searchoverlay .search input::placeholder,#searchoverlay .close,.overlay',
            		'property' => 'border-color',
            	),
            	
            		array(
            		'element'  => 'h2.page_title_single,.sep,.page_breadcrumb .breadcrumb > .active,.page_breadcrumb .breadcrumb a,#menu-toggle:hover,a.mobile-cart-button:hover,a.mobile-login-button:hover,#sidebar-wrapper,.overlay_content_center a.overlay_cart_btn,.overlay_content_center a.overlay_cart_btn:hover,.widget-posts .overlay_content_center a i, .bottom-widget-product .overlay_content_center a i,.breadcrumb a,.breadcrumb > .active,.grid--download--categories a,
        nav.fes-vendor-menu ul li a,.button_secaccent,.button_ghost.button_secaccent:hover,.button_text,.button_ghost.button_text:hover',
            		'property' => 'color',
            	)
            ),
            'choices' => array(
                'palettes' => array(
                    '#28375a',
                    '#282837',
                    '#5a00f0',
                    '#ff6b6b',
                    '#c44d58',
                    '#ecca2e',
                    '#bada55',
                ),
            ),
    ));
    
    
    Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'regular_text_color',
        'label'       => __( 'Regular Text Color', 'mayosis' ),
        'description' => __( 'Change regular text color', 'mayosis' ),
        'section'     => 'common_color',
        'priority'    => 10,
        'default'     => '#28375a',
        'transport' =>$transport,
        'output' => array(
                array(
                		'element'  => 'body,h1,h2,h3,h4,h5,h6,a,.mayosis-play--button-video:focus,.mayosis-play--button-video,.mayosel-select,textarea,.title--button--box .btn.title--box--btn.transparent',
                		'property' => 'color',
                	),
                	
                	array(
                		'element'  => '.sidebar-theme ul li a,.bottom-widget-product  a,.total-post-count p,.author_single_dm_box p, .author_single_dm_box a,.author_meta_single h2 a,.author_meta_single p,.author_meta_single a,
                            .author_meta_single ul li a,.comment-content p,a.sigining-up,.edd-lost-password a,.edd-login-remember span,.promo_price,#edd_checkout_cart th,#edd_checkout_form_wrap legend,#edd_checkout_wrap #edd_checkout_form_wrap label,
                            #edd_checkout_form_wrap span.edd-description,span.edd_checkout_cart_item_title,#edd_checkout_cart .edd_cart_header_row th,#edd_checkout_cart td,#edd_checkout_form_wrap input.edd-input, #edd_checkout_form_wrap textarea.edd-input,
                            #edd_checkout_form_wrap span.edd-required-indicator,#edd_checkout_form_wrap select.edd-select,.single-user-info ul li a,.stylish-input-group button,.user-info span,.user-info a,.single_author_post,.empty_cart_icon i,
                            .empty_cart_icon h2,.fourzerofour-area h1,.fourzerofour-area h3,#edd_profile_editor_form label,table tbody tr td,.mayosis-madalin .modal-header .close,.product-price h3,.sidebar-details p,.bottom-product-sidebar h4,
                            .sidebar-blog-categories ul li a,.release-info .rel-info-value,.release-info .rel-info-tag,#edd_login_form .edd-input, #edd_register_form .edd-input,.grid-testimonal-promo .testimonial_details i.testimonial_queto_dm,.bottom_meta a,
                            .dm_comment_author,.dm_comment-date,.comment--dot,.single-blog-title a,.single-blog-title,.top-header .top-social-icon li a:hover,code,.search-dropdown-main button,.post-promo-box.grid_dm .overlay_content_center a,a.edd-wl-action.edd-wl-button span,
                            .photo--price--block a.edd-wl-action.edd-wl-button,div.fes-form .fes-el .fes-label .fes-help,.fes-label label',
                		'property' => 'color',
                	),
                	
                	array(
                		'element'  => '.section-title,.product-meta a:hover,.maxcollapse-open .maxcollapse-input,.maxcollapse-open .maxcollapse-input::placeholder,
                        .maxcollapse-open .maxcollapse-icon,#edd_show_discount,#edd_final_total_wrap,.bottom-product-sidebar h4,.sidebar-details h3 a,
                        .bottom-product-sidebar .sidebar-details p,.bottom-widget-product .product-price .edd_price,.sidebar-details h3,.sidebar-details h3 a,
                        .sidebar-details p,.sidebar-blog-categories ul li a,.edd_price_options.edd_single_mode ul li label,.product-price h3,.single-user-info ul li a,
                        .single-blog-title a,.single-blog-title,.user-info a,legend, pre,
                        .header-search-form .download_cat_filter select option,
                        .header-search-form .download_cat_filter:after,.prime-wishlist-fav a.edd-wl-action.edd-wl-button,
                        .prime-wishlist-fav a.edd-wl-action.edd-wl-button:hover i,.prime-wishlist-fav a.edd-wl-action.edd-wl-button:hover span,.tag_widget_single ul li a,.sidebar-blog-categories ul li,#fes-save-as-draft',
                		'property' => 'color',
                	),
                	array(
                	    'element' => '::-webkit-input-placeholder,::-moz-placeholder,#edd_checkout_form_wrap input.edd-input::placeholder,#edd_checkout_form_wrap textarea.edd-input::placeholder,#edd_login_form .edd-input::placeholder, #edd_register_form .edd-input::placeholder,sidebar-search input[type=search]::placeholder,.button_ghost.button_text,.button_link.button_text,nav.fes-vendor-menu ul li.active a',
                	    'property' => 'color',
                	    ),
                	    
                	    array(
                	        'element' => '.icon-play',
                	        'property' =>'border-left-color',
                	        ),
                	        
                	        array(
                	        'element' => '.ghost_button,.mayosel-select:after,#edd_user_history th,table#edd_checkout_cart tbody,#edd_checkout_cart input.edd-item-quantity,.rel-info-value p,.button_text,.button_ghost.button_text:hover,#fes-save-as-draft',
                	        'property' =>'border-color',
                	        ),
                	        
                	         array(
                	        'element' => '.ghost_button:hover,.tag_widget_single ul li a:hover,.mayosis-title-audio .mejs-button>button,.button_text,.button_ghost.button_text:hover',
                	        'property' =>'background-color',
                	        ),
                ),
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#ff6b6b',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
    ));
    
    
    Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'form_field_type',
        'label'       => __( 'Form Field Type', 'mayosis' ),
        'section'     => 'common_color',
        'default'     => 'solid',
        'priority'    => 10,
        'choices'     => array(
            'solid'  => esc_attr__( 'Solid', 'mayosis' ),
            'border' => esc_attr__( 'Border', 'mayosis' ),
        ),
    ));
    
    Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'dimension',
        'settings'    => 'global_border_thikness',
        'label'       => esc_attr__( 'Border Thickness', 'mayosis' ),
        'description' => esc_attr__( 'Add Main Site Form Border Thickness', 'mayosis' ),
        'section'     => 'common_color',
        'default'     => '2px',
        'required'    => array(
            array(
                'setting'  => 'form_field_type',
                'operator' => '==',
                'value'    => 'border',
            ),
        ),
    ));
    
     Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'media_player_background',
        'label'       => __( 'Media Player Icon Background Color', 'mayosis' ),
        'description' => __( 'Change Media Player Icon Background Color', 'mayosis' ),
        'section'     => 'common_color',
        'priority'    => 10,
        'default'     => '#ffffff',
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#ff6b6b',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
    ));
    
     Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'media_player_icon_color',
        'label'       => __( 'Media Player Icon Icon Color', 'mayosis' ),
        'description' => __( 'Change Media Player Icon Color', 'mayosis' ),
        'section'     => 'common_color',
        'priority'    => 10,
        'default'     => '#1e3c78',
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#ff6b6b',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
    ));
    
    Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'color',
        'settings'     => 'visited_link_color',
        'label'       => __( 'Visited Link Color', 'mayosis' ),
        'description' => __( 'Change visited link color', 'mayosis' ),
        'section'     => 'common_color',
        'priority'    => 10,
        'default'     => '#b2478f',
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#ff6b6b',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
    ));
    
    Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'radio-buttonset',
        'settings'    => 'loader_website',
        'label'       => __( 'Website Loader', 'mayosis' ),
        'section'     => 'common_color',
        'default'     => 'hide',
        'priority'    => 10,
        'choices'     => array(
            'show'  => esc_attr__( 'Show', 'mayosis' ),
            'hide' => esc_attr__( 'Hide', 'mayosis' ),
        ),
    ));
    
    Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'multicolor',
        'settings'    => 'loader_gradient',
        'label'       => esc_attr__( 'Loader gradient', 'mayosis' ),
        'section'     => 'common_color',
        'priority'    => 10,
        'required'    => array(
            array(
                'setting'  => 'loader_website',
                'operator' => '==',
                'value'    => 'show',
            ),
        ),
        'choices'     => array(
            'color1'    => esc_attr__( 'Form', 'mayosis' ),
            'color2'   => esc_attr__( 'To', 'mayosis' ),
        ),
        'default'     => array(
            'color1'    => '#1e73be',
            'color2'   => '#00897e',
        ),
    ));
    
     Mayosis_Option::add_field( 'mayo_config', array(
        'type'        => 'select',
        'settings'    => 'anchor_style_type',
        'label'       => __( 'Anchor Style', 'mayosis' ),
        'section'     => 'common_color',
        'default'     => 'default',
        'priority'    => 10,
        'choices'     => array(
            'default'  => esc_attr__( 'Default', 'mayosis' ),
            'soft' => esc_attr__( 'Soft Edge', 'mayosis' ),
            'color' => esc_attr__( 'Color Block', 'mayosis' ),
            'water' => esc_attr__( 'Water Flow', 'mayosis' ),
            'ocean' => esc_attr__( 'Ocean Wave', 'mayosis' ),
        ),
    ));
    
    Mayosis_Option::add_field( 'mayo_config', [
	'type'        => 'dimension',
	'settings'    => 'container_width_desktop_big',
	'label'       => esc_html__( 'Container Width(start from 1600px)', 'kirki' ),
	'description' => esc_html__( 'chnage the base container width start from 1600px.', 'kirki' ),
	'section'     => 'common_color',
	'default'     => '1170px',
] );

Mayosis_Option::add_field( 'mayo_config', array(
    'type'        => 'color',
        'settings'     => 'product_breadcrumb_text',
        'label'       => __( 'Breadcrumb Text Color', 'mayosis' ),
        'description' => __( 'Set Breadcrumb Text Color', 'mayosis' ),
        'section'     => 'common_color',
        'priority'    => 10,
        'default'     => '#ffffff',
        'choices' => array(
            'palettes' => array(
                '#28375a',
                '#282837',
                '#5a00f0',
                '#ff6b6b',
                '#c44d58',
                '#ecca2e',
                '#bada55',
            ),
        ),
));

    
//End Common Colors