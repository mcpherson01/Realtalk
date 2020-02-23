<?php get_header(); ?>

	<?php if ( 'on' == get_option( 'evolution_featured' ) ) get_template_part('includes/featured','home'); ?>

	<?php if ( 'false' == get_option('evolution_blog_style') ) { ?>
		<?php if ( 'on' == get_option('evolution_quote') && ( $quote_one = get_option('evolution_quote_one') ) && '' != $quote_one ) { ?>
			<div id="slogan">
				<p><?php echo esc_html( $quote_one ); ?></p>
				<span id="right-quote"></span>
				<div id="top-quote-shadow"></div>
				<div id="bottom-quote-shadow"></div>
			</div> <!-- end #slogan -->
		<?php } ?>

		<?php if ( get_option('evolution_display_recentwork_section') == 'on' ) { ?>
			<div id="recent-work" class="clearfix">
				<div id="work-info">
					<h3><?php esc_html_e('Recent Work','Evolution'); ?></h3>
					<p><?php echo get_option('evolution_homework_desc'); ?></p>
				</div> <!-- end #work-info -->

				<?php
					$work_count = 0;
					$recent_exlcats_work = get_option('evolution_exlcats_work');

					$recent_work_args = apply_filters( 'evolution_recent_work_args', array(
						'posts_per_page' => (int) get_option('evolution_posts_work_num'),
					) );

					if ( is_array( $recent_exlcats_work ) )
						$recent_work_args['category__not_in'] = array_map( 'intval', et_generate_wpml_ids( $recent_exlcats_work, 'category' ) );

					$recent_work_query = new WP_Query( $recent_work_args );
					while ( $recent_work_query->have_posts() ) : $recent_work_query->the_post();
						++$work_count;
						$width = (int) apply_filters( 'evolution_home_work_width', 203 );
						$height = (int) apply_filters( 'evolution_home_work_height', 203 );
						$titletext = get_the_title();
						$thumbnail = get_thumbnail($width,$height,'item-image',$titletext,$titletext,true,'Work');
						$thumb = $thumbnail["thumb"];
						$lightbox_title = ( $work_title = get_post_meta(get_the_ID(), 'work_title',true) ) ? $work_title : $titletext;
						$work_description = ( $work_desc = get_post_meta(get_the_ID(), 'work_description',true) ) ? $work_desc : truncate_post( 50, false );
				?>
						<div class="r-work<?php if ( 0 == $work_count % 3 ) echo ' last'; ?>">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, 'item-image'); ?>
							<span class="overlay"></span>
							<a href="<?php the_permalink(); ?>" class="more"></a>
							<a href="<?php echo esc_url($thumbnail['fullpath']); ?>" class="zoom fancybox" title="<?php echo esc_attr( $lightbox_title ); ?>" rel="work_gallery"></a>
							<p><?php echo esc_html( $work_description ); ?></p>
						</div> <!-- end .r-work -->
				<?php endwhile; wp_reset_postdata(); ?>
			</div> <!-- end #recent-work -->
		<?php } ?>
	</div> <!-- end .container -->

	<div id="divider">
		<div class="container">
			<div></div>
		</div>
	</div>

	<div class="container">
		<?php if ( 'on' == get_option('evolution_display_about_page') ) { ?>
			<?php
				$about_page_query = new WP_Query( 'page_id=' . get_pageId( html_entity_decode( get_option('evolution_about_page') ) ) );
				while ( $about_page_query->have_posts() ) : $about_page_query->the_post();
					global $more;
					$more = 0;
			?>
					<div id="about">
						<h3><?php esc_html_e('More About Our Company','Evolution'); ?></h3>
						<?php the_content(''); ?>
						<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('Read More','Evolution'); ?></span></a>
					</div> <!-- end #about -->
			<?php endwhile; wp_reset_postdata(); ?>
		<?php } ?>

		<?php if ( 'on' == get_option('evolution_display_recent_blog_posts') ) { ?>
			<div id="recent-posts">
				<h3><?php esc_html_e('Recent Blog Posts','Evolution'); ?></h3>
				<?php
					$home_category_id = (int) get_catId( get_option('evolution_home_recentblog_section') );

					while ( have_posts() ) : the_post();
						$width = (int) apply_filters( 'evolution_home_blog_width', 60 );
						$height = (int) apply_filters( 'evolution_home_blog_height', 60 );
						$titletext = get_the_title();
						$thumbnail = get_thumbnail($width,$height,'r-post-image',$titletext,$titletext,true,'Blog');
						$thumb = $thumbnail["thumb"];
				?>
						<div class="r-post clearfix">
							<?php if ( '' != $thumb ) { ?>
								<div class="thumb">
									<a href="<?php the_permalink(); ?>">
										<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, 'r-post-image'); ?>
										<span class="overlay"></span>
									</a>
								</div> 	<!-- end .thumb -->
							<?php } ?>

							<p class="date"><?php the_time( get_option('evolution_date_format') ); ?> | </p>
							<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<p><?php truncate_post(115); ?></p>
						</div> <!-- end .r-post -->
				<?php endwhile; ?>

				<a href="<?php echo esc_url( get_category_link( $home_category_id ) ); ?>" class="readmore"><span><?php esc_html_e('Read More','Evolution'); ?></span></a>
			</div> <!-- end #recent-posts -->
		<?php } ?>

		<div class="clear"></div>
	<?php } else { ?>
		<div id="content_area" class="clearfix">
			<div id="main_content">
				<?php get_template_part('includes/entry','index'); ?>
			</div> <!-- end #main_content -->
			<?php get_sidebar(); ?>
		</div> <!-- end #content_area -->
	<?php } ?>

<?php get_footer(); ?>