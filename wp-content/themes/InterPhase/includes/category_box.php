<?php global $cat_option; ?>
<div class="home-categories">
	<span class="orange-titles"><?php esc_html_e('recent from','InterPhase'); ?> <?php echo esc_html( get_cat_name( get_option( $cat_option ) ) ); ?></span>
	<a href="<?php the_permalink(); ?>">
		<?php the_title(); ?>
	</a>
	<div style="clear: both;"></div>

	<?php truncate_post(310); ?>
</div>