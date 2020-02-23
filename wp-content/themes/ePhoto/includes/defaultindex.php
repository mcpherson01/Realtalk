<span class="current-category"><?php esc_html_e('Currently Browsing','ePhoto') ?>
<?php if (is_tag()) { ?>
&quot;<?php single_tag_title(); ?>&quot;
<?php } elseif( is_author() ) { ?>
<?php global $wp_query;
$curauth = $wp_query->get_queried_object(); ?>
<?php esc_html_e('Posts by','ePhoto') ?> <?php echo $curauth->nickname; ?>
<?php } elseif( is_search() ) { ?>
<?php esc_html_e('search results for','ePhoto') ?>:  <em><?php the_search_query() ?></em>
<?php } else { ?>
<?php esc_html_e('The Archives','ePhoto') ?>
<?php }; ?></span>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="home-wrapper">
		<?php get_template_part('includes/thumbnail'); ?>
	</div>
<?php endwhile; ?>
	<?php get_template_part('includes/page-navigation'); ?>
<?php else : ?>
	<div id="home-wrapper">
		<?php get_template_part('includes/no-results'); ?>
	</div>
<?php endif; ?>