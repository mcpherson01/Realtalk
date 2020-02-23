<?php $i = 1; ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php $blogcat = (int) get_catId(get_option('elegantestate_blog_cat')); ?>
	<?php if ( ( ( is_category() && in_subcat($blogcat,$cat) ) || ( !is_category() && is_archive() ) ) || get_option('elegantestate_blog_style') == 'on' ) { ?>
		<?php if ($i==1) get_template_part('includes/breadcrumbs'); ?>

		<?php $thumb = '';
		$width = 159;
		$height = 159;
		$classtext = '';
		$titletext = get_the_title();
		$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		$thumb = $thumbnail["thumb"]; ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class( array('clearfix','full_entry') ); ?>>
			<?php if ($thumb <> '' && get_option('elegantestate_thumbnails_index') == 'on') { ?>
				<div class="small-thumb">
					<a href="<?php the_permalink(); ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
						<span class="overlay"></span>
					</a>
				</div> 	<!-- end .small-thumb -->
			<?php } ?>

			<div class="entry_content<?php if ($thumb <> '' && get_option('elegantestate_thumbnails_index') == 'on') echo(' setwidth') ?>">
				<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php get_template_part('includes/postinfo'); ?>
				<?php if (get_option('elegantestate_blog_style') == 'false') { ?>
					<p><?php truncate_post(330); ?></p>
				<?php } else { ?>
					<?php the_content(); ?>
				<?php } ?>
			</div> <!-- end .entry_content -->
			<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('Read more','ElegantEstate'); ?></span></a>
		</div> <!-- end .full_entry -->
	<?php } else { ?>
		<?php $thumb = '';
		$width = 292;
		$height = 155;
		$classtext = '';
		$titletext = get_the_title();
		$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
		$thumb = $thumbnail["thumb"];
		$custom = get_post_custom($post->ID);
		$et_price = isset($custom["price"][0]) ? $custom["price"][0] : '';
		$et_divclass = '';
		if ($i%2==0) $et_divclass .= ' second';
		if ($i<3) $et_divclass .= ' first'; ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class( array('entry',$et_divclass) ); ?>>
			<?php if ($thumb <> '' && get_option('elegantestate_thumbnails_index') == 'on') { ?>
				<div class="thumbnail">
					<a href="<?php echo esc_url( $thumbnail['fullpath'] ); ?>" rel="gallery" class="fancybox" title="<?php the_title(); ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
						<span class="overlay2"></span>
						<?php if ($et_price <> '' ) {?>
							<span class="price2"><span><?php echo esc_html($et_price); ?></span></span>
						<?php } ?>
					</a>
				</div> 	<!-- end .thumbnail -->
			<?php } ?>
			<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<div class="hr2"></div>
			<p><?php truncate_post(230); ?></p>
			<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('view the listing','ElegantEstate'); ?></span></a>
		</div> <!-- end .entry -->
	<?php } ?>
<?php $i++; ?>
<?php endwhile; ?>
	<div class="clear"></div>
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
	else { ?>
		 <?php get_template_part('includes/navigation'); ?>
	<?php } ?>

<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>