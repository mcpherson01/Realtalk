<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<article class="entry post clearfix">
		<?php if (get_option('elist_integration_single_top') <> '' && get_option('elist_integrate_singletop_enable') == 'on') echo(get_option('elist_integration_single_top')); ?>

		<h1 class="title"><?php the_title(); ?></h1>

		<?php if ( get_option('elist_postinfo2') <> '' && ( in_array( 'author', get_option('elist_postinfo2') ) || in_array( 'categories', get_option('elist_postinfo2') ) ) ) { ?>
			<p class="meta-info"><?php esc_html_e('Posted','eList'); ?><?php if (in_array('author', get_option('elist_postinfo2'))) { ?> <?php esc_html_e('by','eList'); ?> <?php the_author_posts_link(); ?><?php } ?><?php if (in_array('categories', get_option('elist_postinfo2'))) { ?> <?php esc_html_e('in','eList'); ?> <?php echo get_the_term_list( $post->ID, 'listing_category', '', ', ' ) ?> <?php esc_html_e('on','eList'); ?> <?php the_time( get_option( 'elist_date_format' ) ); ?><?php } ?></p>
		<?php } ?>

		<?php
			$thumb = '';
			$width = 200;
			$height = 200;
			$classtext = '';
			$titletext = get_the_title();
			$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Single');
			$thumb = $thumbnail["thumb"];
		?>
		<?php if ( '' <> $thumb && 'on' == get_option( 'elist_thumbnails' ) ) { ?>
			<div class="post-thumbnail">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				<span class="post-overlay"></span>
			</div> 	<!-- end .post-thumbnail -->
		<?php } ?>

		<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<p><strong>'.esc_attr__('Pages','eList').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php edit_post_link(esc_attr__('Edit this page','eList')); ?>
	</article> <!-- end .entry -->

	<?php if (get_option('elist_integration_single_bottom') <> '' && get_option('elist_integrate_singlebottom_enable') == 'on') echo(get_option('elist_integration_single_bottom')); ?>

	<?php do_action( 'elist_after_listing' ); ?>

	<?php
		if ( 'on' == get_option('elist_show_postcomments') ) {
			echo '<div class="hr"></div>';
			comments_template('', true);
		}
	?>
<?php endwhile; // end of the loop. ?>