<?php if (is_page() || is_category()) { ?>
	<?php $tagline = get_post_meta($post->ID, 'Tagline', $single = true);
		  if (is_category()) $tagline = category_description();
		  if ($tagline <> '') {	?>
				<p class="tagline">
					<?php echo esc_html( strip_tags( $tagline ) ); ?>
				</p>
		  <?php }; ?>
<?php }; ?>