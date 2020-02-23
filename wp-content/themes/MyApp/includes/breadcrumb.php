<div id="breadcrumbs">
	<div class="container clearfix">
		<div id="breadcrumbs-nav">
			<?php if(function_exists('bcn_display')) { bcn_display(); }
			else { ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','MyAppTheme') ?></a> <span class="separator"></span>

				<?php if( is_tag() ) { ?>
					<?php esc_html_e('Posts Tagged &quot;','MyAppTheme'); ?><?php single_tag_title(); echo('&quot;'); ?>
				<?php } elseif (is_day()) { ?>
					<?php esc_html_e('Posts made in','MyAppTheme'); ?> <?php the_time('F jS, Y'); ?>
				<?php } elseif (is_month()) { ?>
					<?php esc_html_e('Posts made in','MyAppTheme'); ?> <?php the_time('F, Y'); ?>
				<?php } elseif (is_year()) { ?>
					<?php esc_html_e('Posts made in','MyAppTheme'); ?> <?php the_time('Y'); ?>
				<?php } elseif (is_search()) { ?>
					<?php esc_html_e('Search results for','MyAppTheme'); ?> <?php the_search_query(); ?>
				<?php } elseif (is_404()) { ?>
					<?php esc_html_e('No results found','MyAppTheme'); ?>
				<?php } elseif (is_single()) { ?>
					<?php $category = get_the_category();
						  $catlink = get_category_link( $category[0]->cat_ID );
						  if ($catlink <> '') echo ('<a href="'.esc_url( $catlink ).'">'.esc_html( $category[0]->cat_name ).'</a> <span class="separator"></span> '.get_the_title()); ?>
				<?php } elseif (is_category()) { ?>
					<?php single_cat_title(); ?>
				<?php } elseif (is_author()) { ?>
					<?php esc_html_e('Posts by ','MyAppTheme'); echo ' ',$curauth->nickname; ?>
				<?php } elseif (is_page()) { ?>
					<?php single_post_title(); ?>
				<?php }; ?>
			<?php }; ?>
		</div> <!-- end #breadcrumbs-nav -->

		<div id="search-form">
			<form method="get" id="searchform1" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="text" value="<?php esc_attr_e('Search...','MyAppTheme'); ?>" name="s" id="searchinput" />
				<?php $colorScheme = get_option('myapptheme_color_scheme'); ?>
				<input type="image" src="<?php echo get_template_directory_uri(); ?>/images/<?php if ( $colorScheme == 'Purple' || $colorScheme == 'Black' ) echo esc_attr($colorSchemePath); ?>search_btn.png" id="searchsubmit" />
			</form>
		</div> <!-- end #search-form -->
	</div> 	<!-- end .container -->
</div>