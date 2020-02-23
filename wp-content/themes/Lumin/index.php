<?php get_header(); ?>
	<h1 id="post-title"><span><?php if ( is_tag() ) { ?>
	    <?php esc_html_e('Posts Tagged &quot;','Lumin'); ?><?php single_tag_title(); ?>&quot;
	<?php } elseif (is_day()) { ?>
		<?php esc_html_e('Posts made in','Lumin'); ?> <?php the_time('F jS, Y'); ?>
	<?php } elseif (is_month()) { ?>
		<?php esc_html_e('Posts made in','Lumin'); ?> <?php the_time('F, Y'); ?>
	<?php } elseif (is_year()) { ?>
		<?php esc_html_e('Posts made in','Lumin'); ?> <?php the_time('Y'); ?>
	<?php } elseif (is_search()) { ?>
		<?php esc_html_e('Search results for:','Lumin'); ?> <em><?php the_search_query() ?></em>
	<?php } elseif (is_author()) { ?>
		<?php global $wp_query;
			  $curauth = $wp_query->get_queried_object(); ?>
		<?php esc_html_e('Posts by','Lumin'); ?> <?php echo $curauth->nickname; ?>
	<?php } ?></span></h1>

	<div id="main">
		<div class="post index">
			<?php get_template_part('includes/category_usual'); ?>
			<div class="clear"></div>
		</div> <!-- end .post -->
	</div> <!-- end #main-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>