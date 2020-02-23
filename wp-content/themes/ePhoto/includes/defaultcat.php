<span class="current-category">
<?php single_cat_title(esc_html__('Currently Browsing: ','ePhoto'), 'display'); ?>
</span>

<div id="home-wrapper">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php get_template_part('includes/thumbnail'); ?>

<?php endwhile; ?>
</div> <!-- end home-wrapper -->

	<?php get_template_part('includes/page-navigation'); ?>
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>