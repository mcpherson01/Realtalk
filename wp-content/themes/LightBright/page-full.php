<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="entry no_sidebar">
			<div class="entry-top"></div>

			<?php get_template_part('includes/share'); ?>

			<div class="post clearfix">
				<div class="content clearfix">

					<h1 class="title"><?php the_title(); ?></h1>

					<div class="clear"></div>

					<?php $thumb = '';
						  $width = 184;
						  $height = 184;
						  $classtext = '';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'thumb');
						  $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '' && get_option('lightbright_page_thumbnails') == 'on') { ?>
						<div class="thumb">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>

							<span class="overlay"></span>
						</div> <!-- end .thumb -->
					<?php }; ?>

					<?php the_content(); ?>
					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','LightBright').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','LightBright')); ?>

				</div> <!-- end .content -->

				<div class="entry-bottom-top"></div>

				<div class="entry-meta clearfix">
					<p class="meta"><span class="main"><?php esc_html_e('Posted by','LightBright');?> <?php the_author_posts_link(); ?></span> <span class="comment-count"><?php comments_popup_link('0','1','%'); ?></span></p>
					<?php if(!is_single()) { ?>
						<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','LightBright'); ?></span></a>
					<?php }; ?>
				</div> <!-- end .entry-meta -->

			</div> <!-- end .post -->

			<div class="entry-bottom"></div>
		</div> <!-- end .entry -->

		<?php if (get_option('lightbright_show_pagescomments') == 'on') comments_template('', true); ?>
	<?php endwhile; endif; ?>
	</div> <!-- end #main-area -->

<?php get_footer(); ?>