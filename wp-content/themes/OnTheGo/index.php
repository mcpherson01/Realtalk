<?php get_header(); ?>

	<div id="main-content">
		<h1 id="index"><?php if ( is_tag() ) { ?>
			<?php esc_html_e('Posts Tagged &quot;','OnTheGo'); ?><?php single_tag_title(); ?>&quot;
		<?php } elseif (is_day()) { ?>
			<?php esc_html_e('Posts made in','OnTheGo'); ?> <?php the_time('F jS, Y'); ?>
		<?php } elseif (is_month()) { ?>
			<?php esc_html_e('Posts made in','OnTheGo'); ?> <?php the_time('F, Y'); ?>
		<?php } elseif (is_year()) { ?>
			<?php esc_html_e('Posts made in','OnTheGo'); ?> <?php the_time('Y'); ?>
		<?php } elseif (is_search()) { ?>
			<?php esc_html_e('Search results for:','OnTheGo'); ?> <em><?php the_search_query() ?></em>
		<?php } elseif (is_author()) { ?>
			<?php global $wp_query;
				  $curauth = $wp_query->get_queried_object(); ?>
			<?php esc_html_e('Posts by','OnTheGo'); ?> <?php echo $curauth->nickname; ?>
		<?php } ?></h1>

		<?php get_template_part('includes/entry'); ?>
	</div> <!-- #main-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>