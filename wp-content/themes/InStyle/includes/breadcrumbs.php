<div id="breadcrumbs">

	<?php if(function_exists('bcn_display')) { bcn_display(); }
		  else { ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','InStyle') ?></a> <span class="raquo">&raquo;</span>

				<?php if( is_tag() ) { ?>
					<?php esc_html_e('Posts Tagged &quot;','InStyle'); ?><?php single_tag_title(); echo('&quot;'); ?>
				<?php } elseif (is_day()) { ?>
					<?php esc_html_e('Posts made in','InStyle'); ?> <?php the_time('F jS, Y'); ?>
				<?php } elseif (is_month()) { ?>
					<?php esc_html_e('Posts made in','InStyle'); ?> <?php the_time('F, Y'); ?>
				<?php } elseif (is_year()) { ?>
					<?php esc_html_e('Posts made in','InStyle'); ?> <?php the_time('Y'); ?>
				<?php } elseif (is_search()) { ?>
					<?php esc_html_e('Search results for','InStyle'); ?> <?php the_search_query(); ?>
				<?php } elseif (is_404()) { ?>
					<?php esc_html_e('No results found','InStyle'); ?>
				<?php } elseif (is_single()) { ?>
					<?php $category = get_the_category();
						  if (!empty($category)) {
								$catlink = get_category_link( $category[0]->cat_ID );
								echo ('<a href="'.esc_url($catlink).'">'.esc_html($category[0]->cat_name).'</a><span class="raquo">&raquo;</span> '.get_the_title());
						  }; ?>
				<?php } elseif (is_category()) { ?>
					<?php single_cat_title(); ?>
				<?php } elseif (is_author()) { ?>
					<?php global $wp_query;
						  $curauth = $wp_query->get_queried_object(); ?>
					<?php esc_html_e('Posts by ','InStyle'); echo ' ',$curauth->nickname; ?>
				<?php } elseif (is_page()) { ?>
					<?php single_post_title(); ?>
				<?php }; ?>
	<?php }; ?>

</div> <!-- end #breadcrumbs -->