<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<article class="entry post clearfix">
		<h1 class="main_title"><?php the_title(); ?></h1>

		<?php if (get_option('evolution_page_thumbnails') == 'on') { ?>
			<?php
				$thumb = '';
				$width = apply_filters( 'evolution_single_image_width', 203 );
				$height = apply_filters( 'evolution_single_image_height', 203 );
				$classtext = 'post-thumb';
				$titletext = get_the_title();
				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Single');
				$thumb = $thumbnail["thumb"];
			?>

			<?php if($thumb <> '') { ?>
				<div class="single-thumbnail">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					<span class="post-overlay"></span>
				</div> 	<!-- end .single-thumbnail -->
			<?php } ?>
		<?php } ?>

		<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<p><strong>'.esc_attr__('Pages','Evolution').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php edit_post_link(esc_attr__('Edit this page','Evolution')); ?>
	</article> <!-- end .entry -->
<?php endwhile; // end of the loop. ?>