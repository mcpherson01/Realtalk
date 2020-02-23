<?php
/*
 * Template Name: Media Template
 * Template Post Type: download, product
 */
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
 $download_id = get_the_ID();
 get_header();  ?>
 


		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content/content', 'photo-download' ); ?>
			<?php get_template_part( 'content/footer-widget', 'download' ); ?>
			
		<?php endwhile; // end of the loop. ?>

		</main>



<?php get_footer(); ?>