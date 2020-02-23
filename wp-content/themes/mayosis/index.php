<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mayosis
 */
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header(); ?>
<?php
$blogarchivestyle = get_theme_mod( 'blog_archive_post_style','both' );
?>
<div class="wrap">
	
	<div class="row page_breadcrumb">
				<?php if ( is_home() && ! is_front_page() ) : ?>
						<h1 class="page-title"><?php single_post_title(); ?></h1>
					<?php else : ?>
					<h2 class="page_title_single"><?php esc_html_e('Blog','mayosis'); ?></h2>
						<?php endif; ?>
						<?php if (function_exists('dm_breadcrumbs')) dm_breadcrumbs(); ?>
						</div>
    <!-- Begin Blog Main Post Layout -->
    <section class="container blog-main-content">
        <div class="row">
            <div class="main-post-body">
                <div class="col-md-8 col-sm-8 col-xs-12 main-post-block index-block">
                    <div class="post-view-style">
                        <div class="col-md-5 col-xs-8 total-post-count">
                            <?php 
                            $count = $GLOBALS['wp_query']->found_posts;
                            $countall = $GLOBALS['wp_query']->post_count;
                            ?>
                            <p><?php esc_html_e('Showing','mayosis'); ?> <strong><?php echo esc_html($countall);?></strong>  <?php esc_html_e('of','mayosis'); ?> <strong><?php echo esc_html($count);?></strong> <?php esc_html_e('Blog Posts','mayosis'); ?></p>
                        </div>
                         <?php if ($blogarchivestyle=="both"): ?>
                        <div class="col-md-7 col-xs-4 post-viewas">
							<ul  class="nav nav-pills">
			<li class="active">
        <a  href="#list" data-toggle="tab"><i class="zil zi-bars"></i></a>
			</li>
			<li><a href="#grid" data-toggle="tab"><i class="zil zi-grid"></i></a>
			</li>
		</ul>
                        </div>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                  
                  
                  <?php if ($blogarchivestyle=="both"): ?>
                   <div class="tab-content clearfix">
			 			 <div class="tab-pane active" id="list">
			 			  <?php get_template_part( 'content/content-archive-post-full' ); ?>
                    <?php mayosis_page_navs(); ?><!-- Blog Post-->
                    <!-- Blog Post-->
					   </div>
					   
					   
					    <div class="tab-pane" id="grid">
					    	 <?php get_template_part( 'content/content-archive-post-grid' ); ?>
					   <?php mayosis_page_navs(); ?>
                 </div>
            
					</div>
                    <?php endif; ?>
                    
                    <?php if ($blogarchivestyle=="list"): ?>
                    <div id="list">
                        <?php get_template_part( 'content/content-archive-post-full' ); ?>
                    <?php mayosis_page_navs(); ?><!-- Blog Post-->
                    </div>
                    <?php endif;?>
                    
                    <?php if ($blogarchivestyle=="grid"): ?>
                    <div id="grid">
                         <?php get_template_part( 'content/content-archive-post-grid' ); ?>
					   <?php mayosis_page_navs(); ?>
                    </div>
                    <?php endif;?>
                    
                    

                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 blog-sidebar">
                <?php get_sidebar(); ?>
                
                
                <!--sidebar widget-->
            </div>
        </div>
    </section>
    <!-- End Blog Main Post Layout-->
    <div class="clearfix"></div>
	
</div>

	<?php
get_footer(); ?>