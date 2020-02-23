<?php
/**
 * Register Sidebar
 */
function mayosis_register_sidebars() {
	/* Register Archive sidebar. */
	
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'mayosis' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'mayosis' ),
		'before_widget' => '<div id="%1$s" class="theme--sidebar--widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
    
  
	
	register_sidebar(
        array(
            'id' => 'page-sidebar',
            'name' => __( 'Page Sidebar', 'mayosis' ),
            'description' => __( 'Main Pages Sidebar.', 'mayosis' ),
            'before_widget' => '<div id="%1$s" class="theme--sidebar--widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        )
    );
    
    register_sidebar( array(
		'name'          => __( 'Product Archive Sidebar', 'mayosis' ),
		'id'            => 'product-archive-sidebar',
		'description'   => __( 'Add widgets here to appear in your product archive sidebar.', 'mayosis' ),
		'before_widget' => '<div id="%1$s" class="theme--sidebar--widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
    
	
	/* Register Single Post sidebar. */
    register_sidebar(
        array(
            'id' => 'single-post',
            'name' => __( 'Single Post Sidebar', 'mayosis' ),
            'description' => __( 'This is For Single Post Sidebar', 'mayosis' ),
            'before_widget' => '<div id="%1$s" class="theme--sidebar--widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        )
    );
	
    
    	/* Register Single Product Free sidebar. */
    register_sidebar(
        array(
            'id' => 'single-product',
            'name' => __( 'Single Product Sidebar', 'mayosis' ),
            'description' => __( 'This is For Single Product Sidebar', 'mayosis' ),
            'before_widget' => '<div id="%1$s" class="theme--sidebar--widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        )
    );
    
    register_sidebar(
        array(
            'id' => 'media-template-product',
            'name' => __( 'Media Template Product Sidebar', 'mayosis' ),
            'description' => __( 'This is For Media Template Sidebar (work on style Two)', 'mayosis' ),
            'before_widget' => '<div id="%1$s" class="theme--sidebar--widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        )
    );
 
	 register_sidebar(
        array(
            'id' => 'hamburger',
            'name' => __( 'Hamburger', 'mayosis' ),
            'description' => __( 'This is For Hamburger Sidebar', 'mayosis' ),
            'before_widget' => '<div id="%1$s" class="hamburger-sidebar %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>'
        )
    );
 
}
add_action( 'widgets_init', 'mayosis_register_sidebars' );
?>