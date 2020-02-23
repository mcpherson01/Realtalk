<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$blog_image_visibility= get_theme_mod( 'blog_featured_visibility','show' );
$blog_image_position= get_theme_mod( 'featured_position_blog','left' );


?>
	<!-- Begin Page Headings Layout -->
   
        <div class="container">
            <div class="row mayosis-flex-center">
                <?php if ($blog_image_position == 'left'): ?>
                <?php if ($blog_image_visibility == 'show'): ?>
                <?php
								// display featured image?
								if ( has_post_thumbnail() ) :?>
                <div class="col-md-4 col-xs-12 post-thumb-single">
                  
								<?php	the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
                       
                </div> 
                   							
            <?php endif; ?>
            <?php endif; ?> 
            <?php endif; ?> 
             <?php if ($blog_image_visibility == 'show'): ?>
                <div class="col-md-8 col-xs-12 post_single_data">
                    <?php else: ?>
                    <div class="col-md-12 col-xs-12 post_single_data">
                    <?php endif; ?>
                     <div class="single--post--header--content">
                   <?php get_template_part( 'includes/blog_header_layout' ); ?>
                   </div>
                </div>
                
                        <?php if ($blog_image_position == 'right'): ?>
                <?php if ($blog_image_visibility == 'show'): ?>
                <?php
								// display featured image?
								if ( has_post_thumbnail() ) :?>
                <div class="col-md-4 col-xs-12 post-thumb-single">
                  
								<?php	the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
                       
                </div> 
                   							
            <?php endif; ?>
            <?php endif; ?> 
            <?php endif; ?> 
                
            </div>
            
        </div>
 
    
    <!-- End Page Headings Layout -->