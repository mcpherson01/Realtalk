<div id="post-top">
	<div class="breadcrumb">
		<?php if(function_exists('bcn_display')) { bcn_display(); }
		else { ?>
			<?php esc_html_e('You are currently viewing','eNews') ?>: <em><?php single_cat_title("") ?></em>
		<?php }; ?>
	</div> <!-- end breadcrumb -->
</div> <!-- end post-top -->

<div id="main-area-wrap">
	<div id="wrapper">
		<div id="main" class="noborder">
<?php $i = 0; if (have_posts()) : while (have_posts()) : the_post();
	$i++; ?>

	<?php $width = 291;
		  $height = 114;
		  $titletext = get_the_title();
		  $thumbnail = get_thumbnail($width,$height,'',$titletext,$titletext);
		  $thumb = $thumbnail["thumb"]; ?>

	<div class="mainpost-wrap<?php if (($i%2)<>0) echo (" fst") ?>">
		<h2><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eNews'), get_the_title()) ?>"><?php truncate_title(37); ?></a></h2>
		<p><?php truncate_post(119); ?></p>

		<?php if ( $thumb <> '' ) { ?>
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eNews'), get_the_title()) ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height); ?>
			</a>
		<?php }; ?>

		<div class="info"><em><?php esc_html_e('posted on','eNews') ?></em>: <?php the_time(get_option('enews_date_format')) ?> | <em><?php esc_html_e('author','eNews') ?></em>: <?php echo get_the_author(); ?></div>
	</div> <!-- end mainpost-wrap-->
<?php endwhile; ?>

	<?php if( function_exists('wp_pagenavi') ) { wp_pagenavi(); }
	else { ?>
		<p class="pagination">
			<?php next_posts_link(esc_html__('&laquo; Previous Entries','eNews')) ?>
		    <?php previous_posts_link(esc_html__('Next Entries &raquo;','eNews')) ?>
		</p>
	<?php } ?>

<?php else : ?>
	<!--If no results are found-->
	<div id="post-content">
		<h1><?php esc_html_e('No Results Found','eNews') ?></h1>
		<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eNews') ?></p>
	</div>
	<!--End if no results are found-->
<?php endif; ?>
		</div> <!-- end main -->