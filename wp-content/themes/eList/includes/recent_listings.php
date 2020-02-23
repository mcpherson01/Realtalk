<section id="recent-listings">
	<div class="container clearfix">
		<?php $et_queried_object = get_queried_object(); ?>

		<?php if ( ( isset( $et_queried_object ) && 'listing_tag' != $et_queried_object->taxonomy ) || is_home() ) { ?>
			<h1><?php esc_html_e( 'Recent Listings', 'eList' ); ?></h1>
		<?php } ?>

		<?php
			$et_count = 0;
			$et_divider = 2;

			if ( is_home() ){
				$et_divider = 3;
			} else {
				echo '<div id="main_content">';
			}

			$et_divider = apply_filters( 'et_divider', $et_divider );
			$et_open = false;

			if ( have_posts() ) : while ( have_posts() ) : the_post();
				$et_count++;
				$et_open = true;
				$et_is_last = $et_count % $et_divider == 0;
		?>
				<article class="r-listing<?php if ( $et_is_last ) echo ' last'; ?>">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="meta-info"><?php esc_html_e('Posted','eList'); ?> <?php esc_html_e('in','eList'); ?> <?php echo get_the_term_list( $post->ID, 'listing_category', '', ', ' ) ?> <?php esc_html_e('on','eList'); ?> <?php the_time( get_option( 'elist_date_format' ) ); ?></p>

					<?php
						$thumb = '';
						$width = 230;
						$height = 100;
						$classtext = 'post-thumb';
						$titletext = get_the_title();
						$thumbnail = get_thumbnail( $width,$height,$classtext,$titletext,$titletext,false,'Entry' );
						$thumb = $thumbnail["thumb"];
					?>
					<?php if ( '' != $thumb && 'on' == get_option('elist_thumbnails_index') ) { ?>
						<div class="post-thumb">
							<a href="<?php the_permalink(); ?>">
								<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext ); ?>
								<span class="overlay"></span>
							</a>
						</div> <!-- end .post-thumb -->
					<?php } ?>

					<p><?php truncate_post( 190 ); ?></p>
					<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e( 'Read More', 'eList' ); ?></a>
				</article> <!-- end .r-listing -->

				<?php
					if ( ! is_home() && $et_is_last ) {
						echo '<div class="hr"></div>';
						$et_open = false;
					}
				?>
		<?php
			endwhile;
				ob_start();
				echo '<div id="taxonomy_pagination">';
					if ( function_exists('wp_pagenavi') ) { wp_pagenavi(); }
					else { get_template_part('includes/navigation','entry'); }
				echo '</div> <!-- end #taxonomy_pagination -->';
				$et_navigation = ob_get_contents();
				ob_end_clean();
			endif;
			if ( ! is_home() ) {
				if ( $et_open ) echo '<div class="hr"></div>';
				if ( isset( $et_navigation ) ) echo $et_navigation;
				echo '</div> <!-- end #main_content -->';
				get_sidebar();
			}
		?>
	</div> <!-- end .container -->
</section> <!-- end #recent-listings -->

<?php if ( is_home() && isset( $et_navigation ) ) echo $et_navigation; ?>