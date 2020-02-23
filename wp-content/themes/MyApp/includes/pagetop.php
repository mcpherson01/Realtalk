<div id="page-top">
	<div id="top-shadow"> </div>
		<div class="container clearfix">

			<div id="cat-description">
				<h1 class="desc-title">
					<?php if (is_category()) single_cat_title();
					  elseif (is_tag()) single_tag_title();
					  elseif (is_day()) the_time('F jS, Y');
					  elseif (is_month()) the_time('F, Y');
					  elseif (is_year()) the_time('Y');
					  elseif (is_search()) the_search_query();
					  elseif (is_author()) {
							global $wp_query;
							$curauth = $wp_query->get_queried_object();
							echo $curauth->nickname;
					  }
					  elseif (is_single()) {
							$category = get_the_category();
							echo ($category[0]->cat_name);
					  }
					  else the_title(); ?>
				</h1>
				<?php if (!is_single()) get_template_part('includes/postinfo'); else {
					$category = get_the_category();
					$catDesc = $category[0]->category_description;
					if ($catDesc <> '') echo ('<p class="tagline">'.$category[0]->category_description.'</p>');
				} ?>
			</div>

			<div id="buy-image2">
				<?php $colorScheme = get_option('myapptheme_color_scheme'); ?>
				<img src="<?php echo get_template_directory_uri(); ?>/images/<?php if ( $colorScheme == 'Purple' || $colorScheme == 'Black' ) echo esc_attr($colorSchemePath); ?>iphone2.png" alt="" />
				<a href="#" id="get-our-app"><?php esc_html_e('Get our App','MyAppTheme'); ?></a>
			</div>

		</div> 	<!-- end .container -->
	<div id="bottom-shadow"> </div>
</div> <!-- end #page-top -->