<?php get_header(); ?>

<?php get_template_part('includes/listing_categories','home'); ?>

<?php if ( 'on' == get_option( 'elist_featured' ) ) get_template_part('includes/featured','home'); ?>

<?php get_template_part('includes/recent_listings','home'); ?>

<?php get_footer(); ?>