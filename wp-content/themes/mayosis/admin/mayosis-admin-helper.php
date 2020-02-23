<?php
/**
 * Get Extra Options
 *
 * @since  1.0
 */
 $mainheadertype= get_theme_mod( 'header_layout_type','one');
 $footerwidgetcolumn= get_theme_mod( 'footer_widget_column','five');
 $footeradditionaltrue= get_theme_mod( 'footer_additonal_widget','hide');
 $copyrighttype = get_theme_mod( 'copyright_type','single');
 $default_bwidget_col= get_theme_mod( 'defultp_bottom_widget_col','three');
if ($mainheadertype == 'two'):{
    function register_mayosis_center_menu()
	{
	register_nav_menus(array(
		'left-menu' => __('Left Menu', 'mayosis') ,
		'right-menu' => __('Right Menu','mayosis') ,
	));
	}

add_action('init', 'register_mayosis_center_menu');

}
 endif;
 
 if ($footerwidgetcolumn == 'one'):{
      /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-one',
            'name' => __( 'Footer Widget Area 1', 'mayosis' ),
            'description' => __( 'This is Footer First Column Sidebar.', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
	
 }
endif;

 if ($footerwidgetcolumn == 'two'):{
      /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-one',
            'name' => __( 'Footer Widget Area 1', 'mayosis' ),
            'description' => __( 'This is Footer First Column Sidebar.', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
	  /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-two',
            'name' => __( 'Footer Widget Area 2', 'mayosis' ),
            'description' => __( 'This is Footer Second Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
 }
endif;

if ($footerwidgetcolumn == 'three'):{
      /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-one',
            'name' => __( 'Footer Widget Area 1', 'mayosis' ),
            'description' => __( 'This is Footer First Column Sidebar.', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
	  /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-two',
            'name' => __( 'Footer Widget Area 2', 'mayosis' ),
            'description' => __( 'This is Footer Second Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    
       /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-three',
            'name' => __( 'Footer Widget Area 3', 'mayosis' ),
            'description' => __( 'This is Footer Three Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
 }
endif;


if ($footerwidgetcolumn == 'four'):{
      /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-one',
            'name' => __( 'Footer Widget Area 1', 'mayosis' ),
            'description' => __( 'This is Footer First Column Sidebar.', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
	  /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-two',
            'name' => __( 'Footer Widget Area 2', 'mayosis' ),
            'description' => __( 'This is Footer Second Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    
       /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-three',
            'name' => __( 'Footer Widget Area 3', 'mayosis' ),
            'description' => __( 'This is Footer Three Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    
      /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-four',
            'name' => __( 'Footer Widget Area 4', 'mayosis' ),
            'description' => __( 'This is Footer Four Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
 }
endif;

if ($footerwidgetcolumn == 'five'):{
      /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-one',
            'name' => __( 'Footer Widget Area 1', 'mayosis' ),
            'description' => __( 'This is Footer First Column Sidebar.', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
	  /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-two',
            'name' => __( 'Footer Widget Area 2', 'mayosis' ),
            'description' => __( 'This is Footer Second Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    
       /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-three',
            'name' => __( 'Footer Widget Area 3', 'mayosis' ),
            'description' => __( 'This is Footer Three Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    
      /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-four',
            'name' => __( 'Footer Widget Area 4', 'mayosis' ),
            'description' => __( 'This is Footer Four Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    
    
	  /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-five',
            'name' => __( 'Footer Widget Area 5', 'mayosis' ),
            'description' => __( 'This is Footer Five Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    /* Repeat register_sidebar() code for additional sidebars. */
 }
endif;

if ($footerwidgetcolumn == 'six'):{
      /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-one',
            'name' => __( 'Footer Widget Area 1', 'mayosis' ),
            'description' => __( 'This is Footer First Column Sidebar.', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
	  /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-two',
            'name' => __( 'Footer Widget Area 2', 'mayosis' ),
            'description' => __( 'This is Footer Second Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    
       /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-three',
            'name' => __( 'Footer Widget Area 3', 'mayosis' ),
            'description' => __( 'This is Footer Three Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    
      /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-four',
            'name' => __( 'Footer Widget Area 4', 'mayosis' ),
            'description' => __( 'This is Footer Four Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    
    
	  /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-five',
            'name' => __( 'Footer Widget Area 5', 'mayosis' ),
            'description' => __( 'This is Footer Five Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    /* Repeat register_sidebar() code for additional sidebars. */
     /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'footer-six',
            'name' => __( 'Footer Widget Area 6', 'mayosis' ),
            'description' => __( 'This is Footer Six Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
    /* Repeat register_sidebar() code for additional sidebars. */
 }
endif;
 if ($footeradditionaltrue == 'show'):{
      /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'additional-footer-one',
            'name' => __( 'Additional Footer Widget Area 1', 'mayosis' ),
            'description' => __( 'This is Additional Footer First Column Sidebar.', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
	  /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'additional-footer-two',
            'name' => __( 'Additional Footer Widget Area 2', 'mayosis' ),
            'description' => __( 'This is Additional Footer Second Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
     /* Register Footer sidebar. */
    register_sidebar(
        array(
            'id' => 'additional-footer-three',
            'name' => __( 'Additional Footer Widget Area 3', 'mayosis' ),
            'description' => __( 'This is Additional Footer Third Column Sidebar', 'mayosis' ),
            'before_widget' => '<div class="footer-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>'
        )
    );
 }
endif;


if($copyrighttype== 'columed'):
    
    /* Register Copyright sidebar. */
    register_sidebar(
        array(
            'id' => 'copyright-footer',
            'name' => __( 'Copyright Footer', 'mayosis' ),
            'description' => __( 'This is Copyright Footer for Rightside Content', 'mayosis' ),
            'before_widget' => '<div class="copyright-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="copyright-widget-title">',
            'after_title' => '</h4>'
        )
    );
endif;

if ($default_bwidget_col == 'one'):
    
    register_sidebar(
        array(
            'id' => 'default-product-widget-one',
            'name' => __( 'Product Default Template Widget One', 'mayosis' ),
            'description' => __( 'This is Additional Widget for Default Product', 'mayosis' ),
            'before_widget' => '<div class="default-product-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="default-product-additional-title">',
            'after_title' => '</h4>'
        )
    );
    endif;
    
    if ($default_bwidget_col == 'two'):
    
    register_sidebar(
        array(
            'id' => 'default-product-widget-one',
            'name' => __( 'Product Default Template Widget One', 'mayosis' ),
            'description' => __( 'This is Additional Widget for Default Product', 'mayosis' ),
            'before_widget' => '<div class="default-product-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="default-product-additional-title">',
            'after_title' => '</h4>'
        )
    );
    
      register_sidebar(
        array(
            'id' => 'default-product-widget-two',
            'name' => __( 'Product Default Template Widget Two', 'mayosis' ),
            'description' => __( 'This is Additional Widget for Default Product', 'mayosis' ),
            'before_widget' => '<div class="default-product-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="default-product-additional-title">',
            'after_title' => '</h4>'
        )
    );
    endif;
    
        if ($default_bwidget_col == 'three'):
    
    register_sidebar(
        array(
            'id' => 'default-product-widget-one',
            'name' => __( 'Product Default Template Widget One', 'mayosis' ),
            'description' => __( 'This is Additional Widget for Default Product', 'mayosis' ),
            'before_widget' => '<div class="default-product-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="default-product-additional-title">',
            'after_title' => '</h4>'
        )
    );
    
      register_sidebar(
        array(
            'id' => 'default-product-widget-two',
            'name' => __( 'Product Default Template Widget Two', 'mayosis' ),
            'description' => __( 'This is Additional Widget for Default Product', 'mayosis' ),
            'before_widget' => '<div class="default-product-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="default-product-additional-title">',
            'after_title' => '</h4>'
        )
    );
    
     register_sidebar(
        array(
            'id' => 'default-product-widget-three',
            'name' => __( 'Product Default Template Widget Three', 'mayosis' ),
            'description' => __( 'This is Additional Widget for Default Product', 'mayosis' ),
            'before_widget' => '<div class="default-product-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="default-product-additional-title">',
            'after_title' => '</h4>'
        )
    );
    endif;
