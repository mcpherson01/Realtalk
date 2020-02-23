<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package mayosis
 */
  if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<section id="primary" class="content-area">
		
	<div class="row page_breadcrumb">
	    <div class="container">
					<h2 class="page_title_single"><?php esc_html_e('Search Result','mayosis'); ?></h2>
					<div class="breadcrumb">
						<span class="active"><?php esc_html_e('Search Results for','mayosis'); ?> "<?php echo esc_html($s); ?>"</span>
						</div>
						</div>
				</div>
		<main id="main" class="site-main container search--content--main" role="main">
		    
			<div class="col-md-12">
			<?php if ( 'download' == get_post_type() ) : ?>
			                    				<?php get_template_part( 'content/content-search-download' ); ?>
				<?php elseif ( 'post' == get_post_type() ) : ?>
                    				<?php if ( have_posts() ) : ?>
                    
                    
                        <?php /* Start the Loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                    				<?php get_template_part( 'content/content-search-post' ); ?>
                    				
                    				<?php endwhile; ?>
                    
                        <div class="col-md-12">
                            <?php mayosis_page_navs(); ?>
                        </div>
                    
                   
                    
                    <?php endif; ?>
                    
                     <?php else : ?>
                   
                        <?php get_template_part( 'content/content', 'none' ); ?>
                    
				
				<?php endif; ?>
		
			
</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>