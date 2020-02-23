<?php get_header(); ?>

<?php get_template_part('includes/listing_categories','index'); ?>

<?php if ( 'on' == get_option( 'elist_featured_index' ) ) get_template_part('includes/featured','tax'); ?>

<?php get_template_part('includes/recent_listings','index'); ?>

<?php get_footer(); ?>