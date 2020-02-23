<?php
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="col-md-12">
    <div class="posts-wrapper">
     

       <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
 
    <!-- Begin Blog Main Post Layout -->
    <section class="container blog-main-content">
        <div class="row">
            <div class="main-post-body">
                <div class="col-md-8 col-sm-8 col-xs-12 main-post-block">
                    <div class="post-view-style">
                        <div class="col-md-5 total-post-count">
                            <?php 
                            $count = $GLOBALS['wp_query']->found_posts;
                            $countall = $GLOBALS['wp_query']->post_count;
                            ?>
                            <p><?php esc_html_e('Showing','mayosis'); ?> <strong><?php echo esc_html($countall);?></strong>  <?php esc_html_e('of','mayosis'); ?> <strong><?php echo esc_html($count);?></strong> <?php esc_html_e('Blog Posts','mayosis'); ?></p>
                        </div>
                        <div class="col-md-7 post-viewas">
							<ul  class="nav nav-pills">
			<li class="active">
        <a  href="#list" data-toggle="tab"><i class="zil zi-bars"></i></a></a>
			</li>
			<li><a href="#grid" data-toggle="tab"><i class="zil zi-grid"></i></a>
			</li>
		</ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                   <div class="tab-content clearfix">
			 			 <div class="tab-pane active" id="list">
			 			 <?php get_template_part( 'content/content-archive-post-full' ); ?>
                           <?php mayosis_page_navs(); ?><!-- Blog Post-->
					   </div>
					   
					   
					    <div class="tab-pane" id="grid">
				 <?php get_template_part( 'content/content-archive-post-grid' ); ?>
					   <?php mayosis_page_navs();?>
                 </div>
			<div class="clearfix"></div>
					</div>
                    
                    

                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 blog-sidebar">
                <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
				<?php endif; ?>
                
                <!--sidebar widget-->
            </div>
        </div>
    </section>
    <!-- End Blog Main Post Layout-->
    <div class="clearfix"></div>
	
</article>

       
    </div>
       
</div>