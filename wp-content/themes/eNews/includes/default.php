<div id="main-area-wrap">
	<?php if (get_option('enews_home_catboxes') == 'on') { ?>
		<!-- Recent From Category Posts -->
		<div id="recentposts">
			<div class="recent first">
				<?php global $ids2; recent_from((get_option('enews_recent_cat1')),0); ?>
			</div> <!-- end recent post -->
			<div class="recent">
				<?php recent_from((get_option('enews_recent_cat2')),1); ?>
			</div> <!-- end recent post -->
			<div class="recent">
				<?php recent_from((get_option('enews_recent_cat3')),2);
				$ids3 = array();
				if (isset($ids)) $ids3 = array_merge((array)$ids,(array)$ids2); ?>
			</div> <!-- end recent post -->
		</div>
		<!-- end Recent From Category Posts -->
	<?php }; ?>

	<div id="wrapper">
		<div id="main">
			<?php $i = 0;
			if (have_posts()) : while (have_posts()) : the_post();
			$i++;?>

<?php $titletext = get_the_title(); ?>

<?php if ($i>=5 && (get_option('enews_home_shorten_posts') == 'on')) { ?>

						<div class="new-post">

							<?php $width = 73;
								  $height = 74;
								  $thumbnail = get_thumbnail($width,$height,'',$titletext,$titletext);
								  $thumb = $thumbnail["thumb"]; ?>

							<?php if ( $thumb <> '' ) { ?>
								<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eNews'), get_the_title()) ?>">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height); ?>
								</a>
							<?php }; ?>

							<h2><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eNews'), get_the_title()) ?>"><?php truncate_title(45); ?></a></h2>
							<p class="info"><em><?php esc_html_e('posted on','eNews') ?></em>: <?php the_time(get_option('enews_date_format')) ?> | <em><?php esc_html_e('author','eNews') ?></em>: <?php echo get_the_author(); ?></p>
							<p><?php truncate_post(150); ?></p>

						</div> <!-- end new-post -->

<?php } else { ?>

						<div class="mainpost-wrap<?php if (($i%2)<>0) echo (" fst") ?>">

							<?php $width = 291;
								  $height = 114;
								  $thumbnail = get_thumbnail($width,$height,'',$titletext,$titletext);
								  $thumb = $thumbnail["thumb"]; ?>

							<h2><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eNews'), get_the_title()) ?>"><?php truncate_title(37); ?></a></h2>
							<p><?php truncate_post(119); ?></p>

							<?php if ( $thumb <> '' ) { ?>
								<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eNews'), get_the_title()) ?>">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height); ?>
								</a>
							<?php }; ?>

							<div class="info"><em><?php esc_html_e('posted on','eNews') ?></em>: <?php the_time(get_option('enews_date_format')) ?> | <em><?php esc_html_e('author','eNews') ?></em>: <?php echo get_the_author(); ?></div>

						</div> <!-- end mainpost-wrap-->

<?php }; ?>

<?php endwhile; ?>

	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
	else { ?>
	<p class="pagination">
		<?php next_posts_link(esc_html__('&laquo; Previous Entries','eNews')) ?>
		<?php previous_posts_link(esc_html__('Next Entries &raquo;','eNews')) ?>
	</p>
	<?php } ?>
<?php endif; ?>
					</div> <!-- end main -->