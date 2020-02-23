<div class="row">
	<div class="col-sm-12">
		<div class="masonry">
			<?php get_template_part('inc/content-product', 'filters'); ?>
			<div class="row">
				<div class="masonry__container">
					<div class="masonry__item col-sm-6"></div>
					<?php
						if ( have_posts() ) : while ( have_posts() ) : the_post();
						
							/**
							 * Get blog posts by blog layout.
							 */
							get_template_part('loop/content-product', 'column-2');
						
						endwhile;	
						else : 
							
							/**
							 * Display no posts message if none are found.
							 */
							get_template_part('loop/content','none');
							
						endif;
					?>
				</div><!--end masonry container-->
			</div><!--end of row-->
		</div><!--end masonry-->
	</div>
</div><!--end of row-->

<?php get_template_part( 'inc/content-pagination', get_option( 'stack_pagination_layout', 'text' ) );