<?php get_header(); ?>

<?php $blogStyle = (get_option('magnificent_blog_style') == 'false') ? false : true; ?>

<?php if (!$blogStyle) { ?>

	<div id="sidebar-left" class="sidebar">
		<div class="block">
			<div class="block-border">
				<div class="block-content">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Left Top') ) : ?>
					<?php endif; ?>
				</div> <!-- end .block-content -->
			</div> <!-- end .block-border -->
		</div> <!-- end .block -->

		<div class="block">
			<div class="block-border">
				<div class="block-content">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Left Bottom') ) : ?>
					<?php endif; ?>

				</div> <!-- end .block-content -->
			</div> <!-- end .block-border -->
		</div> <!-- end .block -->
	</div> <!-- end #sidebar-left -->

	<div id="main-content">

		<?php if (get_option('magnificent_featured') == 'on') get_template_part('includes/featured'); ?>

<?php } else { ?>
	<div id="entries">
<?php } ?>

	<?php if (!$blogStyle) get_template_part('includes/entry');
	else get_template_part('includes/entry-blogstyle'); ?>

</div> <!-- end <?php if (!$blogStyle) echo '#main-content'; else '#entries'; ?> -->

<div id="sidebar-right" class="sidebar">
	<div class="block">
		<div class="block-border">
			<div class="block-content">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Right Top') ) : ?>
				<?php endif; ?>
			</div> <!-- end .block-content -->
		</div> <!-- end .block-border -->
	</div> <!-- end .block -->

	<div class="block">
		<div class="block-border">
			<div class="block-content">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Right Bottom') ) : ?>
				<?php endif; ?>
			</div> <!-- end .block-content -->
		</div> <!-- end .block-border -->
	</div> <!-- end .block -->
</div> <!-- end #sidebar-right -->

<?php get_footer(); ?>