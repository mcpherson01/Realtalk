<?php get_header(); ?>

<?php if ( get_option('inreview_quote') == 'on' ) { ?>
	<div id="quote">
		<p id="tagline-quote">"<?php echo get_option('inreview_quote_text'); ?>"</p>
	</div> <!-- end #quote -->
<?php } ?>

<?php if ( is_home() && get_option('inreview_featured') == 'on' ) get_template_part('includes/featured'); ?>

<div id="main-content">
	<div id="main-content-wrap" class="clearfix">
		<div id="left-area">
			<h4 class="widgettitle"><?php esc_html_e('recent product reviews','InReview'); ?></h4>

			<?php get_template_part('includes/entry','home'); ?>
		</div> <!-- end #left-area -->

		<?php get_sidebar(); ?>
	</div> <!-- end #main-content-wrap -->
</div> <!-- end #main-content -->
<?php get_footer(); ?>