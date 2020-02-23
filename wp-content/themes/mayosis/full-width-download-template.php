<?php
/*
 * Template Name: Full Width
 * Template Post Type: download, product
 */
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
 $download_id = get_the_ID();
 get_header();  ?>
 

		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content/content', 'full-download' ); ?>
			<?php get_template_part( 'content/footer-widget', 'download' ); ?>
		  <div class="container" id="comment_box">
                  <?php if ( class_exists( 'EDD_Reviews' ) ) { ?>
                <div class="mayosis-review-tabs">
			      <div class="tabbable-line">
                    <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#commentmain" role="tab" data-toggle="tab">Comments</a></li>
                    <li><a href="#mayosisreview" role="tab" data-toggle="tab">Customer Reviews</a></li>
                  </ul>
                    </div>
                  
                   <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="commentmain">
                        	<?php if ( comments_open() || '0' != get_comments_number() ) { ?>
                    <?php comments_template(); ?>
                <?php } ?>
                        
                    </div>
                    <div role="tabpanel" class="tab-pane" id="mayosisreview">
                        
                         <?php if ( class_exists( 'EDD_Reviews' ) ) {
								global $post;
								$user = wp_get_current_user();
								$user_id = ( isset( $user->ID ) ? (int) $user->ID : 0 );

								if ( ! edd_reviews()->is_review_status( 'disabled' ) ) {
								?>
								<div class="mayosis-review-section reviews-section">
									<div class="comments">
										<div class="comments-wrap">
										<?php
											edd_get_template_part( 'reviews' );
											if ( get_option( 'thread_comments' ) ) {
												edd_get_template_part( 'reviews-reply' );
											}
										?>
										</div>
									</div>
								</div>
							<?php } }?>
                    </div>
                   
                  </div>
                </div>
              
                
                <?php } else { ?>
                 
                 
                 <?php if ( comments_open() || '0' != get_comments_number() ) { ?>
                    <?php comments_template(); ?>
                <?php } ?>
							
							
			<?php } ?>
            </div>
		<?php endwhile; // end of the loop. ?>

		</main>



<?php get_footer(); ?>