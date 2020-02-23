<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="home-post-wrap-3">
    <?php get_template_part('includes/postinfo'); ?>
	<br style="clear:both;"/>
</div>
<?php endwhile; ?>
<?php get_template_part('includes/page-navigation'); ?>
<?php else : ?>
<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>