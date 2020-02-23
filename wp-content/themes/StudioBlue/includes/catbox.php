<!--Category Box 1-->
<?php $cat_option='studioblue_home_cat_one'; ?>
<div class="home-post-wrap-box">
	<span class="headings"><?php esc_html_e('recent from','StudioBlue'); ?> <?php echo get_categname(get_option($cat_option)); ?></span>
	<?php query_posts("posts_per_page=" . get_option('studioblue_posts_catbox1') . "&cat=".get_catId(get_option($cat_option)));
		  while (have_posts()) : the_post(); ?>
			  <?php get_template_part('includes/category_box'); ?>
	<?php endwhile; wp_reset_query(); ?>
</div>
<!--Category Box 1-->

<!--Category Box 2-->
<?php $cat_option='studioblue_home_cat_two'; ?>
<div class="home-post-wrap-box">
	<span class="headings"><?php esc_html_e('recent from','StudioBlue'); ?> <?php echo get_categname(get_option($cat_option)); ?></span>
	<?php query_posts("posts_per_page=" . get_option('studioblue_posts_catbox2') . "&cat=".get_catId(get_option($cat_option)));
		  while (have_posts()) : the_post(); ?>
			  <?php get_template_part('includes/category_box'); ?>
	<?php endwhile; wp_reset_query(); ?>
</div>
<!--Category Box 2-->
<div style="clear: both;"></div>