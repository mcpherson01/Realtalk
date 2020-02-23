<?php
/*
 * Template Name: Full Width Post
 * Template Post Type: post
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
get_header();
?>



    <div id="primary">


        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'content/content', 'full-width-blog' ); ?>




        <?php endwhile;  ?>
    </div>


<?php get_footer(); ?>